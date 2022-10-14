<? include("Codigo/Seguridad.php") ;$_SESSION["NivelArbol"]="";include("Codigo/Config.php");include("Codigo/Funciones.php");require_once('Codigo/calendar/classes/tc_calendar.php');
//perfiles
GLO_PerfilAcceso(15);


$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);

//completa fecha por defecto
if (empty($_SESSION['TxtFechaD'])){
	$hoy=date("d-m-Y"); list($d,$m,$a)=explode("-",$hoy);$primerdiames="01-".$m."-".$a;$mesrestar=1;
	$_SESSION['TxtFechaD']=date("d-m-Y", strtotime("$primerdiames -0 month"));
	$nextmonth=date("d-m-Y", strtotime("$primerdiames +1 month")); 
	$_SESSION['TxtFechaH']=date("d-m-Y", strtotime("$nextmonth -1 day"));
}

function MostrarTabla($conn){
$query=$_SESSION['TxtQuery65'];$query=str_replace("\\", "", $query);
if (  ($query!="")){
	$rs=mysql_query($query,$conn);
	if(mysql_num_rows($rs)!=0){	
		//Titulos de la tabla		
		$tablaclientes='';
		$tablaclientes .=GLO_inittabla(900,1,0,0);
		$tablaclientes .="<td "."width="."50"." class="."TableShowT"." style='text-align:right;'> N&uacute;mero</td>";   
		$tablaclientes .="<td "."width="."60"." class="."TableShowT"."> Fecha</td>"; 
		$tablaclientes .="<td "."width="."90"." class="."TableShowT"."> Alcance</td>";		
		$tablaclientes .="<td "."width="."110"." class="."TableShowT"."> Req.Legal</td>"; 
		$tablaclientes .="<td "."width="."170"." class="."TableShowT"."> Identificaci&oacute;n</td>";   
		$tablaclientes .="<td "."width="."90"." class="."TableShowT"."> Periodicidad</td>"; 
		$tablaclientes .="<td "."width="."60"." class="."TableShowT".">F.Vto</td>"; 
		$tablaclientes .="<td "."width="."130"." class="."TableShowT".">Responsable </td>";   
		$tablaclientes .="<td "."width="."50"." class="."TableShowT".">Eval.</td>";   
		$tablaclientes .="<td "."width="."60"." class="."TableShowT".">F.Eval</td>";  
		$tablaclientes .="<td "."width="."30"." class="."TableShowT"."> </td>";   
		$tablaclientes .='</tr>';    
		$recuento=0; $estilo=" style='cursor:pointer;' ";         
		while($row=mysql_fetch_array($rs)){
			$colorestado='';$cumpl='';
			$link=" onclick="."location='ISOMLegal/Modificar.php?Flag1=True&id=".$row['Id']."'";
			if ($row['Eval']==1) {$cumpl='SI';$colorestado=' style="font-weight:bold;color:#4CAF50"';}// VERDE 	
			if ($row['Eval']==2) {$cumpl='NO';$colorestado=' style="font-weight:bold;color:#f44336"';}//ROJO
			if ($row['Eval']==3) {$cumpl='N/A';}
			//fecha
			if($row['FVto']!='0000-00-00'){$fechav =FormatoFecha($row['FVto']);}else{$fechav='';}
			if($row['FEval']!='0000-00-00'){$fechae =FormatoFecha( $row['FEval']);}else{$fechae='';}
		
			$id=$row['Id'];
			$tablaclientes .='<tr '.$estilo.GLO_highlight($row['Id']).'>'; 
			$tablaclientes .="<td class="."TableShowD ".$link." style='text-align:right;'> ".str_pad($row['Id'], 6, "0", STR_PAD_LEFT)."</td>"; 
			$tablaclientes .="<td class="."TableShowD ".$link."> ".FormatoFecha($row['Fecha'])."</td>";  
			$tablaclientes .="<td class="."TableShowD ".$link."> ".substr($row['Alcance'],0,12)."</td>";  
			$tablaclientes .="<td class="."TableShowD ".$link."> ".substr($row['Req'],0,14)."</td>";  
			$tablaclientes .="<td class="."TableShowD ".$link."> ".substr($row['Ident'],0,20)."</td>";  
			$tablaclientes .="<td class="."TableShowD ".$link."> ".substr($row['Per'],0,14)."</td>";  
			$tablaclientes .="<td class="."TableShowD ".$link."> ".$fechav."</td>";  
			$tablaclientes .="<td class="."TableShowD ".$link."> ".substr($row['Resp'],0,15)."</td>"; 
			$tablaclientes .="<td class="."TableShowD ".$link.$colorestado."> ".$cumpl."</td>"; 
			$tablaclientes .="<td class="."TableShowD ".$link."> ".$fechae."</td>"; 
			$tablaclientes .="<td class="."TableShowD"." style='text-align:center;'>";  
			$tablaclientes .=GLO_rowbutton("CmdBorrarFila",$row['Id'],"Eliminar",'self','trash','iconlgray','Eliminar',1,0,0);  
			$tablaclientes .="</td>";  
			$tablaclientes .='</tr>'; 
			$recuento=$recuento+1;
		}	
		$tablaclientes .=GLO_fintabla(1,0,$recuento);
		echo $tablaclientes;	
	}else{echo '<p class="MuestraConf" align="center">No existen datos que cumplan esos criterios</p>';}
	//Cierra consulta
	mysql_free_result($rs);
	
}
}






