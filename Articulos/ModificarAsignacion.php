<? include("../Codigo/Seguridad.php");include("../Codigo/Config.php");include("../Codigo/Funciones.php");$_SESSION["NivelArbol"]="../";require_once('../Codigo/calendar/classes/tc_calendar.php');
//perfiles
if ($_SESSION["IdPerfilUser"]!=1 and $_SESSION["IdPerfilUser"]!=2  and $_SESSION["IdPerfilUser"]!=11 and $_SESSION["IdPerfilUser"]!=12 and $_SESSION["IdPerfilUser"]!=14){ header("Location:".$_SESSION["NivelArbol"]."Inicio.php");}
//get
GLO_ValidaGET($_GET['id'],0,0);

$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);

$query="SELECT * From instrumentosasig where Id<>0 and Id=".intval($_GET['id']); $rs=mysql_query($query,$conn);
while($row=mysql_fetch_array($rs)){
	$_SESSION['CbInstrumento']=$row['IdInstrumento'];
	$_SESSION['TxtNroEntidad'] = str_pad($row['IdInstrumento'], 5, "0", STR_PAD_LEFT);
	$_SESSION['TxtNumero'] = str_pad($row['Id'], 5, "0", STR_PAD_LEFT);
	//
	$_SESSION['CbPersonal'] =$row['IdPersonal'];
	$_SESSION['CbUnidad'] =$row['IdUnidad'];
	$_SESSION['CbSector'] =$row['IdSectorM'];
	//
	$_SESSION['TxtFechaA'] = GLO_FormatoFecha($row['FechaD']);//entrega
	$_SESSION['TxtFechaE'] = GLO_FormatoFecha($row['FechaE']);//devolucion pactada
	$_SESSION['TxtFechaB'] = GLO_FormatoFecha($row['FechaH']);//devolucion realizada
	//
	$_SESSION['TxtObs'] = $row['Obs'];
	$_SESSION['ChkReq'] = $row['TIndef'];
}mysql_free_result($rs);


GLOF_Init('','BannerPopUp','zModificarAsignacion',0,'',0,0,0); 

GLO_tituloypath(0,700,'','ASIGNACION INSTRUMENTO','salir');
?>

<table width="700" border="0"   cellspacing="0" class="Tabla" >
<tr> <td width="120" height="5"  ></td> <td width="580"></td> </tr>
<tr> <td height="18"  align="right"  >Asignacion:</td><td>&nbsp;<input  name="TxtNumero" type="text"  readonly="true"  class="TextBoxRO"   value="<? echo $_SESSION['TxtNumero'];?>" style="text-align:right;width:50px"></td></tr>
<tr> <td height="18"  align="right"  >Instrumento:</td><td>&nbsp;<input  name="TxtNroEntidad" type="text"  readonly="true"  class="TextBoxRO"   value="<? echo $_SESSION['TxtNroEntidad'];?>" style="text-align:right;width:50px"> <select name="CbInstrumento" style="width:348px"  class="campos" id="CbInstrumento" ><? GLO_ComboEquiposRO("CbInstrumento",intval($_SESSION['CbInstrumento']),"epparticulos",$conn); ?> </select><label class="MuestraError"> * </label></td></tr>
</table>


<table width="700" border="0"   cellspacing="0" class="Tabla TMT" >
<tr> <td width="120" height="5"  ></td> <td width="580"></td> </tr>
<tr> <td height="18"  align="right"  >Personal:</td><td>&nbsp;<select name="CbPersonal" class="campos" id="CbPersonal"  style="width:400px" onKeyDown="enterxtab(event)"><? ComboPersonalRFROX('CbPersonal',intval($_SESSION['CbPersonal']),$conn); ?></select></td></tr>
<tr> <td height="18"  align="right"  >Unidad:</td><td>&nbsp;<select name="CbUnidad" style="width:400px" class="campos" id="CbUnidad" ><? GLO_ComboActivoUniRO("unidades","CbUnidad","Dominio","",$_SESSION['CbUnidad'],"",$conn); ?> </select></td></tr>
<tr> <td height="18"  align="right"  >Sector:</td><td>&nbsp;<select name="CbSector" style="width:400px" class="campos" id="CbSector" > <? ComboTablaRFROX("sectorm","CbSector","Nombre","",intval($_SESSION['CbSector']),"",$conn); ?> </select></td></tr>
</table>

<table width="700" border="0"   cellspacing="0" class="Tabla TMT" >
<tr> <td width="120" height="5"  ></td> <td width="580"></td> </tr>
<tr> <td height="18"  align="right"  >Entrega:</td><td>&nbsp;<input name="TxtFechaA" id="TxtFechaA"  type="text" class="TextBoxRO"  style="width:65px" maxlength="10"  readonly="true"  value="<? echo $_SESSION['TxtFechaA']; ?>" > <input name="ChkReq"  tabindex="1"  class="check" type="checkbox"  value="1" <? if ($_SESSION['ChkReq'] =='1') echo 'checked'; ?>> <? GLO_CheckColor('Tiempo indefinido',$_SESSION['ChkReq'],0);?></td></tr>
<tr> <td height="18"  align="right"  >Devolucion pactada:</td><td>&nbsp;<? GLO_calendario("TxtFechaE","../Codigo/","actual",1) ?></td></tr>
<tr> <td height="18"  align="right"  >Devuelto:</td><td>&nbsp;<? GLO_calendario("TxtFechaB","../Codigo/","actual",1); ?></td></tr>
</table>

<table width="700" border="0"   cellspacing="0" class="Tabla TMT" >
<tr> <td width="120" height="5"  ></td> <td width="580"></td> </tr>
<tr><td height="18"  align="right"  >Observaciones:</td><td  valign="top" >&nbsp;<input name="TxtObs" type="text" tabindex="2" class="TextBox" style="width:550px" maxlength="100"  value="<? echo $_SESSION['TxtObs']; ?>"></td></tr>
</table>

<?
GLO_guardar("700",3,0);
GLO_mensajeerror();

GLO_cierratablaform(); 
mysql_close($conn); 
include ("../Codigo/FooterConUsuario.php");
?>