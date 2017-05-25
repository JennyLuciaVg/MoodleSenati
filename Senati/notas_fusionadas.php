<?PHP

require_once("../config.php");
require_once("lib.php");


// JUSCE 10 de Julio 2013 mandar solo los NRCs y obtener el tutor de cada uno


/// JUSCE 5 de JULIO con un solo botón leer NOTA Y TUTOR

// 6 de Diciembre 2012
// Este módulo utiliza los campos 
// subsanacion_de para ubicar con que cursos se deben fusionar las notas

// Agregarle el curso correspondiente y el tutor virtual
// 

	$colox[1]="";
	$colox[2]="bgcolor=#fff799";
	$colox[3]="bgcolor=#99e3ff";
	$colox[4]="bgcolor=#feead9";

$site = get_site();
$id_curso=$_GET["id"];
	
if ($id_curso=="")
   {$id_curso=$_POST["id_curso"];}

$titulo_pagina1 = "Acta de Notas de Cursos Fusionados - (Version 24062013)";
print_header("$site->shortname : ". $titulo_pagina1, "X1", $titulo_pagina1, "", "", true, "");

$id_usuario=$USER->id;
$mensaje="";
$mensaje_fusion="";
$existe="0";		
$lista_cursix="";


// este esl array de cursos !!!!
$total_cursox=0;
$cursosex[0]=0;

$nombre_curso_padre="";

