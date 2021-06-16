$("document").ready(function($){




  var nav = $('.ql-toolbar');
  var editor = $('.ql-editor');
  var btn = $('.btn-expandir');

  btn.click(function() {
    window.scrollTo(0, 0);
    editor.toggleClass("full");
    nav.toggleClass("fix-toobar");
    btn.toggleClass("Btnfull");


  });

});



function ColetarDados(){
  var url_atual = window.location.href;

  if ($('.titulo').val()==""){
      alert("Campo do titulo esta em branco\nNão é possivel criar o checkpoint");
  }else{
    setCookie("TituloEditorMakendo"+window.location.href, $('.titulo').val());
    setCookie("ConteudoEditorMakendo"+window.location.href, $('.ql-editor').html());
  }

  }
function puxaCookie(){
  var url_atual = window.location.href;
  if (checkCookie("TituloEditorMakendo"+window.location.href)){
    $('.ql-editor').html(getCookie("ConteudoEditorMakendo"+window.location.href));
    $('.titulo').val(getCookie("TituloEditorMakendo"+window.location.href));
  }
}

function setCookie(cname, cvalue) {
  localStorage.setItem(cname, cvalue);
}

function getCookie(cname) {
  return localStorage.getItem(cname);
}

function checkCookie(cname) {
  var user = getCookie(cname);
  if (user != null) {
    return true;
  } else {
    return false;
  }
}
