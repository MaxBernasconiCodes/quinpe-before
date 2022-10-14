<? include("../Codigo/Seguridad.php") ;include("../Codigo/Config.php") ;include("../Codigo/Funciones.php") ;$_SESSION["NivelArbol"]="../";
include("../Procesos/Includes/zFunciones.php") ;include("../Despacho/zFunciones.php");require_once('../Codigo/calendar/classes/tc_calendar.php');include("Includes/zFunciones.php") ;
//perfiles
GLO_PerfilAcceso(13);

$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);

if (empty($_SESSION['TxtFechaD'])){
	$hoy=date("d-m-Y"); list($d,$m,$a)=explode("-",$hoy);
	$_SESSION['TxtFechaD']=date("d-m-Y", strtotime("$hoy -7 day"));
	$_SESSION['TxtFechaH']=$hoy;
}

function MostrarTabla($conn){
$query=$_SESSION['TxtQBARIP'];
if (  ($query!="")){	
	$rs=mysql_query($query,$conn);
	if(mysql_num_rows($rs)!=0){	
		//contenedora
		$tablaclientes='';		
		$tablaclientes .='<table  width="910" border="0" cellspacing="0" cellpadding="0" class="TMT5"><tr> <td  height="3" ></td></tr>';
		$tablaclientes .='<tr valign="top"> <td  align="center" valign="top" >';
		//Titulos
		$tablaclientes .='<table width="910" border="0" cellspacing="0" cellpadding="0" ><tr>';
		$tablaclientes .="<td class="."recuento".">Acepte o rechace el Pedido de Salida</td></td></tr><tr><td "."height="."3"."></td></tr></table>";
		//		
		$tablaclientes .='<table width="910" class="TableShow" id="tshow"><tr>';
		$tablaclientes .='<td width="50" class="TableShowT TAR">Pedido</td>';
		$tablaclientes .="<td "."width="."70"." class="."TableShowT"."> Fecha</td>";  
		$tablaclientes .="<td "."width="."90"." class="."TableShowT"."> Cliente</td>";  
		$tablaclientes .='<td width="50" class="TableShowT TAR"> Remito</td>';
		$tablaclientes .="<td "."width="."50"." class="."TableShowT".">Solicitud</td>"; 
		$tablaclientes .="<td "."width="."150"." class="."TableShowT".">Accion</td>"; 
		$tablaclientes .="<td "."width="."180"." class="."TableShowT"."> Camion</td>";
		$tablaclientes .="<td "."width="."180"." class="."TableShowT"."> Semi</td>";
		$tablaclientes .='<td width="90" class="TableShowT"> Estado</td>';
		$tablaclientes .='</tr>';   
		$recuento=0;          
		$clase="TableShowD";$estilo=" style='cursor:pointer;' ";
		while($row=mysql_fetch_array($rs)){ 
			$idestado=DES_asignar_estado($row['IdPadre'],$row['Id'],$conn);//estado pedido
			DES_Estado($idestado,$colorrow,$colorfield,$estado);	
			$link=" onclick="."location='ModificarPD.php?Flag1=True&id=".$row['Id']."'";	
			//buscar dominios
			DES_Dominios($row['Id'],$conn,$domcamion,$domsemi);			
			//
			$tablaclientes .='<tr '.$estilo.GLO_highlight($row['Id']).'>';
			$tablaclientes .='<td class="TableShowD TAR"'.$link.'>'.str_pad($row['Id'], 5, "0", STR_PAD_LEFT)."</td>"; 
			$tablaclientes .='<td  class="TableShowD"'.$link.'>'.GLO_FormatoFecha($row['Fecha'])."</td>"; 
			$tablaclientes .='<td  class="TableShowD"'.$link.'>'.substr($row['Cliente'],0,10)."</td>"; 
			$tablaclientes .='<td class="TableShowD TAR"'.$link.'>'.GLO_SinCero($row['Rto'])."</td>";
			$tablaclientes .='<td class="TableShowD TAR TBold TL12"'.$link.'>'.$row['IdPadre']."</td>";
			$tablaclientes .="<td class="."TableShowD".$link."> ".substr($row['Tipo'],0,28)."</td>";  
			$tablaclientes .='<td class="TableShowD"'.$link.'>'.$domcamion."</td>";   
			$tablaclientes .='<td class="TableShowD"'.$link.'>'.$domsemi."</td>"; 
			$tablaclientes .='<td class="TableShowD TBold"'.$link.$colorrow."> ".substr($estado,0,20)."</td>"; 
			$tablaclientes .='</tr>'; 
			$recuento=$recuento+1;
		}	
		$tablaclientes .=GLO_fintabla(0,0,$recuento);
		echo $tablaclientes;	
	}else{echo '<p class="MuestraConf" align="center">No existen datos que cumplan esos criterios</p>';}
	mysql_free_result($rs);
}
}

//html
GLOF_Init('','BannerConMenuHV','zInboxP',0,'MenuH',0,0,0); 
GLO_tituloypath(0,700,'Consulta.php','PEDIDOS LOGISTICA','linksalir');

include("../Despacho/Includes/zCamposFiltros.php"); 


GLO_Hidden('TxtId',0);GLO_Hidden('TxtQBARIP',0);
GLO_mensajeerror();
MostrarTabla($conn);
GLO_cierratablaform();
mysql_close($conn); 


GLO_initcomment(0,0);
echo 'Trae los <font class="comentario3">Pedidos</font> de <font class="comentario2">Salida</font> que tienen items registrados<br>';
GLO_endcomment();


include ("../Codigo/FooterConUsuario.php");
?>