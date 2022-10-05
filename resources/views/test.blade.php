@extends('layouts.app')

@section('navbar')
<nav class="navbar navbar-light bg-light flex-md-nowrap p-0">
    <div class="container-fluid">
        <span class="navbar-brand">test</span>
    </div>
    <div class="dropdown">
        <a href="#" id="dropdown-test1" class="dropdown-toggle" data-bs-toggle="dropdown" aria-haspopup="true">TEST</a>
        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdown-test1">
            <li><a href="#" class="dropdown-item">AAAA</a></li>
            <li><a href="#" class="dropdown-item">BBBB</a></li>
            <li><a href="#" class="dropdown-item">CCCCC</a></li>
        </ul>
    </div>

</nav>
<nav class="navbar navbar-light bg-primary flex-md-nowrap p-0">
    <div class="container-fluid">
        <span class="navbar-brand">test</span>
        <a href="#" id="dropdown-test1" class="dropdown-toggle" data-bs-toggle="dropdown" aria-haspopup="true">TEST</a>
        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdown-test1">
            <li><a href="#" class="dropdown-item">AAAA</a></li>
            <li><a href="#" class="dropdown-item">BBBB</a></li>
            <li><a href="#" class="dropdown-item">CCCCC</a></li>
        </ul>
    </div>
</nav>
@endsection

@section('content')

<nav>
    <div class="nav nav-tabs" id="editor-tab" role="tablist">
        <button id="editor-tab-edit" class="nav-link active" data-bs-toggle="tab" data-bs-target="#editor-edit" type="button" role="tab" aria-controls="editor-edit" aria-selected="true">
            {{ __('Edit') }}
        </button>
        <button id="editor-tab-preview" class="nav-link" data-bs-toggle="tab" data-bs-target="#editor-preview" type="button" role="tab" aria-controls="editor-preview" aria-selected="false">
            {{ __('preview') }}
        </button>
        <div class="btn-group bx-2">
            <button type="button" class="btn btn-outline-secondary"><i class="ei ei-undo"></i></button>
            <button type="button" class="btn btn-outline-secondary"><i class="ei ei-redo"></i></button>
        </div>
        <div class="btn-group bx-2">
            <button type="button" class="btn btn-outline-secondary"><span class="ei-bold"></span></button>
            <button type="button" class="btn btn-outline-secondary"><span class="ei-italic"></span></button>
            <button type="button" class="btn btn-outline-secondary"><span class="ei-underline"></span></button>
            <button type="button" class="btn btn-outline-secondary"><span class="ei-strike"></span></button>
        </div>
        <div class="btn-group bx-2">
            <button type="button" class="btn btn-outline-secondary"><span class="ei-list"></span></button>
            <button type="button" class="btn btn-outline-secondary"><span class="ei-table"></span></button>
            <button type="button" class="btn btn-outline-secondary"><span class="ei-link"></span></button>
            <button type="button" class="btn btn-outline-secondary"><span class="ei-picture"></span></button>
        </div>
    </div>
</nav>

<div class="tab-content">
    <div class="tab-pane active show" id="editor-edit" role="tabpanel" aria-labelledby="editor-tab-edit">
        <textarea name="editor" id="editor" cols="30" rows="10" class="form-control">
        </textarea>
    </div>
    <div class="tab-pane" id="editor-preview" role="tabpanel" aria-labelledby="editor-tab-preview">
        <div id="preview" class="markdown-body overflow-auto p1" style="border: thick solid gray;"></div>
    </div>
</div>

@endsection

@push('scripts')
 
<script src="https://cdnjs.cloudflare.com/ajax/libs/marked/0.3.2/marked.min.js"></script>

<script>

var tabEl = document.querySelector('button[data-bs-toggle="tab"]');
tabEl.addEventListener("hide.bs.tab", function (event) {
  event.target; // newly activated tab
  event.relatedTarget; // previous active tab
  if(event.target.id === 'editor-tab-edit'){
    let editor = document.getElementById('editor');
    let preview = document.getElementById('preview');
    preview.innerHTML = marked(editor.value);
    preview.style.height = editor.clientHeight + "px";
  }
});

</script>
@endpush