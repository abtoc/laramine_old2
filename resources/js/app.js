import './bootstrap';
import './highlight';
import { Editor } from './editor';
import { reloadHighlight } from './highlight';

document.addEventListener('DOMContentLoaded', function(){
    let editor_wrap = document.querySelector('#editor-wrap');
    if(editor_wrap){
        window.editor = new Editor(document.querySelector('#markdown-editor'));
    }

    reloadHighlight(document);
});
