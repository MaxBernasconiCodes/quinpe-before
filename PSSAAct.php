<? include("Codigo/Seguridad.php") ;$_SESSION["NivelArbol"]="";include("Codigo/Funciones.php");include("Codigo/Config.php");

//perfiles

if ($_SESSION["IdPerfilUser"]!=1 and $_SESSION["IdPerfilUser"]!=2 and $_SESSION["IdPerfilUser"]!=3 and $_SESSION["IdPerfilUser"]!=9 and $_SESSION["IdPerfilUser"]!=14 ){ header("Location:".$_SESSION["NivelArbol"]."Inicio.php");}







$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);





function MostrarTabla($conn){

$query="SELECT a.*,t.Nombre as Tipo,f.Nombre as Frec,r.Nombre as Resp From pssa_act a,pssa_tipo t,pssa_frec f, pssa_resp r where a.Id<>0 and a.IdTipo=t.Id and a.IdFrec=f.Id and a.IdResp=r.Id  Order by t.Nombre,f.Nombre,a.Nombre";

$rs=mysql_query($query,$conn);

//Titulos de la tabla

$tablaclientes='';

$tablaclientes .=GLO_inittabla(750,0,0,0);

$tablaclientes .='<td class="TablaTituloLeft"></td>';

$tablaclientes .="<td "."width="."60"." class="."TablaTituloDato"." style='text-align:right;'> N&uacute;mero</td>";  

$tablaclientes .='<td class="TablaTituloLeft"></td>';

$tablaclientes .="<td "."width="."100"." class="."TablaTituloDato".">Tipo</td>";   

$tablaclientes .='<td class="TablaTituloLeft"></td>';

$tablaclientes .="<td "."width="."350"." class="."TablaTituloDato".">Actividad</td>";   

$tablaclientes .='<td class="TablaTituloLeft"></td>'; 

$tablaclientes .="<td "."width="."100"." class="."TablaTituloDato"."> Frecuencia</td>"; 

$tablaclientes .='<td class="TablaTituloLeft"></td>'; 

$tablaclientes .="<td "."width="."100"." class="."TablaTituloDato"."> Responsable</td>"; 

$tablaclientes .='<td class="TablaTituloLeft"></td>';

$tablaclientes .="<td "."width="."40"." class="."TablaTituloDato"."> </td>"; 

$tablaclientes .='<td class="TablaTituloRight"></td>';  

$tablaclientes .='</tr>';    

$recuento=0;    

$clase="TablaDato";   $estilo=" style='cursor:pointer;'";  

//Datos

while($row=mysql_fetch_array($rs)){ 	

	$link=" onclick="."location='PSSAAct/Modificar.php?Flag1=True&id=".$row['Id']."'";

	//muestro

	$tablaclientes .='<tr '.$estilo.'>';  

	$tablaclientes .='<td class="TablaMostrarLeft"></td>';  

	$tablaclientes .="<td class=".$clase.$link." style='text-align:right;'> ".str_pad($row['Id'], 6, "0", STR_PAD_LEFT)."</td>"; 

	$tablaclientes .='<td class="TablaMostrarLeft"></td>';  

	$tablaclientes .="<td class=".$clase.$link."> ".substr($row['Tipo'],0,15)."</td>"; 

	$tablaclientes .='<td class="TablaMostrarLeft"></td>';  

	$tablaclientes .="<td class=".$clase.$link."> ".substr($row['Nombre'],0,55)."</td>"; 

	$tablaclientes .='<td class="TablaMostrarLeft"></td>';  

	$tablaclientes .="<td class=".$clase.$link."> ".substr($row['Frec'],0,15)."</td>"; 

	$tablaclientes .='<td class="TablaMostrarLeft"></td>'; 

	$tablaclientes .="<td class=".$clase.$link."> ".substr($row['Resp'],0,15)."</td>"; 

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







GLOF_Init('','BannerConMenuHV','PSSAAct/zConsulta',0,'',0,0,0); 

GLO_tituloypath(950,750,'pssa','ACTIVIDADES','basica');



GLO_mensajeerror();

GLO_Hidden('TxtId',0);

MostrarTabla($conn);

GLO_cierratablaform();

mysql_close($conn);

include ("Codigo/FooterConUsuario.php");

?>