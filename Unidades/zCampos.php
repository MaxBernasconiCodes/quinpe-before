<? 
//seguridad includes
if(!isset($_SESSION)){include("../Codigo/SeguridadIncludes.php");}
else{include($_SESSION["NivelArbol"]."Codigo/SeguridadIncludes.php");}

include("MenuH.php");
GLO_tituloypath(0,730,'../Unidades.php','UNIDADES','linksalir'); 
GLO_mensajeerror(); 
?>

<table width="730" border="0"  cellspacing="0" class="Tabla" >
<tr><td width="100" height="3"  ></td> <td width="100"></td> <td width="30"></td><td width="140"></td><td width="100" height="3"  ></td> <td width="260"></td> </tr>
<tr>  <td height="18"  align="right"  >N&uacute;mero:</td><td  valign="top" colspan="2"> &nbsp; <input  name="TxtNumero" type="text"  readonly="true"  class="TextBoxRO"   value="<? echo $_SESSION['TxtNumero'];?>" style="text-align:right;width:70px"></td><td  valign="top" >Foto:&nbsp;
<? 
GLO_Hidden('TxtFoto',0);
if (intval($_SESSION['TxtNumero'])!=0){echo GLO_FAButton('CmdArchivo','submit','','self','Explorar','folder','iconbtn').'&nbsp;&nbsp;';}
if (intval($_SESSION['TxtNumero'])!=0 and !(empty($_SESSION['TxtFoto']))){echo GLO_FAButton('CmdVerFoto','submit','','blank','Ver','lupa','iconbtn').' &nbsp; '.GLO_FAButton('CmdBorrarFoto','submit','','self','Borrar','trash','iconbtn');}
?>    
</td><td height="18"  align="right"  >A&ntilde;o:</td><td  valign="top" > &nbsp; <input name="TxtAnio" type="text"  tabindex="2"  class="TextBox" style="width:65px" maxlength="4"  value="<? echo $_SESSION['TxtAnio']; ?>" onChange="this.value=validarEntero(this.value);" ></td></tr>
<tr><td height="18"  align="right"  >Dominio:</td><td  valign="top" colspan="3"> &nbsp; <input name="TxtDominio" type="text"  class="TextBox" style="width:70px;" maxlength="10"  tabindex="1"   value="<? echo $_SESSION['TxtDominio']; ?>" onKeyUp="this.value=this.value.toUpperCase()" /><label class="MuestraError"> * </label></td><td height="18"  align="right"  >Km Ingreso:</td><td  valign="top" >&nbsp; <input name="TxtKmI" type="text"  tabindex="2"  class="TextBox" style="text-align:right;width:65px" maxlength="6"  value="<? echo $_SESSION['TxtKmI']; ?>" onChange="this.value=validarEntero(this.value);" > </td></tr>
<tr><td height="18"  align="right"  >Nombre:</td><td  valign="top" colspan="3">&nbsp; <input name="TxtNombre" type="text"  class="TextBox" style="width:220px;" maxlength="30"  tabindex="1"   value="<? echo $_SESSION['TxtNombre']; ?>" onKeyUp="this.value=this.value.toUpperCase()" /><label class="MuestraError"> * </label></td><td height="18"  align="right"  >Estado:</td><td  valign="top" >&nbsp; <select name="CbCond" tabindex="2"  style="width:220px" class="campos" id="CbCond" ><option value=""></option> <? ComboTablaRFX("unidadescond","CbCond","Nombre","","",$conn); ?> </select></td></tr>
<tr><td height="18"  align="right"  >Categor&iacute;a:</td><td  valign="top" colspan="3">&nbsp; <select name="CbCateg" style="width:220px"  tabindex="1" class="campos" id="CbCateg" ><option value=""></option> <? ComboTablaRFX("unidadescateg","CbCateg","Nombre","","",$conn); ?> </select></td><td height="18"  align="right"  >Elemento:</td><td  valign="top" >&nbsp; <select name="CbElem" tabindex="2"  style="width:220px" class="campos" id="CbElem" ><option value=""></option> <? ComboTablaRFX("unidadeselem","CbElem","Nombre","","",$conn); ?> </select></td></tr>
<tr><td height="18"  align="right"  >Marca:</td><td  valign="top" colspan="3">&nbsp; <select name="CbMarca"  tabindex="1" style="width:220px" class="campos" id="CbMarca" ><option value=""></option> <? ComboTablaRFX("unidadesmarcas","CbMarca","Nombre","","",$conn); ?> </select></td><td height="18"  align="right"  >Condicion:</td><td  valign="top" >&nbsp;<input name="ChkProp"  type="checkbox" style="vertical-align:middle" tabindex="2" value="1" <? if ($_SESSION['ChkProp'] =='1') echo 'checked'; ?>>Propio&nbsp;&nbsp;&nbsp;<input name="ChkAlq"  type="checkbox" style="vertical-align:middle" tabindex="2" value="1" <? if ($_SESSION['ChkAlq'] =='1') echo 'checked'; ?>>Alquilado&nbsp;&nbsp;&nbsp;<input name="ChkLeas"  type="checkbox" style="vertical-align:middle" tabindex="2" value="1" <? if ($_SESSION['ChkLeas'] =='1') echo 'checked'; ?>>Leasing   </td></tr>
<tr><td height="18"  align="right"  >Modelo:</td><td  valign="top" colspan="3"> &nbsp; <input name="TxtModelo" type="text"  class="TextBox" style="width:220px" maxlength="50"  tabindex="1"  value="<? echo $_SESSION['TxtModelo']; ?>"></td><td height="18"  align="right"  >Propietario:</td><td   valign="middle"  >&nbsp; <input name="CbProp" type="text"  class="TextBox" style="width:230px" maxlength="50"  tabindex="2"  value="<? echo $_SESSION['CbProp']; ?>"></td></tr>
</table>




