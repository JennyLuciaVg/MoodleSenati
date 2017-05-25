<?PHP
    require_once("../config.php");
    require_once("lib.php");
	
	
	$id_cursox=$_GET['id'];
	
	if ($id_cursox=="")
		{
		$id_cursox=$_POST['id_cursox'];
		}

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


$mensaje="";	
$total_registros = count($_POST['id_alumno']);
if ($total_registros!=0)
{
	for ($i=0;$i<$total_registros;$i++)
		{
			$id_alux=$_POST["id_alumno"][$i];
			$email_alux=$_POST["email"][$i];
			$city_alux=$_POST["city"][$i];
			$pidm_banner=trim($_POST["pidm_banner"][$i]);
			
			if ($pidm_banner=="")
				{
				$qupdate = "update mdl_user set email='". $email_alux . "', city='". $city_alux . "' where id=". $id_alux;
				$rupdate = pg_query($qupdate) or die('Query failed 37:   ' . pg_last_error());
				$roxy=pg_fetch_array($rupdate);
				}
			else
				{
				$qupdate = "update mdl_user set email='". $email_alux . "', city='". $city_alux . "', pidm_banner=". $pidm_banner.", pidm_ok='s' where id=". $id_alux;
				$rupdate = pg_query($qupdate) or die('Query failed 49:   ' . pg_last_error());
				$roxy=pg_fetch_array($rupdate);
				}
		}
	$mensaje="<p><strong stryle='font-size:14px'><font color=red>Se actualizaron ". $total_registros . " Registros</font></strong></p>";	
}	



$query = "SELECT A.userid, firstname, lastname, email , pidm_banner, username, city ";
$query .="From mdl_user_students A ";
$query .="inner join mdl_user B on A.userid=B.id ";
$query .="Where A.course=" . $id_cursox . " order by lastname ";
$result = pg_query($query) or die('Query failed 33:   ' . pg_last_error());
// Printing results in HTML


	$titulo_pagina = $nombre_curso. " &gt; Edicion de Correos y Ciudades";
	$enlace="<a href='view.php?id=". $id_cursox . "'>". $nombre_curso . "</a> &gt; Edicion de Correos y Ciudades"; 
	print_header("$site->shortname : ". $titulo_pagina, "X1", $enlace, "", "", true, "");

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
<td align=right><strong>Matriculas</strong></td>
<td><a target="_blank" href="http://virtual.senati.edu.pe/course/editar_matriculas.php?id=<?PHP echo $id_cursox ?>"><u>Editar Matriculas</u></a></td>
</TR>
</TABLE>


<BR>
<form name="thisform" id="thisform" method="post">

<?PHP
if ($mensaje!="")
	{
	echo $mensaje;
	}
?>

<table cellpadding="3" cellspacing="1" border="1" bordercolor="gray">
<TR bgcolor="#dddddd">
<td ><strong>Nº</strong></td>
<td><strong>Id Moodle</strong></td>
<td><strong>PIDM SINFO</strong></td>
<td><strong>Username</strong></td>
<td><strong>Apellidos, Nombres</strong></td>
<td><strong>Email</strong></td>
<td><strong>Ciudad</strong></td>
</TR>

<?PHP
$c1=1;
while($row=pg_fetch_array($result)) 
	{
	$total_alumnos=$c1;

	$estilo="";
	if($row["pidm_banner"]=="")
		{
		$estilo="bgcolor=yellow";
		}
	
?>
<TR>
<td align=right><?php echo $c1 ?></td>
<td align=center>
<a title="Ver/Editar" href="http://virtual.senati.edu.pe/user/edit.php?id=<?PHP echo $row["userid"] ?>&course=<?PHP echo $id_cursox ?>" target=_blank><u><?php echo $row["userid"] ?></u></a>
<INPUT type="hidden" name="id_alumno[]" value='<?PHP echo $row["userid"] ?>'></td>
<td <?PHP echo $estilo ?>><INPUT name="pidm_banner[]" size=10 value='<?php echo $row["pidm_banner"] ?>'></td>
<td><?php echo $row["username"] ?></td>
<td>
<?php echo $row["lastname"] . ', '. $row["firstname"] ?></td>
<td><INPUT name="email[]" size=50 value='<?PHP echo $row["email"] ?>'></td>
<td><INPUT name="city[]" size=50 value='<?PHP echo $row["city"] ?>'></td>
</TR>
<?PHP
$c1++;

}
?>
</TABLE>
<p>
<INPUT type=submit value="Salvar Datos">

<INPUT type=button value="Lower Case Correos" onClick="lower_correos();">
<INPUT type=hidden name="id_cursox" value="<?PHP echo $id_cursox ?>">
&nbsp;<font color=red id=fonrep></font>
</p>
</form>

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

function lower_correos(){
obje("fonrep").innerText="Espere ...";

var cole=document.getElementsByName("email[]");
for (i=0;i<cole.length;i++)
	{
	var email=cole[i].value;
	var email=email.toLowerCase();
	cole[i].value=email;
	}
obje("fonrep").innerText="Listo " + cole.length	+ " Correos en Lowecase.";
}

obje("td_alumnos").innerText="<?PHP echo $total_alumnos?>";

</script>
