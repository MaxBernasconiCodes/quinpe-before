<? include("../Codigo/Seguridad.php");include("../Codigo/Config.php");include("../Codigo/Funciones.php");$_SESSION["NivelArbol"]="../";require_once('../Codigo/calendar/classes/tc_calendar.php');include("zFunciones.php");
//perfiles
if ($_SESSION["IdPerfilUser"]!=1 and $_SESSION["IdPerfilUser"]!=2 and $_SESSION["IdPerfilUser"]!=4 and $_SESSION["IdPerfilUser"]!=7 and $_SESSION["IdPerfilUser"]!=3  and $_SESSION["IdPerfilUser"]!=11  and $_SESSION["IdPerfilUser"]!=12  and $_SESSION["IdPerfilUser"]!=9 and $_SESSION["IdPerfilUser"]!=14 ){ header("Location:".$_SESSION["NivelArbol"]."Inicio.php");}
//get
GLO_ValidaGET($_GET['id'],0,0);

$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);


if ($_GET['Flag1']=="True"){//pedidosrepreq IdPR join Id pedidosrepord
	//busco datos
	$query="SELECT r.*,p.IdUnidad,p.FechaI,p.Km,p.Hs,u.Dominio,e.Nombre as EstadoA,p.IdEstado as IdEstadoO From pedidosrepreq r,pedidosrepord p,unidades u,pedidosrepreq_est e where r.Id<>0 and r.IdPR=p.Id and p.IdUnidad=u.Id and r.IdEstado=e.Id and r.Id=".intval($_GET['id']); 
	$rs=mysql_query($query,$conn);$row=mysql_fetch_array($rs);
	if(mysql_num_rows($rs)!=0){
		$_SESSION['TxtNumero'] = str_pad($row['Id'], 6, "0", STR_PAD_LEFT);
		$_SESSION['TxtNroEntidad'] = str_pad($row['IdPR'], 6, "0", STR_PAD_LEFT);
		$_SESSION['TxtIdEstadoO'] = $row['IdEstadoO'];
		$_SESSION['CbClase'] =$row['Clase'];
		$_SESSION['CbTipo'] =$row['Tipo'];
		$_SESSION['CbUrg'] =$row['Urg'];
		$_SESSION['CbCat'] =$row['IdCat'];
		$_SESSION['TxtEstadoA'] =$row['EstadoA'];
		$_SESSION['TxtIdEstadoA'] =$row['IdEstado'];
		$_SESSION['ChkExt'] =$row['Alcance'];
		$_SESSION['TxtObs'] = $row['Obs'];
		$_SESSION['TxtFecha1'] =GLO_FormatoFecha($row['FTurno']);
		$_SESSION['CbProv'] =$row['IdProv'];
		//
		$_SESSION['TxtPRUnidad'] =$row['Dominio'];
		$_SESSION['TxtPRIdUnidad'] = str_pad($row['IdUnidad'], 6, "0", STR_PAD_LEFT);
		$_SESSION['TxtPRFechaI'] =GLO_FormatoFecha($row['FechaI']);
		$_SESSION['TxtPRKm'] = $row['Km'];if ($_SESSION['TxtPRKm']==0){$_SESSION['TxtPRKm'] ="";}
		$_SESSION['TxtPRHs'] = $row['Hs'];if ($_SESSION['TxtPRHs']==0){$_SESSION['TxtPRHs'] ="";}
	}mysql_free_result($rs);
}

 


