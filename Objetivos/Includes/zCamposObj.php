<? 
//seguridad includes
if(!isset($_SESSION)){include("../../Codigo/SeguridadIncludes.php");}
else{include($_SESSION["NivelArbol"]."Codigo/SeguridadIncludes.php");}

GLO_tituloypath(0,750,'Consulta.php?ido='.$_SESSION['TxtNroEntidad'],OBJ_titulo($_SESSION['TxtNroEntidad']),'linksalir');

?>
<table width="750" border="0"   cellspacing="0" class="Tabla" >
<tr> <td width="100" height="5"  ></td> <td width="100"></td><td width="260"></td><td width="270"></td></tr>
<tr><td height="18"  align="right"  >A&ntilde;o:</td><td valign="top" >&nbsp;<input name="TxtAnio" type="text"  tabindex="1"  class="TextBox" style="width:65px" maxlength="4"  value="<? echo $_SESSION['TxtAnio']; ?>" onChange="this.value=validarEntero(this.value);" ><label class="MuestraError"> * </label></td><td align="right"  >Ultima actualizacion:&nbsp;<? GLO_calendario("TxtFechaA","../Codigo/","actual",1) ?></td><td></td></tr>
<tr><td height="18"  align="right"  >Titulo:</td><td valign="top" colspan="3">&nbsp;<input name="TxtTitulo" type="text" class="TextBox" style="width:367px"  tabindex="1" maxlength="40"  value="<? echo $_SESSION['TxtTitulo']; ?>"></td></tr>
</table>

<table width="750" border="0"  cellspacing="0" class="Tabla TMT" >
<tr> <td height="10"></td></tr>
<tr> <td  valign="top" align="center"><textarea name="TxtTexto" style="width:710px" rows="20" class="TextBox" tabindex="1" onKeyPress="event.cancelBubble=true;"><? echo $_SESSION["TxtTexto"]; ?></textarea></td></tr>
<tr> <td height="10"></td></tr>
</table>

<? 
GLO_Hidden('TxtNumero',0);GLO_Hidden('TxtNroEntidad',0);
GLO_guardar("750",2,0);
GLO_mensajeerror();
?>