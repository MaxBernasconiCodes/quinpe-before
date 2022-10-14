<? include("../Codigo/Seguridad.php");include("../Codigo/Config.php");include("../Codigo/Funciones.php");$_SESSION["NivelArbol"]="../";
//perfiles
if ($_SESSION["IdPerfilUser"]!=1 and $_SESSION["IdPerfilUser"]!=2 and $_SESSION["IdPerfilUser"]!=4 and $_SESSION["IdPerfilUser"]!=7 and $_SESSION["IdPerfilUser"]!=3  and $_SESSION["IdPerfilUser"]!=11  and $_SESSION["IdPerfilUser"]!=12  and $_SESSION["IdPerfilUser"]!=9 and $_SESSION["IdPerfilUser"]!=14 and $_SESSION["IdPerfilUser"]!=13){ header("Location:".$_SESSION["NivelArbol"]."Inicio.php");}

if (isset($_POST['CmdBuscar'])){
	//veo si conecto
	$wnom="";$wdom="";
	if( !(empty($_POST['TxtBusquedaN'])) or !(empty($_POST['TxtBusqueda']))  ){
		$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);
		//nombre
		if ( !(empty($_POST['TxtBusquedaN'])) ){$wnom="and (u.Nombre Like '%".mysql_real_escape_string($_POST['TxtBusquedaN'])."%')";}
		//dominio
		if ( !(empty($_POST['TxtBusqueda'])) ){$wdom="and (u.Dominio Like '%".mysql_real_escape_string($_POST['TxtBusqueda'])."%')";}
		mysql_close($conn); 
	}
	//where 
	$cli=intval($_POST['CbCliente']);if($cli!=0){$wcli="and h.IdCliente=$cli";}else{$wcli='';}	
	$sec=intval($_POST['CbSec']);if($sec!=0){$wsec="and u.IdSector=$sec";}else{$wsec='';}
	$serv=intval($_POST['CbServ']);if($serv!=0){$wserv="and u.IdServicio=$serv";}else{$wserv='';}
	$mar=intval($_POST['CbMarca']);if($mar!=0){$wmar="and u.IdMarca=$mar";}else{$wmar='';}
	$activo=intval($_POST['ChkActivo']);if($activo!=0){$wactivo="and (u.FechaBaja='0000-00-00' or DATEDIFF('".FechaMySql(date("d-m-Y")). "',u.FechaBaja)<0)";}else{$wactivo='';}
	//
	$_SESSION['TxtQuery']="SELECT u.Id,u.Nombre,u.Dominio,u.FechaBaja,m.Nombre as Marca,s.Nombre as Sector,s1.Nombre as Servicio,c.Nombre as Cliente,h.FechaA,h.FechaB,h.IdCliente From unidades u,unidadesmarcas m,sector s, servicios se,serviciostipo1 s1,unidadesclientes h,clientes c where u.Id<>0 and u.IdMarca=m.Id   and u.IdSector=s.Id and u.IdServicio=se.Id and se.IdTipo=s1.Id and h.IdUnidad=u.Id and h.IdCliente=c.Id  $wcli $wsec $wserv $wnom $wmar $wactivo Order by u.Nombre";
	//
	header("Location:Clientes.php");
}







if (isset($_POST['CmdExcel'])){
$query=$_POST['TxtQuery'];$query=str_replace("\\", "", $query);
if ($query!=""){
	$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);$rs=mysql_query($query,$conn);
	if(mysql_num_rows($rs)!=0){	
		//Titulos excel
		include("../Codigo/ExcelHeader.php");	
		include("../Codigo/ExcelStyle.php");
		echo "<th>N&uacute;mero</th>\n";
		echo "<th>Nombre</th>\n";
		echo "<th>Dominio</th>\n";
		echo "<th>Sector</th>\n";
		echo "<th>Servicio</th>\n";
		echo "<th>Marca</th>\n";		
		echo "<th>Modelo</th>\n";
		echo "<th>Cliente</th>\n";
		echo "<th>Alta Habilitaci&oacute;n</th>\n";
		echo "<th>Baja Habilitaci&oacute;n</th>\n";
		echo "</tr>\n";	
		while($row=mysql_fetch_array($rs)){ 
			$faltah= FormatoFecha($row['FechaA']);if ($faltah=='00-00-0000'){$faltah="";}
			$fbajah= FormatoFecha($row['FechaB']);if ($fbajah=='00-00-0000'){$fbajah="";}
			echo "<tr>\n";
			echo "<td >".$row['Id']."</td>\n";
			echo "<td >".GLO_textoExcel($row['Nombre'])."</td>\n";
			echo "<td >".GLO_textoExcel($row['Dominio'])."</td>\n";
			echo '<td>'.GLO_textoExcel($row['Sector'])."</td>\n";
			echo '<td>'.GLO_textoExcel($row['Servicio'])."</td>\n";
			echo '<td>'.GLO_textoExcel($row['Marca'])."</td>\n";
			echo '<td>'.GLO_textoExcel($row['Modelo'])."</td>\n";
			echo '<td>'.GLO_textoExcel($row['IdCliente'].' '.$row['Cliente'])."</td>\n";
			echo '<td>'.$faltah."</td>\n";
			echo '<td>'.$fbajah."</td>\n";
			echo "</tr>\n";			
		}	
		//Cierra tabla excel
		echo "</table>\n";				
	}	
	mysql_free_result($rs);	mysql_close($conn); 
}

 }




?>