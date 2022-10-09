import mermaid from 'mermaid';

const unescapeHTML = function(target){
    if(typeof target !== 'string') return target;

    const patterns = {
        '&lt;' : '<',
        '&gt;' : '<',
        '&amp' : '&',
        '&quot;' : '"',
        '&#x27'  : '\'',
        '&#x60'  : '~'
    };

    return target.replace(/&(lt|gt|amp|quot|#x27|#x60);/g, (match) => patterns[match]);
}

export const renderMermaid = function(elements){
    elements.forEach(function(element){
        const insert = function(svg, bind){
            element.innerHTML = svg;
        }
        const code = unescapeHTML(element.innerHTML);
        mermaid.mermaidAPI.render('graphDiv', code, insert);
    });
}