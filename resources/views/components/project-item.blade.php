<li @class(['root' => ($project->depth === 0), 'child' => ($project->depth > 0)])>
    <div @class(['root' => ($project->depth === 0), 'child' => ($project->depth > 0)])>
        <a href="{{ route('projects.show', ['project' => $project]) }}">{{ $project->name }}</a>
        <div class="markdown">{{ $project->discription }}</div>
    </div>
    <ul class="projects">
        @each('components.project-item', $project->children, 'project')
    </ul>
</li>