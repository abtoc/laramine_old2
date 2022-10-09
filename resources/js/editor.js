import { EditorState } from '@codemirror/state';
import { EditorView, keymap } from '@codemirror/view';
import { defaultKeymap } from '@codemirror/commands';
import { markdown } from '@codemirror/lang-markdown';
import { marked } from 'marked';
import { reloadHighlight } from './highlight';

export function Editor(el) {
    this.target = el;

    this.target.querySelector('.ei.ei-undo').parentNode.addEventListener('click', this.clickUndo.bind(this));
    this.target.querySelector('.ei.ei-redo').parentNode.addEventListener('click', this.clickRedo.bind(this));
    this.target.querySelector('.ei.ei-bold').parentNode.addEventListener('click', this.clickBold.bind(this));
    this.target.querySelector('.ei.ei-italic').parentNode.addEventListener('click', this.clickItalic.bind(this));
    this.target.querySelector('.ei.ei-underline').parentNode.addEventListener('click', this.clickUnderline.bind(this));
    this.target.querySelector('.ei.ei-strike').parentNode.addEventListener('click', this.clickStrike.bind(this));
    this.target.querySelector('.ei.ei-table').parentNode.addEventListener('click', this.clickTable.bind(this));
    this.target.querySelector('.ei.ei-list').parentNode.addEventListener('click', this.clickList.bind(this));
//    this.target.querySelector('.ei.ei-cut').parentNode.addEventListener('click', this.clickCut.bind(this));
//    this.target.querySelector('.ei.ei-copy').parentNode.addEventListener('click', this.clickCopy.bind(this));
//    this.target.querySelector('.ei.ei-paste').parentNode.addEventListener('click', this.clickPaste.bind(this));
//    this.target.querySelector('.ei.ei-code').parentNode.addEventListener('click', this.clickCode.bind(this));
    this.target.querySelector('.ei.ei-link').parentNode.addEventListener('click', this.clickLink.bind(this));
    this.target.querySelector('.ei.ei-picture').parentNode.addEventListener('click', this.clickPicture.bind(this));
    this.target.querySelector('button[data-bs-toggle="tab"]').parentNode.addEventListener('hide.bs.tab', this.hideTab.bind(this));
    this.target.querySelector('button[data-bs-toggle="tab"]').parentNode.addEventListener('show.bs.tab', this.showTab.bind(this));

    let textarea = this.target.querySelector('#editor');
    this.codemirror = new EditorView({
        state: EditorState.create({
            doc: textarea.value,
            extensions: [
                keymap.of(defaultKeymap),
                markdown()
            ],
        }),
        parent: this.target.querySelector('#editor-edit')
    });
    if(textarea.form){
        textarea.form.addEventListener('submit', (e) => { textarea.value = this.codemirror.state.doc.toString()});
    }
}


Editor.prototype.clickUndo = function(){
    console.log('undo');
}

Editor.prototype.clickRedo = function(){
    console.log('redo');
}

Editor.prototype.clickBold = function(){
    console.log('bold');
    let cm = this.codemirror;
    cm.dispatch(cm.state.replaceSelection("☆"));
}

Editor.prototype.clickItalic = function(){
    console.log('italic');
}

Editor.prototype.clickUnderline = function(){
    console.log('underline');
}

Editor.prototype.clickStrike = function(){
    console.log('strike');
}

Editor.prototype.clickTable = function(){
    console.log('table');
}

Editor.prototype.clickList = function(){
    console.log('list');
}

Editor.prototype.clickCut = function(){
    console.log('cut');
}

Editor.prototype.clickCopy = function(){
    console.log('copy');
}

Editor.prototype.clickPaste = function(){
    console.log('paste');
}

Editor.prototype.clickCode = function(){
    console.log('code');
}

Editor.prototype.clickLink = function(){
    console.log('link');
}

Editor.prototype.clickPicture = function(){
    console.log('picture');
}

Editor.prototype.hideTab = function(event){
    if(event.target.id === 'editor-tab-edit'){
        let preview = this.target.querySelector('#preview');
        preview.innerHTML = marked(this.codemirror.state.doc.toString());
        reloadHighlight(preview);
        //preview.innerHTML = marked(editor.value);
        let editor_edit = this.target.querySelector('#editor-edit');
        preview.style.height = editor_edit.clientHeight + "px";
        this.target.querySelector('#toolbar').style.display = "none";
    }
}

Editor.prototype.showTab = function(event){
    if(event.target.id === 'editor-tab-edit'){
        this.target.querySelector('#toolbar').style.display = "block";
    }
}

