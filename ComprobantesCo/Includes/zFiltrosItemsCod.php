<? if ($_SESSION["IdPerfilUser"]!=1 and $_SESSION["IdPerfilUser"]!=2 and  $_SESSION["IdPerfilUser"]!=3  and $_SESSION["IdPerfilUser"]!=4  and  $_SESSION["IdPerfilUser"]!=7 and  $_SESSION["IdPerfilUser"]!=9 and $_SESSION["IdPerfilUser"]!=14 and $_SESSION["IdPerfilUser"]!=11 and $_SESSION["IdPerfilUser"]!=12 and  $_SESSION["IdPerfilUser"]!=13){ header("Location:".$_SESSION["NivelArbol"]."Inicio.php");}



//criterios

$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);

$idcompr=intval($_POST['TxtNroEntidad']);

if (!(empty($_POST['TxtFechaD']))){$wfechad="and DATEDIFF(np.Fecha,'".FechaMySql($_POST['TxtFechaD'])."')>=0";}else{$wfechad="";}

if (!(empty($_POST['TxtFechaH']))){$wfechah="and DATEDIFF(np.Fecha,'".FechaMySql($_POST['TxtFechaH'])."')<=0";}else{$wfechah="";}

$nro=intval($_POST['TxtNroInterno']);if($nro!=0){$wnro="and np.Id=$nro";}else{$wnro="";}

$nroped=intval($_POST['TxtNroPedido']);if($nroped!=0){$wnroped="and np.Nro=$nroped";}else{$wnroped="";}

$uni=intval($_POST['CbUnidad']);if($uni!=0){$wuni="and np.IdUnidad=$uni";}else{$wuni="";}

$prov=intval($_POST['CbProv']);if($prov!=0){$wprov="and npi.IdProv=$prov";}else{$wprov="";}

$soli=intval($_POST['CbSoli']);if($soli!=0){$wsoli="and np.IdPerSoli=$soli";}else{$wsoli="";}

if (!(empty($_POST['TxtBusqueda']))){$wnom="and (a.Nombre Like '%".mysql_real_escape_string($_POST['TxtBusqueda'])."%')";}else{$wnom="";}

//sin articulo encontrado, con obs item

$sinart=intval($_POST['ChkSA']);if($sinart!=0){$wsinart="and npi.IdArticulo=0";}else{$wsinart="";}

mysql_close($conn);	

$where=$wfechad.' '.$wfechah.' '.$wnro.' '.$wuni.' '.$wnom.' '.$wprov.' '.$wsoli.' '.$wnroped.' '.$wsinart;

?>