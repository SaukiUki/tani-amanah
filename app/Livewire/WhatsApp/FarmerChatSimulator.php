<?php

declare(strict_types=1);

namespace App\Livewire\WhatsApp;

use App\Models\Farmer;
use App\Models\FarmExpense;
use App\Models\HarvestRecord;
use App\Models\PlantingSeason;
use App\Models\SalamContract;
use App\Models\WhatsAppMessage;
use App\Services\WhatsApp\WhatsAppBotService;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('layouts.app')]
#[Title('Simulasi Bot WA Petani • Asisten Tani Amanah')]
class FarmerChatSimulator extends Component
{
    public int $farmerId;

    public string $messageText = '';

    /**
     * @var array<int, array{
     *     id: int|string,
     *     sender: 'bot'|'farmer',
     *     type: 'text'|'interactive_button'|'voice_note',
     *     text: string,
     *     buttons?: array<int, array{id: string, title: string}>,
     *     time: string,
     *     status?: string
     * }>
     */
    public array $messages = [];

    public function mount(WhatsAppBotService $botService): void
    {
        $farmer = Farmer::query()->where('nama', 'Pak Darma')->first()
            ?? Farmer::query()->first();

        if (! $farmer) {
            $farmer = $botService->resolveFarmer('081234567801');
        }

        $this->farmerId = $farmer->id;

        // Inisialisasi sapaan awal bot
        $greeting = "Sampurasun, *{$farmer->nama}*. Ada yang bisa dibantu?\n\n" .
            "1. Catat biaya\n" .
            "2. Catat panen\n" .
            "3. Jadwal giliran air\n" .
            "4. Harga gabah hari ini\n" .
            "5. Hitung zakat panen\n" .
            "6. Pesan pupuk organik\n\n" .
            "_Ketik angka menu (1-6) atau ketik langsung pesan Anda._";

        $this->messages = [
            [
                'id' => 'init-1',
                'sender' => 'bot',
                'type' => 'text',
                'text' => $greeting,
                'buttons' => [],
                'time' => now()->format('H:i'),
                'status' => 'read',
            ],
        ];
    }

    public function getFarmerProperty(): Farmer
    {
        return Farmer::query()->find($this->farmerId)
            ?? Farmer::query()->where('nama', 'Pak Darma')->first()
            ?? Farmer::query()->firstOrFail();
    }

    public function getSeasonProperty(): PlantingSeason
    {
        return PlantingSeason::query()->where('status_aktif', true)->first()
            ?? PlantingSeason::query()->firstOrFail();
    }

    public function getLatestHarvestProperty(): ?HarvestRecord
    {
        return HarvestRecord::query()
            ->where('farmer_id', $this->farmerId)
            ->where('planting_season_id', $this->season->id)
            ->latest()
            ->first();
    }

    public function getSalamContractProperty(): ?SalamContract
    {
        return SalamContract::query()
            ->where('farmer_id', $this->farmerId)
            ->where('planting_season_id', $this->season->id)
            ->first();
    }

    public function getTotalExpensesProperty(): float
    {
        return (float) FarmExpense::query()
            ->where('farmer_id', $this->farmerId)
            ->where('planting_season_id', $this->season->id)
            ->sum('nominal_rp');
    }

    /**
     * Send message from simulator.
     */
    public function sendMessage(?string $customText = null, string $type = 'text'): void
    {
        $text = trim($customText ?? $this->messageText);

        if ($text === '' && $type !== 'voice_note') {
            return;
        }

        if ($type === 'voice_note' && $text === '') {
            $text = 'Sampurasun Kang, alhamdulillah dinten ieu rengse panen 1.850 kg gabah kering';
        }

        $now = now()->format('H:i');

        // 1. Catat bubble pengirim (Petani)
        $this->messages[] = [
            'id' => 'msg-' . (count($this->messages) + 1),
            'sender' => 'farmer',
            'type' => $type,
            'text' => $text,
            'buttons' => [],
            'time' => $now,
            'status' => 'read',
        ];

        $this->messageText = '';

        // 2. Proses melalui WhatsAppBotService
        $botService = app(WhatsAppBotService::class);
        $result = $botService->processMessage(
            $this->farmer->nomor_wa,
            $type,
            $text
        );

        // 3. Simpan ke log percakapan DB
        WhatsAppMessage::create([
            'farmer_id' => $this->farmer->id,
            'phone_number' => $this->farmer->nomor_wa,
            'direction' => 'inbound',
            'message_type' => $type,
            'body' => $text,
            'payload' => ['simulator' => true],
            'status' => 'received',
        ]);

        WhatsAppMessage::create([
            'farmer_id' => $this->farmer->id,
            'phone_number' => $this->farmer->nomor_wa,
            'direction' => 'outbound',
            'message_type' => ! empty($result['buttons']) ? 'interactive_button' : 'text',
            'body' => $result['reply_text'],
            'payload' => [
                'buttons' => $result['buttons'],
                'action' => $result['action_performed'],
                'data' => $result['data'],
            ],
            'status' => 'sent',
        ]);

        // 4. Catat balasan bot ke riwayat pesan simulator
        $this->messages[] = [
            'id' => 'msg-' . (count($this->messages) + 1),
            'sender' => 'bot',
            'type' => ! empty($result['buttons']) ? 'interactive_button' : 'text',
            'text' => $result['reply_text'],
            'buttons' => $result['buttons'],
            'time' => now()->format('H:i'),
            'status' => 'read',
        ];
    }

    /**
     * Send Quick Action preset chip.
     */
    public function sendPreset(string $text): void
    {
        $this->sendMessage($text, 'text');
    }

    /**
     * Simulate Voice Note harvest input.
     */
    public function sendVoiceNotePreset(): void
    {
        $this->sendMessage('Sampurasun Kang, alhamdulillah dinten ieu rengse panen 1.850 kg gabah kering', 'voice_note');
    }

    /**
     * Click interactive reply button.
     */
    public function clickButton(string $buttonId, string $buttonTitle): void
    {
        $this->sendMessage($buttonTitle, 'interactive_button');
    }

    /**
     * Reset chat to initial state.
     */
    public function resetChat(): void
    {
        $this->mount(app(WhatsAppBotService::class));
    }

    public function render()
    {
        return view('livewire.whatsapp.farmer-chat-simulator', [
            'farmer' => $this->farmer,
            'season' => $this->season,
            'latestHarvest' => $this->latestHarvest,
            'salamContract' => $this->salamContract,
            'totalExpenses' => $this->totalExpenses,
        ]);
    }
}
