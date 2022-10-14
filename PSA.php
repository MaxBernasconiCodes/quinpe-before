<? include("Codigo/Seguridad.php") ;$_SESSION["NivelArbol"]="";include("Codigo/Funciones.php");include("Codigo/Config.php");

//perfiles

if ($_SESSION["IdPerfilUser"]!=1 and $_SESSION["IdPerfilUser"]!=2 and $_SESSION["IdPerfilUser"]!=4 and $_SESSION["IdPerfilUser"]!=7 and $_SESSION["IdPerfilUser"]!=3  and $_SESSION["IdPerfilUser"]!=11  and $_SESSION["IdPerfilUser"]!=12  and $_SESSION["IdPerfilUser"]!=9 and $_SESSION["IdPerfilUser"]!=14 and $_SESSION["IdPerfilUser"]!=13){ header("Location:".$_SESSION["NivelArbol"]."Inicio.php");}







$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);





function MostrarTabla($conn){

$query="SELECT pa.*,t.Nombre as Tipo,p.Identificacion,p.Nombre as Aseg From polizassegauto pa,polizasaseg p,polizastipo t where pa.Id<>0 and pa.IdTipo=t.Id and pa.IdAseg=p.Id  Order by p.Nombre";

$rs=mysql_query($query,$conn);

//Titulos de la tabla

$tablaclientes='';

$tablaclientes .=GLO_inittabla(700,0,0,0);

$tablaclientes .='<td class="TablaTituloLeft"></td>';

$tablaclientes .="<td "."width="."60"." class="."TablaTituloDato"." style='text-align:right;'> N&uacute;mero</td>";   

$tablaclientes .='<td class="TablaTituloLeft"></td>';

$tablaclientes .="<td "."width="."120"." class="."TablaTituloDato".">Tipo</td>";   

$tablaclientes .='<td class="TablaTituloLeft"></td>';

$tablaclientes .="<td "."width="."250"." class="."TablaTituloDato".">Aseguradora</td>";   

$tablaclientes .='<td class="TablaTituloLeft"></td>'; 

$tablaclientes .="<td "."width="."100"." class="."TablaTituloDato"."> CUIT</td>"; 

$tablaclientes .='<td class="TablaTituloLeft"></td>'; 

$tablaclientes .="<td "."width="."65"." class="."TablaTituloDato"."> Inicio</td>"; 

$tablaclientes .='<td class="TablaTituloLeft"></td>'; 

$tablaclientes .="<td "."width="."65"." class="."TablaTituloDato"."> Fin</td>"; 

$tablaclientes .='<td class="TablaTituloLeft"></td>';

$tablaclientes .="<td "."width="."40"." class="."TablaTituloDato"."> </td>"; 

$tablaclientes .='<td class="TablaTituloRight"></td>';  

$tablaclientes .='</tr>';    

$recuento=0;    

$clase="TablaDato";   $estilo=" style='cursor:pointer;' ";  

//Datos

while($row=mysql_fetch_array($rs)){ 	

	$link=" onclick="."location='PSA/Modificar.php?Flag1=True&id=".$row['Id']."'";

	$fvto=GLO_FormatoFecha($row['FechaF']);

	//muestro

	$tablaclientes .='<tr '.$estilo.'>';  

	$tablaclientes .='<td class="TablaMostrarLeft"></td>';  

	$tablaclientes .="<td class=".$clase.$link." style='text-align:right;'> ".str_pad($row['Nro'], 6, "0", STR_PAD_LEFT)."</td>"; 

	$tablaclientes .='<td class="TablaMostrarLeft"></td>';  

	$tablaclientes .="<td class=".$clase.$link."> ".substr($row['Tipo'],0,15)."</td>"; 

	$tablaclientes .='<td class="TablaMostrarLeft"></td>';  

	$tablaclientes .="<td class=".$clase.$link."> ".substr($row['Aseg'],0,25)."</td>"; 

	$tablaclientes .='<td class="TablaMostrarLeft"></td>'; 

	$tablaclientes .="<td class=".$clase.$link."> ".substr($row['Identificacion'],0,14)."</td>"; 

	$tablaclientes .='<td class="TablaMostrarLeft"></td>';  

	$tablaclientes .="<td class=".$clase.$link."> ".GLO_FormatoFecha($row['FechaI'])."</td>";  

	$tablaclientes .='<td class="TablaMostrarLeft"></td>';  

	if ($fvto!="" and (strtotime(date("d-m-Y"))-strtotime($fvto))>0)

	{$tablaclientes .="<td class="."TablaDatoRed".$link."> ".$fvto."</td>";}else{$tablaclientes .="<td class=".$clase.$link."> ".$fvto."</td>";}	 

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



<form  name="Formulario" action="PSA/zConsulta.php" method="post">

<?php GLO_tituloypath(950,700,'unidades','POLIZAS SEGURO','basica'); ?>





<? GLO_mensajeerror();

MostrarTabla($conn);

 ?>



<table  width="700" border="0" cellspacing="0" cellpadding="0"  align="center">

<tr><td  height=3 ><input  name="TxtId"  type="hidden"  value="<? echo $_SESSION['TxtId']; ?>"></td></tr>					

</table>



<? GLO_cierratablaform(); ?>



<? mysql_close($conn); ?>

		





<? include ("Codigo/FooterConUsuario.php");?>

?> 



