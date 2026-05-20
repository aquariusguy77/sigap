<aside class="sidebar" id="sidebar">
    <div class="brand">
        <div class="brand-mark">
            <x-icon name="shield" class="section-icon" />
        </div>
        <div>
            <h1>{{ $appName }}</h1>
            <p>Sistem Informasi & Gerakan Administratif Pengungsi</p>
        </div>
    </div>

    <p class="sidebar-note">
        Pendataan, dokumen, audit, dan pelaporan pengungsi luar negeri secara terpadu untuk wilayah kerja Rudenim Surabaya.
    </p>

    @if ($isSignedIn)
        <span class="nav-label">Navigasi Utama</span>
        <nav class="menu" aria-label="Menu utama SIGAP">
            @foreach ($menuItems as $item)
                <a class="menu-link {{ request()->routeIs(...($item['active'] ?? [$item['route']])) ? 'active' : '' }}" href="{{ route($item['route']) }}">
                    <x-icon :name="$item['icon']" class="menu-icon" />
                    <span>{{ $item['label'] }}</span>
                </a>
            @endforeach
        </nav>
    @else
        <span class="nav-label">Akses</span>
        <nav class="menu" aria-label="Akses masuk SIGAP">
            <a class="menu-link {{ request()->routeIs('login') ? 'active' : '' }}" href="{{ route('login') }}">
                <x-icon name="shield" class="menu-icon" />
                <span>Masuk Sistem</span>
            </a>
        </nav>
    @endif

    <div class="sidebar-footer">
        <div class="status-card">
            <strong>Status Lingkungan</strong>
            <p class="status-note">
                @if ($isSignedIn)
                    Peran aktif: <strong style="color:#fef3c7">{{ $currentRole['label'] }}</strong>. Sinkronisasi Firebase RTDB aktif.
                @else
                    Belum ada sesi aktif. Silakan login untuk membuka modul SIGAP.
                @endif
            </p>
        </div>
        @if ($isSignedIn)
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button class="logout-button" type="submit" style="width:100%;">
                    <x-icon name="logout" class="menu-icon" />
                    <span>Keluar</span>
                </button>
            </form>
        @else
            <a class="logout-button" href="{{ route('login') }}" style="width:100%;text-decoration:none;">
                <x-icon name="shield" class="menu-icon" />
                <span>Masuk</span>
            </a>
        @endif
    </div>
</aside>
