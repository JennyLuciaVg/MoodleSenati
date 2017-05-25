<?PHP

// MODIFICADO EL 18 de OCTUBRE 2008 JUSCE
// MODIFICADO EL 9 de MARZO 2009 JUSCE

    require_once("../config.php");
    require_once("lib.php");
    

    $id       = required_param('id');              // course id
    $download = optional_param('download');
    $user     = optional_param('user', -1);
    $group    = optional_param('group', -1);
    $action   = optional_param('action', 'grades');
    
    $id_usuario=$USER->id;
    $datos_salvados="no";

	/////// LOS TUTORES SOLO PUEDEN VER LAS PONDERACIONES  ////////////////////////////////////////////////
	
    if (!$course = get_record('course', 'id', $id)) {
        error('No course ID');
    }

    require_login($course->id);
    
    if (isteacher($course->id)) {
        $group = get_and_set_current_group($course, $course->groupmode, $group);
    } else {
        $group = get_current_group($course->id);
    }

    
    // if the user set new prefs make sure they happen now
    if ($action == 'set_grade_preferences' && $prefs = data_submitted()) {
        if (!confirm_sesskey()) {
            error(get_string('confirmsesskeybad', 'error'));
        }
        grade_set_preferences($course, $prefs);
    }

    $preferences = grade_get_preferences($course->id);

    
    // we want this in its own window
    if ($action == 'stats') {
        grade_stats();
        exit();
    } else if ($action == 'excel') {
        grade_download('xls', $id);
        exit();
    } else if ($action == 'text') {
        grade_download('txt', $id);
        exit();
    }

    //print_header($course->shortname.': Ponderaciones '.get_string('grades'), $course->fullname, grade_nav($course, $action));
    
    print_header($course->shortname.': Ponderaciones ', $course->fullname, grade_nav($course, $action));


$id_cursox=$course->id;

//ENLACES al final
$link_curso='<strong><a href="'.$CFG->wwwroot.'/course/view.php?id='. $id_cursox .'"><u>Regresar al Curso</u></a></strong>';



// DEBO REVISAR SI EL DATO ES NUEVO o YA EXISTE Y SOLO HAY QUE ACTUALIZARLO
// TABLA senati_pesos_recursos
// id_recurso id de mdl_quiz (id y COURSE) o de mdl_assignment (id y COURSE)
// tipo_recurso assignment o quiz
// peso_recurso
// id_curso


// ME DA CERO SI RECIEN ENTRO
$numero_assign = count($_POST["inp_id_assign_"]);
$numero_quiz = count($_POST["inp_id_quiz_"]);
$numero_foro = count($_POST['inp_id_foro_']);

//ACA ME ENCARGO DE GRABAR LOS DATOS SI ES QUE HE RECIBIDO DATOS
if ($numero_assign !=0)
	{
	for ($i=0; $i<$numero_assign; $i++)
	     {
			$valor_id_assign= $_POST["inp_id_assign_"][$i];
			$valor_peso_assign=$_POST["inp_pond_assign_"][$i];
			  
			$query = 'SELECT count(*) as total FROM senati_pesos_recursos where id_curso='. $id_cursox . ' and id_recurso=' . $valor_id_assign . ' and  tipo_recurso=1';
		    $result = pg_query($query) or die('Query failed 100: ' . pg_last_error());
		    
		    $total_registros=0;
			  
			  while($row_assign=pg_fetch_array($result)) 
							{
							$total_registros=$row_assign["total"];
						  }	
				if ($total_registros==0)
						{//SE HACE UN INSERT
							$qinsert='INSERT INTO senati_pesos_recursos (id_recurso,peso_recurso,id_curso,tipo_recurso, id_usuario) VALUES ('. $valor_id_assign . ',' . $valor_peso_assign . ','. $id_cursox . ',1,'. $id_usuario . ' ); commit;'; 
							$rex = pg_query($qinsert);
						}
				else
					  {//ACA TENGO QUE HACER UN UPDATE
					  	$qupdate='Update senati_pesos_recursos set peso_recurso='. $valor_peso_assign. ', id_usuario='. $id_usuario . ' where id_curso='. $id_cursox. ' and tipo_recurso=1 and id_recurso='. $valor_id_assign. ' ; commit;'; 
						  $rey = pg_query($qupdate);
					
				    }
				$datos_salvados="si";
			 }
	}

