<?PHP
    require_once("../config.php");
    require_once("lib.php");
	
    $id_cursox= optional_param('curso', 0, PARAM_INT);
    $tipoz= optional_param('tipo', 0, PARAM_INT);



	if ($id_cursox=="")
	{
		$id_cursox=$_POST["th_curso"];
	}

$accion=$_POST["th_accion"];
if ($accion=="ordenar")
	{
	$orden_colu=$_POST["th_orden_colu"];
	$orden_tipo=$_POST["th_orden_tipo"];
		if ($orden_colu=="3")
		{
			$ordenar="3 ". $orden_tipo;
		}
		else if ($orden_colu=="4")
		{
			$ordenar="4 ". $orden_tipo . ", lastname";
		}
		else if ($orden_colu=="5")
		{
			$ordenar="5 ". $orden_tipo . ", lastname";
		}
		else if ($orden_colu=="6")
		{
			$ordenar="6 ". $orden_tipo . ", lastname";
		}	
		else
		{
			$ordenar=$orden_colu . " " . $orden_tipo;
		}
	}
else
	{
	$orden_colu="5";
	$orden_tipo="asc";
	$ordenar="5 asc, lastname,camp";
	}	

/*
	ORDEN 
1	userid
3	lastname
4	nombre_centro
5	bloque
6	nrc
*/	
	
	
	

	$site = get_site();

	$query1 = 'SELECT fullname, periodo From mdl_course Where id=' . $id_cursox;
	$result1 = pg_query($query1) or die('Query failed: ' . pg_last_error());

	while($row=pg_fetch_array($result1)) 
		{
		$nombre_curso=$row["fullname"];
		$periodo_curso=$row["periodo"];
		}

	// OBTENGO EL ID DEL USUARIO EN CURSO !!!!!!!!!!!!
	$usuario_id=$USER->id;
	$usuario_email=$USER->email;

//GRUPOS http://virtual.senati.edu.pe/course/groups.php?id=782	$id_cursox
//ESTA PAGINA  http://virtual.senati.edu.pe/course/listado.php?curso=782
	
	
	// AVERIGUO SI EL CURSO TIENE GRUPOS
	
//	$query2 = 'SELECT COALESCE((SELECT 1 FROM mdl_groups WHERE courseid='. $id_cursox .' LIMIT 1),0) as "existe"';
//	$query2 = 'SELECT count(*) as  total FROM mdl_groups WHERE courseid='. $id_cursox ;
	
	$query2  = "Select count(DISTINCT(A.groupid)) as total from mdl_groups_members A ";
	$query2 .= "inner join mdl_groups B on A.groupid=B.id ";
	$query2 .= "where B.courseid=". $id_cursox ;
	

	$result2 = pg_query($query2) or die('Query failed: ' . pg_last_error());
	$row2 = pg_fetch_array($result2);
	$tot_grupos='0';
	if ($row2["total"]!="0")
	    {$tiene_grupos=true;
		$tot_grupos=$row2["total"];
		}
	else
	    {$tiene_grupos=false;}
	
	$titulo_pagina = $nombre_curso. " &gt; Listado de Alumnos";
	$enlace="<a href='view.php?id=". $id_cursox . "'>". $nombre_curso . "</a> &gt; Listado de Alumnos"; 
	print_header("$site->shortname : ". $titulo_pagina, "X1", $enlace, "", "", true, "");

echo "<BR>" ;

// ACA SON TODOS
$query = "SELECT A.userid, firstname, lastname, nombre_centro, A.bloque, A.nrc, email, estado, nota, pidm_banner, A.camp, A.carr, B.city, A.semestre, username, ";
//$query .="(select count(*) from mdl_log Z where (action not in ('login','logout','error')) and Z.course=A.course and A.userid=Z.userid) as accesos,";
$query .="(select count(*) from mdl_log Z where Z.course=A.course and A.userid=Z.userid) as accesos,";
$query .="(Select C.name From mdl_groups C inner join mdl_groups_members D on D.groupid=C.id and D.userid=A.userid where C.courseid=A.course LIMIT 1) as nombre_grupo, ";
$query .="(Select C.id From mdl_groups C inner join mdl_groups_members D on D.groupid=C.id and D.userid=A.userid where C.courseid=A.course LIMIT 1) as id_grupo ";
$query .="From mdl_user_students A ";
$query .="left join mdl_user B on A.userid=B.id ";
$query .="left join senati_centros G on G.id_centro=A.camp ";
$query .="left join senati_actas_notas on id_alumno=A.userid and id_curso=A.course ";
$query .="Where A.course=" . $id_cursox . " order by ". $ordenar ;

