<? include("Codigo/Seguridad.php") ;include("Codigo/Config.php") ;include("Codigo/Funciones.php") ;$_SESSION["NivelArbol"]="";
require_once('Codigo/calendar/classes/tc_calendar.php');

//perfiles
if ($_SESSION["IdPerfilUser"]!=1 and $_SESSION["IdPerfilUser"]!=2 and $_SESSION["IdPerfilUser"]!=3 and $_SESSION["IdPerfilUser"]!=9 and $_SESSION["IdPerfilUser"]!=14 ){ header("Location:".$_SESSION["NivelArbol"]."Inicio.php");}

$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);

//completa fecha por defecto
if (empty($_SESSION['TxtFechaD'])){
	$hoy=date("d-m-Y"); list($d,$m,$a)=explode("-",$hoy);$primerdiames="01-".$m."-".$a;$mesrestar=1;
	$_SESSION['TxtFechaD']=date("d-m-Y", strtotime("$primerdiames -0 month"));
	$nextmonth=date("d-m-Y", strtotime("$primerdiames +1 month")); 
	$_SESSION['TxtFechaH']=date("d-m-Y", strtotime("$nextmonth -1 day"));
}


function MostrarTabla($conn){
$query=$_SESSION['TxtQINSP'];$query=str_replace("\\", "", $query);
if (  ($query!="")){	
	$rs=mysql_query($query,$conn);
	if(mysql_num_rows($rs)!=0){	
		$tablaclientes='';
		$tablaclientes .=GLO_inittabla(700,1,0,0);
		$tablaclientes .="<td "."width="."100"." class="."TableShowT"."> Fecha</td>";   
		$tablaclientes .="<td "."width="."280"." class="."TableShowT"."> Area</td>";   
		$tablaclientes .="<td "."width="."290"." class="."TableShowT"."> Equipo</td>";   
		$tablaclientes .="<td "."width="."30"." class="."TableShowT"."> </td>";   
		$tablaclientes .='</tr>';    
		$recuento=0;          
		$estilo=" style='cursor:pointer;' ";
		while($row=mysql_fetch_array($rs)){ 
			$link=" onclick="."location='InspeccionesSMA/Modificar.php?Flag1=True&id=".$row['Id']."'";
			//muestro
			$tablaclientes .='<tr '.$estilo.GLO_highlight($row['Id']).'>'; 
			$tablaclientes .="<td class="."TableShowD".$link." > ".GLO_FormatoFecha($row['Fecha']).' '.GLO_FormatoHora($row['Hora'])."</td>"; 
			$tablaclientes .="<td class="."TableShowD".$link."> ".substr($row['Yac'],0,20)."</td>"; 
			$tablaclientes .="<td class="."TableShowD".$link."> ".substr($row['Centro'],0,20)."</td>";  
			$tablaclientes .='<td class="TableShowD TAC">'.GLO_rowbutton("CmdBorrarFila",$row['Id'],"Eliminar",'self','trash','iconlgray','Eliminar',1,0,0). "</td>";  
			$tablaclientes .='</tr>'; 
			$recuento=$recuento+1;
		}mysql_free_result($rs);	
		$tablaclientes .=GLO_fintabla(1,0,$recuento);
		echo $tablaclientes;	
	}else{echo '<p class="MuestraConf" align="center">No existen datos que cumplan esos criterios</p>';}
}
}


GLO_InitHTML($_SESSION["NivelArbol"],'TxtFechaD','BannerConMenuHV','InspeccionesSMA/zConsulta',0,0,0,0); 
GLO_tituloypath(950,700,'Inicio.php','INSPECCIONES','linksalir'); 
?>


<table width="700" border="0"   cellspacing="0" class="Tabla" >
<tr><td  height=3 width="70" ></td><td width="100"></td><td  height=3 width="130"></td><td  height=3 width="90"></td><td  height=3 width="210"></td><td  height=3 width="100"></td></tr>
<tr><td  align="right" >Fecha:</td><td>&nbsp;<? GLO_calendario("TxtFechaD","Codigo/","actual",1) ?></td><td  > al&nbsp;<? GLO_calendario("TxtFechaH","Codigo/","actual",1) ?></td><td  align="right" >Equipos:</td><td>&nbsp;<select name="CbCentro" class="campos" id="CbCentro"  style="width:170px" onKeyDown="enterxtab(event)"><option value=""></option><? GLO_ComboEquipos("CbCentro","epparticulos",$conn); ?></select></td><td  align="right"><? GLO_Search('CmdBuscar',0); ?>&nbsp;</td>
</tr>
</table>


<? 
GLO_Hidden('TxtId',0);GLO_Hidden('TxtQINSP',0);
GLO_linkbutton(700,'Agregar','InspeccionesSMA/Alta.php','Detalle','InspeccionesSMA/Detalle.php','','');
GLO_mensajeerror();
MostrarTabla($conn);
mysql_close($conn);  
GLO_cierratablaform();
include ("Codigo/FooterConUsuario.php");
?>