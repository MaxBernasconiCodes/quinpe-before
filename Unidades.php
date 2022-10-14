<? include("Codigo/Seguridad.php") ;include("Codigo/Config.php") ;include("Codigo/Funciones.php") ;$_SESSION["NivelArbol"]="";include("Unidades/Includes/zFunciones.php");
//perfiles
GLO_PerfilAcceso(12);

$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);

//por defecto activos
if ($_SESSION['TxtQUNI']==''){$_SESSION['ChkActivo']=1;}


function UNI_MostrarTabla($conn){
$query=$_SESSION['TxtQUNI'];
$query=str_replace("\\", "", $query);
if (  ($query!="")){	
	$rs=mysql_query($query,$conn);
	if(mysql_num_rows($rs)!=0){	
		//Titulos de la tabla
		$tablaclientes='';
		$tablaclientes .=GLO_inittabla(900,1,0,0);
		$tablaclientes .="<td "."width="."60"." class="."TableShowT"." style='text-align:right;'> N&uacute;mero</td>";  
		$tablaclientes .="<td "."width="."120"." class="."TableShowT".">Dominio </td>";   
		$tablaclientes .="<td "."width="."120"." class="."TableShowT".">Nombre </td>";   
		$tablaclientes .="<td "."width="."100"." class="."TableShowT".">Categor&iacute;a </td>";   
		$tablaclientes .="<td "."width="."60"." class="."TableShowT"."> A&ntilde;o</td>";   
		$tablaclientes .="<td "."width="."110"." class="."TableShowT"."> Servicio</td>"; 
		$tablaclientes .="<td "."width="."100"." class="."TableShowT"." > Estado</td>";  
		$tablaclientes .="<td "."width="."50"." class="."TableShowT"." > Prop.</td>";   
		$tablaclientes .="<td "."width="."50"." class="."TableShowT"." > Alq.</td>";   
		$tablaclientes .="<td "."width="."50"." class="."TableShowT"." > Leas.</td>";   
		$tablaclientes .="<td "."width="."50"." class="."TableShowT"." > Afec.</td>";   
		$tablaclientes .="<td "."width="."30"." class="."TableShowT"."></td>";   
		$tablaclientes .='</tr>';    
		$recuento=0;          
		$estilo=" style='cursor:pointer;'";
		while($row=mysql_fetch_array($rs)){ 			
			$link=" onclick="."location='Unidades/Modificar.php?Flag1=True&id=".$row['Id']."'";
			$fbaja= GLO_FormatoFecha($row['FechaBaja']);
			if ($fbaja=='' or (strtotime(date("d-m-Y"))-strtotime($fbaja))<0){$clase="TableShowD";}else{$clase="TableShowD TGray";}
			//muestro
			$tablaclientes .='<tr '.$estilo.GLO_highlight($row['Id']).'>'; 
			$tablaclientes .='<td class="'.$clase.'"'.$link." style='text-align:right;'> ".str_pad($row['Id'], 6, "0", STR_PAD_LEFT)."</td>"; 
			$tablaclientes .='<td class="'.$clase.'"'.$link."> ".substr($row['Dominio'],0,12)."</td>"; 
			$tablaclientes .='<td class="'.$clase.'"'.$link."> ".substr($row['Nombre'],0,12)."</td>"; 
			$tablaclientes .='<td class="'.$clase.'"'.$link."> ".substr($row['Categ'],0,12)."</td>"; 
			$tablaclientes .='<td class="'.$clase.'"'.$link."> ".$row['Anio']."</td>";  
			$tablaclientes .='<td class="'.$clase.'"'.$link."> ".substr($row['Servicio'],0,12)."</td>"; 
			$tablaclientes .='<td class="'.$clase.'"'.$link."> ".substr($row['Cond'],0,12)."</td>"; 
			$tablaclientes .='<td class="'.$clase.'"'.$link."> ".GLO_Si($row['Propio'])."</td>"; 
			$tablaclientes .='<td class="'.$clase.'"'.$link."> ".GLO_Si($row['Alquilado'])."</td>"; 
			$tablaclientes .='<td class="'.$clase.'"'.$link."> ".GLO_Si($row['Leasing'])."</td>"; 
			$tablaclientes .='<td class="'.$clase.'"'.$link."> ".GLO_Si($row['Afectado'])."</td>";  
			$tablaclientes .='<td  class="TableShowD TAR">';  
			$tablaclientes .=GLO_rowbutton("CmdBorrarFila",$row['Id'],"Eliminar",'self','trash','iconlgray','Eliminar',1,0,0); 
			$tablaclientes .='</td>';  
			$tablaclientes .='</tr>'; 
			$recuento=$recuento+1;
		}	
		$tablaclientes .=GLO_fintabla(1,0,$recuento);
		echo $tablaclientes;	
	}else{echo '<p class="MuestraConf" align="center">No existen datos que cumplan esos criterios</p>';}
	mysql_free_result($rs);
}
}


