<? 
//seguridad includes
if(!isset($_SESSION)){include("../../Codigo/SeguridadIncludes.php");}
else{include($_SESSION["NivelArbol"]."Codigo/SeguridadIncludes.php");}





function STOCK_ColorMovimiento($tipo){
	$res='';
	//ingreso
	if($tipo==1 or $tipo==3){$res='<i class="fa fa-arrow-down TLGreen" style="font-size: 1.3rem;"></i>';}
	//egreso
	if($tipo==2 or $tipo==4){$res='<i class="fa fa-arrow-up TLRed" style="font-size: 1.3rem;"></i>';}
	return $res;	
}




function STOCK_BuscarStock($iddep,$iditem,$iditem2,$idcliprop,$conn){//buscar stock del articulo/dep o prod/dep		
	$stock=0;
	if($iditem!=0){
		$query="Select * From stockdepositos Where IdArticulo=$iditem and IdDeposito=$iddep and IdCliente=$idcliprop";
	}else{$query="Select * From stockdepositos Where IdItem=$iditem2 and IdDeposito=$iddep and IdCliente=$idcliprop";}	
	$rs2=mysql_query($query,$conn);
	while($row2=mysql_fetch_array($rs2)){$stock=$row2['Stock'];}mysql_free_result($rs2);
	return $stock;
}



