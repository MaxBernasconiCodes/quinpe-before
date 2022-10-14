<? if ($_SESSION["IdPerfilUser"]!=1 and $_SESSION["IdPerfilUser"]!=2  and $_SESSION["IdPerfilUser"]!=3  and $_SESSION["IdPerfilUser"]!=9 and $_SESSION["IdPerfilUser"]!=14){ header("Location:".$_SESSION["NivelArbol"]."Inicio.php");}


GLO_tituloypath(0,620,'','PERSONAS INVOLUCRADAS','salir');
?>


<table width="620" border="0"  cellspacing="0" class="Tabla" >
<tr><td width="120" height="3"  ></td>  <td width="500"></td></tr>
<tr><td height="18"  align="right"  >Personal Empresa:</td><td  valign="top" >&nbsp;<select name="CbPersonal" class="campos" id="CbPersonal"  style="width:450px" onKeyDown="enterxtab(event)"><option value=""></option><? ComboPersonalRFX('CbPersonal',$conn); ?></select> <label class="MuestraError"> * </label></td></tr>
<tr><td height="18"  align="right"  >Personal Externo:</td><td  valign="top" >&nbsp;<input name="TxtNombre" type="text" class="TextBox" style="width:450px" maxlength="100"  value="<? echo $_SESSION['TxtNombre']; ?>" onKeyUp="this.value=this.value.toUpperCase()"> </td></tr>
<tr><td height="18"  align="right"  >Observaciones:</td><td  valign="top" >&nbsp;<input name="TxtObs" type="text" class="TextBox" style="width:450px" maxlength="100"  value="<? echo $_SESSION['TxtObs']; ?>" > </td></tr>
</table>

<?
GLO_Hidden('TxtNumero',0);GLO_Hidden('TxtNroEntidad',0);
GLO_guardar("620",1,0); 
GLO_mensajeerror();
?>