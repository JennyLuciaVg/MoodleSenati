<?PHP

    require_once("../config.php");
    require_once("lib.php");

    if (isadmin())
	{

	$site = get_site();
	
	$id_curso_moodle=$_GET["id"];
	
	if ($id_curso_moodle=="")
	   {$id_curso_moodle=$_POST["id_curso_moodle"];}

	$accion=$_POST["txh_accion"];
	
    $mensaje="";
	$mensaje2="";
	
	//CHEQUEO PRIMERO EL NOMBRE DEL CURSO
	$query0  = "Select fullname from mdl_course where id=". $id_curso_moodle;
	$result0 = pg_query($query0) or die('Query failed 23: ' . pg_last_error());
	$roxy=pg_fetch_array($result0); 
	
	$nombre_curso=$roxy["fullname"];
	

    //BORRA MATRICULAS SEGUN BLOQUE	
	$borrados=0;
    if ($accion=="desmatricular")
		{
		$bloque = trim($_POST['tx_bloque']); 
		$mensaje2="No se hizo nada";
		if ($bloque !="")
			{
			$querya  ="Select count(*) as total from mdl_user_students where course=". $id_curso_moodle ." and bloque='". $bloque. "'";
			$resulta = pg_query($querya) or die('Query failed 58: ' . pg_last_error());
			$roz=pg_fetch_array($resulta);
			
			$borrados=$roz["total"];
			$queryu  ="delete from mdl_user_students where course=".$id_curso_moodle . " and bloque='". $bloque. "'";
			$resultu = pg_query($queryu) or die('Query failed 65: ' . pg_last_error());
			$ejecuta=pg_fetch_array($resultu);
			}
			
		$mensaje2="Se borraron " . $borrados. " matriculas.";
		// FIN DE ACCION		
		}

		
	$titulo_pagina1 = "Eliminación de Matriculas según BLOQUE";
	print_header("$site->shortname : ". $titulo_pagina1, "X1", $titulo_pagina1, "", "", true, "");

	
?>

<strong style="color:blue"><a href="view.php?id=<?PHP echo $id_curso_moodle?>"><u><? echo $nombre_curso ?></u></a> - Eliminación de Matriculas según BLOQUE</strong><BR><BR>

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
<font color=blue><em>Este módulo desmatriculará alumnos según su BLOQUE</em></font>
<BR>

<input type=text name="tx_bloque" id="tx_bloque" value="" size=10 maxlength=10  />
<BR />
<BR />
<input type="button" id="bot_desma" value="Desmatricular" onclick="desmatricular();"  />

<input type=hidden name="id_curso_moodle" id="id_curso_moodle" value="<?PHP echo $id_curso_moodle?>"/>
<input type=hidden name="nombre_moodle" id="nombre_moodle" value="<?PHP echo $nombre_curso?>"/>
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
