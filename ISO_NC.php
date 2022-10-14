<? include("Codigo/Seguridad.php") ;include("Codigo/Config.php") ;include("Codigo/Funciones.php") ;$_SESSION["NivelArbol"]="";
require_once('Codigo/calendar/classes/tc_calendar.php');include("ISONC/Includes/zFunciones.php") ;
//perfiles
GLO_PerfilAcceso(14);

$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);


//completa fecha por defecto
if (empty($_SESSION['TxtFechaDCP'])){
	$hoy=date("d-m-Y"); list($d,$m,$a)=explode("-",$hoy);$primerdiames="01-".$m."-".$a;
	$_SESSION['TxtFechaDCP']=date("d-m-Y", strtotime("$primerdiames -0 month"));
	$nextmonth=date("d-m-Y", strtotime("$primerdiames +1 month")); 
	$_SESSION['TxtFechaHCP']=date("d-m-Y", strtotime("$nextmonth -1 day"));
}


function NC_MostrarTabla($conn){
	$query=$_SESSION['TxtConsultaNC'];$query=str_replace("\\", "", $query);
	if (  ($query!="")){
		$rs=mysql_query($query,$conn);
		if(mysql_num_rows($rs)!=0){			
			$tablaclientes ="";
			$tablaclientes .=GLO_inittabla(940,1,0,0);
			$tablaclientes .="<td "."width="."50"." class="."TableShowT"."> N&uacute;mero</td>";   
			$tablaclientes .="<td "."width="."60"." class="."TableShowT"."> Fecha Emisi&oacute;n</td>"; 
			$tablaclientes .="<td "."width="."210"." class="."TableShowT"."> Descripci&oacute;n</td>"; 
			$tablaclientes .="<td "."width="."200"." class="."TableShowT".">Origen</td>"; 
			$tablaclientes .="<td "."width="."60"." class="."TableShowT".">Plazo AC/AP</td>";   
			$tablaclientes .="<td "."width="."60"." class="."TableShowT".">Cumpl. AC/AP</td>";   
			$tablaclientes .="<td "."width="."60"." class="."TableShowT".">Prevista Cierre</td>"; 
			$tablaclientes .="<td "."width="."60"." class="."TableShowT".">Fecha Cierre</td>";   
			$tablaclientes .="<td "."width="."50"." class="."TableShowT".">Nueva NC</td>";   
			$tablaclientes .="<td "."width="."120"." class="."TableShowT".">Estado</td>";   
			$tablaclientes .='</tr>';    
			$recuento=0;  $estilo=" style='cursor:pointer;' ";        
			while($row=mysql_fetch_array($rs)){
				$id=$row['Id'];
				$nronc=str_pad($row['Id'], 5, "0", STR_PAD_LEFT);
				$detalle='';$colordetalle='';$medalla='';
				if ($row['IdEstado']==1) {$estado='<img src="CSS/Imagenes/abierto.png" title=""></img>';$detalle=' Abierto';}
				if ($row['IdEstado']==2) {$estado='<img src="CSS/Imagenes/cumplido.png" title=""></img>';$detalle=' Cumplido';}	
				if ($row['IdEstado']==3) {$estado='<img src="CSS/Imagenes/cerrado.png" title=""></img>';$detalle=' Cerrado';} 
				if ($row['IdEstado']==4) {$estado='<img src="CSS/Imagenes/incumplido.png" title=""></img>';$detalle=' Incumplido';}
				if ($row['IdEstado']==5) {$estado='<img src="CSS/Imagenes/reprogramado.png" title=""></img>';$detalle=' Reprogramado';}
							
				$link=" onclick="."location='ISONC/Modificar.php?Flag1=True&id=".$row['Id']."'";
				//fecha
				if($row['FechaEmision']!='0000-00-00'){$fechae =FormatoFecha($row['FechaEmision']);}else{$fechae='';}
				if($row['FechaPlazo']!='0000-00-00'){$fechapl =FormatoFecha( $row['FechaPlazo']);}else{$fechapl='';}
				if($row['FechaCumpl']!='0000-00-00'){$fechacpl =FormatoFecha( $row['FechaCumpl']);}else{$fechacpl='';}
				if($row['FechaPrevista']!='0000-00-00'){$fechap =FormatoFecha( $row['FechaPrevista']);}else{$fechap='';}
				if($row['FechaCierre']!='0000-00-00'){$fechac =FormatoFecha( $row['FechaCierre']);}else{$fechac='';}
				
				//nueva
				if ($row['IdNCNueva']!=0) {$nuevanc=str_pad($row['NroNCNueva'], 5, "0", STR_PAD_LEFT);}else{$nuevanc='';}
				
				//si abierto: verifica cumplimiento vencido
				if ($row['IdEstado']==1) {
					if($row['FechaPlazo']!='0000-00-00'){
						if ((strtotime(date("d-m-Y"))-strtotime($fechapl))>0){$colordetalle=' style="font-weight:bold;color:#f44336"';}			
					}
				}			
				//si cerrado: verifica cierre puntual, cierre puntual lleva medalla de oro
				if ($row['IdEstado']==3) {
					if( ($row['FechaPrevista']!='0000-00-00') and ($row['FechaCierre']!='0000-00-00')){
						if ((strtotime($fechac)-strtotime($fechap))>0){}
						else{$medalla=' <i class="fa fa-award iconsmallsp iconlgray"></i>';}				
					}	
				}
				
	
				
				$tablaclientes .='<tr '.$estilo.GLO_highlight($row['Id']).'>';
				$tablaclientes .="<td class="."TableShowD ".$link."> ".$nronc.$medalla."</td>";  
				$tablaclientes .="<td class="."TableShowD ".$link."> ".$fechae."</td>";  
				$tablaclientes .="<td class="."TableShowD ".$link."> ".substr($row['Descripcion'],0,25)."</td>";  			
				$tablaclientes .="<td class="."TableShowD ".$link."> ".substr($row['Tipo'],0,33)."</td>"; 
				$tablaclientes .="<td class="."TableShowD ".$link."> ".$fechapl."</td>"; 
				$tablaclientes .="<td class="."TableShowD ".$link."> ".$fechacpl."</td>"; 
				$tablaclientes .="<td class="."TableShowD ".$link."> ".$fechap."</td>";
				$tablaclientes .="<td class="."TableShowD ".$link."> ".$fechac."</td>"; 
				$tablaclientes .="<td class="."TableShowD ".$link."> ".$nuevanc."</td>"; 
				$tablaclientes .="<td class="."TableShowD ".$link.$colordetalle."> ".$estado.$detalle."</td>";							
				$tablaclientes .='</tr>'; 
				$recuento=$recuento+1;
			}	
			$tablaclientes .=GLO_fintabla(2,0,$recuento);
			echo $tablaclientes;	
		}else{echo '<p class="MuestraConf" align="center">No existen datos que cumplan esos criterios</p>';}
		//Cierra consulta
		mysql_free_result($rs);
		
	}
	}
	
