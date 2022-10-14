<? include("../Codigo/Seguridad.php");include("../Codigo/Funciones.php");include("../Codigo/Config.php");$_SESSION["NivelArbol"]="../";require_once('../Codigo/calendar/classes/tc_calendar.php');include("Includes/zFunciones.php");

//perfiles
GLO_PerfilAcceso(14);
//get
GLO_ValidaGET($_GET['id'],0,0);

//si no tiene cargados responsables
if (intval($_SESSION["GLO_IdPersCON"])==0 or intval($_SESSION["GLO_IdPersAPR"])==0){header("Location:".$_SESSION["NivelArbol"]."Inicio.php");}


$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);
if (empty($_SESSION['TxtFecha1'])){ $_SESSION['TxtFecha1']=date("d-m-Y");}


//mostrar campos
if ($_GET['Flag1']=="True"){	
	$query="SELECT d.* From iso_doc d where d.Id<>0 and d.Id=".intval($_GET['id']); $rs=mysql_query($query,$conn);
	while($row=mysql_fetch_array($rs)){
		$_SESSION['TxtCod']= $row['Codigo'];
		$_SESSION['TxtVs']= str_pad($row['Version']+1, 2, "0", STR_PAD_LEFT); 
		$_SESSION['TxtNombre']= $row['Nombre'];  
		$_SESSION['CbTipo']= $row['IdTipoDoc']; 
		$_SESSION['CbSector']= $row['IdSector']; 
		$_SESSION['CbOrigen']= $row['Origen'];
		$_SESSION['TxtFO']= $row['FlagOrig']; 
		$_SESSION['TxtFR']= $row['Id']; 
		$_SESSION['TxtIdPers2']= $_SESSION["GLO_IdPersCON"];  
		$_SESSION['TxtIdPers3']= $_SESSION["GLO_IdPersAPR"]; 	
		$_SESSION['TxtIdEstado']=$row['IdEstado'];				
		$id=$row['Id'];
	}mysql_free_result($rs);
	//verifico si existe nueva version
	$_SESSION['TxtFlagRev']=ISODOC_TieneVersionNueva($id,$conn);//pasa id doc	
}


//revision de version: si es perfil coord/admin y est&aacute; aprobado, y no existe ya una nueva version
$idestado=$_SESSION['TxtIdEstado'];$flagr=$_SESSION['TxtFlagRev'];
if($idestado!=4 or $flagr!=0 ){
	$_SESSION['TxtCod']= ""; 
	$_SESSION['TxtVs']= ""; 
	$_SESSION['TxtNombre']= ""; 
	$_SESSION['TxtArchivo']= ""; 
	$_SESSION['TxtCom1']= ""; 
	$_SESSION['CbTipo']= ""; 
	$_SESSION['CbSector']= ""; 
	$_SESSION['TxtFO']= ""; 
	$_SESSION['TxtFR']= ""; 
	$_SESSION['CbPers1']= ""; 
	$_SESSION['CbProv1']= ""; 
	$_SESSION['TxtIdPers2']= ""; 
	$_SESSION['TxtIdPers3']= ""; 
	$_SESSION['TxtIdEstado']= ""; 
	$_SESSION['TxtFlagRev']= ""; 
	header("Location:".$_SESSION["NivelArbol"]."Inicio.php");
}


GLOF_Init('','BannerConMenuHV','zRevision',0,'MenuH',0,0,0); 
GLO_tituloypath(950,725,'../ISO_Doc.php','DOCUMENTO','linksalir'); 
?> 




<table width="725" border="0"   cellspacing="0" class="Tabla" >
<tr> <td width="80" height="5"  ></td> <td width="280"></td><td width="85" height="5"  ></td> <td width="280"></td> </tr>
<tr><td height="18"  align="left" colspan="4">&nbsp;<strong>Propiedades:</strong></td>  </tr>

<tr><td height="18"  align="right"  >&nbsp;C&oacute;digo:</td><td  valign="top" > &nbsp; <input name="TxtCod" type="text" readonly="true" class="TextBoxRO"style="width:100px" maxlength="15"  value="<? echo $_SESSION['TxtCod']; ?>" onKeyUp="this.value=this.value.toUpperCase()"> </td><td   align="right"  ></td><td  valign="top" ></td></tr>

