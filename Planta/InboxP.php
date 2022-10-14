<? include("../Codigo/Seguridad.php") ;include("../Codigo/Config.php") ;include("../Codigo/Funciones.php") ;$_SESSION["NivelArbol"]="../";include("../Procesos/Includes/zFunciones.php") ;include("../Despacho/zFunciones.php");require_once('../Codigo/calendar/classes/tc_calendar.php');include("Includes/zFunciones.php") ;
//perfiles
if ($_SESSION["IdPerfilUser"]!=1 and $_SESSION["IdPerfilUser"]!=2  and $_SESSION["IdPerfilUser"]!=3  and $_SESSION["IdPerfilUser"]!=9 and $_SESSION["IdPerfilUser"]!=14 ){ header("Location:".$_SESSION["NivelArbol"]."Inicio.php");}

//En el modulo PEDIDOS de la planta es donde se validan las cargas o eventualmente se realizan los cambios en caso de haberlos, para que la BARRERA acceda a lo realmente se carga en la unidad

$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);

if (empty($_SESSION['TxtFechaD'])){
	$hoy=date("d-m-Y"); list($d,$m,$a)=explode("-",$hoy);
	$_SESSION['TxtFechaD']=date("d-m-Y", strtotime("$hoy -7 day"));
	$_SESSION['TxtFechaH']=$hoy;
}

