<? 

include("../Codigo/Seguridad.php");include("../Codigo/Config.php");include("../Codigo/Funciones.php");include("zFunciones.php");$_SESSION["NivelArbol"]="../";

//perfiles

if ($_SESSION["IdPerfilUser"]!=1 and $_SESSION["IdPerfilUser"]!=2 and $_SESSION["IdPerfilUser"]!=4 and $_SESSION["IdPerfilUser"]!=7 and $_SESSION["IdPerfilUser"]!=3  and $_SESSION["IdPerfilUser"]!=11  and $_SESSION["IdPerfilUser"]!=12  and $_SESSION["IdPerfilUser"]!=9 and $_SESSION["IdPerfilUser"]!=14 ){ header("Location:".$_SESSION["NivelArbol"]."Inicio.php");}





if (isset($_POST['CmdAceptar'])){

	$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);

	$ident=intval($_POST['TxtNroEntidad']);//orden

	if (empty($_POST['TxtFecha'])){$fecha="0000-00-00";}else{$fecha=FechaMySql($_POST['TxtFecha']);}	

	$pdte=intval($_POST['ChkPdte']);

	$id=intval($_POST['TxtNumero']);//accion

	//actualizo

	$query="UPDATE pedidosrepreq set FFin='$fecha',Pdtes=$pdte Where Id=".intval($_POST['TxtNumero']);$rs=mysql_query($query,$conn);

	if ($rs){REP_updateestadoaccion($conn,$id,$ident,0);	

	}else{GLO_feedback(2);} 

	mysql_close($conn); 	

	//limpiar datos del form anterior

	foreach($_POST as $key => $value){$_SESSION[$key] = "";}

	header("Location:ModificarReq.php?id=".intval($_POST['TxtNumero'])."&Flag1=True");

}













elseif (  isset($_POST['CmdSalir']) ){

foreach($_POST as $key => $value){$_SESSION[$key] = "";}

header("Location:ModificarReq.php?id=".intval($_POST['TxtNumero'])."&Flag1=True");

}





?>





