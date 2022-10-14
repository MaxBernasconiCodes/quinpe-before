<? 
//seguridad includes
if(!isset($_SESSION)){include("../../Codigo/SeguridadIncludes.php");}
else{include($_SESSION["NivelArbol"]."Codigo/SeguridadIncludes.php");}


GLO_tituloypath(0,700,'','ASIGNACION','salir');
?>


<table width="700" border="0"   cellspacing="0" class="Tabla" >
<tr> <td width="120" height="5"  ></td> <td width="580"></td> </tr>
<tr> <td height="18"  align="right"  >Asignacion:</td><td>&nbsp;<input  name="TxtNumero" type="text"  readonly="true"  class="TextBoxRO"   value="<? echo $_SESSION['TxtNumero'];?>" style="text-align:right;width:50px"></td></tr>
<tr> <td height="18"  align="right"  >Accesorio:</td><td>&nbsp;<select name="CbInstrumento" style="width:400px"  tabindex="1" class="campos" id="CbInstrumento" > <? if(intval($_SESSION['TxtNroEntidad'])!=0 or intval($_SESSION['TxtNumero'])!=0){ GLO_ComboEquiposRO("CbInstrumento",intval($_SESSION['CbInstrumento']),"accesorios",$conn);}else{ echo '<option value=""></option>';GLO_ComboEquipos("CbInstrumento","accesorios",$conn);} ?> </select><label class="MuestraError"> * </label></td></tr>
</table>


<table width="700" border="0"   cellspacing="0" class="Tabla TMT" >
<tr> <td width="120" height="5"  ></td> <td width="580"></td> </tr>
<tr> <td height="18"  align="right"  >&nbsp;Unidad:</td><td  valign="top" >&nbsp;<select name="CbUnidad" class="campos" id="CbUnidad"  style="width:250px" onKeyDown="enterxtab(event)"><?  if (empty($_SESSION['TxtNumero'])){echo '<option value=""></option>';GLO_ComboActivo("unidades","CbUnidad","Nombre","","",$conn);}else{ComboTablaRFROX("unidades","CbUnidad","Nombre","",$_SESSION['CbUnidad'],"",$conn);} ?> </select><label class="MuestraError"> * </label></td></tr>
<tr> <td height="18"  align="right"  >&nbsp;Autorizado por:</td><td>&nbsp;<select name="CbPersonal" class="campos" id="CbPersonal"  style="width:250px" onKeyDown="enterxtab(event)"><option value=""></option><? ComboPersonalRFX('CbPersonal',$conn); ?></select></td></tr>
</table>


<?
//alta
if(intval($_SESSION['TxtNumero'])==0){
    echo 
    '<table width="700" border="0"   cellspacing="0" class="Tabla TMT" >
    <tr> <td width="120" height="5"  ></td> <td width="100"></td><td width="480"></td> </tr>
    <tr> <td height="18"  align="right"  >Entrega:</td><td>&nbsp;';GLO_calendario("TxtFechaA","../Codigo/","actual",1); echo '</td><td><label class="MuestraError"> * </label> <input name="ChkReq"  tabindex="1"  class="check" type="checkbox"  value="1"';if ($_SESSION['ChkReq'] =='1') {echo 'checked';} echo '>';  GLO_CheckColor('Tiempo indefinido',$_SESSION['ChkReq'],0); echo '</td></tr>
    <tr> <td height="18"  align="right"  >Devolucion pactada:</td><td>&nbsp;';GLO_calendario("TxtFechaE","../Codigo/","actual",1); echo '</td></tr>
    </table>';
}
?>


<?
//modificar
if(intval($_SESSION['TxtNumero'])!=0){
    echo 
    '<table width="700" border="0"   cellspacing="0" class="Tabla TMT" >
    <tr> <td width="120" height="5"  ></td> <td width="580"></td> </tr>
    <tr> <td height="18"  align="right"  >Entrega:</td><td>&nbsp;<input name="TxtFechaA" id="TxtFechaA"  type="text" class="TextBoxRO"  style="width:65px" maxlength="10"  readonly="true"  value="'.$_SESSION['TxtFechaA'].'" > <input name="ChkReq"  tabindex="1"  class="check" type="checkbox"  value="1"';if ($_SESSION['ChkReq'] =='1') {echo 'checked';} echo '>';  GLO_CheckColor('Tiempo indefinido',$_SESSION['ChkReq'],0); echo '</td></tr>
    <tr> <td height="18"  align="right"  >Devolucion pactada:</td><td>&nbsp;';GLO_calendario("TxtFechaE","../Codigo/","actual",1); echo '</td></tr>
    <tr> <td height="18"  align="right"  >Devuelto:</td><td>&nbsp;';GLO_calendario("TxtFechaB","../Codigo/","actual",1); echo '</td></tr>

    </table>';
}
?>


<table width="700" border="0"   cellspacing="0" class="Tabla TMT" >
<tr> <td width="120" height="5"  ></td> <td width="580"></td> </tr>
<tr><td height="18"  align="right"  >Observaciones:</td><td  valign="top" >&nbsp;<input name="TxtObs" type="text"  class="TextBox" style="width:550px" maxlength="100"  value="<? echo $_SESSION['TxtObs']; ?>"></td></tr>
</table>


<?
GLO_Hidden('TxtNroEntidad',0);
GLO_botonesform("700",0,2);
GLO_mensajeerror();

GLO_cierratablaform(); 
mysql_close($conn); 
include ("../Codigo/FooterConUsuario.php");
?>