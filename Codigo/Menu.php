<? include("Seguridad.php") ; ?>
<script language="javascript">
function items(id){
	var obj = document.getElementById('ul' + id)
	if(obj.style.display == 'block') obj.style.display = 'none'
	else obj.style.display = 'block'  
}
function ocultaItems(){
	listado = document.getElementById('listaUls')
	contenedores = listado.getElementsByTagName('ul')
	numContenedores = contenedores.length
	for(m=0; m < numContenedores; m++){
	if(contenedores[m].id.indexOf('ul') == 0)
	contenedores[m].style.display = 'none'     }  
}  
</script>

<td  height="100%" valign="top"  class="estilomenu"  style="width:1.8rem"> 
<!--menu-->
<table height="100%"  border="0" cellspacing="0" cellpadding="0" valign="top"  >
<tr > <td  style="height:1.8rem" ></td> </tr>
<tr><td valign="top" >		
<div id="menuv" >
<ul id="listaUls" >

<? 

//estilo menu
$estilodivlista='style="border-bottom:1px solid #dedede;margin-right:6px;"';
$estilodivlista2='style="border-top:1px solid #dedede;margin-right:6px;"';

// ADMINISTRACION
if  ($_SESSION["GLO_IdSistema"]==1 ){ 
	if ( $_SESSION["IdPerfilUser"]==1 or $_SESSION["IdPerfilUser"]==2  or $_SESSION["IdPerfilUser"]==3  or $_SESSION["IdPerfilUser"]==4 or $_SESSION["IdPerfilUser"]==7  or $_SESSION["IdPerfilUser"]==9 or $_SESSION["IdPerfilUser"]==14 or $_SESSION["IdPerfilUser"]==11){ 
		echo '<li id="items">  <a href="'.$_SESSION["NivelArbol"].'ComprobantesCo/NotasPedidoD.php">&nbsp;&nbsp;COMPROBANTES</a> </li>';
		if($_SESSION["IdPerfilUser"]==1 or $_SESSION["IdPerfilUser"]==2 or $_SESSION["IdPerfilUser"]==11){
			echo '<li  id="items">  <a href="'.$_SESSION["NivelArbol"].'Stock.php">&nbsp;&nbsp;STOCK</a> </li>'; 
		}
		//otros
		if($_SESSION["IdPerfilUser"]==1 or $_SESSION["IdPerfilUser"]==2 or $_SESSION["IdPerfilUser"]==11 or $_SESSION["IdPerfilUser"]==14){
			echo '<li id="items" '.$estilodivlista2.'>  <a href="'.$_SESSION["NivelArbol"].'Articulos.php">&nbsp;&nbsp;ARTICULOS</a> </li>';
		}
		if($_SESSION["IdPerfilUser"]==1 or $_SESSION["IdPerfilUser"]==2 or $_SESSION["IdPerfilUser"]==11){
			echo '<li  id="items">  <a href="'.$_SESSION["NivelArbol"].'Proveedores.php">&nbsp;&nbsp;PROVEEDORES</a> </li>'; 
			echo '<li  id="items" '.$estilodivlista2.'><a href="'.$_SESSION["NivelArbol"].'Tablas.php">&nbsp;&nbsp;TABLAS</a></li>';
		}
	}
}






