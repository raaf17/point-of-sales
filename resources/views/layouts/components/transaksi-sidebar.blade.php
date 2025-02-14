<li class="sidebar-item has-sub {{ $title === 'Pengeluaran' || $title === 'Pembelian' || $title === 'Penjualan' ? 'active' : '' }}">
    <a href="#" class='sidebar-link'>
        <i class="bi bi-menu-down"></i>
        <span>Transaksi</span>
    </a>
    <ul class="submenu {{ $title === 'Pengeluaran' || $title === 'Pembelian' || $title === 'Penjualan' ? 'active' : '' }}">
        <li class="submenu-item {{ $title === 'Transaksi Baru' ? 'active' : '' }}">
            <a href="{{ url('/transaksi/baru') }}">{{ __('sidebar.kasir') }}</a>
        </li>
        {{-- <li class="submenu-item {{ $title === 'Pengeluaran' ? 'active' : '' }}">
            <a href="{{ url('/pengeluaran') }}">{{ __('sidebar.expenditure') }}</a>
        </li> --}}
        <li class="submenu-item {{ $title === 'Pembelian' ? 'active' : '' }}">
            <a href="{{ url('/pembelian') }}">{{ __('sidebar.purchase') }}</a>
        </li>
        <li class="submenu-item {{ $title === 'Penjualan' ? 'active' : '' }}">
            <a href="{{ url('/penjualan') }}">{{ __('sidebar.sale') }}</a>
        </li>
    </ul>
</li>
