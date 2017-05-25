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
	$id_curso_actual=0;
	
    $mensaje="";	
	//////////////
    if ($accion=="salvar")
		{
		
		  $visiblex=$_POST["sel_visible"];
		  $periocolo=$_POST["tx_periodo"];
		  
		  $camp_presencial=trim($_POST["tx_camp_pres"]);
		  
		  if ($camp_presencial=="")
			 {$camp_presencial="NULL";}
		  else	 
 			 {$camp_presencial="'".$camp_presencial ."'";}
			 
  		  $patron_semilla=trim($_POST["tx_id_patron_semilla"]);
  		  if ($patron_semilla=="")
			 {$patron_semilla="NULL";}
		  
		  // Tambien la materia curso de SINFO
		  
		  $tx_materia_sinfo=trim($_POST["tx_materia_sinfo"]);
		  $tx_curso_sinfo=trim($_POST["tx_curso_sinfo"]);
		  
		  if ($tx_materia_sinfo=="")
			 {$tx_materia_sinfo="NULL";}
		  else	 
 			 {$tx_materia_sinfo="'".$tx_materia_sinfo ."'";}
			 
		 if ($tx_curso_sinfo=="")
			 {$tx_curso_sinfo="NULL";}
		  else	 
 			 {$tx_curso_sinfo="'".$tx_curso_sinfo ."'";}	 
		  
		  $tx_id_tarea_induccion=trim($_POST["tx_id_tarea_induccion"]);
		  
		  if ($tx_id_tarea_induccion=="")
			 {$tx_id_tarea_induccion="NULL";}
			 
		  $fuente=trim($_POST["tx_font_certi"]);
		  
		  if ($fuente=="" || $fuente=="0")
		     {$fuente="16";}
		  
          $header=trim($_POST["sel_header"]);
		  
		  $nome_curso=trim($_POST["tx_nombre_curso"]);
		  $nombre_corto=trim($_POST["tx_nombre_corto"]);
		  
		  $titulo_certi=trim($_POST["tx_titulo_certi"]);
		  
		  if ($titulo_certi=="")
		  {
		  $query0 = "UPDATE mdl_course set curso_sinfo=". $tx_curso_sinfo .", materia_sinfo=". $tx_materia_sinfo. ",fullname ='". $nome_curso ."', visible=". $visiblex ." , periodo='". $periocolo ."', camp_pres=". $camp_presencial .",id_patron_semilla=". $patron_semilla .", id_tarea_induccion=". $tx_id_tarea_induccion .", font_titulo_certi=". $fuente .", header_certi='". $header ."', shortname='". $nombre_corto . "' where id=" . $id_curso_moodle;
		  }
		  else
		  {
		  $query0 = "UPDATE mdl_course set titulo_certificado='". $titulo_certi . "', curso_sinfo=". $tx_curso_sinfo .", materia_sinfo=". $tx_materia_sinfo. ",fullname ='". $nome_curso ."', visible=". $visiblex ." , periodo='". $periocolo ."', camp_pres=". $camp_presencial .",id_patron_semilla=". $patron_semilla .", id_tarea_induccion=". $tx_id_tarea_induccion .", font_titulo_certi=". $fuente .", header_certi='". $header ."', shortname='". $nombre_corto . "' where id=" . $id_curso_moodle;
		  }
		  $result0 = pg_query($query0) or die('Query failed 56: ' . pg_last_error());
		  $row0=pg_fetch_array($result0); 
		  
		  
		  //GUARDO EL PERIODO
		  //$periocolo=$_POST["tx_periodo"];
		  //$query00 = "UPDATE mdl_course set periodo='". $periocolo ."' where id=" . $id_curso_moodle;
		  //$result00 = pg_query($query00) or die('Query failed 27: ' . pg_last_error());
		  //$row00=pg_fetch_array($result00); 
			
          //////// AVERIGUO SI EXISTE LA RELACION		
		  $query0 = 'SELECT count(*) as total FROM senati_rela_cursos_cursos  where id_course_moodle=' . $id_curso_moodle;
		  $result0 = pg_query($query0) or die('Query failed 32: ' . pg_last_error());
		  
		  $row0=pg_fetch_array($result0); 
		  $total_registros=$row0["total"];
		  $valor_id_cs=$_POST["sel_relacion"];
			if ($total_registros==0)
					{//SE HACE UN INSERT
					    if($valor_id_cs!="")
						{
						$qinsert='INSERT INTO senati_rela_cursos_cursos (id_curso_senati,id_course_moodle) VALUES ('. $valor_id_cs . ',' . $id_curso_moodle . ' )'; 
						$rex = pg_query($qinsert);
						$mensaje="Se insert&oacute; un registro.";
						}
					}
			else
				  {
					if($valor_id_cs!="")
					  {
					  $qupdate="Update senati_rela_cursos_cursos  set id_curso_senati=". $valor_id_cs . " where id_course_moodle=". $id_curso_moodle; 
					  $rey = pg_query($qupdate);
					  $mensaje="Se actualiz&oacute; un registro.";
					  }
					else
					  {
					  //ACA TENGO QUE HACER UN DELETE
					  $q_delete="delete from senati_rela_cursos_cursos where id_course_moodle=". $id_curso_moodle;
					  $rey = pg_query($q_delete);
					  $mensaje="Se elimin&oacute; un registro.";
					  }
				  }
				  
        //// ACA ACTUALIZO LOS DATOS DE PRESENCIAL, SUBSANACION, INDUCCION, PUBLICO y GRUPO

		$publicox=trim($_POST["sel_publico"]);
		$presex=trim($_POST["sel_pres"]);
		$indux=trim($_POST["sel_induccion"]);
		$subsax=trim($_POST["sel_subsa"]);
		$grupox=trim($_POST["sel_grupo"]);
		$patronx=trim($_POST["sel_patron"]);

        $presencial_de_post=trim($_POST["tx_presencial_de"]);
		$subsanacion_de_post=trim($_POST["tx_subsanacion_de"]);

		
		
		if ($presencial_de_post=="")
		   {$presencial_de_post="NULL";}

		if ($subsanacion_de_post=="")
		   {$subsanacion_de_post="NULL";}
		
		if ($grupox=="")
		   {$grupox="NULL";}
	    else		   
	       {$grupox="'". $grupox ."'";}
		
		if ($publicox=="")
		   {$publicox="NULL";}

	    if ($presex=="")
		   {$presex="NULL";}
	    else		   
	       {$presex="'". $presex ."'";}
		   
	    if ($indux=="")
		   {$indux="NULL";}
	    else		   
	       {$indux="'". $indux ."'";}

	    if ($subsax=="")
		   {$subsax="NULL";}
	    else
	       {$subsax="'". $subsax ."'";}
		
		if ($patronx=="s")
		   {$patronx="'s'";}
		else
		   {$patronx="NULL";}		
		
		
		$qupia  ="Update mdl_course set patron=". $patronx .", id_publico=". $publicox. ", presencial=". $presex. ", subsanacion=" . $subsax . ", ";
		$qupia .="induccion=". $indux. ",grupo=". $grupox  .", subsanacion_de=". $subsanacion_de_post . ", presencial_de=". $presencial_de_post ." where id=". $id_curso_moodle;
		
		$rupia = pg_query($qupia) or die('Query failed 101: ' . pg_last_error());
	    $rowpia=pg_fetch_array($rupia);
		}
	   
	//EL NOMBRE DEL CURSO	
	$nombre_moodle=$_POST["nombre_moodle"];
	
	//if ($nombre_moodle=="")
		//{
		$query0  = "Select fullname, shortname, visible, id_patron_semilla, periodo,induccion, subsanacion, presencial, id_publico,grupo, presencial_de, subsanacion_de, patron, camp_pres,materia_sinfo, curso_sinfo, id_tarea_induccion, font_titulo_certi,header_certi, titulo_certificado from mdl_course where id=". $id_curso_moodle;
		$result0 = pg_query($query0) or die('Query failed 127: ' . pg_last_error());
		$roxy=pg_fetch_array($result0); 
		$nombre_moodle=$roxy["fullname"];
		$periodox=$roxy["periodo"];
		$es_patron=$roxy["patron"];	   
		$es_visible=$roxy["visible"];
		$camp_pres=$roxy["camp_pres"];
		$id_patron_semilla=$roxy["id_patron_semilla"];
		$id_tarea_induccion=$roxy["id_tarea_induccion"];
		$font_titulo_certi=$roxy["font_titulo_certi"];
		$header_certi=$roxy["header_certi"];
		$shortname=$roxy["shortname"];
		$titulo_certi=$roxy["titulo_certificado"];
		
		$materia_sinfox=$roxy["materia_sinfo"];
		$curso_sinfox=$roxy["curso_sinfo"];
		
		$induccionx=trim($roxy["induccion"]);
		$subsanacionx=trim($roxy["subsanacion"]);
		$presencialx=trim($roxy["presencial"]);
		$id_publicox=trim($roxy["id_publico"]);
		
		$subsanacion_de=trim($roxy["subsanacion_de"]);
		$presencial_de=trim($roxy["presencial_de"]);
		
		$grupo_curso=trim($roxy["grupo"]);
		
		
		// leo el campus presencial si existe
		$nombre_camp_presencial="";
		if ($camp_pres !="")
			{
			$query_camp  = "Select nombre_centro from senati_centros where id_centro='". $camp_pres ."'";
			$result_camp = pg_query($query_camp) or die('Query failed 166: ' . pg_last_error());
			$roxca=pg_fetch_array($result_camp); 
			$nombre_camp_presencial=$roxca["nombre_centro"];
			}


		$nombre_curso_semilla="";
		if ($id_patron_semilla !="")
			{
			$query_semilla = "Select fullname from mdl_course where id=". $id_patron_semilla ;
			$result_semilla = pg_query($query_semilla) or die('Query failed 180: ' . pg_last_error());
			$roxse=pg_fetch_array($result_semilla);
			$nombre_curso_semilla=$roxse["fullname"];
			}
	//}

	//$query = "Select A.*, B.firstname, B.lastname from mdl_chat A left join mdl_user B on B.id=A.id_tutor where course=" . $id_curso_moodle . " order by A.id asc";
	//$result =pg_query($query) or die('Query failed: ' . pg_last_error());

