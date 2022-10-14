<? 
//seguridad includes
if(!isset($_SESSION)){include("../../Codigo/SeguridadIncludes.php");}
else{include($_SESSION["NivelArbol"]."Codigo/SeguridadIncludes.php");}


function PL_TablaSeguimiento($conn){
$query=$_SESSION['TxtQISOPLAT'];$query=str_replace("\\", "", $query);
if (  ($query!="")){
	$rs=mysql_query($query,$conn);
	if(mysql_num_rows($rs)!=0){	
		//Marco de la tabla	
		$tablaclientes='';	
		$tablaclientes .=GLO_inittabla(1040,0,0,0);
		$tablaclientes .="<td class="."TablaTituloLeft"."> </td>"; 
		$tablaclientes .="<td "."width="."70"." class="."TablaTituloDato"."> Plan</td>";   
		$tablaclientes .="<td class="."TablaTituloLeft"."> </td>"; 
		$tablaclientes .="<td "."width="."100"." class="."TablaTituloDato"."> Codigo</td>";   
		$tablaclientes .="<td class="."TablaTituloLeft"."> </td>"; 
		$tablaclientes .="<td "."width="."340"." class="."TablaTituloDato".' style="font-weight:bold;"'."> Tarea</td>";   
		$tablaclientes .="<td class="."TablaTituloLeft"."> </td>"; 
		$tablaclientes .="<td "."width="."80"." class="."TablaTituloDato".">Lugar</td>";  
		$tablaclientes .="<td class="."TablaTituloLeft"."> </td>"; 
		$tablaclientes .="<td "."width="."70"." class="."TablaTituloDato".">Prioridad</td>";  
		$tablaclientes .="<td class="."TablaTituloLeft"."> </td>"; 
		$tablaclientes .="<td "."width="."70"." class="."TablaTituloDato".">Inicio P.</td>";  
		$tablaclientes .="<td class="."TablaTituloLeft"."> </td>"; 
		$tablaclientes .="<td "."width="."70"." class="."TablaTituloDato".">Final P.</td>";  
		$tablaclientes .="<td class="."TablaTituloLeft"."> </td>"; 
		$tablaclientes .="<td "."width="."70"." class="."TablaTituloDato".">Inicio R.</td>";  
		$tablaclientes .="<td class="."TablaTituloLeft"."> </td>"; 
		$tablaclientes .="<td "."width="."70"." class="."TablaTituloDato".">Final R.</td>"; 
		$tablaclientes .="<td class="."TablaTituloLeft"."> </td>"; 
		$tablaclientes .="<td "."width="."100"." class="."TablaTituloDato".">Estado</td>";  
		$tablaclientes .="<td class="."TablaTituloRight"."> </td>"; 
		$tablaclientes .='</tr>';    
		$recuento=0;  $link='';   
		while($row=mysql_fetch_array($rs)){
			$prio='';if($row['Prio']==1){$prio='Alta';} if($row['Prio']==2){$prio='Media';}if($row['Prio']==3){$prio='Baja';} 
			$tablaclientes .='<tr>';
			$tablaclientes .="<td class="."TablaMostrarLeft"."> </td>";  
			$tablaclientes .="<td  class="."TablaDato ".$link." > ".GLO_FormatoFecha($row['Fecha'])."</td>"; 
			$tablaclientes .='<td class="TablaMostrarLeft"></td>'; 
			$tablaclientes .="<td class="."TablaDato ".$link."> ".substr($row['Codigo'],0,10)."</td>";  
			$tablaclientes .="<td class="."TablaMostrarLeft"."> </td>";  
			$tablaclientes .="<td  class="."TablaDato ".$link." > ".substr($row['Nombre'],0,40)."</td>"; 	 
			$tablaclientes .="<td class="."TablaMostrarLeft"."> </td>";  
			$tablaclientes .="<td  class="."TablaDato ".$link." > ".substr($row['Yac'],0,10)."</td>"; 
			$tablaclientes .="<td class="."TablaMostrarLeft"."> </td>";  
			$tablaclientes .="<td  class="."TablaDato ".$link." > ".$prio."</td>";
			$tablaclientes .="<td class="."TablaMostrarLeft"."> </td>";  
			$tablaclientes .="<td  class="."TablaDato ".$link." > ".GLO_FormatoFecha($row['F1'])."</td>"; 
			$tablaclientes .="<td class="."TablaMostrarLeft"."> </td>";  
			$tablaclientes .="<td  class="."TablaDato ".$link." > ".GLO_FormatoFecha($row['F2'])."</td>"; 
			$tablaclientes .="<td class="."TablaMostrarLeft"."> </td>";  
			$tablaclientes .="<td  class="."TablaDato ".$link." > ".GLO_FormatoFecha($row['F3'])."</td>"; 
			$tablaclientes .="<td class="."TablaMostrarLeft"."> </td>";  
			$tablaclientes .="<td  class="."TablaDato ".$link." > ".GLO_FormatoFecha($row['F4'])."</td>"; 
			$tablaclientes .="<td class="."TablaMostrarLeft"."> </td>";  
			$tablaclientes .="<td  class="."TablaDato ".$link.PL_ColorEstado($row['IdEstado'])." > ".substr($row['Estado'],0,12)."</td>"; 
			$tablaclientes .="<td class="."TablaMostrarRight"."> </td></tr>";  
			$recuento++;
		}mysql_free_result($rs);		
		$tablaclientes .=GLO_fintabla(0,0,$recuento);
		echo $tablaclientes;	
	}else{echo '<p class="MuestraConf" align="center">No existen datos que cumplan esos criterios</p>';}
	//Cierra consulta
	
}
}


