<? include("Codigo/Seguridad.php") ; include("Codigo/Config.php") ;include("Codigo/Funciones.php") ;$_SESSION["NivelArbol"]="";

//perfiles
if ($_SESSION["IdPerfilUser"]!=1 and $_SESSION["IdPerfilUser"]!=2 and $_SESSION["IdPerfilUser"]!=3 and $_SESSION["IdPerfilUser"]!=4  and $_SESSION["IdPerfilUser"]!=7 and $_SESSION["IdPerfilUser"]!=9 and $_SESSION["IdPerfilUser"]!=14 and $_SESSION["IdPerfilUser"]!=10 and $_SESSION["IdPerfilUser"]!=11){ header("Location:".$_SESSION["NivelArbol"]."Inicio.php");}



$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);


function TablaMinutas($conn){//tareas pendientes minutas reunion
	$idpers=intval($_SESSION["GLO_IdPersLog"]);
	$query="Select m.Id,m.Fecha,m.Nombre,p.Obs From iso_minutas_pd p,iso_minutas m Where p.Id<>0 and p.IdPersonal<>0 and p.Estado=0 and p.IdMin=m.Id and p.IdPersonal=$idpers Order by m.Fecha";
	$rs=mysql_query($query,$conn);
	if(mysql_num_rows($rs)!=0){	
		echo '<table width="750" border="0"   cellspacing="0" class="TablaFondo tablanotif TMT2">
		<tr> <td align="center" class="titulonotif" colspan="4">Actividades Pendientes Minutas Reunion</td></tr>
		<tr> <td height="3" width="10"></td><td class="bordenotif" width="80"></td><td class="bordenotif" width="200"></td><td class="bordenotif" width="450"></td><td width="10"></td></tr>
		<tr> <td height="3" colspan="6"></td></tr>';
		$estilo=" style='cursor:pointer;'";
		while($row=mysql_fetch_array($rs)){ 
			$link=" onclick="."location='ISOMinutas/Modificar.php?Flag1=True&id=".$row['Id']."'";
			echo '<tr'.$estilo.'><td></td><td class="entrynotif'.'"'.$link.'>'.GLO_FormatoFecha($row['Fecha']).'</td><td class="entrynotif"'.$link.'>&nbsp;'.substr($row['Nombre'],0,24).'</td><td class="entrynotif"'.$link.'>&nbsp;'.substr($row['Obs'],0,54).'</td><td></td></tr>';
		}mysql_free_result($rs);
		echo '</table>';
	}
}


function TablaCOAutoPreAuto($conn){//pedidos para autorizar/preautorizar
	$idpers=intval($_SESSION["GLO_IdPersLog"]);
	$query="Select distinct np.Id,np.Fecha,np.Titulo From co_npedido np,co_npedido_it npi Where np.Id<>0  and np.Id=npi.IdNP and ((np.IdPerPAuto=$idpers and npi.IdEstado=1) or (np.IdPerAuto=$idpers and (npi.IdEstado=2 or npi.IdEstado=1))) Order by np.Id";
	$rs=mysql_query($query,$conn);
	if(mysql_num_rows($rs)!=0){	
		echo '<table width="750" border="0"   cellspacing="0" class="TablaFondo tablanotif TMT2">
		<tr> <td align="center" class="titulonotif" colspan="4">Pedidos Pendientes para Autorizar</td></tr>
		<tr> <td height="3" width="10"></td><td class="bordenotif" width="80"></td><td class="bordenotif" width="110"></td><td class="bordenotif" width="540"></td><td width="10"></td></tr>
		<tr> <td height="3" colspan="6"></td></tr>';
		$estilo=" style='cursor:pointer;'";
		while($row=mysql_fetch_array($rs)){ 
			$link=" onclick="."location='ComprobantesCo/ModificarNotaPedido.php?Flag1=True&id=".$row['Id']."'";
			echo '<tr'.$estilo.'><td></td><td class="entrynotif'.'"'.$link.'>'.GLO_FormatoFecha($row['Fecha']).'</td><td class="entrynotif'.'"'.$link.'>'.str_pad($row['Id'], 6, "0", STR_PAD_LEFT).'</td><td class="entrynotif"'.$link.'>&nbsp;'.substr($row['Titulo'],0,70).'</td><td></td></tr>';
		}mysql_free_result($rs);
		echo '</table>';
	}
}


