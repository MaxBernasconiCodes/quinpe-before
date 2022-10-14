<? include("Codigo/Seguridad.php") ;$_SESSION["NivelArbol"]="";include("Codigo/Config.php");include("Codigo/Funciones.php");require_once('Codigo/calendar/classes/tc_calendar.php');include("ISOAuditorias/zFunciones.php");
//perfiles
GLO_PerfilAcceso(14);


$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);

//completa fecha por defecto
if (empty($_SESSION['TxtFechaD'])){
	$hoy=date("d-m-Y"); list($d,$m,$a)=explode("-",$hoy);$primerdiames="01-".$m."-".$a;$mesrestar=1;
	$_SESSION['TxtFechaD']=date("d-m-Y", strtotime("$primerdiames -0 month"));
	$nextmonth=date("d-m-Y", strtotime("$primerdiames +1 month")); 
	$_SESSION['TxtFechaH']=date("d-m-Y", strtotime("$nextmonth -1 day"));
}

function MostrarTabla($conn){
	$query=$_SESSION['TxtQISOAUD'];$query=str_replace("\\", "", $query);
	if (  ($query!="")){
		$rs=mysql_query($query,$conn);
		if(mysql_num_rows($rs)!=0){	
			//Titulos de la tabla		
			$tablaclientes='';
			$tablaclientes .=GLO_inittabla(850,1,0,0); 
			$tablaclientes .='<td width="120" class="TableShowT" '."> Tipo</td>"; 
			$tablaclientes .='<td width="340" class="TableShowT" '."> Nombre</td>";  
			$tablaclientes .='<td width="80" class="TableShowT" '.">Programada</td>"; 
			$tablaclientes .='<td width="70" class="TableShowT" '.">Realizada</td>";		
			$tablaclientes .='<td width="80" class="TableShowT" '.">Reprogramada</td>"; 
			$tablaclientes .='<td width="50" class="TableShowT" '.">Estado </td>";  
			$tablaclientes .='<td width="80" class="TableShowT" '.">Detalle </td>";   
			$tablaclientes .='<td width="30" class="TableShowT" '."> </td>";   
			$tablaclientes .='</tr>';    
			$recuento=0; $estilo=" style='cursor:pointer;' ";         
			while($row=mysql_fetch_array($rs)){
				$colorestado='';$estado='';$colordetalle='';
				//estado
				if ($row['IdEstado']==1) {$colorestado=' style="font-weight:bold;color:#00bcd4"';$estado='PROG';}// AZUL
				if ($row['IdEstado']==2) {$colorestado=' style="font-weight:bold;color:#4CAF50"';$estado='CUMPL';}// VERDE 	
				if ($row['Anulado']==1) {$colorestado=' style="font-weight:bold;color:#f44336"';$estado='ANUL';}//ROJO
				//link
				$link=" onclick="."location='ISOAuditorias/Modificar.php?Flag1=True&id=".$row['Id']."'";
				//fecha
				if($row['FechaProg']!='0000-00-00'){$fechap =FechaMesYear($row['FechaProg']);}else{$fechap='';}
				if($row['FechaReal']!='0000-00-00'){$fechar =FormatoFecha( $row['FechaReal']);}else{$fechar='';}
				if($row['FechaRProg']!='0000-00-00'){$fecharp =FormatoFecha( $row['FechaRProg']);}else{$fecharp='';}
				//detalle
				$detalle='';
				if (($row['IdEstado']==1 or $row['IdEstado']==2 ) and ($row['Anulado']==0)) {
					if( ($row['FechaProg']!='0000-00-00') and ($row['FechaReal']!='0000-00-00')){//cumplido
						if (CompararFechas(FormatoFecha($row['FechaReal']),FormatoFecha($row['FechaProg']))==1){$detalle='NO PUNTUAL';}
						else{$detalle='PUNTUAL';}				
					}	
					if( ($row['FechaProg']!='0000-00-00') and ($row['FechaReal']=='0000-00-00')){//programado
						$hoy=date("d-m-Y"); 
						if (CompararFechas(FormatoFecha($row['FechaProg']),$hoy)==2){$detalle='VENCIDO';$colordetalle=' style="font-weight:bold;color:#f44336"';}
						else{$detalle='VIGENTE';}				
					}	
				}		
				$tablaclientes .='<tr '.$estilo.' '.GLO_highlight($row['Id']).'>';
				$tablaclientes .='<td class="TableShowD" '.$link."> ".substr($row['Tipo'],0,14)."</td>";  
				$tablaclientes .='<td class="TableShowD" '.$link."> ".substr($row['Nombre'],0,40)."</td>";  
				$tablaclientes .='<td class="TableShowD" '.$link."> ".$fechap."</td>";  
				$tablaclientes .='<td class="TableShowD" '.$link."> ".$fechar."</td>"; 
				$tablaclientes .='<td class="TableShowD" '.$link."> ".$fecharp."</td>"; 
				$tablaclientes .='<td class="TableShowD" '.$link.$colorestado."> ".$estado."</td>"; 
				$tablaclientes .='<td class="TableShowD" '.$link.$colordetalle."> ".$detalle."</td>"; 
				$tablaclientes .='<td class="TableShowD TAR">'.GLO_rowbutton("CmdBorrarFila",$row['Id'],"Eliminar",'self','trash','iconlgray','Eliminar',1,0,0).'</td>';  
				$tablaclientes .='</tr>'; 
				$recuento=$recuento+1;
			}	
			$tablaclientes .=GLO_fintabla(1,0,$recuento);
			echo $tablaclientes;	
		}else{echo '<p class="MuestraConf" align="center">No existen datos que cumplan esos criterios</p>';}
		//Cierra consulta
		mysql_free_result($rs);
		
	}
}



