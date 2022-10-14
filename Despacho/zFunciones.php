<?//seguridad includes
if(!isset($_SESSION)){include("../Codigo/SeguridadIncludes.php");}
else{include($_SESSION["NivelArbol"]."Codigo/SeguridadIncludes.php");}


//estado pedido/solicitud
function DES_asignar_estado($idsolicitud,$idpedido,$conn){
    //por defecto es PENDIENTE(1)    
    $res=1;
    //si la solicitud esta cerrada es FINALIZADO(3)
    $query="SELECT Id FROM procesosop Where Estado=1 and Id=$idsolicitud";$rs10=mysql_query($query,$conn);
	if(mysql_num_rows($rs10)!=0){$res=3;}mysql_free_result($rs10);
    //si la solicitud esta abierta y en uso en alguna etapa es EN PROCESO
    if($res==1){
        //veo si registra paso x barrera
        $query="SELECT Id FROM procesosop_e1 Where IdPadre=$idsolicitud";
        $rs10=mysql_query($query,$conn);if(mysql_num_rows($rs10)!=0){$res=2;}mysql_free_result($rs10);
        //veo si registra paso x planta
        if($res==1){
            $query="SELECT Id FROM stockmov Where IdPedido=$idpedido";
            $rs10=mysql_query($query,$conn);if(mysql_num_rows($rs10)!=0){$res=2;}mysql_free_result($rs10);
        }
    }
    //vuelve
    return $res;
}

function DES_Estado($idestado,&$colorrow,&$colorfield,&$estado){
    //por defecto es PENDIENTE
    //si la solicitud esta abierta y en uso en alguna etapa es EN PROCESO
    //si la solicitud esta cerrada es FINALIZADO
    switch ($idestado) {
		case 1: $colorrow=' style="color:#ff9800;"';$colorfield='color:#ff9800;';$estado='PENDIENTE'; break;
		case 2:	$colorrow=' style="color:#0F9D58;"';$colorfield='color:#0F9D58;';$estado='EN PROCESO'; break;
        case 3:	$colorrow=' style="color:#0079b1;"';$colorfield='color:#0079b1;';$estado='FINALIZADO'; break;
    }
    /* 16/05/22
    switch ($idestado) {
		case 1: $colorrow=' style="color:#ff9800;"';$colorfield='color:#ff9800;';$estado='PENDIENTE'; break;//pdte
		case 2:	$colorrow=' style="color:#0F9D58;"';$colorfield='color:#0F9D58;';$estado='PLANTA'; break;//aceptado
        case 3:	$colorrow=' style="color:#0F9D58;"';$colorfield='color:#0F9D58;';$estado='FIN PLANTA'; break;//fin planta
        case 4:	$colorrow=' style="color:#0079b1;"';$colorfield='color:#0079b1;';$estado='BARRERA'; break;//aceptado
        case 5:	$colorrow=' style="color:#0079b1;"';$colorfield='color:#0079b1;';$estado='FIN BARRERA'; break;//fin barrera
    }
    */
}
function DES_CbEstado($campo){
    $combo="";
    if( "1" == $_SESSION[$campo]) { $combo .= " <option value="."'1'"." selected='selected'>"."PENDIENTE"."</option>\n";}else{$combo .= " <option value="."'1'"." >"."PENDIENTE"."</option>\n";}
    if( "2" == $_SESSION[$campo]) { $combo .= " <option value="."'2'"." selected='selected'>"."EN PROCESO"."</option>\n";}else{$combo .= " <option value="."'2'"." >"."EN PROCESO"."</option>\n";}
    if( "3" == $_SESSION[$campo]) { $combo .= " <option value="."'3'"." selected='selected'>"."FINALIZADO"."</option>\n";}else{$combo .= " <option value="."'3'"." >"."FINALIZADO"."</option>\n";}
    echo $combo;

    /*16/05/22
    $combo="";
    if( "1" == $_SESSION[$campo]) { $combo .= " <option value="."'1'"." selected='selected'>"."PENDIENTE"."</option>\n";}else{$combo .= " <option value="."'1'"." >"."PENDIENTE"."</option>\n";}
    if( "2" == $_SESSION[$campo]) { $combo .= " <option value="."'2'"." selected='selected'>"."PLANTA"."</option>\n";}else{$combo .= " <option value="."'2'"." >"."PLANTA"."</option>\n";}
    if( "3" == $_SESSION[$campo]) { $combo .= " <option value="."'3'"." selected='selected'>"."FIN PLANTA"."</option>\n";}else{$combo .= " <option value="."'3'"." >"."FIN PLANTA"."</option>\n";}
    if( "4" == $_SESSION[$campo]) { $combo .= " <option value="."'4'"." selected='selected'>"."BARRERA"."</option>\n";}else{$combo .= " <option value="."'4'"." >"."BARRERA"."</option>\n";}
    if( "5" == $_SESSION[$campo]) { $combo .= " <option value="."'5'"." selected='selected'>"."FIN BARRERA"."</option>\n";}else{$combo .= " <option value="."'5'"." >"."FIN BARRERA"."</option>\n";}
    echo $combo;
    */
}



