<? include("../Codigo/Seguridad.php") ;include("../Codigo/Config.php") ;include("../Codigo/Funciones.php");  $_SESSION["NivelArbol"]="../";require_once('../Codigo/calendar/classes/tc_calendar.php');include("Includes/zFunciones.php");include("../Articulos/Includes/zFuncionesA.php");
//perfiles
GLO_PerfilAcceso(12);
//get
GLO_ValidaGET($_GET['id'],0,0);

$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);

//mostrar campos
if ($_GET['Flag1']=="True"){
	$query="SELECT * From unidades where Id<>0 and Id=".intval($_GET['id']); 
	$rs=mysql_query($query,$conn);
	while($row=mysql_fetch_array($rs)){
		$_SESSION['TxtNumero'] =str_pad($row['Id'], 6, "0", STR_PAD_LEFT);
		$_SESSION['TxtNombre'] = $row['Nombre'];
		$_SESSION['TxtFechaA'] = GLO_FormatoFecha($row['FechaAlta']);
		$_SESSION['TxtFechaB'] = GLO_FormatoFecha($row['FechaBaja']);
		$_SESSION['CbElem'] = $row['IdElemento'];
		$_SESSION['TxtAnio'] = $row['Anio'];if ($_SESSION['TxtAnio']==0){$_SESSION['TxtAnio'] ="";}
		$_SESSION['TxtDominio'] = $row['Dominio'];
		$_SESSION['CbMarca'] = $row['IdMarca'];
		$_SESSION['CbCateg'] = $row['IdCateg'];
		$_SESSION['CbCond'] = $row['IdCond'];
		$_SESSION['CbFabr'] = $row['IdFabr'];
		$_SESSION['TxtModelo'] = $row['Modelo'];
		$_SESSION['TxtChasis'] = $row['NroChasis'];
		$_SESSION['TxtMotor'] =  $row['NroMotor'];
		$_SESSION['CbProp'] = $row['Titular'];
		$_SESSION['ChkAlq'] = $row['Alquilado'];
		$_SESSION['ChkProp'] = $row['Propio'];
		$_SESSION['ChkLeas'] = $row['Leasing'];
		$_SESSION['ChkAfe'] = $row['Afectado'];
		$_SESSION['TxtFoto'] = $row['Foto'];	
		$_SESSION['TxtObs'] = $row['Obs'];
		$_SESSION['CbSector'] = $row['IdSector'];
		$_SESSION['CbServicio'] = $row['IdServicio'];
		$_SESSION['CbMarcaT'] = $row['IdMarcaTaco'];
		$_SESSION['CbRodado'] = $row['IdRodado'];
		$_SESSION['TxtKmI'] = $row['KmI'];
		$_SESSION['ChkTaco'] = $row['Taco'];
		$_SESSION['TxtTaco'] = $row['NroTaco'];
		$_SESSION['TxtCub'] = $row['Cub'];
		$_SESSION['CbPSA'] = $row['IdPSA'];
		$_SESSION['CbPST'] = $row['IdPST'];
		$_SESSION['TxtPSA'] = $row['ItPSA'];
		$_SESSION['TxtPST'] = $row['ItPST'];
		$_SESSION['CbPSRCC'] = $row['IdPSRCC'];
		$_SESSION['TxtPSRCC'] = $row['ItPSRCC'];
		$_SESSION['TxtPrecio'] = GLO_MostrarImporte($row['Precio']);
		$_SESSION['TxtPrecioR'] = GLO_MostrarImporte($row['PrecioR']);
		$_SESSION['TxtMes'] = $row['Meses'];
		$_SESSION['CbFAdq'] = $row['IdFormaA'];
		if($row['Meses']>0){$_SESSION['TxtAMes']=$row['Precio']/$row['Meses'];}else{$_SESSION['TxtAMes']=0;}	
		$_SESSION['TxtAMes'] = GLO_MostrarImporte($_SESSION['TxtAMes']);
	}mysql_free_result($rs);
} 


GLO_InitHTML($_SESSION["NivelArbol"],'','BannerConMenuHV','zModificar',0,0,0,0); 
include ("zCampos.php");
?>




<table width="730" border="0"  cellpadding="0" cellspacing="0" class="TMT5" >
<tr ><td height="18" ><i class="fa fa-truck iconsmallsp iconlgray"></i> <strong>Unidades accesorias:</strong></td></tr>
<tr> <td  align="center"><?php GLO_Ancla('A1');Uni_MostrarUniAcc($_SESSION['TxtNumero'],$conn); ?>	</td></tr>
<tr> <td height="25"></td></tr>

<!--asignaciones-->
<tr ><td height="18" ><i class="fa fa-plug iconsmallsp iconlgray"></i> <strong>Accesorios asignados:</strong></td></tr>
<tr> <td  align="center" ><?php GLO_Ancla('A2');UNI_AccesoriosAsignados(intval($_SESSION['TxtNumero']),$conn); ?>	</td></tr>
<tr> <td height="25"></td></tr> 


<!--asignaciones-->
<tr ><td height="18" ><i class="fa fa-pager iconsmallsp iconlgray"></i> <strong>Instrumentos asignados:</strong></td></tr>
<tr> <td  align="center" ><?php GLO_Ancla('A3');ASIG_MostrarAsignadosUnidad(intval($_SESSION['TxtNumero']),$conn); ?>	</td></tr>
<tr> <td height="25"></td></tr> 


<tr ><td height="18" ><i class="fa fa-id-card iconsmallsp iconlgray"></i> <strong>Habilitaciones:</strong></td></tr>
<tr> <td  align="center" ><?php GLO_Ancla('A4');Uni_MostrarVtos($_SESSION['TxtNumero'],$conn); ?>	</td></tr>
<tr> <td height="25"></td></tr>


<!--cubiertas-->
<tr ><td height="18" ><i class="fa fa-ring iconsmallsp iconlgray"></i> <strong>Cubiertas:</strong></td></tr>
<tr> <td  align="center" ><?php GLO_Ancla('A5');UNI_Cubiertas(intval($_SESSION['TxtNumero']),$conn); ?>	</td></tr>
<tr> <td height="25"></td></tr> 


<tr ><td height="18" ><i class="fa fa-comments iconsmallsp iconlgray"></i> <strong>Comentarios:</strong></td></tr>
<tr> <td  align="center"><?php GLO_Ancla('A6');Uni_MostrarComentarios($_SESSION['TxtNumero'],$conn); ?>	</td></tr>
<tr> <td height="25"></td></tr>

<tr ><td height="18" ><i class="fa fa-paperclip iconsmallsp iconlgray"></i> <strong>Archivos adjuntos:</strong></td></tr>
<tr> <td  align="center"><?php GLO_Ancla('A7');GLO_TablaArchivos($_SESSION['TxtNumero'],$conn,"unidadesarchivos","730","Adjuntos/");  ?>	</td></tr>
<tr> <td height="25"></td></tr>


<? if ($_SESSION["IdPerfilUser"]==1 or $_SESSION["IdPerfilUser"]==2){
echo '<tr ><td height="18" ><i class="fa fa-file-alt iconsmallsp iconlgray"></i> <strong>Contratos:</strong></td></tr>
<tr> <td  align="center" >'; GLO_Ancla('A8');Uni_MostrarContratos($_SESSION['TxtNumero'],$conn); echo '</td></tr>';}
?>
</table> 
                 
<? 
GLO_cierratablaform(); 
mysql_close($conn); 
include ("../Codigo/FooterConUsuario.php");
?>