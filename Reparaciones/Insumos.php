<? include("../Codigo/Seguridad.php") ;include("../Codigo/Config.php") ;include("../Codigo/Funciones.php") ;$_SESSION["NivelArbol"]="../";require_once('../Codigo/calendar/classes/tc_calendar.php');include("zFunciones.php");
//perfiles
if ($_SESSION["IdPerfilUser"]!=1 and $_SESSION["IdPerfilUser"]!=2 and $_SESSION["IdPerfilUser"]!=4 and $_SESSION["IdPerfilUser"]!=7 and $_SESSION["IdPerfilUser"]!=3  and $_SESSION["IdPerfilUser"]!=11  and $_SESSION["IdPerfilUser"]!=12  and $_SESSION["IdPerfilUser"]!=9 and $_SESSION["IdPerfilUser"]!=14 ){ header("Location:".$_SESSION["NivelArbol"]."Inicio.php");}

//completa fecha por defecto
if (empty($_SESSION['TxtFechaD'])){
	$hoy=date("d-m-Y"); list($d,$m,$a)=explode("-",$hoy);$primerdiames="01-".$m."-".$a;$mesrestar=1;
	$_SESSION['TxtFechaD']=date("d-m-Y", strtotime("$primerdiames -1 month"));
	$nextmonth=date("d-m-Y", strtotime("$primerdiames +1 month")); 
	$_SESSION['TxtFechaH']=date("d-m-Y", strtotime("$nextmonth -1 day"));
}


$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);


function MostrarTabla($conn){
$query=$_SESSION['TxtQueryRepIns'];$query=str_replace("\\", "", $query);
if (  ($query!="")){	
	$rs=mysql_query($query,$conn);
	if(mysql_num_rows($rs)!=0){	
		//Titulos de la tabla
		$tablaclientes='';
		$tablaclientes .=GLO_inittabla(1000,1,0,0);
		$tablaclientes .="<td "."width="."50"." class="."TableShowT"." style='text-align:right;'> Orden</td>";  
		$tablaclientes .="<td "."width="."70"." class="."TableShowT"."> F.Orden</td>";  
		$tablaclientes .="<td "."width="."140"." class="."TableShowT".">Unidad </td>";   
		$tablaclientes .="<td "."width="."130"." class="."TableShowT".">Sector</td>"; 
		$tablaclientes .="<td "."width="."130"." class="."TableShowT".">Equipo</td>"; 
		$tablaclientes .="<td "."width="."100"." class="."TableShowT"." > Estado Orden</td>";  
		$tablaclientes .="<td "."width="."290"." class="."TableShowT"."> Repuesto/Insumo</td>";   
		$tablaclientes .="<td "."width="."30"." class="."TableShowT"."></td>";   
		$tablaclientes .="<td "."width="."60"." class="."TableShowT"." style='text-align:right;'> Cantidad</td>"; 
		$tablaclientes .='</tr>';    
		$recuento=0; $clase="TableShowD"; $estilo="";$link="";    
		while($row=mysql_fetch_array($rs)){ 			
			$tablaclientes .='<tr '.$estilo.'>';  
			$tablaclientes .="<td class=".$clase.$link." style='text-align:right;'> ".str_pad($row['Id'], 6, "0", STR_PAD_LEFT)."</td>"; 
			$tablaclientes .="<td class=".$clase.$link."> ".GLO_FormatoFecha($row['Fecha'])."</td>";  
			$tablaclientes .="<td class=".$clase.$link."> ".substr($row['Uni'].' '.$row['Dominio'],0,15)."</td>"; 
			$tablaclientes .="<td class=".$clase.$link."> ".substr($row['Sector'],0,15)."</td>"; 
			$tablaclientes .="<td class=".$clase.$link."> ".substr($row['Instr'],0,15)."</td>"; 
			$tablaclientes .="<td class=".$clase.$link."> ".substr($row['Estado'],0,10)."</td>"; 
			$tablaclientes .="<td class=".$clase.$link."> ".str_pad($row['IdArti'], 6, "0", STR_PAD_LEFT).' '.substr($row['Articulo'],0,36)."</td>"; 
			$tablaclientes .="<td class=".$clase.$link."> ".substr($row['Abr'],0,5)."</td>"; 
			$tablaclientes .="<td class=".$clase.$link." style='text-align:right;'> ".$row['Cant']."</td>"; 
			$tablaclientes .='</tr>'; 
			$recuento=$recuento+1;
		}mysql_free_result($rs);	
		$tablaclientes .=GLO_fintabla(1,0,$recuento);
		echo $tablaclientes;	
	}else{echo '<p class="MuestraConf" align="center">No existen datos que cumplan esos criterios</p>';}
}
}

GLOF_Init('TxtNroInterno','BannerConMenuHV','zInsumos',0,'MenuH',0,0,0);
GLO_tituloypath(0,750,'Reportes.php','REPUESTOS/INSUMOS','linksalir');

include("Includes/zFiltrosRep.php") ;
GLO_Hidden('TxtQueryRepIns',0);
GLO_mensajeerror();
MostrarTabla($conn); 
GLO_cierratablaform();
mysql_close($conn);

GLO_initcomment(0,0);
echo 'Al filtrar por <font class="comentario2">Unidad</font> busca por <font class="comentario3">Numero</font> y <font class="comentario3">Nombre</font>';
GLO_endcomment();

include ("../Codigo/FooterConUsuario.php");
?>