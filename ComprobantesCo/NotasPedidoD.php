<? include("../Codigo/Seguridad.php") ; $_SESSION["NivelArbol"]="../";include("../Codigo/Config.php");include("../Codigo/Funciones.php");
require_once('../Codigo/calendar/classes/tc_calendar.php');include("Includes/zFunciones.php");
//perfiles
if ($_SESSION["IdPerfilUser"]!=1 and $_SESSION["IdPerfilUser"]!=2 and  $_SESSION["IdPerfilUser"]!=3  and $_SESSION["IdPerfilUser"]!=4  and  $_SESSION["IdPerfilUser"]!=7 and  $_SESSION["IdPerfilUser"]!=9 and $_SESSION["IdPerfilUser"]!=14 and $_SESSION["IdPerfilUser"]!=11){ header("Location:".$_SESSION["NivelArbol"]."Inicio.php");}

$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);

if (empty($_SESSION['TxtFechaDCONP'])){
	$hoy=date("d-m-Y"); list($d,$m,$a)=explode("-",$hoy);$primerdiames="01-".$m."-".$a;$mesrestar=1;
	$_SESSION['TxtFechaDCONP']=date("d-m-Y", strtotime("$primerdiames -$mesrestar month"));$_SESSION['TxtFechaHCONP']=$hoy;
}

function NP_ConsultaXDefecto(){
//si es preautorizante trae los abiertos(1)
//si es autorizante trae los preautorizados(2)
$log=$_SESSION["GLO_IdPersLog"];
$_SESSION["TxtQNOTAPDET"]="Select np.*,npi.Id as IdNPI,npi.IdEstado,npi.Cant as CantItem,npi.CantAuto as CantAutoItem,npi.Obs as ObsItem,p1.Nombre as NomS,p1.Apellido as ApeS,p2.Nombre as NomA,p2.Apellido as ApeA,p3.Nombre as NomPA,p3.Apellido as ApePA,s.Nombre as Sector,a.Id as IdArticuloItem, a.Nombre as Articulo, um.Abr,e.Nombre as Estado,np.IdPerPAuto,np.IdPerAuto,il.Nombre as Prod,il.Id as IdProd,u2.Abr as Abr2 From co_npedido np,co_npedido_it npi,personal p1,personal p2,personal p3,sector s,epparticulos a,unidadesmedida um,co_npedido_est e,items il,unidadesmedida u2 Where np.Id<>0 and np.Id=npi.IdNP and np.IdPerSoli=p1.Id and np.IdPerAuto=p2.Id and np.IdPerPAuto=p3.Id and np.IdSector=s.Id and npi.IdArticulo=a.Id and a.IdUnidad=um.Id and npi.IdEstado=e.Id and npi.IdItem=il.Id and il.IdUnidad=u2.Id and ((np.IdPerPAuto=$log and npi.IdEstado=1) or (np.IdPerAuto=$log and (npi.IdEstado=2 or npi.IdEstado=1))) Order by np.Id LIMIT 2000";		
}


if (empty($_SESSION["TxtQNOTAPDET"])){NP_ConsultaXDefecto();}

