import './bootstrap';
import './highlight';
import { Editor } from './editor';
import { reloadHighlight } from './highlight';
import mermaid from 'mermaid';
import { renderMermaid } from './mermaid';

document.addEventListener('DOMContentLoaded', function(){
    let editor_wrap = document.querySelector('#editor-wrap');
    if(editor_wrap){
        window.editor = new Editor(document.querySelector('#markdown-editor'));
    }

    reloadHighlight(document);

    mermaid.initialize({startOnLoad: false})
    renderMermaid(document.querySelectorAll('.language-mermaid'));
});

window.mermaid = mermaid;
