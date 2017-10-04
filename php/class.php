<?php
include 'mail.php';
define("HOST", "localhost");
define("USER_DB", "root");
define("PASSWD", "");
define("NAME_BD", "campus");
$NT = ['al'=>'alumnos','pr'=>'profesores', 'st'=>'staff' ];
$forviden = "<?xml version=\"1.0\" encoding=\"UTF-8\"?><!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Strict//EN\"\"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd\"><html xmlns=\"http://www.w3.org/1999/xhtml\" lang=\"en\" xml:lang=\"en\"><head><title>&iexcl;Acceso prohibido!</title>
<link rev=\"made\" href=\"mailto:postmaster@localhost\" /><style type=\"text/css\"><!--/*--><![CDATA[/*><!--*/body { color: #000000; background-color: #FFFFFF;}a:link { color: #0000CC;}p, address {margin-left: 3em;}span {font-size: smaller;}/*]]>*/--></style></head><body><h1>&iexcl;Acceso prohibido!</h1><p>Usted no tiene permiso para acceder al objeto solicitado. El objeto est&aacute; protegido contra lectura o el servidor no puede leerlo.</p><p>Si usted cree que esto es un error del servidor, por favor comun&iacute;queselo al <a href=\"mailto:postmaster@localhost\">administrador del portal</a>.</p><h2>Error 403</h2><address>
  <a href=\"/\">localhost</a><br /><span>Apache/2.4.23 (Win32) OpenSSL/1.0.2h PHP/7.0.13</span></address></body></html>";
trait USUARIO {
    public function sendMail($mensaje, $subject, $from){
        global $mail;
        $para = (isset($this->data['email'])) ? $this->data['email']: $this->data['nombre'];
        $toSend = $mensaje;
        $mail->SetFrom($para, $this->from);
        $mail->addAddress($para, "$from[0] $from[1]");
        $mail->Subject = $subject;       
        $mail->msgHTML($toSend);               
        return (!$mail->send()) ? -9 : True;        
    }

    public function getDates($contTabla, $id, $files) {
        if (!isset($this->con)) $this-> checkConnect();        
        if (gettype($files) == 'array')
            $ask = join(', ', $files);        
        $query = "select $ask from $contTabla[0] WHERE $contTabla[1] = $id";
        $check = mysqli_query($this->con, $query);
        $dates = [];                
        while ($fila = mysqli_fetch_assoc($check)) {
         foreach ($files as $key) {            
             $dates[] = $fila[$key];             
         }
        }
        
        return (count($dates) == 1) ? $dates[0] : $dates;
    }

    public function queryPsswrd($contTabla, $where, $psswrd = NULL){ 
        $psswrd = $psswrd;
        $query = "Update $contTabla[0] Set contrasena='" .md5($psswrd). "' Where $where";               
        return mysqli_query($this->con, $query);
    }

    public function changePsswrd(){
        $this->passwrd = $this->data['contrasena'];                
        $contTabla = $this->contTabla;        
        $id = $this->searchPsswrd($contTabla);
        if ($id[0] === $this->id[0]){
            $pwrd = $this->data['newPsswrd1'];            
            if ($this->queryPsswrd($contTabla, "$contTabla[1]='".$this->id[0]."'", $pwrd))
                return 3;
            else
                return -11;
        }
        else{            
            return -10;
        }
    }
}

trait DOCENTES {    
    public function selectTarget ($grupos) {    	        
        $cursos = "";
        $asignaturas = "";
        foreach ($grupos as $key) {            
            $key = explode("_", $key);
            $cursos .= " or asignaturas.curso BETWEEN " . ($key[1]-0.01 ). " and " .($key[1] + 0.01);            
            $asignaturas .= " or asignaturas.nombre ='".$key[0]."'";
        }
        $cursos = substr($cursos, 4);        
        $asignaturas = substr($asignaturas, 4);                   
        return  ["SELECT email FROM alumnos INNER JOIN matriculaciones ON alumnos.id_alumnos = matriculaciones.id_alumnos INNER JOIN asignaturas ON asignaturas.id_asignaturas = matriculaciones.id_asignaturas WHERE ($cursos) and (asignaturas.nombre = 'photoshop') ", $cursos, $asignaturas];
          }