function MostrarTabla($conn){
$log=$_SESSION["GLO_IdPersLog"];
$espreauto=NP_EsPreAutorizante($conn);//logueado esta en lista pre autorizantes
$esauto=NP_EsAutorizante($conn);//logueado esta en lista autorizantes
//
$query=$_SESSION['TxtQNOTAPDET'];$query=str_replace("\\", "", $query);
if ( ($query!="")){	
	$rs=mysql_query($query,$conn);
	if(mysql_num_rows($rs)!=0){	
		$tablaclientes='';
		if(mysql_num_rows($rs)==2000){$tablaclientes= '<p class="MuestraError" align="center">La consulta permite mostrar hasta 2000 registros</p>';}
		//Titulos de la tabla		
		$tablaclientes .=GLO_inittabla(1140,0,0,0);
		$tablaclientes .='<tr><td align="right">';
		if($espreauto==1){
			$tablaclientes .='<input name="CmdPreautorizar" type="submit" class="boton02" value="PreAutorizar" style="color:#4CAF50; border-color:#4CAF50;width:80px" onClick="document.Formulario.target='."'_self'".';return confirm('."'PreAutorizar'".');">&nbsp;&nbsp;<input name="CmdRechazarPre" type="submit" class="boton02" value="Rechazar" style="color:#f44336;border-color:#f44336;width:80px" onClick="document.Formulario.target='."'_self'".';return confirm('."'Rechazar'".');">';
		}
		if($esauto==1){
			$tablaclientes .=' <input name="CmdAutorizar" type="submit" class="boton02" value="Autorizar" style="color:#4CAF50; border-color:#4CAF50;width:80px" onClick="document.Formulario.target='."'_self'".';return confirm('."'Autorizar'".');">&nbsp;&nbsp;<input name="CmdRechazarAuto" type="submit" class="boton02" value="Rechazar" style="color:#f44336;border-color:#f44336;width:80px" onClick="document.Formulario.target='."'_self'".';return confirm('."'Rechazar'".');">';	
		}	
		$tablaclientes .="</td></tr><tr><td "."height="."3"."></td></tr></table>";
		$tablaclientes .='<table width="1140" class="TableShow" id="tshow"><tr>';	
		$tablaclientes .="<td "."width="."50"." class="."TableShowT"." style='text-align:right;'> Pedido</td>";   
		$tablaclientes .='<td width="70" class="TableShowT"> Alta</td>';   
		$tablaclientes .="<td "."width="."70"." class="."TableShowT"."> Solicitante</td>"; 
		$tablaclientes .="<td "."width="."70"." class="."TableShowT"."> Pre-Autorizante</td>"; 
		$tablaclientes .="<td "."width="."70"." class="."TableShowT"."> Autorizante</td>"; 		
		$tablaclientes .="<td "."width="."50"." class="."TableShowT"."> Sector</td>"; 
		$tablaclientes .="<td "."width="."40"." class="."TableShowT"."> Prio</td>"; 
		$tablaclientes .="<td "."width="."340"." class="."TableShowT"."> Art&iacute;culo o Producto</td>";
		$tablaclientes .="<td "."width="."160"." class="."TableShowT"."> Obs.Item Pedido</td>"; 
		$tablaclientes .="<td "."width="."50"." class="."TableShowT"." style='text-align:right;'> Cant</td>"; 
		$tablaclientes .="<td "."width="."60"." class="."TableShowT"." style='text-align:right;'> Cant Auto</td>"; 
		$tablaclientes .="<td "."width="."30"." class="."TableShowT"."> </td>"; 
		$tablaclientes .="<td "."width="."50"." class="."TableShowT"."> Estado</td>"; 
		$tablaclientes .='<td width="30" class="TableShowT" align="center">'; 
		if($espreauto==1 or $esauto==1){$tablaclientes .='<input type="checkbox" name="ChkAll" onclick="CheckMasivo5();">';}
		$tablaclientes .='</td>';  
		$tablaclientes .='</tr>';    
		$recuento=0;          
		 $estilo=" style='cursor:pointer;'"; $clase="TableShowD";$_SESSION['GLO_IdLocationCONP']=2;	
		while($row=mysql_fetch_array($rs)){ 
			$link=" onclick="."location='ModificarNotaPedido.php?Flag1=True&id=".$row['Id']."'";
			//
			$prio=CO_VerPrioridad($row['Prioridad'],$stprio);
			$idestado=NP_BuscarEstadoNPIId($row['IdNPI'],$row['IdEstado'],$conn);
			$estado=NP_BuscarEstadoNPI($row['IdNPI'],$row['Estado'],$conn);
			$colorestado=NP_BuscarEstadoNPIColor($idestado);
			$muestra=1;$estfiltro=intval($_SESSION['CbEstado']);if($estfiltro!=0){if($idestado!=$estfiltro){$muestra=0;}}
			//articulo,producto u observaciones
			$claseart="TableShowD";
			if($row['IdArticuloItem']>0){
				$textoart=str_pad($row['IdArticuloItem'], 6, "0", STR_PAD_LEFT).' '.$row['Articulo'];$abr=$row['Abr'];
			}else{
				if($row['IdProd']>0){
					$textoart=str_pad($row['IdProd'], 6, "0", STR_PAD_LEFT).' '.$row['Prod'];$abr=$row['Abr2'];
				}else{$claseart="TableShowD TRed ";$textoart=$row['ObsItem'];$abr='';}	
			}
			
			//muestro
			if($muestra==1){
				$tablaclientes .='<tr '.$estilo.GLO_highlight($row['IdNPI']).'>'; 
				$tablaclientes .='<td class="'.$clase.'"'.$link." style='text-align:right;'> ".str_pad($row['Id'], 6, "0", STR_PAD_LEFT)."</td>"; 
				$tablaclientes .='<td class="'.$clase.'"'.$link."> ".FormatoFecha($row['Fecha'])."</td>"; 
				$tablaclientes .='<td class="'.$clase.'"'.$link."> ".substr($row['ApeS'].' '.$row['NomS'],0,8)."</td>";  
				$tablaclientes .='<td class="'.$clase.'"'.$link."> ".substr($row['ApePA'].' '.$row['NomPA'],0,8)."</td>";  
				$tablaclientes .='<td class="'.$clase.'"'.$link."> ".substr($row['ApeA'].' '.$row['NomA'],0,8)."</td>";  
				$tablaclientes .='<td class="'.$clase.'"'.$link."> ".substr($row['Sector'],0,6)."</td>";  
				$tablaclientes .='<td class="'.$clase.$stprio.'"'.$link."> ".$prio."</td>";  
				$tablaclientes .='<td class="'.$claseart.'"'.$link.' title="'.$textoart.'">'.substr($textoart,0,42)."</td>";  
				$tablaclientes .='<td class="'.$clase.'"'.$link.' title="'.$row['ObsItem'].'">'.substr($row['ObsItem'],0,20)."</td>"; 
				$tablaclientes .='<td class="'.$clase.'"'.$link." style='text-align:right;'> ".$row['CantItem']."</td>";  
				if(($espreauto==1 and $row['IdEstado']==1 and $log==$row['IdPerPAuto']) or ($esauto==1 and ($log==$row['IdPerPAuto'] or $log==$row['IdPerAuto']) and ($row['IdEstado']==1))){
				$tablaclientes .='<td class="'.$clase.'"'." style='text-align:right;'>".'<input name="TxtCant['.$row['IdNPI'].']"  type="text"  class="TextBox"  maxlength="7"  value="'.$row['CantAutoItem'].'" onChange="this.value=validarNumeroP(this.value);" style="text-align:right;width:50px">';
				}else{
					$tablaclientes .='<td class="'.$clase.'"'.$link." style='text-align:right;'>".$row['CantAutoItem'].'<input name="TxtCant['.$row['IdNPI'].']"  type="hidden"  value="'.$row['CantAutoItem'].'" >';
				}
				$tablaclientes .='</td>';  
				$tablaclientes .='<td class="'.$clase.'"'.$link."> ".substr($abr,0,5)."</td>";  
				$tablaclientes .='<td class="'.$clase.'"'.$link.$colorestado."> ".substr($estado,0,6)."</td>";  
				$tablaclientes .='<td class="TableShowD" align="center">'; 
				if( ($espreauto==1 and $row['IdEstado']==1 and $log==$row['IdPerPAuto']) or ($esauto==1 and ($log==$row['IdPerPAuto'] or $log==$row['IdPerAuto']) and ($row['IdEstado']==1 or $row['IdEstado']==2))){
					$tablaclientes .='<input type="checkbox" name="campos['.$row['IdNPI'].']" unchecked value=0 onclick="if (this.checked==1) {this.value=1;}else{this.value=0;};" >';
				}
				$tablaclientes .='</td>';  
				$tablaclientes .='</tr>'; 
				$recuento=$recuento+1;
			}
		}	
		$tablaclientes .=GLO_fintabla(1,0,$recuento);
		echo $tablaclientes;
	}else{echo '<p class="MuestraConf" align="center">No existen datos que cumplan esos criterios</p>';}
	mysql_free_result($rs);
}
}




