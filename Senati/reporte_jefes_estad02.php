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
	$titulo_pagina = "Reporte para Jefes de Centro - Alumnos por Campus-Periodo";
	
	
	$site = get_site();
	print_header("$site->shortname : ". $titulo_pagina, "X1", $titulo_pagina, "", "", true, "");
	
	$camp_vc="60A";
	
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

		   $result_listcamp=pg_query($query_listcamp) or die('Query failed 65: ' . pg_last_error());
	   }

$sql_peris="Select distinct(periodo) from mdl_user_students Where periodo is not null order by 1 desc";
$res_peris=pg_query($sql_peris) or die('Query failed 70: ' . pg_last_error());
  
$periodo_select=$_POST["sel_periodo"];	   

if ($periodo_select=="")
   {$ver_repo="no";}
else
   {$ver_repo="si";}



$sql_alu_campus ="Select A.camp, nombre_centro,nombre_zonal, count(distinct(a.userid)) as totalu from mdl_user_students A "; 
$sql_alu_campus .="inner join mdl_course B on B.id=A.course "; 
$sql_alu_campus .="inner join senati_rela_cursos_cursos C on C.id_course_moodle=A.course "; 
$sql_alu_campus .="inner join mdl_user D on A.userid=D.id "; 
$sql_alu_campus .="inner join senati_cursos E on E.id_curso=C.id_curso_senati "; 
$sql_alu_campus .="left join senati_centros F on F.id_centro=A.camp "; 
$sql_alu_campus .="left join senati_zonales G on G.id_zonal=F.id_zonax "; 
$sql_alu_campus .="where A.periodo='". $periodo_select ."' and C.id_curso_senati<>21 and status_sinfo is Null and A.camp is not null "; 
$sql_alu_campus .="group by a.camp, nombre_centro,nombre_zonal "; 
$sql_alu_campus .="order by 3 asc "; 
   
$rs_alu_campus=pg_query($sql_alu_campus) or die('Query failed 88: ' . pg_last_error());

$accion=$_POST["txh_accion"];

$mensaje="";
?>
<strong style="color:blue"><a href="reporte_jefes.php"><u>Reporte para Jefes de Centro</u></a> &gt; Alumnos por Campus-Zonal x Per&iacute;odo</strong>
<BR>
<form name="thisform" id="thisform" method="post">

<TABLE cellspacing="1" cellpadding="1" border="1">
<tr>
<td><strong>Seleccione un Periodo</strong></td>
<td>
<SELECT id="sel_periodo" name="sel_periodo">
<?PHP
while($roc=pg_fetch_array($res_peris))
	{
	$perlista=$roc["periodo"];
	
	if ($perlista==$periodo_select)
	   {$este="selected";}
	else
	   {$este="";}
?>	
	<OPTION <?PHP echo $este ?> value="<?PHP echo $perlista ?>"><?PHP echo $perlista ?></OPTION>
<?PHP	
	}
?>
</SELECT>
&nbsp;
</td>

<td>&nbsp;<INPUT type="submit" value="Ver Reporte">&nbsp;</td>
</tr>
</table>
<BR>
<BR>

<DIV id="div_reporte">

<?PHP
	if ($ver_repo=="si")
		{
		$total_general=0;
?>
	<TABLE cellspacing="1" cellpadding="1" border="1">
	<TR>
	<TD colspan=2 bgcolor=silver><strong>REPORTE</strong></TD>
	<TR>
	<TD align=right><strong>PERIODO</strong>&nbsp;</TD>
	<TD><?PHP echo $periodo_select ?>&nbsp;</TD>
	</TR>
	</TABLE>
<BR>

<TABLE cellspacing="1" cellpadding="2" border="1" bordercolor="gray">
<tr>
<td bgcolor=silver><strong>N&deg;</strong></TD>
<td bgcolor=silver><strong>Campus</strong></TD>
<td bgcolor=silver><strong>Camp</strong></TD>
<td bgcolor=silver><strong>Zonal</strong></TD>
<td bgcolor=silver><strong>Alumnos Distintos</strong></TD>

</TR>
<?PHP
    $sx=0;
	$total_general=0;
	while($roc=pg_fetch_array($rs_alu_campus))
	{
	$sx++;
	$total_general=$total_general+1-1+$roc["totalu"];
	

?>
     <TR>
	 <TD align=right><?PHP echo $sx ?></TD>
	 <TD><?PHP echo $roc["nombre_centro"] ?>&nbsp;</TD>
	 <TD align=center><?PHP echo $roc["camp"] ?>&nbsp;</TD>
	 <TD><?PHP echo $roc["nombre_zonal"] ?>&nbsp;</TD>
	 <TD align=right><?PHP echo $roc["totalu"] ?></TD>

	 </TR>
<?PHP	 
	}
?>
<tr>
<td colspan="4" align=right><strong>TOTAL</strong>&nbsp;</TD>
<td align=right><strong><?PHP echo $total_general ?></strong></TD>
</TR>
</TABLE>

<?PHP	 
	}
?>	
</DIV>



<input type=hidden name="txh_accion" id="txh_accion" value="">
<input type=hidden name="txh_periodo" id="txh_periodo" value="<?PHP echo $periodo_select?>">

<BR><BR>
<strong>M&aacute;s Reportes ...</strong>

<UL>
<LI><strong><a href="reporte_jefes_buscalu.php"><u>B&uacute;squeda de Alumnos</u></a></strong></LI><BR><BR>
<LI><strong><a href="reporte_jefes_estad01.php"><u>Alumnos-Curso x Per&iacute;odo</u></a></strong></LI>
</UL>
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

function ver_acta_notas(id_curso, campx){
	var pagina_acta="acta_notas_para_sinfo.php?curso="+id_curso + "&camp=" + campx;
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