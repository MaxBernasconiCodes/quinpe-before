<? 
//seguridad includes
if(!isset($_SESSION)){include("../../Codigo/SeguridadIncludes.php");}
else{include($_SESSION["NivelArbol"]."Codigo/SeguridadIncludes.php");}

?>

<!-- creacion -->
<table width="725" border="0"   cellspacing="0" class="Tabla TMT" >
<tr> <td width="80" height="5"  ></td> <td width="280"></td><td width="85" height="5"  ></td> <td width="280"></td> </tr>
<tr><td height="18"  align="left" colspan="2" >&nbsp;<strong>Creaci&oacute;n:</strong></td><td align="right" colspan="2" >
<? 
//ve abrir si es perf.coord/admin y el estado es 0(elaborado)/3(rev.control)
if ((($_SESSION["IdPerfilUser"]==1 or $_SESSION["IdPerfilUser"]==2 or $_SESSION["IdPerfilUser"]==4 or $_SESSION["IdPerfilUser"]==3  or $_SESSION["IdPerfilUser"]==9 or $_SESSION["IdPerfilUser"]==14)) and ($_SESSION['TxtIdEstado']==0 or $_SESSION['TxtIdEstado']==3) and  (!(empty($_SESSION['TxtArchivo']))) ){
	echo GLO_FAButton('CmdAbrir','submit','80','self','Abrir','','boton03');
}
?>
&nbsp;</td></tr>
<tr> <td height="18"  align="right"  >Personal:</td><td> &nbsp; <input name="TxtPers1" type="text"  class="TextBoxRO" style="width:250px" readonly="true" value="<? echo $_SESSION['TxtPers1']; ?>"></td><td align="right"  >Fecha:</td><td> &nbsp; 
<? 
//perfil y estado
if( ($_SESSION["IdPerfilUser"]!=1 and $_SESSION["IdPerfilUser"]!=2 and $_SESSION["IdPerfilUser"]!=4 and $_SESSION["IdPerfilUser"]!=3  and $_SESSION["IdPerfilUser"]!=11  and $_SESSION["IdPerfilUser"]!=12  and $_SESSION["IdPerfilUser"]!=9 and $_SESSION["IdPerfilUser"]!=14) or ($_SESSION['TxtIdEstado']==6) ){
	//dejar solo lectura
	echo '<input name="TxtFecha1" type="text"  class="TextBoxRO" style="width:70px" readonly="true" value="'.$_SESSION['TxtFecha1'].'">';
}else{
	//modificar
	echo '<input name="TxtFecha1" id="TxtFecha1"  type="text" class="TextBox"  style="width:70px" maxlength="10"  onchange="this.value=validarFecha(this.value);" value="'.$_SESSION['TxtFecha1'].'"   ><label class="MuestraError"> * </label>';	  calendario("TxtFecha1","../Codigo/","actual");
}

?>
</td></tr>
<tr> <td height="18"  align="right"  >Proveedor:</td><td> &nbsp; <input name="TxtProv1" type="text"  class="TextBoxRO" style="width:250px" readonly="true" value="<? echo $_SESSION['TxtProv1']; ?>"></td><td></td><td></td></tr>
<tr> <td height="18"  align="right"  valign="top" >Comentario:</td><td colspan="3" valign="top" > &nbsp; <textarea name="TxtCom1" style="resize:none;width:600px" rows="1" <? if(($_SESSION["IdPerfilUser"]!=1 and $_SESSION["IdPerfilUser"]!=2 and $_SESSION["IdPerfilUser"]!=4 and $_SESSION["IdPerfilUser"]!=3  and $_SESSION["IdPerfilUser"]!=11  and $_SESSION["IdPerfilUser"]!=12  and $_SESSION["IdPerfilUser"]!=9 and $_SESSION["IdPerfilUser"]!=14) or ($_SESSION['TxtIdEstado']!=0 and $_SESSION['TxtIdEstado']!=3)){echo'readonly="true" class="TextBoxRO"';}else{echo'class="TextBox"';} ?> onKeyPress="event.cancelBubble=true;"><? echo $_SESSION['TxtCom1']; ?></textarea></td></tr>
</table>