    public function sendMailNotification($mensaje, $grade, $to){
        global $mail;
        $preDestino = $this->selectTarget($to);        
        $destino = $this->querys($preDestino[0]);                
        $from = $this->getDates($this->contTabla, $this->id, ['nombre', 'email']);        
        $toSend = "De parte de: ". $from[0] ."\n<br>$mensaje\n<br>Para responder: ".$from[1];        
        $mail->SetFrom($destino[0], "Campus virtual");        
        foreach ($destino as $key) {
            $mail->addAddress($key, "");            
        }
        $mail->Subject = "mensaje de: ". $from[0];        
        $mail->msgHTML($toSend);
        $id_asignaturas = "SELECT id_asignaturas FROM asignaturas WHERE ($preDestino[1]) and ($preDestino[2])";        
        $id_asignaturas = $this->querys($id_asignaturas);        
        $id_asignaturas = join('_',  $id_asignaturas);                
        $query = "insert into notificaciones (id_profesores, id_asignaturas, mensaje) values ('$this->id', '$id_asignaturas', '$mensaje')";        
        if (mysqli_query($this->con, $query))
            return (!$mail->send()) ? -14 : 6;
        else
            return -20;
    }
}

class LOGIN {
    public $tabla = '';
    public $con = '';
    public $id = '';
    public $name = '';
    public $passwrd = '';
    public $datos;
    public $contTabla;
    function __construct($data) {
        $this->data = $data;        
        $this->datos = ['nombre', 'contrasena'];        
        $this->contTabla = $this->selectTable();
    }

    public function checkConnect() {
        $this->con = mysqli_connect(HOST, USER_DB, PASSWD, NAME_BD);        
        if (!$this->con)
            return -3;
        else return 1;
    }

    public function checkVars() {        
        foreach ( $this->datos as $file){            
            if (!isset($this->data[$file]))
                if (is_a($this, 'USSER'))
                    return $file;
                elseif (is_a($this, 'ADMIN'))
                    return $file;
                elseif (is_a($this, 'LOGIN'))
                    return $file;
                else
                    return "No soy nada";
        }
        return 1;      
    }
    
    public function selectTable() {
        global $NT;
        $campus = (isset($this->data["campus"])) ? $this->data["campus"] : $this->campus;
        $contTabla = ['',''];
        if ( $campus === 'profesores')
            $contTabla[0] = $NT['pr'];            
        elseif ( $campus === 'alumnos')
            $contTabla[0] = 'alumnos';
        elseif ( $campus === 'staff'){            
        }
        $contTabla[1] = "id_$contTabla[0]";
        
        return $contTabla;
        
    }

    public function searchName($contTabla) {
        $this->name = mysqli_real_escape_string($this->con, $this->data['nombre']);
        $query = "SELECT ".$this->contTabla[1].", email FROM ".$this->contTabla[0]." WHERE email='$this->name'";        
        $check = mysqli_query($this->con, $query);
        while ($fila = mysqli_fetch_assoc($check)) {
         $passNombre = [$fila[$this->contTabla[1]], $fila['email']];         
        }
        return $passNombre; 
    }

    public function searchPsswrd($contTabla) {
        $this->passwrd = md5($this->data['contrasena']);        
        $query = "SELECT ".$this->contTabla[1].", contrasena FROM ".$this->contTabla[0]." WHERE contrasena='$this->passwrd'";

        $check = mysqli_query($this->con, $query);        
        while ($fila = mysqli_fetch_assoc($check)) {
            $passPwrd = [$fila[$contTabla[1]], $fila['contrasena']];            
        }
        return $passPwrd;
    }

    private function getFirstAsign(){
        $query = ($this->contTabla[0] === 'alumnos') ? 
        "select nombre from asignaturas inner join matriculaciones on  asignaturas.id_asignaturas = matriculaciones.id_asignaturas where id_alumnos = ".$this->id ." order by nombre limit 1" : 
        "select nombre from asignaturas where id_profesores = ".$this->id . " order by nombre limit 1";
        return $this->querys($query)[0];
    }

    public function completed() {
        $contTabla = $this->selectTable();
        $passNombre = $this->searchName($contTabla);
        if (!isset($passNombre))
            return -5;        
        $passPwrd = $this->searchPsswrd($contTabla);        
        if (!isset($passPwrd))
            return -6;
        elseif($passNombre[0] !==$passPwrd[0])
            return -2;
        else{
            $this->id = $passPwrd[0];
            return 1 . " ".$this->getFirstAsign();
        }
    }

