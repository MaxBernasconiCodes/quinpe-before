<? include("../Codigo/Seguridad.php");include("../Codigo/Config.php");include("../Codigo/Funciones.php");$_SESSION["NivelArbol"]="../";
//perfiles
if ($_SESSION["IdPerfilUser"]!=1 and $_SESSION["IdPerfilUser"]!=2){ header("Location:".$_SESSION["NivelArbol"]."Inicio.php");}




//Boton Buscar
if (isset($_POST['CmdBuscar'])){
	$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);
	foreach($_POST as $key => $value){$_SESSION[$key] = $value;}
	//personal
	if ((empty($_POST['TxtBusqueda']))){$wpers="";}
	else{$wpers="and (p.Nombre Like '%".mysql_real_escape_string($_POST['TxtBusqueda'])."%' or p.Apellido Like '%".mysql_real_escape_string($_POST['TxtBusqueda'])."%')";}
	//fecha
	$wfechad='';$wfechah='';
	if (!(empty($_POST['TxtFechaD']))){$wfechad="and (DATEDIFF(a.Fecha,'".FechaMySql($_POST['TxtFechaD'])."')>=0 or a.Fecha='0000-00-00')";}
	if (!(empty($_POST['TxtFechaH']))){$wfechah="and (DATEDIFF(a.Fecha,'".FechaMySql($_POST['TxtFechaH'])."')<=0 or a.Fecha='0000-00-00')";}
	//select
	$_SESSION['TxtQHLOG']="SELECT p.Nombre,p.Apellido,p.Legajo,a.Fecha From personal p,usuarios u,auditorialogin a where a.IdUsuario=u.Usuario and u.IdPersonal=p.Id and u.IdPersonal<>0 $wpers $wfechad $wfechah Order by a.Fecha,p.Apellido,p.Nombre";
	mysql_close($conn); 
	header("Location:../HistorialLogin.php");
}





if (isset($_POST['CmdExcel'])){
$query=$_POST['TxtQHLOG'];$query=str_replace("\\", "", $query);
if ($query!=""){
	$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);$rs=mysql_query($query,$conn);
	if(mysql_num_rows($rs)!=0){	
		//Titulos excel
		include("../Codigo/ExcelHeader.php");	
		include("../Codigo/ExcelStyle.php");
		echo "<th>Legajo</th>\n";
		echo "<th>Nombre</th>\n";
		echo "<th>Fecha</th>\n";
		echo "</tr>\n";	
		while($row=mysql_fetch_array($rs)){ 
			echo "<tr>\n";
			echo "<td align='right'>".str_pad($row['Legajo'], 6, "0", STR_PAD_LEFT)."</td>\n";
			echo '<td>'.GLO_textoExcel($row['Apellido']." ".$row['Nombre'])."</td>\n";
			echo '<td>'.FormatoFechaHora($row['Fecha'])."</td>\n";
			echo "</tr>\n";			
		}	
		echo "</table>\n";				
	}	
	mysql_free_result($rs);	mysql_close($conn); 
}

 }
?>