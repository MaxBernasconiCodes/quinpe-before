<? if ($_SESSION["IdPerfilUser"]!=1 and $_SESSION["IdPerfilUser"]!=2  and $_SESSION["IdPerfilUser"]!=3  and $_SESSION["IdPerfilUser"]!=9 and $_SESSION["IdPerfilUser"]!=14){ header("Location:".$_SESSION["NivelArbol"]."Inicio.php");}

function INCID_MostrarTabla($conn){
$query=$_SESSION['TxtQINCID'];$query=str_replace("\\", "", $query);
if (  ($query!="")){	
	$rs=mysql_query($query,$conn);
	if(mysql_num_rows($rs)!=0){	
		//Titulos de la tabla
		$tablaclientes='';
		$tablaclientes .=GLO_inittabla(1000,1,0,0);
		$tablaclientes .="<td "."width="."60"." class="."TableShowT"."> N&uacute;mero</td>";   
		$tablaclientes .="<td "."width="."70"." class="."TableShowT"."> Fecha</td>";   
		$tablaclientes .="<td "."width="."150"." class="."TableShowT"."> Sector</td>";   
		$tablaclientes .="<td "."width="."150"." class="."TableShowT"."> Lugar</td>"; 
		$tablaclientes .="<td "."width="."100"." class="."TableShowT"."> Denunciante</td>"; 
		$tablaclientes .="<td "."width="."360"." class="."TableShowT"."> Tipo</td>"; 
		$tablaclientes .="<td "."width="."80"." class="."TableShowT"." > Estado</td>"; 
		$tablaclientes .="<td "."width="."30"." class="."TableShowT"."></td>";   
		$tablaclientes .='</tr>';    
		$recuento=0;          
		$clase="TableShowD";
		while($row=mysql_fetch_array($rs)){ 			
			GLO_LinkRowTablaInit($estilo,$link,$row['Id'],0);
			include("zTipoIncidente.php");
			//muestro
			$tablaclientes .='<tr '.$estilo.GLO_highlight($row['Id']).'>';
			$tablaclientes .="<td class=".$clase.$link."> ".str_pad($row['Id'], 6, "0", STR_PAD_LEFT)."</td>"; 
			$tablaclientes .="<td class=".$clase.$link."> ".GLO_FormatoFecha($row['Fecha'])."</td>"; 
			$tablaclientes .="<td class=".$clase.$link."> ".substr($row['Sector'],0,18)."</td>"; 
			$tablaclientes .="<td class=".$clase.$link."> ".substr($row['Yac'],0,18)."</td>"; 
			$tablaclientes .="<td class=".$clase.$link."> ".substr($row['Ap2'].' '.$row['Nom2'],0,12)."</td>";  
			$tablaclientes .="<td class=".$clase.$link."> ".substr($tipoincidente,0,65)."</td>"; 
			$tablaclientes .="<td class=".$clase.$link.INC_colorestado($row['IdE'])."> ".INC_estado($row['IdE'])."</td>"; 
			$tablaclientes .="<td class="."TableShowD"." style='text-align:center;'>";  						
			$tablaclientes .=GLO_rowbutton("CmdBorrarFila",$row['Id'],"Eliminar",'self','trash','iconlgray','Eliminar',1,0,0);  					
			$tablaclientes .="</td>";  
			$tablaclientes .='</tr>'; 
			$recuento=$recuento+1;
		}	
		$tablaclientes .=GLO_fintabla(1,0,$recuento);
		echo $tablaclientes;	
	}else{echo '<p class="MuestraConf" align="center">No existen datos que cumplan esos criterios</p>';}
	mysql_free_result($rs);
}
}


function INC_TablaInvolucrados($idpadre,$conn){
$idpadre=intval($idpadre);
$query="SELECT m.*,p.Nombre as Nom,p.Apellido as Ap From incidentes_per m,personal p where m.IdPersonal=p.Id and m.IdP=$idpadre Order by m.Id";
$rs=mysql_query($query,$conn);
//Titulos de la tabla
$tablaclientes='';
$tablaclientes .='<table width="750" class="TableShow" id="tshow"><tr>';
$tablaclientes .="<td "."width="."310"." class="."TableShowT".' style="font-weight:bold;"'."> Involucrado</td>";   
$tablaclientes .="<td "."width="."400"." class="."TableShowT"."> Observaciones</td>";  
$tablaclientes .='<td width="40" class="TableShowT TAR" >'.GLO_FAButton('CmdAddP','submit','','self','Agregar','add','iconbtn').'</td>'; 
$tablaclientes .='</tr>';             
$estilo=" style='cursor:pointer;' ";  
while($row=mysql_fetch_array($rs)){
	$link=" onclick="."location='ModificarP.php?Flag1=True"."&id=".$row['Id']."'";
	$tablaclientes .='<tr '.$estilo.'>';
	//si carga personal lo muestra, sino muestra texto
	if($row['IdPersonal']==0){$tablaclientes .="<td  class="."TableShowD ".$link." > ".substr($row['Nombre'],0,36)."</td>";}
	else{$tablaclientes .="<td  class="."TableShowD ".$link." > ".substr($row['Ap'].' '.$row['Nom'],0,36)."</td>";}		 
	$tablaclientes .="<td  class="."TableShowD ".$link." > ".substr($row['Obs'],0,50)."</td>"; 
	$tablaclientes .='<td  class="TableShowD TAR">'; 
	$tablaclientes .=GLO_rowbutton("CmdBorrarFilaP",$row['Id'],"Eliminar",'self','trash','iconlgray','Eliminar',0,0,0); 
	$tablaclientes .="</td></tr>";  
}	
$tablaclientes .="</table>";echo $tablaclientes;	
mysql_free_result($rs);
}