if ($numero_quiz !=0)
	{
			for ($i=0; $i<$numero_quiz; $i++)
	     {
			  
			$valor_id_quiz= $_POST["inp_id_quiz_"][$i];
			$valor_peso_quiz=$_POST["inp_pond_quiz_"][$i];
			  
			  
 			$query = 'SELECT count(*) as total FROM senati_pesos_recursos where id_curso='. $id_cursox . ' and id_recurso=' . $valor_id_quiz . ' and  tipo_recurso=2';
		    $result = pg_query($query) or die('Query failed 137: ' . pg_last_error());
		    
		    $total_registros=0;
			  
			  while($row_quiz=pg_fetch_array($result)) 
							{
							$total_registros=$row_quiz["total"];
						  }	
				if ($total_registros==0)
						{//SE HACE UN INSERT
							$qinsert='INSERT INTO senati_pesos_recursos (id_recurso,peso_recurso,id_curso,tipo_recurso, id_usuario) VALUES ('. $valor_id_quiz . ',' . $valor_peso_quiz . ','. $id_cursox . ',2,'. $id_usuario . '); commit;'; 
							$rex = pg_query($qinsert);
						}
				else
						{//ACA TENGO QUE HACER UN UPDATE
						 $qupdate='Update senati_pesos_recursos set peso_recurso='. $valor_peso_quiz . ' , id_usuario='. $id_usuario . ' where id_curso='. $id_cursox. ' and tipo_recurso=2 and id_recurso='. $valor_id_quiz .' ; commit;'; 
						  $rey = pg_query($qupdate);
					
						}
				$datos_salvados="si";		
			 }
////////////////// FOROS ///////////////////////////////
if ($numero_foro !=0)
	{
		for ($i=0; $i<$numero_foro; $i++)
	     {
		    $valor_id_foro= $_POST["inp_id_foro_"][$i];
			$valor_peso_foro=$_POST["inp_pond_foro_"][$i];
			  
			$query = 'SELECT count(*) as total FROM senati_pesos_recursos where id_curso='. $id_cursox . ' and id_recurso=' . $valor_id_foro . ' and  tipo_recurso=3';
		    $result = pg_query($query) or die('Query failed 171: ' . pg_last_error());
		    
		    $total_registros=0;
			  
			  while($row_foro=pg_fetch_array($result)) 
							{
							$total_registros=$row_foro["total"];
						  }	
				if ($total_registros==0)
						{//SE HACE UN INSERT
							$qinsert='INSERT INTO senati_pesos_recursos (id_recurso,peso_recurso,id_curso,tipo_recurso, id_usuario) VALUES ('. $valor_id_foro . ',' . $valor_peso_foro . ','. $id_cursox . ',3,'. $id_usuario . '); commit;'; 
							$rex = pg_query($qinsert);
						}
				else
						{//ACA TENGO QUE HACER UN UPDATE
						 $qupdate='Update senati_pesos_recursos set peso_recurso='. $valor_peso_foro . ' , id_usuario='. $id_usuario . ' where id_curso='. $id_cursox. ' and tipo_recurso=3 and id_recurso='. $valor_id_foro .' ; commit;'; 
						  $rey = pg_query($qupdate);
					
						}
				$datos_salvados="si";		
			 }
		}	  
			  
	}	
	
// debo saber si tiene un patron semilla y mostrarlo
$query_semilla = 'SELECT id_patron_semilla FROM mdl_course where id='. $id_cursox;
$result_semilla = pg_query($query_semilla) or die('Query failed 198: ' . pg_last_error());
$roq=pg_fetch_array($result_semilla);
$id_curso_semilla=$roq["id_patron_semilla"];

	
?>

