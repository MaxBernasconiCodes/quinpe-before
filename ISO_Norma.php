<? include("Codigo/Seguridad.php") ;$_SESSION["NivelArbol"]="";include("Codigo/Config.php");include("Codigo/Funciones.php");
//perfiles
GLO_PerfilAcceso(14);

$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);

function MostrarTabla($conn){
	$query="SELECT c.* From iso_nc_norma c where c.Id<>0 Order by c.FechaBaja,c.Nombre";$rs=mysql_query($query,$conn);	
	if(mysql_num_rows($rs)!=0){			
		$tablaclientes='';
		$tablaclientes .=GLO_inittabla(550,1,0,0);
		$tablaclientes .="<td "."width="."440"." class="."TableShowT".">Nombre</td>";   
		$tablaclientes .="<td "."width="."80"." class="."TableShowT".">Baja</td>";   
		$tablaclientes .="<td "."width="."30"." class="."TableShowT"."> </td>"; 
		$tablaclientes .='</tr>';             
		$recuento=0; $estilo=" style='cursor:pointer;' ";
		while($row=mysql_fetch_array($rs)){ 			
			$link=" onclick="."location='ISONorma/Modificar.php?Flag1=True&id=".$row['Id']."'";
			$fbaja= GLO_FormatoFecha($row['FechaBaja']);
			if ($fbaja=='' or (strtotime(date("d-m-Y"))-strtotime($fbaja))<0){$clase="";}else{$clase=" TGray";}	
			$tablaclientes .='<tr '.$estilo.GLO_highlight($row['Id']).'>'; 
			$tablaclientes .='<td class="TableShowD'.$clase.'"'.$link."> "." ".substr($row['Nombre'],0,30)."</td>"; 
			$tablaclientes .='<td class="TableShowD'.$clase.'"'.$link."> ".$fbaja."</td>"; 
			$tablaclientes .='<td class="TableShowD TAC">'.GLO_rowbutton("CmdBorrarFila",$row['Id'],"Eliminar",'self','trash','iconlgray','Eliminar',1,0,0). "</td>";  
			$tablaclientes .='</tr>';
			$recuento=$recuento+1;
		}	
		$tablaclientes .=GLO_fintabla(0,0,$recuento);
		echo $tablaclientes;	
	}else{echo '<p class="MuestraConf" align="center">No existen datos que cumplan esos criterios</p>';}
	mysql_free_result($rs);
}


GLOF_Init('','BannerConMenuHV','ISONorma/zConsulta',0,'',0,0,0); 
GLO_tituloypath(0,550,'','NORMAS DE CALIDAD','basica');
GLO_Hidden('TxtId',0);
GLO_mensajeerror();
MostrarTabla($conn);
mysql_close($conn);
GLO_cierratablaform();
include ("Codigo/FooterConUsuario.php");
?>