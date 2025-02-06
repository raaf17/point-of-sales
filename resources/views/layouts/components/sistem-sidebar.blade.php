@if (auth()->user()->level == 1)
    <li class="sidebar-item  has-sub">
        <a href="#" class='sidebar-link'>
            <i class="bi bi-stack"></i>
            <span>Sistem</span>
        </a>
        <ul class="submenu ">
            <li class="submenu-item ">
                <a href="{{ url('/user') }}">{{ __('sidebar.user') }}</a>
            </li>
            <li class="submenu-item ">
                <a href="{{ url('/setting') }}">{{ __('sidebar.web') }}</a>
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
