<?php

	// 13 de OCTUBRE 2012
	// 26 de Agosto 2013 JUSCE
	// IMPORTACION DE FOROS
	// 29 de ABRIL 2014: Creación de Foros: Tener los id de los posts del curso semilla en la página
	

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

	/// FECHA ACTUAL PARA INGRESAR A LA BD		
	$ano_actual=date("Y");
	$mes_actual=date("n");
	$dia_actual=date("j");
	$hora_actual=date("H");
	$min_actual=date("i");
	
	$fecha_hora_actual=$dia_actual.'-'.$mes_actual.'-'.$ano_actual. ' ' . $hora_actual. ":".$min_actual;
	
	//ESTO ME DA LA HORA REAL QUE DEBO METER EN LA BD
	$fecha_hora_actual_integer = strtotime ($fecha_hora_actual);
	$diasem=date('w',$fecha_hora_actual_integer);
	$reto='';
	if ($diasem==1){$reto='Lunes';}
	if ($diasem==2){$reto='Martes';}
	if ($diasem==3){$reto='Miercoles';}
	if ($diasem==4){$reto='Jueves';}
	if ($diasem==5){$reto='Viernes';}
	if ($diasem==6){$reto='S&aacute;bado';}
	if ($diasem==0){$reto='Domingo';}
	$fecha_hora_actual=$reto. ' ' .date('d-m-Y H:i',$fecha_hora_actual_integer);
    ////// FIN DE FECHA
		
		
	$accion=$_POST["tx_accion"];
	$id_foro_seleccionado="";
	if ($accion=="salvar")
		{
		//valores recuperados
		$id_tutorx=trim($_POST["sel_id_tutor"]);
		$id_grupox=trim($_POST["sel_id_grupo"]);
		$id_forox=trim($_POST["sel_id_foro"]);
		
		
		$name_forox=trim($_POST["tx_name_foro"]);
		$tx_textox=$_POST["tx_texto"];
		$datax=pg_escape_string($tx_textox);
		
		if ($id_tutorx=="" || $id_grupox=="" || $id_forox=="" || $name_forox=="")
			{
			$mensaje="<strong><font color=red>FALTAN DATOS.</font></strong>";			
			}
		else
			{
			////////////////////////////// CON ESTAS LINEAS SE CREAR CADA TEMA por TUTOR-GRUPO /////////////////////////////////////////////////////////////////
			/// debo darle como parametros
			
			// $id_tutorx
			// $id_grupox
			// $id_forox
			
			// $fecha_hora_actual_integer
			// $id_curso_moodle
			// $datax
			// $name_forox
			// a menos que estos dos datos los saque de la tabla mdl_forum_posts con el id Subject y message  
			
			///////// DEBO IDENTIFICAR EL ID FORO PARA SELECCIONARLO EN LA SGTE PAGINA
			$id_foro_seleccionado=$id_forox;
			$qinsert  ="insert into mdl_forum_discussions (forum, name, userid, groupid, timemodified,course) values (";
			$qinsert .=$id_forox . ",'". $name_forox . "'," . $id_tutorx . "," . $id_grupox. "," . $fecha_hora_actual_integer .",". $id_curso_moodle .")";
			$rsinsert=pg_query($qinsert) or die('Query failed 71: ' . pg_last_error());
			
            // VERIFICAR CUAL ES EL ID que se GENERÓ
			$qselect  ="select id from mdl_forum_discussions where forum=". $id_forox . " and name='". $name_forox . "' and ";
			$qselect .="userid=". $id_tutorx . " and groupid=". $id_grupox . " and timemodified=". $fecha_hora_actual_integer; 
			$rselect=pg_query($qselect) or die('Query failed 77: ' . pg_last_error());
			$rox_se=pg_fetch_array($rselect);
			
			$id_new_discussion=$rox_se["id"];
			
			$qinsert  ="insert into mdl_forum_posts (discussion, subject,userid,message,created,modified,format,parent) values (";
			$qinsert .=$id_new_discussion . ",'". $name_forox . "',". $id_tutorx . ",'". $datax. "'," ;
			$qinsert .=$fecha_hora_actual_integer . ",". $fecha_hora_actual_integer . ",1,0)";
			$rsinsert=pg_query($qinsert) or die('Query failed 85: ' . pg_last_error());
			
			
			// VERIFICAR CUAL ES EL ID que se GENERÓ
			$qselect  ="select id from mdl_forum_posts where discussion=". $id_new_discussion . " and subject='". $name_forox . "' and ";
			$qselect .="userid=". $id_tutorx . " and modified=". $fecha_hora_actual_integer;
			$rselect=pg_query($qselect) or die('Query failed 90: ' . pg_last_error());
			$rox_se=pg_fetch_array($rselect);
			
			$id_new_post=$rox_se["id"];
			
			/// UPDATE DEL firstpost en mdl_form_discussions
			$qupdate="update mdl_forum_discussions set firstpost=". $id_new_post. " where id=".$id_new_discussion;
			$rupdate=pg_query($qupdate) or die('Query failed 96: ' . pg_last_error());

			//// ESTO ES UNA FUNCION !!!!!! del 18 de OCTUBRE 2012 JUSCE
            //select remplaza_slashes de la tabla mdl_forum_posts
			$qreplace="select remplaza_slashes(". $id_new_post . ")";
			$rreplace=pg_query($qreplace) or die('Query failed 104: ' . pg_last_error());
			////////////////////////////// CON ESTAS LINEAS SE CREAR CADA TEMA por TUTOR-GRUPO /////////////////////////////////////////////////////////////////
			
	        
			$mensaje ="<font color=red>Se Cre&oacute; un Foro : <BR>";
			$mensaje .="id_discussion=". $id_new_discussion ."<BR>";
			$mensaje .="id_post=". $id_new_post ."</font>";
			}
		/// FIN DE SALVAR	
		}
		