//estado etapa pedido/solicitud
function DES_CbEstadoPlanta($campo){
    $combo="";
    if( "1" == $_SESSION[$campo]) { $combo .= " <option value="."'1'"." selected='selected'>"."PENDIENTE"."</option>\n";}else{$combo .= " <option value="."'1'"." >"."PENDIENTE"."</option>\n";}
    if( "2" == $_SESSION[$campo]) { $combo .= " <option value="."'2'"." selected='selected'>"."FIN PLANTA"."</option>\n";}else{$combo .= " <option value="."'2'"." >"."FIN PLANTA"."</option>\n";}
    echo $combo;
}
function DES_EstadoPlanta($idestado,&$colorrow,&$colorfield,&$estado){
    $colorrow='';$colorfield='';$estado='';
    if($idestado<3){$colorrow=' style="color:#ff9800;"';$colorfield='color:#ff9800;';$estado='PENDIENTE';}
    if($idestado>2){$colorrow=' style="color:#0F9D58;"';$colorfield='color:#0F9D58;';$estado='FIN PLANTA';}
}




function DES_EstadoEtapa($idestado,&$colorrow,&$colorfield,&$estado){
    $colorrow='';$colorfield='';$estado='';
    switch ($idestado) {
		case 1: $colorrow=' style="color:#ff9800;"';$colorfield='color:#ff9800;';$estado='PENDIENTE'; break;//pdte
		case 2:	$colorrow=' style="color:#0F9D58;"';$colorfield='color:#0F9D58;';$estado='PLANTA'; break;//aceptado
        case 3:	$colorrow=' style="color:#0F9D58;"';$colorfield='color:#0F9D58;';$estado='FIN PLANTA'; break;//fin planta
        case 4:	$colorrow=' style="color:#0079b1;"';$colorfield='color:#0079b1;';$estado='BARRERA'; break;//aceptado
        case 5:	$colorrow=' style="color:#0079b1;"';$colorfield='color:#0079b1;';$estado='FIN BARRERA'; break;//fin barrera
    }
}
function DES_CbEstadoEtapa($campo){
    $combo="";
    if( "1" == $_SESSION[$campo]) { $combo .= " <option value="."'1'"." selected='selected'>"."PENDIENTE"."</option>\n";}else{$combo .= " <option value="."'1'"." >"."PENDIENTE"."</option>\n";}
    if( "2" == $_SESSION[$campo]) { $combo .= " <option value="."'2'"." selected='selected'>"."PLANTA"."</option>\n";}else{$combo .= " <option value="."'2'"." >"."PLANTA"."</option>\n";}
    if( "3" == $_SESSION[$campo]) { $combo .= " <option value="."'3'"." selected='selected'>"."FIN PLANTA"."</option>\n";}else{$combo .= " <option value="."'3'"." >"."FIN PLANTA"."</option>\n";}
    if( "4" == $_SESSION[$campo]) { $combo .= " <option value="."'4'"." selected='selected'>"."BARRERA"."</option>\n";}else{$combo .= " <option value="."'4'"." >"."BARRERA"."</option>\n";}
    if( "5" == $_SESSION[$campo]) { $combo .= " <option value="."'5'"." selected='selected'>"."FIN BARRERA"."</option>\n";}else{$combo .= " <option value="."'5'"." >"."FIN BARRERA"."</option>\n";}
    echo $combo;
}




