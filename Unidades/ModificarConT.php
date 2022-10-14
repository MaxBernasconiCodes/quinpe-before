<? include("../Codigo/Seguridad.php");include("../Codigo/Config.php");include("../Codigo/Funciones.php");$_SESSION["NivelArbol"]="../";require_once('../Codigo/calendar/classes/tc_calendar.php');
//perfiles
if ($_SESSION["IdPerfilUser"]!=1 and $_SESSION["IdPerfilUser"]!=2){ header("Location:".$_SESSION["NivelArbol"]."Inicio.php");}
//get
GLO_ValidaGET($_GET['item'],0,0);

$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);
$query="SELECT * From unidades_cont where Id<>0 and Id=".intval($_GET['item']); $rs=mysql_query($query,$conn);$row=mysql_fetch_array($rs);
if(mysql_num_rows($rs)!=0){
	$_SESSION['TxtNumero'] =$row['Id'];
	$_SESSION['TxtNroEntidad']=str_pad($row['IdEntidad'], 6, "0", STR_PAD_LEFT);
	$_SESSION['TxtImporte'] = GLO_MostrarImporte($row['Importe']);
	$_SESSION['CbMoneda'] = $row['Moneda'];
	$_SESSION['TxtFechaA'] = GLO_FormatoFecha($row['FechaD']);
	$_SESSION['TxtFechaH'] = GLO_FormatoFecha($row['FechaH']);
	$_SESSION['TxtObs'] = $row['Obs'];
}mysql_free_result($rs);
mysql_close($conn); 







?> 


<? include ("../Codigo/HeadFull.php");?>
<link rel="STYLESHEET" type="text/css" href="../CSS/Estilo.css" >

<? GLO_bodyform('',0,0);?>
<? include ("../Codigo/BannerPopUp.php");?>


<form name="Formulario" action="zModificarConT.php" method="post">
<? GLO_tituloypath(0,700,'','TARIFAS','salir'); ?>


<table width="700" border="0"  cellspacing="0" class="Tabla" >
<tr> <td width="100" height="5"  ></td> <td width="600"></td> </tr>
<tr> <td height="18"  align="right"  >&nbsp;Desde:</td><td> &nbsp; <input name="TxtFechaA" id="TxtFechaA"  type="text" class="TextBoxRO"  style="width:70px" value="<? echo $_SESSION['TxtFechaA']; ?>" ></td></tr>
<tr> <td height="18"  align="right"  >Hasta:</td><td> &nbsp; <input name="TxtFechaH" id="TxtFechaH"  type="text" class="TextBoxRO"  style="width:70px" value="<? echo $_SESSION['TxtFechaH']; ?>" ></td></tr>
<tr> <td height="18"  align="right"  >Tarifa:</td><td> &nbsp; <input name="TxtImporte" type="text"  class="TextBox" style="width:100px" maxlength="14"  value="<? echo $_SESSION['TxtImporte']; ?>" onChange="this.value=validarMoneda(this.value);">&nbsp; <select name="CbMoneda" style="width:80px" class="campos" id="CbMoneda" ><? ComboMoneda('CbMoneda') ?></select> &nbsp;<font class="comentario">Por favor utilice el formato 1.000,00</font></td></tr>
<tr><td height="18"  align="right"  >&nbsp;Observaciones:</td><td  valign="top" > &nbsp; <input name="TxtObs" type="text"  class="TextBox" style="width:550px" maxlength="200"  value="<? echo $_SESSION['TxtObs']; ?>"></td></tr>
</table>


<? 
GLO_Hidden('TxtNroEntidad',0);GLO_Hidden('TxtNumero',0);
GLO_botonesform(700,0,2);
GLO_mensajeerror();
GLO_cierratablaform();
include ("../Codigo/FooterConUsuario.php");
?>