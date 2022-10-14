<? include("../Codigo/Seguridad.php");include("../Codigo/Config.php");include("../Codigo/Funciones.php");$_SESSION["NivelArbol"]="../";
//perfiles
if ($_SESSION["IdPerfilUser"]!=1 and $_SESSION["IdPerfilUser"]!=2  and $_SESSION["IdPerfilUser"]!=3  and $_SESSION["IdPerfilUser"]!=9 and $_SESSION["IdPerfilUser"]!=14){ header("Location:".$_SESSION["NivelArbol"]."Inicio.php");}


if (isset($_POST['CmdBuscar'])){
	foreach($_POST as $key => $value){$_SESSION[$key] = $value;}
	//filtros
	if (!(empty($_POST['TxtFechaD']))){$wfechad="and DATEDIFF(a.Fecha,'".FechaMySql($_POST['TxtFechaD'])."')>=0";}else{$wfechad="";}
	if (!(empty($_POST['TxtFechaH']))){$wfechah="and DATEDIFF(a.Fecha,'".FechaMySql($_POST['TxtFechaH'])."')<=0";}else{$wfechah="";}
	$ctro=intval($_POST['CbCentro']);if($ctro!=0){$wctro="and a.IdCentro=$ctro";}else{$wctro='';}
	$cli=intval($_POST['CbCliente']);if($cli!=0){$wcli="and a.IdCliente=$cli";}else{$wcli='';}
	//
	$_SESSION['TxtQTOT']="Select a.*,s.Nombre as Sector,p.Nombre as N1,p.Apellido as A1,p2.Nombre as N2,p2.Apellido as A2,co.Nombre as Centro,cli.Nombre as Cliente,tc.Nombre as Cat From tot a,sector s,personal p,personal p2,epparticulos co,clientes cli,totcat tc Where a.Id<>0 and a.IdSector=s.Id and a.IdCentro=co.Id and a.IdPersonal=p.Id and a.IdPersonal2=p2.Id and a.IdCliente=cli.Id and  a.IdCat=tc.Id $wfechad $wfechah $wctro $wcli Order by a.Fecha,co.Nombre";
	header("Location:../TOT.php");
}



if (isset($_POST['CmdBorrarFila'])){
	foreach($_POST as $key => $value){$_SESSION[$key] = $value;}
	$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);
	$query="Delete From tot Where Id=".intval($_POST['TxtId']);	$rs=mysql_query($query,$conn);
	if ($rs){GLO_feedback(1);}else{GLO_feedback(2);} 
	mysql_close($conn); 
	header("Location:../TOT.php"); 	
}




if (isset($_POST['CmdLinkRow'])){
	foreach($_POST as $key => $value){$_SESSION[$key] = "";}
	$_SESSION['TxtQTOT']=$_POST['TxtQTOT'];
	header("Location:Modificar.php?id=".intval($_POST['TxtId'])."&Flag1=True");
}




if (isset($_POST['CmdExcel'])){
	$query=$_POST['TxtQTOT'];$query=str_replace("\\", "", $query);
	if ($query!=""){
		$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);$rs=mysql_query($query,$conn);
		if(mysql_num_rows($rs)!=0){	
			include("../Codigo/ExcelHeader.php");	
			include("../Codigo/ExcelStyle.php");
			echo "<th>Equipo</th>\n";
			echo "<th>Cliente</th>\n";			
			echo "<th>Fecha</th>\n";
			echo "<th>Sector</th>\n";
			echo "<th>Resp.Deteccion</th>\n";			
			echo "<th>Categoria de observacion/desvio</th>\n";
			echo "<th>Situacion detectada</th>\n";	
			echo "<th>Pudo corregir el problema usted mismo</th>\n";
			echo "<th>Se aplico autoridad detencion de trabajo</th>\n";
			echo "<th>Posible consecuencia</th>\n";
			echo "<th>Accin Correctiva/Accin Preventiva</th>\n";
			echo "<th>Responsable de seguimiento acciones</th>\n";
			echo "<th>Estado</th>\n";
			echo "</tr>\n";				
			while($row=mysql_fetch_array($rs)){ 
				if($row['Estado']==0){$estado='ABIERTO';}else{$estado='CERRADO';}
				echo "<tr>\n";
				echo '<td>'.GLO_textoExcel($row['Centro'])."</td>\n";
				echo '<td>'.GLO_textoExcel($row['Cliente'])."</td>\n";
				echo '<td>'.GLO_FormatoFecha($row['Fecha'])."</td>\n";
				echo '<td>'.GLO_textoExcel($row['Sector'])."</td>\n";
				echo '<td>'.GLO_textoExcel($row['A1'].' '.$row['N1'])."</td>\n";
				echo '<td>'.GLO_textoExcel($row['Cat'])."</td>\n";
				echo '<td>'.GLO_textoExcel($row['AccionR'])."</td>\n";
				echo '<td>'.GLO_SiNo($row['O1'])."</td>\n";//si:1,no:0
				echo '<td>'.GLO_SiNo($row['O2'])."</td>\n";//si:1,no:0
				echo '<td>'.GLO_textoExcel($row['Cons'])."</td>\n";
				echo '<td>'.GLO_textoExcel($row['AccionCP'])."</td>\n";
				echo '<td>'.GLO_textoExcel($row['A2'].' '.$row['N2'])."</td>\n";
				echo '<td>'.$estado."</td>\n";
				echo "</tr>\n";			
			}	
			//Cierra tabla excel
			echo "</table>\n";				
		}	
		mysql_free_result($rs);	mysql_close($conn); 
	}

 }

?>