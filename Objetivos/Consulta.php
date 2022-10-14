<? include("../Codigo/Seguridad.php") ;include("../Codigo/Config.php") ;include("../Codigo/Funciones.php") ;$_SESSION["NivelArbol"]="../";
include("zFunciones.php");
//perfiles
if ($_SESSION["IdPerfilUser"]!=1 and $_SESSION["IdPerfilUser"]!=2){ header("Location:".$_SESSION["NivelArbol"]."Inicio.php");}
//get
if(intval($_GET['ido'])==0 or intval($_GET['ido'])>5){ header("Location:".$_SESSION["NivelArbol"]."Inicio.php");}


$_SESSION['TxtNroEntidad'] = intval($_GET['ido']);//me dice que objetivo voy a modificar

$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);


function MostrarTabla($idobjetivo,$conn){
    $tablaobj=OBJ_tabla($idobjetivo);
    //busca
	$query="SELECT c.* From $tablaobj c where c.Id<>0 Order by c.Anio DESC";$rs=mysql_query($query,$conn);	
    if(mysql_num_rows($rs)!=0){	
        //Marco de la tabla	
        $tablaclientes='';	
        $tablaclientes .=GLO_inittabla(700,1,0,0);
        $tablaclientes .="<td "."width="."70"." class="."TableShowT"."> A&ntilde;o</td>"; 
        $tablaclientes .="<td "."width="."200"." class="."TableShowT"."> Objetivo</td>"; 
        $tablaclientes .="<td "."width="."400"." class="."TableShowT"."> Detalle</td>"; 
        $tablaclientes .="<td "."width="."70"." class="."TableShowT"."> Actualizacion</td>";  
        $tablaclientes .="<td "."width="."30"." class="."TableShowT"."> </td>"; 
        $tablaclientes .='</tr>';    
        $recuento=0;$estilo=" style='cursor:pointer;' ";      
        while($row=mysql_fetch_array($rs)){
            $link=" onclick="."location='Modificar.php?id=".$row['Id']."&ido=".$idobjetivo."&Flag1=True'";
            //
            $tablaclientes .='<tr '.$estilo.GLO_highlight($row['Id']).'>';
            $tablaclientes .="<td class="."TableShowD ".$link."> ".$row['Anio']."</td>";  
            $tablaclientes .="<td class="."TableShowD ".$link."> ".substr($row['Titulo'],0,24)."</td>"; 
            $tablaclientes .="<td class="."TableShowD ".$link."> ".substr($row['Nombre'],0,50)."</td>";  
            $tablaclientes .="<td class="."TableShowD ".$link."> ".GLO_FormatoFecha($row['Fecha'])."</td>";  
            $tablaclientes .='<td class="TableShowD TAC">'.GLO_rowbutton("CmdBorrarFila",$row['Id'],"Eliminar",'self','trash','iconlgray','Eliminar',1,0,0);  					
            $tablaclientes .="</tr>";  
            $recuento=$recuento+1;
        }mysql_free_result($rs);		
        $tablaclientes .=GLO_fintabla(0,0,$recuento);
        echo $tablaclientes;	
    }else{echo '<p class="MuestraConf" align="center">No existen datos que cumplan esos criterios</p>';}
}
    

GLOF_Init('','BannerConMenuHV','zConsulta',0,'',0,0,0); 
GLO_tituloypath(0,700,'',OBJ_titulo($_SESSION['TxtNroEntidad']),'basica');

GLO_Hidden('TxtId',0);GLO_Hidden('TxtNroEntidad',0);

GLO_mensajeerror(); 
MostrarTabla(intval($_SESSION['TxtNroEntidad']),$conn);
GLO_cierratablaform();
mysql_close($conn);
include ("../Codigo/FooterConUsuario.php");
?>