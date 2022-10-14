<? include("../Codigo/Seguridad.php") ;include("../Codigo/Config.php") ;include("../Codigo/Funciones.php") ;$_SESSION["NivelArbol"]="../";require_once('../Codigo/calendar/classes/tc_calendar.php');
//perfiles
if ($_SESSION["IdPerfilUser"]!=1 and $_SESSION["IdPerfilUser"]!=2  and $_SESSION["IdPerfilUser"]!=11 and $_SESSION["IdPerfilUser"]!=12 and $_SESSION["IdPerfilUser"]!=14){ header("Location:".$_SESSION["NivelArbol"]."Inicio.php");}
$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);

$_SESSION['TxtOriACCCertif']=1;//para que vuelva a esta pagina


//completa fecha por defecto
if (empty($_SESSION['TxtFechaD'])){
	$hoy=date("d-m-Y"); list($d,$m,$a)=explode("-",$hoy);$primerdiames="01-".$m."-".$a;$mesrestar=1;
	$_SESSION['TxtFechaD']=date("d-m-Y", strtotime("$primerdiames -0 month"));
	$nextmonth=date("d-m-Y", strtotime("$primerdiames +1 month")); 
	$_SESSION['TxtFechaH']=date("d-m-Y", strtotime("$nextmonth -1 day"));
}
function MostrarTabla($conn){
$query=$_SESSION['TxtQuery47'];$query=str_replace("\\", "", $query);
if (  ($query!="")){
	$rs=mysql_query($query,$conn);
	if(mysql_num_rows($rs)!=0){	
		//contenedora
		$tablaclientes='';
		$tablaclientes .=GLO_inittabla(900,1,0,0);
		$tablaclientes .="<td "."width="."80"." class="."TableShowT"."> Fecha</td>"; 
		$tablaclientes .="<td "."width="."280"." class="."TableShowT"."> Equipo</td>";   
		$tablaclientes .="<td "."width="."130"." class="."TableShowT"."> NSE</td>";   
		$tablaclientes .="<td "."width="."130"." class="."TableShowT"."> Certificaci&oacute;n</td>";   
		$tablaclientes .="<td "."width="."150"." class="."TableShowT".">Certificado </td>";  
		$tablaclientes .="<td "."width="."80"." class="."TableShowT"."> Vencimiento</td>"; 
		$tablaclientes .="<td "."width="."40"." class="."TableShowT"."> </td>";   
		$tablaclientes .='</tr>';    
		$recuento=0;
		$estilo=" style='cursor:pointer;' ";   
		while($row=mysql_fetch_array($rs)){
			$link=" onclick="."location='ModificarCE.php?Flag1=True&id=".$row['Id']."'";
			$fechar =GLO_FormatoFecha($row['FechaReal']);
			if ($row['Inactivo']==0){$clase="TableShowD";}else{$clase="TableShowD TGray";}
			$tablaclientes .='<tr '.$estilo.GLO_highlight($row['Id']).'>'; 
			$tablaclientes .='<td class="'.$clase.'"'.$link."> ".GLO_FormatoFecha($row['FechaProg'])."</td>";  
			$tablaclientes .='<td class="'.$clase.'"'.$link."> ".substr($row['Nombre'],0,34)."</td>"; 
			$tablaclientes .='<td class="'.$clase.'"'.$link."> ".substr($row['NSE'],0,25)."</td>"; 
			$tablaclientes .='<td class="'.$clase.'"'.$link."> ".substr($row['TipoC'],0,14)."</td>";  
			$tablaclientes .='<td class="'.$clase.'"'.$link."> ".substr($row['Certificado'],0,16)."</td>"; 
			if ($fechar!="" and (strtotime(date("d-m-Y"))-strtotime($fechar))>0 and $row['Inactivo']==0)
			{$tablaclientes .='<td class="TableShowD TRed"'.$link."> ".$fechar."</td>";}
			else{$tablaclientes .='<td class="'.$clase.'"'.$link."> ".$fechar."</td>";}	 
			$tablaclientes .="<td class="."TableShowD"." style='text-align:center;'>".GLO_rowbutton("CmdBorrarFila",$row['Id'],"Eliminar",'self','trash','iconlgray','Eliminar',0,0,0)."</td>";  
			$tablaclientes .='</tr>'; 
			$recuento=$recuento+1;
		}mysql_free_result($rs);	
		$tablaclientes .=GLO_fintabla(1,0,$recuento);
		$tablaclientes .='</td></tr></table>';
		echo $tablaclientes;	
	}else{echo '<p class="MuestraConf" align="center">No existen datos que cumplan esos criterios</p>';}
}
}


