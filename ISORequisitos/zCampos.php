<? 
//seguridad includes
if(!isset($_SESSION)){include("../Codigo/SeguridadIncludes.php");}
else{include($_SESSION["NivelArbol"]."Codigo/SeguridadIncludes.php");}

GLO_tituloypath(0,700,'../ISO_Requisitos.php','REQUISITO DE CALIDAD','linksalir');
?>


<table width="700" border="0"   cellspacing="0" class="Tabla" >
<tr> <td width="80" height="5"  ></td> <td width="620"></td></tr>
<tr><td height="18"  align="right"  >Numero:</td><td  valign="top" >&nbsp;<input name="TxtNro" type="text" class="TextBox" style="width:70px" maxlength="7" tabindex="1"  value="<? echo $_SESSION['TxtNro']; ?>" > <label class="MuestraError"> * </label></td></tr>
<tr><td height="18"  align="right"  >Norma:</td><td  valign="top" >&nbsp;<select name="CbNorma" style="width:200px" tabindex="1" class="campos" id="CbNorma" ><option value=""></option> <? GLO_ComboActivo("iso_nc_norma","CbNorma","Id","","",$conn); ?> </select> <label class="MuestraError"> * </label></td></tr>
<tr><td height="18"  align="right"   valign="top">Requisito:</td><td  valign="top" >&nbsp;<input name="TxtNombre" type="text" class="TextBox" style="width:570px;" maxlength="200"  tabindex="1" value="<? echo $_SESSION['TxtNombre']; ?>" ></textarea> <label class="MuestraError TVT"> * </label></td></tr>
<tr><td height="18"  align="right"   valign="top">Baja:</td><td  valign="top" >&nbsp;<?  GLO_calendario("TxtFechaB","../Codigo/","actual",1); ?></td></tr>
</table>

<? 
GLO_Hidden('TxtNumero',0);
GLO_botonesform("700",0,2); 
GLO_mensajeerror();
GLO_cierratablaform(); 
?>