function crear_foros($id_tutorx,$id_grupox,$id_forox,$id_cursox, $id_postix, $fecha_actual){
		////////////////////////////// CON ESTAS LINEAS SE CREAR CADA TEMA por TUTOR-GRUPO /////////////////////////////////////////////////////////////////
		/// debo darle como parametros
		
		// $id_tutorx
		// $id_grupox
		// $id_forox
		
		// $fecha_hora_actual_integer
		// $id_curso_moodle
		
		// Esto lo saco con $id_postix
		// $datax
		// $name_forox
		// a menos que estos dos datos los saque de la tabla mdl_forum_posts con el id Subject y message  
		
		//EXTRAIGO LOS DATOS DEL POST A IMPORTAR
		
		$qextrae  ="Select subject, message from mdl_forum_posts where id=". $id_postix;
		$rextrae=pg_query($qextrae) or die('Query failed 1571: ' . $id_postix . " - ". pg_last_error());
		$rox_extrae=pg_fetch_array($rextrae);
		
		$name_forox=$rox_extrae["subject"];
		$datax=pg_escape_string($rox_extrae["message"]);
	    
	    
	
		///////// DEBO IDENTIFICAR EL ID FORO PARA SELECCIONARLO EN LA SGTE PAGINA
		//$id_foro_seleccionado=$id_forox;
		$qinsert  ="insert into mdl_forum_discussions (forum, name, userid, groupid, timemodified,course) values (";
		$qinsert .=$id_forox . ",'". $name_forox . "'," . $id_tutorx . "," . $id_grupox. "," . $fecha_actual .",". $id_cursox .")";
		$rsinsert=pg_query($qinsert) or die('Query failed 71: ' . pg_last_error());
		
		// VERIFICAR CUAL ES EL ID que se GENERÓ
		$qselect  ="select id from mdl_forum_discussions where forum=". $id_forox . " and name='". $name_forox . "' and ";
		$qselect .="userid=". $id_tutorx . " and groupid=". $id_grupox . " and timemodified=". $fecha_actual; 
		$rselect=pg_query($qselect) or die('Query failed 157: ' . pg_last_error());
		$rox_se=pg_fetch_array($rselect);
		
		$id_new_discussion=$rox_se["id"];
		
		$qinsert  ="insert into mdl_forum_posts (discussion, subject,userid,message,created,modified,format,parent) values (";
		$qinsert .=$id_new_discussion . ",'". $name_forox . "',". $id_tutorx . ",'". $datax. "'," ;
		$qinsert .=$fecha_actual . ",". $fecha_actual . ",1,0)";
		$rsinsert=pg_query($qinsert) or die('Query failed 210: ' . pg_last_error());
		
		
		// VERIFICAR CUAL ES EL ID que se GENERÓ
		$qselect  ="select id from mdl_forum_posts where discussion=". $id_new_discussion . " and subject='". $name_forox . "' and ";
		$qselect .="userid=". $id_tutorx . " and modified=". $fecha_actual;
		$rselect=pg_query($qselect) or die('Query failed 216: ' . pg_last_error());
		$rox_se=pg_fetch_array($rselect);
		
		$id_new_post=$rox_se["id"];
		
		/// UPDATE DEL firstpost en mdl_form_discussions
		$qupdate="update mdl_forum_discussions set firstpost=". $id_new_post. " where id=".$id_new_discussion;
		$rupdate=pg_query($qupdate) or die('Query failed 96: ' . pg_last_error());

		//// ESTO ES UNA FUNCION !!!!!! del 18 de OCTUBRE 2012 JUSCE
		//select remplaza_slashes de la tabla mdl_forum_posts
		$qreplace="select remplaza_slashes(". $id_new_post . ")";
		$rreplace=pg_query($qreplace) or die('Query failed 228: ' . pg_last_error());
		
		
		////////////////////////////// CON ESTAS LINEAS SE CREAR CADA TEMA por TUTOR-GRUPO /////////////////////////////////////////////////////////////////
		return "OK";
}	


		
	//// ACA SALVO CON EL METODO GRUPAL //////////////////
	
	if ($accion=="salvar total")
		{
		//echo "<INPUT type=text name=id_tutorex[] readOnly value='". $id_tutorex[$i] ."'>";
		//echo "<INPUT type=text name=id_grupex[] readOnly value='". $id_grupex[$i] ."'>";
		//echo "<INPUT type=text name=id_forex[] readOnly value='". $id_forex[$j] ."'>";
		//echo "<INPUT type=text name=id_postex[] value=''>";
		
		$mensaje="";
		$fecha_actual1=$fecha_hora_actual_integer;
		$id_cursox1=$id_curso_moodle;
		$numero_registros = count($_POST['id_tutorex']);
		$total_importar=0;
	   	for ($i=0; $i<$numero_registros; $i++)
			{
			$id_postix1=trim($_POST["id_postex"][$i]);
			
			if ($id_postix1 !="")
			    {
				//// IMPORTAR DE VERDAD
				$id_tutorx1=$_POST["id_tutorex"][$i];
				$id_grupox1=$_POST["id_grupex"][$i];
				$id_forox1=$_POST["id_forex"][$i];
				crear_foros($id_tutorx1,$id_grupox1,$id_forox1,$id_cursox1, $id_postix1, $fecha_actual1);
				$total_importar++;
				}
			}
		$mensaje="<strong><font color=red>Se importaron ".	$total_importar . " Temas en los Foros </font></strong>";
		
		// Debo Leer Todos Los Inputs y de ahi llamar a la function
		//function crear_foros($id_tutorx,$id_grupox,$id_forox,$id_cursox, $id_postix, $fecha_actual){
		// Luego crear un mensaje
		}

	
	
	


    /////////////////////////////////////////////////////	

	$nombre_moodle=$course->fullname;
    $titulo_pagina1 = "Creacion de Foros por Grupo";
	$enlace="<a href='view.php?id=". $id_curso_moodle . "'>". $nombre_moodle."</a> &gt; Creaci&oacute;n de Foros por Grupo";
	print_header("$site->shortname : ". $titulo_pagina1, "X1", $enlace, "", "", true, "");
	
	// Listar los Foros si hay
	// Listar los Grupos y sus Tutores Asignados
	
    //// Saber si hay registros 
    $existen_foros=false;	
	$query_existen_foros="SELECT COALESCE((SELECT 1 FROM mdl_forum WHERE course=". $id_curso_moodle ." LIMIT 1),0) as existe";
    $result_existen_foros=pg_query($query_existen_foros) or die('Query failed 45 : ' . pg_last_error());
	
	$rox1=pg_fetch_array($result_existen_foros);
	
	if ($rox1["existe"]=="1")
		{$existen_foros=true;}
	else
		{$existen_foros=false;}
	
	if ($existen_foros)
		{
		///	Listar las foros por Grupo existentes
		$query_lista_foros  ="Select A.name as nombre_foro, A.id as id_foro, C.section as unidad from mdl_forum A ";
		$query_lista_foros .="inner join mdl_course_modules B on B.instance=A.id and A.course=B.course ";
		$query_lista_foros .="inner join mdl_course_sections C on C.id=B.section ";
		$query_lista_foros .="where B.module=5 and A.scale<>-1 and A.type='general' and A.course=". $id_curso_moodle. " " ;
		$query_lista_foros .="order by C.section";
		$result_lista_foros = pg_query($query_lista_foros) or die('Query failed 62 : ' . pg_last_error());
		}
	else
        {
		$mensaje="<font color=red>Este Curso no tiene Foros.</font>";
        }		