if(isteacher($course->id) || isadmin())
	{
	$nombre_moodle=$_POST["nombre_moodle"];
		
		if ($nombre_moodle=="")
		   {
			$query0  = "Select fullname from mdl_course where id=". $id_curso;
			$result0 = pg_query($query0) or die('Query failed 43: ' . pg_last_error());
			$roxy=pg_fetch_array($result0); 
			$nombre_moodle=$roxy["fullname"];
		   }
		   
	    /////////////////////////////// USO DE NUEVO METODO DE FUSION /////////////////////////////////////////////////////////////////
	
	    /////////ACA VERIFICO SI EXISTE UNA RELACION ENTRE EL CURSO ACTUAL y CUALQUIER OTRO
		// EL CURSO ACTUAL PUEDE Estar en el campo subsanacion_de
		// $id_curso estoy en este curso
		// 1) está en subsanacion_de en la lista de mdl_course
        // 2) subsanacion de
		//// BUSCO SIEMPRE AL PADRE ////////////
		//// SI ENCUENTRO AL PADRE BASTA CON HACER ESTO :
		//// Select A.id, A.subsanacion_de from mdl_course A where A.subsanacion_de=id_padre or A.id=id_padre
		//// Y el resultado esta en el id
		//// Como encuentro al padre ???
		
		
		/// AVERIGUO SI ES PADRE (1) o NO ES PADRE (0)  
		$querya="SELECT COALESCE((SELECT 1 FROM mdl_course WHERE subsanacion_de=". $id_curso ."  LIMIT 1),0)  as es_padre";
		$resulta=pg_query($querya) or die('Query failed A: ' . pg_last_error());
		$roxa=pg_fetch_array($resulta);
		$es_padre=$roxa["es_padre"];
		
		/// AVERIGUO SI ES HIJO (1) o NO ES HIJO (0)  
		$queryb="SELECT COALESCE((SELECT 1 FROM mdl_course WHERE subsanacion_de is not null and id=". $id_curso ."  LIMIT 1),0) as es_hijo";
		$resultb=pg_query($queryb) or die('Query failed B: ' . pg_last_error());
		$roxb=pg_fetch_array($resultb);
		$es_hijo=$roxb["es_hijo"];
		
		//// SI NO ES NI PADRE NI HIJO SIGNIFICA QUE NO ESTA FUSIONADO CON NADA
		$id_padre="0";
		$existe_fusion="NO";
		if ($es_hijo=="0" && $es_padre=="0")
			{
				$mensaje_fusion="Este curso no tiene cursos asociados de subsanaci&oacute;n o rezagados.";
			}
		else
			{
			if ($es_hijo=="1")
				{
				$mensaje_fusion= "Este curso est&aacute; asociado a un curso regular.";
				/// DEBO BUSCAR AL PADRE
				$queryc="SELECT subsanacion_de FROM mdl_course WHERE id=". $id_curso; 
				$resultc=pg_query($queryc) or die('Query failed C: ' . pg_last_error());
				$roxc=pg_fetch_array($resultc);
				$id_padre=$roxc["subsanacion_de"];
				$existe_fusion="SI";
				}
				
			if ($es_padre=="1")
				{
				$mensaje_fusion= "Este curso es el curso Regular y tiene cursos fusionados.";
				$id_padre=$id_curso;
				$existe_fusion="SI";
				}	
			}
		
		
		if ($id_padre != "0")
           {
		   ////	CREO LA LISTA DE CURSOS RELACIONADOS
			$queryp="Select id, fullname,periodo from mdl_course where subsanacion_de=". $id_padre ." or id=". $id_padre ;
			$resultp=pg_query($queryp) or die('Query failed D: ' . pg_last_error());
			$lista_cursix="";
			
			
			$cy=0;
			while($roxp=pg_fetch_array($resultp)) 
				 {
				 $idx=$roxp["id"];
				 if ($idx==$id_padre)
				    { 
					$nombre_curso_padre=$roxp["id"];
					$peroxido=$roxp["periodo"];
					}

				 if ($cy!=0)
				    { 
				  	$lista_cursix=$lista_cursix.",".$idx;
					}
				 else
					{
					$lista_cursix=$idx;
					}
			     $cursosex[$total_cursox]=$idx; 	
				 $total_cursox++;
				 $cy++;
				 }
           }		   
	    /////////////////////////////// FIN DE USO DE NUEVO METODO DE FUSION /////////////////////////////////////////////////////////////////
		
		// Busco el Curso REGULAR o el PRINCIPAL DESDE DONDE SE SACARON LOS TUTORES
		if ($id_padre=="0")
			{
			$id_curso_reg=$id_curso;
			}
		else
			{
			$id_curso_reg=$id_padre;
			}
		
		
		if ($lista_cursix !="")
			{
		
			$nombre_curso=$nombre_curso_padre;
			$nombre_comun=$nombre_curso;
			///////////////////////////////////////////////////////////////////////
			$query2  = 'SELECT fullname,id from mdl_course where id IN ('. $lista_cursix.')';
			$result2 = pg_query($query2) or die('Query failed: ' . pg_last_error());
			$lista_nombres_cursos="";

			while($roxy2=pg_fetch_array($result2)) 
				{
				$lista_nombres_cursos=$lista_nombres_cursos . "<BR>" . trim($roxy2["fullname"]) . " (id=". $roxy2["id"] . ")" ;
				}
				//////////////////////////////////////////
				/*$query  = 'SELECT firstname, lastname, email , max(cast( Nota as Float)) as Notax, B.pidm_banner, max(A.nrc) as nrc, max(A.bloque) as bloque, A.periodo, A.camp, A.userid, status_sinfo, M.nombre_centro ';
				$query .= 'From mdl_user_students A inner join mdl_user B on userid=B.id ';
				$query .= 'left join senati_usuarios K on K.id_usuario=B.id ';
				$query .= 'left join senati_centros M on M.id_centro=A.camp ';
				$query .= 'left join senati_actas_notas C on C.id_curso=A.course and B.id=id_alumno Where A.course IN ('. $lista_cursix.') ';
				$query .= 'Group by ';
				$query .= 'firstname, lastname, email,A.nrc,A.bloque,B.pidm_banner, A.periodo, A.camp, A.userid,status_sinfo, nombre_centro ';
				$query .= 'order by status_sinfo ASC, camp, A.nrc, lastname ';
				*/
				
				//// ESTE QUERY ME DA EL ID DEL CURSO EN EL CUAL OBTUVO LA NOTA 
				$query  = 'SELECT firstname, lastname, email , max(cast(Nota as Float)) as Notax, B.pidm_banner, ';
				$query .= 'max(A.nrc) as nrc, max(A.bloque) as bloque, A.periodo, A.camp, A.userid, status_sinfo, M.nombre_centro ';
				//$query .= '(Select id from mdl_course J where J.id in ('. $lista_cursix.') and subsanacion_de is null) as id_cursox ';
				$query .= 'From mdl_user_students A ';
				$query .= 'inner join mdl_user B on userid=B.id ';
				$query .= 'left join senati_usuarios K on K.id_usuario=B.id ';
				$query .= 'left join senati_centros M on M.id_centro=A.camp ';
				$query .= 'left join senati_actas_notas C on C.id_curso=A.course and B.id=id_alumno ';
				$query .= 'Where A.course IN ('. $lista_cursix.') ';
				$query .= 'Group by ';
				$query .= 'firstname, lastname, email,A.nrc,A.bloque,B.pidm_banner, A.periodo, A.camp, ';
				$query .= 'A.userid,status_sinfo, nombre_centro ';
				$query .= 'order by status_sinfo ASC, A.nrc, camp, lastname';
				
				$resultado_final = pg_query($query) or die('Query failed 177: ' . pg_last_error());
				
				
			

				// NOMBRE DEL CURSO SINFO
				$query3  = 'Select distinct(banner_subj_code), banner_crse_numb, nombre_curso From senati_rela_cursos_cursos a ';
				$query3 .= 'inner Join mdl_course b on b.id=a.id_course_moodle ';
				$query3 .= 'inner Join senati_cursos c on a.id_curso_senati=c.id_curso where b.id IN ('. $lista_cursix.')';
				$result3 = pg_query($query3) or die('Query failed: ' . pg_last_error());

				$row3=pg_fetch_array($result3);
				$nombre_curso_senati=$row3["nombre_curso"];
				$codigo_sinfo=$row3["banner_subj_code"].'-'. $row3["banner_crse_numb"];
				//////////////////////////////////////////
				//NRCS DISTINTOS
				$query_nrcs = 'SELECT distinct(A.nrc) as nrc From mdl_user_students A Where a.course IN ('. $lista_cursix.')';
				$result_nrcs = pg_query($query_nrcs) or die('Query failed 90: ' . pg_last_error());
				$lista_nrcs="";
				$ctx=0;
				while($row_nrc=pg_fetch_array($result_nrcs))
					{
					if ($row_nrc["nrc"] !="")
						{
							if ($lista_nrcs=="")
							   {$lista_nrcs="'".$row_nrc["nrc"]."'";}
							else
							   {
							   $lista_nrcs=$lista_nrcs . ",'" . $row_nrc["nrc"]."'";
							   }
						}
					$ctx++;
					}
				$total_nrcs=$ctx;
				
				////////////////////////////////
				
				//NRCS - CAMP DISTINTOS
				$query_nrcs_camp  = 'SELECT distinct(A.nrc) as nrc, camp, nombre_centro as campus From mdl_user_students A ';
				$query_nrcs_camp .= 'left join senati_centros B on id_centro=A.camp ';
				$query_nrcs_camp .= 'Where a.course IN ('. $lista_cursix.')';
				$result_nrcs_camp = pg_query($query_nrcs_camp) or die('Query failed 236: ' . $query_nrcs_camp . ' - '. pg_last_error());
				$lista_nrcs_camp="";
				$ctxcamp=0;
				while($row_nrc_camp=pg_fetch_array($result_nrcs_camp))
					{
					if ($row_nrc_camp["nrc"] !="")
						{
							if ($ctxcamp!=0)
							   {$lista_nrcs_camp=$lista_nrcs_camp . "<BR>" . $row_nrc_camp["nrc"]." - ". $row_nrc_camp["camp"] . " - " . $row_nrc_camp["campus"];}
							else
							   {$lista_nrcs_camp=$row_nrc_camp["nrc"]." - ". $row_nrc_camp["camp"] . " - " . $row_nrc_camp["campus"];}
						}
					$ctxcamp++;
					}
				$total_nrcs_camp=$ctxcamp;
			}
		else
			{
			$mensaje="Este curso no est&aacute; fusionado con ning&uacute;n otro.";
			}
?>
<strong><a href="view.php?id=<?PHP echo $id_curso?>"><u style="color:blue"><?PHP echo $nombre_moodle ?></u></a></strong> -&gt; <strong>Notas Fusionadas</strong>
<BR>
<BR>
<p>
<a href="notas_fusionadas_sin_retirados.php?id=<?PHP echo $id_curso?>"><u>VER NOTAS FUSIONADAS SIN RETIRADOS DE SINFO</u></a>
</p>


<?PHP

echo "<p>";
echo "<em>Id del Curso : " . $id_curso . "</em>";
echo "<BR>";
echo "<em>". $mensaje_fusion . "</em>";
echo "<BR>";
echo "<em>Lista de Cursos : ". $lista_cursix . "</em>";
echo "<BR>";
echo "<em><font color=red>Id del Curso desde donde se obtendr&aacute; el TUTOR DEL ALUMNO: " . $id_curso_reg . "</font></em>";

echo "</p>";

if (trim($mensaje)=="")
      {
	  //// PONGO LA LISTA *****************************************
   	  
	 
?>

<strong style="color:blue"><u>CURSOS</u> : <?PHP echo $lista_nombres_cursos ?></strong>
<BR><BR>
<strong>CURSO SINFO : <?PHP echo $nombre_curso_senati. ' ('.$codigo_sinfo.')' ?></strong>

<BR><BR>
<input type="button" value="Leer Notas SINFO SHRCMRK (SSB)" onclick="procesar();">&nbsp;&nbsp;&nbsp;<font style="font-size:14px" id=fones color=red></font><BR><br>
<input type="button" value="Leer Notas SINFO SHACRSE (INB H.A.)" onclick="procesar_shacrse();">&nbsp;&nbsp;&nbsp;<font style="font-size:14px" id=fones2 color=red></font><BR><br>
<input type="button" value="Leer Tutores SINFO" onclick="crea_tabla_nrcs_tutores();">&nbsp;&nbsp;&nbsp;<font style="font-size:14px" id=fonest color=red></font>



<BR><BR>


Leer desde la linea : <INPUT type=text value="1" id=tx_linea name=tx_linea size=3>

<BR><BR>
<div id="div_tabla">
<table cellpadding="2" cellspacing="2" border=1 bordercolor="gray" id="tabla_data">
<TR bgcolor="#dddddd">
<td><strong>N&deg;</strong></td>
<td><strong>ID SINFO</strong></td>
<td><strong>Apellidos, Nombres</strong></td>
<td><strong>PIDM</strong></td>
<td><strong>NRC</strong></td>
<td><strong>PERIODO</strong></td>
<td align=center><strong>NOTA SV</strong></td>
<td align=center><strong>NOTA Sinfo<BR>SHRCMRK</strong></td>
<td align=center><strong>NOTA Sinfo<BR>SHACRSE</strong></td>
<td align=center><strong>Estado SV</strong></td>
<td align=center><strong>STATUS SINFO</strong></td>
<td align=left><strong>TUTOR SINFO</strong></td>
<td><strong>BLOQUE</strong></td>
<td><strong>CAMP</strong></td>
<td><strong>CAMPUS</strong></td>
<td><strong>ID Alumno Moodle</strong></td>
<td><strong>Tutor Virtual</strong></td>
<td><strong>ID Tutor</strong></td>
</TR>

<?PHP
$c1=0;
$total_ap=0;
$total_de=0;
$total_np=0;
$total_ret_sinfo=0;
//COLOR de fondo
$nuc=0;
$id_user_ant=0;

while($row=pg_fetch_array($resultado_final)) 
	{
	$id_userx=$row["userid"];
	$c1++;

if($row["status_sinfo"]=="RET")
	{$total_ret_sinfo++;}

$id_alu=$row["pidm_banner"];
if ($id_alu !="")
   {$id_alu=str_pad($id_alu, 9, "0", STR_PAD_LEFT);}

$nrcz=$row["nrc"];
if ($row["nrc"]=="")
	{$nrcz="0";}

$periodoz=$row["periodo"];
if ($row["periodo"]=="")
	{$periodoz="0";}


///////// ACA TENGO LA NOTA DEL SELECT
$nota_leida=$row["notax"];	
	
$stax="";	
if ($nota_leida*100 >= 1050)
	{
	$statux="<font color=blue>Aprobado</font>";
	$total_ap++;
	$stax="AP";
	}	
else
	{
	$statux="<font color=red>Desaprobado</font>";
	$total_de++;
	$stax="DE";
	}

//FORMATEO LA NOTA	
$notaw = str_replace(".", ",", $nota_leida);	
if ($nota_leida*100 < 1000)
	{
	$notaw='0'.$notaw;
	}	
if ($notaw=="0")
	{
	$notaw='01,0';	
	}
if (strlen($notaw)==2)
	{
		$notaw=$notaw.',0';
	}


	$id_alu_moodle=$row["userid"];
	
	
//	if($id_curso_reg!=2508)
//	{

    

		/// CON ESTO TENGO EL NOMBRE DEL TUTOR
		
		// REVISAR ACA PUES HE PUESTO UN PARCHE CON LIMIT 1
		
		$qtutor  = "select lastname||', '||firstname as tutor, pidm_banner from mdl_user_teachers A ";
		$qtutor .= "inner join mdl_user C on A.userid=C.id ";
		$qtutor .= "Where A.course=". $id_curso_reg ." and A.userid ";
		$qtutor .= "in (select B.userid from mdl_groups_members B Where groupid=(select groupid from mdl_groups_members P Where groupid in (Select id from mdl_groups Q where courseid=A.course) and userid=". $id_alu_moodle." LIMIT 1))";
		$rqtutor = pg_query($qtutor) or die('Query failed 402, Alumno : '. $id_alu_moodle .', ID CURSO REG : '. $id_curso_reg. ' --- ' . pg_last_error());

		$row_tut=pg_fetch_array($rqtutor);
		$tut_alu=$row_tut["tutor"];
		$tut_alu_id=$row_tut["pidm_banner"];
		
		if (trim($tut_alu_id)=="")
		 {
			 $crt=0;
			 while ($crt!= $total_cursox)
			{	/// CON ESTO TENGO EL NOMBRE DEL TUTOR
			
				$id_curso_rex=$cursosex[$crt];
				$qtutor  = "select lastname||', '||firstname as tutor, pidm_banner from mdl_user_teachers A ";
				$qtutor .= "inner join mdl_user C on A.userid=C.id ";
				$qtutor .= "Where A.course=". $id_curso_rex ." and A.userid ";
				$qtutor .= "in (select B.userid from mdl_groups_members B Where groupid=(select groupid from mdl_groups_members P Where groupid in (Select id from mdl_groups Q where courseid=A.course) and userid=". $id_alu_moodle."))";
				$rqtutor = pg_query($qtutor) or die('Query failed 419: ' . pg_last_error());

				$row_tut=pg_fetch_array($rqtutor);
				$tut_alu=$row_tut["tutor"];
				$tut_alu_id=$row_tut["pidm_banner"];
				$crt++;
			}	
		}



	
?>
<TR>
<td align="right"><?php echo $c1 ?></td>
<td align="right" style="color:blue"><?php echo $id_alu ?></td>
<td ><?php echo $row["lastname"]. ', '. $row["firstname"] ?></td>
<td align="right" ><?php echo $row["pidm_banner"] ?></td>
<td align="center"><?PHP echo $row["nrc"] ?></td>
<td align="center"><?PHP echo $row["periodo"] ?></td>
<td align="center"><?php echo $notaw ?></td>
<td align="center" style="color:green">&nbsp;</td>
<td align="center" style="color:green">&nbsp;</td>
<td align="center"><?php echo $statux ?></td>
<td align="center">&nbsp;<strong style="color:red"><?PHP echo $row["status_sinfo"] ?></strong>&nbsp;</td>
<td align="center" style="color:green">&nbsp;</td>
<td align="center"><?PHP echo $row["bloque"] ?></td>
<td align="center"><?PHP echo $row["camp"] ?></td>
<td><?PHP echo $row["nombre_centro"] ?></td>
<td align="right"><?PHP echo $row["userid"] ?></td>
<td align="center"><font color=green><?PHP echo $tut_alu ?></font></td>
<td align="center"><font color=green><?PHP echo $tut_alu_id ?></font></td>
</TR>
<?PHP
}

//Porcentajes
//number_format($nota_ponderadax,1);

$total_aprobados_porc=0;
$total_desaprobados_porc=0;
$total_no_aprobados=0;
$total_no_aprobados_porc=0;

if ($c1!="0" && $c1!="")
	{
	$total_aprobados_porc=number_format(100*$total_ap/$c1,1);
	$total_desaprobados_porc=number_format(100*$total_de/$c1,1);
	$total_no_aprobados=$total_de+1-1+$total_re+$total_np;
	$total_no_aprobados_porc=number_format(100*$total_no_aprobados/$c1,1);
	}
?>
</table>
</div>
<P>
<strong>DE HISTORIA ACADEMICA</strong><BR><BR>
<TABLE border=1 cellspacing=1 cellpadding=3 bordercolor="gray">
<TR>
<TD bgcolor="#efefef" colspan=3><strong>RESUMEN</strong></td>
</TR>
<TR>
<td align=right>Aprobados&nbsp;</td><td align=right>&nbsp;<?PHP echo $total_ap?></td>
<td align=right>&nbsp;<?PHP echo $total_aprobados_porc?> %</td>
</TR>
<TR>
<td align=right>Desaprobados&nbsp;</td><td align=right>&nbsp;<?PHP echo $total_no_aprobados?></td>
<td align=right>&nbsp;<?PHP echo $total_no_aprobados_porc?> %</td>
</tr>
<td align=right><strong>TOTAL</strong>&nbsp;</td><td align=right>&nbsp;<strong><font color=blue><?PHP echo $c1?></font></strong></td>
<td align=right>&nbsp;100 %</td>
</tr>
</table>
<BR>
<div id="chartcontainer01"></div>



<BR>
<strong>RETIRADOS DE SINFO : <font color=red><?PHP echo $total_ret_sinfo?></font></strong>.
<BR>
</p>
<BR>
<form id="formabla" method="post" target=_blank action="acta_notas_para_sinfo_fusion_una_nota_excel.php">
<input type=button value="Ver tabla para Copiar a Excel" onclick="ver_tabla();">
<BR><BR>
<textarea rows=10 cols=100 name="contenido_tabla" id="contenido_tabla"></textarea>
</form>
<BR>
<INPUT type=hidden name="tx_conteo_notas" id="tx_conteo_notas" value="0">
<INPUT type=hidden name="tx_conteo_notas2" id="tx_conteo_notas2" value="0">
<INPUT type=hidden name="tx_conteo_tutores" id="tx_conteo_tutores" value="0">

<BR>
<STRONG>PARA ADMINISTRACION</STRONG>
<p>
NRCS<BR>
<INPUT type=text id="txa_nrcs" name="txa_nrcs" readOnly value="<?PHP echo $lista_nrcs ?>" size=80><BR><BR>

PERIODO<BR>
<input type=text id="tx_periodo" name="tx_periodo" readOnly value="<?PHP echo $peroxido?>"><BR><BR>

Total NRCS<BR>
<INPUT type=text id="tx_total_nrcs" name="tx_total_nrcs" readOnly value="<?PHP echo $total_nrcs ?>" size=4>
</p>

<div id="div_nrcs_tutores" name="div_nrcs_tutores">
</div>


<p>
<strong>DATOS SENATI VIRTUAL (NRC-CAMP-CAMPUS)</strong>
<BR>
<?PHP echo $lista_nrcs_camp?>
</p>

<?PHP

      //// TERMINO LA LISTA *****************************************
	  }
else
      {
	  echo $mensaje;
	  }  	  
?>



<?PHP		

	////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	
	
	}
