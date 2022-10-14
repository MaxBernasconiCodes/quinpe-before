<? include("Codigo/Seguridad.php") ;include("Codigo/Config.php") ;include("Codigo/Funciones.php") ;$_SESSION["NivelArbol"]="";
require_once('Codigo/calendar/classes/tc_calendar.php');include("ISODoc/Includes/zFunciones.php");
//perfiles
GLO_PerfilAcceso(14);

$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);

if ($_SESSION["TxtConsultaDoc"]==""){ConsultaxDefecto();}

function MostrarTabla($conn){
$query=$_SESSION['TxtConsultaDoc'];
if (  ($query!="")){
	$rs=mysql_query($query,$conn);
	if(mysql_num_rows($rs)!=0){	
		//Titulos de la tabla	
		$tablaclientes='';
		$tablaclientes .=GLO_inittabla(980,1,0,0);
		$tablaclientes .="<td "."width="."50"." class="."TableShowT"."> N&uacute;mero</td>";   
		$tablaclientes .="<td "."width="."110"." class="."TableShowT"."> C&oacute;digo</td>"; 
		$tablaclientes .="<td "."width="."280"." class="."TableShowT"."> Nombre</td>"; 
		$tablaclientes .="<td "."width="."30"." class="."TableShowT"."> Vs</td>"; 
		$tablaclientes .="<td "."width="."150"." class="."TableShowT".">Tipo</td>"; 
		$tablaclientes .="<td "."width="."80"." class="."TableShowT".">Sector</td>"; 
		$tablaclientes .="<td "."width="."60"." class="."TableShowT".">Origen</td>"; 
		$tablaclientes .="<td "."width="."70"." class="."TableShowT".">Alta</td>"; 
		$tablaclientes .="<td "."width="."90"." class="."TableShowT".">Estado</td>"; 
		$tablaclientes .="<td "."width="."30"." class="."TableShowT"."></td>"; 
		$tablaclientes .="<td "."width="."30"." class="."TableShowT"."></td>"; 
		$tablaclientes .='</tr>';    
		$recuento=0;  $estilo=" style='cursor:pointer;' ";     
		while($row=mysql_fetch_array($rs)){
			$link=" onclick="."location='ISODoc/Modificar.php?Flag1=True&id=".$row['Id']."'";
			$ori='';if($row['Origen']==1){$ori='Externo';}if($row['Origen']==2){$ori='Interno';}
			$colorest=ISODOC_ColorEstado($row['IdEstado']);
			//
			$tablaclientes .='<tr '.$estilo.GLO_highlight($row['Id']).'>';
			$tablaclientes .="<td class="."TableShowD ".$link."> ".str_pad($row['Id'], 5, "0", STR_PAD_LEFT)."</td>";  
			$tablaclientes .="<td class="."TableShowD ".$link."> ".substr($row['Codigo'],0,15)."</td>";  
			$tablaclientes .="<td class="."TableShowD ".$link."> ".substr($row['Nombre'],0,40)."</td>";  			
			$tablaclientes .="<td class="."TableShowD ".$link."> ".str_pad($row['Version'], 2, "0", STR_PAD_LEFT)."</td>";  
			$tablaclientes .="<td class="."TableShowD ".$link."> ".substr($row['Tipo'],0,18)."</td>"; 
			$tablaclientes .="<td class="."TableShowD ".$link."> ".substr($row['Sector'],0,10)."</td>"; 
			$tablaclientes .="<td class="."TableShowD ".$link."> ".$ori."</td>"; 
			$tablaclientes .="<td class="."TableShowD ".$link."> ".GLO_FormatoFecha($row['FechaCRE'])."</td>"; 
			$tablaclientes .="<td class="."TableShowD ".$link.$colorest."> ".substr($row['Estado'],0,10)."</td>"; 
			$tablaclientes .="<td  class="."TableShowD"." style='text-align:center;'>"; 		
			//ver archivo: 
			//si es obsoleto(6) solo usuario perfil admin
			//todos los estados si es perf.admin/perf.coord/contr/apr, y los demas solo aprobado(4)
			if ((($_SESSION["IdPerfilUser"]==1 or $_SESSION["IdPerfilUser"]==2 or $_SESSION["IdPerfilUser"]==4 or $_SESSION["IdPerfilUser"]==3  or $_SESSION["IdPerfilUser"]==9 or $_SESSION["IdPerfilUser"]==14 or $_SESSION["GLO_IdPersLog"]==$row['IdPersCON'] or $_SESSION["GLO_IdPersLog"]==$row['IdPersAPR'] or $row['IdEstado']==4) and $row['IdEstado']!=6) or ($row['IdEstado']==6 and ($_SESSION["IdPerfilUser"]==1 or $_SESSION["IdPerfilUser"]==2 ))){
				if( !(empty($row['Ruta']))){//si tiene adjunto visible
					$tablaclientes .=GLO_rowbutton("CmdVerFile",$row['Id'],"Ver",'blank','lupa','iconlgray','',1,0,0);  
				}
			}
			$tablaclientes .="</td>";  
			$tablaclientes .="<td  class="."TableShowD"." style='text-align:center;'>"; 
			//elimina si esta 0:elaborado o 3:revisar control y sin adjunto y admin sistema
			if($row['Ruta']=='' and ($row['IdEstado']==0 or $row['IdEstado']==3) and ($_SESSION["IdPerfilUser"]==1 or $_SESSION["IdPerfilUser"]==2) ){
				$tablaclientes .=GLO_rowbutton("CmdBorrarFila",$row['Id'],"Eliminar",'self','trash','iconlgray','Eliminar',1,0,0);  	
			}				
			$tablaclientes .="</td>";  		
			$tablaclientes .='</tr>'; 
			$recuento++;
		}	
		$tablaclientes .=GLO_fintabla(1,0,$recuento);
		echo $tablaclientes;
	}else{echo '<p class="MuestraConf" align="center">No existen datos que cumplan esos criterios</p>';}
	mysql_free_result($rs);
}
}