    public function querys($query, $files = null) {
        $arr = [];
        $check = mysqli_query($this->con, $query);
        if (is_null($files)){
            while ($fila = mysqli_fetch_row($check)) {
                    $arr[] = $fila[0];
            }
        }
        else{            
            while ($fila = mysqli_fetch_row($check)) {
                for  ($i = 0; $i<count($files); $i++) {
                    $arr[] = $fila[$i];
                }
            }
        }
        return (isset($arr)) ? $arr : -13;
    }
}

class ADMIN extends LOGIN {
    use USUARIO, DOCENTES;
    private $query = '';
    private $psswrd = '';
    private $table = '';
    public $from = 'Campus virtual';
    function __construct($data,  $datos= NULL, $tabla) {
        global $NT;
        $this->data = $data;
        $this->contTabla = $this->selectTable();
        if (!isset($datos)){                                   
            switch ($tabla) {
                case 'alumnos':
                    $this->datos =['nombre', 'apellidos', 'nacimiento', 'sexo', 'dni', 'cuentaBancaria', 'direccion', 'ciudad', 'provincia', 'cp', 'curso', 'grado', 'telefono', 'email','asignaturas'];
                    $this->tabla = $NT['al'];
                     break;
                case 'profesores':
                case 'staff':
                    $this->datos =['nombre', 'apellidos', 'nacimiento', 'sexo', 'dni', 'cuentaBancaria', 'direccion', 'ciudad', 'provincia', 'telefono', 'email'];
                    $this->tabla =  ($tabla == 'profesores') ? "profesores" :"staff";
                    break;
                default:
                    break;
            }
        }
        else{
            $this->datos = $datos;
            $this->tabla = $tabla;
        }
    }
    //Genera una contraseña aleatoria en funcion de la hora a la que se realiza el registro
    private function psswd() {        
        return substr( md5(microtime()), 1, 8);
    }

    //Esta funcion te devuelve la consulta que se tiene que realizar
    private function queryRegistro(){
        $i = 0;
        $check = [];        
        $files = "";
        $values = "";
        foreach ($this->datos as $file){
            if ($file !== 'asignaturas'){
                $files .= "$file, ";
                $values.= "'".$this->data[$file]. "', ";
            }
        }
        $files .= "contrasena";
        $this->psswrd = $this->psswd();        
        
        $values.= "'".md5($this->psswrd)."'";
        return "insert into $this->tabla ($files) values ($values)";
    }
    private function updateFiles($table, $where){
        $query = "update $table set id_profesores  = $this->id $where";        
        return (!mysqli_query($this->con, $query)) ? -14 : true;             
    }

    //Realiza la operacion en la base de datos
    public function registro(){
        $subject = "Bienvenido";
        $from = [$this->data['nombre'], $this->data['apellidos']];
        $query = $this->queryRegistro();
        if (mysqli_query($this->con, $query)){
            $this->id = mysqli_insert_id($this->con);
            $this->updateFiles('asignaturas', "where $asignaturasToUp");
            $mensaje = "$from[0] bienvenido al campus virtual!!!.\nEsperamos que la estancia sea lo más agradable posible y recuerda, siempre trabajamos para mejorar ;)\n tu nueva constraseña es: <b>$this->psswrd</b> No se te olvide cambiarla :)";
            if ($this->sendMail($mensaje, $subject, $from)){                
                return 2;
            }
        }
        else            
            return -8;         
    }    

    public function forgetPsswrd(){        
        $contTabla = $this->contTabla;
        $mail = $this-> searchName($contTabla);
        if (isset($mail)){
            $id = $mail[0];
            $this->getDates($contTabla, $id, 'email');            
            $psswrd = $this -> psswd();
            if ($this->queryPsswrd($contTabla, "email='$mail[1]'", $psswrd)){
                $mensaje = "¿Has enviado una solicitud para recibir una nueva contraseña?\n Si no lo has hecho olvida este mensaje. En caso afirmativo, tu nueva contraseña es $psswrd";
                $subject = 'Nueva contraseña';
                $from = ['',''];
                if ($this->sendMail($mensaje, $subject, $from))
                    return 4;
                else
                    return -12 ;
            }
        }
    }

    public function appendAsign(){
        if ($this->tabla === 'alumnos'){
            foreach ($this->data['asignaturas'] as $key) {
                $query = "insert into matriculaciones (id_alumnos, id_asignaturas) values (".$_SESSION['us_id'] .", $key)";                
                if(!mysqli_query($this->con, $query))
                    return -17;
            }
            return 5;
        }
        else {
            foreach ($this->data['asignaturas'] as $key) {
                $name = $this->querys("select nombre from asignaturas where id_asignaturas=$key");                
                $query = "update asignaturas set id_profesores = ".$_SESSION['us_id'] ." where nombre = '".$name[0] ."'";
                if(!mysqli_query($this->con, $query))
                    return -17;
            }
            return 5;
            }
        }

}

