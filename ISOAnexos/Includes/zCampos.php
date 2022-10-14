<? 
//seguridad includes
if(!isset($_SESSION)){include("../../Codigo/SeguridadIncludes.php");}
else{include($_SESSION["NivelArbol"]."Codigo/SeguridadIncludes.php");}


GLO_tituloypath(0,700,'../ISO_Anexos.php','DOCUMENTO EXTERNO','linksalir');
?>



<table width="700" border="0"   cellspacing="0" class="Tabla" >
<tr> <td width="80" height="5"  ></td> <td width="620"></td></tr>
<tr><td height="18"  align="right"  >N&uacute;mero:</td><td>&nbsp;<input name="TxtNumero" type="text"  class="TextBoxRO" style="text-align:right;width:50px" readonly="true" value="<? echo $_SESSION['TxtNumero']; ?>"></td></tr>
<tr><td height="18"  align="right"  >&nbsp;Nombre:</td><td>&nbsp;<input name="TxtNombre" type="text" class="TextBox" style="width:550px" maxlength="100"  value="<? echo $_SESSION['TxtNombre']; ?>"> <label class="MuestraError"> * </label></td></tr>
<tr> <td height="18"  align="right"   >Origen:</td><td>&nbsp;<input name="CbOrigen" type="text" class="TextBox" style="width:300px" maxlength="50"  value="<? echo $_SESSION['CbOrigen']; ?>"> </td></tr>
<tr> <td height="18"  align="right"   >Sector:</td><td>&nbsp;<select name="CbSector" class="campos" id="CbSector"  style="width:300px" onKeyDown="enterxtab(event)"><option value=""></option><? ComboTablaRFX("sector","CbSector","Nombre","","",$conn); ?></select> </td></tr>
</table>
