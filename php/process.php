<?php
error_reporting(0);
include 'class.php';
session_start();
$data = $_POST['data'];
$operacion = $_POST['fun'];
$log;

function selectClass() {
	global $log, $data, $operacion;
	$alert = "<script>alert(Ha ocurrido un error)</script>";
	switch ($operacion) {
		case 'LOGIN':
			$log = new $operacion($data);			
			procedimiento1();
			break;
		case 'change':
			$us_id = $_SESSION['us_id'];
			$c = $_SESSION['us_c'];
			if ($c == 'alumnos')
				$log = new ALUMNO([$us_id, $c],null, $data);			
			elseif ($c === 'profesores'){				
				$log = new PROFESOR([$us_id, $c],null, $data);
			}
	
			if (procedimiento1(false)){				
				echo $log->changePsswrd();
			}
			break;
		case 'REGISTRO':
			$log = new ADMIN($data, NULL, $data['campus']);			
			if (procedimiento1(false)){
				echo $log->registro();
				$_SESSION['us_id'] = $log->id;
				$_SESSION['us_c'] = $log->tabla;
				if ($log->tabla == 'alumnos')
					$_SESSION['us_grado'] = $log->data['grado'];
				}
			else
				echo $alert;
			break;
		case 'appendAsign':
		$data['campus'] = $_SESSION['us_c'];
			$log = new ADMIN($data, ['campus', 'asignaturas'], $data['campus']);
			if (procedimiento1(false))
				echo $log ->appendAsign();
			break;
		case 'forget':			
			$datos = ['nombre', 'campus'];			
			$tabla = $data['campus'];			
			$log = new ADMIN($data, $datos, $tabla);
			if (procedimiento1(false))
				echo $log->forgetPsswrd();
			else
				echo $alert;
			break;

		case 'color':            
            $us_id = $_SESSION['us_id'];
            $c = $_SESSION['us_c'];
            $log = new SYSTEM($us_id, $c);
            $log-> checkConnect();
            echo $log->selectColor();
            break;

		case 'selectAsign': 
			$us_id = $_SESSION['us_id'];
			$c = $_SESSION['us_c'];			
			$log = new SYSTEM($us_id, $c, $data);			
			echo $log->selectAsign();
			break;

		case 'asignatura':			
			$us_id = $_SESSION['us_id'];
			$c = $_SESSION['us_c'];
			$datos = ['asignatura'];
			$_SESSION['asignatura'] = $data['asignatura'];			
			$log = new SYSTEM ($us_id, $c, $data, $datos);
			if(procedimiento1(false)){
					echo $log->getAsignatura();
			}
			else
				echo $alert;
			break;
		case 'checkAsig':			
			$data = ['campus'=>$_SESSION['us_c'], 'grado'=>$_SESSION['us_grado']];
			$log = new SYSTEM(null, $_SESSION['us_c'], $data, ['campus', 'grado']);			
			echo $log-> selectkAllAsign();
			break;
		case 'notificacion':			
			$us_id = $_SESSION['us_id'];			
			$datos = ['mensaje', 'grado', 'cursos'];
			$log = new PROFESOR($us_id, $datos, $data);		
			if (procedimiento1(false)){				
				echo $log->sendMailNotification($data['mensaje'], $data['grado'], $data['cursos']);
			}
			else
				echo -16;
			break;
		case 'logOut':
			logOut();
			break;
		default:			
			break;

	}
}


selectClass();
function procedimiento1($myFlag = true)  {
	global $log, $operacion;			
	if ($log-> checkConnect() !== 1){		
		echo $log-> checkConnect();	
		}
	elseif ($log-> checkVars() !== 1){			
		echo -3;
	}
	else{			
		if($myFlag) {				
			echo $log->completed();							
			if ($operacion === 'LOGIN')
				$_SESSION['us_id'] = $log->id;									
				$_SESSION['us_c'] = $log->contTabla[0];
			}
			else				
				return true;		
		}
		exit;	
}

function logOut() {
	echo -4;
	session_destroy();
	exit;
}

?>
