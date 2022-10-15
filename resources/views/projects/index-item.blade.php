<li @class(['root' => ($project->depth === 0), 'child' => ($project->depth > 0)])>
    <div @class(['root' => ($project->depth === 0), 'child' => ($project->depth > 0)])>
        <a href="{{ route('projects.show', ['project' => $project]) }}" @class(['link-dark' => !$project->isActive()])>{{ $project->name }}</a>
        @if($project->isJoining())<i class="bi bi-person"></i>@endif
        @unless(is_null($project->description))
            <div class="markdown-body">{{ markdown($project->description) }}</div>
        @endunless
    </div>
    <ul class="projects">
        @each('projects.index-item', $project->children, 'project')
    </ul>
</li>