<BR>

<strong>PONDERACION DE NOTAS DE TAREAS y/o CUESTIONARIOS correspondientes al Curso : </strong><BR><BR>
<strong style="color:blue"><?PHP echo $course->fullname?></strong>&nbsp;<strong>(ID del CURSO :</strong> <?PHP echo $course->id?>)
<?PHP
if ($datos_salvados=="si")
	{
?>	
<BR><BR><strong style="color:red">Sus Datos fueron salvados con &eacute;xito ...</strong>
<?PHP
	}
?>
<BR>
<BR>
<?PHP

// Connecting, selecting database
// FUNCIONA ACA


// Performing SQL query
$query  = "SELECT distinct(A.id), A.name, peso_recurso, C.section FROM mdl_assignment A ";
$query .= "left join senati_pesos_recursos on id_recurso=A.id and tipo_recurso=1 and id_curso=". $id_cursox . " "; 
$query .= "inner Join mdl_course_modules B on A.course=B.Course and module=1 and instance=A.id ";
$query .= "inner Join mdl_course_sections C on B.section=C.id "; 
$query .= "where A.course=". $id_cursox . " order by C.section asc, A.id asc";

$result = pg_query($query) or die('Query failed: ' . pg_last_error());
// Printing results in HTML
?>



<FORM name="thisform" id="thisform" method="post">
<TABLE border=1 cellspacing=1 cellpadding=1>
<TR bgcolor=#dddddd height=23>
<td><STRONG style="color:blue">TAREAS (assignments)</strong></td>
<td><STRONG style="color:blue">Ponderaci&oacute;n</strong></td>
<td align="center"><STRONG style="color:blue">&nbsp;Unidad&nbsp;</strong></td>
</TR>
<?php

$c1=0;
while($row=pg_fetch_array($result)) 
	{
$c1++;		
?>
<TR><td ><?php echo $row["name"]. ' (' . $row["id"] . ')' ?>&nbsp;</td>
<td><INPUT name="inp_id_assign_[]" type="hidden" value="<?php echo $row["id"] ?>">&nbsp;
	  <INPUT name="inp_pond_assign_[]" type="text" onkeypress="numeros();" size=2 maxlength=3 value="<?php echo $row["peso_recurso"] ?>">&nbsp;
</td>
<td align="center">
<?PHP echo $row["section"]?>
</td>

</TR>

<?PHP		  
 
	}
echo "</TABLE>";
?>


<?PHP

// Connecting, selecting database
// FUNCIONA ACA

// Performing SQL query
$query  = "SELECT distinct(A.id), A.name, peso_recurso, C.section FROM mdl_quiz A ";
$query .= "left join senati_pesos_recursos on id_recurso=id and tipo_recurso=2 and id_curso=". $id_cursox . " ";
$query .= "inner Join mdl_course_modules B on A.course=B.Course and module=12 and instance=A.id ";
$query .= "inner Join mdl_course_sections C on B.section=C.id "; 
$query .= "where A.course=". $id_cursox . " order by C.section asc, A.id asc";

$result = pg_query($query) or die('Query failed: ' . pg_last_error());
// Printing results in HTML
?>
<BR>
<BR>

<TABLE border="1" cellspacing="1" cellpadding="1">

<TR bgcolor=#dddddd height=23>
<td><STRONG style="color:blue">CUESTIONARIOS (quiz)</strong></td>
<td><STRONG style="color:blue">Ponderaci&oacute;n</strong> </td>
<td align="center"><STRONG style="color:blue">&nbsp;Unidad&nbsp;</strong></td>
</TR>	