//para identificar si corresponde a planta
//y que tipo de remitos genera el pedido en planta
function DES_estipoplanta($idtipo,$tipo){//$tipo 1:carga, 2:formulado
    $res=0;$carga=0;$formu=0;
    switch ($idtipo) {
		case 1: $res=1;$formu=1;break;//formulado
		case 2: $res=1;$carga=1;break;//carga
		case 4: $res=1;$carga=1;$formu=1;break;//formulado+carga
		case 5: $res=1;$carga=1;$formu=1;break;//formulado+carga+salida
        case 6: $res=1;$carga=1;break;//carga+salida
    }
    if($tipo==1){$res=$carga;}//carga
    if($tipo==2){$res=$formu;}//formulado
    return $res;
}
function DES_estipobarrera($idtipo){
    $res=0;
    switch ($idtipo) {
		case 3: $res=1;break;//salida
		case 5: $res=1;break;//formulado+carga+salida
        case 6: $res=1;break;//carga+salida
    }
    return $res;
}
  


//buscar datos
function DES_Dominios($idpadre,$conn,&$domcamion,&$domsemi){
    $domcamion='';$domsemi='';
    //busco datos propio
    $query="SELECT u1.Dominio,u2.Dominio as Dominio2 From despacho_p d,unidades u1, unidades u2 where d.IdUnidad=u1.Id and d.IdSemi=u2.Id and d.IdPadre=$idpadre LIMIT 1";$rs10=mysql_query($query,$conn);
    while($row10=mysql_fetch_array($rs10)){
        $domcamion=$row10['Dominio'];
        $domsemi=$row10['Dominio2'];
    }mysql_free_result($rs10);
    
    //busco datos tercero
    if($domcamion==''){
        $query="SELECT d.Dominio,d.Dominio2 From despacho_t d where d.IdPadre=$idpadre LIMIT 1";
        $rs10=mysql_query($query,$conn);
        while($row10=mysql_fetch_array($rs10)){
            $domcamion=$row10['Dominio'];
            $domsemi=$row10['Dominio2'];
        }mysql_free_result($rs10);
    }
}

function DES_Chofer($idpadre,$conn,&$chofer,&$dnichofer){
    $chofer='';$dnichofer='';
    //busco datos propio
    $query="SELECT p.Documento,p.Nombre as N, p.Apellido as A From despacho_p d,personal p where d.IdChofer=p.Id and d.IdPadre=$idpadre LIMIT 1";$rs10=mysql_query($query,$conn);
    while($row10=mysql_fetch_array($rs10)){
        $chofer=$row10['A'].' '.$row10['N'];
        $dnichofer=$row10['Documento'];
    }mysql_free_result($rs10);
    
    //busco datos tercero
    if($chofer==''){
        $query="SELECT d.Chofer,d.DNI From despacho_t d where d.IdPadre=$idpadre LIMIT 1";$rs10=mysql_query($query,$conn);
        while($row10=mysql_fetch_array($rs10)){
            $chofer=$row10['Chofer'];
            $dnichofer=$row10['DNI'];
        }mysql_free_result($rs10);
    }
}




