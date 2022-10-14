<? include("../Codigo/Seguridad.php");include("../Codigo/Config.php");include("../Codigo/Funciones.php");$_SESSION["NivelArbol"]="../";
//perfiles
GLO_PerfilAcceso(14);
//si no tiene cargados responsables
if (intval($_SESSION["GLO_IdPersCON"])==0 or intval($_SESSION["GLO_IdPersAPR"])==0){header("Location:".$_SESSION["NivelArbol"]."Inicio.php");}



if (isset($_POST['CmdBuscar'])){
	if ((empty($_POST['OptTipo']))){	
		foreach($_POST as $key => $value){$_SESSION[$key] = $value;	}	
		GLO_feedback(3);	
	    header("Location:Control.php");
	}else{
		$consulta="";
		//Documentos obsoletos(6) con copias sin retirar(FechaB=0000-00-00)
		if ($_POST['OptTipo']=='A'){		
			$consulta="Select distinct d.* From iso_doc d,iso_doc_copias c Where d.Id=c.IdDoc and d.IdEstado=6 and c.FechaB='0000-00-00'";
		}
		
		foreach($_POST as $key => $value){$_SESSION[$key] = $value;}
		$_SESSION['TxtConsultaCon']=$consulta;
		header("Location:Control.php");
	}
}





if (isset($_POST['CmdExcel'])){
	$query=$_POST['TxtConsultaCon'];$query=str_replace("\\", "", $query);
	if ($query!=""){
		$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);$rs=mysql_query($query,$conn);
		if(mysql_num_rows($rs)!=0){	
			//Titulos excel
			include("../Codigo/ExcelHeader.php");
			include("../Codigo/ExcelStyle.php");
			echo "<th> Doc.</th>\n";			
			echo "<th>C&oacute;digo</th>\n";		
			echo "<th>Nombre</th>\n";
			echo "<th>Versi&oacute;n</th>\n";
			echo "<th>Creaci&oacute;n</th>\n";
			echo "<th>Control</th>\n";
			echo "<th>Aprobaci&oacute;n</th>\n";
			echo "<th>Expiraci&oacute;n</th>\n";
			echo "</tr>\n";				
			//datos excel	
			while($row=mysql_fetch_array($rs)){ 
				if($row['FechaCRE']!='0000-00-00'){$fecha1 =FormatoFecha($row['FechaCRE']);}else{$fecha1='';}
				if($row['FechaCON']!='0000-00-00'){$fecha2 =FormatoFecha($row['FechaCON']);}else{$fecha2='';}
				if($row['FechaAPR']!='0000-00-00'){$fecha3 =FormatoFecha($row['FechaAPR']);}else{$fecha3='';}
				if($row['FechaEXP']!='0000-00-00'){$fecha4 =FormatoFecha($row['FechaEXP']);}else{$fecha4='';}
				//excel
				echo "<tr>\n";
				echo '<td>'.$row['Id']."</td>\n";
				echo '<td>'.GLO_textoExcel($row['Codigo'])."</td>\n";
				echo '<td>'.GLO_textoExcel($row['Nombre'])."</td>\n";
				echo '<td>'.GLO_textoExcel($row['Version'])."</td>\n";
				echo '<td>'.$fecha1."</td>\n";
				echo '<td>'.$fecha2."</td>\n";
				echo '<td>'.$fecha3."</td>\n";
				echo '<td>'.$fecha4."</td>\n";
				echo "</tr>\n";			
			}	
			//Cierra tabla excel
			echo "</table>\n";				
		}	
		mysql_free_result($rs);	mysql_close($conn); 
	}

 }
 
 
?>