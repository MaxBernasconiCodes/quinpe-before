<? include("Codigo/Seguridad.php") ;include("Codigo/Config.php") ;include("Codigo/Funciones.php") ;$_SESSION["NivelArbol"]="";
//perfiles
if ($_SESSION["IdPerfilUser"]!=1 and $_SESSION["IdPerfilUser"]!=2 and $_SESSION["IdPerfilUser"]!=5  and $_SESSION["IdPerfilUser"]!=3  and $_SESSION["IdPerfilUser"]!=11  and $_SESSION["IdPerfilUser"]!=12  and $_SESSION["IdPerfilUser"]!=9 and $_SESSION["IdPerfilUser"]!=14){ header("Location:".$_SESSION["NivelArbol"]."Inicio.php");}

$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);


function CLI_MostrarTabla($conn){
    $query=$_SESSION['TxtQCLI'];$query=str_replace("\\", "", $query);
    if (  ($query!="")){	
        $rs=mysql_query($query,$conn);
        if(mysql_num_rows($rs)!=0){	
            $tablaclientes='';
            $tablaclientes .=GLO_inittabla(860,1,0,0);
            $tablaclientes .="<td "."width="."50"." class="."TableShowT"." style='text-align:right;'> N&uacute;mero</td>";   
            $tablaclientes .="<td "."width="."460"." class="."TableShowT"."> Raz&oacute;n Social</td>";   
            $tablaclientes .="<td "."width="."100"." class="."TableShowT"."> Actividad</td>";   
            $tablaclientes .="<td "."width="."80"." class="."TableShowT"."> CUIT</td>"; 
            $tablaclientes .="<td "."width="."90"." class="."TableShowT"."> Localidad</td>"; 
            $tablaclientes .="<td "."width="."80"." class="."TableShowT"."> Cond.IVA</td>";   
            $tablaclientes .='</tr>';    
            $recuento=0;          
            $estilo=" style='cursor:pointer;' ";
            while($row=mysql_fetch_array($rs)){ 			
                $link=" onclick="."location='Clientes/Modificar.php?Flag1=True&id=".$row['Id']."'";
                $fbaja= FormatoFecha($row['FechaBaja']);if ($fbaja=='00-00-0000'){$fbaja="";}
                if ($fbaja=='' or (strtotime(date("d-m-Y"))-strtotime($fbaja))<0){$clase="TableShowD";}else{$clase="TableShowD TGray";}	
                //muestro
                $tablaclientes .='<tr '.$estilo.GLO_highlight($row['Id']).'>';  
                $tablaclientes .='<td class="'.$clase.'"'.$link." style='text-align:right;'> ".str_pad($row['Id'], 5, "0", STR_PAD_LEFT)."</td>"; 
                $tablaclientes .='<td class="'.$clase.'"'.$link."> ".substr($row['Nombre'],0,53)."</td>"; 
                $tablaclientes .='<td class="'.$clase.'"'.$link."> ".substr($row['Actividad'],0,12)."</td>";  
                $tablaclientes .='<td class="'.$clase.'"'.$link."> ".substr($row['Identificacion'],0,14)."</td>"; 
                $tablaclientes .='<td class="'.$clase.'"'.$link."> ".substr($row['NombreLocalidad'],0,10)."</td>"; 
                $tablaclientes .='<td class="'.$clase.'"'.$link."> ".substr($row['IVA'],0,10)."</td>"; 
                $tablaclientes .='</tr>'; 
                $recuento=$recuento+1;
            }	
            $tablaclientes .=GLO_fintabla(1,0,$recuento);
            echo $tablaclientes;	
        }else{echo '<p class="MuestraConf" align="center">No existen datos que cumplan esos criterios</p>';}
        mysql_free_result($rs);
    }
    }
    


GLOF_Init('','BannerConMenuHV','Clientes/zClientes',0,'Clientes/MenuH',0,0,0); 
GLO_tituloypath(0,700,'Inicio.php','CLIENTES','linksalir'); 
?>


<table width="700" border="0"   cellspacing="0" class="Tabla" >
<tr><td  height=3 width="90" ></td><td  height=3 width="100"></td><td  height=3 width="80"></td><td  height=3 width="100"></td><td  height=3 width="80"></td><td  width="100"></td><td  width="110"></td><td width="30"></td></tr>
<tr>  <td  align="right" >Raz&oacute;n Social:</td><td>&nbsp;<input name="TxtBusqueda" type="text" class="TextBox" style="width:80px" maxlength="20" onKeyDown="enterxtab(event)"> </td><td  align="right" >CUIT:</td><td>&nbsp;<input name="TxtBusquedaCUIT" type="text" class="TextBox" style="width:80px" maxlength="20" onKeyDown="enterxtab(event)"></td><td  align="right" >Actividad:</td><td>&nbsp;<select name="CbActividad" class="campos" id="CbActividad"  style="width:80px" onKeyDown="enterxtab(event)"><option value=""></option><? ComboTablaRFX("actividades","CbActividad","Nombre","","",$conn); ?></select></td><td><input name="ChkActivo"  type="checkbox"  value="1" <? if ($_SESSION['ChkActivo'] =='1') echo 'checked'; ?>> Activos</td><td  align="right"><? GLO_Search('CmdBuscar',0);?></td></tr>
</table>


	
<? 
GLO_linkbutton(700,'Agregar','Clientes/Alta.php','','','','');
GLO_Hidden('TxtId',0);GLO_Hidden('TxtQCLI',0);
GLO_mensajeerror();
CLI_MostrarTabla($conn); 
mysql_close($conn);
GLO_cierratablaform();
include ("Codigo/FooterConUsuario.php");
?>