function TablaISODocCON($conn){//documentos para controlar
	$idpers=intval($_SESSION["GLO_IdPersLog"]);
	if($_SESSION["GLO_IdPersCON"]==$idpers){
		$query="Select Id,Codigo,Nombre,FechaCRE From iso_doc Where Id<>0 and (IdEstado=1 or IdEstado=5) Order by Id";
		$rs=mysql_query($query,$conn);
		if(mysql_num_rows($rs)!=0){	
			echo '<table width="750" border="0"   cellspacing="0" class="TablaFondo tablanotif TMT2">
			<tr> <td align="center" class="titulonotif" colspan="4">Documentos Pendientes para Controlar</td></tr>
			<tr> <td height="3" width="10"></td><td class="bordenotif" width="80"></td><td class="bordenotif" width="110"></td><td class="bordenotif" width="540"></td><td width="10"></td></tr>
			<tr> <td height="3" colspan="6"></td></tr>';
			$estilo=" style='cursor:pointer;'";
			while($row=mysql_fetch_array($rs)){ 
				$link=" onclick="."location='ISODoc/Modificar.php?Flag1=True&id=".$row['Id']."'";
				echo '<tr'.$estilo.'><td></td><td class="entrynotif'.'"'.$link.'>'.GLO_FormatoFecha($row['FechaCRE']).'</td><td class="entrynotif'.'"'.$link.'>'.substr($row['Codigo'],0,15).'</td><td class="entrynotif"'.$link.'>&nbsp;'.substr($row['Nombre'],0,70).'</td><td></td></tr>';
			}mysql_free_result($rs);
			echo '</table>';
		}
	}
}


function TablaISODocAPR($conn){//documentos para controlar
	$idpers=intval($_SESSION["GLO_IdPersLog"]);
	if($_SESSION["GLO_IdPersAPR"]==$idpers){
		$query="Select Id,Codigo,Nombre,FechaCRE From iso_doc Where Id<>0 and (IdEstado=2) Order by Id";
		$rs=mysql_query($query,$conn);
		if(mysql_num_rows($rs)!=0){	
			echo '<table width="750" border="0"   cellspacing="0" class="TablaFondo tablanotif TMT2">
			<tr> <td align="center" class="titulonotif" colspan="4">Documentos Pendientes para Aprobar</td></tr>
			<tr> <td height="3" width="10"></td><td class="bordenotif" width="80"></td><td class="bordenotif" width="110"></td><td class="bordenotif" width="540"></td><td width="10"></td></tr>
			<tr> <td height="3" colspan="6"></td></tr>';
			$estilo=" style='cursor:pointer;'";
			while($row=mysql_fetch_array($rs)){ 
				$link=" onclick="."location='ISODoc/Modificar.php?Flag1=True&id=".$row['Id']."'";
				echo '<tr'.$estilo.'><td></td><td class="entrynotif'.'"'.$link.'>'.GLO_FormatoFecha($row['FechaCRE']).'</td><td class="entrynotif'.'"'.$link.'>'.substr($row['Codigo'],0,15).'</td><td class="entrynotif"'.$link.'>&nbsp;'.substr($row['Nombre'],0,70).'</td><td></td></tr>';
			}mysql_free_result($rs);
			echo '</table>';
		}
	}
}



GLO_InitHTML($_SESSION["NivelArbol"],'','BannerPopUp','',0,0,0,0); 
GLO_tituloypath(0,750,'InicioIntranet.php','','linksalir');


echo '<table width="750" border="0" cellspacing="0" valign="top"><tr><td>';
//pedidos
if ($_SESSION["IdPerfilUser"]==1 or $_SESSION["IdPerfilUser"]==2 or $_SESSION["IdPerfilUser"]==3 or $_SESSION["IdPerfilUser"]==4   or $_SESSION["IdPerfilUser"]==7 or $_SESSION["IdPerfilUser"]==9 or $_SESSION["IdPerfilUser"]==11 or $_SESSION["IdPerfilUser"]==14){
	TablaCOAutoPreAuto($conn);
}
//minutas y docs
if ($_SESSION["IdPerfilUser"]==1 or $_SESSION["IdPerfilUser"]==2 or $_SESSION["IdPerfilUser"]==3 or $_SESSION["IdPerfilUser"]==4   or $_SESSION["IdPerfilUser"]==7 or $_SESSION["IdPerfilUser"]==9 or $_SESSION["IdPerfilUser"]==10 or $_SESSION["IdPerfilUser"]==11 or $_SESSION["IdPerfilUser"]==14){
	TablaISODocCON($conn);
	TablaISODocAPR($conn);
	TablaMinutas($conn);
}
echo '</td></tr></table>';


GLO_cierratablaform(); 
mysql_close($conn); 
include ("Codigo/FooterConUsuario.php");
?>