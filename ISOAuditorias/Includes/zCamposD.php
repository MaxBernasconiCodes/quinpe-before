<? 
//seguridad includes
if(!isset($_SESSION)){include("../../Codigo/SeguridadIncludes.php");}
else{include($_SESSION["NivelArbol"]."Codigo/SeguridadIncludes.php");}



?>

<? GLO_tituloypath(0,700,'','DESVIO','salir'); ?>

<table width="700" border="0"   cellspacing="0" class="Tabla" >
<tr> <td width="100" height="5"  ></td> <td width="600"></td> </tr>
<tr> <td height="18"  align="right"  >Observaci&oacute;n:</td><td  valign="top" > &nbsp; <select name="CbDesvio" style="width:300px" class="campos" id="CbDesvio" ><option value=""></option><? ISOAUDI_CbDesvios("CbDesvio","iso_audi_desvios",$conn); ?></select><label class="MuestraError"> * </label></td>					</tr>
<tr> <td height="18"  align="right"  >Descripci&oacute;n:</td><td  valign="top" > &nbsp; <input name="TxtDesc" type="text" class="TextBox" style="width:550px" maxlength="200"  value="<? echo $_SESSION['TxtDesc']; ?>"></td></tr>
<tr> <td height="18"  align="right"  >Acci&oacute;n:</td><td  valign="top" > &nbsp; <input name="TxtAccion" type="text" class="TextBox" style="width:550px" maxlength="200"  value="<? echo $_SESSION['TxtAccion']; ?>"></td>
</tr>
</table>

<? 
GLO_Hidden('TxtNroEntidad',0);GLO_Hidden('TxtNumero',0);
GLO_botonesform("700",0,2); 
GLO_mensajeerror();
GLO_cierratablaform();
mysql_close($conn); 
?> 
