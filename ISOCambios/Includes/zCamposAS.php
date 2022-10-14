<? 
//seguridad includes
if(!isset($_SESSION)){include("../../Codigo/SeguridadIncludes.php");}
else{include($_SESSION["NivelArbol"]."Codigo/SeguridadIncludes.php");}


?>

<? GLO_tituloypath(950,600,'sgi','INTEGRANTES','salir'); ?>

<table width="600" border="0"  cellspacing="0" class="Tabla" >
<tr><td width="100" height="3"  ></td>  <td width="500"></td></tr>
<tr><td height="18"  align="right"  >Personal:</td><td  valign="top" >&nbsp;<select name="CbPersonal" class="campos" id="CbPersonal"  style="width:450px" onKeyDown="enterxtab(event)"><option value=""></option><? ComboPersonalRFX('CbPersonal',$conn); ?></select> <label class="MuestraError"> * </label></td></tr>
</table>

<?
GLO_Hidden('TxtNumero',0);GLO_Hidden('TxtNroEntidad',0);
GLO_botonesform("600",0,2); 
GLO_mensajeerror();
?>