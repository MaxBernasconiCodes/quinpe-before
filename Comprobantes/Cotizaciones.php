<? include("../Codigo/Seguridad.php") ; $_SESSION["NivelArbol"]="../";include("../Codigo/Config.php");include("../Codigo/Funciones.php");require_once('../Codigo/calendar/classes/tc_calendar.php');
//perfiles
if ($_SESSION["IdPerfilUser"]!=1 and $_SESSION["IdPerfilUser"]!=2 and $_SESSION["IdPerfilUser"]!=3  and  $_SESSION["IdPerfilUser"]!=9 and $_SESSION["IdPerfilUser"]!=14){ header("Location:".$_SESSION["NivelArbol"]."Inicio.php");}

$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);

if (empty($_SESSION['TxtFechaD'])){
	$hoy=date("d-m-Y"); list($d,$m,$a)=explode("-",$hoy);$primerdiames="01-".$m."-".$a;$mesrestar=1;
	$_SESSION['TxtFechaD']=date("d-m-Y", strtotime("$primerdiames -$mesrestar month"));$_SESSION['TxtFechaH']=$hoy;
}

function MostrarTabla($conn){
$query=$_SESSION['TxtQCOTV'];$query=str_replace("\\", "", $query);
if ( ($query!="")){	
	$rs=mysql_query($query,$conn);
	if(mysql_num_rows($rs)!=0){	
		//Titulos de la tabla
		$tablaclientes='';
		$tablaclientes .=GLO_inittabla(990,1,0,0);
		$tablaclientes .='<td width="50" class="TableShowT TAR"> N&uacute;mero</td>';   
		$tablaclientes .="<td "."width="."70"." class="."TableShowT"."> Fecha</td>";   
		$tablaclientes .="<td "."width="."250"." class="."TableShowT"."> Cliente</td>"; 
		$tablaclientes .="<td "."width="."190"." class="."TableShowT"."> Tipo Servicio</td>"; 
		$tablaclientes .="<td "."width="."70"." class="."TableShowT"."> Presentar</td>";   
		$tablaclientes .='<td width="50" class="TableShowT TAR">Oport</td>'; 
		$tablaclientes .="<td "."width="."160"." class="."TableShowT"."> Estado</td>"; 
		$tablaclientes .="<td "."width="."30"." class="."TableShowT"."> </td>";   
		$tablaclientes .='</tr>';    
		$recuento=0;          
		$estilo=" style='cursor:pointer;' ";$clase="TableShowD";
		while($row=mysql_fetch_array($rs)){ 			
			$link=" onclick="."location='ModificarCotizacion.php?Flag1=True&id=".$row['Id']."'";
			//estado
			$colore='';
			if($row['IdEstado']==1){$colore=' TGreen';}if($row['IdEstado']==2){$colore=' TRed';}	
			if($row['IdEstado']==3){$colore=' TBlue';}	if($row['IdEstado']==4){$colore=' TOrange';}	
			//muestro
			$tablaclientes .='<tr '.$estilo.GLO_highlight($row['Id']).'>'; 
			$tablaclientes .="<td class=".$clase.$link."> ".str_pad($row['Id'], 6, "0", STR_PAD_LEFT)."</td>"; 
			$tablaclientes .="<td class=".$clase.$link."> ".FormatoFecha($row['Fecha'])."</td>"; 
			$tablaclientes .="<td class=".$clase.$link."> ".substr($row['Nombre'],0,25)."</td>";  
			$tablaclientes .="<td class=".$clase.$link."> ".substr($row['LA'],0,24)."</td>";  
			$tablaclientes .="<td class=".$clase.$link."> ".GLO_FormatoFecha($row['FechaPre'])."</td>";  
			$tablaclientes .='<td class="TableShowD TAR"'.$link."> ".GLO_SinCeroSTRPAD($row['IdOp'], 6)."</td>"; 
			$tablaclientes .='<td class="TableShowD TBold'.$colore.'"'.$link.'>'.substr($row['Estado'],0,22)."</td>";  
			$tablaclientes .="<td class="."TableShowD"." style='text-align:center;'>";  
			$tablaclientes .=GLO_rowbutton("CmdBorrarFila",$row['Id'],"Eliminar",'self','trash','iconlgray','Eliminar',1,0,0);  
			$tablaclientes .="</td>";  
			$tablaclientes .='</tr>'; 
			$recuento++;
		}	
		$tablaclientes .=GLO_fintabla(1,0,$recuento);
		echo $tablaclientes;
	}
	mysql_free_result($rs);
}
}


GLOF_Init('','BannerConMenuHV','zCotizaciones',0,'MenuH',0,0,0); 
GLO_tituloypath(0,700,'Oportunidades.php','COTIZACIONES','linksalir');
?> 

<table width="700" border="0"   cellspacing="0" class="Tabla" >
<tr> <td height="5" width="70"></td><td width="100"></td><td width="120"></td><td width="70"></td><td width="100"></td><td width="70"></td><td width="100"></td><td width="30"></td></tr>

<tr> <td height="18"  align="right">Fecha:</td><td>&nbsp;<?php  GLO_calendario("TxtFechaD","../Codigo/","actual",1); ?></td>   <td> al&nbsp;<?php  GLO_calendario("TxtFechaH","../Codigo/","actual",1); ?></td><td align="right">Tipo:</td><td>&nbsp;<select name="CbTipo"  style="width:80px" class="campos"  id="CbTipo" ><option value=""></option><? ComboTablaRFX("serviciostipo1","CbTipo","Nombre","","",$conn); ?> </select></td><td align="right">Numero:</td><td>&nbsp;<input  name="TxtNroInterno" type="text"  class="TextBox"  align="right"   value="<? echo $_SESSION['TxtNroInterno'];?>" onChange="this.value=validarEntero(this.value);" style="width:70px"></td></td><td></tr>

<tr> <td height="18"  align="right">Cliente:</td><td   colspan="2">&nbsp;<select name="CbCliente" class="campos" id="CbCliente"  style="width:200px" onKeyDown="enterxtab(event)"><option value=""></option><? GLO_ComboActivo("clientes","CbCliente","Nombre","","",$conn); ?></select></td><td  align="right">Estado:</td><td>&nbsp;<select name="CbEstado" style="width:80px" class="campos" id="CbEstado" ><option value=""></option> <? ComboTablaRFX("c_coti_estados","CbEstado","Id","","and Id<>5",$conn); ?> </select></td><td  align="right">Oportunidad:</td><td >&nbsp;<input name="TxtIdOp" type="text"  class="TextBox" style="text-align:right;width:70px" onChange="this.value=validarEntero(this.value);"  value="<? echo $_SESSION['TxtIdOp']; ?>"></td><td   align="right" ><? GLO_Search('CmdBuscar',0); ?></td></tr>
</table>





<? 
GLO_Hidden('TxtId',0);GLO_Hidden('TxtQCOTV',0);
GLO_mensajeerror(); 
MostrarTabla($conn); 
GLO_cierratablaform();
mysql_close($conn);

GLO_initcomment(0,0);
echo 'Las <font class="comentario2">Cotizaciones</font> se generan desde las <font class="comentario3">Oportunidades</font>';
GLO_endcomment();
include ("../Codigo/FooterConUsuario.php");
?>