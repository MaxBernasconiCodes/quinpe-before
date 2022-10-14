<? include("../Codigo/Seguridad.php");include("../Codigo/Config.php");include("../Codigo/Funciones.php");$_SESSION["NivelArbol"]="../";require_once('../Codigo/calendar/classes/tc_calendar.php');
//perfiles
if ($_SESSION["IdPerfilUser"]!=1 and $_SESSION["IdPerfilUser"]!=2){ header("Location:".$_SESSION["NivelArbol"]."Inicio.php");}
//get
GLO_ValidaGET($_GET['Id'],0,0);

$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);

$_SESSION['TxtNroEntidad'] = str_pad($_GET['Id'], 6, "0", STR_PAD_LEFT);






?> 

<? include ("../Codigo/HeadFull.php");?>
<link rel="STYLESHEET" type="text/css" href="../CSS/Estilo.css" >
</head>

<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="document.forms['Formulario']['CbTipo'].focus()">
<? include ("../Codigo/BannerPopUp.php");?>


<form name="Formulario" action="zAltaCon.php" method="post" onKeyPress="if (event.which == 13 || event.keyCode == 13){return false;}">
<? GLO_tituloypath(0,700,'','CONTRATOS','salir'); ?>



<table width="700" border="0"   cellspacing="0" class="Tabla" >
<tr><td width="100" height="3"  ></td>  <td width="150"></td><td width="450"></td></tr>
<tr><td height="18"  align="right"  >Proveedor:</td><td  valign="top" colspan="2">&nbsp;<select name="CbProv" style="width:550px" class="campos" id="CbProv"  tabindex="1" ><option value=""></option> <? ComboProveedorRFX("CbProv","",$conn); ?> </select><label class="MuestraError"> * </label></td></tr>
<tr><td height="18"  align="right"  >Inicio:</td><td  valign="top" colspan="2">&nbsp;<input name="TxtFechaA" id="TxtFechaA"   type="text" class="TextBox"  style="width:70px;" maxlength="10" tabindex="1" onChange="this.value=validarFecha(this.value);" value="<? echo $_SESSION['TxtFechaA']; ?>"      ><label class="MuestraError"> * </label><?php  calendario("TxtFechaA","../Codigo/","actual"); ?></td></tr>
<tr><td height="18"  align="right"  >Fin:</td><td  valign="top" >&nbsp;<input name="TxtFechaB" id="TxtFechaB"   type="text" class="TextBox"  style="width:70px;" maxlength="10" tabindex="1" onChange="this.value=validarFecha(this.value);" value="<? echo $_SESSION['TxtFechaB']; ?>"      ><label class="MuestraError"> * </label><?php  calendario("TxtFechaB","../Codigo/","actual"); ?></td><td></td></tr>
<tr><td height="18"  align="right"  >Contrato:</td><td  valign="top" colspan="2">&nbsp;<input name="TxtNroCon" type="text"  tabindex="1"  class="TextBox" style="text-align:right;width:70px" maxlength="10"  value="<? echo $_SESSION['TxtNroCon']; ?>" onChange="this.value=validarEntero(this.value);" ><label class="MuestraError"> * </label></td></tr>
</table>



<?
GLO_Hidden('TxtNroEntidad',0);GLO_Hidden('TxtNumero',0);GLO_Hidden('TxtId',0);
GLO_obsform(700,100,'Observaciones','TxtObs',2,0);
GLO_botonesform(700,0,2);
GLO_mensajeerror(); ?>            

<? GLO_cierratablaform(); ?>

<? mysql_close($conn); 
$_SESSION['TxtNumero'] ="";
$_SESSION['TxtNroEntidad'] ="";
$_SESSION['CbProv'] ="";
$_SESSION['TxtFechaA'] ="";
$_SESSION['TxtFechaB'] ="";
$_SESSION['TxtNroCon'] ="";
$_SESSION['TxtObs'] ="";
?>			
				


<? include ("../Codigo/FooterConUsuario.php");?>