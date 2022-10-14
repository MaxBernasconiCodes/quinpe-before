<? include("Codigo/Seguridad.php") ; include("Codigo/Config.php") ;include("Codigo/Funciones.php") ;$_SESSION["NivelArbol"]="";

//perfiles 
if ($_SESSION["IdPerfilUser"]!=1 and $_SESSION["IdPerfilUser"]!=2 and $_SESSION["IdPerfilUser"]!=3  and  $_SESSION["IdPerfilUser"]!=4 and $_SESSION["IdPerfilUser"]!=7 and $_SESSION["IdPerfilUser"]!=9 and $_SESSION["IdPerfilUser"]!=11  and $_SESSION["IdPerfilUser"]!=14){ header("Location:".$_SESSION["NivelArbol"]."Inicio.php");}


$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);




function TablaVtosUnidades($conn){
	//vtos hoy o dentro de una semana + vencidos	
	$fhoy=FechaMySql(date("d-m-Y"));
	$fhoym14=date("Y-m-d", strtotime("$fhoy +14 day"));
	//habilitaciones
	$query1="SELECT p.Id,p.Nombre,p.Dominio, v.Fecha, t.Nombre as TipoV From unidades p,unidadesvtos v,unidadesvtos_tipos t where p.Id<>0 and t.Id=v.IdTipo and v.IdEntidad=p.Id and v.Inactivo=0 and (p.FechaBaja='0000-00-00' or DATEDIFF('".$fhoy. "',p.FechaBaja)<0) and (DATEDIFF('".$fhoym14. "',v.Fecha)>0)";
	//Poliza Seg.Automotor
	$query2="SELECT p.Id,p.Nombre,p.Dominio, v.FechaF as Fecha, 'POLIZA SEG.AUTOMOTOR' as TipoV From unidades p,polizassegauto v where p.Id<>0 and v.Id=p.IdPSA and p.IdPSA<>0 and (p.FechaBaja='0000-00-00' or DATEDIFF('".$fhoy. "',p.FechaBaja)<0) and (DATEDIFF('".$fhoym14. "',v.FechaF)>0) ";
	//Poliza Seg.Tecnico
	$query3="SELECT p.Id,p.Nombre,p.Dominio, v.FechaF as Fecha, 'POLIZA SEG.TECNICO' as TipoV From unidades p,polizassegauto v where p.Id<>0 and v.Id=p.IdPST and p.IdPST<>0 and (p.FechaBaja='0000-00-00' or DATEDIFF('".$fhoy. "',p.FechaBaja)<0) and (DATEDIFF('".$fhoym14. "',v.FechaF)>0)";
	//Poliza Seg.RCC
	$query4="SELECT p.Id,p.Nombre,p.Dominio, v.FechaF as Fecha, 'POLIZA SEG.RCC' as TipoV From unidades p,polizassegauto v where p.Id<>0 and v.Id=p.IdPSRCC and p.IdPSRCC<>0 and (p.FechaBaja='0000-00-00' or DATEDIFF('".$fhoy. "',p.FechaBaja)<0) and (DATEDIFF('".$fhoym14. "',v.FechaF)>0)";
	//todo	
	$query="$query1 UNION $query2 UNION $query3 UNION $query4  Order by Fecha";	$rs=mysql_query($query,$conn);
	if(mysql_num_rows($rs)!=0){	
		//titulo
		echo '<table width="600" border="0"   cellspacing="0" class="TablaFondo tablanotif">
		<tr> <td align="center" class="titulonotif" colspan="6">Habilitaciones Unidades</td></tr>
		<tr> <td height="3" width="10"></td><td class="bordenotif" width="190"></td><td class="bordenotif" width="100"></td><td class="bordenotif" width="200"></td><td class="bordenotif" width="90"></td><td width="10"></td></tr>
		<tr> <td height="3" colspan="6"></td></tr>';
		while($row=mysql_fetch_array($rs)){ 
			GLO_LinkRowTablaInit($estilo,$link,$row['Id'],1);
			$fvto= GLO_FormatoFecha($row['Fecha']);
			if ((strtotime(date("d-m-Y"))-strtotime($fvto))>0){$estiloc=' TRed';}else{$estiloc='';}
			echo '<tr'.$estilo.'><td></td><td class="entrynotif"'.$link.'>&nbsp;'.substr($row['Nombre'],0,20).'</td><td class="entrynotif"'.$link.'>'.substr($row['Dominio'],0,12).'</td><td class="entrynotif"'.$link.'>'.substr($row['TipoV'],0,24).'</td><td class="entrynotif'.$estiloc.'"'.$link.'>'.$fvto.'</td><td></td></tr>';
		}mysql_free_result($rs);
		//help
		echo '<tr><td></td><td class="comentario" colspan="5">&nbsp;Habilitaciones activas <font class="comentario2">vencidas</font>, o que vencen dentro de los proximos 14 dias</td></tr>';
		//cierra
		echo '</table>';
	}
}


