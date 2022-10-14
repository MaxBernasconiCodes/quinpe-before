<? include("../Codigo/Seguridad.php");include("../Codigo/Config.php");include("../Codigo/Funciones.php");$_SESSION["NivelArbol"]="../";

//perfiles

if ($_SESSION["IdPerfilUser"]!=1 and $_SESSION["IdPerfilUser"]!=2 and $_SESSION["IdPerfilUser"]!=4 and $_SESSION["IdPerfilUser"]!=7 and $_SESSION["IdPerfilUser"]!=3  and $_SESSION["IdPerfilUser"]!=11  and $_SESSION["IdPerfilUser"]!=12  and $_SESSION["IdPerfilUser"]!=9 and $_SESSION["IdPerfilUser"]!=14 and $_SESSION["IdPerfilUser"]!=13){ header("Location:".$_SESSION["NivelArbol"]."Inicio.php");}







//Boton Buscar

if (isset($_POST['CmdBuscar'])){

	$fechahoy=FechaMySql(date("d-m-Y"));

	$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);

	foreach($_POST as $key => $value){$_SESSION[$key] = $value;}

	//where 

	if ((empty($_POST['TxtBusqueda']))){$wdom="";}else{$wdom="and (u.Dominio Like '%".mysql_real_escape_string($_POST['TxtBusqueda'])."%')";}

	$serv=intval($_POST['CbServ']);if($serv!=0){$wserv="and u.IdServicio=$serv";}else{$wserv='';}

	$cat=intval($_POST['CbCateg']);if($cat!=0){$wcat="and u.IdCateg=$cat";}else{$wcat='';}

	$chkprop=intval($_POST['ChkProp']);if($chkprop!=0){$wchkprop="and u.Propio=$chkprop";}else{$wchkprop='';}

	$alq=intval($_POST['ChkAlq']);if($alq!=0){$walq="and u.Alquilado=$alq";}else{$walq='';}

	$leas=intval($_POST['ChkLeas']);if($leas!=0){$wleas="and u.Leasing=$leas";}else{$wleas='';}

	$afec=intval($_POST['ChkAfe']);if($afec!=0){$wafec="and u.Afectado=$afec";}else{$wafec='';}

	$activo=intval($_POST['ChkActivo']);if($activo!=0){$wactivo="and (u.FechaBaja='0000-00-00' or DATEDIFF('".$fechahoy. "',u.FechaBaja)<0)";}else{$wactivo='';}

	$nro=intval($_POST['TxtNroInterno']);if($nro!=0){$wnro="and u.Id=$nro";}else{$wnro='';}		

	$nrolista=intval($_POST['CbNroInterno']);if($nrolista!=0){$wnrolista="and u.Id=$nrolista";}else{$wnrolista='';}		

	//query pagina

	$_SESSION['TxtQUNI']="SELECT u.*,ca.Nombre as Categ,co.Nombre as Cond,s1.Nombre as Servicio From unidades u,unidadescateg ca,unidadescond co, servicios se,serviciostipo1 s1 where u.Id<>0 and u.IdCateg=ca.Id and u.IdCond=co.Id and u.IdServicio=se.Id and se.IdTipo=s1.Id  $wserv $wdom $wcat $wchkprop $walq $wleas $wafec $wactivo $wnro $wnrolista Order by u.FechaBaja,u.Nombre";

	//query excel

	$_SESSION['TxtQUNIEX']="SELECT u.*,e.Nombre as Elem,m.Nombre as Marca,ca.Nombre as Categ,co.Nombre as Cond,f.Nombre as Fabr,s.Nombre as Sector,s1.Nombre as Servicio,mt.Nombre as MarcaT,r.Nombre as Rodado From unidades u,unidadeselem e,unidadesmarcas m,unidadescateg ca,unidadescond co,unidadesfabric f,sector s, servicios se,serviciostipo1 s1,unidadesmarcastaco mt,unidadesrodados r where u.Id<>0 and u.IdElemento=e.Id and u.IdMarca=m.Id and u.IdCateg=ca.Id and u.IdCond=co.Id and u.IdFabr=f.Id and u.IdSector=s.Id and u.IdServicio=se.Id and se.IdTipo=s1.Id  and u.IdMarcaTaco=mt.Id and u.IdRodado=r.Id $wserv $wdom $wcat $wchkprop $walq $wleas $wafec $wactivo $wnro $wnrolista Order by u.FechaBaja,u.Nombre";



	mysql_close($conn); 

	header("Location:../Unidades.php");

}







