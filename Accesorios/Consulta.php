<? include("../Codigo/Seguridad.php") ;include("../Codigo/Config.php") ;include("../Codigo/Funciones.php") ;
$_SESSION["NivelArbol"]="../";
//perfiles
GLO_PerfilAcceso(12);

$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);


function MostrarTabla($conn){
	$query=$_SESSION['TxtQACC'];$query=str_replace("\\", "", $query);
	if (  ($query!="")){	
		$rs=mysql_query($query,$conn);
		if(mysql_num_rows($rs)!=0){	
			//contenedora
			$tablaclientes='';
			$tablaclientes .=GLO_inittabla(1000,1,0,0);
			$tablaclientes .="<td "."width="."50"." class="."TableShowT"." style='text-align:right;'> N&uacute;mero</td>";  
			$tablaclientes .="<td "."width="."200"." class="."TableShowT"."> Elemento</td>";   
			$tablaclientes .="<td "."width="."320"." class="."TableShowT"." > Modelo</td>";  
			$tablaclientes .="<td "."width="."100"." class="."TableShowT"." > Serie</td>"; 
			$tablaclientes .="<td "."width="."100"." class="."TableShowT"."> Nombre</td>"; 
			$tablaclientes .="<td "."width="."100"." class="."TableShowT"." >Lote</td>";   
			$tablaclientes .="<td "."width="."90"." class="."TableShowT"." >Ubicacion</td>";   
			$tablaclientes .="<td "."width="."70"." class="."TableShowT".">Vto</td>";  
			$tablaclientes .="<td "."width="."30"." class="."TableShowT"."> </td>";   
			$tablaclientes .='</tr>';    
			$recuento=0;          
			$estilo=" style='cursor:pointer;' ";
			while($row=mysql_fetch_array($rs)){ 			
				$link=" onclick="."location='Modificar.php?Flag1=True&id=".$row['Id']."'";
				if (GLO_FormatoFecha($row['FechaBaja'])==''){$clase="TableShowD";}else{$clase="TableShowD TGray";}		
				//ubicacion
				$idpadre=$row['Id'];
				$query="SELECT u.Nombre as Unidad From accesorios_asig ia,unidades u where ia.IdUnidad=u.id and ia.Id<>0 and ia.FechaH='0000-00-00' and ia.IdInstrumento=$idpadre Order by ia.FechaD Desc";$rs2=mysql_query($query,$conn);
				$row2=mysql_fetch_array($rs2);if(mysql_num_rows($rs2)!=0){$ubi=substr($row2['Unidad'],0,12);}else{$ubi="";}mysql_free_result($rs2);
				//vto
				$query="SELECT pp.FechaReal From accesorios_prog pp  where pp.Id<>0 and pp.FechaReal<>'0000-00-00' and pp.IdInstrumento=$idpadre Order by pp.FechaReal";
				$rs2=mysql_query($query,$conn);
				$row2=mysql_fetch_array($rs2);if(mysql_num_rows($rs2)!=0){$fechar=GLO_FormatoFecha($row2['FechaReal']);}else{$fechar="";}
				mysql_free_result($rs2);
				//muestro
				$tablaclientes .='<tr '.$estilo.GLO_highlight($row['Id']).'>';  
				$tablaclientes .='<td class="'.$clase.'"'.$link." style='text-align:right;'> ".str_pad($row['Id'], 6, "0", STR_PAD_LEFT)."</td>"; 
				$tablaclientes .='<td class="'.$clase.'"'.$link."> ".substr($row['Elem'],0,24)."</td>"; 
				$tablaclientes .='<td class="'.$clase.'"'.$link."> ".substr($row['Modelo'],0,40)."</td>"; 
				$tablaclientes .='<td class="'.$clase.'"'.$link."> ".substr($row['NSE'],0,12)."</td>"; 
				$tablaclientes .='<td class="'.$clase.'"'.$link."> ".substr($row['Nombre'],0,12)."</td>"; 
				$tablaclientes .='<td class="'.$clase.'"'.$link."> ".substr($row['Lote'],0,12)."</td>";
				$tablaclientes .='<td class="'.$clase.' TBlue"'.$link."> ".$ubi."</td>";  
				if ($fechar!="" and (strtotime(date("d-m-Y"))-strtotime($fechar))>0)
				{$tablaclientes .='<td class="TableShowD TRed"'.$link."> ".$fechar."</td>";}else{$tablaclientes .='<td class="'.$clase.'"'.$link."> ".$fechar."</td>";}	
				$tablaclientes .="<td class="."TableShowD"." style='text-align:center;'>".GLO_rowbutton("CmdBorrarFila",$row['Id'],"Eliminar",'self','trash','iconlgray','Eliminar',1,0,0)."</td>";  
				$tablaclientes .='</tr>'; 
				$recuento=$recuento+1;
			}mysql_free_result($rs);	
			$tablaclientes .=GLO_fintabla(1,0,$recuento);
			echo $tablaclientes;	
		}else{echo '<p class="MuestraConf" align="center">No existen datos que cumplan esos criterios</p>';}	
	}
}


GLOF_Init('','BannerConMenuHV','zConsulta',0,'MenuH',0,0,0); 
GLO_tituloypath(0,700,'../Inicio.php','ACCESORIOS','linksalir'); 

?>


<table width="700" border="0"   cellspacing="0" class="Tabla" >
<tr><td  height=3 width="90" ></td><td  height=3 width="210"></td><td  height=3 width="90"></td><td  height=3 width="210"></td><td  height=3 width="100"></td></tr>
<tr><td  align="right" >Nombre:</td><td>&nbsp;<input name="TxtBusquedaN" type="text" class="TextBox" style="width:170px" maxlength="20" onKeyDown="enterxtab(event)"></td><td  align="right" >Elemento:</td><td>&nbsp<select name="CbInstrumento" class="campos" id="CbInstrumento"  style="width:170px" onKeyDown="enterxtab(event)"><option value=""></option><? ComboTablaRFX("accesorios_tipo","CbInstrumento","Nombre","","",$conn); ?></select></td><td  align="right"><? GLO_Search('CmdBuscar',0); ?></td>		</tr>
</table>


<? 
GLO_Hidden('TxtId',0);GLO_Hidden('TxtQACC',0);
GLO_linkbutton(700,'Agregar','Alta.php','','','','');
GLO_mensajeerror();
MostrarTabla($conn);
GLO_cierratablaform();
mysql_close($conn);

GLO_initcomment(0,0);
echo 'Para <font class="comentario3">eliminarlo</font> no debe tener adjuntos ni foto asociados';
GLO_endcomment();

include ("../Codigo/FooterConUsuario.php");
?>