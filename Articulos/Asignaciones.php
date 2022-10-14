<? include("../Codigo/Seguridad.php");include("../Codigo/Config.php") ;include("../Codigo/Funciones.php") ;$_SESSION["NivelArbol"]="../";require_once('../Codigo/calendar/classes/tc_calendar.php');
//perfiles
if ($_SESSION["IdPerfilUser"]!=1 and $_SESSION["IdPerfilUser"]!=2  and $_SESSION["IdPerfilUser"]!=11 and $_SESSION["IdPerfilUser"]!=12 and $_SESSION["IdPerfilUser"]!=14){ header("Location:".$_SESSION["NivelArbol"]."Inicio.php");}

$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);

$_SESSION['TxtOriARTAsig']=1;//para que vuelva a esta pagina



function MostrarTabla($conn){
	$query=$_SESSION['TxtQuery69'];$query=str_replace("\\", "", $query);
	if (  ($query!="")){	
		$rs=mysql_query($query,$conn);
		if(mysql_num_rows($rs)!=0){	
			//Titulos de la tabla
			$tablaclientes='';
			$tablaclientes .=GLO_inittabla(1090,1,0,0);
			$tablaclientes .="<td "."width="."50"." class="."TableShowT"." style='text-align:right;'>Prestamo</td>";
			$tablaclientes .="<td "."width="."50"." class="."TableShowT"." style='text-align:right;'>Articulo</td>";  
			$tablaclientes .="<td "."width="."330"." class="."TableShowT"."> Nombre</td>";   
			$tablaclientes .="<td "."width="."130"." class="."TableShowT"."> NSE</td>";   
			$tablaclientes .="<td "."width="."160"." class="."TableShowT"." >Asignado</td>";  
			$tablaclientes .="<td "."width="."70"." class="."TableShowT"."> Desde</td>";  
			$tablaclientes .="<td "."width="."70"." class="."TableShowT"."> Hasta</td>";  
			$tablaclientes .="<td "."width="."70"." class="."TableShowT"."> Devuelto</td>";   
			$tablaclientes .="<td "."width="."100"." class="."TableShowT".">Observaciones</td>";  
			$tablaclientes .="<td "."width="."30"." class="."TableShowT"."> </td>"; 
			$tablaclientes .="<td "."width="."30"." class="."TableShowT"."> </td>"; 
			$tablaclientes .='</tr>';    
			$recuento=0;          
			$estilo=" style='cursor:pointer;' ";
			while($row=mysql_fetch_array($rs)){ 
				$link=" onclick="."location='ModificarAsignacion.php?Flag1=True&id=".$row['IdAs']."'";
				//
				include("Includes/zNombreA.php");
				//
				$fb= GLO_FormatoFecha($row['FechaH']);
				$claseti=' TBlue';if($row['TIndef']==1){$ti='Tiempo indefinido';}else{$ti='';}
				//
				if(GLO_FechaVencida(GLO_FormatoFecha($row['FechaE']))==1 and GLO_FormatoFecha($row['FechaH'])==''){$classvto=' TRed';}else{$classvto='';}
				//
				if ($fb==''){$clase="TableShowD";}else{$clase="TableShowD TGray";$claseti='';$classvto='';}
				//muestro
				$tablaclientes .='<tr '.$estilo.GLO_highlight($row['IdAs']).'>';
				$tablaclientes .='<td class="'.$clase.'"'.$link." style='text-align:right;'> ".str_pad($row['IdAs'], 6, "0", STR_PAD_LEFT)."</td>"; 
				$tablaclientes .='<td class="'.$clase.'"'.$link." style='text-align:right;'> ".str_pad($row['Id'], 6, "0", STR_PAD_LEFT)."</td>"; 
				$tablaclientes .='<td class="'.$clase.'"'.$link."> ".substr($row['Nombre'],0,40)."</td>"; 
				$tablaclientes .='<td class="'.$clase.'"'.$link."> ".substr($row['NSE'],0,25)."</td>"; 
				$tablaclientes .='<td class="'.$clase.'"'.$link."> ".substr($nomasignado,0,20)."</td>"; 
				$tablaclientes .='<td class="'.$clase.'"'.$link."> ".GLO_FormatoFecha($row['FechaD'])."</td>";  
				$tablaclientes .='<td class="'.$clase.$classvto.'"'.$link."> ".GLO_FormatoFecha($row['FechaE'])."</td>"; 
				$tablaclientes .='<td class="'.$clase.'"'.$link."> ".GLO_FormatoFecha($row['FechaH'])."</td>";  
				$tablaclientes .='<td class="'.$clase.$claseti.'"'.$link."> ".$ti."</td>"; 
				$tablaclientes .='<td class="TableShowD TAC">';
				//si no esta devuelto
				if($row['FechaH']=='0000-00-00'){
					$tablaclientes .=GLO_rowbutton("CmdDevolver",$row['IdAs'],"Devolver",'self','check','iconlgray','Devolver '.substr($row['Nombre'],0,20),1,0,0);
				} 
				$tablaclientes .='</td><td class="TableShowD TAC">'.GLO_rowbutton("CmdBorrarFila",$row['IdAs'],"Eliminar",'self','trash','iconlgray','Eliminar',1,0,0).'</td>'; 
				$tablaclientes .='</tr>'; 
				$recuento=$recuento+1;
			}mysql_free_result($rs);
			$tablaclientes .=GLO_fintabla(3,0,$recuento);
			echo $tablaclientes;	
		}else{echo '<p class="MuestraConf" align="center">No existen datos que cumplan esos criterios</p>';}
	}
}


