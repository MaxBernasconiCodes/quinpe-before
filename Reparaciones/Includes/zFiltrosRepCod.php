<? 
//seguridad includes
if(!isset($_SESSION)){include("../../Codigo/SeguridadIncludes.php");}
else{include($_SESSION["NivelArbol"]."Codigo/SeguridadIncludes.php");}



//where 

$wbuscar="";

if (!(empty($_POST['TxtFechaD']))){$wbuscar=$wbuscar." and DATEDIFF(r.Fecha,'".FechaMySql($_POST['TxtFechaD'])."')>=0";}

if (!(empty($_POST['TxtFechaH']))){$wbuscar=$wbuscar." and DATEDIFF(r.Fecha,'".FechaMySql($_POST['TxtFechaH'])."')<=0";}

$vbuscar=intval($_POST['CbEstado']);if($vbuscar!=0){$wbuscar=$wbuscar." and r.IdEstado=$vbuscar";}

$vbuscar=intval($_POST['TxtNroOR']);if($vbuscar!=0){$wbuscar=$wbuscar." and r.Id=$vbuscar";}	

$vbuscar=intval($_POST['ChkSSoli']);if($vbuscar!=0){$wbuscar=$wbuscar." and r.IdSoli=0";}	

$vbuscar=intval($_POST['CbUnidad']);if($vbuscar!=0){$wbuscar=$wbuscar." and r.IdUnidad=$vbuscar";}

$vbuscar=intval($_POST['CbSector']);if($vbuscar!=0){$wbuscar=$wbuscar." and r.IdSector=$vbuscar";}

$vbuscar=intval($_POST['CbInstrumento']);if($vbuscar!=0){$wbuscar=$wbuscar." and r.IdInstr=$vbuscar";}



?>