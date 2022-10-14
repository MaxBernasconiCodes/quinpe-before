<? include("../Codigo/Seguridad.php") ;include("../Codigo/Config.php");include("../Codigo/Funciones.php");$_SESSION["NivelArbol"]="../";

//perfiles
if ($_SESSION["IdPerfilUser"]!=1 and $_SESSION["IdPerfilUser"]!=2 and $_SESSION["IdPerfilUser"]!=4  and $_SESSION["IdPerfilUser"]!=3  and $_SESSION["IdPerfilUser"]!=11  and $_SESSION["IdPerfilUser"]!=12  and $_SESSION["IdPerfilUser"]!=9 and $_SESSION["IdPerfilUser"]!=14){ header("Location:".$_SESSION["NivelArbol"]."Inicio.php");}


if (isset($_POST['CmdAgregar'])){	header("Location:Alta.php");}

if (isset($_POST['CmdSalir'])){
	foreach($_POST as $key => $value){$_SESSION[$key] = '';}
	header("Location:../ISO_Doc.php");
}

if (isset($_POST['CmdExcel'])){
	$query="SELECT r.*,a.Nombre as Accion,s.Nombre as Sector,p.Nombre,p.Apellido From iso_doc_resp r,iso_doc_acciones a,personal p,sector s where a.Id=r.IdAccion and p.Id=r.IdPersonal and s.Id=r.IdSector and r.Id<>0 Order by r.FechaB,s.Nombre,a.Id,p.Apellido,p.Nombre";
	if ($query!=""){
		$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);$rs=mysql_query($query,$conn);
		if(mysql_num_rows($rs)!=0){	
			include("../Codigo/ExcelHeader.php");
			include("../Codigo/ExcelStyle.php");
			echo "<th>Acci&oacute;n</th>\n";
			echo "<th>Nombre</th>\n";
			echo "<th >Alta</th>\n";
			echo "<th >Baja</th>\n";
			echo "</tr>\n";	
			
			while($row=mysql_fetch_array($rs)){ 
				$falta = FormatoFecha($row['FechaA']);if ($falta=='00-00-0000'){$falta="";}
				$fbaja= FormatoFecha($row['FechaB']);if ($fbaja=='00-00-0000'){$fbaja="";}
				echo "<tr>\n";
				echo '<td>'.GLO_textoExcel($row['Accion'])."</td>\n";
				echo '<td>'.GLO_textoExcel($row['Apellido'].' '.$row['Nombre'])."</td>\n";
				echo '<td>'.$falta."</td>\n";
				echo '<td>'.$fbaja."</td>\n";
				echo "</tr>\n";		
			}	
			echo "</table>\n";	
		}	
		mysql_free_result($rs);	mysql_close($conn); 
	}

 }


?>

