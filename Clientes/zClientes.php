<? include("../Codigo/Seguridad.php");include("../Codigo/Config.php");include("../Codigo/Funciones.php");$_SESSION["NivelArbol"]="../";
//perfiles
if ($_SESSION["IdPerfilUser"]!=1 and $_SESSION["IdPerfilUser"]!=2 and $_SESSION["IdPerfilUser"]!=5 and $_SESSION["IdPerfilUser"]!=3  and $_SESSION["IdPerfilUser"]!=11  and $_SESSION["IdPerfilUser"]!=12  and $_SESSION["IdPerfilUser"]!=9 and $_SESSION["IdPerfilUser"]!=14 ){ header("Location:".$_SESSION["NivelArbol"]."Inicio.php");}



if (isset($_POST['CmdBuscar'])){
	foreach($_POST as $key => $value){$_SESSION[$key] = $value;}
	$wbuscar='';
	$vbuscar=intval($_POST['CbActividad']);if($vbuscar!=0){$wbuscar=$wbuscar." and p.IdActividad=$vbuscar";}
	$vbuscar=intval($_POST['ChkActivo']);if($vbuscar!=0){$wbuscar=$wbuscar." and (p.FechaBaja='0000-00-00' or DATEDIFF('".FechaMySql(date("d-m-Y")). "',p.FechaBaja)<0)";}
	//conecta
	if ( !(empty($_POST['TxtBusqueda'])) or !(empty($_POST['TxtBusquedaCUIT'])) ){
		$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);
		//
		if (!(empty($_POST['TxtBusqueda']))){$wbuscar=$wbuscar." and (p.Nombre Like '%".mysql_real_escape_string($_POST['TxtBusqueda'])."%' or p.Apellido Like '%".mysql_real_escape_string($_POST['TxtBusqueda'])."%')";}
		//
		if (!(empty($_POST['TxtBusquedaCUIT']))){$wbuscar=$wbuscar." and (p.Identificacion Like '%".mysql_real_escape_string($_POST['TxtBusquedaCUIT'])."%')";}
		mysql_close($conn); 
	}
	//
	$_SESSION['TxtQCLI']='SELECT p.*, l.Nombre as NombreLocalidad,a.Nombre as Actividad,cv.Nombre as IVA From clientes p,localidades l,actividades a,condicioniva cv  where p.Id<>0 and p.IdLocalidad=l.Id and p.IdActividad=a.Id and p.IdIva=cv.Id '.$wbuscar.' Order by p.FechaBaja,p.Nombre';
	//
	header("Location:../Clientes.php");
}





if (isset($_POST['CmdExcel'])){
$query=$_POST['TxtQCLI'];$query=str_replace("\\", "", $query);
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
		echo "<th>Observaciones</th>\n";
		echo "<th>Tel&eacute;fonos</th>\n";	
		echo "</tr>\n";	
		while($row=mysql_fetch_array($rs)){ 
			echo "<tr>\n";
			echo '<td>'.$row['Id']."</td>\n";
			echo '<td>'.$row['Nombre']."</td>\n";
			echo '<td>'.$row['Apellido']."</td>\n";
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
			echo '<td>'.$row['Obs']."</td>\n";	
			//telefonos
			$query='SELECT * From clitelefonos where Id<>0 and IdEntidad='.$row['Id'];$rs2=mysql_query($query,$conn);$tels="";
			while($row2=mysql_fetch_array($rs2)){ $tels=$tels."(".$row2['CodigoArea']." )".$row2['NumeroTelefono'].";";	}mysql_free_result($rs2);	
			echo '<td>'.$tels."</td>\n";						
			echo "</tr>\n";			
		}	
		echo "</table>\n";				
	}	
	mysql_free_result($rs);	mysql_close($conn); 
}

 }





if (isset($_POST['CmdLista'])){//exporta importes vigentes
	$query="SELECT i.Nombre, c.Nombre as Cli,ici.*,ic.IdContrato From items i, itemscliente ic, itemsclienteimporte ici, clientes c where i.Id<>0 and i.Id=ic.IdItem and ic.Id=ici.IdItemCliente and ic.IdCliente=c.Id and ici.FechaH='0000-00-00' Order by c.Nombre,ic.IdContrato,i.Nombre";
	if ($query!=""){
		$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);$rs=mysql_query($query,$conn);
		if(mysql_num_rows($rs)!=0){	
			include("../Codigo/ExcelHeader.php");
			include("../Codigo/ExcelStyle.php");
			echo "<th>Cliente</th>\n";
			echo "<th>Contrato</th>\n";
			echo "<th >Concepto</th>\n";
			echo "<th >Importe</th>\n";
			echo "<th >Moneda</th>\n";
			echo "<th >Desde</th>\n";
			echo "<th >Observaciones Importe</th>\n";
			echo "</tr>\n";	
			
			while($row=mysql_fetch_array($rs)){ 
				$fechad =GLO_FormatoFecha($row['FechaD']);
				if ($row['Importe']==0){$costo=0;}else{$costo=number_format($row['Importe'], 2, ',', '');}
				if($row['Moneda']==0){$mon='Pesos';}else{$mon='D&oacute;lares';}
				echo "<tr>\n";
				echo '<td>'.$row['Cli']."</td>\n";
				echo '<td>'.$row['IdContrato']."</td>\n";
				echo '<td>'.GLO_textoExcel($row['Nombre'])."</td>\n";
				echo '<td>'.$costo."</td>\n";
				echo '<td>'.$mon."</td>\n";
				echo '<td>'.$fechad."</td>\n";
				echo '<td>'.GLO_textoExcel($row['Obs'])."</td>\n";
				echo "</tr>\n";		
			}	
			echo "</table>\n";	
		}	
		mysql_free_result($rs);	mysql_close($conn); 
	}

 }


?>