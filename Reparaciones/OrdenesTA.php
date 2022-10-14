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
$query=$_SESSION['TxtQREPORDTA'];
if ( $query!=""){	
	$rs=mysql_query($query,$conn);
	if(mysql_num_rows($rs)!=0){	
		$tablaclientes='';
		$tablaclientes .=GLO_inittabla(1030,1,0,0);
		$tablaclientes .="<td "."width="."70"." class="."TableShowT"."> Fecha T.</td>";   
		$tablaclientes .="<td "."width="."350"." class="."TableShowT".">Tarea</td>";  
		$tablaclientes .="<td "."width="."50"." class="."TableShowT"." style='text-align:right;'> Orden</td>";   
		$tablaclientes .="<td "."width="."80"." class="."TableShowT".">Unidad </td>";   
		$tablaclientes .="<td "."width="."80"." class="."TableShowT".">Sector</td>"; 
		$tablaclientes .="<td "."width="."80"." class="."TableShowT".">Equipo</td>"; 
		$tablaclientes .="<td "."width="."80"." class="."TableShowT".">Responsable</td>"; 
		$tablaclientes .="<td "."width="."80"." class="."TableShowT".">Responsable</td>"; 
		$tablaclientes .="<td "."width="."80"." class="."TableShowT".">Responsable</td>"; 
		$tablaclientes .="<td "."width="."80"." class="."TableShowT".">Responsable</td>"; 
		$tablaclientes .='</tr>';    
		$recuento=0; $clase="TableShowD";         
		$estilo="";$link="";
		while($row=mysql_fetch_array($rs)){ 			
			$tablaclientes .='<tr '.$estilo.GLO_highlight($row['Id']).'>';
			$tablaclientes .="<td class=".$clase.$link."> ".GLO_FormatoFecha($row['FechaT'])."</td>"; 
			$tablaclientes .="<td class=".$clase.$link."> ".substr($row['ObsT'],0,50)."</td>"; 
			$tablaclientes .="<td class=".$clase.$link." style='text-align:right;'> ".str_pad($row['IdOrden'], 6, "0", STR_PAD_LEFT)."</td>"; 
			$tablaclientes .="<td class=".$clase.$link."> ".substr($row['Uni'].' '.$row['Dominio'],0,10)."</td>"; 
			$tablaclientes .="<td class=".$clase.$link."> ".substr($row['Sector'],0,10)."</td>"; 
			$tablaclientes .="<td class=".$clase.$link."> ".substr($row['Instr'],0,10)."</td>"; 
			$tablaclientes .="<td class=".$clase.$link."> ".substr($row['Ap'],0,10)."</td>"; 
			$tablaclientes .="<td class=".$clase.$link."> ".substr($row['Ap1'],0,10)."</td>"; 
			$tablaclientes .="<td class=".$clase.$link."> ".substr($row['Ap2'],0,10)."</td>"; 
			$tablaclientes .="<td class=".$clase.$link."> ".substr($row['Ap3'],0,10)."</td>"; 
			$tablaclientes .='</tr>'; 
			$recuento=$recuento+1;
		}	mysql_free_result($rs);
		$tablaclientes .=GLO_fintabla(3,0,$recuento);
		echo $tablaclientes;	
	}else{echo '<p class="MuestraConf" align="center">No existen datos que cumplan esos criterios</p>';}
}
}

GLOF_Init('','BannerConMenuHV','zOrdenesTA',0,'MenuH',0,0,0);
GLO_tituloypath(0,700,'Solicitudes.php','TAREAS ASIGNADAS','linksalir');
?>

<table width="700" border="0"   cellspacing="0" class="Tabla" >
<tr><td  height=3 width="60" ></td><td width="100"></td><td width="120"></td><td width="70"></td><td width="310"></td><td width="50"></td></tr>
<tr><td  align="right" >Fecha T.:</td><td>&nbsp;<input name="TxtFechaD"  id="TxtFechaD" type="text" class="TextBox"  style="width:65px" maxlength="10"  onchange="this.value=validarFecha(this.value);" value="<? echo $_SESSION['TxtFechaD']; ?>"   ><?php  calendario("TxtFechaD","../Codigo/","actual"); ?></td><td>al&nbsp;&nbsp;<input name="TxtFechaH"  id="TxtFechaH" type="text" class="TextBox"  style="width:65px" maxlength="10"  onchange="this.value=validarFecha(this.value);" value="<? echo $_SESSION['TxtFechaH']; ?>"   ><?php  calendario("TxtFechaH","../Codigo/","actual"); ?></td><td align="right">Responsables:</td><td>&nbsp;<select name="CbPersonal" style="width:250px" class="campos" ><option value=""></option><? ComboPersonalRFX("CbPersonal",$conn); ?></select></td><td  align="right"><? GLO_Search('CmdBuscar',0); ?>&nbsp;</td></tr>
</table>




<? 
GLO_Hidden('TxtId',0);GLO_Hidden('TxtQREPORDTA',0);
GLO_mensajeerror(); 
MostrarTabla($conn);
GLO_cierratablaform();
mysql_close($conn);

GLO_initcomment(0,0);
echo 'Solo considera <font class="comentario2">Tareas</font> con <font class="comentario3">Responsable</font> asignado';
GLO_endcomment();

include ("../Codigo/FooterConUsuario.php");
?>