<? include("Codigo/Seguridad.php") ;include("Codigo/Config.php") ;include("Codigo/Funciones.php") ;$_SESSION["NivelArbol"]="";
require_once('Codigo/calendar/classes/tc_calendar.php');include("CAM/Includes/zFunciones.php");
//perfiles
if ($_SESSION["IdPerfilUser"]!=1 and $_SESSION["IdPerfilUser"]!=2  and $_SESSION["IdPerfilUser"]!=3  and $_SESSION["IdPerfilUser"]!=9 and $_SESSION["IdPerfilUser"]!=14){ header("Location:".$_SESSION["NivelArbol"]."Inicio.php");}

$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);

if (empty($_SESSION['TxtFechaD'])){
	$hoy=date("d-m-Y"); list($d,$m,$a)=explode("-",$hoy);$primerdiames="01-".$m."-".$a;$mesrestar=1;
	$_SESSION['TxtFechaD']=date("d-m-Y", strtotime("$primerdiames -0 month"));
	$nextmonth=date("d-m-Y", strtotime("$primerdiames +1 month")); 
	$_SESSION['TxtFechaH']=date("d-m-Y", strtotime("$nextmonth -1 day"));
}

function CAM_MostrarTabla($conn){
$query=$_SESSION['TxtQCAM'];$query=str_replace("\\", "", $query);
if (  ($query!="")){	
	$rs=mysql_query($query,$conn);
	if(mysql_num_rows($rs)!=0){	
		//Titulos de la tabla
		$tablaclientes='';
		$tablaclientes .=GLO_inittabla(950,1,0,0);
		$tablaclientes .='<td width="50" class="TableShowT TAR"> Numero</td>';
		$tablaclientes .="<td "."width="."70"." class="."TableShowT"."> Fecha</td>";   
		$tablaclientes .="<td "."width="."250"." class="."TableShowT"."> Producto</td>"; 
		$tablaclientes .="<td "."width="."150"." class="."TableShowT"."> Cliente</td>"; 
		$tablaclientes .="<td "."width="."100"." class="."TableShowT".">Lote</td>"; 
		$tablaclientes .="<td "."width="."100"." class="."TableShowT".">Remito</td>"; 
		$tablaclientes .="<td "."width="."70"." class="."TableShowT"."> Vence</td>"; 
		$tablaclientes .="<td "."width="."80"." class="."TableShowT"."> Origen</td>"; 
		$tablaclientes .="<td "."width="."100"." class="."TableShowT"."> Estado</td>"; 
		$tablaclientes .="<td "."width="."30"." class="."TableShowT"."></td>";   
		$tablaclientes .='</tr>';    
		$recuento=0;          
		$clase="TableShowD";$_SESSION['TxtOriOPELab']=0; //para ver a donde vuelve   
		while($row=mysql_fetch_array($rs)){ 			
			GLO_LinkRowTablaInit($estilo,$link,$row['Id'],0);
			if($row['IdPE1IT']!=0){$origen='INGRESO';}
			if($row['IdPE2IT']!=0){$origen='FORMULADO';}	
			//muestro
			$tablaclientes .='<tr '.$estilo.GLO_highlight($row['Id']).'>';
			$tablaclientes .='<td class="TableShowD TAR"'.$link.'>'.str_pad($row['Id'], 5, "0", STR_PAD_LEFT)."</td>"; 
			$tablaclientes .="<td class=".$clase.$link."> ".GLO_FormatoFecha($row['Fecha'])."</td>"; 
			$tablaclientes .="<td class=".$clase.$link."> ".substr($row['Producto'],0,30)."</td>"; 
			$tablaclientes .="<td class=".$clase.$link."> ".substr($row['Cliente'],0,18)."</td>"; 
			$tablaclientes .="<td class=".$clase.$link."> ".substr($row['Lote'],0,15)."</td>";  	
			$tablaclientes .="<td class=".$clase.$link."> ".substr($row['Rto'],0,15)."</td>";  		
			$tablaclientes .="<td class=".$clase.$link."> ".GLO_FormatoFecha($row['FechaV'])."</td>";
			$tablaclientes .='<td  class="TableShowD'.'"'.$link.'>'.substr($origen,0,10)."</td>"; 
			$tablaclientes .="<td class=".$clase.$link.' style="font-weight:bold;'.CAM_colorestado($row['IdE']).'"'."> ".substr($row['Est'],0,12)."</td>";  
			$tablaclientes .="<td class="."TableShowD"." style='text-align:center;'>";
			if($row['IdE']==1){
				$tablaclientes .=GLO_rowbutton("CmdBorrarFila",$row['Id'],"Eliminar",'self','trash','iconlgray','Eliminar '.substr($row['Nombre'],0,20),1,0,0); 
			} 
			$tablaclientes .='</td></tr>'; 
			$recuento=$recuento+1;
		}	
		$tablaclientes .=GLO_fintabla(0,0,$recuento);
		echo $tablaclientes;	
	}else{echo '<p class="MuestraConf" align="center">No existen datos que cumplan esos criterios</p>';}
	mysql_free_result($rs);
}
}


