<?PHP
//borra_ceros.php

    require_once("../config.php");
    require_once("lib.php");
	
$id_cursox= optional_param('id', 0, PARAM_INT);
	if ($id_cursox=="")
		{
			$id_cursox=$_POST["th_curso"];
		}	

    if (isadmin() || isteacher($id_cursox))
	{
	$qcurso="Select fullname from mdl_course where id=". $id_cursox;
	$rcurso = pg_query($qcurso) or die('Query failed 13: ' . pg_last_error());
	$roy=pg_fetch_array($rcurso);
	
	$nombre_curso=$roy["fullname"];
	$accion=$_POST["th_accion"]; // Solo cuando se pulsa el boton salvar


$mensaje="";
if ($accion=="salvar")
   {
    $id_user=$USER->id;
	
    $borrados=0;
    $totax = count($_POST['th_id_intento']);
	   
	for($i=0;$i<$totax;$i++)
			{
			$sino=$_POST['th_sino'][$i];
			$id_intento=$_POST['th_id_intento'][$i];
			
			if($sino=="S")
				{
				$borrados++;
				///BORRAR EL INTENTO
				$qborrar="delete from mdl_quiz_attempts where id=".$id_intento;
				$rborrar = pg_query($qborrar) or die('Query failed 46: ' . pg_last_error());
				$borrax=pg_fetch_array($rborrar);
				
				$id_alux=$_POST['th_id_alumno'][$i];
				$id_quix=$_POST['th_id_quiz'][$i];
				
				// Aca debo registra quien borro que, a quien y cuando
				/*
					id_usuario : $id_user
					id_alumno : $id_alux
					id_attempt : $id_intento
					id_curso : $id_cursox
					id_quiz : $id_quix
					
				*/
				//Grabar en tabla log log_borrado_ceros
				$qlog="insert into log_borrado_ceros(id_usuario, id_alumno, id_attempt,id_curso,id_quiz) values(".  $id_user. "," . $id_alux . "," . $id_intento . ",". $id_cursox . "," .$id_quix . ");";
				$rlog = pg_query($qlog) or die('Query failed 58 : ' . pg_last_error());
				$logax=pg_fetch_array($rlog);
				}
			}
	$mensaje="Se borraron " . $borrados . " intentos.";
	}		
	
	
	$qlista  = "Select A.*,B.lastname||', '||B.firstname as alumno, A.userid as id_alumno, C.name as nombre_quiz from mdl_quiz_attempts A ";
	$qlista .= "inner join mdl_user B on B.id=A.userid ";
	$qlista .= "inner join mdl_quiz C on C.id=A.Quiz ";
	$qlista .= "Where quiz in (select id from mdl_quiz J where J.course=". $id_cursox .") and A.sumgrades=0 order by quiz, B.lastname, B.firstname";
	
	$result1 = pg_query($qlista) or die('Query failed 10: ' . pg_last_error());

	$titulo_pagina = "Borrar Ceros de Cuestionarios (quiz) (Solo Administradores) ";
	$site = get_site();
	
	print_header("$site->shortname : ". $titulo_pagina, "X1", $titulo_pagina, "", "", true, "");
	
	//LISTA DE QUIZES
	$query2  ="SELECT A.id,name, timeopen,timeclose,timelimit, C.section, instance, B.visible, C.visible as unidad_visible, B.id as id_module from mdl_quiz A ";
	$query2 .="inner Join mdl_course_modules B on A.course=B.Course and module=12 and instance=A.id ";
	$query2 .="inner Join mdl_course_sections C on B.section=C.id "; 
	$query2 .="where A.course=" . $id_cursox . " order by  C.section asc,B.id";
	$result2 = pg_query($query2) or die('Query failed: ' . pg_last_error());
	
	
	
	$ano_actual=date("Y");
	$mes_actual=date("n");
	$dia_actual=date("j");

/// Me da la fecha

function fecha_formateada($fecha_time){
if ($fecha_time !=0)
   {
    //JUSCE ACTUALIZA HORA
	$fecha_real=$fecha_time;//+3600;//-6*3600;
	//$fecha_real=$fecha_time;
	
	$diasem=date('w',$fecha_real);
	$reto='';
	if ($diasem==1){$reto='Lunes';}
	if ($diasem==2){$reto='Martes';}
	if ($diasem==3){$reto='Miercoles';}
	if ($diasem==4){$reto='Jueves';}
	if ($diasem==5){$reto='Viernes';}
	if ($diasem==6){$reto='Sabado';}
	if ($diasem==0){$reto='Domingo';}
	$salida=$reto. ' ' .date('d-m-Y H:i',$fecha_real);
   }
else
   {
$salida='-';
   }
return $salida;
}
	
		
?>

<strong style="color:blue"><a href="view.php?id=<?PHP echo $id_cursox ?>"><u><?PHP echo $nombre_curso . " (". $id_cursox.")" ?></u></a></strong>
<BR><BR>

<?PHP
if ($mensaje!="")
	{
	echo "<p><strong><FONT color=red>" . $mensaje . "</font></strong></p>";
	}
?>

<strong><em>LISTA DE QUIZES y CRONOGRAMA</em></strong>
<table cellpadding="2" cellspacing="2" border="1" bordercolor="black">
<TR>
<td bgcolor=#ABBDD4><strong>Id Quiz</strong></td>
<td bgcolor=#ABBDD4><strong>Nombre Quiz</strong></td>
<td bgcolor=#ABBDD4><strong>Fecha de Apertura</strong></td>
<td bgcolor=#ABBDD4><strong>Fecha de Cierre</strong></td>
<td bgcolor=#ABBDD4><strong>Tiempo Límite</strong></td>
</TR>
<?PHP
//LISTA DE QUIZES

while($rom=pg_fetch_array($result2)) 
	{
	$id_quiz=$rom["id"];
	$nombre_quiz=$rom["name"];
	
	$fecha_open_format=fecha_formateada($rom["timeopen"]);
	$fecha_close_format=fecha_formateada($rom["timeclose"]);
    $timelimit=$rom["timelimit"];
?>
<TR>
<td align=center><?PHP echo $id_quiz ?></td>
<td><?PHP echo $nombre_quiz ?></td>
<td><?PHP echo $fecha_open_format ?></td>
<td><?PHP echo $fecha_close_format ?></td>
<td align=center><?PHP echo $timelimit ?></td>
</TR>
<?PHP	
    }	
?>	
<TABLE>

<BR><BR>
<form name="thisform" id="thisform" method=POST>

<strong><em>LISTA DE INTENTOS con CERO</em></strong>
<table cellpadding="2" cellspacing="2" border="1" bordercolor="black">
<TR>
<td align=center bgcolor=#ABBDD4><strong>Borrar</strong><BR>
<a href="javascript:sel_tona();"><u style="color:blue" id="sel_tona">Seleccionar Todos</u></a>
</td>
<td bgcolor=#ABBDD4><strong>Id Intento</strong></td>
<td bgcolor=#ABBDD4><strong>Nombre Quiz</strong></td>
<td bgcolor=#ABBDD4><strong>Id Quiz</strong></td>
<td bgcolor=#ABBDD4><strong>Alumno</strong></td>
<td bgcolor=#ABBDD4><strong>Timestart</strong></td>
<td bgcolor=#ABBDD4><strong>Timefinish</strong></td>
<td bgcolor=#ABBDD4><strong>Timemodified</strong></td>

</TR>
<?PHP
$ct=0;
while($row=pg_fetch_array($result1)) 
		{
		$intento=$row["id"];
		$id_quiz=$row["quiz"];
		$nombre_quiz=$row["nombre_quiz"];
		$alumno=$row["alumno"];
		$id_alumno=$row["id_alumno"];
		$timestart=$row["timestart"];
		$timefinish=$row["timefinish"];
		$timemodified=$row["timemodified"];
		
?>
<TR>
<td align=center>
<input type="checkbox" name="chk_quiz" onClick="chequear(this,th_th_sino_<?PHP echo $ct?>);"/>
<input type="hidden" name="th_sino[]" id="th_th_sino_<?PHP echo $ct?>" size=4 value="" class="th_check" />
<input type="hidden" name="th_id_alumno[]" id="th_id_alumno[]" size=4 value="<?PHP echo $id_alumno ?>"  />
<input type="hidden" name="th_id_quiz[]" id="th_id_quiz[]" size=4 value="<?PHP echo $id_quiz ?>"  />
<input type="hidden" name="th_id_intento[]" size=4 value="<?PHP echo $intento ?>"/>
</td>
<td align=center><?PHP echo $intento ?></td>
<td><?PHP echo $nombre_quiz ?></td>
<td align=center><?PHP echo $id_quiz ?></td>
<td><?PHP echo $alumno ?></td>
<td><?PHP echo fecha_formateada($timestart) ?></td>
<td><?PHP echo fecha_formateada($timefinish) ?></td>
<td><?PHP echo fecha_formateada($timemodified) ?></td>
</TR>
<?PHP
		//FIN DEL WHILE
		$ct++;
		}
?>		
</TABLE>
<P>
<strong><em>INTENTOS CON CERO: <?PHP echo $ct ?></em></strong><BR>
<input type="hidden" name="th_accion" id="th_accion" size=4 value="" />
<input type="hidden" name="th_curso" size=4 value="<?PHP echo $id_cursox ?>" />
</P>
<p>
<input type="button" onclick="salvar();" value="Borrar los intentos seleccionados">
</p>
</form>

<script language="javascript">

function obje(ide){
	var obex=document.getElementById(ide);
	return obex;
}

function salvar(){
	obje("th_accion").value="salvar";
	obje("thisform").submit();
}

function trim(str)
{
if(!str || typeof str != "string")
return "";
return str.replace(/^[\s]+/,'').replace(/[\s]+$/,'').replace(/[\s]{2,}/,' ');
}

function sel_tona(){
	var selt=obje("sel_tona");
	
	if (selt.innerText=="Seleccionar Todos")
	   {
	   selt.innerText="Seleccionar Ninguno";
	   var v1=true;
	   var v2="S";
	   }
	else
	   {
	   selt.innerText="Seleccionar Todos";
   	   var v1=false;
	   var v2="";
	   }
	var cole=document.getElementsByName("chk_quiz");
	var radios=document.getElementsByClassName('th_check')
	
	lex=cole.length;
	
	 for (ix=0;ix<lex;ix++)
	     {
		 cole.item(ix).checked=v1;
		 radios.item(ix).value=v2;
		 }
}


function chequear(objez,objeth) {
// objez es el mismo checkbox
// objeth es el input box al costado
if (objez.checked)
   {
   objeth.value="S";
   }
else
   {
   objeth.value="";
   }
}
</script>
<?PHP
print_footer();
}
else
{
    echo "Pagina solo para Administradores";
}
?>