class ALUMNO extends LOGIN{
    use USUARIO;
    public $id;    
    function __construct($id, $datos = NULL, $data = NULL) {
        $this->data = $data;
        $this->datos = (is_null($datos)) ? ['contrasena', 'newPsswrd1', 'newPsswrd2'] : $datos;
        $this->id = $id;
        $this->contTabla = ['alumnos', 'id_alumnos'];        
    }    
}

class PROFESOR extends LOGIN{
    use USUARIO, DOCENTES;
     public $id;    
    function __construct($id, $datos = NULL, $data = NULL) {
        $this->data = $data;                
        $this->datos = (is_null($datos)) ? ['contrasena', 'newPsswrd1', 'newPsswrd2'] : $datos;
        $this->id = $id;        
        $this->contTabla = ['profesores', 'id_profesores'];        
    }
}

class SYSTEM extends LOGIN{
    use USUARIO;
    function __construct($id = null, $c= null, $data = null, $datos = null){        
        $this->id = $id;
        $this->campus = $c;        
        $this->contTabla = $this->selectTable();
        $this->data = $data;        
        $this->datos = $datos;        
    }

    private function createDir($myFlag = true){
        global $forviden;
        $hoy = getdate();
        $name = $this->getDates($this->contTabla, $this->id, ['nombre']);
        $tmp = $hoy['weekday'] . $hoy['yday'] . $hoy['month'];
        $tmp = md5($tmp);        
        $_SESSION['folder'] = $tmp;
        $path = '../'.$tmp;        
        if (!is_dir($path)){
            mkdir($path, 0700);
            $file = fopen("$path/index.html", 'w');
            fputs($file, $forviden);            
            fclose($file);
            $this->delFolder();
            $file = fopen("../files/name.txt", 'w');
            fputs($file, $tmp);            
            fclose($file);
         }
        if ($myFlag)
            $path .= "/" .md5($name);        
        else
            $path .= "/" .$this->data['asignatura'];
        if (!is_dir($path))
            return  (mkdir($path, 0700)) ?  $path : false;
        else
            return $path;
    }
    
    private function moveFile($path, $uri) {
        return (copy($uri, $path)) ? 'true': 'false';
    }
        
    public function getAsignatura() {
        /*Obtener la asignatura*/
        $toReturn = '';
        $asig = $this->data['asignatura'];
        $query = "select uri_guia_docente FROM asignaturas where nombre = '$asig'";      
        $uri = $this->querys($query)[0];
        $path = $this-> createDir();
        $_SESSION['path'] = $path;
        $path .= "/$uri";
        $this-> moveFile($path, "../files/guias/".$uri);
        $path = substr($path, 3);
        $toReturn .= (isset($path)) ? $path: -15 ;
        $toReturn.= '*';        
        /*Obtener el color*/
        if ($this->contTabla[0] == 'alumnos'){
                $toReturn .=$this->selectColor().'*';                
                /*Obtener el la lista de asignaturas*/
                $toReturn .=$this->showAsignaturas() .'*';   
                /*Obtener datos de la asignatura*/
                $toReturn .= $this->getDatesAsign() .'*';
                /*Obtener las notificaciones*/
                $toReturn .= $this->getNotificaciones() . '*';
                $toReturn .= $this->getDownload() . '*';
        }
        else {
          $toReturn .= $this->getWorks() . '*';   
        }
        $toReturn .= $this->campus;
        return $toReturn;
    }

    private function vaciarFolder($path) {        
        if (is_dir($path))
            $content = scandir($path);
        else
            return false;            
        foreach ($content as $key) {            
            if ($key == '.' || $key == '..')
                continue;
            if(is_dir($path."/".$key))
                $this->vaciarFolder($path."/".$key);
            elseif (is_file($path.'/'.$key)) 
                unlink($path.'/'.$key);
            else{
                return -16;
            }
        }
        rmdir($path);
        return true;
    }

    private function delFolder() {
            $nameFile = '../files/name.txt';
            if (is_file($nameFile))
                $file = fopen($nameFile, 'r');            
            else
                return;
            $name = fgets($file);            
            fclose($file);
            if ($name !== $_SESSION['folder']){                
                $this->vaciarFolder("../$name");  
            }
    }
    
