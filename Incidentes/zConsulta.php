<? include("../Codigo/Seguridad.php");include("../Codigo/Config.php");include("../Codigo/Funciones.php");$_SESSION["NivelArbol"]="../";include("Includes/zFunciones.php");
//perfiles
if ($_SESSION["IdPerfilUser"]!=1 and $_SESSION["IdPerfilUser"]!=2  and $_SESSION["IdPerfilUser"]!=3  and $_SESSION["IdPerfilUser"]!=9 and $_SESSION["IdPerfilUser"]!=14){ header("Location:".$_SESSION["NivelArbol"]."Inicio.php");}


if (isset($_POST['CmdBuscar'])){
	foreach($_POST as $key => $value){$_SESSION[$key] = $value;}
	$wbuscar='';
	//filtros
	if (!(empty($_POST['TxtFechaD']))){$wbuscar=$wbuscar." and DATEDIFF(a.Fecha,'".FechaMySql($_POST['TxtFechaD'])."')>=0";}
	if (!(empty($_POST['TxtFechaH']))){$wbuscar=$wbuscar." and DATEDIFF(a.Fecha,'".FechaMySql($_POST['TxtFechaH'])."')<=0";}
	$vbuscar=intval($_POST['CbYac']);if($vbuscar!=0){$wbuscar=$wbuscar." and a.IdYac=$vbuscar";}
	$vbuscar=intval($_POST['CbSector']);if($vbuscar!=0){$wbuscar=$wbuscar." and a.IdSector=$vbuscar";}	
	$vbuscar=intval($_POST['CbPersonal']);if($vbuscar!=0){$wbuscar=$wbuscar." and a.IdPersonal=$vbuscar";}
	//estado (id0 es pdte)
	$vbuscar=intval($_POST['CbEstado']);if($vbuscar!=0){$vbuscar=$vbuscar-1;$wbuscar=$wbuscar." and a.IdE=$vbuscar";}
	//
	$_SESSION['TxtQINCID']="Select a.*,s.Nombre as Sector,p2.Nombre as Nom2,p2.Apellido as Ap2,y.Nombre as Yac From incidentes a,sector s,personal p2,yacimientos y Where a.Id<>0 and a.IdSector=s.Id and a.IdPersonal=p2.Id and a.IdYac=y.Id $wbuscar Order by a.Fecha,a.Hora,s.Nombre";
	header("Location:../Incidentes.php");
}



if (isset($_POST['CmdBorrarFila'])){
	foreach($_POST as $key => $value){$_SESSION[$key] = $value;}
	$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);
	$query="Delete From incidentes Where Id=".intval($_POST['TxtId']);	$rs=mysql_query($query,$conn);
	if ($rs){GLO_feedback(1);}else{GLO_feedback(2);} 
	mysql_close($conn); 
	header("Location:../Incidentes.php"); 	
}




if (isset($_POST['CmdLinkRow'])){
	foreach($_POST as $key => $value){$_SESSION[$key] = "";}
	$_SESSION['TxtQINCID']=$_POST['TxtQINCID'];
	header("Location:Modificar.php?id=".intval($_POST['TxtId'])."&Flag1=True");
}




if (isset($_POST['CmdExcel'])){
	$query=$_POST['TxtQINCID'];$query=str_replace("\\", "", $query);
	if ($query!=""){
		$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);$rs=mysql_query($query,$conn);
		if(mysql_num_rows($rs)!=0){	
			include("../Codigo/ExcelHeader.php");	
			include("../Codigo/ExcelStyle.php");
			echo "<th>Fecha</th>\n";
			echo "<th>Hora</th>\n";
			echo "<th>Sector</th>\n";
			echo "<th>Lugar</th>\n";	
			echo "<th>Denunciante</th>\n";
			//
			echo "<th>Laboral</th>\n";
			echo "<th>In Itinere</th>\n";
			echo "<th>Tipo</th>\n";
			//
			echo "<th>Descripcion</th>\n";
			echo "<th>Da&ntilde;os</th>\n";
			echo "<th>Condiciones</th>\n";
			echo "<th>Actos</th>\n";
			echo "<th>Causa</th>\n";
			//
			echo "<th>Involucrados</th>\n";
			echo "<th>Medidas</th>\n";
			//
			echo "<th>Estado</th>\n";
			echo "</tr>\n";				
			while($row=mysql_fetch_array($rs)){ 
				include("Includes/zTipoIncidente.php");
				$idpadre=$row['Id'];//id incidente
				//personas
				$involucrados='';
				$query="SELECT m.IdPersonal,m.Nombre,p.Nombre as Nom,p.Apellido as Ap From incidentes_per m,personal p where m.IdPersonal=p.Id and m.IdP=$idpadre Order by m.Id";$rs2=mysql_query($query,$conn);
				while($row2=mysql_fetch_array($rs2)){ 
					if($row2['IdPersonal']==0){$involucrados=GLO_ListaTexto($involucrados,$row2['Nombre']);}
					else{$involucrados=GLO_ListaTexto($involucrados,$row2['Ap'].' '.$row2['Nom']);}
				}mysql_free_result($rs2);
				//medidas
				$medidas='';
				$query="SELECT m.*,p.Nombre as N,p.Apellido as A From incidentes_med m,personal p where m.IdPersonal=p.Id and m.IdP=$idpadre Order by m.Id";$rs2=mysql_query($query,$conn);
				while($row2=mysql_fetch_array($rs2)){
					$medidas=GLO_ListaTexto($medidas,$row2['Obs']);
				}mysql_free_result($rs2);
				//
				echo "<tr>\n";
				echo '<td>'.GLO_FormatoFecha($row['Fecha'])."</td>\n";
				echo '<td>'.GLO_FormatoHora($row['Hora'])."</td>\n";
				echo '<td>'.GLO_textoExcel($row['Sector'])."</td>\n";
				echo '<td>'.GLO_textoExcel($row['Yac'])."</td>\n";
				echo '<td>'.GLO_textoExcel($row['Ap2'].' '.$row['Nom2'])."</td>\n";
				//
				echo '<td>'.GLO_Si($row['Tipo1'])."</td>\n";
				echo '<td>'.GLO_Si($row['Tipo2'])."</td>\n";
				echo '<td>'.GLO_textoExcel($tipoincidente)."</td>\n";
				//
				echo '<td>'.GLO_textoExcel($row['Obs'])."</td>\n";
				echo '<td>'.GLO_textoExcel($row['Obs1'])."</td>\n";
				echo '<td>'.GLO_textoExcel($row['Obs2'])."</td>\n";
				echo '<td>'.GLO_textoExcel($row['Obs3'])."</td>\n";
				echo '<td>'.GLO_textoExcel($row['Obs4'])."</td>\n";
				//
				echo '<td>'.GLO_textoExcel($involucrados)."</td>\n";
				echo '<td>'.GLO_textoExcel($medidas)."</td>\n";
				//
				echo '<td>'.GLO_textoExcel(INC_estado($row['IdE']))."</td>\n";	
				echo "</tr>\n";			
			}	
			//Cierra tabla excel
			echo "</table>\n";				
		}	
		mysql_free_result($rs);	mysql_close($conn); 
	}

 }

?>