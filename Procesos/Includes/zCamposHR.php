<? include($_SESSION["NivelArbol"]."Codigo/Seguridad.php");

function TablaDespacho($idpadre,$ide,$conn){
	$idpadre=intval($idpadre);
    $query="SELECT distinct p.Id,p.Fecha,t.Abr as Tipo FROM despacho p,despacho_tipo t Where t.Id=p.IdTipo and p.IdPadre=$idpadre";
    $rs=mysql_query($query,$conn);
    if(mysql_num_rows($rs)!=0){	
        //Titulos de la tabla
        $tablaclientes='';
        $tablaclientes .='<table width="300" border="0" cellspacing="0" cellpadding="0" class="TMT20"><tr>';
        $tablaclientes .='<td class="recuento"><i class="fa fa-file-alt iconvsmallsp iconlgray"></i> <label class="TBold">Logistica</label> <label class="TGray">Pedidos</label></td></td></tr></table>';	
        $tablaclientes .='<table width="300" class="TableShow TMT" id="tshow"><tr>';
        $tablaclientes .='<td width="50" class="TableShowT TAR"> Pedido</td>';
        $tablaclientes .="<td "."width="."70"." class="."TableShowT"."> Fecha</td>"; 
        $tablaclientes .="<td "."width="."150"." class="."TableShowT"."> Tipo</td>"; 
        $tablaclientes .='<td width="30" class="TableShowT"></td>'; 
        $tablaclientes .='</tr>';             
        $estilo="";$link="";
        while($row=mysql_fetch_array($rs)){
            $tablaclientes .='<tr '.$estilo.GLO_highlight($row['Id']).'>';
			$tablaclientes .="<td class="."TableShowD".$link."> ".str_pad($row['Id'], 6, "0", STR_PAD_LEFT)."</td>"; 
            $tablaclientes .="<td class="."TableShowD".$link." > ".FormatoFecha($row['Fecha'])."</td>";
			$tablaclientes .='<td class="TableShowD"'.$link.">".substr($row['Tipo'],0,20)."</td>";   
            $tablaclientes .='<td class="TableShowD TAC">'; 						
			$tablaclientes .=GLO_rowbutton("CmdVer4",$row['Id'],"Ver",'self','lupa','iconlgray','',1,0,0);  	
			$tablaclientes .="</td>";  
            $tablaclientes .="</tr>";  
        }mysql_free_result($rs);	
        $tablaclientes .="</table>";
        echo $tablaclientes;	
    }
}

function TablaBarrera($idpadre,$ide,$conn){
	$idpadre=intval($idpadre);
	$query="SELECT a.Id,a.Fecha,a.Hora,a.Tipo,a.Retorno from procesosop_e1 a where a.Id<>0 and a.Etapa=$ide and a.IdPadre=$idpadre";$rs=mysql_query($query,$conn);
    if(mysql_num_rows($rs)!=0){	
        //titulo etapa
        if($ide==0){ $titulo='Ingreso';}else{$titulo='Egreso';}
        //Titulos de la tabla
        $tablaclientes='';
        $tablaclientes .='<table width="300" border="0" cellspacing="0" cellpadding="0" class="TMT20"><tr>';
        $tablaclientes .='<td class="recuento"><i class="fa fa-truck iconvsmallsp iconlgray" ></i> <label class="TBold">Barrera</label> <label class="TGray">'.$titulo.'</label></td></td></tr></table>';	
        $tablaclientes .='<table width="300" class="TableShow TMT" id="tshow"><tr>';
        $tablaclientes .="<td "."width="."70"." class="."TableShowT"."> Fecha</td>";  
        $tablaclientes .="<td "."width="."50"." class="."TableShowT"."> Hora</td>";   
        $tablaclientes .="<td "."width="."100"." class="."TableShowT"."> Tipo</td>"; 
        $tablaclientes .="<td "."width="."50"." class="."TableShowT"."> </td>"; 
        $tablaclientes .='<td width="30" class="TableShowT"></td>'; 
        $tablaclientes .='</tr>';             
        $estilo="";$link="";
        while($row=mysql_fetch_array($rs)){
            if($row['Retorno']==0){$ret='';}else{$ret='Retorno';}
            //
            $tablaclientes .='<tr '.$estilo.GLO_highlight($row['Id']).'>';
            $tablaclientes .="<td class="."TableShowD".$link."> ".GLO_FormatoFecha($row['Fecha'])."</td>"; 
            $tablaclientes .="<td class="."TableShowD".$link."> ".GLO_FormatoHora($row['Hora'])."</td>"; 
            $tablaclientes .='<td class="TableShowD"'.$link."> ".PROC_TipoUnidad($row['Tipo'])."</td>"; 
            $tablaclientes .='<td  class="TableShowD TRed"'.$link.'>'.$ret."</td>"; 
			$tablaclientes .='<td class="TableShowD TAC">'; 						
			$tablaclientes .=GLO_rowbutton("CmdVer1",$row['Id'],"Ver",'self','lupa','iconlgray','',1,0,0);  	
			$tablaclientes .="</td>";  
            $tablaclientes .="</tr>";  
        }mysql_free_result($rs);	
        $tablaclientes .="</table>";
        echo $tablaclientes;	
    }
}

