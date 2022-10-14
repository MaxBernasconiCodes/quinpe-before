<? 
//seguridad includes
if(!isset($_SESSION)){include("../../Codigo/SeguridadIncludes.php");}
else{include($_SESSION["NivelArbol"]."Codigo/SeguridadIncludes.php");}

$elem=intval($_POST['CbInstrumento']); 
$fabr=intval($_POST['CbFabr']); 

$nom=mysql_real_escape_string(ltrim($_POST['TxtNombre']));
$obs=mysql_real_escape_string($_POST['TxtObs']);
$mod=mysql_real_escape_string($_POST['TxtModelo']);
$nse=mysql_real_escape_string($_POST['TxtNSE']);
$lote=mysql_real_escape_string($_POST['TxtLote']);

$fechaf=GLO_FechaMySql($_POST['TxtFechaF']);	
$fechai=GLO_FechaMySql($_POST['TxtFechaI']);	
$fechav=GLO_FechaMySql($_POST['TxtFechaV']);	
$fechab=GLO_FechaMySql($_POST['TxtFechaB']);	

$id=intval($_POST['TxtNumero']);

//insert 1/update 2
if($tipocambio==1){
    $nroId=GLO_generoID('accesorios',$conn);
    $query="INSERT INTO accesorios (Id,Nombre,IdElemento,Modelo,NSE,Lote,Obs,Foto,IdFabricante,FechaBaja,FechaF,FechaI,FechaV) VALUES ($nroId,'$nom',$elem,'$mod','$nse','$lote','$obs','',$fabr,'$fechab','$fechaf','$fechai','$fechav')"; 
    $rs=mysql_query($query,$conn); 
    if ($rs){$grabook=1;}else{GLO_feedback(2);$grabook=0; } 
}else{
    $query="UPDATE accesorios set Nombre='$nom',IdElemento=$elem,Modelo='$mod',NSE='$nse',Lote='$lote',Obs='$obs',IdFabricante=$fabr,FechaBaja='$fechab',FechaF='$fechaf',FechaI='$fechai',FechaV='$fechav' Where Id=$id";
    $rs=mysql_query($query,$conn);
    if ($rs){GLO_feedback(1);}else{GLO_feedback(2);} 
}    



?>