/*
	ORDEN 
1	userid
2	firstname
3	lastname
4	nombre_centro
5	bloque
6	nrc
*/


//$tipoz=="1" significa desaprobados
if ($tipoz=="1")
{
$query = "SELECT A.userid, firstname, lastname, email , nombre_centro, nota, estado, pidm_banner, A.camp, A.nrc, A.bloque, A.carr, B.city, A.semestre, status_sinfo, username, ";
//$query .="(select count(*) from mdl_log Z where (action not in ('login','logout','error')) and Z.course=A.course and A.userid=Z.userid) as accesos,";
$query .="(select count(*) from mdl_log Z where Z.course=A.course and A.userid=Z.userid) as accesos,";
$query .="(Select C.name From mdl_groups C inner join mdl_groups_members D on D.groupid=C.id and D.userid=A.userid where C.courseid=A.course LIMIT 1) as nombre_grupo, ";
$query .="(Select C.id From mdl_groups C inner join mdl_groups_members D on D.groupid=C.id and D.userid=A.userid where C.courseid=A.course LIMIT 1) as id_grupo ";
$query .="From mdl_user_students A ";
$query .="left join mdl_user B on A.userid=B.id ";
$query .="left join senati_centros G on G.id_centro=A.camp ";
$query .="left join senati_actas_notas on id_alumno=A.userid and id_curso=A.course ";
$query .="Where estado<>'AP' and A.course=" . $id_cursox . " order by status_sinfo ASC, A.bloque,  lastname,camp";
}
if ($tipoz=="2")
{
//tomando en cuenta 3.9 10.4
$query = "SELECT A.userid, firstname, lastname, email , nombre_centro, nota, estado, pidm_banner, A.camp, A.nrc, A.bloque, A.carr, B.city, A.semestre, status_sinfo, username, ";
//$query .="(select count(*) from mdl_log Z where (action not in ('login','logout','error')) and Z.course=A.course and A.userid=Z.userid) as accesos,";
$query .="(select count(*) from mdl_log Z where Z.course=A.course and A.userid=Z.userid) as accesos,";
$query .="(Select C.name From mdl_groups C inner join mdl_groups_members D on D.groupid=C.id and D.userid=A.userid where C.courseid=A.course LIMIT 1) as nombre_grupo, ";
$query .="(Select C.id From mdl_groups C inner join mdl_groups_members D on D.groupid=C.id and D.userid=A.userid where C.courseid=A.course LIMIT 1) as id_grupo ";
$query .="From mdl_user_students A ";
$query .="left join mdl_user B on A.userid=B.id ";
$query .="left join senati_centros G on G.id_centro=A.camp ";
$query .="left join senati_actas_notas on id_alumno=A.userid and id_curso=A.course ";
$query .="Where status_sinfo is null and estado<>'AP' and cast(nota as float) >3.9 and A.course=" . $id_cursox . " order by status_sinfo ASC, A.bloque,  lastname,camp";
}

$result = pg_query($query) or die('Query failed: ' . pg_last_error());
// Printing results in HTML

?>

<table cellpadding="2" cellspacing="2" border="1" bordercolor="gray">
<TR >
<td align=right><strong>Curso</strong></td>
<td ><?PHP echo $nombre_curso ?></td>
</TR>
<TR>
<td align=right><strong>ID Curso</strong></td>
<td ><?PHP echo $id_cursox ?></td>
</TR>
<TR>
<td align=right><strong>Per&iacute;odo SINFO</strong></td>
<td ><?PHP echo $periodo_curso ?></td>
</TR>
<TR>
<td align=right><strong>Alumnos</strong></td>
<td id=td_alumnos>.</td>
</TR>
<TR>
<td align=right><strong>Grupos</strong></td>
<td ><?PHP echo $tot_grupos ?>&nbsp;
<?PHP 
if ($tot_grupos !="0")
{
 echo '<a target="_blank" href="http://virtual.senati.edu.pe/course/groups.php?id=' .$id_cursox. '"><u>Ir a p&aacute;gina de Grupos</u></a>&nbsp;';
} 
?>
 </td>
</TR>

<?PHP

if(isadmin())
{
?>
	<TR>
	<td align=right><strong>Matriculas</strong></td>
	<td><a target="_blank" href="http://virtual.senati.edu.pe/course/editar_matriculas.php?id=<?PHP echo $id_cursox ?>"><u>Editar Matriculas</u></a></td>
	</TR>
<?PHP
}
?>

