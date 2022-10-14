<? include("../Codigo/Seguridad.php");include("../Codigo/Config.php");include("../Codigo/Funciones.php");$_SESSION["NivelArbol"]="../";

//perfiles

if ($_SESSION["IdPerfilUser"]!=1 and $_SESSION["IdPerfilUser"]!=2 and $_SESSION["IdPerfilUser"]!=3 and $_SESSION["IdPerfilUser"]!=9 and $_SESSION["IdPerfilUser"]!=14 ){ header("Location:".$_SESSION["NivelArbol"]."Inicio.php");}







//Boton Buscar

if (isset($_POST['CmdBuscar'])){

	foreach($_POST as $key => $value){$_SESSION[$key] = $value;}

	$wfechad="and DATEDIFF(i.Fecha,'".FechaMySql($_POST['TxtFechaD'])."')>=0";

	$wfechah="and DATEDIFF(i.Fecha,'".FechaMySql($_POST['TxtFechaH'])."')<=0";

	$centro=intval($_POST['CbCentro']);if($centro!=0){$wcentro="and i.IdCentro=$centro";}else{$wcentro='';}

	//query

	$_SESSION['TxtQINSP']="SELECT i.*,e.Nombre as Centro,y.Nombre as Yac,p1.Nombre as N1,p1.Apellido as A1,p2.Nombre as N2,p2.Apellido as A2,p3.Nombre as N3,p3.Apellido as A3 From inspecciones i,epparticulos e,yacimientos y,personal p1,personal p2,personal p3 where i.Id<>0 and i.IdCentro=e.Id and i.IdYac=y.Id and i.IdP1=p1.Id and i.IdP2=p2.Id and i.IdP3=p3.Id $wcentro $wfechad $wfechah Order by i.Fecha";

	header("Location:../InspeccionesSMA.php");

}









if (isset($_POST['CmdBorrarFila'])){

	$query="Delete From inspecciones Where Id=".intval($_POST['TxtId']);

	$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);$rs=mysql_query($query,$conn);

	if ($rs){GLO_feedback(1);}else{GLO_feedback(2);} 

	mysql_close($conn); 

	header("Location:../InspeccionesSMA.php"); 	

}









if (isset($_POST['CmdExcel'])){

	$query=$_POST['TxtQINSP'];$query=str_replace("\\", "", $query);

	if ($query!=""){

		$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);$rs=mysql_query($query,$conn);

		if(mysql_num_rows($rs)!=0){	

			//Titulos excel

			include("../Codigo/ExcelHeader.php");

			include("../Codigo/ExcelStyle.php");

			echo "<th>Fecha</th>\n";

			echo "<th>Hora</th>\n";			

			echo "<th>Area</th>\n";			

			echo "<th>Equipo</th>\n";

			echo "<th>Operador</th>\n";

			echo "<th>Chofer</th>\n";

			echo "<th>Ayudante</th>\n";

			echo "<th>Observaciones</th>\n";

			echo "</tr>\n";				

			while($row=mysql_fetch_array($rs)){ 

				echo "<tr>\n";

				echo '<td>'.GLO_FormatoFecha($row['Fecha']) ."</td>\n";

				echo '<td>'.GLO_FormatoHora($row['Hora'])."</td>\n";

				echo '<td>'.GLO_textoExcel($row['Yac'])."</td>\n";

				echo '<td>'.GLO_textoExcel($row['Centro'])."</td>\n";	

				echo '<td>'.GLO_textoExcel($row['A1'].' '.$row['N1'])."</td>\n";

				echo '<td>'.$row['A2'].' '.$row['N2']."</td>\n";	

				echo '<td>'.GLO_textoExcel($row['A3'].' '.$row['N3'])."</td>\n";

				echo '<td>'.GLO_textoExcel($row['Obs'])."</td>\n";				

				echo "</tr>\n";			

			}	

			echo "</table>\n";				

		}mysql_free_result($rs);		

		mysql_close($conn); 

	}



 }







?>





