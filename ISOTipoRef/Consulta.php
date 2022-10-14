<? include("../Codigo/Seguridad.php") ;$_SESSION["NivelArbol"]="../";include("../Codigo/Config.php");include("../Codigo/Funciones.php");

//perfiles
GLO_PerfilAcceso(16);


$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);

function MostrarTabla($conn){
	$query="SELECT c.* From iso_tiporef c where c.Id<>0 Order by c.Nombre";$rs=mysql_query($query,$conn);	
	if(mysql_num_rows($rs)!=0){			
		$tablaclientes='';
		$tablaclientes .=GLO_inittabla(700,1,0,0);
		$tablaclientes .="<td "."width="."200"." class="."TableShowT".">Nombre</td>";   
		$tablaclientes .="<td "."width="."470"." class="."TableShowT".">Detalle</td>";   
		$tablaclientes .="<td "."width="."30"." class="."TableShowT"."> </td>"; 
		$tablaclientes .='</tr>';             
		$recuento=0; $estilo=" style='cursor:pointer;' ";
		while($row=mysql_fetch_array($rs)){ 			
			$link=" onclick="."location='Modificar.php?Flag1=True&id=".$row['Id']."'";
			$tablaclientes .='<tr '.$estilo.'>';  
			$tablaclientes .='<td class="TableShowD"'.$link."> ".substr($row['Nombre'],0,24)."</td>"; 
			$tablaclientes .='<td class="TableShowD"'.$link."> ".substr($row['Obs'],0,60)."</td>"; 
			$tablaclientes .='<td class="TableShowD TAC">'.GLO_rowbutton("CmdBorrarFila",$row['Id'],"Eliminar",'self','trash','iconlgray','Eliminar',0,0,0). "</td>";  
			$tablaclientes .='</tr>';
			$recuento=$recuento+1;
		}	
		$tablaclientes .=GLO_fintabla(0,0,$recuento);
		echo $tablaclientes;	
	}else{echo '<p class="MuestraConf" align="center">No existen datos que cumplan esos criterios</p>';}
	mysql_free_result($rs);
}


GLOF_Init('','BannerConMenuHV','zConsulta',0,'',0,0,0); 
GLO_tituloypath(0,700,'','REFERENCIAS','basica');
GLO_Hidden('TxtId',0);
GLO_mensajeerror();
MostrarTabla($conn);
mysql_close($conn);
GLO_cierratablaform();
include ("../Codigo/FooterConUsuario.php");
?>