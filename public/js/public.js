$(document).ready(function(){

    $(".btn-elimina").click(function(e){

        e.preventDefault();

        $("#delete" + $(this).attr("ref") ).submit();


    });

	$('.no-context').bind('contextmenu', function(e){
	    return false;
	}); 


////APUNTES COMENTARIOS


  $('#formApunteComentarios').on('submit', function(e){
    
      e.preventDefault();   
      $.ajax({
          type: "POST",
          cache: false,
          dataType: "json",
          encoding: "UTF-8",
          url: $( this ).attr("action"),
          data: $( this ).serialize(),
          success: function (data) {
            $('#formApunteComentarios textarea').val("");
            cargaApunteComentarios();

          },
          error: function (error) {

            console.log(error);

          }
      });
   
  });


  function cargaApunteComentarios(){

    if($('#apunteComentariosLista').length){
      var apunte_id = $('#apunteComentariosLista').attr('refid');

      $.ajax({
          type: "GET",
          cache: false,
          dataType: "json",
          encoding: "UTF-8",
          url: '/apunte-comentarios/' + apunte_id,
          data: $( this ).serialize(),
          success: function (data) {

            $('#apunteComentariosLista').html("");

            for(var i=0; i<data.data.length;i++){

              $('#apunteComentariosLista').append("<div>"+data.data[i].texto+apunteComentarioEnlaces(data.data[i])+"</div>");

            }

            cargaApunteComentariosEventos();
          },
          error: function (error) {

            console.log(error);

          }
      });
    }
  }

  function apunteComentarioEnlaces(data){

       var uhtml = '<a href="#" class="eliminaApunteComentario" refid="'+data.id+'">Elimina</a>';

       var html = '<div class="comentario-reacciones"><span class="qcomentariook">'+data.positivos+'</span> <a href="#" class="comentariook" refid="'+data.id+'">Me gusta</a> <span class="qcomentarioko">'+data.negativos+'</span> <a href="#" class="comentarioko" refid="'+data.id+'">No me gusta</a></div>';


      if(checkUser()){

        if(data.user_id==UID){

            html = uhtml + html;

        }  

      }
      return html;
  }

  function eliminaApunteComentario(id){

      $.ajax({
          type: "POST",
          cache: false,
          dataType: "json",
          encoding: "UTF-8",
          url: '/apunte-comentarios/destroy/'+id,
          data: token(),
          success: function (data) {
            $('#formApunteComentarios textarea').val("");
            cargaApunteComentarios();

          },
          error: function (error) {

            console.log(error);

          }
      });
  }




  function cargaApunteComentariosEventos(){

            $(".eliminaApunteComentario").click(function(e){

              e.preventDefault();
              eliminaApunteComentario($(this).attr("refid"));

            });

            $(".comentariook").click(function(e){

                e.preventDefault();

                comentarioReacciona($(this).attr("refid"), 1)

            });

            $(".comentarioko").click(function(e){

                e.preventDefault();

                comentarioReacciona($(this).attr("refid"), 0)

            });
  }
  //Inicia Comentarios
  cargaApunteComentarios()
  //Inicia Eventos
  cargaApunteComentariosEventos();

  ////////////////////////////
  //REACCIONES

  $(".apunteok").click(function(e){

      e.preventDefault();

      apunteReacciona($(this).attr("refid"), 1)

  });

  $(".apunteko").click(function(e){

      e.preventDefault();

      apunteReacciona($(this).attr("refid"), 0)

  });

  function apunteReacciona(id, tipo){
      var toko= token();
      $.ajax({
          type: "POST",
          cache: false,
          dataType: "json",
          encoding: "UTF-8",
          url: '/apuntes/react/'+id,
          data: {"_token":toko._token, "tipo": tipo},
          success: function (data) {
            muestraApunteReacciones(data);
          },
          error: function (error) {

            console.log(error);

          }
      });

  }

  function muestraApunteReacciones(data){
      $(".qapunteok").text(data.data.positivos);
      $(".qapunteko").text(data.data.negativos);
  }
  ////////////////////////////
  //COMENTARIO REACCIONES

  function comentarioReacciona(id, tipo){
      var toko= token();
      $.ajax({
          type: "POST",
          cache: false,
          dataType: "json",
          encoding: "UTF-8",
          url: '/apunte-comentarios/react/'+id,
          data: {"_token":toko._token, "tipo": tipo},
          success: function (data) {
            cargaApunteComentarios();
          },
          error: function (error) {

            console.log(error);

          }
      });

  }


  //UTIL

  function checkUser(){
    if(typeof UID !== 'undefined'){        
      return true;
    }else{
      return false;
    }
  }

  function token(){

    return {'_token':$('meta[name="csrf-token"]').attr('content')};
  }


  });
