<? 
//seguridad includes
if(!isset($_SESSION)){include("../../Codigo/SeguridadIncludes.php");}
else{include($_SESSION["NivelArbol"]."Codigo/SeguridadIncludes.php");}

GLO_tituloypath(0,600,'','PARTICIPANTE','salir'); 
?>

<table width="600" border="0"  cellspacing="0" class="Tabla" >
<tr><td width="100" height="3"  ></td>  <td width="500"></td></tr>
<tr><td height="18"  align="right"  >Nombre:</td><td  valign="top" >&nbsp;<input name="TxtNombre" type="text" class="TextBox" style="width:450px" maxlength="50"  value="<? echo $_SESSION['TxtNombre']; ?>" ><label class="MuestraError"> * </label></td></tr>
<tr><td height="18"  align="right"  >Empresa:</td><td  valign="top" >&nbsp;<input name="TxtObs" type="text" class="TextBox" style="width:450px" maxlength="50"  value="<? echo $_SESSION['TxtObs']; ?>" onkeyup="this.value=this.value.toUpperCase()"> </td></tr>
</table>

<?
GLO_Hidden('TxtNumero',0);GLO_Hidden('TxtNroEntidad',0);
GLO_botonesform("600",0,2); 
GLO_mensajeerror();
?>