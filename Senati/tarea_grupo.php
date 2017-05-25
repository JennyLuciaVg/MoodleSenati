<?php

	// 7 de Agosto 2012
	// 24 de Agosto 2012 Muestro contenido HTML de cada tarea existente
    // Creación de Tareas por Grupo

    require_once("../config.php");
    require_once("lib.php");
    require_once("$CFG->libdir/blocklib.php");
    require_once("$CFG->dirroot/enrol/enrol.class.php");

    if (isadmin())
	{	
	$mensaje="";
	$site = get_site();
	
	$id=$_GET["id"];
	if ($id=="")
		{$id=$_POST["courseid"];}
	$id_curso_moodle=$id;
    if ($id)
		{
        if (! $course = get_record("course", "id", $id))
			{
            error("Course ID was incorrect");
			}
		}

	$accion=$_POST["tx_accion"];
	
	if ($accion=="importar")
		{
			//TENGO $id_curso_moodle
			$id_curso_importar=$_POST["id_curso_importar"];
			// Es todo lo necesario para importar
			
			
			// Leer todos los datos de las tareas de ese curso y hacer una copia en la tareas del curso actual
			// Si existen las tareas no hacer NADA ni mostrar el botón
			// del curso receptor tengo las unidades -> tareas
			// del curso fuente tengo las unidades -> tareas
			
			///////////////////RECEPTOR//////////////////////////
			$qreceptor  ="Select A.id as id_tarea, B.id as recurso,C.section as unidad  from mdl_assignment A ";
			$qreceptor .="inner join mdl_course_modules B on B.instance=A.id ";
			$qreceptor .="inner join mdl_course_sections C on C.id=B.section ";
			$qreceptor .="where A.course=". $id_curso_moodle ." and assignmenttype='uploadsingle' and B.module=1 ";
			$qreceptor .="order by C.section ";
			$rreceptor = pg_query($qreceptor) or die('Query failed 50 : ' . pg_last_error());
			$totar=0;
			// CHEQUEAR LA UNIDAD el indice es la unidad !!!!!!!!
			while($rox_array=pg_fetch_array($rreceptor))
				{
					$totar++;
					$unixa=$rox_array["unidad"];
					$id_tareay[$unixa]=$rox_array["id_tarea"];
					$id_moduley[$unixa]=$rox_array["recurso"];
					$id_unidady[$unixa]=$unixa;
				}
			//$mensaje  ="El curso importado es: " . $id_curso_importar . "<BR>" ;
			//$mensaje .="Tareas Receptor: " . $totar . "<BR>";
			
			//////////////////// EMISOR ////////////////////////////
			$qemisor  ="Select distinct(numero_grupo), unidad, contenido from senati_tareas A ";
			$qemisor .="inner join mdl_assignment B on A.id_tarea=B.id ";
			$qemisor .="where B.course=". $id_curso_importar . " order by unidad";
			$remisor = pg_query($qemisor) or die('Query failed 66 : ' . pg_last_error());
			
			$tareas_grupo_importar=0;
			
			while($rox_emisor=pg_fetch_array($remisor))
				{
				$tareas_grupo_importar++;
				$unidad_emisor=$rox_emisor["unidad"];
				$numero_grupo_emisor=$rox_emisor["numero_grupo"];
				
				$data_texto=$rox_emisor["contenido"];
				$datax=pg_escape_string($data_texto);

                /////DATOS QUE INGRESARAN A LA BD				
				$id_tarea=$id_tareay[$unidad_emisor];
				$id_nume_grupo=$numero_grupo_emisor;
				$id_module=$id_moduley[$unidad_emisor];
				$unidadx=$unidad_emisor;
				////////
				
				$qexiste="SELECT COALESCE((SELECT 1 FROM senati_tareas WHERE id_tarea=". $id_tarea ." and numero_grupo=". $id_nume_grupo ." LIMIT 1),0) as existe";
				$rexiste=pg_query($qexiste) or die('Query failed 80: ' . pg_last_error());
				$row_existe=pg_fetch_array($rexiste);
				$existe=$row_existe["existe"];
				
				//////
				
				if ($existe=="1")
					{
						$query1="update senati_tareas set contenido='". $datax ."' where id_tarea=". $id_tarea . " and numero_grupo=". $id_nume_grupo ;
						$result1 = pg_query($query1) or die('Query failed 89: ' . pg_last_error());
						$ejecuta=pg_fetch_array($result1);
						$mensaje="Se Actualiz&oacute; un Registro.";
					}
				else
					{
						$query1="insert into senati_tareas (id_tarea,numero_grupo,id_module, unidad) values(". $id_tarea .",". $id_nume_grupo .",". $id_module. ",". $unidadx .")";
						$result1 = pg_query($query1) or die('Query failed 96: ' . pg_last_error());
						$ejecuta=pg_fetch_array($result1);
						
						$query2="update senati_tareas set contenido='". $datax ."' where id_tarea=". $id_tarea . " and numero_grupo=". $id_nume_grupo ;
						$result2 = pg_query($query2) or die('Query failed 101: ' . pg_last_error());
						$ejecuta2=pg_fetch_array($result2);
						$mensaje="Se Insert&oacute; un Registro.";
					}
				    
					//////
				}
				$mensaje="<strong><font color=red>Se importaron ". $tareas_grupo_importar ." Tareas.</font></strong>";
		}
	
	// Debo listar las tarea que no sean offline y los grupos en general
	// Desde mdl_course_modules puedo leer los 
	// module assignment es 1
	// instance es el id de la tabla mdl_assignment
	
	$query_tarea  ="Select B.name, B.id as id_tarea, A.id as id_module, C.section as unidad from mdl_course_modules A ";
	$query_tarea .="inner join mdl_assignment B on A.instance=B.id and A.course=B.course ";
	$query_tarea .="inner join mdl_course_sections C on C.id=A.section ";
	$query_tarea .="Where A.course=". $id_curso_moodle . " and module=1 and assignmenttype='uploadsingle' order by C.section"; 
    $result_tarea = pg_query($query_tarea) or die('Query failed 35 : ' . pg_last_error());

	$nombre_moodle=$course->fullname;
    $titulo_pagina1 = "Creacion/Edicion de Tareas por Grupo";
	$enlace="<a href='view.php?id=". $id_curso_moodle . "'>". $nombre_moodle."</a> &gt; Creaci&oacute;n/Edici&oacute;n de Tareas por Grupo";
	print_header("$site->shortname : ". $titulo_pagina1, "X1", $enlace, "", "", true, "");

    //// Saber si hay registros 
    $existen_tareas=false;	
	$query_existen_tareas="SELECT COALESCE((SELECT 1 FROM senati_tareas WHERE id_tarea in (Select id from mdl_assignment E where E.course=". $id_curso_moodle .") LIMIT 1),0) as existe";
    $result_existen_tareas=pg_query($query_existen_tareas) or die('Query failed 72 : ' . pg_last_error());
	
	$rox1=pg_fetch_array($result_existen_tareas);
	
	if ($rox1["existe"]=="1")
		{$existen_tareas=true;}
	else
		{$existen_tareas=false;}
	
	if ($existen_tareas)
		{
		///	Listar las Tareas por Grupo existentes
		$query_tar_lista  ="Select id_tarea, B.name, numero_grupo, D.section as unidad, contenido from senati_tareas A ";
		$query_tar_lista .="inner join mdl_assignment B on B.id=A.id_tarea ";
		$query_tar_lista .="inner join mdl_course_modules C on C.instance=A.id_tarea and module=1 ";
		$query_tar_lista .="inner join mdl_course_sections D on D.id=C.section ";
		$query_tar_lista .="where A.id_tarea in (Select id from mdl_assignment E where E.course=". $id_curso_moodle .") ";
		$query_tar_lista .="order by 4,1,3";
		$result_tar_lista = pg_query($query_tar_lista) or die('Query failed 93 : ' . pg_last_error());
		}
		
		// Leo el curso semilla

		//id_patron_semilla

		$id_patron_semilla="";
		$query0  = "Select id_patron_semilla from mdl_course where id=". $id_curso_moodle;
		$result0 = pg_query($query0) or die('Query failed 163: ' . pg_last_error());
		$roxyz=pg_fetch_array($result0); 
		$id_patron_semilla=$roxyz["id_patron_semilla"];

		
$contenido="";		
?>
<strong style="color:blue">Creaci&oacute;n/Edici&oacute;n de Tareas por Grupo</strong><BR><BR>

<?PHP
if ($mensaje !="")
{
echo "<p>";
echo $mensaje;
echo "</p>";
}
?>

<form method="post" action="tarea_grupo_editar.php" name="thisform" id="thisform">
<?PHP 
if ($existen_tareas)
{
?>
		<strong>EDITAR ALGUNA TAREA EXISTENTE</strong>
		<table cellspacing=2 cellpadding=2 border=1 bordercolor=#aaaaaa> 
		<TR>
		<TD bgcolor=#eeeeee><strong>Tarea</strong></TD><TD bgcolor=#eeeeee><strong>Grupo Num&eacute;rico</strong></TD><TD bgcolor=#eeeeee><strong>Contenido</strong></TD>
		<TD bgcolor=#eeeeee>&nbsp;</TD>
		</TR>
		<?PHP
		while($rox_tar_lista=pg_fetch_array($result_tar_lista))
		{
		$nume_grupo=$rox_tar_lista["numero_grupo"];
		$id_tarea=$rox_tar_lista["id_tarea"];
		?>
		<TR>
		<TD>
		<?PHP echo $rox_tar_lista["name"] ?> (Unidad <?PHP echo $rox_tar_lista["unidad"] ?>)&nbsp;
		</TD>
		<TD align=center>
		<?PHP echo $rox_tar_lista["numero_grupo"] ?>
		</TD>
		<TD align=left>
		<?PHP echo $rox_tar_lista["contenido"] ?>
		</TD>
		<TD>
		<input type="button" value="Editar" onClick="editar(<?PHP echo $id_tarea ?>,<?PHP echo $nume_grupo ?>)">
		</TD>
		</TR>
		<?PHP
		}
		?>
		</TABLE>
		<BR>
		<HR>
<?PHP
}
?>

<strong>O CREAR UNA NUEVA TAREA o REEMPLAZAR UNA EXISTENTE</strong>
<table cellspacing=2 cellpadding=2 border=1 bordercolor=#dddddd>
<tr>
<TD><strong>TAREA</strong></TD>
<TD>
<SELECT name="sel_tarea_module" id="sel_tarea_module">
<?PHP
$ctareas=0;
while($rox_tarea=pg_fetch_array($result_tarea))
{
$ctareas++;
?>
<OPTION value="<?PHP echo $rox_tarea["id_tarea"]. ",". $rox_tarea["id_module"] ?>"><?PHP echo $rox_tarea["name"] ?> (Unidad <?PHP echo $rox_tarea["unidad"] ?>)</OPTION>
<?PHP
}
?>
</SELECT>
</TD>
</TR>

<TR>
<TD><strong>N&uacute;mero de Grupo</strong></TD>
<TD>
<SELECT id="sel_nume_grupo" name="sel_nume_grupo">
<OPTION value="1">1</OPTION>
<OPTION value="2">2</OPTION>
<OPTION value="3">3</OPTION>
<OPTION value="4">4</OPTION>
<OPTION value="5">5</OPTION>
<OPTION value="6">6</OPTION>
<OPTION value="7">7</OPTION>
<OPTION value="8">8</OPTION>
<OPTION value="9">9</OPTION>
<OPTION value="10">10</OPTION>
</SELECT>
</TD>
</TR>
</TABLE>
<BR>



<?PHP 
$able="";
if ($ctareas == 0)
   {$able="disabled";}
?>
<input type="submit" <?PHP echo $able ?> value="Guardar">

<INPUT type="hidden" name="tx_id_tarea" id="tx_id_tarea">
<INPUT type="hidden" name="tx_nume_grupo" id="tx_nume_grupo">
<INPUT type="hidden" name="tx_id_module" id="tx_id_module">
<INPUT type="hidden" name="tx_accion" id="tx_accion">
<INPUT type="hidden" name="courseid" id="courseid" value="<?PHP echo $id_curso_moodle?>">

<p>
<?PHP
    $usehtmleditor = can_use_html_editor();
	
	print_simple_box_start("");
	
	print_textarea($usehtmleditor, 20, 50, 280, 200, "tx_texto", $contenido);
	if ($usehtmleditor)
	   {
		use_html_editor("tx_texto");
	   }
    print_simple_box_end();
	// tendre un textarea id="edit-tx_texto" name="tx_texto"
?>
</p>

	<p>
	<TABLE cellspacing=1 cellpadding=1 border=1>
	<TR>
	<TD colspan=2 bgcolor=silver align=center><strong>Importar Tareas desde otro Curso - Se remplazaran la existentes (solo administradores)</strong></TD>
	</TR>
	<TR>
	<TD>
	<strong>ID CURSO</strong>
	</TD>
	<TD><INPUT type=text id="id_curso_importar" name="id_curso_importar" size=6 maxlength=6 onKeyPress="numeros();" value="<?PHP echo $id_patron_semilla?>"></TD>
	</TR>
	<TR>
	<TD>&nbsp;</TD>
	<TD><INPUT type=button value="IMPORTAR" onClick="importar();"></TD>
	</TR> 
	</TABLE>
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

function editar(id_tarea, nume_grupo){
	obje("tx_id_tarea").value=id_tarea;
	obje("tx_nume_grupo").value=nume_grupo;
	obje("tx_accion").value="";
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

function importar(){
	if (trim(obje("id_curso_importar").value) !="")
		{
			obje("thisform").action="";
			obje("tx_accion").value="importar";
			obje("thisform").submit();
		}	
}
	
</script>
<?PHP
}
else
{
echo "Debe ser administrador para entrar a esta pagina";
}
?>