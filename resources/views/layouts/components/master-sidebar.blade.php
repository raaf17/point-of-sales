<li class="sidebar-item has-sub {{ $title === 'Kategori' || $title === 'Produk' || $title === 'Members' || $title === 'Supplier' ? 'active' : '' }}">
    <a href="#" class='sidebar-link'>
        <i class="bi bi-stack"></i>
        <span>Master Data</span>
    </a>
    <ul class="submenu {{ $title === 'Kategori' || $title === 'Produk' || $title === 'Members' || $title === 'Supplier' ? 'active' : '' }}">
        <li class="submenu-item {{ $title === 'Kategori' ? 'active' : '' }}">
            <a href="{{ url('/kategori') }}" class="submenu-link">{{ __('sidebar.category') }}</a>
        </li>
        <li class="submenu-item {{ $title === 'Produk' ? 'active' : '' }}">
            <a href="{{ url('/produk') }}" class="submenu-link">{{ __('sidebar.product') }}</a>
        </li>
        <li class="submenu-item {{ $title === 'Members' ? 'active' : '' }}">
            <a href="{{ url('/member') }}" class="submenu-link">{{ __('sidebar.member') }}</a>
        </li>
        <li class="submenu-item {{ $title === 'Supplier' ? 'active' : '' }}">
            <a href="{{ url('/supplier') }}" class="submenu-link">{{ __('sidebar.supplier') }}</a>
        </li>
    </ul>
</li>
