<? include("../Codigo/Seguridad.php");include("../Codigo/Config.php");include("../Codigo/Funciones.php");$_SESSION["NivelArbol"]="../";
//perfiles
if ($_SESSION["IdPerfilUser"]!=1 and $_SESSION["IdPerfilUser"]!=2  and $_SESSION["IdPerfilUser"]!=4  and $_SESSION["IdPerfilUser"]!=3  and $_SESSION["IdPerfilUser"]!=11  and $_SESSION["IdPerfilUser"]!=12  and $_SESSION["IdPerfilUser"]!=9 and $_SESSION["IdPerfilUser"]!=14 and $_SESSION["IdPerfilUser"]!=11  and $_SESSION["IdPerfilUser"]!=12 and $_SESSION["IdPerfilUser"]!=12){ header("Location:".$_SESSION["NivelArbol"]."Inicio.php");}

if (isset($_POST['CmdLinkRow'])){
	foreach($_POST as $key => $value){$_SESSION[$key] = "";}
	header("Location:Modificar.php?id=".intval($_POST['TxtId'])."&Flag1=True");
}

if (isset($_POST['CmdAgregar'])){	header("Location:Alta.php");}

if (isset($_POST['CmdBorrarFila'])){
	$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);
	$query="Delete From unidadesmedida Where Id=".intval($_POST['TxtId']);$rs=mysql_query($query,$conn);
	if ($rs){GLO_feedback(1);}else{GLO_feedback(2);}  
	mysql_close($conn); 
	header("Location:../UnidadesMed.php"); 	
}

if (isset($_POST['CmdSalir'])){
	foreach($_POST as $key => $value){$_SESSION[$key] = '';}
	header("Location:../Tablas.php");
}

if (isset($_POST['CmdExcel'])){
	$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);
	$query="SELECT s.* From unidadesmedida s where s.Id<>0  Order By s.Nombre";$rs=mysql_query($query,$conn);
	$rs=mysql_query($query,$conn);
	if(mysql_num_rows($rs)!=0){	
		include("../Codigo/ExcelHeader.php");	
		include("../Codigo/ExcelStyle.php");	
		echo "<th>Nombre</th>\n";
		echo "<th>Abr</th>\n";
		echo "</tr>\n";	
		while($row=mysql_fetch_array($rs)){ 
			echo "<tr>\n";
			echo "<td>".$row['Nombre']."</td>\n";
			echo "<td >".$row['Abr']."</td>\n";
			echo "</tr>\n";			
		}echo "</table>\n";				
	}	
	mysql_free_result($rs);	mysql_close($conn); 
}

?>