//html
GLOF_Init('TxtFechaD','BannerConMenuHV','CAM/zConsulta',0,'CAM/MenuH',0,0,0); 
GLO_tituloypath(0,780,'CAM/Inbox.php','CERTIFICADO ANALISIS','linksalir');
?>


<table width="780" border="0" cellspacing="0" class="Tabla" >
<tr> <td height="3" width="70"></td><td width="100"></td><td width="130"></td><td width="70"></td><td width="130"></td><td width="80"></td><td width="70"></td><td width="130"></td></tr>
<tr> <td height="18" align="right">&nbsp;Fecha:</td><td >&nbsp;<?php  GLO_calendario("TxtFechaD","Codigo/","actual",2); ?></td><td> al&nbsp;<?php  GLO_calendario("TxtFechaH","Codigo/","actual",2); ?></td><td height="18" align="right">Producto:</td><td>&nbsp;<select name="CbProducto" class="campos" id="CbProducto"  style="width:110px" onKeyDown="enterxtab(event)"><option value=""></option><? ComboTablaRFX("items","CbProducto","Nombre","","and Tipo=0",$conn); ?></select></td><td height="18" align="right">Nro.Remito:</td><td>&nbsp;<input name="TxtNro" type="text"  class="TextBox"  maxlength="8"  value="<? echo $_SESSION['TxtNro']; ?>"    style="text-align:right;width:50px" onChange="this.value=validarEntero(this.value);"></td><td>Nro.Analisis:&nbsp;<input  name="TxtNroInterno" type="text"  class="TextBox"  align="right"   value="<? echo $_SESSION['TxtNroInterno'];?>" onChange="this.value=validarEntero(this.value);" style="text-align:right;width:50px"></td></tr>

<tr> <td height="18" align="right">Cliente:</td><td  colspan="2">&nbsp;<select name="CbCliente" class="campos" id="CbCliente"  style="width:180px" onKeyDown="enterxtab(event)"><option value=""></option><? GLO_ComboActivo("clientes","CbCliente","Nombre","","",$conn); ?></select></td><td height="18" align="right">Estado:</td><td>&nbsp;<select name="CbEstado"  tabindex="1"  class="campos" id="CbEstado"  style="width:110px" onKeyDown="enterxtab(event)"><option value=""></option><? ComboTablaRFX("cam_est","CbEstado","Nombre","","",$conn); ?></select></td><td height="18" align="right">Lote:</td><td >&nbsp;<input name="TxtLote" type="text"  class="TextBox"  maxlength="13"  value="<? echo $_SESSION['TxtLote']; ?>" style="width:50px"></td><td  align="right"><? GLO_Search('CmdBuscar',0); ?>&nbsp;</td></tr>

</table>


<? 
GLO_Hidden('TxtId',0);GLO_Hidden('TxtQCAM',0);
GLO_linkbutton(780,'Agregar','CAM/Alta.php','','','','');
GLO_mensajeerror();
CAM_MostrarTabla($conn);
GLO_cierratablaform();
mysql_close($conn); 

GLO_initcomment(0,0);
echo 'Solo pueden eliminarse los COA con estado <font class="comentario2">En Proceso</font>';
GLO_endcomment();

include ("Codigo/FooterConUsuario.php");
?>