function MostrarTabla($conn){
$query=$_SESSION['TxtQPLAIBPM'];
if (  ($query!="")){	
	$rs=mysql_query($query,$conn);
	if(mysql_num_rows($rs)!=0){	
		//contenedora
		$tablaclientes='';		
		$tablaclientes .='<table  width="1000" border="0" cellspacing="0" cellpadding="0" class="TMT5"><tr> <td  height="3" ></td></tr>';
		$tablaclientes .='<tr valign="top"> <td  align="center" valign="top" >';
		//Titulos
		$tablaclientes .='<table width="1000" border="0" cellspacing="0" cellpadding="0" ><tr>';
		$tablaclientes .="<td class="."recuento".">Acepte o rechace el Pedido de Formulado/Carga</td></td></tr><tr><td "."height="."3"."></td></tr></table>";
		//		
		$tablaclientes .='<table width="1000" class="TableShow" id="tshow"><tr>';
		$tablaclientes .='<td width="50" class="TableShowT TAR">Pedido</td>';
		$tablaclientes .="<td "."width="."70"." class="."TableShowT"."> Fecha</td>";  
		$tablaclientes .="<td "."width="."90"." class="."TableShowT"."> Cliente</td>";  
		$tablaclientes .='<td width="50" class="TableShowT TAR"> Remito</td>';
		$tablaclientes .="<td "."width="."50"." class="."TableShowT".">Solicitud</td>"; 
		$tablaclientes .="<td "."width="."150"." class="."TableShowT"."> Accion</td>"; 
		$tablaclientes .="<td "."width="."180"." class="."TableShowT"."> Camion</td>";
		$tablaclientes .="<td "."width="."180"." class="."TableShowT"."> Semi</td>";
		$tablaclientes .='<td width="90" class="TableShowT">Planta</td>';
		$tablaclientes .='<td width="90" class="TableShowT">Pedido</td>';
		$tablaclientes .='</tr>';    
		$recuento=0;          
		$estilo=" style='cursor:pointer;' ";
		while($row=mysql_fetch_array($rs)){ 
			$link=" onclick="."location='ModificarP.php?Flag1=True&id=".$row['Id']."'";	
			//
			$idestado=DES_asignar_estado($row['IdPadre'],$row['Id'],$conn);//estado pedido
			DES_Estado($idestado,$colorrow,$colorfield,$estado);//estado pedido
			DES_EstadoPlanta($row['IdEstadoP'],$colorrow2,$colorfield2,$estado2);//estado etapa planta
			//buscar dominios
			DES_Dominios($row['Id'],$conn,$domcamion,$domsemi);			
			//
			$tablaclientes .='<tr '.$estilo.GLO_highlight($row['Id']).'>';
			$tablaclientes .='<td class="TableShowD TAR"'.$link.'>'.str_pad($row['Id'], 5, "0", STR_PAD_LEFT)."</td>"; 
			$tablaclientes .='<td  class="TableShowD"'.$link.'>'.GLO_FormatoFecha($row['Fecha'])."</td>"; 
			$tablaclientes .='<td  class="TableShowD"'.$link.'>'.substr($row['Cliente'],0,10)."</td>"; 
			$tablaclientes .='<td class="TableShowD TAR"'.$link.'>'.GLO_SinCero($row['Rto'])."</td>";
			$tablaclientes .='<td class="TableShowD TAR TBold TL12"'.$link.'>'.$row['IdPadre']."</td>";
			$tablaclientes .="<td class="."TableShowD".$link."> ".substr($row['Tipo'],0,28)."</td>";  
			$tablaclientes .='<td class="TableShowD"'.$link.'>'.$domcamion."</td>";   
			$tablaclientes .='<td class="TableShowD"'.$link.'>'.$domsemi."</td>"; 
			$tablaclientes .='<td class="TableShowD TBold"'.$link.$colorrow2."> ".substr($estado2,0,20)."</td>"; 
			$tablaclientes .='<td class="TableShowD TBold"'.$link.$colorrow."> ".substr($estado,0,20)."</td>"; 
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
GLOF_Init('','BannerConMenuHV','zInboxP',0,'MenuH',0,0,0); 
GLO_tituloypath(0,700,'Inbox.php','PEDIDOS FORMULADO Y CARGA','linksalir');
?>

<table width="700" border="0"   cellspacing="0" class="Tabla" >
<tr> <td height="5" width="70"></td><td width="100"></td><td width="120"></td><td width="70"></td><td width="100"></td><td width="70"></td><td width="140"></td><td width="30"></td></tr>
<tr> <td height="18"  align="right">Fecha:</td><td>&nbsp;<?php  GLO_calendario("TxtFechaD","../Codigo/","actual",1); ?></td>    <td> al&nbsp;<?php  GLO_calendario("TxtFechaH","../Codigo/","actual",1); ?></td><td align="right">Pedido:</td><td>&nbsp;<input  name="TxtNroInterno" type="text"  class="TextBox"  align="right"   value="<? echo $_SESSION['TxtNroInterno'];?>" onChange="this.value=validarEntero(this.value);" style="width:70px"></td><td align="right">Accion:</td><td>&nbsp;<select name="CbTipo" class="campos" id="CbTipo"  style="width:120px" onKeyDown="enterxtab(event)"><option value=""></option><? ComboTablaRFX("despacho_tipo","CbTipo","Orden","","",$conn); ?></select></td><td></td></tr>

<tr> <td height="18"  align="right">Cliente:</td><td   colspan="2">&nbsp;<select name="CbCliente" class="campos" id="CbCliente"  style="width:200px" onKeyDown="enterxtab(event)"><option value=""></option><? GLO_ComboActivo("clientes","CbCliente","Nombre","","",$conn); ?></select></td><td align="right">Rto:</td><td>&nbsp;<input name="TxtRto" type="text"  class="TextBox"  maxlength="8"  value="<? echo $_SESSION['TxtRto']; ?>"  style="width:70px" onChange="this.value=validarEntero(this.value);"></td><td  align="right">Planta:</td><td >&nbsp;<select name="CbEstado" style="width:120px" class="campos" id="CbEstado" ><option value=""></option> <? DES_CbEstadoPlanta("CbEstado"); ?> </select></td><td   align="right" ><? GLO_Search('CmdBuscar',0); ?></td></tr>
</table>

<?
GLO_Hidden('TxtId',0);GLO_Hidden('TxtQPLAIBPM',0);
GLO_mensajeerror();
MostrarTabla($conn);
GLO_cierratablaform();
mysql_close($conn); 


GLO_initcomment(0,0);
echo 'Trae los <font class="comentario3">Pedidos</font> de <font class="comentario2">Formulado</font> y <font class="comentario2">Carga</font> que tienen items registrados<br>';
GLO_endcomment();

PLA_verimagenplanta();//imagen planta

include ("../Codigo/FooterConUsuario.php");
?>