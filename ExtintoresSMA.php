<? include("Codigo/Seguridad.php") ;include("Codigo/Config.php") ;include("Codigo/Funciones.php") ;$_SESSION["NivelArbol"]="";
require_once('Codigo/calendar/classes/tc_calendar.php');
//perfiles
if ($_SESSION["IdPerfilUser"]!=1 and $_SESSION["IdPerfilUser"]!=2 and $_SESSION["IdPerfilUser"]!=3 and $_SESSION["IdPerfilUser"]!=9 and $_SESSION["IdPerfilUser"]!=14 ){ header("Location:".$_SESSION["NivelArbol"]."Inicio.php");}

$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);


function MostrarTabla($conn){
$query=$_SESSION['TxtQEXTSMA'];$query=str_replace("\\", "", $query);
if (  ($query!="")){	
	$rs=mysql_query($query,$conn);
	if(mysql_num_rows($rs)!=0){	
		//Titulos de la tabla
		$tablaclientes='';
		$tablaclientes .=GLO_inittabla(900,1,0,0);
		$tablaclientes .="<td "."width="."60"." class="."TableShowT"." style='text-align:right;'> N&uacute;mero</td>";   
		$tablaclientes .="<td "."width="."140"." class="."TableShowT"."> Unidad</td>";   
		$tablaclientes .="<td "."width="."100"." class="."TableShowT"."> Ubicaci&oacute;n</td>";   
		$tablaclientes .="<td "."width="."80"." class="."TableShowT"."> Producto</td>"; 
		$tablaclientes .="<td "."width="."50"." class="."TableShowT"."  style='text-align:right;'> Capacidad</td>";  
		$tablaclientes .="<td "."width="."50"." class="."TableShowT"." > Chapa</td>"; 
		$tablaclientes .="<td "."width="."45"." class="."TableShowT"." > Mang</td>";  
		$tablaclientes .="<td "."width="."45"." class="."TableShowT"." > Coll</td>";   
		$tablaclientes .="<td "."width="."45"." class="."TableShowT"." > Prec</td>";   
		$tablaclientes .="<td "."width="."45"." class="."TableShowT"." > Ext</td>";  
		$tablaclientes .="<td "."width="."60"." class="."TableShowT"."> Vto</td>";  
		$tablaclientes .="<td "."width="."60"." class="."TableShowT"."> VtoPH</td>";  
		$tablaclientes .="<td "."width="."80"." class="."TableShowT"."> Estado</td>";  
		$tablaclientes .="<td "."width="."30"." class="."TableShowT"."> </td>";   
		$tablaclientes .='</tr>';    
		$recuento=0;          
		$estilo=" style='cursor:pointer;' ";$clase="TableShowD";
		while($row=mysql_fetch_array($rs)){ 
			$link=" onclick="."location='ExtintoresSMA/Modificar.php?Flag1=True&id=".$row['Id']."'";
			$f1 = GLO_FormatoFecha($row['Vto']);
			$f2= GLO_FormatoFecha($row['VtoPH']);
			if ((CompararFechas(FormatoFecha($row['Vto']),date("d-m-Y"))==2) and ($row['Baja']==0)){$c1=' style=";color:#FF0000"';}else{$c1='';}
			if ((CompararFechas(FormatoFecha($row['VtoPH']),date("d-m-Y"))==2) and ($row['Baja']==0)){$c2=' style=";color:#FF0000"';}else{$c2='';}
			if ($row['Baja']==0){$clase='TableShowD';}else{$clase='TableShowD TGray';}	
			//muestro
			$tablaclientes .='<tr '.$estilo.GLO_highlight($row['Id']).'>'; 
			$tablaclientes .='<td class="'.$clase.'"'.$link." style='text-align:right;'> ".$row['Nro']."</td>"; 
			$tablaclientes .='<td class="'.$clase.'"'.$link."> ".substr($row['Unidad'].' '.$row['Dominio'],0,17)."</td>"; 
			$tablaclientes .='<td class="'.$clase.'"'.$link."> ".substr($row['Ubi'],0,12)."</td>";  
			$tablaclientes .='<td class="'.$clase.'"'.$link."> ".substr($row['Prod'],0,10)."</td>"; 
			$tablaclientes .='<td class="'.$clase.'"'.$link." style='text-align:right;'> ".$row['Capacidad']."</td>"; 
			$tablaclientes .='<td class="'.$clase.'"'.$link."> ".$row['Chapa']."</td>"; 
			$tablaclientes .='<td class="'.$clase.'"'.$link."> ".$row['Manguera']."</td>"; 
			$tablaclientes .='<td class="'.$clase.'"'.$link."> ".$row['Collarin']."</td>"; 
			$tablaclientes .='<td class="'.$clase.'"'.$link."> ".$row['Precinto']."</td>"; 
			$tablaclientes .='<td class="'.$clase.'"'.$link."> ".$row['Exterior']."</td>"; 
			$tablaclientes .='<td class="'.$clase.'"'.$link.$c1."> ".$f1."</td>";  
			$tablaclientes .='<td class="'.$clase.'"'.$link.$c2."> ".$f2."</td>";  
			$tablaclientes .='<td class="'.$clase.'"'.$link."> ".substr($row['Obs'],0,10)."</td>"; 
			$tablaclientes .="<td class="."TableShowD"." style='text-align:center;'>".GLO_rowbutton("CmdBorrarFila",$row['Id'],"Eliminar",'self','trash','iconlgray','Eliminar',1,0,0). "</td>";  
			$tablaclientes .='</tr>'; 
			$recuento=$recuento+1;
		}	mysql_free_result($rs);
		$tablaclientes .=GLO_fintabla(1,0,$recuento);
		echo $tablaclientes;	
	}else{echo '<p class="MuestraConf" align="center">No existen datos que cumplan esos criterios</p>';}	
}
}


