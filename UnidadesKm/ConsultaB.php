<? include("../Codigo/Seguridad.php") ;include("../Codigo/Config.php") ;include("../Codigo/Funciones.php") ;$_SESSION["NivelArbol"]="../";require_once('../Codigo/calendar/classes/tc_calendar.php');
include("Includes/zFunciones.php") ;
//perfiles
GLO_PerfilAcceso(12);


//completa fecha por defecto
if (empty($_SESSION['TxtFechaD'])){
	$hoy=date("d-m-Y"); list($d,$m,$a)=explode("-",$hoy);$primerdiames="01-".$m."-".$a;
	$_SESSION['TxtFechaD']=date("d-m-Y", strtotime("$primerdiames -0 month"));
	$_SESSION['TxtFechaH']=$hoy;
}


$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);

    
function MostrarTabla($conn){
    $query=$_SESSION['TxtQUNIKMB'];
    if ($query!=""){
        $rs=mysql_query($query,$conn);
        if(mysql_num_rows($rs)!=0){	
            //Marco de la tabla	
            $tablaclientes='';	
            $tablaclientes .=GLO_inittabla(580,1,0,0);  
            $tablaclientes .='<td align="right">'.GLO_FAButton('CmdGuardar','submit','80','self','Eliminar','cross','boton02')."</td></tr></table>"; 	
            $tablaclientes .='<table width="580" class="TableShow TMT" id="tshow"><tr>';                    
            $tablaclientes .='<td width="150" class="TableShowT"> Dominio</td>'; 
            $tablaclientes .='<td width="100" class="TableShowT  bordeleftdark">'.'Fecha Control'."</td>";// 
            $tablaclientes .='<td width="100" class="TableShowT TAR  ">'.'Km Recorridos'."</td>";  //
            $tablaclientes .='<td width="100" class="TableShowT TAR ">'.'Hs Marcha'."</td>"; //
            $tablaclientes .='<td width="100" class="TableShowT TAR ">'.'Hs Ralenti'."</td>"; //
            $tablaclientes .='<td width="30" class="TableShowT TAC"> <input type="checkbox" name="ChkAll" unchecked onclick="CheckMasivo();"></td>';
            $tablaclientes .='</tr>';  
            $recuento=0;
            //filas
            while($row=mysql_fetch_array($rs)){
                //muestro
                $tablaclientes .='<tr '.GLO_highlight($row['Id']).'>';                
                $tablaclientes .='<td  class="TableShowD" >'.$row['Dominio']."</td>"; 
                $tablaclientes .='<td class="TableShowD bordeleftdark">'.GLO_FormatoFecha($row['Fecha']).'</td>';
                $tablaclientes .='<td class="TableShowD TAR">'.$row['Km'].'</td>';               
                $tablaclientes .='<td class="TableShowD TAR">'.GLO_FormatoHora($row['Hm']).'</td>';             
                $tablaclientes .='<td class="TableShowD TAR">'.GLO_FormatoHora($row['Hr']).'</td>'; 
                $tablaclientes .='<td class="TableShowD TAC">'.'<input type="checkbox" name="campos['.$row['Id'].']" >'."</td>";  
                $tablaclientes .='</tr>'; 
                $recuento++;
            }mysql_free_result($rs);
            $tablaclientes .=GLO_fintabla(0,0,$recuento);
            echo $tablaclientes;	
        }else{echo '<p class="MuestraConf" align="center">No existen datos que cumplan esos criterios</p>';}
    }   
}
    

GLOF_Init('','BannerConMenuHV','zConsultaB',0,'MenuH',0,0,0); 
GLO_tituloypath(0,580,'Consulta.php','ELIMINAR DATOS RSV','linksalir');
?>

<table width="580" border="0"   cellspacing="0" class="Tabla" >
<tr><td  height=3 width="70" ></td><td width="100"></td><td width="150"></td></td><td width="80"></td><td width="150"></td><td width="30"></td></tr>
<tr><td  align="right" >Fecha:</td><td>&nbsp;<?php  GLO_calendario("TxtFechaD","../Codigo/","actual",1); ?></td><td>al&nbsp;&nbsp;<?php  GLO_calendario("TxtFechaH","../Codigo/","actual",1); ?></td><td align="right">Dominio:</td><td>&nbsp;<input name="TxtBusqueda" type="text" class="TextBox" style="width:80px" maxlength="20" onKeyDown="enterxtab(event)" onKeyUp="this.value=this.value.toUpperCase()"></td><td   align="right" ><? GLO_Search('CmdBuscar',0); ?>&nbsp;</td></tr>
</table>

<? 
GLO_Hidden('TxtId',0);GLO_Hidden('TxtQUNIKMB',0);
GLO_mensajeerror(); 
MostrarTabla($conn);
GLO_cierratablaform();
mysql_close($conn);


GLO_initcomment(580,0);
echo 'Seleccione <font class="comentario2">Periodo</font> para ejecutar la consulta<br>';
GLO_endcomment();

include ("../Codigo/FooterConUsuario.php");
?>