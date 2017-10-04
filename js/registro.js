var phpLog = 'php/process.php';
var $form = $('form.registro');
var $mensajes = $('#mensajes p');
var $inputName = $('input[name=nombre]');
var $inputPaswrd = $('input[name=passwrd]');
var error = 'Algo ha ido mal, por favor intentelo de nuevo más tarde';
var URL = window.location.href,
	primer = '';


//Funcion para mostrar la contraseña
$('#visor').mousedown(function(){
	$($inputPaswrd).attr('type' , 'text').css('border', '2px solid red');
}).mouseup(function(){
	$($inputPaswrd).attr('type' , 'password').css('border', '1px solid black')	
});

//Selección de campus
$('.radio').click(function(){	
	var x = $(this).index('.radio'), val = '';
	switch (x){
		case 0:
			val = 'alumnos'
			break;
		case 1:
			val = 'profesores'
			break;
		case 2:
			val = 'staff'
			break;
	}		
	$('.radio').val(val)
});


// Envio del login
$($form).submit(function (e) {
	e.preventDefault()
	var login = {nombre: undefined, contrasena: undefined, session: undefined, campus: ''}
	login.nombre = $($inputName).val()
	login.contrasena = $($inputPaswrd).val()
	login.campus = $('input[name=campus]').val()
	log(login.campus)
	if (login.contrasena.length ===0 || login.nombre.length ===0 || login.campus == '' && $mensajes.html().search('campos') === -1)		
		$mensajes.text("Los campos no pueden estar vacios")
	else 
		$.post(phpLog, {fun: 'LOGIN', data: login}, checkFunction)	
})

$('#logOut').click(function(){
	$.post(phpLog, {'fun': 'logOut', 'data': {'vacio':''}},checkFunction)
})



//---------------------------Para introducir un nuevo ususario----------------------
var campus = 'voy a decirte el capus'
var input = $('.formRegistro input');

//Consulta y funcion para cargar las asignaturas

var inputRadio = $(".formRegistro .asig")
$('.formRegistro').css('display', 'none');
if (URL.search('asignatura') == -1)
$('#selectCampus input').click(function(){	
	$('.formRegistro').css('display', 'block');
	$('#selectCampus').css('display', 'none');
	var ind = $(this).index('#selectCampus input');	
	switch(ind){
		case 0:
			campus = 'alumnos'
			$('#profesores').remove()
			break;
		case 1:			
			campus = 'profesores'
			$('#alumnos').remove()
			break;
		case 2:
			campus = 'staff'
			break;
		default:
			break;
	}
	input = $('.formRegistro input');
})
 
function Login (registro){
	this.registro = registro;
	this.checkFiles = function() {
		var carga = []
		var repeat = []	//Dice los campos que hay que repetir y por que
		for (var i in registro){	
			carga.push(i.toString())
		}
		for (var i = 0; i< carga.length; i++){
			//Comprovacion de si los campos estan vacios
			if (this.registro[carga[i]] === '') {
				repeat.push([i, true]);
				this.registro[carga[i]] = undefined;
			}
			//Comprovación si lo campos no se corresponden con el patron
			else if (typeof($(input[i]).attr('pat')) !== 'undefined'){
					var pat = new RegExp($(input[i]).attr('pat'))
					if (this.registro[carga[i]].search(pat)===-1){
						repeat.push([i, false]);
						this.registro[carga[i]] = undefined;
					}
				}
		}
		return repeat
	}
	// esta funcion comprueba si hay que repetir los campos. Si la pos dos del array que devuelve es true,
	//significa que el campo esta vacio. Si es false, es que no coincide con el patron
	this.check = this.checkFiles()
	this.reWrite = function(){
		var quote = '';
		var empty = true;
		var check = this.check
		for (var i = 0; i<check.length; i++){
			quote = ''
			if (check[i][1] || !check[i][1]){
				if (check[i][1])
					quote = 'Este campo no puede estar vacio';
				else
					quote = 'El campo no se ha rellenado correctamente' +
				$(input[check[i][0]]).val('').attr('placeholder', quote)
				empty = false
			}
		}
		if (!empty)
			return false 
			// return true 
		else 
			return true;
	
	}
	this.sendForm = function(php, data, fun) {		
		$.post(php, data, fun).fail(function(xhr, status, err) {alert(err + '\n ha ocurrido un error')})		 
	}
}

