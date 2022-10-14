<? include("../Codigo/Seguridad.php");include("../Codigo/Config.php");include("../Codigo/Funciones.php");$_SESSION["NivelArbol"]="../";
//perfiles
GLO_PerfilAcceso(14);
//get
GLO_ValidaGET($_GET['Id'],0,0);

$_SESSION['TxtNroEntidad']=$_GET['Id'];
$_SESSION['TxtTipo'] =$_GET['IdTipo'];

$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);
?> 

<? include ("../Codigo/HeadFull.php");?>
<link rel="STYLESHEET" type="text/css" href="../CSS/Estilo.css" >

<? GLO_bodyform('',0,0);?>
<? include ("../Codigo/BannerPopUp.php");?>


<form name="Formulario" action="zAltaAuditado.php" method="post" onKeyPress="if (event.which == 13 || event.keyCode == 13){return false;}">
<?php GLO_tituloypath(950,500,'sgi','AUDITADO','salir'); ?>

<table width="500" border="0"   cellspacing="0" class="Tabla" >
<tr> <td width="100" height="5"  ></td> <td width="400"></td> </tr>
<tr> <td   align="right"  valign="top" >&nbsp;Auditado:</td><td  valign="top" > &nbsp; <select name="CbPersonal"  style="width:300px" class="campos" id="CbPersonal" ><option value=""></option> <? ComboPersonalRFX("CbPersonal",$conn); ?> </select>
</td>					</tr>
</table>


<? 
GLO_Hidden('TxtNroEntidad',0);GLO_Hidden('TxtNumero',0);GLO_Hidden('TxtTipo',0);
GLO_botonesform("500",0,2);
GLO_mensajeerror();
GLO_cierratablaform();
mysql_close($conn);
include ("../Codigo/FooterConUsuario.php");
?>