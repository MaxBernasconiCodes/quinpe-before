<? include("../Codigo/Seguridad.php");include("../Codigo/Config.php");include("../Codigo/Funciones.php");$_SESSION["NivelArbol"]="../";
require_once('../Codigo/calendar/classes/tc_calendar.php');include("../Procesos/Includes/zFunciones.php") ;include("../CAM/Includes/zFunciones.php");include("Includes/zFunciones.php") ;
//perfiles
GLO_PerfilAcceso(13);

//get
GLO_ValidaGET($_GET['id'],0,0);
$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);

if ($_GET['Flag1']=="True"){
	$query="SELECT m.*,p.IdCliente,a.Rto,a.Etapa,a.Retorno From procesosop_e1_it m,procesosop_e1 a,procesosop p where m.IdPadre=a.Id and a.IdPadre=p.Id and m.Id=".intval($_GET['id']);
	$rs=mysql_query($query,$conn);$row=mysql_fetch_array($rs);
	if(mysql_num_rows($rs)!=0){
		$_SESSION['CbCliente']=$row['IdCliente'];
		$_SESSION['TxtRto'] = $row['Rto'];
		//0:ingreso,1:salida
		if($row['Etapa']==0){$_SESSION['CbEtapa']=1;}else{$_SESSION['CbEtapa']=2;}
		//
		$_SESSION['TxtNumero'] = $row['Id'];
		$_SESSION['TxtNroEntidad'] = $row['IdPadre'];
		$_SESSION['CbItem'] =  $row['IdIC'];	
		$_SESSION['CbUnidad'] = $row['IdU'];	
		$_SESSION['TxtRes'] =$row['Cant'];	
		$_SESSION['TxtVal'] =$row['Lote'];
		$_SESSION['CbEnv']=$row['IdEnv'];
		$_SESSION['TxtCant'] =$row['CantI'];
		$_SESSION['TxtBultos'] =$row['Bultos'];
		$_SESSION['TxtObs'] =$row['Destino'];
		$_SESSION['ChkRE'] = $row['Retorno'];//ingreso+propio
	}mysql_free_result($rs);
}

//ingreso/salida
if($_SESSION['CbEtapa']==1){$nometapa='INGRESO';}else{$nometapa='EGRESO';}

//retorno ingreso + propio
if($_SESSION['ChkRE']==1 and $_SESSION['CbEtapa']==1){
	$retorno='<label style="border: none;color:#f44336;">Retorno</label>';
}else{$retorno='';}

//busco si hay cam asociado
$existecam=0;
$query="SELECT a.Id From cam a where a.IdPE1IT=".intval($_SESSION['TxtNumero']);
$rs=mysql_query($query,$conn);$row=mysql_fetch_array($rs);
if(mysql_num_rows($rs)!=0){$existecam=$row['Id'];}mysql_free_result($rs);


function TablaLab2($idpadre,$conn){
	$idpadre=intval($idpadre);
	$query="SELECT a.*,e.Nombre as Est From cam a,cam_est e  where  a.IdE=e.Id and a.IdPE1IT=$idpadre";
	$rs=mysql_query($query,$conn);
	//Titulos de la tabla
	$tablaclientes='';
	$tablaclientes .='<table width="700" border="0" cellspacing="0" cellpadding="0" class="TMT"><tr>';
	$tablaclientes .='<td class="recuento"><label class="TBold">Laboratorio</label> <label class="TGray">Calidad</label></td></td></tr></table>';	
	$tablaclientes .='<table width="300" class="TableShow TMT" id="tshow"><tr>';
	$tablaclientes .='<td width="50" class="TableShowT TAR"> COA</td>';
	$tablaclientes .="<td "."width="."70"." class="."TableShowT"."> Fecha</td>"; 
	$tablaclientes .="<td "."width="."170"." class="."TableShowT"."> Estado</td>"; 
	$tablaclientes .='</tr>';             
	$estilo="";$link="";
	while($row=mysql_fetch_array($rs)){
		$tablaclientes .='<tr '.$estilo.'>';
		$tablaclientes .='<td class="TableShowD TAR"'.$link.'>'.str_pad($row['Id'], 5, "0", STR_PAD_LEFT)."</td>"; 
		$tablaclientes .="<td class="."TableShowD".$link."> ".GLO_FormatoFecha($row['Fecha'])."</td>"; 
		$tablaclientes .="<td class="."TableShowD".$link.' style="font-weight:bold;'.CAM_colorestado($row['IdE']).'"'."> ".substr($row['Est'],0,18)."</td>";  
		$tablaclientes .="</tr>";  
	}mysql_free_result($rs);	
	$tablaclientes .="</table>";echo $tablaclientes;	
}
	