// $('body').on('submit','.formRegistro', function(e) {
$('.formRegistro').on('submit', function(e) {
	e.preventDefault();
	input = $('.formRegistro input');
	// Esta variable va a contener todos los datos del registro	
	var registro = (campus == 'alumnos') ? {
		"nombre": undefined,
		"apellidos": undefined,
		"nacimiento": undefined,		
		"dni": undefined,
		"direccion": undefined,
		"ciudad": undefined,
		"provincia": undefined,
		"cp": undefined,
		"cuentaBancaria": undefined,
		"curso": undefined,
		"telefono": undefined,
		"email": undefined,
		"sexo": undefined,
		"campus": undefined,
		"grado": undefined,
		"asignaturas": [] 
	} : 
	{
		"nombre": undefined,
		"apellidos": undefined,
		"nacimiento": undefined,
		"dni": undefined,
		"direccion": undefined,
		"ciudad": undefined,
		"provincia": undefined,
		"cp": undefined,
		"cuentaBancaria": undefined,	
		"telefono": undefined,
		"email": undefined,
		"nacimiento": undefined,
		"sexo": undefined,
		"campus": undefined
	}
	var carga = [];	
	for (var i in registro){		
		carga.push(i.toString())
	}
	for (var i = 0; i< carga.length; i++){
		registro[carga[i]] = $(input[i]).val();		
	}
	registro['campus'] = campus;		
	registro['sexo'] = $('select[name=sexo]').val()	
	registro['grado'] = $('select[name=grado]').val()
	if (campus == 'alumnos') registro['asignaturas'] = ['vbe'];
	primer = new Login(registro);
	if (primer.reWrite()) 		
		primer.sendForm(phpLog, {fun : 'REGISTRO', data: primer.registro}, checkFunction)
	else
		$mensajes.html(error);
})

//--------------------------------------------------------------------------------------------

$('#changePssword').submit(function(e){
	input = $('input')
	e.preventDefault();
	var registro = {
		'contrasena': undefined,
		'newPsswrd1': undefined,
		'newPsswrd2': undefined
	}
	var carga = []
	for (var i in registro){		
		carga.push(i.toString())
	}
	for (var i = 0; i< carga.length; i++){
		registro[carga[i]] = $(input[i]).val();		
	}	
	carga = undefined
	console.log(registro)
	var change = new Login(registro)
	//Primero vemos si hay campos vacios
	if (change.reWrite()) 		
		change.sendForm(phpLog, {fun : 'change', data: change.registro}, checkFunction)
	else
		alert(error);
})

$('#newPsswrd').submit(function(e){
	input = $('input')
	e.preventDefault();
	var registro = {'campus': undefined, 'nombre': undefined};
	registro.campus = $(input[0]).val();
	registro.nombre = $(input[2]).val();	
	var forget = new Login(registro);
	if (forget.reWrite()) 		
		forget.sendForm(phpLog, {fun : 'forget', data: forget.registro}, checkFunction)
	else
		alert(error);
});

/*-----------------------------------------Notificaciones-------------------------------------------------*/
//Empezamos definiendo que asignaturas puede dar ese profesor

var cursos;
if (URL.search('notificaciones') !== -1)
$.post(phpLog, {'fun':'selectAsign', 'data': {'grade': ''}}, function(data) {cursos = selectGrade(data, false)})

function selectGrade(data, myFlag){
	log(data)
	var gradosVal = data.split(','),
		grados = [], 
		asig = [], 
		carga,
		cargaUpper;				

	for (var i = 0; i< gradosVal.length-1; i++){
		if(!myFlag)
			gradosVal[i] = gradosVal[i].replace('_','')			
		carga = gradosVal[i]
		cargaUpper = carga[0].toUpperCase()
		carga = cargaUpper + carga.substring(1,carga.length);
		if(myFlag){
			asig.push(gradosVal[i].split('_'))
			asig[i][2] = carga.split('_')[0];
		}
		(carga === 'Grafico') ? grados.push('Gráfico') : grados.push(carga)
		
	}
	(!myFlag) ? loadList("Grado", grados, gradosVal) :loadRadio(asig)
	
}

function selectAsign (data) {
	log(data)
	var gradosVal = data.split(','),		 
		asig = [],
		carga,
		cargaUpper;
	for (var i = 0; i< gradosVal.length-1; i++){
		asig.push(gradosVal[i].split('_'))				
	}
	log(asig)
	loadRadio(asig)


}
$('body').on('click','#cursos', function(e) {
	var val = $('#grade').val()
	$.post(phpLog, {'fun':'selectAsign', 'data':{'grade': val}}, function(data) {cursos = selectGrade(data, true)})		
});