function MostrarTablaComentarios($idpadre,$conn){
$query="SELECT * From pedidosrepreq_com where IdEntidad=$idpadre Order by Id";$rs=mysql_query($query,$conn);
//Titulos de la tabla
$tablaclientes='';
$tablaclientes .='<table width="750" border="0" cellspacing="0" cellpadding="0" ><tr>';
$tablaclientes .='<td class="TablaTituloLeft"></td>';
$tablaclientes .="<td "."width="."160"." class="."TablaTituloDato"."> Usuario</td>";   
$tablaclientes .='<td class="TablaTituloLeft"></td>'; 
$tablaclientes .="<td "."width="."550"." class="."TablaTituloDato"."> Comentario</td>";  
$tablaclientes .='<td class="TablaTituloLeft"></td>'; 
$tablaclientes .='<td width="40" class="TablaTituloDato TAR">'.GLO_FAButton('CmdAddC','submit','','self','Agregar','add','iconbtn').'<td>';

$tablaclientes .='<td class="TablaTituloRight"></td>';  
$tablaclientes .='</tr>';             
$estilo=" style='cursor:pointer;' ";
while($row=mysql_fetch_array($rs)){
	//busco nombre comentario
	$query= "Select p.Nombre,p.Apellido From personal p,usuarios u Where p.Id=u.IdPersonal and u.Usuario='".$row['IdUsuario']."'";
	$rs2=mysql_query($query,$conn);$row2=mysql_fetch_array($rs2);
	if(mysql_num_rows($rs2)!=0){$creadox=substr($row2['Apellido'].' '.$row2['Nombre'],0,11);} else{$creadox='';}
	mysql_free_result($rs2);
	$link=" onclick="."location='ModificarComentarioReq.php?Flag1=True"."&id=".$row['Id']."&identidad=".$idpadre."'";
	$tablaclientes .='<tr '.$estilo.'>';  
	$tablaclientes .='<td class="TablaMostrarLeft"></td>';  
	$tablaclientes .="<td  class="."TablaDato".$link."> ".$creadox.' '.FormatoFecha($row['Fecha'])."</td>"; 
	$tablaclientes .='<td class="TablaMostrarLeft"></td>';  
	$tablaclientes .="<td  class="."TablaDato".$link."> ".substr($row['Comentario'],0,75)."</td>"; 
	$tablaclientes .='<td class="TablaMostrarLeft"></td>';  
	$tablaclientes .='<td  class="TablaDatoR">';
	$tablaclientes .=GLO_rowbutton("CmdBorrarFilaC",$row['Id'],"Eliminar",'self','trash','iconlgray','Eliminar',0,0,0);
	$tablaclientes .="</td><td class="."TablaMostrarRight"."> </td></tr>";  
}	
$tablaclientes .="</table>";echo $tablaclientes;	
mysql_free_result($rs);
}



