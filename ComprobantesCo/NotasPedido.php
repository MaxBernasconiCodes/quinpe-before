<? include("../Codigo/Seguridad.php") ; $_SESSION["NivelArbol"]="../";include("../Codigo/Config.php");include("../Codigo/Funciones.php");
require_once('../Codigo/calendar/classes/tc_calendar.php');include("Includes/zFunciones.php");
//perfiles
if ($_SESSION["IdPerfilUser"]!=1 and $_SESSION["IdPerfilUser"]!=2 and $_SESSION["IdPerfilUser"]!=11 and $_SESSION["IdPerfilUser"]!=12){ header("Location:".$_SESSION["NivelArbol"]."Inicio.php");}

$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);

if (empty($_SESSION['TxtFechaDCONP'])){
	$hoy=date("d-m-Y"); list($d,$m,$a)=explode("-",$hoy);$primerdiames="01-".$m."-".$a;$mesrestar=1;
	$_SESSION['TxtFechaDCONP']=date("d-m-Y", strtotime("$primerdiames -$mesrestar month"));$_SESSION['TxtFechaHCONP']=$hoy;
}


function MostrarTabla($conn){
$query=$_SESSION['TxtQNOTAP'];$query=str_replace("\\", "", $query);
if ( ($query!="")){	
	$rs=mysql_query($query,$conn);
	if(mysql_num_rows($rs)!=0){	
		//Titulos de la tabla
		$tablaclientes='';
		$tablaclientes .=GLO_inittabla(870,1,0,0);
		$tablaclientes .="<td "."width="."60"." class="."TableShowT"." style='text-align:right;'> Pedido</td>";   
		$tablaclientes .='<td width="60" class="TableShowT"> Alta</td>';   
		$tablaclientes .="<td "."width="."380"." class="."TableShowT"."> Titulo</td>"; 
		$tablaclientes .="<td "."width="."160"." class="."TableShowT"."> Solicitante</td>"; 
		$tablaclientes .="<td "."width="."100"." class="."TableShowT"."> Sector</td>"; 
		$tablaclientes .="<td "."width="."70"." class="."TableShowT"."> Prioridad</td>"; 
		$tablaclientes .="<td "."width="."30"." class="."TableShowT"."> </td>";   
		$tablaclientes .='</tr>';    
		$recuento=0;  $estilo=" style='cursor:pointer;'";$clase="TableShowD";$_SESSION['GLO_IdLocationCONP']=0; 	      
		//Datos
		while($row=mysql_fetch_array($rs)){ 			
			$link=" onclick="."location='ModificarNotaPedido.php?Flag1=True&id=".$row['Id']."'";
			$prio=CO_VerPrioridad($row['Prioridad'],$stprio);
			//muestro
			$tablaclientes .='<tr '.$estilo.GLO_highlight($row['Id']).'>'; 
			$tablaclientes .="<td class=".$clase.$link." style='text-align:right;'> ".str_pad($row['Id'], 6, "0", STR_PAD_LEFT)."</td>"; 
			$tablaclientes .="<td class=".$clase.$link."> ".FormatoFecha($row['Fecha'])."</td>"; 
			$tablaclientes .="<td class=".$clase.$link."> ".substr($row['Titulo'],0,45)."</td>";  
			$tablaclientes .="<td class=".$clase.$link."> ".substr($row['ApeS'].' '.$row['NomS'],0,20)."</td>";  
			$tablaclientes .="<td class=".$clase.$link."> ".substr($row['Sector'],0,12)."</td>";  
			$tablaclientes .='<td class="'.$clase.$stprio.' "'.$link."> ".$prio."</td>";  
			$tablaclientes .="<td class="."TableShowD"." style='text-align:center;'>"; 
			$tablaclientes .=GLO_rowbutton("CmdBorrarFila",$row['Id'],"Eliminar",'self','trash','iconlgray','Eliminar',1,0,0);  
			$tablaclientes .="</td>";  
			$tablaclientes .='</tr>'; 
			$recuento=$recuento+1;
		}	
		$tablaclientes .=GLO_fintabla(1,0,$recuento);
		echo $tablaclientes;
	}else{echo '<p class="MuestraConf" align="center">No existen datos que cumplan esos criterios</p>';}
	mysql_free_result($rs);
}
}


GLOF_Init('','BannerConMenuHV','zNotasPedido',0,'MenuH',0,0,0);
GLO_tituloypath(0,700,"NotasPedidoD.php",'NOTA DE PEDIDO','linksalir');
?> 

<table width="700" border="0"   cellspacing="0" class="Tabla" >
<tr> <td height="5" width="70"></td><td width="100"></td><td width="130"></td><td width="90"></td><td width="150"></td><td width="60"></td><td width="100"></td></tr>
<tr> <td height="18"  align="right">Alta:</td><td>&nbsp;<? GLO_calendario("TxtFechaDCONP","../Codigo/","actual",1) ?></td>
     <td> al&nbsp;<? GLO_calendario("TxtFechaHCONP","../Codigo/","actual",1) ?></td><td align="right">Autorizante:</td><td>&nbsp;<select name="CbAuto" class="campos" id="CbAuto"  style="width:130px" onKeyDown="enterxtab(event)"><option value=""></option><? CO_PersonalAutoNP($conn); ?></select></td> <td  align="right">Pedido:</td><td >&nbsp;<input  name="TxtNroPedido" type="text"  class="TextBox"  align="right"   value="<? echo $_SESSION['TxtNroPedido'];?>" onChange="this.value=validarEntero(this.value);" style="text-align:right;width:70px"></td></tr>
<tr> <td height="18"  align="right">Sector:</td><td   colspan="2">&nbsp;<select name="CbSector" class="campos" id="CbSector"  style="width:180px" onKeyDown="enterxtab(event)"><option value=""></option><? ComboTablaRFX("sector","CbSector","Nombre","","",$conn); ?></select></td>
<td  align="right">Solicitante:</td><td  >&nbsp;<select name="CbSoli" class="campos" id="CbSoli"  style="width:130px" onKeyDown="enterxtab(event)"><option value=""></option><? CO_PersonalSoliNP($conn); ?></select></td><td  align="right" colspan="2"><? GLO_Search('CmdBuscar',0); ?>&nbsp;</td>
</tr>
</table>



<? 
GLO_Hidden('TxtId',0);GLO_Hidden('TxtQNOTAP',0);
GLO_mensajeerror(); 
MostrarTabla($conn); 
GLO_cierratablaform();
mysql_close($conn);

GLO_initcomment(870,0);
echo 'S&oacute;lo es posible <font class="comentario2">Eliminar</font> un Pedido si no tiene <font class="comentario3">Items</font>';
GLO_endcomment();

include ("../Codigo/FooterConUsuario.php");
?>