// OPERACIONES
if  ($_SESSION["GLO_IdSistema"]==4 ){
	if($_SESSION["IdPerfilUser"]==1 or $_SESSION["IdPerfilUser"]==2 or $_SESSION["IdPerfilUser"]==3 or $_SESSION["IdPerfilUser"]==9 or $_SESSION["IdPerfilUser"]==14){
		echo '<li onclick="ocultaItems()" id="items" >  <a href="'.$_SESSION["NivelArbol"].'Despacho/Consulta.php">&nbsp;&nbsp;LOGISTICA</a> </li>';
	}
	//perfil Barrera(16) solo ve Barrera
	if($_SESSION["IdPerfilUser"]==1 or $_SESSION["IdPerfilUser"]==2 or $_SESSION["IdPerfilUser"]==3 or $_SESSION["IdPerfilUser"]==9 or $_SESSION["IdPerfilUser"]==14 or $_SESSION["IdPerfilUser"]==16){
		echo '<li onclick="ocultaItems()" id="items">  <a href="'.$_SESSION["NivelArbol"].'Barrera/Consulta.php">&nbsp;&nbsp;BARRERA</a> </li>';
	}
	if($_SESSION["IdPerfilUser"]==1 or $_SESSION["IdPerfilUser"]==2 or $_SESSION["IdPerfilUser"]==3 or $_SESSION["IdPerfilUser"]==9 or $_SESSION["IdPerfilUser"]==14){
		echo '<li onclick="ocultaItems()" id="items">  <a href="'.$_SESSION["NivelArbol"].'CAM/Inbox.php">&nbsp;&nbsp;LABORATORIO</a> </li>';
		echo '<li onclick="ocultaItems()" id="items" '.$estilodivlista.'>  <a href="'.$_SESSION["NivelArbol"].'Planta/Inbox.php">&nbsp;&nbsp;PLANTA</a> </li>';
		echo '<li onclick="ocultaItems()" id="items" '.$estilodivlista.'>  <a href="'.$_SESSION["NivelArbol"].'Procesos/Procesos.php">&nbsp;&nbsp;SOLICITUDES</a> </li>';
	}

	if($_SESSION["IdPerfilUser"]==1 or $_SESSION["IdPerfilUser"]==2 or $_SESSION["IdPerfilUser"]==3 or $_SESSION["IdPerfilUser"]==9 or $_SESSION["IdPerfilUser"]==14 or $_SESSION["IdPerfilUser"]==11){
		echo '<li onclick="ocultaItems()" id="items">  <a href="'.$_SESSION["NivelArbol"].'Clientes.php">&nbsp;&nbsp;CLIENTES</a> </li>';
	}
	if($_SESSION["IdPerfilUser"]==1 or $_SESSION["IdPerfilUser"]==2 or $_SESSION["IdPerfilUser"]==3 or $_SESSION["IdPerfilUser"]==9 or $_SESSION["IdPerfilUser"]==14){
		echo '<li onclick="ocultaItems()" id="items">  <a href="'.$_SESSION["NivelArbol"].'Comprobantes/Oportunidades.php">&nbsp;&nbsp;COMPROBANTES</a> </li>';
		echo '<li onclick="ocultaItems()" id="items">  <a href="'.$_SESSION["NivelArbol"].'Servicios.php">&nbsp;&nbsp;SERVICIOS</a> </li>';
	}
	//tablas
	if ( $_SESSION["IdPerfilUser"]==1 or $_SESSION["IdPerfilUser"]==2 or $_SESSION["IdPerfilUser"]==3 or $_SESSION["IdPerfilUser"]==4 or $_SESSION["IdPerfilUser"]==9 or $_SESSION["IdPerfilUser"]==14 or $_SESSION["IdPerfilUser"]==11){		
		echo '<li onclick="ocultaItems()" id="items" '.$estilodivlista2.'><a href="'.$_SESSION["NivelArbol"].'Tablas.php">&nbsp;&nbsp;TABLAS</a></li>';
	}
	
}
 


// RRHH
if  ($_SESSION["GLO_IdSistema"]==5 ){
	//personal 
	if ( $_SESSION["IdPerfilUser"]==1 or $_SESSION["IdPerfilUser"]==2 or $_SESSION["IdPerfilUser"]==3){ 
		echo '<li id="items">  <a href="'.$_SESSION["NivelArbol"].'Personal.php">&nbsp;&nbsp;LEGAJOS</a> </li>'; 
	}
	if ($_SESSION["IdPerfilUser"]==11){ 
		echo '<li id="items">  <a href="'.$_SESSION["NivelArbol"].'Personal.php">&nbsp;&nbsp;PERSONAL</a> </li>'; 
	}
	//general
	if ( $_SESSION["IdPerfilUser"]==1 or $_SESSION["IdPerfilUser"]==2 or $_SESSION["IdPerfilUser"]==3 ){
		echo '<li onclick="ocultaItems();items(2)" id="items">&nbsp;&nbsp;GENERAL</li>';
		echo '<ul id="ul2" class="submenu">';
		if ( $_SESSION["IdPerfilUser"]==1 or $_SESSION["IdPerfilUser"]==2 ){
			echo '<li id="items">  <a href="'.$_SESSION["NivelArbol"].'HistorialLogin.php">&nbsp;&nbsp;Historial</a></li>';
			echo '<li id="items">  <a href="'.$_SESSION["NivelArbol"].'MiEmpresa.php">&nbsp;&nbsp;Mi Empresa</a> </li>';
		}
		if ( $_SESSION["IdPerfilUser"]==1 or $_SESSION["IdPerfilUser"]==2 or $_SESSION["IdPerfilUser"]==3 ){
			echo '<li id="items">  <a href="'.$_SESSION["NivelArbol"].'Noticias.php">&nbsp;&nbsp;Noticias</a> </li>';
		}
		if ( $_SESSION["IdPerfilUser"]==1 or $_SESSION["IdPerfilUser"]==2 ){
			echo '<li id="items">  <a href="'.$_SESSION["NivelArbol"].'Usuarios.php">&nbsp;&nbsp;Usuarios</a> </li>';	
		}	
		echo '</ul>';
	}
	//tablas
	if ( $_SESSION["IdPerfilUser"]==1 or $_SESSION["IdPerfilUser"]==2 or $_SESSION["IdPerfilUser"]==3 or $_SESSION["IdPerfilUser"]==11){ 
		echo '<li onclick="ocultaItems()" id="items"><a href="'.$_SESSION["NivelArbol"].'Tablas.php">&nbsp;&nbsp;TABLAS</a></li>';
	}
}


