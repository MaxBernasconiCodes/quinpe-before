<? include("../Codigo/Seguridad.php") ;include("../Codigo/Config.php") ;include("../Codigo/Funciones.php") ;$_SESSION["NivelArbol"]="../";include ("Includes/zFunciones.php");
//perfiles
if ($_SESSION["IdPerfilUser"]!=1 and $_SESSION["IdPerfilUser"]!=2 and $_SESSION["IdPerfilUser"]!=11){ header("Location:".$_SESSION["NivelArbol"]."Inicio.php");}


$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);

function PROV_MostrarTablaD($conn){
    $query=$_SESSION['TxtQPROVD'];$query=str_replace("\\", "", $query);
    if (  ($query!="")){	
        $rs=mysql_query($query,$conn);
        if(mysql_num_rows($rs)!=0){	
            //contenedora
            $tablaclientes='';
            $tablaclientes .=GLO_inittabla(850,1,0,0);
            $tablaclientes .="<td "."width="."400"." class="."TableShowT"."> Raz&oacute;n Social</td>";   
            $tablaclientes .="<td "."width="."70"." class="."TableShowT"."> Fecha</td>";   
            $tablaclientes .="<td "."width="."70".' class="TableShowT TAR"> Trayectoria</td>';   
            $tablaclientes .="<td "."width="."60".' class="TableShowT TAR">  Gestion</td>';  
            $tablaclientes .="<td "."width="."50".' class="TableShowT TAR">  Total</td>';   
            $tablaclientes .="<td "."width="."200"." class="."TableShowT"."> Descripcion</td>";   
            $tablaclientes .='</tr>';    
            $recuento=0;  $clase="TableShowD";
            $_SESSION['GLO_IdLocationPROVD']=1; 
            while($row=mysql_fetch_array($rs)){ 			
                GLO_LinkRowTablaInit($estilo,$link,$row['Id'],2);	
                include ("Includes/zTotales.php");
                $color1=PROV_EPestilo($t3,1,0);
                $color2=PROV_EPestilo($t3,2,0);
                //filtro estado
                if(intval($_SESSION['CbEstado'])==0){$muestrofila=1;}
                else{$muestrofila=PROV_WhereDes(intval($_SESSION['CbEstado']),$t3);}
                //muestro
                if($muestrofila==1){
                    $tablaclientes .='<tr '.$estilo.GLO_highlight($row['Id']).'>'; 
                    $tablaclientes .='<td class="'.$clase.'"'.$link."> ".substr($row['Apellido'],0,46)."</td>"; 
                    $tablaclientes .='<td class="TableShowD"'.$link."> ".GLO_FormatoFecha($row['Fecha'])."</td>"; 
                    $tablaclientes .='<td class="TableShowD  TAR"'.$link."> ".$t1."</td>"; 
                    $tablaclientes .='<td class="TableShowD  TAR"'.$link."> ".$t2."</td>"; 
                    $tablaclientes .='<td class="TableShowD  TAR"'.$link." style='font-weight:bold;".$color1."'> ".$t3."</td>"; 
                    $tablaclientes .='<td class="TableShowD"'.$link." style='font-weight:bold;".$color2."'> ".PROV_EPlabel($t3)."</td>"; 
                    $tablaclientes .='</tr>'; 
                    $recuento=$recuento+1;
                }
            }mysql_free_result($rs);	
            $tablaclientes .=GLO_fintabla(1,0,$recuento);
            echo $tablaclientes;	
        }else{echo '<p class="MuestraConf" align="center">No existen datos que cumplan esos criterios</p>';}
        
    }
    }
    

GLO_InitHTML($_SESSION["NivelArbol"],'TxtBusqueda','BannerConMenuHV','zProveedoresD',0,0,0,0);
GLO_tituloypath(0,700,'../Proveedores.php','EVALUACIONES','linksalir');
?>

<table width="700" border="0"   cellspacing="0" class="Tabla" >
<tr><td  height=3 width="90" ></td><td  height=3 width="160"></td><td width="70"></td><td  width="170"></td><td  width="100"></td><td width="100"></td></tr>
<tr>  <td  align="right" >Raz&oacute;n Social:</td><td>&nbsp;<input name="TxtBusqueda" type="text" class="TextBox" style="width:130px" maxlength="20" onKeyDown="enterxtab(event)"> </td><td  align="right" >Estado:</td><td>&nbsp;<select name="CbEstado" class="campos" id="CbEstado"  style="width:140px" onKeyDown="enterxtab(event)"><option value=""></option><? PROV_CbDes("CbEstado"); ?></select></td>
<td></td><td  align="right"><? GLO_Search('CmdBuscar',0); ?>&nbsp;</td></tr>


</table>

<? 
GLO_Hidden('TxtId',0);GLO_Hidden('TxtQPROVD',0);
GLO_mensajeerror();
PROV_MostrarTablaD($conn); 
mysql_close($conn);
GLO_cierratablaform();
include ("../Codigo/FooterConUsuario.php");
?>