function PL_TablaTareas($idpadre,$conn){
$idpadre=intval($idpadre);
$query="SELECT m.*,y.Nombre as Yac,e.Nombre as Estado From plan_t m,yacimientos y,plan_e e where m.IdYac=y.Id and m.IdEstado=e.Id and m.IdP=$idpadre Order by m.Id";
$rs=mysql_query($query,$conn);
//Titulos de la tabla
$tablaclientes='<table width="1150" border="0"  cellpadding="0" cellspacing="0"><tr><td height="3" ></td></tr><tr ><td  align="center" >';
$tablaclientes .='<table width="1150" border="0" cellspacing="0" cellpadding="0" ><tr>';
$tablaclientes .="<td class="."TablaTituloLeft"."> </td>"; 
$tablaclientes .="<td "."width="."20"." class="."TablaTituloDato"."> </td>";  
$tablaclientes .="<td class="."TablaTituloLeft"."> </td>"; 
$tablaclientes .="<td "."width="."200"." class="."TablaTituloDato"."> Observaciones</td>";   
$tablaclientes .="<td class="."TablaTituloLeft"."> </td>"; 
$tablaclientes .="<td "."width="."300"." class="."TablaTituloDato"."> Tarea</td>";   
$tablaclientes .="<td class="."TablaTituloLeft"."> </td>"; 
$tablaclientes .="<td "."width="."60"." class="."TablaTituloDato".">Lugar</td>";  
$tablaclientes .="<td class="."TablaTituloLeft"."> </td>"; 
$tablaclientes .="<td "."width="."40"." class="."TablaTituloDato".">Prio</td>";  
$tablaclientes .="<td class="."TablaTituloLeft"."> </td>"; 
$tablaclientes .="<td "."width="."120"." class="."TablaTituloDato".">Responsable</td>";  
$tablaclientes .="<td class="."TablaTituloLeft"."> </td>"; 
$tablaclientes .="<td "."width="."70"." class="."TablaTituloDato".">Inicio Prog</td>";  
$tablaclientes .="<td class="."TablaTituloLeft"."> </td>"; 
$tablaclientes .="<td "."width="."70"." class="."TablaTituloDato".">Final Prog</td>";  
$tablaclientes .="<td class="."TablaTituloLeft"."> </td>"; 
$tablaclientes .="<td "."width="."70"." class="."TablaTituloDato".">Inicio Real</td>";  
$tablaclientes .="<td class="."TablaTituloLeft"."> </td>"; 
$tablaclientes .="<td "."width="."70"." class="."TablaTituloDato".">Final Real</td>"; 
$tablaclientes .="<td class="."TablaTituloLeft"."> </td>"; 
$tablaclientes .="<td "."width="."100"." class="."TablaTituloDato".">Estado</td>";  
$tablaclientes .="<td class="."TablaTituloLeft"."> </td>"; 
$tablaclientes .="<td width="."30"." class="."TablaTituloDatoR".' >'.GLO_FAButton('CmdAddA','submit','','self','Agregar','add','iconbtn').'</td>'; 
$tablaclientes .="<td class="."TablaTituloRight"."> </td>"; 
$tablaclientes .='</tr>';             
$estilo=" style='cursor:pointer;' ";  $cont=0; $recuento=0;
while($row=mysql_fetch_array($rs)){
	$link=" onclick="."location='ModificarTarea.php?Flag1=True"."&id=".$row['Id']."'";
	$prio='';$claseprio='TablaDato';
	if($row['Prio']==1){$prio='Alta';$claseprio='TablaDatoRed';} if($row['Prio']==2){$prio='Media';}if($row['Prio']==3){$prio='Baja';} 
	$cont++;  
	//resp
	$resp='';
	$query="SELECT s.Nombre as Sector From plan_tresp m,sector s where m.IdSector=s.Id and m.IdPT=".$row['Id']." Order by s.Nombre";
	$rs2=mysql_query($query,$conn);while($row2=mysql_fetch_array($rs2)){$resp=GLO_ListaTexto($resp,substr($row2['Sector'],0,4));}
	mysql_free_result($rs2);
	//
	$tablaclientes .='<tr '.$estilo.'>';
	$tablaclientes .="<td class="."TablaMostrarLeft"."> </td>";  
	$tablaclientes .="<td  class="."TablaDato".$link.' style="text-align:center;vertical-align:top"'." > ".$cont."</td>"; 
	$tablaclientes .="<td class="."TablaMostrarLeft"."> </td>";  
	$tablaclientes .="<td  class="."TablaDato".$link.' title="'.$row['Obs'].'">'.substr($row['Obs'],0,28)."</td>"; 	 
	$tablaclientes .="<td class="."TablaMostrarLeft"."> </td>";  
	$tablaclientes .="<td  class="."TablaDato ".$link.' title="'.$row['Nombre'].'">'.substr($row['Nombre'],0,40)."</td>"; 	 
	$tablaclientes .="<td class="."TablaMostrarLeft"."> </td>";  
	$tablaclientes .="<td  class="."TablaDato ".$link." > ".substr($row['Yac'],0,8)."</td>"; 
	$tablaclientes .="<td class="."TablaMostrarLeft"."> </td>";  
	$tablaclientes .="<td  class=".$claseprio.$link." > ".$prio."</td>";
	$tablaclientes .="<td class="."TablaMostrarLeft"."> </td>";  
	$tablaclientes .="<td  class="."TablaDato ".$link." > ".substr($resp,0,16)."</td>"; 
	$tablaclientes .="<td class="."TablaMostrarLeft"."> </td>";  
	$tablaclientes .="<td  class="."TablaDato ".$link." > ".GLO_FormatoFecha($row['F1'])."</td>"; 
	$tablaclientes .="<td class="."TablaMostrarLeft"."> </td>";  
	$tablaclientes .="<td  class="."TablaDato ".$link." > ".GLO_FormatoFecha($row['F2'])."</td>"; 
	$tablaclientes .="<td class="."TablaMostrarLeft"."> </td>";  
	$tablaclientes .="<td  class="."TablaDato ".$link." > ".GLO_FormatoFecha($row['F3'])."</td>"; 
	$tablaclientes .="<td class="."TablaMostrarLeft"."> </td>";  
	$tablaclientes .="<td  class="."TablaDato ".$link." > ".GLO_FormatoFecha($row['F4'])."</td>"; 
	$tablaclientes .="<td class="."TablaMostrarLeft"."> </td>";  
	$tablaclientes .="<td  class="."TablaDato ".$link.PL_ColorEstado($row['IdEstado'])." > ".substr($row['Estado'],0,12)."</td>"; 
	$tablaclientes .="<td class="."TablaMostrarLeft"."> </td>";  
	$tablaclientes .="<td  class="."TablaDatoR".">"; 
	$tablaclientes .=GLO_rowbutton("CmdBorrarFilaA",$row['Id'],"Eliminar",'self','trash','iconlgray','Eliminar',0,0,0); 
	$tablaclientes .="</td><td class="."TablaMostrarRight"."> </td></tr>";  
	$recuento++;
}	
$tablaclientes .="</table></td></tr></table>";echo $tablaclientes;	
mysql_free_result($rs);
}

