<? include("../Codigo/Seguridad.php");include("../Codigo/Config.php");include("../Codigo/Funciones.php");$_SESSION["NivelArbol"]="../";
require_once('../Codigo/calendar/classes/tc_calendar.php');include("Includes/zFunciones.php") ;
//perfiles
if ($_SESSION["IdPerfilUser"]!=1 and $_SESSION["IdPerfilUser"]!=2  and $_SESSION["IdPerfilUser"]!=3  and $_SESSION["IdPerfilUser"]!=9 and $_SESSION["IdPerfilUser"]!=14){ header("Location:".$_SESSION["NivelArbol"]."Inicio.php");}

$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);

if (empty($_SESSION['TxtFechaD'])){
	$hoy=date("d-m-Y"); list($d,$m,$a)=explode("-",$hoy);$primerdiames="01-".$m."-".$a;$mesrestar=1;
	$_SESSION['TxtFechaD']=date("d-m-Y", strtotime("$primerdiames -0 month"));
	$nextmonth=date("d-m-Y", strtotime("$primerdiames +1 month")); 
	$_SESSION['TxtFechaH']=date("d-m-Y", strtotime("$nextmonth -1 day"));
}


function MostrarTabla($conn){
	$query=$_SESSION['TxtQPROCOP'];$query=str_replace("\\", "", $query);
	if (  ($query!="")){	
		$rs=mysql_query($query,$conn);
		if(mysql_num_rows($rs)!=0){	
			//variables
			$tdetapa='<td width="60" class="TableShowT TAC" style="font-weight:normal;">';
			$iconetapa='iconvsmallsp iconlgray';
			//Titulos de la tabla
			$tablaclientes='';
			$tablaclientes .=GLO_inittabla(950,1,0,0);
			$tablaclientes .='<td width="50" class="TableShowT TAR" valign="bottom"> Numero</td>';
			$tablaclientes .='<td width="70" class="TableShowT" valign="bottom"> Fecha</td>';    
			$tablaclientes .='<td width="250" class="TableShowT" valign="bottom"> Cliente</td>'; 
			$tablaclientes .='<td width="160" class="TableShowT" valign="bottom"> Tipo</td>'; 
			//
			$tablaclientes .=$tdetapa.'<i class="fa fa-file-alt '.$iconetapa.'"></i><br>Logistica<br><label class="TGray">Pedido</label></td>'; 
			$tablaclientes .=$tdetapa.'<i class="fa fa-truck '.$iconetapa.'" ></i><br>Barrera<br><label class="TGray">Ingreso</label></td>'; 
			$tablaclientes .=$tdetapa.'<i class="fa fa-flask '.$iconetapa.'"></i><br>Lab<br><label class="TGray">Calidad</label></td>'; 
			$tablaclientes .=$tdetapa.'<i class="fa fa-warehouse '.$iconetapa.'"></i><br>Planta<br><label class="TGray">Form/Carga</label></td>'; 
			$tablaclientes .=$tdetapa.'<i class="fa fa-flask '.$iconetapa.'"></i><br>Lab<br><label class="TGray">Calidad</label></td>'; 
			$tablaclientes .=$tdetapa.'<i class="fa fa-truck '.$iconetapa.'" ></i><br>Barrera<br><label class="TGray">Egreso</label></td>'; 
			//
			$tablaclientes .='<td width="30" class="TableShowT"></td>';  
			$tablaclientes .='<td width="30" class="TableShowT"></td>';   
			$tablaclientes .='</tr>';    
			$recuento=0;    $_SESSION['TxtOriOPESoli']=0; //para ver a donde vuelve   
			while($row=mysql_fetch_array($rs)){ 			
				GLO_LinkRowTablaInit($estilo,$link,$row['Id'],0);
				$tipopedido='';
				$query="SELECT t.Abr FROM despacho d,despacho_tipo t Where t.Id=d.IdTipo and d.IdPadre=".$row['Id'];$rs10=mysql_query($query,$conn);$row10=mysql_fetch_array($rs10);
				if(mysql_num_rows($rs10)!=0){$tipopedido=$row10['Abr'];}mysql_free_result($rs10);
				//muestro
				$tablaclientes .='<tr '.$estilo.GLO_highlight($row['Id']).'>';
				$tablaclientes .='<td class="TableShowD TAR TBold TL12"'.$link.'>'.str_pad($row['Id'], 5, "0", STR_PAD_LEFT)."</td>"; 
				$tablaclientes .="<td class="."TableShowD".$link."> ".GLO_FormatoFecha($row['Fecha'])."</td>"; 
				$tablaclientes .="<td class="."TableShowD".$link."> ".substr($row['Cliente'],0,30)."</td>"; 
				$tablaclientes .="<td class="."TableShowD".$link."> ".substr($tipopedido,0,22)."</td>"; 
				//
				$tablaclientes .='<td class="TableShowD TAC"'.$link."> ".PROC_ColorEstado(4,$row['Id'],$conn)."</td>";//des
				$tablaclientes .='<td class="TableShowD TAC"'.$link."> ".PROC_ColorEstado(1,$row['Id'],$conn)."</td>";//bar 
				$tablaclientes .='<td class="TableShowD TAC"'.$link."> ".PROC_ColorEstado(2,$row['Id'],$conn)."</td>";//lab
				$tablaclientes .='<td class="TableShowD TAC"'.$link."> ".PROC_ColorEstado(3,$row['Id'],$conn)."</td>";//pla 
				$tablaclientes .='<td class="TableShowD TAC"'.$link."> ".PROC_ColorEstado(6,$row['Id'],$conn)."</td>";//lab 
				$tablaclientes .='<td class="TableShowD TAC"'.$link."> ".PROC_ColorEstado(10,$row['Id'],$conn)."</td>";//bar 
				//cerrar/abrir	
				$tablaclientes .='<td class="TableShowD TAC">';		 
				if($row['Estado']==0){				 					
					$tablaclientes .=GLO_rowbutton("CmdCerrarP",$row['Id'],"Cerrar",'self','unlock','iconlgray','',1,0,0); 
				}else{
					$tablaclientes .=GLO_rowbutton("CmdAbrirP",$row['Id'],"Abrir",'self','lock','iconred','',1,0,0); 
				}
				$tablaclientes .="</td>";  
				//borrar
				$tablaclientes .='<td class="TableShowD TAC">'; 						
				$tablaclientes .=GLO_rowbutton("CmdBorrarFila",$row['Id'],"Eliminar",'self','trash','iconlgray','Eliminar',1,0,0);  	
				$tablaclientes .="</td>";  
				$tablaclientes .='</tr>'; 
				$recuento=$recuento+1;
			}	
			$tablaclientes .=GLO_fintabla(0,0,$recuento);
			echo $tablaclientes;	
		}else{echo '<p class="MuestraConf" align="center">No existen datos que cumplan esos criterios</p>';}
		mysql_free_result($rs);
	}
}


