<? include("../Codigo/Seguridad.php");include("../Codigo/Config.php");include("../Codigo/Funciones.php");include("Includes/zFunciones.php");
//perfiles
GLO_PerfilAcceso(14);


if (isset($_POST['CmdBuscar'])){
	foreach($_POST as $key => $value){$_SESSION[$key] = $value;}
	if(!(empty($_POST['TxtFechaDCP']))){$wfechad="and DATEDIFF(m.Fecha,'".FechaMySql($_POST['TxtFechaDCP'])."')>=0";}else{$wfechad='';}
	if(!(empty($_POST['TxtFechaHCP']))){$wfechah="and DATEDIFF(m.Fecha,'".FechaMySql($_POST['TxtFechaHCP'])."')<=0";}else{$wfechah='';}
	$est=intval($_POST['CbEstado']);if($est!=0){$west="and m.Estado=$est";}else{$west='';}
	$prio=intval($_POST['CbPrio']);if($prio!=0){$wprio="and m.Prio=$prio";}else{$wprio='';}
	//
	$_SESSION['TxtQISOCAM']="Select m.* From iso_cambios m Where m.Id<>0 $wfechad $wfechah $west $wprio Order by m.Fecha";
	header("Location:../ISO_Cambios.php");
}


if (isset($_POST['CmdBorrarFila'])){
	$query="Delete From iso_cambios Where Id=".intval($_POST['TxtId']);
	$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);$rs=mysql_query($query,$conn);
	if ($rs){GLO_feedback(1);}else{GLO_feedback(2);} 
	mysql_close($conn); 
	header("Location:../ISO_Cambios.php"); 	
}



if (isset($_POST['CmdAgregar'])){	
	foreach($_POST as $key => $value){$_SESSION[$key] = "";}
	$_SESSION['TxtQISOCAM']=$_POST['TxtQISOCAM'];
	header("Location:Alta.php");
}

if (isset($_POST['CmdLinkRow'])){
	foreach($_POST as $key => $value){$_SESSION[$key] = "";}
	$_SESSION['TxtQISOCAM']=$_POST['TxtQISOCAM'];
	header("Location:Modificar.php?id=".intval($_POST['TxtId'])."&Flag1=True");
}


if (isset($_POST['CmdSalir'])){
	foreach($_POST as $key => $value){$_SESSION[$key] = '';}
	header("Location:../Inicio.php");
}


 
 if (isset($_POST['CmdExcel'])){
	$query=$_POST['TxtQISOCAM'];$query=str_replace("\\", "", $query);
	if ($query!=""){
		$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);$rs=mysql_query($query,$conn);
		if(mysql_num_rows($rs)!=0){	
			//Titulos excel
			include("../Codigo/ExcelHeader.php");
			include("../Codigo/ExcelStyle.php");
			echo "<th>Numero</th>\n";			
			echo "<th>Fecha</th>\n";
			echo "<th>Obra/Serv/Sector</th>\n";
			echo "<th>Prioridad</th>\n";
			echo "<th>Estado</th>\n";
			echo "<th>Tipo Cambio</th>\n";	
			echo "<th>Evaluacion</th>\n";
			echo "<th>Integrantes Evaluacion</th>\n";
			echo "<th>Resolucion</th>\n";
			echo "<th>Actividades Pendientes</th>\n";	
			echo "</tr>\n";					
			while($row=mysql_fetch_array($rs)){ 
				$idpadre=$row['Id'];
				//tipo
				$tipoc="";
				$query="SELECT p.Nombre as Tipo From iso_cambios_t1 m,iso_cambios_tipo p where m.IdTipo=p.Id and m.IdPadre=$idpadre Order by m.Id";$rs2=mysql_query($query,$conn);
					while($row2=mysql_fetch_array($rs2)){ $tipoc=GLO_ListaTexto($tipoc,$row2['Tipo']);}mysql_free_result($rs2);	
				//integrantes
				$integr="";
				$query="SELECT p.Nombre as Nom,p.Apellido as Ap From iso_cambios_r1 m,personal p where m.IdPersonal=p.Id and m.IdPadre=$idpadre Order by m.Id";$rs2=mysql_query($query,$conn);
				while($row2=mysql_fetch_array($rs2)){ $integr=GLO_ListaTexto($integr,$row2['Ap'].' '.$row2['Nom']);	}mysql_free_result($rs2);	
				//actividades
				$pend="";
				$query="SELECT m.Obs From iso_cambios_plan m,personal p where m.IdPersonal=p.Id and m.IdPadre=$idpadre Order by m.Id";$rs2=mysql_query($query,$conn);
				while($row2=mysql_fetch_array($rs2)){ $pend=GLO_ListaTexto($pend,$row2['Obs']);	}mysql_free_result($rs2);	
				//excel
				echo "<tr>\n";
				echo '<td>'.str_pad($row['Id'], 5, "0", STR_PAD_LEFT)."</td>\n";
				echo '<td>'.GLO_FormatoFecha($row['Fecha'])."</td>\n";
				echo '<td>'.GLO_textoExcel($row['Nombre'])."</td>\n";
				echo '<td>'.CAM_BuscaPrioridad($row['Prio'])."</td>\n";
				echo '<td>'.CAM_BuscaEstado($row['Estado'])."</td>\n";				
				echo '<td>'.GLO_textoExcel($tipoc)."</td>\n";
				echo '<td>'.GLO_FormatoFecha($row['FechaE'])."</td>\n";
				echo '<td>'.GLO_textoExcel($integr)."</td>\n";
				echo '<td>'.GLO_FormatoFecha($row['FechaR'])."</td>\n";
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