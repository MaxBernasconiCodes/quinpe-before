<? include("../Codigo/Seguridad.php");include("../Codigo/Config.php");include("../Codigo/Funciones.php");
//perfiles
GLO_PerfilAcceso(14);


if (isset($_POST['CmdBuscar'])){
	foreach($_POST as $key => $value){$_SESSION[$key] = $value;}
	if(!(empty($_POST['TxtFechaDCP']))){$wfechad="and DATEDIFF(m.Fecha,'".FechaMySql($_POST['TxtFechaDCP'])."')>=0";}else{$wfechad='';}
	if(!(empty($_POST['TxtFechaHCP']))){$wfechah="and DATEDIFF(m.Fecha,'".FechaMySql($_POST['TxtFechaHCP'])."')<=0";}else{$wfechah='';}
	//
	$_SESSION['TxtQISOMIN']="Select m.* From iso_minutas m Where m.Id<>0 $wfechad $wfechah Order by m.Fecha,m.Hora";
	header("Location:../ISO_Minutas.php");
}


if (isset($_POST['CmdBorrarFila'])){
	$query="Delete From iso_minutas Where Id=".intval($_POST['TxtId']);
	$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);$rs=mysql_query($query,$conn);
	if ($rs){GLO_feedback(1);}else{GLO_feedback(2);} 
	mysql_close($conn); 
	header("Location:../ISO_Minutas.php"); 	
}



if (isset($_POST['CmdLinkRow'])){
	foreach($_POST as $key => $value){$_SESSION[$key] = "";}
	$_SESSION['TxtQISOMIN']=$_POST['TxtQISOMIN'];
	header("Location:Modificar.php?id=".intval($_POST['TxtId'])."&Flag1=True");
}

 
 if (isset($_POST['CmdExcel'])){
	$query=$_POST['TxtQISOMIN'];$query=str_replace("\\", "", $query);
	if ($query!=""){
		$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);$rs=mysql_query($query,$conn);
		if(mysql_num_rows($rs)!=0){	
			//Titulos excel
			include("../Codigo/ExcelHeader.php");
			include("../Codigo/ExcelStyle.php");
			echo "<th>Fecha</th>\n";
			echo "<th>Hora</th>\n";
			echo "<th>Tema</th>\n";
			echo "<th>Asistentes</th>\n";	
			echo "<th>Desarrollo</th>\n";
			echo "<th>Pendientes</th>\n";	
			echo "</tr>\n";					
			while($row=mysql_fetch_array($rs)){ 
				if($row['Fecha']!='0000-00-00'){$fecha =FormatoFecha($row['Fecha']);}else{$fecha='';}
				$hora1=date("H:i",strtotime($row['Hora'])); if ($hora1=='00:00'){$hora1="";}
				//asistentes
				$asist="";
				$query="SELECT m.*,p.Nombre as Nom,p.Apellido as Ap From iso_minutas_as m,personal p where m.Id<>0 and m.IdPersonal=p.Id and m.IdMin=".$row['Id'];$rs2=mysql_query($query,$conn);
				//si carga personal lo muestra, sino muestra texto				
				while($row2=mysql_fetch_array($rs2)){ 
					if($row2['IdPersonal']==0){$nomasistente=$row2['Nombre'];}else{$nomasistente=$row2['Ap'].' '.$row2['Nom'];}
					$asist=GLO_ListaTexto($asist,$nomasistente);	
				}mysql_free_result($rs2);	
				//desarrollo
				$desa="";
				$query="SELECT m.* From iso_minutas_des m where m.Id<>0 and m.IdMin=".$row['Id'];$rs2=mysql_query($query,$conn);
				while($row2=mysql_fetch_array($rs2)){ $desa=GLO_ListaTexto($desa,$row2['Obs']);	}mysql_free_result($rs2);	
				//pendientes
				$pend="";
				$query="SELECT m.* From iso_minutas_pd m where m.Id<>0 and m.IdMin=".$row['Id'];$rs2=mysql_query($query,$conn);
				while($row2=mysql_fetch_array($rs2)){ $pend=GLO_ListaTexto($pend,$row2['Obs']);	}mysql_free_result($rs2);	
				//excel
				echo "<tr>\n";
				echo '<td>'.$fecha."</td>\n";
				echo '<td>'.$hora1."</td>\n";
				echo '<td>'.GLO_textoExcel($row['Nombre'])."</td>\n";
				echo '<td>'.GLO_textoExcel($asist)."</td>\n";
				echo '<td>'.GLO_textoExcel($desa)."</td>\n";
				echo '<td>'.GLO_textoExcel($pend)."</td>\n";				
				echo "</tr>\n";			
			}	
			//Cierra tabla excel
			echo "</table>\n";				
		}	
		mysql_free_result($rs);	mysql_close($conn); 
	}

 }
?>