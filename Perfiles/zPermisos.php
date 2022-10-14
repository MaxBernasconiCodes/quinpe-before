<? include("../Codigo/Seguridad.php"); $_SESSION["NivelArbol"]="../";

/*
0 Administracion  
1 Coordinador 
2 General 
3 Mantenimiento 
4 RRHH 
5 SGI Externo
6 HSE 
7 SGI Externo Limitado
8 Barrera 
*/

$f=$perfil;
$wtd=125;
$td='<td width="'.$wtd.'"><input type="button" class="botoniniciomenu"  style="width:115px;" value=';
$tdlista='<td  class="textomanual" style="padding-right:6px"; valign="top">';
$p='class="TDGray"';

//tabla
$wtbl=7*$wtd;
if($f==0 or $f==2 or $f==6){$wtbl=6*$wtd;}
if($f==1 or $f==3){$wtbl=4*$wtd;}
if($f==5 or $f==7 or $f==8){$wtbl=2*$wtd;}
$wtable='width="'.$wtbl.'"';


//titulos
echo '<table '.$wtable.' border="0"  cellpadding="0" cellspacing="0" >
<tr >'; 
if($f==0 or $f==1 or $f==2 or $f==3 or $f==4 or $f==6){echo $td.'"COMPRAS"></td>';}
if($f==0 or $f==1 or $f==2 or $f==3 or $f==4 or $f==5 or $f==6 or $f==7 or $f==8){echo $td.'"INDICADORES"></td>';}
if($f==0 or $f==1 or $f==2 or $f==3 or $f==4 or $f==6){echo $td.'"MANTENIMIENTO"></td>';}
if($f==0 or $f==2 or $f==4 or $f==6 or $f==8){echo $td.'"OPERACIONES"></td>';}
if($f==0 or $f==4){echo $td.'"RRHH"></td>';}
if($f==0 or $f==1 or $f==2 or $f==3 or $f==4 or $f==5 or $f==6 or $f==7){echo $td.'"SGI"></td>';}
if($f==2 or $f==4 or $f==6){echo $td.'"SMA"></td>';}
echo '</tr>';


//listas
echo '<tr> ';

//COMPRAS
if($f==0 or $f==1 or $f==2 or $f==3 or $f==4 or $f==6){
    echo $tdlista;
    if($f==0 or $f==1 or $f==2 or $f==3 or $f==4 or $f==6){echo '<p '.$p.'>COMPROBANTES </p>'; }
    if($f==0){echo '<p '.$p.'>STOCK </p>'; }
    if($f==0 or $f==6){echo '<p '.$p.'>ARTICULOS </p>'; }
    if($f==0){echo '<p '.$p.'>PROVEEDORES </p>'; }
    if($f==0){echo '<p '.$p.'>TABLAS </p>'; }
    echo '</td>';
}


//INDICADORES
if($f==0 or $f==1 or $f==2 or $f==3 or $f==4 or $f==5 or $f==6 or $f==7 or $f==8){
    echo $tdlista;
    if($f==0 or $f==1 or $f==2 or $f==3 or $f==4 or $f==5 or $f==6 or $f==7 or $f==8){echo '<p '.$p.'>OBJETIVOS </p>'; }
    if($f==0){echo '<p '.$p.'>COMPRAS </p>'; }
    if($f==1 or $f==2){echo '<p '.$p.'>OPERACIONES </p>'; }
    if($f==4){echo '<p '.$p.'>RRHH </p>'; }
    if($f==1 or $f==2){echo '<p '.$p.'>UNIDADES </p>'; }
    echo '</td>';
}


//MANTENIMIENTO
if( $f==0 or $f==1 or $f==2 or $f==3 or $f==4 or $f==6){
    echo $tdlista;
    if($f==0 or $f==1 or $f==2 or $f==3 or $f==4 or $f==6){echo '<p '.$p.'>UNIDADES </p>'; }
    if($f==0 or $f==1 or $f==2 or $f==3 or $f==4 or $f==6){echo '<p '.$p.'>CONTROL RSV </p>'; }	
    if($f==0 or $f==1 or $f==2 or $f==3 or $f==4 or $f==6){echo '<p '.$p.'>REPARACIONES </p>'; }
    if($f==0 or $f==1 or $f==2 or $f==3 or $f==4 or $f==6){echo '<p '.$p.'>ACCESORIOS </p>'; }	
    if($f==0 or $f==1 or $f==2 or $f==3 or $f==4 or $f==6){echo '<p '.$p.'>SECTORES </p>'; }	
    echo '</td>';
}