// PONER LOS TUTORES Y SUS GRUPOS y si TIENEN FOROS O NO

   $query_tutores  ="Select A.userid as id_tutor, firstname, lastname from mdl_user_teachers A ";
   $query_tutores .="inner join mdl_user B on A.userid=B.id ";
   $query_tutores .="where A.course=". $id_curso_moodle. " " ;
   $query_tutores .="order by B.lastname";
   $result_tutores = pg_query($query_tutores) or die('Query failed 95 : ' . pg_last_error());
	

?>
<strong style="color:blue">Creaci&oacute;n de Foros por Grupo</strong><BR>

<?PHP
echo "<p>";
echo "<strong>FECHA Y HORA ACTUAL (D/M/A)</strong> : ". $fecha_hora_actual . " (UNIX ". $fecha_hora_actual_integer. ")";
echo "</p>";

if ($mensaje !="")
	{
	echo "<p>";
	echo $mensaje;
	echo "</p>";
	}
?>



<table cellpadding=0 cellspacing=0 border=0>
<tr>
<td>



<form method="post" action="" name="thisform" id="thisform">

<?PHP 

	// TUTORES - GRUPOS
	// DEBO PONER CUANTOS FOROS TIPO CERO TIENE CADA TUTOR GRUPO
	
	print_simple_box_start("left");
	echo "<strong>Tutores - Grupos</strong>";
	echo "<BR><BR>";
	$tot_foros=0;
	
	//// Para la creacion masiva de Foros JUSCE 19 de Agosto 2013
	$total_combina=0;
	// Creo array de id_tuores e id_grupos
	
	$total_tgf=0; /////// esto es un array de tutor, grupo y foro
	
	while($rox_tg=pg_fetch_array($result_tutores))
		{
		//A.userid as id_tutor, firstname, lastname,C.name as nombre_grupo, C.id as id_grupo
		$id_tutorg    = $rox_tg["id_tutor"];
		$nombre_tutor = $rox_tg["lastname"]. ", ". $rox_tg["firstname"];

		echo "<strong>Tutor : ". $nombre_tutor . " (ID=". $id_tutorg. ")</strong><BR>";
		
	    $query_grupos  ="Select B.name as nombre_grupo, B.id as id_grupo from mdl_groups_members A ";
	    $query_grupos .="inner join mdl_groups B on B.id=A.groupid ";
	    $query_grupos .="where B.courseid=". $id_curso_moodle. " and A.userid=". $id_tutorg ;
	    $query_grupos .="order by 1";
	    $result_grupos = pg_query($query_grupos) or die('Query failed 135 : ' . pg_last_error());
		    echo "<UL>";
			$total_foros_del_tutor=0;
			while($rox_gg=pg_fetch_array($result_grupos))
			     {
				  $id_grupo     = $rox_gg["id_grupo"];
				  $nombre_grupo = $rox_gg["nombre_grupo"];				 
				 
				 if ($id_tutorx==$id_tutorg && $id_grupo==$id_grupox)
				    {
					echo "<LI>". $nombre_grupo . " (id=". $id_grupo . ") <font color=red>Aqu&iacute; estuve</font>&nbsp;";
					}
				else
				   {
				   echo "<LI>". $nombre_grupo . " (id=". $id_grupo . ") ";
				   }
				  
				  ///
				  ///ACA DEBO PONER UN CHECK PARA SELECCIONAR LOS SELECT DEL COSTADO
				  /// con $id_tutorg e $id_grupo
				  echo " <a href='javascript:selex(". $id_tutorg  .",". $id_grupo  .")'><u><font color=green>seleccionar</font></u>&nbsp;<img src='../pix/flechita.gif'></a>";
				  
				  
				  //// Para la creacion masiva de Foros JUSCE 19 de Agosto 2013
	              $id_tutorex[$total_combina]=$id_tutorg;
				  $nombre_tutorex[$total_combina]=$nombre_tutor;
  	              $id_grupex[$total_combina]=$id_grupo;
				  $nombre_grupex[$total_combina]=$nombre_grupo;
				  
				  $total_combina++;
				  
				  
				  // DEBO PONER CUANTOS FOROS TIPO CERO TIENE CADA TUTOR GRUPO
				  // TENGO
				  // $id_grupo
				  // $id_tutorg
				  // $id_curso_moodle

				  //$qcuento_foros  ="Select count(*) as total_foros, E.section as unidad from mdl_forum_posts A ";
				  
				  $qcuento_foros  ="Select count(*) as total_foros, E.section as unidad, C.id as id_foro from mdl_forum_posts A ";
				  $qcuento_foros .="inner join mdl_forum_discussions B on B.id=A.discussion ";
				  $qcuento_foros .="inner join mdl_forum C on B.forum=C.id ";
  				  $qcuento_foros .="inner join mdl_course_modules D on D.instance=C.id and C.course=D.course ";
  				  $qcuento_foros .="inner join mdl_course_sections E on D.section=E.id ";
				  $qcuento_foros .="where B.userid=". $id_tutorg . " and B.groupid=". $id_grupo . " and C.course=". $id_curso_moodle ." and A.parent=0 and D.module=5 ";
				  $qcuento_foros .="group by E.section, C.id ";
				  $qcuento_foros .="order by E.section ";
				  
				  
				  $rs_cuento_foros = pg_query($qcuento_foros) or die('Query failed 247 : ' . pg_last_error());
				  while($rox_cf=pg_fetch_array($rs_cuento_foros))
						{
						////////// ACA TENGO EL ID_FORO, ID_TUTOR, ID_GRUPO
						$total_foros_del_tutor++;
						$total_foros=$rox_cf["total_foros"];
						$unidad_foros=$rox_cf["unidad"];
						$tot_foros=$tot_foros+$total_foros;
						echo "<BR><font color=blue>" . $total_foros . " Foro(s) en la Unidad ". $unidad_foros. " y en ese Grupo.</font>";
						
						$tgf_id_tutor[$total_tgf]=$id_tutorg;
						$tgf_id_grupo[$total_tgf]=$id_grupo;
						$tgf_id_foro[$total_tgf]=$rox_cf["id_foro"];
						$total_tgf++;
						}
				  echo "</LI>";
			     } 
				 if( $total_foros_del_tutor==0)
				   {
				   echo "<strong><font color=red>Este Tutor no tiene Foros.</font></strong>";
				   }
			echo "</UL>";	 
		}
	

	//// PONER CANTIDAD DE FOROS Y DE GRUPOS
	
	echo "<strong style='color:blue'>TOTAL FOROS : " .$tot_foros . "</strong><BR><BR>";
	
	echo "<strong style='color:blue' id=fon_tot_grupos></strong><BR><BR>";
	
	
	echo "<font color=red>Cada Tutor-Grupo debe tener M&iacute;nimo un FORO por UNIDAD.</font>";
	print_simple_box_end();
