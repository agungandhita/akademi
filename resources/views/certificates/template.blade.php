<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sertifikat Pelatihan - {{ ucwords(trim($participantName ?? 'Peserta')) }} - {{ $training->title }}</title>
    
    <!-- Google Fonts for Ultra-Sharp Institutional Certificate Typography -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Alex+Brush&family=Cinzel:wght@600;700;800;900&family=Great+Vibes&family=Montserrat:wght@600;700;800;900&family=Playfair+Display:ital,wght@0,600;0,700;1,600&family=Plus+Jakarta+Sans:wght@500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Material Symbols -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />

    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            background-color: #0b1329;
            color: #1e293b;
            font-family: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, sans-serif;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        /* Top Bar Toolbar (Hidden on Print) */
        .cert-toolbar {
            width: 100%;
            background-color: #1e293b;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            padding: 12px 24px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: sticky;
            top: 0;
            z-index: 50;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.4);
        }

        .cert-toolbar-left {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .cert-toolbar-title {
            color: #f8fafc;
            font-size: 14px;
            font-weight: 700;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .badge-preview {
            background-color: #f59e0b;
            color: #000;
            font-size: 10px;
            font-weight: 800;
            padding: 2px 8px;
            border-radius: 9999px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .cert-toolbar-actions {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .zoom-controls {
            display: flex;
            align-items: center;
            background-color: rgba(255, 255, 255, 0.08);
            border-radius: 10px;
            padding: 3px 6px;
            gap: 4px;
        }

        .btn-zoom {
            background: none;
            border: none;
            color: #cbd5e1;
            padding: 4px 6px;
            border-radius: 6px;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.2s ease;
        }
        .btn-zoom:hover {
            background-color: rgba(255, 255, 255, 0.15);
            color: #ffffff;
        }

        .zoom-level {
            font-size: 11px;
            font-weight: 700;
            color: #94a3b8;
            min-width: 38px;
            text-align: center;
        }

        .btn-toolbar {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 8px 16px;
            border-radius: 10px;
            font-size: 12px;
            font-weight: 700;
            text-decoration: none;
            transition: all 0.2s ease;
            cursor: pointer;
            border: none;
        }

        .btn-back {
            background-color: rgba(255, 255, 255, 0.1);
            color: #cbd5e1;
        }
        .btn-back:hover {
            background-color: rgba(255, 255, 255, 0.2);
            color: #ffffff;
        }

        .btn-print {
            background-color: #0284c7;
            color: #ffffff;
            box-shadow: 0 2px 4px rgba(2, 132, 199, 0.3);
        }
        .btn-print:hover {
            background-color: #0369a1;
            transform: translateY(-1px);
        }

        /* Certificate Viewport Stage */
        .cert-viewport {
            flex: 1;
            width: 100%;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 35px 20px;
            overflow: auto;
        }

        .cert-canvas-wrapper {
            display: flex;
            justify-content: center;
            align-items: center;
        }

        /* The Canvas: Exact 1024 x 662 matching reference */
        .cert-canvas {
            width: 1024px;
            height: 662px;
            min-width: 1024px;
            min-height: 662px;
            position: relative;
            background-image: url('{{ asset('img/certificate-template-bg.png') }}');
            background-size: 100% 100%;
            background-position: center;
            background-repeat: no-repeat;
            box-shadow: 0 25px 60px -15px rgba(0, 0, 0, 0.85);
            background-color: #ffffff;
            border-radius: 2px;
            transition: transform 0.2s ease;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }

        /* 1. Nomor Kegiatan */
        .cert-number {
            position: absolute;
            top: 172px;
            left: 0;
            right: 0;
            text-align: center;
            font-family: 'Montserrat', sans-serif;
            font-size: 13px;
            font-weight: 700;
            letter-spacing: 0.9px;
            color: #0d2238;
            text-transform: uppercase;
        }

        /* 2. Nama Peserta (Calligraphy / Script) */
        .cert-recipient {
            position: absolute;
            top: 218px;
            left: 80px;
            right: 80px;
            height: 78px;
            display: flex;
            align-items: flex-end;
            justify-content: center;
            padding-bottom: 2px;
            font-family: 'Great Vibes', 'Alex Brush', cursive;
            color: #0b2246;
            line-height: 1;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            text-shadow: 0 1px 2px rgba(11, 34, 70, 0.15);
            @php
                $cleanName = ucwords(trim($participantName ?? 'Nama Peserta'));
                $nameLen = strlen($cleanName);
                if ($nameLen > 40) {
                    echo 'font-size: 38px;';
                } elseif ($nameLen > 28) {
                    echo 'font-size: 46px;';
                } elseif ($nameLen > 18) {
                    echo 'font-size: 54px;';
                } else {
                    echo 'font-size: 62px;';
                }
            @endphp
        }

        /* 3. Banner & Nama Kegiatan Pelatihan */
        .cert-banner-container {
            position: absolute;
            top: 359px;
            left: 270px;
            width: 484px;
            height: 44px;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            padding: 0 16px;
            pointer-events: none;
        }

        .cert-training-title {
            width: 100%;
            font-family: 'Cinzel', 'Montserrat', serif;
            font-weight: 700;
            color: #ffffff;
            text-transform: uppercase;
            text-shadow: 0 1px 3px rgba(0, 0, 0, 0.7);
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
            text-overflow: ellipsis;
            @php
                $titleLen = strlen($training->title ?? '');
                if ($titleLen > 70) {
                    echo 'font-size: 11px; line-height: 1.25; letter-spacing: 0.3px;';
                } elseif ($titleLen > 45) {
                    echo 'font-size: 12.5px; line-height: 1.3; letter-spacing: 0.5px;';
                } else {
                    echo 'font-size: 14.5px; line-height: 1.3; letter-spacing: 1px; font-weight: 800;';
                }
            @endphp
        }

        /* 4. Tanggal Pelaksanaan */
        .cert-date-line {
            position: absolute;
            top: 442px;
            left: 0;
            right: 0;
            text-align: center;
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 12.5px;
            color: #334155;
            font-weight: 500;
        }

        .cert-date-val {
            font-weight: 700;
            color: #0f2238;
            margin-left: 4px;
        }

        /* 5. Tanda Tangan (Left & Right Boxes) */
        .sig-box {
            position: absolute;
            top: 472px;
            width: 220px;
            text-align: center;
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        .sig-box-left {
            left: 101px;
        }

        .sig-box-right {
            left: 671px;
        }

        .sig-title {
            font-size: 12.5px;
            font-weight: 700;
            color: #0b2246;
            height: 18px;
            line-height: 18px;
            letter-spacing: 0.2px;
        }

        .sig-image-box {
            height: 60px;
            display: flex;
            align-items: flex-end;
            justify-content: center;
            padding-bottom: 2px;
        }

        .sig-img {
            max-height: 56px;
            max-width: 140px;
            object-fit: contain;
            filter: contrast(1.1);
        }

        .sig-line {
            width: 165px;
            margin: 0 auto;
            height: 1.2px;
            background-color: #334155;
        }

        .sig-name {
            font-size: 12.5px;
            font-weight: 700;
            color: #0f172a;
            margin-top: 5px;
            line-height: 1.2;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .sig-nip {
            font-size: 11px;
            font-weight: 500;
            color: #475569;
            margin-top: 2px;
            line-height: 1.2;
        }

        /* Print Settings (A4 Landscape, High Quality, Zero Margin) */
        @page {
            size: 297mm 210mm landscape;
            margin: 0;
        }

        @media print {
            html, body {
                background: none !important;
                background-color: #ffffff !important;
                padding: 0 !important;
                margin: 0 !important;
                width: 297mm !important;
                height: 210mm !important;
            }

            .cert-toolbar {
                display: none !important;
            }

            .cert-viewport {
                padding: 0 !important;
                margin: 0 !important;
                display: flex !important;
                align-items: center !important;
                justify-content: center !important;
                width: 297mm !important;
                height: 210mm !important;
                overflow: hidden !important;
            }

            .cert-canvas-wrapper {
                width: 297mm !important;
                height: 191.9mm !important;
            }

            .cert-canvas {
                transform: none !important;
                width: 297mm !important;
                height: 191.9mm !important;
                min-width: 0 !important;
                min-height: 0 !important;
                max-width: 297mm !important;
                max-height: 191.9mm !important;
                box-shadow: none !important;
                border-radius: 0 !important;
                margin: 0 !important;
                page-break-after: avoid !important;
                page-break-inside: avoid !important;
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
            }
        }
    </style>
</head>
<body>

    <!-- Floating Top Toolbar -->
    <div class="cert-toolbar">
        <div class="cert-toolbar-left">
            @if(isset($backUrl))
                <a href="{{ $backUrl }}" class="btn-toolbar btn-back">
                    <span class="material-symbols-outlined" style="font-size: 16px;">arrow_back</span>
                    <span>Kembali</span>
                </a>
            @endif
            <div class="cert-toolbar-title">
                <span>Pratinjau Sertifikat Pelatihan</span>
                @if(isset($isPreview) && $isPreview)
                    <span class="badge-preview">Mode Pratinjau Admin</span>
                @endif
            </div>
        </div>

        <div class="cert-toolbar-actions">
            <!-- Zoom Controls -->
            <div class="zoom-controls">
                <button type="button" class="btn-zoom" onclick="setZoom(0.9)" title="Perkecil">
                    <span class="material-symbols-outlined" style="font-size: 16px;">zoom_out</span>
                </button>
                <span class="zoom-level" id="zoom-indicator">100%</span>
                <button type="button" class="btn-zoom" onclick="setZoom(1.1)" title="Perbesar">
                    <span class="material-symbols-outlined" style="font-size: 16px;">zoom_in</span>
                </button>
                <button type="button" class="btn-zoom" onclick="resetZoom()" title="Reset Ukuran (100%)">
                    <span class="material-symbols-outlined" style="font-size: 16px;">restart_alt</span>
                </button>
            </div>

            <!-- Print Action -->
            <button type="button" onclick="window.print()" class="btn-toolbar btn-print">
                <span class="material-symbols-outlined" style="font-size: 16px;">print</span>
                <span>Cetak / Simpan PDF</span>
            </button>
        </div>
    </div>

    <!-- Certificate Viewport Stage -->
    <div class="cert-viewport">
        <div class="cert-canvas-wrapper">
            <div class="cert-canvas" id="certificate-canvas">
                
                <!-- 1. Nomor Kegiatan -->
                <div class="cert-number">
                    NOMOR KEGIATAN: {{ $certificateNumber }}
                </div>

                <!-- 2. Nama Lengkap Peserta -->
                <div class="cert-recipient">
                    {{ ucwords(trim($participantName ?? 'Nama Peserta')) }}
                </div>

                <!-- 3. Nama Kegiatan Pelatihan (Dalam Banner Biru Emas) -->
                <div class="cert-banner-container">
                    <div class="cert-training-title">
                        {{ strtoupper($training->title) }}
                    </div>
                </div>

                <!-- 4. Tanggal Kegiatan Pelatihan -->
                <div class="cert-date-line">
                    pada tanggal <span class="cert-date-val">{{ $certificateDate }}</span>
                </div>

                <!-- 5. Tanda Tangan Kiri: Ketua Pelaksana -->
                <div class="sig-box sig-box-left">
                    <div class="sig-title">{{ $signerLeftTitle }}</div>
                    <div class="sig-image-box">
                        @if($signerLeftSignatureUrl)
                            <img src="{{ $signerLeftSignatureUrl }}" alt="Tanda Tangan" class="sig-img" />
                        @endif
                    </div>
                    <div class="sig-line"></div>
                    <div class="sig-name">{{ $signerLeftName }}</div>
                    <div class="sig-nip">
                        @if(!empty($signerLeftNip))
                            {{ str_starts_with(strtoupper(trim($signerLeftNip)), 'NIP') ? $signerLeftNip : 'NIP. ' . $signerLeftNip }}
                        @else
                            NIP. .....................................
                        @endif
                    </div>
                </div>

                <!-- 6. Tanda Tangan Kanan: Pimpinan Akademi Pelatihan -->
                <div class="sig-box sig-box-right">
                    <div class="sig-title">{{ $signerRightTitle }}</div>
                    <div class="sig-image-box">
                        @if($signerRightSignatureUrl)
                            <img src="{{ $signerRightSignatureUrl }}" alt="Tanda Tangan" class="sig-img" />
                        @endif
                    </div>
                    <div class="sig-line"></div>
                    <div class="sig-name">{{ $signerRightName }}</div>
                    <div class="sig-nip">
                        @if(!empty($signerRightNip))
                            {{ str_starts_with(strtoupper(trim($signerRightNip)), 'NIP') ? $signerRightNip : 'NIP. ' . $signerRightNip }}
                        @else
                            NIP. .....................................
                        @endif
                    </div>
                </div>

            </div>
        </div>
    </div>

    <script>
        let currentScale = 1;
        function setZoom(factor) {
            currentScale = Math.min(Math.max(currentScale * factor, 0.6), 1.8);
            applyZoom();
        }
        function resetZoom() {
            currentScale = 1;
            applyZoom();
        }
        function applyZoom() {
            const canvas = document.getElementById('certificate-canvas');
            if (canvas) {
                canvas.style.transform = `scale(${currentScale})`;
                canvas.style.transformOrigin = 'center center';
            }
            const indicator = document.getElementById('zoom-indicator');
            if (indicator) {
                indicator.textContent = `${Math.round(currentScale * 100)}%`;
            }
        }
    </script>
</body>
</html>
