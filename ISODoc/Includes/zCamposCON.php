<? 
//seguridad includes
if(!isset($_SESSION)){include("../../Codigo/SeguridadIncludes.php");}
else{include($_SESSION["NivelArbol"]."Codigo/SeguridadIncludes.php");}

?>

<!-- control -->
<table width="725" border="0"   cellspacing="0" class="Tabla TMT" >
<tr> <td width="80" height="5"  ></td> <td width="280"></td><td width="85" height="5"  ></td> <td width="280"></td> </tr>
<tr><td height="18"  align="left" colspan="2" >&nbsp;<strong>Control:</strong></td><td align="right" colspan="2" >

<? //ve abrir si es controlador y el estado es 1(abierto)/5(rev.aprob)
if ( (($_SESSION["GLO_IdPersLog"]==$_SESSION['TxtIdPers2']) or $_SESSION["IdPerfilUser"]==1) and ($_SESSION['TxtIdEstado']==1 or $_SESSION['TxtIdEstado']==5)){
	echo GLO_FAButton('CmdControl','submit','80','self','Controlar','','boton03').'&nbsp;'.GLO_FAButton('CmdRControl','submit','80','self','Corregir','','boton05');
}
?>

&nbsp;</td></tr>
<tr> <td height="18"  align="right"  >Responsable:</td><td> &nbsp; <input name="TxtPers2" type="text"  class="TextBoxRO" style="width:250px" readonly="true" value="<? echo $_SESSION['TxtPers2']; ?>"></td><td align="right"  >Fecha:</td><td> &nbsp; 
<?
//valida perfil y estado
if( ($_SESSION["IdPerfilUser"]!=1 and $_SESSION["IdPerfilUser"]!=2 and $_SESSION["IdPerfilUser"]!=4 and $_SESSION["IdPerfilUser"]!=3  and $_SESSION["IdPerfilUser"]!=11  and $_SESSION["IdPerfilUser"]!=12  and $_SESSION["IdPerfilUser"]!=9 and $_SESSION["IdPerfilUser"]!=14)  or ($_SESSION['TxtIdEstado']==0 or $_SESSION['TxtIdEstado']==1 or $_SESSION['TxtIdEstado']==6) ){
	//dejar solo lectura
	echo '<input name="TxtFecha2" type="text"  class="TextBoxRO" style="width:70px" readonly="true" value="'.$_SESSION['TxtFecha2'].'">';
}else{
	//modificar fecha
	echo '<input name="TxtFecha2" id="TxtFecha2"  type="text" class="TextBox"  style="width:70px" maxlength="10"  onchange="this.value=validarFecha(this.value);" value="'.$_SESSION['TxtFecha2'].'"   ><label class="MuestraError"> * </label>';
	calendario("TxtFecha2","../Codigo/","actual");
}

?>
</td></tr>
<tr> <td height="18"  align="right"  valign="top" >Comentario:</td><td colspan="3" valign="top" > &nbsp; <textarea name="TxtCom2" style="resize:none;width:600px" rows="1" onKeyPress="event.cancelBubble=true;" <? if($_SESSION["GLO_IdPersLog"]!=$_SESSION['TxtIdPers2']  or ($_SESSION['TxtIdEstado']!=1 and $_SESSION['TxtIdEstado']!=5)){echo'readonly="true" class="TextBoxRO"';}else{echo'class="TextBox"';} ?>><? echo $_SESSION['TxtCom2']; ?></textarea></td></tr>
</table>
