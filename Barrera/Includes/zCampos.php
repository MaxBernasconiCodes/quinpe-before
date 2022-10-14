<? 
//seguridad includes
if(!isset($_SESSION)){include("../../Codigo/SeguridadIncludes.php");}
else{include($_SESSION["NivelArbol"]."Codigo/SeguridadIncludes.php");}

//modificar propios y terceros vehiculo

GLO_tituloypath(0,760,'','BARRERA '.$nometapa,'salir');
GLO_mensajeerrorE();
?>

<table width="760" border="0"  cellspacing="0" class="Tabla" >
<tr> <td width="110" height="5"  ></td> <td width="100"></td><td width="200"></td><td width="110"></td><td width="110"></td> <td width="140"></td></tr>
<tr> <td height="18"  align="right"  >Fecha:</td><td >&nbsp;<?php  GLO_calendario("TxtFechaA","../Codigo/","actual",1); ?></td><td>&nbsp;<input name="TxtHora"   id="time" type="text"  class="TextBox"  style="width:50px" maxlength="5"  tabindex="1" value="<? echo $_SESSION['TxtHora']; ?>" onChange="this.value=validarHora(this.value);">&nbsp;<select name="CbEtapa" class="campos TBold <? if(intval($_SESSION['CbEtapa'])==1){echo 'TBlue';}else{echo 'TGreen';} ?>" id="CbEtapa"  style="width:80px;"  tabindex="2" onKeyDown="enterxtab(event)"><? echo PROC_CbTipoEtapa('CbEtapa',1);?></select></td><td align="right"  >Propietario Camion:</td><td>&nbsp;<select name="CbTipo" class="campos" id="CbTipo"  style="width:80px"  tabindex="2" onKeyDown="enterxtab(event)"><? echo PROC_CbTipoUnidad('CbTipo');?></select></td><td></td></tr>

<tr> <td height="18"  align="right"  >Cliente Solicitud:</td><td colspan="2">&nbsp;<select name="CbCliente2"  class="campos" id="CbCliente2"  tabindex="1" style="width:250px" onKeyDown="enterxtab(event)"><? if (intval($_SESSION['TxtNroEntidad'])==0 and intval($_SESSION['CbEtapa'])==1){echo '<option value=""></option> ';GLO_ComboActivo("clientes","CbCliente2","Nombre","","",$conn);}else{ComboTablaRFROX("clientes","CbCliente2","Nombre","",$_SESSION['CbCliente2'],"",$conn);} ?></select></td><td align="right"  ><? if(intval($_SESSION['CbEtapa'])==2){ echo 'Pedido:';}?></td><td>
<? 
if(intval($_SESSION['CbEtapa'])==2){ echo '&nbsp;<input name="TxtNroPedido" type="text"  class="TextBoxRO" style="text-align:right;width:50px" readonly="true" value="'.$_SESSION['TxtNroPedido'].'">';}
//ingreso+propio muestra retorno
if( intval($_SESSION['CbEtapa'])==1 and intval($_SESSION['CbTipo'])==1 ){
	echo '<input name="ChkRE"  type="checkbox" class="check"  value="1"';if ($_SESSION['ChkRE'] =='1') echo 'checked'; 
	echo '>';GLO_CheckColor('Retorno',$_SESSION['ChkRE'],0);
}
?>
</td><td>
</td></tr>

<tr> <td height="18"  align="right"  >Solicitud:</td><td colspan="2">&nbsp;<?
//ingreso muestra
if(intval($_SESSION['CbEtapa'])==1){
	echo '<input  name="TxtNroEntidad" type="text"  readonly="true"  class="TextBoxRO"   value="'.$_SESSION['TxtNroEntidad'].'" style="text-align:right;width:50px">&nbsp;';
}


//egreso selecciona
if(intval($_SESSION['CbEtapa'])==2){
	echo '<select name="TxtNroEntidad" style="width:250px" class="campos" id="TxtNroEntidad"  tabindex="1">'; if(intval($_SESSION['TxtNroEntidad'])==0 or $tieneitems==0){echo '<option value=""></option>';GLO_CbComprobanteV("procesosop","TxtNroEntidad","a.Id",6,"","and a.Estado=0",$conn);}else{GLO_CbComprobanteRO("procesosop","TxtNroEntidad","Id","",6,$_SESSION['TxtNroEntidad'],"",$conn);} echo '</select>&nbsp;';
}

