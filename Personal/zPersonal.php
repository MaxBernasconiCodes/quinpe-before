<? include("../Codigo/Seguridad.php");include("../Codigo/Config.php");include("../Codigo/Funciones.php");$_SESSION["NivelArbol"]="../";
//perfiles
GLO_PerfilAcceso(10);



//Boton Buscar
if (isset($_POST['CmdBuscar'])){
	$fechahoy=FechaMySql(date("d-m-Y"));
	$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);
	foreach($_POST as $key => $value){$_SESSION[$key] = $value;}
	//personal
	if ((empty($_POST['TxtBusqueda']))){$wpers="";}
	else{$wpers="and (p.Nombre Like '%".mysql_real_escape_string($_POST['TxtBusqueda'])."%' or p.Apellido Like '%".mysql_real_escape_string($_POST['TxtBusqueda'])."%')";}
	//combos
	$sector=intval($_POST['CbSector']);if($sector!=0){$wsector="and p.IdSector=$sector";}else{$wsector='';}
	$func=intval($_POST['CbFuncion']);if($func!=0){$wfunc="and p.IdFuncion=$func";}else{$wfunc='';}
	$activo=intval($_POST['ChkActivo']);if($activo==0){$wactivo="and (p.FechaBaja='0000-00-00' or DATEDIFF('".$fechahoy. "',p.FechaBaja)<0)";}else{$wactivo="and (DATEDIFF('".$fechahoy. "',p.FechaBaja)>=0)";}
	//query pagina
	$_SESSION['TxtQPERS']="SELECT p.*,l.Nombre as NombreLocalidad,f.Nombre as Funcion,rs.Nombre as RazonSocial From personal p,localidades l,funcion f,parametrosrs rs where p.Id<>0 and p.IdLocalidad=l.Id and p.IdFuncion=f.Id and p.IdRS=rs.Id $wpers $wsector $wfunc $wactivo Order by p.FechaBaja,p.Apellido,p.Nombre";
	//query excel
	$_SESSION['TxtQPEREX']="SELECT p.*,l.Nombre as NombreLocalidad,l2.Nombre as NombreLocalidadL,t.Nombre as Turno,f.Nombre as Funcion,s.Nombre as Sector,a.Nombre as ART,rs.Nombre as RazonSocial,ee.Nombre as Estudios From personal p,localidades l,localidades l2,turnos t,funcion f,sector s, art a,parametrosrs rs, estudios ee where p.Id<>0 and p.IdLocalidad=l.Id and p.IdLocalidadL=l2.Id and p.IdTurno=t.Id and p.IdFuncion=f.Id and p.IdSector=s.Id and a.Id=p.IdART and p.IdRS=rs.Id and p.IdEstudios=ee.Id $wpers $wsector $wfunc $wactivo Order by p.FechaBaja,p.Apellido,p.Nombre";
	mysql_close($conn); 
	header("Location:../Personal.php");
}




if (isset($_POST['CmdBorrarFila'])){
	$idpers=intval($_POST['TxtId']);$tipoent="R";
	$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);
	foreach($_POST as $key => $value){$_SESSION[$key] = $value;}
	$query="Delete From personal Where Id=$idpers";	$rs=mysql_query($query,$conn);
	if ($rs){GLO_feedback(1);
	//borro telefonos
	$query="Delete From telefonos Where IdEntidad=$idpers and TipoEntidad='$tipoent'";$rs=mysql_query($query,$conn);	
	}else{GLO_feedback(2); } 
	mysql_close($conn); 	
	header("Location:../Personal.php");
}



