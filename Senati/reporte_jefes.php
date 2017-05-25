<?PHP
require_once("../config.php");


// el campo campus_repo tiene los campus separados por comas '60E','60X' etc
// el que es jefe -> jefe-centro : 's'

	$usuario=$USER->id;
	//VERIFICO SI ES JEFE DE CENTRO
	$qjefe  ='SELECT jefe_centro, campus_repo from mdl_user where id=' . $usuario;
	$result_jefe=pg_query($qjefe) or die('Query failed: ' . pg_last_error());
	
	$roj=pg_fetch_array($result_jefe);
	
	$esjefe=$roj["jefe_centro"];
	$campus_repo=$roj["campus_repo"];
	
	// Si $esjefe
	// Si en campus_repo esta vacio significa que es para todos los campus
	// Sino entonces los campus deben estar separados por comas y comillas simples
	
	$ver_cursos="";
    if ($esjefe=="s")
{
	$titulo_pagina = "Reporte para Jefes de Centro";
	$site = get_site();
	print_header("$site->shortname : ". $titulo_pagina, "X1", $titulo_pagina, "", "", true, "");
	
	if ($campus_repo=="")
	   {
		   //TODOS LOS CAMPUS
	       $lista_campus="Todos los campus";
		   
		   $query_campus  ="Select distinct(camp), periodo, nombre_centro ";
		   $query_campus .="from mdl_user_Students ";
		   $query_campus .="inner join senati_centros on camp=id_centro ";
		   $query_campus .="Where periodo is not null ";
		   $query_campus .="order by periodo desc, nombre_centro";
		   
		   $result_campus=pg_query($query_campus) or die('Query failed 46: ' . pg_last_error());
	   }
	else
	   {
       ///LEER LOS CAMPUS ESPECIFICOS
		   $query_campus  ="Select distinct(camp), periodo, nombre_centro ";
		   $query_campus .="from mdl_user_Students ";
		   $query_campus .="inner join senati_centros on camp=id_centro ";
		   $query_campus .="Where periodo is not null ";
		   $query_campus .="and camp in (". $campus_repo . ") ";
		   $query_campus .="order by nombre_centro, periodo desc ";
		   
		   $result_campus=pg_query($query_campus) or die('Query failed 53: ' . pg_last_error());
		   
		   /// LISTA DE CAMPUS
		   $query_listcamp  ="Select distinct(camp), nombre_centro from mdl_user_students ";
		   $query_listcamp .="inner join senati_centros on camp=id_centro ";
		   $query_listcamp .="Where periodo is not null order by nombre_centro ";

		   $result_listcamp=pg_query($query_listcamp) or die('Query failed 60: ' . pg_last_error());
	   }

$accion=$_POST["txh_accion"];
$camp_vc="";
$campus_vc="";
$periodo_vc="";
if ($accion=="ver cursos")
	{
		$camp_vc=$_POST["txh_camp"];
		$periodo_vc=$_POST["txh_periodo"];
		
		//QUERY DE LOS CURSOS
		$sql_cursos ="Select distinct(B.id), fullname from mdl_user_students  A ";
		$sql_cursos .="inner join mdl_course B on A.course=B.id " ;
		$sql_cursos .="where A.periodo='". $periodo_vc."' and camp='". $camp_vc ."' ";
		$sql_cursos .="order by B.id desc ";
		
		
		$sql_cursos ="Select distinct(B.id), fullname, count(*) as alumnos ";
		$sql_cursos .="from mdl_user_students A ";
		$sql_cursos .="inner join mdl_course B on A.course=B.id ";
		$sql_cursos .="where A.periodo='". $periodo_vc."' and camp='". $camp_vc ."' ";
		$sql_cursos .="Group by b.id, fullname ";
		$sql_cursos .="order by B.id desc ";
	
		
		$rs_cursos=pg_query($sql_cursos) or die('Query failed 84: ' . pg_last_error());
		$ver_cursos="si";
	}
$mensaje="";
?>
<strong style="color:blue">Reporte para Jefes de Centro</strong>
<BR>
<form name="thisform" id="thisform" method="post">

<TABLE cellspacing="1" cellpadding="1" border="1">
<tr>
<td><strong>Seleccione un Campus - Periodo</strong></td>
<td>
<SELECT id="sel_camp_periodo" name="sel_camp_periodo">
<?PHP
while($row=pg_fetch_array($result_campus))
	{
	$camp=$row["camp"];
	$periodo=$row["periodo"];
	$campus=$row["nombre_centro"];
	
	if ($camp_vc==$camp && $periodo_vc==$periodo)
	   {$este="selected";}
	else
	   {$este="";}
	
	if ($camp_vc==$camp)
	   {$campus_vc=$campus;}
	
?>	
	<OPTION <?PHP echo $este ?> value="<?PHP echo $camp.'-'. $periodo ?>"><?PHP echo $campus.' - '. $periodo ?></OPTION>
<?PHP	
	}
?>
</SELECT>
</td>
</tr>
</table>
<BR>

<INPUT type="button" value="Ver Cursos" onclick="ver_cursos();">

<BR><BR>

<DIV id=div_reporte>

<?PHP
	if ($ver_cursos=="si")
		{
?>
	<TABLE cellspacing="1" cellpadding="1" border="1">
	<TR>
	<TD colspan=2 bgcolor=silver><strong>REPORTE</strong></TD>
	<TR>
	<TD align=right><strong>CAMP</strong>&nbsp;</TD>
	<TD><?PHP echo $camp_vc ?>&nbsp;</TD>
	</TR>
	<TR>
	<TD align=right><strong>CAMPUS</strong>&nbsp;</TD>
	<TD><?PHP echo $campus_vc ?>&nbsp;</TD>
	</TR>
	<TR>
	<TD align=right><strong>PERIODO</strong>&nbsp;</TD>
	<TD><?PHP echo $periodo_vc ?>&nbsp;</TD>
	</TR>
	</TABLE>
<BR>

<TABLE cellspacing="1" cellpadding="2" border="1">
<tr>
<td bgcolor=silver><strong>ID CURSO</strong></TD>
<td bgcolor=silver><strong>NOMBRE CURSO</strong></TD>
<td bgcolor=silver><strong>Alumnos*</strong></TD>
<td bgcolor=silver><strong>Ver</strong></TD>
<td bgcolor=silver><strong>Ver</strong></TD>
<td bgcolor=silver><strong>Ver</strong></TD>
<td bgcolor=silver><strong>Ver</strong></TD>
</TR>
<?PHP
	while($roc=pg_fetch_array($rs_cursos))
	{
?>
     <TR>
	 <TD align=center><?PHP echo $roc["id"] ?></TD>
	 <TD><?PHP echo $roc["fullname"] ?>&nbsp;</TD>
	 <TD align=right><?PHP echo $roc["alumnos"] ?></TD>
	 <TD align=center><a href="javascript:ver_listado(<?PHP echo $roc["id"] ?>)"><u>Listado</u></a></TD>
	 <TD align=center><a href="javascript:ver_listado_evidencias(<?PHP echo $roc["id"] ?>)"><u>Evidencias</u></a></TD>
	 <TD align=center><a href="javascript:ver_tutores(<?PHP echo $roc["id"] ?>)"><u>Tutores</u></a></TD>
	 <TD align=center><a href="javascript:ver_acta_notas(<?PHP echo $roc["id"] ?>)"><u>Acta de Notas</u></a></TD>
	 </TR>
<?PHP	 
	}
?>	
</TABLE>

<strong>* Es la cantidad de alumnos de ese Campus-Periodo en ese curso</strong>

<?PHP	 
		}
?>	
</DIV>

<div id="div_tutores">

</div>

<input type=hidden name="txh_accion" id="txh_accion" value="">
<input type=hidden name="txh_camp" id="txh_camp" value="<?PHP echo $camp_vc ?>">
<input type=hidden name="txh_periodo" id="txh_periodo" value="<?PHP echo $periodo_vc ?>">
<input type=hidden name="txh_id_curso" id="txh_id_curso" value="">

<BR><BR>
<strong><a href="reporte_jefes_buscalu.php"><u>B&uacute;squeda de Alumnos</u></a></strong>
</form>
<BR />

<?PHP
print_footer();
?>
<script language="javascript">

function obje(ide){
	var obex=document.getElementById(ide);
	return obex;
}

function ver_tutores(id_curso){
	obje("div_tutores").innerHTML="<BR><BR><strong><font color=red>Espere ...</font></strong>";
	url="reporte_listado_tutores_ajax.php";
	var xmlo=crea_xmlhttpPost(url);
		 xmlo.onreadystatechange = function()
		  {
		   if (xmlo.readyState == 4) {
			   update_div_tutores(xmlo.responseText);
			   }
		  }
	qstr="id_curso=" + escape(id_curso);
	xmlo.send(qstr);
}


function update_div_tutores(str){
	obje("div_tutores").innerHTML=str;
}


function crea_xmlhttpPost(url) {
    var xmlHttpReq = false;
    var self = this;
    if (window.XMLHttpRequest) {
        self.xmlHttpReq = new XMLHttpRequest();
    }
    else if (window.ActiveXObject) {
        self.xmlHttpReq = new ActiveXObject("Microsoft.XMLHTTP");
    }
    self.xmlHttpReq.open("POST", url, true);
	self.xmlHttpReq.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
	return self.xmlHttpReq;
}

function ver_acta_notas(id_curso){
	obje("txh_id_curso").value=id_curso;
	var pagina_acta="acta_notas_para_sinfo.php?id_curso_moodle="+id_curso;
	window.navigate(pagina_acta);

}

function ver_listado(id_curso){
	obje("txh_id_curso").value=id_curso;
	obje("thisform").action="reporte_jefes_alu_listado.php";
	obje("thisform").submit();
}


function ver_listado_evidencias(id_curso){
	obje("txh_id_curso").value=id_curso;
	obje("thisform").action="reporte_jefes_alu_listado_evidencias.php";
	obje("thisform").submit();
}

function ver_cursos(){

	obje("div_reporte").innerHTML="";
	obje("div_tutores").innerHTML="";
    obje("div_reporte").innerHTML="<FONT color=red>Procesando, espere ....</FONT>";
	
	var valor=obje("sel_camp_periodo").value;
	var iof=valor.indexOf("-");
	var camp=valor.substring(0, iof);
	var periodo=valor.substring(iof+1);
	
	obje("txh_camp").value=camp;
	obje("txh_periodo").value=periodo;
	obje("txh_accion").value="ver cursos";

	obje("thisform").submit();
}

function resetar(){
	obje("thisform").reset();
}


function comillas() {
	//no acepta comillas simples ni dobles
	wek=window.event.keyCode;
	if (wek==39 || wek==34) {window.event.keyCode=0;}
}

function salvar(){
	obje("th_accion").value="salvar";
	obje("thisform").submit();
}


</script>
<?PHP
}
else
{
echo "Debe ser Jefe para entrar a esta pagina";
}
?>