//ingreso, si no tiene solicitud 
if(intval($_SESSION['CbEtapa'])==1 and intval($_SESSION['TxtNumero'])!=0 and intval($_SESSION['TxtNroEntidad'])==0){
	echo GLO_FAButton("CmdAltaSoli",'submit','100','self','Alta Solicitud','add','boton02');
}
//ingreso, si tiene solicitud y no tiene items
if(intval($_SESSION['CbEtapa'])==1 and intval($_SESSION['TxtNumero'])!=0 and intval($_SESSION['TxtNroEntidad'])!=0 and $tieneitems==0){
	echo GLO_FAButton("CmdBorrarSoli",'submit','110','self','Borrar Solicitud','trash','boton02').'&nbsp;&nbsp;';
}
//si tiene solicitud
if( intval($_SESSION['TxtNroEntidad'])!=0 ){
	echo GLO_FAButton("CmdVerSoli",'submit','','self','Ver Solicitud','lupa','iconbtn');
}


?>
</td><td align="right"  ></td><td>&nbsp;</td><td align="right">
<? 
//si es ingreso y es particular
if( intval($_SESSION['CbEtapa'])==1 and $tieneitems==0){echo GLO_FAButton('CmdAltaEgreso','submit','80','self','Alta Egreso','','boton03');}
?>&nbsp;</td></tr>

</table>

<? 
//campos tercero/propio
if( intval($_SESSION['CbTipo'])==1){include ("Includes/zCamposP.php");}//1 propio
if( intval($_SESSION['CbTipo'])==2){include ("Includes/zCamposT.php");}//2 terceros

GLO_obsform(760,100,'Observaciones','TxtObs',2,0);
GLO_botonesform(760,0,2);

GLO_Hidden('TxtNumero',0);GLO_Hidden('TxtId',0);
GLO_Hidden('TxtDocCong',0);GLO_Hidden('TxtDominioCong',0);GLO_Hidden('TxtDominio2Cong',0);

//planilla y permisos
if(intval($_SESSION['TxtNumero'])!=0){
	echo '<table width="760" border="0"  cellpadding="0" cellspacing="0" class="TMT"><tr><td align="right">'; 

	//terceros
	if(intval($_SESSION['CbTipo'])==2){ 
		echo GLO_FAButton('CmdControlT','submit','80','self','Control','checklist','boton02');//checklist
		echo ' '.GLO_FAButton('CmdImprimirT','submit','80','blank','Imprimir','print','boton02');//permiso
	} 
	//propios
	if(intval($_SESSION['CbTipo'])==1){ 
		echo GLO_FAButton('CmdControlP','submit','80','self','Control','checklist','boton02');//checklist
		//permiso ingreso
		if( intval($_SESSION['CbEtapa'])==1 ){echo ' '.GLO_FAButton('CmdImprimirPI','submit','80','blank','Imprimir','print','boton02');}
		//permiso egreso
		//if( intval($_SESSION['CbEtapa'])==2 ){echo ' '.GLO_FAButton('CmdImprimirPE','submit','80','blank','Imprimir','print','boton02');}
	} 
	
	echo '</td> </tr></table>'; 
}



GLO_mensajeerror(); 

//si no es alta y tiene proceso
if(intval($_SESSION['TxtNumero'])!=0 and intval($_SESSION['TxtNroEntidad'])!=0){
	GLO_Ancla('A1'); PROC1_TablaItems($_SESSION['TxtNumero'],$conn);
}else{
	echo '<table  width="760" border="0" cellspacing="0" cellpadding="0" class="TMT5">';
	echo '<tr> <td class="TBlue" style="font-size:1.5rem;">Para agregar <font class="TBold">Items</font> es necesario generar una <font class="TBold">Solicitud</font> de Servicios</td> </tr>';
	echo '</table>';
    
    
}




?>	