GLOF_Init('','BannerConMenuHV','zAsignaciones',0,'MenuH',0,0,0); 
GLO_tituloypath(0,830,'../Articulos.php','EQUIPOS ASIGNADOS','linksalir'); 

?>


<table width="830" border="0"  cellspacing="0" class="Tabla" >
<tr><td  height=3 width="60" ></td><td  width="100"></td><td  width="120"></td><td width="60"></td><td width="100"></td><td width="60"></td><td width="100"></td><td width="60"></td><td   width="100"></td><td width="30"></td></tr>
<tr><td  align="right" >Asignado:</td><td>&nbsp;<? GLO_calendario("TxtFechaD","../Codigo/","actual",1) ?></td><td  >al&nbsp;<? GLO_calendario("TxtFechaH","../Codigo/","actual",1) ?></td><td  align="right" >Personal:</td><td>&nbsp;<select name="CbPersonal" class="campos" id="CbPersonal"  style="width:80px" onKeyDown="enterxtab(event)"><option value=""></option><? ComboPersonalRFX('CbPersonal',$conn); ?></select></td><td  align="right" >Unidad:</td><td>&nbsp;<select name="CbUnidad"  style="width:80px" class="campos" id="CbUnidad" ><? echo '<option value=""></option>';GLO_ComboActivoUni("unidades","CbUnidad","Dominio","","",$conn); ?> </select></td><td  align="right" >Estado:</td><td colspan="2">&nbsp;<select name="CbEstado" style="width:100px" class="campos" id="CbEstado" ><? GLO_CbEstadoASIG("CbEstado"); ?> </select></td>		</tr>

<tr><td  align="right" >Equipo:</td><td colspan="2">&nbsp;<input name="TxtBusquedaN" type="text" class="TextBox" style="width:180px" maxlength="20" onKeyDown="enterxtab(event)"></td><td  align="right" >Rubro:</td><td>&nbsp;<select name="CbInstrumento" class="campos" id="CbInstrumento"  style="width:80px" onKeyDown="enterxtab(event)"><option value=""></option><? ComboTablaRFX("rubros","CbInstrumento","Nombre","","",$conn); ?></select></td><td  align="right" >Sector:</td><td>&nbsp;<select name="CbSector"  style="width:80px" class="campos" id="CbSector" > <? echo '<option value=""></option>';ComboTablaRFX("sectorm","CbSector","Nombre","","",$conn); ?> </select></td><td  align="right" ></td><td><input name="ChkActivo"  type="checkbox"  value="1" <? if ($_SESSION['ChkActivo'] =='1') echo 'checked'; ?>> Indefinido</td><td  align="right"><? GLO_Search('CmdBuscar',0); ?>&nbsp;</td>	</tr>
</table>


<? 
GLO_Hidden('TxtId',0);GLO_Hidden('TxtQuery69',0);
GLO_linkbutton(830,'Agregar','AltaAsignacion.php','Bienes','Bienes.php','','');


GLO_mensajeerror();
MostrarTabla($conn);
GLO_cierratablaform(); 
mysql_close($conn);

GLO_initcomment(0,0);
echo 'Muestra por defecto las <font class="comentario2">Asignaciones</font> que estan <font class="comentario3">Sin Devolver</font>';
GLO_endcomment();
include ("../Codigo/FooterConUsuario.php");
?>