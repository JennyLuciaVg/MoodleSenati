<?PHP

    require_once("../config.php");
    require_once("lib.php");

	$site = get_site();
    $id=required_param('id');              // course id
	
	$id_cursox=$id;
	$id_usuario=$USER->id;
	
	
	// VERIFICO SI ES ADMIN O TUTOR DEL CURSO

if (isadmin())
{

	//Verifico si el curso tiene grupos ($tiene_grupos=="1" -> "Este curso tiene grupos")
	
	$qexist='SELECT COALESCE((Select 1 from mdl_groups A inner join mdl_groups_members on groupid=A.id where courseid='. $id_cursox . ' LIMIT 1),0) as "existe"';
	$result_existe = pg_query($qexist) or die('Query failed: ' . pg_last_error());
	$roxg=pg_fetch_array($result_existe);
	$tiene_grupos=$roxg["existe"];
	
	//Verifico si tiene Ponderaciones
	$query1='SELECT COALESCE((Select 1 from senati_pesos_recursos where id_curso='. $id_cursox . ' LIMIT 1),0) as "tiene_pond"';
	$result1 = pg_query($query1) or die('Query failed: ' . pg_last_error());
	$rox=pg_fetch_array($result1);
	if ($rox["tiene_pond"]=="0")
		 {$existe_ponderacion=false;}
	else
		 {$existe_ponderacion=true;}

	//Nombre del Curso
	$query0 = 'SELECT fullname FROM mdl_course where id='. $id_cursox;
	$result0 = pg_query($query0) or die('Query failed: ' . pg_last_error());
	$rox0=pg_fetch_array($result0);
	$nombre_curso=$rox0["fullname"];

	$titulo_pagina = "Menu de Reportes de Evidencias";
	$enlace="<a href='view.php?id=". $id_cursox . "'>". $nombre_curso . "</a> &gt; " . $titulo_pagina; 
	print_header("$site->shortname : ". $titulo_pagina, "X1", $enlace, "", "", true, "");
	
?>
<BR>
<?PHP
$query  = 'SELECT A.userid, firstname, lastname, A.camp,nombre_centro, A.carr, ';
$query .= '(Select name from mdl_groups C ';
$query .= 'inner join mdl_groups_members D on D.groupid=C.id and D.userid=A.userid ';
$query .= 'where C.courseid=A.course LIMIT 1) as grupo ';
$query .= 'From mdl_user_students A  ';
$query .= 'left join mdl_user B on A.userid=B.id ';
$query .= 'left join senati_centros on id_centro=camp  ';
$query .= 'Where A.course='. $id_cursox .' order by 7,lastname, camp,carr ';

$result = pg_query($query) or die('Query failed: ' . pg_last_error());
?>

<?PHP
if ($existe_ponderacion==false)
	 {
	  echo '<BR>Este Curso todavia NO TIENE PONDERACIONES. No se podr&aacute; generar el reporte.<BR>';
	 }
else
{	 
?>	

<p align=center>
<?PHP
echo '<a href="view.php?id='.$id_cursox . '"><u style="font-size:16px">'. $nombre_curso. '</u></a>';
?>
</p>

<div align=center>
	<strong><font color=blue>Alumnos por Campus-Carrera</font></strong>
	<TABLE border=1 cellspacing=1 cellpadding=2 bordercolor="gray">
	<TR bgcolor=#dddddd>
	<TD><strong>Carr</strong></td>
	<TD><strong>Carrera</strong></td>
	<TD><strong>Camp</strong></td>
	<TD><strong>Campus</strong></td>
	<TD><strong>Alumnos</strong></td>
	</TR>
	<?PHP
		//TOTAL ALUMNOS CAMPUS-CARRERA
		$query_alca ="Select DISTINCT(A.camp), B.nombre_centro, A.carr, C.materia_desc as carrera, count(*) as total_alu ";
		$query_alca .="from mdl_user_students A ";
		$query_alca .="left join senati_centros B on B.id_centro=A.camp ";
		$query_alca .="left Join senati_materias C on C.materia_code=A.carr ";
		$query_alca .="Where A.course=". $id_cursox . " ";
		$query_alca .="Group by A.camp, A.carr,B.nombre_centro,C.materia_desc ";
		$query_alca .="order by B.nombre_centro ";
		$result_alca = pg_query($query_alca) or die('Query failed: ' . pg_last_error());
	$total_alux=0;
	$camp_antes="X";
	$sub_total=0;
	while($rox_alca=pg_fetch_array($result_alca)) 
		{
			$total_alux=$total_alux+1-1+ $rox_alca["total_alu"];
			$sub_total=$sub_total+1-1+$rox_alca["total_alu"];
			if ($camp_antes !="X" && $camp_antes != $rox_alca["camp"])
				{
				$sub_total=$sub_total+1-1-$rox_alca["total_alu"];
				echo "<TR>";
				echo "<td align=right colspan=3><strong>Total por Campus</strong></TD>";
				
				
				//echo "<TD align=left style='color:blue'>". $campus_antes. "</td>";
			?>
				
		    <TD align=left style='color:blue'><u style="cursor:hand;cursor:pointer" onclick='ver_evi_camp("<?PHP echo $camp_antes ?>")'><?PHP echo $campus_antes ?></u></td>
				
			<?PHP	
				echo "<TD align=right><strong>". $sub_total. "</strong></td>";
				echo "</TR>";
				$sub_total=1-1+$rox_alca["total_alu"];
				}
			echo "<TR>";
			echo "<TD align=center>". $rox_alca["carr"]. "</td>";
			echo "<TD align=left>". $rox_alca["carrera"]. "</td>";
			echo "<TD align=center>". $rox_alca["camp"]. "</td>";
			echo "<TD align=left>". $rox_alca["nombre_centro"]. "</td>";
			echo "<TD align=right>". $rox_alca["total_alu"]. "</td>";
			echo "</TR>";
			$camp_antes=$rox_alca["camp"];
			$campus_antes=$rox_alca["nombre_centro"];
		}
		
		$sub_total=$sub_total+1-1-$rox_alca["total_alu"];
		
	?>		
		
		<TR>
		<td align=right colspan=3><strong>Total por Campus</strong></TD>
		<TD align=left style='color:blue'><u style="cursor:hand;cursor:pointer" onclick='ver_evi_camp("<?PHP echo $camp_antes ?>")'><?PHP echo $campus_antes ?></u></td>
		<TD align=right><strong><?PHP echo $sub_total ?></strong></td>
		</TR>

	<tr bgcolor=#cccccc>
	<td align=right colspan=4><strong>Total Alumnos</strong></TD>
	<TD align=right><strong><?PHP echo $total_alux ?></strong></TD>
	</TR>
	</TABLE>
</div>

<p align=center>
<A NAME="reportix"></A>
<div id="div_rep">

</div>
<?PHP
//Viene del else de Ponderaciones
}
?>

<BR>
<BR>

<div id="chart_tareas"></div>

<div id="chart_foros"></div>


<?PHP
    print_footer($course);
?>

<script type="text/javascript" src="jscharts.js"></script>


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

function ver_evi_camp(camp){
	obje("div_rep").innerHTML="<strong><font color=red>Espere ...</font></strong>";
	//obje("div_rep").innerHTML=id_curso+ " - " + camp;
	window.location.hash="reportix";
	url="reporte_evi_camp_ajax.php";
	
	var xmlo=crea_xmlhttpPost(url);
		 xmlo.onreadystatechange = function()
		  {
		   if (xmlo.readyState == 4) {
			   update_div(xmlo.responseText);
			   }
		  }
	qstr="curso=" + escape(<?PHP echo $id_cursox?>)+"&camp="+escape(camp);
	xmlo.send(qstr);
	
}

function ver_evi_tutor(id_tutor){
	obje("div_rep").innerHTML="<strong><font color=red>Espere ...</font></strong>";
	//obje("div_rep").innerHTML=id_curso+ " - " + camp;
	window.location.hash="reportix";
	url="reporte_evi_tutor_ajax.php";
	
	var xmlo=crea_xmlhttpPost(url);
		 xmlo.onreadystatechange = function()
		  {
		   if (xmlo.readyState == 4) {
			   update_div(xmlo.responseText);
			   }
		  }
	qstr="curso=" + escape(<?PHP echo $id_cursox?>)+"&tutor="+escape(id_tutor);
	xmlo.send(qstr);
}


function update_div(str){
	obje("div_rep").innerHTML=str;
	//crea_charts();
}


// Esto se hace despues de recibir los datos mediante ajax
function crea_charts(){
	/// Leo la tabla Tareas
	var oTable = obje('tabla_tareas');
	var lex = oTable.rows.length;
	for (i=1;i<lex;i++)	
		{
			var cole = oTable.rows.item(i).cells;
			// El PIDM esta en innerText es un cell
			//Falta Recalificar
			var nombre_tarea=cole[1].innerText;
			var no_enviaron=1*cole[2].innerText+1-1;
			var falta_calificar=1*cole[3].innerText+1-1;
			var calificados=1*cole[4].innerText+1-1;
			
			var myData = new Array(['No enviaron tarea', no_enviaron], ['Falta Calificar', falta_calificar],['Calificadas', calificados]);
			//var myData = new Array(['No enviaron tarea', 10], ['Falta Calificar', 30],['Calificadas', 50]);
			
			var myColors = new Array('#0000FF', '#FF0000','#FF00EF');

            //var contenido_anterior=obje("chart_tareas").innerHTML;
			var myChart = new JSChart('chart_tareas', 'bar');
			myChart.setDataArray(myData);
			myChart.colorizeBars(myColors);
			myChart.draw();
			//obje("chart_tareas").innerHTML="<strong>" + nombre_tarea + "</strong><BR>" + obje("chart_tareas").innerHTML;
			//var contenido_actual=obje("chart_tareas").innerHTML;
			
			obje("chart_tareas").innerHTML=contenido_anterior + "<BR><BR>" + contenido_actual;
		}
}

</script>
<?PHP
}
else
{
	echo "Debe ser Administrador o Tutor del Cursa para ingresar a esta pagina";
}
?>