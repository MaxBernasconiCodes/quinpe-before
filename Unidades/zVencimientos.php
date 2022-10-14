<? include("../Codigo/Seguridad.php");include("../Codigo/Config.php");include("../Codigo/Funciones.php");$_SESSION["NivelArbol"]="../";
//perfiles
if ($_SESSION["IdPerfilUser"]!=1 and $_SESSION["IdPerfilUser"]!=2 and $_SESSION["IdPerfilUser"]!=4 and $_SESSION["IdPerfilUser"]!=7 and $_SESSION["IdPerfilUser"]!=3  and $_SESSION["IdPerfilUser"]!=11  and $_SESSION["IdPerfilUser"]!=12  and $_SESSION["IdPerfilUser"]!=9 and $_SESSION["IdPerfilUser"]!=14 and $_SESSION["IdPerfilUser"]!=13){ header("Location:".$_SESSION["NivelArbol"]."Inicio.php");}


//Boton Buscar
if (isset($_POST['CmdBuscar'])){
	foreach($_POST as $key => $value){$_SESSION[$key] = $value;}	
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
	//where plazo vto polizas
	if($tipov=="Vencidos"){$wvtop=" and DATEDIFF('".$fhoy. "',v.FechaF)>0";}
	if($tipov=="Vigentes"){$wvtop=" and DATEDIFF('".$fhoy. "',v.FechaF)<=0";}
	if($tipov=="Vacio"){$wvtop=" and v.FechaF='0000-00-00'";}
	if($tipov=="Todos"){$wvtop="";}
	if(($tipov=="MesActual")or($tipov=="MesProximo")){$wvtop=" and DATEDIFF(v.FechaF,'".$fdesde."')>=0 and DATEDIFF(v.FechaF,'".$fhasta."')<0";}
	//where tipo vto
	$vto=intval($_POST['CbVto']);if($vto!=0){$wtipovto="and v.IdTipo=$vto";}else{$wtipovto='';}
	//where req
	$req=intval($_POST['ChkReq']);if($req!=0){$wreq="and v.Req=1";}else{$wreq='';}

	if($vto==0){//todos los tipos
		$query1="SELECT p.*,v.Inactivo, v.Fecha, v.FechaE,v.Req,v.Obs,t.Nombre as Tipo From unidades p,unidadesvtos v,unidadesvtos_tipos t where p.Id<>0 and t.Id=v.IdTipo and v.IdEntidad=p.Id and (p.FechaBaja='0000-00-00' or DATEDIFF('".$fhoy. "',p.FechaBaja)<0) and v.Inactivo=0 $wvto $wtipovto $wreq";
		$query2="SELECT p.*,0 as Inactivo, v.FechaF as Fecha, v.FechaI as FechaE,1 as Req,' ' as Obs,'Poliza Seg.Automotor' as Tipo From unidades p,polizassegauto v where p.Id<>0 and v.Id=p.IdPSA and p.IdPSA<>0 and (p.FechaBaja='0000-00-00' or DATEDIFF('".$fhoy. "',p.FechaBaja)<0) $wvtop";
		$query3="SELECT p.*,0 as Inactivo, v.FechaF as Fecha, v.FechaI as FechaE,1 as Req,' ' as Obs,'Poliza Seg.Tecnico' as Tipo From unidades p,polizassegauto v where p.Id<>0 and v.Id=p.IdPST and p.IdPST<>0 and (p.FechaBaja='0000-00-00' or DATEDIFF('".$fhoy. "',p.FechaBaja)<0) $wvtop";	
		$query4="SELECT p.*,0 as Inactivo, v.FechaF as Fecha, v.FechaI as FechaE,1 as Req,' ' as Obs,'Poliza Seg.RCC' as Tipo From unidades p,polizassegauto v where p.Id<>0 and v.Id=p.IdPSRCC and p.IdPSRCC<>0 and (p.FechaBaja='0000-00-00' or DATEDIFF('".$fhoy. "',p.FechaBaja)<0) $wvtop";	
		$query="$query1 UNION $query2 UNION $query3 UNION $query4  Order by Inactivo,Nombre,Tipo";
	}
	if($vto==999){//polizas
		$query2="SELECT p.*,0 as Inactivo, v.FechaF as Fecha, v.FechaI as FechaE,1 as Req,' ' as Obs,'Poliza Seg.Automotor' as Tipo From unidades p,polizassegauto v where p.Id<>0 and v.Id=p.IdPSA and p.IdPSA<>0 and (p.FechaBaja='0000-00-00' or DATEDIFF('".$fhoy. "',p.FechaBaja)<0) $wvtop";
		$query3="SELECT p.*,0 as Inactivo, v.FechaF as Fecha, v.FechaI as FechaE,1 as Req,' ' as Obs,'Poliza Seg.Tecnico' as Tipo From unidades p,polizassegauto v where p.Id<>0 and v.Id=p.IdPST and p.IdPST<>0 and (p.FechaBaja='0000-00-00' or DATEDIFF('".$fhoy. "',p.FechaBaja)<0) $wvtop";	
		$query4="SELECT p.*,0 as Inactivo, v.FechaF as Fecha, v.FechaI as FechaE,1 as Req,' ' as Obs,'Poliza Seg.RCC' as Tipo From unidades p,polizassegauto v where p.Id<>0 and v.Id=p.IdPSRCC and p.IdPSRCC<>0 and (p.FechaBaja='0000-00-00' or DATEDIFF('".$fhoy. "',p.FechaBaja)<0) $wvtop";	
		$query="$query2 UNION $query3 UNION $query4  Order by Inactivo,Nombre,Tipo";
	}
	if($vto!=0 and $vto!=999){//habilitacion
		$query1="SELECT p.*,v.Inactivo, v.Fecha, v.FechaE,v.Req,v.Obs,t.Nombre as Tipo From unidades p,unidadesvtos v,unidadesvtos_tipos t where p.Id<>0 and t.Id=v.IdTipo and v.IdEntidad=p.Id and (p.FechaBaja='0000-00-00' or DATEDIFF('".$fhoy. "',p.FechaBaja)<0)  and v.Inactivo=0 $wvto $wtipovto $wreq";
		$query="$query1 Order by Inactivo,Nombre,Tipo";
	}
	
	
	$_SESSION['TxtQuery']=$query;
	header("Location:../VencimientosU.php");
}



