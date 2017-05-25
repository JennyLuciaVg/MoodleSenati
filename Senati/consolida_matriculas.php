<?PHP

    require_once("../config.php");
    require_once("lib.php");

    if (isadmin())
{
	//$id_curso_moodle= optional_param('id', 0, PARAM_INT);
	
	$id_curso_moodle=$_GET["id"];
	
	$site = get_site();

	//print_header("$site->shortname : ". $titulo_pagina, "X1", $titulo_pagina, "", "", true, "");
	
	if($id_curso_moodle=="")
	  {$id_curso_moodle=$_POST["id_curso_moodle"];}
	  
	//MATRICULAR  
	//VERIFICO SI DEBO MATRICULAR ALUMNOS
	$numero_registros=0;
	$mensaje="";
	$accion=$_POST["tx_accion"];
	$alus_creados="";
	
	
///////////////////////////// SALVAR 

	if ($accion=="salvar")
		{
		$periodico=$_POST["periodo_curso"];
		//matricular a los alumnos
		$numero_matriculas = count($_POST["inp_sv_id"]);
        $rxmat=0; 

		
		for ($i=0; $i<$numero_matriculas; $i++)
			{
			  $id_user_sv=$_POST["inp_sv_id"][$i];
  			  $pidm_sinfo=$_POST["inp_pidm"][$i];
			  $camp=trim($_POST["inp_camp"][$i]);
			  $nrc=trim($_POST["inp_nrc"][$i]);
			  $bloque=trim($_POST["inp_bloque"][$i]);
			  $ape_nombres=trim($_POST["inp_ape_nombres"][$i]);
			  
			  if ($id_user_sv =="")
			  {
			    // Los busco en la base de datos como usuario o pidm_banner
				// tengo el pidm de todos modos
				$sql1="Select id from mdl_user where deleted=0 and (pidm_banner=". $pidm_sinfo . " or username='". $pidm_sinfo."')";
				$res_sql1=pg_query($sql1) or die('Query failed 43: ' . pg_last_error());
				$rocio1=pg_fetch_array($res_sql1); 
		
		        $id_user_sv=$rocio1["id"];
				// si tampoco existe : debo crearlo !!!!!!!!!!!!!!!!!!!!!
				
				
				if ($id_user_sv =="")
				   {
				   $pos_coma=strrpos($ape_nombres, ",");
   				   $apes=substr($ape_nombres,0,$pos_coma);
				   $nombres=substr($ape_nombres,$pos_coma+2);
				   $emilio=$pidm_sinfo . "@senati.pe";
				   
				   // EL CAMPUS DEBO SACARLO DE LA BASE DE DATOS
				   $qcamp="select nombre_centro from senati_centros where id_centro='". $camp ."'";
				   $rscamp=pg_query($qcamp) or die('Query failed 61: ' . pg_last_error());
				   $roco=pg_fetch_array($rscamp); 
				   $ciudad=$roco["nombre_centro"];
				   
				   
				   ///ACA CREO ALUMNOS AUTOMATICAMENTE//////////////////////
				   $qcrear  ="Insert into mdl_user(username,lastname,firstname,pidm_banner,password,campus,city,email,confirmed,pidm_ok,tipo_user) values(";
				   $qcrear .="'" . $pidm_sinfo . "','" . $apes . "','" . $nombres . "',". $pidm_sinfo . ", md5('123456'),'" . $camp . "','". $ciudad ."','" . $emilio . "',1,'s',3)";
				   $rs_crear=pg_query($qcrear) or die('Query failed 68: ' . pg_last_error());
				   $oxytemp=pg_fetch_array($rs_crear); 

				   //// AHORA DEBO BUSCAR AL ALUMNO CREADO
				   $q21="select id from mdl_user where pidm_banner=". $pidm_sinfo. " and campus='". $camp . "' and username='". $pidm_sinfo. "'";
				   $rs21=pg_query($q21) or die('Query failed 73: ' . pg_last_error());
				   $rox21=pg_fetch_array($rs21); 
				   $id_user_sv=$rox21["id"];
				   
				   $alus_creados .="<BR>" . $apes. ", " . $nombres . " (ID SINFO : ". $pidm_sinfo . ", ID SV :" . $id_user_sv . ")";
				   
				   /////////////////////////
				   $no_existen++;
				   }
			  }
			  if ($id_user_sv !="")
			    {
					if ($camp=="")
						{$camp="NULL";}
					else
						{$camp="'".$camp."'";}
						
					if ($nrc=="")
					   {$nrc="NULL";}
					else
					   {$nrc="'".$nrc."'";}
				    
					if ($bloque=="")
			           {$bloque="NULL";}
			        else
			           {$bloque="'".$bloque."'";}
					   
					/// VERIFICAR QUE EL ALUMNO NO ESTA MATRICULADO POR OTRA VIA
					$qexiste="SELECT COALESCE((SELECT 1 FROM mdl_user_students WHERE course=". $id_curso_moodle ." and userid=". $id_user_sv ." LIMIT 1),0) as existe";
					$rexiste=pg_query($qexiste) or die('Query failed 103: ' . pg_last_error());
					$row_existe=pg_fetch_array($rexiste);
					$existe=$row_existe["existe"];
					
					if ($existe=="0")
						{
						$qmatri  = "Insert into mdl_user_students (course,userid,camp,nrc,periodo,bloque,enrol) values (";
						$qmatri .= $id_curso_moodle. "," . $id_user_sv . ",". $camp. "," . $nrc. ",'". $periodico ."',". $bloque . ",'manual')";
						$rmatri=pg_query($qmatri) or die('Query failed 111: ' . pg_last_error());
						$rxmat++;
						}
				}
			}
	 		$mensaje="Se matricularon ". $rxmat . " Alumnos. " . $bloque;
		}





//////////////////////////// FIN SALVAR
	
    //id_curso_moodle	  
	//periodo_curso
	//tx_accion
	//inp_sv_id[]
	//inp_pidm[]
	//inp_camp[]
	//inp_nrc[]
	//inp_bloque[]
	// El input PIDM ME SIRVE SI ES QUE NO TENGO EL SV_ID
	//FIN MATRICULAR  
	
	//// OBTENCION DE DATOS DEL CURSO
	
		$query0  = "Select fullname,startdate, A.periodo, banner_subj_code, banner_crse_numb, C.materia_sinfo, C.curso_sinfo from mdl_course A ";
		$query0 .= "left join senati_rela_cursos_Cursos B on id_course_moodle=A.id ";
		$query0 .= "left join senati_cursos C on C.id_curso=id_curso_senati ";
		$query0 .= "where A.id=". $id_curso_moodle;
		
	    $result0 = pg_query($query0) or die('Query failed: ' . pg_last_error());
		$roxy=pg_fetch_array($result0); 
		
		$nombre_moodle=$roxy["fullname"];
		$fecha_inicio_nf=$roxy["startdate"];
		$fecha_inicio=date("d-m-Y",$fecha_inicio_nf);
		$periodo_curso=$roxy["periodo"];
		$materiax=$roxy["banner_subj_code"];
		$cursox=$roxy["banner_crse_numb"];

		$materiay=$roxy["materia_sinfo"];
		$cursoy=$roxy["curso_sinfo"];
	
	//// FIN DE OBTENCION DE DATOS DEL CURSO
	  
	  
	

	$titulo_pagina1 = "Consolidaci&oacute;n de Matriculas con SINFO ";
	$titulo_pagina2 = "Consolidaci&oacute;n de Matriculas con SINFO ";
	
	print_header("$site->shortname : ". $titulo_pagina1, "X1", $titulo_pagina2, "", "", true, "");

	$query  ="SELECT distinct(pidm_banner), status_sinfo ";
	$query .="From mdl_user_students A ";
    $query .="left join mdl_user B on userid=B.id ";
	$query .="Where A.course=" . $id_curso_moodle;

	$result = pg_query($query) or die('Query failed: ' . pg_last_error());
	// Printing results in HTML
	
	//// BLOQUES DISTINTOS
	$queryb  ="SELECT distinct(bloque) ";
	$queryb .="From mdl_user_students A ";
	$queryb .="Where bloque<>'' and bloque is not null and A.course=" . $id_curso_moodle;

	$resultb = pg_query($queryb) or die('Query failed: ' . pg_last_error());
	// Printing results in HTML
	$cb=0;
	$lista_bloques="";
	while($rocb=pg_fetch_array($resultb)) 
		{
		if ($cb!=0)
		   {
		   $lista_bloques=$lista_bloques . ",'" . $rocb["bloque"] . "'";
		   }
		else
		   {
		   $lista_bloques= "'" . $rocb["bloque"] . "'" ;
		   }
		$cb++;   
		}
    
	//// NRCS DISTINTOS
	$queryn  ="SELECT distinct(nrc) ";
	$queryn .="From mdl_user_students A ";
	$queryn .="Where nrc<>'' and nrc is not null and A.course=" . $id_curso_moodle;

	$resultn = pg_query($queryn) or die('Query failed: ' . pg_last_error());

	$cnrc=0;
	$lista_nrcs="";
	while($rocn=pg_fetch_array($resultn)) 
		{
		if ($cnrc!=0)
		   {
		   $lista_nrcs=$lista_nrcs . ",'" . $rocn["nrc"] . "'";
		   }
		else
		   {
		   $lista_nrcs= "'" . $rocn["nrc"] . "'" ;
		   }
		$cnrc++;   
		}
	
		
		
//Campus distintos
	
	$querycamp  ="SELECT distinct(camp), nombre_centro, count(*) as alumnos From mdl_user_students ";
	$querycamp .="left join senati_centros on camp=id_centro ";
	$querycamp .="Where camp is not null and course=" . $id_curso_moodle;
	$querycamp .=" Group by camp,nombre_centro ";
	
	$resultcamp = pg_query($querycamp) or die('Query failed 82: ' . pg_last_error());

$camp_distintos="";
$campus_distintos="";

$cz=0;
while($roca=pg_fetch_array($resultcamp)) 
	{
	$camp=$roca["camp"];
	$campus=$roca["nombre_centro"];
	$alumnos=$roca["alumnos"];
	if($cz==0)
		{
		$camp_distintos="'". $camp . "'";
		$campus_distintos=$campus . " (". $camp . ") - Alumnos : ". $alumnos;
		}
	else
		{
		$camp_distintos .=",'" . $camp . "'";
		$campus_distintos .= "<BR>".$campus . " (". $camp . ") - Alumnos : ". $alumnos;
		}
	$cz++;
	}	

?>
<BR />

<strong style="color:blue">Consolidaci&oacute;n de Matriculas con SINFO - <a href="view.php?id=<?PHP echo $id_curso_moodle?>"><u><? echo $nombre_moodle ?></u></a></strong><BR><BR>

<?PHP
if ($mensaje!="")
	{
	echo "<p><FONT color=red>" . $mensaje . "</font></p>";
	}

if ($alus_creados!="")
   {
   echo "ALUMNOS CREADOS<BR><font color=green>". $alus_creados . "</font>";
   }
?>
<table cellpadding="3" cellspacing="1" border="1" bordercolor="gray" id="tabla_matriculas">
<tr><td align=right><strong>ID Curso Moodle</strong></td><td><?PHP echo $id_curso_moodle?></td></tr>
<tr><td align=right><strong>Nombre Curso Moodle</strong></td><td><u style="color:blue;cursor:hand;" onclick="window.navigate('view.php?id=<?PHP echo $id_curso_moodle?>')"><?PHP echo $nombre_moodle?></u></td></tr>
<tr><td align=right><strong>MATERIA-CURSO SINFO</strong></td><td><?PHP echo $materiax.'-'.$cursox.'&nbsp;&nbsp;&nbsp;&nbsp;'. $materiay.'-'.$cursoy  ?></td></tr>
<tr><td align=right><strong>PERIODO SINFO</strong></td><td><?PHP echo $periodo_curso ?></td></tr>
<tr><td align=right><strong>Fecha de Inicio</strong></td><td><?PHP echo $fecha_inicio ?></td></tr>
<tr><td align=right><strong><a href="teacher.php?id=<?PHP echo $id_curso_moodle?>"><u>Tutor(es)</u></a></strong></td>
<td>

<?PHP

$sqx='SELECT userid, firstname, lastname From mdl_user_teachers A left join mdl_user B on userid=B.id Where course=' . $id_curso_moodle ;
$profes = pg_query($sqx) or die('Query failed: ' . pg_last_error());

while($rot=pg_fetch_array($profes)) 
	{
	$proxe =$rot["firstname"]. ', '. $rot["lastname"];
    $proxe_upper=strtoupper ($proxe);
    echo $proxe_upper;
    echo '<BR>';
	}
?>


</td>
</tr>
<tr><td align=right><strong>Total Alumnos</strong></td>
<td ><font id=fon_total_alus name=fon_total_alus color=blue></font>
</td>
</tr>
<tr><td align=right><strong>Retirados de SINFO</strong></td>
<td ><font id=fon_ret_sinfo name=fon_ret_sinfo color=red></font>
</td>
</tr>
</table>
<BR>


<?PHP
$c1=0;
$todos_pidm=",";
$ret=0;
while($row=pg_fetch_array($result)) 
	{
	$pidm=$row["pidm_banner"];
	//pongo todos los pidms entre comas para que a la hora de buscarlos lo busque entre comas !!!!!!
	$todos_pidm .=$pidm . ',';
	$c1++;
	$fondox="";
    if ($row["status_sinfo"] !="")
	   {
	   $ret++;
	   }
   }

$cursos="'".$materiax . "-" . $cursox ."'";

if ($materiay!="" && $cursoy !="")
	{$curso2 ="'" . $materiay . "-" . $cursoy ."'";
	$cursos .= "," . $curso2;
	}

?>
<TABLE cellspacing=1 cellpadding=1 border=1>
<TR>
<TD colspan=2 bgcolor=silver><strong>Datos para extraer a los alumnos que no est&aacute;n matriculados ac&aacute; pero si en SINFO</strong></TD>
<TR>
<TD><strong>Campus distintos </strong></TD>
<TD><INPUT id="camp_distintos" name="camp_distintos" size=80 type=text value="<?PHP echo $camp_distintos ?>">
<BR>
<?PHP echo $campus_distintos ?>
</TD>
</TR>

<TR>
<TD><strong>PIDMS distintos </strong></TD>
<TD>
<TEXTAREA id="pidm_distintos" name="pidm_distintos" rows=5 cols=80><?PHP echo $todos_pidm ?></textarea>
</TD>
</TR>

<TR>
<TD><strong>Cursos SINFO</strong></TD>
<TD>
<INPUT id="cursos_sinfo" name="cursos_sinfo" type=text value="<?PHP echo $cursos ?>" size=100>
</TD>
</TR>

<TR>
<TD><strong>BLOQUES SINFO<BR>para matricula<BR>PASO 1 &oacute; :</strong></TD>
<TD>
<INPUT id="bloques_sinfo" name="bloques_sinfo" type=text size=100 value="<?PHP echo $lista_bloques?>"><BR>

<INPUT type=button value="Leer Alumnos en esos BLOQUES desde SINFO" style="width:295px" onClick="leer_alu_bloques();">
&nbsp;&nbsp;<font style="font-size:13px" id="fonbloques" name="fonbloques" color=red></font>
</TD>
</TR>

<TR>
<TD><strong>NRCS SINFO<BR>para matricula<BR>PASO 1 &oacute; :</strong></TD>
<TD>
<INPUT id="nrcs_sinfo" name="nrcs_sinfo" type=text size=100 value="<?PHP echo $lista_nrcs?>"><BR>

<INPUT type=button value="Leer Alumnos en esos NRCS desde SINFO" style="width:295px" onClick="leer_alu_nrcs();">
&nbsp;&nbsp;<font style="font-size:13px" id="fontnrcs" name="fontnrcs" color=red></font>
</TD>
</TR>



<TR>
<TD><strong>PIDMS SINFO<BR>para matricula<BR>PASO 1 &oacute; :</strong></TD>
<TD>
<INPUT id="pidms_sinfo" name="pidms_sinfo" type=text size=100 value=""><BR>

<INPUT type=button value="Leer Alumnos con esos PIDMS SINFO" style="width:295px" onClick="leer_alu_pidms();">
&nbsp;&nbsp;<font style="font-size:13px" id="fontpidms" name="fontpidms" color=red></font>
</TD>
</TR>


<TR>
<TD><STRONG>PASO 1</STRONG></TD>
<TD>
<INPUT type=button value="Leer Alumnos en esos CAMPUS desde SINFO" style="width:295px" onclick="leer_faltantes();">
&nbsp;&nbsp;<font style="font-size:13px" id="fonfal" name="fonfal" color=red></font>
</TD>
</TR>
<TR>
<TD><STRONG>PASO 2</STRONG></TD>
<TD>
<INPUT type=button value="Comparar Alumnos Faltantes" disabled id=bot_compara name=bot_compara style="width:195px" onclick="comparar_pidms();">
&nbsp;&nbsp;<font style="font-size:13px" id="fonfal2" name="fonfal2" color=red></font>
</TD>
</TR>
<TR>
<TD><STRONG>PASO 3</STRONG></TD>
<TD>
<INPUT type=button value="Matricular Alumnos Faltantes" disabled id=bot_matricular name=bot_matricular style="width:195px" onclick="matricular_faltantes();">
</TD>
</TR>
<TR>
<TD><STRONG>PASO 4</STRONG></TD>
<TD>
<a href="groups.php?id=<?PHP echo $id_curso_moodle ?>"><u>Ir a la p&aacute;gina de Grupos</u></a>  o  <a href="editar_matriculas.php?id=<?PHP echo $id_curso_moodle ?>"><u>Ir a Editar Matriculas</u></a>
</TD>
</TR>
</TABLE>

<form name="thisform" id="thisform" method="post">

<div id="div2">
</div>

<div id="div3">
</div>

<input type=hidden name="id_curso_moodle" id="id_curso_moodle" value="<?PHP echo $id_curso_moodle?>"/>
<input type=hidden name="periodo_curso" id="periodo_curso" value="<?PHP echo $periodo_curso?>"/>
<input type=hidden name="tx_accion" id="tx_accion" value=""/>

</form>

<?PHP
print_footer();
?>
<script language="javascript">

function obje(ide){
	var obex=document.getElementById(ide);
	return obex;
}

obje("fon_total_alus").innerText="<?PHP echo $c1 ?>";
obje("fon_ret_sinfo").innerText="<?PHP echo $ret ?>";


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

//////////// LEE PIDMS DE SINFO //////////////////////////////
function leer_alu_pidms(){
   obje("div2").innerHTML ="";
   obje("div3").innerHTML ="";
   obje("bot_compara").disabled=true;
   window.status="Procesando alumnos, espere ...";
   obje("fontpidms").innerText = "Procesando alumnos, espere ...";
	url="consolida_matriculas_pidms_proxy.php";
	var xmlo=crea_xmlhttpPost(url);
		 xmlo.onreadystatechange = function()
		  {
		   if (xmlo.readyState == 4)
			   {
			   update_matriculas_pidms(xmlo.responseText);
			   }
		  }
	var pidms=trim(obje("pidms_sinfo").value);
	var salida = pidms.replace(/ /g, ",");
	obje("pidms_sinfo").value=salida;
	var pidms=trim(obje("pidms_sinfo").value);
	
	
	qstr="pidms="+escape(pidms);
	xmlo.send(qstr);
}

function update_matriculas_pidms(str){
	//sale una tabla llamada asi : id=tabla_sinfo name=tabla_sinfo
	obje("div2").innerHTML = str;
	
	obje("fontpidms").innerText = "Listo : Ir al PASO 2.";
	window.status = "Listo.";
	obje("bot_compara").disabled=false;
}




//// DEBO LEER los PIDMS de la tabla ajax id=tabla_sinfo name=tabla_sinfo y buscar si existe en la lista de pidms
//// si es -1 poner DEBE MATRICULARSE
//// si no es -1 pongo OK
//// PIDM esta en la 3era columna en la 9 columna debo poner el estado

//// LEER BLOQUES
function leer_alu_bloques(){
   obje("div2").innerHTML ="";
   obje("div3").innerHTML ="";
   obje("bot_compara").disabled=true;
	window.status="Procesando alumnos, espere ...";
	obje("fonbloques").innerText = "Procesando alumnos, espere ...";

	url="consolida_matriculas_bloques_proxy.php";
	var xmlo=crea_xmlhttpPost(url);
		 xmlo.onreadystatechange = function()
		  {
		   if (xmlo.readyState == 4)
			   {
			   update_matriculas_bloques(xmlo.responseText);
			   }
		  }
	var periodo=trim(obje("periodo_curso").value);
	var cursos=trim(obje("cursos_sinfo").value);
	var bloques=trim(obje("bloques_sinfo").value);
	//No envio los pidms pues se cuelga, recibo todos y los comparo en el lado cliente
	//var pidms=trim(obje("pidm_distintos").value);
	//qstr="periodo="+escape(periodo) + "&cursos=" + escape(cursos) + "&camps=" + escape(camps) + "&pidms=" + escape(pidms);
	qstr="periodo="+escape(periodo) + "&cursos=" + escape(cursos) + "&bloques=" + escape(bloques);
	xmlo.send(qstr);
}

function update_matriculas_bloques(str){
	//sale una tabla llamada asi : id=tabla_sinfo name=tabla_sinfo
	obje("div2").innerHTML = str;
	
	obje("fonbloques").innerText = "Listo : Ir al PASO 2.";
	window.status = "Listo.";
	obje("bot_compara").disabled=false;
}


//////////////////////// leer NRCS
function leer_alu_nrcs(){
   obje("fontnrcs").innerHTML ="";
   obje("div2").innerHTML ="";
   obje("div3").innerHTML ="";
   obje("bot_compara").disabled=true;
	window.status="Procesando alumnos, espere ...";
	obje("fontnrcs").innerText = "Procesando alumnos, espere ...";

	url="consolida_matriculas_nrcs_proxy.php";
	var xmlo=crea_xmlhttpPost(url);
		 xmlo.onreadystatechange = function()
		  {
		   if (xmlo.readyState == 4)
			   {
			   update_matriculas_nrcs(xmlo.responseText);
			   }
		  }
	var periodo=trim(obje("periodo_curso").value);
	var cursos=trim(obje("cursos_sinfo").value);
	var nrcs=trim(obje("nrcs_sinfo").value);
	//No envio los pidms pues se cuelga, recibo todos y los comparo en el lado cliente
	//var pidms=trim(obje("pidm_distintos").value);
	//qstr="periodo="+escape(periodo) + "&cursos=" + escape(cursos) + "&camps=" + escape(camps) + "&pidms=" + escape(pidms);
	qstr="periodo="+escape(periodo) + "&cursos=" + escape(cursos) + "&nrcs=" + escape(nrcs);
	xmlo.send(qstr);
}

function update_matriculas_nrcs(str){
	//sale una tabla llamada asi : id=tabla_sinfo name=tabla_sinfo
	obje("div2").innerHTML = str;
	
	obje("fontnrcs").innerText = "Listo : Ir al PASO 2.";
	window.status = "Listo.";
	obje("bot_compara").disabled=false;
}



function comparar_pidms(){

	obje("fonfal2").innerHTML="Comparando ....";
	obje("fonfal2").innerHTML="Comparando ....";
	obje("fonfal2").innerHTML="Comparando ....";
	obje("fonfal2").innerHTML="Comparando ....";
	obje("fonfal2").innerHTML="Comparando ....";
	
    //aca realizo la iteracion de la tabla_sinfo
	objtabla_sinfo=document.getElementById("tabla_sinfo");
	var cole_rows=objtabla_sinfo.rows;
	total_rows=cole_rows.length;
	
	// se debe ir de 0 a total_rows-1
	//rows[0].cells
	//tableObject.cells
	//itero rows
	// Hay nueve cells el PIDM es [2]  el Proceso es el [8]
	//var pidm_distintos=obje("pidm_distintos").innerText;
	var pidm_distintos=obje("pidm_distintos").value;
	var faltantes=0;
	var array_tr_id_borrar = new Array();
	var trb=-1;
	
	for (ir=1;ir<total_rows;ir++)
		{
		var cole_cells=objtabla_sinfo.rows[ir].cells;
		var pidm_sinfo=trim(cole_cells[2].innerText);
		var posix = pidm_distintos.indexOf(","+pidm_sinfo+",");
		if (posix==-1)
		   {
		   faltantes++;
		   var celda=cole_cells[8];
		   //cole_cells[8].style.color="red";
		   //cole_cells[8].innerText="FALTANTE";
		   celda.style.color="red";
		   celda.innerHTML="FALTANTE&nbsp;";
		   //aca debo crear los inputs : cole_cells[8]
		   //EL NOMBRE
		   var input=document.createElement('input');
		   input.type='hidden';
		   input.value=cole_cells[3].innerText;
		   input.name='inp_ape_nombres[]';
		   celda.appendChild(input);
		   //EL SV_ID
		   var input=document.createElement('input');
		   input.type='hidden';
		   input.value=cole_cells[1].innerText;
		   input.name='inp_sv_id[]';
		   celda.appendChild(input);
   		   //EL PIDM
		   var input=document.createElement('input');
		   input.type='hidden';
		   input.value=pidm_sinfo;
		   input.name='inp_pidm[]';
		   celda.appendChild(input);
		   //EL CAMP
		   var input=document.createElement('input');
		   input.type='hidden';
		   input.value=cole_cells[4].innerText;
		   input.name='inp_camp[]';
		   celda.appendChild(input);
		   //EL NRC
		   var input=document.createElement('input');
		   input.type='hidden';
		   input.value=cole_cells[6].innerText;
		   input.name='inp_nrc[]';
		   celda.appendChild(input);
		   //EL BLOQUE
		   var input=document.createElement('input');
		   input.type='hidden';
		   input.value=cole_cells[7].innerText;
		   input.name='inp_bloque[]';
		   celda.appendChild(input);
           }
		else
		   {
		   trb++;
		   //digo que ese TR debe borrarse
		   array_tr_id_borrar[trb]=objtabla_sinfo.rows[ir].id;
           }
		}
	//BORRAR TRs
	//el asp me devuelve los TR con ID de esa manera puedo borrarlos
    //<TR id='rowy_" & ct & "'> ej <tr id="rowy_135">
	for (ix=0;ix<trb+1;ix++)
	    {
		var id_tr=array_tr_id_borrar[ix];
		var row_borrar = obje(id_tr);
		row_borrar.parentNode.removeChild(row_borrar);
		}
	obje("div3").innerHTML ="<strong style='color:red'>Alumnos FALTANTES : " + faltantes + "</strong>";
	obje("fonfal2").innerText = "Listo.";
	if (faltantes==0)
	   {objtabla_sinfo.style.display="none";}
	else
	   {obje("bot_matricular").disabled=false;}
	
}
//ESTAS FUNCIONES ESTAN SOLO PARA SINTAXIS
function delete1(){	
	var row = document.getElementById('row1');
	row.parentNode.removeChild(row);
}
function remove(objeto_td)
    {
        var tr = objeto_td.parentNode;
        var table = tr.parentNode;
        table.removeChild(tr);
    }
//FIN ESTAS FUNCIONES ESTAN SOLO PARA SINTAXIS

function matricular_faltantes(){
	obje("tx_accion").value="salvar";
	obje("thisform").submit();
}

function leer_faltantes(){
   obje("div2").innerHTML ="";
   obje("div3").innerHTML ="";
   obje("bot_compara").disabled=true;
	window.status="Procesando alumnos, espere ...";
	obje("fonfal").innerText = "Procesando alumnos, espere ...";

	url="consolida_matriculas_faltantes_proxy.php";
	var xmlo=crea_xmlhttpPost(url);
		 xmlo.onreadystatechange = function()
		  {
		   if (xmlo.readyState == 4)
			   {
			   update_matriculas_faltantes(xmlo.responseText);
			   }
		  }
	var periodo=trim(obje("periodo_curso").value);
	var cursos=trim(obje("cursos_sinfo").value);
	var camps=trim(obje("camp_distintos").value);
	//No envio los pidms pues se cuelga, recibo todos y los comparo en el lado cliente
	//var pidms=trim(obje("pidm_distintos").value);
	//qstr="periodo="+escape(periodo) + "&cursos=" + escape(cursos) + "&camps=" + escape(camps) + "&pidms=" + escape(pidms);
	qstr="periodo="+escape(periodo) + "&cursos=" + escape(cursos) + "&camps=" + escape(camps);
	xmlo.send(qstr);
}

function update_matriculas_faltantes(str){

	//sale una tabla llamada asi : id=tabla_sinfo name=tabla_sinfo
	obje("div2").innerHTML = str;
	
	obje("fonfal").innerText = "Listo.";
	window.status = "Listo.";
	obje("bot_compara").disabled=false;
}

function comillas() {
	//no acepta comillas simples ni dobles
	wek=window.event.keyCode;
	if (wek==39 || wek==34) {window.event.keyCode=0;}
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