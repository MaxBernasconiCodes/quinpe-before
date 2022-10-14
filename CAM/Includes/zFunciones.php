<? include($_SESSION["NivelArbol"]."Codigo/Seguridad.php");

function CAM_colorestado($idestado){
$colorest='';
if($idestado=='1'){$colorest='color:#ff9800';}//en proceso
if($idestado=='2'){$colorest='color:#0F9D58';}//aceptado
if($idestado=='3'){$colorest='color:#f44336';}//rechazado
if($idestado=='4'){$colorest='color:#0F9D58';}//no lleva
return $colorest;
}


function CAM_estadoitemingreso($iditem,&$idcam,&$idestado,&$estado,$conn){
$idcam=0;$idestado=0;$estado='';
$query="SELECT a.Id,a.IdE,e.Nombre FROM cam a,cam_est e Where a.IdE=e.Id and a.IdPE1IT=$iditem";$rs10=mysql_query($query,$conn);
$row10=mysql_fetch_array($rs10);
if(mysql_num_rows($rs10)!=0){$idcam=$row10['Id'];$idestado=$row10['IdE'];$estado=$row10['Nombre'];}mysql_free_result($rs10);

}
?>