function TablaPlanta3($idpadre,$conn){
	$idpadre=intval($idpadre);
	$query="SELECT s.*,d.Nombre as Deposito,t.Nombre as TipoM,i.Cantidad,u.Abr  From stockmov s,depositos d,stock_tipomov t,stockmov_items i,cam a,items il,unidadesmedida u where s.IdDeposito=d.Id and s.IdTipoMov=t.Id and i.IdMov=s.Id and s.IdCAM=a.Id and i.IdItem=il.Id and il.IdUnidad=u.Id and a.IdPE1IT=$idpadre Order by s.Fecha,s.Id";
	$rs=mysql_query($query,$conn);
	//Titulos de la tabla
	$tablaclientes='';
	$tablaclientes .='<table width="700" border="0" cellspacing="0" cellpadding="0" class="TMT20"><tr>';
	$tablaclientes .='<td class="recuento"><label class="TBold">Planta</label> <label class="TGray">Almacenamiento</label></td></td></tr></table>';	
	$tablaclientes .='<table width="560" class="TableShow TMT" id="tshow"><tr>';
	$tablaclientes .="<td "."width="."70"." class="."TableShowT"."> Fecha</td>";   
	$tablaclientes .="<td "."width="."120"." class="."TableShowT"."> Tipo</td>";   
	$tablaclientes .="<td "."width="."50"." class="."TableShowT"." style='text-align:right;'> Movim.</td>";   
	$tablaclientes .="<td "."width="."70"." class="."TableShowT"." style='text-align:right;'> Ingreso</td>";   
	$tablaclientes .="<td "."width="."70"." class="."TableShowT"." style='text-align:right;'> Egreso</td>"; 
	$tablaclientes .="<td "."width="."40"." class="."TableShowT"."> </td>"; 
	$tablaclientes .="<td "."width="."170"." class="."TableShowT"."> Dep&oacute;sito</td>"; 
	$tablaclientes .='</tr>';  
	$estilo="";$link="";
	while($row=mysql_fetch_array($rs)){
		$ingreso="";$egreso="";	if($row['IdTipoMov']==1 or $row['IdTipoMov']==3){$ingreso=$row['Cantidad'];}else{$egreso=$row['Cantidad'];}	
		$tablaclientes .='<tr '.$estilo.'>';
		$tablaclientes .="<td class="."TableShowD".$link." > ".FormatoFecha($row['Fecha'])."</td>";
		$tablaclientes .="<td class="."TableShowD".$link."> ".substr($row['TipoM'],0,14)."</td>"; 
		$tablaclientes .="<td class="."TableShowD".$link." style='text-align:right;'> ".str_pad($row['Id'], 6, "0", STR_PAD_LEFT)."</td>";  
		$tablaclientes .='<td class="TableShowD TAR TBlue">'.$ingreso."</td>"; 
		$tablaclientes .='<td class="TableShowD TAR TRed">'.$egreso."</td>"; 
		$tablaclientes .="<td class="."TableShowD".$link."> ".substr($row['Abr'],0,5)."</td>"; 
		$tablaclientes .="<td class="."TableShowD".$link."> ".substr($row['Deposito'],0,20)."</td>"; 
		$tablaclientes .="</tr>";  
	}mysql_free_result($rs);	
	$tablaclientes .="</table>";echo $tablaclientes;	
}





GLO_InitHTML($_SESSION["NivelArbol"],'TxtNombre','BannerPopUpMH','zModificarItem',0,0,0,0);
include("Includes/zCamposItem.php");
if($existecam==0){GLO_guardar("730",3,0);}
GLO_mensajeerror();

//hilo
echo '<table  width="700" border="0" cellspacing="0" cellpadding="0" class="TMT10"><tr> <td  height="3" ></td></tr><tr valign="top"> <td valign="top" >';
TablaLab2($_SESSION['TxtNumero'],$conn);
TablaPlanta3($_SESSION['TxtNumero'],$conn);
echo '</td></tr></table>';


GLO_cierratablaform();
mysql_close($conn); 
GLO_initcomment(730,0);
echo 'No puede modificar items asociados a <font class="comentario3">COA</font><br>';
echo 'El <font class="comentario2">Cliente</font> de la Solicitud es el due&ntilde;o del <font class="comentario3">Producto</font>';
GLO_endcomment();
include ("../Codigo/FooterConUsuario.php");
?>