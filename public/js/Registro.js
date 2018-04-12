function Registro()
{
	//Registro datos
	var txtNombres=$("#txtNombres");
	var txtApellidos=$("#txtApellidos");
	var txtCorreo=$("#txtCorreo");
	var txtClave=$("#txtClave");
	var txtClaveSocial=$("#txtClaveFormularioSocial");
	var frmNuevoRegistro=$("#frmNuevoRegistro");
	var _token=$("#csrf-token");
	//Registro sociales
	var frmDatosSociales=$("#frmDatosSociales");
	//Registro perfil
	var lstAnioInicio=$("#lstAnioInicio");
	var lstAnioFin=$("#lstAnioFin");
	var txtUniversidad=$("#txtUniversidad");
	var listaUniversidadTexto=$("#listaUniversidades");//lista de universidades (Alimenta los filtros)
	var txtCarrera=$("#txtCarrera");
	var listaCarreras=$("#listaCarreras");//lista de universidades (Alimenta los filtros)
	var frmRegistroPerfil=$("#frmRegistroPerfil");
	//Registro Cursos
	var agregarCursos=$("#agregarCursos");
	var fmrCursos=$("#fmrCursos");
	this.iniciar=function()
	{
		txtCorreo.keyup(validarCorreo);
		txtClave.keyup(validarClave);
		txtClaveSocial.keyup(validarClave);
		frmNuevoRegistro.on('submit',sendRegistro);
		frmRegistroPerfil.on('submit',sendRegistroPerfil);

		frmDatosSociales.on('submit',sendDatosSociales);

		agregarCursos.on('click',agregarNuevoCurso);
		fmrCursos.on('submit',sendCursos);
		txtUniversidad.on('change',seleccionarCarrera);
	}
	function validarCorreo()
	{
		var regex = /[\w-\.]{2,}@([\w-]{2,}\.)*([\w-]{2,}\.)[\w-]{2,4}/;
		if (regex.test($(this).val().trim())){
			mensajesFormularios('mail_msj_ok')
		}else {
			mensajesFormularios('mail_msj_error');
		}
	}
	function validarClave()
	{
		var longitud=$(this).val().length;
		if (longitud >= 6){
			mensajesFormularios('clave_msj_ok')
		}else {
			mensajesFormularios('clave_msj_error');
		}
	}
	function mensajesFormularios(elemento)
	{
		$(".msj_alert").hide();
		$("#"+elemento).show();
		setTimeout(function(){
			$(".msj_alert").hide();
		},3000);
	}
	function sendRegistro(e)
	{
		e.preventDefault();
		var campos = ['txtNombres','txtApellidos','txtCorreo','txtClave'];
		validarRegistro=validarCampos(campos);
		if(validarRegistro == 1){
			alert('Faltan datos.');
		}
		var objRegistro=new Object();
		objRegistro.nombres=txtNombres.val();
		objRegistro.apellidos=txtApellidos.val();
		objRegistro.correo=txtCorreo.val();
		objRegistro.clave=txtClave.val();
		objRegistro._token=_token.attr('content');
		procesarPost('guardar-registro',objRegistro,retornoGuardarRegistro);
	}
	function retornoGuardarRegistro(data)
	{
		if(data==1)
		{
			redirigir('registro-perfil');
		}
	}
	function sendRegistroPerfil(e)
	{
		e.preventDefault();
		var campos = ['txtUniversidad','txtCarrera','lstAnioInicio','lstAnioFin'];
		validarPerfil=validarCampos(campos);
		if(validarPerfil == 1){
			alert('Faltan datos.');
		}
		var objPerfil=new Object();
		objPerfil.universidad=txtUniversidad.val();
		objPerfil.carrera=txtCarrera.val();
		objPerfil.inicio=lstAnioInicio.val();
		objPerfil.fin=lstAnioFin.val();
		objPerfil._token=_token.attr('content');
		procesarPost('guardar-perfil',objPerfil,retornoRegistrarPerfil);
	}
	function retornoRegistrarPerfil(data)
	{
		if(data==1)
		{
			redirigir('registro-cursos');
		}
	}
	function sendDatosSociales(e)
	{
		e.preventDefault();
		var campos = ['txtClaveFormularioSocial'];
		validarPerfil=validarCampos(campos);
		if(validarPerfil == 1){
			alert('Faltan datos.');
		}
		var objSocial=new Object();
		objSocial.clave=txtClaveSocial.val();
		objSocial._token=_token.attr('content');
		procesarPost('guardar-clave-social',objSocial,retornoRegistrarClaveSocial);
	}
	function retornoRegistrarClaveSocial(data)
	{
		if(data==1)
		{
			redirigir('registro-perfil');
		}
	}

	function seleccionarCarrera()
	{
		var universidad = $(this).val();
		var objUniversidad=new Object();
		objUniversidad.universidad=universidad;
		objUniversidad._token=_token.attr('content');
		procesarPost('consultar-carrera',objUniversidad,cargarCarreras);
	}
	function cargarCarreras(data)
	{
		listaCarreras.html('');
		$.each(data,function(index,value){
			listaCarreras.append('<option value="'+value.nombre+'"></option>');
		});
	}
	function agregarNuevoCurso(e)
	{
		e.preventDefault();
		var cantidad = $('.filters_cursos').size();
		$("#listaCursos").before('<input type="text" class="form-control mb_10 filters_cursos" list="listaCursos" id="filter_curso_'+(cantidad + 1)+'">');
	}
	function sendCursos(e)
	{
		e.preventDefault();
		var cantidad = $('.filters_cursos').size();
		var arrCursos=[];
		for(var i=0 ; i < cantidad ; i++){
			arrCursos.push($(".filters_cursos:eq("+(i)+")").val());
		}
		var objCursos=new Object();
		objCursos.cursos=arrCursos;
		objCursos._token=_token.attr('content');
		procesarPost('guardar-cursos',objCursos,retornoGuardarCursos);
	}
	function retornoGuardarCursos(data)
	{
		console.log(data);
	}
	/*FUNCIONES DE APOYO*/
	function validarCampos(camposUsuario)
	{
		var existe=0;
		$.each(camposUsuario,function(index,value){
			if($('#'+value).val()==""){
				$('#'+value).css('border','solid 1px red');
				existe++;
				setTimeout(function(){
					$('#'+value).css('border','solid 1px #ccc');
				},3000);
			}
		})
		if(existe > 0){
			return 1;
		}else{
			return 0;
		}
	}
	function procesarPost(link,datos,funcion)
	{
		var url = link;
		$.ajax({
			dataType:"json",
			data:datos,
			type:"POST",
			url: url,
			success: function(evt,ss,aa){
				funcion(evt);
			},
			error:errorLectura
		});
	}
	function errorLectura(data)
	{
		console.log(data)
	}
	function redirigir(url)
	{
		location.href = url;
	}
}


var registro=new Registro();
registro.iniciar();