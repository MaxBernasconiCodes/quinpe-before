<? include("Codigo/Seguridad.php") ;include("Codigo/Config.php") ;include("Codigo/Funciones.php") ;$_SESSION["NivelArbol"]="";include ("Proveedores/Includes/zFunciones.php");
//perfiles
if ($_SESSION["IdPerfilUser"]!=1 and $_SESSION["IdPerfilUser"]!=2 and $_SESSION["IdPerfilUser"]!=11){ header("Location:".$_SESSION["NivelArbol"]."Inicio.php");}

$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);

function PROV_MostrarTabla($conn){
    $query=$_SESSION['TxtQPROV'];$query=str_replace("\\", "", $query);
    if (  ($query!="")){	
        $rs=mysql_query($query,$conn);
        if(mysql_num_rows($rs)!=0){	
            $tablaclientes='';
            $tablaclientes .=GLO_inittabla(830,1,0,0);
            $tablaclientes .="<td "."width="."400"." class="."TableShowT"."> Raz&oacute;n Social</td>";   
            $tablaclientes .="<td "."width="."140"." class="."TableShowT"."> CUIT</td>"; 
            $tablaclientes .='<td width="100" class="TableShowT"> Cond.IVA</td>';  
            $tablaclientes .='<td width="140" class="TableShowT"> Actividad</td>';  
            $tablaclientes .='<td width="50" class="TableShowT"> Critico</td>'; 
            $tablaclientes .='<td width="50" class="TableShowT"> Evaluar</td>'; 
            $tablaclientes .='</tr>';    
            $recuento=0;          
            $estilo=" style='cursor:pointer;' ";
            $clase="TableShowD";
            while($row=mysql_fetch_array($rs)){ 			
                $link=" onclick="."location='Proveedores/Modificar.php?Flag1=True&id=".$row['Id']."'";
                $fbaja= GLO_FormatoFecha($row['FechaBaja']);
                if ($fbaja!='' and (strtotime(date("d-m-Y"))-strtotime($fbaja))>=0){$clase="TableShowD TGray";}	
                //muestro
                $tablaclientes .='<tr '.$estilo.GLO_highlight($row['Id']).'>'; 
                $tablaclientes .='<td class="'.$clase.'"'.$link."> ".substr($row['Apellido'],0,50)."</td>"; 
                $tablaclientes .='<td class="'.$clase.'"'.$link."> ".substr($row['Identificacion'],0,15)."</td>"; 
                $tablaclientes .='<td class="'.$clase.'"'.$link.'>'.substr($row['IVA'],0,12).'</td>'; 
                $tablaclientes .='<td class="'.$clase.'"'.$link.'>'.substr($row['Actividad'],0,16).'</td>'; 
                $tablaclientes .='<td class="'.$clase.'"'.$link.'>'.GLO_Si($row['Critico']).'</td>'; 
                $tablaclientes .='<td class="'.$clase.'"'.$link.'>'.GLO_Si($row['Evaluar']).'</td>'; 
                $tablaclientes .='</tr>'; 
                $recuento=$recuento+1;
            }mysql_free_result($rs);	
            $tablaclientes .=GLO_fintabla(1,0,$recuento);
            echo $tablaclientes;	
        }else{echo '<p class="MuestraConf" align="center">No existen datos que cumplan esos criterios</p>';}
        
    }
    }
    

GLO_InitHTML($_SESSION["NivelArbol"],'TxtBusqueda','BannerConMenuHV','Proveedores/zProveedores',0,0,0,0);
GLO_tituloypath(0,700,'Inicio.php','PROVEEDORES','linksalir');
?>

<table width="700" border="0"   cellspacing="0" class="Tabla" >
<tr><td  height=3 width="90" ></td><td  height=3 width="160"></td><td width="70"></td><td  width="160"></td><td  width="110"></td><td width="100"></td></tr>
<tr>  <td  align="right" >Raz&oacute;n Social:</td><td>&nbsp;<input name="TxtBusqueda" type="text" class="TextBox" style="width:130px" maxlength="20" onKeyDown="enterxtab(event)"> </td><td  align="right" >Actividad:</td><td>&nbsp;<select name="CbActividad" class="campos" id="CbActividad"  style="width:130px" onKeyDown="enterxtab(event)"><option value=""></option><? ComboTablaRFX("actividades","CbActividad","Nombre","","",$conn); ?></select></td><td><input name="ChkC1"  type="checkbox"  class="check" value="1" <? if ($_SESSION['ChkC1'] =='1') echo 'checked'; ?>> Cr&iacute;tico</td><td  align="right"></td></tr>
<tr>  <td  align="right" >CUIT:</td><td>&nbsp;<input name="TxtBusquedaCUIT" type="text" class="TextBox" style="width:130px" maxlength="20" onKeyDown="enterxtab(event)"> </td><td  align="right" ></td><td><input name="ChkActivo"  type="checkbox"  class="check" value="1" <? if ($_SESSION['ChkActivo'] =='1') echo 'checked'; ?>> Activos</td> <td><input name="ChkC2"  type="checkbox"  class="check" value="1" <? if ($_SESSION['ChkC2'] =='1') echo 'checked'; ?>> Evaluar </td>  <td  align="right"><? GLO_Search('CmdBuscar',0); ?>&nbsp;</td></tr>
</table>

<? 
GLO_Hidden('TxtId',0);GLO_Hidden('TxtQPROV',0);
GLO_linkbutton(700,'Agregar','Proveedores/Alta.php','EVALUACION','Proveedores/ProveedoresD.php','','');
GLO_mensajeerror();
PROV_MostrarTabla($conn); 
mysql_close($conn);
GLO_cierratablaform();
include ("Codigo/FooterConUsuario.php");
?>