if (isset($_POST['CmdExcel'])){
	$query=$_POST['TxtQuery'];$query=str_replace("\\", "", $query);
	if ($query!=""){
		$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);$rs=mysql_query($query,$conn);
		if(mysql_num_rows($rs)!=0){	
			//Titulos excel
			include("../Codigo/ExcelHeader.php");	
			include("../Codigo/ExcelStyle.php");
			echo "<th>Id</th>\n";
			echo "<th>Nombre</th>\n";			
			echo "<th>Dominio</th>\n";
			echo "<th>Habilitaci&oacute;n</th>\n";
			echo "<th>Emisi&oacute;n</th>\n";
			echo "<th>Vencimiento</th>\n";
			echo "<th>Requerido</th>\n";
			echo "<th>Observaciones</th>\n";
			echo "<th>Inactivo</th>\n";
			echo "</tr>\n";	
			while($row=mysql_fetch_array($rs)){ 
				$femi= GLO_FormatoFecha($row['FechaE']);
				$fvto= GLO_FormatoFecha($row['Fecha']);
				if($row['Req']==0){$req='No';} else{$req='Si';}
				if ($row['Inactivo']==1){$inac="Inactivo";}else{$inac="";}	
				echo "<tr>\n";
				echo "<td align='right'>".str_pad($row['Id'], 6, "0", STR_PAD_LEFT)."</td>\n";
				echo '<td>'.GLO_textoExcel($row['Nombre'])."</td>\n";
				echo '<td>'.GLO_textoExcel($row['Dominio'])."</td>\n";
				echo '<td>'.GLO_textoExcel($row['Tipo'])."</td>\n";
				echo '<td>'.$femi."</td>\n";
				if ($fvto!="" and (strtotime(date("d-m-Y"))-strtotime($fvto))>0 and $row['Inactivo']==0)
				{echo "<td><font color=red>".$fvto."</font></td>\n";}else{echo '<td>'.$fvto."</td>\n";}
				echo '<td>'.$req."</td>\n";
				echo '<td>'.GLO_textoExcel($row['Obs'])."</td>\n";
				echo "<td >".$inac."</td>\n";
				echo "</tr>\n";			
			}	
			//Cierra tabla excel
			echo "</table>\n";				
		}	
		mysql_free_result($rs);	mysql_close($conn); 
	}
 }





?>