?>

<?PHP
print_simple_box_start("");	
?>

<table cellpadding=3 cellspacing=3 border=1>
<tr>
<td bgcolor=silver colspan=2><strong>CREAR TEMA EN EL FORO</strong></td>
</tr>


<TR>
<td><strong>TUTOR</strong></td>




<td><SELECT id="sel_id_tutor" name="sel_id_tutor">
<?PHP
	$q1  ="Select userid, firstname, lastname from mdl_user_teachers A ";
	$q1 .="inner join mdl_user B on B.id=A.userid ";
	$q1 .="Where A.course=". $id_curso_moodle ;
	$r1=pg_query($q1) or die('Query failed 268: ' . pg_last_error());
	while($rox_tut=pg_fetch_array($r1))
	{

	
?>
    <OPTION value="<?PHP echo $rox_tut["userid"] ?>"><?PHP echo $rox_tut["lastname"]. ", ". $rox_tut["firstname"] ?></OPTION> 
<?PHP
	}
?>
</SELECT>
</td>
</TR>
<TR>
<td><strong>ID GRUPO</strong></td>
<td>
<SELECT id="sel_id_grupo" name="sel_id_grupo">
<?PHP
	$q2  ="Select id, name from mdl_groups where courseid=". $id_curso_moodle ." order by name";
	$r2=pg_query($q2) or die('Query failed 286: ' . pg_last_error());
	$totix_grupos=0;
	while($rox_grup=pg_fetch_array($r2))
	{
	$totix_grupos++;
?>
    <OPTION value="<?PHP echo $rox_grup["id"] ?>"><?PHP echo $rox_grup["name"] ?></OPTION> 
<?PHP
	}