// Printing results in HTML

	$nombre_induccion="";
	if ($id_tarea_induccion !="")
	{
		$sqlinduccion = 'Select name from mdl_assignment where id=' . $id_tarea_induccion;
		$rsqlinduccion = pg_query($sqlinduccion) or die('Query failed 219: ' . pg_last_error());
		$rowq=pg_fetch_array($rsqlinduccion);
		$nombre_induccion="TAREA : <font color=blue><em>". $rowq["name"] . "</em></font>";
	}
	
	



	$titulo_pagina1 = "Datos Generales del Curso";
	print_header("$site->shortname : ". $titulo_pagina1, "X1", $titulo_pagina1, "", "", true, "");

/// SI EXISTE UNA RELACION LA MUESTRA
	$sql1 = 'Select * from senati_rela_cursos_cursos inner join senati_cursos on id_curso_senati=id_curso where id_course_moodle=' . $id_curso_moodle;
    $rsql1 = pg_query($sql1) or die('Query failed: ' . pg_last_error());
    $row1=pg_fetch_array($rsql1);
	$id_curso_actual=1*$row1["id_curso_senati"];
	$nombre_curso_actual=$row1["nombre_curso"];

	if ($nombre_curso_actual !="")
	   {
	   $mostrar_curso=$nombre_curso_actual;
	   }
	   else
	   {
	   $mostrar_curso="NO TIENE";
	   }	


	   
