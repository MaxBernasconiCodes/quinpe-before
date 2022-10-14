<? include("Codigo/Seguridad.php") ;include("Codigo/Config.php") ;$_SESSION["NivelArbol"]="";include("Codigo/Funciones.php");
//perfiles
if ($_SESSION["IdPerfilUser"]!=1 and $_SESSION["IdPerfilUser"]!=2 and $_SESSION["IdPerfilUser"]!=4 and $_SESSION["IdPerfilUser"]!=7 and $_SESSION["IdPerfilUser"]!=9 and $_SESSION["IdPerfilUser"]!=14 and $_SESSION["IdPerfilUser"]!=13){ header("Location:".$_SESSION["NivelArbol"]."Inicio.php");}

$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);

function MostrarTabla($conn){
$query=$_SESSION['TxtQuery'];$query=str_replace("\\", "", $query);
if (  ($query!="")){
	$rs=mysql_query($query,$conn);
	if(mysql_num_rows($rs)!=0){	
		//cierra cont
		$tablaclientes='';
		$tablaclientes .=GLO_inittabla(750,0,0,0);
		$tablaclientes .='<td class="TablaTituloLeft"></td>';
		$tablaclientes .="<td "."width="."60"." class="."TablaTituloDato"." style='text-align:right;'> N&uacute;mero</td>";   
		$tablaclientes .='<td class="TablaTituloLeft"></td>';
		$tablaclientes .="<td "."width="."130"." class="."TablaTituloDato"."> Nombre</td>";  
		$tablaclientes .='<td class="TablaTituloLeft"></td>';
		$tablaclientes .="<td "."width="."100"." class="."TablaTituloDato"."> Dominio</td>";  
		$tablaclientes .='<td class="TablaTituloLeft"></td>';  
		$tablaclientes .="<td "."width="."270"." class="."TablaTituloDato"."> Habilitaci&oacute;n</td>"; 
		$tablaclientes .='<td class="TablaTituloLeft"></td>'; 
		$tablaclientes .="<td "."width="."70"." class="."TablaTituloDato"."> Emisi&oacute;n</td>"; 
		$tablaclientes .='<td class="TablaTituloLeft"></td>'; 
		$tablaclientes .="<td "."width="."70"." class="."TablaTituloDato"."> Vto</td>"; 
		$tablaclientes .='<td class="TablaTituloLeft"></td>'; 
		$tablaclientes .="<td "."width="."50"." class="."TablaTituloDato"."> Req</td>"; 
		$tablaclientes .='<td class="TablaTituloRight"></td>';  
		$tablaclientes .='</tr>';    
		$recuento=0;          
		$estilo="";$link="";
		while($row=mysql_fetch_array($rs)){ 			
			$femi= GLO_FormatoFecha($row['FechaE']);
			$fvto= GLO_FormatoFecha($row['Fecha']);
			if($row['Req']==0){$req='No';} else{$req='Si';}
			if ($row['Inactivo']==0){$clase="TablaDato";}else{$clase="TablaDatoR2";}
			//muestro
			$tablaclientes .='<tr '.$estilo.'>';  
			$tablaclientes .='<td class="TablaMostrarLeft"></td>';  
			$tablaclientes .="<td class=".$clase.$link." style='text-align:right;'> ".str_pad($row['Id'], 6, "0", STR_PAD_LEFT)."</td>"; 
			$tablaclientes .='<td class="TablaMostrarLeft"></td>';    
			$tablaclientes .="<td class=".$clase.$link."> ".substr($row['Nombre'],0,12)."</td>"; 
			$tablaclientes .='<td class="TablaMostrarLeft"></td>';    
			$tablaclientes .="<td class=".$clase.$link."> ".substr($row['Dominio'],0,12)."</td>"; 
			$tablaclientes .='<td class="TablaMostrarLeft"></td>';  
			$tablaclientes .="<td class=".$clase.$link."> ".substr($row['Tipo'],0,40)."</td>";  
			$tablaclientes .='<td class="TablaMostrarLeft"></td>';  
			$tablaclientes .="<td class=".$clase."> ".$femi."</td>";  
			$tablaclientes .='<td class="TablaMostrarLeft"></td>'; 
			if ($fvto!="" and (strtotime(date("d-m-Y"))-strtotime($fvto))>0 and $row['Inactivo']==0)
			{$tablaclientes .="<td class="."TablaDatoRed"."> ".$fvto."</td>";}else{$tablaclientes .="<td class=".$clase."> ".$fvto."</td>";}	 
			$tablaclientes .='<td class="TablaMostrarLeft"></td>';  
			$tablaclientes .="<td class=".$clase."> ".$req."</td>";  
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


GLOF_Init('','BannerConMenuHV','Unidades/zVencimientos',0,'Unidades/MenuH',0,0,0); 
GLO_tituloypath(0,700,'Unidades.php','VENCIMIENTOS HABILITACIONES','linksalir'); 

?>



<table width="700" border="0"  cellspacing="0" class="Tabla" >
<tr><td width="300" height="5"  ></td> <td width="150"></td><td width="150"></td> <td width="100"></td></tr>
<tr> <td  >&nbsp;Vencimiento:&nbsp;<select name="CbVto"  class="campos" id="CbVto" style="width:200px"><option value=""></option><? ComboTablaRFX("unidadesvtos_tipos","CbVto","Nombre","","",$conn); ?><option value="999">P&oacute;lizas</option></select></td><td  >&nbsp;Tipo:&nbsp;<select name="CbTipoV"  class="campos" id="CbTipoV" style="width:100px"><? ComboTipoVto("CbTipoV"); ?></select></td><td><input name="ChkReq"  type="checkbox"  value="1" <? if ($_SESSION['ChkReq'] =='1') echo 'checked'; ?>> Requeridos</td>  <td   align="right"><? GLO_Search('CmdBuscar',0); ?>
    &nbsp;</td>
</tr>
</table>



<? 
GLO_Hidden('TxtQuery',0);
GLO_mensajeerror();
MostrarTabla($conn);
GLO_cierratablaform(); 
mysql_close($conn);
include ("Codigo/FooterConUsuario.php");
?>