GLO_InitHTML($_SESSION["NivelArbol"],'TxtFechaDCP','BannerConMenuHV','ISONC/zISO_NC',0,0,0,0); 
GLO_tituloypath(0,700,'Inicio.php','NO CONFORMIDADES','linksalir'); 
?>


<table width="700" border="0"   cellspacing="0" class="Tabla" >
<tr> <td height="5" width="80"></td><td width="100"></td><td width="120"></td><td width="70"></td><td width="100"></td><td width="130"></td><td width="100"></td></tr>
<tr> <td height="18"  align="right">&nbsp;Fecha:</td><td  >&nbsp;<?php  GLO_calendario("TxtFechaDCP","Codigo/","actual",1); ?></td><td  > al&nbsp;<?php  GLO_calendario("TxtFechaHCP","Codigo/","actual",1); ?></td>
<td height="18" align="right">Estado:</td><td   >&nbsp;<select name="CbEstadoNC" class="campos" id="CbEstadoNC"  style="width:80px" onKeyDown="enterxtab(event)"><option value=""></option><? ComboEstadoISO_NC(); ?></select></td><td colspan="2">&nbsp;Tipo:&nbsp;<select name="CbTipoH" style="width:100px" class="campos" id="CbTipoH"  tabindex="1" ><option value=""></option> <? ComboTablaRFX("iso_nc_tipo2","CbTipoH","Nombre","","",$conn); ?>   </select></td></tr>
<tr> <td height="18"  align="right">&nbsp;Sector:</td><td  colspan="2">&nbsp;<select name="CbSector" class="campos" id="CbSector"  style="width:180px" onKeyDown="enterxtab(event)"><option value=""></option><? ComboTablaRFX("sector","CbSector","Nombre","","",$conn); ?></select></td>
<td  align="right">Cliente:</td><td  >&nbsp;<select name="CbCliente" class="campos" id="CbCliente"  style="width:80px" onKeyDown="enterxtab(event)"><option value=""></option><? GLO_ComboActivo("clientes","CbCliente","Nombre","","",$conn); ?></select></td><td colspan="2"><input name="ChkVtoCumpl"  type="checkbox"  class="check" value="1" <? if ($_SESSION['ChkVtoCumpl'] =='1') echo 'checked'; ?>>Cumplimiento Vencido</td></tr>
<tr> <td height="18"  align="right">Responsable:</td><td  colspan="2">&nbsp;<select name="CbPersonal" class="campos" id="CbPersonal"  style="width:180px" onKeyDown="enterxtab(event)"><option value=""></option><? ComboPersonalRFX("CbPersonal",$conn); ?></select></td>
<td  align="right">Origen:</td><td >&nbsp;<select name="CbTipo" style="width:80px" class="campos" id="CbTipo" ><option value=""></option> <? ComboTablaRFX("iso_nc_tipo","CbTipo","Nombre","","",$conn); ?> </select></td><td><input name="ChkVtoCierre"  type="checkbox"  class="check" value="1" <? if ($_SESSION['ChkVtoCierre'] =='1') echo 'checked'; ?>>Cierre Vencido</td><td   align="right" ><? GLO_Search('CmdBuscar',0); ?>&nbsp;</td></tr>
</table>


<?
if ($_SESSION["IdPerfilUser"]==1 or $_SESSION["IdPerfilUser"]==2 or $_SESSION["IdPerfilUser"]==4 or $_SESSION["IdPerfilUser"]==3  or $_SESSION["IdPerfilUser"]==9 or $_SESSION["IdPerfilUser"]==14){GLO_linkbutton(700,'Agregar','ISONC/Alta.php','','','','');}

GLO_Hidden('TxtId',0);GLO_Hidden('TxtConsultaNC',0);GLO_Hidden('TxtConsultaNCDet',0);
GLO_mensajeerror();
NC_MostrarTabla($conn); 
GLO_cierratablaform();
mysql_close($conn);

GLO_initcomment(940,0);
echo 'Fecha <font class="comentario3">Plazo</font> es la estimada de Cumplimiento de AC/AP.Fecha <font class="comentario2">Prevista</font> es la programada para el Cierre de la NC';
GLO_endcomment();
include ("Codigo/FooterConUsuario.php");
?>