<?php
$c2=0;
while($row=pg_fetch_array($result)) 
	{
$c2++;				
?>
<TR><td ><?php echo $row["name"] . ' (' . $row["id"] . ')' ?>&nbsp;</td>
<td><INPUT name="inp_id_quiz_[]" type="hidden" value="<?php echo $row["id"] ?>">&nbsp;
<INPUT name="inp_pond_quiz_[]" onkeypress="numeros();" type="text" size=2 maxlength=3 value="<?php echo $row["peso_recurso"] ?>">&nbsp;
</td>
<td align="center">
<?PHP echo $row["section"]?>
</td>
</TR>

<?PHP		  
 
}
echo "</TABLE>";
?>


<?PHP

// Connecting, selecting database
// FUNCIONA ACA

// Performing SQL query
$query  = "SELECT distinct(A.id), A.name, peso_recurso, C.section FROM mdl_forum A ";
$query .= "left join senati_pesos_recursos on id_recurso=A.id and tipo_recurso=3 and id_curso=". $id_cursox . " ";
$query .= "inner Join mdl_course_modules B on A.course=B.Course and module=5 and instance=A.id ";
$query .= "inner Join mdl_course_sections C on B.section=C.id "; 
$query .= "where A.course=". $id_cursox . " and A.scale=20 order by C.section asc, A.id asc";

$result = pg_query($query) or die('Query failed: ' . pg_last_error());
// Printing results in HTML
?>
<BR>
<BR>

<TABLE border=1 cellspacing=1 cellpadding=1>

<TR bgcolor=#dddddd height=23>
<td><STRONG style="color:blue">FOROS (forums)</strong></td>
<td><STRONG style="color:blue">Ponderaci&oacute;n</strong> </td>
<td align="center"><STRONG style="color:blue">&nbsp;Unidad&nbsp;</strong></td>
</TR>	

<?php
$c3=0;
while($row=pg_fetch_array($result)) 
	{
$c3++;				
?>
<TR>
<td ><?php echo $row["name"] . ' (' . $row["id"] . ')' ?>&nbsp;</td>
<td><INPUT name="inp_id_foro_[]" type="hidden" value="<?php echo $row["id"] ?>">&nbsp;
<INPUT name="inp_pond_foro_[]" onkeypress="numeros();" type="text" size=2 maxlength=3 value="<?php echo $row["peso_recurso"] ?>">&nbsp;
</td>
<td align="center">
<?PHP echo $row["section"]?>
</td>
</TR>
<?PHP		  
 
	}
echo "</TABLE>";
?>

<br>
<br>




<?PHP 

if (isadmin())
	{
?>
<a href="javascript:salvar();"><INPUT onclick="salvar();" type="button" name="bot_salvar" value="Salvar Datos"></a>

<br>
<br>
<strong style="color:blue">NOTA : La suma de todos los pesos de ponderaci&oacuten debe ser igual a 100.</strong>
<HR>
<BR />
PATRON SEMILLA <input type=text onKeyPress="numeros();" size=5 name="tx_patron_semilla" id="tx_patron_semilla" value="<?PHP echo $id_curso_semilla?>">
&nbsp;
<a href="javascript:leer_semilla();"><INPUT onclick="leer_semilla();" type="button" name="boton_leer_ponde" value="Leer Ponderaciones desde la Semilla" ></a>
&nbsp;<strong><font color=red id=font_pondera></font></strong>
<?PHP
    //// DE isadmin 
	}
?>

</FORM>
<BR>
<div id="div_pondera" style="display:none">
</div>

<BR />
<?PHP echo $link_curso?>

<br>
<br>


<a href="http://virtual.senati.edu.pe/course/datos_curso.php?id=<?PHP echo $id_cursox?>"><u>Ir a Datos Generales</u></a>


<?PHP
    print_footer($course);
?>
<script language="javascript">
function obje(ide){
	var obex=document.getElementById(ide);
	return obex;
}

function numeros(){
// solo acepta numeros
wek=window.event.keyCode;
if (wek<48 || wek>57){window.event.keyCode=0;}
}

function trim(str)
{
if(!str || typeof str != "string")
return "";
return str.replace(/^[\s]+/,'').replace(/[\s]+$/,'').replace(/[\s]{2,}/,' ');
}

