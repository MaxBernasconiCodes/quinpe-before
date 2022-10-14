<? include("../Codigo/Seguridad.php");include("../Codigo/Config.php");include("../Codigo/Funciones.php");$_SESSION["NivelArbol"]="../";require_once('../Codigo/calendar/classes/tc_calendar.php');
//perfiles
GLO_PerfilAcceso(14);
//get
GLO_ValidaGET($_GET['Id'],0,0);
//si no tiene cargados responsables
if (intval($_SESSION["GLO_IdPersCON"])==0 or intval($_SESSION["GLO_IdPersAPR"])==0){header("Location:".$_SESSION["NivelArbol"]."Inicio.php");}

$_SESSION['TxtPath']=str_pad(intval($_GET['Id']), 5, "0", STR_PAD_LEFT);
$_SESSION['TxtNumero']=intval($_GET['Id']);



?> 
<? include ("../Codigo/HeadFull.php");?>
<link rel="STYLESHEET" type="text/css" href="../CSS/Estilo.css" >
<? GLO_bodyform('',0,0);?>
<? include ("../Codigo/BannerPopUp.php");?>

<form name="Formulario" action="zAltaCopia.php" method="post" >
<?php GLO_tituloypath(950,600,'sgi','DISTRIBUCION COPIAS','salir'); ?>

<table width="600" border="0"  cellspacing="0" class="Tabla" >
<tr> <td width="100" height="5"  ></td> <td width="500"></td> </tr>
<tr> <td height="18" align="right"  >Documento:</td><td  valign="top" > &nbsp; <input  name="TxtPath" type="text"  readonly="true"  class="TextBoxRO"   value="<? echo $_SESSION['TxtPath'];?>" style="text-align:right;width:50px"></td></tr>
<tr> <td   align="right"  valign="top" >&nbsp;Cantidad:</td><td  valign="top" > &nbsp; <input name="TxtCant" type="text"  class="TextBox"  maxlength="2"  value="<? echo $_SESSION['TxtCant']; ?>" onChange="this.value=validarEntero(this.value);" style="width:65px"><label class="MuestraError"> * </label></td></tr>
<tr> <td   align="right"  valign="top" >&nbsp;Entregadas:</td><td  valign="top" >&nbsp;  <input name="TxtFechaA" id="TxtFechaA"  type="text" class="TextBox"  style="width:65px" maxlength="10"  onchange="this.value=validarFecha(this.value);" value="<? echo $_SESSION['TxtFechaA']; ?>"   >
<? calendario("TxtFechaA","../Codigo/","actual") ?><label class="MuestraError"> * </label></td></tr>
<tr> <td   align="right"  valign="top" >&nbsp;Retiradas:</td><td  valign="top" >&nbsp;  <input name="TxtFechaB" id="TxtFechaB"  type="text" class="TextBox"  style="width:65px" maxlength="10"  onchange="this.value=validarFecha(this.value);" value="<? echo $_SESSION['TxtFechaB']; ?>"   >
<? calendario("TxtFechaB","../Codigo/","actual") ?></td></tr>
<tr> <td   align="right"  valign="top" >&nbsp;Observaciones:</td><td  valign="top" > &nbsp; <input name="TxtObs" type="text"  class="TextBox" style="width:450px" maxlength="100"  value="<? echo $_SESSION['TxtObs']; ?>"><input  name="TxtNumero" type="hidden" value="<? echo $_SESSION['TxtNumero']; ?>"></td></tr>
</table>
<? GLO_botonesform("600",0,2); ?> 
<? GLO_mensajeerror(); ?>

<? //limpia las var de session
$_SESSION['TxtNumero'] ="";
$_SESSION['TxtPath'] ="";
$_SESSION['CbCentro'] ="";
$_SESSION['TxtCant'] ="";
$_SESSION['TxtFechaA'] ="";
$_SESSION['TxtFechaB'] ="";
$_SESSION['TxtObs'] ="";
?>			
<? GLO_cierratablaform(); ?>
				

<? include ("../Codigo/FooterConUsuario.php");?>