//LISTA DE CURSOS SENATI

$sql_cursos = " Select id_curso, nombre_curso from senati_cursos order by 2";
$rs_cursos = pg_query($sql_cursos) or die('Query failed: ' . pg_last_error());
$total_cursos=0;
?>

<strong style="color:blue"><a href="view.php?id=<?PHP echo $id_curso_moodle?>"><u><? echo $nombre_moodle ?></u></a> - Datos Generales del Curso</strong><BR><BR>

<form name="thisform" id="thisform" method="post">

<font style="font-size:14px" id=fones color=red><?PHP echo $mensaje?></font>

<TABLE cellspacing=2 cellpadding=2 border=1>

<TR>
<TD>&nbsp;</TD>
<TD bgcolor=silver><strong>DATOS DEL CURSO</strong></TD>
</TR>


<TR>
<TD align=right><strong>Curso Visible&nbsp;</strong></TD>
<TD>
<SELECT name="sel_visible" id="sel_visible">
<?PHP
if ($es_visible=="1")
	{
	$v1="selected";
	$v2="";
	}
else
	{
	$v2="selected";
	$v1="";
	}	
?>
<OPTION <?PHP echo $v1 ?> value="1">SI</OPTION> 
<OPTION <?PHP echo $v2 ?> value="0">NO</OPTION> 
</select>
</TD>
<TR>






