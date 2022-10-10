import _ from 'lodash';
import { EditorState } from '@codemirror/state';
import { EditorView, keymap } from '@codemirror/view';
import { defaultKeymap } from '@codemirror/commands';
import { indentWithTab } from '@codemirror/commands';
import { markdown } from '@codemirror/lang-markdown';
import { marked } from 'marked';
import { reloadHighlight } from './highlight';
import DOMPurify from 'dompurify';
import { renderMermaid } from './mermaid';

export function Editor(el) {
    this.target = el;

    this.target.querySelector('.ei.ei-bold').parentNode.addEventListener('click', this.clickBold.bind(this));
    this.target.querySelector('.ei.ei-italic').parentNode.addEventListener('click', this.clickItalic.bind(this));
    this.target.querySelector('.ei.ei-strike').parentNode.addEventListener('click', this.clickStrike.bind(this));
    this.target.querySelector('.ei.ei-table').parentNode.addEventListener('click', this.clickTable.bind(this));
    this.target.querySelector('.ei.ei-list').parentNode.addEventListener('click', this.clickList.bind(this));
    this.target.querySelector('.ei.ei-code').parentNode.addEventListener('click', this.clickCode.bind(this));
    this.target.querySelector('.ei.ei-link').parentNode.addEventListener('click', this.clickLink.bind(this));
    this.target.querySelector('.ei.ei-picture').parentNode.addEventListener('click', this.clickPicture.bind(this));
    this.target.querySelector('button[data-bs-toggle="tab"]').parentNode.addEventListener('hide.bs.tab', this.hideTab.bind(this));
    this.target.querySelector('button[data-bs-toggle="tab"]').parentNode.addEventListener('show.bs.tab', this.showTab.bind(this));

    let textarea = this.target.querySelector('#editor');
    this.codemirror = new EditorView({
        state: EditorState.create({
            doc: textarea.value,
            extensions: [
                keymap.of([defaultKeymap, indentWithTab]),
                markdown()
            ],
        }),
        parent: this.target.querySelector('#editor-edit')
    });
    if(textarea.form){
        textarea.form.addEventListener('submit', (e) => { textarea.value = this.codemirror.state.doc.toString()});
    }
}

Editor.prototype._changeCharacters = function(cm, s, e){
    const from = cm.state.selection.main.from;
    const to   = cm.state.selection.main.to;
    const text  = s + cm.state.sliceDoc(from, to) + e;
    cm.dispatch({
        changes: { from: from, to: to, insert: text }
    });
}

Editor.prototype._changeParagraph = function(cm, p)
{
    let from   = cm.state.selection.main.from;
    let to     = cm.state.selection.main.to;
    const str =  cm.state.doc.toString();
    for(; from>0; from--){
        if(str[from] === "\n") break;
    }
    for(; to<str.length; to++){
        if(str[to] === "\n") break;
    }
    const text = cm.state.sliceDoc(from, to);
    const list = text.split("\n");
    let newList = [];
    list.forEach((item) => {newList.push(item.replace(/^(.*)$/g, (p + ' ' + '$1')))});
    const newText = newList.join("\n");
    cm.dispatch({
        changes: { from: from, to: to, insert: newText }
    });
}

Editor.prototype._insertParagraph = function(cm, p)
{
    let to     = cm.state.selection.main.to;
    const str =  cm.state.doc.toString();
    for(; to<str.length; to++){
        if(str[to] === "\n") break;
    }
    cm.dispatch({
        changes: { from: to, insert: p }
    });
}

Editor.prototype._changeParagraphAll = function(cm, p)
{
    let from   = cm.state.selection.main.from;
    let to     = cm.state.selection.main.to;
    const str =  cm.state.doc.toString();
    for(; from>0; from--){
        if(str[from] === "\n") break;
    }
    for(; to<str.length; to++){
        if(str[to] === "\n") break;
    }
    const text = p + "\n" + cm.state.sliceDoc(from, to) + "\n" + p;
    cm.dispatch({
        changes: { from: from, to: to, insert: text }
    });
}

Editor.prototype.clickBold = function(){
    this._changeCharacters(this.codemirror, '**', '**');
}

Editor.prototype.clickItalic = function(){
    this._changeCharacters(this.codemirror, '*', '*');
}

Editor.prototype.clickStrike = function(){
    this._changeCharacters(this.codemirror, '~~', '~~');
}

Editor.prototype.clickTable = function(){
    this._insertParagraph(this.codemirror, `
|A  |B  |C  |D  |
|---|---|---|---|
|   |   |   |   |
|   |   |   |   |
`);
}

Editor.prototype.clickList = function(){
    this._changeParagraph(this.codemirror, '-');
}

Editor.prototype.clickCode = function(){
    this._changeParagraphAll(this.codemirror, '```');
}

Editor.prototype.clickLink = function(){
    this._changeCharacters(this.codemirror, '[', '](https://)');
}

Editor.prototype.clickPicture = function(){
    this._changeCharacters(this.codemirror, '![', '](https://)');
}

Editor.prototype.hideTab = function(event){
    if(event.target.id === 'editor-tab-edit'){
        let preview = this.target.querySelector('#preview');
        preview.innerHTML = DOMPurify.sanitize(marked(this.codemirror.state.doc.toString()));
        reloadHighlight(preview);
        renderMermaid(this.target.querySelectorAll('pre code.language-mermaid'));
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

