<? include("../Codigo/Seguridad.php") ;include("../Codigo/Config.php") ;include("../Codigo/Funciones.php") ;$_SESSION["NivelArbol"]="../";require_once('../Codigo/calendar/classes/tc_calendar.php');include("Includes/zFunciones.php") ;
//perfiles
GLO_PerfilAcceso(12);

//completa fecha por defecto
if (empty($_SESSION['TxtFechaD'])){
	$hoy=date("d-m-Y"); list($d,$m,$a)=explode("-",$hoy);$primerdiames="01-".$m."-".$a;
	$_SESSION['TxtFechaD']=date("d-m-Y", strtotime("$primerdiames -0 month"));
	$_SESSION['TxtFechaH']=$hoy;
}
//completa tipo reporte
if (empty($_SESSION['OptTipo'])){
	$_SESSION['OptTipo']=1;
}

$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);

    
function MostrarTablaDetalle($conn){
    $query=$_SESSION['TxtQUNIKM'];
    if ($query!=""){
        $rs=mysql_query($query,$conn);
        if(mysql_num_rows($rs)!=0){	
            //Marco de la tabla	
            $tablaclientes='';	
            $tablaclientes .=GLO_inittabla(600,1,0,0);            
            $tablaclientes .='<td width="130" class="TableShowT"> Dominio</td>'; 
            $tablaclientes .='<td width="50" class="TableShowT"> Numero</td>'; 
            $tablaclientes .='<td width="110" class="TableShowT"> Nombre</td>'; 
            $tablaclientes .='<td width="70" class="TableShowT  bordeleftdark">'.'Fecha Control'."</td>";// 
            $tablaclientes .='<td width="80" class="TableShowT TAR  ">'.'Km Recorridos'."</td>";  //
            $tablaclientes .='<td width="80" class="TableShowT TAR ">'.'Hs Marcha'."</td>"; //
            $tablaclientes .='<td width="80" class="TableShowT TAR ">'.'Hs Ralenti'."</td>"; //
            $tablaclientes .='</tr>';  
            $recuento=0;
            //filas
            while($row=mysql_fetch_array($rs)){
                UNIKM_buscarunidad($row['Dominio'],$nom,$nro,$conn);
                //muestro
                $tablaclientes .='<tr '.GLO_highlight($row['Id']).'>';                
                $tablaclientes .='<td  class="TableShowD" >'.$row['Dominio']."</td>"; 
                $tablaclientes .='<td class="TableShowD TAR">'.GLO_SinCeroSTRPAD($nro,6).'</td>'; 
                $tablaclientes .='<td class="TableShowD">'.substr($nom,0,12).'</td>'; 
                $tablaclientes .='<td class="TableShowD bordeleftdark">'.GLO_FormatoFecha($row['Fecha']).'</td>';
                $tablaclientes .='<td class="TableShowD TAR">'.$row['Km'].'</td>';               
                $tablaclientes .='<td class="TableShowD TAR">'.GLO_HoraaDecimal($row['Hm']).'</td>';             
                $tablaclientes .='<td class="TableShowD TAR">'.GLO_HoraaDecimal($row['Hr']).'</td>'; 
                $tablaclientes .='</tr>'; 
                $recuento++;
            }mysql_free_result($rs);
            $tablaclientes .=GLO_fintabla(1,0,$recuento);
            echo $tablaclientes;	
        }else{echo '<p class="MuestraConf" align="center">No existen datos que cumplan esos criterios</p>';}
    }   
}
 