function INC_TablaMedidas($idpadre,$conn){
$idpadre=intval($idpadre);
$query="SELECT m.*,p.Nombre as N,p.Apellido as A From incidentes_med m,personal p where m.IdPersonal=p.Id and m.IdP=$idpadre Order by m.Id";
$rs=mysql_query($query,$conn);
//Titulos de la tabla
$tablaclientes='';
$tablaclientes .='<table width="750" class="TableShow" id="tshow"><tr>';
$tablaclientes .="<td "."width="."520"." class="."TableShowT".' style="font-weight:bold;"'."> Medidas</td>";   
$tablaclientes .="<td "."width="."120"." class="."TableShowT".' style="font-weight:bold;"'."> Responsable</td>";   
$tablaclientes .="<td "."width="."70"." class="."TableShowT".' style="font-weight:bold;"'."> Estado</td>";  
$tablaclientes .='<td width="40" class="TableShowT TAR" >'.GLO_FAButton('CmdAddM','submit','','self','Agregar','add','iconbtn').'</td>'; 
$tablaclientes .='</tr>';             
$estilo=" style='cursor:pointer;' "; $cont=0; 
while($row=mysql_fetch_array($rs)){
	$link=" onclick="."location='ModificarM.php?Flag1=True"."&id=".$row['Id']."'";
	//estado
	if($row['Estado']==0){$estado='Pendiente';$colorestado=' style="color:#f44336;vertical-align:top"';}
	if($row['Estado']==1){$estado='Realizada';$colorestado=' style="color:#00bcd4;vertical-align:top"';}
	if($row['Estado']==2){$estado='Cancelada';$colorestado=' style="color:#cc0099;vertical-align:top"';}
	//
	$cont=$cont+1; 
	$tablaclientes .='<tr '.$estilo.'>';
	$tablaclientes .="<td  class="."TableShowD ".$link.' style="white-space:normal;"'."> ".substr($row['Obs'],0,70)."</td>"; 
	$tablaclientes .="<td  class="."TableShowD ".$link.' style="vertical-align:top"'." > ".substr($row['A'].' '.$row['N'],0,15)."</td>";
	$tablaclientes .="<td  class="."TableShowD ".$link.$colorestado."> ".$estado."</td>"; 
	$tablaclientes .='<td  class="TableShowD TAR">'; 
	$tablaclientes .=GLO_rowbutton("CmdBorrarFilaM",$row['Id'],"Eliminar",'self','trash','iconlgray','Eliminar',0,0,0); 
	$tablaclientes .="</td></tr>";  
}	
$tablaclientes .="</table>";echo $tablaclientes;	
mysql_free_result($rs);
}


//estado
function INC_cbestado($campo){
	$combo="";
	if( "1" == $_SESSION[$campo]) { $combo .= " <option value="."'1'"." selected='selected'>"."ABIERTO"."</option>\n";}else{$combo .= " <option value="."'1'"." >"."ABIERTO"."</option>\n";}
	if( "2" == $_SESSION[$campo]) { $combo .= " <option value="."'2'"." selected='selected'>"."CERRADO"."</option>\n";}else{$combo .= " <option value="."'2'"." >"."CERRADO"."</option>\n";}
	echo $combo;
}
function INC_colorestado($idestado){
	$colorest='';
	if($idestado=='0'){$colorest=' style="font-weight:bold;color:#ef6c00"';}// naranja
	if($idestado=='1'){$colorest=' style="font-weight:bold;color:#0F9D58"';}//verde
	return $colorest;
}
function INC_estado($idestado){
	$est='';
	if($idestado=='0'){$est='ABIERTO';}
	if($idestado=='1'){$est='CERRADO';}
	return $est;
}



?>