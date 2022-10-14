<? include("../Codigo/Seguridad.php");include("../Codigo/Config.php");include("../Codigo/Funciones.php");$_SESSION["NivelArbol"]="../";
require_once('../Codigo/calendar/classes/tc_calendar.php');include("../Procesos/Includes/zFunciones.php");include("Includes/zFunciones.php") ;
//perfiles
GLO_PerfilAcceso(13);

$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);

if (empty($_SESSION['TxtFechaD'])){
	$hoy=date("d-m-Y"); list($d,$m,$a)=explode("-",$hoy);$primerdiames="01-".$m."-".$a;$mesrestar=1;
	$_SESSION['TxtFechaD']=date("d-m-Y", strtotime("$primerdiames -0 month"));
	$nextmonth=date("d-m-Y", strtotime("$primerdiames +1 month")); 
	$_SESSION['TxtFechaH']=date("d-m-Y", strtotime("$nextmonth -1 day"));
}


function MostrarTabla($conn){
$query=$_SESSION['TxtQPROCBARIT'];$query=str_replace("\\", "", $query);
if (  ($query!="")){	
	$rs=mysql_query($query,$conn);
	if(mysql_num_rows($rs)!=0){	
		//Titulos de la tabla
		$tablaclientes='';
		$tablaclientes .=GLO_inittabla(750,1,0,0);
		$tablaclientes .='<td width="70" class="TableShowT" >Fecha</td>';  
		$tablaclientes .='<td width="50" class="TableShowT" > Hora</td>';   
		$tablaclientes .='<td width="100" class="TableShowT" > Cliente Solicitud</td>'; 
		$tablaclientes .='<td width="370" class="TableShowT" > Producto</td>'; 
		$tablaclientes .='<td width="50" class="TableShowT TAR">Solicitud</td>';
		$tablaclientes .='<td width="60" class="TableShowT"> Etapa</td>';
		$tablaclientes .='<td width="50" class="TableShowT"> </td>';
		$tablaclientes .='</tr>';    
		$recuento=0; $_SESSION['TxtOriProcIt']=1;//para que vuelva          
		while($row=mysql_fetch_array($rs)){
			GLO_LinkRowTablaInit($estilo,$link,$row['IdIte1'],0); //pasa id item
			if($row['Etapa']==0){$colore=' TBlue';$etapa='INGRESO';}else{$colore=' TGreen';$etapa='EGRESO';}
			//
			if($row['Retorno']==0){$ret='';}else{$ret='Retorno';}
			//			
			$tablaclientes .='<tr '.$estilo.GLO_highlight($row['IdIte1']).'>';
			$tablaclientes .="<td class="."TableShowD".$link."> ".GLO_FormatoFecha($row['Fecha'])."</td>"; 
			$tablaclientes .="<td class="."TableShowD".$link."> ".GLO_FormatoHora($row['Hora'])."</td>"; 
			$tablaclientes .="<td class="."TableShowD".$link."> ".substr($row['Cliente'],0,12)."</td>"; 
			$tablaclientes .="<td class="."TableShowD".$link."> ".substr($row['Item'],0,45)."</td>"; 
			$tablaclientes .='<td class="TableShowD TAR TBold TL12"'.$link.'>'.$row['IdPadre']."</td>"; 
			$tablaclientes .='<td  class="TableShowD'.$colore.'"'.$link.'>'.$etapa."</td>"; 
			$tablaclientes .='<td  class="TableShowD TRed"'.$link.'>'.$ret."</td>"; 
			$tablaclientes .='</tr>'; 
			$recuento=$recuento+1;
		}	
		$tablaclientes .=GLO_fintabla(0,0,$recuento);
		echo $tablaclientes;	
	}else{echo '<p class="MuestraConf" align="center">No existen datos que cumplan esos criterios</p>';}
	mysql_free_result($rs);
}
}


//html
GLOF_Init('TxtFechaD','BannerConMenuHV','zItems',0,'MenuH',0,0,0); 
GLO_tituloypath(0,600,'Consulta.php','PRODUCTOS BARRERA','linksalir');
?>

<table width="600" border="0" cellspacing="0" class="Tabla" >
<tr> <td height="3" width="110"></td><td width="100"></td><td width="130"></td><td width="90"></td><td width="100"></td><td width="20"></td><td width="70"></td></tr>
<tr> <td height="18" align="right">Fecha:</td><td >&nbsp;<?php  GLO_calendario("TxtFechaD","../Codigo/","actual",2); ?></td><td> al&nbsp;<?php  GLO_calendario("TxtFechaH","../Codigo/","actual",2); ?></td><td align="right">Remito:</td><td>&nbsp;<input name="TxtNro" type="text"  class="TextBox"  maxlength="8"  value="<? echo $_SESSION['TxtNro']; ?>"    style="text-align:right;width:80px" onChange="this.value=validarEntero(this.value);"></td><td align="right"></td><td>&nbsp;</td></tr>
<tr> <td height="18" align="right">Cliente Solicitud:</td><td  colspan="2">&nbsp;<select name="CbCliente" class="campos" id="CbCliente"  style="width:170px" onKeyDown="enterxtab(event)"><option value=""></option><? GLO_ComboActivo("clientes","CbCliente","Nombre","","",$conn); ?></select></td><td align="right">Etapa:</td><td>&nbsp;<select name="CbEtapa" class="campos" id="CbEtapa"  style="width:80px"  tabindex="2" onKeyDown="enterxtab(event)"><? echo PROC_CbTipoEtapa('CbEtapa',0);?></select></td><td></td><td  align="right"><? GLO_Search('CmdBuscar',0); ?></td></tr>
</table>


<? 
GLO_Hidden('TxtId',0);GLO_Hidden('TxtQPROCBARIT',0);
GLO_mensajeerror();
MostrarTabla($conn);
GLO_cierratablaform();
mysql_close($conn); 

GLO_initcomment(0,0);
echo 'Muestra todos los <font class="comentario2">Productos</font> de los <font class="comentario3">Ingresos</font> y <font class="comentario3">Egresos</font> registrados<br>';
GLO_endcomment();
include ("../Codigo/FooterConUsuario.php");
?>