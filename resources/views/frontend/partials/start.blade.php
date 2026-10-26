<!DOCTYPE html>
<html lang="id" class="scroll-smooth">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="robots" content="index, follow" />
    <meta name="theme-color" content="#001539" />

    <!-- SEO Meta Tags -->
    <title>{{ $title ?? 'Akademi Pelatihan - Akselerasi Karir & Keahlian Digital' }}</title>
    <meta name="description" content="{{ $metaDescription ?? 'Akademi Pelatihan adalah platform terpercaya untuk peningkatan kompetensi guru, siswa, dan masyarakat umum dengan kurikulum standar nasional terakreditasi.' }}" />
    <link rel="canonical" href="{{ url()->current() }}" />

    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="{{ $ogType ?? 'website' }}" />
    <meta property="og:url" content="{{ url()->current() }}" />
    <meta property="og:title" content="{{ $title ?? 'Akademi Pelatihan - Akselerasi Karir & Keahlian Digital' }}" />
    <meta property="og:description" content="{{ $metaDescription ?? 'Platform terpercaya untuk peningkatan kompetensi guru, siswa, dan masyarakat umum dengan kurikulum standar nasional terakreditasi.' }}" />
    <meta property="og:image" content="{{ asset('img/logo.png') }}" />
    <meta property="og:site_name" content="Akademi Pelatihan" />
    <meta property="og:locale" content="id_ID" />

    <!-- Twitter -->
    <meta name="twitter:card" content="summary_large_image" />
    <meta name="twitter:url" content="{{ url()->current() }}" />
    <meta name="twitter:title" content="{{ $title ?? 'Akademi Pelatihan - Akselerasi Karir & Keahlian Digital' }}" />
    <meta name="twitter:description" content="{{ $metaDescription ?? 'Platform terpercaya untuk peningkatan kompetensi guru, siswa, dan masyarakat umum dengan kurikulum standar nasional terakreditasi.' }}" />
    <meta name="twitter:image" content="{{ asset('img/logo.png') }}" />

    <link rel="icon" type="image/png" href="{{ asset('img/logo.png') }}" />

    <!-- Typography & Icons -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Plus+Jakarta+Sans:wght@600;700;800&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-surface font-sans text-on-surface min-h-screen flex flex-col antialiased">
