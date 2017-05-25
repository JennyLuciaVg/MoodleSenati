<?PHP

    require_once("../config.php");
    require_once("lib.php");
	
	/// Regularizar Presenciales
	
	// Chequea si es presencial y si tiene las matriculas adecuadas
	// Crea nuevas y borra las que no corresponden

    if (isadmin())
	{

	$site = get_site();
	
	$id_curso_moodle=$_GET["id"];
	
	if ($id_curso_moodle=="")
	   {$id_curso_moodle=$_POST["id_curso_moodle"];}

	$accion=$_POST["txh_accion"];
	
    $mensaje="";
	$mensaje2="";

    	
	//CHEQUEO PRIMERO QUE SE TRATA DE UN CURSO PRESENCIAL Y EL CAMPUS
	$query0  = "Select fullname, presencial_de from mdl_course where id=". $id_curso_moodle;
	$result0 = pg_query($query0) or die('Query failed 23: ' . pg_last_error());
	$roxy=pg_fetch_array($result0); 
	
	$nombre_curso=$roxy["fullname"];
	$es_presencial=trim($roxy["presencial_de"]);

	
	/////////// ADEMAS SOLO LLEVAN LOS QUE ESTAN EN FB ///////////////////////
	
	/*

	SELECT COALESCE((
	Select 1 from senati_actas_notas A
	inner join mdl_course B on B.id=A.id_curso
	Where B.induccion='s' and A.id_alumno=38988 and estado='AP' and B.id <> LIMIT 1),0) as existe
	
	*/
	
	$borrados=0;
    if ($accion=="desmatricular")
		{
		$numex1 = count($_POST['tx_id_matricula']); // how many files in the $_FILES array?

		for($i=0;$i<$numex1;$i++)
				{
					 //SE DEBE BORRAR
					$borrados++;
					$id_matrix=$_POST['tx_id_matricula'][$i];
					
					$queryu  ="delete from mdl_user_students where id=". $id_matrix;
					$resultu = pg_query($queryu) or die('Query failed 67: ' . pg_last_error());
					$ejecuta=pg_fetch_array($resultu);
	
				}
		$mensaje2="Se borraron " . $borrados. " matriculas.";
		
		// FIN DE ACCION	
		}
		
	$titulo_pagina1 = "Eliminación de Matriculas PRESENCIALES";
	print_header("$site->shortname : ". $titulo_pagina1, "X1", $titulo_pagina1, "", "", true, "");

	$sql_alus = "Select A.*,B.*, C.*, A.id as id_matricula from mdl_user_students A ";
	$sql_alus .= "inner join mdl_course B on A.course=B.id ";
	$sql_alus .= "inner join mdl_user C on A.userid=C.id ";
	$sql_alus .="where A.course=". $id_curso_moodle ." and A.userid not in(Select userid from mdl_user_students D where D.course=B.presencial_de) ";
	
$rs_alus = pg_query($sql_alus) or die('Query failed 89: ' . pg_last_error());

$disa="";
if($es_presencial=="")
	{
	$mensaje="Este NO ES UN CURSO PRESENCIAL.";
	$disa="disabled";
	}
else
{
    // SI ES UN CURSO PRESENCIAL
	// SI EL CURSO ESTA EN ACTAS NO DEBE PERMITIRSE BORRAR LA MATRICULA
	
	$sql_acta = "SELECT COALESCE((Select 1 from senati_actas_notas Where id_curso=". $id_curso_moodle ." LIMIT 1),0) as existe_acta";	
	$rs_acta = pg_query($sql_acta) or die('Query failed 100: ' . pg_last_error());
	$rox_acta=pg_fetch_array($rs_acta);
	$existe_acta=$rox_acta["existe_acta"];

	if ($existe_acta=="1")
	{
		$mensaje="Este CURSO YA TIENE ACTAS DE NOTAS NO SE PUEDE DESMATRICULAR.";
		$disa="disabled";
	}
}
	
?>

<strong style="color:blue"><a href="view.php?id=<?PHP echo $id_curso_moodle?>"><u><? echo $nombre_curso ?></u></a> - Eliminación de Matriculas Presenciales</strong><BR><BR>

<?PHP 
if ($mensaje !="")
	{
?>
<p>
<font style="font-size:14px" color=red><?PHP echo $mensaje?></font>
</p>
<?PHP
	}
?>

<?PHP 
if ($mensaje2 !="")
	{
?>
<p>
<em><font style="font-size:14px" color=red><?PHP echo $mensaje2 ?></font></em>
</p>
<?PHP
	}
?>

<form name="thisform" id="thisform" method="post">
<font color=blue><em>Este módulo verifica si el alumno está matriculado en el curso padre.</em></font>
<BR>
<BR>
<strong>LISTA DE ALUMNOS QUE NO DEBERIAN ESTAR EN ESTE CURSO PRESENCIAL</strong>
<TABLE cellspacing=2 cellpadding=2 border=1>
<TR>
<TD bgcolor=silver><strong>N&deg;</strong></TD>
<TD bgcolor=silver><strong>ID Matricula</strong></TD>
<TD bgcolor=silver><strong>Alumno</strong></TD>
<TD bgcolor=silver><strong>PIDM</strong></TD>
<TD bgcolor=silver><strong>Bloque</strong></TD>
</TR>
<?PHP
$ct=0;
while($rox=pg_fetch_array($rs_alus))
{
$ct++;
$enlace='http://virtual.senati.edu.pe/user/view.php?id='. $rox["userid"].'&course=1';
?>
<TR>
<TD align=right><?PHP echo $ct  ?></td>
<TD align=right><?PHP echo $rox["id_matricula"]  ?> <INPUT type=hidden name="tx_id_matricula[]" value="<?PHP echo $rox["id_matricula"] ?>"></TD>
<TD><a href="<?PHP echo $enlace ?>" target=_blank><u><?PHP echo $rox["lastname"]. ", ". $rox["firstname"]  ?></u></a><INPUT type=hidden name="tx_id_alu[]" size=8 value="<?PHP echo $rox["userid"] ?>"></TD>
<TD align=right><?PHP echo $rox["pidm_banner"]  ?></TD>
<TD><?PHP echo $rox["bloque"]  ?></TD>
</TR>

<?PHP
}
?>
</TABLE>
<P>
<input type="button" id="bot_desma" <?PHP echo $disa ?> value="DESMATRICULAR" onclick="desmatricular();" />
</p>

<input type=hidden name="id_curso_moodle" id="id_curso_moodle" value="<?PHP echo $id_curso_moodle?>"/>
<input type=hidden name="nombre_moodle" id="nombre_moodle" value="<?PHP echo $nombre_curso?>"/>
<input type=hidden name="txh_accion" id="txh_accion" value=""/>
<input type=hidden name="tx_conteo" id="tx_conteo" value="0"/>
<input type=hidden name="tx_desma" id="tx_desma" value="0"/>

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

function desmatricular() {

	obje("txh_accion").value="desmatricular";
	obje("thisform").submit();
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
