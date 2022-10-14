<? include("../Codigo/Seguridad.php") ; 





$tipo=intval($_POST['CbTipo']);
$cli=intval($_POST['CbCliente']);
if (empty($_POST['TxtFecha'])){$fecha="0000-00-00";}else{$fecha=FechaMySql($_POST['TxtFecha']);}	
$sec=intval($_POST['CbSector']);
$sec2=intval($_POST['CbSector2']);
$sec3=intval($_POST['CbSector3']);
$sec4=intval($_POST['CbSector4']);
$resp=intval($_POST['CbRespDet']);
$respext=mysql_real_escape_string($_POST['TxtRespDet']);
$norma1=intval($_POST['CbNorma1']);
$norma2=intval($_POST['CbNorma2']);
$norma3=intval($_POST['CbNorma3']);
$req1=intval($_POST['CbReq1']);
$req2=intval($_POST['CbReq2']);
$req3=intval($_POST['CbReq3']);
$req4=intval($_POST['CbReq4']);
$req5=intval($_POST['CbReq5']);
$req6=intval($_POST['CbReq6']);
$des=mysql_real_escape_string($_POST['TxtDescripcion']);	
$desai=mysql_real_escape_string($_POST['TxtDesAI']);
$rai=intval($_POST['CbPartAI']);									
$causa=mysql_real_escape_string($_POST['TxtCausa']);
$pcausa1=intval($_POST['CbPartCausa1']);
$pcausa2=intval($_POST['CbPartCausa2']);
$pcausa3=intval($_POST['CbPartCausa3']);
$pcausa4=intval($_POST['CbPartCausa4']);
$pcausa5=intval($_POST['CbPartCausa5']);
$pcausa6=intval($_POST['CbPartCausa6']);




//PARTE6
$accion=mysql_real_escape_string($_POST['TxtAccion']);
$raccion1=intval($_POST['CbRespAccion1']);
$raccion2=intval($_POST['CbRespAccion2']);
$raccion3=intval($_POST['CbRespAccion3']);
$raccion4=intval($_POST['CbRespAccion4']);
$raccion5=intval($_POST['CbRespAccion5']);
$raccion6=intval($_POST['CbRespAccion6']);
$otrosr=mysql_real_escape_string($_POST['TxtOtrosR']);	
$otrosrm=mysql_real_escape_string($_POST['TxtOtrosRM']);	
if (empty($_POST['TxtFPlazo'])){$fechapl="0000-00-00";}else{$fechapl=FechaMySql($_POST['TxtFPlazo']);}
if (empty($_POST['TxtFCumpl'])){$fechacpl="0000-00-00";}else{$fechacpl=FechaMySql($_POST['TxtFCumpl']);}


if (empty($_POST['TxtFPrevista'])){$fechap="0000-00-00";}else{$fechap=FechaMySql($_POST['TxtFPrevista']);}
if (empty($_POST['TxtFCierre'])){$fechac="0000-00-00";}else{$fechac=FechaMySql($_POST['TxtFCierre']);}
if (empty($_POST['TxtFechaAI'])){$fechaai="0000-00-00";}else{$fechaai=FechaMySql($_POST['TxtFechaAI']);}
$obs=mysql_real_escape_string($_POST['TxtObsVerif']);
$verif=intval($_POST['CbVerif']);
$nueva=intval($_POST['CbNuevaNC']);
$acc=intval($_POST['ChkAceptada']);
$otrosp=mysql_real_escape_string($_POST['TxtOtrosP']);	
$otrospm=mysql_real_escape_string($_POST['TxtOtrosPM']);	
//estado
$estado=1;
if($fechacpl=="0000-00-00" and $fechac=="0000-00-00" and $nueva==0){$estado=1;}//no se cumplio aun: abierto
if($fechacpl!="0000-00-00" and $fechac=="0000-00-00" and $nueva==0){$estado=2;}//se cumplio: cumplido
if($fechacpl!="0000-00-00" and $fechac!="0000-00-00" and $nueva==0){$estado=3;}//se cerr&oacute;: cerrado	
if($fechacpl=="0000-00-00" and $fechac!="0000-00-00" and $nueva==0){$estado=4;}//se cerr&oacute; incumplido: incumplido	
if($nueva!=0){$estado=5;}//si se adjunta una nueva NC ees reprogramada	


$tipoh=intval($_POST['CbTipoH']);	


$id=intval($_POST['TxtNumero']);			

?>