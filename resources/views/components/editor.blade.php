<div id="markdown-editor">
    <nav class="d-flex">
        <div class="nav nav-tabs" id="editor-tab" role="tablist">
            <button id="editor-tab-edit" class="nav-link py-1 active" data-bs-toggle="tab" data-bs-target="#editor-edit" type="button" role="tab" aria-controls="editor-edit" aria-selected="true">
                {{ __('Edit') }}
            </button>
            <button id="editor-tab-preview" class="nav-link py-1" data-bs-toggle="tab" data-bs-target="#editor-preview" type="button" role="tab" aria-controls="editor-preview" aria-selected="false">
                {{ __('Preview') }}
            </button>
        </div>
        <div id="toolbar" class="align-middle">
            <div class="btn-group mx-1 align-middle">
                <button type="button" class="btn btn-outline-secondary btn-sm"><i class="ei ei-bold"></i></button>
                <button type="button" class="btn btn-outline-secondary btn-sm"><i class="ei ei-italic"></i></button>
                <button type="button" class="btn btn-outline-secondary btn-sm"><i class="ei ei-strike"></i></button>
            </div>
            <div class="btn-group mx-1 align-middle">
                <button type="button" class="btn btn-outline-secondary btn-sm"><i class="ei ei-list"></i></button>
                <button type="button" class="btn btn-outline-secondary btn-sm"><i class="ei ei-table"></i></button>
                <button type="button" class="btn btn-outline-secondary btn-sm"><i class="ei ei-code"></i></button>
            </div>
            <div class="btn-group mx-1 align-middle">
                <button type="button" class="btn btn-outline-secondary btn-sm"><i class="ei ei-link"></i></button>
                <button type="button" class="btn btn-outline-secondary btn-sm"><i class="ei ei-picture"></i></button>
            </div>
        </div>
    </nav>
    <style>
        .cm-editor {
            min-height: 160px;
            max-height: 400px;
            overflow: auto;
            border: 1px solid lightgray;
        }
    </style>
    <div id="editor-wrap" class="tab-content">
        <div class="tab-pane active show" id="editor-edit" role="tabpanel" aria-labelledby="editor-tab-edit" style="border: 1px solid lightgray;">
            <textarea name="{{ $name }}" id="editor" cols="30" rows="10" class="form-control d-none">{{ $slot }}</textarea>
        </div>
        <div class="tab-pane overflow-auto" id="editor-preview" role="tabpanel" aria-labelledby="editor-tab-preview" style="border: 1px solid lightgray;">
            <div id="preview" class="markdown-body"></div>
        </div>
    </div>
</div>
