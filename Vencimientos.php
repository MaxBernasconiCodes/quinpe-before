<? include("Codigo/Seguridad.php");include("Codigo/Config.php") ;$_SESSION["NivelArbol"]="";include("Codigo/Funciones.php");
//perfiles
GLO_PerfilAcceso(10);

$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);

function MostrarTabla($conn){
$query=$_SESSION['TxtQuery'];$query=str_replace("\\", "", $query);
if (  ($query!="")){
	$rs=mysql_query($query,$conn);
	if(mysql_num_rows($rs)!=0){	
		//cierra cont
		$tablaclientes='';
		$tablaclientes .=GLO_inittabla(880,0,0,0);
		$tablaclientes .='<td class="TablaTituloLeft"></td>';
		$tablaclientes .="<td "."width="."50"." class="."TablaTituloDato"."> Legajo</td>";   
		$tablaclientes .='<td class="TablaTituloLeft"></td>';
		$tablaclientes .="<td "."width="."120"." class="."TablaTituloDato"."> Apellido</td>";   
		$tablaclientes .='<td class="TablaTituloLeft"></td>';
		$tablaclientes .="<td "."width="."120"." class="."TablaTituloDato"."> Nombre</td>";   
		$tablaclientes .='<td class="TablaTituloLeft"></td>';
		$tablaclientes .="<td "."width="."100"." class="."TablaTituloDato"."> Servicio</td>";   
		$tablaclientes .='<td class="TablaTituloLeft"></td>';  
		$tablaclientes .="<td "."width="."270"." class="."TablaTituloDato"."> Habilitaci&oacute;n</td>"; 
		$tablaclientes .='<td class="TablaTituloLeft"></td>'; 
		$tablaclientes .="<td "."width="."70"." class="."TablaTituloDato"."> Emisi&oacute;n</td>"; 
		$tablaclientes .='<td class="TablaTituloLeft"></td>'; 
		$tablaclientes .="<td "."width="."70"." class="."TablaTituloDato"."> Vto</td>"; 
		$tablaclientes .='<td class="TablaTituloLeft"></td>';
		$tablaclientes .='<td "."width="40" class="TablaTituloDato" title="Requerido"> Req</td>';   
		$tablaclientes .='<td class="TablaTituloLeft"></td>';
		$tablaclientes .='<td "."width="40" class="TablaTituloDato" title="Inactivo"> Inac</td>';   
		$tablaclientes .='<td class="TablaTituloRight"></td>';  
		$tablaclientes .='</tr>';    
		$recuento=0;          
		$estilo="";$link="";
		while($row=mysql_fetch_array($rs)){ 
			$fvto= GLO_FormatoFecha($row['Fecha']);
			if($row['Inactivo']==0){$clase="TablaDato";}else{$clase="TablaDatoR2";}
			//muestro
			$tablaclientes .=" <tr> ";  
			$tablaclientes .='<td class="TablaMostrarLeft"></td>';  
			$tablaclientes .="<td class=".$clase." style='text-align:right;'> ".str_pad($row['Legajo'], 6, "0", STR_PAD_LEFT)."</td>"; 
			$tablaclientes .='<td class="TablaMostrarLeft"></td>';    
			$tablaclientes .="<td class=".$clase."> ".substr($row['Apellido'],0,14)."</td>"; 
			$tablaclientes .='<td class="TablaMostrarLeft"></td>';    
			$tablaclientes .="<td class=".$clase."> ".substr($row['Nombre'],0,14)."</td>"; 
			$tablaclientes .='<td class="TablaMostrarLeft"></td>';    
			$tablaclientes .="<td class=".$clase."> ".substr($row['Servicio'],0,12)."</td>"; 
			$tablaclientes .='<td class="TablaMostrarLeft"></td>';  
			$tablaclientes .="<td class=".$clase."> ".substr($row['Tipo'],0,40)."</td>";  
			$tablaclientes .='<td class="TablaMostrarLeft"></td>';  
			$tablaclientes .="<td class=".$clase."> ".GLO_FormatoFecha($row['FechaE'])."</td>";  
			$tablaclientes .='<td class="TablaMostrarLeft"></td>'; 
			if ($fvto!="" and (strtotime(date("d-m-Y"))-strtotime($fvto))>0  and ($row['Inactivo']==0))
			{$tablaclientes .="<td class="."TablaDatoRed"."> ".$fvto."</td>";}else{$tablaclientes .="<td class=".$clase."> ".$fvto."</td>";}	 
			$tablaclientes .='<td class="TablaMostrarLeft"></td>'; 	 
			$tablaclientes .="<td class=".$clase."> ".GLO_Si($row['Req'])."</td>"; 
			$tablaclientes .='<td class="TablaMostrarLeft"></td>'; 	 
			$tablaclientes .="<td class=".$clase."> ".GLO_Si($row['Inactivo'])."</td>"; 
			$tablaclientes .='<td class="TablaMostrarRight"></td>';  
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

function ComboTipoVto($campo){
$combo="";
if( "Vencidos" == $_SESSION[$campo]) { $combo .= " <option value="."'Vencidos'"." selected='selected'>"."Vencidos"."</option>\n";}else{$combo .= " <option value="."'Vencidos'"." >"."Vencidos"."</option>\n";}
if( "MesActual" == $_SESSION[$campo]) { $combo .= " <option value="."'MesActual'"." selected='selected'>"."MesActual"."</option>\n";}else{$combo .= " <option value="."'MesActual'"." >"."MesActual"."</option>\n";}
if( "MesProximo" == $_SESSION[$campo]) { $combo .= " <option value="."'MesProximo'"." selected='selected'>"."MesProximo"."</option>\n";}else{$combo .= " <option value="."'MesProximo'"." >"."MesProximo"."</option>\n";}
if( "Vigentes" == $_SESSION[$campo]) { $combo .= " <option value="."'Vigentes'"." selected='selected'>"."Vigentes"."</option>\n";}else{$combo .= " <option value="."'Vigentes'"." >"."Vigentes"."</option>\n";}
if( "Vacio" == $_SESSION[$campo]) { $combo .= " <option value="."'Vacio'"." selected='selected'>"."Vacio"."</option>\n";}else{$combo .= " <option value="."'Vacio'"." >"."Vacio"."</option>\n";}
if( "Todos" == $_SESSION[$campo]) { $combo .= " <option value="."'Todos'"." selected='selected'>"."Todos"."</option>\n";}else{$combo .= " <option value="."'Todos'"." >"."Todos"."</option>\n";}
echo $combo;
}


GLOF_Init('TxtBusqueda','BannerConMenuHV','Personal/zVencimientos',0,'Personal/MenuH',0,0,0); 
GLO_tituloypath(950,700,'Personal.php','VENCIMIENTOS HABILITACIONES','linksalir'); 
?>

<table width="700" border="0"  cellspacing="0" class="Tabla" >
<tr><td width="80"></td> <td width="200" height="5"  ></td> <td width="70"></td><td width="150"></td>  <td width="170"></td> <td width="30"></td></tr>
<tr> <td align="right">Personal:</td><td >&nbsp;<input name="TxtBusqueda" type="text" class="TextBox" style="width:170px" maxlength="20" onKeyDown="enterxtab(event)"></td><td align="right">Tipo:</td><td  >&nbsp;<select name="CbTipoV"  class="campos" id="CbTipoV" style="width:120px"><? ComboTipoVto("CbTipoV"); ?></select></td><td><input name="ChkReq"  type="checkbox"  value="1" <? if ($_SESSION['ChkReq'] =='1') echo 'checked'; ?>> Requeridos</td><td align="right"></td></tr>
<tr> <td align="right">Vencimiento:</td><td  >&nbsp;<select name="CbVto"  class="campos" id="CbVto" style="width:170px"><option value=""></option><? ComboTablaRFX("personalvtos_tipos","CbVto","Nombre","","",$conn); ?></select></td><td align="right"></td><td  ></td><td><input name="ChkInactivo"   type="checkbox"  value="1" <? if ($_SESSION['ChkInactivo'] =='1') echo 'checked'; ?>>Activos</td><td align="right"><? GLO_Search('CmdBuscar',0); ?>&nbsp;</td></tr>
</table>


<? 
GLO_Hidden('TxtQuery',0);
GLO_mensajeerror();
MostrarTabla($conn);
GLO_cierratablaform(); 
mysql_close($conn);
include ("Codigo/FooterConUsuario.php");
?>