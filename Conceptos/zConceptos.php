<? include("../Codigo/Seguridad.php") ;$_SESSION["NivelArbol"]="../";include("../Codigo/Config.php");include("../Codigo/Funciones.php");
//perfiles
if ($_SESSION["IdPerfilUser"]!=1 and $_SESSION["IdPerfilUser"]!=2   and $_SESSION["IdPerfilUser"]!=3  and  $_SESSION["IdPerfilUser"]!=9 and $_SESSION["IdPerfilUser"]!=14){ header("Location:".$_SESSION["NivelArbol"]."Inicio.php");}


if (isset($_POST['CmdBuscar'])){	
	foreach($_POST as $key => $value){$_SESSION[$key] = $value;}
	//nombre
	if ((empty($_POST['TxtBusquedaN']))){$wnom="";}	else{
		$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);
		$wnom="and (c.Nombre Like '%".mysql_real_escape_string($_POST['TxtBusquedaN'])."%')";
		mysql_close($conn); 
	}
	$activo=intval($_POST['ChkActivo']);if($activo!=0){$wactivo="and c.Inactivo=0";}else{$wactivo='';}	
	$tipo=intval($_POST['CbTipo']);if($tipo!=99){$wtipo="and c.Tipo=$tipo";}else{$wtipo='';}	
	//query
	$_SESSION['TxtQIT']="SELECT c.*,u.Abr From items c,unidadesmedida u where c.Id<>0 and c.IdUnidad=u.Id $wnom $wactivo $wtipo Order by c.Inactivo,c.Nombre";
	//
	header("Location:../Conceptos.php");
}

if (isset($_POST['CmdBorrarFila'])){
	$query="Delete From items Where Id=".intval($_POST['TxtId']);
	$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);$rs=mysql_query($query,$conn);
	if ($rs){GLO_feedback(1);}else{GLO_feedback(2);} 
	mysql_close($conn); 
	header("Location:../Conceptos.php"); 	
}

if (isset($_POST['CmdExcel'])){//exporta items existentes
	$query="SELECT * From items where Id<>0 Order by Inactivo,Nombre";
	if ($query!=""){
		$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);$rs=mysql_query($query,$conn);
		if(mysql_num_rows($rs)!=0){	
			include("../Codigo/ExcelHeader.php");
			include("../Codigo/ExcelStyle.php");
			echo "<th>Numero</th>\n";
			echo "<th>Nombre</th>\n";
			echo "<th>Estado</th>\n";
			echo "</tr>\n";	
			while($row=mysql_fetch_array($rs)){ 
				if ($row['Inactivo']==0){$inac="";$color='';}else{$inac="Inactivo";$color=' style="color:#f44336"';}
				echo "<tr>\n";
				echo '<td>'.$row['Id']."</td>\n";
				echo '<td>'.GLO_textoExcel($row['Nombre'])."</td>\n";
				echo "<td ".$color.">".$inac."</td>\n";
				echo "</tr>\n";		
			}	
			echo "</table>\n";	
		}	
		mysql_free_result($rs);	mysql_close($conn); 
	}
 }

?>