$('#notificaciones').submit(function(e){
	e.preventDefault()
	var notificaciones = {
		'mensaje': undefined,
		'grado': undefined,
		'cursos': []
	}
	var $select = $('select'),
		$radio = $(':radio');
		for (var i = 0; i<$radio.length; i++){
			if($($radio[i]).prop("checked") === true){
				notificaciones.cursos.push($($radio[i]).val())				
			}
		}
		
	notificaciones.mensaje = $('#mensaje').val();
	notificaciones.grado = $($select[0]).val()	
	var enviar  = new Login (notificaciones);
	if (enviar.reWrite())
		enviar.sendForm(phpLog, {fun : 'notificacion', data: enviar.registro}, checkFunction)
	else
		alert(error);
})
/*---------------------Pinta la lista de asignaturas que se puedan seleccionar--------*/
if (URL.search('asignatura') !== -1){	
	$.post(phpLog, {'fun': 'checkAsig', 'data': {'campus':'', 'grado': ''}}, writeCheckAsign)
	function writeCheckAsign(data) {
		log(data)
		dates = data.split('*');
		var asig = [],
			txt = '',
			curso = ['Primer curso', 'Segundo curso', 'Tercer curso', 'Cuarto curso'],
			grado = ['Grafico', 'Moda', 'Video juegos']
			asig = [],
			val = [],
			m =(dates.length == 1) ? 0 : 1;
		for (m; m<dates.length; m++){
			data = dates[m].split('¿');
			if (dates.length !== 1)
				txt += '<h3>'+grado[m-1]+'</h3>';
			for (var i = 0; i< data.length; i++){
				asig = data[i].split(',');
				txt += '<div class="curso"><div class="rowCat">'+curso[i] +'</div> <div class="info"><div class="tablaAsignatura"> Asignaturas </div><div class="infoAsignatura">';
				for (var x = 0; x< asig.length-1; x++){
					val = asig[x].split('%')
					txt += val[1] + '<input type="radio"  value="'+val[0]+'" class="radio asig">';
				}
				txt+='</div></div></div>';
			}
		}
		$('#asignaturas').html(txt)
	}


	/*------------------------------------formulario asignaturas---------------------------------*/
	$('#selectCampus').submit(function(e){
		e.preventDefault();
		var input = $('input[type=radio]'),
			select = [];
		for (var i = 0; i< input.length; i++){
			if ($(input[i]).prop("checked") === true)
				select.push($(input[i]).val())
		}	
		$.post(phpLog, {'fun': 'appendAsign', 'data': {'campus': '', 'asignaturas': select}}, checkFunction)
	});
}

/*------------------------Todo lo relacionado con el main-----------------------------------*/

if (URL.search('contraseña') === -1){
var URL1 = URL.split('?')[1],
	error = "Error en la subida del fichero";	
$.post(phpLog, {'fun':'asignatura', data: {'asignatura':URL1}},system)
$('.toSend').submit(function(e){
	var ind = $(this).index('.toSend')
		e.preventDefault();  
		formdata = new FormData();
		var f = document.getElementsByClassName("inputfile")[ind].files[0]
	if (typeof f == 'undefined' || f == null){
		alert(error)
		return false;
	}
	if (!f.type==='application/pdf' || !f.type==='application/zip'){
		alert(error + 'debido al formato')
		return false;	
	}
	var inp = $('input[type=radio]')
	var obj = {'grupo': ''}
	for (var i = 0; i< inp.length; i++){
		if ($(inp[i]).prop("checked") === true)
			obj.grupo = $(inp[i]).val();
	}

	
	formdata.append("fichero_usuario", f);
	$.post("php/subidaB.php", {'txt': obj}, function(d){log(d)})
	$.ajax({
        url: "php/subidaB.php",
        type: "POST",
        data: formdata,
        processData: false,
        contentType: false,
        success: checkFunction,
        error: function () {	        
        	alert(error);
        }
  });
})
/*----------------------------------showAsignaturas--------------------------------*/

function drawAsistencia(arr){
  var noti = $('.textIzq')
  noti = noti[0];
  $(noti).html ('<div id="cali">Calificación: </div><div id="asiste">Asistencia: '+arr+'%</div>');
        
}
 function drawAsignaturas(arr) {
	var arr = arr.split(','),
		txt = '',
		carga = '',
		cargaUpper = '';
	for (var i in arr){
		carga = arr[i]
		cargaUpper = carga[0].toUpperCase()
		carga = cargaUpper + carga.substring(1,carga.length);
		txt += '<li class="hide"><a class="li_menu" href="'+URL.split('?')[0]+'?'+ arr[i] +'">'+carga+'</a></li>';		
	}
	$('#asignaturas').append(txt)
}

function drawProfesor(arr){
	var name = arr.split(',');
	var txt = name[0]+' '+name[1]+': <a href="#">'+name[2]+'</a>';
	$('.textIzq').prepend(txt);

}

function drawNotifications(arr){
	var data = arr.split('_'),
		txt = '';
	for (var i = 0; i< data.length; i++){
		data[i] = data[i].split(',')
		txt += '<b>'+data[i][1]+':</b><br>'+data[i][0]+'<br>';
	}
	$('.notificaciones').append(txt);
}
function drawNotificationsAsig(arr){
	var data = arr.split(','),
		txt = '';
	for (var i =0; i< data.length;i++){
		txt += '<div class="dataAsignatura"><div class="iconAsignatura"><img src="img/Bell-Icon.png" alt=""></div><div class="textAsignatura"><a href="#"class="showAsignatura">'+data[i]+'</a></div></div>'
	}

	$('#notAsig').append(txt);
}
function drawName(u){
var c = u[0].toUpperCase();
u = c + u.substring(1,u.length)
	$('#nombreAsignatura').html(u);
}
function drawRecurso(uri){
	$('#recursoDescargable').attr('href', uri);	
}

function diferenceCampus(c){
	if (c !== 'alumnos'){
		var noti = $('.cajaAsignatura')		
		$(noti[0]).html ('<a href="notificaciones.html">Enviar notificaciones</a>');
		var field1 = $(noti[1]).find('button').html ();
		field1 = field1.replace('Recursos', 'Entregas');
		$(noti[1]).find('button').html(field1);
		field = $(noti[2]).find('button').html ();
		field1 = field1.replace('Entregas', 'Recursos');
		$(noti[2]).find('button').html (field1);
		$('.cajaArchivo').prepend('Grupo 1 <input type="radio" name = "grupos"value="1">Grupo 2<input type="radio" name = "grupos"value="2">Ambos <input type="radio" name = "grupos"value="3">')
	}

}

function drawUrls(){
	var a = $('a'),
		href = '';
	for (var i = 0; i< a.length; i++){
		href = $(a[i]).attr('href');
		if(href !== '#' && href.search(/[?]/) === -1) {
			$(a[i]).attr('href', href+ '?'+ URL1);
		}
	}
}


/*------------------------------------------ --------------------------------------*/
function system(data){	
	data = data.split('*')
	$('.textDcha a').attr('href', data[0]);
	if (data[2] !== 'profesores'){
		$('header, .asigName, .rowCat, label, .enviar').css("background-color",data[1]);
		drawAsignaturas(data[2]);
		drawProfesor(data[3]);
		drawAsistencia(data[4]);
		drawNotifications(data[5]);
		drawNotificationsAsig(data[6]);
		drawName(URL1);
		drawRecurso(data[7]);		
		return data[8];
	}
	else  if (data[2] == 'profesores'){		
		diferenceCampus(data[2]);
		drawRecurso(data[1])
	}
		drawUrls();
		return data[2]
}
}


