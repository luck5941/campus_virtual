<?php

define("HOST","localhost");

define("USER_DB","root");

define("PASSWD","");

define("NAME_DB","campusHola");

$con= mysqli_connect(HOST, USER_DB, PASSWD, NAME_DB);

if ($con)

	echo "todo ok <br>";


$asig = [

	[["nombre" =>"creativad", "curso" => 1.1,"grado"=> "grafico"],["nombre" =>"video", "curso" => 1.1,"grado"=>"grafico"],["nombre" =>"photoshop", "curso" => 1.1,"grado"=>"grafico"]],

	[["nombre" =>"creativad", "curso" => 1.2,"grado"=> "grafico"],["nombre" =>"video", "curso" => 1.2,"grado"=>"grafico"],["nombre" =>"photoshop", "curso" => 1.2,"grado"=>"grafico"]],

	[["nombre" =>"color", "curso" => 2.1,"grado"=> "grafico"],["nombre" =>"dibujo", "curso" => 2.1,"grado"=>"grafico"],["nombre" =>"packaging", "curso" => 2.1,"grado"=>"grafico"]],

	[["nombre" =>"color", "curso" => 2.2,"grado"=> "grafico"],["nombre" =>"dibujo", "curso" => 2.2,"grado"=>"grafico"],["nombre" =>"packaging", "curso" => 2.2,"grado"=>"grafico"]],

	[["nombre" =>"editorial", "curso" => 3.1,"grado"=> "grafico"],["nombre" =>"comic", "curso" => 3.1,"grado"=>"grafico"],["nombre" =>"historia_arte", "curso" => 3.1,"grado"=>"grafico"]],

	[["nombre" =>"editorial", "curso" => 3.2,"grado"=> "grafico"],["nombre" =>"comic", "curso" => 3.2,"grado"=>"grafico"],["nombre" =>"historia_arte", "curso" => 3.2,"grado"=>"grafico"]],

	[["nombre" =>"publicidad", "curso" => 4.1,"grado"=> "grafico"],["nombre" =>"legislacion", "curso" => 4.1,"grado"=>"grafico"],["nombre" =>"dibujo_tecnico", "curso" => 4.1,"grado"=>"grafico"]],

	[["nombre" =>"publicidad", "curso" => 4.2,"grado"=> "grafico"],["nombre" =>"legislacion", "curso" => 4.2,"grado"=>"grafico"],["nombre" =>"dibujo_tecnico", "curso" => 4.2,"grado"=>"grafico"]],

	[["nombre" =>"programacion", "curso" => 1.1,"grado"=> "videojuegos"],["nombre" =>"unity", "curso" => 1.1,"grado"=>"videojuegos"],["nombre" =>"animacion", "curso" => 1.1,"grado"=>"videojuegos"]],

	[["nombre" =>"programacion", "curso" => 1.2,"grado"=> "videojuegos"],["nombre" =>"unity", "curso" => 1.2,"grado"=>"videojuegos"],["nombre" =>"animacion", "curso" => 1.2,"grado"=>"videojuegos"]],

	[["nombre" =>"modelado", "curso" => 2.1,"grado"=> "videojuegos"],["nombre" =>"infografia", "curso" => 2.1,"grado"=>"videojuegos"],["nombre" =>"cinema", "curso" => 2.1,"grado"=>"videojuegos"]],

	[["nombre" =>"modelado", "curso" => 2.2,"grado"=> "videojuegos"],["nombre" =>"infografia", "curso" => 2.2,"grado"=>"videojuegos"],["nombre" =>"cinema", "curso" => 2.2,"grado"=>"videojuegos"]],

	[["nombre" =>"programacion_avanzada", "curso" => 3.1,"grado"=> "videojuegos"],["nombre" =>"personajes", "curso" => 3.1,"grado"=>"videojuegos"],["nombre" =>"ilustracion", "curso" => 3.1,"grado"=>"videojuegos"]],

	[["nombre" =>"programacion_avanzada", "curso" => 3.2,"grado"=> "videojuegos"],["nombre" =>"personajes", "curso" => 3.2,"grado"=>"videojuegos"],["nombre" =>"ilustracion", "curso" => 3.2,"grado"=>"videojuegos"]],

	[["nombre" =>"guion", "curso" => 4.1,"grado"=> "videojuegos"],["nombre" =>"prototipo", "curso" => 4.1,"grado"=>"videojuegos"],["nombre" =>"desarrollo", "curso" => 4.1,"grado"=>"videojuegos"]],

	[["nombre" =>"guion", "curso" => 4.2,"grado"=> "videojuegos"],["nombre" =>"prototipo", "curso" => 4.2,"grado"=>"videojuegos"],["nombre" =>"desarrollo", "curso" => 4.2,"grado"=>"videojuegos"]],

	[["nombre" =>"patronaje", "curso" => 1.1,"grado"=> "moda"],["nombre" =>"medidas", "curso" => 1.1,"grado"=>"moda"],["nombre" =>"historia_moda", "curso" => 1.1,"clase"=>"moda"]],

	[["nombre" =>"patronaje", "curso" => 1.2,"grado"=> "moda"],["nombre" =>"medidas", "curso" => 1.2,"grado"=>"moda"],["nombre" =>"historia_moda", "curso" => 1.2,"clase"=>"moda"]],

	[["nombre" =>"fotografia", "curso" => 2.1,"grado"=> "moda"],["nombre" =>"zapatos", "curso" => 2.1,"grado"=>"moda"],["nombre" =>"pantalones", "curso" => 2.1,"clase"=>"moda"]],

	[["nombre" =>"fotografia", "curso" => 2.2,"grado"=> "moda"],["nombre" =>"zapatos", "curso" => 2.2,"grado"=>"moda"],["nombre" =>"pantalones", "curso" => 2.2,"clase"=>"moda"]],

	[["nombre" =>"tendencia", "curso" => 3.1,"grado"=> "moda"],["nombre" =>"pasarela", "curso" => 3.1,"grado"=>"moda"],["nombre" =>"sombreros", "curso" => 3.1,"clase"=>"moda"]],

	[["nombre" =>"tendencia", "curso" => 3.2,"grado"=> "moda"],["nombre" =>"pasarela", "curso" => 3.2,"grado"=>"moda"],["nombre" =>"sombreros", "curso" => 3.2,"clase"=>"moda"]],

	[["nombre" =>"textiles", "curso" => 4.1,"grado"=> "moda"],["nombre" =>"estampados", "curso" => 4.1,"grado"=>"moda"],["nombre" =>"complementos", "curso" => 4.1,"clase"=>"moda"]],

	[["nombre" =>"textiles", "curso" => 4.2,"grado"=> "moda"],["nombre" =>"estampados", "curso" => 4.2,"grado"=>"moda"],["nombre" =>"complementos", "curso" => 4.2,"clase"=>"moda"]],

];


/*
$files = "";

$values = "";



for ($i = 0; $i< count($asig); $i++){

	for ($n = 0; $n< count($asig[$i]); $n++){

		$values .= "(";

		foreach ($asig[$i][$n] as $key => $value) {

			$values .= "'$value', ";	

		}		

		$values .= ")";

	}

}

$files = "nombre, curso, grado";

$query  = "insert into asignaturas ($files) values $values";

$values = str_replace(", )", "), ", $values);

$values = substr($values, 0,-2);

$query  = "insert into asignaturas ($files) values $values";

// echo $query;

if (mysqli_query($con, $query))

	echo "Well done!!!";

else

	echo "something was wrong";
*/

$f = mysqli_query($con, "select nombre from asignaturas");
while($fila = mysqli_fetch_assoc($f)){
	if(!mysqli_query($con, "update asignaturas set uri_guia_docente = 'guia_".$fila['nombre'].".pdf' where nombre= '".$fila['nombre']."'"))
		echo "update asignaturas set uri_guia_docente = 'guia_".$fila['nombre'].".pff' where nombre= '".$fila['nombre']."'\n";

}



/*

$n = 5;

$s = ($n == 3) ? "hola" : "mundo" : "casa";

echo $s;

*/

?>