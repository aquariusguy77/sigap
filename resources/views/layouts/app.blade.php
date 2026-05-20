<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="theme-color" content="#0e6473">
    <title>{{ ($title ?? ($pageHeading ?? $appName)) }} • {{ $appName }}</title>
    <meta name="description" content="SIGAP — Sistem Informasi & Gerakan Administratif Pengungsi Rudenim Surabaya. Pendataan, dokumen, audit, dan pelaporan terpadu.">
    @include('sigap.partials.styles')
</head>
<body>
    <div class="overlay" id="overlay"></div>
    <div class="app-shell">
        @include('partials.sidebar')
        <main class="main-content">
            @include('partials.topbar')
            <div class="page-body">
                @if (session('status'))
                    <div class="flash" role="status">
                        <x-icon name="check" class="chip-icon" />
                        <span>{{ session('status') }}</span>
                    </div>
                @endif

                @if ($errors->any())
                    <div class="flash alert-error" role="alert">
                        <x-icon name="alert" class="chip-icon" />
                        <div>
                            <strong>Periksa kembali isian berikut:</strong>
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                @endif

                @yield('content')

                <footer class="footer">
                    <strong>{{ $appName }}</strong> • Sistem Informasi & Gerakan Administratif Pengungsi • {{ now()->format('Y') }} • Rumah Detensi Imigrasi Surabaya
                </footer>
            </div>
        </main>
    </div>

    <script>
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('overlay');
        const sidebarToggle = document.getElementById('sidebarToggle');

        const toggleSidebar = (open) => {
            if (!sidebar || !overlay) return;
            sidebar.classList.toggle('open', open);
            overlay.classList.toggle('visible', open);
        };

        sidebarToggle?.addEventListener('click', () => toggleSidebar(true));
        overlay?.addEventListener('click', () => toggleSidebar(false));
        document.querySelectorAll('.menu-link').forEach((link) => {
            link.addEventListener('click', () => {
                if (window.innerWidth <= 980) toggleSidebar(false);
            });
        });
    </script>
</body>
</html>