function PL_TablaParticipantes($idpadre,$conn){
$idpadre=intval($idpadre);
$query="SELECT m.* From plan_part m where m.IdP=$idpadre Order by m.Nombre";
$rs=mysql_query($query,$conn);
//Titulos de la tabla
$tablaclientes='<table width="700" border="0"  cellpadding="0" cellspacing="0"><tr><td height="3" ></td></tr><tr ><td height="18" ><i class="fa fa-users iconsmallsp iconlgray"></i> <strong>Participantes:</strong></td></tr><tr> <td  align="center" >';
$tablaclientes .='<table width="700" border="0" cellspacing="0" cellpadding="0" ><tr>';
$tablaclientes .="<td class="."TablaTituloLeft"."> </td>"; 
$tablaclientes .="<td "."width="."20"." class="."TablaTituloDato"."> </td>";   
$tablaclientes .="<td class="."TablaTituloLeft"."> </td>"; 
$tablaclientes .="<td "."width="."325"." class="."TablaTituloDato".' style="font-weight:bold;"'."> Nombre</td>";   
$tablaclientes .="<td class="."TablaTituloLeft"."> </td>"; 
$tablaclientes .="<td "."width="."325"." class="."TablaTituloDato".">Empresa</td>";  
$tablaclientes .="<td class="."TablaTituloLeft"."> </td>"; 
$tablaclientes .="<td width="."30"." class="."TablaTituloDatoR".' >'.GLO_FAButton('CmdAddA','submit','','self','Agregar','add','iconbtn').'</td>'; 
$tablaclientes .="<td class="."TablaTituloRight"."> </td>"; 
$tablaclientes .='</tr>';             
$estilo=" style='cursor:pointer;' ";  $cont=0; 
while($row=mysql_fetch_array($rs)){
	$link=" onclick="."location='ModificarAsistente.php?Flag1=True"."&id=".$row['Id']."'";
	$cont=$cont+1;  
	$tablaclientes .='<tr '.$estilo.'>';
	$tablaclientes .="<td class="."TablaMostrarLeft"."> </td>";  
	$tablaclientes .="<td  class="."TablaDato ".$link.' style="text-align:center;vertical-align:top"'." > ".$cont."</td>"; 
	$tablaclientes .="<td class="."TablaMostrarLeft"."> </td>";  
	$tablaclientes .="<td  class="."TablaDato ".$link." > ".substr($row['Nombre'],0,32)."</td>"; 	 
	$tablaclientes .="<td class="."TablaMostrarLeft"."> </td>";  
	$tablaclientes .="<td  class="."TablaDato ".$link." > ".substr($row['Empresa'],0,32)."</td>"; 
	$tablaclientes .="<td class="."TablaMostrarLeft"."> </td>";  
	$tablaclientes .="<td  class="."TablaDatoR".">"; 
	$tablaclientes .=GLO_rowbutton("CmdBorrarFilaA",$row['Id'],"Eliminar",'self','trash','iconlgray','Eliminar',0,0,0); 
	$tablaclientes .="</td><td class="."TablaMostrarRight"."> </td></tr>";  
}	
$tablaclientes .="</table></td></tr></table>";echo $tablaclientes;	
mysql_free_result($rs);
}


