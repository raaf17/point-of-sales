<div id="sidebar" class="active">
    <div class="sidebar-wrapper active">
        <div class="sidebar-header position-relative">
            <div class="d-flex justify-content-between align-items-center">
                <div class="logo">
                    <a href="{{ url('/dashboard') }}">Kasirku</a>
                </div>
                <div class="sidebar-toggler  x">
                    <a href="#" class="sidebar-hide d-xl-none d-block"><i class="bi bi-x bi-middle"></i></a>
                </div>
            </div>
        </div>
        <div class="sidebar-menu">
            <ul class="menu">
                <li class="sidebar-title">Menu</li>

                <li class="sidebar-item {{ $title === 'Dashboard' ? 'active' : '' }}">
                    <a href="{{ route('dashboard') }}" class='sidebar-link'>
                        <i class="bi bi-grid-fill"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                @if (auth()->user()->level == 1)
                    @include('layouts.components.master-sidebar')
                    <li class="sidebar-item {{ $title === 'Transaksi Baru' ? 'active' : '' }}">
                        <a href="{{ url('/transaksi/baru') }}" class='sidebar-link'>
                            <i class="bi bi-kanban-fill"></i>
                            <span>Kasir</span>
                        </a>
                    </li>
                    @include('layouts.components.laporan-sidebar')
                    @include('layouts.components.sistem-sidebar')
                @else
                    <li class="sidebar-item {{ $title === 'Member' ? 'active' : '' }}">
                        <a href="{{ url('/member') }}" class='sidebar-link'>
                            <i class="bi bi-person-fill"></i>
                            <span>Membership</span>
                        </a>
                    </li>
                    <li class="sidebar-item {{ $title === 'Laporan Penjualan' ? 'active' : '' }}">
                        <a href="{{ url('/penjualan') }}" class='sidebar-link'>
                            <i class="bi bi-newspaper"></i>
                            <span>Laporan</span>
                        </a>
                    </li>
                @endif
            </ul>
        </div>
    </div>
</div>