function MostrarTablaInsumos($idpadre,$conn){
$query="SELECT r.*,a.Nombre as Articulo,um.Abr From pedidosrepreq_ins r,epparticulos a,unidadesmedida um where r.Id<>0 and r.IdArti=a.Id and a.IdUnidad=um.Id and r.IdPRR=$idpadre Order by a.Nombre  ";$rs=mysql_query($query,$conn);
//Titulos de la tabla
$tablaclientes='';
$tablaclientes .='<table width="750" border="0" cellspacing="0" cellpadding="0" ><tr>';
$tablaclientes .='<td class="TablaTituloLeft"></td>';
$tablaclientes .="<td "."width="."360"." class="."TablaTituloDato"."> Repuesto/Insumo</td>";   
$tablaclientes .='<td class="TablaTituloLeft"></td>';
$tablaclientes .="<td "."width="."30"." class="."TablaTituloDato"."></td>";   
$tablaclientes .='<td class="TablaTituloLeft"></td>';
$tablaclientes .="<td "."width="."60"." class="."TablaTituloDato"." style='text-align:right;'> Cantidad</td>"; 
$tablaclientes .='<td class="TablaTituloLeft"></td>';
$tablaclientes .="<td "."width="."130"." class="."TablaTituloDato"." >PSI</td>";   
$tablaclientes .='<td class="TablaTituloLeft"></td>';
$tablaclientes .="<td "."width="."130"." class="."TablaTituloDato".">MIM</td>";   
$tablaclientes .='<td class="TablaTituloLeft"></td>'; 
$tablaclientes .='<td width="40" class="TablaTituloDato TAR">';
//si esta retirada o finalizada no puede modificar 
if (intval($_SESSION['TxtIdEstadoO'])!=7 and intval($_SESSION['TxtIdEstadoO'])!=8 and intval($_SESSION['TxtIdEstadoO'])!=9){
$tablaclientes .=GLO_FAButton('CmdAddI','submit','','self','Agregar','add','iconbtn');
}
$tablaclientes .='</td><td class="TablaTituloRight"></td>';  
$tablaclientes .='</tr>';             
$estilo=" style='cursor:pointer;' ";$clase="TablaDato";
while($row=mysql_fetch_array($rs)){ 
	$link=" onclick="."location='ModificarI.php?Flag1=True"."&id=".$row['Id']."'";
	$tablaclientes .='<tr '.$estilo.'>';  
	$tablaclientes .='<td class="TablaMostrarLeft"></td>';  
	$tablaclientes .="<td class=".$clase.$link."> ".str_pad($row['IdArti'], 6, "0", STR_PAD_LEFT).' '.substr($row['Articulo'],0,30)."</td>"; 
	$tablaclientes .='<td class="TablaMostrarLeft"></td>';  
	$tablaclientes .="<td class=".$clase.$link."> ".substr($row['Abr'],0,5)."</td>"; 
	$tablaclientes .='<td class="TablaMostrarLeft"></td>'; 	 
	$tablaclientes .="<td class=".$clase.$link." style='text-align:right;'> ".$row['Cant']."</td>"; 
	$tablaclientes .='<td class="TablaMostrarLeft"></td>'; 	 
	$tablaclientes .="<td class=".$clase.$link."> ".str_pad($row['PSI'], 6, "0", STR_PAD_LEFT).' '.GLO_FormatoFecha($row['FechaPSI'])."</td>"; 
	$tablaclientes .='<td class="TablaMostrarLeft"></td>'; 	 
	$tablaclientes .="<td class=".$clase.$link."> ".str_pad($row['MIM'], 6, "0", STR_PAD_LEFT).' '.GLO_FormatoFecha($row['FechaMIM'])."</td>"; 
	$tablaclientes .='<td class="TablaMostrarLeft"></td>';  
	$tablaclientes .='<td  class="TablaDatoR">';
	//si esta retirada no puede borrar 
	if (intval($_SESSION['TxtIdEstadoO'])!=8 and intval($_SESSION['TxtIdEstadoO'])!=9){
		$tablaclientes .=GLO_rowbutton("CmdBorrarFilaI",$row['Id'],"Eliminar",'self','trash','iconlgray','Eliminar',0,0,0);
	}
	$tablaclientes .="</td><td class="."TablaMostrarRight"."> </td>";  
	$tablaclientes .='</tr>'; 
}	
//Cerrar tabla
$tablaclientes .="</table>"; 
echo $tablaclientes;	
mysql_free_result($rs);
}



