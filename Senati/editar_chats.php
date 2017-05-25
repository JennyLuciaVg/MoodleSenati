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
    if ($accion=="salvar")
		{
		$numero_registros = count($_POST['inp_id_chat']); // Cuantos elementos hay en el array?
		$mensaje="No hay ningún registro a procesar";
		if ($numero_registros > 0)
		    {
			for ($i=0; $i<$numero_registros; $i++)
			     {
				 $id_chat =$_POST["inp_id_chat"][$i];
				 $id_tutor=$_POST["sel_tutor"][$i];
				 
				 if ($id_tutor!="")
				    {$query_update="update mdl_chat set id_tutor=". $id_tutor . " where id=". $id_chat ;}
				 else
				    {$query_update="update mdl_chat set id_tutor=NULL where id=". $id_chat ;}
				
				 $rs_salvar = pg_query($query_update) or die('Query failed: ' . pg_last_error());
				 $rox_salvar=pg_fetch_array($rs_salvar);
				 }
		    }
		}
	   
	//EL NOMBRE DEL CURSO	
	$nombre_moodle=$_POST["nombre_moodle"];
	
	if ($nombre_moodle=="")
		{
		$query0  = "Select fullname from mdl_course where id=". $id_curso_moodle;
		$result0 = pg_query($query0) or die('Query failed: ' . pg_last_error());
		$roxy=pg_fetch_array($result0); 
		$nombre_moodle=$roxy["fullname"];
		}

	$query = "Select A.*, B.firstname, B.lastname from mdl_chat A left join mdl_user B on B.id=A.id_tutor where course=" . $id_curso_moodle . " order by A.id asc";
	$result =pg_query($query) or die('Query failed: ' . pg_last_error());
	
	
// LISTA DE TUTORES DEL COURSE id userid course mdl_user_teachers

$sql_teachers = "select userid, firstname, lastname from mdl_user_teachers A inner join mdl_user B on A.userid=B.id where course=" . $id_curso_moodle . " order by lastname, firstname";
$rs_teachers = pg_query($sql_teachers) or die('Query failed: ' . pg_last_error());
$total_teachers=0;
$c1=0;
while($roy=pg_fetch_array($rs_teachers)) 
	{
	$c1++;
	$id_teacher[$c1]=$roy["userid"];
	$nombre_teacher[$c1]=$roy["lastname"].", ". $roy["firstname"];
    $total_teachers=$c1;
	}

// Printing results in HTML

	$titulo_pagina1 = "Edicion de Chats";
	print_header("$site->shortname : ". $titulo_pagina1, "X1", $titulo_pagina1, "", "", true, "");

?>
<strong style="color:blue"><a href="view.php?id=<?PHP echo $id_curso_moodle?>"><u><? echo $nombre_moodle ?></u></a> - Edici&oacute;n de Chats</strong><BR><BR>



<form name="thisform" id="thisform" method="post">

<font style="font-size:14px" id=fones color=red></font>

<table cellpadding="2" cellspacing="2" border="1" bordercolor="gray">
<TR bgcolor="#dddddd">
<td><strong>N&deg;</strong></td>
<td><strong>ID Chat</strong></td>
<td><strong>Nombre del CHAT</strong></td>
<td><strong>SELECCIONAR TUTOR</strong></td>
<td><strong>TUTOR ACTUAL (Apellidos, Nombres)</strong></td>
<td><strong>ID TUTOR</strong></td>
</TR>
<?PHP
$c1=0;
while($row=pg_fetch_array($result)) 
	{
	$c1++;
?>
<TR>


<td><?PHP echo $c1 ?></td>
<td align=center><?PHP echo $row["id"] ?><input type=hidden name="inp_id_chat[]" value="<?PHP echo $row["id"] ?>"></td>
<td><?PHP echo $row["name"] ?></td>
<td>
	<SELECT name="sel_tutor[]">
	<OPTION value="">No Definido</OPTION>
	<?PHP 
		$cx=0;
		while ($cx<$total_teachers)
			{
			$cx++;
			$sela="";
			if ($row["id_tutor"]==$id_teacher[$cx])
			   {$sela="selected";}
	?>
			<OPTION <?PHP echo $sela ?> value="<?PHP echo $id_teacher[$cx]?>"><?PHP echo $nombre_teacher[$cx] ?></OPTION>
	<?PHP
			}
	?>
	</SELECT>
</td>
<td><?PHP echo $row["lastname"] . ", ". $row["firstname"]?>&nbsp;</td>
<td><?PHP echo $row["id_tutor"] ?>&nbsp;</td>
</TR>
<?PHP
}
?>
</table>
<BR />
<input type="button" value="Salvar" onclick="salvar();" />&nbsp;&nbsp;<input type="button" value="Cancelar" onclick="cancelar();" />&nbsp;&nbsp;
<BR />
<BR />

<input type=hidden name="id_curso_moodle" id="id_curso_moodle" value="<?PHP echo $id_curso_moodle?>"/>
<input type=hidden name="nombre_moodle" id="nombre_moodle" value="<?PHP echo $nombre_moodle?>"/>
<input type=hidden name="txh_accion" id="txh_accion" value=""/>


<ul>
<LI><a href="editar_encuestas.php?id=<?PHP echo $id_curso_moodle ?>">Enlazar Encuestas</a></LI>
<LI><a href="cursos_actualiza_unidades.php?id=<?PHP echo $id_curso_moodle ?>">Actualizar Unidades</a></LI>
</UL>


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