//tablas
function DES_TablaItemsServicio($idpadre,$tipo,$conn,$v1){//0:despacho,1:planta.2:barrera
    $idpadre=intval($idpadre);
    $query="SELECT m.*,u.Abr as Uni ,i.Nombre as Item,e.Nombre as Env From despacho a,despacho_it m,items i,unidadesmedida u,envases e where m.IdItemServ<>0 and a.Id=m.IdPadre and m.IdIC=i.Id and m.Id<>0 and m.IdU=u.Id and m.IdEnv=e.Id and m.IdPadre=$idpadre Order by i.Nombre";
    $rs=mysql_query($query,$conn);
    //Titulos de la tabla
    $tablaclientes='';
    $tablaclientes .='<table width="800" class="TableShow TMT20" id="tshow"><tr>';
    $tablaclientes .='<td width="330" class="TableShowT" > Producto guardar/formular/cargar (del servicio)</td>';   
    $tablaclientes .='<td width="50" class="TableShowT" > Unidad</td>';   
    $tablaclientes .='<td width="70" class="TableShowT TAR" > Cantidad</td>'; 
    $tablaclientes .='<td width="90" class="TableShowT" > Envase</td>';  
    $tablaclientes .='<td width="80" class="TableShowT" > Lote</td>'; 
    $tablaclientes .='<td width="50" class="TableShowT TAR" > Bultos</td>'; 
    $tablaclientes .='<td width="100" class="TableShowT" > Destino</td>'; 
    $tablaclientes .='<td width="30" class="TableShowT TAR">';
    //solo agrega si es despacho y esta pdte
    if($tipo==0){$tablaclientes .=GLO_FAButton('CmdAddIS','submit','','self','Agregar','add','iconbtn');}
    $tablaclientes .='</td></tr>';   
    // 
    $total=0; $totalb=0;$uni=0;$uniok=0; //0:init, 1:ok, 2:dif        
    while($row=mysql_fetch_array($rs)){
        if($tipo==0){
            $link=" onclick="."location='ModificarItemS.php?Flag1=True"."&id=".$row['Id']."'"; $estilo=" style='cursor:pointer;' ";
        }else{$link='';$estilo='';}
        //suma total y compara unidades
        $total= $total+$row['Cant'];
        $totalb= $totalb+$row['Bultos'];
        if($uniok==0){ $uni=$row['IdU'];$uniok=1;}//toma primer unidad
        if($uniok==1){ if($row['IdU']!=$uni){$uniok=2;} }//descarta total si hay alguna distinta
        //
        $tablaclientes .='<tr '.$estilo.GLO_highlight($row['Id']).'>';  
        $tablaclientes .='<td  class="TableShowD"'.$link.'>'.substr($row['Item'],0,38)."</td>"; 
        $tablaclientes .='<td  class="TableShowD"'.$link.'>'.substr($row['Uni'],0,12)."</td>";
        $tablaclientes .='<td  class="TableShowD TAR"'.$link.'>'.$row['Cant']."</td>";
        $tablaclientes .='<td  class="TableShowD"'.$link.'>'.substr($row['Env'],0,10)."</td>"; 
        $tablaclientes .='<td  class="TableShowD"'.$link.'>'.substr($row['Lote'],0,10)."</td>"; 
        $tablaclientes .='<td  class="TableShowD TAR"'.$link.'>'.$row['Bultos']."</td>";
        $tablaclientes .='<td  class="TableShowD"'.$link.'>'.substr($row['Destino'],0,12)."</td>"; 
        $tablaclientes .='<td  class="TableShowD TAR">'; 
        //solo si esta pdte y es despacho
        if($tipo==0){$tablaclientes .=GLO_rowbutton("CmdBorrarFilaIS",$row['Id'],"Eliminar",'self','trash','iconlgray','Eliminar',0,0,0);}
        $tablaclientes .="</td></tr>";  
    }mysql_free_result($rs);
    //total muestra si las unidades coinciden 
    if($uniok==1 and $total>0){$total=number_format($total, 2);}else{$total='';}
    if($totalb>0){$totalb=number_format($totalb, 2);}else{$totalb='';}
    $tablaclientes .='<tr><td  class="TableShowD TAR TBlue" colspan="3">'.$total.'</td><td  class="TableShowD" colspan="2"></td><td  class="TableShowD TAR TBlue">'.$totalb.'</td><td  class="TableShowD" colspan="2"></td></tr>'; 
    //cierra y muestra 	
    $tablaclientes .="</table>";echo $tablaclientes;	
}

