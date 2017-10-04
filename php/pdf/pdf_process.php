<?php

include '../class.php';
require('fpdf.php');

$genPdf = new SYSTEM();
$genPdf->checkConnect();
$check = $genPdf->querys("select nombre from asignaturas");

$values = '';


/*
foreach ($check as $key) {
    if(!mysqli_query($genPdf->con, "update asignaturas set uri_guia_docente = 'guia_$key.pdf' where nombre = '$key'"))
        echo "error";
    echo "update asignaturas set uri_guia_docente = 'guia_$key' where nombre = $key<br>";    
}

*/



// foreach($check as $key){
$key = 'creatividad';
    $pdf = new FPDF();
    $pdf->AddPage();
    $pdf->SetFont('Arial','B',16);    
    $pdf->Cell(40,10,"Guia docente $key");
    // echo $key;
    $pdf->Output('F',"../../files/guias/guia_$key.pdf");
    $pdf->Close();
// }




?>