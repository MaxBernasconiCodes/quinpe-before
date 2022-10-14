<? include($_SESSION["NivelArbol"]."Codigo/Seguridad.php");



if(intval($_SESSION['TxtNumero'])!=0){
    DES_TablaUnidadesP($_SESSION['TxtNumero'],$conn,$esdespacho,0);//propios
    DES_TablaUnidadesT($_SESSION['TxtNumero'],$conn,$esdespacho,0);//terceros
}

?>