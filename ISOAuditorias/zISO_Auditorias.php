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
		$vbuscar=intval($_POST['CbEstado']);if($vbuscar==1 or $vbuscar==2){$wbuscar=$wbuscar." and (a.IdEstado=$vbuscar and a.Anulado=0)";}
		if($vbuscar==3){$wbuscar=$wbuscar." and a.Anulado=1";}
		$vbuscar=intval($_POST['ChkVto']);	
		if($vbuscar==1){
			$hoy=date("d-m-Y"); 
			$wbuscar=$wbuscar." and ((a.FechaReal='0000-00-00' and DATEDIFF(a.FechaProg,'".FechaMySql($hoy)."')<0) and a.Anulado=0)";
		}
		$consulta="Select a.*,s.Nombre as Sector,t.Nombre as Tipo,y.Nombre as Yac From iso_audi_prog a,yacimientos y,sector s,iso_audi_tipo t Where a.Idyac=y.Id and a.IdSector=s.Id and a.IdTipo=t.Id $wbuscar Order by a.FechaProg";
	}	
	foreach($_POST as $key => $value){$_SESSION[$key] = $value;}
	$_SESSION['TxtQISOAUD']=$consulta;
	header("Location:../ISO_Auditorias.php");
}


if (isset($_POST['CmdBorrarFila'])){	
	$query="Delete From iso_audi_prog Where Id=".intval($_POST['TxtId']);
	$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);$rs=mysql_query($query,$conn);
	if ($rs){GLO_feedback(1);}else{GLO_feedback(2);} 
	mysql_close($conn); 
	foreach($_POST as $key => $value){$_SESSION[$key] = $value;}
	header("Location:../ISO_Auditorias.php"); 	
}




if (isset($_POST['CmdExcel'])){
	$query=$_POST['TxtQISOAUD'];$query=str_replace("\\", "", $query);
	if ($query!=""){
		$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);$rs=mysql_query($query,$conn);
		if(mysql_num_rows($rs)!=0){	
			//Titulos excel
			include("../Codigo/ExcelHeader.php");
			include("../Codigo/ExcelStyle.php");
			echo "<th>Tipo</th>\n";
			echo "<th>Nombre</th>\n";			
			echo "<th>Sector</th>\n";
			echo "<th>Programada</th>\n";			
			echo "<th>Realizada</th>\n";	
			echo "<th>Hora Real</th>\n";			
			echo "<th>Duraci&oacute;n</th>\n";	
			echo "<th>Reprogramada</th>\n";		
			echo "<th>Lugar</th>\n";
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
				if($row['FechaProg']!='0000-00-00'){$fechap =FechaMesYear($row['FechaProg']);}else{$fechap='';}
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
				echo '<td>'.GLO_textoExcel($row['Tipo'])."</td>\n";
				echo '<td>'.GLO_textoExcel($row['Nombre'])."</td>\n";
				echo '<td>'.GLO_textoExcel($row['Sector'])."</td>\n";
				echo '<td>'.$fechap."</td>\n";
				echo '<td>'.$fechar."</td>\n";					
				echo '<td>'.$hora."</td>\n";					
				echo '<td>'.GLO_textoExcel($dur)."</td>\n";	
				echo '<td>'.$fecharp."</td>\n";	
				echo '<td>'.GLO_textoExcel($row['Yac'])."</td>\n";		
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