?>
</SELECT>
</td>
</TR>
<TR>
<td><strong>ID FORO</strong></td>
<td>

<SELECT id="sel_id_foro" name="sel_id_foro">

<?PHP
//// Para la creacion masiva de Foros JUSCE 19 de Agosto 2013
$total_forex=0;


	$q4  ="Select a.id as id_foro, name, C.section as unidad from mdl_forum A ";
	$q4 .="inner join mdl_course_modules B on B.instance=A.id ";
	$q4 .="inner join mdl_course_sections C on C.id=B.section ";
	$q4 .="Where A.course=". $id_curso_moodle ." and B.module=5 and type='general' and scale<>-1 ";
	$q4 .="order by C.section ";
	$r4=pg_query($q4) or die('Query failed 310: ' . pg_last_error());
	while($rox_foro=pg_fetch_array($r4))
	{
	//// Para la creacion masiva de Foros JUSCE 19 de Agosto 2013
	$id_forex[$total_forex]=$rox_foro["id_foro"];
	$unidad_forex[$total_forex]=$rox_foro["unidad"];
	$nombre_forex[$total_forex]=$rox_foro["name"];
	
	$total_forex++;
	///////
	
	$selx="";
	if ($id_foro_seleccionado==$rox_foro["id_foro"])
		{
		$selx="selected";
		}
	
	
?>
    <OPTION <?PHP echo $selx ?> value="<?PHP echo $rox_foro["id_foro"] ?>"><?PHP echo $rox_foro["name"] . " (Unidad ". $rox_foro["unidad"] . ")" ?></OPTION> 
<?PHP
	}
?>
</SELECT>
</td>
</TR>
<TR>
<td><strong>TEMA DEL FORO</strong></td>
<td>
<INPUT type="text" name="tx_name_foro" size=75 id="tx_name_foro" maxlength=200></td>
</TR>
</TABLE>



<p>
<INPUT type=submit value="Crear Tema en el Foro">
</p>

<strong>CONTENIDO DEL TEMA EN HTML</strong>
<?PHP
    $usehtmleditor = can_use_html_editor();
	$contenido="";
	
	print_textarea($usehtmleditor, 20, 50, 280, 200, "tx_texto", $contenido);
	if ($usehtmleditor)
	   {
		use_html_editor("tx_texto");
	   }
	?>
    

	
<?PHP    print_simple_box_end();
	// tendre un textarea id="edit-tx_texto" name="tx_texto"
?>



</td>
</tr>
</table>


<table cellpadding=0 cellspacing=0 border=0>
<tr>
<td>

<?PHP
print_simple_box_start("left");
?>


<div align=left>
<strong>IMPORTACION DE FOROS (Solo para Administradores)</strong><BR>
<?PHP


