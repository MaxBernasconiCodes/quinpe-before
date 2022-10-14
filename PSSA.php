<? include("Codigo/Seguridad.php") ;include("Codigo/Config.php") ;include("Codigo/Funciones.php") ;$_SESSION["NivelArbol"]="";

//perfiles

if ($_SESSION["IdPerfilUser"]!=1 and $_SESSION["IdPerfilUser"]!=2 and $_SESSION["IdPerfilUser"]!=3 and $_SESSION["IdPerfilUser"]!=9 and $_SESSION["IdPerfilUser"]!=14 ){ header("Location:".$_SESSION["NivelArbol"]."Inicio.php");}



$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);





function MostrarTabla($conn){

$query="SELECT p.* From pssa p Where p.Id<>0";$rs=mysql_query($query,$conn);

if(mysql_num_rows($rs)!=0){	

	//Titulos de la tabla

	$tablaclientes='';

	$tablaclientes .=GLO_inittabla(400,0,0,0);

	$tablaclientes .='<td class="TablaTituloLeft"></td>';

	$tablaclientes .="<td "."width="."100"." class="."TablaTituloDato"." > A&ntilde;o</td>";  

	$tablaclientes .='<td class="TablaTituloLeft"></td>';

	$tablaclientes .="<td "."width="."300"." class="."TablaTituloDato"."> Actualizaci&oacute;n</td>";   

	$tablaclientes .='<td class="TablaTituloRight"></td>';  

	$tablaclientes .='</tr>';    

	$recuento=0;          

	$estilo=" style='cursor:pointer;' ";$clase="TablaDato";

	while($row=mysql_fetch_array($rs)){ 

		$link=" onclick="."location='PSSA/Modificar.php?Flag1=True&id=".$row['Id']."'";

		//muestro

		$tablaclientes .='<tr '.$estilo.'>';  

		$tablaclientes .='<td class="TablaMostrarLeft"></td>';  

		$tablaclientes .="<td class=".$clase.$link." > ".$row['Year']."</td>"; 

		$tablaclientes .='<td class="TablaMostrarLeft"></td>';    

		$tablaclientes .="<td class=".$clase.$link." > ".GLO_FormatoFecha($row['FechaA'])."</td>"; 

		$tablaclientes .='<td class="TablaMostrarRight"></td>';  

		$tablaclientes .='</tr>'; 

		$recuento=$recuento+1;

	}	

	$tablaclientes .=GLO_fintabla(0,0,$recuento);

	echo $tablaclientes;	

}else{echo '<p class="MuestraConf" align="center">No existen datos que cumplan esos criterios</p>';}

mysql_free_result($rs);

}





GLOF_Init('','BannerConMenuHV','',0,'',0,0,0); 

GLO_tituloypath(950,400,'Inicio.php','PSSA','linksalir');



GLO_Hidden('TxtId',0);

GLO_linkbutton(400,'Agregar','PSSA/Alta.php','Tablas','PSSA/Tablas.php','','');

GLO_mensajeerror();

MostrarTabla($conn);

GLO_cierratablaform();

mysql_close($conn);

include ("Codigo/FooterConUsuario.php");

?>