function PL_TablaResp($idpadre,$conn){
$idpadre=intval($idpadre);
$query="SELECT m.*,s.Nombre as Sector From plan_tresp m,sector s where m.IdSector=s.Id and m.IdPT=$idpadre Order by s.Nombre";
$rs=mysql_query($query,$conn);
//Titulos de la tabla
$tablaclientes='<table width="500" border="0"  cellpadding="0" cellspacing="0"><tr><td height="3" ></td></tr><tr ><td height="18" ><i class="fa fa-user-tie iconsmallsp iconlgray"></i> <strong>Responsables:</strong></td></tr><tr> <td  align="center" >';
$tablaclientes .='<table width="500" border="0" cellspacing="0" cellpadding="0" ><tr>';
$tablaclientes .="<td class="."TablaTituloLeft"."> </td>"; 
$tablaclientes .="<td "."width="."20"." class="."TablaTituloDato"."> </td>";   
$tablaclientes .="<td class="."TablaTituloLeft"."> </td>"; 
$tablaclientes .="<td "."width="."450"." class="."TablaTituloDato".' style="font-weight:bold;"'."> Nombre</td>";   
$tablaclientes .="<td class="."TablaTituloLeft"."> </td>"; 
$tablaclientes .="<td width="."30"." class="."TablaTituloDatoR".' >'.GLO_FAButton('CmdAddA','submit','','self','Agregar','add','iconbtn').'</td>'; 
$tablaclientes .="<td class="."TablaTituloRight"."> </td>"; 
$tablaclientes .='</tr>';             
$estilo="";$link="";  $cont=0; 
while($row=mysql_fetch_array($rs)){
	$cont=$cont+1;  
	$tablaclientes .='<tr '.$estilo.'>';
	$tablaclientes .="<td class="."TablaMostrarLeft"."> </td>";  
	$tablaclientes .="<td  class="."TablaDato ".$link.' style="text-align:center;vertical-align:top"'." > ".$cont."</td>"; 
	$tablaclientes .="<td class="."TablaMostrarLeft"."> </td>";  
	$tablaclientes .="<td  class="."TablaDato ".$link." > ".substr($row['Sector'],0,50)."</td>"; 	 
	$tablaclientes .="<td class="."TablaMostrarLeft"."> </td>";  
	$tablaclientes .="<td  class="."TablaDatoR".">"; 
	$tablaclientes .=GLO_rowbutton("CmdBorrarFilaA",$row['Id'],"Eliminar",'self','trash','iconlgray','Eliminar',0,0,0); 
	$tablaclientes .="</td><td class="."TablaMostrarRight"."> </td></tr>";  
}	
$tablaclientes .="</table></td></tr></table>";echo $tablaclientes;	
mysql_free_result($rs);
}