<TR>
<TD align=right><strong>Nombre del Curso&nbsp;</strong></TD>
<TD>
<INPUT type=text name="tx_nombre_curso" id="tx_nombre_curso" onKeypress="comillas();" size=120 maxlength=200 value="<?PHP echo $nombre_moodle?>">
</TD>
</TR>

<TR>
<TD align=right><strong>Nombre Corto&nbsp;</strong></TD>
<TD>
<input type="text" name="tx_nombre_corto" id="tx_nombre_corto" maxlength="40" onKeypress="comillas();" size="20" value="<?PHP echo $shortname ?>" />
</TD>
</TR>

<TR>
<TD align=right><strong>Relacionar con curso SENATI&nbsp;</strong></TD>
<TD>

<SELECT name="sel_relacion" id="sel_relacion">
<OPTION value=''>NO ESPECIFICADO</OPTION>
<?PHP 
while($roy=pg_fetch_array($rs_cursos)) 
	{
	if ($id_curso_actual+1-1==$roy["id_curso"]+1-1)
	    {$sela="selected";}
	else
	    {$sela="";}

	echo "<OPTION ". $sela .  " value='" . $roy["id_curso"] . "'>" . $roy["nombre_curso"] . "</OPTION>\n";
	}	
?>
</SELECT><BR>
Relaci&oacute;n Actual : <font color=blue><?PHP echo $mostrar_curso ?></font>
</TD>

<TR>
<TD align=right><strong>Materia - Curso SINFO&nbsp;</strong></TD>
<TD>
<INPUT type=text name="tx_materia_sinfo" id="tx_materia_sinfo" size=5 maxlength=5 value="<?PHP echo $materia_sinfox?>">
<INPUT type=text name="tx_curso_sinfo" id="tx_curso_sinfo" size=5 maxlength=5 value="<?PHP echo $curso_sinfox?>">
</TD>
</TR>


<TR>
<TD align=right><strong>Periodo&nbsp; 	</strong></TD>
<TD>
<INPUT type=text name="tx_periodo" id="tx_periodo" size=8 maxlength=8 value="<?PHP echo $periodox?>">
</TD>
</TR>

<TR>
<TD align=right><strong>¿ Es Subsanaci&oacute;n ?&nbsp; 	</strong></TD>
<TD>
<?PHP
if ($subsanacionx=="s")
   {$sela1="selected";
    $sela2="";
   }
else
   {$sela2="selected";
    $sela1="";
   }
?>


<SELECT id="sel_subsa" name="sel_subsa">
<OPTION <?PHP echo $sela1 ?> value="s">SI</OPTION>
<OPTION <?PHP echo $sela2 ?>  value="n">NO</OPTION>
</SELECT>
&nbsp;<strong>Id del Curso al cual Subsana</strong>&nbsp; 
<INPUT type=text onKeypress="numeros();" size=5 maxlength=5 name="tx_subsanacion_de" id="tx_subsanacion_de" value="<?PHP echo $subsanacion_de ?>">
&nbsp;<strong>(o Curso con el cual Fusionar)</strong>
</TD>
</TR>

