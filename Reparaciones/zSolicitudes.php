<? include("../Codigo/Seguridad.php");include("../Codigo/Config.php");include("../Codigo/Funciones.php");$_SESSION["NivelArbol"]="../";
//perfiles
if ($_SESSION["IdPerfilUser"]!=1 and $_SESSION["IdPerfilUser"]!=2 and $_SESSION["IdPerfilUser"]!=4 and $_SESSION["IdPerfilUser"]!=7 and $_SESSION["IdPerfilUser"]!=3  and $_SESSION["IdPerfilUser"]!=11  and $_SESSION["IdPerfilUser"]!=12  and $_SESSION["IdPerfilUser"]!=9 and $_SESSION["IdPerfilUser"]!=14 ){ header("Location:".$_SESSION["NivelArbol"]."Inicio.php");}



//Boton Buscar
if (isset($_POST['CmdBuscar'])){
	$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);
	foreach($_POST as $key => $value){$_SESSION[$key] = $value;}
	//where 
	$wbuscar="";
	if (!(empty($_POST['TxtFechaD']))){$wbuscar=$wbuscar." and DATEDIFF(r.Fecha,'".FechaMySql($_POST['TxtFechaD'])."')>=0";}
	if (!(empty($_POST['TxtFechaH']))){$wbuscar=$wbuscar." and DATEDIFF(r.Fecha,'".FechaMySql($_POST['TxtFechaH'])."')<=0";}
	$vbuscar=intval($_POST['CbEstado']);if($vbuscar!=0){$wbuscar=$wbuscar." and r.IdEstado=$vbuscar";}
	$vbuscar=intval($_POST['TxtNroPR']);if($vbuscar!=0){$wbuscar=$wbuscar." and r.Id=$vbuscar";}	
	$vbuscar=intval($_POST['ChkSOrden']);if($vbuscar!=0){$wbuscar=$wbuscar." and r.IdOrden=0";}	
	$vbuscar=intval($_POST['CbUnidad']);if($vbuscar!=0){$wbuscar=$wbuscar." and r.IdUnidad=$vbuscar";}
	$vbuscar=intval($_POST['CbSector']);if($vbuscar!=0){$wbuscar=$wbuscar." and r.IdSector=$vbuscar";}
	$vbuscar=intval($_POST['CbInstrumento']);if($vbuscar!=0){$wbuscar=$wbuscar." and r.IdInstr=$vbuscar";}
	$vbuscar=intval($_POST['CbPersonal']);if($vbuscar!=0){$wbuscar=$wbuscar." and r.IdPersonal=$vbuscar";}
	//query
	$_SESSION['TxtQREPSOL']="SELECT r.*,u.Nombre as Uni,u.Dominio,e.Nombre as Estado,rt.Nombre as TipoS,p.Apellido as Ap,p.Nombre as Nom,o.FechaI,o.FechaE,o.Obs,eo.Nombre as EstadoOrden,sm.Nombre as Sector,ins.Nombre as Instr From pedidosrep r,unidades u,pedidosrep_est e,pedidosrep_tipo rt,personal p,pedidosrepord o,pedidosrepord_est eo,sectorm sm,epparticulos ins where r.Id<>0 and r.IdUnidad=u.Id and r.IdEstado=e.Id and r.IdTipo=rt.Id and r.IdPersonal=p.Id and r.IdOrden=o.Id and o.IdEstado=eo.Id and r.IdSector=sm.Id and r.IdInstr=ins.Id $wbuscar Order by r.Fecha,r.Id";
	mysql_close($conn); 
	header("Location:Solicitudes.php");
}





if (isset($_POST['CmdBorrarFila'])){
	$query="Delete From pedidosrep Where Id=".intval($_POST['TxtId']);
	$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);$rs=mysql_query($query,$conn);
	if ($rs){GLO_feedback(1);}else{GLO_feedback(2);} 
	mysql_close($conn); 
	header("Location:Solicitudes.php");	
}



if (isset($_POST['CmdExcel'])){
$query=$_POST['TxtQREPSOL'];$query=str_replace("\\", "", $query);
if ($query!=""){
	$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);$rs=mysql_query($query,$conn);
	if(mysql_num_rows($rs)!=0){	
		include("../Codigo/ExcelHeader.php");	
		include("../Codigo/ExcelStyle.php");
		echo "<th>Nro.Solicitud</th>\n";
		echo "<th>Fecha</th>\n";
		echo "<th>Unidad</th>\n";
		echo "<th>Sector</th>\n";
		echo "<th>Equipo</th>\n";
		echo "<th>Tipo</th>\n";	
		echo "<th>Estado Soli</th>\n";
		echo "<th>Solicitante</th>\n";		
		echo "<th>F.Solic.Ingreso</th>\n";
		echo "<th>F.Ingresar</th>\n";
		echo "<th>F.Retirar</th>\n";	
		echo "<th>Nro.Orden</th>\n";
		echo "<th>Estado Orden</th>\n";
		echo "<th>Comentarios</th>\n";	
		echo "<th>Requrimientos</th>\n";
		echo "</tr>\n";	
		while($row=mysql_fetch_array($rs)){ 
			echo "<tr>\n";
			echo "<td >".$row['Id']."</td>\n";
			echo '<td>'.GLO_FormatoFecha($row['Fecha'])."</td>\n";
			echo '<td>'.GLO_textoExcel($row['Uni'].' '.$row['Dominio'])."</td>\n";
			echo '<td>'.GLO_textoExcel($row['Sector'])."</td>\n";
			echo '<td>'.GLO_textoExcel($row['Instr'])."</td>\n";
			echo '<td>'.GLO_textoExcel($row['TipoS'])."</td>\n";
			echo '<td>'.GLO_textoExcel($row['Estado'])."</td>\n";	
			echo '<td>'.GLO_textoExcel($row['Ap'].' '.$row['Nom'])."</td>\n";	
			echo '<td>'.GLO_FormatoFecha($row['FechaSI'])."</td>\n";			
			echo '<td>'.GLO_FormatoFecha($row['FechaI'])."</td>\n";
			echo '<td>'.GLO_FormatoFecha($row['FechaE'])."</td>\n";		
			echo "<td >".$row['IdOrden']."</td>\n";	
			echo '<td>'.GLO_textoExcel($row['EstadoOrden'])."</td>\n";		
			echo '<td>'.GLO_textoExcel($row['Obs'])."</td>\n";	
			//requerimientos
			$query="SELECT rr.Obs From pedidosrepreqsoli rr where rr.Id<>0 and rr.IdPR=".$row['Id'];$rs2=mysql_query($query,$conn);
			$requerimientos='';
			while($row2=mysql_fetch_array($rs2)){ 
				$requerimientos=GLO_ListaTexto($requerimientos,$row2['Obs']);
			}mysql_free_result($rs2);
			echo '<td>'.GLO_textoExcel($requerimientos)."</td>\n";
			echo "</tr>\n";			
		}	
		//Cierra tabla excel
		echo "</table>\n";				
	}mysql_free_result($rs);	
	mysql_close($conn); 
}
}




?>


