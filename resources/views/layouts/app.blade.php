<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Beras Amanah — Beras pulen segar langsung dari Koperasi Tani Desa Panosogan, Serang. Ditanam dengan akad salam, bebas ijon, dan penuh berkah.">
    
    <title>{{ $title ?? 'Beras Amanah • Koperasi Tani Desa Panosogan, Serang' }}</title>

    <!-- Google Fonts: Plus Jakarta Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,300..800;1,300..800&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
    <style>
        [x-cloak] { display: none !important; }
    </style>
</head>
<body class="bg-stone-200/80 text-stone-900 antialiased min-h-screen flex flex-col font-sans selection:bg-[#1E3F2B] selection:text-white">

    <!-- Main Content -->
    <main class="flex-1">
        @if(isset($slot) && $slot->isNotEmpty())
            {{ $slot }}
        @else
            @yield('content')
        @endif
    </main>

    @livewireScripts
</body>
</html>