<TD align=right><strong>¿ Es Inducci&oacute;n ?&nbsp;</strong></TD>
<TD>
<?PHP

if ($induccionx=="s")
   {$sela1="selected";
    $sela2="";
   }
else
   {$sela2="selected";
    $sela1="";
   }
?>

<SELECT id="sel_induccion" name="sel_induccion">
<OPTION <?PHP echo $sela1 ?> value="s">SI</OPTION>
<OPTION <?PHP echo $sela2 ?> value="n">NO</OPTION>
</SELECT>
</TD>
</TR>

<TR>
<TD align=right><strong>¿ Es Presencial ?&nbsp; 	</strong></TD>
<TD>
<?PHP
	

if ($presencialx=="s")
   {$sela1="selected";
    $sela2="";
   }
else
   {$sela2="selected";
    $sela1="";
   }
?>

<SELECT id="sel_pres" name="sel_pres">
<OPTION <?PHP echo $sela1 ?> value="s">SI</OPTION>
<OPTION <?PHP echo $sela2 ?> value="n">NO</OPTION>
</SELECT>
&nbsp; <strong>Id del Curso Padre</strong>&nbsp;
<INPUT type=text onKeypress="numeros();" size=5 maxlength=5 name="tx_presencial_de" id="tx_presencial_de" value="<?PHP echo $presencial_de ?>"> 

&nbsp; <strong>Camp Presencial</strong>&nbsp;
<INPUT type=text onKeypress="numeros();" size=4 maxlength=3 name="tx_camp_pres" id="tx_camp_pres" value="<?PHP echo $camp_pres ?>"> 
<?PHP echo "&nbsp;<font color=blue><em>". $nombre_camp_presencial . "</em></font>" ?>
</TD>
</TR>

<TR>
<TD align=right><strong>¿ Es un Curso Patr&oacute;n ?&nbsp;</strong></TD>
<TD>
<?PHP
$sela_si="";
$sela_no="selected";

if ($es_patron=="s")
	{$sela_si="selected";
	 $sela_no="";
	}


?>
<SELECT id="sel_patron" name="sel_patron">
<OPTION <?PHP echo $sela_si ?> value="s">SI</OPTION>
<OPTION <?PHP echo $sela_no ?> value="">NO</OPTION>
</SELECT>
</TD>
</TR>


<TR>
<TD align=right><strong>ID Tarea de Inducci&oacute;n&nbsp;</strong></TD>
<TD>
<INPUT type=text onKeypress="numeros();" size=5 maxlength=5 name="tx_id_tarea_induccion" id="tx_id_tarea_induccion" value="<?PHP echo $id_tarea_induccion ?>">&nbsp;<?PHP echo $nombre_induccion ?>
</TD>
</TR>
<TR>
<TD align=right><strong>P&uacute;blico (dirigido a)&nbsp; 	</strong></TD>
<TD>
<?PHP
$sela0="";
$sela1="";
$sela2="";
$sela3="";
$sela4="";
$sela5="";
$sela6="";

if ($id_publicox=="")
	{$sela0="selected";}
	
if ($id_publicox=="1")
	{$sela1="selected";}	

if ($id_publicox=="2")
	{$sela2="selected";}

if ($id_publicox=="3")
	{$sela3="selected";}
	
if ($id_publicox=="4")
	{$sela4="selected";}
	
if ($id_publicox=="5")
	{$sela5="selected";}
	
if ($id_publicox=="6")
	{$sela6="selected";}			