<tr><td height="18"  align="right"  >Versi&oacute;n:</td><td  valign="top" > &nbsp; <input name="TxtVs" type="text"  readonly="true" class="TextBoxRO" style="text-align:right;width:25px" maxlength="2"  value="<? echo $_SESSION['TxtVs']; ?>" onChange="this.value=validarEntero(this.value);" ></td><td height="18"  align="right"  ></td><td  valign="top" > </td></tr>

<tr><td height="18"  align="right"  >Tipo:</td><td  valign="top" > &nbsp; <select name="CbTipo" style="width:200px" class="campos"><? ComboTablaRFX("iso_doc_tipo","CbTipo","Nombre","","",$conn); ?></select> <label class="MuestraError"> * </label> </td><td height="18"  align="right"  ></td><td  valign="top" >&nbsp;  </td></tr>

<tr><td height="18"  align="right"  >Sector:</td><td  valign="top" > &nbsp; <select name="CbSector" style="width:200px" class="campos"><? ComboTablaRFX("sector","CbSector","Nombre","","",$conn); ?></select> <label class="MuestraError"> * </label> </td><td align="right"  ></td><td  valign="top" ></td></tr>

<tr><td height="18"  align="right"  >Origen:</td><td  valign="top" > &nbsp; <select name="CbOrigen" style="width:200px" class="campos"><option value=""></option><? ComboISOOrigenDoc(); ?></select> </td><td align="right"  ></td><td  valign="top" ></td></tr>
</table> 



<!-- documento -->
<table width="725" border="0" cellspacing="0" class="Tabla TMT" >
<tr> <td width="80" height="5"  ></td> <td width="280"></td><td width="85" height="5"  ></td> <td width="280"></td> </tr>
<tr><td height="18"  align="left" colspan="2" >&nbsp;<strong>Documento:</strong></td></tr>
<tr><td height="18"  align="right"  >&nbsp;Nombre:</td><td  valign="top"  colspan="3"> &nbsp; <input name="TxtNombre" type="text" class="TextBox" style="width:600px" maxlength="200"  value="<? echo $_SESSION['TxtNombre']; ?>"> <label class="MuestraError"> * </label></td></tr>
</table>



<!-- creacion -->
<table width="725" border="0"  cellspacing="0" class="Tabla TMT" >
<tr> <td width="80" height="5"  ></td> <td width="280"></td><td width="85" height="5"  ></td> <td width="280"></td> </tr>
<tr><td height="18"  align="left" colspan="2" >&nbsp;<strong>Creaci&oacute;n:</strong></td></tr>
<tr> <td height="18"  align="right"  >Personal:</td><td> &nbsp; <select name="CbPers1" style="width:240px" class="campos"><option value=""></option><? ComboPersonalRFX('CbPers1',$conn); ?></select><label class="MuestraError"> * </label></td><td align="right">Fecha:</td><td>&nbsp; <input name="TxtFecha1" id="TxtFecha1"  type="text" class="TextBox"  style="width:70px" maxlength="10"  onchange="this.value=validarFecha(this.value);" value="<? echo $_SESSION['TxtFecha1']; ?>"   ><label class="MuestraError"> * </label><? calendario("TxtFecha1","../Codigo/","actual") ?> </td></tr>

<tr> <td height="18"  align="right"  >Proveedor:</td><td> &nbsp; <select name="CbProv1" style="width:240px" class="campos"><option value=""></option><? ComboProveedorRFX('CbProv1',"",$conn); ?></select><label class="MuestraError"> * </label></td><td align="right"></td><td></td></tr>

<tr> <td height="18"  align="right"  valign="top" >Comentario:</td><td colspan="3" valign="top" > &nbsp; <textarea name="TxtCom1" style="resize:none;width:600px" rows="1" class="TextBox" onKeyPress="event.cancelBubble=true;"><? echo $_SESSION['TxtCom1']; ?></textarea></td></tr>
</table>

<?

GLO_Hidden('TxtFR',0);GLO_Hidden('TxtFO',0);GLO_Hidden('TxtIdEstado',0);
GLO_Hidden('TxtFlagRev',0);GLO_Hidden('TxtIdPers2',0);GLO_Hidden('TxtIdPers3',0);

GLO_botonesform("725",0,2); 
GLO_mensajeerror(); 
GLO_cierratablaform();

mysql_close($conn); 

GLO_initcomment(725,0);
echo 'En los datos de <font class="comentario3">Creacion</font> seleccione <font class="comentario2">Personal</font> o <font class="comentario2">Proveedor</font>';
GLO_endcomment();

include ("../Codigo/FooterConUsuario.php");
?>