GLO_InitHTML($_SESSION["NivelArbol"],'TxtFechaV1D','BannerConMenuHV','ExtintoresSMA/zConsulta',0,0,0,0); 
GLO_tituloypath(950,700,'Inicio.php','EXTINTORES','linksalir'); 
?>


<table width="700" border="0"  cellspacing="0" class="Tabla" >
<tr><td  height=3 width="100" ></td><td width="100"></td><td  height=3 width="130"></td><td  height=3 width="100"></td><td  height=3 width="170"></td><td  height=3 width="100"></td></tr>
<tr><td  align="right" >Vto:</td><td>&nbsp;<input name="TxtFechaV1D"  id="TxtFechaV1D" type="text" class="TextBox"  style="width:65px" maxlength="10"  onchange="this.value=validarFecha(this.value);" value="<? echo $_SESSION['TxtFechaV1D']; ?>"   ><? calendario("TxtFechaV1D","Codigo/","actual") ?></td><td  > al&nbsp;<input name="TxtFechaV1H"  id="TxtFechaV1H" type="text" class="TextBox"  style="width:65px" maxlength="10"  onchange="this.value=validarFecha(this.value);" value="<? echo $_SESSION['TxtFechaV1H']; ?>"   ><? calendario("TxtFechaV1H","Codigo/","actual") ?></td><td  align="right" >Unidad:</td><td>&nbsp;<select name="CbUnidad" class="campos" id="CbUnidad"  style="width:80px" onKeyDown="enterxtab(event)"><option value=""></option><? GLO_ComboActivoUni("unidades","CbUnidad","Dominio","","",$conn); ?></select></td><td><input name="ChkActivo"  type="checkbox"  value="1" <? if ($_SESSION['ChkActivo'] =='1') echo 'checked'; ?>> Activos</td></tr>
<tr><td  align="right" >VtoPH:</td><td>&nbsp;<input name="TxtFechaV2D"  id="TxtFechaV2D" type="text" class="TextBox"  style="width:65px" maxlength="10"  onchange="this.value=validarFecha(this.value);" value="<? echo $_SESSION['TxtFechaV2D']; ?>"   ><? calendario("TxtFechaV2D","Codigo/","actual") ?></td><td  > al&nbsp;<input name="TxtFechaV2H"  id="TxtFechaV2H" type="text" class="TextBox"  style="width:65px" maxlength="10"  onchange="this.value=validarFecha(this.value);" value="<? echo $_SESSION['TxtFechaV2H']; ?>"   ><? calendario("TxtFechaV2H","Codigo/","actual") ?></td><td  align="right" >Nro.Extintor:</td><td>&nbsp;<input  name="TxtNro" type="text"  class="TextBox"  align="right"   value="<? echo $_SESSION['TxtNro'];?>" onChange="this.value=validarEntero(this.value);" style="text-align:right;width:80px"></td><td  align="right"><? GLO_Search('CmdBuscar',0); ?>&nbsp;</td>	
</tr>
</table>


<? 
GLO_Hidden('TxtId',0);GLO_Hidden('TxtQEXTSMA',0);
GLO_linkbutton(700,'Agregar','ExtintoresSMA/Alta.php','Ubicacion','ExtintoresUbi.php','','');
GLO_mensajeerror();
MostrarTabla($conn);
mysql_close($conn);
GLO_cierratablaform();

GLO_initcomment(900,0);
echo 'Muestra en <font class="comentario3">gris</font> los extintores dados de <font class="comentario2">baja</font>';
GLO_endcomment();
include ("Codigo/FooterConUsuario.php");
?>