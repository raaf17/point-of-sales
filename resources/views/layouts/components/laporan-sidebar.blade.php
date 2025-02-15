<li class="sidebar-item has-sub {{ $title === 'Laporan Stok Barang' || $title === 'Laporan Penjualan' ? 'active' : '' }}">
    <a href="#" class='sidebar-link'>
        <i class="bi bi-newspaper"></i>
        <span>Laporan</span>
    </a>
    <ul class="submenu {{ $title === 'Laporan Stok Barang' || $title === 'Laporan Penjualan' ? 'active' : '' }}">
        <li class="submenu-item {{ $title === 'Laporan Stok Barang' ? 'active' : '' }}">
            <a href="{{ url('/laporan_stok') }}" class="submenu-link">{{ __('sidebar.stokbarang') }}</a>
        </li>
        <li class="submenu-item {{ $title === 'Laporan Penjualan' ? 'active' : '' }}">
            <a href="{{ url('/laporan') }}" class="submenu-link">{{ __('sidebar.penjualan') }}</a>
        </li>
    </ul>
</li>