<table width="730" border="0"  cellspacing="0" class="Tabla TMT" >
<tr><td width="100" height="3"  ></td> <td width="100"></td> <td width="30"></td><td width="140"></td><td width="100" height="3"  ></td><td width="100"></td> <td width="30"></td><td width="130"></td></tr>
<tr><td height="18"  align="right"  >Nro.Chasis:</td><td  valign="top" colspan="3">&nbsp; <input name="TxtChasis" type="text"  class="TextBox" style="width:220px" maxlength="30"  tabindex="3"  value="<? echo $_SESSION['TxtChasis']; ?>"></td><td height="18"  align="right"  >Rodado Cub.:</td><td  valign="top"  colspan="3">&nbsp; <select name="CbRodado" tabindex="4"  style="width:150px" class="campos" id="CbRodado" ><option value=""></option> <? ComboTablaRFX("unidadesrodados","CbRodado","Nombre","","",$conn); ?> </select>&nbsp;&nbsp;Cant:&nbsp;<input name="TxtCub" type="text"  tabindex="4"  class="TextBox" style="text-align:right;width:40px" maxlength="3"  value="<? echo $_SESSION['TxtCub']; ?>" onChange="this.value=validarEntero(this.value);" >  </td></tr>
<tr><td height="18"  align="right"  >Nro.Motor:</td><td  valign="top" colspan="3">&nbsp; <input name="TxtMotor" type="text"  class="TextBox" style="width:220px" maxlength="30"  tabindex="3"  value="<? echo $_SESSION['TxtMotor']; ?>"></td><td height="18"  align="right"  >Pza.Seg.Autom.:</td><td  valign="top"  colspan="3">&nbsp; <select name="CbPSA" tabindex="4"  style="width:150px" class="campos" id="CbPSA" ><option value=""></option> <? ComboPolizaSeguroRFX("CbPSA",$conn); ?> </select>&nbsp;&nbsp; Item:&nbsp;<input name="TxtPSA" type="text"  tabindex="4"  class="TextBox" style="text-align:right;width:40px" maxlength="3"  value="<? echo $_SESSION['TxtPSA']; ?>" onChange="this.value=validarEntero(this.value);" > </td></tr>
<tr><td height="18"  align="right"  >Fabricante:</td><td  valign="top" colspan="3">&nbsp; <select name="CbFabr" tabindex="3"  style="width:220px" class="campos" id="CbFabr" ><option value=""></option> <? ComboTablaRFX("unidadesfabric","CbFabr","Nombre","","",$conn); ?> </select></td><td height="18"  align="right"  >Pza.Seg.T&eacute;cnico:</td><td  valign="top"  colspan="3">&nbsp; <select name="CbPST" tabindex="4"  style="width:150px" class="campos" id="CbPST" ><option value=""></option> <? ComboPolizaSeguroRFX("CbPST",$conn); ?> </select>&nbsp;&nbsp; Item:&nbsp;<input name="TxtPST" type="text"  tabindex="4"  class="TextBox" style="text-align:right;width:40px" maxlength="3"  value="<? echo $_SESSION['TxtPST']; ?>" onChange="this.value=validarEntero(this.value);" ></td></tr>
<tr><td height="18"  align="right"  >Tac&oacute;grafo:</td><td  valign="top" colspan="3">&nbsp;<input name="ChkTaco"  style="vertical-align:middle" type="checkbox"  tabindex="3" value="1" <? if ($_SESSION['ChkTaco'] =='1') echo 'checked'; ?>>&nbsp;<select name="CbMarcaT" tabindex="3"  style="width:200px" class="campos" id="CbMarcaT" ><option value=""></option> <? ComboTablaRFX("unidadesmarcastaco","CbMarcaT","Nombre","","",$conn); ?> </select></td><td height="18"  align="right"  >Pza.Seg.RCC:</td><td  valign="top"  colspan="3">&nbsp; <select name="CbPSRCC" tabindex="4"  style="width:150px" class="campos" id="CbPSRCC" ><option value=""></option> <? ComboPolizaSeguroRFX("CbPSRCC",$conn); ?> </select>&nbsp;&nbsp; Item:&nbsp;<input name="TxtPSRCC" type="text"  tabindex="4"  class="TextBox" style="text-align:right;width:40px" maxlength="3"  value="<? echo $_SESSION['TxtPSRCC']; ?>" onChange="this.value=validarEntero(this.value);" ></td></tr>
<tr><td height="18"  align="right"  >Nro.Tac&oacute;grafo:</td><td  valign="top" colspan="3">&nbsp; <input name="TxtTaco" type="text"  class="TextBox" style="width:220px" maxlength="30"  tabindex="3"  value="<? echo $_SESSION['TxtTaco']; ?>"> </td><td height="18"  align="right"  >Fecha Alta:</td><td  valign="top" >&nbsp; <input name="TxtFechaA" id="TxtFechaA"  tabindex="4"  type="text" class="TextBox"  style="width:70px;" maxlength="10"  onchange="this.value=validarFecha(this.value);" value="<? echo $_SESSION['TxtFechaA']; ?>"   >
<? calendario("TxtFechaA","../Codigo/","actual") ?></td><td height="18" ><label class="MuestraError"> * </label></td><td  valign="top" >Baja:&nbsp;<input name="TxtFechaB"  id="TxtFechaB" type="text"  tabindex="4" class="TextBox"  style="width:70px;" maxlength="9"  onchange="this.value=validarFecha(this.value);" value="<? echo $_SESSION['TxtFechaB']; ?>"   ><? calendario("TxtFechaB","../Codigo/","actual") ?></td></td></tr>
</table>



