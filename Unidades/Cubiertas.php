<? include("../Codigo/Seguridad.php");include("../Codigo/Config.php");include("../Codigo/Funciones.php");$_SESSION["NivelArbol"]="../";require_once('../Codigo/calendar/classes/tc_calendar.php');
//perfiles
GLO_PerfilAcceso(12);

$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);

if (empty($_SESSION['TxtFechaD'])){
	$hoy=date("d-m-Y"); list($d,$m,$a)=explode("-",$hoy);$primerdiames="01-".$m."-".$a;$mesrestar=1;
	$_SESSION['TxtFechaD']=date("d-m-Y", strtotime("$primerdiames -0 month"));
	$nextmonth=date("d-m-Y", strtotime("$primerdiames +1 month")); 
	$_SESSION['TxtFechaH']=date("d-m-Y", strtotime("$nextmonth -1 day"));
}


function MostrarTabla($conn){
	$query=$_SESSION['TxtQuery'];$query=str_replace("\\", "", $query);
	if (  ($query!="")){	
		$rs=mysql_query($query,$conn);
		if(mysql_num_rows($rs)!=0){	
			//Titulos de la tabla
			$tablaclientes='';
			$tablaclientes .=GLO_inittabla(1030,1,0,0);
			$tablaclientes .="<td "."width="."100"." class="."TableShowT"."> Unidad</td>";  
			$tablaclientes .="<td "."width="."100"." class="."TableShowT"."> Dominio</td>";   
			$tablaclientes .="<td "."width="."70"." class="."TableShowT".">Fecha</td>";  
			$tablaclientes .="<td "."width="."100"." class="."TableShowT"."> Marca</td>";
			$tablaclientes .='<td width="50" class="TableShowT TAR">Cantidad</td>';   
			$tablaclientes .="<td "."width="."150"." class="."TableShowT"."> Medida</td>";  
			$tablaclientes .='<td width="70" class="TableShowT TAR">Odometro</td>';  
			$tablaclientes .='<td width="100" class="TableShowT TAR">Km Recorridos</td>';  
			$tablaclientes .='<td width="70" class="TableShowT">Alineacion</td>';
			$tablaclientes .='<td width="70" class="TableShowT">Balanceo</td>';
			$tablaclientes .='<td width="150" class="TableShowT">Ubicacion reemplazo</td>';
			$tablaclientes .='</tr>';    
			$recuento=0;          
			$estilo="";$link="";$clase="TableShowD";
			while($row=mysql_fetch_array($rs)){ 			
				//muestro
				$tablaclientes .='<tr '.$estilo.GLO_highlight($row['Id']).'>'; 
				$tablaclientes .='<td class="'.$clase.'"'.$link."> ".substr($row['Nombre'],0,12)."</td>"; 
				$tablaclientes .='<td class="'.$clase.'"'.$link."> ".substr($row['Dominio'],0,12)."</td>"; 
				$tablaclientes .='<td class="'.$clase.'"'.$link."> ".GLO_FormatoFecha($row['Fecha'])."</td>";  
				$tablaclientes .='<td class="'.$clase.'"'.$link."> ".substr($row['Marca'],0,12)."</td>"; 
				$tablaclientes .='<td class="'.$clase.' TAR"'.$link."> ".$row['Cant']."</td>"; 
				$tablaclientes .='<td class="'.$clase.'"'.$link."> ".substr($row['Med'],0,18)."</td>"; 
				$tablaclientes .='<td class="'.$clase.' TAR"'.$link."> ".$row['Odo']."</td>"; 
				$tablaclientes .='<td class="'.$clase.' TAR"'.$link."> ".$row['KmR']."</td>"; 
				$tablaclientes .='<td class="'.$clase.'"'.$link."> ".GLO_Si($row['Ali'])."</td>"; 
				$tablaclientes .='<td class="'.$clase.'"'.$link."> ".GLO_Si($row['Bal'])."</td>"; 
				$tablaclientes .='<td class="'.$clase.'"'.$link."> ".substr($row['UbiR'],0,18)."</td>"; 
				$tablaclientes .='</tr>'; 
				$recuento++;
			}	
			$tablaclientes .=GLO_fintabla(1,0,$recuento);
			echo $tablaclientes;	
		}else{echo '<p class="MuestraConf" align="center">No existen datos que cumplan esos criterios</p>';}
		mysql_free_result($rs);
	}
}


GLOF_Init('','BannerConMenuHV','zCubiertas',0,'MenuH',0,0,0); 
GLO_tituloypath(0,700,'../Unidades.php','CUBIERTAS','linksalir'); 
?>



<table width="700" border="0"   cellspacing="0" class="Tabla" >
<tr><td  height=3 width="80" ></td><td  width="100"></td><td  width="120"></td><td width="70"></td><td width="120"></td><td width="60"></td><td   width="120"></td><td width="30"></td></tr>

<tr><td  align="right" >Fecha:</td><td>&nbsp;<? GLO_calendario("TxtFechaD","../Codigo/","actual",1) ?></td><td  >al&nbsp;<? GLO_calendario("TxtFechaH","../Codigo/","actual",1) ?></td><td  align="right" ></td><td><input name="ChkI1"  type="checkbox"  value="1" <? if ($_SESSION['ChkI1'] =='1') echo 'checked'; ?>> Sin Alineacion</td><td align="right" >Marca:</td><td colspan="2">&nbsp;<select name="CbMarca" style="width:100px" class="campos" id="CbMarca" ><option value=""></option> <? ComboTablaRFX("unidades_marcascub","CbMarca","Nombre","","",$conn); ?> </select></td></tr>

<tr><td  align="right" >Unidad:</td><td colspan="2">&nbsp;<select name="CbUnidad" class="campos" id="CbUnidad"  style="width:70px" onKeyDown="enterxtab(event)"><option value=""></option><? GLO_ComboActivo("unidades","CbUnidad","Nombre","","",$conn); ?></select>&nbsp;&nbsp;Dominio:&nbsp;<input name="TxtBusqueda" type="text" class="TextBox" style="width:70px" maxlength="6" onKeyDown="enterxtab(event)"></td><td  align="right" ></td><td><input name="ChkI2"  type="checkbox"  value="1" <? if ($_SESSION['ChkI2'] =='1') echo 'checked'; ?>> Sin Balanceo</td><td></td><td></td><td  align="right"><? GLO_Search('CmdBuscar',0); ?>&nbsp;</td></tr>
</table>

<? 
GLO_mensajeerror();
GLO_Hidden('TxtQuery',0);
MostrarTabla($conn);
GLO_cierratablaform(); 
mysql_close($conn);
include ("../Codigo/FooterConUsuario.php");
?>