GLO_InitHTML($_SESSION["NivelArbol"],'TxtBusqueda','BannerConMenuHV','Unidades/zUnidades',0,0,0,0);
include("Unidades/MenuH.php");
GLO_tituloypath(0,700,'Inicio.php','UNIDADES','linksalir'); 
?>


<table width="700" border="0"  cellspacing="0" class="Tabla" >
<tr><td  height=3 width="70" ></td><td width="170"></td><td  width="60"></td><td width="120"></td><td width="90"></td><td width="90"></td><td  width="100"></td></tr>
<tr><td  align="right" >N&uacute;mero:</td><td>&nbsp;<input  name="TxtNroInterno" type="text"  class="TextBox"  align="right"   value="<? echo $_SESSION['TxtNroInterno'];?>" onChange="this.value=validarEntero(this.value);" style="width:60px"> <select name="CbNroInterno" class="campos" id="CbNroInterno"  style="width:70px" onKeyDown="enterxtab(event)"><option value=""></option><? ComboTablaRFNX('unidades','CbNroInterno','Id',0,'','',$conn); ?></select></td><td  align="right" >Dominio:</td><td>&nbsp;<input name="TxtBusqueda" type="text" class="TextBox" style="width:80px" maxlength="20" onKeyDown="enterxtab(event)"></td><td><input name="ChkProp"  type="checkbox" tabindex="11" value="1" <? if ($_SESSION['ChkProp'] =='1') echo 'checked'; ?>>Propio</td><td ><input name="ChkLeas"  type="checkbox" tabindex="11" value="1" <? if ($_SESSION['ChkLeas'] =='1') echo 'checked'; ?>>Leasing</td><td><input name="ChkActivo"  type="checkbox"  value="1" <? if ($_SESSION['ChkActivo'] =='1') echo 'checked'; ?>> Activos</td>		</tr>
<tr><td  align="right" >Categor&iacute;a:</td><td>&nbsp;<select name="CbCateg" class="campos" id="CbCateg"  style="width:130px" onKeyDown="enterxtab(event)"><option value=""></option><? ComboTablaRFX("unidadescateg","CbCateg","Nombre","","",$conn); ?></select></td><td  align="right" >Servicio:</td><td>&nbsp;<select name="CbServ" class="campos" id="CbServ"  style="width:80px" onKeyDown="enterxtab(event)"><option value=""></option><? CompletarComboServicioRFX("CbServ",$conn);  ?></select></td><td><input name="ChkAlq"  type="checkbox"  value="1" <? if ($_SESSION['ChkAlq'] =='1') echo 'checked'; ?>>Alquilado</td><td><input name="ChkAfe"  type="checkbox" tabindex="18" value="1" <? if ($_SESSION['ChkAfe'] =='1') echo 'checked'; ?>>Afectado</td><td  align="right"><? GLO_Search('CmdBuscar',0); ?>&nbsp;</td>	</tr>
</table>

<?
GLO_linkbutton(700,'Agregar','Unidades/Alta.php','','','','');
GLO_Hidden('TxtId',0);GLO_Hidden('TxtQUNI',0);GLO_Hidden('TxtQUNIEX',0);
GLO_mensajeerror(); 
UNI_MostrarTabla($conn);
GLO_cierratablaform();
mysql_close($conn);

GLO_initcomment(900,0);
echo 'Para eliminar una Unidad, primero deben borrarse sus adjuntos';
GLO_endcomment();
include ("Codigo/FooterConUsuario.php");
?>