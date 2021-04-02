var toolbarOptions = {    toolbar: [
  ['save'],
  [ 'bold', 'italic', 'underline', 'strike' ],
  [{ 'color': [] }, { 'background': [] }],
  [{ 'header': '1' }, { 'header': '2' }, 'code-block' ],
  [{ 'list': 'ordered' }, { 'list': 'bullet'}],
  [ 'link', 'image', 'video'],
  [ 'clean' ],
]

};

var quill = new Quill('#editor-container', {
  modules: toolbarOptions,
  placeholder: 'Olá mundo!! Escreva aqui algo épico...ou nem tanto.',
  theme: 'snow'    // 'snow'  or 'bubble'
});


$('button.ql-save').click(function() {
  ColetarDados();
});

function Localizar(){
  ColetarDados();
  const selfQuill = this.quill
  const myEditor = document.querySelector('#quill-editor')
  const text = selfQuill.root.innerHTML
  document.querySelector('.Delta').innerHTML = text
  LocalizarTag("<img",'DeltaIMG',"\"\>");
}

function LocalizarTag(tag,alvoTextArea,fTag){
  texto=document.querySelector('.Delta').value;
  receboimg=false;
  lockimg=false;
  imgstring="";
  for (var i = 0; i < texto.length; i++) {
    if (texto.substring(i, i+tag.length)==tag&&lockimg==false){
      receboimg=true;
    }else if (texto.substring(i, i+fTag.length)==fTag&&receboimg==true){
      imgstring=imgstring+fTag;
      receboimg=false;
      lockimg=true;
    }
    if (receboimg==true){
      imgstring=imgstring+(texto.substring(i, i+1));

    }
  }
  document.getElementById(alvoTextArea).value=imgstring;
}
