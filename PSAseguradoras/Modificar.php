<? include("../Codigo/Seguridad.php") ;include("../Codigo/Config.php") ;include("../Codigo/Funciones.php"); $_SESSION["NivelArbol"]="../";
//perfiles
if ($_SESSION["IdPerfilUser"]!=1 and $_SESSION["IdPerfilUser"]!=2 and $_SESSION["IdPerfilUser"]!=4 and $_SESSION["IdPerfilUser"]!=7 and $_SESSION["IdPerfilUser"]!=3  and $_SESSION["IdPerfilUser"]!=11  and $_SESSION["IdPerfilUser"]!=12  and $_SESSION["IdPerfilUser"]!=9 and $_SESSION["IdPerfilUser"]!=14 and $_SESSION["IdPerfilUser"]!=13){ header("Location:".$_SESSION["NivelArbol"]."Inicio.php");}
//get
GLO_ValidaGET($_GET['id'],0,0);

$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);

//mostrar campos
if ($_GET['Flag1']=="True"){	
	$query="SELECT * From polizasaseg where Id<>0 and Id=".intval($_GET['id']); 
	$rs=mysql_query($query,$conn);
	while($row=mysql_fetch_array($rs)){
		$_SESSION['TxtNumero'] = str_pad($row['Id'], 6, "0", STR_PAD_LEFT);
		$_SESSION['TxtCUIT']= $row['Identificacion'];
		$_SESSION['TxtNombre']=$row['Nombre'];
		$_SESSION['TxtDireccion']=  $row['Direccion'];
		$_SESSION['CbLocalidad'] = $row['IdLocalidad'];		
		$_SESSION['TxtProvincia']=  $row['Provincia'];
		$_SESSION['TxtCP']=  $row['CP'];
		$_SESSION['TxtObs'] = $row['Observaciones'];
		$_SESSION['TxtT1']= $row['T1']; 
		$_SESSION['TxtT2']= $row['T2']; 
		$_SESSION['TxtC1']= $row['C1']; 
		$_SESSION['TxtC2']= $row['C2']; 
	}
	mysql_free_result($rs);
}



GLOF_Init('TxtNombre','BannerConMenuHV','zModificar',0,'',0,0,0); 
GLO_tituloypath(0,730,'../PSAseguradoras.php','ASEGURADORA','linksalir');
?>



<table width="730" border="0"  cellspacing="0" class="Tabla" >
<tr><td width="100" height="3"  ></td>  <td width="260"></td><td width="85" height="3"  ></td><td width="285"></td></tr>
<tr><td height="18"  align="right"  >N&uacute;mero:</td><td  valign="top" >&nbsp;<input  name="TxtNumero" type="text"  readonly="true"  class="TextBoxRO"   value="<? echo $_SESSION['TxtNumero'];?>" style="text-align:right;width:50px"></td><td height="18"  align="right"  >Direcci&oacute;n:</td><td  valign="top" >&nbsp;<input name="TxtDireccion" type="text"  class="TextBox" style="width:230px" maxlength="200" tabindex="2" value="<? echo $_SESSION['TxtDireccion']; ?>"> </td></tr>
<tr><td height="18"  align="right"  >Nombre:</td><td  valign="top" >&nbsp;<input name="TxtNombre" type="text"  class="TextBox" style="width:230px" maxlength="50" tabindex="1"  value="<? echo $_SESSION['TxtNombre']; ?>" onKeyUp="this.value=this.value.toUpperCase()" />
<label class="MuestraError"> * </label></td><td height="18"  align="right"  >Localidad:</td><td  valign="top" >&nbsp;<select name="CbLocalidad" style="width:230px" class="campos" id="CbLocalidad" tabindex="2" onChange="this.form.submit()" ><option value=""></option> <? $Flag=false; ComboTablaRFX("localidades","CbLocalidad","Nombre","","",$conn);$Flag=true; ?> </select></td></tr>
<tr><td height="18"  align="right"  >CUIT:</td><td  valign="top" >&nbsp;<input name="TxtCUIT" type="text"  class="TextBox"  maxlength="13" tabindex="1" style="width:90px" value="<? echo $_SESSION['TxtCUIT']; ?>" /><label class="MuestraError"> * </label></td><td height="18"  align="right"  >Provincia:</td><td  valign="top" >&nbsp;<input name="TxtProvincia" type="text"  class="TextBoxRO" style="width:175px" maxlength="30" readonly="true" value="<? echo $_SESSION['TxtProvincia']; ?>">&nbsp; <input name="TxtCP" type="text"  class="TextBoxRO" style="width:50px"  readonly="true" value="<? echo $_SESSION['TxtCP']; ?>"> </td></tr>
<tr><td height="18"  align="right"  >Tel&eacute;fono1:</td><td  valign="top" >&nbsp;<input name="TxtT1" type="text"  class="TextBox" style="width:230px" maxlength="30" tabindex="1"  value="<? echo $_SESSION['TxtT1']; ?>" /></td><td height="18"  align="right"  >Contacto1:</td><td  valign="top" >&nbsp;<input name="TxtC1" type="text"  class="TextBox" style="width:230px" maxlength="50" tabindex="2"  value="<? echo $_SESSION['TxtC1']; ?>" /></td></tr>
<tr><td height="18"  align="right"  >Tel&eacute;fono2:</td><td  valign="top" >&nbsp;<input name="TxtT2" type="text"  class="TextBox" style="width:230px" maxlength="30" tabindex="1"  value="<? echo $_SESSION['TxtT2']; ?>" /></td><td height="18"  align="right"  >Contacto2:</td><td  valign="top" >&nbsp;<input name="TxtC2" type="text"  class="TextBox" style="width:230px" maxlength="50" tabindex="2"  value="<? echo $_SESSION['TxtC2']; ?>" /></td></tr>
<tr><td height="18"  align="right"  >Observaciones:</td><td  valign="top" colspan="3" >&nbsp;<input name="TxtObs" type="text"  class="TextBox" style="width:580px" maxlength="200" tabindex="3" value="<? echo $_SESSION['TxtObs']; ?>"> <input  name="TxtId"   type="hidden"   value="<? echo $_SESSION['TxtId']; ?>"></td></tr>
</table>



<? GLO_botonesform("730",0,2); ?>
<? GLO_mensajeerror(); ?>

<? GLO_cierratablaform(); ?>	

<? mysql_close($conn); 
//limpia las var de session
$_SESSION['TxtNumero'] ="";
$_SESSION['TxtCUIT']= "";
$_SESSION['TxtNombre']="";
$_SESSION['TxtDireccion']= "";
$_SESSION['CbLocalidad'] ="";	
$_SESSION['TxtProvincia']="";
$_SESSION['TxtCP']="";
$_SESSION['TxtObs'] ="";
$_SESSION['TxtT1']= "";
$_SESSION['TxtT2']= ""; 
$_SESSION['TxtC1']="";
$_SESSION['TxtC2']="";
$_SESSION['TxtId']= "";
?>		
				

<? include ("../Codigo/FooterConUsuario.php");?>