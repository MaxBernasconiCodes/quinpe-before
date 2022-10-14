<? 
//seguridad includes
if(!isset($_SESSION)){include("../../Codigo/SeguridadIncludes.php");}
else{include($_SESSION["NivelArbol"]."Codigo/SeguridadIncludes.php");}

GLO_tituloypath(0,600,'','TALLES','salir');
?>
<table width="600" border="0"   cellspacing="0" class="Tabla" >
<tr><td width="100" height="3"  ></td>  <td width="150"></td><td width="350"></td></tr>
<tr><td height="18"  align="right"  >Tipo:</td><td  valign="top" colspan="2">&nbsp;<select name="CbTipo" style="width:300px" class="campos" id="CbTipo"  tabindex="1" ><option value=""></option> <? ComboTablaRFX("personaltalles_el","CbTipo","Nombre","","",$conn); ?> </select><label class="MuestraError"> * </label></td></tr>
<tr><td height="18"  align="right"  >Talle:</td><td  valign="top" colspan="2">&nbsp;<input name="TxtTalle" type="text"  class="TextBox" style="width:300px" maxlength="30"  value="<? echo $_SESSION['TxtTalle']; ?>"><label class="MuestraError"> * </label></td></tr>
</table>


<? 
GLO_Hidden('TxtNroEntidad',0);GLO_Hidden('TxtNumero',0);
GLO_obsform(600,100,'Observaciones','TxtObs',4,0);
GLO_botonesform("600",0,2); 
GLO_mensajeerror();
?>