function TablaVtosPersonal($conn){
	//vtos hoy o dentro de una semana + vencidos
	$fhoy=FechaMySql(date("d-m-Y"));
	$fhoym14=date("Y-m-d", strtotime("$fhoy +14 day"));
	//habilitaciones
	$query="SELECT p.Id,p.Apellido,p.Nombre,v.Fecha,t.Nombre as Tipo From personal p,personalvtos v,personalvtos_tipos t  where p.Id<>0 and t.Id=v.IdTipo and v.IdEntidad=p.Id and v.Inactivo=0 and (p.FechaBaja='0000-00-00' or DATEDIFF('".$fhoy. "',p.FechaBaja)<0) and (DATEDIFF('".$fhoym14. "',v.Fecha)>0) Order by v.Fecha";
	$rs=mysql_query($query,$conn);
	if(mysql_num_rows($rs)!=0){	
		echo '<table width="600" border="0"   cellspacing="0" class="TablaFondo tablanotif">	
		<tr> <td align="center" class="titulonotif" colspan="6">Habilitaciones Personal</td></tr>
		<tr> <td height="3" width="10"></td><td class="bordenotif" width="190"></td><td class="bordenotif" width="100"></td><td class="bordenotif" width="200"></td><td class="bordenotif" width="90"></td><td width="10"></td></tr>
		<tr> <td height="3" colspan="6"></td></tr>';
		while($row=mysql_fetch_array($rs)){ 
			GLO_LinkRowTablaInit($estilo,$link,$row['Id'],2);
			$fvto= GLO_FormatoFecha($row['Fecha']);
			if ((strtotime(date("d-m-Y"))-strtotime($fvto))>0){$estiloc=' TRed';}else{$estiloc='';}
			echo '<tr'.$estilo.'><td></td><td class="entrynotif"'.$link.'>&nbsp;'.substr($row['Apellido'],0,20).'</td><td class="entrynotif"'.$link.'>'.substr($row['Nombre'],0,12).'</td><td class="entrynotif"'.$link.'>'.substr($row['Tipo'],0,24).'</td><td class="entrynotif'.$estiloc.'"'.$link.'>'.$fvto.'</td><td></td></tr>';
		}mysql_free_result($rs);
		//help
		echo '<tr><td></td><td class="comentario" colspan="5">&nbsp;Habilitaciones activas <font class="comentario2">vencidas</font>, o que vencen dentro de los proximos 14 dias</td></tr>';
		//cierra
		echo '</table>';
	}
}


function TablaVtosArticulos($conn){
	//vtos hoy o dentro de una semana + vencidos	
	$fhoy=FechaMySql(date("d-m-Y"));
	$fhoym14=date("Y-m-d", strtotime("$fhoy +14 day"));
	//habilitaciones
	$query="SELECT p.Id,p.Nombre,p.FechaV From epparticulos p  where p.Id<>0 and (p.FechaBaja='0000-00-00' or DATEDIFF('".$fhoy. "',p.FechaBaja)<0) and (DATEDIFF('".$fhoym14. "',p.FechaV)>0) Order by p.FechaV";
	$rs=mysql_query($query,$conn);
	if(mysql_num_rows($rs)!=0){	
		echo '<table width="600" border="0"   cellspacing="0" class="TablaFondo tablanotif">	
		<tr> <td align="center" class="titulonotif" colspan="6">Vencimientos Articulos</td></tr>
		<tr> <td height="3" width="10"></td><td class="bordenotif" width="190"></td><td class="bordenotif" width="100"></td><td class="bordenotif" width="200"></td><td class="bordenotif" width="90"></td><td width="10"></td></tr>
		<tr> <td height="3" colspan="6"></td></tr>';
		while($row=mysql_fetch_array($rs)){ 
			GLO_LinkRowTablaInit($estilo,$link,$row['Id'],3);
			$fvto= GLO_FormatoFecha($row['FechaV']);
			if ((strtotime(date("d-m-Y"))-strtotime($fvto))>0){$estiloc=' TRed';}else{$estiloc='';}
			echo '<tr'.$estilo.'><td></td><td class="entrynotif" colspan="3"'.$link.'>&nbsp;'.substr($row['Nombre'],0,46).'</td><td class="entrynotif'.$estiloc.'"'.$link.'>'.$fvto.'</td><td></td></tr>';
		}mysql_free_result($rs);
		//help
		echo '<tr><td></td><td class="comentario" colspan="5">&nbsp;Articulos que <font class="comentario2">vencen</font> dentro de los proximos 14 dias</td></tr>';
		//cierra
		echo '</table>';
	}
}