//html
GLOF_Init('','BannerConMenuHV','zProcesos',0,'MenuH',0,0,0); 
GLO_tituloypath(0,730,'../Inicio.php','SOLICITUDES','linksalir');
?>

<table width="730" border="0" cellspacing="0" class="Tabla" >
<tr> <td height="3" width="70"></td><td width="100"></td><td width="130"></td><td width="70"></td><td width="180"></td><td width="50"></td><td width="100"></td><td width="30"></td></tr>
<tr> <td height="18" align="right">Fecha:</td><td >&nbsp;<?php  GLO_calendario("TxtFechaD","../Codigo/","actual",2); ?></td><td> al&nbsp;<?php  GLO_calendario("TxtFechaH","../Codigo/","actual",2); ?></td><td height="18" align="right">Cliente:</td><td>&nbsp;<select name="CbCliente" class="campos" id="CbCliente"  style="width:160px" onKeyDown="enterxtab(event)"><option value=""></option><? GLO_ComboActivo("clientes","CbCliente","Nombre","","",$conn); ?></select></td><td  align="right">Estado:</td><td >&nbsp;<select name="CbEstado"   class="campos" id="CbEstado"  style="width:80px" onKeyDown="enterxtab(event)"><option value=""></option><? PROC_CbEstadoProceso("CbEstado"); ?></select></td><td  align="right"><? GLO_Search('CmdBuscar',0); ?>&nbsp;</td></tr>

</table>


<? 
GLO_Hidden('TxtId',0);GLO_Hidden('TxtQPROCOP',0);
GLO_mensajeerror();
MostrarTabla($conn);
GLO_cierratablaform();
mysql_close($conn); 

GLO_initcomment(0,0);
echo 'Las <font class="comentario3">Solicitudes</font> se dan de alta en <font class="comentario2">Logistica</font><br>';
echo 'Una vez que una <font class="comentario3">Solicitud</font> esta <font class="comentario2">Cerrada</font>, no puede tomarse desde <font class="comentario3">Barrera</font><br>';
echo 'No cerrar la <font class="comentario3">Solicitud</font> hasta que se registre el <font class="comentario2">Retorno</font> en <font class="comentario3">Barrera</font><br>';
GLO_endcomment();

include ("../Codigo/FooterConUsuario.php");
?>