function STOCK_TablaDetalle($idpadre,$tipomov,$idcam,$idpedido,$idcliprop,$conn){//vienen de OC(compra) o de NP(almacen)
	$idpadre=intval($idpadre);
	$tipomov=intval($tipomov);
	$idcam=intval($idcam);$idcliprop=intval($idcliprop);
	$query="SELECT s.*, a.Nombre as Articulo,a.Modelo,a.Stock as FS, m.Nombre as Marca,npi.NroOC,npi.Obs as ObsItem,per.Nombre as NAudi,per.Apellido as AAudi,il.Nombre as Prod,u.Abr,u2.Abr as Abr2 From stockmov_items s, epparticulos a,marcas m,co_npedido np,co_npedido_it npi,personal per,items il,unidadesmedida u,unidadesmedida u2 where s.IdItemNP=npi.Id and np.Id=npi.IdNP and s.IdArticulo=a.Id and a.IdMarca=m.Id and s.IdNP=np.Id and per.Id=s.IdUser and s.IdItem=il.Id and a.IdUnidad=u.Id and il.IdUnidad=u2.Id and s.IdMov=$idpadre Order by a.Nombre,il.Nombre";
	$rs=mysql_query($query,$conn);
	//
	$tablaclientes='<table width="980" border="0"  cellpadding="0" cellspacing="0"><tr><td height="5"></td></tr>';
	//rtos asociados a cam o pedidos no se modifican
	if($idcam==0 and $idpedido==0){
		//RI/AI
		if($tipomov==1 or $tipomov==3){$tablaclientes .='<tr><td align="right">'.GLO_FAButton('CmdAddD2','submit','90','self','Items OC','add','boton02').'</td></tr>';}
		//RE/AE
		if($tipomov==2 or $tipomov==4){$tablaclientes .='<tr><td align="right">'.GLO_FAButton('CmdAddD4','submit','90','self','Items NP','add','boton02').'</td></tr>';}
	}
	//Titulos de la tabla
	$tablaclientes .='<tr><td height="3"></td></tr><tr> <td  align="center" ><table width="980" border="0"  cellpadding="0" cellspacing="0"><tr>';
	$tablaclientes .='<td class="TablaTituloLeft"></td>';
	$tablaclientes .="<td "."width="."70"." class="."TablaTituloDato"." style='text-align:right;'> Cantidad</td>"; 
	$tablaclientes .='<td class="TablaTituloLeft"></td>';
	$tablaclientes .="<td "."width="."70"." class="."TablaTituloDato"." style='text-align:right;'> Stock</td>"; 
	$tablaclientes .='<td class="TablaTituloLeft"></td>';  
	$tablaclientes .="<td "."width="."40"." class="."TablaTituloDato"."></td>";  
	$tablaclientes .='<td class="TablaTituloLeft"></td>';  
	$tablaclientes .="<td "."width="."390"." class="."TablaTituloDato"."> Articulo o Producto</td>";  
	$tablaclientes .='<td class="TablaTituloLeft"></td>';
	$tablaclientes .="<td "."width="."200"." class="."TablaTituloDato"."> Obs.Item Pedido</td>"; 
	$tablaclientes .='<td class="TablaTituloLeft"></td>';
	$tablaclientes .="<td "."width="."50"." class="."TablaTituloDato"." style='text-align:right;'> OC</td>"; 
	$tablaclientes .='<td class="TablaTituloLeft"></td>';
	$tablaclientes .="<td "."width="."60"." class="."TablaTituloDato"." style='text-align:right;'> Pedido</td>";  
	$tablaclientes .='<td class="TablaTituloLeft"></td>';
	$tablaclientes .="<td "."width="."70"." class="."TablaTituloDato".">Registr&oacute;</td>"; 
	$tablaclientes .='<td class="TablaTituloLeft"></td>'; 
	$tablaclientes .="<td width="."30"." class="."TablaTituloDatoR".">";
	//rtos asociados a cam o pedidos no se modifican
	if($idcam==0 and $idpedido==0){$tablaclientes .=GLO_FAButton('CmdAddD','submit','','self','Agregar','add','iconbtn');} 
	$tablaclientes .='</td><td class="TablaTituloRight"></td>';  
	$tablaclientes .='</tr>';            
	while($row=mysql_fetch_array($rs)){
		//articulo o producto
		if($row['IdArticulo']>0){
			$textoart=str_pad($row['IdArticulo'], 6, "0", STR_PAD_LEFT).' '.$row['Articulo'];$abr=$row['Abr'];
		}else{$textoart=str_pad($row['IdItem'], 6, "0", STR_PAD_LEFT).' '.$row['Prod'];$abr=$row['Abr2'];}
		if($row['NroOC']=='0' or $row['NroOC']==''){$oc='';}else{$oc=$row['NroOC'];}
		if($row['IdNP']==0){$np='';}else{$np=str_pad($row['IdNP'], 8, "0", STR_PAD_LEFT);}	
		//buscar stock del articulo/dep o prod/dep
		$iddep=intval($_SESSION['CbDep']);$iditem=$row['IdArticulo'];$iditem2=$row['IdItem'];
		$stock=STOCK_BuscarStock($iddep,$iditem,$iditem2,$idcliprop,$conn);
		//
		$tablaclientes .=" <tr> ";  
		$tablaclientes .='<td class="TablaMostrarLeft"></td>'; 
		$tablaclientes .="<td  class="."TablaDato"."  style='text-align:right;'> ".$row['Cantidad']."</td>"; 
		$tablaclientes .='<td class="TablaMostrarLeft"></td>'; 
		$tablaclientes .="<td  class="."TablaDato"."  style='text-align:right;'> ".$stock."</td>"; 
		$tablaclientes .='<td class="TablaMostrarLeft"></td>'; 
		$tablaclientes .="<td  class="."TablaDato".'>'.substr($abr,0,5)."</td>"; 
		$tablaclientes .='<td class="TablaMostrarLeft"></td>'; 
		$tablaclientes .="<td  class="."TablaDato".' title="'.$textoart.'">'.substr($textoart,0,43)."</td>"; 
		$tablaclientes .='<td class="TablaMostrarLeft"></td>'; 
		$tablaclientes .="<td  class="."TablaDato".' title="'.$row['ObsItem'].'">'.substr($row['ObsItem'],0,24)."</td>"; 
		$tablaclientes .='<td class="TablaMostrarLeft"></td>';  
		$tablaclientes .="<td class="."TablaDato"." style='text-align:right;'> ".$oc."</td>"; 
		$tablaclientes .='<td class="TablaMostrarLeft"></td>';  
		$tablaclientes .="<td class="."TablaDato"." style='text-align:right;'> ".$np."</td>"; 
		$tablaclientes .='<td class="TablaMostrarLeft"></td>'; 
		$tablaclientes .="<td  class="."TablaDato"." > ".substr($row['AAudi'].' '.$row['NAudi'],0,8)."</td>"; 
		$tablaclientes .='<td class="TablaMostrarLeft"></td>';  
		$tablaclientes .="<td  class="."TablaDatoR".">"; 
		//rtos asociados a cam o pedidos no se modifican
		if($idcam==0 and $idpedido==0){$tablaclientes .=GLO_rowbutton("CmdBorrarFilaD",$row['Id'],"Eliminar",'self','trash','iconlgray','Eliminar',0,0,0);}
		$tablaclientes .="</td><td class="."TablaMostrarRight"."> </td></tr>";  
	}mysql_free_result($rs);	
	$tablaclientes .="</table></td></tr></table> ";
	echo $tablaclientes;		
}