if (isset($_POST['CmdBorrarFila'])){

	$query="Delete From unidades Where Id=".intval($_POST['TxtId']);

	$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);$rs=mysql_query($query,$conn);

	if ($rs){GLO_feedback(1);}else{GLO_feedback(2);} 

	mysql_close($conn); 

	header("Location:../Unidades.php"); 	

}







if (isset($_POST['CmdExcel'])){

$query=$_POST['TxtQUNIEX'];$query=str_replace("\\", "", $query);

if ($query!=""){

	$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);$rs=mysql_query($query,$conn);

	if(mysql_num_rows($rs)!=0){	

		include("../Codigo/ExcelHeader.php");	

		include("../Codigo/ExcelStyle.php");

		echo "<th>N&uacute;mero</th>\n";

		echo "<th>Dominio</th>\n";

		echo "<th>Nombre</th>\n";

		echo "<th>Categor&iacute;a</th>\n";

		echo "<th>Marca</th>\n";		

		echo "<th>Modelo</th>\n";

		echo "<th>Nro.Chasis</th>\n";

		echo "<th>Nro.Motor</th>\n";

		echo "<th>Fabricante</th>\n";

		echo "<th>Alta</th>\n";

		echo "<th>Baja</th>\n";

		//

		echo "<th>A&ntilde;o</th>\n";

		echo "<th>KmIngreso</th>\n";

		echo "<th>Estado</th>\n";

		echo "<th>Elemento</th>\n";

		echo "<th>Propio</th>\n";

		echo "<th>Alquilado</th>\n";

		echo "<th>Leasing</th>\n";

		echo "<th>Propietario</th>\n";

		echo "<th>Tac&oacute;grafo</th>\n";

		echo "<th>Marca Tac&oacute;grafo</th>\n";

		echo "<th>Nro.Tac&oacute;grafo</th>\n";

		echo "<th>Rodado</th>\n";

		echo "<th>Cant.Cubiertas</th>\n";

		//

		echo "<th>Sector</th>\n";

		echo "<th>Servicio</th>\n";

		echo "<th>Afectado</th>\n";

		//

		echo "<th>Observaciones</th>\n";

		echo "</tr>\n";	

		while($row=mysql_fetch_array($rs)){ 

			echo "<tr>\n";

			echo "<td >".$row['Id']."</td>\n";

			echo "<td >".GLO_textoExcel($row['Dominio'])."</td>\n";

			echo "<td >".GLO_textoExcel($row['Nombre'])."</td>\n";

			echo '<td>'.GLO_textoExcel($row['Categ'])."</td>\n";			

			echo '<td>'.GLO_textoExcel($row['Marca'])."</td>\n";

			echo '<td>'.GLO_textoExcel($row['Modelo'])."</td>\n";

			echo '<td>'.GLO_textoExcel($row['NroChasis'])."</td>\n";

			echo '<td>'.GLO_textoExcel($row['NroMotor'])."</td>\n";

			echo '<td>'.GLO_textoExcel($row['Fabr'])."</td>\n";

			echo '<td>'.GLO_FormatoFecha($row['FechaAlta'])."</td>\n";

			echo '<td>'.GLO_FormatoFecha($row['FechaBaja'])."</td>\n";

			//

			echo '<td>'.$row['Anio']."</td>\n";

			echo '<td>'.$row['KmI']."</td>\n";

			echo '<td>'.GLO_textoExcel($row['Cond'])."</td>\n";

			echo '<td>'.GLO_textoExcel($row['Elem'])."</td>\n";

			echo '<td>'.GLO_Si($row['Propio'])."</td>\n";

			echo '<td>'.GLO_Si($row['Alquilado'])."</td>\n";

			echo '<td>'.GLO_Si($row['Leasing'])."</td>\n";

			echo '<td>'.GLO_textoExcel($row['Titular'])."</td>\n";			

			echo '<td>'.GLO_Si($row['Taco'])."</td>\n";

			echo '<td>'.GLO_textoExcel($row['MarcaT'])."</td>\n";

			echo '<td>'.GLO_textoExcel($row['NroTaco'])."</td>\n";

			echo '<td>'.GLO_textoExcel($row['Rodado'])."</td>\n";

			echo '<td>'.GLO_textoExcel($row['Cub'])."</td>\n";

			//

			echo '<td>'.GLO_textoExcel($row['Sector'])."</td>\n";

			echo '<td>'.GLO_textoExcel($row['Servicio'])."</td>\n";

			echo '<td>'.GLO_Si($row['Afectado'])."</td>\n";

			//

			echo '<td>'.GLO_textoExcel($row['Obs'])."</td>\n";

			echo "</tr>\n";			

		}	

		//Cierra tabla excel

		echo "</table>\n";				

	}	

	mysql_free_result($rs);	mysql_close($conn); 

}



 }









?>





