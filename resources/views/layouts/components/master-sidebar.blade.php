@if (auth()->user()->level == 1)
    <li class="sidebar-item  has-sub">
        <a href="#" class='sidebar-link'>
            <i class="bi bi-stack"></i>
            <span>Master Data</span>
        </a>
        <ul class="submenu ">
            <li class="submenu-item ">
                <a href="{{ url('/kategori') }}" class="submenu-link">{{ __('sidebar.category') }}</a>
            </li>
            <li class="submenu-item ">
                <a href="{{ url('/produk') }}" class="submenu-link">{{ __('sidebar.product') }}</a>
            </li>
            <li class="submenu-item ">
                <a href="{{ url('/member') }}" class="submenu-link">{{ __('sidebar.member') }}</a>
            </li>
        </ul>
    </li>
@else
    <li>
        <a href="{{ route('transaksi.baru') }}">
            <i class="fa fa-cart-arrow-down"></i> <span>Transaksi Baru</span>
        </a>
    </li>
@endif
