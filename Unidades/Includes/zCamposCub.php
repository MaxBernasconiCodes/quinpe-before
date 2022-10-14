<? 
//seguridad includes
if(!isset($_SESSION)){include("../../Codigo/SeguridadIncludes.php");}
else{include($_SESSION["NivelArbol"]."Codigo/SeguridadIncludes.php");}

GLO_tituloypath(0,700,'','CUBIERTAS','salir');
?>

<table width="700" border="0"  cellspacing="0" class="Tabla" >
<tr><td width="120" height="3"  ></td>  <td width="580"></td></tr>
<tr><td height="18"  align="right"  >Fecha:</td><td  valign="top" >&nbsp;<input name="TxtFecha" id="TxtFecha"   type="text" class="TextBox"  style="width:70px;" maxlength="10" tabindex="1" onChange="this.value=validarFecha(this.value);" value="<? echo $_SESSION['TxtFecha']; ?>"      ><?php  calendario("TxtFecha","../Codigo/","actual"); ?><label class="MuestraError"> * </label></td></tr>
<tr><td height="18"  align="right"  >Solicitante:</td><td  valign="top" >&nbsp;<select name="CbPersonal" style="width:500px" class="campos" id="CbPersonal"  tabindex="1" ><option value=""></option> <? ComboPersonalRFX("CbPersonal",$conn); ?></td></tr>

<tr><td height="18"  align="right"  >Odometro:</td><td  valign="top" >&nbsp;<input name="TxtKm1" type="text"  tabindex="1"  class="TextBox" style="width:65px" maxlength="6"  value="<? echo $_SESSION['TxtKm1']; ?>" onChange="this.value=validarEntero(this.value);" ></td></tr>

<tr><td height="18"  align="right"  >Cantidad:</td><td  valign="top" >&nbsp;<input name="TxtCant" type="text"  tabindex="1"  class="TextBox" style="width:65px" maxlength="2"  value="<? echo $_SESSION['TxtCant']; ?>" onChange="this.value=validarEntero(this.value);" ></td></tr>

<tr><td height="18"  align="right"  >Marca:</td><td  valign="top" >&nbsp;<select name="CbMarca"  tabindex="1" style="width:300px" class="campos" id="CbMarca" ><option value=""></option> <? ComboTablaRFX("unidades_marcascub","CbMarca","Nombre","","",$conn); ?> </select></td></tr>

<tr><td height="18"  align="right"  >Medida:</td><td  valign="top" >&nbsp;<input name="TxtMed" type="text"  class="TextBox" style="width:100px;" maxlength="15"  tabindex="1"   value="<? echo $_SESSION['TxtMed']; ?>" ></td></tr>

<tr><td height="18"  align="right"  ></td><td  valign="top" ><input name="ChkI1"  type="checkbox" tabindex="1"  class="check" value="1" <? if ($_SESSION['ChkI1'] =='1') echo 'checked'; ?>>Alineacion</td></tr>

<tr><td height="18"  align="right"  ></td><td  valign="top" ><input name="ChkI2"  type="checkbox" tabindex="1"  class="check" value="1" <? if ($_SESSION['ChkI2'] =='1') echo 'checked'; ?>>Balanceo</td></tr>

<tr><td height="18"  align="right"  >Ubicacion reemplazo:</td><td  valign="top" >&nbsp;<input name="TxtUbic" type="text"  class="TextBox" style="width:500px;" maxlength="50"  tabindex="1"   value="<? echo $_SESSION['TxtUbic']; ?>" ></td></tr>

<tr><td height="18"  align="right"  >Km recorridos:</td><td  valign="top" >&nbsp;<input name="TxtKm2" type="text"  tabindex="1"  class="TextBox" style="width:65px" maxlength="6"  value="<? echo $_SESSION['TxtKm2']; ?>" onChange="this.value=validarEntero(this.value);" ></td></tr>

<tr><td height="18"  align="right"  >Observaciones:</td><td  valign="top" >&nbsp;<input name="TxtObs" type="text"  class="TextBox" style="width:500px;" maxlength="100"  tabindex="1"   value="<? echo $_SESSION['TxtObs']; ?>" ></td></tr>

</table>


<? 
GLO_Hidden('TxtNroEntidad',0);GLO_Hidden('TxtNumero',0);
GLO_botonesform("700",0,2);
GLO_mensajeerror(); 
?>