function TablaLaboratorio($idpadre,$ide,$conn){
	$idpadre=intval($idpadre);
    //etapa
    if($ide==0){
        $titulo='Materia prima';
        $query="SELECT distinct c.Id,c.Fecha,c.IdE,e.Nombre as Est from cam c,cam_est e,procesosop_e1 p,procesosop_e1_it pi where c.Id<>0 and c.IdE=e.Id and c.IdPE1IT=pi.Id and p.Etapa=0 and p.Id=pi.IdPadre and p.IdPadre=$idpadre";
    }else{
        $titulo='Formulado';
        $query="SELECT distinct c.Id,c.Fecha,c.IdE,e.Nombre as Est from cam c,cam_est e,stockmov a1,stockmov_items a2,despacho p Where c.Id<>0 and c.IdE=e.Id and a2.IdCAM=c.Id and a2.IdMov=a1.Id and a1.IdPedido=p.Id and a1.IdOrigen=3 and a1.IdTipoMov=3 and p.IdPadre=$idpadre";
    }
    //
    $rs=mysql_query($query,$conn);
    if(mysql_num_rows($rs)!=0){	
        //Titulos de la tabla
        $tablaclientes='';
        $tablaclientes .='<table width="300" border="0" cellspacing="0" cellpadding="0" class="TMT20"><tr>';
        $tablaclientes .='<td class="recuento"><i class="fa fa-flask iconvsmallsp iconlgray"></i> <label class="TBold">Laboratorio</label> <label class="TGray">'.$titulo.'</label></td></td></tr></table>';	
        $tablaclientes .='<table width="300" class="TableShow TMT" id="tshow"><tr>';
        $tablaclientes .='<td width="50" class="TableShowT TAR"> COA</td>';
        $tablaclientes .="<td "."width="."70"." class="."TableShowT"."> Fecha</td>"; 
        $tablaclientes .="<td "."width="."150"." class="."TableShowT"."> Estado</td>"; 
        $tablaclientes .='<td width="30" class="TableShowT"></td>'; 
        $tablaclientes .='</tr>';             
        $estilo="";$link="";
        while($row=mysql_fetch_array($rs)){
            $tablaclientes .='<tr '.$estilo.GLO_highlight($row['Id']).'>';
            $tablaclientes .='<td class="TableShowD TAR"'.$link.'>'.str_pad($row['Id'], 5, "0", STR_PAD_LEFT)."</td>"; 
            $tablaclientes .="<td class="."TableShowD".$link."> ".GLO_FormatoFecha($row['Fecha'])."</td>"; 
            $tablaclientes .="<td class="."TableShowD".$link.' style="font-weight:bold;'.CAM_colorestado($row['IdE']).'"'."> ".substr($row['Est'],0,18)."</td>";  
            $tablaclientes .='<td class="TableShowD TAC">'; 						
			$tablaclientes .=GLO_rowbutton("CmdVer2",$row['Id'],"Ver",'self','lupa','iconlgray','',1,0,0);  	
			$tablaclientes .="</td>";  
            $tablaclientes .="</tr>";  
        }mysql_free_result($rs);	
        $tablaclientes .="</table>";
        echo $tablaclientes;	
    }
}

