<? include("../Codigo/Seguridad.php");include("../Codigo/Config.php");include("../Codigo/Funciones.php");$_SESSION["NivelArbol"]="../";
//perfiles
if ($_SESSION["IdPerfilUser"]!=1 and $_SESSION["IdPerfilUser"]!=2 and $_SESSION["IdPerfilUser"]!=3 and $_SESSION["IdPerfilUser"]!=9 and $_SESSION["IdPerfilUser"]!=14 ){ header("Location:".$_SESSION["NivelArbol"]."Inicio.php");}



if (isset($_POST['CmdAgregar'])){	header("Location:Alta.php");}

if (isset($_POST['CmdBorrarFila'])){
	$query="Delete From pssa_act Where Id=".intval($_POST['TxtId']);
	$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);$rs=mysql_query($query,$conn);
	if ($rs){GLO_feedback(1);}else{GLO_feedback(2);} 
	mysql_close($conn); 
	header("Location:../PSSAAct.php"); 	
}

if (isset($_POST['CmdSalir'])){
	foreach($_POST as $key => $value){$_SESSION[$key] = '';}
	header("Location:../PSSA/Tablas.php");
}

if (isset($_POST['CmdExcel'])){
$query="SELECT a.*,t.Nombre as Tipo,f.Nombre as Frec,r.Nombre as Resp From pssa_act a,pssa_tipo t,pssa_frec f, pssa_resp r where a.Id<>0 and a.IdTipo=t.Id and a.IdFrec=f.Id and a.IdResp=r.Id  Order by t.Nombre,f.Nombre,a.Nombre";
	if ($query!=""){
		$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);$rs=mysql_query($query,$conn);
		if(mysql_num_rows($rs)!=0){	
			include("../Codigo/ExcelHeader.php");
			include("../Codigo/ExcelStyle.php");
			echo "<th>N&uacute;mero</th>\n";
			echo "<th>Tipo</th>\n";
			echo "<th>Actividad</th>\n";			
			echo "<th>Frecuencia</th>\n";			
			echo "<th>Responsable</th>\n";
			echo "</tr>\n";				
			while($row=mysql_fetch_array($rs)){ 
				echo "<tr>\n";
				echo '<td>'.$row['Id']."</td>\n";
				echo '<td>'.$row['Tipo']."</td>\n";
				echo '<td>'.GLO_textoExcel($row['Nombre'])."</td>\n";				
				echo '<td>'.GLO_textoExcel($row['Frec'])."</td>\n";
				echo '<td>'.GLO_textoExcel($row['Resp'])."</td>\n";
				echo "</tr>\n";		
			}	
			echo "</table>\n";	
		}	
		mysql_free_result($rs);	mysql_close($conn); 
	}

 }




?>