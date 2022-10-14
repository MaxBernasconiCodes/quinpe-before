<? include("../Codigo/Seguridad.php");include("../Codigo/Config.php");include("../Codigo/Funciones.php");$_SESSION["NivelArbol"]="../";
require_once('../Codigo/calendar/classes/tc_calendar.php');include("Includes/zFunciones.php") ;
//perfiles
GLO_PerfilAcceso(13);

$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);

if (empty($_SESSION['TxtFDBAR'])){
	$hoy=date("d-m-Y"); $_SESSION['TxtFDBAR']=$hoy;$_SESSION['TxtFHBAR']=$hoy;
}


function MostrarTabla($conn){
$query=$_SESSION['TxtQPROCBAR'];
if (  ($query!="")){	
	$rs=mysql_query($query,$conn);
	if(mysql_num_rows($rs)!=0){	
		$tablaclientes='';
		$tablaclientes .=GLO_inittabla(1050,1,0,0);
		$tablaclientes .="<td "."width="."70"." class="."TableShowT"."> Fecha</td>";  
		$tablaclientes .="<td "."width="."50"." class="."TableShowT"."> Hora</td>";   
		$tablaclientes .="<td "."width="."80"." class="."TableShowT"."> Tipo</td>"; 
		$tablaclientes .="<td "."width="."80"." class="."TableShowT"."> Ingreso</td>"; 
		$tablaclientes .="<td "."width="."150"." class="."TableShowT".">Conductor/Persona</td>"; 
		$tablaclientes .="<td "."width="."80"." class="."TableShowT".">DNI</td>"; 
		$tablaclientes .="<td "."width="."200"." class="."TableShowT".">Cliente</td>"; 
		$tablaclientes .="<td "."width="."100"." class="."TableShowT".">Remito</td>";
		$tablaclientes .='<td width="50" class="TableShowT TAR"> Solicitud</td>';
		$tablaclientes .='<td width="50" class="TableShowT TAR"> Pedido</td>';
		$tablaclientes .='<td width="60" class="TableShowT"> Etapa</td>';
		$tablaclientes .='<td width="50" class="TableShowT"> </td>';
		$tablaclientes .='<td width="30" class="TableShowT"></td>';  
		$tablaclientes .='</tr>'; $estilo=" style='cursor:pointer;'";   
		$recuento=0;  $_SESSION['TxtOriOPEBar']=0;//para que vuelva   
		$ingresos=0;  $egresos=0;      
		while($row=mysql_fetch_array($rs)){ 
			if($row['TipoB']=='PERSONA'){$link=" onclick="."location='ModificarPersona.php?Flag1=True&id=".$row['Id']."'";}
			else{$link=" onclick="."location='ModificarVehiculo.php?Flag1=True&id=".$row['Id']."'";}	
			//
			if($row['Tipo']==2){$clase2=' TGreen';}else{$clase2='';}	
			//
			if($row['Etapa']==0){$colore=' TBlue';$etapa='INGRESO';$ingresos++;}
			else{$colore=' TOrange';$etapa='EGRESO'; $egresos++;}	
			//
			if($row['Tipo']==1){$doc=$row['Documento'];$cho=$row['ACH'].' '.$row['NCH'];}
			else{$doc=$row['DNI'];$cho=$row['Chofer'];}
			//
			if($row['Retorno']==0){$ret='';}else{$ret='Retorno';}
			//
			$tablaclientes .='<tr '.$estilo.GLO_highlight($row['Id']).'>';
			$tablaclientes .="<td class="."TableShowD".$link."> ".GLO_FormatoFecha($row['Fecha'])."</td>"; 
			$tablaclientes .="<td class="."TableShowD".$link."> ".GLO_FormatoHora($row['Hora'])."</td>"; 
			$tablaclientes .='<td class="TableShowD'.$clase2.'"'.$link."> ".PROC_TipoUnidad($row['Tipo'])."</td>"; 
			$tablaclientes .="<td class="."TableShowD".$link."> ".$row['TipoB']."</td>";
			$tablaclientes .="<td class="."TableShowD".$link."> ".substr($cho,0,18)."</td>"; 
			$tablaclientes .="<td class="."TableShowD".$link."> ".$doc."</td>"; 
			$tablaclientes .="<td class="."TableShowD".$link."> ".substr($row['Cliente'],0,24)."</td>"; 
			$tablaclientes .="<td class="."TableShowD".$link."> ".substr($row['Rto'],0,15)."</td>";  
			$tablaclientes .='<td class="TableShowD TAR TBold TL12"'.$link.'>'.GLO_SinCeroSTRPAD($row['IdPadre'],5)."</td>"; 
			$tablaclientes .='<td class="TableShowD TAR"'.$link.'>'.GLO_SinCeroSTRPAD($row['IdPedido'],5)."</td>"; 
			$tablaclientes .='<td  class="TableShowD'.$colore.'"'.$link.'>'.$etapa."</td>"; 
			$tablaclientes .='<td  class="TableShowD TRed"'.$link.'>'.$ret."</td>"; 
			$tablaclientes .='<td class="TableShowD TAC">';
			if($row['TipoB']=='PERSONA'){//persona
				$tablaclientes .=GLO_rowbutton("CmdBorrarFila1",$row['Id'],"Eliminar",'self','trash','iconlgray','Eliminar',1,0,0);
			}else{//camion
				$tablaclientes .=GLO_rowbutton("CmdBorrarFila2",$row['Id'],"Eliminar",'self','trash','iconlgray','Eliminar',1,0,0);
			}			  					
			$tablaclientes .='</td></tr>'; 
			$recuento=$recuento+1;
		}	
		//GLO_fintabla
		$tablaclientes .='</table></td></tr>';
		$tablaclientes .='<tr><td class="comentario ';
		if($ingresos>$egresos){$tablaclientes .='TRed';}//si hay gente adentro
		$tablaclientes .='" style="vertical-align:top;text-align:right;">'.$recuento.' registros | '.$ingresos.' ingresos | '.$egresos.' egresos </td></tr>';
		$tablaclientes .='<tr><td  height=5 ></td></tr></table>';
		//
		echo $tablaclientes;	
	}else{echo '<p class="MuestraConf" align="center">No existen datos que cumplan esos criterios</p>';}
	mysql_free_result($rs);
}
}


