<? 
//seguridad includes
if(!isset($_SESSION)){include("../../Codigo/SeguridadIncludes.php");}
else{include($_SESSION["NivelArbol"]."Codigo/SeguridadIncludes.php");}

?>

<table width="720" border="0"  cellspacing="0" class="Tabla" >
<tr><td width="100" height="3"  ></td> <td width="320"></td><td width="120" height="3"  ></td> <td width="180"></td> </tr>

<tr> <td height="18"  align="right"  >N&uacute;mero:</td><td  valign="top">&nbsp;<input  name="TxtNumero" type="text"  readonly="true"  class="TextBoxRO"   value="<? echo $_SESSION['TxtNumero'];?>" style="text-align:right;width:50px"></td><td  align="right"  >Fabricacion:</td><td  valign="top" >&nbsp;<? GLO_calendario("TxtFechaF","../Codigo/","actual",2) ?></td></tr>

<tr><td height="18"  align="right"  >Nombre:</td><td  valign="top">&nbsp;<input name="TxtNombre" type="text"  class="TextBox" style="width:280px;" maxlength="50"  tabindex="1"   value="<? echo $_SESSION['TxtNombre']; ?>" onKeyUp="this.value=this.value.toUpperCase()" /><label class="MuestraError"> * </label></td><td  align="right"  >Inspeccion:</td><td  valign="top" >&nbsp;<? GLO_calendario("TxtFechaI","../Codigo/","actual",2) ?></td></tr>

<tr><td height="18"  align="right"  >Elemento:</td><td  valign="top">&nbsp;<select name="CbInstrumento" style="width:280px"  tabindex="1" class="campos" id="CbInstrumento" ><option value=""></option> <? ComboTablaRFX("accesorios_tipo","CbInstrumento","Nombre","","",$conn); ?> </select><label class="MuestraError"> * </label></td><td  align="right"  >Vto.Inspeccion:</td><td  valign="top" >&nbsp;<? GLO_calendariovto("TxtFechaV","../Codigo/","actual",2) ?></td></tr>


</table>



<table width="720" border="0"  cellspacing="0" class="Tabla TMT" >
<tr><td width="100" height="3"  ></td> <td width="320"></td> <td width="250"></td><td width="50"></td> </tr>

<tr><td height="18"  align="right"  >Modelo:</td><td  valign="top">&nbsp;<input name="TxtModelo" type="text"  class="TextBox" style="width:280px" maxlength="50"  tabindex="1"  value="<? echo $_SESSION['TxtModelo']; ?>"></td><td rowspan="5" valign="middle" align="right">
<? if($_SESSION['TxtFoto']!=''){ echo '<img src="'.'../Codigo/OpenImage.php?id='.'../Archivos/Accesorios/'.$_SESSION['TxtFoto'].'" style="height:91px;width:auto;border-radius:4px;">';}?>
</td><td align="right">
<? if (intval($_SESSION['TxtNumero'])!=0){echo GLO_FAButton('CmdArchivo','submit','','self','Explorar','folder','iconbtn').'&nbsp;&nbsp;';}?>
</td></tr>

<tr><td height="18"  align="right"  >Nro.Serie:</td><td  valign="top">&nbsp;<input name="TxtNSE" type="text"  class="TextBox" style="width:280px" maxlength="30"  tabindex="3"  value="<? echo $_SESSION['TxtNSE']; ?>"></td><td align="right"><? if (intval($_SESSION['TxtNumero'])!=0 and !(empty($_SESSION['TxtFoto']))){echo GLO_FAButton('CmdVerFoto','submit','','blank','Ver','lupa','iconbtn').'&nbsp;&nbsp;';} ?></td></tr>

<tr><td height="18"  align="right"  >Fabricante:</td><td  valign="top">&nbsp;<select name="CbFabr" tabindex="3"  style="width:280px" class="campos" id="CbFabr" ><option value=""></option> <? ComboTablaRFX("unidadesfabric","CbFabr","Nombre","","",$conn); ?> </select></td><td align="right"><? if (intval($_SESSION['TxtNumero'])!=0 and !(empty($_SESSION['TxtFoto']))){echo GLO_FAButton('CmdBorrarFoto','submit','','self','Borrar','trash','iconbtn').'&nbsp;&nbsp;';} ?></td></tr>
<tr><td height="18"  align="right"  >Lote:</td><td  valign="top">&nbsp;<input name="TxtLote" type="text"  class="TextBox" style="width:100px" maxlength="15"  tabindex="4"  value="<? echo $_SESSION['TxtLote']; ?>"></td><td></td></tr>

<tr><td height="18"  align="right"  >Baja:</td><td  valign="top">&nbsp;<? GLO_calendario("TxtFechaB","../Codigo/","actual",2) ?></td><td></td></tr>

</table>




<? 
GLO_Hidden('TxtId',0);GLO_Hidden('TxtFoto',0);
GLO_obs(720,100,'Observaciones','TxtObs',2,0,5); 
GLO_guardar("720",6,0);
GLO_mensajeerror();


//adjuntos
if (intval($_SESSION['TxtNumero'])!=0){
    echo '<table width="720" border="0"  cellpadding="0" cellspacing="0">
    <tr> <td height="10" ></td></tr>
    <tr ><td height="18" ><i class="fa fa-truck iconsmallsp iconlgray"></i> <strong>Asignaciones:</strong></td></tr>
    <tr> <td  align="center">';MostrarTablaItems($_SESSION['TxtNumero'],$conn); echo '</td></tr>
    <tr> <td height="20"></td></tr>
    <tr ><td height="18" ><i class="fa fa-id-card iconsmallsp iconlgray"></i> <strong>Certificaciones:</strong></td></tr>
    <tr> <td  align="center">';MostrarTablaCE($_SESSION['TxtNumero'],$conn); echo '</td></tr>
    </table>';
}



?>