</TABLE>
<p>
<font color=red><STRONG style="font-size:16px">NO SE MUESTRAN LOS RETIRADOS</strong></font>
</p>
<!--
<a href="listado.php?curso=<?PHP echo $id_cursox ?>&tipo=1"><u>Ver solo Desaprobados</u></a>&nbsp;&nbsp;
<a href="listado.php?curso=<?PHP echo $id_cursox ?>&tipo=2"><u>Pasan a Subsanaci&oacute;n</u></a>&nbsp;&nbsp;
<a href="listado.php?curso=<?PHP echo $id_cursox ?>"><u>Ver Todos</u></a>
<BR>
-->

<?PHP

// en el conteo de alumnos no debo contar los profesores
if ($tot_grupos !="0")
	{
	
	$query9  = "Select DISTINCT(A.groupid), B.name, count(*) as alumnos from mdl_groups_members A ";
	$query9 .= "inner join mdl_groups B on A.groupid=B.id ";
	$query9 .= "where B.courseid=" . $id_cursox. " and A.userid not in (select userid from mdl_user_teachers C where C.course=B.courseid) ";
	$query9 .= "group by A.groupid, B.name order by B.name ";
	$result9 = pg_query($query9) or die('Query failed: ' . pg_last_error());
	}

// si es administrador  isadmin() es =1 sino es igual a nada

?>
<BR />
<?PHP

if ($tipoz=="1")
{
echo "<strong style='color:blue'>SOLO DESAPROBADOS</strong>";
}

if ($tipoz=="2")
{
echo "<strong style='color:blue'>PASAN A SUBSANACION (Nota >3.9) </strong>";
}
if ($tipoz!="1" && $tipoz!="2")
{
echo "<strong style='color:blue'>TODOS</strong>";
}
?>
<BR>
<table cellpadding="1" cellspacing="1" border="1" bordercolor="gray">
<TR bgcolor="#dddddd">
<td ><strong>Nº</strong></td>
<td align=right><strong>Id Moodle</strong></td>
<td align=right><strong>PIDM SINFO</strong></td>
<td align=right><strong>Username</strong></td>
<?PHP 
if ($tiene_grupos)
	{
	echo "<td><strong>Id_Grupo</strong></td>";
	echo "<td><strong>Grupo</strong></td>";
	}

/*
	ORDEN 
1	userid
3	lastname
4	nombre_centro
5	bloque
6	nrc

ordenar(campo)
*/


	
?>

<td><strong><a href="javascript:ordenar(3);"><u>Apellidos, Nombres</u></a></strong></td>
<td><strong><a href="javascript:ordenar(6);"><u>Nrc</u></a></strong></td>
<td><strong><a href="javascript:ordenar(5);"><u>Bloque</u></a></strong></td>
<td><strong>Camp</strong></td>
<td><strong><a href="javascript:ordenar(4);"><u>Campus</u></a></strong></td>
<td><strong>Email</strong></td>
<td><strong>Empresa</strong></td>
<td><strong>Accesos</strong></td>
<td><strong>Nota HA*</strong></td>
<td><strong>Estado HA*</strong></td>
</TR>

<?PHP

$lista_emails="";
$c1=0;
$nunca_accedieron=0;
$no_tienen_grupo=0;
while($row=pg_fetch_array($result)) 
	{
	$id_userx=$row["userid"];
	$c1++;
	if ($c1==1)
	   {$lista_emails=$row["email"];}
	else
	   {$lista_emails=$lista_emails . '; ' . $row["email"];}

    $stax=$row["estado"];
    $statux="";
	$estilo="";
if ($stax=="AP")
   {$statux="Aprobado";
    $estilo='style="color:blue"';}
if ($stax=="RE")
   {$statux="Retirado";}
if ($stax=="DE")
   {$statux="Desaprobado";}
if ($stax=="NP")
   {$statux="No particip&oacute;";}

if ($row["accesos"] =="0") 
{$nunca_accedieron++;}

$colog='';
if ($tiene_grupos)
	{
	$id_grupox=$row["id_grupo"];
		if ($row["nombre_grupo"]=='')
		   {$grupo_name="NO TIENE";
		   $colog='style="color:red"';
		   $no_tienen_grupo++;
		   }
		else    
		   {$grupo_name=$row["nombre_grupo"];
		   $colog='style="color:blue"';
		   }
	}   


?>
<TR>
<td align=right><?php echo $c1 ?></td>
<td align=right><?php echo $row["userid"] ?></td>
<td align=right><?php echo $row["pidm_banner"] ?></td>
<td align=right><?php echo $row["username"] ?></td>

<?PHP 
if ($tiene_grupos)
{
?>
<td <?PHP echo $colog ?>><?php echo $id_grupox ?></td>
<td <?PHP echo $colog ?>><?php echo $grupo_name ?></td>
<?PHP
}
?>
<td><?php echo $row["lastname"] . ', '. $row["firstname"] ?></td>
<!--<td align="center">&nbsp;<strong style="color:red"><?PHP echo $row["status_sinfo"] ?></strong>&nbsp;</td>-->
<td><?php echo $row["nrc"] ?></td>
<td><?php echo $row["bloque"] ?></td>
<td><?php echo $row["camp"] ?></td>
<td><?php echo $row["nombre_centro"] ?></td>
<td><?php echo $row["email"] ?></td>
<td><?php echo $row["city"] ?></td>
<td align="right"><?php echo $row["accesos"] ?></td>
<td <?PHP echo $estilo?> align="right"><?php echo $row["nota"] ?></td>
<td <?PHP echo $estilo?> ><?PHP echo $statux?></td>
</TR>
<?PHP
}
$total_alumnos=$c1;
if ($c1==0)
    {$c1=1;}
