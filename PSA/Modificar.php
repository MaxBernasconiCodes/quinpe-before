<? include("../Codigo/Seguridad.php") ;include("../Codigo/Config.php") ;include("../Codigo/Funciones.php"); $_SESSION["NivelArbol"]="../";require_once('../Codigo/calendar/classes/tc_calendar.php');

//perfiles

if ($_SESSION["IdPerfilUser"]!=1 and $_SESSION["IdPerfilUser"]!=2 and $_SESSION["IdPerfilUser"]!=4 and $_SESSION["IdPerfilUser"]!=7 and $_SESSION["IdPerfilUser"]!=3  and $_SESSION["IdPerfilUser"]!=11  and $_SESSION["IdPerfilUser"]!=12  and $_SESSION["IdPerfilUser"]!=9 and $_SESSION["IdPerfilUser"]!=14 and $_SESSION["IdPerfilUser"]!=13){ header("Location:".$_SESSION["NivelArbol"]."Inicio.php");}



$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);



//mostrar campos

if ($_GET['Flag1']=="True"){	

	$query="SELECT * From polizassegauto where Id<>0 and Id=".intval($_GET['id']); 

	$rs=mysql_query($query,$conn);

	while($row=mysql_fetch_array($rs)){

		$_SESSION['TxtNumero'] = str_pad($row['Id'], 6, "0", STR_PAD_LEFT);

		$_SESSION['TxtNro']= str_pad($row['Nro'], 6, "0", STR_PAD_LEFT);

		$_SESSION['CbTipo']=$row['IdTipo'];

		$_SESSION['CbAseg']=  $row['IdAseg'];

		$_SESSION['TxtFechaA'] = GLO_FormatoFecha($row['FechaI']);

		$_SESSION['TxtFechaB'] = GLO_FormatoFecha($row['FechaF']);

	}

	mysql_free_result($rs);

}







function MostrarTablaComentarios($idpadre,$conn){

$query="SELECT * From polizas_com where IdEntidad=$idpadre Order by Id";$rs=mysql_query($query,$conn);

//Titulos de la tabla

$tablaclientes='';

$tablaclientes .="<table width="."600"." border="."0"." cellspacing="."0"." cellpadding="."0"." ><tr>";

$tablaclientes .='<td class="TablaTituloLeft"></td>';

$tablaclientes .="<td "."width="."160"." class="."TablaTituloDato"."> Usuario</td>";   

$tablaclientes .='<td class="TablaTituloLeft"></td>'; 

$tablaclientes .="<td "."width="."400"." class="."TablaTituloDato"."> Comentario</td>";  

$tablaclientes .='<td class="TablaTituloLeft"></td>'; 

$tablaclientes .="<td width="."40"." class="."TablaTituloDatoR".">".GLO_FAButton('CmdAddC','submit','','self','Agregar','add','iconbtn')." </td>"; 

$tablaclientes .='<td class="TablaTituloRight"></td>';  

$tablaclientes .='</tr>';             

$estilo=" style='cursor:pointer;' ";

while($row=mysql_fetch_array($rs)){

	//busco nombre comentario

	$query= "Select p.Nombre,p.Apellido From personal p,usuarios u Where p.Id=u.IdPersonal and u.Usuario='".$row['IdUsuario']."'";

	$rs2=mysql_query($query,$conn);$row2=mysql_fetch_array($rs2);

	if(mysql_num_rows($rs2)!=0){$creadox=substr($row2['Apellido'].' '.$row2['Nombre'],0,11);} else{$creadox='';}

	mysql_free_result($rs2);

	$link=" onclick="."location='ModificarComentario.php?Flag1=True"."&id=".$row['Id']."&identidad=".$idpadre."'";

	$tablaclientes .='<tr '.$estilo.'>';  

	$tablaclientes .='<td class="TablaMostrarLeft"></td>';  

	$tablaclientes .="<td  class="."TablaDato".$link."> ".$creadox.' '.FormatoFecha($row['Fecha'])."</td>"; 

	$tablaclientes .='<td class="TablaMostrarLeft"></td>';  

	$tablaclientes .="<td  class="."TablaDato".$link."> ".substr($row['Comentario'],0,65)."</td>"; 

	$tablaclientes .='<td class="TablaMostrarLeft"></td>';  

	$tablaclientes .="<td  class="."TablaDatoR".">"; 



	$tablaclientes .=GLO_rowbutton("CmdBorrarFilaC",$row['Id'],"Eliminar",'self','trash','iconlgray','Eliminar',0,0,0);

	$tablaclientes .="</td><td class="."TablaMostrarRight"."> </td></tr>";  

}	

$tablaclientes .="</table>";echo $tablaclientes;	

mysql_free_result($rs);

}





GLOF_Init('TxtNro','BannerConMenuHV','zModificar',0,'',0,0,0); 



include ("Includes/zCampos.php");

GLO_FAAdjuntarArchivos($_SESSION['TxtNumero'],$conn,"polizas_arch","600","Adjuntos/","Archivos adjuntos","paperclip",0,0,1);

?>





<table width="600" border="0"  cellpadding="0" cellspacing="0" class="fondo" >

<tr> <td height="15"></td></tr>

<!--comentarios-->

<tr ><td height="18" ><i class="fa fa-comments iconsmallsp iconlgray"></i> <strong>Comentarios:</strong></td></tr>

<tr> <td><?php MostrarTablaComentarios($_SESSION['TxtNumero'],$conn); ?>	</td></tr>

</table>                  

    



<? 

GLO_cierratablaform(); 

mysql_close($conn); 

include ("../Codigo/FooterConUsuario.php");

?>