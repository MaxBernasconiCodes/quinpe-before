<? include("../Codigo/Seguridad.php") ; 
//perfiles
if ($_SESSION["IdPerfilUser"]!=1 and $_SESSION["IdPerfilUser"]!=2   and $_SESSION["IdPerfilUser"]!=3  and  $_SESSION["IdPerfilUser"]!=9 and $_SESSION["IdPerfilUser"]!=14){ header("Location:".$_SESSION["NivelArbol"]."Inicio.php");}

GLO_tituloypath(0,600,'../Conceptos.php','ITEM','linksalir'); 
?>


<table width="600" border="0"   cellspacing="0" class="Tabla" >
<tr> <td width="100" height="5"  ></td> <td width="500"></td></tr>
<tr><td height="18"  align="right"  >Nombre:</td><td  valign="top" >&nbsp;<input name="TxtNombre" type="text" class="TextBox" style="width:400px"  maxlength="50"  value="<? echo $_SESSION['TxtNombre']; ?>" onKeyUp="this.value=this.value.toUpperCase()"><label class="MuestraError"> * </label></td></tr>
<tr><td height="18"  align="right"  >Tipo:</td><td  valign="top" >&nbsp;<select name="CbTipo" class="campos" id="CbTipo"  style="width:150px" onKeyDown="enterxtab(event)"><?  Cb_TipoItem("CbTipo"); ?></select><label class="MuestraError"> * </label></td></tr>
<tr><td height="18"  align="right"  >Unidad de medida:</td><td  valign="top" >&nbsp;<select name="CbUnidad" class="campos" id="CbUnidad"  tabindex="1"  style="width:150px" onKeyDown="enterxtab(event)"><? if(intval($_SESSION['CbUnidad'])==0){echo '<option value=""></option>';ComboTablaRFX("unidadesmedida","CbUnidad","Nombre","","",$conn);}else{ComboTablaRFROX("unidadesmedida","CbUnidad","Nombre","",$_SESSION['CbUnidad'],"",$conn);} ?></select><label class="MuestraError"> * </label></td></tr>

<tr><td height="18"  align="right"  ></td><td  valign="top" ><input name="ChkInactivo" type="checkbox"  value="1" <? if ($_SESSION['ChkInactivo'] =='1') echo 'checked'; ?>>Inactivo</td></tr>
</table>

<? 
GLO_Hidden('TxtNumero',0);GLO_Hidden('TxtId',0);
GLO_botonesform(600,0,2);
GLO_mensajeerror(); 
?>

