import './bootstrap';
import './highlight';
import { Editor } from './editor';
import { reloadHighlight } from './highlight';
import mermaid from 'mermaid';
import { renderMermaid } from './mermaid';
import { Modal } from 'bootstrap';
import { message } from 'laravel-mix/src/Log';

document.addEventListener('DOMContentLoaded', function(){
    let editor_wrap = document.querySelector('#editor-wrap');
    if(editor_wrap){
        window.editor = new Editor(document.querySelector('#markdown-editor'));
    }
    Livewire.on('refreshEditor', function(){
        let editor_wrap = document.querySelector('#editor-wrap');
        if(editor_wrap){
            window.editor = new Editor(document.querySelector('#markdown-editor'));
        }
    });


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
        item.addEventListener('dragover', (event) => {
            event.preventDefault();
            event.dataTransfer.dropEffect = 'copy';
        });
        item.addEventListener('drop', function(event){
            event.preventDefault();
            this.draggable = false;
            const from = /(.+)-([0-9]+)/.exec(event.dataTransfer.getData('text'));
            const to = /(.+)-([0-9]+)/.exec(this.id);
            if(from[1] === to[1]){
                const form = this.querySelector('#dragged-form');
                form.querySelector('#from').value = from[2];
                form.submit();
            }
        });
    });

    const confirms = document.querySelectorAll('a[data-confirm]');
    confirms.forEach((confirm) => {
        confirm.addEventListener('click', (event)=> {
            event.preventDefault();
            if(!window.confirm(confirm.getAttribute('data-confirm'))){
                return false;
            }
            const form = document.querySelector(confirm.getAttribute('data-confirm-for'));
            console.log(form);
            if(form){
                form.submit();
            }
            return true;
        });
    });

    const submits = document.querySelectorAll('a[data-submit-for]');
    submits.forEach((submit) => {
        submit.addEventListener('click', (event) => {
            event.preventDefault();
            const form = document.querySelector(submit.getAttribute('data-submit-for'));
            if(form){
                form.submit();
            }
            return true;
        });
    });

    const modals = document.querySelectorAll('a[data-modal-for]');
    modals.forEach((el) => {
        const target = document.querySelector(el.getAttribute('data-modal-for'));
        const modal = new Modal(target);
        el.addEventListener('click', (event) => {
            event.preventDefault();
            modal.show();
        });
        target.addEventListener('hidden.bs.modal', (event) =>{
            Livewire.emit('hiddenModal');
        });
        Livewire.on('hideModal', ()=>{
            modal.hide();
        });
        Livewire.on('errorModal', (message) =>{
            alert(message);
        });
    });
});

window.mermaid = mermaid;