function TablaVtosAccesoriosA($conn){
	//vtos hoy o dentro de una semana + vencidos	
	$fhoy=FechaMySql(date("d-m-Y"));
	$fhoym14=date("Y-m-d", strtotime("$fhoy +14 day"));
	//habilitaciones
	$query="SELECT p.Id,p.FechaE,a.Nombre From accesorios a,accesorios_asig p where p.Id<>0 and p.IdInstrumento=a.Id and p.FechaH='0000-00-00' and p.FechaE<>'0000-00-00' and DATEDIFF('".$fhoym14. "',p.FechaE)>0 Order by p.FechaE";
	$rs=mysql_query($query,$conn);
	if(mysql_num_rows($rs)!=0){	
		echo '<table width="600" border="0"   cellspacing="0" class="TablaFondo tablanotif">	
		<tr> <td align="center" class="titulonotif" colspan="6">Entregas pactadas Accesorios</td></tr>
		<tr> <td height="3" width="10"></td><td class="bordenotif" width="190"></td><td class="bordenotif" width="100"></td><td class="bordenotif" width="200"></td><td class="bordenotif" width="90"></td><td width="10"></td></tr>
		<tr> <td height="3" colspan="6"></td></tr>';
		while($row=mysql_fetch_array($rs)){ 
			GLO_LinkRowTablaInit($estilo,$link,$row['Id'],4);
			$fvto= GLO_FormatoFecha($row['FechaE']);
			if ((strtotime(date("d-m-Y"))-strtotime($fvto))>0){$estiloc=' TRed';}else{$estiloc='';}
			echo '<tr'.$estilo.'><td></td><td class="entrynotif" colspan="3"'.$link.'>&nbsp;'.substr($row['Nombre'],0,46).'</td><td class="entrynotif'.$estiloc.'"'.$link.'>'.$fvto.'</td><td></td></tr>';
		}mysql_free_result($rs);
		//help
		echo '<tr><td></td><td class="comentario" colspan="5">&nbsp;Entregas <font class="comentario2">pactadas</font> dentro de los proximos 14 dias</td></tr>';
		//cierra
		echo '</table>';
	}
}

function TablaVtosInstrumentosA($conn){
	//vtos hoy o dentro de una semana + vencidos	
	$fhoy=FechaMySql(date("d-m-Y"));
	$fhoym14=date("Y-m-d", strtotime("$fhoy +14 day"));
	//habilitaciones
	$query="SELECT p.Id,p.FechaE,a.Nombre From epparticulos a,instrumentosasig p where p.Id<>0 and p.IdInstrumento=a.Id and p.FechaH='0000-00-00' and p.FechaE<>'0000-00-00' and DATEDIFF('".$fhoym14. "',p.FechaE)>0 Order by p.FechaE";
	$rs=mysql_query($query,$conn);
	if(mysql_num_rows($rs)!=0){	
		echo '<table width="600" border="0"   cellspacing="0" class="TablaFondo tablanotif">	
		<tr> <td align="center" class="titulonotif" colspan="6">Entregas pactadas Articulos</td></tr>
		<tr> <td height="3" width="10"></td><td class="bordenotif" width="190"></td><td class="bordenotif" width="100"></td><td class="bordenotif" width="200"></td><td class="bordenotif" width="90"></td><td width="10"></td></tr>
		<tr> <td height="3" colspan="6"></td></tr>';
		while($row=mysql_fetch_array($rs)){ 
			GLO_LinkRowTablaInit($estilo,$link,$row['Id'],5);
			$fvto= GLO_FormatoFecha($row['FechaE']);
			if ((strtotime(date("d-m-Y"))-strtotime($fvto))>0){$estiloc=' TRed';}else{$estiloc='';}
			echo '<tr'.$estilo.'><td></td><td class="entrynotif" colspan="3"'.$link.'>&nbsp;'.substr($row['Nombre'],0,46).'</td><td class="entrynotif'.$estiloc.'"'.$link.'>'.$fvto.'</td><td></td></tr>';
		}mysql_free_result($rs);
		//help
		echo '<tr><td></td><td class="comentario" colspan="5">&nbsp;Entregas <font class="comentario2">pactadas</font> dentro de los proximos 14 dias</td></tr>';
		//cierra
		echo '</table>';
	}
}


