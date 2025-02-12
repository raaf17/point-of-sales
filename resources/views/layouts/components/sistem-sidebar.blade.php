<li class="sidebar-item has-sub {{ $title === 'Users' || $title === 'Settings' || $title === 'Logs Activity' ? 'active' : '' }}">
    <a href="#" class='sidebar-link'>
        <i class="bi bi-stack"></i>
        <span>Sistem</span>
    </a>
    <ul class="submenu {{ $title === 'Users' || $title === 'Settings' || $title === 'Logs Activity' ? 'active' : '' }}">
        <li class="submenu-item {{ $title === 'Logs Activity' ? 'active' : '' }}">
            <a href="{{ url('/logs_activity') }}">{{ __('sidebar.log') }}</a>
        </li>
        <li class="submenu-item {{ $title === 'Users' ? 'active' : '' }}">
            <a href="{{ url('/user') }}">{{ __('sidebar.user') }}</a>
        </li>
        <li class="submenu-item {{ $title === 'Settings' ? 'active' : '' }}">
            <a href="{{ url('/setting') }}">{{ __('sidebar.web') }}</a>
        </li>
    </ul>
</li>