function ComboEstadoAuditoria(){
$combo="";
if( "1" == $_SESSION['CbEstado']) { $combo .= " <option value="."'1'"." selected='selected'>"."SI"."</option>\n";}else{$combo .= " <option value="."'1'"." >"."SI"."</option>\n";}
if( "2" == $_SESSION['CbEstado']) { $combo .= " <option value="."'2'"." selected='selected'>"."NO"."</option>\n";}else{$combo .= " <option value="."'2'"." >"."NO"."</option>\n";}
if( "3" == $_SESSION['CbEstado']) { $combo .= " <option value="."'3'"." selected='selected'>"."N/A"."</option>\n";}else{$combo .= " <option value="."'3'"." >"."N/A"."</option>\n";}
echo $combo;
}


GLOF_Init('','BannerConMenuHV','ISOMLegal/zISO_MLegal',0,'',0,0,0); 
GLO_tituloypath(0,700,'Inicio.php','MATRIZ DE REQUISITOS LEGALES','linksalir');
?>



<table width="700" border="0" cellspacing="0" class="Tabla" >
<tr> <td height="5" width="80"></td><td width="100"></td><td width="160"></td><td width="90"></td><td width="230"></td><td width="30"></td></tr>
<tr> <td height="18"  align="right">Fecha Carga:</td><td  >&nbsp;<?php  GLO_calendario("TxtFechaD","Codigo/","actual",1); ?></td><td  > al&nbsp;
<?php  GLO_calendario("TxtFechaH","Codigo/","actual",1); ?></td><td height="18" align="right">Alcance:</td><td   colspan="2">&nbsp;<select name="CbTipo" class="campos" id="CbTipo"  style="width:180px" onKeyDown="enterxtab(event)"><option value=""></option><? ComboTablaRFX("iso_matriz_a","CbTipo","Nombre","","",$conn); ?></select></td></tr>
<tr><td height="18"  align="right">Fecha Vto:</td><td  >&nbsp;<?php  GLO_calendario("TxtFechaD2","Codigo/","actual",1); ?></td><td  > al&nbsp;
<?php  GLO_calendario("TxtFechaH2","Codigo/","actual",1); ?></td><td  align="right">Per&iacute;odo:</td><td >&nbsp;<select name="CbPer" style="width:180px" class="campos" id="CbPer" ><option value=""></option><? ComboTablaRFX("iso_matriz_p","CbPer","Nombre","","",$conn); ?> </select></td><td   align="right" ></td></tr>
<tr><td height="18"  align="right">Fecha Eval:</td><td  >&nbsp;<?php  GLO_calendario("TxtFechaD3","Codigo/","actual",1); ?></td><td  > al&nbsp;<?php  GLO_calendario("TxtFechaH3","Codigo/","actual",1); ?></td><td  align="right">Evaluaci&oacute;n:</td><td >&nbsp;<select name="CbEstado" class="campos" id="CbEstado"  style="width:100px" onKeyDown="enterxtab(event)"><option value=""></option><? ComboEstadoAuditoria(); ?></select></td><td   align="right" ><? GLO_Search('CmdBuscar',0); ?>&nbsp;</td></tr>
</table>


<? 
GLO_Hidden('TxtId',0);GLO_Hidden('TxtQuery65',0);
GLO_linkbutton(700,'Agregar','ISOMLegal/Alta.php','','','','');
GLO_mensajeerror();
MostrarTabla($conn);
GLO_cierratablaform();
mysql_close($conn);
include ("Codigo/FooterConUsuario.php");
?>