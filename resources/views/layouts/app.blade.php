<!DOCTYPE html>
<html lang="en" class="h-full">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>@yield('title', 'Manga Shelf') — Shelf</title>

    {{-- Tailwind CSS --}}
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        display: ['"Playfair Display"', 'Georgia', 'serif'],
                        body:    ['"DM Sans"', 'sans-serif'],
                        mono:    ['"DM Mono"', 'monospace'],
                    },
                    colors: {
                        ink:   { DEFAULT: '#0E0E10', 50: '#F4F4F5', 100: '#E4E4E7', 200: '#A1A1AA', 300: '#71717A', 400: '#52525B', 500: '#3F3F46', 600: '#27272A', 700: '#1C1C1F', 800: '#141416', 900: '#0E0E10' },
                        paper: '#F7F4EE',
                        accent: '#C8A96E',
                    },
                    borderRadius: { shelf: '3px' },
                }
            }
        }
    </script>

    {{-- Google Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=DM+Mono:wght@400;500&family=DM+Sans:wght@300;400;500&family=Playfair+Display:ital,wght@0,600;0,700;1,600&display=swap" rel="stylesheet" />

    {{-- Alpine.js --}}
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <style>
        /* ── Base ── */
        * { box-sizing: border-box; }
        body { background-color: #0E0E10; color: #E4E4E7; font-family: 'DM Sans', sans-serif; }

        /* ── Scrollbar ── */
        ::-webkit-scrollbar { width: 6px; }
        ::-webkit-scrollbar-track { background: #141416; }
        ::-webkit-scrollbar-thumb { background: #3F3F46; border-radius: 3px; }

        /* ── Cover placeholder ── */
        .cover-placeholder {
            background: linear-gradient(135deg, #1C1C1F 0%, #27272A 100%);
            display: flex; align-items: center; justify-content: center;
        }

        /* ── Card hover lift ── */
        .manga-card { transition: transform 0.2s ease, box-shadow 0.2s ease; }
        .manga-card:hover { transform: translateY(-4px); box-shadow: 0 16px 40px rgba(0,0,0,0.6); }

        /* ── Status badge ── */
        .status-badge {
            font-family: 'DM Mono', monospace;
            font-size: 0.6rem;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            padding: 2px 6px;
            border-radius: 2px;
        }

        /* ── Tab strip active ── */
        .tab-active {
            color: #C8A96E;
            border-bottom: 2px solid #C8A96E;
        }

        /* ── Progress bar ── */
        .progress-bar-fill { transition: width 0.4s ease; }

        /* ── Flash notice ── */
        .flash { animation: fadeSlide 0.3s ease forwards; }
        @keyframes fadeSlide {
            from { opacity: 0; transform: translateY(-8px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        /* ── Source row fade in ── */
        .source-row { animation: rowIn 0.15s ease forwards; }
        @keyframes rowIn {
            from { opacity: 0; transform: translateX(-6px); }
            to   { opacity: 1; transform: translateX(0); }
        }
    </style>
</head>

<body class="min-h-screen flex flex-col">

    {{-- ── Top Nav ── --}}
    <header class="border-b border-ink-600 px-6 py-4 flex items-center justify-between sticky top-0 z-40 bg-ink-900/95 backdrop-blur">
        <a href="{{ route('manga.index') }}" class="font-display text-xl tracking-wide text-paper hover:text-accent transition-colors">
            ReadingDB
        </a>
        <a href="{{ route('manga.create') }}"
           class="text-xs font-mono uppercase tracking-widest px-4 py-2 border border-accent text-accent hover:bg-accent hover:text-ink-900 transition-all duration-200">
            + Add Entry
        </a>
    </header>

    {{-- ── Flash Message ── --}}
    @if (session('success'))
        <div x-data="{ show: true }"
             x-show="show"
             x-init="setTimeout(() => show = false, 3000)"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             class="flash fixed top-16 right-4 z-50 bg-ink-600 border border-accent/40 text-paper text-xs font-mono px-4 py-2 rounded-shelf shadow-xl">
            {{ session('success') }}
        </div>
    @endif

    {{-- ── Main Content ── --}}
    <main class="flex-1 px-6 py-8 max-w-screen-xl mx-auto w-full">
        @yield('content')
    </main>

    {{-- ── Footer ── --}}
    <footer class="border-t border-ink-600 px-6 py-3 text-center text-ink-300 text-xs font-mono">
        Shelf &mdash; personal manga tracker
    </footer>

</body>
</html>
