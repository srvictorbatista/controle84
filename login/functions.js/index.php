//-- ----------------------------------
$('form').submit(function(event){
                // event.currentTarget.childNodes[3].childNodes[7].childNodes[0].innerHTML= "";
                $('#'+event.target.parentNode.id+' form #form_retunr').eq(0).html("\
                    <center style=\"color:#DDD;opacity: 0.7;font-size:14px;font-weight:normal;\">Processando...  \
                      <span style=\"padding:15px; background: url(launcher/images/loader.gif) center no-repeat;background-size: 20px; opacity: 0.8;}\"></span>\
                    </center>\
                 ");
                 $.ajax({
                    type: $(this).attr('method'),
                    url: $(this).attr('action'),
                    data: new FormData($(this)[0]),
                    mimeType: "multipart/form-data",
                    contentType: false,
                    processData:false,
                    dataType: "json",
                    encode: true,
                  }).done(function(data){
                    $('#'+event.target.parentNode.id+' form #form_retunr').eq(0).html(data.message);
                  }).fail(function(jqXHR, textStatus, msg){
                       console.error(
                          'ERRO NO FORM AJAX: \n'+msg+
                          ' \nFORM ACTION: '+this.url+
                          ' \nFORM DATA: '+this.data
                       );
                       $('#'+event.target.parentNode.id+' form #form_retunr').eq(0).html("\
                          <br>\
                          <center style=\"font-size:14px;color:#EE3333;margin:-20px 0px 20px 0px;\">\
                            <STRONG>DESCULPE... ALGO DEU ERRADO: </STRONG><br>\
                            Verifique a sua conexão ou contate o suporte.\
                          </center>\
                       ");
                        setTimeout(function(){
                           $('#'+event.target.parentNode.id+' form').eq(0).submit();  // Re-submit
                        },6000);
                       
                  });
                  /* ::DEBUG:: */ event.preventDefault();
});

//-- ----------------------------------
// Sugerir senha
function rand_str(length=1,charac='all') {
    let result = '';
    let characters = 'ABCDEFGHJKLMNPQRSTUVWXYZabcdefghjkmnpqrstuvwxyz1234567890_!@#$%&+*Çç{}[]()-?'; //iloIO§£¢¬/|,.;:ªº°^~';
    if(charac == 1){
        characters = 'ABCDEFGHJKLMNPQRSTUVWXYZ'; //IO
    } if(charac == 2){
        characters = 'abcdefghjkmnpqrstuvwxyz'; //ilo
    } if(charac == 3){
        characters = '1234567890';        
    } if(charac == 4){
        characters = '_!@#$%&+*Çç{}[]()-?'; //§£¢¬/|,.;:ªº°^~';
    }
    const charactersLength = characters.length;
    let counter = 0;
    while (counter < length) {
      result += characters.charAt(Math.floor(Math.random() * charactersLength));
      counter += 1;
    }
    return result;
}
function rand_pwd(){
  RANDON_PWD = 
    rand_str(1,1)+ // Maiusculo
    rand_str(1,4)+ // Simbolo
    rand_str(1,3)+ // Numero
    rand_str(4)+   // Aleatorio    
    rand_str(1,2); // minusculo

    $('input[name="senha1"], input[name="senha2"]').
      attr('style','color:#157C17 /*#C70000*/; font-weight:bold;font-size:24px;').
      attr('type','text').
      val(RANDON_PWD);
    //return RANDON_PWD;
}
$('input[name="senha1"], input[name="senha2"]').focus(function(){
    $('input[name="senha1"], input[name="senha2"]').
        attr('style','');
});

$('input[name="senha1"]').blur(function(){
   //console.log('...');
    $('input[name="senha1"]').
        attr('type','pwd');
});
$('input[name="senha2"]').blur(function(){
   //console.log('...');
    $('input[name="senha2"]').
        attr('type','pwd');
});
//-- ----------------------------------
// Verificacao de retornos
A = setInterval(function(){
  try {
    if($('input[name="2Fa"]').val().length >1){
        //console.log('sim');
        $('input[name="validation"]').val($('input[name="2Fa"]').val());
        $('#2fawaget').submit();
        //clearInterval(A);
    }
  } catch(err){void(0)} 
}, 5000);
B = setInterval(function(){
  try {
    if($('input[name="TokenIn"]').val().length >1){
        //console.log('sim');
        $('#login input[name="login"]').val($('#subsc #fh5co-form input[name="login"]').val());
        $('input[name="pwd"]').val($('input[name="senha1"]').val());
        $('#tolls #login').click();
        $('#login #fh5co-form').submit();
        $('input[name="senha1"], input[name="senha2"]').attr('style','').attr('type','pwd');
        clearInterval(B);
    }
  } catch(err){void(0)} 
}, 15000);

setInterval(function(){
  try {
    if($('input[name="goit"]').val().length >1){
    window.open($('input[name="goit"]').val(),'_self');
    }
  } catch(err){void(0)} 
  //console.log('aguardando...');
}, 1500);

//logou!
setInterval(function(){
  try {
    if($('input[name="TokenLoged"]').val().length >1){
    window.open($('input[name="TokenLoged"]').val(),'_self');
    }
  } catch(err){void(0)} 
  //console.log('aguardando...');
}, 1800);
//-- ----------------------------------