$qsemi  ="select id_patron_semilla from mdl_course where id=". $id_curso_moodle;
$rsemi=pg_query($qsemi) or die('Query failed 578: ' . pg_last_error());
$rox_semi=pg_fetch_array($rsemi);
$id_patron=$rox_semi["id_patron_semilla"];
$total_unidades=0;
if ($id_patron!="")
{
	echo "<HR><p><strong>Id del Curso Semilla :</strong> <a href='creacion_foros.php?id=". $id_patron ."' target=_blank><u> ". $id_patron. "</u></a></p>";
	/// PONER LOS POSTS POR UNIDAD DE ESE CURSO
	                    
						$existen_forox=false;
						$query_existen_forox="SELECT COALESCE((SELECT 1 FROM mdl_forum WHERE course=". $id_patron ." LIMIT 1),0) as existe";
						$result_existen_forox=pg_query($query_existen_forox) or die('Query failed 591 : ' . pg_last_error());
						
						$rox11=pg_fetch_array($result_existen_forox);
						
						if ($rox11["existe"]=="1")
							{$existen_forox=true;}
						else
							{$existen_forox=false;}
						
						if ($existen_forox)
							{
							///	Listar las foros por Grupo existentes Ordeno por UNIDAD
							$query_lista_forox  ="Select A.name as nombre_foro, A.id as id_foro, C.section as unidad from mdl_forum A ";
							$query_lista_forox .="inner join mdl_course_modules B on B.instance=A.id and A.course=B.course ";
							$query_lista_forox .="inner join mdl_course_sections C on C.id=B.section ";
							$query_lista_forox .="where B.module=5 and A.scale<>-1 and A.type='general' and A.course=". $id_patron. " " ;
							$query_lista_forox .="order by C.section";
							$result_lista_forox = pg_query($query_lista_forox) or die('Query failed 608 : ' . pg_last_error());
							
							
									// ITERO LOS FOROS
									echo "<p>";
									while($rox_forox=pg_fetch_array($result_lista_forox))
									{
										$id_forox=$rox_forox["id_foro"];
										$nombre_forox=$rox_forox["nombre_foro"];
										$unidax=$rox_forox["unidad"];
										$total_unidades=$unidax;
										echo "<strong>" . $nombre_forox . " (". $id_forox .") - UNIDAD : " . $unidax .", IDs de los posts y sus nombres:</strong><BR>";
										
										// VER SI TIENEN TEMAS CERO LOS TUTORES
										$query_lista_discussionx  ="Select C.id as id_post, A.name from mdl_forum_discussions A ";
										$query_lista_discussionx .="inner join mdl_forum_posts C on A.id=C.discussion and C.userid=A.userid and C.parent=0 and a.firstpost=C.id ";
										$query_lista_discussionx .="where A.forum=". $id_forox . " and A.userid in (Select B.userid from mdl_user_teachers B where B.course=". $id_patron.") order by C.id";
										$result_lista_discussionx = pg_query($query_lista_discussionx) or die('Query failed 628 : ' . pg_last_error());

										///////////////
										echo "<UL>";	
										while($rox_disx=pg_fetch_array($result_lista_discussionx))
											{
											//$nombre_tutor_disc = $rox_disc["lastname"]. ", ". $rox_disc["firstname"];
											//$id_discussionx=$rox_disx["id_discussion"]; /// id de la tabla mdl_forum_discussions
											$id_post_semilla=$rox_disx["id_post"]; /// id de la tabla mdl_forum_posts
											$nombre_post_semilla=$rox_disx["name"];
											echo "<LI>" . $id_post_semilla . " - ". $nombre_post_semilla . " <input type=hidden value=". $id_post_semilla. " name='id_post_semilla[". $unidax."]'>";
											echo "</LI>";
											}
										echo "</UL>";
										//echo "<BR>";
										///////////////
									}
									echo "</p>";
									echo "<INPUT type=button id='boton_rellenar' disabled value='Rellenar ID POSTs para luego Importarlos' onClick='rellena_posts();'>";
									echo "<BR>";
									echo "<HR>";
							}
						else
							{
							echo "<font color=red>Este Curso SEMILLA no tiene Foros.</font><BR>";
							}
}

// id_patron_semilla
// Mostrar el Curso SEMILLA
// echo $total_combina;
// echo $total_forex;

echo "<BR>";

//////////////// Debo tener un array que tenga tutor, grupo y foro : si existe NO LO PONGO
/* ESTE ES EL ARRAY
$tgf_id_tutor[$total_tgf]=$id_tutorg;
$tgf_id_grupo[$total_tgf]=$id_grupo;
$tgf_id_foro[$total_tgf]=$rox_cf["id_foro"];
$total_tgf++;
*/

$total_para_importar=0;
for ($j=0;$j<$total_forex;$j++)
	{
	echo "<p><strong>". $nombre_forex[$j] . " (Unidad : ". $unidad_forex[$j] . "). Tutor, Grupo</strong></p>";
	 for ($i=0;$i<$total_combina;$i++)
		{
		
		/// CHEQUEO QUE NO EXISTA YA UN FORO/TUTOR/GRUPO y asi limpio un poco la pantalla
		$sw=false;
		for ($k=0;$k<$total_tgf;$k++)
			{
			if ($id_tutorex[$i]==$tgf_id_tutor[$k] && $id_grupex[$i]==$tgf_id_grupo[$k] && $id_forex[$j]==$tgf_id_foro[$k])
			    {
				$sw=true;
				break;
				}
			}
		
        if ($sw==false)		
			{
			echo $nombre_tutorex[$i] . " , <u>Grupo :</u> " . $nombre_grupex[$i] . ", <u>ID POST</u> a importar : ";	
			echo "<INPUT type=text name=id_postex[] value='' size=6>";
			echo "<INPUT type=hidden name=id_tutorex[] value='". $id_tutorex[$i] ."'>";
			echo "<INPUT type=hidden name=id_grupex[]  value='". $id_grupex[$i] ."'>";
			echo "<INPUT type=hidden name=id_forex[] value='". $id_forex[$j] ."'>";
			echo "<INPUT type=hidden name=numero_unidad_post[] value='". $unidad_forex[$j] ."'>";
			
			echo "<BR>";
			$total_para_importar++;
			}
		}
	}
	if($total_para_importar!=0)
		{
		
		echo "<BR>";
		echo "<INPUT type=button value='IMPORTAR FOROS' onClick='importa_foros();'>";
		}

	//  Debo crear los id_foros
	//  $id_tutorex[$total_combina]=$id_tutorg;
	//  $id_grupex[$total_combina]=$id_grupo;
	//  $total_combina++;
	//  $id_forex[$total_forex]=$rox_foro["id_foro"];
	//  $total_forex
