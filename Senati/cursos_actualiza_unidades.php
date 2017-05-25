<?PHP
    require_once("../config.php");
    require_once("lib.php");
	
	//DEBE INCLUIR EDITAR CHATS y ENCUESTAS
	// ULTIMA ACTUALIZACION : 5 de MAYO 2014
	

    if (isadmin())
{    

	$idcmoodle=$_GET['id'];	
	if ($idcmoodle=="")
		{$idcmoodle=$_POST['idcmoodle'];}
	
	
	
	$titulo_pagina = "Modulo para Actualizar Unidades";
	$site = get_site();

	print_header("$site->shortname : ". $titulo_pagina, "X1", $titulo_pagina, "", "", true, "");
	

$accion = $_POST["th_accion"];
$mensaje="";
$numex="0"; 

///////////// FUNCIONES PHP /////////////////

$ano_actual=date("Y");
$mes_actual=date("n");
$dia_actual=date("j");

function nombre_modulo_castellano($nombre){
	$salida=$nombre;
	if ($nombre=="label"){$salida="Etiqueta";}
	if ($nombre=="resource"){$salida="Recurso";}
	if ($nombre=="forum"){$salida="Foro";}
	if ($nombre=="assignment"){$salida="Tarea";}
	if ($nombre=="quiz"){$salida="Cuestionario";}
	if ($nombre=="feedback"){$salida="Encuesta";}
	if ($nombre=="chat"){$salida="Chat";}
	if ($nombre=="certificate"){$salida="Certificado";}
	if ($nombre=="glossary"){$salida="Glosario";}
	return $salida;
}

function dame_text_en_html($text)
{
// signos < > en html
$text=str_replace(array("<",">"), array("&lt;","&gt;"),$text); 
//tildes en vocales y ñ
$text=str_replace(array("á","é","í","ó","ú","ñ"), array("$aacute;","$eacute;","$iacute;","$oacute;","$uacute;","&ntilde;"),$text); 

//devuelve el texto en html
return $text;
}



function fecha_formateada($fecha_time){
// le doy el numero entero y me da la Fecha bine Formateada !!!!!!!!!
if ($fecha_time !=0)
   {
	$fecha_real=$fecha_time-3600;
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

function fecha_formateada_sin_hora($fecha_time){
// le doy el numero entero y me da la Fecha bien Formateada !!!!!!!!!
if ($fecha_time !=0)
   {
	$fecha_real=$fecha_time-3600;
	$diasem=date('w',$fecha_real);
	$reto='';
	if ($diasem==1){$reto='Lunes';}
	if ($diasem==2){$reto='Martes';}
	if ($diasem==3){$reto='Miercoles';}
	if ($diasem==4){$reto='Jueves';}
	if ($diasem==5){$reto='Viernes';}
	if ($diasem==6){$reto='Sabado';}
	if ($diasem==0){$reto='Domingo';}
	$salida=$reto. ' ' .date('d-m-Y',$fecha_real);
   }
else
   {
$salida='-';
   }
return $salida;
}
/////////////////////////////////////// FIN DE FUNCIONES PHP /////////////





////////////////// ACTUALIZA LAS UNIDADES Y SUS RECURSOS
if ($accion=="salvar")
	{
	$numex1 = count($_POST['sel_sino_unidad']); // how many files in the $_FILES array?

	for($i=0;$i<$numex1;$i++)
		{
		$seccion=$_POST['id_section'][$i];
		$seccion_visible=$_POST['sel_sino_unidad'][$i];
		
		$queryu  ="update mdl_course_sections set visible=". $seccion_visible. " where id=". $seccion ;
        $resultu = pg_query($queryu) or die('Query failed 123: ' . pg_last_error());
        $ejecuta=pg_fetch_array($resultu);
		$mensaje="Se actualizaron las Unidades del Curso Moodle : ". $idcmoodle; 	
		}
    $numex2 = count($_POST['id_module']); // how many files in the $_FILES array?
	
	for($i=0;$i<$numex2;$i++)
		{
		$modulo=$_POST['id_module'][$i];
		$modulo_visible=$_POST['sel_module_visible'][$i];
		
		$queryu  ="update mdl_course_modules set visible=". $modulo_visible. " where id=". $modulo ;
        $resultu = pg_query($queryu) or die('Query failed 135: ' . pg_last_error());
        $ejecuta=pg_fetch_array($resultu);
		$mensaje="Se actualizaron las Unidades del Curso Moodle : ". $idcmoodle; 	
		}
		
    $numex3 = count($_POST['id_section_borrar']); // Secciones a borrar
	
	for($i=0;$i<$numex3;$i++)
		{
		$id_section_borrar=$_POST['id_section_borrar'][$i];
		$sel_borra_section=$_POST['sel_borra_section'][$i];
		
		if ($sel_borra_section="SI")
            {			   
			$queryu  ="delete from mdl_course_sections where id=". $id_section_borrar ;
			$resultu = pg_query($queryu) or die('Query failed 150: ' . pg_last_error());
			$ejecuta=pg_fetch_array($resultu);
			$mensaje="Se actualizaron las Unidades del Curso Moodle : ". $idcmoodle;
			} 	
		}
	$numex=$numex1*1+$numex2*1+$numex3*1;
	///////// AQUI SALVO LOS NOMBRE DE LOS MODULOS
	
	$numero_registros = count($_POST['th_id_instancia']);
    $total_cambios=0;
	for ($i=0; $i<$numero_registros; $i++)
		{
		$tablax=$_POST['th_tablax'][$i];
		if ($tablax=="mdl_chat" || $tablax=="mdl_feedback" || $tablax=="mdl_forum" || $tablax=="mdl_assignment" || $tablax=="mdl_quiz")
			{
			$id_instancia=$_POST['th_id_instancia'][$i];
			$nombrex=$_POST['th_nombrex'][$i];
			$qr_update_name ="update " . $tablax . " set name='". $nombrex . "' where id=". $id_instancia;
			$rs_update_name=pg_query($qr_update_name) or die('Query failed 168: ' . pg_last_error());
			$total_cambios++;
			
			/////// Asignar tutor a chat o feedback
			///ACA DEBO ASIGNAR LAS ENCUESTAS y LOS CHATS id_chat_feedback[] 
			if ($tablax=="mdl_chat" || $tablax=="mdl_feedback")
				{
				$id_chat_feedback=trim($_POST['id_chat_feedback'][$i]);
				$id_tutor=trim($_POST['th_id_tutor'][$i]);
				if ($id_tutor!="")
				   {
				   $query_update="update ". $tablax ." set id_tutor=". $id_tutor . " where id=". $id_chat_feedback ;
				   }
				else
				   {
				   $query_update="update ". $tablax ." set id_tutor=NULL where id=". $id_chat_feedback ;
				   }
		        $rs_salvar_cf = pg_query($query_update) or die('Query failed: 183 ' . pg_last_error());
				$rox_salvar_cf=pg_fetch_array($rs_salvar_cf); 
				}
			}
		}
	

    ///////////////////////	
		$mensaje2="Se actualizaron ". $total_cambios . " M&oacute;dulos";
	/////// FIN DE SALVAR NOMBRE DE MODULOS	
	}

$query0  ="select fullname,startdate from mdl_course where id=" . $idcmoodle;
$result0 = pg_query($query0) or die('Query failed 198: ' . pg_last_error());
$rony=pg_fetch_array($result0);

$nombre_curso_moodle=$rony["fullname"];
$fecha_inicio_cm=fecha_formateada_sin_hora($rony["startdate"]);


$query1 ="SELECT id, section, visible, summary from mdl_course_sections where course=". $idcmoodle. " order by section";
$result1=pg_query($query1) or die('Query failed 206: ' . pg_last_error());


//////LISTA DE TUTORES debo mostrar tambien el id del tutor

$queryx  = "Select lastname||', '||firstname as nombre, A.userid from mdl_user_teachers A ";
$queryx .= "inner join mdl_user B on A.userid=B.id where course=". $idcmoodle . " order by 1";
$resultx = pg_query($queryx) or die('Query failed 189: ' . pg_last_error());

$lista_tutores="";
$total_tutores_js=0;
$ct=0;
while($rox2=pg_fetch_array($resultx)) 
	{
	$tutores_js[$ct]=$rox2["nombre"];
	$tutores_id_js[$ct]=$rox2["userid"];
	
	if ($ct!=0)
		{$lista_tutores .="<BR>". $rox2["nombre"] . " (" . $rox2["userid"] . ")" ;}
	else
		{$lista_tutores .=$rox2["nombre"]. " (" . $rox2["userid"] . ")" ;}
	$ct++;	
	$total_tutores_js=$ct;
	}


?>
<a href="view.php?id=<?PHP echo $idcmoodle ?>"><strong><font color="blue"><u><?PHP echo $nombre_curso_moodle ?></u></strong></font></a> - M&oacute;dulo para Actualizar Unidades y M&oacute;dulos<BR>

<div id="div_mensaje">
<?PHP
	if ($mensaje !="")
	{
	echo "<BR><strong><FONT color=red>" . $mensaje . ".</font></strong>";
	echo "<BR><strong><FONT color=red>" . $mensaje2 . ".</font></strong>";
	}
?>
</div>
<BR>
<form name="thisform" id="thisform" method="post">

<!-- INICIO -->

<table cellpadding="1" cellspacing="1" border="1" bordercolor="#999999">
<tr><td bgcolor="#DDDDDD" colspan="2"><strong>Actualizaci&oacute;n de Unidades (sections) y Recursos</strong></td></tr>
<tr><td align="right"><strong>Curso</strong>&nbsp;</td><td>&nbsp;<font color="blue"><?PHP echo $nombre_curso_moodle ?></font>&nbsp;</td></tr>
<tr><td align="right"><strong>ID Moodle</strong>&nbsp;</td><td>&nbsp;<?PHP echo $idcmoodle ?></td></tr>
<tr><td align="right"><strong>Fecha de Inicio</strong>&nbsp;</td><td>&nbsp;<?PHP echo $fecha_inicio_cm?> (D/M/A) &nbsp;</td></tr>
<tr><td align="right"><strong>Fecha Actual</strong>&nbsp;</td><td>&nbsp;<?PHP echo  $dia_actual.'-'. $mes_actual. '-' . $ano_actual?> (D/M/A)</td></tr>
</table>


<BR>
<strong style="color:blue">mdl_course_sections</strong>
<BR>
<BR>
<table cellpadding="2" cellspacing="1" border="1" bordercolor="#999999">
<tr bgcolor="#00CCFF">
<td align="center"><strong>ID</strong></td>
<td><strong>Section</strong></td>
<td><strong>Visible</strong>&nbsp;</td>
<td><strong>Resumen</strong>&nbsp;</td>
</tr>

<?PHP
while($rox=pg_fetch_array($result1)) 
	{
	$id_section=$rox["id"];
	$unidad=$rox["section"];
	$visible=$rox["visible"];
	
	if ($visible=="0")
	   {$visa="NO";
        $sele2="selected";
		$bgcolor="bgcolor=#DDDDDD";
		$sele1="";	   
	   }
	else
	   {$visa="SI";
        $sele1="selected";
		$bgcolor="";
		$sele2="";	   
	   }
	   
	$summary=$rox["summary"];

?>		
<tr >
<td <?PHP echo $bgcolor?> align="right"><?PHP echo $id_section ?>&nbsp;<input type=hidden name="id_section[]" value="<?PHP echo $id_section ?>"></td>
<td <?PHP echo $bgcolor?> align="center"><strong style="font-size:18px"><?PHP echo $unidad ?></strong></td>
<td <?PHP echo $bgcolor?> align="center">
<select name="sel_sino_unidad[]">
<option value="1" <?PHP echo $sele1?>>SI</option>
<option value="0" <?PHP echo $sele2?>>NO</option>
</select>
</td>
<td >
<?PHP echo $summary ?>
<?PHP


 // CUENTO LOS MODULOS de esta seccion y de ese curso
  $query_mod_count ="SELECT count(*) as total from mdl_course_modules A ";
  $query_mod_count .="inner join mdl_course_sections C on C.id=A.section and C.course=A.course ";
  $query_mod_count .="where C.section=". $unidad ." and A.course=". $idcmoodle;
  $result_count = pg_query($query_mod_count) or die('Query failed 311: ' . pg_last_error());
  
  $rock=pg_fetch_array($result_count);
  $total_mod=$rock["total"];
	
if ($total_mod !=0)
{
  
  $query_sequence="Select sequence from mdl_course_sections where id=" . $id_section . " and course=". $idcmoodle ;
  $res_sequence=pg_query($query_sequence) or die('Query failed 320: ' . pg_last_error());
  $roseq=pg_fetch_array($res_sequence);
  $secuenciax=$roseq["sequence"];
  
  $seqarray = explode(",", $secuenciax);   
// recorre el array   
// imprime los elementos individuales
    $conta=0;
	$caso="CASE ";
	foreach ($seqarray as $seqa) {   
	  $conta++;
	  $caso= $caso . " WHEN A.id=" . $seqa . " THEN " . $conta. " ";
	}
	$caso=$caso . " ELSE 150 END as orden ";
	
	
	
	 

  /* CON ESTE QUERY TENGO LA SECUENCIA !!!!!!!!!!!
  // aca debo ordenar segun el campo de sequence
  // los numeros en sequence de mdl_course_sections me dan el orden de id en mdl_course_modules !!!!!!!!!!!!!!!!!!!!!!!!!!!!!
  // EXTRAIGO LA SECUENCIA
  /// EL 	$id_section obtenido mas arriba LINEAS 132 me da la secuencia
  //Debo descifrar esa secuencia y ponerles peso segun esten listados !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! COMO ???????????????
  
 CASE WHEN A.id=17378 THEN 1
     WHEN A.id=17402 THEN 2
     WHEN A.id=17379 THEN 3
     ELSE 50 END as orden
	 
	 order by 7
*/  
  
  $query_modules ="SELECT A.id, B.name, A.visible, A.module, A.instance, " . $caso . " from mdl_course_modules A ";  
  $query_modules .="inner join mdl_modules B on B.id=A.module ";
  $query_modules .="inner join mdl_course_sections C on C.id=A.section and C.course=A.course ";
  $query_modules .="where C.section=". $unidad ." and A.course=". $idcmoodle. " order by 6";
  $result_modules = pg_query($query_modules) or die('Query failed 358: ' . pg_last_error());

// la instancia es el id de la tabla correspondiente por ejemplo para label es el id de mdl_label

?>
    <BR />
    <strong>MODULOS : <?PHP echo $total_mod?></strong><BR />
  
    <table cellpadding="2" cellspacing="1" border="1" bordercolor="#999999">
	 <tr bgcolor="#00CCFF">
    <td align="center"><strong>ID Mod</strong></td>
    <td><strong>Tipo</strong></td>
	<td><strong>Tabla e ID</strong></td>
    <td><strong>Nombre o Contenido</strong>&nbsp;</td>
    <td><strong>Visible</strong>&nbsp;</td>
	<td><strong>Extras</strong>&nbsp;</td>
    </tr>
    <?PHP

     while($roy=pg_fetch_array($result_modules)) 
     {
	 $contenido="-";
	 $instancia=$roy["instance"];
	 $name_module=$roy["name"];
	 $nombre_modulo=nombre_modulo_castellano($name_module);
	 
	 $tablax="";
	 
	 /// VERIFICO CADA TIPO DE MODULO
	 
	 /// FALTA CERTIFICATE Y GLOSSARY /////////////////////////////////////
	 
	 $imagen="";
	 $name_input="";
	 if ($name_module=="label")
	 	{
		  $queryx="SELECT name, content from mdl_label where id=". $instancia;;
		  $resultx = pg_query($queryx) or die('Query failed 395: ' . pg_last_error());
		  $roz=pg_fetch_array($resultx);
		  $contenido=$roz["content"];
		  $tablax="mdl_label";
		  
		  
		}
	 else if ($name_module=="quiz")
	 	{
		  $queryx="SELECT name from mdl_quiz where id=". $instancia;
		  $resultx = pg_query($queryx) or die('Query failed 405: ' . pg_last_error());
		  $roz=pg_fetch_array($resultx);
		  $contenido=$roz["name"];
   		  $imagen="<img src='". $CFG->wwwroot. "/theme/tema_senati/pix/mod/quiz/icon.gif'>&nbsp;";
		  $tablax="mdl_quiz";
		  
		}

	 else if ($name_module=="assignment")
	 	{
		  $queryx="SELECT name from mdl_assignment where id=". $instancia;
		  $resultx = pg_query($queryx) or die('Query failed 416: ' . pg_last_error());
		  $roz=pg_fetch_array($resultx);
		  $contenido=$roz["name"];
  		  $imagen="<img src='". $CFG->wwwroot. "/theme/tema_senati/pix/mod/assignment/icon.gif'>&nbsp;";
		  $tablax="mdl_assignment";
		}
	 else if ($name_module=="forum")
	 	{
		  $queryx="SELECT name from mdl_forum where id=". $instancia;
		  $resultx = pg_query($queryx) or die('Query failed 425: ' . pg_last_error());
		  $roz=pg_fetch_array($resultx);
		  $contenido=$roz["name"];
		  $imagen="<img src='". $CFG->wwwroot. "/theme/tema_senati/pix/mod/forum/icon.gif'>&nbsp;";
		  $tablax="mdl_forum";
		  
		}
	 else if ($name_module=="resource")
	 	{
		  $queryx="SELECT name from mdl_resource where id=". $instancia;;
		  $resultx = pg_query($queryx) or die('Query failed 435: ' . pg_last_error());
		  $roz=pg_fetch_array($resultx);
		  $contenido=$roz["name"];
  		  $imagen="<img src='". $CFG->wwwroot. "/theme/tema_senati/pix/mod/resource/icon.gif'>&nbsp;";
		  $tablax="mdl_resource";
		}
	 else if ($name_module=="feedback")
	 	{
		  $queryx="SELECT name from mdl_feedback where id=". $instancia;
		  $resultx = pg_query($queryx) or die('Query failed 444: ' . pg_last_error());
		  $roz=pg_fetch_array($resultx);
		  $contenido=$roz["name"];
   		  $imagen="<img src='". $CFG->wwwroot. "/theme/tema_senati/pix/mod/feedback/icon.gif'>&nbsp;";
		  $tablax="mdl_feedback";
		}

	 else if ($name_module=="chat")
	 	{
		  $queryx="SELECT name from mdl_chat where id=". $instancia;
		  $resultx = pg_query($queryx) or die('Query failed 454: ' . pg_last_error());
		  $roz=pg_fetch_array($resultx);
		  $contenido=$roz["name"];
   		  $imagen="<img src='". $CFG->wwwroot. "/theme/tema_senati/pix/mod/chat/icon.gif'>&nbsp;";
		  $tablax="mdl_chat";
		}
	 else if ($name_module=="certificate")
	 	{
		  $queryx="SELECT name from mdl_certificate where id=". $instancia;
		  $resultx = pg_query($queryx) or die('Query failed 463: ' . pg_last_error());
		  $roz=pg_fetch_array($resultx);
		  $contenido=$roz["name"];
   		  $imagen="<img src='". $CFG->wwwroot. "/theme/tema_senati/pix/mod/certificate/icon.gif'>&nbsp;";
		  $tablax="mdl_certificate";
		}
	 else if ($name_module=="glossary")
	 	{
		  $queryx="SELECT name from mdl_glossary where id=". $instancia;
		  $resultx = pg_query($queryx) or die('Query failed 472: ' . pg_last_error());
		  $roz=pg_fetch_array($resultx);
		  $contenido=$roz["name"];
   		  $imagen="<img src='". $CFG->wwwroot. "/theme/tema_senati/pix/mod/glossary/icon.gif'>&nbsp;";
		  $tablax="mdl_glossary";
		}

	 /// FALTA CERTIFICATE Y GLOSSARY /////////////////////////////////////		
		

    $visible_module=$roy["visible"];
	
	if ($visible_module=="0")
	   {$sele2="selected";
		$sele1="";
		$colavis="bgcolor=#DDDDDD";	   
	   }
	else
	   {$sele1="selected";
		$sele2="";
		$colavis="";	   	   
	   }
    ?> 
        <tr <?PHP echo $colavis ?>>
        <td align="center"><?PHP echo $roy["id"] ?><input type="hidden" name="id_module[]" value="<?PHP echo $roy["id"] ?>"></td>
        <td><?PHP echo $nombre_modulo ?></td>
		<td><?PHP echo $tablax . " (".  $instancia . ")"; ?>
		   <input type="hidden" name="id_chat_feedback[]" value="<?PHP echo $instancia ?>" size=4>
		</td>
        <td><?PHP echo $imagen ?>
		<?PHP 
		if ($name_module!="label" && $name_module!="resource")
			{
			$tama="size=50";
			
			if($name_module=="feedback" || $name_module=="chat")
				{
				$tama="size=80";
				}
		?>	
		    <input type=hidden name="th_tablax[]" value="<?PHP echo $tablax?>">
			<input type=hidden name="th_id_instancia[]" value="<?PHP echo $instancia?>">
			<input type=text name="th_nombrex[]" <?PHP echo $tama ?> maxlength=100 value="<?PHP echo $contenido?>">
		<?PHP
			}
		else
		    {
			echo $contenido;
			
			?>
			<input type=hidden name="th_tablax[]" value="">
			<input type=hidden name="th_id_instancia[]" value="">
			<input type=hidden name="th_nombrex[]" value="">
			<?PHP
			}
		
		//////// Verificar si tiene datos extra	Si la tabla es mdl_chat o mdl_feedback y leer su tutor desde mdl_user
		
		$dato_extra="-";
		$id_tutor="";
		if ($tablax=="mdl_chat")
			{
			/// $instancia
			$query_chat  = "Select lastname||', '||firstname as nombre, id_tutor from mdl_chat A left join mdl_user B on B.id=A.id_tutor where A.id=". $instancia;
			$result_chat = pg_query($query_chat) or die('Query failed: 518' . pg_last_error());
			$rox_chat=pg_fetch_array($result_chat); 
			$nombre_tutor=trim($rox_chat["nombre"]);
			$id_tutor=trim($rox_chat["id_tutor"]);
			if ($nombre_tutor!="")
				{$dato_extra="TUTOR: ". $nombre_tutor;}
			}
		else if($tablax=="mdl_feedback")
			{
			/// $instancia
			$query_feedback  = "Select lastname||', '||firstname as nombre,id_tutor from mdl_feedback A left join mdl_user B on B.id=A.id_tutor where A.id=". $instancia;
			$result_feedback = pg_query($query_feedback) or die('Query failed: 518' . pg_last_error());
			$rox_feedback=pg_fetch_array($result_feedback); 
			$nombre_tutor=trim($rox_feedback["nombre"]);
			$id_tutor=trim($rox_feedback["id_tutor"]);
			if ($nombre_tutor!="")
				{$dato_extra="TUTOR : ". $nombre_tutor;}
			}
		else
			{
			$dato_extra="-";
			$id_tutor="";
			}
		?>
		</td>
        <td align="center">
        <select name="sel_module_visible[]">
        <option value="1" <?PHP echo $sele1?>>SI</option>
        <option value="0" <?PHP echo $sele2?>>NO</option>
        </select>
        </td>
		<td><em><?PHP echo $dato_extra ?></em><input type=hidden name="th_id_tutor[]" value="<?echo $id_tutor?>" size=4> </td>
        </tr>
    <?PHP    
     }
    ?>
</table>

<?PHP
}
else
	{
	echo "&nbsp;";
// echo  "Esta secci&oacute;n no tiene m&oacute;dulos, desea eliminarla ? . <INPUT type=hidden name='id_section_borrar[]' value='".$id_section."'>";
// echo  "<select name='sel_borra_section[]'>";
// echo  "<option value='SI'>SI</option>";
// echo  "<option value='NO' selected>NO</option>";
// echo  "</select>";
	}    
?>
    
    
</td>
</tr>
<?PHP
	}
?>
</table>
<BR>

<!-- FIN -->


<input type="button" id="bot_salvar" name="bot_salvar" value="Salvar" onclick="salvar();"/>
<BR>

<div>
<BR>
<strong>Lista de Tutores</strong><BR><BR>
<?PHP echo $lista_tutores ?>
</div>

<input type="hidden" name="idcmoodle" value="<?PHP echo $idcmoodle ?>" />
<input type="hidden" name="th_accion" value="salvar" />

<ul>
<LI><a href="editar_chats.php?id=<?PHP echo $idcmoodle ?>">Enlazar Chats</a></LI>
<LI><a href="editar_encuestas.php?id=<?PHP echo $idcmoodle ?>">Enlazar Encuestas</a></LI>
</UL>


<STRONG>Encuestas a no tomar en cuenta para asignar a Tutores</STRONG>
<P>
<INPUT type=text id="encues1" value="Encuesta de Opinión del Curso" size=50><BR>
<INPUT type=text id="encues2" value="Encuesta: Alumno SENATI Virtual" size=50>
</P>
<P>
<input type=button value="Asignar Tutores a Salas y Encuestas" onClick="asignar_tutores();">
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

function salvar(){
	obje("bot_salvar").disabled=true;
    obje("div_mensaje").innerHTML="<BR><strong><FONT color=red>Espere...</font></strong>";
	obje("thisform").submit();
}

function trim(str)
{
if(!str || typeof str != "string")
return "";
return str.replace(/^[\s]+/,'').replace(/[\s]+$/,'').replace(/[\s]{2,}/,' ');
}

function asignar_tutores(){
<?PHP
$cd='"';
echo "var total_tutores=". $total_tutores_js . ";\n";
echo "var tutor = new Array();\n";
echo "var tutor_id = new Array();\n";

for ($j=0;$j<$total_tutores_js; $j++)
	{
	echo "tutor[". $j . "]=". $cd. $tutores_js[$j] . $cd . ";\n";
	echo "tutor_id[". $j . "]=". $cd. $tutores_id_js[$j] . $cd . ";\n";
	}
//el ultimo indice es igual al total menos 1
?>

// Estas 3 Colecciones tiene la misma cantidad de elementos
// Se deben usar las que tiene como valor mdl_chat y mdl_feedback en th_tablax[]
// Luego en el Nombre th_nombrex[] se le pone el nombre del TUTORE
// en mdl_Chat : Sala del Tutor + Nombre del Tutor
// en mdl_feedback : Encuesta de Opinión acerca del Tutor + Nombre del Tutor
	
	var indice_chat=0;
	var indice_feedback=0;
	
	var cole1=document.getElementsByName("th_tablax[]");
	var lex1=cole1.length;

	var cole2=document.getElementsByName("th_id_instancia[]");
	var lex2=cole2.length;

	var cole3=document.getElementsByName("th_nombrex[]");
	var lex3=cole3.length;
	
	var cole4=document.getElementsByName("sel_module_visible[]");
	var lex4=cole4.length;
	
	var cole5=document.getElementsByName("id_chat_feedback[]");
	var lex5=cole5.length;
	
	var cole6=document.getElementsByName("id_chat_feedback[]");
	var lex6=cole6.length;
	
	var cole7=document.getElementsByName("th_id_tutor[]");
	var lex7=cole7.length;


	/// lex1 es igual que lex4
	/// LA PRIMERA ENCUESTA ES Encuesta de Opinión del Curso
	/// LES PONE NOMBRES A LA SALAS y LES PONE VISIBLE :
	/// SOLO FALTA ASOCIARLAS CON EL ID DEL TUTOR QUE NO ESTA SALVO EN LA ENCUESTA QUE DIGA : Encuesta de Opinión del Curso
	
	
	for (j=0;j<lex1;j++)
		{
			if (cole1[j].value=="mdl_chat")
			   {
			   if (indice_chat<total_tutores)
				  {
				  cole3[j].value="Sala del Tutor " + tutor[indice_chat];
				  cole7[j].value=tutor_id[indice_chat];
				  indice_chat++;
				  cole4[j].value="1";
				  }
				else
				  {
				  cole4[j].value="0";
				  cole7[j].value="";
				  }
			   }
			// LA primera encuesta deberia obviarla pues es Encuesta de Opinión del Curso   
			if (cole1[j].value=="mdl_feedback")
			   {	
			   cole4[j].value="0";
			   var encuesta1=obje("encues1").value;
			   var encuesta2=obje("encues2").value;
			   
			   
			   // ESTO ES PARA CURSOS DE INDUCCION TAMBIEN
			   if (indice_feedback<total_tutores && cole3[j].value!=encuesta1 && cole3[j].value!=encuesta2)
				  {
				  cole3[j].value="Encuesta de Opinión acerca del Tutor " + tutor[indice_feedback];
				  cole7[j].value=tutor_id[indice_feedback];
				  indice_feedback++;
				  cole4[j].value="1";
				  }
				else
				  {
				  cole4[j].value="0";
				  cole7[j].value="";
				  }
				/// PARA INDUCCION LA ENCUESTA DEBE SEGUIR ACTIVA  
				if(cole3[j].value==encuesta1 || cole3[j].value==encuesta2)  
					{
					cole4[j].value="1";
					cole7[j].value="";
					}
			   }   
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