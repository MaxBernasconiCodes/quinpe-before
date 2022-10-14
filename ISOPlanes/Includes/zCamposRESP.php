<? 
//seguridad includes
if(!isset($_SESSION)){include("../../Codigo/SeguridadIncludes.php");}
else{include($_SESSION["NivelArbol"]."Codigo/SeguridadIncludes.php");}



GLO_tituloypath(0,500,'','RESPONSABLE','salir'); 

?>



<table width="500" border="0"  cellspacing="0" class="Tabla" >

<tr><td width="100" height="3"  ></td>  <td width="400"></td></tr>

<tr><td height="18"  align="right"  >Sector:</td><td  valign="top" >&nbsp;<select name="CbSector"  tabindex="1" style="width:300px" class="campos" id="CbSector" ><option value=""></option> <? ComboTablaRFX("sector","CbSector","Nombre","","",$conn); ?> </select><label class="MuestraError"> * </label></td></tr>

</table>



<?

GLO_Hidden('TxtNumero',0);GLO_Hidden('TxtNroEntidad',0);GLO_Hidden('TxtNroEntidad2',0);

GLO_botonesform("500",0,2); 

GLO_mensajeerror();

?>