if (isset($_POST['CmdExcel'])){
$query=$_POST['TxtQPEREX'];$query=str_replace("\\", "", $query);
if ($query!=""){
	$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);$rs=mysql_query($query,$conn);
	if(mysql_num_rows($rs)!=0){	
		//Titulos excel
		include("../Codigo/ExcelHeader.php");	
		include("../Codigo/ExcelStyle.php");
		echo "<th>Legajo</th>\n";
		echo "<th>Nombre</th>\n";
		echo "<th>Documento</th>\n";
		echo "<th>Identificaci&oacute;n</th>\n";	
		echo "<th>Estado Civil</th>\n";
		echo "<th>Carga Familiar</th>\n";
		//
		echo "<th>Fecha Nac.</th>\n";
		echo "<th>Lugar Nac.</th>\n";
		echo "<th>Nacionalidad</th>\n";
		echo "<th>Estudios</th>\n";
		echo "<th>EMail</th>\n";
		//
		echo "<th>Direcci&oacute;n Real</th>\n";
		echo "<th>Localidad Real</th>\n";
		echo "<th>Provincia Real</th>\n";
		echo "<th>CP Real</th>\n";
		//
		echo "<th>Direcci&oacute;n Legal</th>\n";
		echo "<th>Localidad Legal</th>\n";
		echo "<th>Provincia Legal</th>\n";
		echo "<th>CP Legal</th>\n";
		//
		echo "<th>Alta</th>\n";
		echo "<th>Baja</th>\n";
		echo "<th>Razon Social</th>\n";
		echo "<th>Sector</th>\n";
		echo "<th>Funcion</th>\n";
		echo "<th>Turno</th>\n";
		//
		echo "<th>ART</th>\n";
		echo "<th>Obra Social</th>\n";
		echo "<th>Categoria OS</th>\n";		
		echo "<th>Convenio</th>\n";
		//
		echo "<th>Observaciones</th>\n";
		echo "</tr>\n";	
		while($row=mysql_fetch_array($rs)){ 
			$falta= FormatoFecha($row['FechaAlta']);if ($falta=='00-00-0000'){$falta="";}
			$fbaja= FormatoFecha($row['FechaBaja']);if ($fbaja=='00-00-0000'){$fbaja="";}
			$fnac= FormatoFecha($row['FechaNacimiento']);if ($fnac=='00-00-0000'){$fnac="";}
			echo "<tr>\n";
			echo "<td align='right'>".str_pad($row['Legajo'], 6, "0", STR_PAD_LEFT)."</td>\n";
			echo '<td>'.GLO_textoExcel($row['Apellido']." ".$row['Nombre'])."</td>\n";
			echo '<td>'.$row['TipoDocumento']." ".$row['Documento']."</td>\n";
			echo '<td>'.$row['TipoIdentificacion']." ".$row['Identificacion']."</td>\n";
			echo '<td>'.GLO_textoExcel($row['EstadoCivil'])."</td>\n";
			echo '<td>'.$row['CargaFamiliar']."</td>\n";
			//
			echo '<td>'.$fnac."</td>\n";
			echo '<td>'.GLO_textoExcel($row['LugarNacimiento'])."</td>\n";
			echo '<td>'.GLO_textoExcel($row['Nacionalidad'])."</td>\n";
			echo '<td>'.GLO_textoExcel($row['Estudios'])."</td>\n";	
			echo '<td>'.GLO_textoExcel($row['EMail'])."</td>\n";
			//
			echo '<td>'.GLO_textoExcel($row['Direccion'])."</td>\n";
			echo '<td>'.GLO_textoExcel($row['NombreLocalidad'])."</td>\n";
			echo '<td>'.GLO_textoExcel($row['Provincia'])."</td>\n";
			echo '<td>'.GLO_textoExcel($row['CP'])."</td>\n";
			//
			echo '<td>'.GLO_textoExcel($row['DireccionL'])."</td>\n";
			echo '<td>'.GLO_textoExcel($row['NombreLocalidadL'])."</td>\n";
			echo '<td>'.GLO_textoExcel($row['ProvinciaL'])."</td>\n";
			echo '<td>'.GLO_textoExcel($row['CPL'])."</td>\n";
			//
			echo '<td>'.$falta."</td>\n";
			echo '<td>'.$fbaja."</td>\n";
			echo '<td>'.GLO_textoExcel($row['RazonSocial'])."</td>\n";
			echo '<td>'.GLO_textoExcel($row['Sector'])."</td>\n";
			echo '<td>'.GLO_textoExcel($row['Funcion'])."</td>\n";
			echo '<td>'.GLO_textoExcel($row['Turno'])."</td>\n";
			//
			echo '<td>'.GLO_textoExcel($row['ART'])."</td>\n";			
			echo '<td>'.GLO_textoExcel($row['ObraSocial'])."</td>\n";
			echo '<td>'.GLO_textoExcel($row['CategoriaOS'])."</td>\n";
			echo '<td>'.GLO_textoExcel($row['Convenio'])."</td>\n";
			echo '<td>'.GLO_textoExcel($row['Observaciones'])."</td>\n";	
			echo "</tr>\n";			
		}	
		//Cierra tabla excel
		echo "</table>\n";				
	}	
	mysql_free_result($rs);	mysql_close($conn); 
}

 }




?>