//OPERACIONES
if($f==0 or $f==2 or $f==4 or $f==6 or $f==8){
    echo $tdlista;
    if($f==2 or $f==4 or $f==6 or $f==8){echo '<p '.$p.'>BARRERA </p>'; }
    if($f==2 or $f==4 or $f==6){echo '<p '.$p.'>LABORATORIO </p>'; }
    if($f==2 or $f==4 or $f==6){echo '<p '.$p.'>PLANTA </p>'; }
    if($f==2 or $f==4 or $f==6){echo '<p '.$p.'>DESPACHO </p>'; }	
    if($f==2 or $f==4 or $f==6){echo '<p '.$p.'>SOLICITUDES </p>'; }	
    if($f==0 or $f==2 or $f==4 or $f==6){echo '<p '.$p.'>CLIENTES </p>'; }
    if($f==2 or $f==4 or $f==6){echo '<p '.$p.'>COMPROBANTES </p>'; }	
    if($f==2 or $f==4 or $f==6){echo '<p '.$p.'>SERVICIOS </p>'; }	
    if($f==0 or $f==2 or $f==4 or $f==6){echo '<p '.$p.'>TABLAS </p>'; }	
    echo '</td>';
}


//RRHH
if($f==0 or $f==4){
    echo $tdlista;
    if($f==4){echo '<p '.$p.'>LEGAJOS </p>'; }
    if($f==0){echo '<p '.$p.'>PERSONAL </p>'; }
    if($f==4){echo '<p '.$p.'>NOTICIAS </p>'; }
    if($f==0 or $f==4){echo '<p '.$p.'>TABLAS</p>';}
    echo '</td>';
}


//SGI
if($f==0 or $f==1 or $f==2 or $f==3 or $f==4 or $f==5 or $f==6 or $f==7){
    echo $tdlista;
    if($f==0 or $f==1 or $f==2 or $f==3 or $f==4 or $f==5 or $f==6){echo '<p '.$p.'>AUDITORIAS </p>'; }
    if($f==0 or $f==1 or $f==2 or $f==3 or $f==4 or $f==5 or $f==6){echo '<p '.$p.'>CAMBIOS </p>'; }
    if($f==0 or $f==1 or $f==2 or $f==3 or $f==4 or $f==5 or $f==6){echo '<p '.$p.'>DOCUMENTOS </p>'; }	
    if($f==0 or $f==1 or $f==2 or $f==3 or $f==4 or $f==5 or $f==6){echo '<p '.$p.'>EXTERNOS </p>'; }
    if($f==0 or $f==1 or $f==2 or $f==3 or $f==4 or $f==5 or $f==6){echo '<p '.$p.'>NO CONFORM</p>'; }
    if($f==0 or $f==1 or $f==2 or $f==3 or $f==4 or $f==5 or $f==6 or $f==7){echo '<p '.$p.'>MATRIZ LEGAL </p>'; }
    if($f==0 or $f==1 or $f==2 or $f==3 or $f==4 or $f==5 or $f==6){echo '<p '.$p.'>MINUTAS </p>'; }
    if($f==2 or $f==6){echo '<p '.$p.'>PLANES </p>'; }	
    if($f==2 or $f==6){echo '<p '.$p.'>PROGRAMAS </p>'; }	
    if($f==0 or $f==1 or $f==2 or $f==3 or $f==4 or $f==5 or $f==6){echo '<p '.$p.'>TABLAS </p>'; }
    echo '</td>';
}
//SMA
if($f==2 or $f==4 or $f==6){
    echo $tdlista;
    if($f==2 or $f==4 or $f==6){echo '<p '.$p.'>EXTINTORES </p>'; }
    if($f==2 or $f==4 or $f==6){echo '<p '.$p.'>INCIDENTES </p>'; }
    if($f==2 or $f==4 or $f==6){echo '<p '.$p.'>INSPECCIONES </p>'; }	
    if($f==2 or $f==4 or $f==6){echo '<p '.$p.'>PSSA</p>'; }
    if($f==2 or $f==4 or $f==6){echo '<p '.$p.'>TOT </p>'; }
    if($f==2 or $f==4 or $f==6){echo '<p '.$p.'>TABLAS </p>'; }
    echo '</td>';
}



echo '</tr>
</table>';
?>