GLOF_Init('TxtFechaD','BannerConMenuHV','ISOAuditorias/zISO_Auditorias',0,'',0,0,0); 
GLO_tituloypath(0,700,'Inicio.php','AUDITORIAS','linksalir');
?>


<table width="700" border="0"  cellspacing="0" class="Tabla" >
<tr> <td height="5" width="80"></td><td width="100"></td><td width="130"></td><td width="90"></td><td width="160"></td><td width="140"></td></tr>
<tr> <td height="18"  align="right">&nbsp;Fecha Prog:</td><td  >&nbsp;<?php  GLO_calendario("TxtFechaD","Codigo/","actual",1); ?></td><td  > al&nbsp;<?php  GLO_calendario("TxtFechaH","Codigo/","actual",1); ?></td><td height="18" align="right">Auditoria:</td><td >&nbsp;<select name="CbTipo" class="campos" id="CbTipo"  style="width:120px" onKeyDown="enterxtab(event)"><option value=""></option><? ComboTablaRFX("iso_audi_tipo","CbTipo","Nombre","","",$conn); ?></select></td><td><input name="ChkVto"  type="checkbox" class="check" value="1" <? if ($_SESSION['ChkVto'] =='1') echo 'checked'; ?>> Vencidas</td></tr>
<tr><td height="18"  align="right">Sector:</td><td  colspan="2">&nbsp;<select name="CbSector" class="campos" id="CbSector"  style="width:180px" onKeyDown="enterxtab(event)"><option value=""></option><? ComboTablaRFX("sector","CbSector","Nombre","","",$conn); ?></select></td><td  align="right">Estado:</td><td >&nbsp;<select name="CbEstado" class="campos" id="CbEstado"  style="width:120px" onKeyDown="enterxtab(event)"><option value=""></option><? ISOAUDI_CbEstadoAuditoria(); ?></select></td><td align="right" ><? GLO_Search('CmdBuscar',0); ?>&nbsp;</td></tr>
</table>


<? 
GLO_Hidden('TxtId',0);GLO_Hidden('TxtQISOAUD',0);
GLO_linkbutton(700,'Agregar','ISOAuditorias/Alta.php','Detalle','ISOAuditorias/Desvios.php','','');
GLO_mensajeerror(); 
MostrarTabla($conn);
GLO_cierratablaform();
include ("Codigo/FooterConUsuario.php");
?>