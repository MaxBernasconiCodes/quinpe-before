<? include("Codigo/Seguridad.php") ;$_SESSION["NivelArbol"]="";include("Codigo/Config.php");include("Codigo/Funciones.php");
//perfiles
GLO_PerfilAcceso(14);

$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);

function MostrarTabla($conn){
$query=$_SESSION['TxtQuery31'];$query=str_replace("\\", "", $query);
if (  ($query!="")){
	$rs=mysql_query($query,$conn);
	//Titulos de la tabla
	$tablaclientes='';
	$tablaclientes .=GLO_inittabla(800,1,0,0);
	$tablaclientes .="<td "."width="."120"." class="."TableShowT".">Norma</td>";  
	$tablaclientes .="<td "."width="."80"." class="."TableShowT".">Numero</td>";   
	$tablaclientes .="<td "."width="."560"." class="."TableShowT".">Requisito</td>";   
	$tablaclientes .="<td "."width="."40"." class="."TableShowT"."> </td>"; 
	$tablaclientes .='</tr>';             
	$recuento=0;$estilo=" style='cursor:pointer;' ";
	while($row=mysql_fetch_array($rs)){ 
		$link=" onclick="."location='ISORequisitos/Modificar.php?Flag1=True&id=".$row['Id']."'";
		$fbaja= GLO_FormatoFecha($row['FechaBaja']);
		if ($fbaja=='' or (strtotime(date("d-m-Y"))-strtotime($fbaja))<0){$clase="TableShowD";}else{$clase="TableShowD TGray";}	
		
		$tablaclientes .='<tr '.$estilo.GLO_highlight($row['Id']).'>'; 
		$tablaclientes .='<td class="'.$clase.'"'.$link.">".substr($row['Norma'],0,12)."</td>"; 
		$tablaclientes .='<td class="'.$clase.'"'.$link.">".substr($row['Nro'],0,12)."</td>"; 
		$tablaclientes .='<td class="'.$clase.'"'.$link.">".substr($row['Nombre'],0,95)."</td>"; 
		$tablaclientes .="<td class="."TableShowD"." style='text-align:center;'>".GLO_rowbutton("CmdBorrarFila",$row['Id'],"Eliminar",'self','trash','iconlgray','Eliminar',1,0,0). "</td>";  
		$tablaclientes .='</tr>';
		$recuento++;
	}mysql_free_result($rs);	
	$tablaclientes .=GLO_fintabla(0,0,$recuento);
	echo $tablaclientes;	
}	
}


GLOF_Init('TxtBusqueda','BannerConMenuHV','ISORequisitos/zISO_Req',0,'',0,0,0); 
GLO_tituloypath(0,700,'ISO_Tablas.php','REQUISITOS','linksalir'); 
?> 


<table width="700" border="0"   cellspacing="0" class="Tabla" >
<tr> <td height="5" width="70"></td><td width="150"></td><td width="150"></td><td width="230"></td><td width="100"></td></tr>
<tr> 
<td height="18"  align="right">Norma:</td><td >&nbsp;<select name="CbNorma" style="width:100px" tabindex="1" class="campos" id="CbNorma" ><option value=""></option> <? GLO_ComboActivo("iso_nc_norma","CbNorma","Id","","",$conn); ?> </select></td>
<td >Nro:&nbsp;<input name="TxtNro" type="text"  class="TextBox"  maxlength="10"  value="<? echo $_SESSION['TxtNro']; ?>"  style="text-align:right;width:70px" onKeyDown="enterxtab(event)"></td><td   colspan="1">Requisito:&nbsp;<input name="TxtBusqueda" type="text" class="TextBox" style="width:130px" maxlength="100" onKeyDown="enterxtab(event)"></td><td   align="right" ><? GLO_Search('CmdBuscar',0); ?>&nbsp;</td>
</tr>
</table>


<? 
GLO_linkbutton(700,'Agregar','ISORequisitos/Alta.php','','','','');
GLO_Hidden('TxtId',0);GLO_Hidden('TxtQuery31',0);
GLO_mensajeerror(); 
MostrarTabla($conn);
GLO_cierratablaform();
mysql_close($conn);
include ("Codigo/FooterConUsuario.php");
?>