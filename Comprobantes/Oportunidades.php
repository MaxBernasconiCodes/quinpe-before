<? include("../Codigo/Seguridad.php") ; $_SESSION["NivelArbol"]="../";include("../Codigo/Config.php");include("../Codigo/Funciones.php");require_once('../Codigo/calendar/classes/tc_calendar.php');
//perfiles
if ($_SESSION["IdPerfilUser"]!=1 and $_SESSION["IdPerfilUser"]!=2 and $_SESSION["IdPerfilUser"]!=3  and  $_SESSION["IdPerfilUser"]!=9 and $_SESSION["IdPerfilUser"]!=14){ header("Location:".$_SESSION["NivelArbol"]."Inicio.php");}

$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);

if (empty($_SESSION['TxtFechaD'])){
	$hoy=date("d-m-Y"); list($d,$m,$a)=explode("-",$hoy);$primerdiames="01-".$m."-".$a;$mesrestar=1;
	$_SESSION['TxtFechaD']=date("d-m-Y", strtotime("$primerdiames -$mesrestar month"));$_SESSION['TxtFechaH']=$hoy;
}

function MostrarTabla($conn){
$query=$_SESSION['TxtQOPOV'];$query=str_replace("\\", "", $query);
if ( ($query!="")){	
	$rs=mysql_query($query,$conn);
	if(mysql_num_rows($rs)!=0){	
		//Titulos de la tabla
		$tablaclientes='';
		$tablaclientes .=GLO_inittabla(900,1,0,0);
		$tablaclientes .="<td "."width="."50"." class="."TableShowT"."> N&uacute;mero</td>";   
		$tablaclientes .="<td "."width="."70"." class="."TableShowT"."> Fecha</td>";   
		$tablaclientes .="<td "."width="."250"." class="."TableShowT"."> Cliente</td>"; 
		$tablaclientes .="<td "."width="."240"." class="."TableShowT"."> Tipo Servicio</td>"; 
		$tablaclientes .="<td "."width="."160"." class="."TableShowT"."> Estado</td>"; 
		$tablaclientes .="<td "."width="."30"." class="."TableShowT"."> </td>";   
		$tablaclientes .='</tr>';    
		$recuento=0;          
		$estilo=" style='cursor:pointer;' ";$clase="TableShowD";
		while($row=mysql_fetch_array($rs)){ 			
			$link=" onclick="."location='ModificarOportunidad.php?Flag1=True&id=".$row['Id']."'";
			//estado
			$colore='';
			if($row['IdEstado']==1){$colore=' TBlue';}//aceptada
			if($row['IdEstado']==2){$colore=' TRed';}//rech
			if($row['IdEstado']==3){$colore=' TGreen';}//cotizada
			//muestro
			$tablaclientes .='<tr '.$estilo.GLO_highlight($row['Id']).'>'; 
			$tablaclientes .="<td class=".$clase.$link."> ".str_pad($row['Id'], 6, "0", STR_PAD_LEFT)."</td>"; 
			$tablaclientes .="<td class=".$clase.$link."> ".FormatoFecha($row['Fecha'])."</td>"; 
			$tablaclientes .="<td class=".$clase.$link."> ".substr($row['Nombre'],0,25)."</td>";  
			$tablaclientes .="<td class=".$clase.$link."> ".substr($row['LA'],0,24)."</td>";  
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


GLOF_Init('','BannerConMenuHV','zOportunidades',0,'MenuH',0,0,0); 
GLO_tituloypath(0,700,'../Inicio.php','OPORTUNIDADES','linksalir');
?> 

<table width="700" border="0"   cellspacing="0" class="Tabla" >
<tr> <td height="5" width="70"></td><td width="100"></td><td width="120"></td><td width="70"></td><td width="100"></td><td width="70"></td><td width="100"></td><td width="30"></td></tr>

<tr> <td height="18"  align="right">Fecha:</td><td>&nbsp;<?php  GLO_calendario("TxtFechaD","../Codigo/","actual",1); ?></td>   <td> al&nbsp;<?php  GLO_calendario("TxtFechaH","../Codigo/","actual",1); ?></td><td align="right">Tipo:</td><td>&nbsp;<select name="CbTipo"  style="width:80px" class="campos"  id="CbTipo" ><option value=""></option><? ComboTablaRFX("serviciostipo1","CbTipo","Nombre","","",$conn); ?> </select></td><td align="right">Numero:</td><td>&nbsp;<input  name="TxtNroInterno" type="text"  class="TextBox"  align="right"   value="<? echo $_SESSION['TxtNroInterno'];?>" onChange="this.value=validarEntero(this.value);" style="width:70px"></td></td><td></tr>

<tr> <td height="18"  align="right">Cliente:</td><td   colspan="2">&nbsp;<select name="CbCliente" class="campos" id="CbCliente"  style="width:200px" onKeyDown="enterxtab(event)"><option value=""></option><? GLO_ComboActivo("clientes","CbCliente","Nombre","","",$conn); ?></select></td><td  align="right">Estado:</td><td>&nbsp;<select name="CbEstado" style="width:80px" class="campos" id="CbEstado" ><option value=""></option> <? ComboTablaRFX("c_oportunidad_est","CbEstado","Nombre","","",$conn); ?> </select></td><td  align="right"></td><td >&nbsp;</td><td   align="right" ><? GLO_Search('CmdBuscar',0); ?></td></tr>
</table>





<? 
GLO_linkbutton(700,'Agregar','AltaOportunidad.php','','','','');
GLO_Hidden('TxtId',0);GLO_Hidden('TxtQOPOV',0);
GLO_mensajeerror(); 
MostrarTabla($conn); 
GLO_cierratablaform();
mysql_close($conn);

GLO_initcomment(0,0);
echo 'Luego de dar de alta la <font class="comentario2">Oportunidad</font> podra generar la <font class="comentario3">Cotizacion</font>';
GLO_endcomment();
include ("../Codigo/FooterConUsuario.php");
?>