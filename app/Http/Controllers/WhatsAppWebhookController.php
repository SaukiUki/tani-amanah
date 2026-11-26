<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\WhatsAppMessage;
use App\Services\WhatsApp\WhatsAppBotService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class WhatsAppWebhookController extends Controller
{
    public function __construct(
        protected WhatsAppBotService $botService
    ) {}

    /**
     * Handle Meta Cloud API Webhook Verification.
     * GET /api/webhooks/whatsapp
     */
    public function verify(Request $request): Response
    {
        $mode = $request->query('hub_mode', $request->query('hub.mode'));
        $token = $request->query('hub_verify_token', $request->query('hub.verify_token'));
        $challenge = $request->query('hub_challenge', $request->query('hub.challenge'));

        $expectedToken = config('services.whatsapp.verify_token', 'tani-amanah-secret-token');

        if ($mode === 'subscribe' && $token === $expectedToken) {
            return response((string) $challenge, 200)
                ->header('Content-Type', 'text/plain');
        }

        return response('Unauthorized or invalid token', 403);
    }

    /**
     * Handle Inbound WhatsApp Webhook Messages.
     * POST /api/webhooks/whatsapp
     */
    public function handle(Request $request): JsonResponse
    {
        $payload = $request->all();

        // Parse phone, type, and content (supporting both direct JSON & Meta Cloud API nested structure)
        $parsed = $this->parseIncomingPayload($payload);

        $senderPhone = $parsed['from'];
        $messageType = $parsed['type'];
        $messageContent = $parsed['content'];

        // Process message through Bot Service
        $botResult = $this->botService->processMessage(
            $senderPhone,
            $messageType,
            $messageContent,
            $payload
        );

        $farmer = $botResult['farmer'];
        $replyText = $botResult['reply_text'];
        $buttons = $botResult['buttons'];
        $action = $botResult['action_performed'];

        // Log Inbound Message
        WhatsAppMessage::create([
            'farmer_id' => $farmer->id,
            'phone_number' => $senderPhone,
            'direction' => 'inbound',
            'message_type' => $messageType,
            'body' => $messageContent,
            'payload' => $payload,
            'status' => 'received',
        ]);

        // Log Outbound Bot Reply
        WhatsAppMessage::create([
            'farmer_id' => $farmer->id,
            'phone_number' => $senderPhone,
            'direction' => 'outbound',
            'message_type' => ! empty($buttons) ? 'interactive_button' : 'text',
            'body' => $replyText,
            'payload' => [
                'buttons' => $buttons,
                'action' => $action,
                'data' => $botResult['data'],
            ],
            'status' => 'sent',
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Processed successfully',
            'reply' => $replyText,
            'buttons' => $buttons,
            'action' => $action,
            'farmer' => [
                'id' => $farmer->id,
                'nama' => $farmer->nama,
                'nomor_wa' => $farmer->nomor_wa,
            ],
        ]);
    }

    /**
     * Extract sender, type, and content from either standard or Meta Cloud payload.
     *
     * @param array<string, mixed> $payload
     * @return array{from: string, type: string, content: string}
     */
    protected function parseIncomingPayload(array $payload): array
    {
        // 1. Direct / Simulator payload
        if (isset($payload['from']) || isset($payload['body']) || isset($payload['message'])) {
            $from = (string) ($payload['from'] ?? '081234567801');
            $type = (string) ($payload['type'] ?? 'text');
            $content = (string) ($payload['body'] ?? $payload['message'] ?? $payload['content'] ?? '');

            if (isset($payload['button_id']) || isset($payload['interactive_button'])) {
                $type = 'interactive_button';
                $content = (string) ($payload['button_id'] ?? $payload['interactive_button'] ?? $content);
            }

            return [
                'from' => $from,
                'type' => $type,
                'content' => $content,
            ];
        }

        // 2. Meta Cloud API standard webhook payload
        $entry = $payload['entry'][0]['changes'][0]['value'] ?? null;
        if ($entry && isset($entry['messages'][0])) {
            $msg = $entry['messages'][0];
            $from = (string) ($msg['from'] ?? '081234567801');
            $msgType = (string) ($msg['type'] ?? 'text');

            $content = match ($msgType) {
                'text' => $msg['text']['body'] ?? '',
                'interactive' => $msg['interactive']['button_reply']['id']
                    ?? $msg['interactive']['button_reply']['title']
                    ?? '',
                'audio' => 'voice_note_received',
                'button' => $msg['button']['text'] ?? $msg['button']['payload'] ?? '',
                default => $msg['text']['body'] ?? '',
            };

            $type = match ($msgType) {
                'interactive', 'button' => 'interactive_button',
                'audio' => 'voice_note',
                default => 'text',
            };

            return [
                'from' => $from,
                'type' => $type,
                'content' => $content,
            ];
        }

        // Fallback default
        return [
            'from' => '081234567801',
            'type' => 'text',
            'content' => 'menu',
        ];
    }
}