$porcentaje_noa=number_format (100*($nunca_accedieron/$c1),2);
//number_format (1234.567, 2);
$accedieron=$c1-$nunca_accedieron;
$porcentaje_a=number_format (100-$porcentaje_noa,2);


echo "</TABLE><BR><font color=blue>*Las Notas y El Estado vienen de Historia Académica.</font><BR><BR>";
echo "<TABLE border=1 cellspacing=2 bordercolor=gray>";
echo "<TR><TD><strong>Nunca accedieron </TD><TD align=right>". $nunca_accedieron ." alumnos </strong></TD><TD align=right> " .  $porcentaje_noa. " % </TD></TR>";
echo "<TR><TD><strong>Accedieron </TD><TD align=right>". $accedieron ." alumnos </strong></TD><TD align=right> " .  $porcentaje_a. " % </TD></TR>";
echo "</TABLE>";

if ($tot_grupos !="0")
	{echo "<BR><strong>No tienen Grupo : ".  $no_tienen_grupo. " alumnos.</strong>";
?>
<BR /><BR />
<em>1. Haga click en el Nombre del Grupo para ver los emails de los alumnos de ese Grupo.</em><BR>
<em>2. Haga click en el Nombre del Tutor para ver los emails de los alumnos de ese Tutor en este Curso.</em><BR>
<table cellpadding="1" cellspacing="4" border="0">
<tr>
<td valign="top">


<table cellpadding="2" cellspacing="2" border="1" bordercolor="gray">
<TR bgcolor="#dddddd">
<td><strong>Nº</strong></td>
<td><strong>id_grupo</strong></td>
<td ><strong>Nombre del Grupo</strong></td>
<td ><strong>Tutor</strong></td>
<td align=right><strong>Alumnos</strong></td>
</TR>
<?PHP
$cx=0;
	
		while($row9=pg_fetch_array($result9)) 
		   {
		   $cx++;
		   //Profes
		    $queryp  = 'Select C.userid, lastname, firstname from mdl_groups_members A ';
			$queryp .= 'inner join mdl_groups B on A.groupid=B.id ';
			$queryp .= 'inner join mdl_user_teachers C on C.userid=A.userid and C.course=B.courseid ';
			$queryp .= 'inner join mdl_user D on D.id=C.userid ';
			$queryp .= 'where B.id=' . $row9["groupid"] . ' order by B.name';
			$resultp = pg_query($queryp) or die('Query failed: ' . pg_last_error());
	        $rowp = pg_fetch_array($resultp);
			$profesor=$rowp["firstname"]. ", ". $rowp["lastname"];
			$id_tutor=$rowp["userid"];
			if ($id_tutor=="")
			   {$id_tutor="0";}
	   
?>

<TR >
<td align=right><?PHP echo $cx ?></td>
<td align=right><?PHP echo $row9["groupid"]?></td>
<td style="color:blue"><a href='javascript:ver_emails_grupo(<?PHP echo $row9["groupid"]?>,<?PHP echo $id_tutor ?>);'><u><?PHP echo $row9["name"]?></u></a></td>
<td ><a href='javascript:ver_emails_tutor(<?PHP echo $id_tutor ?>);'><u style="color:black"><?PHP echo $profesor ?></u></a> (id=<?PHP echo $id_tutor ?>)</td>
<td align=right><?PHP echo $row9["alumnos"]?></td>
</TR>

<?PHP			
		   }
	if ($no_tienen_grupo !="0")
		{	   
			$cx++;
			echo "<TR>";
			echo "<td align=right>" . $cx ."</td>";
			echo "<td style='color:red' colspan=3>NO TIENEN GRUPO</td>";
			echo "<td align=right >". $no_tienen_grupo. "</td>";
			echo "</TR>";
		}
	echo "</TABLE>";
	echo "</td>";
	echo "<td valign=top>";
	echo "<div id=div_emails>";
	echo "</div>";
	echo "</td>";
	echo "</TR>";
	echo "</TABLE>";
		   
	   	
	}
