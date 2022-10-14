<? include($_SESSION["NivelArbol"]."Codigo/Seguridad.php");

$fa=GLO_FechaMySql($_POST['TxtFechaA']);
$hora=$_POST['TxtHora'];if($hora==''){$hora='00:00';}
$hora2=$_POST['TxtHora2'];if($hora2==''){$hora2='00:00';}
//
$cli=intval($_POST['CbCliente']); 
$tipo=intval($_POST['CbTipo']);
$servicio=intval($_POST['CbServicio']); 
//
$med=intval($_POST['CbMedio']);
$rec=intval($_POST['CbPersonal']);
$rto=intval($_POST['TxtRto']);
//
$fb=GLO_FechaMySql($_POST['TxtFechaB']);
$con=mysql_real_escape_string($_POST['TxtContacto']);
$cf=mysql_real_escape_string($_POST['TxtCliente']);
$loc=mysql_real_escape_string($_POST['TxtUbic']);

//
$obs=mysql_real_escape_string($_POST['TxtObs']);
//
$id=intval($_POST['TxtNumero']);


//insert 1/update 2
if($tipocambio==1){
    //genera solicitud (estado 0 abierto)
    $nroId=GLO_generoID('procesosop',$conn);
    $query="INSERT INTO procesosop (Id,Fecha,IdCliente,Estado) VALUES ($nroId,'$fa',$cli,0)";
    $rs=mysql_query($query,$conn);
    if ($rs){
        $padre=$nroId;//Solicitud
        //inserta
        $nroId=GLO_generoID("despacho",$conn);
        $query="INSERT INTO despacho (Id,IdCliente,IdPadre,Fecha,Hora,IdTipo,Obs,FechaEP,HoraEP,Medio,IdPersonal,Contacto,CliFinal,Loc,IdEstado,IdEstadoP,Rto,IdServicio) VALUES ($nroId,$cli,$padre,'$fa','$hora',$tipo,'$obs','$fb','$hora2',$med,$rec,'$con','$cf','$loc',1,1,$rto,$servicio)"; 
        $rs=mysql_query($query,$conn);
        if ($rs){GLO_feedback(1);$grabook=1;}else{GLO_feedback(2);$grabook=0;}         
    }else{GLO_feedback(2);} 
}else{
    $query="UPDATE despacho set Fecha='$fa',Hora='$hora',IdTipo=$tipo,Obs='$obs',FechaEP='$fb',HoraEP='$hora2',Medio=$med,IdPersonal=$rec,Contacto='$con',CliFinal='$cf',Loc='$loc',Rto=$rto,IdServicio=$servicio Where Id=$id";
    /*//sacar comentario   
     $query="UPDATE despacho set Fecha='$fa',Hora='$hora',IdTipo=$tipo,Obs='$obs',FechaEP='$fb',HoraEP='$hora2',Medio=$med,IdPersonal=$rec,Contacto='$con',CliFinal='$cf',Loc='$loc',Rto=$rto Where Id=$id";
    */
    $rs=mysql_query($query,$conn);
    if ($rs){GLO_feedback(1);}else{GLO_feedback(2);} 
}

?>