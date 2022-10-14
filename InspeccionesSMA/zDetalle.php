<? include("../Codigo/Seguridad.php");include("../Codigo/Config.php");include("../Codigo/Funciones.php");$_SESSION["NivelArbol"]="../";

//perfiles

if ($_SESSION["IdPerfilUser"]!=1 and $_SESSION["IdPerfilUser"]!=2 and $_SESSION["IdPerfilUser"]!=3 and $_SESSION["IdPerfilUser"]!=9 and $_SESSION["IdPerfilUser"]!=14 ){ header("Location:".$_SESSION["NivelArbol"]."Inicio.php");}







//Boton Buscar

if (isset($_POST['CmdBuscar'])){

	foreach($_POST as $key => $value){$_SESSION[$key] = $value;}

	$wfechad="and DATEDIFF(i.Fecha,'".FechaMySql($_POST['TxtFechaD'])."')>=0";

	$wfechah="and DATEDIFF(i.Fecha,'".FechaMySql($_POST['TxtFechaH'])."')<=0";

	$centro=intval($_POST['CbCentro']);if($centro!=0){$wcentro="and i.IdCentro=$centro";}else{$wcentro='';}

	$_SESSION['TxtQuery74']="SELECT d.*, e.Nombre as Estado,p.Nombre,p.Apellido,ce.Nombre as Centro,y.Nombre as Yac,i.fecha as FechaI  From inspecciones_det d,inspecciones_det_est e,personal p,inspecciones i,epparticulos ce,yacimientos y where d.IdInsp=i.Id and d.IdEstado=e.id and d.Id<>0 and p.Id=d.IdPersonal and i.IdCentro=ce.Id and i.IdYac=y.Id $wcentro $wfechad $wfechah Order by d.Fecha, p.Apellido,p.Nombre";

	header("Location:Detalle.php");

}

















if (isset($_POST['CmdExcel'])){

	$query=$_POST['TxtQuery74'];$query=str_replace("\\", "", $query);

	if ($query!=""){

		$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);$rs=mysql_query($query,$conn);

		if(mysql_num_rows($rs)!=0){	

			//Titulos excel

			include("../Codigo/ExcelHeader.php");

			include("../Codigo/ExcelStyle.php");

			echo "<th>Fecha</th>\n";

			echo "<th>Area</th>\n";			

			echo "<th>Equipo</th>\n";

			//

			echo "<th>Fecha</th>\n";

			echo "<th>Detalle</th>\n";

			echo "<th>Responsable</th>\n";

			echo "<th>Estado</th>\n";

			echo "<th>Cumpl.</th>\n";

			echo "</tr>\n";				

			while($row=mysql_fetch_array($rs)){ 

				$fechai = FormatoFecha($row['FechaI']);if ($fechai=='00-00-0000'){$fechai="";}

				$fecha = FormatoFecha($row['Fecha']);if ($fecha=='00-00-0000'){$fecha="";}

				$fecha2 = FormatoFecha($row['Fecha2']);if ($fecha2=='00-00-0000'){$fecha2="";}

				echo "<tr>\n";

				echo '<td>'.$fechai."</td>\n";

				echo '<td>'.GLO_textoExcel($row['Yac'])."</td>\n";

				echo '<td>'.GLO_textoExcel($row['Centro'])."</td>\n";	

				//

				echo '<td>'.$fecha."</td>\n";	

				echo '<td>'.GLO_textoExcel($row['Obs'])."</td>\n";	

				echo '<td>'.GLO_textoExcel($row['Apellido'].' '.$row['Nombre'])."</td>\n";	

				echo '<td>'.GLO_textoExcel($row['Estado'])."</td>\n";	

				echo '<td>'.$fecha2."</td>\n";					

				echo "</tr>\n";			

			}	

			echo "</table>\n";				

		}	

		mysql_free_result($rs);	mysql_close($conn); 

	}



 }







?>





