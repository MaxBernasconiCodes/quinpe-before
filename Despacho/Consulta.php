<? include("../Codigo/Seguridad.php") ; $_SESSION["NivelArbol"]="../";include("../Codigo/Config.php");include("../Codigo/Funciones.php");include("zFunciones.php");require_once('../Codigo/calendar/classes/tc_calendar.php');
//perfiles
if ($_SESSION["IdPerfilUser"]!=1 and $_SESSION["IdPerfilUser"]!=2  and $_SESSION["IdPerfilUser"]!=3  and $_SESSION["IdPerfilUser"]!=9 and $_SESSION["IdPerfilUser"]!=14){ header("Location:".$_SESSION["NivelArbol"]."Inicio.php");}

$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);

if (empty($_SESSION['TxtFechaD'])){
	$hoy=date("d-m-Y"); list($d,$m,$a)=explode("-",$hoy);
	$_SESSION['TxtFechaD']=date("d-m-Y", strtotime("$hoy -1 day"));
	$_SESSION['TxtFechaH']=$hoy;
	//$primerdiames="01-".$m."-".$a;$mesrestar=0;
	//$_SESSION['TxtFechaD']=date("d-m-Y", strtotime("$primerdiames -$mesrestar month"));
}



function MostrarTabla($conn){
$query=$_SESSION['TxtQOPEDES'];$query=str_replace("\\", "", $query);
if ( ($query!="")){	
	$rs=mysql_query($query,$conn);
	if(mysql_num_rows($rs)!=0){	
		//Titulos de la tabla
		$tablaclientes='';
		$tablaclientes .=GLO_inittabla(1090,1,0,0);
		$tablaclientes .="<td "."width="."50"." class="."TableShowT".">Pedido</td>";  
		$tablaclientes .='<td width="30" class="TableShowT"> Mes</td>';
		$tablaclientes .='<td width="30" class="TableShowT"> Sem</td>';
		$tablaclientes .='<td width="30" class="TableShowT"> Dia</td>'; 
		$tablaclientes .="<td "."width="."70"." class="."TableShowT"."> Fecha</td>";   
		$tablaclientes .='<td width="35" class="TableShowT"> Hora</td>';
		$tablaclientes .="<td "."width="."80"." class="."TableShowT"."> Cliente</td>"; 
		$tablaclientes .='<td width="50" class="TableShowT TAR"> Remito</td>';
		$tablaclientes .='<td width="50" class="TableShowT TAR"> Solicitud</td>';
		$tablaclientes .="<td "."width="."145"." class="."TableShowT"."> Accion</td>"; 
		$tablaclientes .="<td "."width="."100"." class="."TableShowT"."> Linea A</td>";
		$tablaclientes .="<td "."width="."130"." class="."TableShowT"."> Camion</td>";
		$tablaclientes .="<td "."width="."130"." class="."TableShowT"."> Semi</td>";
		$tablaclientes .='<td width="90" class="TableShowT"> Estado</td>';		
		$tablaclientes .="<td "."width="."30"." class="."TableShowT"."> </td>";   
		$tablaclientes .='</tr>';    
		$recuento=0;$_SESSION['TxtOriOPEDes']=0;//para que vuelva           
		$estilo=" style='cursor:pointer;' ";$clase="TableShowD";
		while($row=mysql_fetch_array($rs)){ 			
			$link=" onclick="."location='Modificar.php?Flag1=True&id=".$row['Id']."'";	
			$idestado=DES_asignar_estado($row['IdPadre'],$row['Id'],$conn);//estado pedido
			DES_Estado($idestado,$colorrow,$colorfield,$estado);	
			//buscar dominios
			DES_Dominios($row['Id'],$conn,$domcamion,$domsemi);			
			//muestro  
			$tablaclientes .='<tr '.$estilo.GLO_highlight($row['Id']).'>'; 
			$tablaclientes .="<td class=".$clase.$link."> ".str_pad($row['Id'], 6, "0", STR_PAD_LEFT)."</td>"; 
			$tablaclientes .='<td class="TableShowD"'.$link.'>'.date("m",strtotime($row['Fecha']))."</td>";
			$tablaclientes .='<td class="TableShowD"'.$link.'>'.date("W",strtotime($row['Fecha']))."</td>";
			$tablaclientes .='<td class="TableShowD"'.$link.'>'.date("D",strtotime($row['Fecha']))."</td>";
			$tablaclientes .="<td class=".$clase.$link."> ".FormatoFecha($row['Fecha'])."</td>"; 
			$tablaclientes .='<td class="TableShowD"'.$link.'>'.GLO_FormatoHora($row['Hora'])."</td>";
			$tablaclientes .="<td class=".$clase.$link."> ".substr($row['Nombre'],0,10)."</td>";  
			$tablaclientes .='<td class="TableShowD TAR"'.$link.'>'.GLO_SinCero($row['Rto'])."</td>";
			$tablaclientes .='<td class="TableShowD TAR TBold TL12"'.$link.'>'.$row['IdPadre']."</td>";
			$tablaclientes .='<td class="TableShowD"'.$link.'>'.$row['Tipo']."</td>"; 
			$tablaclientes .='<td class="TableShowD"'.$link.'>'.substr($row['LineaA'],0,12)."</td>"; 
			$tablaclientes .='<td class="TableShowD"'.$link.'>'.$domcamion."</td>";   
			$tablaclientes .='<td class="TableShowD"'.$link.'>'.$domsemi."</td>"; 
			$tablaclientes .='<td class="TableShowD TBold"'.$link.$colorrow.">".substr($estado,0,20)."</td>";   
			$tablaclientes .="<td class="."TableShowD"." style='text-align:center;'>";  
			//solo elimina si esta pendiente
			if($idestado==1){
				$tablaclientes .=GLO_rowbutton("CmdBorrarFila",$row['Id'],"Eliminar",'self','trash','iconlgray','Eliminar',1,0,0);
			}			  
			$tablaclientes .="</td></tr>";  
			$recuento=$recuento+1;
		}	
		$tablaclientes .=GLO_fintabla(2,0,$recuento);
		echo $tablaclientes;
	}mysql_free_result($rs);	
}
}

GLO_InitHTML($_SESSION["NivelArbol"],'','BannerConMenuHV','zConsulta',0,0,0,0);
GLO_tituloypath(950,700,'../Inicio.php','PEDIDOS LOGISTICA','linksalir');

include("Includes/zCamposFiltros.php"); 

GLO_linkbutton(700,'Agregar','Alta.php','','','','');
GLO_Hidden('TxtId',0);
GLO_Hidden('TxtQOPEDES',0);GLO_Hidden('TxtQOPEDESXLS',0);GLO_Hidden('TxtQOPEDESXLS2',0);
GLO_mensajeerror(); 
MostrarTabla($conn); 
mysql_close($conn);
GLO_cierratablaform();

GLO_initcomment(0,0);
echo 'Solo es posible eliminar el <font class="comentario3">Pedido</font> si esta <font class="comentario2">PENDIENTE</font>';
GLO_endcomment();

include ("../Codigo/FooterConUsuario.php");
?>