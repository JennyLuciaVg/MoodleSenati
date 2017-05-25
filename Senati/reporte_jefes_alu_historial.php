<?PHP
    require_once("../config.php");
    require_once("../course/lib.php");


// VER HISTORIAL DEL ALUMNO	
	$usuario=$USER->id;
	
	if ($usuario=="")
	    {
		Header ("location: http://virtual.senati.edu.pe");
		}

	//$usuario_id debe estar con un valor sino redireccionarlo !!!!!		
	
	//VERIFICO SI ES JEFE DE CENTRO
	$qjefe  ='SELECT jefe_centro, campus_repo from mdl_user where id=' . $usuario;
	$result_jefe=pg_query($qjefe) or die('Query failed 16: ' . pg_last_error());
	
	$roj=pg_fetch_array($result_jefe);
	
	$esjefe=$roj["jefe_centro"];
	$campus_repo=$roj["campus_repo"];
	
	// ACA DEBO RECIBIR EL ID DE UN ALUMNO VIENE DE reporte_jefes_buscalu.php
	
	$id_alumno=$_POST["txh_id_alu"];
	
    if ($esjefe=="s")
{
	
	$site = get_site();

	$query1 = 'SELECT * From mdl_user left join senati_centros on id_centro=campus Where id=' . $id_alumno;
	$result1 = pg_query($query1) or die('Query failed 37: ' . pg_last_error());
	$row1=pg_fetch_array($result1);
	
	$nombre_alumno=$row1["lastname"] . ', '. $row1["firstname"];
	$email_alumno=$row1["email"];
	$campus=$row1["nombre_centro"] . ' ('. $row1["campus"]. ')';
	$pidm=$row1["pidm_banner"];
	
	$titulo_pagina = "Reporte para Jefes de Centro - Historial de un Alumno";
		
	print_header("$site->shortname : ". $titulo_pagina, "X1", $titulo_pagina, "", "", true, "");

$query  ="Select A.*, B.fullname, C.nota, C.estado from mdl_user_Students A ";
$query .="inner join mdl_course B on a.course=B.id ";
$query .="left join senati_actas_notas c on id_alumno=A.userid and id_curso=B.id ";
$query .="where userid=". $id_alumno . " order by A.periodo desc";

$result = pg_query($query) or die('Query failed 50: ' . pg_last_error());




	
//$result = pg_query($query) or die('Query failed 101: ' . pg_last_error());
// Printing results in HTML

?>
<strong style="color:blue"><a href="reporte_jefes.php"><u>Reporte para Jefes de Centro</u></a> - <a href="reporte_jefes_buscalu.php"><u>B&uacute;squeda de Alumnos</u></a> - Historial de un alumno.</strong>
<BR><BR>


<table cellpadding="3" cellspacing="2" border="1" bordercolor=gray>
<TR>
<td colspan=2 bgcolor=silver><strong>DATOS GENERALES</strong></td>
</TR>

<TR>
<td align=right><font color=blue>PIDM SINFO</font></TD>
<td><?PHP echo $pidm ?>&nbsp;</TD>
</TR>

<TR>
<td align=right><font color=blue>Apellidos, Nombres</font></TD>
<td><?PHP echo $nombre_alumno ?>&nbsp;</TD>
</TR>

<TR>
<td align=right><font color=blue>ID de SENATI VIRTUAL</font></TD>
<td><?PHP echo $id_alumno ?>&nbsp;</TD>
</TR>

<TR>
<td align=right><font color=blue>Email</font></TD>
<td><?PHP echo $email_alumno ?>&nbsp;</TD>
</TR>

<TR>
<td align=right><font color=blue>Campus</font></TD>
<td><?PHP echo $campus ?>&nbsp;</TD>
</TR>

</TABLE>

<BR><BR>
<table cellpadding="3" cellspacing="2" border="1" bordercolor=gray>
<TR>
<TD bgcolor=silver><strong>ID Curso</strong></TD>
<TD bgcolor=silver><strong>Curso</strong></TD>
<TD bgcolor=silver><strong>Camp</strong></TD>
<TD bgcolor=silver><strong>NRC</strong></TD>
<TD bgcolor=silver><strong>Periodo</strong></TD>
<TD bgcolor=silver><strong>Bloque</strong></TD>
<TD bgcolor=silver><strong>Semestre</strong></TD>
<TD bgcolor=silver><strong>Carrera</strong></TD>
<TD bgcolor=silver><strong>Status SINFO</strong></TD>
<TD bgcolor=silver><strong>Nota</strong></TD>
<TD bgcolor=silver><strong>Estado</strong></TD>
</TR>

<?PHP

while ($row=pg_fetch_array($result))
{
?>

<TR>
<TD align=center><?PHP echo $row["course"]?></TD>
<TD><?PHP echo $row["fullname"]?></TD>
<TD align=center><?PHP echo $row["camp"]?></TD>
<TD align=center><?PHP echo $row["nrc"]?></TD>
<TD align=center><?PHP echo $row["periodo"]?></TD>
<TD align=center><?PHP echo $row["bloque"]?></TD>
<TD align=center><?PHP echo $row["semestre"]?></TD>
<TD align=center><?PHP echo $row["carr"]?></TD>
<TD align=center><font color=red><?PHP echo $row["status_sinfo"]?></font></TD>
<TD align=right><?PHP echo $row["nota"]?></TD>
<TD align=center><?PHP echo $row["estado"]?></TD>
</TR>
<?PHP
}
?>
</TABLE>


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

</script>
<?PHP
}
else
{
echo "Debe ser Jefe para entrar a esta pagina";
}
?>