function ComboEstadoCursosP(){//prog:1,cumpl:2
$combo="";
if( "2" == $_SESSION['CbEstadoCP']) { $combo .= " <option value="."'2'"." selected='selected'>"."CUMPL"."</option>\n";}else{$combo .= " <option value="."'2'"." >"."CUMPL"."</option>\n";}
if( "1" == $_SESSION['CbEstadoCP']) { $combo .= " <option value="."'1'"." selected='selected'>"."PROG"."</option>\n";}else{$combo .= " <option value="."'1'"." >"."PROG"."</option>\n";}
echo $combo;
}

GLOF_Init('','BannerConMenuHV','zCertificaciones',0,'MenuH',0,0,0); 
GLO_tituloypath(0,710,'../Articulos.php','CERTIFICACIONES EQUIPOS','linksalir');
?>

<table width="710" border="0"  cellspacing="0" class="Tabla" >
<tr> <td height="5" width="80"></td><td width="100"></td><td width="130"></td><td width="80"></td><td width="100"></td><td width="50"></td><td width="100"></td><td width="50"></td></tr>
<tr> <td height="18"  align="right">&nbsp;Fecha:</td><td  >&nbsp;<? GLO_calendario("TxtFechaD","../Codigo/","actual",1) ?></td><td  > al&nbsp;<? GLO_calendario("TxtFechaH","../Codigo/","actual",1) ?></td><td align="right">Equipo:</td><td  >&nbsp;<select name="CbInstrumento" class="campos" id="CbInstrumento"  style="width:80px" onKeyDown="enterxtab(event)"><option value=""></option><? GLO_ComboEquipos("CbInstrumento","epparticulos",$conn); ?></select></td><td align="right">Certif:</td><td colspan="2">&nbsp;<select name="CbCertif" class="campos" id="CbCertif"  style="width:80px" onKeyDown="enterxtab(event)"><option value=""></option><? ComboTablaRFX("instrumentostipocertif","CbCertif","Nombre","","",$conn); ?></select></td></tr>
<tr> <td height="18"  align="right">Vencimiento:</td><td  >&nbsp;<input name="TxtFechaDCP"  id="TxtFechaDCP" type="text" class="TextBox"  style="width:65px" maxlength="10"  onchange="this.value=validarFecha(this.value);" value="<? echo $_SESSION['TxtFechaDCP']; ?>"   ><? calendario("TxtFechaDCP","../Codigo/","actual") ?></td><td  > al&nbsp;<input name="TxtFechaHCP"  id="TxtFechaHCP" type="text" class="TextBox"  style="width:65px" maxlength="10"  onchange="this.value=validarFecha(this.value);" value="<? echo $_SESSION['TxtFechaHCP']; ?>"   ><? calendario("TxtFechaHCP","../Codigo/","actual") ?></td><td  align="right">Rubro:</td><td>&nbsp;<select name="CbTInstrumento" class="campos" id="CbTInstrumento"  style="width:80px" onKeyDown="enterxtab(event)"><option value=""></option><? ComboTablaRFX("rubros","CbTInstrumento","Nombre","","",$conn); ?></select></td><td></td><td><input name="ChkVtoCP"  type="checkbox"  value="1" <? if ($_SESSION['ChkVtoCP'] =='1') echo 'checked'; ?>>Vencidos</td><td   align="right" ><? GLO_Search('CmdBuscar',0); ?>&nbsp;</td></tr>
</table>

<? 
GLO_Hidden('TxtId',0);GLO_Hidden('TxtQuery47',0);
GLO_linkbutton(710,'Agregar','AltaCE.php','','','','');

GLO_mensajeerror();
MostrarTabla($conn);

GLO_cierratablaform();
mysql_close($conn);

GLO_initcomment(0,0);
echo 'Considera solo las habilitaciones activas';
GLO_endcomment();
?>		
<? include ("../Codigo/FooterConUsuario.php");?>