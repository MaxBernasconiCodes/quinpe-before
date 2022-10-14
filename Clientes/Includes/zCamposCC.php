<? if ($_SESSION["IdPerfilUser"]!=1 and $_SESSION["IdPerfilUser"]!=2 and $_SESSION["IdPerfilUser"]!=5 and $_SESSION["IdPerfilUser"]!=3  and $_SESSION["IdPerfilUser"]!=11  and $_SESSION["IdPerfilUser"]!=12  and $_SESSION["IdPerfilUser"]!=9 and $_SESSION["IdPerfilUser"]!=14 ){ header("Location:".$_SESSION["NivelArbol"]."Inicio.php");}

GLO_tituloypath(0,730,'','CENTRO DE COSTO','salir');
?>

<table width="730" border="0"   cellspacing="0" class="Tabla" >
<tr><td width="100" height="3"  ></td>  <td width="270"></td><td width="90" height="3"  ></td><td width="270"></td></tr>
<tr><td height="18"  align="right"  >Nombre:</td><td  valign="top" >&nbsp;<input name="TxtNombre" type="text"  class="TextBox" style="width:220px" maxlength="30"  value="<? echo $_SESSION['TxtNombre']; ?>" onKeyUp="this.value=this.value.toUpperCase()" /><label class="MuestraError"> * </label></td><td height="18"  align="right"  >Direcci&oacute;n:</td><td  valign="top" >&nbsp;<input name="TxtDir" type="text"  class="TextBox" style="width:230px" maxlength="200"  value="<? echo $_SESSION['TxtDir']; ?>"></td></tr>
<tr><td height="18"  align="right"  >Divisi&oacute;n:</td><td  valign="top" >&nbsp;<input name="TxtDiv" type="text"  class="TextBox" style="width:220px" maxlength="30"  value="<? echo $_SESSION['TxtDiv']; ?>" ></td><td height="18"  align="right"  >Localidad:</td><td  valign="top" >&nbsp;<select name="CbLocalidad" style="width:230px" class="campos" id="CbLocalidad" onChange="this.form.submit()" ><option value=""></option> <? ComboTablaRFX("localidades","CbLocalidad","Nombre","","",$conn);?> </select> </td></tr>
<tr><td height="18"  align="right"  >CUIT:</td><td  valign="top" >&nbsp;<input name="TxtCUIT" type="text"  class="TextBox"  maxlength="13"  style="width:90px" value="<? echo $_SESSION['TxtCUIT']; ?>" /></td><td height="18"  align="right"  >Provincia:</td><td  valign="top" >&nbsp;<input name="TxtProvincia" type="text"  class="TextBoxRO" style="width:175px" maxlength="30" readonly="true" value="<? echo $_SESSION['TxtProvincia']; ?>">&nbsp; <input name="TxtCP" type="text"  class="TextBoxRO" style="width:50px"  readonly="true" value="<? echo $_SESSION['TxtCP']; ?>"></td></tr>
<tr><td height="18"  align="right"  >Imputaci&oacute;n:</td><td  valign="top" >&nbsp;<input name="TxtNroI" type="text"  class="TextBox" style="width:80px" maxlength="8"  value="<? echo $_SESSION['TxtNroI']; ?>" onChange="this.value=validarEntero(this.value);" >  </td><td height="18"  align="right"  >Sector:</td><td  valign="top" >&nbsp;<select name="CbSector" style="width:230px" class="campos" id="CbSector" ><option value=""></option> <? ComboTablaRFX("sector","CbSector","Nombre","","",$conn); ?> </select></td></tr>
</table>



<? 
GLO_Hidden('TxtNroEntidad',0);GLO_Hidden('TxtNumero',0);
GLO_obsform(730,100,'Observaciones','TxtObs',0,1);//ch200
GLO_botonesform("730",0,2);
GLO_mensajeerror();
GLO_cierratablaform(); 
mysql_close($conn); 
?>