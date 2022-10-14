<? //perfiles
if ($_SESSION["IdPerfilUser"]!=1 and $_SESSION["IdPerfilUser"]!=2 and $_SESSION["IdPerfilUser"]!=3  and $_SESSION["IdPerfilUser"]!=11  and $_SESSION["IdPerfilUser"]!=12 and $_SESSION["IdPerfilUser"]!=4   and $_SESSION["IdPerfilUser"]!=9 and $_SESSION["IdPerfilUser"]!=14   and $_SESSION["IdPerfilUser"]!=13){ header("Location:".$_SESSION["NivelArbol"]."Inicio.php");}


?>

<table width="600" border="0"  cellspacing="0" class="Tabla">
<tr> <td width="100" height="5"  ></td> <td width="500"></td> </tr>
<tr><td height="18"  align="right"  >Nombre:</td><td  valign="top" >&nbsp;<input  name="TxtNombre" type="text" class="TextBox" style="width:300px" maxlength="30"  tabindex="1" value="<? echo $_SESSION['TxtNombre']; ?>" onKeyUp="this.value=this.value.toUpperCase()" <? GLO_keypress(0);?>> <label class="MuestraError"> * </label></td></tr>
<tr><td height="18"  align="right"  >CP:</td><td  valign="top" >&nbsp;<input name="TxtCP" type="text" class="TextBox" tabindex="1" style="width:80px" maxlength="10"  value="<? echo $_SESSION['TxtCP']; ?>" <? GLO_keypress(0);?>> 	</td></tr>
<tr><td height="21"  align="right"  >Provincia:</td><td  valign="top" >&nbsp;<select name="CbPcia"  class="campos" id="CbPcia" tabindex="1" style="width:300px"><option value=""></option> <? ComboTablaRFX("provincias","CbPcia","Nombre","","",$conn); ?> </select> <label class="MuestraError"> * </label>  <? GLO_CmdAddRefresh('Prov',0);?></td></tr>
</table>

<? 
GLO_Hidden('TxtNumero',0);
?>