function STOCK_TablaDetalleRI($idpadre,$idcam,$idpedido,$idcliprop,$conn){//siempre vienen de OC
	$idpadre=intval($idpadre);
	$idcam=intval($idcam);$idcliprop=intval($idcliprop);
	$query="SELECT s.*, a.Nombre as Articulo,a.Modelo,a.Stock as FS, m.Nombre as Marca,npi.NroOC,npi.Obs as ObsItem,per.Nombre as NAudi,per.Apellido as AAudi,il.Nombre as Prod,u.Abr,u2.Abr as Abr2  From stockmov_items s, epparticulos a,marcas m,co_npedido np,co_npedido_it npi,personal per,items il,unidadesmedida u,unidadesmedida u2 where s.IdItemNP=npi.Id and np.Id=npi.IdNP and s.IdArticulo=a.Id and a.IdMarca=m.Id and s.IdNP=np.Id and per.Id=s.IdUser and s.IdItem=il.Id and a.IdUnidad=u.Id and il.IdUnidad=u2.Id and s.IdMov=$idpadre Order by a.Nombre,il.Nombre";
	$rs=mysql_query($query,$conn);
	//Titulos de la tabla
	$tablaclientes='<table width="980" border="0"  cellpadding="0" cellspacing="0"><tr><td height="3"></td></tr>';
	//rtos asociados a cam no se modifican
	if($idcam==0 and $idpedido==0){$tablaclientes .='<tr><td align="right">'.GLO_FAButton('CmdAddD2','submit','90','self','Items OC','add','boton02').'</td></tr>';}
	$tablaclientes .='<tr><td height="3"></td></tr><tr> <td  align="center" ><table width="980" border="0"  cellpadding="0" cellspacing="0"><tr>';
	$tablaclientes .='<td class="TablaTituloLeft"></td>';
	$tablaclientes .="<td "."width="."70"." class="."TablaTituloDato"." style='text-align:right;'> Cantidad</td>"; 
	$tablaclientes .='<td class="TablaTituloLeft"></td>';
	$tablaclientes .="<td "."width="."70"." class="."TablaTituloDato"." style='text-align:right;'> Pendiente</td>"; 
	$tablaclientes .='<td class="TablaTituloLeft"></td>';
	$tablaclientes .="<td "."width="."50"." class="."TablaTituloDato"." style='text-align:right;'> Stock</td>"; 
	$tablaclientes .='<td class="TablaTituloLeft"></td>';  
	$tablaclientes .="<td "."width="."40"." class="."TablaTituloDato"."></td>";  
	$tablaclientes .='<td class="TablaTituloLeft"></td>';  
	$tablaclientes .="<td "."width="."340"." class="."TablaTituloDato"."> Articulo o Producto</td>";  
	$tablaclientes .='<td class="TablaTituloLeft"></td>';
	$tablaclientes .="<td "."width="."200"." class="."TablaTituloDato"."> Obs.Item Pedido</td>"; 
	$tablaclientes .='<td class="TablaTituloLeft"></td>';
	$tablaclientes .="<td "."width="."50"." class="."TablaTituloDato"." style='text-align:right;'> OC</td>";   
	$tablaclientes .='<td class="TablaTituloLeft"></td>';
	$tablaclientes .="<td "."width="."60"." class="."TablaTituloDato"." style='text-align:right;'> Pedido</td>";  
	$tablaclientes .='<td class="TablaTituloLeft"></td>';
	$tablaclientes .="<td "."width="."70"." class="."TablaTituloDato".">Registr&oacute;</td>"; 
	$tablaclientes .='<td class="TablaTituloLeft"></td>'; 
	$tablaclientes .="<td width="."30"." class="."TablaTituloDatoR".">";
	//rtos asociados a cam no se modifican
	if($idcam==0 and $idpedido==0){$tablaclientes .=GLO_FAButton('CmdAddD','submit','','self','Agregar','add','iconbtn'); }	
	$tablaclientes .='</td><td class="TablaTituloRight"></td>';  
	$tablaclientes .='</tr>';             
	$estilo=" style='cursor:pointer;' ";$clase="TablaDato";	
	while($row=mysql_fetch_array($rs)){
		$link=" onclick="."location='ModificarItemRI.php?Flag1=True"."&IdItem=".$row['Id']."&Id=".$idpadre."'";
		//articulo o producto
		if($row['IdArticulo']>0){
			$textoart=str_pad($row['IdArticulo'], 6, "0", STR_PAD_LEFT).' '.$row['Articulo'];$abr=$row['Abr'];
		}else{$textoart=str_pad($row['IdItem'], 6, "0", STR_PAD_LEFT).' '.$row['Prod'];$abr=$row['Abr2'];}

		if($row['NroOC']=='0' or $row['NroOC']==''){$oc='';}else{$oc=$row['NroOC'];}
		if($row['IdNP']==0){$np='';}else{$np=str_pad($row['IdNP'], 8, "0", STR_PAD_LEFT);}	
		//buscar stock del articulo/dep o prod/dep
		$iddep=intval($_SESSION['CbDep']);$iditem=$row['IdArticulo'];$iditem2=$row['IdItem'];
		$stock=STOCK_BuscarStock($iddep,$iditem,$iditem2,$idcliprop,$conn);
		//buscar pendiente
		$pdte=0;
		$query="SELECT npi.CantAuto From co_npedido_it npi Where npi.Id=".$row['IdItemNP'];
		$rs2=mysql_query($query,$conn);	while($row2=mysql_fetch_array($rs2)){$pdte=$row2['CantAuto']-$row['Cantidad'];}mysql_free_result($rs2);
		if($pdte>0){$pdte=number_format($pdte,2, '.', '');}else{$pdte='';}
		//
		$tablaclientes .="<tr".$estilo."> "; 
		$tablaclientes .='<td class="TablaMostrarLeft"></td>'; 
		$tablaclientes .="<td  class=".$clase.$link."  style='text-align:right;'> ".$row['Cantidad']."</td>"; 
		$tablaclientes .='<td class="TablaMostrarLeft"></td>'; 
		$tablaclientes .="<td  class=".$clase.$link."  style='text-align:right;font-weight:bold;color:#f44336;'> ".$pdte."</td>"; 
		$tablaclientes .='<td class="TablaMostrarLeft"></td>'; 
		$tablaclientes .="<td  class=".$clase.$link."  style='text-align:right;'> ".$stock."</td>"; 
		$tablaclientes .='<td class="TablaMostrarLeft"></td>'; 
		$tablaclientes .="<td  class="."TablaDato".'>'.substr($abr,0,5)."</td>"; 
		$tablaclientes .='<td class="TablaMostrarLeft"></td>'; 
		$tablaclientes .="<td  class=".$clase.$link.' title="'.$textoart.'">'.substr($textoart,0,43)."</td>"; 
		$tablaclientes .='<td class="TablaMostrarLeft"></td>'; 
		$tablaclientes .="<td  class="."TablaDato".' title="'.$row['ObsItem'].'">'.substr($row['ObsItem'],0,24)."</td>"; 
		$tablaclientes .='<td class="TablaMostrarLeft"></td>';  
		$tablaclientes .="<td class=".$clase.$link." style='text-align:right;'> ".$oc."</td>"; 
		$tablaclientes .='<td class="TablaMostrarLeft"></td>';  
		$tablaclientes .="<td class=".$clase.$link." style='text-align:right;'> ".$np."</td>"; 
		$tablaclientes .='<td class="TablaMostrarLeft"></td>'; 
		$tablaclientes .="<td  class="."TablaDato".$link." > ".substr($row['AAudi'].' '.$row['NAudi'],0,8)."</td>"; 
		$tablaclientes .='<td class="TablaMostrarLeft"></td>';  
		$tablaclientes .='<td class="TablaDatoR">';
		//rtos asociados a cam no se modifican
		if($idcam==0 and $idpedido==0){$tablaclientes .=GLO_rowbutton("CmdBorrarFilaD",$row['Id'],"Eliminar",'self','trash','iconlgray','Eliminar',0,0,0);} 
		$tablaclientes .='</td><td class="TablaMostrarRight"> </td></tr>';  
	}mysql_free_result($rs);
	$tablaclientes .="</table></td></tr></table> ";
	echo $tablaclientes;		
}



