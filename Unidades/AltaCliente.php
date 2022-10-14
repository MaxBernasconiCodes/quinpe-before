<? include("../Codigo/Seguridad.php");include("../Codigo/Config.php");include("../Codigo/Funciones.php");$_SESSION["NivelArbol"]="../";require_once('../Codigo/calendar/classes/tc_calendar.php');
//perfiles
if ($_SESSION["IdPerfilUser"]!=1 and $_SESSION["IdPerfilUser"]!=2 and $_SESSION["IdPerfilUser"]!=4 and $_SESSION["IdPerfilUser"]!=7 and $_SESSION["IdPerfilUser"]!=3  and $_SESSION["IdPerfilUser"]!=11  and $_SESSION["IdPerfilUser"]!=12  and $_SESSION["IdPerfilUser"]!=9 and $_SESSION["IdPerfilUser"]!=14 and $_SESSION["IdPerfilUser"]!=13){ header("Location:".$_SESSION["NivelArbol"]."Inicio.php");}
//get
GLO_ValidaGET($_GET['Id'],0,0);

$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);

$_SESSION['TxtNroEntidad'] = str_pad($_GET['Id'], 6, "0", STR_PAD_LEFT);





?> 


<? include ("../Codigo/HeadFull.php");?>
<link rel="STYLESHEET" type="text/css" href="../CSS/Estilo.css" >
</head>



<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="document.forms['Formulario']['CbCliente'].focus()">
<? include ("../Codigo/BannerPopUp.php");?>


<form name="Formulario" action="zAltaCliente.php" method="post" onKeyPress="if (event.which == 13 || event.keyCode == 13){return false;}">
<? GLO_tituloypath(0,600,'','HABILITACION EN CLIENTE','salir'); ?>


<table width="600" border="0"  cellspacing="0" class="Tabla" >
<tr><td width="100" height="3"  ></td>  <td width="500"></td></tr>
<tr><td height="18"  align="right"  >Cliente:</td><td  valign="top" >&nbsp;<select name="CbCliente" style="width:300px" class="campos" id="CbCliente"  tabindex="1" ><option value=""></option> <? GLO_ComboActivo("clientes","CbCliente","Nombre","","",$conn); ?> </select><label class="MuestraError"> * </label></td></tr>
<tr><td height="18"  align="right"  >Alta:</td><td  valign="top" >&nbsp;<input name="TxtFechaA" id="TxtFechaA"   type="text" class="TextBox"  style="width:70px;" maxlength="10" tabindex="2" onChange="this.value=validarFecha(this.value);" value="<? echo $_SESSION[TxtFechaA]; ?>"      ><?php  calendario("TxtFechaA","../Codigo/","actual"); ?><label class="MuestraError"> * </label></td></tr>
<tr><td height="18"  align="right"  >Baja:</td><td  valign="top" >&nbsp;<input name="TxtFechaB" id="TxtFechaB"   type="text" class="TextBox"  style="width:70px;" maxlength="10" tabindex="3" onChange="this.value=validarFecha(this.value);" value="<? echo $_SESSION[TxtFechaB]; ?>"      ><?php  calendario("TxtFechaB","../Codigo/","actual"); ?></td></tr>
</table>


<?
GLO_Hidden('TxtNroEntidad',0);GLO_Hidden('TxtNumero',0);
GLO_obsform(600,100,'Observaciones','TxtObs',3,0);
GLO_botonesform(600,0,2);
GLO_mensajeerror();
GLO_cierratablaform();
mysql_close($conn);
include ("../Codigo/FooterConUsuario.php"); 
?>