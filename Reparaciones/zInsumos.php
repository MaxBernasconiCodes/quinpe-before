<? include("../Codigo/Seguridad.php");include("../Codigo/Config.php");include("../Codigo/Funciones.php");$_SESSION["NivelArbol"]="../";

//perfiles

if ($_SESSION["IdPerfilUser"]!=1 and $_SESSION["IdPerfilUser"]!=2 and $_SESSION["IdPerfilUser"]!=4 and $_SESSION["IdPerfilUser"]!=7 and $_SESSION["IdPerfilUser"]!=3  and $_SESSION["IdPerfilUser"]!=11  and $_SESSION["IdPerfilUser"]!=12  and $_SESSION["IdPerfilUser"]!=9 and $_SESSION["IdPerfilUser"]!=14 ){ header("Location:".$_SESSION["NivelArbol"]."Inicio.php");}







//Boton Buscar

if (isset($_POST['CmdBuscar'])){

	$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);

	foreach($_POST as $key => $value){$_SESSION[$key] = $value;}

	include("Includes/zFiltrosRepCod.php") ;		

	//query //pedidosrepreq IdPR join Id pedidosrepord

	$_SESSION['TxtQueryRepIns']="SELECT r.*,u.Dominio,u.Nombre as Uni,e.Nombre as Estado,a.Nombre as Articulo,um.Abr,ra.IdArti,ra.PSI,ra.FechaPSI,ra.MIM,ra.FechaMIM,ra.Cant,sm.Nombre as Sector,ins.Nombre as Instr From pedidosrepord r,unidades u,pedidosrepord_est e,pedidosrep pr,pedidosrepreq rr,pedidosrepreq_ins ra,epparticulos a,unidadesmedida um,sectorm sm,epparticulos ins where r.Id<>0 and r.IdUnidad=u.Id and r.IdEstado=e.Id  and ra.IdPRR=rr.Id and ra.IdArti=a.Id and a.IdUnidad=um.Id and rr.IdPR=r.Id and r.IdSoli=pr.Id and  r.IdSector=sm.Id and r.IdInstr=ins.Id $wbuscar Order by r.Fecha,r.Id,a.Nombre";

	mysql_close($conn); 

	header("Location:Insumos.php");

}









if (isset($_POST['CmdExcel'])){

$query=$_POST['TxtQueryRepIns'];$query=str_replace("\\", "", $query);

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

		echo "<th>Repuesto</th>\n";	

		echo "<th>Cantidad</th>\n";	

		echo "<th>Nro.PSI</th>\n";	

		echo "<th>Fecha PSI</th>\n";

		echo "<th>Nro.MIM</th>\n";

		echo "<th>Fecha MIM</th>\n";	

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

			//

			echo '<td>'.GLO_textoExcel(str_pad($row['IdArti'], 6, "0", STR_PAD_LEFT).' '.$row['Articulo'].' '.$row['Abr'])."</td>\n";	

			echo '<td>'.number_format($row['Cant'],2, ',', '')."</td>\n";	

			echo '<td>'.str_pad($row['PSI'], 6, "0", STR_PAD_LEFT)."</td>\n";	

			echo '<td>'.GLO_FormatoFecha($row['FechaPSI'])."</td>\n";

			echo '<td>'.str_pad($row['MIM'], 6, "0", STR_PAD_LEFT)."</td>\n";

			echo '<td>'.GLO_FormatoFecha($row['FechaMIM'])."</td>\n";	

			echo "</tr>\n";			

		}	

		//Cierra tabla excel

		echo "</table>\n";				

	}	

	mysql_free_result($rs);	mysql_close($conn); 

}



 }









?>





