let input = document.getElementById('text-vak');
// rendering a page
let editor = CodeMirror.fromTextArea(input, {
    lineNumbers: true,
    mode: 'text/html',
    theme: "erlang-dark",
    htmlMode: true,
    startOpen: true,
    extraKeys: {"Ctrl-Space": "autocomplete"}
});

editor.setSize(800, 400);
// choosing a language

function getValue(x) {
    let value = x.options[x.selectedIndex].innerText;
    var modes = {'SQL':'text/x-sql','PHP':'text/x-php','Javascript':'text/javascript','CSS':'text/css', 'HTML':'text/html'};
    console.log(value); 
    editor.setOption('mode', modes[value]);
}

let select = document.getElementById('language').value;

if (select) {
    let value = select;
    var modes = {'SQL':'text/x-sql','PHP':'text/x-php','Javascript':'text/javascript','CSS':'text/css', 'HTML':'text/html'};
    console.log(value); 
    editor.setOption('mode', modes[value]);
}
