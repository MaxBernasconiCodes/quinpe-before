<? if ($_SESSION["IdPerfilUser"]!=1 and $_SESSION["IdPerfilUser"]!=2 and $_SESSION["IdPerfilUser"]!=3 and $_SESSION["IdPerfilUser"]!=9 and $_SESSION["IdPerfilUser"]!=14 ){ header("Location:".$_SESSION["NivelArbol"]."Inicio.php");}

GLO_tituloypath(0,700,'../PSSAAct.php','ACTIVIDADES','linksalir'); 
?>

<table width="700" border="0"  cellspacing="0" class="Tabla" >
<tr><td width="100" height="3"  ></td>  <td width="600"></td></tr>
<tr><td height="18"  align="right"  >&nbsp;N&uacute;mero:</td><td  valign="top" >&nbsp;<input  name="TxtNumero" type="text"  readonly="true"  class="TextBoxRO"   value="<? echo $_SESSION['TxtNumero'];?>" style="text-align:right;width:50px"></td></tr>
<tr><td height="18"  align="right"  >&nbsp;Nombre:</td><td  valign="top" >&nbsp;<input name="TxtNombre" type="text" class="TextBox" style="width:500px" maxlength="100"  value="<? echo $_SESSION['TxtNombre']; ?>" > <label class="MuestraError"> * </label></td></tr>
<tr><td height="18"  align="right"  >Tipo:</td><td  valign="top" >&nbsp;<select name="CbTipo" style="width:200px" class="campos" id="CbTipo"  tabindex="1" ><option value=""></option> <? ComboTablaRFX("pssa_tipo","CbTipo","Nombre","","",$conn); ?> </select><label class="MuestraError"> * </label></td></tr>
<tr><td height="18"  align="right"  >Frecuencia:</td><td  valign="top" >&nbsp;<select name="CbFrec" style="width:200px" class="campos" id="CbFrec"  tabindex="1" ><option value=""></option> <? ComboTablaRFX("pssa_frec","CbFrec","Nombre","","",$conn); ?> </select></td></tr>
<tr><td height="18"  align="right"  >Responsable:</td><td  valign="top" >&nbsp;<select name="CbResp" style="width:200px" class="campos" id="CbResp"  tabindex="1" ><option value=""></option> <? ComboTablaRFX("pssa_resp","CbResp","Nombre","","",$conn); ?> </select></td></tr>
</table>


<?
GLO_botonesform("700",0,2);
GLO_mensajeerror(); 
?>