<? include("../Codigo/Seguridad.php");include("../Codigo/Config.php");include("../Codigo/Funciones.php");$_SESSION["NivelArbol"]="../";
//perfiles
GLO_PerfilAcceso(10);


//Boton Buscar
if (isset($_POST['CmdBuscar'])){
	foreach($_POST as $key => $value){$_SESSION[$key] = $value;}
	$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);
	//personal
	if ((empty($_POST['TxtBusqueda']))){$wpers="";}
	else{$wpers="and (p.Nombre Like '%".mysql_real_escape_string($_POST['TxtBusqueda'])."%' or p.Apellido Like '%".mysql_real_escape_string($_POST['TxtBusqueda'])."%')";}
	//fechas
	$tipov=$_POST['CbTipoV'];$wvto='';
	$hoy=date("d-m-Y"); list($d,$m,$a)=explode("-",$hoy);$primerdiames="01-".$m."-".$a;
	$fhoy=FechaMySql(date("d-m-Y"));
	if($tipov=="MesActual"){
		$fdesde=FechaMySql(date("d-m-Y", strtotime("$primerdiames")));
		$fhasta=FechaMySql(date("d-m-Y", strtotime("$primerdiames +1 month")));
	}
	if($tipov=="MesProximo"){
		$fdesde=FechaMySql(date("d-m-Y", strtotime("$primerdiames +1 month")));
		$fhasta=FechaMySql(date("d-m-Y", strtotime("$primerdiames +2 month")));
	}
	//where plazo vto
	if($tipov=="Vencidos"){$wvto=" and DATEDIFF('".$fhoy. "',v.Fecha)>0";}
	if($tipov=="Vigentes"){$wvto=" and DATEDIFF('".$fhoy. "',v.Fecha)<=0";}
	if($tipov=="Vacio"){$wvto=" and v.Fecha='0000-00-00'";}
	if($tipov=="Todos"){$wvto="";}
	if(($tipov=="MesActual")or($tipov=="MesProximo")){$wvto=" and DATEDIFF(v.Fecha,'".$fdesde."')>=0 and DATEDIFF(v.Fecha,'".$fhasta."')<0";}
	//where 
	$vto=intval($_POST['CbVto']);if($vto!=0){$wtipovto="and v.IdTipo=$vto";}else{$wtipovto='';}
	$req=intval($_POST['ChkReq']);if($req!=0){$wreq="and v.Req=1";}else{$wreq='';}
	$act=intval($_POST['ChkInactivo']);if($act!=0){$wact="and v.Inactivo=0";}else{$wact='';}
	//
	$query="SELECT p.*,v.Inactivo, v.Fecha, v.FechaE,v.Req,v.Obs,t.Nombre as Tipo From personal p,personalvtos v,personalvtos_tipos t where p.Id<>0 and t.Id=v.IdTipo and v.IdEntidad=p.Id  and (p.FechaBaja='0000-00-00' or DATEDIFF('".$fhoy. "',p.FechaBaja)<0) $wvto $wtipovto $wreq $wact $wpers  Order by v.Inactivo,p.Apellido,p.Nombre,t.Nombre";
	$_SESSION['TxtQuery']=$query;
	mysql_close($conn); 
	header("Location:../Vencimientos.php");
}



if (isset($_POST['CmdExcel'])){
	$query=$_POST['TxtQuery'];$query=str_replace("\\", "", $query);
	if ($query!=""){
		$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);$rs=mysql_query($query,$conn);
		if(mysql_num_rows($rs)!=0){	
			//Titulos excel
			include("../Codigo/ExcelHeader.php");	
			include("../Codigo/ExcelStyle.php");
			echo "<th>Legajo</th>\n";
			echo "<th>Apellido</th>\n";			
			echo "<th>Nombre</th>\n";
			echo "<th>Habilitaci&oacute;n</th>\n";
			echo "<th>Emisi&oacute;n</th>\n";
			echo "<th>Vencimiento</th>\n";
			echo "</tr>\n";	
			while($row=mysql_fetch_array($rs)){ 
				$femi= GLO_FormatoFecha($row['FechaE']);
				$fvto= GLO_FormatoFecha($row['Fecha']);
				echo "<tr>\n";
				echo "<td align='right'>".str_pad($row['Legajo'], 6, "0", STR_PAD_LEFT)."</td>\n";
				echo '<td>'.GLO_textoExcel($row['Apellido'])."</td>\n";
				echo '<td>'.GLO_textoExcel($row['Nombre'])."</td>\n";
				echo '<td>'.GLO_textoExcel($row['Tipo'])."</td>\n";
				echo '<td>'.$femi."</td>\n";
				if ($fvto!="" and (strtotime(date("d-m-Y"))-strtotime($fvto))>0)
				{echo "<td><font color=red>".$fvto."</font></td>\n";}else{echo '<td>'.$fvto."</td>\n";}
				echo "</tr>\n";			
			}	
			//Cierra tabla excel
			echo "</table>\n";				
		}	
		mysql_free_result($rs);	mysql_close($conn); 
	}
 }




?>