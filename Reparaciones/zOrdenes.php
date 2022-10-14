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
	$vbuscar=intval($_POST['TxtNroOR']);if($vbuscar!=0){$wbuscar=$wbuscar." and r.Id=$vbuscar";}	
	$vbuscar=intval($_POST['ChkSSoli']);if($vbuscar!=0){$wbuscar=$wbuscar." and r.IdSoli=0";}	
	$vbuscar=intval($_POST['CbUnidad']);if($vbuscar!=0){$wbuscar=$wbuscar." and r.IdUnidad=$vbuscar";}
	$vbuscar=intval($_POST['CbSector']);if($vbuscar!=0){$wbuscar=$wbuscar." and r.IdSector=$vbuscar";}
	$vbuscar=intval($_POST['CbInstrumento']);if($vbuscar!=0){$wbuscar=$wbuscar." and r.IdInstr=$vbuscar";}
	//query
	$_SESSION['TxtQREPORD']="SELECT r.*,u.Dominio,u.Nombre as Uni,e.Nombre as Estado,epr.Nombre as EstadoSoli,pr.IdEstado as IdEstadoSoli,sm.Nombre as Sector,ins.Nombre as Instr From pedidosrepord r,unidades u,pedidosrepord_est e,pedidosrep pr,pedidosrep_est epr,sectorm sm,epparticulos ins where r.Id<>0 and r.IdUnidad=u.Id and r.IdEstado=e.Id and r.IdSoli=pr.Id and pr.IdEstado=epr.Id and r.IdSector=sm.Id and r.IdInstr=ins.Id $wbuscar Order by r.Fecha,r.Id";
	mysql_close($conn); 
	header("Location:Ordenes.php");
}






if (isset($_POST['CmdBorrarFila'])){
	$query="Delete From pedidosrepord Where Id=".intval($_POST['TxtId']);
	$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);$rs=mysql_query($query,$conn);
	if ($rs){GLO_feedback(1);}else{GLO_feedback(2);} 
	mysql_close($conn); 
	header("Location:Ordenes.php");	
}



if (isset($_POST['CmdExcel'])){
$query=$_POST['TxtQREPORD'];$query=str_replace("\\", "", $query);
if ($query!=""){
	$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);$rs=mysql_query($query,$conn);
	if(mysql_num_rows($rs)!=0){	
		include("../Codigo/ExcelHeader.php");	
		include("../Codigo/ExcelStyle.php");
		echo "<th>Nro.Orden</th>\n";
		echo "<th>Fecha Orden</th>\n";
		echo "<th>Unidad</th>\n";
		echo "<th>Sector</th>\n";
		echo "<th>Equipo</th>\n";
		echo "<th>Estado Orden</th>\n";
		echo "<th>Nro.Solicitud</th>\n";	
		echo "<th>Estado Solicitud</th>\n";
		echo "<th>Ingreso Taller</th>\n";
		echo "<th>Km</th>\n";	
		echo "<th>Hs</th>\n";		
		echo "<th>Comentarios</th>\n";	
		echo "</tr>\n";	
		while($row=mysql_fetch_array($rs)){ 
			echo "<tr>\n";
			echo "<td >".$row['Id']."</td>\n";
			echo '<td>'.GLO_FormatoFecha($row['Fecha'])."</td>\n";
			echo '<td>'.GLO_textoExcel($row['Uni'].' '.$row['Dominio'])."</td>\n";
			echo '<td>'.GLO_textoExcel($row['Sector'])."</td>\n";
			echo '<td>'.GLO_textoExcel($row['Instr'])."</td>\n";
			echo '<td>'.GLO_textoExcel($row['Estado'])."</td>\n";	
			echo "<td >".$row['IdSoli']."</td>\n";	
			echo '<td>'.GLO_textoExcel($row['EstadoSoli'])."</td>\n";		
			echo '<td>'.GLO_FormatoFecha($row['FechaIT'])."</td>\n";				
			echo '<td>'.$row['Km']."</td>\n";
			echo '<td>'.number_format($row['Hs'],2, ',', '')."</td>\n";	
			echo '<td>'.GLO_textoExcel($row['Obs'])."</td>\n";		
			echo "</tr>\n";			
		}	
		//Cierra tabla excel
		echo "</table>\n";				
	}	
	mysql_free_result($rs);	mysql_close($conn); 
}

 }




?>


