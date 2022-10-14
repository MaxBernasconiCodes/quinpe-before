<? if ($_SESSION["IdPerfilUser"]!=1 and $_SESSION["IdPerfilUser"]!=2   and $_SESSION["IdPerfilUser"]!=3  and  $_SESSION["IdPerfilUser"]!=9 and $_SESSION["IdPerfilUser"]!=14){ header("Location:".$_SESSION["NivelArbol"]."Inicio.php");}


function SERV_MostrarTabla2($conn){
$query=$_SESSION['TxtQSERV2'];$query=str_replace("\\", "", $query);
if (  ($query!="")){
	$rs=mysql_query($query,$conn);
	//Titulos de la tabla
	$tablaclientes='';
	$tablaclientes .=GLO_inittabla(800,1,0,0);
	$tablaclientes .="<td "."width="."200"." class="."TableShowT"."> Cliente</td>";   
	$tablaclientes .="<td "."width="."150"." class="."TableShowT"."> Linea A</td>";  
	$tablaclientes .="<td "."width="."150"." class="."TableShowT"."> Linea B</td>"; 
	$tablaclientes .="<td "."width="."50"." class="."TableShowT"."> Codigo</td>"; 
	$tablaclientes .="<td "."width="."250"." class="."TableShowT"."> Item</td>"; 
	$tablaclientes .='</tr>';             
	$estilo="";$link="";
	while($row=mysql_fetch_array($rs)){ 			
		$fbaja= GLO_FormatoFecha($row['FechaBaja']);if ($fbaja==''){$clase="";}else{$clase=" TGray";}
		$tablaclientes .='<tr>';
		$tablaclientes .='<td class="TableShowD'.$clase.'"'.$link."> ".substr($row['Cli'],0,24)."</td>";  
		$tablaclientes .='<td class="TableShowD'.$clase.'"'.$link."> ".substr($row['LA'],0,18)."</td>"; 
		$tablaclientes .='<td class="TableShowD'.$clase.'"'.$link."> ".substr($row['LB'],0,18)."</td>"; 
		$tablaclientes .='<td class="TableShowD'.$clase.'"'.$link."> ".substr($row['Cod'],0,2)."</td>"; 
		$tablaclientes .='<td class="TableShowD'.$clase.'"'.$link."> ".substr($row['Item'],0,30)."</td>"; 
		$tablaclientes .='</tr>';

	}mysql_free_result($rs);
	$tablaclientes .=GLO_fintabla(0,0,0);
	echo $tablaclientes;	
}
}




function SERV_MostrarTabla($conn){
$query=$_SESSION['TxtQSERV'];$query=str_replace("\\", "", $query);
if (  ($query!="")){
	$rs=mysql_query($query,$conn);
	//Titulos de la tabla
	$tablaclientes='';
	$tablaclientes .=GLO_inittabla(800,1,0,0);
	$tablaclientes .="<td "."width="."450"." class="."TableShowT"."> Cliente</td>";   
	$tablaclientes .="<td "."width="."320"." class="."TableShowT"."> Linea A</td>";  
	$tablaclientes .="<td width="."30"." class="."TableShowT"."> </td>"; 
	$tablaclientes .='</tr>';             
	$recuento=0; $estilo=" style='cursor:pointer;' ";
	while($row=mysql_fetch_array($rs)){ 		
		$link=" onclick="."location='Servicios/Modificar.php?id=".$row['Id']."'";
		$fbaja= GLO_FormatoFecha($row['FechaBaja']);if ($fbaja==''){$clase="";}else{$clase=" TGray";}
		$tablaclientes .='<tr '.$estilo.GLO_highlight($row['Id']).'>';
		$tablaclientes .='<td class="TableShowD'.$clase.'"'.$link."> ".substr($row['Cli'],0,50)."</td>";  
		$tablaclientes .='<td class="TableShowD'.$clase.'"'.$link."> ".substr($row['LA'],0,35)."</td>"; 
		$tablaclientes .="<td class="."TableShowD"." style='text-align:center;'>".GLO_rowbutton("CmdBorrarFila",$row['Id'],"Eliminar",'self','trash','iconlgray','Eliminar',1,0,0)."</td>";  
		$tablaclientes .='</tr>';
		$recuento=$recuento+1;	 
	}mysql_free_result($rs);
	$tablaclientes .=GLO_fintabla(1,0,$recuento);
	echo $tablaclientes;	
}
}

?>