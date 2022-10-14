<? include("../Codigo/Seguridad.php") ;include("../Codigo/Config.php") ;include("../Codigo/Funciones.php");  $_SESSION["NivelArbol"]="../";require_once('../Codigo/calendar/classes/tc_calendar.php');include ("Includes/zFunciones.php");

//perfiles

if ($_SESSION["IdPerfilUser"]!=1 and $_SESSION["IdPerfilUser"]!=2 and $_SESSION["IdPerfilUser"]!=3 and $_SESSION["IdPerfilUser"]!=9 and $_SESSION["IdPerfilUser"]!=14 ){ header("Location:".$_SESSION["NivelArbol"]."Inicio.php");}

//get

GLO_ValidaGET($_GET['id'],0,0);



$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);



//mostrar campos

if ($_GET['Flag1']=="True"){

$query="SELECT i.* From inspecciones i where i.Id<>0 and i.Id=".intval($_GET['id']); 

$rs=mysql_query($query,$conn);

while($row=mysql_fetch_array($rs)){

	$_SESSION['TxtNumero'] = str_pad($row['Id'], 6, "0", STR_PAD_LEFT);

	$_SESSION['CbCentro'] = $row['IdCentro'];

	$_SESSION['CbYac'] = $row['IdYac'];

	$_SESSION['CbP1'] = $row['IdP1'];

	$_SESSION['CbP2'] = $row['IdP2'];

	$_SESSION['CbP3'] = $row['IdP3'];

	$_SESSION['TxtFechaA'] = FormatoFecha($row['Fecha']);if ($_SESSION['TxtFechaA']=='00-00-0000'){$_SESSION['TxtFechaA'] ="";}

	$_SESSION['TxtHora']=date("H:i",strtotime($row['Hora'])); if ($_SESSION['TxtHora']=='00:00'){$_SESSION['TxtHora']="";}

	$_SESSION['TxtObs'] = $row['Obs'];

	$_SESSION['TxtFoto'] = $row['Foto'];

	$_SESSION['CbU1'] = $row['IdU1'];

	$_SESSION['CbU2'] = $row['IdU2'];

	$_SESSION['CbU3'] = $row['IdU3'];

	$_SESSION['CbU4'] = $row['IdU4'];

	$_SESSION['CbU5'] = $row['IdU5'];

	$_SESSION['CbU6'] = $row['IdU6'];

	$_SESSION['CbU7'] = $row['IdU7'];

	$_SESSION['CbU8'] = $row['IdU8'];

	$_SESSION['CbEU1'] = $row['IdEU1'];

	$_SESSION['CbEU2'] = $row['IdEU2'];

	$_SESSION['CbEU3'] = $row['IdEU3'];

	$_SESSION['CbEU4'] = $row['IdEU4'];

	$_SESSION['CbEU5'] = $row['IdEU5'];

	$_SESSION['CbEU6'] = $row['IdEU6'];

	$_SESSION['CbEU7'] = $row['IdEU7'];

	$_SESSION['CbEU8'] = $row['IdEU8'];

	$_SESSION['ChkI1'] = $row['I1'];

	$_SESSION['ChkI2'] = $row['I2'];

	$_SESSION['ChkI3'] = $row['I3'];

	$_SESSION['ChkI4'] = $row['I4'];

	$_SESSION['ChkI5'] = $row['I5'];

	$_SESSION['ChkI6'] = $row['I6'];

	$_SESSION['ChkI7'] = $row['I7'];

	$_SESSION['ChkI8'] = $row['I8'];

	$_SESSION['ChkI9'] = $row['I9'];

	$_SESSION['ChkI10'] = $row['I10'];

	$_SESSION['ChkI11'] = $row['I11'];

	$_SESSION['ChkI12'] = $row['I12'];



}mysql_free_result($rs);

} 



GLO_InitHTML($_SESSION["NivelArbol"],'TxtNombre','BannerConMenuHV','zModificar',0,0,0,0); 



include ("Includes/zCampos.php");

GLO_exportarform(750,1,1,0,0,0);

?>





 <!--detalle-->

<table width="750" border="0"  cellpadding="0" cellspacing="0">

<tr> <td height="5" ></td></tr>

<tr ><td height="18" ><i class="fa fa-flag iconsmallsp iconlgray"></i> <strong>Detalle Seguimiento:</strong></td></tr>

<tr> <td  align="center" ><?php  MostrarTablaItemsInsp(intval($_SESSION['TxtNumero']),$conn); ?></td></tr>

<tr> <td height="15"></td></tr>

 <!--archivos-->

<tr ><td height="18" ><i class="fa fa-paperclip iconsmallsp iconlgray"></i> <strong>Archivos adjuntos:</strong></td></tr>

<tr> <td  align="center"  ><?php GLO_TablaArchivos(intval($_SESSION['TxtNumero']),$conn,"inspeccionesarchivos","750","Adjuntos/"); ?></td></tr>

<tr> <td height="15"></td></tr>

 <!--op-->

<tr ><td height="18" ><i class="fa fa-id-card iconsmallsp iconlgray"></i> <strong>Habilitaciones Operador:</strong></td></tr>

<tr> <td  align="center"  ><?php MostrarTablaVtosSMA(intval($_SESSION['CbP1']),$conn); ?></td></tr>

<tr> <td height="15"></td></tr>

 <!--chof-->

<tr ><td height="18" ><i class="fa fa-id-card iconsmallsp iconlgray"></i> <strong>Habilitaciones Chofer:</strong></td></tr>

<tr> <td  align="center"  ><?php MostrarTablaVtosSMA(intval($_SESSION['CbP2']),$conn); ?></td></tr>

<tr> <td height="15"></td></tr>

 <!--ayud-->

<tr ><td height="18" ><i class="fa fa-id-card iconsmallsp iconlgray"></i> <strong>Habilitaciones Ayudante:</strong></td></tr>

<tr> <td  align="center"  ><?php MostrarTablaVtosSMA(intval($_SESSION['CbP3']),$conn); ?></td></tr>

</table>                  

     



<?

GLO_cierratablaform(); 

mysql_close($conn); 

include ("../Codigo/FooterConUsuario.php");

?>