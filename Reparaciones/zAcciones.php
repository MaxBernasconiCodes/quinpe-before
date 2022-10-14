<? include("../Codigo/Seguridad.php");include("../Codigo/Config.php");include("../Codigo/Funciones.php");$_SESSION["NivelArbol"]="../";

//perfiles

if ($_SESSION["IdPerfilUser"]!=1 and $_SESSION["IdPerfilUser"]!=2 and $_SESSION["IdPerfilUser"]!=4 and $_SESSION["IdPerfilUser"]!=7 and $_SESSION["IdPerfilUser"]!=3  and $_SESSION["IdPerfilUser"]!=11  and $_SESSION["IdPerfilUser"]!=12  and $_SESSION["IdPerfilUser"]!=9 and $_SESSION["IdPerfilUser"]!=14 ){ header("Location:".$_SESSION["NivelArbol"]."Inicio.php");}







//Boton Buscar

if (isset($_POST['CmdBuscar'])){

	$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);

	foreach($_POST as $key => $value){$_SESSION[$key] = $value;}

	include("Includes/zFiltrosRepCod.php") ;		

	//query //pedidosrepreq IdPR join Id pedidosrepord

	$_SESSION['TxtQueryRepReq']="SELECT r.*,u.Dominio,u.Nombre as Uni,e.Nombre as Estado,c.Nombre as Cat,er.Nombre as EstadoR,rr.Clase,rr.Tipo,rr.Urg,rr.Obs as ObsR,l.Nombre as ClaseN,t.Nombre as TipoN,sm.Nombre as Sector,ins.Nombre as Instr From pedidosrepord r,unidades u,pedidosrepord_est e,pedidosrep pr,pedidosrepreq rr,pedidosrepreq_cat c,pedidosrepreq_est er,pedidosrepreq_clase l,pedidosrepreq_tipo t,sectorm sm,epparticulos ins where r.Id<>0 and r.IdUnidad=u.Id and r.IdEstado=e.Id and rr.IdCat=c.Id and rr.IdEstado=er.Id and rr.IdPR=r.Id and r.IdSoli=pr.Id and rr.Clase=l.Id and rr.Tipo=t.Id and r.IdSector=sm.Id and r.IdInstr=ins.Id $wbuscar  Order by r.Fecha,r.Id,rr.Clase,c.Nombre";

	mysql_close($conn); 

	header("Location:Acciones.php");

}









if (isset($_POST['CmdExcel'])){

$query=$_POST['TxtQueryRepReq'];$query=str_replace("\\", "", $query);

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

		echo "<th>Clase</th>\n";	

		echo "<th>Tipo</th>\n";	

		echo "<th>Ext</th>\n";	

		echo "<th>Categoria</th>\n";	

		echo "<th>Urgencia</th>\n";	

		echo "<th>Estado Acci&oacute;n</th>\n";	

		echo "<th>Observaciones</th>\n";	

		echo "</tr>\n";	

		while($row=mysql_fetch_array($rs)){ 

			$urg='';if($row['Urg']==1){$urg='Baja';} if($row['Urg']==2){$urg='Media';} if($row['Urg']==3){$urg='Alta';}

			echo "<tr>\n";

			echo "<td >".$row['Id']."</td>\n";

			echo '<td>'.GLO_FormatoFecha($row['Fecha'])."</td>\n";

			echo '<td>'.GLO_textoExcel($row['Uni'].' '.$row['Dominio'])."</td>\n";

			echo '<td>'.GLO_textoExcel($row['Sector'])."</td>\n";

			echo '<td>'.GLO_textoExcel($row['Instr'])."</td>\n";

			echo '<td>'.GLO_textoExcel($row['Estado'])."</td>\n";				

			echo "<td >".$row['IdSoli']."</td>\n";	

			//

			echo '<td>'.$row['ClaseN']."</td>\n";	

			echo '<td>'.$row['TipoN']."</td>\n";	

			echo '<td>'.GLO_SiNo($row['Alcance'])."</td>\n";	

			echo '<td>'.GLO_textoExcel($row['Cat'])."</td>\n";	

			echo '<td>'.$urg."</td>\n";	

			echo '<td>'.GLO_textoExcel($row['EstadoR'])."</td>\n";	

			echo '<td>'.GLO_textoExcel($row['ObsR'])."</td>\n";		

			echo "</tr>\n";			

		}	

		//Cierra tabla excel

		echo "</table>\n";				

	}	

	mysql_free_result($rs);	mysql_close($conn); 

}



 }









?>