GLOF_Init('','BannerConMenuHV','zNotasPedidoD',0,'MenuH',0,0,0);
GLO_tituloypath(1170,800,"../Inicio.php",'DETALLE DE PEDIDOS','linksalir');
?> 


<table width="800" border="0"   cellspacing="0" class="Tabla" >
<tr> <td height="5" width="80"></td><td width="100"></td><td width="120"></td><td width="70"></td><td width="100"></td><td width="70"></td><td width="130"></td><td width="60"></td><td width="70"></td></tr>
<tr> <td height="18"  align="right">Alta:</td><td>&nbsp;<? GLO_calendario("TxtFechaDCONP","../Codigo/","actual",1) ?></td> <td> al&nbsp;<? GLO_calendario("TxtFechaHCONP","../Codigo/","actual",1) ?></td> <td align="right">Sector:</td><td>&nbsp;<select name="CbSector" class="campos" id="CbSector"  style="width:80px" onKeyDown="enterxtab(event)"><option value=""></option><? ComboTablaRFX("sector","CbSector","Nombre","","",$conn); ?></select></td><td  align="right">Art&iacute;culo:</td><td >&nbsp;<input name="TxtBusqueda" type="text" class="TextBox" style="width:100px" maxlength="30" onKeyDown="enterxtab(event)"></td><td  align="right">Pedido:</td><td  colspan="2">&nbsp;<input  name="TxtNroPedido" type="text"  class="TextBox"  align="right"   value="<? echo $_SESSION['TxtNroPedido'];?>" onChange="this.value=validarEntero(this.value);" style="text-align:right;width:50px"></td></tr>