    private function selectColor(){
        $contTabla = $this->selectTable();
        $grado = $this->getDates($contTabla, $this->id, ['grado']);        
        switch ($grado){
            case 'moda':
                $grado = '#d845ca';
                break;
            case 'grafico':                
                $grado = '#e81f41';
                break;
            case 'interiores':
                $grado = '#17c69c';
                break;
            case 'producto':
                $grado = '#17adc6';
                break;
            case 'videojuegos':
                $grado = '#24e81f';
                break;
            default: 
                $grado = '#FF1744';
                break;
        }
            return $grado;            

    }

    public function selectAsign() {                    
        if (!$this->con) $this-> checkConnect();         
            if(isset($this->data['grade'])){
                if ($this->data['grade'] == ''){
                    $query = "select grado from asignaturas inner join ".$this->contTabla[0]." on (asignaturas.".$this->contTabla[1]." = ".$this->contTabla[0].".".$this->contTabla[1].") group by grado";
                    $field = ['grado'];
                }
                else{
                    $query = "select asignaturas.nombre, asignaturas.curso from asignaturas inner join ".$this->contTabla[0]." on (asignaturas.".$this->contTabla[1]." = ".$this->contTabla[0].".".$this->contTabla[1].") where grado = '".$this->data['grade']."'";
                    $field = ['nombre', 'curso'];
                }
            }
        if (!isset($this->data['grade'])){
            if( $this->contTabla[0] == 'profesores') {
            $query = "select asignaturas.nombre, asignaturas.curso from asignaturas inner join ".$this->contTabla[0]." on (asignaturas.".$this->contTabla[1]." = ".$this->contTabla[0].".".$this->contTabla[1].")";
            $field = ['nombre', 'curso'];
            }
            elseif( $this->contTabla[0] == 'alumnos') {
                $query = "select nombre from asignaturas inner join matriculaciones on asignaturas.id_asignaturas = matriculaciones.id_asignaturas where id_alumnos = ".$this->id ." order by nombre";
                $field = ['nombre'];
            }
        }

        $check = mysqli_query($this->con, $query);
        $dates = '';
        while ($fila = mysqli_fetch_assoc($check)) {
            foreach ($field as $key) {
             $dates .= $fila[$key]."_";
            }
            $dates .= ",";
        }
        return $dates;
    }

    private function showAsignaturas() {
        $toReturn = '';
        $asignaturas = $this->selectAsign();        
        $asignaturas = substr(str_replace('_,', ',', $asignaturas), 0,-1);
        $query = "select profesores.nombre, apellidos, email from profesores inner join asignaturas on  asignaturas.id_profesores = profesores.id_profesores where asignaturas.nombre = '".$this->data['asignatura']."' group by profesores.nombre";
        
        $files = ['nombre', 'apellidos', 'email'];
        $nombreProf =  $this->querys($query, $files);        
        $nameProf = '';
        for ($i=0; $i< 3; $i++){
            $nameProf .= $nombreProf[$i].",";            
        }
        
        $toReturn .= "$asignaturas"."*". substr($nameProf, 0,-1);                
        return $toReturn;
        
    }
    private function getDatesAsign() {
        $query = "select asistencia from matriculaciones inner join alumnos on alumnos.id_alumnos = matriculaciones.id_alumnos where alumnos.id_alumnos = $this->id";        
        $note = $this->querys($query)[0];
        return $note;        
    }

    private function getNotificaciones(){
        $query = "select mensaje, asignaturas.nombre from notificaciones inner join asignaturas on asignaturas.id_profesores = notificaciones.id_profesores inner join matriculaciones on matriculaciones.id_asignaturas = asignaturas.id_asignaturas where matriculaciones.id_alumnos = ".$this->id." order by id_notificaciones desc limit 3";
        $field = ['mensaje','nombre'];
        $not = $this->querys($query, $field);
        $toReturn = '';                
        for ($i =0; $i < count($not); $i++){
            if ($i %2 == 0)
                $toReturn .= $not[$i] . ",";
            else
                $toReturn .= $not[$i] . "_";
                
        }

        $query = "select mensaje, asignaturas.nombre from notificaciones inner join asignaturas on asignaturas.id_profesores = notificaciones.id_profesores inner join matriculaciones on matriculaciones.id_asignaturas = asignaturas.id_asignaturas where matriculaciones.id_alumnos = ".$this->id." and asignaturas.nombre = '".$this->data['asignatura']."' order by id_notificaciones desc limit 10";        
        $not = $this->querys($query);
        $toReturn2 = '';
        for ($i =0; $i < count($not); $i++){            
                $toReturn2 .= $not[$i] . ",";
        }
        return substr($toReturn, 0,-1) .'*'. substr($toReturn2, 0,-1);
    }

