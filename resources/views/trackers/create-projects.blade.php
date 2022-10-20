<li @class(['root' => $project->depth === 0, 'child' => $project->depth > 0]) style="list-style-type: none;">
    <div class="form-check">
        <input type="checkbox" id="form-check-{{ $project->id }}" class="form-check-input" name="projects[]" value="{{ $project->id }}" @checked(in_array($project->id, [old('projects')]))>
        <label for="form-check-{{ $project->id }}" class="form-check-label">{{ $project->name }}</label>
    </div>
    <ul class="projects">
        @each('trackers.create-projects', $project->children, 'project')
    </ul>
</li>