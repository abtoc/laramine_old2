import './bootstrap';
import './highlight';
import { Editor } from './editor';
import { reloadHighlight } from './highlight';
import mermaid from 'mermaid';
import { renderMermaid } from './mermaid';
import { fromCodePoint } from '@codemirror/state';

document.addEventListener('DOMContentLoaded', function(){
    let editor_wrap = document.querySelector('#editor-wrap');
    if(editor_wrap){
        window.editor = new Editor(document.querySelector('#markdown-editor'));
    }

    reloadHighlight(document);

    mermaid.initialize({startOnLoad: false})
    renderMermaid(document.querySelectorAll('.language-mermaid'));

    const items = document.querySelectorAll('.dragged-item');
    items.forEach((item) => {
        item.querySelector('.dragged-button').addEventListener('mousedown', (event)=>{
            item.draggable = true;
            item.addEventListener('dragstart', (event) => {
                event.dataTransfer.setData('text/plain', event.target.id);
            });
        });
        item.addEventListener('mouseout', (event)=>{

        });
        item.addEventListener('dragover', (event) => {
            event.preventDefault();
            event.dataTransfer.dropEffect = 'copy';
        });
        item.addEventListener('drop', function(event){
            event.preventDefault();
            this.draggable = false;
            const form = this.querySelector('#dragged-form');
            form.querySelector('#from').value = event.dataTransfer.getData('text');
            form.submit();
        });
    });
});

window.mermaid = mermaid;
