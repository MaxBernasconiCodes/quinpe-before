<? include("../Codigo/Seguridad.php") ;include("../Codigo/Config.php") ;include("../Codigo/Funciones.php") ;$_SESSION["NivelArbol"]="../";require_once('../Codigo/calendar/classes/tc_calendar.php');include("zFunciones.php");
//perfiles
if ($_SESSION["IdPerfilUser"]!=1 and $_SESSION["IdPerfilUser"]!=2 and $_SESSION["IdPerfilUser"]!=4 and $_SESSION["IdPerfilUser"]!=7 and $_SESSION["IdPerfilUser"]!=3  and $_SESSION["IdPerfilUser"]!=11  and $_SESSION["IdPerfilUser"]!=12  and $_SESSION["IdPerfilUser"]!=9 and $_SESSION["IdPerfilUser"]!=14 ){ header("Location:".$_SESSION["NivelArbol"]."Inicio.php");}

//completa fecha por defecto
if (empty($_SESSION['TxtFechaD'])){
	$hoy=date("d-m-Y"); list($d,$m,$a)=explode("-",$hoy);$primerdiames="01-".$m."-".$a;
	$_SESSION['TxtFechaD']=date("d-m-Y", strtotime("$primerdiames -3 month"));
	$nextmonth=date("d-m-Y", strtotime("$primerdiames +1 month")); 
	$_SESSION['TxtFechaH']=date("d-m-Y", strtotime("$nextmonth -1 day"));
}


$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);

function MostrarTabla($conn){
$query=$_SESSION['TxtQREPORDT'];
if ( $query!=""){	
	$rs=mysql_query($query,$conn);
	if(mysql_num_rows($rs)!=0){	
		$tablaclientes='';
		$tablaclientes .=GLO_inittabla(1030,0,0,0);
		$tablaclientes .="<td align="."right".">".GLO_FAButton('CmdGuardar','submit','90','self','Asignar','check','boton02')."</td>"; 
		$tablaclientes .="</tr><tr><td "."height="."3"."></td></tr></table>";
		//Titulos de la tabla
		$tablaclientes .='<table width="1030" class="TableShow" id="tshow"><tr>';
		$tablaclientes .="<td "."width="."70"." class="."TableShowT"."> Fecha T.</td>";   
		$tablaclientes .="<td "."width="."510"." class="."TableShowT".">Tarea</td>";  
		$tablaclientes .="<td "."width="."50"." class="."TableShowT"." style='text-align:right;'> Orden</td>";   
		$tablaclientes .="<td "."width="."170"." class="."TableShowT".">Unidad </td>";   
		$tablaclientes .="<td "."width="."100"." class="."TableShowT".">Sector</td>"; 
		$tablaclientes .="<td "."width="."100"." class="."TableShowT".">Equipo</td>"; 
		$tablaclientes .='<td width="30" class="TableShowT TAC"> <input type="checkbox"  name="ChkAll" unchecked onclick="CheckMasivoColor();"></td>';
		$tablaclientes .='</tr>';    
		$recuento=0; $clase="TableShowD";         
		$estilo="";$link="";
		while($row=mysql_fetch_array($rs)){ 			
			$tablaclientes .='<tr id="'.$row['Id'].'" >'; 
			$tablaclientes .="<td class=".$clase.$link."> ".GLO_FormatoFecha($row['FechaT'])."</td>"; 
			$tablaclientes .="<td class=".$clase.$link."> ".substr($row['ObsT'],0,70)."</td>"; 
			$tablaclientes .="<td class=".$clase.$link." style='text-align:right;'> ".str_pad($row['IdOrden'], 6, "0", STR_PAD_LEFT)."</td>"; 
			$tablaclientes .="<td class=".$clase.$link."> ".substr($row['Uni'].' '.$row['Dominio'],0,20)."</td>"; 
			$tablaclientes .="<td class=".$clase.$link."> ".substr($row['Sector'],0,12)."</td>"; 
			$tablaclientes .="<td class=".$clase.$link."> ".substr($row['Instr'],0,12)."</td>"; 
			$tablaclientes .='<td class="TableShowD TAC"><input type="checkbox" name="campos['.$row['Id'].']" unchecked value=0 onclick="if (this.checked==1) {this.value=1;}else{this.value=0;};" onChange="CheckRow('.$row['Id'].',this.value);"></td>';  
			$tablaclientes .='</tr>'; 
			$recuento=$recuento+1;
		}	mysql_free_result($rs);
		$tablaclientes .=GLO_fintabla(0,0,$recuento);
		echo $tablaclientes;	
	}else{echo '<p class="MuestraConf" align="center">No existen datos que cumplan esos criterios</p>';}
}
}

GLOF_Init('','BannerConMenuHV','zOrdenesT',0,'MenuH',0,0,0);
GLO_tituloypath(0,750,'Solicitudes.php','TAREAS PENDIENTES DE ASIGNAR','linksalir');
?>

<table width="750" border="0"   cellspacing="0" class="Tabla" >
<tr><td  height=3 width="60" ></td><td width="100"></td><td width="120"></td><td width="70"></td><td width="360"></td><td width="50"></td></tr>
<tr><td  align="right" >Fecha T.:</td><td>&nbsp;<input name="TxtFechaD"  id="TxtFechaD" type="text" class="TextBox"  style="width:65px" maxlength="10"  onchange="this.value=validarFecha(this.value);" value="<? echo $_SESSION['TxtFechaD']; ?>"   ><?php  calendario("TxtFechaD","../Codigo/","actual"); ?></td><td>al&nbsp;&nbsp;<input name="TxtFechaH"  id="TxtFechaH" type="text" class="TextBox"  style="width:65px" maxlength="10"  onchange="this.value=validarFecha(this.value);" value="<? echo $_SESSION['TxtFechaH']; ?>"   ><?php  calendario("TxtFechaH","../Codigo/","actual"); ?></td><td align="right">Responsables:</td><td>&nbsp;<select name="CbPersonal" style="width:80px" class="campos" ><option value=""></option><? ComboPersonalRFX("CbPersonal",$conn); ?></select> <select name="CbPersonal1" style="width:80px" class="campos" ><option value=""></option><? ComboPersonalRFX("CbPersonal1",$conn); ?></select> <select name="CbPersonal2" style="width:80px" class="campos" ><option value=""></option><? ComboPersonalRFX("CbPersonal2",$conn); ?></select> <select name="CbPersonal3" style="width:80px" class="campos" ><option value=""></option><? ComboPersonalRFX("CbPersonal3",$conn); ?></select></td><td  align="right"><? GLO_Search('CmdBuscar',0); ?>&nbsp;</td></tr>
</table>




<? 
GLO_Hidden('TxtId',0);GLO_Hidden('TxtQREPORDT',0);
GLO_mensajeerror(); 
MostrarTabla($conn);
GLO_cierratablaform();
mysql_close($conn);

GLO_initcomment(0,0);
echo 'Solo considera <font class="comentario2">Tareas</font> sin <font class="comentario3">Responsable</font> asignado';
GLO_endcomment();

include ("../Codigo/FooterConUsuario.php");
?>