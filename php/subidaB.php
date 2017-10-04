<?php
include 'class.php';
session_start();
$log = new SYSTEM ($_SESSION['us_id'], $_SESSION['us_c']);
$log->checkConnect();
$asignatura = $_SESSION['asignatura'];
if (isset($_POST['txt'])){
	$_SESSION['group'] = $_POST['txt'];
	$query = "select curso from asignaturas inner join profesores on asignaturas.id_profesores = profesores.id_profesores where asignaturas.nombre = '$asignatura'";
	$_SESSION['curso'] = $log->querys($query);
	switch ($_POST['txt']['grupo']) {
	 	case '1':
	 		$_SESSION['curso'] = [$_SESSION['curso'][0]];
	 		break;
	 	case '2':
			$_SESSION['curso'] = [$_SESSION['curso'][1]];
	 		break;
	 	default:	 		
	 		break;
	}
	exit();
}

$curso = $_SESSION['curso'];
$id_prof = $_SESSION['us_id'];

$check = $log->getDates([$log->contTabla[0], $log->contTabla[1]], $_SESSION['us_id'], ['nombre', 'apellidos']);

$uri = "../files/". $log->contTabla[0];
$updateFile = $uri . basename($_FILES['fichero_usuario']['name']);
$nameFile = basename($_FILES['fichero_usuario']['name']);
$ext = explode( "." , $nameFile);
if ($log->contTabla[0] == 'alumnos')
	$nameFile = date("g-i-s") . "_" . $check[0] . "_" . $check[1] . "_" . $_SESSION['us_id'] . ".$ext[1]";
else
	$nameFile = $check[0] . "_$nameFile";


if(!is_dir($uri)){
	mkdir($uri);
}

if (move_uploaded_file($_FILES['fichero_usuario']['tmp_name'], "$uri/$nameFile"))
	if ($log->contTabla[0] == 'alumnos'){

		$idDest = $log->querys("select id_profesores from asignaturas where nombre = '$asignatura'")[0];		
		$query = "insert into trabajos_subida (nombre, id_destinatario, id_remitente, uri ) values ('$asignatura', $idDest, ". $log->id .", '$uri/$nameFile')";
		echo (mysqli_query($log->con, $query)) ? 7 :  -21;
	}
	else {				
		foreach ($curso as $key) {			
		$query = "insert into recursos_subida (nombre, c_destinatario, id_remitente, uri) values ('".$_SESSION['asignatura'] ."', $key, $id_prof, '$uri/$nameFile')";
		if (!mysqli_query($log->con, "update recursos_subida set uri = '$uri/$nameFile' where id_remitente = $id_prof")){
			if (!mysqli_query($log->con, $query)) {
				echo  -21;
				break;
			}
		}
	}
	echo 7;
}

?>