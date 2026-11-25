<?php

declare(strict_types=1);

namespace App\Filament\Resources\Subscriptions\Tables;

use App\Models\Subscription;
use App\Services\Finance\SubscriptionService;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Notifications\Notification;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class SubscriptionsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('invoice_number')
                    ->label('No. Invoice')
                    ->searchable()
                    ->copyable()
                    ->weight('bold')
                    ->color('primary'),

                TextColumn::make('customer_name')
                    ->label('Nama Pelanggan')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),

                TextColumn::make('customer_phone')
                    ->label('WhatsApp')
                    ->searchable()
                    ->copyable(),

                TextColumn::make('city')
                    ->label('Wilayah')
                    ->badge()
                    ->color('gray')
                    ->sortable(),

                TextColumn::make('plan_type')
                    ->label('Paket')
                    ->badge()
                    ->formatStateUsing(fn ($state): string => match ((string) $state) {
                        'quarterly' => 'Musiman (3 bln)',
                        'monthly' => 'Bulanan (1 bln)',
                        default => ucfirst((string) $state),
                    })
                    ->color(fn ($state): string => match ((string) $state) {
                        'quarterly' => 'success',
                        default => 'info',
                    }),

                TextColumn::make('total_amount')
                    ->label('Total Bayar')
                    ->formatStateUsing(fn ($state): string => 'Rp ' . number_format((float) $state, 0, ',', '.'))
                    ->sortable()
                    ->weight('bold'),

                TextColumn::make('salam_allocation_amount')
                    ->label('Modal Salam')
                    ->formatStateUsing(fn ($state): string => 'Rp ' . number_format((float) $state, 0, ',', '.'))
                    ->sortable(),

                TextColumn::make('payment_method')
                    ->label('Metode')
                    ->badge()
                    ->formatStateUsing(fn ($state): string => strtoupper((string) $state)),

                TextColumn::make('payment_status')
                    ->label('Status')
                    ->badge()
                    ->formatStateUsing(fn ($state): string => match (strtolower((string) $state)) {
                        'paid', 'lunas' => 'Lunas',
                        'pending', 'menunggu', 'menunggu_pembayaran' => 'Menunggu',
                        'cancelled', 'batal' => 'Batal',
                        default => ucfirst((string) $state),
                    })
                    ->color(fn ($state): string => match (strtolower((string) $state)) {
                        'paid', 'lunas' => 'success',
                        'pending', 'menunggu', 'menunggu_pembayaran' => 'warning',
                        'cancelled', 'batal' => 'danger',
                        default => 'gray',
                    }),

                TextColumn::make('paid_at')
                    ->label('Waktu Bayar')
                    ->dateTime('d M Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('delivery_address')
                    ->label('Alamat')
                    ->limit(35)
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('payment_status')
                    ->label('Status Pembayaran')
                    ->options([
                        'paid' => 'Lunas (Dana Salam Diterima)',
                        'pending' => 'Menunggu Pembayaran',
                        'cancelled' => 'Dibatalkan',
                    ]),

                SelectFilter::make('plan_type')
                    ->label('Paket Langganan')
                    ->options([
                        'quarterly' => 'Musiman (30 kg - Rp 525.000)',
                        'monthly' => 'Bulanan (10 kg - Rp 175.000)',
                    ]),

                SelectFilter::make('city')
                    ->label('Wilayah Pengiriman')
                    ->options([
                        'Serang' => 'Serang',
                        'Cilegon' => 'Cilegon',
                        'Tangerang' => 'Tangerang',
                        'Jakarta' => 'Jakarta',
                    ]),
            ])
            ->recordActions([
                Action::make('markAsPaid')
                    ->label('Tandai Lunas')
                    ->icon(Heroicon::OutlinedCheckCircle)
                    ->color('success')
                    ->requiresConfirmation()
                    ->modalHeading('Tandai Pesanan Lunas')
                    ->modalDescription('Apakah Anda yakin ingin menandai pesanan ini sebagai lunas? Dana salam akan dicatat dan dihitung dinamis di dasbor koperasi.')
                    ->visible(fn (Subscription $record): bool => $record->payment_status !== 'paid')
                    ->action(function (Subscription $record, SubscriptionService $service): void {
                        $service->confirmPayment($record);

                        Notification::make()
                            ->title('Pesanan Ditandai Lunas')
                            ->body("Invoice {$record->invoice_number} berhasil dikonfirmasi.")
                            ->success()
                            ->send();
                    }),

                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('id', 'desc');
    }
}