function PL_TablaHistorial($idpadre,$conn){
$idpadre=intval($idpadre);
$query="SELECT a.*, ac.Nombre as Cambio, p.Nombre, p.Apellido From plan_audi a, auditoriaacciones ac, personal p where a.IdCambio=ac.Id and  a.IdPersonal=p.Id and a.IdPadre=$idpadre Order by a.Id";
$rs=mysql_query($query,$conn);
//Titulos de la tabla
$tablaclientes='<table width="700" border="0"  cellpadding="0" cellspacing="0"><tr> <td height="5"  ></td> </tr><tr ><td height="18" ><i class="fa fa-user-edit iconsmallsp iconlgray"></i> <strong>Cambios realizados:</strong></td></tr><tr> <td  align="center" >';
$tablaclientes .="<table width="."700"." border="."0"." cellspacing="."0"." cellpadding="."0"." ><tr>";
$tablaclientes .='<td class="TablaTituloLeft"></td>'; 
$tablaclientes .="<td "."width="."70"." class="."TablaTituloDato"."> Fecha</td>";   
$tablaclientes .='<td class="TablaTituloLeft"></td>';  
$tablaclientes .="<td "."width="."200"." class="."TablaTituloDato"."> Cambio</td>";  
$tablaclientes .='<td class="TablaTituloLeft"></td>';  
$tablaclientes .="<td "."width="."430"." class="."TablaTituloDato"."> Usuario</td>";  
$tablaclientes .='<td class="TablaTituloRight"></td>';  
$tablaclientes .='</tr>';             
//Datos
while($row=mysql_fetch_array($rs)){
	$tablaclientes .=" <tr> ";  
	$tablaclientes .='<td class="TablaMostrarLeft"></td>';  
	$tablaclientes .="<td  class="."TablaDato"." > ".GLO_FormatoFecha($row['Fecha'])."</td>"; 
	$tablaclientes .='<td class="TablaMostrarLeft"></td>';  
	$tablaclientes .="<td  class="."TablaDato"." > ".substr($row['Cambio'],0,20)."</td>"; 
	$tablaclientes .='<td class="TablaMostrarLeft"></td>';  
	$tablaclientes .="<td  class="."TablaDato"." > ".substr($row['Apellido'].' '.$row['Nombre'],0,50)."</td>"; 
	$tablaclientes .="</td><td class="."TablaMostrarRight"."> </td></tr>";  
}	
$tablaclientes .='</table></td></tr><tr> <td height="5"></td></tr></table>';echo $tablaclientes;	
mysql_free_result($rs);
}



