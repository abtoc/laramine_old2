<ul class="nav nav-tabs mb-3">
    <li class="nav-item">
        <x-nav-link href="{{ route_query('groups.edit', ['group' => $group])}}" active="{{ is_route_named('groups.edit') }}">{{ __('All') }}</x-nav-link>
    </li>
    @if($group->isGroup(true))
        <li class="nav-item">
            <x-nav-link href="{{ route_query('groups.users', ['group' => $group]) }}" active="{{ is_route_named('groups.users') }}">{{ __('User') }}</x-nav-link>
        </li>
    @endif
    <li class="nav-item">
        <x-nav-link href="{{ route_query('groups.projects', ['group' => $group]) }}" active="{{ is_route_named('groups.projects') }}">{{ __('Project') }}</x-nav-link>
    </li>
</ul>
