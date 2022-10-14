<? if ($_SESSION["IdPerfilUser"]!=1 and $_SESSION["IdPerfilUser"]!=2 and $_SESSION["IdPerfilUser"]!=4 and $_SESSION["IdPerfilUser"]!=7 and $_SESSION["IdPerfilUser"]!=3  and $_SESSION["IdPerfilUser"]!=11  and $_SESSION["IdPerfilUser"]!=12  and $_SESSION["IdPerfilUser"]!=9 and $_SESSION["IdPerfilUser"]!=14 and $_SESSION["IdPerfilUser"]!=13){ header("Location:".$_SESSION["NivelArbol"]."Inicio.php");}

GLO_tituloypath(0,600,'../PSA.php','POLIZAS SEGURO','linksalir'); 
?>

<table width="600" border="0"   cellspacing="0" class="Tabla" >
<tr><td width="100" height="3"  ></td>  <td width="150"></td><td width="350"></td></tr>
<tr><td height="18"  align="right"  >N&uacute;mero:</td><td  valign="top" colspan="2">&nbsp;<input  name="TxtNro" type="text"  class="TextBox"   maxlength="5"  tabindex="1"   value="<? echo $_SESSION['TxtNro'];?>" onChange="this.value=validarEntero(this.value);" style="text-align:right; width:50px" ><label class="MuestraError"> * </label></td></tr>
<tr><td height="18"  align="right"  >Tipo:</td><td  valign="top" colspan="2">&nbsp;<select name="CbTipo" style="width:300px" class="campos" id="CbTipo"  tabindex="1" ><option value=""></option> <? ComboTablaRFX("polizastipo","CbTipo","Nombre","","",$conn); ?> </select><label class="MuestraError"> * </label></td></tr>
<tr><td height="18"  align="right"  >Aseguradora:</td><td  valign="top" colspan="2">&nbsp;<select name="CbAseg" style="width:300px" class="campos" id="CbAseg"  tabindex="1" ><option value=""></option> <? ComboTablaRFX("polizasaseg","CbAseg","Nombre","","",$conn); ?> </select><label class="MuestraError"> * </label></td></tr>
<tr><td height="18"  align="right"  >Inicio:</td><td  valign="top" colspan="2">&nbsp;<input name="TxtFechaA" id="TxtFechaA"   type="text" class="TextBox"  style="width:70px;" maxlength="10" tabindex="2" onChange="this.value=validarFecha(this.value);" value="<? echo $_SESSION['TxtFechaA']; ?>"      > <?php  calendario("TxtFechaA","../Codigo/","actual"); ?></td></tr>
<tr><td height="18"  align="right"  >Fin:</td><td  valign="top" >&nbsp;<input name="TxtFechaB" id="TxtFechaB"   type="text" class="TextBox"  style="width:70px;" maxlength="10" tabindex="2" onChange="this.value=validarFecha(this.value);" value="<? echo $_SESSION['TxtFechaB']; ?>"      > <?php  calendario("TxtFechaB","../Codigo/","actual"); ?></td><td></td></tr>
</table>

<?
GLO_Hidden('TxtNumero',0);GLO_Hidden('TxtId',0);
GLO_botonesform("600",0,2); 
GLO_mensajeerror();
?>