else

	{
	echo "Debe ser Administrador o Tutor del Curso para entrar a esta pagina";
	}	
?>	

<?PHP
print_footer();
?>

<?PHP
if ($existe_fusion=="SIxxxxxxx")
{
?>
<script type="text/javascript" src="jscharts.js"></script>
<script type="text/javascript">
	
	var myData = new Array(['Aprobados', <?PHP echo $total_ap?>], ['Desaprobados', <?PHP echo $total_no_aprobados?>]);
	var myColors = new Array('#0000FF', '#FF0000');
	
	var myChart = new JSChart('chartcontainer01', 'bar');
	myChart.setDataArray(myData);
	myChart.colorizeBars(myColors);
	
	myChart.draw();
</script>
<?PHP
}
?>
<script language="javascript">

function obje(ide){
	var obex=document.getElementById(ide);
	return obex;
}


function ver_tabla(){
	var str=obje("div_tabla").innerHTML;
	obje("contenido_tabla").value=str;
	obje("formabla").submit();
}

function pausecomp(millis) 
{
	var date = new Date();
	var curDate = null;

	do { curDate = new Date(); } 
	while(curDate-date < millis);
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

function procesar(){
    
	obje("tx_conteo_notas").value="0";
	var leerdesde=1+1*obje('tx_linea').value-1;
	obje("fones").innerText="";
	window.status="Extrayendo informacion ....";
	var oTable = obje('tabla_data');
	var lex = oTable.rows.length;
	
	
    //limpiar celdas
	for (i=leerdesde;i<lex;i++)	
		{
			var zx=i+1;
			var cole = oTable.rows.item(i).cells;	
		
			var objth_nota_sinfo=cole[7];
			var objth_nota_sv=cole[6];
			
			objth_nota_sinfo.innerText="";
		
			objth_nota_sinfo.style.backgroundColor="white";
			objth_nota_sv.style.backgroundColor="white";
		}	
	
	

	for (i=leerdesde;i<lex;i++)	
		{
			var zx=i+1;
			var cole = oTable.rows.item(i).cells;
			var objth_pidm=cole[3];

			var ix=objth_pidm.sourceIndex;

			var pidm=objth_pidm.innerText;

			var objth_nrc=cole[4];
			var nrc=objth_nrc.innerText;
			
			var objth_periodo=cole[5];
			var periodo=objth_periodo.innerText;
			
			//leer_nota(pidm,nrc,periodo,ix+4,zx,lex);
			leer_nota(pidm,nrc,periodo,i,zx,lex);
		}
}

function leer_nota(pidmx,nrcx,periodox,indice_objeto,nume,total){
	url="acta_notas_para_sinfo_proxy.php";
	var xmlo=crea_xmlhttpPost(url);
		 xmlo.onreadystatechange = function()
		  {
		   if (xmlo.readyState == 4)
			   {
			   update_data(xmlo.responseText,indice_objeto,nume,total);
			   }
		  }
	var pidm=pidmx;
	var nrc=nrcx;
	var periodo=periodox;

	qstr="pidm=" + escape(pidm) + "&periodo="+escape(periodo)+ "&nrc="+escape(nrc);
	xmlo.send(qstr);
}

function update_data(str,indice,numex,totalx){
    var valor_conteo_notas=obje("tx_conteo_notas").value;
	valor_conteo_notas++;
	obje("tx_conteo_notas").value=valor_conteo_notas;
	obje("fones").innerText="Procesando " + valor_conteo_notas + " de " + (totalx-1) ;
	window.status="Procesando " + valor_conteo_notas + " de " + (totalx-1);

	if (valor_conteo_notas==totalx-1)
	   {
	   obje("fones").innerText="Listo Notas";
	   window.status="Listo Notas";
	   }

	if(str.indexOf("x") ==-1)
	  {
		var strx=str;
		if(strx =="1")
		  {var strx="01,0";}
		
        var oTable = obje('tabla_data');
		var cole = oTable.rows.item(indice).cells;
		
		var objth_nota_sinfo=cole[7];
		var objth_nota_sv=cole[6];
		
		objth_nota_sinfo.innerText=strx;
		var nota_sv=objth_nota_sv.innerText;
		
		objth_nota_sinfo.style.backgroundColor="white";
		objth_nota_sv.style.backgroundColor="white";

		
		if (nota_sv != strx)
		   {
			objth_nota_sinfo.style.backgroundColor="silver";
			//objth_nota_sv.style.backgroundColor="silver";
		   }
		/// ESTO EVITA CONFUNDIR LA NOTAS entr QUE 1 y 0.1
		
		if(strx=="00,0" || strx=="01,0" || strx=="00,1" || strx=="00,2" || strx=="00,3" || strx=="00,4" || strx=="00,5" || strx=="00,6" || strx=="00,7" || strx=="00,8" || strx=="00,9")
			  {
			  if (nota_sv=="00,0" || nota_sv=="01,0" || nota_sv=="00,1" || nota_sv=="00,2" || nota_sv=="00,3" || nota_sv=="00,4" || nota_sv=="00,5" || nota_sv=="00,6" || nota_sv=="00,7" || nota_sv=="00,8" || nota_sv=="00,9")
				 {
				 objth_nota_sinfo.style.backgroundColor="";
				 objth_nota_sv.style.backgroundColor="";
				 }
			  }
		}
}
/// Lleno la tabla de nrcs
/// notas_fusionadas_proxy.php

function crea_tabla_nrcs_tutores(){
   obje("div_nrcs_tutores").innerText="";
	url="notas_fusionadas_proxy.php";
	obje("fonest").innerText="Espere...";
	var xmlo=crea_xmlhttpPost(url);
		 xmlo.onreadystatechange = function()
		  {
		   if (xmlo.readyState == 4)
			   {
			   update_tabla_tutor_nrc(xmlo.responseText);
			   }
		  }
	var nrcs=obje("txa_nrcs").value;
	var periodo=obje("tx_periodo").value;
	qstr="periodo="+escape(periodo)+ "&nrcs="+escape(nrcs);
	xmlo.send(qstr);
}

function update_tabla_tutor_nrc(str){
	obje("div_nrcs_tutores").innerHTML=str;
	
	// Ahora tengo una tabla con los NRCS y SUS TUTORES
	// DEBO HACER EL RECORRIDO de la TABLA GRANDE Y UBICAR LOS DATOS EN LA TABLA CHICA
	// PARA ESO CREO UN ARRAY DE NRC y NOMBRES
	
	// tabla_nrc_tutores (NRC, TUTOR y PIDM)
	var oTable = obje('tabla_nrc_tutores');
	var lex = oTable.rows.length;
	// creo un array con nrcs y tutores
	// tx_total_nrcs
	
	
	tox=obje("tx_total_nrcs").value;
	
	var arra_nrc = new Array(tox+1); 
	var arra_tutor = new Array(tox+1); 
	
	
	/// ESTO ES PARA LOS QUE EXISTEN EN SINFO
	var total_nrcs=0;
	for (i=1;i<lex;i++)	
		{
			var cole = oTable.rows.item(i).cells;	
			var obj_nrc=cole[0].innerText;
			var obj_tutor=cole[1].innerText;
			if (obj_nrc !="")
				{
					 //arrax[obj_nrc]=obj_tutor;
					
					arra_nrc[total_nrcs]=obj_nrc;
					arra_tutor[total_nrcs]=obj_tutor;
					total_nrcs++;
				}
		}	
	// Tengo el array de Tutores de 0 a total_nrcs-1
	
	obje("tx_total_nrcs").value=total_nrcs;
	
	
	/// Ahora si hago un barrido de los NRCS que hay en la tabla grande
	
	var leerdesde=1+1*obje('tx_linea').value-1;
	obje("fones").innerText="";
	var oTable = obje('tabla_data');
	var lex = oTable.rows.length;
	
    //limpiar celdas de TUTORES
	for (i=leerdesde;i<lex;i++)	
		{
			var cole = oTable.rows.item(i).cells;	
			var objth_tutor_sinfo=cole[11];
			objth_tutor_sinfo.innerText="";
		}
	
	//PONGO TUTORES USANDO LOS ARRAY
	// Poner un contador
	for (i=leerdesde;i<lex;i++)	
		{
		    obje("fonest").innerText=i + " de "+ lex;;
			var cole = oTable.rows.item(i).cells;	
			var objth_nrc_alumno=cole[4];
			var nrc=objth_nrc_alumno.innerText;
				// ubico al tutor 			
				var tutor="";
				for (j=0;j<total_nrcs;j++)
					{
					if (arra_nrc[j]==nrc)
						{
						tutor=arra_tutor[j];
						break;
						}
					}
			//PEGO EL TUTOR		
			var objth_tutor_sinfo=cole[11];	
			objth_tutor_sinfo.innerHTML="<font color=green>"+ tutor +"</font>";
		}	
	
	obje("fonest").innerText="Listo";
	////// FIN DE RECORRIDO DE TABLA GRANDE
	
}

//crea_tabla_nrcs_tutores();

///////////////////////////////////////////////////// TABLA SHACRSE ////////////////////////////////////////////////////////////////////////////

function procesar_shacrse(){
    
	obje("tx_conteo_notas2").value="0";
	var leerdesde=1+1*obje('tx_linea').value-1;
	obje("fones2").innerText="";
	window.status="Extrayendo informacion ....";
	var oTable = obje('tabla_data');
	var lex = oTable.rows.length;
	
	
    //limpiar celdas
	for (i=leerdesde;i<lex;i++)	
		{
			var zx=i+1;
			var cole = oTable.rows.item(i).cells;	
		
			var objth_nota_sinfo_shacrse=cole[8];
			
			objth_nota_sinfo_shacrse.innerText="";
			objth_nota_sinfo_shacrse.style.backgroundColor="white";
		}	
	
	

	for (i=leerdesde;i<lex;i++)	
		{
			var zx=i+1;
			var cole = oTable.rows.item(i).cells;
			var objth_pidm=cole[3];

			var pidm=objth_pidm.innerText;

			var objth_nrc=cole[4];
			var nrc=objth_nrc.innerText;
			
			var objth_periodo=cole[5];
			var periodo=objth_periodo.innerText;
			
			leer_nota_shacrse(pidm,nrc,periodo,i,zx,lex);
		}
}

function leer_nota_shacrse(pidmx,nrcx,periodox,indice_objeto,nume,total){
	url="notas_fusionadas_proxy_shacrse.php";
	var xmlo=crea_xmlhttpPost(url);
		 xmlo.onreadystatechange = function()
		  {
		   if (xmlo.readyState == 4)
			   {
			   update_data_shacrse(xmlo.responseText,indice_objeto,nume,total);
			   }
		  }
	var pidm=pidmx;
	var nrc=nrcx;
	var periodo=periodox;

	qstr="pidm=" + escape(pidm) + "&periodo="+escape(periodo)+ "&nrc="+escape(nrc);
	xmlo.send(qstr);
}

/////// UPDATE DATE SHACRSE
function update_data_shacrse(str,indice,numex,totalx){
    var valor_conteo_notas=obje("tx_conteo_notas2").value;
	valor_conteo_notas++;
	obje("tx_conteo_notas2").value=valor_conteo_notas;
	obje("fones2").innerText="Procesando " + valor_conteo_notas + " de " + (totalx-1) ;

	if (valor_conteo_notas==totalx-1)
	   {
	   obje("fones2").innerText="Listo Notas";
	   }

	if(str.indexOf("x") ==-1)
	  {
		var strx=str;
		if(strx =="1")
		  {var strx="01,0";}
		
        var oTable = obje('tabla_data');
		var cole = oTable.rows.item(indice).cells;
		
		var objth_nota_sinfo_shacrse=cole[8];
		var objth_nota_sv=cole[6];
		
		objth_nota_sinfo_shacrse.innerText=strx;
		var nota_sv=objth_nota_sv.innerText;
		
		objth_nota_sinfo_shacrse.style.backgroundColor="white";

		
		if (nota_sv != strx)
		   {
			objth_nota_sinfo_shacrse.style.backgroundColor="silver";
		   }
		/// ESTO EVITA CONFUNDIR LA NOTAS entr QUE 1 y 0.1
		
		if(strx=="00,0" || strx=="01,0" || strx=="00,1" || strx=="00,2" || strx=="00,3" || strx=="00,4" || strx=="00,5" || strx=="00,6" || strx=="00,7" || strx=="00,8" || strx=="00,9")
			  {
			  if (nota_sv=="00,0" || nota_sv=="01,0" || nota_sv=="00,1" || nota_sv=="00,2" || nota_sv=="00,3" || nota_sv=="00,4" || nota_sv=="00,5" || nota_sv=="00,6" || nota_sv=="00,7" || nota_sv=="00,8" || nota_sv=="00,9")
				 {
				 objth_nota_sinfo_shacrse.style.backgroundColor="";
				 }
			  }
		}
}

///////////// FIN TABLA SHACRSE SHRTCKG

</script>