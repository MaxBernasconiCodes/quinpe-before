<? include("Codigo/Seguridad.php") ;include("Codigo/Config.php") ;include("Codigo/Funciones.php") ;$_SESSION["NivelArbol"]="";
include("ISOProgramas/Includes/zFunciones.php") ;
//perfiles
if ($_SESSION["IdPerfilUser"]!=1 and $_SESSION["IdPerfilUser"]!=2 and $_SESSION["IdPerfilUser"]!=9 and $_SESSION["IdPerfilUser"]!=14){ header("Location:".$_SESSION["NivelArbol"]."Inicio.php");}

$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);

function PL_MostrarTabla($conn){
    $query=$_SESSION['TxtQISOPROG'];$query=str_replace("\\", "", $query);
    if (  ($query!="")){
        $rs=mysql_query($query,$conn);
        if(mysql_num_rows($rs)!=0){	
            //Marco de la tabla	
            $tablaclientes='';	
            $tablaclientes .=GLO_inittabla(800,1,0,0);
            $tablaclientes .="<td "."width="."60"." class="."TableShowT"."> Fecha</td>"; 
            $tablaclientes .="<td "."width="."150"." class="."TableShowT"."> Sector</td>"; 
            $tablaclientes .="<td "."width="."150"." class="."TableShowT"."> Tipo</td>"; 
            $tablaclientes .="<td "."width="."410"." class="."TableShowT".">Referencia</td>";   
            $tablaclientes .="<td "."width="."30"." class="."TableShowT"."> </td>";   
            $tablaclientes .='</tr>';    
            $recuento=0;     
            while($row=mysql_fetch_array($rs)){
                GLO_LinkRowTablaInit($estilo,$link,$row['Id'],0);
                $tablaclientes .='<tr '.$estilo.GLO_highlight($row['Id']).'>';
                $tablaclientes .="<td class="."TableShowD ".$link."> ".$row['Fecha']."</td>";  
                $tablaclientes .="<td class="."TableShowD ".$link."> ".substr($row['Sector'],0,18)."</td>";  
                $tablaclientes .="<td class="."TableShowD ".$link."> ".substr($row['Tipo'],0,18)."</td>";  
                $tablaclientes .="<td class="."TableShowD ".$link."> ".substr($row['Nombre'],0,50)."</td>";  			
                $tablaclientes .="<td class="."TableShowD"." style='text-align:center;'>";  						
                $tablaclientes .=GLO_rowbutton("CmdBorrarFila",$row['Id'],"Eliminar",'self','trash','iconlgray','Eliminar',1,0,0);  					
                $tablaclientes .="</td>";  
                $tablaclientes .='</tr>'; 
                $recuento=$recuento+1;
            }mysql_free_result($rs);		
            $tablaclientes .=GLO_fintabla(0,0,$recuento);
            echo $tablaclientes;	
        }else{echo '<p class="MuestraConf" align="center">No existen datos que cumplan esos criterios</p>';}
        //Cierra consulta
        
    } 
}

    
GLO_InitHTML($_SESSION["NivelArbol"],'TxtFechaDCP','BannerConMenuHV','ISOProgramas/zConsulta',0,0,0,0); 
GLO_tituloypath(0,700,'Inicio.php','PROGRAMAS DE ACTIVIDADES','linksalir');
?>

<table width="700" border="0"   cellspacing="0" class="Tabla" >
<tr> <td height="5" width="80"></td><td width="100"></td><td width="80"></td><td width="170"></td><td width="80"></td><td width="170"></td><td width="40"></td></tr>
<tr> <td height="18"  align="right">&nbsp;Fecha:</td><td  >&nbsp;<input name="TxtFechaDCP" type="text"  class="TextBox" style="width:60px" maxlength="4"  value="<? echo $_SESSION[TxtFechaDCP]; ?>" onChange="this.value=validarEntero(this.value);" ></td><td align="right">Sector:</td><td>&nbsp;&nbsp;<select name="CbSector" class="campos" id="CbSector"  style="width:150px" onkeydown="enterxtab(event)"><option value=""></option><? ComboTablaRFX("sector","CbSector","Nombre","","",$conn); ?></select></td><td align="right">Tipo:</td><td>&nbsp;&nbsp;<select name="CbTipo" class="campos" id="CbTipo"  style="width:150px" onkeydown="enterxtab(event)"><option value=""></option><? ComboTablaRFX("programas_tipo","CbTipo","Nombre","","",$conn); ?></select></td><td   align="right" ><? GLO_Search('CmdBuscar',0);?></td></tr>
</table>

<? 
GLO_Hidden('TxtId',0);GLO_Hidden('TxtQISOPROG',0);
GLO_linkbutton(700,'Agregar','ISOProgramas/Alta.php','','','','');
GLO_mensajeerror(); 
PL_MostrarTabla($conn);
GLO_cierratablaform();
mysql_close($conn);
include ("Codigo/FooterConUsuario.php");
?>