<?PHP
    require_once("../config.php");
    require_once("lib.php");
	
	$site = get_site();
	
	// CON ESTE MODULO PUEDO DEFINIR LOS DATOS DE LAS EVALUACIONES SEGUN PERIODO y CAMPUS
	
	$camp_listar="";
	
    if (isadmin())
	{
	$accion=$_POST["txh_accion"];
	$mensaje="";
    $id_usuario=$USER->id;
		

	if ($accion=="salvar")
		{
		$camp_listar=$_POST["th_camp_sel"];
		$periodo_listar=$_POST["th_periodo_sel"];
		
		$numero_registros = count($_POST['th_id_curso']); // how many files in the $_FILES array?
		for ($i=0; $i<$numero_registros; $i++)
		    {
			 $id_cursox=$_POST["th_id_curso"][$i];
			 $visiblex=trim($_POST["sel_curso_visible"][$i]);
			 
			 $update_curso="Update mdl_course set visible=". $visiblex. " where id=". $id_cursox; 
			 $rg_curso = pg_query($update_curso);
			}
		$mensaje="Se actualizaron ". $numero_registros . " Cursos";
		}

	if ($accion=="listar")
		{
		$camp_listar=$_POST["sel_camp"];
		$periodo_listar=$_POST["tx_periodo"];
		$mensaje="CAMP: " .$camp_listar . ", PERIODO: " . $periodo_listar;
		}
		
	if ($accion!="")
		{
		// Listar los cursos presenciales que tengan matriculas en ese campus y periodo
		$query_cursos_camp  = "Select id, fullname, visible from mdl_course A where periodo='". $periodo_listar ."' and presencial_de is not null ";
		$query_cursos_camp .= "and (SELECT COALESCE((SELECT 1 FROM mdl_user_students B WHERE B.course=A.id and B.camp='". $camp_listar ."' LIMIT 1),0) as existe)=1 ";
		$query_cursos_camp .= " order by id desc";
		
		$rs_cursos_camp = pg_query($query_cursos_camp) or die('Query failed 49: ' . pg_last_error());
		}
		


//LISTA DE CENTROS

$query_centros  = "Select id_centro, nombre_centro from senati_centros where id_centro not in ('00','SV','STI','50','60Q','65','60R','72A','73','69','60I','60Y') ";
$query_centros .= "order by nombre_centro ";

$rs_centros = pg_query($query_centros) or die('Query failed: ' . pg_last_error());


//////////////// HEADER PAGINA ////////////////
$titulo_pagina = "Evaluaciones de Cursos Presenciales";
$enlace = "<a href='../course/cursos_admin_menu.php'>Administraci&oacute;n de Cursos</a> &gt; Evaluaciones de Cursos Presenciales";
print_header("$site->shortname : ". $titulo_pagina, "X1", $enlace, "", "", true, "");

?>

<strong style="color:blue"><a href="../course/cursos_admin_menu.php"><u>Administraci&oacute;n de Cursos</u></a> &gt; Evaluaciones de Cursos Presenciales</strong><BR><BR>
<form name="thisform" id="thisform" method="post">

<strong><font style="font-size:14px" id=fones color=red><?PHP echo $mensaje?></font></strong>

<TABLE cellspacing=2 cellpadding=2 border=1 bordercolor="#b6dbed">
<TR bgcolor="#6bb6de">
<td colspan=2><strong>CAMPUS Y PERIODO</strong></TD>
</TR>
<tr>
	<td>Seleccione el Campus</td>
	<td>
	<SELECT name="sel_camp" id="sel_camp">
	<?PHP
	while($roc=pg_fetch_array($rs_centros))
	{
		$camp=$roc["id_centro"];
		$campus=$roc["nombre_centro"];
		echo "<OPTION value='" . $camp . "'>" . $campus . " (". $camp . ")</OPTION>\n";
	} 
	?>
	</SELECT>
	</td>
</tr>
<td>Ingrese el Periodo</TD>
<TD>
<INPUT type="text" size="8" maxlength="8" name="tx_periodo" id="tx_periodo" value="<?PHP echo $periodo_listar?>">&nbsp;
</TD>
</TR>

<TR>
<TD>&nbsp;</TD>
<TD>
<INPUT type="button" value="Listar" onclick="listar();" />&nbsp;&nbsp;
</TD>
</TR>
</TABLE>

<?PHP
if ($camp_listar !="")
	{
?>
<p>
<TABLE cellspacing="2" cellpadding="2" border=1 bordercolor="#b6dbed">
<TR bgcolor="#6bb6de">
<TD><strong>&nbsp;ID Curso&nbsp;</strong></TD>
<TD><strong>Curso</strong></TD>
<TD><strong>&nbsp;Estado del Curso&nbsp;</strong></TD>
</TR>
	<?PHP
	while($roa=pg_fetch_array($rs_cursos_camp))
		{
		// LISTAR LOS CURSOS SEGUN PERIODO Y CAMPUS
		$id_curso=$roa["id"];
		$nombre_curso=$roa["fullname"];
		$visible_curso=$roa["visible"];
		
		if ($visible_curso=="1")
		    {$estado_curso="Abierto";
			 $color_curso="blue";
			 $option1="Dejarlo Abierto";
			 $option2="Cerrar Curso";
			 $valoption1="1";
			 $valoption2="0";
			}
		else
		    {$estado_curso="Cerrado";
			 $color_curso="gray";
			 $option1="Dejarlo Cerrado";
			 $option2="Abrir Curso";
			 $valoption1="0";
			 $valoption2="1";
			}

		echo "<TR>\n";
		echo "<TD align=center>". $id_curso ." <INPUT type='hidden' name='th_id_curso[]' size=4 value='". $id_curso ."'></TD>\n";
		echo "<TD ><font color=". $color_curso . ">". $nombre_curso ."</font></TD>\n";
		echo "<TD>&nbsp;". $estado_curso ."&nbsp;<font style='font-size:9px' color=blue><em>cambiar:</em></font>&nbsp;\n";
		echo "<SELECT name=sel_curso_visible[]>\n";
		echo "<OPTION value='". $valoption1 ."'>" . $option1 . "</OPTION>\n";
		echo "<OPTION value='". $valoption2 ."'>" . $option2 . "</OPTION>\n";
		echo "</SELECT>\n";
		echo "</TD>\n";
		echo "</TR>\n";

		$query_quizes  ="select A.id as id_course_modules, ";
		$query_quizes .="C.id as id_quiz, ";
		$query_quizes .="C.name as nombre_quiz, ";
		$query_quizes .="A.instance, ";
		$query_quizes .="A.section as module_section, ";
		$query_quizes .="A.visible as module_visible, ";
		$query_quizes .="B.visible as seccion_visible, ";
		$query_quizes .="C.password as password_quiz, ";
		$query_quizes .="subnet ";
		$query_quizes .="from mdl_course_modules A ";
		$query_quizes .="inner join mdl_course_sections B on B.id=A.section ";
		$query_quizes .="inner join mdl_quiz C on A.instance=C.id and C.course=A.course ";
		$query_quizes .="where module=12 ";
		$query_quizes .="and A.course=". $id_curso . " ";
		$query_quizes .="order by C.id ";
		
		$rs_quizes = pg_query($query_quizes) or die('Query failed 144: ' . pg_last_error());

		
		
		
		/// AHORA PONGO LOS DATOS DE CADA QUIZ
		echo "<TR>";
		echo "<TD colspan=3 align=center>";
		    
			echo "<table cellspacing=2 cellpadding=2 border=1 bordercolor=#6bb6de>\n";
			echo "<TR bgcolor=#e9f8ff>\n";
			echo "<TD>ID Cuestionario</TD>\n";
			echo "<TD>Nombre Cuestionario</TD>\n";
			echo "<TD>Password</TD>\n";
			echo "<TD>IP de Acceso</TD>\n";
			echo "<TD>Estado del Cuestionario</TD>\n";
			echo "<TD>Estado de la Secci&oacute;n</TD>\n";
			echo "</TR>\n";
			
			while($rob=pg_fetch_array($rs_quizes))
				{
				$id_quiz=$rob["id_quiz"];
				$nombre_quiz=$rob["nombre_quiz"];
				$instance=$rob["instance"];
				$password_quiz=$rob["password_quiz"];
				$module_section=$rob["module_section"];
				$module_visible=$rob["module_visible"];
				$seccion_visible=$rob["seccion_visible"];
				$subnet=$rob["subnet"];
				
				if($module_visible=="1")
				   {$quiz_visible="Abierto";}
				else   
				   {$quiz_visible="Cerrado";}
				   
				if($seccion_visible=="1")
				   {$estado_seccion="Abierta";}
				else   
				   {$estado_seccion="Cerrada";}   
				   
				
				echo "<TR>\n";
				echo "<TD align=center>". $id_quiz ."</TD>\n";
				echo "<TD>". $nombre_quiz ."</TD>\n";
				echo "<TD align=center>". $password_quiz ."</TD>\n";
				echo "<TD align=center>". $subnet ."</TD>\n";
				echo "<TD align=center>". $quiz_visible ."</TD>\n";
				echo "<TD align=center>". $estado_seccion ."</TD>\n";
				echo "</TR>\n";
				}
			
			echo "</table>";
		
		echo "</TD>";
		echo "</TR>";
		}
	?>
</TABLE>

	<p><INPUT type=button value="Guardar Cambios" onClick="salvar();"></p>
</p>
<?PHP
	// IF CAMP LISTAR
	}
?>


<input type="hidden" name="th_camp_sel" id="th_camp_sel" value="<?PHP echo $camp_listar ?>" />
<input type="hidden" name="th_periodo_sel" id="th_periodo_sel" value="<?PHP echo $periodo_listar ?>" />
<input type="hidden" name="txh_accion" id="txh_accion" value=""/>
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

function comillas(){
	//no acepta comillas simples ni dobles
	wek=window.event.keyCode;
	if (wek==39 || wek==34) {window.event.keyCode=0;}
}

function salvar(){

	obje("txh_accion").value="salvar";
	obje("thisform").submit();
}


function listar(){
	var camp=obje("sel_camp").value;
	var periodo=trim(obje("tx_periodo").value);

	if (periodo!="" && camp !="")
		{
			obje("tx_periodo").value=periodo;
			obje("txh_accion").value="listar";
			obje("thisform").submit();
		}	
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

obje("sel_camp").selectedIndex=-1;

<?PHP 
if ($camp_listar !="")
	{
?>
	obje("sel_camp").value="<?PHP echo $camp_listar?>";
<?PHP	
	}
?>

</script>
<?PHP
}
else
{
echo "Debe ser administrador para entrar a esta pagina";
}
?>