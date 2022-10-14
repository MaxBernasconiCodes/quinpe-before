<? include("../Codigo/Seguridad.php") ;include("../Codigo/Config.php");include("../Codigo/Funciones.php"); $_SESSION["NivelArbol"]="../";include("Includes/zFunciones.php") ;
 
//perfiles
GLO_PerfilAcceso(14);
//get
GLO_ValidaGET($_GET['Id'],0,0);

 //si no tiene cargados responsables
if (intval($_SESSION["GLO_IdPersCON"])==0 or intval($_SESSION["GLO_IdPersAPR"])==0){header("Location:".$_SESSION["NivelArbol"]."Inicio.php");}


 function MostrarTabla(){
	include("../Codigo/Seguridad.php"); include("../Codigo/Config.php");
	$id=intval($_GET['Id']);
	$query="Select d.*,t.Nombre as Tipo,e.Nombre as Estado,s.Nombre as Sector From iso_doc d,iso_doc_tipo t,iso_doc_estados e,sector s Where t.Id=d.IdTipoDoc and e.Id=d.IdEstado and s.Id=d.IdSector and d.FlagOrig=$id Order By d.Version";
	$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);$rs=mysql_query($query,$conn);
	if(mysql_num_rows($rs)!=0){	
		//Titulos de la tabla		
		$tablaclientes='';
		$tablaclientes .=GLO_inittabla(940,1,0,0);
		$tablaclientes .="<td "."width="."50"." class="."TableShowT"."> N&uacute;mero</td>";   
		$tablaclientes .="<td "."width="."110"." class="."TableShowT"."> C&oacute;digo</td>"; 
		$tablaclientes .="<td "."width="."350"." class="."TableShowT"."> Nombre</td>"; 
		$tablaclientes .="<td "."width="."30"." class="."TableShowT"."> Vs</td>"; 
		$tablaclientes .="<td "."width="."100"." class="."TableShowT".">Tipo</td>"; 
		$tablaclientes .="<td "."width="."80"." class="."TableShowT".">Sector</td>"; 
		$tablaclientes .="<td "."width="."60"." class="."TableShowT".">Origen</td>"; 
		$tablaclientes .="<td "."width="."70"." class="."TableShowT".">Alta</td>"; 
		$tablaclientes .="<td "."width="."90"." class="."TableShowT".">Estado</td>"; 
		$tablaclientes .='</tr>';    
		$recuento=0;$link="";$estilo="";          
		while($row=mysql_fetch_array($rs)){
			$ori='';if($row['Origen']==1){$ori='Externo';}if($row['Origen']==2){$ori='Interno';}
			$colorest=ISODOC_ColorEstado($row['IdEstado']);		
			//
			$tablaclientes .='<tr '.$estilo.GLO_highlight($row['Id']).'>';   
			$tablaclientes .="<td class="."TableShowD ".$link."> ".str_pad($row['Id'], 5, "0", STR_PAD_LEFT)."</td>";  
			$tablaclientes .="<td class="."TableShowD ".$link."> ".substr($row['Codigo'],0,15)."</td>";  
			$tablaclientes .="<td class="."TableShowD ".$link."> ".substr($row['Nombre'],0,40)."</td>";  			
			$tablaclientes .="<td class="."TableShowD ".$link."> ".str_pad($row['Version'], 2, "0", STR_PAD_LEFT)."</td>";	
			$tablaclientes .="<td class="."TableShowD ".$link."> ".substr($row['Tipo'],0,12)."</td>"; 
			$tablaclientes .="<td class="."TableShowD ".$link."> ".substr($row['Sector'],0,10)."</td>"; 
			$tablaclientes .="<td class="."TableShowD ".$link."> ".$ori."</td>"; 
			$tablaclientes .="<td class="."TableShowD ".$link."> ".GLO_FormatoFecha($row['FechaCRE'])."</td>"; 
			$tablaclientes .="<td class="."TableShowD ".$link.$colorest."> ".substr($row['Estado'],0,10)."</td>"; 
			$tablaclientes .='</tr>'; 
			$recuento++;
		}mysql_free_result($rs);	
		//Cerrar tabla
		$tablaclientes .=GLO_fintabla(0,0,$recuento);
		echo $tablaclientes;	
	}
	//Cierra consulta
	mysql_close($conn);
}



GLOF_Init('','BannerPopUp','',0,'',0,0,0); 
GLO_tituloypath(0,940,'','VERSIONES','close');
MostrarTabla();
GLO_cierratablaform();
include ("../Codigo/FooterConUsuario.php");
?>
