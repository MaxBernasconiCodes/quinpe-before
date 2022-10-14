<? include("../Codigo/Seguridad.php") ; $_SESSION["NivelArbol"]="../";include("../Codigo/Config.php");include("../Codigo/Funciones.php");
//perfiles
if ($_SESSION["IdPerfilUser"]!=1 and $_SESSION["IdPerfilUser"]!=2 and $_SESSION["IdPerfilUser"]!=3  and  $_SESSION["IdPerfilUser"]!=9 and $_SESSION["IdPerfilUser"]!=14){ header("Location:".$_SESSION["NivelArbol"]."Inicio.php");}

if (isset($_POST['CmdBuscar'])){ 	
	foreach($_POST as $key => $value){$_SESSION[$key] = $value;}
	//filtro
	$wbuscar='';
	if (!(empty($_POST['TxtFechaD']))){$wbuscar=$wbuscar." and DATEDIFF(a.Fecha,'".FechaMySql($_POST['TxtFechaD'])."')>=0";}
	if (!(empty($_POST['TxtFechaH']))){$wbuscar=$wbuscar." and DATEDIFF(a.Fecha,'".FechaMySql($_POST['TxtFechaH'])."')<=0";}
	$vbuscar=intval($_POST['TxtNroInterno']);if($vbuscar!=0){$wbuscar=$wbuscar." and a.Id=$vbuscar";}
	$vbuscar=intval($_POST['CbCliente']);if($vbuscar!=0){$wbuscar=$wbuscar." and a.IdCliente=$vbuscar";}
	$vbuscar=intval($_POST['CbEstado']);if($vbuscar!=0){$wbuscar=$wbuscar." and a.IdEstado=$vbuscar";}	
	$vbuscar=intval($_POST['CbTipo']);if($vbuscar!=0){$wbuscar=$wbuscar." and a.IdTipo=$vbuscar";}	
	//
	$_SESSION['TxtQOPOV']="Select a.*,c.Nombre,e.Nombre as Estado,s1.Nombre as LA From c_oportunidades a,clientes c,c_oportunidad_est e,serviciostipo1 s1 Where a.IdCliente=c.Id and e.Id=a.IdEstado and s1.Id=a.IdTipo $wbuscar Order by a.Id";
	header("Location:Oportunidades.php");
}



elseif (isset($_POST['CmdBorrarFila'])){
	foreach($_POST as $key => $value){$_SESSION[$key] = $value;}
	$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);
	$query="Delete From c_oportunidades Where Id=".intval($_POST['TxtId']);$rs=mysql_query($query,$conn);
	if ($rs){GLO_feedback(1);}else{GLO_feedback(2);} 
	mysql_close($conn); 
	header("Location:Oportunidades.php"); 	
}



elseif (isset($_POST['CmdExcel'])){
	$query=$_POST['TxtQOPOV'];$query=str_replace("\\", "", $query);
	if ($query!=""){
		$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);$rs=mysql_query($query,$conn);
		if(mysql_num_rows($rs)!=0){	
			include("../Codigo/ExcelHeader.php");
			include("../Codigo/ExcelStyle.php");
			echo "<th>N&uacute;mero</th>\n";
			echo "<th>Fecha</th>\n";
			echo "<th>Cliente</th>\n";	
			echo "<th >Tipo Servicio</th>\n";
			echo "<th>Observaciones</th>\n";
			echo "<th>Estado</th>\n";	
			echo "</tr>\n";				
			while($row=mysql_fetch_array($rs)){ 
				echo "<tr>\n";
				echo '<td>'.$row['Id']."</td>\n";
				echo '<td>'.FormatoFecha($row['Fecha'])."</td>\n";
				echo '<td>'.GLO_textoExcel($row['Nombre'])."</td>\n";
				echo '<td>'.GLO_textoExcel($row['LA'])."</td>\n";
				echo '<td>'.GLO_textoExcel($row['Obs'])."</td>\n";
				echo '<td>'.GLO_textoExcel($row['Estado'])."</td>\n";
				echo "</tr>\n";			
			}	
			echo "</table>\n";				
		}	
		mysql_free_result($rs);	mysql_close($conn); 
	}

 }



?> 

