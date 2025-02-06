@if (auth()->user()->level == 1)
    <li class="sidebar-item  has-sub">
        <a href="#" class='sidebar-link'>
            <i class="bi bi-menu-down"></i>
            <span>Transaksi</span>
        </a>
        <ul class="submenu ">
            <li class="submenu-item ">
                <a href="{{ url('/pengeluaran') }}">{{ __('sidebar.expenditure') }}</a>
            </li>
            <li class="submenu-item ">
                <a href="{{ url('/pembelian') }}">{{ __('sidebar.purchase') }}</a>
            </li>
            <li class="submenu-item ">
                <a href="{{ url('/penjualan') }}">{{ __('sidebar.sale') }}</a>
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