?>	
<?PHP
echo "<BR><BR><strong>Lista de Emails para Outlook o Exchange :</strong>";
?>
<BR />
<textarea cols=80 rows=12 readonly><?PHP echo $lista_emails?></textarea>

<FORM name="thisform" id="thisform" method=post>
<input type="hidden" name="th_accion" id="th_accion" value="">
<input type="hidden" name="th_curso" id="th_curso" value="<?PHP echo $id_cursox ?>">
<input type="hidden" name="th_orden_colu" id="th_orden_colu" value="<?PHP echo $orden_colu ?>">
<input type="hidden" name="th_orden_tipo" id="th_orden_tipo" value="<?PHP echo $orden_tipo ?>">
</form>

<?PHP 

if(isadmin())
	{
?>

<BR><a href="listado_editar_correos.php?id=<?PHP echo $id_cursox ?>"><u>EDITAR CORREOS, CIUDAD y PIDM</u></a>
<br>

<BR><a href="cursos_edicion_actas.php?id=<?PHP echo $id_cursox ?>"><u>EDICION DE ACTA OFICIAL</u></a>
<br>

<BR><a href="induccion_borra_matriculas.php?id=<?PHP echo $id_cursox ?>"><u>Eliminación de Matriculas de Cursos de Inducción</u></a>
<br>

<BR><a href="borra_matriculas.php?id=<?PHP echo $id_cursox ?>"><u>Eliminación de Matriculas según BLOQUE</u></a>
<br>

<BR><a href="regulariza_subsanaciones.php?id=<?PHP echo $id_cursox ?>"><u>Eliminación de Matriculas de Cursos de Susbanación</u></a>
<br>

<BR><a href="regulariza_presenciales.php?id=<?PHP echo $id_cursox ?>"><u>Eliminación de Matriculas de Cursos Presenciales</u></a>
<br>

<?PHP
	}
	
if(isteacher($id_cursox) || isadmin())
	{
?>
<BR><a href="borra_ceros.php?id=<?PHP echo $id_cursox ?>"><u>Borrar Ceros de los Cuestionarios</u></a>
<br>
<?PHP
	}
?>




<?PHP
print_footer();
?>
<script language="javascript">

function obje(ide){
var obex=document.getElementById(ide);
return obex;
}

function ordenar(campo){
	obje("th_accion").value="ordenar";	
	if (obje("th_orden_colu").value==campo)
		{
		if (obje("th_orden_tipo").value=="asc")
		   {
			obje("th_orden_tipo").value="desc";
		   }
		else
		   {
			obje("th_orden_tipo").value="asc";
		   }
		}
	else
		{
		obje("th_orden_colu").value=campo;
		obje("th_orden_tipo").value="asc";
		}
	obje("thisform").submit();
}

obje("td_alumnos").innerText="<?PHP echo $total_alumnos?>";


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

function ver_emails_grupo(id_grupo, id_tutor){
	obje("div_emails").innerHTML="<strong><font color=red>Espere ...</font></strong>";
	url="listado_emails_grupo_ajax.php";
	
	var xmlo=crea_xmlhttpPost(url);
		 xmlo.onreadystatechange = function()
		  {
		   if (xmlo.readyState == 4) {
			   update_div(xmlo.responseText);
			   }
		  }
	qstr="id_grupo=" + escape(id_grupo)+"&id_tutor="+escape(id_tutor);
	xmlo.send(qstr);
}

function ver_emails_tutor(id_tutor){
	obje("div_emails").innerHTML="<strong><font color=red>Espere ...</font></strong>";
	url="listado_emails_tutor_ajax.php";
	
	var xmlo=crea_xmlhttpPost(url);
		 xmlo.onreadystatechange = function()
		  {
		   if (xmlo.readyState == 4) {
			   update_div(xmlo.responseText);
			   }
		  }
	qstr="id_tutor=" + escape(id_tutor)+"&id_curso="+escape(<?PHP echo $id_cursox?>);
	xmlo.send(qstr);
}


function update_div(str){
obje("div_emails").innerHTML=str;
}



</script>