function TablaVtosAccesoriosC($conn){
	//vtos hoy o dentro de una semana + vencidos	
	$fhoy=FechaMySql(date("d-m-Y"));
	$fhoym14=date("Y-m-d", strtotime("$fhoy +14 day"));
	//habilitaciones
	$query="SELECT p.Id,p.FechaReal,a.Nombre From accesorios a,accesorios_prog p where p.Id<>0 and p.IdInstrumento=a.Id  and p.FechaReal<>'0000-00-00' and DATEDIFF('".$fhoym14. "',p.FechaReal)>0 Order by p.FechaReal";
	$rs=mysql_query($query,$conn);
	if(mysql_num_rows($rs)!=0){	
		echo '<table width="600" border="0"   cellspacing="0" class="TablaFondo tablanotif">	
		<tr> <td align="center" class="titulonotif" colspan="6">Vencimientos Certificaciones Accesorios</td></tr>
		<tr> <td height="3" width="10"></td><td class="bordenotif" width="190"></td><td class="bordenotif" width="100"></td><td class="bordenotif" width="200"></td><td class="bordenotif" width="90"></td><td width="10"></td></tr>
		<tr> <td height="3" colspan="6"></td></tr>';
		while($row=mysql_fetch_array($rs)){ 
			GLO_LinkRowTablaInit($estilo,$link,$row['Id'],7);
			$fvto= GLO_FormatoFecha($row['FechaReal']);
			if ((strtotime(date("d-m-Y"))-strtotime($fvto))>0){$estiloc=' TRed';}else{$estiloc='';}
			echo '<tr'.$estilo.'><td></td><td class="entrynotif" colspan="3"'.$link.'>&nbsp;'.substr($row['Nombre'],0,46).'</td><td class="entrynotif'.$estiloc.'"'.$link.'>'.$fvto.'</td><td></td></tr>';
		}mysql_free_result($rs);
		//help
		echo '<tr><td></td><td class="comentario" colspan="5">&nbsp;Certificaciones que <font class="comentario2">vencen</font> dentro de los proximos 14 dias</td></tr>';
		//cierra
		echo '</table>';
	}
}

function TablaVtosInstrumentosC($conn){
	//vtos hoy o dentro de una semana + vencidos	
	$fhoy=FechaMySql(date("d-m-Y"));
	$fhoym14=date("Y-m-d", strtotime("$fhoy +14 day"));
	//habilitaciones
	$query="SELECT p.Id,p.FechaReal,a.Nombre From epparticulos a,instrumentosprog p where p.Id<>0 and p.IdInstrumento=a.Id  and p.FechaReal<>'0000-00-00' and DATEDIFF('".$fhoym14. "',p.FechaReal)>0 Order by p.FechaReal";
	$rs=mysql_query($query,$conn);
	if(mysql_num_rows($rs)!=0){	
		echo '<table width="600" border="0"   cellspacing="0" class="TablaFondo tablanotif">	
		<tr> <td align="center" class="titulonotif" colspan="6">Vencimientos Certificaciones Articulos</td></tr>
		<tr> <td height="3" width="10"></td><td class="bordenotif" width="190"></td><td class="bordenotif" width="100"></td><td class="bordenotif" width="200"></td><td class="bordenotif" width="90"></td><td width="10"></td></tr>
		<tr> <td height="3" colspan="6"></td></tr>';
		while($row=mysql_fetch_array($rs)){ 
			GLO_LinkRowTablaInit($estilo,$link,$row['Id'],8);
			$fvto= GLO_FormatoFecha($row['FechaReal']);
			if ((strtotime(date("d-m-Y"))-strtotime($fvto))>0){$estiloc=' TRed';}else{$estiloc='';}
			echo '<tr'.$estilo.'><td></td><td class="entrynotif" colspan="3"'.$link.'>&nbsp;'.substr($row['Nombre'],0,46).'</td><td class="entrynotif'.$estiloc.'"'.$link.'>'.$fvto.'</td><td></td></tr>';
		}mysql_free_result($rs);
		//help
		echo '<tr><td></td><td class="comentario" colspan="5">&nbsp;Certificaciones que <font class="comentario2">vencen</font> dentro de los proximos 14 dias</td></tr>';
		//cierra
		echo '</table>';
	}
}


