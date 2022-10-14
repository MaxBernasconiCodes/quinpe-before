<? include($_SESSION["NivelArbol"]."Codigo/Seguridad.php");


//copia 
$resultadocopy=copy($_FILES['archivo']['tmp_name'], $dirdestino.$nombrearchivo);

//inserta
if($resultadocopy){ 
    $rs=mysql_query($query,$conn);
}else{GLO_feedback(35);}//el copy no funciono	
?>