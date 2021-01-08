<li class="nav-item {{ Nav::isRoute('materiku.index') }}">
    <a class="nav-link" href="{{ route('materiku.index') }}">
        <i class="fas fa-fw fa-book"></i>
        <span>{{ __('Materiku') }}</span>
    </a>
</li>

<li class="nav-item {{ Nav::isRoute('premium_data') }}">
    <a class="nav-link" href="{{ route('premium_data') }}">
        <i class="fas fa-fw fa-book"></i>
        <span>{{ __('Akun') }}</span>
    </a>
</li>