function DES_TablaItems($idpadre,$tipo,$conn,$v1){//0:despacho,1:planta.2:barrera
    $idpadre=intval($idpadre);
    //si es despacho filtra los que se toman de servicios
    if($tipo==0){$filtroservicios="and m.IdItemServ=0";}else{$filtroservicios="";}
    //
    $query="SELECT m.*,u.Abr as Uni ,i.Nombre as Item,e.Nombre as Env From despacho a,despacho_it m,items i,unidadesmedida u,envases e where a.Id=m.IdPadre and m.IdIC=i.Id and m.Id<>0 and m.IdU=u.Id and m.IdEnv=e.Id and m.IdPadre=$idpadre $filtroservicios Order by i.Nombre";
    $rs=mysql_query($query,$conn);
    //Titulos de la tabla
    $tablaclientes='';
    $tablaclientes .='<table width="800" class="TableShow TMT20" id="tshow"><tr>';
    $tablaclientes .='<td width="330" class="TableShowT" > Producto a guardar/formular/cargar</td>';   
    $tablaclientes .='<td width="50" class="TableShowT" > Unidad</td>';   
    $tablaclientes .='<td width="70" class="TableShowT TAR" > Cantidad</td>'; 
    $tablaclientes .='<td width="90" class="TableShowT" > Envase</td>';  
    $tablaclientes .='<td width="80" class="TableShowT" > Lote</td>'; 
    $tablaclientes .='<td width="50" class="TableShowT TAR" > Bultos</td>'; 
    $tablaclientes .='<td width="100" class="TableShowT" > Destino</td>'; 
    $tablaclientes .='<td width="30" class="TableShowT TAR">';
    //solo agrega si es despacho y esta pdte
    if($tipo==0){$tablaclientes .=GLO_FAButton('CmdAdd','submit','','self','Agregar','add','iconbtn');}
    $tablaclientes .='</td></tr>';   
    // 
    $total=0; $totalb=0;$uni=0;$uniok=0; //0:init, 1:ok, 2:dif        
    while($row=mysql_fetch_array($rs)){
        $link='';$estilo='';
        if($tipo==0 or $tipo==1){GLO_LinkRowTablaInit($estilo,$link,$row['Id'],0);}//despacho y planta
        //suma total y compara unidades
        $total= $total+$row['Cant'];
        $totalb= $totalb+$row['Bultos'];
        if($uniok==0){ $uni=$row['IdU'];$uniok=1;}//toma primer unidad
        if($uniok==1){ if($row['IdU']!=$uni){$uniok=2;} }//descarta total si hay alguna distinta
        //
        $tablaclientes .='<tr '.$estilo.GLO_highlight($row['Id']).'>';  
        $tablaclientes .='<td  class="TableShowD"'.$link.'>'.substr($row['Item'],0,38)."</td>"; 
        $tablaclientes .='<td  class="TableShowD"'.$link.'>'.substr($row['Uni'],0,12)."</td>";
        $tablaclientes .='<td  class="TableShowD TAR"'.$link.'>'.$row['Cant']."</td>";
        $tablaclientes .='<td  class="TableShowD"'.$link.'>'.substr($row['Env'],0,10)."</td>"; 
        $tablaclientes .='<td  class="TableShowD"'.$link.'>'.substr($row['Lote'],0,10)."</td>"; 
        $tablaclientes .='<td  class="TableShowD TAR"'.$link.'>'.$row['Bultos']."</td>";
        $tablaclientes .='<td  class="TableShowD"'.$link.'>'.substr($row['Destino'],0,12)."</td>"; 
        $tablaclientes .='<td  class="TableShowD TAR">'; 
        //solo si esta pdte y es despacho
        if($tipo==0){$tablaclientes .=GLO_rowbutton("CmdBorrarFila",$row['Id'],"Eliminar",'self','trash','iconlgray','Eliminar',0,0,0);}
        $tablaclientes .="</td></tr>";  
    }mysql_free_result($rs);
    //total muestra si las unidades coinciden 
    if($uniok==1 and $total>0){$total=number_format($total, 2);}else{$total='';}
    if($totalb>0){$totalb=number_format($totalb, 2);}else{$totalb='';}
    $tablaclientes .='<tr><td  class="TableShowD TAR TBlue" colspan="3">'.$total.'</td><td  class="TableShowD" colspan="2"></td><td  class="TableShowD TAR TBlue">'.$totalb.'</td><td  class="TableShowD" colspan="2"></td></tr>'; 
    //cierra y muestra 	
    $tablaclientes .="</table>";echo $tablaclientes;	
}
    