//html
GLOF_Init('TxtFDBAR','BannerConMenuHV','zConsulta',0,'MenuH',0,0,0); 
GLO_tituloypath(0,800,'../Inicio.php','BARRERA','linksalir');
?>

<table width="800" border="0" cellspacing="0" class="Tabla" >
<tr> <td height="3" width="70"></td><td width="100"></td><td width="120"></td><td width="70"></td><td width="90"></td><td width="70"></td><td width="120"></td><td width="150"></td><td width="30"></td></tr>

<tr> <td height="18" align="right">Fecha:</td><td >&nbsp;<?php  GLO_calendario("TxtFDBAR","../Codigo/","actual",2); ?></td><td> al&nbsp;<?php  GLO_calendario("TxtFHBAR","../Codigo/","actual",2); ?></td><td align="right">Tipo:</td><td>&nbsp;<select name="CbTipo" class="campos" id="CbTipo"  style="width:70px"  tabindex="2" onKeyDown="enterxtab(event)"><? echo PROC_CbTipoUnidadFilter('CbTipo');?></select></td><td  align="right">DNI:</td><td>&nbsp;<input name="TxtDoc" type="text"  class="TextBox"  maxlength="14"  value="<? echo $_SESSION['TxtDoc']; ?>"  style="width:100px" onChange="this.value=validarEntero(this.value);"></td><td><input name="Chk1"  type="checkbox" class="check"  value="1" <? if ($_SESSION['Chk1'] =='1') echo 'checked'; ?>>Con Productos</td><td>&nbsp;</td></tr>

