<? include("../Codigo/Seguridad.php");include("../Codigo/Config.php");include("../Codigo/Funciones.php");$_SESSION["NivelArbol"]="../";
//perfiles
GLO_PerfilAcceso(10);


//Boton Buscar
if (isset($_POST['CmdBuscar'])){
	foreach($_POST as $key => $value){$_SESSION[$key] = $value;}
	$mes=intval($_POST['CbMes']);if($mes!=0){$wmes="and MONTH(p.FechaNacimiento)=$mes";}else{$wmes='';}		
	//todo
	$_SESSION['TxtConsulta']="SELECT p.*, l.Nombre as NombreLocalidad,t.Nombre as Turno,f.Nombre as Funcion,s.Nombre as Sector,p.FechaNacimiento From personal p,localidades l,turnos t,funcion f,sector s where p.Id<>0 and p.IdLocalidad=l.Id and p.IdTurno=t.Id and p.IdFuncion=f.Id and p.IdSector=s.Id and p.FechaBaja='0000-00-00' and p.FechaNacimiento<>'0000-00-00' $wmes Order by MONTH(p.FechaNacimiento), DAY(p.FechaNacimiento),p.Apellido,p.Nombre";
	header("Location:../PersonalCumpl.php");
}



if (isset($_POST['CmdExcel'])){
	$query=$_POST['TxtConsulta'];$query=str_replace("\\", "", $query);
	if ($query!=""){
		$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);$rs=mysql_query($query,$conn);
		if(mysql_num_rows($rs)!=0){	
			//Titulos excel
			include("../Codigo/ExcelHeader.php");	
		include("../Codigo/ExcelStyle.php");	
			echo "<th>Nombre</th>\n";
			echo "<th>Cumplea&ntilde;os</th>\n";
			echo "<th>Edad</th>\n";
			echo "<th>Sector</th>\n";
			echo "<th>Funcion</th>\n";
			echo "<th>Localidad</th>\n";
			echo "<th>Provincia</th>\n";
			echo "</tr>\n";						
			//datos excel	
			while($row=mysql_fetch_array($rs)){ 
				list($a,$m,$d)=explode("-",$row['FechaNacimiento']);$cumple=intval($d)." de ".G_NombreMes($m);
				echo "<tr>\n";
				echo "<td>".$row['Apellido']." ".$row['Nombre']."</td>\n";
				echo '<td>'.$cumple."</td>\n";
				echo "<td>".edad($row['FechaNacimiento'])."</td>\n";
				echo "<td>".$row['Sector']."</td>\n";
				echo "<td>".$row['Funcion']."</td>\n";
				echo "<td>".$row['NombreLocalidad']."</td>\n";
				echo "<td>".$row['Provincia']."</td>\n";
				echo "</tr>\n";			
			}	
			//Cierra tabla excel
			echo "</table>\n";				
		}	
		mysql_free_result($rs);	mysql_close($conn); 
	}
 }




?>