<? if ($_SESSION["IdPerfilUser"]!=1 and $_SESSION["IdPerfilUser"]!=2 and $_SESSION["IdPerfilUser"]!=5 and $_SESSION["IdPerfilUser"]!=3  and $_SESSION["IdPerfilUser"]!=11  and $_SESSION["IdPerfilUser"]!=12  and $_SESSION["IdPerfilUser"]!=9 and $_SESSION["IdPerfilUser"]!=14 ){ header("Location:".$_SESSION["NivelArbol"]."Inicio.php");}

GLO_tituloypath(0,700,'','UTE','salir');
?>

<table width="700" border="0"   cellspacing="0" class="Tabla" >
<tr><td width="100" height="3"  ></td>  <td width="600"></td></tr>
<tr><td height="18"  align="right">Razon Social:</td><td>&nbsp;<input name="TxtNombre" type="text"  class="TextBox" style="width:500px" maxlength="100"  value="<? echo $_SESSION['TxtNombre']; ?>" onKeyUp="this.value=this.value.toUpperCase()" /><label class="MuestraError"> * </label></td></tr>
<tr><td height="18"  align="right">CUIT:</td><td>&nbsp;<input name="TxtCUIT" type="text"  class="TextBox"  maxlength="13"  tabindex="2"  style="width:120px" value="<? echo $_SESSION['TxtCUIT']; ?>" /><label class="MuestraError"> * </label></td></tr>
<tr><td height="18"  align="right">Cond.IVA:</td><td>&nbsp;<select name="CbIva" style="width:120px" class="campos" id="CbIva"  tabindex="2" ><option value=""></option> <? ComboTablaRFX("condicioniva","CbIva","Nombre","","",$conn); ?> </select></td></tr>
</table>



<table width="700" border="0"   cellspacing="0" class="Tabla TMT" >
<tr><td width="100" height="3"  ></td>  <td width="600"></td></tr>
<tr><td height="18"  align="right">Direccion:</td><td>&nbsp;<input name="TxtDir" type="text"  class="TextBox" style="width:500px" maxlength="200"  value="<? echo $_SESSION['TxtDir']; ?>"></td></tr>
<tr><td height="18"  align="right">Localidad:</td><td>&nbsp;<select name="CbLocalidad" style="width:500px" class="campos" id="CbLocalidad" onChange="this.form.submit()" ><option value=""></option> <? ComboTablaRFX("localidades","CbLocalidad","Nombre","","",$conn);?> </select></td></tr>
<tr><td height="18"  align="right">Provincia:</td><td>&nbsp;<input name="TxtProvincia" type="text"  class="TextBoxRO" style="width:395px" maxlength="30" readonly="true" value="<? echo $_SESSION['TxtProvincia']; ?>">&nbsp; <input name="TxtCP" type="text"  class="TextBoxRO" style="width:100px"  readonly="true" value="<? echo $_SESSION['TxtCP']; ?>"></td></tr>
</table>


<? 
GLO_Hidden('TxtNroEntidad',0);GLO_Hidden('TxtNumero',0);
GLO_botonesform("700",0,2);
GLO_mensajeerror();
GLO_cierratablaform(); 
mysql_close($conn); 
?>