?>
<SELECT id="sel_publico" name="sel_publico">
<OPTION <?PHP echo $sela0 ?> value="">NO ESPECIFICADO</OPTION>
<OPTION <?PHP echo $sela1 ?> value="1">Exalumno</OPTION>
<OPTION <?PHP echo $sela2 ?> value="2">Trabajadores Empresas Aportantes</OPTION>
<OPTION <?PHP echo $sela3 ?> value="3">Alumnos SENATI</OPTION>
<OPTION <?PHP echo $sela4 ?> value="4">Publico en General</OPTION>
<OPTION <?PHP echo $sela5 ?> value="5">Trabajador del SENATI</OPTION>
<OPTION <?PHP echo $sela6 ?> value="6">Equipo de SENATI VIRTUAL</OPTION>
</SELECT>
</TD>
</TR>
<TR>
<TD align=right><strong>Grupo&nbsp;</strong></TD>
<TD>
<?PHP
$sela0="";
$sela1="";
$sela2="";
$sela3="";

if ($grupo_curso=="")
	{$sela0="selected";}
	
if ($grupo_curso=="A")
	{$sela1="selected";}	

if ($grupo_curso=="B")
	{$sela2="selected";}

if ($grupo_curso=="C")
	{$sela3="selected";}

if($header_certi=="s")
	{
	$headsi="selected";
	$headno="";
	}
else
	{
	$headno="selected";
	$headsi="";
	}
	
?>
<SELECT id="sel_grupo" name="sel_grupo">
<OPTION <?PHP echo $sela0 ?> value="">NO ESPECIFICADO</OPTION>
<OPTION <?PHP echo $sela1 ?> value="A">A</OPTION>
<OPTION <?PHP echo $sela2 ?> value="B">B</OPTION>
<OPTION <?PHP echo $sela3 ?> value="C">C</OPTION>
</SELECT>
</TD>
</TR>
<TR>
<TD align=right><strong>Id del Patr&oacute;n Semilla&nbsp;</strong></TD>
<TD>
<INPUT type=text onKeypress="numeros();" size=5 maxlength=5 name="tx_id_patron_semilla" id="tx_id_patron_semilla" value="<?PHP echo $id_patron_semilla ?>"> 
<?PHP echo "&nbsp;<font color=blue><em>". $nombre_curso_semilla . "</em></font>" ?>
</TD>
</TR>

<TR>
<TD>&nbsp;</TD>
<TD bgcolor=silver><strong>CERTIFICADO</strong></TD>
</TR>
<TR>
<TD align=right><strong>Titulo</strong></TD>
<TD>
<INPUT type=text onKeypress="comillas();" size=100 maxlength=100 name="tx_titulo_certi" id="tx_titulo_certi" value="<?PHP echo $titulo_certi ?>"> 
</TD>
</TR>

<TR>
<TD align=right><strong>Tama&ntilde;o de Fuente&nbsp;</strong></TD>
<TD>
<INPUT type=text onKeypress="numeros();" size=5 maxlength=5 name="tx_font_certi" id="tx_font_certi" value="<?PHP echo $font_titulo_certi ?>"> 
&nbsp;<font color=blue><em>&nbsp;Para el T&iacute;tulo del Certificado (el estandar es 16)</em></font>
</TD>
</TR>

<TR>
<TD align=right><strong>Header Certificado&nbsp;</strong></TD>
<TD>

<SELECT id="sel_header" name="sel_header">
<OPTION <?PHP echo $headsi ?> value="s">SI</OPTION>
<OPTION <?PHP echo $headno ?> value="n">NO</OPTION>
</SELECT>
&nbsp;<font color=blue><em>&nbsp;Certificado con Header o No</em></font>
</TD>
</TR>


</TABLE>
<BR>

<BR />
<input type="button" value="Salvar" onclick="salvar();" />&nbsp;&nbsp;<input type="button" value="Cancelar" onclick="cancelar();" />&nbsp;&nbsp;
<BR />
<BR />

<input type=hidden name="id_curso_moodle" id="id_curso_moodle" value="<?PHP echo $id_curso_moodle?>"/>
<input type=hidden name="nombre_moodle" id="nombre_moodle" value="<?PHP echo $nombre_moodle?>"/>
<input type=hidden name="txh_accion" id="txh_accion" value=""/>

<a href="http://virtual.senati.edu.pe/grade/pondera01.php?id=<?PHP echo $id_curso_moodle?>"><u>Ir a Ponderaciones</u></a>

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
