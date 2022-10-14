<? include("../Codigo/Seguridad.php") ; $_SESSION["NivelArbol"]="../";include("../Codigo/Funciones.php");?>


<? include ("../Codigo/HeadFull.php");?>
<link rel="STYLESHEET" type="text/css" href="../CSS/Estilo.css" >
<? GLO_bodyform('',0,0); 
GLO_formform('Formulario','zManual.php',0,0,0);
include ("../Codigo/BannerManual.php");
GLO_tituloypath(0,650,'../Reparaciones/Solicitudes.php','','linksalir');
?>



<table width="100%" border="0"  cellpadding="0" cellspacing="0"  >
<tr> <td height="5"></td></tr>
<tr><td>

<? 
switch (intval($_SESSION[TxtIdManual])) { 
case 0:
	include("zInicio.php");break;
case 2:
	include("zCircuito.php");break;
case 3:
	include("zSolicitudes.php");break;
case 4:
	include("zOrdenes.php");break;
case 5:
	include("zPlanilla.php");break;
case 6:
	include("zAcciones.php");break;
case 8:
	include("zTareas.php");break;
case 9:
	include("zInsumos.php");break;
}


$_SESSION[TxtIdManual]='';
GLO_Hidden('TxtIdManual',0);
?>

</td></tr></table>

<? 
GLO_cierratablaform();
include ("../Codigo/FooterConUsuario.php");
?>