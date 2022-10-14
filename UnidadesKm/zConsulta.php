<? include("../Codigo/Seguridad.php");include("../Codigo/Config.php");include("../Codigo/Funciones.php");$_SESSION["NivelArbol"]="../";include("Includes/zFunciones.php");
//perfiles
GLO_PerfilAcceso(12);


if (isset($_POST['CmdBuscar'])){
	//busca las unidades marcadas como RSV
	foreach($_POST as $key => $value){$_SESSION[$key] = $value;}
	//valida algun filtro
	if(empty($_POST['TxtFechaD']) and empty($_POST['TxtFechaH'])){
		$_SESSION['TxtQUNIKM']='';$_SESSION['GLO_msgE']='Por favor seleccione Periodo';
	}else{
		$wbuscar='';
		if (!(empty($_POST['TxtFechaD']))){$wbuscar=$wbuscar." and DATEDIFF(u2.Fecha,'".FechaMySql($_POST['TxtFechaD'])."')>=0";}
		if (!(empty($_POST['TxtFechaH']))){$wbuscar=$wbuscar." and DATEDIFF(u2.Fecha,'".FechaMySql($_POST['TxtFechaH'])."')<=0";}
		$vbuscar=intval($_POST['CbMes']);if($vbuscar!=0){$wbuscar=$wbuscar." and MONTH(u2.Fecha)=$vbuscar";}
		//dominio/nombre
		if ( !(empty($_POST['TxtBusqueda'])) or  !(empty($_POST['TxtBusqueda2'])) ){
			$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);
			$textodominio=mysql_real_escape_string($_POST['TxtBusqueda']);
			$wbuscar=$wbuscar." and (REPLACE(TRIM(u2.Dominio),'-','')  Like '%".trim(strtoupper(str_replace('-','',str_replace(' ','',$textodominio))))."%')";
			$textonombre=mysql_real_escape_string($_POST['TxtBusqueda2']);
			mysql_close($conn); 
		}

		//filtra nombre unidad 
		if($textonombre!=''){
			//busca el dominio de las uniddaes de quinpe con ese nombre
			$queryunidadesquinpe="( SELECT REPLACE(REPLACE(TRIM(u.Dominio),'-',''),' ','') From unidades u Where u.Id<>0  and (u.Nombre Like '%".$textonombre."%') )";
			$wherenombrequinpe=" and ( REPLACE(REPLACE(TRIM(u2.Dominio),'-',''),' ','') IN  $queryunidadesquinpe)";
		}else{$wherenombrequinpe='';}

		//tipo reporte
		if($_POST['OptTipo']==2){//detallado
			$_SESSION['TxtQUNIKM']="SELECT u2.* From unidadeskm u2 Where u2.Id<>0  $wbuscar $wherenombrequinpe Order by u2.Fecha,u2.Dominio";
		}else{
			//acumulado trae horas en segundos
			$query="SELECT u2.Km,u2.Hm,u2.Hr,u2.Fecha,REPLACE(TRIM(u2.Dominio),'-','') as Dominio FROM unidadeskm u2 WHERE u2.Id<>0 $wbuscar $wherenombrequinpe";
			$_SESSION['TxtQUNIKM']="SELECT sum(x.Km) as Km,SUM(TIME_TO_SEC(x.Hm)) as Hm,SUM(TIME_TO_SEC(x.Hr)) as Hr, x.Dominio From ($query) x Group By x.Dominio Order by x.Fecha,x.Dominio";
		}
	}
	//
	header("Location:Consulta.php");
}


elseif (isset($_POST['CmdExcel'])){
	$query=$_POST['TxtQUNIKM'];$query=str_replace("\\", "", $query);
	if ($query!=""){
		$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);$rs=mysql_query($query,$conn);
		if(mysql_num_rows($rs)!=0){	
			//Titulos excel
			include("../Codigo/ExcelHeader.php");
			include("../Codigo/ExcelStyle.php");
			echo "<th>Dominio</th>\n";
			echo "<th>Numero</th>\n";
			echo "<th>Nombre</th>\n";	
			if($_POST['OptTipo']==2){echo "<th>Fecha</th>\n";}//detallado	
			echo "<th>Km Recorridos</th>\n";		
			echo "<th>Hs Marcha</th>\n";			
			echo "<th>Hs Ralenti</th>\n";
			echo "</tr>\n";				
			while($row=mysql_fetch_array($rs)){ 
				UNIKM_buscarunidad($row['Dominio'],$nom,$nro,$conn);
				//
				echo "<tr>\n";					
				echo '<td>'.GLO_textoExcel($row['Dominio'])."</td>\n";
				echo '<td>'.GLO_SinCeroSTRPAD($nro,6)."</td>\n";
				echo '<td>'.GLO_textoExcel($nom)."</td>\n";
				//detallado
				if($_POST['OptTipo']==2){
					echo '<td>'.GLO_FormatoFecha($row['Fecha'])."</td>\n";
					echo '<td>'.number_format($row['Km'],2, ',', '')."</td>\n";	
					echo '<td>'.GLO_HoraaDecimal($row['Hm'])."</td>\n";	
					echo '<td>'.GLO_HoraaDecimal($row['Hr'])."</td>\n";	
					}else{
						echo '<td>'.number_format($row['Km'],2, ',', '')."</td>\n";	
						echo '<td>'.GLO_SegundosaDecimal($row['Hm'])."</td>\n";	
						echo '<td>'.GLO_SegundosaDecimal($row['Hr'])."</td>\n";	
					}	
				echo "</tr>\n";			
			}	
			echo "</table>\n";				
		}mysql_free_result($rs);		  
		mysql_close($conn); 
	}

 }


?>