function MostrarTablaAcumulado($conn){
    $query=$_SESSION['TxtQUNIKM'];
    if ($query!=""){
        $rs=mysql_query($query,$conn);
        if(mysql_num_rows($rs)!=0){	
            //Marco de la tabla	
            $tablaclientes='';	
            $tablaclientes .=GLO_inittabla(600,1,0,0);            
            $tablaclientes .='<td width="130" class="TableShowT"> Dominio</td>'; 
            $tablaclientes .='<td width="50" class="TableShowT"> Numero</td>'; 
            $tablaclientes .='<td width="110" class="TableShowT"> Nombre</td>'; 
            $tablaclientes .='<td width="110" class="TableShowT TAR  ">'.'Km Recorridos'."</td>";  //
            $tablaclientes .='<td width="100" class="TableShowT TAR ">'.'Hs Marcha'."</td>"; //
            $tablaclientes .='<td width="100" class="TableShowT TAR ">'.'Hs Ralenti'."</td>"; //
            $tablaclientes .='</tr>';  
            $recuento=0;
            //filas
            while($row=mysql_fetch_array($rs)){
                UNIKM_buscarunidad($row['Dominio'],$nom,$nro,$conn);
                //muestro
                $tablaclientes .='<tr '.GLO_highlight($row['Dominio']).'>';                
                $tablaclientes .='<td  class="TableShowD" >'.$row['Dominio']."</td>"; 
                $tablaclientes .='<td class="TableShowD TAR">'.GLO_SinCeroSTRPAD($nro,6).'</td>'; 
                $tablaclientes .='<td class="TableShowD">'.substr($nom,0,12).'</td>'; 
                $tablaclientes .='<td class="TableShowD TAR">'.$row['Km'].'</td>';               
                $tablaclientes .='<td class="TableShowD TAR">'.GLO_SegundosaDecimal($row['Hm']).'</td>';             
                $tablaclientes .='<td class="TableShowD TAR">'.GLO_SegundosaDecimal($row['Hr']).'</td>'; 
                $tablaclientes .='</tr>'; 
                $recuento++;
            }mysql_free_result($rs);
            $tablaclientes .=GLO_fintabla(1,0,$recuento);
            echo $tablaclientes;	
        }else{echo '<p class="MuestraConf" align="center">No existen datos que cumplan esos criterios</p>';}
    }   
}


GLOF_Init('','BannerConMenuHV','zConsulta',0,'MenuH',0,0,0); 
GLO_tituloypath(0,600,'../Inicio.php','CONTROL KILOMETRAJE','linksalir');
?>

<table width="600" border="0"   cellspacing="0" class="Tabla" >
<tr><td  height=3 width="70" ></td><td width="100"></td><td width="150"></td></td><td width="80"></td><td width="170"></td><td width="30"></td></tr>
<tr><td  align="right" >Fecha:</td><td>&nbsp;<?php  GLO_calendario("TxtFechaD","../Codigo/","actual",1); ?></td><td>al&nbsp;&nbsp;<?php  GLO_calendario("TxtFechaH","../Codigo/","actual",1); ?></td><td align="right">Dominio:</td><td>&nbsp;<input name="TxtBusqueda" type="text" class="TextBox" style="width:80px" maxlength="20" onKeyDown="enterxtab(event)" onKeyUp="this.value=this.value.toUpperCase()"></td><td   align="right" ></td></tr>

<tr><td  align="right" >Reporte:</td><td colspan="2">&nbsp;<input name="OptTipo"  type="radio"  class="radiob"   value="1"<? if ($_SESSION['OptTipo'] =='1') echo 'checked'; ?> >Acumulado <input name="OptTipo"  type="radio"  class="radiob"   value="2"<? if ($_SESSION['OptTipo'] =='2') echo 'checked'; ?> >Detallado</td><td align="right">Nombre:</td><td>&nbsp;<input name="TxtBusqueda2" type="text" class="TextBox" style="width:80px" maxlength="20" onKeyDown="enterxtab(event)" onKeyUp="this.value=this.value.toUpperCase()"></td><td   align="right" ><? GLO_Search('CmdBuscar',0); ?>&nbsp;</td></tr>
</table>

<? 
GLO_Hidden('TxtId',0);GLO_Hidden('TxtQUNIKM',0);
GLO_mensajeerror(); 

if(intval($_SESSION['OptTipo'])==2){//detallado
    MostrarTablaDetalle($conn);
}else{
    MostrarTablaAcumulado($conn); 
}

GLO_cierratablaform();
mysql_close($conn);


GLO_initcomment(0,0);
echo 'Seleccione <font class="comentario2">Periodo</font> para ejecutar la consulta<br>';
echo 'Muestra las <font class="comentario3">Horas</font> en decimal<br>';
echo 'Si no ve el <font class="comentario2">Nombre</font>, revise que coincida el Dominio con alguna <font class="comentario3">Unidad</font> registrada<br>';
GLO_endcomment();

include ("../Codigo/FooterConUsuario.php");
?>