// SGI
if ($_SESSION["GLO_IdSistema"]==7){
	if ($_SESSION["IdPerfilUser"]==1 or $_SESSION["IdPerfilUser"]==2 or $_SESSION["IdPerfilUser"]==3 or $_SESSION["IdPerfilUser"]==4 or $_SESSION["IdPerfilUser"]==7 or $_SESSION["IdPerfilUser"]==9 or $_SESSION["IdPerfilUser"]==10 or $_SESSION["IdPerfilUser"]==11 or $_SESSION["IdPerfilUser"]==14){	
		echo '<li id="items">  <a href="'.$_SESSION["NivelArbol"].'ISO_Auditorias.php">&nbsp;&nbsp;AUDITORIAS</a> </li>';
		echo '<li id="items">  <a href="'.$_SESSION["NivelArbol"].'ISO_Cambios.php">&nbsp;&nbsp;CAMBIOS</a> </li>'; 
		echo '<li id="items">  <a href="'.$_SESSION["NivelArbol"].'ISO_Doc.php">&nbsp;&nbsp;DOCUMENTOS</a> </li>';
		echo '<li id="items">  <a href="'.$_SESSION["NivelArbol"].'ISO_Anexos.php">&nbsp;&nbsp;EXTERNOS</a> </li>'; 
		echo '<li id="items">  <a href="'.$_SESSION["NivelArbol"].'ISO_NC.php">&nbsp;&nbsp;NO CONFORM.</a> </li>';
	}
	//sgi externo limitado(15) solo ve matriz
	if ($_SESSION["IdPerfilUser"]==1 or $_SESSION["IdPerfilUser"]==2 or $_SESSION["IdPerfilUser"]==3 or $_SESSION["IdPerfilUser"]==4 or $_SESSION["IdPerfilUser"]==7 or $_SESSION["IdPerfilUser"]==9 or $_SESSION["IdPerfilUser"]==10 or $_SESSION["IdPerfilUser"]==11 or $_SESSION["IdPerfilUser"]==14 or $_SESSION["IdPerfilUser"]==15 ){		
		echo '<li id="items">  <a href="'.$_SESSION["NivelArbol"].'ISO_MLegal.php">&nbsp;&nbsp;MATRIZ LEGAL</a> </li>';	
	}
	if ($_SESSION["IdPerfilUser"]==1 or $_SESSION["IdPerfilUser"]==2 or $_SESSION["IdPerfilUser"]==3 or $_SESSION["IdPerfilUser"]==4 or $_SESSION["IdPerfilUser"]==7 or $_SESSION["IdPerfilUser"]==9 or $_SESSION["IdPerfilUser"]==10 or $_SESSION["IdPerfilUser"]==11 or $_SESSION["IdPerfilUser"]==14){	
		echo '<li id="items">  <a href="'.$_SESSION["NivelArbol"].'ISO_Minutas.php">&nbsp;&nbsp;MINUTAS</a> </li>';	
	}
	if ($_SESSION["IdPerfilUser"]==1 or $_SESSION["IdPerfilUser"]==2 or $_SESSION["IdPerfilUser"]==9 or $_SESSION["IdPerfilUser"]==14){	
		echo '<li id="items">  <a href="'.$_SESSION["NivelArbol"].'ISO_Planes.php">&nbsp;&nbsp;PLANES</a> </li>';
		echo '<li id="items">  <a href="'.$_SESSION["NivelArbol"].'ISOProgramas/Consulta.php">&nbsp;&nbsp;PROGRAMAS</a> </li>';
	}
	if ($_SESSION["IdPerfilUser"]==1 or $_SESSION["IdPerfilUser"]==2 or $_SESSION["IdPerfilUser"]==3 or $_SESSION["IdPerfilUser"]==4 or $_SESSION["IdPerfilUser"]==7 or $_SESSION["IdPerfilUser"]==9 or $_SESSION["IdPerfilUser"]==10 or $_SESSION["IdPerfilUser"]==11 or $_SESSION["IdPerfilUser"]==14){	
		echo '<li id="items" '.$estilodivlista2.'>  <a href="'.$_SESSION["NivelArbol"].'ISO_Tablas.php">&nbsp;&nbsp;TABLAS</a> </li>';
	}
}