<tr><td height="18"  align="right">Autorizante:</td><td   colspan="2">&nbsp;<select name="CbAuto" class="campos" id="CbAuto"  style="width:180px" onKeyDown="enterxtab(event)"><option value=""></option><? CO_PersonalAutoNP($conn); ?></select></td><td  align="right">Proveedor:</td><td >&nbsp;<select name="CbProv" class="campos" id="CbProv"  style="width:80px" onKeyDown="enterxtab(event)"><option value=""></option><? ComboProveedorRFX("CbProv","",$conn); ?></select></td><td  align="right">Estado:</td><td>&nbsp;<select name="CbEstado" style="width:100px" class="campos" id="CbEstado" ><option value=""></option> <? ComboTablaRFX("co_npedido_est","CbEstado","Id","","",$conn); ?> </select></td><td  align="right">Prioridad:</td><td>&nbsp;<select name="CbPrio" style="width:50px" class="campos" id="CbPrio" ><option value=""></option> <? CO_Prioridad(); ?> </select></td></tr>

<tr><td height="18"  align="right">Solicitante:</td><td   colspan="2">&nbsp;<select name="CbSoli" class="campos" id="CbSoli"  style="width:180px" onKeyDown="enterxtab(event)"><option value=""></option><? CO_PersonalSoliNP($conn); ?></select></td><td  align="right">Item:</td><td >&nbsp;<select name="CbTipo" class="campos" id="CbTipo"  style="width:80px" onKeyDown="enterxtab(event)"><option value=""></option><? GLO_CbTipoItem("CbTipo"); ?></select></td><td  align="right"></td><td >&nbsp;</td><td   align="right"  colspan="2"><? GLO_Search('CmdBuscar',0); ?>&nbsp;</td></tr>
</table>


<table  width="800" border="0" cellspacing="0" cellpadding="0" class="TMT">
<tr  valign="bottom"><td  valign="bottom" align="left"><input name="CmdAgregar" type="button" class="boton" value="Agregar" onClick="document.Formulario.target='_self';window.location.href='AltaNotaPedido.php'">
<? 
//detalle/puntos pedido (11 Administracion)
if($_SESSION["IdPerfilUser"]==1 or $_SESSION["IdPerfilUser"]==2 or $_SESSION["IdPerfilUser"]==11){
	echo ' <input name="CmdDetalle" type="button" class="boton"   value="Pedidos" onClick="document.Formulario.target='."'_self'".';window.location.href='."'NotasPedido.php'".'">';
	echo ' <input name="CmdPuntos" type="button" class="boton"   value="Puntos" onClick="document.Formulario.target='."'_self'".';window.location.href='."'../PuntosPedido.php'".'">';
} 
?>
 </td></tr>
</table>


<? 
GLO_Hidden('TxtId',0);GLO_Hidden('TxtQNOTAPDET',0);
GLO_mensajeerror(); 
MostrarTabla($conn);
GLO_cierratablaform();
mysql_close($conn); 
include ("../Codigo/FooterConUsuario.php");
?>