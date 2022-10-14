<? include("../Codigo/Seguridad.php");include("../Codigo/Config.php");include("../Codigo/Funciones.php");
//perfiles
GLO_PerfilAcceso(14);


if (isset($_POST['CmdBuscar'])){
	foreach($_POST as $key => $value){$_SESSION[$key] = $value;}
	$wfechad="and DATEDIFF(m.Fecha,'".FechaMySql($_POST['TxtFechaDCP'])."')>=0";
	$wfechah="and DATEDIFF(m.Fecha,'".FechaMySql($_POST['TxtFechaHCP'])."')<=0";
	//estado
	$est=intval($_POST['CbEstado']);$west='';
	if($est==1){$west='and pd.Estado=0';}if($est==2){$west='and pd.Estado=1';}if($est==3){$west='and pd.Estado=2';}
	//
	$_SESSION['TxtQISOMINAP']="Select m.*,pd.Obs,pd.Estado,p.Nombre as Nom,p.Apellido as Ap From iso_minutas m,iso_minutas_pd pd,personal p Where m.Id<>0 and m.Id=pd.IdMin and pd.IdPersonal=p.Id $wfechad $wfechah $west Order by m.Fecha,pd.Obs";
	header("Location:Tareas.php");
}




 
 if (isset($_POST['CmdExcel'])){
	$query=$_POST['TxtQISOMINAP'];$query=str_replace("\\", "", $query);
	if ($query!=""){
		$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);$rs=mysql_query($query,$conn);
		if(mysql_num_rows($rs)!=0){	
			//Titulos excel
			include("../Codigo/ExcelHeader.php");
			include("../Codigo/ExcelStyle.php");
			echo "<th>Minuta</th>\n";			
			echo "<th>Fecha</th>\n";
			echo "<th>Hora</th>\n";
			echo "<th>Tema</th>\n";
			echo "<th>Actividad</th>\n";	
			echo "<th>Responsable</th>\n";
			echo "<th>Estado</th>\n";	
			echo "</tr>\n";					
			while($row=mysql_fetch_array($rs)){ 
				if($row['Fecha']!='0000-00-00'){$fecha =FormatoFecha($row['Fecha']);}else{$fecha='';}
				$hora1=date("H:i",strtotime($row['Hora'])); if ($hora1=='00:00'){$hora1="";}
				//estado
				if($row['Estado']==0){$estado='Pendiente';$colorestado=' style="color:#f44336;vertical-align:top"';}
				if($row['Estado']==1){$estado='Realizada';$colorestado=' style="color:#00bcd4;vertical-align:top"';}
				if($row['Estado']==2){$estado='Cancelada';$colorestado=' style="color:#cc0099;vertical-align:top"';}
				//
				echo "<tr>\n";
				echo '<td>'.str_pad($row['Id'], 5, "0", STR_PAD_LEFT)."</td>\n";
				echo '<td>'.$fecha."</td>\n";
				echo '<td>'.$hora1."</td>\n";
				echo '<td>'.GLO_textoExcel($row['Nombre'])."</td>\n";
				echo '<td>'.GLO_textoExcel($row['Obs'])."</td>\n";
				echo '<td>'.GLO_textoExcel($row['Ap'].' '.$row['Nom'])."</td>\n";
				echo "<td".$colorestado.">".$estado."</td>\n";				
				echo "</tr>\n";			
			}	
			//Cierra tabla excel
			echo "</table>\n";				
		}	
		mysql_free_result($rs);	mysql_close($conn); 
	}

 }
?>