// ACA VALIDO QUE LOS DATOS NO ESTEN VACIOS Y QUE NO SUMEN MAS O MENOS DE 100
function salvar(){
	var cole = document.getElementsByTagName("INPUT")
	var lex=cole.length;
	sw=true;
	var conte;
	for (i=0;i<lex;i++)
	{
		  conte=trim(cole.item(i).value);
		  if (conte=="" && cole.item(i).name != "tx_patron_semilla")
	   		{sw=false;
	   		 break;	
	   		}
	}   		
	
	//if (sw==false)
	if (1==2)
		{alert ("Debe llenar todos los datos de ponderacion por favor.");}
	else
		{	
		suma_pond=0;
		totinp=0;
		for (i=0;i<lex;i++)
			{
				var nombre, ss;                //Declare variables.
				var nombre=cole.item(i).name;
				ss = nombre.substr(0, 8);  
					if (ss=="inp_pond")
					{totinp++;
					 suma_pond=suma_pond*1+1-1+ 1*cole.item(i).value;
					}
			}
			if (suma_pond==100)
			{thisform.submit();	
				}
			else
			{alert("La suma debe ser 100, la suma actual es : "+ suma_pond);}
		}
}

/////////////////////////////
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

/////////////// LEER AJAX SEMILLA /////////////

function leer_semilla(){
   var id_curso_semilla=trim(obje("tx_patron_semilla").value);
   if (id_curso_semilla!="")
	   {
	   obje("font_pondera").innerText ="Espere ...";
	   url="pondera01_ajax.php";
	   var xmlo=crea_xmlhttpPost(url);
			 xmlo.onreadystatechange = function()
			  {
			   if (xmlo.readyState == 4)
				   {
				   update_ponderaciones(xmlo.responseText);
				   }
			  }
		qstr="id_curso_semilla="+escape(id_curso_semilla);
		xmlo.send(qstr);
		}
}

function update_ponderaciones(str){
	obje("div_pondera").innerHTML=str;
	////ACA DEBO HACER TODO LA MACANA DE RELLENAR LOS INPUTS DEL CURSO ACTUAL
	
	// inp_pond_foro_[] son los que recibiran
	// inp_pond_assign_[] son los que recibiran
	// inp_pond_quiz_[] son los que recibiran
	
	// inp_ponx_assign[] LOS QUE DARAN DATOS
	// inp_ponx_quiz[] LOS QUE DARAN DATOS
	// inp_ponx_foro[] LOS QUE DARAN DATOS
	
	//Tareas
	var cole1=document.getElementsByName("inp_ponx_assign[]"); // Leido del Ajax
	var cole2=document.getElementsByName("inp_pond_assign_[]"); //Reciben Datos
	var lex1=cole1.length;
	var lex2=cole2.length;
	for (i=0;i<lex1;i++)
		{
		if (i<=lex2-1)
			{
			 cole2[i].value=cole1[i].value;
			}
		}
	
    var cole1=document.getElementsByName("inp_ponx_quiz[]"); // Leido del Ajax
	var cole2=document.getElementsByName("inp_pond_quiz_[]"); //Reciben Datos
	var lex1=cole1.length;
	var lex2=cole2.length;
	for (i=0;i<lex1;i++)
		{
		if (i<=lex2-1)
			{
			 cole2[i].value=cole1[i].value;
			}
		}

    var cole1=document.getElementsByName("inp_ponx_foro[]"); // Leido del Ajax
	var cole2=document.getElementsByName("inp_pond_foro_[]"); //Reciben Datos
	var lex1=cole1.length;
	var lex2=cole2.length;
	for (i=0;i<lex1;i++)
		{
		if (i<=lex2-1)
			{
			 cole2[i].value=cole1[i].value;
			}
		}
	obje("font_pondera").innerText ="Listo, ahora debe Salvar los Datos !";	
}


</script>

