<?PHP
    require_once("../config.php");
    require_once("lib.php");


	$id_curso_moodle=$_GET["id"];
	
	//Listado en modo EXCEL PARA TUTORES

	$id_usuario=$USER->id;
	
	
    if (isteacher($id_curso_moodle) || isadmin())
	{
	$site = get_site();
	
	$id_curso_moodle=$_GET["id"];
	
	if ($id_curso_moodle=="")
	   {$id_curso_moodle=$_POST["id_curso_moodle"];}

	//NOMBRE DEL CURSO   
	$query0  = "Select fullname from mdl_course where id=". $id_curso_moodle;
	$result0 = pg_query($query0) or die('Query failed: ' . pg_last_error());
	$roxy=pg_fetch_array($result0); 
	$nombre_moodle=$roxy["fullname"];
	   
	   

	$accion=$_POST["txh_accion"];
	$mensaje="";
	
	/// TODOS LOS GRUPOS Y SUS TUTORES
	$query_all_groups  = "Select A.id as id_grupo, A.name as nombre_grupo, A.num_grupo as grupo_numerico, B.userid, firstname, lastname, pidm_banner from mdl_groups A ";
	$query_all_groups .= "inner join mdl_groups_members B on A.id=B.groupid ";
	$query_all_groups .= "inner join mdl_user D on D.id=B.userid ";
	$query_all_groups .= "where B.userid in( ";
	$query_all_groups .= "Select C.userid from mdl_user_teachers C where C.course=A.courseid) ";
	$query_all_groups .= "and A.courseid=". $id_curso_moodle. " ";
	$query_all_groups .= "order by B.userid, A.name ";
	
	$result_all_groups =pg_query($query_all_groups) or die('Query failed: ' . pg_last_error());	
	
	
	// USUARIO ACTUAL
	$query_user="select firstname, lastname, pidm_banner, id from mdl_user where id=". $id_usuario;
	$result_user =pg_query($query_user) or die('Query failed: ' . pg_last_error());
	$row_user=pg_fetch_array($result_user);
	
	$nombre_usuario=$row_user["firstname"] . ", ". $row_user["lastname"];
	
	
	//// LISTA DE ALUMNOS SOLO DEL TUTOR
	if (!isadmin())
		{
		///
		$query_alus_tutor  ="Select * from ";
		$query_alus_tutor .="(SELECT ";
		$query_alus_tutor .="A.userid as alu_id_sv, ";
		$query_alus_tutor .="A.status_sinfo, ";
		$query_alus_tutor .="B.pidm_banner as alu_pidm, "; 
		$query_alus_tutor .="B.lastname as apellidos_alumno, ";
		$query_alus_tutor .="B.firstname as nombres_alumno, ";
		$query_alus_tutor .="B.email as email_alumno, ";
		$query_alus_tutor .="A.bloque, ";
		$query_alus_tutor .="(Select C.name From mdl_groups C inner join mdl_groups_members D on D.groupid=C.id and D.userid=A.userid where C.courseid=A.course LIMIT 1) as nombre_grupo, ";
		$query_alus_tutor .="(Select X.id From mdl_groups X inner join mdl_groups_members J on J.groupid=X.id and J.userid=A.userid where X.courseid=A.course LIMIT 1) as id_grupo, ";
		$query_alus_tutor .="(Select E.userid from mdl_groups_members E ";
 		$query_alus_tutor .="inner join mdl_user_teachers F on F.userid=E.userid and E.groupid=(Select M.id From mdl_groups M inner join mdl_groups_members P on P.groupid=M.id and P.userid=A.userid where M.courseid=A.course LIMIT 1) ";
 		$query_alus_tutor .="where F.course=A.course ";
 		$query_alus_tutor .="LIMIT 1) as id_tutor, ";
		$query_alus_tutor .="(Select G.num_grupo From mdl_groups G inner join mdl_groups_members H on H.groupid=G.id and H.userid=A.userid where G.courseid=A.course LIMIT 1) as grupo_numerico ";
		$query_alus_tutor .="From mdl_user_students A ";
		$query_alus_tutor .="left join mdl_user B on A.userid=B.id "; 
		$query_alus_tutor .="Where A.course=". $id_curso_moodle. ") as consultax ";
		$query_alus_tutor .="where id_tutor=". $id_usuario ." order by status_sinfo, nombre_grupo, bloque, apellidos_alumno ";

		$result_alus_tutor =pg_query($query_alus_tutor) or die('Query failed 74: ' . pg_last_error());
		
		}
	else
	{
	    /////// ADMINISTRADOR ///////////////
		
		$query_alus_tutor .="SELECT ";
		$query_alus_tutor .="A.userid as alu_id_sv, ";
		$query_alus_tutor .="A.status_sinfo, ";
		$query_alus_tutor .="B.pidm_banner as alu_pidm, "; 
		$query_alus_tutor .="B.lastname as apellidos_alumno, ";
		$query_alus_tutor .="B.firstname as nombres_alumno, ";
		$query_alus_tutor .="B.email as email_alumno, ";
		$query_alus_tutor .="A.bloque, ";
		$query_alus_tutor .="(Select C.name From mdl_groups C inner join mdl_groups_members D on D.groupid=C.id and D.userid=A.userid where C.courseid=A.course LIMIT 1) as nombre_grupo, ";
		$query_alus_tutor .="(Select X.id From mdl_groups X inner join mdl_groups_members J on J.groupid=X.id and J.userid=A.userid where X.courseid=A.course LIMIT 1) as id_grupo, ";
		$query_alus_tutor .="(Select E.userid from mdl_groups_members E ";
 		$query_alus_tutor .="inner join mdl_user_teachers F on F.userid=E.userid and E.groupid=(Select M.id From mdl_groups M inner join mdl_groups_members P on P.groupid=M.id and P.userid=A.userid where M.courseid=A.course LIMIT 1) ";
 		$query_alus_tutor .="where F.course=A.course ";
 		$query_alus_tutor .="LIMIT 1) as id_tutor, ";
		$query_alus_tutor .="(Select G.num_grupo From mdl_groups G inner join mdl_groups_members H on H.groupid=G.id and H.userid=A.userid where G.courseid=A.course LIMIT 1) as grupo_numerico ";
		$query_alus_tutor .="From mdl_user_students A ";
		$query_alus_tutor .="left join mdl_user B on A.userid=B.id "; 
		$query_alus_tutor .="Where A.course=". $id_curso_moodle. " order by 2, 8, 7, apellidos_alumno ";

		$result_alus_tutor =pg_query($query_alus_tutor) or die('Query failed 101: ' . pg_last_error());
	
	}
	

    // Printing results in HTML
	$titulo_pagina1 = "Mis Alumnos";
	//print_header("$site->shortname : ". $titulo_pagina1, "X1", $titulo_pagina1, "", "", true, "");
	
	$enlace="<a href='view.php?id=". $id_curso_moodle . "'>". $nombre_moodle . "</a> &gt; Mis Alumnos";
	print_header("$site->shortname : ". $titulo_pagina1, "X1", $enlace, "", "", true, "");

//CAMPOS 

// ID SINFO
// APELLIDOS
// NOMBRES
// EMAIL
// GRUPO
// BLOQUE

	
?>
<strong style="color:blue">Mis Alumnos</strong><BR><BR>

<form name="thisform" id="thisform" method="post">

<!--
<strong><font style="font-size:14px">GRUPOS - TUTORES DEL CURSO</font></strong>
<table cellpadding="2" cellspacing="2" border="1" bordercolor="#b6dbed">
<TR bgcolor="#6bb6de">
<td><strong>N&deg;</strong></td>
<td><strong>Nombre del Grupo</strong></td>
<td><strong>Grupo Num&eacute;rico</strong></td>
<td><strong>Tutor</strong></td>
<td><strong>ID SINFO Tutor</strong></td>
</TR>
<?PHP
$c1=0;
while($row=pg_fetch_array($result_all_groups)) 
	{
	$c1++;
?>
<TR>
<td><?PHP echo $c1 ?></td>
<td><?PHP echo $row["nombre_grupo"] ?></td>
<td align=center><?PHP echo $row["grupo_numerico"] ?></td>
<td><?PHP echo $row["firstname"]. ", ". $row["lastname"] ?></td>
<td align=center><?PHP echo $row["pidm_banner"] ?></td>
</TR>
<?PHP
}
?>
</table>
-->
<p>
<strong>USUARIO ACTUAL:</strong>&nbsp;<em style="color:blue"><?PHP echo $nombre_usuario ?></em>
</p>

	<?PHP
	/// SOLO PARA TUTORES Y ADMIN
	//if (!isadmin()){
	if (1==1){
	

	$cx=0;
	?>
	
	<table cellpadding="2" cellspacing="2" border="1" bordercolor="#b6dbed">
	<TR bgcolor="#6bb6de">
	<td><strong>N&deg;</strong></td>
	<td><strong>ID SINFO</strong></td>
	<td><strong>Status SINFO</strong></td>
	
	<td><strong>Apellidos </strong></td>
	<td><strong>Nombre</strong></td>
	<td><strong>Email</strong></td>
	<td><strong>Bloque</strong></td>
	<td><strong>Grupo</strong></td>
	<td><strong>Grupo Num&eacute;rico</strong></td>
	</TR>

	<?PHP
	while($roch=pg_fetch_array($result_alus_tutor))
	{
	$cx++;
	?>
	<TR>
	<td align=right><?PHP echo $cx ?></td>
	<td align=center><?PHP echo $roch["alu_pidm"] ?></td>
	<td align=center><font color=red><?PHP echo $roch["status_sinfo"] ?></font></td>
	<td><?PHP echo $roch["apellidos_alumno"] ?></td>
	<td><?PHP echo $roch["nombres_alumno"] ?></td>
	<td><?PHP echo $roch["email_alumno"] ?></td>
	<td><?PHP echo $roch["bloque"] ?></td>
	<td><?PHP echo $roch["nombre_grupo"] ?></td>
	<td align=center><?PHP echo $roch["grupo_numerico"] ?></td>
	</TR>

	<?PHP
	} 
	?>
	</TABLE>
	<BR>
	<BR>
	<?PHP
		}
	?>

<input type=hidden name="txh_accion" id="txh_accion" value=""/>

</form>
<?PHP
print_footer();
?>

<script language="javascript">
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


function obje(ide){
	var obex=document.getElementById(ide);
	return obex;
}

function comillas() {
	//no acepta comillas simples ni dobles
	wek=window.event.keyCode;
	if (wek==39 || wek==34) {window.event.keyCode=0;}
}

function salvar() {
	obje("txh_accion").value="salvar";
	obje("thisform").submit();
}

function cancelar()
{
 window.location.href="view.php?id=<?PHP echo $id_curso_moodle?>";  
}

function numeros()
	{
	// onkeypress="return numeros();" 
	// trans-browser compatibility
	// solo acepta numeros
	var e = event || evt;
	var charCode = e.which || e.keyCode;
	if (charCode > 31 && (charCode < 48 || charCode > 57))
	   return false;
	   return true;
	}

function trim(str)
	{
	if(!str || typeof str != "string")
	return "";
	return str.replace(/^[\s]+/,'').replace(/[\s]+$/,'').replace(/[\s]{2,}/,' ');
	}

</script>
<?PHP
}
else
{
echo "Debe ser administrador para entrar a esta pagina";
}
?>