<? include("../Codigo/Seguridad.php") ;include("../Codigo/Config.php") ;include("../Codigo/Funciones.php");  $_SESSION["NivelArbol"]="../";require_once('../Codigo/calendar/classes/tc_calendar.php');
//perfiles
GLO_PerfilAcceso(12);

//get
GLO_ValidaGET($_GET['id'],0,0);

$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);

if ($_GET['Flag1']=="True"){
	$query="SELECT * From accesorios where Id<>0 and Id=".intval($_GET['id']); $rs=mysql_query($query,$conn);
	while($row=mysql_fetch_array($rs)){
		$_SESSION['TxtNumero'] = str_pad($row['Id'], 6, "0", STR_PAD_LEFT);
		$_SESSION['TxtNombre'] = $row['Nombre'];
        $_SESSION['CbInstrumento'] = $row['IdElemento'];
		$_SESSION['TxtModelo'] = $row['Modelo'];
		$_SESSION['TxtNSE'] = $row['NSE'];
        $_SESSION['TxtLote'] = $row['Lote'];
        $_SESSION['CbFabr'] = $row['IdFabricante'];
		$_SESSION['TxtObs'] = $row['Obs'];
		$_SESSION['TxtFoto'] = $row['Foto'];	
        //
		$_SESSION['TxtFechaF'] = GLO_FormatoFecha($row['FechaF']);
		$_SESSION['TxtFechaI'] = GLO_FormatoFecha($row['FechaI']);
		$_SESSION['TxtFechaV'] = GLO_FormatoFecha($row['FechaV']);
		$_SESSION['TxtFechaB'] = GLO_FormatoFecha($row['FechaBaja']);
	}mysql_free_result($rs);
} 



function MostrarTablaItems($idpadre,$conn){ 
	$query="SELECT ia.*, u.Nombre as Unidad,p.Nombre,p.Apellido From accesorios_asig ia,unidades u,personal p where ia.IdUnidad=u.id and ia.Id<>0 and p.Id=ia.IdPersonal and ia.IdInstrumento=$idpadre Order by ia.FechaD Desc";$rs=mysql_query($query,$conn);
	//Titulos de la tabla
	$tablaclientes='';
	$tablaclientes .='<table width="720" class="TableShow" id="tshow"><tr>';
	$tablaclientes .="<td "."width="."200"." class="."TableShowT"."> Unidad</td>";   
	$tablaclientes .="<td "."width="."150"." class="."TableShowT"."> Autorizado por</td>";   
	$tablaclientes .="<td "."width="."70"." class="."TableShowT"."> Desde</td>"; 
	$tablaclientes .="<td "."width="."70"." class="."TableShowT"."> Hasta</td>"; 
	$tablaclientes .="<td "."width="."70"." class="."TableShowT"."> Devuelto</td>"; 
	$tablaclientes .="<td "."width="."120"." class="."TableShowT".">Observaciones</td>";   
	$tablaclientes .='<td width="40" class="TableShowT TAR">'.GLO_FAButton('CmdAddI','submit','','self','Agregar','add','iconbtn')." </td>"; 
	$tablaclientes .='</tr>';             
	$recuento=0; $estilo=" style='cursor:pointer;' ";
	$_SESSION['TxtOriACCAsig']=0; //para ver a donde vuelve
	while($row=mysql_fetch_array($rs)){ 
		$link=" onclick="."location='ModificarAsignacion.php?Flag1=True"."&id=".$row['Id']."'";
		if($row['TIndef']==1){$ti='Tiempo indefinido';}else{$ti='';}
		if(GLO_FechaVencida(GLO_FormatoFecha($row['FechaE']))==1 and GLO_FormatoFecha($row['FechaH'])==''){$classvto=' TRed';}else{$classvto='';}
		//
		$tablaclientes .='<tr '.$estilo.'>';  
		$tablaclientes .="<td class="."TableShowD".$link."> ".substr($row['Unidad'],0,24)."</td>"; 
		$tablaclientes .="<td class="."TableShowD".$link."> ".substr($row['Apellido'].' '.$row['Nombre'],0,18)."</td>"; 
		$tablaclientes .="<td class="."TableShowD".$link."> ".GLO_FormatoFecha($row['FechaD'])."</td>"; 
		$tablaclientes .='<td class="TableShowD'.$classvto.'"'.$link."> ".GLO_FormatoFecha($row['FechaE'])."</td>"; 
		$tablaclientes .="<td class="."TableShowD".$link."> ".GLO_FormatoFecha($row['FechaH'])."</td>";  
		$tablaclientes .="<td class="."TableShowD".$link."> ".$ti."</td>"; 
		$tablaclientes .='<td class="TableShowD TAR">'.GLO_rowbutton("CmdBorrarFilaI",$row['Id'],"Eliminar",'self','trash','iconlgray','Eliminar',0,0,0). "</td>";  
		$tablaclientes .='</tr>'; 
		$recuento=$recuento+1;
	}mysql_free_result($rs);	
	$tablaclientes .="</table>"; 
	echo $tablaclientes;
}


