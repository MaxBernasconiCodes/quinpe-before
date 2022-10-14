<? if ($_SESSION["IdPerfilUser"]!=1 and $_SESSION["IdPerfilUser"]!=2  and $_SESSION["IdPerfilUser"]!=3  and $_SESSION["IdPerfilUser"]!=9 and $_SESSION["IdPerfilUser"]!=14){ header("Location:".$_SESSION["NivelArbol"]."Inicio.php");}


$tipoincidente='';


if($row['C2']==1){
    $tipoincidente=$tipoincidente.'1) Incidentes sin lesion con perdida de materiales, ';
}

if($row['C1']==1){
    $tipoincidente=$tipoincidente.'2) Incidentes con lesion sin perdida de dias. Se reintegra al trabajo en menos de 48hs, ';
}

if($row['C4']==1){
    $tipoincidente=$tipoincidente.'3) Incidentes con lesion con perdidas de dias, debe ausentarse por mas de 48hs a la actividad laboral, ';
}

if($row['C5']==1){
    $tipoincidente=$tipoincidente.'4) Incidentes con lesion donde el operador sufre una incapacidad permanente o fatalidad, ';
}

if($row['C3']==1){
    $tipoincidente=$tipoincidente.'5) Todo derrame no contenidos, sin importar su estado de agregacion ';
}

?>