<tr> <td height="18" align="right">Cliente:</td><td  colspan="2">&nbsp;<select name="CbCliente" class="campos" id="CbCliente"  style="width:170px" onKeyDown="enterxtab(event)"><option value=""></option><? GLO_ComboActivo("clientes","CbCliente","Nombre","","",$conn); ?></select></td><td align="right">Ingreso:</td><td>&nbsp;<select name="CbTipo2" class="campos" id="CbTipo2"  style="width:70px"  tabindex="2" onKeyDown="enterxtab(event)"><option value=""></option><? echo PROC_CbTipoBarrera("CbTipo2");?></select></td><td align="right">Personal:</td><td>&nbsp;<select name="CbPersonal" style="width:100px" class="campos"  id="CbPersonal" ><option value=""></option><? echo ComboPersonalRFX("CbPersonal",$conn);?></select></td><td><input name="Chk2"  type="checkbox" class="check"  value="1" <? if ($_SESSION['Chk2'] =='1') echo 'checked'; ?>>Con Pedido</td><td></td></tr>

<tr> <td height="18" align="right">Producto:</td><td  colspan="2">&nbsp;<select name="CbProducto" class="campos" id="CbProducto"  style="width:170px" onKeyDown="enterxtab(event)"><option value=""></option><? ComboTablaRFX("items","CbProducto","Nombre","","and Tipo=0",$conn); ?></select></td><td align="right">Etapa:</td><td>&nbsp;<select name="CbEtapa" class="campos" id="CbEtapa"  style="width:70px"  tabindex="2" onKeyDown="enterxtab(event)"><? echo PROC_CbTipoEtapa('CbEtapa',0);?></select></td><td align="right">Rto:</td><td>&nbsp;<input name="TxtNro" type="text"  class="TextBox"  maxlength="8"  value="<? echo $_SESSION['TxtNro']; ?>"  style="text-align:right;width:100px" onChange="this.value=validarEntero(this.value);"></td><td><input name="ChkRE"  type="checkbox" class="check"  value="1" <? if ($_SESSION['ChkRE'] =='1') echo 'checked'; ?>>Retorno</td><td  align="right"><? GLO_Search('CmdBuscar',0); ?></td></tr>

</table>



<table width="800" border="0" cellspacing="0" class="TMT" >
<tr> <td> <button type="button" class="boton" style="width:150px" onClick="window.location.href='AltaVehiculoP.php';"><i class="fa fa-truck"></i> PROPIOS VEH&Iacute;CULO</button> <button type="button" class="boton" style="width:150px" onClick="window.location.href='AltaPersonaP.php';"><i class="fa fa-walking"></i> PROPIOS PERSONA</button> <button type="button" class="botongreen" style="width:150px" onClick="window.location.href='AltaVehiculoT.php';"><i class="fa fa-truck"></i> TERCEROS VEH&Iacute;CULO</button> <button type="button" class="botongreen" style="width:150px" onClick="window.location.href='AltaPersonaT.php';"><i class="fa fa-walking"></i> TERCEROS PERSONA</button></td></tr>
 
<tr><td class="TL12 TViolet TBold TAR"><? $enbase=BAR_ingresos($conn);
if($enbase>0){echo BAR_ingresos($conn).' Personas ingresaron hoy y no registran egreso'; }
?></td></tr>
</table>

<? 
GLO_Hidden('TxtId',0);GLO_Hidden('TxtQPROCBAR',0);
GLO_mensajeerror();
MostrarTabla($conn);
GLO_cierratablaform();
mysql_close($conn); 

GLO_initcomment(0,0);
echo 'Muestra todos los <font class="comentario2">Ingresos</font> y <font class="comentario3">Egresos</font> registrados';
GLO_endcomment();
include ("../Codigo/FooterConUsuario.php");
?>