<li @class(['root' => ($project->depth === 0), 'child' => ($project->depth > 0)])>
    <div @class(['root' => ($project->depth === 0), 'child' => ($project->depth > 0)])>
        <a href="{{ route('projects.show', ['project' => $project]) }}">{{ $project->name }}</a>
        @unless(is_null($project->description))
            <div class="markdown">{!! Str::markdown($project->description, ['html_input' => 'escape']) !!}</div>
        @endunless
    </div>
    <ul class="projects">
        @each('components.project-item', $project->children, 'project')
    </ul>
</li>