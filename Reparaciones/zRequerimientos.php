<? include("../Codigo/Seguridad.php");include("../Codigo/Config.php");include("../Codigo/Funciones.php");$_SESSION["NivelArbol"]="../";
//perfiles
if ($_SESSION["IdPerfilUser"]!=1 and $_SESSION["IdPerfilUser"]!=2 and $_SESSION["IdPerfilUser"]!=4 and $_SESSION["IdPerfilUser"]!=7 and $_SESSION["IdPerfilUser"]!=3  and $_SESSION["IdPerfilUser"]!=11  and $_SESSION["IdPerfilUser"]!=12  and $_SESSION["IdPerfilUser"]!=9 and $_SESSION["IdPerfilUser"]!=14 ){ header("Location:".$_SESSION["NivelArbol"]."Inicio.php");}



//Boton Buscar
if (isset($_POST['CmdBuscar'])){
	$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);
	foreach($_POST as $key => $value){$_SESSION[$key] = $value;}
	include("Includes/zFiltrosRepCod.php") ;		
	//query
	$_SESSION['TxtQueryRepReqSoli']="SELECT r.*,u.Dominio,u.Nombre as Uni,e.Nombre as Estado,rt.Nombre as TipoS,p.Apellido as Ap,p.Nombre as Nom,rr.Fecha as FechaR,rr.Urg,rr.Obs as ObsR,rr.Estado as EstadoR,sm.Nombre as Sector,ins.Nombre as Instr From pedidosrep r,unidades u,pedidosrep_est e,pedidosrep_tipo rt,personal p,pedidosrepord o,pedidosrepreqsoli rr,sectorm sm,epparticulos ins where r.Id<>0 and r.IdUnidad=u.Id and r.IdEstado=e.Id and r.IdTipo=rt.Id and r.IdPersonal=p.Id and r.IdOrden=o.Id and rr.IdPR=r.Id and r.IdSector=sm.Id and r.IdInstr=ins.Id $wbuscar Order by r.Fecha,r.Id,rr.Fecha,rr.Obs";
	mysql_close($conn); 
	header("Location:Requerimientos.php");
}




if (isset($_POST['CmdExcel'])){
$query=$_POST['TxtQueryRepReqSoli'];$query=str_replace("\\", "", $query);
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
		echo "<th>Estado</th>\n";	
		echo "<th>Tipo</th>\n";	
		echo "<th>Solicitante</th>\n";	
		echo "<th>Nro.Orden</th>\n";
		//
		echo "<th>Fecha</th>\n";	
		echo "<th>Descripci&oacute;n</th>\n";	
		echo "<th>Urgencia</th>\n";	
		echo "<th>Estado</th>\n";	
		echo "</tr>\n";	
		while($row=mysql_fetch_array($rs)){ 
			$urg='';if($row['Urg']==1){$urg='Baja';} if($row['Urg']==2){$urg='Media';} if($row['Urg']==3){$urg='Alta';}
			$estado='Pdte';if($row['EstadoR']==1){$estado='Visto';} 
			echo "<tr>\n";
			echo "<td >".$row['Id']."</td>\n";
			echo '<td>'.GLO_FormatoFecha($row['Fecha'])."</td>\n";
			echo '<td>'.GLO_textoExcel($row['Uni'].' '.$row['Dominio'])."</td>\n";
			echo '<td>'.GLO_textoExcel($row['Sector'])."</td>\n";
			echo '<td>'.GLO_textoExcel($row['Instr'])."</td>\n";
			echo '<td>'.GLO_textoExcel($row['Estado'])."</td>\n";	
			echo '<td>'.GLO_textoExcel($row['TipoS'])."</td>\n";
			echo '<td>'.GLO_textoExcel($row['Ap'].' '.$row['Nom'])."</td>\n";		
			echo "<td >".$row['IdOrden']."</td>\n";		
			//
			echo '<td>'.GLO_FormatoFecha($row['FechaR'])."</td>\n";	
			echo '<td>'.GLO_textoExcel($row['ObsR'])."</td>\n";	
			echo '<td>'.$urg."</td>\n";	
			echo '<td>'.$estado."</td>\n";	
			echo "</tr>\n";			
		}	
		//Cierra tabla excel
		echo "</table>\n";				
	}	
	mysql_free_result($rs);	mysql_close($conn); 
}

 }




?>


