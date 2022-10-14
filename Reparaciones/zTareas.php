<? include("../Codigo/Seguridad.php");include("../Codigo/Config.php");include("../Codigo/Funciones.php");$_SESSION["NivelArbol"]="../";
//perfiles
if ($_SESSION["IdPerfilUser"]!=1 and $_SESSION["IdPerfilUser"]!=2 and $_SESSION["IdPerfilUser"]!=4 and $_SESSION["IdPerfilUser"]!=7 and $_SESSION["IdPerfilUser"]!=3  and $_SESSION["IdPerfilUser"]!=11  and $_SESSION["IdPerfilUser"]!=12  and $_SESSION["IdPerfilUser"]!=9 and $_SESSION["IdPerfilUser"]!=14 ){ header("Location:".$_SESSION["NivelArbol"]."Inicio.php");}



//Boton Buscar
if (isset($_POST['CmdBuscar'])){
	$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);
	foreach($_POST as $key => $value){$_SESSION[$key] = $value;}
	include("Includes/zFiltrosRepCod.php") ;		
	//query //pedidosrepreq IdPR join Id pedidosrepord
	$_SESSION['TxtQueryRepTar']="SELECT r.*,u.Dominio,u.Nombre as Uni,e.Nombre as Estado,ra.Hora1,ra.Hora2,ra.Fecha as FechaT,ra.Obs as ObsT,p2.Apellido as ApT,p2.Nombre as NomT,sm.Nombre as Sector,ins.Nombre as Instr From pedidosrepord r,unidades u,pedidosrepord_est e,pedidosrep pr,pedidosrepreq rr,pedidosrepreq_act ra,personal p2,sectorm sm,epparticulos ins where r.Id<>0 and r.IdUnidad=u.Id and r.IdEstado=e.Id and ra.IdPRR=rr.Id and ra.IdPersonal=p2.Id and rr.IdPR=r.Id and r.IdSoli=pr.Id and r.IdSector=sm.Id and r.IdInstr=ins.Id $wbuscar Order by r.Fecha,r.Id,ra.Fecha,ra.Hora1";
	mysql_close($conn); 
	header("Location:Tareas.php");
}




if (isset($_POST['CmdExcel'])){
$query=$_POST['TxtQueryRepTar'];$query=str_replace("\\", "", $query);
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
		//
		echo "<th>Fecha</th>\n";	
		echo "<th>Hora Inicio</th>\n";	
		echo "<th>Hora Fin</th>\n";	
		echo "<th>Actividad</th>\n";	
		echo "<th>Responsable</th>\n";	
		echo "</tr>\n";	
		while($row=mysql_fetch_array($rs)){ 
			echo "<td >".$row['Id']."</td>\n";
			echo '<td>'.GLO_FormatoFecha($row['Fecha'])."</td>\n";
			echo '<td>'.GLO_textoExcel($row['Uni'].' '.$row['Dominio'])."</td>\n";
			echo '<td>'.GLO_textoExcel($row['Sector'])."</td>\n";
			echo '<td>'.GLO_textoExcel($row['Instr'])."</td>\n";
			echo '<td>'.GLO_textoExcel($row['Estado'])."</td>\n";				
			echo "<td >".$row['IdSoli']."</td>\n";	
			//	
			echo '<td>'.GLO_FormatoFecha($row['FechaT'])."</td>\n";
			echo '<td>'.GLO_FormatoHora($row['Hora1'])."</td>\n";
			echo '<td>'.GLO_FormatoHora($row['Hora2'])."</td>\n";
			echo '<td>'.GLO_textoExcel($row['ObsT'])."</td>\n";	
			echo '<td>'.GLO_textoExcel($row['ApT'].' '.$row['NomT'])."</td>\n";	
			echo "</tr>\n";			
		}	
		//Cierra tabla excel
		echo "</table>\n";				
	}	
	mysql_free_result($rs);	mysql_close($conn); 
}

 }




?>


