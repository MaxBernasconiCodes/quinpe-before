<? if ($_SESSION["IdPerfilUser"]!=1 and $_SESSION["IdPerfilUser"]!=2 and $_SESSION["IdPerfilUser"]!=3 and $_SESSION["IdPerfilUser"]!=9 and $_SESSION["IdPerfilUser"]!=14 ){ header("Location:".$_SESSION["NivelArbol"]."Inicio.php");}


GLO_tituloypath(0,700,'','DETALLE SEGUIMIENTO','salir'); 
?>



<table width="700" border="0"   cellspacing="0" class="Tabla" >
<tr> <td width="100" height="5"  ></td> <td width="100"></td><td width="500"></td> </tr>
<tr> <td height="18"  align="right"  >&nbsp;Fecha:</td><td> &nbsp; <? GLO_calendario("TxtFechaA","../Codigo/","actual",1) ?></td><td><label class="MuestraError"> * </label></td></tr>
<tr><td height="18"  align="right"  >Detalle:</td><td colspan="2"> &nbsp; <input name="TxtObs" type="text"  class="TextBox" style="width:550px" maxlength="200"  value="<? echo $_SESSION['TxtObs']; ?>"><label class="MuestraError"> * </label></td></tr>
<tr> <td height="18"  align="right"  >Personal:</td><td colspan="2"> &nbsp; <select name="CbPersonal" class="campos" id="CbPersonal"  style="width:250px" onKeyDown="enterxtab(event)"><option value=""></option><? ComboPersonalRFX('CbPersonal',$conn); ?></select></td></tr>
<tr> <td height="18"  align="right"  >Estado:</td><td colspan="2"> &nbsp; <select name="CbEstado" class="campos" id="CbEstado"  style="width:100px" onKeyDown="enterxtab(event)"><? ComboTablaRFX("inspecciones_det_est","CbEstado","Nombre desc","","",$conn); ?></select><input  name="TxtNumero" type="hidden" value="<? echo $_SESSION['TxtNumero']; ?>"><input  name="TxtNroEntidad"  type="hidden"   value="<? echo $_SESSION['TxtNroEntidad']; ?>"></td></tr>
<tr> <td height="18"  align="right"  >Cumplimiento:</td><td colspan="2"> &nbsp; <? GLO_calendario("TxtFechaB","../Codigo/","actual",1) ?></td></tr>
</table>


<? 
GLO_botonesform("700",0,2); 
GLO_mensajeerror();
?>