?>
</div>
<?PHP
   print_simple_box_end();
?>

</td>
</tr>
</table>

	
<?PHP
if ($existen_foros)
	{
		while($rox_foros=pg_fetch_array($result_lista_foros))
		{
		$id_foro=$rox_foros["id_foro"];
		$nombre_foro=$rox_foros["nombre_foro"];
		
		print_simple_box_start("left");
		
		
		echo "<strong>ID FORO: ". $id_foro . " (Tabla mdl_forum) - " . $nombre_foro . " - <font style='font-size:20px'>Unidad ". $rox_foros["unidad"] . "</font></strong>";
		echo "<p>";
		// VER SI TIENEN TEMAS CERO LOS TUTORES
		$query_lista_discussions  ="Select A.id as id_discussion, A.name as name_discussion, A.userid as id_tutor, A.groupid as id_grupo, firstname, lastname,message, C.id as id_post from mdl_forum_discussions A ";
		$query_lista_discussions .="inner join mdl_forum_posts C on A.id=C.discussion and C.userid=A.userid and C.parent=0 and a.firstpost=C.id ";
		$query_lista_discussions .="inner join mdl_user D on D.id=A.userid ";
		$query_lista_discussions .="where A.forum=". $id_foro . " and A.userid in (Select B.userid from mdl_user_teachers B where B.course=". $id_curso_moodle.")";
		$result_lista_discussions = pg_query($query_lista_discussions) or die('Query failed 198 : ' . pg_last_error());
		$tot_temas=0;
		?>
		<table cellpadding=3 cellspacing=3 border=1>
		<tr>
		<td bgcolor=silver><strong>id_discussion*</strong></td>
		<td bgcolor=silver><strong>Tutor</strong></td>
		<td bgcolor=silver><strong>Id Tutor</strong></td>
		<td bgcolor=silver><strong>Id Grupo</strong></td>
		<td bgcolor=silver><strong>name_discussion*</strong></td>
		<td bgcolor=silver><strong>Mensaje</strong></td>
		<td bgcolor=silver><strong>id_post**</strong></td>
		<!--td bgcolor=silver><strong>HTML</strong></td-->
		<td bgcolor=silver><strong>EDICION</strong></td>
		</tr>
		
		<?PHP
		while($rox_disc=pg_fetch_array($result_lista_discussions))
			{
			$tot_temas++;
			$nombre_tutor_disc = $rox_disc["lastname"]. ", ". $rox_disc["firstname"];
			
			$id_discussionx=$rox_disc["id_discussion"]; /// id de la tabla mdl_forum_discussions
			$id_postx=$rox_disc["id_post"]; /// id de la tabla mdl_forum_posts
			
			
			
			echo "<tr>";
			echo "<td align=center>". $rox_disc["id_discussion"] . "</td>";
			
		    //$contenidox=pg_escape_string($rox_disc["message"]);
			$contenidox=$rox_disc["message"];
			
			
			echo "<td>". $nombre_tutor_disc . "</td>";
			echo "<td align=center>". $rox_disc["id_tutor"] . "</td>";
			echo "<td align=center>". $rox_disc["id_grupo"] . "</td>";
			echo "<td>". $rox_disc["name_discussion"] . "</td>";
			echo "<td>". $contenidox . "</td>";
			echo "<td >". $id_postx ."</td>";
			//echo "<td valign=top><textarea rows=5 cols=50>". $contenidox . "</textarea></td>";
			echo "<td valign=middle align=center><INPUT type=button value='Editar' onClick='editar_foro(". $id_discussionx .",". $id_postx .");'></td>";
			echo "</tr>";
			}
		echo "</table>";
		echo "* De la Tabla mdl_forum_discussions<BR>";
		echo "** De la Tabla mdl_forum_posts";
		echo "</p>";
		echo "<strong>TEMAS : " . $tot_temas ."</strong>";
		
		print_simple_box_end();
		}
// de si existen foros
	}


//// ESTO SIRVE PARA ABAJO	
?>


<INPUT type="hidden" name="tx_accion" id="tx_accion" value="salvar">
<INPUT type="hidden" name="courseid" id="courseid" value="<?PHP echo $id_curso_moodle?>">

</form>

