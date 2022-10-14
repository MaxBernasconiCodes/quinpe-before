<? include("../Codigo/Seguridad.php");include("../Codigo/Config.php");include("../Codigo/Funciones.php");$_SESSION["NivelArbol"]="../";require_once('../Codigo/calendar/classes/tc_calendar.php');
//perfiles
GLO_PerfilAcceso(14);
//si no tiene cargados responsables
if (intval($_SESSION["GLO_IdPersCON"])==0 or intval($_SESSION["GLO_IdPersAPR"])==0){header("Location:".$_SESSION["NivelArbol"]."Inicio.php");}


$_SESSION['TxtPath']=str_pad(intval($_GET['Id']), 5, "0", STR_PAD_LEFT);

//mostrar datos
if ($_GET['Flag1']=="True"){
	$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);
	$query="SELECT * From iso_doc_copias Where Id=".intval($_GET['IdCP']);
	$rs=mysql_query($query,$conn);
	while($row=mysql_fetch_array($rs)){
		$_SESSION['TxtNumero']=$row['Id'];
		$_SESSION['TxtNroEntidad']=$row['IdDoc'];
		$_SESSION['CbCentro'] =$row['IdCentro'];
		$_SESSION['TxtCant'] =$row['Cantidad'];
		$_SESSION['TxtFechaA'] = FormatoFecha($row['FechaA']);if ($_SESSION['TxtFechaA']=='00-00-0000'){$_SESSION['TxtFechaA'] ="";}
		$_SESSION['TxtFechaB'] = FormatoFecha($row['FechaB']);if ($_SESSION['TxtFechaB']=='00-00-0000'){$_SESSION['TxtFechaB'] ="";}
		$_SESSION['TxtObs'] =$row['Obs'];
	}mysql_free_result($rs);
	mysql_close($conn);
}




?> 

<? include ("../Codigo/HeadFull.php");?>
<link rel="STYLESHEET" type="text/css" href="../CSS/Estilo.css" >

<? GLO_bodyform('',0,0);?>
<? include ("../Codigo/BannerPopUp.php");?>


<form name="Formulario" action="zModificarCopia.php" method="post" >
<?php GLO_tituloypath(950,600,'sgi','DISTRIBUCION COPIAS','salir'); ?>


<table width="600" border="0"  cellspacing="0" class="Tabla" >
<tr> <td width="100" height="5"  ></td> <td width="500"></td> </tr>
<tr> <td height="18" align="right"  >Documento:</td><td  valign="top" > &nbsp; <input  name="TxtPath" type="text"  readonly="true"  class="TextBoxRO"   value="<? echo $_SESSION['TxtPath'];?>" style="text-align:right;width:50px"></td></tr>
<tr> <td   align="right"  valign="top" >&nbsp;Cantidad:</td><td  valign="top" > &nbsp; <input name="TxtCant" type="text"  class="TextBox"  maxlength="2"  value="<? echo $_SESSION['TxtCant']; ?>" onChange="this.value=validarEntero(this.value);" style="width:65px"><label class="MuestraError"> * </label></td></tr>
<tr> <td   align="right"  valign="top" >&nbsp;Entregadas:</td><td  valign="top" >&nbsp;  <input name="TxtFechaA" id="TxtFechaA"  type="text" class="TextBox"  style="width:65px" maxlength="10"  onchange="this.value=validarFecha(this.value);" value="<? echo $_SESSION['TxtFechaA']; ?>"   >
<? calendario("TxtFechaA","../Codigo/","actual") ?><label class="MuestraError"> * </label></td></tr>
<tr> <td   align="right"  valign="top" >&nbsp;Retiradas:</td><td  valign="top" >&nbsp;  <input name="TxtFechaB" id="TxtFechaB"  type="text" class="TextBox"  style="width:65px" maxlength="10"  onchange="this.value=validarFecha(this.value);" value="<? echo $_SESSION['TxtFechaB']; ?>"   >
<? calendario("TxtFechaB","../Codigo/","actual") ?></td></tr>
<tr> <td   align="right"  valign="top" >&nbsp;Observaciones:</td><td  valign="top" > &nbsp; <input name="TxtObs" type="text"  class="TextBox" style="width:450px" maxlength="100"  value="<? echo $_SESSION['TxtObs']; ?>"><input  name="TxtNumero" type="hidden" value="<? echo $_SESSION['TxtNumero']; ?>"><input  name="TxtNroEntidad"  type="hidden"   value="<? echo $_SESSION['TxtNroEntidad']; ?>"></td></tr>
</table>


<? GLO_botonesform("600",0,2); ?> 
<? GLO_mensajeerror(); ?>




<? GLO_cierratablaform(); ?>

				


<? include ("../Codigo/FooterConUsuario.php");?>