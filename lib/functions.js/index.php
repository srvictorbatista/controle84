<? 
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
include_once('../../_config.php'); include_once('../../_sessao.php'); ?>
<?if(!@empty($_GET)){ //echo print_r($_GET);?>
  <?IF(
    (@$_GET['pgn'] == 'index.php') || 
    (@$_GET['pgn'] == 'pacotes.php')
  ): ?>
//-- --------------------------------------------------------------------------
//-- --------------------------------------------------------------------------
//-- ----------------------------------
  //-----------------------------------------------------
  //-- ---------| Reload functions (com time) |----------
  //-----------------------------------------------------
  if((typeof RealoadThisScript === "undefined")){
    RealoadThisScript = '\
    <SCRIPT id="RealoadThisScript"\>\
    $(\'#RealoadThisScript\').remove();\n\
    function time(){\n\
       return new Date().getTime();\n\
    }\n\
    function getQueryParam(urlParam, paramName){\n\
      var found = null; \n\
      var parts = urlParam.split("?");\n\
      if (parts.length > 1) {\n\
        var params = parts[1].split("&");\n\
        params.forEach(function(item) {\n\
          var keyValue = item.split("=");\n\
          if (keyValue[0] === paramName) {\n\
            found = keyValue[1];\n\
          }\n\
        });\n\
      }\n\
      return found;\n\
    }\n\
    function forceReloadJS(srcUrlContains) {\n\
      $.each($(\'script:empty[src*="\' + srcUrlContains + \'"]\'), function(index, el) {\n\
        var oldSrc = $(el).attr(\'src\');\n\
        var oldTime = getQueryParam(oldSrc,\'time\');\n\
          if(oldTime==null){\n\
              var EndUrl = \'&time=\'+time();\n\
          }else{EndUrl=\'\';}\n\
          var newSrc = oldSrc.replace(oldTime, time());\n\
        $(el).remove();\n\
        $(\'\<script/>\').attr(\'src\', newSrc+EndUrl).appendTo(\'body\');\n\
      });\n\
    }\n\
    setInterval(function(){\n\
       forceReloadJS(\'functions.js?pgn=index\') // apenas no index\n\
    }, 15000);\n\
    </SCRIPT>';
    $('body').append(RealoadThisScript);
  }
  //-----------------------------------------------------
//-- ----------------------------------





//-- ----------------------------------
//-- --- Alarm
//-- ----------------------------------
setInterval(function(){
    //alarm('Isto é um teste de notificação/alarme.');
}, 300000);


//-- ----------------------------------
//-- --- Resumo Mensal
//-- ----------------------------------
if((typeof $('#resumomensal .box .number h2').html() != "undefined")){
  function GoPrevMensal(
    Mes='Mês de Teste',
    Realizado='Realizado (0)',
    Realizado_valor='R$ 0,00',
    Falta='Falta (0)',
    Falta_valor='R$ 0,00',
    Previsto='Previsto (0)',
    Previsto_valor='R$ 0,00',
    Progresso='Progresso: ',
    Progresso_val1='0',
    Progresso_val2='0',
    Precent1=0, 
    Precent2=0
    ){ 
      if(Precent1>100){Precent1=100;}//if(Precent1<0){Precent1=0;}
      /*if(Precent2>100){Precent2=100;}*/if(Precent2<0){Precent2=0;}
      start = parseFloat($('#resumomensal .box .number h2').html().replace(/[^0-9]/g,'-'));
      end = parseFloat(Precent1);
      if(start <= end){       
        //console.log('start é menor que end');
        for(i = start; i < end; i++){
          setTimeout(function(){
            $('#resumomensal .box .number h2').html(
              parseFloat($('#resumomensal .box .number h2').html().replace(/[^0-9]/g,'-'))+1+'%'
            );            
          }, i*25);    
        }
      }else{
        //console.log('start é maior que end');       
        for(i = end; i < start; i++){
          setTimeout(function(){
            $('#resumomensal .box .number h2').html(
              parseFloat($('#resumomensal .box .number h2').html().replace(/[^0-9]/g,'-'))-1+'%'
            );            
          }, i*25);    
        }
      }

      //-- -------- Se negativo ---------
      if(end < 0){  
      $('#resumomensal circle:nth-child(2), #resumomensal .number h2, #resumomensal #refresh').
        css({
            "stroke": "#44FF00",//#008888", 
            "color":  "#44FF00"//"#339999"
        });
        setTimeout(function(){ // Converte negativo em positivo (na exibição)
          $('#resumomensal .box .number h2').html(
             '+'+ parseFloat($('#resumomensal .box .number h2').html().replace(/[^0-9]/g,''))+'%'
          );
        }, 650);  
      }else{ 
      $('#resumomensal circle:nth-child(2), #resumomensal .number h2, #resumomensal #refresh').
        css({
            "stroke": "#FF9600", 
            "color": "#FF9600"
        });
      }

      setTimeout(function(){
        $('#resumomensal #mes').html(Mes);

        $('#resumomensal #realizado').html(Realizado);
        $('#resumomensal #realizado_valor').html(Realizado_valor);
        
        $('#resumomensal #falta').html(Falta);
        $('#resumomensal #falta_valor').html(Falta_valor);
        
        $('#resumomensal #previsto').html(Previsto);
        $('#resumomensal #previsto_valor').html(Previsto_valor);

        $('#resumomensal #progresso').html(Progresso);
        $('#resumomensal #progresso_valor').html('<b>'+Progresso_val1+'</b>/'+Progresso_val2+' &nbsp; '+Precent2+'%');        
        $('#resumomensal #circleProgress').css('strokeDashoffset', 440 - (440 * Precent1) /100);
        $('#resumomensal .progress-bar').css('width',Precent2+'%')
      }, 500);

      setTimeout(function(){
        $('#resumomensal #refresh').css('color','#454d5540 !mportant');
      }, 500);
  }
      //-- ----------------------------------
      <?   include_once("../php/_grap_resumo_mes.php");       ?>
      //-- ----------------------------------
}
//-- ----------------------------------



function novopacote(
        pacote_title = '<i class="far fas fa-solid fa-box-open nav-icon"></i><sup style="font-weight: 900;font-size: 17px;margin: -10px -2px 0px 2px;">+</sup> &nbsp; Novo Pacote',
        pacote_id = '',
        pacote_nome = '',
        pacote_descricao = '',
        pacote_valor = '',
        pacote_btn_link_2 = 'javascript:void(0)',
        pacote_btn_label_2 = 'Fechar'
){
        MODAL(
            [
                {
                    'title': pacote_title, 
                    'body':''+

                      "           <input type=\"hidden\"  name=\"pacote_id\" value=\""+pacote_id+"\" id=\"\"> "+

                      "            <div class=\"form-group\">"+
                      "               <label>Nome do Pacote<span style=\"color:#FF3333;\">*</span></label>"+
                      "                <input type=\"text\" name=\"pacote_nome\" value=\""+pacote_nome+"\" id=\"\" class=\"form-control\" placeholder=\"Nome do Pacote\"  >"+
                      "                <input type=\"hidden\" name=\"pacote_novo\" value=\"<?=$_SESSION["PREFIX"];?>\" >"+
                      "            </div>"+

                      "            <!-- div class=\"form-group\">"+
                      "               <label>Descrição</label>"+
                      "                <textarea name=\"pacote_descricao\" id=\"\" class=\"form-control\" placeholder=\"Descrição...\" >"+pacote_descricao+"</textarea>"+
                      "            </div -->"+

                      "            <div class=\"form-group\">"+
                      "               <label>Valor R$</label>"+
                      "                <input type=\"text\" name=\"pacote_valor\" value=\""+pacote_valor+"\" id=\"\" class=\"form-control\" placeholder=\"R$ ___.___,__\" >"+
                      "            </div>"+


                      "<div id=\"hospselect\">"+

                      "</div>",
                    'action':'<?=$url;?>../../lib/php/novopacote.php',
                    'method':'POST',
                }, 
                {'type':'submit', 'name':'NAME1', 'value':'VALOR1', 'label':'Enviar', 'link':'javascript:void(0)'},
                {'type':'button', 'name':'NAME2', 'value':'VALOR2', 'label':pacote_btn_label_2, 'link':pacote_btn_link_2}
            ]
        );
        /*************************************************/

}

//-- ----------------------------------
//-- ----------------------------------

function pacoteedit(
        pacote_edit_title = '<i class="far fas fa-solid fa-box-open nav-icon"></i> <sup style="font-size: 12px;margin-left:-5px;"><i class="far fas fa-solid fa-pen"></i></sup> &nbsp; Editar Pacote',
        pacote_edit_id = '',
        pacote_edit_nome = '',
        pacote_edit_descricao = '',
        pacote_edit_valor = '',
        pacote_edit_btn_link_2 = 'javascript:void(0)',
        pacote_edit_btn_label_2 = 'Fechar'
){
        MODAL(
            [
                {
                    'title': pacote_edit_title, 
                    'body':''+

                      "           <input type=\"hidden\"  name=\"pacote_edit_id\" value=\""+pacote_edit_id+"\" id=\"\"> "+

                      "            <div class=\"form-group\">"+
                      "               <label>Nome do Pacote<span style=\"color:#FF3333;\">*</span></label>"+
                      "                <input type=\"text\" name=\"pacote_edit_nome\" value=\""+pacote_edit_nome+"\" id=\"\" class=\"form-control\" placeholder=\"Nome\"  >"+
                      "            </div>"+

                      "            <!-- div class=\"form-group\">"+
                      "               <label>Descrição</label>"+
                      "                <textarea name=\"pacote_edit_descricao\" id=\"\" class=\"form-control\" placeholder=\"Descrição...\" >"+pacote_edit_descricao+"</textarea>"+
                      "            </div -->"+

                      "            <div class=\"form-group\">"+
                      "               <label>Valor R$</label>"+
                      "                <input type=\"text\" name=\"pacote_edit_valor\" value=\""+pacote_edit_valor+"\" id=\"\" class=\"form-control\" placeholder=\"R$ ___.___,__\" >"+
                      "            </div>"+


                      "<div id=\"hospselect\">"+


                      "</div>",
                    'action':'<?=$url;?>../../lib/php/editarpacote.php',
                    'method':'POST',
                }, 
                {'type':'submit', 'name':'NAME1', 'value':'VALOR1', 'label':'Enviar', 'link':'javascript:void(0)'},
                {'type':'button', 'name':'NAME2', 'value':'VALOR2', 'label':pacote_edit_btn_label_2, 'link':pacote_edit_btn_link_2}
            ]
        );
        /*************************************************/

}



//-- ----------------------------------


//-- ----------------------------------
//-- ----------------------------------





function novocliente(
        cliente_title = '<i class="far fas fa-user-plus nav-icon"></i> &nbsp; Novo Cliente',
        cliente_id = '',
        cliente_nome = '',
        cliente_email = '',
        cliente_telefone = '',
        cliente_pacoteid = '',
        cliente_btn_link_2 = 'javascript:void(0)',
        cliente_btn_label_2 = 'Fechar'
){
        MODAL(
            [
                {
                    'title': cliente_title, 
                    'body':''+

                      "           <input type=\"hidden\"  name=\"cliente_id\" value=\""+cliente_id+"\" id=\"\"> "+

                      "            <div class=\"form-group\">"+
                      "               <label>Nome<span style=\"color:#FF3333;\">*</span></label>"+
                      "                <input type=\"text\" name=\"cliente_nome\" value=\""+cliente_nome+"\" id=\"\" class=\"form-control\" placeholder=\"Nome\"  >"+
                      "                <input type=\"hidden\" name=\"cliente_novo\" value=\"<?=$_SESSION["PREFIX"];?>\" id=\"\" class=\"form-control\" placeholder=\"Nome\"  >"+
                      "            </div>"+

                      "            <div class=\"form-group\">"+
                      "               <label>E-mail</label>"+
                      "                <input type=\"text\" name=\"cliente_email\" value=\""+cliente_email+"\" id=\"\" class=\"form-control\" placeholder=\"E-mail\"  >"+
                      "            </div>"+

                      "            <div class=\"form-group\">"+
                      "               <label>Telefone</label>"+
                      "                <input type=\"text\" name=\"cliente_telefone\" value=\""+cliente_telefone+"\" id=\"\" class=\"form-control\" placeholder=\"(__) 9.____-____\"  >"+
                      "            </div>"+


                      "<div id=\"hospselect\">"+

                      "   <div style=\"border:solid 1px #666;padding:0px 15px;border-radius: 5px; margin-bottom:10px;\">"+
                      "            <div class=\"form-group\">"+
                      "               <label>Pacote / Plano / Produto</label>"+
                      "                <select name=\"cliente_pacoteid\" id=\"cliente_pacoteid\" class=\"form-control\" style=\"margin-bottom:5px; font-weight:bold;color:#007BFF;\" onchange=\"LoadPackData();\">"+
                      "                  <option value=\"0\" style=\"text-align:left;\" description_pack=\"\" price_pack=\"\">   ---   SELECIONE   ---   </option>"+
<?  $statment = $conn->prepare("SELECT *, CONCAT('R$ ', FORMAT(`valor_base`, 2, 'de_DE')) AS `preco` FROM `_pacotes` /*WHERE `id` > 0*/  ORDER BY `id` ASC"); $statment->execute(); $LIST_DESQ='';while($row_sql_cont = $statment->fetch(PDO::FETCH_ASSOC)){$LIST_DESQ = str_replace("\r\n","\\\\n", $row_sql_cont['descricao']);echo"                      \"                  <option value=\\\"{$row_sql_cont['id']}\\\" description_pack=\\\"{$LIST_DESQ}\\\" price_pack=\\\"{$row_sql_cont['preco']}\\\">".str_replace("'","´",$row_sql_cont['nome'])."</option>\"+\n";}?>
                      "                </select>"+
                      "            </div>"+

                      "            <!-- div class=\"form-group\" id=\"_description\" style=\"display:none;\">"+
                      "               <label>Descrição do Pacote</label>"+
                      "                <div id=\"description_pack\"></div>"+
                      "            </div -->"+

                      "            <div class=\"form-group\" id=\"_price\" style=\"display:none;\">"+
                      "               <label>Valor do Pacote</label>"+
                      "                <div id=\"price_pack\"></div>"+
                      "            </div>"+
                      "   </div>"+


                      "            <div class=\"form-group\">"+
                      "               <label>Notas e observações</label>"+
                      "                <textarea name=\"cliente_notas\" id=\"\" class=\"form-control\" placeholder=\"Observação...\"></textarea>"+
                      "            </div>"+
                      "            <div class=\"form-group\">"+
                      "               <label>Valor a Pagar</label>"+
                      "                <input type=\"text\" name=\"cliente_valor_contrato\" value=\"\" id=\"cliente_valor_contrato\" class=\"form-control\" placeholder=\"R$ ____.___,__\"  >"+
                      "            </div>"+

                      "            <div class=\"form-group\">"+
                      "             <label>Prox. Vencimento: </label>"+
                      "               <div class=\"input-group date\" id=\"\" data-target-input=\"nearest\">"+
                      "               <input type=\"text\" name=\"venc\" id=\"venc\" class=\"form-control\" placeholder=\"Telefone\" value=\"<?=date("d/m/Y", strtotime("+1 month"));?>\" />"+
                      "                   <div class=\"input-group-append\" onclick=\"$('#venc').click();\" style=\"cursor:pointer;\">"+
                      "                       <div class=\"input-group-text\"><i class=\"fa fa-calendar\"></i></div>"+
                      "                   </div>"+
                      "               </div>"+
                      "            </div>"+

                      "</div>",
                    'action':'<?=$url;?>../../lib/php/novocliente.php',
                    'method':'POST',
                }, 
                {'type':'submit', 'name':'NAME1', 'value':'VALOR1', 'label':'Enviar', 'link':'javascript:void(0)'},
                {'type':'button', 'name':'NAME2', 'value':'VALOR2', 'label':cliente_btn_label_2, 'link':cliente_btn_link_2}
            ]
        );
        /*************************************************/

                //*
                $('#venc').daterangepicker({ 
                    "singleDatePicker": true, 
                    "autoApply": true,
                    "drops": "up",
                    "locale": {
                      "format": "DD/MM/YYYY",
                      "separator": " - ",
                      "applyLabel": "Aplicar",
                      "cancelLabel": "Cancelar",
                      "fromLabel": "De",
                      "toLabel": "Até",
                      "customRangeLabel": "Período",
                      "daysOfWeek": [
                          "Dom",
                          "Seg",
                          "Ter",
                          "Qua",
                          "Qui",
                          "Sex",
                          "Sáb"
                      ],
                      "monthNames": [
                          "Janeiro",
                          "Fevereiro",
                          "Março",
                          "Abril",
                          "Maio",
                          "Junho",
                          "Julho",
                          "Agosto",
                          "Setembro",
                          "Outubro",
                          "Novembro",
                          "Dezembro"
                      ],
                      "firstDay": 0
                    }
                  });
                  /**/


        // Acrescentado para iniciar com o 1º pacote por padrão
        $('#cliente_pacoteid').children('option').eq(1).attr('selected','selected').change();
        $('#cliente_valor_contrato').val($('#price_pack').html());

}



function LoadPackData(){
    //$('#description_pack').html( $('#cliente_pacoteid option[value='+$('#cliente_pacoteid').val()+']').attr('description_pack').replace(/\\n/g, '<BR />') );
    $('#price_pack').html( $('#cliente_pacoteid option[value='+$('#cliente_pacoteid').val()+']').attr('price_pack').replace(/\\n/g, '<BR />') );

  if($('#cliente_pacoteid').val() > 0){
    // $('#_description').attr('style','display:block;');
    // $('#description_pack').attr('style',' cursor: not-allowed; color:#888;font-weight:bold;border:solid 1px #666;padding:0px 15px;border-radius: 5px;');

    $('#_price').attr('style','display:block;');
    $('#price_pack').attr('style',' cursor: not-allowed; color:#FF3333AB;font-size:25px;font-weight:bold;border:solid 1px #666;padding:0px 15px;border-radius: 5px;');
    $('#cliente_valor_contrato').val($('#price_pack').html());
  }else{
    $('#_description').attr('style','display:none;');
    $('#_price').attr('style','display:none;');
    $('#cliente_valor_contrato').val('');
  }
}



//-- ----------------------------------
//-- ----------------------------------

function clienteedit(
        cliente_edit_title = 'Editar Cliente',
        cliente_edit_id = '',
        cliente_edit_nome = '',
        cliente_edit_email = '',
        cliente_edit_telefone = '',
        cliente_edit_pacoteid = '',
        cliente_edit_notas = '',
        cliente_edit_valor_contrato = '',
        cliente_edit_data = '<?=date("d/m/Y", strtotime("+1 month"));?>',
        cliente_edit_btn_link_1 = 'javascript:void(0)',
        cliente_edit_btn_label_1 = 'Enviar',
        cliente_edit_btn_link_2 = 'javascript:void(0)',
        cliente_edit_btn_label_2 = 'Fechar'
){
        MODAL(
            [
                {
                    'title': '<i class="far fas fa-user-edit nav-icon"></i> &nbsp; '+cliente_edit_title,
                    'body':''+

                      "           <input type=\"hidden\"  name=\"cliente_edit_id\" value=\""+cliente_edit_id+"\" id=\"\"> "+

                      "            <div class=\"form-group\">"+
                      "               <label>Nome<span style=\"color:#FF3333;\">*</span></label>"+
                      "                <input type=\"text\" name=\"cliente_edit_nome\" value=\""+cliente_edit_nome+"\" id=\"\" class=\"form-control\" placeholder=\"Nome\"  >"+
                      "                <input type=\"hidden\" name=\"cliente_edit_novo\" value=\"<?=$_SESSION["PREFIX"];?>\" id=\"\" class=\"form-control\" placeholder=\"Nome\"  >"+
                      "            </div>"+

                      "            <div class=\"form-group\">"+
                      "               <label>E-mail</label>"+
                      "                <input type=\"text\" name=\"cliente_edit_email\" value=\""+cliente_edit_email+"\" id=\"\" class=\"form-control\" placeholder=\"E-mail\"  >"+
                      "            </div>"+

                      "            <div class=\"form-group\">"+
                      "               <label>Telefone</label>"+
                      "                <input type=\"text\" name=\"cliente_edit_telefone\" value=\""+cliente_edit_telefone+"\" id=\"\" class=\"form-control\" placeholder=\"(__) 9.____-____\"  >"+
                      "            </div>"+


                      "<div class=\"card card-secondary\">"+
                      "  <div class=\"card-header\" style=\"padding: 12px 0px 0px 8px; height:40px;\">"+
                      "    <h1 class=\"card-title\">Situação do Contrato: &nbsp; </h1>"+

                      "  <div style=\"float:right;margin-right:5px;\"><label class=\"switch\">"+
                      "   <input type=\"checkbox\" name=\"cliente_edit_encerrar_contrato\">"+
                      "   <span class=\"round\"></span>"+
                      "  </label></div>"+
                      "  <div id=\"sdescricao_switch\"></div>"+

                      " </div>"+                  


                      "<div id=\"hospselect\">"+




                      "   <div style=\"border:solid 1px #666;padding:0px 15px;border-radius: 5px; margin-bottom:10px;\">"+
                      "            <div class=\"form-group\">"+
                      "               <label>Pacote / Plano / Produto</label>"+
                      "                <select name=\"cliente_edit_pacoteid\" id=\"cliente_edit_pacoteid\" class=\"form-control\" style=\"margin-bottom:5px; font-weight:bold;color:#007BFF;\" onchange=\"Cliente_ReLoadPackData();\">"+
                      "                  <option value=\"0\" style=\"text-align:left;\" description_pack=\"\" price_pack=\"\">   ---   SELECIONE   ---   </option>"+
<?  $statment = $conn->prepare("SELECT *, CONCAT('R$ ', FORMAT(`valor_base`, 2, 'de_DE')) AS `preco` FROM `_pacotes` /*WHERE `id` > 0*/  ORDER BY `id` ASC"); $statment->execute(); $LIST_DESQ='';while($row_sql_cont = $statment->fetch(PDO::FETCH_ASSOC)){$LIST_DESQ = str_replace("\r\n","\\\\n", $row_sql_cont['descricao']);echo"                      \"                  <option value=\\\"{$row_sql_cont['id']}\\\" description_pack=\\\"{$LIST_DESQ}\\\" price_pack=\\\"{$row_sql_cont['preco']}\\\">".str_replace("'","´",$row_sql_cont['nome'])."</option>\"+\n";}?>
                      "                </select>"+
                      "            </div>"+

                      "            <!-- div class=\"form-group\" id=\"_description\" style=\"display:none;\">"+
                      "               <label>Descrição do Pacote</label>"+
                      "                <div id=\"description_pack\"></div>"+
                      "            </div -->"+

                      "            <div class=\"form-group\" id=\"_price\" style=\"display:none;\">"+
                      "               <label>Valor do Pacote</label>"+
                      "                <div id=\"price_pack\"></div>"+
                      "            </div>"+
                      "   </div>"+




                      "            <div class=\"form-group\">"+
                      "               <label>Notas e observações</label>"+
                      "                <textarea name=\"cliente_edit_notas\" id=\"\" class=\"form-control\" placeholder=\"Observação...\">"+cliente_edit_notas+"</textarea>"+
                      "            </div>"+
                      "            <div class=\"form-group\">"+
                      "               <label>Valor a Pagar</label>"+
                      "                <input type=\"text\" name=\"cliente_edit_valor_contrato\" value=\""+cliente_edit_valor_contrato+"\" id=\"cliente_valor_contrato\" class=\"form-control\" placeholder=\"R$ ____.___,__\"  >"+
                      "            </div>"+


                      "            <div class=\"form-group\">"+
                      "             <label>Prox. Vencimento: </label>"+
                      "               <div class=\"input-group date\" id=\"\" data-target-input=\"nearest\">"+
                      "               <input type=\"text\" name=\"venc\" id=\"venc\" class=\"form-control\" placeholder=\"Telefone\" value=\""+cliente_edit_data+"\" />"+
                      "                   <div class=\"input-group-append\" onclick=\"$('#venc').click();\" style=\"cursor:pointer;\">"+
                      "                       <div class=\"input-group-text\"><i class=\"fa fa-calendar\"></i></div>"+
                      "                   </div>"+
                      "               </div>"+
                      "            </div>"+

                      "</div>",
                    'action':'<?=$url;?>../../lib/php/editarcliente.php',
                    'method':'POST',
                }, 
                {'type':'submit', 'name':'NAME1', 'value':'VALOR1', 'label':cliente_edit_btn_label_1, 'link':cliente_edit_btn_link_1},
                {'type':'button', 'name':'NAME2', 'value':'VALOR2', 'label':cliente_edit_btn_label_2, 'link':cliente_edit_btn_link_2}
            ]
        );
        /*************************************************/


        //-- ---------------------------------------------------------------------
        $('.switch input[name="cliente_edit_encerrar_contrato"]').parent().
            attr('style','width:115px; top:-8px;').
            html($('.switch input[name="cliente_edit_encerrar_contrato"]').parent().html()+'\
                  <STYLE>\
                                .switch input[name="cliente_edit_encerrar_contrato"]:checked + span:before {\
                                  -webkit-transform: translateX(80px) !important;\
                                  -ms-transform: translateX(80px) !important;\
                                  transform: translateX(80px) !important;\
                                }\
                    </STYLE>\
            ');


                $('.switch input[name="cliente_edit_encerrar_contrato"]').
                siblings(' .round').
                attr('style','color: #FFF !important; padding: 5px 45px !important;').
                html('Ativo');


        $('input[name="cliente_edit_encerrar_contrato"]').click(function(){

            if($('input[name="cliente_edit_encerrar_contrato"]').is(":checked")){
                //ON
                $('.switch input[name="cliente_edit_encerrar_contrato"]').
                    siblings(' .round').
                    attr('style','color: #FFF !important; padding: 5px 12px !important;').
            html('Encerrar');
            }else{
                //OFF
                $('.switch input[name="cliente_edit_encerrar_contrato"]').
                siblings(' .round').
                attr('style','color: #FFF !important; padding: 5px 45px !important;').
                html('Ativo');
                
            }


        });
        //-- ---------------------------------------------------------------------


        $('#cliente_edit_pacoteid option[value='+Math.ceil(cliente_edit_pacoteid)+']').attr('selected','selected').change();
        $('#cliente_valor_contrato').val(cliente_edit_valor_contrato);

                //*
                $('#venc').daterangepicker({ 
                    "singleDatePicker": true, 
                    "autoApply": true,
                    "drops": "up",
                    "locale": {
                      "format": "DD/MM/YYYY",
                      "separator": " - ",
                      "applyLabel": "Aplicar",
                      "cancelLabel": "Cancelar",
                      "fromLabel": "De",
                      "toLabel": "Até",
                      "customRangeLabel": "Período",
                      "daysOfWeek": [
                          "Dom",
                          "Seg",
                          "Ter",
                          "Qua",
                          "Qui",
                          "Sex",
                          "Sáb"
                      ],
                      "monthNames": [
                          "Janeiro",
                          "Fevereiro",
                          "Março",
                          "Abril",
                          "Maio",
                          "Junho",
                          "Julho",
                          "Agosto",
                          "Setembro",
                          "Outubro",
                          "Novembro",
                          "Dezembro"
                      ],
                      "firstDay": 0
                    }
                  });
                  /**/

                          // Acrescentado para iniciar com o 1º pacote por padrão (se nulo)
                          if((cliente_edit_pacoteid=='')){
                           $('#cliente_edit_pacoteid').children('option').eq(1).attr('selected','selected').change();
                           $('#cliente_edit_valor_contrato').val($('#price_pack').html());
                          }

                          // corrige borda em daterangepicker
                          $('.drp-calendar').css({"padding-right":"5px"});

}

//-- ----------------------------------
function Cliente_ReLoadPackData(){
    // $('#description_pack').html( $('#cliente_edit_pacoteid option[value='+$('#cliente_edit_pacoteid').val()+']').attr('description_pack').replace(/\\n/g, '<BR />') );
    $('#price_pack').html( $('#cliente_edit_pacoteid option[value='+$('#cliente_edit_pacoteid').val()+']').attr('price_pack').replace(/\\n/g, '<BR />') );

  if($('#cliente_edit_pacoteid').val() > 0){
    $('#_description').attr('style','display:block;');
    // $('#description_pack').attr('style',' cursor: not-allowed; color:#888;font-weight:bold;border:solid 1px #666;padding:0px 15px;border-radius: 5px;');

    $('#_price').attr('style','display:block;');
    $('#price_pack').attr('style',' cursor: not-allowed; color:#FF3333AB;font-size:25px;font-weight:bold;border:solid 1px #666;padding:0px 15px;border-radius: 5px;');
    $('#cliente_valor_contrato').val($('#price_pack').html());
  }else{
    $('#_description').attr('style','display:none;');
    $('#_price').attr('style','display:none;');
    $('#cliente_valor_contrato').val('');
  }
}

//-- ----------------------------------
//-- ----------------------------------

function pagamentoedit(
        pagamento_edit_title = 'Editar Pagamento',
        pagamento_edit_id = '',
        pagamento_edit_nome = '',
        pagamento_edit_email = '',
        pagamento_edit_telefone = '',
        pagamento_edit_pacoteid = '',
        pagamento_edit_notas = '',
        pagamento_edit_valor_contrato = '',
        pagamento_edit_venc = '<?=date("d/m/Y H:i:s");?>',
        pagamento_edit_data = '<?=date("d/m/Y H:i:s", strtotime("+1 month"));?>',
        pagamento_edit_btn_link_1 = 'javascript:void(0)',
        pagamento_edit_btn_label_1 = 'Enviar',
        pagamento_edit_btn_link_2 = 'javascript:void(0)',
        pagamento_edit_btn_label_2 = 'Fechar'
){
        MODAL(
            [
                {
                    'title': '<i class="far fas fa-solid fa-sack-dollar"></i> &nbsp; '+pagamento_edit_title,
                    'body':''+

                      "           <input type=\"hidden\"  name=\"pagamento_edit_id\" value=\""+pagamento_edit_id+"\" id=\"\"> "+

                      "            <div class=\"form-group\">"+
                      "               <label style=\"color:#FFFFFF6B;\">Nome<span style=\"color:#FF33337D;\">*</span></label>"+
                      "                <input type=\"text\" name=\"pagamento_edit_nome\" disabled=\"true\" style=\"cursor:not-allowed; font-weight:bold; color:#FFFFFF6B;\" \
                                              value=\""+pagamento_edit_nome+"\" id=\"\" class=\"form-control\" placeholder=\"Nome\"  >"+
                      "                <input type=\"hidden\" name=\"pagamento_edit_novo\" value=\"<?=$_SESSION["PREFIX"];?>\" id=\"\" >"+
                      "            </div>"+

                      "            <div class=\"form-group\">"+
                      "               <label style=\"color:#FFFFFF6B;\">E-mail</label>"+
                      "                <input type=\"text\" name=\"pagamento_edit_email\" disabled=\"true\" style=\"cursor:not-allowed; font-weight:bold; color:#FFFFFF6B;\" \
                                              value=\""+pagamento_edit_email+"\" id=\"\" class=\"form-control\" placeholder=\"CLIENTE SEM E-MAIL\"  >"+
                      "            </div>"+

                      "            <div class=\"form-group\">"+
                      "               <label style=\"color:#FFFFFF6B;\">Telefone</label>"+
                      "                <input type=\"text\" name=\"pagamento_edit_telefone\" disabled=\"true\" style=\"cursor:not-allowed; font-weight:bold; color:#FFFFFF6B;\" \
                                              value=\""+pagamento_edit_telefone+"\" id=\"\" class=\"form-control\" placeholder=\"CLIENTE SEM TELEFONE\"  >"+
                      "            </div>"+


                      "<!-- div class=\"card card-secondary\">"+
                      "  <div class=\"card-header\" style=\"padding: 12px 0px 0px 8px; height:40px;\">"+
                      "    <h1 class=\"card-title\">Situação do Contrato: &nbsp; </h1>"+

                      "  <div style=\"float:right;margin-right:5px;\"><label class=\"switch\">"+
                      "   <input type=\"checkbox\" name=\"pagamento_edit_encerrar_contrato\">"+
                      "   <span class=\"round\"></span>"+
                      "  </label></div>"+
                      "  <div id=\"sdescricao_switch\"></div>"+

                      " </div -->"+                  


                      "<div id=\"hospselect\">"+




                      "   <div style=\"border:solid 1px #666;padding:0px 15px;border-radius: 5px; margin-bottom:10px;\">"+
                      "            <div class=\"form-group\">"+
                      "               <label>Pacote / Plano / Produto</label>"+
                      "                <select name=\"pagamento_edit_pacoteid\" id=\"pagamento_edit_pacoteid\" class=\"form-control\" style=\"margin-bottom:5px; font-weight:bold;color:#007BFF;\" onchange=\"Pagamento_ReLoadPackData();\">"+
                      "                  <option value=\"0\" style=\"text-align:left;\" description_pack=\"\" price_pack=\"\">   ---   SELECIONE   ---   </option>"+
<?  $statment = $conn->prepare("SELECT *, CONCAT('R$ ', FORMAT(`valor_base`, 2, 'de_DE')) AS `preco` FROM `_pacotes` /*WHERE `id` > 0*/  ORDER BY `id` ASC"); $statment->execute(); $LIST_DESQ='';while($row_sql_cont = $statment->fetch(PDO::FETCH_ASSOC)){$LIST_DESQ = str_replace("\r\n","\\\\n", $row_sql_cont['descricao']);echo"                      \"                  <option value=\\\"{$row_sql_cont['id']}\\\" description_pack=\\\"{$LIST_DESQ}\\\" price_pack=\\\"{$row_sql_cont['preco']}\\\">".str_replace("'","´",$row_sql_cont['nome'])."</option>\"+\n";}?>
                      "                </select>"+
                      "            </div>"+

                      "            <!-- div class=\"form-group\" id=\"_description\" style=\"display:none;\">"+
                      "               <label>Descrição do Pacote</label>"+
                      "                <div id=\"description_pack\"></div>"+
                      "            </div -->"+

                      "            <div class=\"form-group\" id=\"_price\" style=\"display:none;\">"+
                      "               <label>Valor do Pacote</label>"+
                      "                <div id=\"price_pack\"></div>"+
                      "            </div>"+
                      "   </div>"+




                      "            <div class=\"form-group\">"+
                      "               <label>Notas e observações</label>"+
                      "                <textarea name=\"pagamento_edit_notas\" id=\"\" class=\"form-control\" placeholder=\"Observação...\">"+pagamento_edit_notas+"</textarea>"+
                      "            </div>"+
                      "            <div class=\"form-group\">"+
                      "               <label>Valor Recebido</label>"+
                      "                <input type=\"text\" name=\"pagamento_edit_valor_contrato\" value=\""+pagamento_edit_valor_contrato+"\" id=\"pagamento_valor_contrato\" class=\"form-control\" placeholder=\"R$ ____.___,__\"  >"+
                      "            </div>"+

                      "            <div class=\"form-group\">"+
                      "             <label>Vencimento </label>"+
                      "               <div class=\"input-group date\" id=\"\" data-target-input=\"nearest\">"+
                      "               <input type=\"text\" name=\"venc\" id=\"venc\" class=\"form-control\" placeholder=\"Telefone\" value=\""+pagamento_edit_venc+"\" />"+
                      "                   <div class=\"input-group-append\" onclick=\"$('#venc').click();\" style=\"cursor:pointer;\">"+
                      "                       <div class=\"input-group-text\"><i class=\"fa fa-calendar\"></i></div>"+
                      "                   </div>"+
                      "               </div>"+
                      "            </div>"+


                      "            <div class=\"form-group\">"+
                      "             <label>Recebido em</label>"+
                      "               <div class=\"input-group date\" id=\"\" data-target-input=\"nearest\">"+
                      "               <input type=\"text\" name=\"receb\" id=\"receb\" class=\"form-control bg-success\" style=\"font-weight:bold;font-size:25px;\" placeholder=\"\" value=\""+pagamento_edit_data+"\" />"+
                      "                   <div class=\"input-group-append\" onclick=\"$('#receb').click();\" style=\"cursor:pointer;\">"+
                      "                       <div class=\"input-group-text bg-success\"><i class=\"fa fa-calendar\"></i></div>"+
                      "                   </div>"+
                      "               </div>"+
                      "            </div>"+

                      "</div>",
                    'action':'<?=$url;?>../../lib/php/editarrecebimento.php',
                    'method':'POST',
                }, 
                {'type':'submit', 'name':'NAME1', 'value':'VALOR1', 'label':pagamento_edit_btn_label_1, 'link':pagamento_edit_btn_link_1},
                {'type':'button', 'name':'NAME2', 'value':'VALOR2', 'label':pagamento_edit_btn_label_2, 'link':pagamento_edit_btn_link_2}
            ]
        );
        /*************************************************/


        //-- ---------------------------------------------------------------------
        $('.switch input[name="pagamento_edit_encerrar_contrato"]').parent().
            attr('style','width:115px; top:-8px;').
            html($('.switch input[name="pagamento_edit_encerrar_contrato"]').parent().html()+'\
                  <STYLE>\
                                .switch input[name="pagamento_edit_encerrar_contrato"]:checked + span:before {\
                                  -webkit-transform: translateX(80px) !important;\
                                  -ms-transform: translateX(80px) !important;\
                                  transform: translateX(80px) !important;\
                                }\
                    </STYLE>\
            ');


                $('.switch input[name="pagamento_edit_encerrar_contrato"]').
                siblings(' .round').
                attr('style','color: #FFF !important; padding: 5px 45px !important;').
                html('Ativo');


        $('input[name="pagamento_edit_encerrar_contrato"]').click(function(){

            if($('input[name="pagamento_edit_encerrar_contrato"]').is(":checked")){
                //ON
                $('.switch input[name="pagamento_edit_encerrar_contrato"]').
                    siblings(' .round').
                    attr('style','color: #FFF !important; padding: 5px 12px !important;').
            html('Encerrar');
            }else{
                //OFF
                $('.switch input[name="pagamento_edit_encerrar_contrato"]').
                siblings(' .round').
                attr('style','color: #FFF !important; padding: 5px 45px !important;').
                html('Ativo');
                
            }


        });
        //-- ---------------------------------------------------------------------


        $('#pagamento_edit_pacoteid option[value='+Math.ceil(pagamento_edit_pacoteid)+']').attr('selected','selected').change();
        $('#pagamento_valor_contrato').val(pagamento_edit_valor_contrato);

                //*
                  $('#venc').daterangepicker({ 
                    "singleDatePicker": true, 
                    "autoApply": true,
                    "drops": "up",
                    "locale": {
                      "format": "DD/MM/YYYY",
                      "separator": " - ",
                      "applyLabel": "Aplicar",
                      "cancelLabel": "Cancelar",
                      "fromLabel": "De",
                      "toLabel": "Até",
                      "customRangeLabel": "Período",
                      "daysOfWeek": [
                          "Dom",
                          "Seg",
                          "Ter",
                          "Qua",
                          "Qui",
                          "Sex",
                          "Sáb"
                      ],
                      "monthNames": [
                          "Janeiro",
                          "Fevereiro",
                          "Março",
                          "Abril",
                          "Maio",
                          "Junho",
                          "Julho",
                          "Agosto",
                          "Setembro",
                          "Outubro",
                          "Novembro",
                          "Dezembro"
                      ],
                      "firstDay": 0
                    }
                  });


                $('#receb').daterangepicker({ 
                    "singleDatePicker": true,     
                    "timePicker": true,
                    "timePicker24Hour": true,
                    "timePickerSeconds": true,
                    "drops": "up",
                    "autoApply": true,
                    "locale": {
                      "format": "DD/MM/YYYY HH:mm:ss",
                      "separator": " - ",
                      "applyLabel": "Aplicar",
                      "cancelLabel": "Cancelar",
                      "fromLabel": "De",
                      "toLabel": "Até",
                      "customRangeLabel": "Período",
                      "daysOfWeek": [
                          "Dom",
                          "Seg",
                          "Ter",
                          "Qua",
                          "Qui",
                          "Sex",
                          "Sáb"
                      ],
                      "monthNames": [
                          "Janeiro",
                          "Fevereiro",
                          "Março",
                          "Abril",
                          "Maio",
                          "Junho",
                          "Julho",
                          "Agosto",
                          "Setembro",
                          "Outubro",
                          "Novembro",
                          "Dezembro"
                      ],
                      "firstDay": 0
                    }
                  });

                  // corrige borda e eventos em daterangepicker
                  correcao_daterangepicker_COM_TIME();
                  /**/

                          // Acrescentado para iniciar com o 1º pacote por padrão (se nulo)
                          if((pagamento_edit_pacoteid=='')){
                           $('#pagamento_edit_pacoteid').children('option').eq(1).attr('selected','selected').change();
                           $('#pagamento_edit_valor_contrato').val($('#price_pack').html());
                          }

}
//-- ----------------------------------
  //-- ------------------------------------------------------------------
  //-- ---------------------------[ ATENCAO! ]---------------------------
  //-- --- Recomandado somente em DateRangePicker com autoApply e time
  //-- ------------------------------------------------------------------
  function correcao_daterangepicker_COM_TIME(){
    $(".drp-buttons").on('DOMSubtreeModified', ".drp-selected", function() {
        // console.log('disparo 1');
        $('.daterangepicker .applyBtn').click();
        

        $('.daterangepicker .calendar-time select').change(function(){
            // console.log('disparo 2');
            $('.daterangepicker .applyBtn').click();
        });

        $('.daterangepicker .drp-buttons').css({
            "position": "absolute", 
             "z-index": "-10", 
             "height": "0px", 
             "width": "0", 
             "overflow": "hidden"
        });
        $('.drp-calendar').css({"padding-right":"5px"});
    });
  }
  //-- ------------------------------------------------------------------
//-- ----------------------------------
function Pagamento_ReLoadPackData(){
    // $('#description_pack').html( $('#pagamento_edit_pacoteid option[value='+$('#pagamento_edit_pacoteid').val()+']').attr('description_pack').replace(/\\n/g, '<BR />') );
    $('#price_pack').html( $('#pagamento_edit_pacoteid option[value='+$('#pagamento_edit_pacoteid').val()+']').attr('price_pack').replace(/\\n/g, '<BR />') );

  if($('#pagamento_edit_pacoteid').val() > 0){
    $('#_description').attr('style','display:block;');
    // $('#description_pack').attr('style',' cursor: not-allowed; color:#888;font-weight:bold;border:solid 1px #666;padding:0px 15px;border-radius: 5px;');

    $('#_price').attr('style','display:block;');
    $('#price_pack').attr('style',' cursor: not-allowed; color:#FF3333AB;font-size:25px;font-weight:bold;border:solid 1px #666;padding:0px 15px;border-radius: 5px;');
    $('#pagamento_valor_contrato').val($('#price_pack').html());
  }else{
    $('#_description').attr('style','display:none;');
    $('#_price').attr('style','display:none;');
    $('#pagamento_valor_contrato').val('');
  }
}


//-- ----------------------------------
//-- --------------------------------------------------------------------------
//-- --------------------------------------------------------------------------
  <?ENDIF; //END: index.php?>
  <?IF(
    (@$_GET['pgn'] == 'clientes.php')
  ): //Paginas de clientes ?>
//-- --------------------------------------------------------------------------
//-- ----------------------------------

/* // Carrega clientes em modal
function paginacaclientes(
        moderacao_title = '<i class="bi bi-person-lines-fill"></i> Editar/Gerenciar clientes',
        pagina = '',
        moderacao_btn_link_2 = '$(\'#tickets\').DataTable().ajax.reload( null, false )',
        moderacao_btn_label_2 = 'Fechar e Atualizar'
){
        MODAL(
            [
                {
                    'title': moderacao_title, 
                    'body':''+

                      "           <input type=\"hidden\"  name=\"pagina\" value=\""+pagina+"\" id=\"\"> "+

                      "  <DIV id=\"AjaxSearchDisplay\">"+

                      "  </DIV>",
                    'action':'../php/search_list_clientes.php',
                    'method':'POST',
                },
                {'type':'button', 'name':'NAME2', 'value':'VALOR2', 'label':moderacao_btn_label_2, 'onclick':moderacao_btn_link_2}
            ]
        );
        // *************************************************
        try{$('#MDLl32E2A41B form').submit();}catch(e){false;}
}
/**/

//-- ----------------------------------
            // Carrega clientes na pagina
            function loadpaginaclientes($PAGINA='', $SEARCH='', $DATA='<?=date("d/m/Y");?> - <?=date("d/m/Y",strtotime("+2 days"));?>', $PACOTE='', $METHOD='POST', $ACTION='../php/search_list_clientes.php'){
              /////////////////////////////////////////////////////////////
              //$('#MDLl32E2A41C form').submit(function(event){
                //$('#MDLl32E2A41C #busc_venc').val($SEARCH);
                $('#MDLl32E2A41C form input[name="pagina"]').val($PAGINA);
                $('#MDLl32E2A41C form input[name="search"]').val($SEARCH);
                $('#MDLl32E2A41C .card-title').html('<span style="color:#AAA;">Por favor, aguarde...</span>');
                if($('#MDLl32E2A41C button[title="Selecionar todos"] i').attr('class') == "far fa-check-square"){
                    //$('#MDLl32E2A41C button[title="Selecionar todos"]').click();
                    $('#MDLl32E2A41C button[title="Selecionar todos"] i').attr('class','far fa-square');
                };
                $("#MDLl32E2A41C #box_content").html("<center style=\"font-weight:bold;color:#BBB;padding:120px;\">CARREGANDO... &nbsp; <i class=\"fas fa-sync-alt fa-spin\" style=\"/*animation: loading 1.2s linear infinite;*/\"></i></center>");
                  $.ajax({
                    type: $METHOD,
                    //url: $(this).attr('action'),
                    url: $ACTION,
                    data: new FormData($('#MDLl32E2A41C form')[0]),
                    mimeType: "multipart/form-data",
                    contentType: false,
                    processData:false,
                    dataType: "json",
                    encode: true,
                  }).done(function(data){
                    /* ::DEBUG::
                    console.log(data);
                    /**/
                    $("#MDLl32E2A41C #box_content").html(data.message);
                  }).fail(function(jqXHR, textStatus, msg){
                       console.error(
                          'ERRO NO FORM DO MODAL: \n'+msg+
                          ' \nFORM ACTION: '+this.url+
                          ' \nFORM DATA: '+this.data
                       );
                       $("#MDLl32E2A41C #box_content").html(
                          "<br>"+
                          "<center style=\"color:#DDD;padding:215px 0px 80px 0px;\">"+
                            "<STRONG>DESCULPE... ALGO DEU ERRADO: </STRONG><br>"+
                            "Verifique a sua conexão ou contate o suporte."+
                          "</center>"
                       );
                        setTimeout(function(){
                          reload_loadpaginaclientes();
                        },6000);
                       
                  });
                  //* ::DEBUG:: */ event.preventDefault();
              //});
              /////////////////////////////////////////////////////////////
              //$('#MDLl32E2A41C form').submit();
            };
            loadpaginaclientes();
            
//-- ----------------------------------
            function reload_loadpaginaclientes(){
              $('.fa-sync-alt').attr('style','animation: loading 1.2s linear infinite;'); 
                setTimeout(
                  function(){
                      loadpaginaclientes($('input[name=\'pagina\']').val(), $('input[name=\'search\']').val());
                  },
                800);
            }

            checkall_l = 0;
            function checkall_loadpaginaclientes(){
                   if(checkall_l == 1 /*$('.icheck-primary input[type="checkbox"]').prop('checked')*/){
                       $('.icheck-primary input[type="checkbox"]').attr('checked', false);
                       $('.icheck-primary input[type="checkbox"]').removeAttr('checked');
                       $('.mailbox-controls .checkbox-toggle .fa-check-square').attr('class','far fa-square');
                       //console.log('Todos desmarcados');
                       checkall_l = 0;
                   }else{
                       $('.icheck-primary input[type="checkbox"]').attr('checked', true);
                       $('.mailbox-controls .checkbox-toggle .fa-square').attr('class','far fa-check-square');
                       //console.log('Todos selecionados');
                       checkall_l = 1;
                   }
            }

            function verificacheck(MARCADOS=''){$i=0;
                $('.icheck-primary input[type="checkbox"]').each(function (index, obj){
                    if (this.checked === true){
                        if($i>0){
                          MARCADOS +=', '+this.id;
                        }else{
                          MARCADOS +=this.id;
                        }$i++;
                    }
                }); return MARCADOS;//.replace(/check/g, "");
            };

           // verificacheck();
           // console.log(MARCADOS);

            function valuescheck(VALUES=''){$i=0;
                $('.icheck-primary input[type="checkbox"]').each(function (index, obj){
                    if (this.checked === true){
                        if($i>0){
                          VALUES +=', '+this.value;
                        }else{
                          VALUES +=this.value;
                        }$i++;
                    }
                }); return VALUES;//.replace(/check/g, "");
            };


           go=0;
//-- ----------------------------------
//-- ----------------------------------

// Excluir clientes
function deleteclientes(
        delcliente_title = '<i class="fas fa-exclamation-triangle"></i> &nbsp; ATENÇÃO!',
        delcliente_id = '',
        delcliente_nome = '',
        delcliente_email = '',
        delcliente_telefone = '',
        delcliente_pacoteid = '',
        delcliente_btn_link_2 = 'javascript:void(0)',
        delcliente_btn_label_2 = 'Fechar'
){

        MODAL(
            [
                {
                    'title': delcliente_title, 
                    'body':''+

                      "           <input type=\"hidden\"  name=\"delcliente_id\" value=\""+delcliente_id+"\" id=\"\"> "+

                      "            <div class=\"form-group\">"+
                      "               <label><i class=\"far fas fa-user-times\"></i> &nbsp; Você deseja realmente, excluir o's cliente's a baixo? </label><br>"+
                      //"               Você deseja realmente, excluir o's cliente's a baixo?<br>"+
                      "               <i id=\"nomes\" style=\"font-size:25px;font-weight:bold; color:#DC3545!important;\">NOMES</i><br>"+
                      "               <br>Tenha cuidado. Esta ação não poderá ser desfeita.<br>"+
                      "            </div>"+

                      "</div>",
                    'action':'<?=$url;?>../../lib/php/delcliente.php',
                    'method':'POST',
                }, 
                {'type':'submit', 'name':'NAME1', 'value':'VALOR1', 'label':'Sim, tenho certeza!', 'link':'javascript:void(0)'},
                {'type':'button', 'name':'NAME2', 'value':'VALOR2', 'label':delcliente_btn_label_2, 'link':delcliente_btn_link_2}
            ]
        );
        /*************************************************/


        DELCHECK = verificacheck();
        $('#MDLl32E2A41B input[name=delcliente_id]').val(DELCHECK);

        VALCHECK = valuescheck().replace(/,/g, "<br>");
        $('#MDLl32E2A41B #nomes').html(VALCHECK);

}
//-- ----------------------------------

// Renovar faturas dos clientes 
function renovarfaturas(
        // renovarfaturas_title = '<i class="fas fa-exclamation-triangle"></i>  &nbsp; ATENÇÃO!',
        renovarfaturas_id = '',
        renovarfaturas_nome = '',
        renovarfaturas_email = '',
        renovarfaturas_telefone = '',
        renovarfaturas_pacoteid = '',
        renovarfaturas_btn_link_2 = 'javascript:void(0)',
        renovarfaturas_btn_label_2 = 'Fechar'
){

        MODAL(
            [
                {
                    'title': '<i class="far fas fa-solid fa-outdent" style="transform:rotate(180deg);-ms-transform:rotate(180deg);"></i> <sup style="font-size:10px;margin-left:1px;top:-2px;"> <i class="far fas fa-user-cog"></i></sup> &nbsp; Renovar Contratos', 
                    'body':''+

                      "           <input type=\"hidden\"  name=\"renovarfaturas_id\" value=\""+renovarfaturas_id+"\" id=\"\"> "+

                      "            <div class=\"form-group\">"+
                      "               <label><i class=\"far fa-regular fa-circle-check\"></i> &nbsp; Você deseja realmente, renovar o's contrato's dos clientes a baixo? </label><br>"+
                      //"               Você deseja realmente, renovar o's cliente's a baixo?<br>"+
                      "               <i id=\"nomes\" style=\"font-size:25px;font-weight:bold; color:#35DC59 !important;\">NOMES</i><br>"+
                      "               <br>Tenha cuidado. Pois, esta ação não poderá ser desfeita.<br>"+
                      "            </div>"+

                      "</div>",
                    'action':'<?=$url;?>../../lib/php/renovarfaturas.php',
                    //'action':'<?=$url;?>../../lib/php/callback.php',
                    'method':'POST',
                }, 
                {'type':'submit', 'name':'NAME1', 'value':'VALOR1', 'label':'Sim, tenho certeza!', 'link':'javascript:void(0)'},
                {'type':'button', 'name':'NAME2', 'value':'VALOR2', 'label':renovarfaturas_btn_label_2, 'link':renovarfaturas_btn_link_2}
            ]
        );
        /*************************************************/


        RENOVCHECK = verificacheck();
        $('#MDLl32E2A41B input[name=renovarfaturas_id]').val(RENOVCHECK);

        VALCHECK = valuescheck().replace(/,/g, "<br>");
        $('#MDLl32E2A41B #nomes').html(VALCHECK);

}

//-- ----------------------------------

// Renovar fatura dos clientes (com um toque)
function renovarfatura(
        renovarfatura_id = '',
        renovarfatura_nome = '',
        //renovarfatura_btn_link_2 = 'javascript:void(0)',
        //renovarfatura_btn_label_2 = 'Fechar'
){

        MODAL(
            [
                {
                    'title': '<i class="far fas fa-solid fa-outdent" style="transform:rotate(180deg);-ms-transform:rotate(180deg);"></i> <sup style="font-size:10px;margin-left:1px;top:-2px;"> <!-- i class=\"far fas fa-solid fa-horse-head\"></i --> <i class="far fas fa-user-cog"></i></sup> &nbsp; Renovando Contrato', 
                    'body':''+

                      "           <input type=\"hidden\"  name=\"renovarfaturas_id\" value=\""+renovarfatura_id+"\" id=\"renovarfaturas_id\"> "+

                      "               <i class=\"far fas fa-solid fa-share-square\" style=\"font-size:40px;\"></i>  <sup style=\"font-size:20px;margin-left:-1px;top:-15px;\"><i class=\"far fas fa-calendar-check\"></i></sup> &nbsp; Renovando o contrato atual, para os próximos 30 dias."+
                      "            <div class=\"form-group\">"+
                      "               <label></label>"+
                      "               <center style=\"font-size:25px;color:#DDD!important;\">CLIENTE: <span id=\"nome\" style=\"font-weight:bold;\">"+renovarfatura_nome+"</span></center><br>"+
                      "               <input type=\"hidden\"  name=\"renovarfatura_nome\" value=\""+renovarfatura_nome+"\" id=\"renovarfatura_nome\"> "+
                      "               <center style=\"font-weight:bold; font-size:18px;\"><i class=\"fas fa-exclamation-triangle\"></i> &nbsp; - &nbsp; Por favor, aguarde... &nbsp; <i class=\"fas fa-sync-alt fa-spin\"></i></center>"+
                      "            </div>"+

                      "</div>",
                    'action':'<?=$url;?>../../lib/php/renovarfaturas.php',
                    'method':'POST',
                }, 
                //{'type':'submit', 'name':'NAME1', 'value':'VALOR1', 'label':'Sim, tenho certeza!', 'link':'javascript:void(0)'},
                //{'type':'button', 'name':'NAME2', 'value':'VALOR2', 'label':renovarfatura_btn_label_2, 'link':renovarfatura_btn_link_2}
            ]
        );
        /*************************************************/
        setTimeout(function(){$('#MDLl32E2A41B form').submit();}, 50);

}

//-- ----------------------------------
//-- ----------------------------------

// Encerrar faturas dos clientes 
function encerrarfaturas(
        // encerrarfaturas_title = '<i class="fas fa-exclamation-triangle"></i>  &nbsp; ATENÇÃO!',
        encerrarfaturas_id = '',
        encerrarfaturas_nome = '',
        encerrarfaturas_email = '',
        encerrarfaturas_telefone = '',
        encerrarfaturas_pacoteid = '',
        encerrarfaturas_btn_link_2 = 'javascript:void(0)',
        encerrarfaturas_btn_label_2 = 'Fechar'
){

        MODAL(
            [
                {
                    'title': '<i class="fas fa-solid fa-circle-dollar-to-slot"></i><!-- i class="fas fa-exclamation-triangle"></i -->  &nbsp; ENCERRAR CONTRATOS', 
                    'body':''+

                      "           <input type=\"hidden\"  name=\"encerrarfaturas_id\" value=\""+encerrarfaturas_id+"\" id=\"\"> "+

                      "            <div class=\"form-group\">"+
                      "               <label><i class=\"fa-regular fa-circle-down\"></i> &nbsp; Você deseja realmente, encerrar o's contrato's do's cliente's a baixo? </label><br>"+
                      //"               Você deseja realmente, encerrar o's cliente's a baixo?<br>"+
                      "               <i id=\"nomes\" style=\"font-size:25px;font-weight:bold; color:#FF9600 !important;\">NOMES</i><br>"+
                      "               <br><p style=\"font-size:13px; line-height:15px; font-style:italic;\"><sub style=\"color:#FF0000;font-size:30px;\">*</sub>Embora os clientes possam adquirir novos contratos no futuro. Os contratos atuais não poderão ser renovados. Pois, serão permanentemente encerrados<!-- , quitados na data presente --> e arquivados para fins de auditoria e análises futuras. Não havendo possibilidade de renovação. <br>Esta ação não poderá ser desfeita. </p>"+
                      "            </div>"+

                      "</div>",
                    'action':'<?=$url;?>../../lib/php/encerrarfaturas.php',
                    'method':'POST',
                }, 
                {'type':'submit', 'name':'NAME1', 'value':'VALOR1', 'label':'Sim, tenho certeza!', 'link':'javascript:void(0)'},
                {'type':'button', 'name':'NAME2', 'value':'VALOR2', 'label':encerrarfaturas_btn_label_2, 'link':encerrarfaturas_btn_link_2}
            ]
        );
        /*************************************************/


        ENCERRARCHECK = verificacheck();
        $('#MDLl32E2A41B input[name=encerrarfaturas_id]').val(ENCERRARCHECK);

        VALCHECK = valuescheck().replace(/,/g, "<br>");
        $('#MDLl32E2A41B #nomes').html(VALCHECK);

}

//-- ----------------------------------


//-- ----------------------------------
//-- --------------------------------------------------------------------------
//-- ----------------------------------
<?ENDIF; //END: clientes.php?>

<?IF((@$_GET['pgn'] == 'pacotes.php')): //Paginas de pacotes ?>
//-- --------------------------------------------------------------------------
//-- ----------------------------------

//-- ----------------------------------
            // Carrega pacotes na pagina
            function loadpaginapacotes($PAGINA='', $SEARCH='', $METHOD='POST', $ACTION='../php/search_list_pacotes.php'){
              /////////////////////////////////////////////////////////////
              //$('#MDLl32E2A41C form').submit(function(event){
                $('#MDLl32E2A41C form input[name="pagina"]').val($PAGINA);
                $('#MDLl32E2A41C form input[name="search"]').val($SEARCH);
                $('#MDLl32E2A41C .card-title').html('<span style="color:#AAA;">Por favor, aguarde...</span>');
                if($('#MDLl32E2A41C button[title="Selecionar todos"] i').attr('class') == "far fa-check-square"){
                    //$('#MDLl32E2A41C button[title="Selecionar todos"]').click();
                    $('#MDLl32E2A41C button[title="Selecionar todos"] i').attr('class','far fa-square');
                };
                $("#MDLl32E2A41C #box_content").html("<center style=\"font-weight:bold;color:#BBB;padding:120px;\">CARREGANDO... &nbsp; <i class=\"fas fa-sync-alt fa-spin\" style=\"/*animation: loading 1.2s linear infinite;*/\"></i></center>");
                  $.ajax({
                    type: $METHOD,
                    //url: $(this).attr('action'),
                    url: $ACTION,
                    data: new FormData($('#MDLl32E2A41C form')[0]),
                    mimeType: "multipart/form-data",
                    contentType: false,
                    processData:false,
                    dataType: "json",
                    encode: true,
                  }).done(function(data){
                    /* ::DEBUG::
                    console.log(data);
                    /**/
                    $("#MDLl32E2A41C #box_content").html(data.message);
                  }).fail(function(jqXHR, textStatus, msg){
                       console.error(
                          'ERRO NO FORM DO MODAL: \n'+msg+
                          ' \nFORM ACTION: '+this.url+
                          ' \nFORM DATA: '+this.data
                       );
                       $("#MDLl32E2A41C #box_content").html(
                          "<br>"+
                          "<center style=\"color:#DDD;padding:215px 0px 80px 0px;\">"+
                            "<STRONG>DESCULPE... ALGO DEU ERRADO: </STRONG><br>"+
                            "Verifique a sua conexão ou contate o suporte."+
                          "</center>"
                       );
                        setTimeout(function(){
                          reload_loadpaginapacotes();
                        },6000);
                       
                  });
                  //* ::DEBUG:: */ event.preventDefault();
              //});
              /////////////////////////////////////////////////////////////
              //$('#MDLl32E2A41C form').submit();
            };
            loadpaginapacotes();
            

            function reload_loadpaginapacotes(){
              $('.fa-sync-alt').attr('style','animation: loading 1.2s linear infinite;'); 
                setTimeout(
                  function(){
                      loadpaginapacotes($('input[name=\'pagina\']').val(), $('input[name=\'search\']').val());
                  },
                800);
            }

            checkall_l = 0;
            function checkall_loadpaginapacotes(){
                   if(checkall_l == 1 /*$('.icheck-primary input[type="checkbox"]').prop('checked')*/){
                       $('.icheck-primary input[type="checkbox"]').attr('checked', false);
                       $('.icheck-primary input[type="checkbox"]').removeAttr('checked');
                       $('.mailbox-controls .checkbox-toggle .fa-check-square').attr('class','far fa-square');
                       //console.log('Todos desmarcados');
                       checkall_l = 0;
                   }else{
                       $('.icheck-primary input[type="checkbox"]').attr('checked', true);
                       $('.mailbox-controls .checkbox-toggle .fa-square').attr('class','far fa-check-square');
                       //console.log('Todos selecionados');
                       checkall_l = 1;
                   }
            }

            function verificacheck(MARCADOS=''){$i=0;
                $('.icheck-primary input[type="checkbox"]').each(function (index, obj){
                    if (this.checked === true){
                        if($i>0){
                          MARCADOS +=', '+this.id;
                        }else{
                          MARCADOS +=this.id;
                        }$i++;
                    }
                }); return MARCADOS;//.replace(/check/g, "");
            };

           // verificacheck();
           // console.log(MARCADOS);

            function valuescheck(VALUES=''){$i=0;
                $('.icheck-primary input[type="checkbox"]').each(function (index, obj){
                    if (this.checked === true){
                        if($i>0){
                          VALUES +=', '+this.value;
                        }else{
                          VALUES +=this.value;
                        }$i++;
                    }
                }); return VALUES;//.replace(/check/g, "");
            };


           go=0;
//-- ----------------------------------
//-- ----------------------------------

// Excluir pacotes
function deletepacotes(
        delpacote_title = '<i class="fas fa-exclamation-triangle"></i> &nbsp; ATENÇÃO!',
        delpacote_id = '',
        delpacote_nome = '',
        delpacote_email = '',
        delpacote_telefone = '',
        delpacote_pacoteid = '',
        delpacote_btn_link_2 = 'javascript:void(0)',
        delpacote_btn_label_2 = 'Fechar'
){

        MODAL(
            [
                {
                    'title': delpacote_title, 
                    'body':''+

                      "           <input type=\"hidden\"  name=\"delpacote_id\" value=\""+delpacote_id+"\" id=\"\"> "+

                      "            <div class=\"form-group\">"+
                      "               <label><i class=\"far fas fa-user-times\"></i> &nbsp; Você deseja realmente, excluir o's pacote's a baixo? <!--<i class=\"fas fa-exclamation-triangle\"></i> &nbsp; ATENÇÃO! - <i class=\"far fas fa-user-times\"></i> &nbsp; Excluir Cliente --></label><br>"+
                      //"               Você deseja realmente, excluir o's pacote's a baixo?<br>"+
                      "               <i id=\"nomes\" style=\"font-size:25px;font-weight:bold; color:#DC3545!important;\">NOMES</i><br>"+
                      "               <br>Tenha cuidado. Esta ação não poderá ser desfeita.<br>"+
                      "            </div>"+

                      "</div>",
                    'action':'<?=$url;?>../../lib/php/delpacote.php',
                    'method':'POST',
                }, 
                {'type':'submit', 'name':'NAME1', 'value':'VALOR1', 'label':'Sim, tenho certeza!', 'link':'javascript:void(0)'},
                {'type':'button', 'name':'NAME2', 'value':'VALOR2', 'label':delpacote_btn_label_2, 'link':delpacote_btn_link_2}
            ]
        );
        /*************************************************/


        DELCHECK = verificacheck();
        $('#MDLl32E2A41B input[name=delpacote_id]').val(DELCHECK);

        VALCHECK = valuescheck().replace(/,/g, "<br>");
        $('#MDLl32E2A41B #nomes').html(VALCHECK);

}

//-- ----------------------------------
//-- ----------------------------------
//-- --------------------------------------------------------------------------
//-- ----------------------------------
<?ENDIF; //END: clientes.php?>

<?IF((@$_GET['pgn'] == 'relatorios.php')): //Paginas de relatorios ?>
//-- --------------------------------------------------------------------------
//-- ----------------------------------

//-- ----------------------------------

            // Carrega pagamentos na folha
            function loadfolharelatoriospagamentos($PAGINA='', $SEARCH='', $DATA='<?=date("d/m/Y");?> - <?=date("d/m/Y",strtotime("+2 days"));?>', $PACOTE='', $METHOD='POST', $ACTION='../php/search_list_pagamentos.php'){
              /////////////////////////////////////////////////////////////
              //$('#MDLl32E2A41C form').submit(function(event){
                //$('#MDLl32E2A41C #busc_venc').val($SEARCH);
                $('#MDLl32E2A41C form input[name="pagamentos_folha"]').val($PAGINA);
                $('#MDLl32E2A41C form input[name="search"]').val($SEARCH);
                $('#MDLl32E2A41C .card-title').html('<span style="color:#AAA;">Por favor, aguarde...</span>');
                if($('#MDLl32E2A41C button[title="Selecionar todos"] i').attr('class') == "far fa-check-square"){
                    //$('#MDLl32E2A41C button[title="Selecionar todos"]').click();
                    $('#MDLl32E2A41C button[title="Selecionar todos"] i').attr('class','far fa-square');
                };
                $("#MDLl32E2A41C #box_content").html("<center style=\"font-weight:bold;color:#BBB;padding:120px;\">CARREGANDO... &nbsp; <i class=\"fas fa-sync-alt fa-spin\" style=\"/*animation: loading 1.2s linear infinite;*/\"></i></center>");
                  $.ajax({
                    type: $METHOD,
                    //url: $(this).attr('action'),
                    url: $ACTION,
                    data: new FormData($('#MDLl32E2A41C form')[0]),
                    mimeType: "multipart/form-data",
                    contentType: false,
                    processData:false,
                    dataType: "json",
                    encode: true,
                  }).done(function(data){
                    /* ::DEBUG::
                    console.log(data);
                    /**/
                    $("#MDLl32E2A41C #box_content").html(data.message);
                  }).fail(function(jqXHR, textStatus, msg){
                       console.error(
                          'ERRO NO FORM DO MODAL: \n'+msg+
                          ' \nFORM ACTION: '+this.url+
                          ' \nFORM DATA: '+this.data
                       );
                       $("#MDLl32E2A41C #box_content").html(
                          "<br>"+
                          "<center style=\"color:#DDD;padding:215px 0px 80px 0px;\">"+
                            "<STRONG>DESCULPE... ALGO DEU ERRADO: </STRONG><br>"+
                            "Verifique a sua conexão ou contate o suporte."+
                          "</center>"
                       );
                        setTimeout(function(){
                          loadfolharelatoriospagamentos();
                        },6000);
                       
                  });
                  //* ::DEBUG:: */ event.preventDefault();
              //});
              /////////////////////////////////////////////////////////////
              //$('#MDLl32E2A41C form').submit();
            };
             loadfolharelatoriospagamentos();
            
//-- ----------------------------------
//-- ----------------------------------

// Encerrar contrato (a partir do caixa) 
function encerrarcontrato(
        // encerrarcontrato_title = '<i class="fas fa-exclamation-triangle"></i>  &nbsp; ATENÇÃO!',
        encerrarcontrato_id = '',
        encerrarcontrato_nome = '',
        encerrarcontrato_email = '',
        encerrarcontrato_telefone = '',
        encerrarcontrato_pacoteid = '',
        encerrarcontrato_btn_link_2 = 'javascript:void(0)',
        encerrarcontrato_btn_label_2 = 'Fechar'
){

        MODAL(
            [
                {
                    'title': '<i class="fas fa-solid fa-circle-dollar-to-slot"></i><!-- i class="fas fa-exclamation-triangle"></i -->  &nbsp; ENCERRAR CONTRATO', 
                    'body':''+

                      "           <input type=\"hidden\"  name=\"encerrarfaturas_id\" value=\""+encerrarcontrato_id+"\" id=\"\"> "+

                      "            <div class=\"form-group\">"+
                      "               <label><i class=\"fa-regular fa-circle-down\"></i> &nbsp; Você deseja realmente, encerrar o contrato do cliente a baixo? </label><br>"+
                      //"               Você deseja realmente, encerrar o cliente a baixo?<br>"+
                      "               <i id=\"nomes\" style=\"font-size:25px;font-weight:bold; color:#FF9600 !important;\">SEM NOME</i><br>"+
                      "               <br><p style=\"font-size:13px; line-height:15px; font-style:italic;\"><sub style=\"color:#FF0000;font-size:30px;\">*</sub>O contrato atual será encerrado<!-- , quitado na data presente --> e arquivado para fins de auditoria e análises futuras. Não havendo possibilidade de renovação. </p>"+
                      "            </div>"+

                      "</div>",
                    'action':'<?=$url;?>../../lib/php/encerrarfaturas.php',
                    'method':'POST',
                }, 
                {'type':'submit', 'name':'NAME1', 'value':'VALOR1', 'label':'Sim, tenho certeza!', 'link':'javascript:void(0)'},
                {'type':'button', 'name':'NAME2', 'value':'VALOR2', 'label':encerrarcontrato_btn_label_2, 'link':encerrarcontrato_btn_link_2}
            ]
        );
        /*************************************************/



        $('#MDLl32E2A41B input[name=encerrarcontrato_id]').val(encerrarcontrato_id);

        VALCHECK = encerrarcontrato_nome.replace(/,/g, "<br>");
        $('#MDLl32E2A41B #nomes').html(VALCHECK);

}

//-- ----------------------------------
//-- ----------------------------------

// Excluir recebimento
function delrecebimento(
        // delrecebimento_title = '<i class="fas fa-exclamation-triangle"></i>  &nbsp; ATENÇÃO!',
        delrecebimento_id = '',
        delrecebimento_nome = '',
        delrecebimento_email = '',
        delrecebimento_telefone = '',
        delrecebimento_pacoteid = '',
        delrecebimento_btn_link_2 = 'javascript:void(0)',
        delrecebimento_btn_label_2 = 'Fechar'
){

        MODAL(
            [
                {
                    'title': '<i class="fas fa-solid fa-circle-dollar-to-slot"></i><!-- i class="fas fa-exclamation-triangle"></i -->  &nbsp; EXCLUIR RECEBIMENTO (ESTORNO)', 
                    'body':''+

                      "           <input type=\"hidden\"  name=\"delrecebimento_id\" value=\""+delrecebimento_id+"\" id=\"\"> "+

                      "            <div class=\"form-group\">"+
                      "               <label><i class=\"far fa-solid fa-money-bill-trend-up\" style=\"transform:rotate(180deg);-ms-transform:rotate(180deg);\"></i> &nbsp; Você deseja realmente, excluir o recebimneto a baixo? </label><br>"+
                      //"               Você deseja realmente, excluir o recebimneto a baixo?<br>"+
                      "               <i id=\"nomes\" style=\"font-size:25px;font-weight:bold; color:#44FF00 !important;\">SEM NOME</i><br>"+
                      "               <br><p style=\"font-size:13px; line-height:15px; font-style:italic;\"><sub style=\"color:#FF0000;font-size:30px;\">*</sub>O recebimneto atual será permanentemente excluido. <br>Esta ação não poderá ser desfeita. </p>"+
                      "            </div>"+

                      "</div>",
                    'action':'<?=$url;?>../../lib/php/delrecebimento.php',
                    'method':'POST',
                }, 
                {'type':'submit', 'name':'NAME1', 'value':'VALOR1', 'label':'Sim, tenho certeza!', 'link':'javascript:void(0)'},
                {'type':'button', 'name':'NAME2', 'value':'VALOR2', 'label':delrecebimento_btn_label_2, 'link':delrecebimento_btn_link_2}
            ]
        );
        /*************************************************/



        $('#MDLl32E2A41B input[name=delrecebimento_id]').val(delrecebimento_id);

        VALCHECK = delrecebimento_nome.replace(/,/g, "<br>");
        $('#MDLl32E2A41B #nomes').html(VALCHECK);

}


//-- ----------------------------------

//-- ----------------------------------
//-- --------------------------------------------------------------------------
//-- ----------------------------------
<?ENDIF; //END: relatorios.php?>


  <? // TODAS AS PÀGINAS (get:pgn) ?>
//-- --------------------------------------------------------------------------
//-- --------------------------------------------------------------------------
//-- ----------------------------------

  var $NOIMAGESEND = '<?=$NOIMAGESEND;?>';

  MODAL = function($MODAL=[{'title': 'Isto é uma janela modal', 'body':'Seu conteúdo ou campos de formulario, aparecerão aqui...', 'action':'#MDL_ACTION','method':'POST'}, {'type':'button', 'name':'', 'value':'', 'label':'Fechar', 'link':''}, {'type':'submit', 'name':'', 'value':'', 'label':'Submeter', 'link':''}]){
    try{
      $MDL_INPUT = '';
      $I = $MODAL.length-1;
      $i=0;for(let input in $MODAL){
        if($i==0){
          // -- ---------------------------------
          try{
            if($MODAL[0].title != undefined){
              $TITULO = $MODAL[0].title;
            }
          }catch(e){ 
              $TITULO = '';
          }
          try{
            if($MODAL[0].body != undefined){
              $CORPO = $MODAL[0].body;
            }
          }catch(e){ 
              $CORPO = '';
          }
          try{
            if($MODAL[0].action != undefined){
              $ACTION = $MODAL[0].action;
            }
          }catch(e){ 
              $ACTION = '';
          }
          try{
            if($MODAL[0].method != undefined){
              $METHOD = $MODAL[0].method;
            }
          }catch(e){ 
              $METHOD = '';
          }
          // -- ---------------------------------
        }else if($i<=$I){          
          if(($MODAL[input].type == 'button') || ($MODAL[input].type == 'submit')){
              if($MODAL[input].type != undefined){
                 $MDL_INPUT += "<button type=\""+$MODAL[input].type+"\" ";
              }            
              if($MODAL[input].name != undefined){
                $MDL_INPUT += "name=\""+$MODAL[input].name+"\" ";
              }            
              if($MODAL[input].onkeyup != undefined){
                $MDL_INPUT += "onkeyup=\""+$MODAL[input].onkeyup+"\" ";
              }            
              if($MODAL[input].id != undefined){
                $MDL_INPUT += "id=\""+$MODAL[input].id+"\" ";
              }            
              if($MODAL[input].type == 'submit'){
                $MDL_INPUT += "class=\"btn btn-primary /*btn-success*/\" ";
              }else if($MODAL[input].class != undefined){
                $MDL_INPUT += "class=\""+$MODAL[input].class+"\" ";
              }else{
                $MDL_INPUT += "class=\"btn btn-secondary\" ";
              }
              if($MODAL[input].value != undefined){
                $MDL_INPUT += "value=\""+$MODAL[input].value+"\" ";
              }
              if($MODAL[input].link != undefined){
                $MDL_INPUT_link = "window.open('"+$MODAL[input].link+"','_self'); ";
              }else{
                $MDL_INPUT_link = "";
              }              
              if($MODAL[input].onclick != undefined){
                $MDL_INPUT += "onClick=\""+$MDL_INPUT_link+$MODAL[input].onclick+"\" ";
              }else{
                $MDL_INPUT += "onClick=\""+$MDL_INPUT_link+"\" ";
              }
              if(
                ($MODAL[input].label == 'Fechar') ||
                ($MODAL[input].label == 'fechar') ||
                ($MODAL[input].label == 'FECHAR') ||
                ($MODAL[input].label == 'Fechar e Atualizar') ||
                ($MODAL[input].label == 'fechar e atualizar') ||
                ($MODAL[input].label == 'FECHAR E ATUALIZAR') ||
                ($MODAL[input].label == 'Cancelar') ||
                ($MODAL[input].label == 'cancelar') ||
                ($MODAL[input].label == 'CANCELAR') ||
                ($MODAL[input].label == 'Entendi') ||
                ($MODAL[input].label == 'entendi') ||
                ($MODAL[input].label == 'ENTENDI')
              ){
                $MDL_INPUT +=  "data-bs-dismiss=\"modal\" data-dismiss=\"modal\">"+$MODAL[input].label+"</button>";
              }else if(
                ($MODAL[input].label == 'Não') ||
                ($MODAL[input].label == 'não') ||
                ($MODAL[input].label == 'NÃO') ||
                ($MODAL[input].label == 'Nao') ||
                ($MODAL[input].label == 'nao') ||
                ($MODAL[input].label == 'NAO')
              ){
                $MDL_INPUT +=  "data-bs-dismiss=\"modal\" style=\"background-color:#DC3545; border:solid 1px #dc3545;\">"+$MODAL[input].label+"</button>";
              }else if(
                ($MODAL[input].label == 'Excluir') ||
                ($MODAL[input].label == 'excluir') ||
                ($MODAL[input].label == 'EXCLUIR') ||
                ($MODAL[input].label == 'Apagar') ||
                ($MODAL[input].label == 'apagar') ||
                ($MODAL[input].label == 'APAGAR') ||
                ($MODAL[input].label == 'Deletar') ||
                ($MODAL[input].label == 'deletar') ||
                ($MODAL[input].label == 'DELETAR')
              ){
                $MDL_INPUT +=  "style=\"background-color:#DC3545; border:solid 1px #DC3545;\"><i class=\"bi bi-trash-fill delbtm\"></i>"+$MODAL[input].label+"</button>";
              }else if($MODAL[input].label != undefined){
                $MDL_INPUT += ">"+$MODAL[input].label+"</button>";
              }          
          }
        }      
      $i++;
      }
      /////////////////////////////////////////////
      PRINT_IT = "" +
      "<div class=\"modal fade\" id=\"MDLl32E2A41B\" tabindex=\"-1\" aria-labelledby=\"exampleModalLabel\" aria-hidden=\"true\">"+
      "  <div class=\"modal-dialog\">"+
      "    <div class=\"modal-content\">"+
      "      <div class=\"modal-header\">"+
      "        <h5 class=\"modal-title\" id=\"exampleModalLabel\">"+$TITULO+"</h5>"+
      "        <button type=\"button\" class=\"btn-close close\" data-dismiss=\"modal\" aria-label=\"Close\"><span aria-hidden=\"true\">×</span></button>"+
      "      </div>"+
      "     <form action=\""+$ACTION+"\" method=\""+$METHOD+"\"  enctype=\"multipart/form-data\"> "+
      "        <div class=\"modal-body\">"+
                  $CORPO +
      "            <div class=\"form-group\">"+
      "               <center style=\"color:#0000AA;font-weight:600;font-style:italic;margin-top:10px;\">"+
      "                   <div id=\"resultado\"></div>"+
      "                </center>"+
      "            </div>"+

      "            <div class=\"modal-footer\">"+
                      $MDL_INPUT + 
      "            </div>"+

      "        </div>"+
      "      </form>"+

      "  </div>"+
      "</div>"+
      "</div>";
      /////////////////////////////////////////////
    }catch(e){ 
     // console.clear();
    }
    try{
    //-- ################ Gerando elementos dinamicamente ################    
    $('body #MDLl32E2A41B,body .modal-backdrop.fade.show').remove();
    $('body').append(PRINT_IT);
            $('#MDLl32E2A41B').modal('show').attr('onclick','setTimeout(function(){if($(\'body\').attr(\'class\')==\'vsc-initialized\'){$(\'body\').attr(\'style\',\''+BodyStyle+'\')/*.css(\'overflow\',\'auto\').css(\'padding-right\',\'0px\').removeAttr(\'style\');*/}},2000)'); 
            document.body.style.paddingRight='0px';
            $tr = $(this).closest('tr');
              var data = $tr.children("td").map(function(){
                return $(this).text();              
              }).get();
        /////////////////////////////////////////////////////////////
        $('#MDLl32E2A41B form').submit(function(event){
            $("#MDLl32E2A41B #resultado").html("<span style=\"color:#DDD;\">Por favor, aguarde...</span>");
            $.ajax({
              type: $METHOD,
              url: $(this).attr('action'),
              data: new FormData($('#MDLl32E2A41B form')[0]),
              mimeType: "multipart/form-data",
              contentType: false,
              processData:false,
              dataType: "json",
              encode: true,
            }).done(function(data){
              /* ::DEBUG::
              console.log(data);
              /**/
              $("#MDLl32E2A41B #resultado").html(data.message);
            }).fail(function(jqXHR, textStatus, msg){
                 console.error(
                    'ERRO NO FORM DO MODAL: \n'+msg+
                    ' \nFORM ACTION: '+this.url+
                    ' \nFORM DATA: '+this.data
                 );
                 $("#MDLl32E2A41B #resultado").html(
                    "<span style=\"color:#FF3333;\">"+
                      "<strong style=\"font-weight:900;font-size:16px;font-family:Arial Black,Arial Bold,Gadget,sans-serif;\">ISTO ESTA LEVANDO MAIS TEMPO QUE O NORMAL: </strong><br>"+
                      "Por favor, verifique a sua conexão ou contate o suporte."+
                    "</span>"
                 );
                 setTimeout(function(){
                    $('#MDLl32E2A41B form').submit();
                 },8000);
            });
            /* ::DEBUG:: */ event.preventDefault();
        });
        /////////////////////////////////////////////////////////////
    //-- #################################################################
    }catch(e){ 
     // console.clear();
    }
    return null;
}; $('*[data-mdl]').click(function(){eval($(this).attr('data-mdl')+'()')}); if($('body').attr('style')==undefined){BodyStyle="";}else{BodyStyle=$('body').attr('style','');}

/*
MODAL(
    [
        {
            'title': 'Título do modal', 
            'body':'Insira seu conteúdo ou campos de formulario, aqui...', 
            'action':'#MDL_ACTION',
            'method':'POST',
        }, 
        {'type':'submit', 'name':'NAME1', 'value':'VALOR1', 'label':'Submeter', 'link':'javascript:void(0)'}, 
        {'type':'button', 'name':'NAME1', 'value':'VALOR1', 'label':'Entendi', 'link':'javascript:void(0)'}, 
        {'type':'button', 'name':'NAME1', 'value':'VALOR1', 'label':'Ao Clicar', 'link':'javascript:void(0)', 'onclick':'alert(\'ok\')'}, 
        {'type':'button', 'name':'NAME2', 'value':'VALOR2', 'label':'Fechar', 'link':'#fechar'}
    ]
);
/**/

function is_file(url){
    var http = new XMLHttpRequest();
    http.open('HEAD', url, false);
    http.send();
    return http.status != 404;
}


//-- ----------------------------------

function login(
        cliente_title = '<i class="bi bi-person-circle"></i> Entrar',
        cliente_login = '',
        cliente_senha = '',
        cliente_token = '<?=$_SESSION["TOKEN2"];?>',
        cliente_btn_link_2 = 'void(0)',
        cliente_btn_label_2 = 'Fechar'
){
        MODAL(
            [
                {
                    'title': cliente_title, 
                    'body':''+
                    
                      "           <input type=\"hidden\"  name=\"cliente_token\" value=\""+cliente_token+"\" id=\"\"> "+

                      "            <div class=\"form-group\">"+
                      "               <label>Login:<span style=\"color:#FF0000;\">*</span></label>"+
                      "                <input type=\"text\" name=\"cliente_login\" value=\""+cliente_login+"\" id=\"\" class=\"form-control\" placeholder=\"Usuário\"  >"+
                      "            </div>"+

                      "            <div class=\"form-group\">"+
                      "               <label>Senha:<span style=\"color:#FF0000;\">*</span></label>"+
                      "                <input type=\"password\" name=\"cliente_senha\" value=\""+cliente_senha+"\" id=\"pwd\" class=\"form-control\" placeholder=\"Senha\"  >"+
                      "            </div>",
                    'action':'lib/php/login.php',
                    'method':'POST',
                }, 
                {'type':'submit', 'name':'NAME1', 'value':'VALOR1', 'label':'Logar', 'link':'javascript:void(0)'},
                {'type':'button', 'name':'NAME2', 'value':'VALOR2', 'label':cliente_btn_label_2, 'onclick':cliente_btn_link_2}
            ]
        );
        /*************************************************/
}


//-- ----------------------------------
// Login (na home)
//-- ----------------------------------
$('#FRMLl32E241E form').submit(function(event){
     // alert('function.js ok');     
            $("#FRMLl32E241E #resultado").html("<span style=\"color:#FFF;\">Por favor, aguarde...</span>").css('background-color','#034669FA').css('color','#FFF');
            $.ajax({
              type: 'POST',
              url: $(this).attr('action'),
              data: new FormData($('#FRMLl32E241E form')[0]),
              mimeType: "multipart/form-data",
              contentType: false,
              processData:false,
              dataType: "json",
              encode: true,
            }).done(function(data){
              /* ::DEBUG::
              console.log(data);
              /**/
              $("#FRMLl32E241E #resultado").html(data.message).css('background-color','#034669FA').css('color','#FFF');
              if(data.success == false){
                $("#FRMLl32E241E #resultado").css('background-color','#DDDD66');
              }
            }).fail(function(jqXHR, textStatus, msg){
                 console.error(
                    'ERRO NO FORM DO MODAL: \n'+msg+
                    ' \nFORM ACTION: '+this.url+
                    ' \nFORM DATA: '+this.data
                 );
                 $("#FRMLl32E241E #resultado").html(
                    "<span style=\"color:#FF3333;\">"+
                      "DESCULPE... ALGO DEU ERRADO: <br>"+
                      "Verifique a sua conexão ou contate o suporte."+
                    "</span>"
                 ).css('background-color','#DDDD66');
            });
            /* ::DEBUG:: */ event.preventDefault();
 });
//-- ----------------------------------
//-- ----------------------------------

//-- ----------------------------------
// ALERTA

function alert(
        text = '',
        link = 'javascript:void(0)'
){
        MODAL(
            [
                {
                    'title': '<i class="fas fa-exclamation-triangle"></i> &nbsp; ALERTA!', 
                    'body':''+

                      "           "+text+

                      "            <div class=\"form-group\">"+
                      "            </div>",
                    'action':'<?=$url;?>../../lib/php/login.php',
                    'method':'POST',
                }, 
                {'type':'button', 'name':'NAME1', 'value':'VALOR1', 'label':'Entendi', 'link':link},
            ]
        );
        /*************************************************/
        //*
            mp3 = './lib/song/alert.mp3';
            $.ajax({
                url:mp3,
                type:'HEAD',
                success: function(){
                   //arquivo encontrado
                      audio = new Audio(mp3); audio.play();
                      audio.addEventListener('canplaythrough', function() {
                        audio.play();
                      });
                },
                error: function(error){
                    //arquivo não encontrado
                    console.clear();
                    mp3 = '../.'+mp3;
                    audio = new Audio(mp3); audio.play();
                    audio.addEventListener('canplaythrough', function() {
                        audio.play();
                    });
                }
            });
        /**/
}
//-- ----------------------------------

//-- ----------------------------------
// INFO

function info(
        text = '',
        link = 'javascript:void(0)'
){
        MODAL(
            [
                {
                    'title': '<i class="icon fas fa-info  bg-white" style="padding:8px 15px; border-radius: 20px;"></i> &nbsp; INFORMAÇÃO!', 
                    'body':''+

                      "           "+text+

                      "            <div class=\"form-group\">"+
                      "            </div>",
                    'action':'<?=$url;?>../../lib/php/login.php',
                    'method':'POST',
                }, 
                {'type':'button', 'name':'NAME1', 'value':'VALOR1', 'label':'Entendi', 'link':link},
            ]
        );
        /*************************************************/
        //*
            mp3 = './lib/song/info.mp3';
            $.ajax({
                url:mp3,
                type:'HEAD',
                success: function(){
                   //arquivo encontrado
                      audio = new Audio(mp3); audio.play();
                      audio.addEventListener('canplaythrough', function() {
                        audio.play();
                      });
                },
                error: function(error){
                    //arquivo não encontrado
                    console.clear();
                    mp3 = '../.'+mp3;
                    audio = new Audio(mp3); audio.play();
                    audio.addEventListener('canplaythrough', function() {
                        audio.play();
                    });
                }
            });
        /**/
}
//-- ----------------------------------

//-- ----------------------------------
// ALARM

function alarm(
        text = '',
        link = 'javascript:void(0)'
){
        MODAL(
            [
                {
                    'title': '<i class="fa fa-bell  bg-white" style="padding:8px 10px; border-radius: 20px;"></i> &nbsp; ALARME!', 
                    'body':''+

                      "           "+text+

                      "            <div class=\"form-group\">"+
                      "            </div>",
                    'action':'<?=$url;?>../../lib/php/login.php',
                    'method':'POST',
                }, 
                {'type':'button', 'name':'NAME1', 'value':'VALOR1', 'label':'Entendi', 'link':link},
            ]
        );
        /*************************************************/
        //*
            mp3 = './lib/song/alarm.mp3';
            $.ajax({
                url:mp3,
                type:'HEAD',
                success: function(){
                   //arquivo encontrado
                      audio = new Audio(mp3); audio.play();
                      audio.addEventListener('canplaythrough', function() {
                        audio.play();
                      });
                },
                error: function(error){
                    //arquivo não encontrado
                    console.clear();
                    mp3 = '../.'+mp3;
                    audio = new Audio(mp3); audio.play();
                    audio.addEventListener('canplaythrough', function() {
                        audio.play();
                    });
                }
            });
            setTimeout(function(){
            mp3 = './lib/song/alarm_2x.mp3';
            $.ajax({
                url:mp3,
                type:'HEAD',
                success: function(){
                   //arquivo encontrado
                      audio = new Audio(mp3); audio.play();
                      audio.addEventListener('canplaythrough', function() {
                        audio.play();
                      });
                },
                error: function(error){
                    //arquivo não encontrado
                    console.clear();
                    mp3 = '../.'+mp3;
                    audio = new Audio(mp3); audio.play();
                    audio.addEventListener('canplaythrough', function() {
                        audio.play();
                    });
                }
            });

                Push.create("ALARME DE CONTROLE  84!", {
                  body: text + ' \nAbra o aplicativo para... \n',
                  icon: "./lib/imgs/favicon.png",
                  timeout: 36000,
                  onClick: function(){
                    window.focus();
                    //window.open("https://controle84.com/_sistema/","_self");
                    info("<b>Notificação:</b> "+text);
                    //window.location="https://controle84.com/_sistema/";
                    this.close();
                  }
                });
          }, 500);
        /**/
}
// alert('Isto é um teste de alerta.',"javascript:info(\\'Isto é um teste de informação.\\',\\'JavaScript:alarm(`Isto é um teste de alarme.`)\\')");


 TESTE_MDL_BOX = function(){
     alarm('Isto é um teste de alarme.',"javascript:alert(\\'Isto é um teste de alerta.\\',\\'JavaScript:info(`Isto é um teste de informação.`,`JavaScript:TESTE_MDL_BOX();`)\\')");
 } //TESTE_MDL_BOX();


//-- ----------------------------------
$(document).ready(function(){

// ***      
<?IF(@$_SESSION["PRIVID"]>=1): //SE LOGADO ?>
  $('#carousel_c922').attr('style','display:block;');
  $('#carousel_c923').html('<DIV style="width:100%; height:100%;"></DIV>').attr('style','background:#FFF;');
<? ENDIF;?>


});
//-- ----------------------------------

//-- --------------------------------------------------------------------------
//-- --------------------------------------------------------------------------

refresh = function(){
  document.location.reload(1);
}





//console.log('<?=@$_GET['pgn'];?>');
//-- --------------------------------------------------------------------------
// ESPAÇO RESERVADO PARA ANOTAÇÕES NO CONSOLE
//-- --------------------------------------------------------------------------
  /*console.info('\n\
    NOTAS: \n\
    -- -----------------------------------------------------------------\n\
    XXXXXX \n\
    -- -----------------------------------------------------------------\n\
  ');/**/
//-- --------------------------------------------------------------------------

<?exit();}else{echo "//<CENTER><H1>Deixe de ser abelhudoª!</H1><i>Não ha nada para ver aqui.</i></CENTER><style>*{color:#FFF;}CENTER *{color:#000;font-family:Arial;}H1{margin:20% 5px 0px 5px;}i{margin:0px 5px; font-size:28px;}</style>";}exit();?>