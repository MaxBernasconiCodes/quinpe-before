<? include("../Codigo/Seguridad.php");include("../Codigo/Config.php");include("../Codigo/Funciones.php");$_SESSION["NivelArbol"]="../";require_once('../Codigo/calendar/classes/tc_calendar.php');
//perfiles
if ($_SESSION["IdPerfilUser"]!=1 and $_SESSION["IdPerfilUser"]!=2){ header("Location:".$_SESSION["NivelArbol"]."Inicio.php");}
//get
GLO_ValidaGET($_GET['Id'],0,0);

$_SESSION['TxtNroEntidad'] = str_pad($_GET['Id'], 6, "0", STR_PAD_LEFT);




?> 


<? include ("../Codigo/HeadFull.php");?>
<link rel="STYLESHEET" type="text/css" href="../CSS/Estilo.css" >

<? GLO_bodyform('',0,0);?>
<? include ("../Codigo/BannerPopUp.php");?>


<form name="Formulario" action="zAltaConT.php" method="post" >
<? GLO_tituloypath(0,700,'','TARIFAS','salir'); ?>


<table width="700" border="0"   cellspacing="0" class="Tabla" >
<tr> <td width="100" height="5"  ></td> <td width="600"></td> </tr>
<tr> <td height="18"  align="right"  >&nbsp;Desde:</td><td> &nbsp; <input name="TxtFechaA" id="TxtFechaA"  type="text" class="TextBox"  style="width:70px" maxlength="10"  onchange="this.value=validarFecha(this.value);" value="<? echo $_SESSION['TxtFechaA']; ?>" ><label class="MuestraError"> * </label><? calendario("TxtFechaA","../Codigo/","actual") ?></td></tr>
<tr> <td height="18"  align="right"  >Importe:</td><td> &nbsp; <input name="TxtImporte" type="text"  class="TextBox" style="width:100px" maxlength="14"  value="<? echo $_SESSION['TxtImporte']; ?>" onChange="this.value=validarMoneda(this.value);">&nbsp; <select name="CbMoneda" style="width:80px" class="campos" id="CbMoneda" ><? ComboMoneda('CbMoneda') ?></select> &nbsp;<font class="comentario">Por favor utilice el formato 1.000,00</font></td></tr>
<tr><td height="18"  align="right"  >&nbsp;Observaciones:</td><td  valign="top" > &nbsp; <input name="TxtObs" type="text"  class="TextBox" style="width:550px" maxlength="200"  value="<? echo $_SESSION['TxtObs']; ?>"></td></tr>
</table>


<? 
GLO_Hidden('TxtNroEntidad',0);GLO_Hidden('TxtNumero',0);
GLO_botonesform(700,0,2);
GLO_mensajeerror();
GLO_cierratablaform();
include ("../Codigo/FooterConUsuario.php");
?>