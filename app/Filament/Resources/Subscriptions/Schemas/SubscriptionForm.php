<?php

declare(strict_types=1);

namespace App\Filament\Resources\Subscriptions\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class SubscriptionForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('invoice_number')
                    ->label('Nomor Invoice')
                    ->disabled()
                    ->dehydrated(false)
                    ->placeholder('Dibuat otomatis oleh sistem'),

                TextInput::make('customer_name')
                    ->label('Nama Pelanggan')
                    ->required()
                    ->maxLength(255),

                TextInput::make('customer_phone')
                    ->label('Nomor WhatsApp')
                    ->tel()
                    ->required()
                    ->maxLength(20),

                Select::make('city')
                    ->label('Wilayah Pengiriman')
                    ->options([
                        'Serang' => 'Serang',
                        'Cilegon' => 'Cilegon',
                        'Tangerang' => 'Tangerang',
                        'Jakarta' => 'Jakarta',
                    ])
                    ->default('Serang')
                    ->required(),

                Textarea::make('delivery_address')
                    ->label('Alamat Lengkap Pengiriman')
                    ->rows(3)
                    ->columnSpanFull()
                    ->required(),

                Select::make('plan_type')
                    ->label('Pilihan Paket')
                    ->options([
                        'quarterly' => 'Paket Musiman (3 bulan di muka - Rp 525.000)',
                        'monthly' => 'Paket Bulanan (10 kg/bulan - Rp 175.000)',
                    ])
                    ->default('quarterly')
                    ->required(),

                TextInput::make('rice_kg_per_month')
                    ->label('Beras per Bulan (kg)')
                    ->numeric()
                    ->default(10)
                    ->required(),

                TextInput::make('duration_months')
                    ->label('Durasi Langganan (Bulan)')
                    ->numeric()
                    ->default(3)
                    ->required(),

                TextInput::make('total_amount')
                    ->label('Total Pembayaran')
                    ->numeric()
                    ->prefix('Rp')
                    ->required(),

                TextInput::make('salam_allocation_amount')
                    ->label('Alokasi Modal Tanam Salam')
                    ->numeric()
                    ->prefix('Rp')
                    ->default(0),

                Select::make('payment_method')
                    ->label('Metode Pembayaran')
                    ->options([
                        'qris' => 'QRIS (Semua E-Wallet / Bank)',
                        'va' => 'Virtual Account Bank Syariah (BSI)',
                    ])
                    ->default('qris')
                    ->required(),

                Select::make('payment_status')
                    ->label('Status Pembayaran')
                    ->options([
                        'paid' => 'Lunas (Dana Salam Diterima)',
                        'pending' => 'Menunggu Pembayaran',
                        'cancelled' => 'Dibatalkan',
                    ])
                    ->default('paid')
                    ->required(),

                DateTimePicker::make('paid_at')
                    ->label('Waktu Pembayaran'),
            ]);
    }
}
