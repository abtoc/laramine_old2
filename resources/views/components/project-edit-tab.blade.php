<ul class="nav nav-tabs mb-3">
    @can('update', $project)
        <li class="nav-item">
            <x-nav-link href="{{ route_query('projects.edit.setting', ['project' => $project])}}" active="{{ is_route_named('projects.edit.setting') }}">{{ __('Project') }}</x-nav-link>
        </li>
    @endcan
    @can('member', $project)
        <li class="nav-item">
            <x-nav-link href="{{ route_query('projects.edit.member', ['project' => $project]) }}" active="{{ is_route_named('projects.edit.member') }}">{{ __('Member') }}</x-nav-link>
        </li>
    @endcan
</ul>
