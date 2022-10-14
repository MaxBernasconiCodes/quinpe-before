<? include("../Codigo/Seguridad.php");include("../Codigo/Config.php");include("../Codigo/Funciones.php");$_SESSION["NivelArbol"]="../";
//perfiles
if ($_SESSION["IdPerfilUser"]!=1 and $_SESSION["IdPerfilUser"]!=2 and $_SESSION["IdPerfilUser"]!=4 and $_SESSION["IdPerfilUser"]!=7 and $_SESSION["IdPerfilUser"]!=3  and $_SESSION["IdPerfilUser"]!=11  and $_SESSION["IdPerfilUser"]!=12  and $_SESSION["IdPerfilUser"]!=9 and $_SESSION["IdPerfilUser"]!=14 and $_SESSION["IdPerfilUser"]!=13){ header("Location:".$_SESSION["NivelArbol"]."Inicio.php");}



if (isset($_POST['CmdAgregar'])){	header("Location:Alta.php");}

if (isset($_POST['CmdBorrarFila'])){
	$query="Delete From polizasaseg Where Id=".intval($_POST['TxtId']);
	$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);$rs=mysql_query($query,$conn);
	if ($rs){GLO_feedback(1);}else{GLO_feedback(2);} 
	mysql_close($conn); 
	header("Location:../PSAseguradoras.php"); 	
}

if (isset($_POST['CmdSalir'])){
	foreach($_POST as $key => $value){$_SESSION[$key] = '';}
	header("Location:../Unidades/Tablas.php");
}

if (isset($_POST['CmdExcel'])){
	$query="SELECT p.*, l.Nombre as Loc From polizasaseg p,localidades l where p.Id<>0 and p.IdLocalidad=l.Id Order by p.Nombre";
	if ($query!=""){
		$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);$rs=mysql_query($query,$conn);
		if(mysql_num_rows($rs)!=0){	
			include("../Codigo/ExcelHeader.php");
			include("../Codigo/ExcelStyle.php");
			echo "<th>N&uacute;mero</th>\n";
			echo "<th>Nombre</th>\n";
			echo "<th>CUIT</th>\n";			
			echo "<th>Direcci&oacute;n</th>\n";
			echo "<th>Localidad</th>\n";
			echo "<th>Provincia</th>\n";
			echo "<th>CP</th>\n";
			echo "<th>Tel&eacute;fono1</th>\n";
			echo "<th>Tel&eacute;fono2</th>\n";
			echo "<th>Contacto1</th>\n";
			echo "<th>Contacto2</th>\n";
			echo "<th>Observaciones</th>\n";
			echo "</tr>\n";	
			
			while($row=mysql_fetch_array($rs)){ 
				echo "<tr>\n";
				echo '<td>'.$row['Id']."</td>\n";
				echo '<td>'.GLO_textoExcel($row['Nombre'])."</td>\n";
				echo '<td>'.$row['Identificacion']."</td>\n";
				echo '<td>'.GLO_textoExcel($row['Direccion'])."</td>\n";
				echo '<td>'.GLO_textoExcel($row['Loc'])."</td>\n";
				echo '<td>'.GLO_textoExcel($row['Provincia'])."</td>\n";
				echo '<td>'.GLO_textoExcel($row['CP'])."</td>\n";
				echo '<td>'.$row['T1']."</td>\n";
				echo '<td>'.$row['T2']."</td>\n";
				echo '<td>'.GLO_textoExcel($row['C1'])."</td>\n";
				echo '<td>'.GLO_textoExcel($row['C2'])."</td>\n";
				echo '<td>'.GLO_textoExcel($row['Observaciones'])."</td>\n";	
				echo "</tr>\n";		
			}	
			echo "</table>\n";	
		}	
		mysql_free_result($rs);	mysql_close($conn); 
	}

 }




?>