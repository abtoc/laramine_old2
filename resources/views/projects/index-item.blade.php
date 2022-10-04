<li @class(['root' => ($project->depth === 0), 'child' => ($project->depth > 0)])>
    <div @class(['root' => ($project->depth === 0), 'child' => ($project->depth > 0)])>
        <a href="{{ route('projects.show', ['project' => $project]) }}" @class(['link-dark' => !$project->isActive()])>{{ $project->name }}</a>
        @unless(is_null($project->description))
            <div class="markdown-body">{!! Str::markdown($project->description, ['html_input' => 'escape']) !!}</div>
        @endunless
    </div>
    <ul class="projects">
        @each('projects.index-item', $project->children, 'project')
    </ul>
</li>