function MostrarTablaEstados($idpadre,$conn){
$query="SELECT p.*,e.Nombre as Estado From pedidosrepreq_hist p, pedidosrepreq_est e where p.IdEstado=e.Id and p.IdPRR=$idpadre Order by p.Fecha";$rs=mysql_query($query,$conn);
//Titulos de la tabla
$tablaclientes='';
$tablaclientes .='<table width="750" border="0" cellspacing="0" cellpadding="0" ><tr>';
$tablaclientes .='<td class="TablaTituloLeft"></td>';
$tablaclientes .="<td "."width="."70"." class="."TablaTituloDato"."> Fecha</td>";   
$tablaclientes .='<td class="TablaTituloLeft"></td>'; 
$tablaclientes .="<td "."width="."320"." class="."TablaTituloDato"."> Estado</td>";  
$tablaclientes .='<td class="TablaTituloLeft"></td>'; 
$tablaclientes .="<td width="."360"." class="."TablaTituloDato"."> Usuario</td>"; 
$tablaclientes .='<td class="TablaTituloRight"></td>';  
$tablaclientes .='</tr>';             
$estilo=" style='cursor:pointer;' ";$clase="TablaDato";
while($row=mysql_fetch_array($rs)){
	$link=" onclick="."location='ModificarEPRR.php?Flag1=True"."&id=".$row['Id']."'";
	//busco nombre comentario
	$query= "Select p.Nombre,p.Apellido From personal p,usuarios u Where p.Id=u.IdPersonal and u.Usuario='".$row['IdUsuario']."'";
	$rs2=mysql_query($query,$conn);$row2=mysql_fetch_array($rs2);
	if(mysql_num_rows($rs2)!=0){$creadox=substr($row2['Apellido'].' '.$row2['Nombre'],0,50);} else{$creadox='';}mysql_free_result($rs2);
	$tablaclientes .='<tr '.$estilo.'>';  
	$tablaclientes .='<td class="TablaMostrarLeft"></td>';  
	$tablaclientes .="<td  class="."TablaDato".$link."> ".FormatoFecha($row['Fecha'])."</td>"; 
	$tablaclientes .='<td class="TablaMostrarLeft"></td>';  
	$tablaclientes .="<td  class="."TablaDato".$link."> ".substr($row['Estado'],0,50)."</td>";
	$tablaclientes .="<td class="."TablaMostrarLeft"."></td>";  
	$tablaclientes .="<td  class="."TablaDato".$link."> ".$creadox."</td>";
	$tablaclientes .="<td class="."TablaMostrarRight"."> </td></tr>";  
}	
$tablaclientes .="</table>";echo $tablaclientes;	
mysql_free_result($rs);
}


GLOF_Init('','BannerPopUp','zModificarReq',0,'',0,0,0); 
GLO_tituloypath(0,750,'','ACCION A IMPLEMENTAR','salir');

include ("zCamposReq.php");

REP_TablaAct($_SESSION['TxtNumero'],$conn,0); //tareas
?>

           

<table width="750" border="0"  cellpadding="0" cellspacing="0"  class="TMT20">
<tr ><td ><i class="fa fa-traffic-light iconsmallsp iconlgray"></i> <strong>Estados:</strong></td></tr>
<tr> <td  align="center"><?php MostrarTablaEstados($_SESSION['TxtNumero'],$conn); ?>	</td></tr>
<tr> <td height="20"></td></tr>

<tr ><td ><i class="fa fa-toolbox iconsmallsp iconlgray"></i> <strong>Repuestos/Insumos:</strong></td></tr>
<tr> <td  align="center"  ><?php MostrarTablaInsumos($_SESSION['TxtNumero'],$conn); ?>	</td></tr>
<tr> <td height="20"></td></tr>

<tr ><td ><i class="fa fa-comments iconsmallsp iconlgray"></i> <strong>Comentarios:</strong></td></tr>
<tr> <td  align="center"><?php MostrarTablaComentarios($_SESSION['TxtNumero'],$conn); ?>	</td></tr>
<tr> <td height="20"></td></tr>

<tr ><td ><i class="fa fa-paperclip iconsmallsp iconlgray"></i> <strong>Archivos adjuntos:</strong></td></tr>
<tr> <td  align="center" ><?php GLO_TablaArchivos($_SESSION['TxtNumero'],$conn,"pedidosrepreq_arch","750","Adjuntos/"); ?>	</td></tr>
</table>                  
          
           
<? 
GLO_cierratablaform();
mysql_close($conn); 

GLO_initcomment(750,0);
echo 'Complete <font class="comentario2">Tareas</font> e <font class="comentario2">Insumos</font><br>';
echo 'Para completar la <font class="comentario2">Accion</font> seleccione el boton <font class="comentario3">Finalizar Accion</font>';
GLO_endcomment();

include ("../Codigo/FooterConUsuario.php");
?>