function STOCK_TablaDetallePlanta($idpadre,$readonly,$idcam,$idpedido,$idcliprop,$conn){
	//productos ingresados a planta desde barrera
	$idpadre=intval($idpadre);$idcam=intval($idcam);$idcliprop=intval($idcliprop);
	$query="SELECT s.*, il.Nombre as Prod,e.Nombre as Env,a.Lote,a.Rto, art.Nombre as Articulo,um.Abr ,u2.Abr as Abr2 From stockmov_items s, items il,cam a,procesosop_e1_it a2,envases e,epparticulos art,unidadesmedida um,unidadesmedida u2 where s.IdItem=il.Id and s.IdCAM=a.Id and a2.Id=a.IdPE1IT and a2.IdEnv=e.Id and s.IdArticulo=art.Id and art.IdUnidad=um.Id and il.IdUnidad=u2.Id  and s.IdMov=$idpadre Order by  art.Nombre,il.Nombre";
	$rs=mysql_query($query,$conn);
	//Titulos de la tabla
	$tablaclientes ='';
	$tablaclientes .=GLO_inittabla(960,1,0,0);
	$tablaclientes .="<td "."width="."70"." class="."TableShowT"." style='text-align:right;'> Cantidad</td>"; 
	$tablaclientes .="<td "."width="."80"." class="."TableShowT"." style='text-align:right;'> Stock</td>"; 
	$tablaclientes .='<td width="40" class="TableShowT" > </td>'; 
	$tablaclientes .="<td "."width="."420"." class="."TableShowT"."> Articulo o Producto</td>";  
	$tablaclientes .='<td width="100" class="TableShowT" > Envase</td>'; 
	$tablaclientes .="<td "."width="."100"." class="."TableShowT".">Lote</td>"; 
	$tablaclientes .="<td "."width="."100"." class="."TableShowT".">Remito</td>"; 
	$tablaclientes .='<td width="50" class="TableShowT TAR">'; 
	//rtos asociados a cam no se modifican
	if($idcam==0 and $readonly==0){$tablaclientes .=GLO_FAButton('CmdAddD','submit','','self','Agregar','add','iconbtn');} 
	$tablaclientes .="</td></tr>"; 
	$estilo="";$link="";$clase="TableShowD";	
	while($row=mysql_fetch_array($rs)){		
		//articulo o producto
		if($row['IdArticulo']>0){
			$textoart=str_pad($row['IdArticulo'], 6, "0", STR_PAD_LEFT).' '.$row['Articulo'];$abr=$row['Abr'];
		}else{$textoart=str_pad($row['IdItem'], 6, "0", STR_PAD_LEFT).' '.$row['Prod'];$abr=$row['Abr2'];}
		//buscar stock del articulo/dep o prod/dep
		$iddep=intval($_SESSION['CbDep']);$iditem=$row['IdArticulo'];$iditem2=$row['IdItem'];
		$stock=STOCK_BuscarStock($iddep,$iditem,$iditem2,$idcliprop,$conn);
		//si es ajuste y es producto sin cam selecciona datos
		if($idcam==0 and $idpedido==0 and $row['IdItem']!=0){
			//envase
			$comboenv=ComboTablaRFXMasivo("envases",$row['IdEnvIT'],"Nombre","","",$conn);
			$envprod='<select name="CbEnv['.$row['Id'].']" style="width:90px" class="campos"><option value=""></option>'.$comboenv.' </select>';
			//lote
			$loteprod='<input name="TxtVal['.$row['Id'].']" style="width:90px" type="text"  class="TextBox"  maxlength="10" value="'.$row['LoteIT'].'">';
		}else{
			$envprod=substr($row['Env'],0,12);$loteprod=substr($row['Lote'],0,12);
		}
		//
		$tablaclientes .='<tr '.$estilo.GLO_highlight($row['Id']).'>';
		$tablaclientes .="<td  class=".$clase.$link."  style='text-align:right;'> ".$row['Cantidad']."</td>"; 
		$tablaclientes .="<td  class=".$clase.$link."  style='text-align:right;'> ".$stock."</td>"; 
		$tablaclientes .="<td  class=".$clase.$link.' >'.substr($abr,0,45)."</td>"; 
		$tablaclientes .="<td  class=".$clase.$link.' title="'.$textoart.'">'.substr($textoart,0,50)."</td>"; 
		$tablaclientes .="<td class=".$clase.$link." > ".$envprod."</td>"; 
		$tablaclientes .="<td class=".$clase.$link." > ".$loteprod."</td>"; 
		$tablaclientes .="<td class=".$clase.$link." > ".substr($row['Rto'],0,12)."</td>"; 
		$tablaclientes .='<td class="TableShowD TAR">';
		//si es modulo operaciones, y es ajuste producto ofrece grabar
		if($idcam==0 and $idpedido==0 and $row['IdItem']!=0 and $readonly==0){
			$tablaclientes .=GLO_rowbutton("CmdGrabaFilaD",$row['Id'],"Guardar",'self','save','iconlgray','',1,0,0); 
		}
		//rtos asociados a cam no se modifican, solo desde operaciones
		if($readonly==0){
			$tablaclientes .=' &nbsp; '.GLO_rowbutton("CmdBorrarFilaD",$row['Id'],"Eliminar",'self','trash','iconlgray','Eliminar',1,0,0); 
		}	

		$tablaclientes .='</td></tr>';  
		
	}mysql_free_result($rs);
	$tablaclientes .=GLO_fintabla(0,0,0);
	echo $tablaclientes;	
	}


	function STOCK_MostrarTabla($query,$tipo,$conn){ //tipo 0:compras, 1:planta
		if ($query!=""){	
			$rs=mysql_query($query,$conn);
			if(mysql_num_rows($rs)!=0){	
				$tablaclientes='';
				$tablaclientes .=GLO_inittabla(1020,1,0,0);
				$tablaclientes .="<td "."width="."70"." class="."TableShowT"."> Fecha</td>";  
				$tablaclientes .="<td "."width="."30"." class="."TableShowT"."> </td>";   
				$tablaclientes .="<td "."width="."120"." class="."TableShowT"."> Tipo</td>";   
				$tablaclientes .="<td "."width="."70"." class="."TableShowT"." style='text-align:right;'> Movimiento</td>";   
				$tablaclientes .="<td "."width="."70"." class="."TableShowT"." style='text-align:right;'> Ingreso</td>";   
				$tablaclientes .="<td "."width="."70"." class="."TableShowT"." style='text-align:right;'> Egreso</td>"; 
				$tablaclientes .="<td "."width="."130"." class="."TableShowT"."> Propietario</td>";   
				$tablaclientes .="<td "."width="."130"." class="."TableShowT"."> Dep&oacute;sito</td>"; 
				$tablaclientes .="<td "."width="."100"." class="."TableShowT"."> Origen</td>";
				$tablaclientes .="<td "."width="."100"." class="."TableShowT"."> Remito</td>"; 
				$tablaclientes .="<td "."width="."50"." class="."TableShowT"." style='text-align:right;'> COA</td>"; 
				$tablaclientes .="<td "."width="."50"." class="."TableShowT"." style='text-align:right;'> Pedido</td>"; 
				$tablaclientes .="<td "."width="."30"." class="."TableShowT"."> </td>"; 
				$tablaclientes .='</tr>';    
				$recuento=0;$estilo=" style='cursor:pointer;'"; $clase="TableShowD";   
				$_SESSION['TxtOriStock']=0; //para ver a donde vuelve
				if($tipo==1){$_SESSION['TxtOriOPEPla']=0; } //planta
				while($row=mysql_fetch_array($rs)){ 
					//ver si es compras o planta
					if($tipo==0){$link=" onclick="."location='Stock/Modificar.php?Flag1=True&id=".$row['Id']."'";}			
					if($tipo==1){$link=" onclick="."location='Modificar.php?Flag1=True&id=".$row['Id']."'";}
					//
					$ingreso="";$egreso=""; $mov=$row['Id'];
					$query2="SELECT sum(Cantidad) as Total From stockmov_items where IdMov=$mov";$rs2=mysql_query($query2,$conn);
					while($row2=mysql_fetch_array($rs2)){$total=$row2['Total'];}mysql_free_result($rs2);
					if($row['IdTipoMov']==1 or $row['IdTipoMov']==3){$ingreso=$total;}else{$egreso=$total;}		
					$compr="";if($row['Suc']>0 or $row['Nro']>0){$compr=$row['Tipo'].str_pad($row['Suc'], 4, "0", STR_PAD_LEFT)."-".str_pad($row['Nro'], 8, "0", STR_PAD_LEFT);}	
					//muestro
					$tablaclientes .='<tr '.$estilo.GLO_highlight($row['Id']).'>'; 
					$tablaclientes .="<td class=".$clase.$link." > ".FormatoFecha($row['Fecha'])."</td>";
					$tablaclientes .="<td class=".$clase.$link." style='text-align:center;'> ".STOCK_ColorMovimiento($row['IdTipoMov'])."</td>";
					$tablaclientes .="<td class=".$clase.$link."> ".substr($row['TipoM'],0,14)."</td>"; 
					$tablaclientes .="<td class=".$clase.$link." style='text-align:right;'> ".str_pad($row['Id'], 6, "0", STR_PAD_LEFT)."</td>";  
					$tablaclientes .="<td class=".$clase.$link." style='text-align:right;'> ".$ingreso."</td>"; 
					$tablaclientes .="<td class=".$clase.$link." style='text-align:right;'> ".$egreso."</td>"; 
					$tablaclientes .="<td class=".$clase.$link."> ".substr($row['Cliente'],0,15)."</td>"; 
					$tablaclientes .="<td class=".$clase.$link."> ".substr($row['Deposito'],0,15)."</td>"; 
					$tablaclientes .="<td class=".$clase.$link."> ".substr($row['Ori'],0,12)."</td>"; 
					$tablaclientes .="<td class=".$clase.$link." > ".$compr."</td>"; 
					$tablaclientes .="<td class=".$clase.$link." style='text-align:right;'>".GLO_SinCeroSTRPAD($row['IdCAM'],5)."</td>";  
					$tablaclientes .="<td class=".$clase.$link." style='text-align:right;'>".GLO_SinCeroSTRPAD($row['IdPedido'],5)."</td>"; 
					$tablaclientes .="<td class=".$clase." style='text-align:center;'> ";
					//si esta asociado a COA solo elimina si es planta
					if($tipo==1 or ($tipo==0 and $row['IdCAM']==0 and $row['IdPedido']==0) ){
						$tablaclientes .=GLO_rowbutton("CmdBorrarFila",$row['Id'],"Eliminar",'self','trash','iconlgray','Eliminar',1,0,0);
					}
					$tablaclientes .='</td></tr>'; 
	
					$recuento=$recuento+1;
				}	mysql_free_result($rs);

				//exportar
				if($tipo==0){$tablaclientes .=GLO_fintabla(1,0,$recuento);}
				else{$tablaclientes .=GLO_fintabla(0,0,$recuento);}
				
				echo $tablaclientes;	
			}else{echo '<p class="MuestraConf" align="center">No existen datos que cumplan esos criterios</p>';}
			
		}
	}
		
?>