    public function selectkAllAsign() {
        if (!$this->con) $this->checkConnect();                
        $query =  ($this->campus == 'alumnos') ? 
        "select curso, id_asignaturas, nombre  from asignaturas where grado = '". $this->data['grado'] ."' group by nombre order by curso" : 
        "select curso, id_asignaturas, nombre from asignaturas group by nombre order by grado, curso";
        $asignaturas = ($this->campus == 'alumnos') ? $this->querys($query, ['curso', 'id_asignaturas','nombre']) : 
        $this->querys($query, ['curso', 'id_asignaturas','nombre']);

        if ($this->campus == 'alumnos') {
            $curso = ['1.1', ''];
            $toReturn= '';
            foreach ($asignaturas as $key) {

                if (intval($key) !== 0){
                    if (!strpos($key, '.')){
                        $toReturn .= "$key%";
                    }
                    else{
                        $curso[1] = $key;
                        if ($curso[0] !== $curso[1]){
                            $curso[0] = $curso[1];
                            $toReturn .= "¿";                        
                        }
                    }
                }
                else{
                    $toReturn .= "$key,";                    
                }
            }            
        }
        else {
            $curso = ['1.1', ''];
            $toReturn= '';
            $i = 0;
            foreach ($asignaturas as $key) {            
                if($i %36 == 0){
                    $toReturn .= "*";
                    $curso[0] = '1.1';
                }
                else{
                    if (intval($key) !== 0){
                        if (!strpos($key, '.')){
                            $toReturn .= "$key%";
                        }
                        else{
                            $curso[1] = $key;
                            if ($curso[0] !== $curso[1]){
                                $curso[0] = $curso[1];
                                $toReturn .= "_$key|";                    
                            }
                        }
                    }
                    else{
                        $toReturn .= "$key,";                    
                    }
                }                
                $i++;
            }
        }
        if ($this->data['grado'])            
            return $toReturn . "/".$this->data['grado'];
        else 
            return $toReturn;

    }

    private function getDownload(){
        $toReturn = '';
        $asig = $this->data['asignatura'];
        $query = "select uri from recursos_subida where nombre = '$asig'";
        $uri = $this->querys($query)[0];
        $path = $this-> createDir();
        $_SESSION['path'] = $path;
        $name = explode("/", $uri);        
        $path .= $name[count($name)-1];        
        $this-> moveFile($path, $uri);        
        $path = substr($path, 3);
        $toReturn .= (isset($path)) ? $path: -15 ;
        $toReturn.= '*';
        return $toReturn;
    }

    private function getWorks(){
        $path = $this->createDir(false);
        $query = "select uri from trabajos_subida where id_destinatario = ".$this->id;
        $uris = $this->querys($query);
        foreach ($uris as $k) { 
            $name = explode("/", $k);
            $name = "/".$name[count($name)-1];                                   
            $this->moveFile($path.$name, $k);
        }
        return $this-> createZip($path);
    }

    private function createZip($path) {
        $f = array_diff(scandir($path), ['.', '..']);        
        $zip = new ZipArchive;
        $zipname = 'descargas.zip';
        $zip->open($zipname, ZIPARCHIVE::CREATE);
        foreach ($f as $file) {
            $zip->addFile("$path/$file", $file);                        
        }
        $zip->close();
        $rutaFinal = "../descargas";
        if(!is_dir($rutaFinal))
            mkdir($rutaFinal);
        rename($zipname, "$rutaFinal/$zipname");
        return substr("$rutaFinal/$zipname", 3);
    }
}

function toFor($arr) {
    echo "Inicio toFor<br>\n";    
    foreach ((array)$arr as $key) {
        echo "$key, ";
    }
    echo "Fin toFor<br>\n";
}

function toForKey($arr) {
 echo "Inicio toForKey<br>\n";    
    foreach ((array)$arr as $key => $value) {
        echo "$key: $value\n";        
    }
    
    echo "Fin toForKey<br>\n";   
}


?>