function DES_TablaUnidadesP($idpadre,$conn,$esdespacho,$v1){
    $idpadre=intval($idpadre);
    $query="SELECT d.*,p.Nombre as N, p.Apellido as A,u1.Nombre as NU1,u1.Dominio as DU1,u2.Nombre as NU2,u2.Dominio as DU2 From despacho_p d,despacho a,personal p,unidades u1, unidades u2 where a.Id=d.IdPadre and d.IdChofer=p.Id and d.IdUnidad=u1.Id and d.IdSemi=u2.Id  and d.IdPadre=$idpadre Order by d.Id";
    $rs=mysql_query($query,$conn);
    //Titulos de la tabla
    $tablaclientes='';
    $tablaclientes .='<table width="800" class="TableShow TMT20" id="tshow"><tr>';
    $tablaclientes .="<td "."width="."250"." class="."TableShowT".">Conductor camion Propio</td>";   
    $tablaclientes .="<td "."width="."245"." class="."TableShowT"."> Dominio Camion</td>";   
    $tablaclientes .="<td "."width="."245"." class="."TableShowT"."> Dominio Semi</td>";   
    $tablaclientes .='<td width="60" class="TableShowT TAR">';
    if($esdespacho==1){ $tablaclientes .=GLO_FAButton('CmdAddVP','submit','','self','Agregar','add','iconbtn'); }
    $tablaclientes .='</td></tr>';             
    while($row=mysql_fetch_array($rs)){
        if($esdespacho==1){
			//chofer
			$combochofer=ComboTablaRFXMasivoPers($row['IdChofer'],'',$conn);
			$chofer='<select name="CbPersonal['.$row['Id'].']" style="width:220px" class="campos"><option value=""></option>'.$combochofer.' </select>';
			//camion
			$combodom1=ComboTablaRFXMasivoUni($row['IdUnidad'],"",$conn);
			$dom1='<select name="CbUnidad['.$row['Id'].']" style="width:220px" class="campos"><option value=""></option>'.$combodom1.' </select>';
			//semi
			$combodom2=ComboTablaRFXMasivoUni($row['IdSemi'],"",$conn);
			$dom2='<select name="CbUnidad2['.$row['Id'].']" style="width:220px" class="campos"><option value=""></option>'.$combodom2.' </select>';
        }else{
            $chofer=substr($row['A'].' '.$row['N'],0,30);
            $dom1=substr($row['IdUnidad'].' '.$row['NU1'].' '.$row['DU1'],0,34); $dom2=substr($row['IdSemi'].' '.$row['NU2'].' '.$row['DU2'],0,34);
        }
        //
        $tablaclientes .='<tr>';
        $tablaclientes .='<td  class="TableShowD ">'.$chofer.'</td>'; 
        $tablaclientes .='<td  class="TableShowD ">'.$dom1.'</td>'; 
        $tablaclientes .='<td  class="TableShowD ">'.$dom2.'</td>'; 
        $tablaclientes .='<td  class="TableShowD TAC">'; 
        //completar/eliminar unidades
        if($esdespacho==1){//pdte
            $tablaclientes .=GLO_rowbutton("CmdGrabaFilaVP",$row['Id'],"Guardar",'self','save','iconlgray','',0,0,0); 
            $tablaclientes .=' &nbsp; '.GLO_rowbutton("CmdBorrarFilaVP",$row['Id'],"Eliminar",'self','trash','iconlgray','Eliminar',0,0,0); 
        }
        //seleccionar una unidad
        if($esdespacho==2 and trim($chofer)!=''){//barrera
            $tablaclientes .='<input name="OptUniP"  type="radio"  class="radiob"  value="'.$row['Id'].'"';if ($_SESSION['OptUniP'] ==$row['Id']){$tablaclientes .='checked';} $tablaclientes .='>';
        }        
        $tablaclientes .="</td></tr>";  
    }mysql_free_result($rs);	
    $tablaclientes .="</table>";echo $tablaclientes;	
}

