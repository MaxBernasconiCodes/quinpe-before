<? include("Codigo/Seguridad.php") ;include("Codigo/Config.php") ;include("Codigo/Funciones.php") ;$_SESSION["NivelArbol"]="";

//perfiles

if ($_SESSION["IdPerfilUser"]!=1 and $_SESSION["IdPerfilUser"]!=2 and $_SESSION["IdPerfilUser"]!=4 and $_SESSION["IdPerfilUser"]!=7 and $_SESSION["IdPerfilUser"]!=3  and $_SESSION["IdPerfilUser"]!=11  and $_SESSION["IdPerfilUser"]!=12  and $_SESSION["IdPerfilUser"]!=9 and $_SESSION["IdPerfilUser"]!=14 and $_SESSION["IdPerfilUser"]!=13){ header("Location:".$_SESSION["NivelArbol"]."Inicio.php");}





$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);





function MostrarTabla($conn){

$query="SELECT * From polizasaseg where Id<>0 Order by Nombre";$rs=mysql_query($query,$conn);

//Titulos de la tabla

$tablaclientes='';

$tablaclientes .=GLO_inittabla(600,0,0,0);

$tablaclientes .='<td class="TablaTituloLeft"></td>';

$tablaclientes .="<td "."width="."60"." class="."TablaTituloDato"." style='text-align:right;'> N&uacute;mero</td>";   

$tablaclientes .='<td class="TablaTituloLeft"></td>';

$tablaclientes .="<td "."width="."400"." class="."TablaTituloDato".">Nombre</td>";   

$tablaclientes .='<td class="TablaTituloLeft"></td>'; 

$tablaclientes .="<td "."width="."100"." class="."TablaTituloDato"."> CUIT</td>"; 

$tablaclientes .='<td class="TablaTituloLeft"></td>';

$tablaclientes .="<td "."width="."40"." class="."TablaTituloDato"."> </td>"; 

$tablaclientes .='<td class="TablaTituloRight"></td>';  

$tablaclientes .='</tr>';    

$recuento=0;    

$clase="TablaDato";   $estilo=" style='cursor:pointer;' ";  

//Datos

while($row=mysql_fetch_array($rs)){ 	

	$link=" onclick="."location='PSAseguradoras/Modificar.php?Flag1=True&id=".$row['Id']."'";

	//muestro

	$tablaclientes .='<tr '.$estilo.'>';  

	$tablaclientes .='<td class="TablaMostrarLeft"></td>';  

	$tablaclientes .="<td class=".$clase.$link." style='text-align:right;'> ".str_pad($row['Id'], 6, "0", STR_PAD_LEFT)."</td>"; 

	$tablaclientes .='<td class="TablaMostrarLeft"></td>';  

	$tablaclientes .="<td class=".$clase.$link."> ".substr($row['Nombre'],0,35)."</td>"; 

	$tablaclientes .='<td class="TablaMostrarLeft"></td>'; 

	$tablaclientes .="<td class=".$clase.$link."> ".substr($row['Identificacion'],0,14)."</td>"; 

	$tablaclientes .='<td class="TablaMostrarLeft"></td>';  

	$tablaclientes .="<td class="."TablaDato"." style='text-align:center;'>";  	

	$tablaclientes .=GLO_rowbutton("CmdBorrarFila",$row['Id'],"Eliminar",'self','trash','iconlgray','Eliminar',0,0,0);

	$tablaclientes .="</td><td class="."TablaMostrarRight"."> </td>";  

	$tablaclientes .='</tr>'; 

	$recuento=$recuento+1;

}	

$tablaclientes .=GLO_fintabla(1,0,$recuento);

echo $tablaclientes;	

//Cierra consulta

mysql_free_result($rs);

}









?> 



<? include ("Codigo/HeadFull.php");?>

<link rel="STYLESHEET" type="text/css" href="CSS/Estilo.css" >



<? GLO_bodyform('',0,0);?>

<? include ("Codigo/BannerConMenuHV.php");?>



<form  name="Formulario" action="PSAseguradoras/zConsulta.php" method="post">

<?php GLO_tituloypath(950,600,'unidades','ASEGURADORAS','basica'); ?>



<? 

GLO_mensajeerror();

MostrarTabla($conn);

?>



<table  width="600" border="0" cellspacing="0" cellpadding="0"  align="center">

<tr><td  height=3 ><input  name="TxtId"  type="hidden"  value="<? echo $_SESSION['TxtId']; ?>"></td></tr>					

</table>





<? GLO_cierratablaform(); ?>



<? mysql_close($conn); ?>

		





<? include ("Codigo/FooterConUsuario.php");?>