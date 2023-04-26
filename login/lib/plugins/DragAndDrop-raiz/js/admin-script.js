/** help */
function log(message) {
    console.log('> ' + message)
}

/** app */
const cards = document.querySelectorAll('.card')
const dropzones = document.querySelectorAll('.dropzone')


/** our cards */
cards.forEach(card => {
    card.addEventListener('dragstart', dragstart)
    card.addEventListener('drag', drag)
    card.addEventListener('dragend', dragend)

    //card.addEventListener('mouseover', hover)
})

function hover(){
   // $('.dropzone').html($('.dropzone').html());
    //console.log(       this.getBoundingClientRect()            );
};


function dragstart() {
    // log('CARD: Start dragging ')
    dropzones.forEach( dropzone => dropzone.classList.add('highlight'));
    clone=0;

    // this = card
    this.classList.add('is-dragging');
}

function drag() {
    // log('CARD: Is dragging ')
}

function dragend() {
    // log('CARD: Stop drag! ')
    dropzones.forEach( dropzone => dropzone.classList.remove('highlight'))


    // this = card
    this.classList.remove('is-dragging')
}

/** place where we will drop cards */
dropzones.forEach( dropzone => {
    dropzone.addEventListener('dragenter', dragenter)
    dropzone.addEventListener('dragover', dragover)
    dropzone.addEventListener('dragleave', dragleave)
    dropzone.addEventListener('drop', drop)
})

function dragenter() {
    // log('DROPZONE: Enter in zone ')
}

function dragover() {
    // this = dropzone
    this.classList.add('over')





    // get dragging card
    let cardBeingDragged = document.querySelector('.is-dragging')
    // this = dropzone
    //this.appendChild(cardBeingDragged) //move

    if(clone == 0){
        this.prepend(cardBeingDragged.cloneNode(true)); // copy
          // create a new element
          button = document.createElement("button");
          button.classList.add("close");
          button.onclick = function(){ this.parentElement.remove('is-dragging'); };
          newContent = document.createTextNode(" REMOVER ");
          button.appendChild(newContent);
          this.querySelector('.is-dragging').prepend(button);
            document.querySelector('.is-dragging').classList.remove('is-dragging'); // remove class


            //document.querySelectorAll('.card').onhover = function(){ console.log(this.parentElement.children); };


            //parentElement.insertBefore(newElement, parentElement.children[2]);
        clone=1;
        //console.log('... ');

    }


   

}

function dragleave() {
    // log('DROPZONE: Leave ')
    // this = dropzone
    this.classList.remove('over')

}

function drop() {
    // log('DROPZONE: dropped ')
    this.classList.remove('over')

}

////////////////////////////////


/*
  function addTodos(nodrop=1){
    $('.dropzone').html( $('.dropzone').html() + $('.no-dropzone#'+nodrop).html() );
    //$('.dropzone').html( $('.no-dropzone#'+nodrop).html() );
    $('.dropzone .card button').remove();
    $('.dropzone .card').prepend('<button class="close" onclick="this.parentElement.remove();"> REMOVER </button>');
  }



  function ETM(TM=null){
    $(".return").click(function(){    $(".return").hide('500');   })

    window.clearTimeout(TM);
    window.TM = setTimeout(function(){
            $(".return").hide('fast');
    }, 15000);
  }

  $('.dropzone').bind('DOMSubtreeModified', function(){
    //console.log('alterado');
    //$(".return").show(600,ETM);
    // $('#permiss').submit();
  });
/**/



//-- ----------------------------------
  $('form').submit(function(event){
                 RETORNO = $(this).attr('return');
                 //console.log('retorno: ' + RETORNO);
                 $(RETORNO).show(600);
                 $(RETORNO).html("\
                    <center style=\"color:#DDD;opacity: 0.7;font-size:14px;font-weight:normal;\">Processando...  \
                      <span style=\"padding:15px; background: url(../launcher/images/loader.gif) center no-repeat;background-size: 20px; opacity: 0.8;}\"></span>\
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
                    $(RETORNO).html(data.message);
                    //$('#form_retunr').html(data.message);
                  }).fail(function(jqXHR, textStatus, msg){
                       console.error(
                          'ERRO NO FORM AJAX: \n'+msg+
                          ' \nFORM ACTION: '+this.url+
                          ' \nFORM DATA: '+this.data
                       );
                       $(RETORNO).html("\
                          <br>\
                          <center style=\"font-size:14px;color:#EE3333;margin:-20px 0px 20px 0px;\">\
                            <STRONG>DESCULPE... ALGO DEU ERRADO: </STRONG><br>\
                            Verifique a sua conexão ou contate o suporte.\
                          </center>\
                       ");
                        setTimeout(function(){
                          //$('.dropzone').click(); // Re-submit
                        },6000);
                       
                  });
                  /* ::DEBUG:: */ event.preventDefault();
  });
//-- ----------------------------------