function ConsultaXDefecto(){
$where='';
// perfil coord y admin
if ($_SESSION["IdPerfilUser"]==1 or $_SESSION["IdPerfilUser"]==2 or $_SESSION["IdPerfilUser"]==4  or $_SESSION["IdPerfilUser"]==3  or $_SESSION["IdPerfilUser"]==9 or $_SESSION["IdPerfilUser"]==14 or $_SESSION["IdPerfilUser"]==10){$where=" and d.IdEstado=3";}
//verifico controlador
if ($_SESSION["GLO_IdPersCON"]==$_SESSION["GLO_IdPersLog"]){$where=" and (d.IdEstado=1 or d.IdEstado=5)";}
//verifico si es aprobador
if ($_SESSION["GLO_IdPersAPR"]==$_SESSION["GLO_IdPersLog"]){$where=" and d.IdEstado=2";}
//query
$_SESSION["TxtConsultaDoc"]="Select d.*,t.Nombre as Tipo,e.Nombre as Estado,s.Nombre as Sector,r.Nombre as Req,p1.Nombre as N1,p1.Apellido as A1,p2.Nombre as N2,p2.Apellido as A2,p3.Nombre as N3,p3.Apellido as A3,r.Nro as NReq From iso_doc d,iso_doc_tipo t,iso_doc_estados e,sector s,iso_nc_req r,personal p1,personal p2,personal p3 Where t.Id=d.IdTipoDoc and e.Id=d.IdEstado and s.Id=d.IdSector and r.Id=d.IdReq and p1.Id=d.IdPersCRE and p2.Id=d.IdPersCON and p3.Id=d.IdPersAPR $where Order By d.Codigo";
}



GLOF_Init('TxtNro','BannerConMenuHV','ISODoc/zISO_Doc',0,'ISODoc/MenuH',0,0,0); 
GLO_tituloypath(0,810,'Inicio.php','CONTROL DE DOCUMENTOS','linksalir');
?>

