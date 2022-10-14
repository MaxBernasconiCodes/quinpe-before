<? 
//seguridad includes
if(!isset($_SESSION)){include("../../Codigo/SeguridadIncludes.php");}
else{include($_SESSION["NivelArbol"]."Codigo/SeguridadIncludes.php");}

//busca pedido de despacho y completa unidad, chofer e items

if($tipocompletar=='unidad'){//antes de insertar barrera
    if($tipo==1){
        //completa unidad y chofer si chofer coincide despacho con barrera
        $query="SELECT d.*  From despacho_p d,despacho a where a.Id=d.IdPadre and d.IdChofer=$per and a.IdPadre=$idpadre Order by d.Id LIMIT 1";
        $rs=mysql_query($query,$conn);$row=mysql_fetch_array($rs);
        if(mysql_num_rows($rs)!=0){
            $uni=$row['IdUnidad'];
            $uni2=$row['IdSemi'];
        }else{$uni=0;$uni2=0;}
        mysql_free_result($rs);
    }

    //camion terceros
    if($tipo==2){
        //completa unidad y chofer
        $query="SELECT d.*  From despacho_t d,despacho a where a.Id=d.IdPadre and DNI='$doc' and a.IdPadre=$idpadre Order by d.Id LIMIT 1";
        $rs=mysql_query($query,$conn);$row=mysql_fetch_array($rs);
        if(mysql_num_rows($rs)!=0){
            $cho=$row['Chofer'];
            $dom=$row['Dominio'];
            $dom2=$row['Dominio2'];
        }else{$cho='';$dom='';$dom2='';}
        mysql_free_result($rs);
        //busco ultimo registros barrera chofer
        if($doc!=''){
            $query="SELECT Chofer,Sedro,ChkC1,ChkC2,FC1,FC2 FROM procesosop_e1 Where DNI='$doc' and DNI<>'' and Id<>$id Order by Id desc LIMIT 1";
            $rs=mysql_query($query,$conn);
            $row=mysql_fetch_array($rs);if(mysql_num_rows($rs)!=0){
                if($cho==''){$cho=$row['Chofer'];}
                $sedro = $row['Sedro'];
                $chkc1 = $row['ChkC1'];$chkc2= $row['ChkC2'];
                $fc1=$row['FC1'];$fc2 =$row['FC2'];
            }else{$sedro='';$chkc1=0;$chkc2=0;$fc1=$fv;$fc2=$fv;}
            mysql_free_result($rs);
        }
        //busco ultimo registros barrera dom1
        if($dom!=''){
            $query="SELECT * FROM procesosop_e1 Where Dominio='$dom' and Dominio<>'' Order by Id desc LIMIT 1";
            $rs=mysql_query($query,$conn);
            $row=mysql_fetch_array($rs);if(mysql_num_rows($rs)!=0){
                $mar = $row['IdMarca'];
                $cat = $row['IdCateg'];
                $mod = $row['Modelo'];
                $chku1 = $row['ChkU1'];$chku2 = $row['ChkU2'];$chku3 = $row['ChkU3'];
                $fu1 =$row['FU1'];$fu2 =$row['FU2']; $fu3 =$row['FU3'];
            }else{$mar=0;$cat=0;$mod='';$chku1=0;$chku2=0;$chku3=0;$fu1=$fv;$fu2=$fv;$fu3=$fv;}
            mysql_free_result($rs);
            }
        //busco ultimo registros barrera dom1
        if($dom2!=''){
            $query="SELECT * FROM procesosop_e1 Where Dominio2='$dom2' and Dominio2<>'' Order by Id desc LIMIT 1";
            $rs=mysql_query($query,$conn);
            $row=mysql_fetch_array($rs);if(mysql_num_rows($rs)!=0){
                $mar2 = $row['IdMarca2'];
                $cat2 = $row['IdCateg2'];
                $mod2 = $row['Modelo2'];
                $chks1 = $row['ChkS1'];$chks2 = $row['ChkS2'];$chks3= $row['ChkS3'];
                $fs1=$row['FS1'];$fs2 =$row['FS2'];$fs3 =$row['FS3'];
            }else{$mar2=0;$cat2=0;$mod2='';$chks1=0;$chks2=0;$chks3=0;$fs1=$fv;$fs2=$fv;$fs3=$fv;}
            mysql_free_result($rs);
        }
    }
}


//completa items
if($tipocompletar=='items'){//despues de insertar barrera
    $query="SELECT m.* From despacho_it m,despacho a where a.Id=m.IdPadre and a.IdPadre=$idpadre";//$idpadre es la solicitud
    $rs=mysql_query($query,$conn);
    while($row=mysql_fetch_array($rs)){
        $nroIditem=GLO_generoID("procesosop_e1_it",$conn);
        $query="INSERT INTO procesosop_e1_it (Id,IdPadre,IdIC,IdU,Cant,Lote,IdEnv,CantI,Bultos,Destino) VALUES ($nroIditem,$nroId,".$row['IdIC'].",".$row['IdU'].",".$row['Cant'].",'".$row['Lote']."',".$row['IdEnv'].",0,".$row['Bultos'].",'".$row['Destino']."')";$rs2=mysql_query($query,$conn);
    }mysql_free_result($rs);
}


?>