function PL_ColorEstado($idestado){
$colorest='';
if($idestado=='2'){$colorest=' style="font-weight:bold;color:#00bcd4"';}//celeste programado
if($idestado=='4'){$colorest=' style="font-weight:bold;color:#4CAF50"';}//verde claro en ejecucion 
if($idestado=='3'){$colorest=' style="font-weight:bold;color:#009900"';}//verde ejecutado
if($idestado=='5'){$colorest=' style="font-weight:bold;color:#3366cc"';}//azul cerrado
if($idestado=='1'){$colorest=' style="font-weight:bold;color:#f44336"';}//rojo rechazado
if($idestado=='6'){$colorest=' style="font-weight:bold;color:#ff9900"';}//naranja reprogramado
return $colorest;
}



function PL_ColorEstadoC($idestado){
$colorest='';
if($idestado=='2'){$colorest='font-weight:bold;color:#00bcd4';}//celeste programado
if($idestado=='4'){$colorest='font-weight:bold;color:#4CAF50';}//verde claro en ejecucion 
if($idestado=='3'){$colorest='font-weight:bold;color:#009900';}//verde ejecutado
if($idestado=='5'){$colorest='font-weight:bold;color:#3366cc';}//azul cerrado
if($idestado=='1'){$colorest='font-weight:bold;color:#f44336';}//rojo rechazado
if($idestado=='6'){$colorest='font-weight:bold;color:#ff9900';}//naranja reprogramado
echo $colorest;
}



function PL_Auditoria($accion,$padre,$conn){
	$fecha=FechaMySql(date("d-m-Y"));$pers=intval($_SESSION["GLO_IdPersLog"]);$padre=intval($padre);
	//inserto
	$nroId=GLO_generoID("plan_audi",$conn);
	$query="INSERT INTO plan_audi(Id,IdPadre,IdCambio,IdPersonal,Fecha) VALUES ($nroId,$padre,$accion,$pers,'$fecha')";	
	$rs2=mysql_query($query,$conn);		
}
?>