<table width="810" border="0"  cellspacing="0" class="Tabla" >
<tr> <td height="5" width="70"></td><td width="100"></td><td width="120"></td><td width="60"></td><td width="100"></td><td width="60"></td><td width="100"></td><td width="60"></td><td width="100"></td><td width="30"></td></tr>
<tr> 
<td height="18"  align="right">Creacion:</td><td>&nbsp;<?php  GLO_calendario("TxtFechaD","Codigo/","actual",1); ?></td><td  > al&nbsp;<?php  GLO_calendario("TxtFechaH","Codigo/","actual",1); ?></td><td align="right">Origen:</td><td>&nbsp;<select name="CbOrigen" style="width:80px" class="campos" id="CbOrigen" ><option value=""></option> <? ComboISOOrigenDoc(); ?> </select></td><td height="18" align="right">Id:</td><td>&nbsp;<input name="TxtNro" type="text"  class="TextBox"  maxlength="10"  value="<? echo $_SESSION['TxtNro']; ?>" onChange="this.value=validarEntero(this.value);" style="text-align:right;width:90px" onKeyDown="enterxtab(event)"></td><td align="right" >Estado:</td><td>&nbsp;<select name="CbEstado" class="campos" id="CbEstado"  style="width:80px" onKeyDown="enterxtab(event)"><option value="999"></option><option value="0">ELABORADO</option><? ComboTablaRFX("iso_doc_estados","CbEstado","Id","","",$conn); ?></select></td></tr>

<tr> <td height="18"  align="right">Nombre:</td><td colspan="2">&nbsp;<input name="TxtBusqueda" type="text" class="TextBox" style="width:180px" maxlength="20" onKeyDown="enterxtab(event)"></td><td  align="right">Sector:</td><td >&nbsp;<select name="CbSector" class="campos" id="CbSector"  style="width:80px" onKeyDown="enterxtab(event)"><option value=""></option><? ComboTablaRFX("sector","CbSector","Nombre","","",$conn); ?></select></td><td  align="right">C&oacute;digo:</td><td >&nbsp;<input name="TxtCod" type="text" class="TextBox" style="width:90px" maxlength="20" onKeyDown="enterxtab(event)"></td><td align="right" >Tipo:</td><td>&nbsp;<select name="CbTipo" style="width:80px" class="campos" id="CbTipo" ><option value=""></option> <? ComboTablaRFX("iso_doc_tipo","CbTipo","Nombre","","",$conn); ?> </select></td><td  align="right" ><? GLO_Search('CmdBuscar',0); ?>&nbsp;</td></tr>

</table>


<table  width="810" border="0" cellspacing="0" cellpadding="0" >
<tr><td  height=3 width="600"></td><td width="210" ></td></tr>
<tr  valign="bottom"><td align="left" valign="bottom" >
<? //solo agregan perfil coord y admin
if ($_SESSION["IdPerfilUser"]==1 or $_SESSION["IdPerfilUser"]==2 or $_SESSION["IdPerfilUser"]==3 or $_SESSION["IdPerfilUser"]==4   or $_SESSION["IdPerfilUser"]==5 or  $_SESSION["IdPerfilUser"]==6 or  $_SESSION["IdPerfilUser"]==7 or $_SESSION["IdPerfilUser"]==9 or $_SESSION["IdPerfilUser"]==14){
echo '<input name="CmdAgregar" type="button" class="boton"  style="width:80px;" value="Agregar" onClick="window.location.href='."'ISODoc/Alta.php'".';">&nbsp;';
}
?> 
</td><td   align="right" ><? echo GLO_FAButton('CmdRefresh','submit','90','self','Actualizar','load','boton02');?>&nbsp;</td>	</tr>
</table>


<? 
GLO_Hidden('TxtId',0);GLO_Hidden('TxtConsultaDoc',0);
GLO_mensajeerror();
MostrarTabla($conn); 
GLO_cierratablaform();
mysql_close($conn);

GLO_initcomment(0,0);
echo 'No podr&aacute;n cargarse <font class="comentario2">Documentos</font>  si primero no se registran los <font class="comentario2">Responsables</font><br>';
echo 'El perfil <font class="comentario3">Administrador Sistema</font> podra <font class="comentario2">eliminar</font> documentos sin adjuntos, registros ni copias';

GLO_endcomment();
include ("Codigo/FooterConUsuario.php");
?>