function TablaPlanta($idpadre,$ide,$conn){
	$idpadre=intval($idpadre);
    $query1="SELECT distinct s.Id,s.Fecha,t.Nombre as TipoM From stockmov s,stockmov_items si,stock_tipomov t,cam c,procesosop_e1 p,procesosop_e1_it pi where s.Id=si.IdMov and s.IdTipoMov=t.Id and  si.IdCAM=c.Id and s.IdOrigen=5  and c.IdPE1IT=pi.Id and p.Id=pi.IdPadre and p.IdPadre=$idpadre";
    $query2="SELECT distinct s.Id,s.Fecha,t.Nombre as TipoM From stockmov s,stockmov_items si,stock_tipomov t,despacho p where s.Id=si.IdMov and s.IdTipoMov=t.Id and  si.IdPedido=p.Id and s.IdOrigen IN (3,4) and p.IdPadre=$idpadre";
    $query="$query1 UNION ALL $query2 ";
    /* 15/5/22
    //etapa
    if($ide==0){
        $titulo='Materia prima';
        $query="SELECT distinct s.Id,s.Fecha,t.Nombre as TipoM From stockmov s,stockmov_items si,stock_tipomov t,cam c,procesosop_e1 p,procesosop_e1_it pi where s.Id=si.IdMov and s.IdTipoMov=t.Id and  si.IdCAM=c.Id and s.IdOrigen=5  and c.IdPE1IT=pi.Id and p.Id=pi.IdPadre and p.IdPadre=$idpadre";
    }else{
        $titulo='Almac/Formulado/Carga';
        $query="SELECT distinct s.Id,s.Fecha,t.Nombre as TipoM From stockmov s,stockmov_items si,stock_tipomov t,despacho p where s.Id=si.IdMov and s.IdTipoMov=t.Id and  si.IdPedido=p.Id and s.IdOrigen IN (3,4) and p.IdPadre=$idpadre";
    }
    */
    //
    $rs=mysql_query($query,$conn);
    if(mysql_num_rows($rs)!=0){	
        //Titulos de la tabla
        $tablaclientes='';
        $tablaclientes .='<table width=300" border="0" cellspacing="0" cellpadding="0" class="TMT20"><tr>';
        $tablaclientes .='<td class="recuento"><i class="fa fa-warehouse iconvsmallsp iconlgray"></i> <label class="TBold">Planta</label> <label class="TGray">Almac/Formulado/Carga</label></td></td></tr></table>';	
        $tablaclientes .='<table width="300" class="TableShow TMT" id="tshow"><tr>';
        $tablaclientes .="<td "."width="."70"." class="."TableShowT"."> Fecha</td>";   
        $tablaclientes .="<td "."width="."150"." class="."TableShowT"."> Tipo</td>";   
        $tablaclientes .="<td "."width="."50"." class="."TableShowT"." style='text-align:right;'> Movim.</td>";   
        $tablaclientes .='<td width="30" class="TableShowT"></td>'; 
        $tablaclientes .='</tr>';             
        $estilo="";$link="";
        while($row=mysql_fetch_array($rs)){
            $tablaclientes .='<tr '.$estilo.GLO_highlight($row['Id']).'>';
            $tablaclientes .="<td class="."TableShowD".$link." > ".FormatoFecha($row['Fecha'])."</td>";
            $tablaclientes .="<td class="."TableShowD".$link."> ".substr($row['TipoM'],0,14)."</td>"; 
            $tablaclientes .="<td class="."TableShowD".$link." style='text-align:right;'> ".str_pad($row['Id'], 6, "0", STR_PAD_LEFT)."</td>";  
            $tablaclientes .='<td class="TableShowD TAC">'; 						
			$tablaclientes .=GLO_rowbutton("CmdVer3",$row['Id'],"Ver",'self','lupa','iconlgray','',1,0,0);  	
			$tablaclientes .="</td>";  
            $tablaclientes .="</tr>";  
        }mysql_free_result($rs);	
        $tablaclientes .="</table>";
        echo $tablaclientes;	
    }
}






//hilo
echo '<table  width="780" border="0" cellspacing="0" cellpadding="0"><tr valign="top"> <td valign="top" width="400">';
//
TablaDespacho($_SESSION['TxtNumero'],0,$conn);//despacho pedidos
TablaBarrera($_SESSION['TxtNumero'],0,$conn);//barrera ingreso
TablaLaboratorio($_SESSION['TxtNumero'],0,$conn);//lab materia prima
TablaPlanta($_SESSION['TxtNumero'],0,$conn);//planta 
TablaLaboratorio($_SESSION['TxtNumero'],1,$conn);//lab formulado
TablaBarrera($_SESSION['TxtNumero'],1,$conn);//barrera egreso
//
echo '</td><td valign="top" width="380">';
//
GLO_Archivos($_SESSION['TxtNumero'],$conn,"procesosop_adj","380","Archivos adjuntos","paperclip",0,0,1,"TMT20",0,0,0);
//
echo '</td></tr></table>';

?>