// SMA
if ($_SESSION["GLO_IdSistema"]==6){
	if ( $_SESSION["IdPerfilUser"]==1 or $_SESSION["IdPerfilUser"]==2 or $_SESSION["IdPerfilUser"]==3  or $_SESSION["IdPerfilUser"]==9 or $_SESSION["IdPerfilUser"]==14){
		echo '<li id="items">  <a href="'.$_SESSION["NivelArbol"].'ExtintoresSMA.php">&nbsp;&nbsp;EXTINTORES</a> </li>';  
		echo '<li id="items">  <a href="'.$_SESSION["NivelArbol"].'Incidentes.php">&nbsp;&nbsp;INCIDENTES</a> </li>'; 
		echo '<li id="items">  <a href="'.$_SESSION["NivelArbol"].'InspeccionesSMA.php">&nbsp;&nbsp;INSPECCIONES</a> </li>';  
		echo '<li id="items">  <a href="'.$_SESSION["NivelArbol"].'PSSA.php">&nbsp;&nbsp;PSSA</a> </li>'; 
		echo '<li id="items">  <a href="'.$_SESSION["NivelArbol"].'TOT.php">&nbsp;&nbsp;TOT</a> </li>'; 
		//tablas
		echo '<li onclick="ocultaItems()" id="items" '.$estilodivlista2.'><a href="'.$_SESSION["NivelArbol"].'Tablas.php">&nbsp;&nbsp;TABLAS</a></li>';
	}
}



// MANTENIMIENTO
if ($_SESSION["GLO_IdSistema"]==3){
	if ( $_SESSION["IdPerfilUser"]==1 or $_SESSION["IdPerfilUser"]==2 or $_SESSION["IdPerfilUser"]==3 or $_SESSION["IdPerfilUser"]==4 or $_SESSION["IdPerfilUser"]==7 or $_SESSION["IdPerfilUser"]==9 or $_SESSION["IdPerfilUser"]==11 or $_SESSION["IdPerfilUser"]==14 ){
		echo '<li id="items">  <a href="'.$_SESSION["NivelArbol"].'Unidades.php">&nbsp;&nbsp;UNIDADES</a> </li>'; 
		echo '<li id="items" >  <a href="'.$_SESSION["NivelArbol"].'UnidadesKm/Consulta.php">&nbsp;&nbsp;CONTROL RSV</a> </li>';
		echo '<li id="items" '.$estilodivlista2.'>  <a href="'.$_SESSION["NivelArbol"].'Reparaciones/Solicitudes.php">&nbsp;&nbsp;REPARACIONES</a> </li>'; 
		echo '<li id="items" '.$estilodivlista2.'>  <a href="'.$_SESSION["NivelArbol"].'Accesorios/Consulta.php">&nbsp;&nbsp;ACCESORIOS</a>'; 
		echo '<li id="items" '.$estilodivlista2.'>  <a href="'.$_SESSION["NivelArbol"].'SectorM.php">&nbsp;&nbsp;SECTORES</a> </li>';
	}
}



// INDICADORES
if ($_SESSION["GLO_IdSistema"]==10){
		
	echo '<li id="items" '.$estilodivlista.'>  <a href="'.$_SESSION["NivelArbol"].'Objetivos/Objetivos.php">&nbsp;&nbsp;OBJETIVOS</a> </li>';
	/*
	if ( $_SESSION["IdPerfilUser"]==1 or $_SESSION["IdPerfilUser"]==2 or $_SESSION["IdPerfilUser"]==11 ){
		echo '<li id="items">  <a href="'.$_SESSION["NivelArbol"].'Indicadores/Compras.php">&nbsp;&nbsp;COMPRAS</a> </li>';
	}

	if ( $_SESSION["IdPerfilUser"]==1 or $_SESSION["IdPerfilUser"]==2 or $_SESSION["IdPerfilUser"]==4  or $_SESSION["IdPerfilUser"]==9 ){
		echo '<li id="items" >  <a href="'.$_SESSION["NivelArbol"].'Indicadores/Operaciones1.php">&nbsp;&nbsp;OPERACIONES</a> </li>';
	}
	*/
	if ( $_SESSION["IdPerfilUser"]==1 or $_SESSION["IdPerfilUser"]==2 or $_SESSION["IdPerfilUser"]==3){
		echo '<li id="items">  <a href="'.$_SESSION["NivelArbol"].'Indicadores/RRHH2.php">&nbsp;&nbsp;RRHH</a> </li>';
	}

	if ( $_SESSION["IdPerfilUser"]==1 or $_SESSION["IdPerfilUser"]==2 or $_SESSION["IdPerfilUser"]==4  or $_SESSION["IdPerfilUser"]==9 ){
		echo '<li id="items" >  <a href="'.$_SESSION["NivelArbol"].'Indicadores/UNI.php">&nbsp;&nbsp;UNIDADES</a> </li>';
	}
}


?>

</ul>
<script type="text/javascript">
ocultaItems()
</script>
</div>
</td></tr>
</table>
<!--fin menu-->

</td>
<td  style="width:1.8rem" class="fondo" >&nbsp; </td>