GLO_InitHTML($_SESSION["NivelArbol"],'','BannerPopUp','Intranet/zNotificaciones',0,0,0,0); 
GLO_tituloypath(950,600,'InicioIntranet.php','','linksalir');

echo '<table width="600" border="0" cellspacing="0" valign="top"><tr><td>';
	//personal
	if ($_SESSION["IdPerfilUser"]==1 or $_SESSION["IdPerfilUser"]==2 or $_SESSION["IdPerfilUser"]==3 or $_SESSION["IdPerfilUser"]==11){
		TablaVtosPersonal($conn);
		echo '</td></tr><tr><td height="20"></td></tr><tr><td>';
	}
	//unidades
	if ($_SESSION["IdPerfilUser"]==1 or $_SESSION["IdPerfilUser"]==2 or $_SESSION["IdPerfilUser"]==3 or $_SESSION["IdPerfilUser"]==4   or $_SESSION["IdPerfilUser"]==7 or $_SESSION["IdPerfilUser"]==9 or $_SESSION["IdPerfilUser"]==11 or $_SESSION["IdPerfilUser"]==14){
		TablaVtosUnidades($conn);
		echo '</td></tr><tr><td height="20"></td></tr><tr><td>';
	}
	//articulos vtos
	if ($_SESSION["IdPerfilUser"]==1 or $_SESSION["IdPerfilUser"]==2 or $_SESSION["IdPerfilUser"]==11 or $_SESSION["IdPerfilUser"]==14){
		TablaVtosArticulos($conn);
		echo '</td></tr><tr><td height="20"></td></tr><tr><td>';
	}
	//accesorios asignaciones
	if ($_SESSION["IdPerfilUser"]==1 or $_SESSION["IdPerfilUser"]==2 or $_SESSION["IdPerfilUser"]==3 or $_SESSION["IdPerfilUser"]==4   or $_SESSION["IdPerfilUser"]==7 or $_SESSION["IdPerfilUser"]==9 or $_SESSION["IdPerfilUser"]==11 or $_SESSION["IdPerfilUser"]==14){
		TablaVtosAccesoriosA($conn);
		echo '</td></tr><tr><td height="20"></td></tr><tr><td>';
	}
	//instrumentos asignaciones
	if ($_SESSION["IdPerfilUser"]==1 or $_SESSION["IdPerfilUser"]==2 or $_SESSION["IdPerfilUser"]==3 or $_SESSION["IdPerfilUser"]==4   or $_SESSION["IdPerfilUser"]==7 or $_SESSION["IdPerfilUser"]==9 or $_SESSION["IdPerfilUser"]==11 or $_SESSION["IdPerfilUser"]==14){
		TablaVtosInstrumentosA($conn);
		echo '</td></tr><tr><td height="20"></td></tr><tr><td>';
	}
	/*
	//accesorios certificaciones
	if ($_SESSION["IdPerfilUser"]==1 or $_SESSION["IdPerfilUser"]==2 or $_SESSION["IdPerfilUser"]==3 or $_SESSION["IdPerfilUser"]==4   or $_SESSION["IdPerfilUser"]==7 or $_SESSION["IdPerfilUser"]==9 or $_SESSION["IdPerfilUser"]==11 or $_SESSION["IdPerfilUser"]==14){
		TablaVtosAccesoriosC($conn);
		echo '</td></tr><tr><td height="20"></td></tr><tr><td>';
	}
	//instrumentos certificaciones
	if ($_SESSION["IdPerfilUser"]==1 or $_SESSION["IdPerfilUser"]==2 or $_SESSION["IdPerfilUser"]==3 or $_SESSION["IdPerfilUser"]==4   or $_SESSION["IdPerfilUser"]==7 or $_SESSION["IdPerfilUser"]==9 or $_SESSION["IdPerfilUser"]==11 or $_SESSION["IdPerfilUser"]==14){
		TablaVtosInstrumentosC($conn);
		echo '</td></tr><tr><td height="20"></td></tr><tr><td>';
	}
	*/
echo '</td></tr></table>';

GLO_Hidden('TxtId',0);
GLO_cierratablaform(); 
mysql_close($conn); 
include ("Codigo/FooterConUsuario.php");
?>