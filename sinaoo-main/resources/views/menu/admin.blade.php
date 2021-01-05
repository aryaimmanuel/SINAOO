<li class="nav-item {{ Nav::isRoute('member.index') }}">
    <a class="nav-link" href="{{ route('member.index') }}">
        <i class="fas fa-fw fa-users"></i>
        <span>{{ __('Users') }}</span>
    </a>
</li>

<li class="nav-item {{ Nav::isRoute('lesson.category') }}">
    <a class="nav-link" href="{{ route('lesson.category') }}">
        <i class="fas fa-fw fa-book"></i>
        <span>{{ __('Categories') }}</span>
    </a>
</li>

<li class="nav-item {{ Nav::isRoute('lesson.index') }}">
    <a class="nav-link" href="{{ route('lesson.index') }}">
        <i class="fas fa-fw fa-building"></i>
        <span>{{ __('Lessons') }}</span>
    </a>
</li>