<form id="formeditar" name="formeditar" method="post" action="creacion_foros_editar.php">
<INPUT type="hidden" name="courseidx" id="courseidx" value="<?PHP echo $id_curso_moodle?>">
<INPUT type="hidden" name="id_discussionx" id="id_discussionx" value="">
<INPUT type="hidden" name="id_postx" id="id_postx" value="">
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

function importa_foros()
{
	obje("thisform").action="";
	obje("tx_accion").value="salvar total";
	obje("thisform").submit();
}
	
/// Esto no se para que sirve	
function importar(){
	if (trim(obje("id_curso_importar").value) !="")
		{
			obje("thisform").action="";
			obje("tx_accion").value="importar";
			obje("thisform").submit();
		}	
}
	
function selex(id_tutor, id_grupo){
	obje("sel_id_grupo").value=id_grupo;
	obje("sel_id_tutor").value=id_tutor;
}

function editar_foro(id_discussion, id_post){
	obje("id_discussionx").value=id_discussion;
	obje("id_postx").value=id_post;
	obje("formeditar").submit();
}

function rellena_posts(){

/////// MEJORAR PARA CUALQUIER CANTIDAD DE UNIDADES ACA SOLO FUNCIONA PARA 4

var total_unidades=<?PHP echo $total_unidades?>;


// LAS SEMILLAS
//<input type=text value=". $id_post_semilla. " name=id_post_semilla[unidad]>

// LAS SEMILLAS
for (k=1;k<=total_unidades;k++)
	{
	if (k==1)
	    {
		var cole_semillas_01=document.getElementsByName("id_post_semilla[" + k + "]");
		var largo_semillas_01=cole_semillas_01.length;
		//alert (k+ " _ " + largo_semillas_01);
		}
	if (k==2)
	    {
		var cole_semillas_02=document.getElementsByName("id_post_semilla[" + k + "]");
		var largo_semillas_02=cole_semillas_02.length;
		//alert (k+ " _ " + largo_semillas_02);
		}
	if (k==3)
	    {
		var cole_semillas_03=document.getElementsByName("id_post_semilla[" + k + "]");
		var largo_semillas_03=cole_semillas_03.length;
		//alert (k+ " _ " + largo_semillas_03);
		}
	if (k==4)
	    {
		var cole_semillas_04=document.getElementsByName("id_post_semilla[" + k + "]");
		var largo_semillas_04=cole_semillas_04.length;
		//alert (k+ " _ " + largo_semillas_04);
		}
	}

	var cuenta_semillas_01=0;
	var cuenta_semillas_02=0;
	var cuenta_semillas_03=0;
	var cuenta_semillas_04=0;

//RECEPTORES
//id_postex[] y numero_unidad_post[]
var cole_id_posts_receptores=document.getElementsByName("id_postex[]");
var largo_id_posts_receptores=cole_id_posts_receptores.length;

var cole_unidad_posts_receptores=document.getElementsByName("numero_unidad_post[]");
// el largo de esta coleccion es la misma que la de arriba



// ITERO RECEPTORES
for (i=0; i<largo_id_posts_receptores;i++)
	{
	    //El cajetin que recibira el dato y el cajetin con el numero de unidad
		var objinp_id_post_receptor=cole_id_posts_receptores[i];
		var objinp_unidad_post_receptor=cole_unidad_posts_receptores[i];
		var unidax=objinp_unidad_post_receptor.value;
		
		if(unidax==1)
			{
			   if(cuenta_semillas_01+1> largo_semillas_01)
				{
				cuenta_semillas_01=0;
				}
			objinp_id_post_receptor.value=cole_semillas_01[cuenta_semillas_01].value;	
			cuenta_semillas_01++;
			}
			
		if(unidax==2)
			{
			   if(cuenta_semillas_02+1> largo_semillas_02)
				{
				cuenta_semillas_02=0;
				}
			objinp_id_post_receptor.value=cole_semillas_02[cuenta_semillas_02].value;	
			cuenta_semillas_02++;
			}
			
		if(unidax==3)
			{
			   if(cuenta_semillas_03+1> largo_semillas_02)
				{
				cuenta_semillas_03=0;
				}
			objinp_id_post_receptor.value=cole_semillas_03[cuenta_semillas_03].value;
			cuenta_semillas_03++;
			}
			
		if(unidax==4)
			{
			   if(cuenta_semillas_04+1 > largo_semillas_04)
				{
				cuenta_semillas_04=0;
				}
			objinp_id_post_receptor.value=cole_semillas_04[cuenta_semillas_04].value;
			cuenta_semillas_04++;
			}
		//objinp_id_post_receptor.value=i + " _ "+ unidax;
	}


}
<?PHP
if($total_para_importar!=0)
	{
	echo 'obje("boton_rellenar").disabled=false;';
	}
else	
	{
	echo 'obje("boton_rellenar").disabled=true;';
	}	
?>



// Pongo el Total de Grupos

	obje("fon_tot_grupos").innerText="TOTAL GRUPOS : <?PHP echo $totix_grupos?>";
	
</script>
<?PHP
}
else
{
echo "Debe ser administrador para entrar a esta pagina";
}
?>