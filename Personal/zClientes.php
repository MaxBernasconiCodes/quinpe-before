<? include("../Codigo/Seguridad.php");include("../Codigo/Config.php");include("../Codigo/Funciones.php");$_SESSION["NivelArbol"]="../";

//perfiles
include("../Perfiles/Permisos/p1.php");







//Boton Buscar

if (isset($_POST[CmdBuscar])){

	$consulta="";$fechahoy=FechaMySql(date("d-m-Y"));

	$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);

	foreach($_POST as $key => $value){$_SESSION[$key] = $value;}

	//personal

	if ((empty($_POST['TxtBusqueda']))){$wpers="";}

	else{$wpers="and (p.Nombre Like '%".mysql_real_escape_string($_POST['TxtBusqueda'])."%' or p.Apellido Like '%".mysql_real_escape_string($_POST['TxtBusqueda'])."%')";}

	//combos

	$cli=intval($_POST['CbCliente']);if($cli!=0){$wcli="and h.IdCliente=$cli";}else{$wcli='';}

	$orden=mysql_real_escape_string($_POST['CbOrden']);	

	$sector=intval($_POST['CbSector']);if($sector!=0){$wsector="and p.IdSector=$sector";}else{$wsector='';}

	$serv=intval($_POST['CbServicio']);if($serv!=0){$wserv="and p.IdServicio=$serv";}else{$wserv='';}

	$func=intval($_POST['CbFuncion']);if($func!=0){$wfunc="and p.IdFuncion=$func";}else{$wfunc='';}

	$rsoc=intval($_POST['CbRS']);if($rsoc!=0){$wrsoc="and p.IdRS=$rsoc";}else{$wrsoc='';}

	$activo=intval($_POST['ChkActivo']);if($activo!=0){$wactivo="and (p.FechaBaja='0000-00-00' or DATEDIFF('".$fechahoy. "',p.FechaBaja)<0)";}else{$wactivo='';}

	$consulta="SELECT p.*,t.Nombre as Turno,f.Nombre as Funcion,s.Nombre as Sector,s1.Nombre as Servicio,rs.Nombre as RazonSocial,c.Nombre as Cliente,h.FechaA,h.FechaB,h.IdCliente  From personal p,turnos t,funcion f,sector s, servicios se,serviciostipo1 s1,parametrosrs rs,personalclientes h,clientes c where p.Id<>0  and p.IdTurno=t.Id and p.IdServicio=se.Id and se.IdTipo=s1.Id  and p.IdFuncion=f.Id and p.IdSector=s.Id and p.IdRS=rs.Id and h.IdPersonal=p.Id and h.IdCliente=c.Id $wpers $wcli $wsector $wserv $wfunc $wrsoc $wactivo Order by p.Apellido,c.Nombre,h.FechaA";

	$_SESSION[TxtQuery]=$consulta;

	mysql_close($conn); 

	header("Location:Clientes.php");

}











if (isset($_POST[CmdExcel])){

$query=$_POST['TxtQuery'];$query=str_replace("\\", "", $query);

if ($query!=""){

	$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);$rs=mysql_query($query,$conn);

	if(mysql_num_rows($rs)!=0){	

		//Titulos excel

		include("../Codigo/ExcelHeader.php");	

		include("../Codigo/ExcelStyle.php");

		echo "<th>Legajo</th>\n";

		echo "<th>Identificaci&oacute;n</th>\n";			

		echo "<th>Documento</th>\n";

		echo "<th>Nombre</th>\n";

		echo "<th>Razon Social</th>\n";

		echo "<th>Turno</th>\n";

		echo "<th>Sector</th>\n";

		echo "<th>Funci&oacute;n</th>\n";

		echo "<th>Servicio</th>\n";

		echo "<th>Cliente</th>\n";

		echo "<th>Alta Habilitaci&oacute;n</th>\n";

		echo "<th>Baja Habilitaci&oacute;n</th>\n";

		echo "</tr>\n";	

		while($row=mysql_fetch_array($rs)){ 

			$faltah= FormatoFecha($row['FechaA']);if ($faltah=='00-00-0000'){$faltah="";}

			$fbajah= FormatoFecha($row['FechaB']);if ($fbajah=='00-00-0000'){$fbajah="";}

			echo "<tr>\n";

			echo "<td align='right'>".str_pad($row['Legajo'], 6, "0", STR_PAD_LEFT)."</td>\n";

			echo '<td>'.$row['TipoIdentificacion']." ".$row['Identificacion']."</td>\n";

			echo '<td>'.$row['TipoDocumento']." ".$row['Documento']."</td>\n";

			echo '<td>'.GLO_textoExcel($row['Apellido']." ".$row['Nombre'])."</td>\n";

			echo '<td>'.GLO_textoExcel($row['RazonSocial'])."</td>\n";

			echo '<td>'.GLO_textoExcel($row['Turno'])."</td>\n";

			echo '<td>'.GLO_textoExcel($row['Sector'])."</td>\n";

			echo '<td>'.GLO_textoExcel($row['Funcion'])."</td>\n";

			echo '<td>'.GLO_textoExcel($row['Servicio'])."</td>\n";

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