function MostrarTablaCE($idpadre,$conn){ 
	$query="SELECT pp.*,im.Nombre as TipoC From accesorios_prog pp,instrumentostipocertif im  where pp.Id<>0 and pp.IdTipoCertif=im.Id and pp.IdInstrumento=$idpadre Order by pp.Inactivo,pp.FechaProg";$rs=mysql_query($query,$conn);
	//Titulos de la tabla
	$tablaclientes='';
	$tablaclientes .='<table width="720" class="TableShow" id="tshow"><tr>';
	$tablaclientes .="<td "."width="."60"." class="."TableShowT"."> Certif</td>";   
	$tablaclientes .="<td "."width="."70"." class="."TableShowT"."> Fecha</td>";   
	$tablaclientes .="<td "."width="."100"." class="."TableShowT"."> Certificaci&oacute;n</td>";   
	$tablaclientes .="<td "."width="."150"." class="."TableShowT".">Certificado </td>";  
	$tablaclientes .="<td "."width="."220"." class="."TableShowT"."> Observaciones</td>"; 
	$tablaclientes .="<td "."width="."80"." class="."TableShowT"."> Vencimiento</td>"; 
	$tablaclientes .='<td width="40" class="TableShowT TAR">'.GLO_FAButton('CmdAddCE','submit','','self','Agregar','add','iconbtn')." </td>"; 
	$tablaclientes .='</tr>';             
	$recuento=0; $estilo=" style='cursor:pointer;' ";
	$_SESSION['TxtOriACCCertif']=0; //para ver a donde vuelve
	while($row=mysql_fetch_array($rs)){ 
		$link=" onclick="."location='ModificarCE.php?Flag1=True"."&id=".$row['Id']."'";		
		$fechar =GLO_FormatoFecha($row['FechaReal']);
		if ($row['Inactivo']==0){$clase="";}else{$clase=" TGray";}	
		$tablaclientes .='<tr '.$estilo.'>';  
		$tablaclientes .='<td class="TableShowD'.$clase.'"'.$link."> ".str_pad($row['Id'], 6, "0", STR_PAD_LEFT)."</td>"; 
		$tablaclientes .='<td class="TableShowD'.$clase.'"'.$link."> ".GLO_FormatoFecha($row['FechaProg'])."</td>"; 
		$tablaclientes .='<td class="TableShowD'.$clase.'"'.$link."> ".substr($row['TipoC'],0,12)."</td>"; 
		$tablaclientes .='<td class="TableShowD'.$clase.'"'.$link."> ".substr($row['Certificado'],0,16)."</td>";  
		$tablaclientes .='<td class="TableShowD'.$clase.'"'.$link."> ".substr($row['Obs'],0,30)."</td>"; 
		if ($fechar!="" and (strtotime(date("d-m-Y"))-strtotime($fechar))>0 and $row['Inactivo']==0)
		{$tablaclientes .='<td class="TableShowD TRed"'.$link."> ".$fechar."</td>";}
		else{$tablaclientes .='<td class="TableShowD'.$clase.'"'.$link."> ".$fechar."</td>";}	 
		$tablaclientes .='<td class="TableShowD TAR">'.GLO_rowbutton("CmdBorrarFilaCE",$row['Id'],"Eliminar",'self','trash','iconlgray','Eliminar',0,0,0). "</td>";  
		$tablaclientes .='</tr>'; 
		$recuento=$recuento+1;
	}mysql_free_result($rs);	
	$tablaclientes .="</table>"; 
	echo $tablaclientes;
}



GLOF_Init('TxtNombre','BannerConMenuHV','zModificar',0,'MenuH',0,0,0); 
GLO_tituloypath(0,720,'Consulta.php','ACCESORIO','linksalir');

include ("Includes/zCampos.php"); 

GLO_cierratablaform();
mysql_close($conn);
include ("../Codigo/FooterConUsuario.php");
?>