function checkFunction(data){	
	var x = data.split(' '),
	$input = $('input')
	x[0] = parseInt(x[0])
	if (!isNaN(x[0]))
		data = x[0]	
	switch (data) {
	case 7:
		alert('Se ha subido correctamente');
		break;
	case 6:
		alert('Se han enviado los mensajes');
		$('#mensaje').val('')
		break;
	case 5:
		location.href = 'registro.html';
	case 4:
		$mensajes.text('Su nueva contraseña se ha enviado al correo')
		$($input).val('')
		break
	case 3:
		$mensajes.text('Se ha cambiado la contraseña correctamente')
		$($input).val('')
		break
	case 2:
		location.href = 'asignatura.html';
		$($input).val('')
		break
	case 1:
		location.href = 'main.html?' + x[1];				
		break;
	case -1:
		$mensajes.text(error)				
		break;
	case -2: 
			if($mensajes.html().search('nombre') ===-1){
				$($mensajes).text('Contraseña o nombre incorrectos\n' +data);
				$($input).val('')
			}
		break;
	case -3: 		
		$mensajes.text(error)		
		break;
	case -4: 
		location.href = 'index.html';
		break;
	case -5: 
		$($mensajes).html('El usuario no está registrado');
		$($inputName).val('')
		break;
	case -6: 
		$($mensajes).html('Contraseña incorrecta');
		break;
	case -7:
		$($mensajes).html(error + '<br> No se ha enviado la informacion de forma correcta');
		break
	case -8:
		$($mensajes).html(error + '<br>Ha habido un fallo en la conexion');
		break
	case -9:
		$($mensajes).html(error + '<br>El mail no se ha enviado correctamente');
		break
	case -10:		
		$($mensajes).html(error + '<br>La contraseña inicial no coincide con la contraseña que tenemos guardada');
		break
	case -11:
		$($mensajes).html(error + '<br>Ha habio un error en la conexion');
		break
	case -12:
		$($mensajes).html(error + '<br>No se ha enviado el correo con su nueva contraseña Esta es:' + x[1]);
		break;
	case -13:
		$($mensajes).html(error + 'Fallo en la consulta');
		break;
	case -20:
		alert('No se han podido enviar las notificaciones');
		break;
	case -21:
		alert('No se ha subido correctamente');
		break;
	default:			
		console.log(data)
		break;
	}
	$($inputPaswrd).val('')	
}

//---------------------------------------------------------------------------------------------------
function showFor(arr){	
	for (var i in arr){
		log(i + '\n' + arr[i])
	}
}

var log = console.log