<table width="730" border="0"   cellspacing="0" class="Tabla TMT" >
<tr><td width="100" height="3"  ></td> <td width="100"></td> <td width="30"></td><td width="140"></td><td width="100" height="3"  ></td> <td width="260"></td> </tr>
<tr> <td height="18"  align="right"  >Sector:</td><td  valign="top"  colspan="3">&nbsp; <select name="CbSector" style="width:220px" class="campos" id="CbSector"  tabindex="5"><option value=""></option> <? ComboTablaRFX("sector","CbSector","Nombre","","",$conn); ?> </select></td><td height="18"  align="right"  >Servicio:</td><td  valign="top" >&nbsp; <select name="CbServicio" tabindex="5"  style="width:130px" class="campos" id="CbServicio" ><option value=""></option> <? CompletarComboServicioRFX("CbServicio",$conn); ?> </select>&nbsp; &nbsp; <input name="ChkAfe"  type="checkbox" tabindex="5" style="vertical-align:middle" value="1" <? if ($_SESSION['ChkAfe'] =='1') echo 'checked'; ?>>Afectado</td></tr>
</table> 




<? if ($_SESSION["IdPerfilUser"]==1 or $_SESSION["IdPerfilUser"]==2){ include ("zCamposT.php");} ?>  


<? 
GLO_Hidden('TxtId',0);
GLO_obsform(730,100,'Observaciones','TxtObs',1,0);
GLO_botonesform(730,0,2);
?>   


<? 
$_SESSION['TxtNombre'] =  "";
$_SESSION['TxtFechaA'] =  "";
$_SESSION['TxtFechaB'] =  "";
$_SESSION['CbElem'] =  "";
$_SESSION['TxtAnio'] =  "";
$_SESSION['TxtDominio'] =  "";
$_SESSION['CbMarca'] =  "";
$_SESSION['CbCateg'] =  "";
$_SESSION['CbCond'] =  "";
$_SESSION['CbFabr'] =  "";
$_SESSION['TxtModelo'] =  "";
$_SESSION['TxtChasis'] =  "";
$_SESSION['TxtMotor'] =  "";
$_SESSION['CbProp'] =  "";
$_SESSION['ChkAlq'] =  "";
$_SESSION['ChkAfe'] =  "";
$_SESSION['TxtFoto'] =  "";
$_SESSION['TxtVtoVTV'] =  "";
$_SESSION['TxtVtoSeg'] = "";
$_SESSION['CbSector'] =  "";
$_SESSION['CbServicio'] =  "";
$_SESSION['TxtObs'] =  "";
$_SESSION['ChkATV'] =  "";
$_SESSION['TxtATV'] =  "";
$_SESSION['ChkATI'] =  "";
$_SESSION['TxtATI'] =  "";
$_SESSION['ChkAVTV'] =  "";
$_SESSION['TxtAVTV'] =  "";
$_SESSION['CbMarcaT'] =  "";
$_SESSION['CbRodado'] =  "";
$_SESSION['TxtKmI'] =  "";
$_SESSION['ChkTaco'] =  "";
$_SESSION['TxtTaco'] =  "";
$_SESSION['TxtCub'] =  "";
$_SESSION['CbPSA'] =  "";
$_SESSION['CbPST'] =  "";
$_SESSION['TxtPSA'] =  "";
$_SESSION['TxtPST'] =  "";
$_SESSION['ChkProp'] ="";
$_SESSION['ChkLeas'] = "";
$_SESSION['TxtPrecio']= "";
$_SESSION['TxtPrecioR'] = "";
$_SESSION['TxtMes'] = "";
$_SESSION['CbFAdq'] = "";
$_SESSION['TxtAMes']= "";
$_SESSION['CbPSRCC']= "";
$_SESSION['TxtPSRCC']= "";

?>			
