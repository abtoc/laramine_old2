<li @class(['root' => $project->depth === 0, 'child' => $project->depth > 0]) style="list-style-type: none;">
    <div class="form-check">
        <input type="checkbox" id="form-check-{{ $project->id }}" class="form-check-input" name="projects[]" value="{{ $project->id }}" @checked(in_array($project->id, $projects_old))>
        <label for="form-check-{{ $project->id }}" class="form-check-label">{{ $project->name }}</label>
    </div>
    <ul class="projects">
        @foreach($project->children as $child)
            @include('trackers.edit-projects', ['project' => $child, 'projects_old' => $projects_old])
        @endforeach
    </ul>
</li>