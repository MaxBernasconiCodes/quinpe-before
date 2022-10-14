<? include("../Codigo/Seguridad.php");include("../Codigo/Config.php");include("../Codigo/Funciones.php");$_SESSION["NivelArbol"]="../";include("Includes/zFunciones.php");
//perfiles
GLO_PerfilAcceso(16);

//get
GLO_ValidaGET($_GET['Id'],0,0);

$_SESSION['TxtNroEntidad'] = str_pad($_GET['Id'], 6, "0", STR_PAD_LEFT);

$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);


function MostrarTabla($idtipoe,$idpadre,$conn){
	PL_TipoEntidadM($idtipoe,$wquery,$worder,$wcampo);
	$query="Select c.Id,".$wquery." where c.Id<>0 and c.FechaBaja='0000-00-00' and c.Id NOT IN (select ".$wcampo." from programas_t where IdP=$idpadre)".$worder;
	$rs=mysql_query($query,$conn);
	if(mysql_num_rows($rs)!=0){
		$tablaclientes='';
		//guardar		
		$tablaclientes .=GLO_inittabla(500,0,0,0);
		$tablaclientes .="<td "."height="."3"."></td></tr><tr><td class="."recuento".">Seleccione el Item y luego grabe. </td><td align="."right".">".GLO_FAButton('CmdGuardar','submit','90','self','Agregar','save','boton02')."</td></tr><tr><td "."height="."3"."></td></tr></table>";
		//Titulos de la tabla
		$tablaclientes .='<table width="500" class="TableShow" id="tshow"><tr>';
		$tablaclientes .='<td width="470" class="TableShowT"> Nombre</td>';   
		$tablaclientes .='<td width="30" class="TableShowT TAC"><input type="checkbox" name="ChkAll" onclick="CheckMasivoColor();"></td>'; 
		$tablaclientes .='</tr>';             
		$recuento=0;  
		while($row=mysql_fetch_array($rs)){ 
			$tablaclientes .='<tr id="'.$row['Id'].'" >'; 
			$tablaclientes .='<td class="TableShowD">'.substr($row['Entidad'],0,50).'</td>'; 	
			$tablaclientes .='<td class="TableShowD TAC">'; 
			$tablaclientes .='<input type="checkbox" name="campos['.$row['Id'].']" unchecked value=0 onclick="if (this.checked==1) {this.value=1;}else{this.value=0;};" onChange="CheckRow('.$row['Id'].',this.value);">'; 
			$tablaclientes .='</td></tr>';
			$recuento++;
		}
		$tablaclientes .=GLO_fintabla(0,0,$recuento);
		echo $tablaclientes;	
	}mysql_free_result($rs);	
}


//tipo programa
$query="SELECT m.IdTipoE From programas m where m.Id=".intval($_GET['Id']);$rs=mysql_query($query,$conn);$row=mysql_fetch_array($rs);if(mysql_num_rows($rs)!=0){	$_SESSION['CbTipoE'] = $row['IdTipoE'];}mysql_free_result($rs);


GLO_InitHTML($_SESSION["NivelArbol"],'TxtObs2','BannerPopUp','zAltaTareaM',0,0,0,0);
GLO_tituloypath(0,500,'','PROGRAMACION','salir'); 

MostrarTabla(intval($_SESSION['CbTipoE']),intval($_SESSION['TxtNroEntidad']),$conn);
GLO_Hidden('TxtNumero',0);GLO_Hidden('TxtNroEntidad',0);GLO_Hidden('CbTipoE',0);

GLO_cierratablaform();
mysql_close($conn); 
include ("../Codigo/FooterConUsuario.php");
?>