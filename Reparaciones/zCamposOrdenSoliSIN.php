<? 
//seguridad includes
if(!isset($_SESSION)){include("../Codigo/SeguridadIncludes.php");}
else{include($_SESSION["NivelArbol"]."Codigo/SeguridadIncludes.php");}


?>



	

<table width="750" border="0"  cellspacing="0" class="Tabla TMT" >

<tr><td width="100" height="3"  ></td> <td width="130"></td> <td width="90"></td><td width="100"></td><td width="100" height="3"  ></td> <td width="230"></td> </tr>

<tr> <td height="18"  align="right"  >Nro.Solicitud:</td><td  valign="top">&nbsp;<select name="CbSoli" style="width:65px" class="campos" id="CbSoli" > <? ComboSolicitudes($conn) ?> </select></td><td colspan="2" ><? if ( (intval($_SESSION['CbSoli'])==0)){ echo '<input name="CmdAltaSoli" type="submit" class="boton02" value="Alta Solicitud" onClick="document.Formulario.target='."'_self'".'">&nbsp;';} ?></td><td height="18"  align="right"  ></td><td  valign="top" >&nbsp;</td></tr>

</table>