function DES_TablaUnidadesT($idpadre,$conn,$esdespacho,$v1){
    $idpadre=intval($idpadre);
    $query="SELECT d.*  From despacho_t d,despacho a where a.Id=d.IdPadre and d.IdPadre=$idpadre Order by d.Id";
    $rs=mysql_query($query,$conn);
    //Titulos de la tabla
    $tablaclientes='';
    $tablaclientes .='<table width="800" class="TableShow TMT20" id="tshow"><tr>';
    $tablaclientes .="<td "."width="."340"." class="."TableShowT".">Chofer camion Tercero</td>";  
    $tablaclientes .="<td "."width="."120"." class="."TableShowT"."> DNI</td>";    
    $tablaclientes .="<td "."width="."140"." class="."TableShowT"."> Dominio Camion</td>";   
    $tablaclientes .="<td "."width="."140"." class="."TableShowT"."> Dominio Semi</td>";   
    $tablaclientes .='<td width="60" class="TableShowT TAR">';
    if($esdespacho==1){ $tablaclientes .=GLO_FAButton('CmdAddVT','submit','','self','Agregar','add','iconbtn'); }
    $tablaclientes .='</td></tr>';             
    while($row=mysql_fetch_array($rs)){
        if($esdespacho==1){
            $chofer='<input name="TxtChofer['.$row['Id'].']" style="width:320px" type="text"  class="TextBox"  maxlength="50" value="'.$row['Chofer'].'">';
            $dni='<input name="TxtDoc['.$row['Id'].']" style="width:100px" type="text"  class="TextBox"  maxlength="13" value="'.$row['DNI'].'">';
            $dom1='<input name="TxtDominio['.$row['Id'].']" style="width:120px" type="text"  class="TextBox"  maxlength="10" value="'.$row['Dominio'].'" onKeyUp="this.value=this.value.toUpperCase()">';
            $dom2='<input name="TxtDominio2['.$row['Id'].']" style="width:120px" type="text"  class="TextBox"  maxlength="10" value="'.$row['Dominio2'].'" onKeyUp="this.value=this.value.toUpperCase()">';
        }else{
            $chofer=substr($row['Chofer'],0,40); $dni=substr($row['DNI'],0,16);
            $dom1=substr($row['Dominio'],0,16); $dom2=substr($row['Dominio2'],0,16);
        }
        //
        $tablaclientes .='<tr>';
        $tablaclientes .='<td  class="TableShowD ">'.$chofer.'</td>'; 
        $tablaclientes .='<td  class="TableShowD ">'.$dni.'</td>'; 
        $tablaclientes .='<td  class="TableShowD ">'.$dom1.'</td>'; 
        $tablaclientes .='<td  class="TableShowD ">'.$dom2.'</td>'; 
        $tablaclientes .='<td  class="TableShowD TAC">'; 
        //completar/eliminar unidades
        if($esdespacho==1){//pdte
            $tablaclientes .=GLO_rowbutton("CmdGrabaFilaVT",$row['Id'],"Guardar",'self','save','iconlgray','',0,0,0); 
            $tablaclientes .=' &nbsp; '.GLO_rowbutton("CmdBorrarFilaVT",$row['Id'],"Eliminar",'self','trash','iconlgray','Eliminar',0,0,0); 
        }
        //seleccionar una unidad
        if($esdespacho==2 and trim($dni)!=''){//barrera
            $tablaclientes .='<input name="OptUniT"  type="radio"  class="radiob"  value="'.$row['Id'].'"';if ($_SESSION['OptUniT'] ==$row['Id']){$tablaclientes .='checked';} $tablaclientes .='>';
        }
        $tablaclientes .="</td></tr>";  
    }mysql_free_result($rs);	
    $tablaclientes .="</table>";echo $tablaclientes;	
}



?>