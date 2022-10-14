<? 
//seguridad includes
if(!isset($_SESSION)){include("../Codigo/SeguridadIncludes.php");}
else{include($_SESSION["NivelArbol"]."Codigo/SeguridadIncludes.php");}

?>


<table width="700" border="0"   cellspacing="0" class="Tabla TMT" >
<tr> <td width="90" height="3"  ></td> <td width="260"></td><td width="100"></td> <td width="250"></td> </tr>
<tr><td align="right" >&nbsp;Proveedor:</td><td  valign="top"  colspan="3">&nbsp;<select name="CbProveedor" class="campos" id="CbProveedor"  style="width:200px" onKeyDown="enterxtab(event)"><? ComboProveedorRFROX("CbProveedor",$_SESSION['CbProveedor'],"",$conn); ?></select><label class="MuestraError"> * </label></td></tr>
</table> 
