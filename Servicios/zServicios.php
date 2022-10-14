<? include("../Codigo/Seguridad.php") ;include("../Codigo/Config.php");include("../Codigo/Funciones.php");$_SESSION["NivelArbol"]="../";
//perfiles
if ($_SESSION["IdPerfilUser"]!=1 and $_SESSION["IdPerfilUser"]!=2   and $_SESSION["IdPerfilUser"]!=3  and  $_SESSION["IdPerfilUser"]!=9 and $_SESSION["IdPerfilUser"]!=14){ header("Location:".$_SESSION["NivelArbol"]."Inicio.php");}


if (isset($_POST['CmdBuscar'])){
	foreach($_POST as $key => $value){$_SESSION[$key] = $value;}
	$serv=intval($_POST['CbServicio']);if($serv!=0){$wserv="and s.IdTipo=$serv";}else{$wserv='';}
	$cli=intval($_POST['CbCliente']);if($cli!=0){$wcli="and s.IdCliente=$cli";}else{$wcli='';}
	$activo=intval($_POST['ChkActivo']);if($activo!=0){$wactivo="and s.FechaBaja='0000-00-00'";}else{$wactivo='';}
	//
	$_SESSION['TxtQSERV']="SELECT s.*, c.Nombre as Cli,s1.Nombre as LA From servicios s,clientes c,serviciostipo1 s1 where s.IdCliente=c.Id and s1.Id=s.IdTipo and s.Id<>0 $wserv $wcli $wactivo $wtipos Order by s.FechaBaja,c.Nombre,s1.Nombre";
	//vista detallada solo activos
	$_SESSION['TxtQSERV2']="SELECT s.*,c.Nombre as Cli,s1.Nombre as LA,i.Nombre as Item,s2.Nombre as LB,sib.Cod From servicios s,clientes c,serviciostipo1 s1,itemscliente_serv si, items i, itemscliente_serv_b sib,serviciostipo s2 where s.IdCliente=c.Id and s1.Id=s.IdTipo and si.IdPadre=s.Id and si.IdItem=i.Id and sib.IdLB=s2.Id and sib.IdPadre=si.Id and s.Id<>0 and sib.Id<>0 and s.FechaBaja='0000-00-00' $wserv $wcli $wactivo $wtipos Order by c.Nombre,s1.Nombre,i.Nombre,s2.Nombre";
	//volver
	header("Location:../Servicios.php");
}




if (isset($_POST['CmdBorrarFila'])){
	$query="Delete From servicios Where Id=".intval($_POST['TxtId']);
	$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);$rs=mysql_query($query,$conn);
	if ($rs){GLO_feedback(1);}else{GLO_feedback(2);} 
	mysql_close($conn); 
	header("Location:../Servicios.php");
}

if (isset($_POST['CmdExcel'])){
	$query=$_POST['TxtQSERV'];$query=str_replace("\\", "", $query);
	if ($query!=""){
		$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);$rs=mysql_query($query,$conn);
		if(mysql_num_rows($rs)!=0){	
			include("../Codigo/ExcelHeader.php");
			include("../Codigo/ExcelStyle.php");			
			echo "<th>Cliente</th>\n";
			echo "<th >LA</th>\n";
			echo "<th >Baja</th>\n";
			echo "</tr>\n";				
			while($row=mysql_fetch_array($rs)){ 
				$fbaja= FormatoFecha($row['FechaBaja']);if ($fbaja=='00-00-0000'){$fbaja="";}
				echo "<tr>\n";				
				echo '<td>'.GLO_textoExcel($row['Cli'])."</td>\n";				
				echo '<td>'.GLO_textoExcel($row['LA'])."</td>\n";
				echo '<td>'.$fbaja."</td>\n";
				echo "</tr>\n";		
			}	
			echo "</table>\n";	
		}	
		mysql_free_result($rs);	mysql_close($conn); 
	}

 }


?>

