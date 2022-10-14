<? include($_SESSION["NivelArbol"]."Codigo/Seguridad.php");




function PLA_verimagenplanta(){
	echo '<img src="'.'../Codigo/OpenImage.php?id='.'../Archivos/Fotos/ImagenPlanta.jpg" style="width:80rem;height:auto;border-radius:4px;"></img>';
}


function PLA_puedeingresarcam($idcam,&$iditem,&$iditem2,&$cant,&$existerto,&$idcliprop,&$llevafactor,$conn){
	//trae datos cam
	$iditem=0;$iditem2=0;$cant=0;$llevafactor=0;
	$query="Select a.IdProducto,a2.Cant,a2.CantI,a.IdCliente,a2.IdU as UniBar,p.IdUnidad as UniProd From cam a,procesosop_e1_it a2,items p Where a.Id<>0 and a2.Id=a.IdPE1IT and a.IdProducto=p.Id and a.Id=$idcam";$rs=mysql_query($query,$conn);
	while($row=mysql_fetch_array($rs)){	//cantidad pendiente a ingresar
		$iditem2=$row['IdProducto'];$cant=$row['Cant']-$row['CantI'];$idcliprop=$row['IdCliente'];
		//valido que la unidad coincida
		if($row['UniBar']!=$row['UniProd']){$llevafactor=1;}
	}mysql_free_result($rs);
	//Valida primero que no exista remito con el id de cam, sin items
	$existerto=0;
	//$query="Select a.Id From stockmov a Where a.Id<>0 and a.IdCAM=$idcam";$rs=mysql_query($query,$conn);
	//while($row=mysql_fetch_array($rs)){$existerto=$row['Id'];}mysql_free_result($rs);
}


function PLA_whereinbox(){
	$res='';
	//aceptados y no llevan analisis
	$res=$res." and (a.IdE=2 or a.IdE=4)";
	//deben estar asociados a item barrera para que traiga cantidad
	$res=$res." and a.IdPE1IT<>0";
	//aun tienen cantidad pendiente
	$res=$res." and (a2.Cant-a2.CantI>0)";
	//no fueron ingresados en planta(valida stockmov_item)
	//$res=$res." and a.Id NOT IN (select s.IdCAM from stockmov_items s where s.IdCAM<>0)";
	return $res;
}


?>