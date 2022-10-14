<? include("../Codigo/Seguridad.php");include("../Codigo/Config.php");include("../Codigo/Funciones.php");$_SESSION["NivelArbol"]="../";

//perfiles

if ($_SESSION["IdPerfilUser"]!=1 and $_SESSION["IdPerfilUser"]!=2 and $_SESSION["IdPerfilUser"]!=3 and $_SESSION["IdPerfilUser"]!=9 and $_SESSION["IdPerfilUser"]!=14 ){ header("Location:".$_SESSION["NivelArbol"]."Inicio.php");}



$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);



$_SESSION['TxtNroEntidad']=$_GET['Id'];//id pssa







function MostrarTabla($conn){

$idpssa=$_SESSION['TxtNroEntidad'];

//actividades que no est&eacute;n asociadas a esta pssa

$query="SELECT a.*,t.Nombre as Tipo,f.Nombre as Frec,r.Nombre as Resp From pssa_act a,pssa_tipo t,pssa_frec f, pssa_resp r where a.Id<>0 and a.IdTipo=t.Id and a.IdFrec=f.Id and a.IdResp=r.Id and a.Id NOT IN(Select x.IdAct From pssa_items x Where x.IdPssa=$idpssa) Order by t.Nombre,f.Nombre,a.Nombre";$rs=mysql_query($query,$conn);

//muestro tabla

if(mysql_num_rows($rs)!=0){

	//boton guardar

	$tablaclientes='';

	$tablaclientes .="<table width="."850"." border="."0"." cellspacing="."0"." cellpadding="."0"." ></tr><tr><td "."height="."3"."></td></tr><tr><td class="."recuento".">Seleccione el Item y luego grabe. </td><td align="."right".">".GLO_FAButton('CmdGuardar','submit','80','self','Guardar','save','boton02')."</td></tr><tr><td "."height="."3"."></td></tr></table>";

	//Titulos de la tabla

	$tablaclientes .=GLO_inittabla(850,1,0,0);

	$tablaclientes .="<td "."width="."60"." class="."TableShowT"." style='text-align:right;'> N&uacute;mero</td>";  

	$tablaclientes .="<td "."width="."100"." class="."TableShowT".">Tipo</td>";   

	$tablaclientes .="<td "."width="."440"." class="."TableShowT".">Actividad</td>";   

	$tablaclientes .="<td "."width="."110"." class="."TableShowT"."> Frecuencia</td>"; 

	$tablaclientes .="<td "."width="."110"." class="."TableShowT"."> Responsable</td>"; 

	$tablaclientes .='<td width="30" class="TableShowT TAC"><input type="checkbox" name="ChkAll" onclick="CheckMasivoColor();"></td>'; 

	$tablaclientes .='</tr>';             

	$recuento=0;  

	while($row=mysql_fetch_array($rs)){ 

		$tablaclientes .='<tr id="'.$row['Id'].'" >'; 

		$tablaclientes .="<td class="."TableShowD"." style='text-align:right;'> ".str_pad($row['Id'], 6, "0", STR_PAD_LEFT)."</td>"; 

		$tablaclientes .="<td class="."TableShowD"."> ".substr($row['Tipo'],0,15)."</td>"; 	

		$tablaclientes .="<td class="."TableShowD"."> ".substr($row['Nombre'],0,80)."</td>"; 

		$tablaclientes .="<td class="."TableShowD"."> ".substr($row['Frec'],0,15)."</td>"; 

		$tablaclientes .="<td class="."TableShowD"."> ".substr($row['Resp'],0,15)."</td>";  

		$tablaclientes .='<td class="TableShowD TAC"><input type="checkbox" name="campos['.$row['Id'].']" unchecked value=0 onclick="if (this.checked==1) {this.value=1;}else{this.value=0;};" onChange="CheckRow('.$row['Id'].',this.value);"></td>'; 

		$tablaclientes .='</tr>';

		$recuento=$recuento+1;

	}

	$tablaclientes .=GLO_fintabla(0,0,$recuento);

	echo $tablaclientes;	

}mysql_free_result($rs);	

}





GLOF_Init('','BannerPopUp','zAltaD',0,'',0,0,0);

GLO_tituloypath(950,850,'pssa','ACTIVIDADES','salir');



MostrarTabla($conn);

GLO_Hidden('TxtNroEntidad',0);

GLO_mensajeerror();

mysql_close($conn); 

$_SESSION['TxtNroEntidad']="";

GLO_cierratablaform();

include ("../Codigo/FooterConUsuario.php");

?>