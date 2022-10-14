<? include("../Codigo/Seguridad.php");include("../Codigo/Config.php");include("../Codigo/Funciones.php");$_SESSION["NivelArbol"]="../";
//perfiles
if ($_SESSION["IdPerfilUser"]!=1 and $_SESSION["IdPerfilUser"]!=2 and $_SESSION["IdPerfilUser"]!=11){ header("Location:".$_SESSION["NivelArbol"]."Inicio.php");}


if (isset($_POST['CmdBuscar'])){
	foreach($_POST as $key => $value){$_SESSION[$key] = $value;}
	$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);
	//
	$wbuscar='';
	$vbuscar=intval($_POST['CbActividad']);if($vbuscar!=0){$wbuscar=$wbuscar." and p.IdActividad=$vbuscar";}
	$vbuscar=intval($_POST['ChkActivo']);if($vbuscar!=0){$wbuscar=$wbuscar." and (p.FechaBaja='0000-00-00' or DATEDIFF('".FechaMySql(date("d-m-Y")). "',p.FechaBaja)<0)";}
	//
	if (!(empty($_POST['TxtBusqueda']))){$wbuscar=$wbuscar." and (p.Nombre Like '%".mysql_real_escape_string($_POST['TxtBusqueda'])."%' or p.Apellido Like '%".mysql_real_escape_string($_POST['TxtBusqueda'])."%')";}
	//
	if (!(empty($_POST['TxtBusquedaCUIT']))){$wbuscar=$wbuscar." and (p.Identificacion Like '%".mysql_real_escape_string($_POST['TxtBusquedaCUIT'])."%')";}
	//
	$vbuscar=intval($_POST['ChkC1']);if($vbuscar!=0){$wbuscar=$wbuscar." and p.Critico=1";}
	$vbuscar=intval($_POST['ChkC2']);if($vbuscar!=0){$wbuscar=$wbuscar." and p.Evaluar=1";}
	//query 
	$_SESSION['TxtQPROV']='SELECT p.*, l.Nombre as NombreLocalidad,a.Nombre as Actividad,cv.Nombre as IVA From proveedores p,localidades l,actividades a,condicioniva cv  where p.Id<>0 and p.IdLocalidad=l.Id and p.IdActividad=a.Id and p.IdIva=cv.Id '.$wbuscar.' Order by p.FechaBaja,p.Apellido';
	mysql_close($conn); 
	header("Location:../Proveedores.php");
}





if (isset($_POST['CmdExcel'])){
$query=$_POST['TxtQPROV'];$query=str_replace("\\", "", $query);
if ($query!=""){
	$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);$rs=mysql_query($query,$conn);
	if(mysql_num_rows($rs)!=0){	
		include("../Codigo/ExcelHeader.php");	
		include("../Codigo/ExcelStyle.php");
		echo "<th>N&uacute;mero</th>\n";
		echo "<th>Raz&oacute;n Social</th>\n";
		echo "<th>Nombre Fantas&iacute;a</th>\n";
		echo "<th>Alta</th>\n";
		echo "<th>Baja</th>\n";
		echo "<th>Identificaci&oacute;n</th>\n";
		echo "<th>Cond.IVA</th>\n";			
		echo "<th>Direcci&oacute;n</th>\n";
		echo "<th>Localidad</th>\n";
		echo "<th>Provincia</th>\n";
		echo "<th>CP</th>\n";
		echo "<th>EMail</th>\n";
		echo "<th>Actividad</th>\n";
		echo "<th>Tipo</th>\n";
		echo "<th>Observaciones</th>\n";
		echo "<th>Tel&eacute;fonos</th>\n";	
		echo "</tr>\n";	
		while($row=mysql_fetch_array($rs)){ 
			$tipo='';if($row['Tipo']==0){$tipo='Externo';}else{$tipo='Interno';}//0:externo, 1:interno
			echo "<tr>\n";
			echo '<td>'.$row['Id']."</td>\n";
			echo '<td>'.$row['Apellido']."</td>\n";
			echo '<td>'.$row['Nombre']."</td>\n";
			echo '<td>'.GLO_FormatoFecha($row['FechaAlta'])."</td>\n";
			echo '<td>'.GLO_FormatoFecha($row['FechaBaja'])."</td>\n";
			echo '<td>'.$row['TipoIdentificacion']." ".$row['Identificacion']."</td>\n";
			echo '<td>'.$row['IVA']."</td>\n";
			echo '<td>'.$row['Direccion']."</td>\n";
			echo '<td>'.$row['NombreLocalidad']."</td>\n";
			echo '<td>'.$row['Provincia']."</td>\n";
			echo '<td>'.$row['CP']."</td>\n";
			echo '<td>'.$row['Email']."</td>\n";
			echo '<td>'.$row['Actividad']."</td>\n";
			echo "<td>".$tipo."</td>\n";
			echo '<td>'.$row['Observaciones']."</td>\n";	
			//telefonos
			$query='SELECT * From provtelefonos where Id<>0 and IdEntidad='.$row['Id'];$rs2=mysql_query($query,$conn);$tels="";
			while($row2=mysql_fetch_array($rs2)){ $tels=$tels."(".$row2['CodigoArea']." )".$row2['NumeroTelefono'].";";	}mysql_free_result($rs2);	
			echo '<td>'.$tels."</td>\n";						
			echo "</tr>\n";			
		}	
		echo "</table>\n";				
	}	
	mysql_free_result($rs);	mysql_close($conn); 
}

 }





?>