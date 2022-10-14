<? include("../Codigo/Seguridad.php");include("../Codigo/Config.php");include("../Codigo/Funciones.php");

//perfiles
GLO_PerfilAcceso(14);




if (isset($_POST['CmdBuscar'])){
	$consulta="";
	//verifica que se seleccione criterio
	if ((empty($_POST['TxtFechaD'])) or (empty($_POST['TxtFechaH']))){$consulta="";}
	else{
		$wbuscar=" and DATEDIFF(a.FechaProg,'".FechaMySql($_POST['TxtFechaD'])."')>=0";
		$wbuscar=$wbuscar." and DATEDIFF(a.FechaProg,'".FechaMySql($_POST['TxtFechaH'])."')<=0";
		$vbuscar=intval($_POST['CbTipo']);if($vbuscar!=0){$wbuscar=$wbuscar." and a.IdTipo=$vbuscar";}
		$vbuscar=intval($_POST['CbSector']);if($vbuscar!=0){$wbuscar=$wbuscar." and a.IdSector=$vbuscar";}
		$vbuscar=intval($_POST['CbDesvioT']);if($vbuscar!=0){$wbuscar=$wbuscar." and p.IdDesvioT=$vbuscar";}
		$vbuscar=intval($_POST['CbDesvio']);if($vbuscar!=0){$wbuscar=$wbuscar." and aa.IdDesvio=$vbuscar";}
		$consulta="Select a.*,s.Nombre as Sector,t.Nombre as Tipo,y.Nombre as Yac,p.Nombre as Desvio,p.Nro,aa.Obs as ObsD,aa.Accion as AccionD,i.Nombre as Inst,o.Nombre as Centro,t2.Nombre as NombreT, t2.Nro as NroT From iso_audi_prog a,yacimientos y,sector s,iso_audi_tipo t,iso_audi_progdes aa,iso_audi_desvios p,instalaciones i,epparticulos o,iso_audi_desviost t2 Where a.IdYac=y.Id and a.IdSector=s.Id and a.IdTipo=t.Id and a.Id=aa.IdAudiP and p.Id=aa.IdDesvio and a.IdInstalacion=i.Id and a.IdCentro=o.Id and p.IdDesvioT=t2.Id  $wbuscar Order by p.Nro,p.Nombre,a.FechaProg";
	}	
	foreach($_POST as $key => $value){$_SESSION[$key] = $value;}
	$_SESSION['TxtQISOAUD3']=$consulta;
	header("Location:Desvios.php");
}




if (isset($_POST['CmdExcel'])){
	$query=$_POST['TxtQISOAUD3'];$query=str_replace("\\", "", $query);
	if ($query!=""){
		$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);$rs=mysql_query($query,$conn);
		if(mysql_num_rows($rs)!=0){	
			//Titulos excel
			include("../Codigo/ExcelHeader.php");
			include("../Codigo/ExcelStyle.php");
			echo "<th>Tipo</th>\n";
			echo "<th>Observacion</th>\n";
			echo "<th>Descripci&oacute;n</th>\n";
			echo "<th>Acci&oacute;n</th>\n";
			echo "<th>Fecha Prog.</th>\n";			
			echo "<th>Fecha Real</th>\n";	
			echo "<th>Hora Real</th>\n";			
			echo "<th>Duraci&oacute;n</th>\n";		
			echo "<th>Reprogramada</th>\n";
			echo "<th>Tipo</th>\n";
			echo "<th>Sector</th>\n";
			echo "<th>Lugar</th>\n";
			echo "<th>Instalaci&oacute;n</th>\n";
			echo "<th>Equipo</th>\n";
			echo "<th>Estado</th>\n";
			echo "<th>Detalle</th>\n";
			echo "<th>Observaciones</th>\n";
			echo "</tr>\n";				
			//datos excel	
			while($row=mysql_fetch_array($rs)){ 
				//color estado
				$colorestado='';$detalle='';$colordetalle='';
				//estado
				if ($row['IdEstado']==1) {$colorestado='style="font-weight:bold;color:#0066CC"';$estado='PROG';}//PROG azul
				if ($row['IdEstado']==2) {$colorestado='style="font-weight:bold;color:#008000"';$estado='CUMPL';}//CUMPL VERDE 
				if ($row['Anulado']==1) {$colorestado=' style="font-weight:bold;color:#f44336"';$estado='ANULADA';}//ROJO
				//fecha
				if($row['FechaProg']!='0000-00-00'){$fechap =FormatoFecha($row['FechaProg']);}else{$fechap='';}
				if($row['FechaReal']!='0000-00-00'){$fechar =FormatoFecha( $row['FechaReal']);}else{$fechar='';}
				if($row['FechaRProg']!='0000-00-00'){$fecharp =FormatoFecha( $row['FechaRProg']);}else{$fecharp='';}
				$hora=date("H:i",strtotime($row['HoraReal'])); if ($hora=='00:00'){$hora="";}
				$dur=date("H:i",strtotime($row['Duracion'])); if ($dur=='00:00'){$dur="";}	
				//detalle
				$detalle='';
				if (($row['IdEstado']==1 or $row['IdEstado']==2 ) and ($row['Anulado']==0)) {
					if( ($row['FechaProg']!='0000-00-00') and ($row['FechaReal']!='0000-00-00')){//cumplido
						if (CompararFechas(FormatoFecha($row['FechaReal']),FormatoFecha($row['FechaProg']))==1){$detalle='CUMPL.NO PUNTUAL';}
						else{$detalle='CUMPL.PUNTUAL';}				
					}	
					if( ($row['FechaProg']!='0000-00-00') and ($row['FechaReal']=='0000-00-00')){//programado
						$hoy=date("d-m-Y"); 
						if (CompararFechas(FormatoFecha($row['FechaProg']),$hoy)==2){$detalle='PROG.VENCIDO';$colordetalle='style="font-weight:bold;color:#FF0000"';}
						else{$detalle='PROG.VIGENTE';}				
					}	
				}		
				echo "<tr>\n";
				echo '<td>'.$row['NroT'].'  '.$row['NombreT']."</td>\n";
				echo '<td>'.$row['Nro'].'  '.$row['Desvio']."</td>\n";
				echo '<td>'.GLO_textoExcel($row['ObsD'])."</td>\n";
				echo '<td>'.GLO_textoExcel($row['AccionD'])."</td>\n";
				echo '<td>'.$fechap."</td>\n";
				echo '<td>'.$fechar."</td>\n";	
				echo '<td>'.$hora."</td>\n";	
				echo '<td>'.$dur."</td>\n";	
				echo '<td>'.$fecharp."</td>\n";
				echo '<td>'.GLO_textoExcel($row['Tipo'])."</td>\n";
				echo '<td>'.GLO_textoExcel($row['Sector'])."</td>\n";
				echo '<td>'.GLO_textoExcel($row['Yac'])."</td>\n";	
				echo '<td>'.GLO_textoExcel($row['Inst'])."</td>\n";
				echo '<td>'.GLO_textoExcel($row['Centro'])."</td>\n";		
				echo "<td ".$colorestado.">".$estado."</td>\n";
				echo "<td ".$colordetalle.">".$detalle."</td>\n";
				echo '<td>'.GLO_textoExcel($row['Obs'])."</td>\n";
				echo "</tr>\n";			
			}	
			//Cierra tabla excel
			echo "</table>\n";				
		}	
		mysql_free_result($rs);	mysql_close($conn); 
	}

 }
?>