<? 
//seguridad includes
if(!isset($_SESSION)){include("../../Codigo/SeguridadIncludes.php");}
else{include($_SESSION["NivelArbol"]."Codigo/SeguridadIncludes.php");}





GLO_tituloypath(0,700,'../ISO_Planes.php','PLAN DE ACCION','linksalir');

?>



<table width="700" border="0"   cellspacing="0"  class="Tabla">

<tr><td width="100" height="3" ></td><td width="300" ></td><td width="300" ></td></tr>

<tr> <td  align="right" height="18">Fecha:</td><td>&nbsp;<? GLO_calendario("TxtFecha","../Codigo/","actual",1) ?></td><td align="right"><? if(intval($_SESSION['TxtNumero'])!=0){ echo '<input name="CmdTareas" type="submit" class="boton02"  value="Tareas" onClick="document.Formulario.target='."'_self'".'">&nbsp;<input name="CmdHistorial" type="submit" class="boton02"  value="Historial" onClick="document.Formulario.target='."'_self'".'">&nbsp;';} ?></td></tr>

<tr> <td  align="right" height="18">Codigo:</td><td colspan="2">&nbsp;<input name="TxtCodigo" type="text"  tabindex="1" class="TextBox" style="width:80px" maxlength="10"  value="<? echo $_SESSION['TxtCodigo']; ?>" onkeyup="this.value=this.value.toUpperCase()" ><label class="MuestraError"> * </label></td></tr>

<tr> <td  align="right" height="18">Sector:</td><td colspan="2">&nbsp;<select name="CbSector"  tabindex="1" style="width:250px;" class="campos" id="CbSector" ><option value=""></option> <? ComboTablaRFX("sector","CbSector","Nombre","","",$conn); ?> </select></td></tr>

<tr> <td  align="right" height="18">Referencia:</td><td colspan="2">&nbsp;<input name="TxtNombre" type="text" class="TextBox"   tabindex="1"  style="width:540px" maxlength="100"  value="<? echo $_SESSION['TxtNombre']; ?>" ><label class="MuestraError"> * </label></td></tr>

</table>



<?

GLO_Hidden('TxtNumero',0);GLO_Hidden('TxtId',0);

GLO_botonesform("700",0,2); 

GLO_mensajeerror();

?>