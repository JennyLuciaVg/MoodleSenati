<?PHP

require_once("../config.php");
require_once("lib.php");

$site = get_site();

$ano_actual=date("Y");
$mes_actual=date("n");
$dia_actual=date("j");

$id_curso=$_GET["id"];
	
if ($id_curso=="")
   {$id_curso=$_POST["tx_id_curso"];}


$titulo_pagina1 = "Registro de Incidencias";
print_header("$site->shortname : ". $titulo_pagina1, "X1", $titulo_pagina1, "", "", true, "");

$id_usuario=$USER->id;
$id_incidencia=$_POST["tx_id_incidencia"];

if ($id_incidencia=="")
    {$modo="NUEVA";}
else
    {$modo="EDICION";}

$mensaje="";

/////////////DATOS LUEGO DE SALVAR ///////////////
$id_alumno_leido="";
$incidencia_leida="";
$fecha_leida="";
/////////////FIN DATOS LUEGO DE SALVAR ///////////////
if(isteacher($course->id) || isadmin())
	{
	////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    $accion=$_POST["txh_accion"];
	if ($accion=="salvar")	
		{
		///////////////// SALVO LA INCIDENCIA ///////////////////////////////////
		$id_cursox=$_POST["tx_id_curso"];
		$id_tutorx=$_POST["tx_id_tutor"];
		$id_alumnox=$_POST["sel_alumno"];
		$incidencia=$_POST["txarea_incidencia"];
		
		if ($id_incidencia=="") 
		    {
			///INSERTO
			$query_insert  ="insert into senati_reg_incidencias (id_tutor,id_alu,id_curso,incidencia) VALUES(";
			$query_insert .=$id_tutorx. ",". $id_alumnox . "," . $id_cursox . ",'".$incidencia . "')";
		
			$result_query = pg_query($query_insert) or die('Query failed 48: ' . pg_last_error());
			$ejecuta=pg_fetch_array($result_query);
			
			/// RECUPERO EL NUMERO DE INCIDENCIA

			$query21  = "Select max(id_inc) as idx from senati_reg_incidencias where id_tutor=". $id_tutorx ." and id_alu=". $id_alumnox ." and id_curso=". $id_cursox;
			$result21 = pg_query($query21) or die('Query failed 54: ' . pg_last_error());
			$row21 = pg_fetch_array($result21);

			$id_incidencia=$row21["idx"];
			$modo="EDICION";
			$mensaje="Se registr&oacute; con &eacute;xito la incidencia.";
			}
		else
            {
			/// EDICION
			
			$query_update  = "Update senati_reg_incidencias set id_tutor=". $id_tutorx .", id_alu=". $id_alumnox .", id_curso=". $id_cursox . ",incidencia='".$incidencia . "' where id_inc=". $id_incidencia;
			$result_update = pg_query($query_update) or die('Query failed 73: ' . pg_last_error());
			$ejecuta = pg_fetch_array($result_update);
			
			$modo="EDICION";
			$mensaje="Se edit&oacute; con &eacute;xito la incidencia.";
			
			
            }
		///// COMO HE SALVADO LA INCIDENCIA DEBO LEERLA PARA EDITARLA !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
		//QUEDA EL AUTOR Y EL CURSO SOLO CAMBIA EL ALUMNO Y EL COTENIDO	
		$query_leer = "Select * from senati_reg_incidencias where id_inc=". $id_incidencia;
		$result_leer = pg_query($query_leer) or die('Query failed 75: ' . pg_last_error());
		$row31 = pg_fetch_array($result_leer);
		
		$id_alumno_leido=$row31["id_alu"];
		$incidencia_leida=$row31["incidencia"];
		$fecha_leida=$row31["fecha"];
		
		
		
		
			
		//// FIN DE SALVAR INCIDENCIA	
		}
	
		$nombre_moodle=$_POST["nombre_moodle"];
		
		if ($nombre_moodle=="")
		   {
			$query0  = "Select fullname from mdl_course where id=". $id_curso;
			$result0 = pg_query($query0) or die('Query failed 29: ' . pg_last_error());
			$roxy=pg_fetch_array($result0); 
			$nombre_moodle=$roxy["fullname"];
		   }
		   
		$query1  = "Select firstname, lastname from mdl_user where id=". $id_usuario;
		$result1 = pg_query($query1) or die('Query failed 29: ' . pg_last_error());
		$roza=pg_fetch_array($result1); 
		$lastname=$roza["firstname"];
		$firstname=$roza["lastname"];
		
		$nombre_usuario=$firstname . ", ". $lastname


////// ES NUEVA O ES PARA EDITAR
		   
?>

<STRONG><a href='view.php?id=<?PHP echo $id_curso?>'><u style="color:blue"><?PHP echo $nombre_moodle?></u></a> - &gt; Registro de Incidencias - &gt; <?PHP echo $modo ?></STRONG>

<form name=thisform id=thisform method=post>

<?PHP
if ($mensaje!="")
   {echo  "<strong><font color=red>". $mensaje . "</font></strong><BR>";}
?>

<BR><BR>
<table cellpadding=2 cellspacing=2 border=1 bordercolor=silver>
<TR>
<TD align=right><strong>ID INCIDENCIA</strong></TD>
<TD>
<?PHP 
if($id_incidencia=="")
   {echo "<strong style='color:blue'>NUEVA</strong>";}
else   
   {echo $id_incidencia;}	
 ?>

</TD>
</TR>



<TR>
<TD align=right><strong>ID CURSO</strong></TD>
<TD><?PHP echo $id_curso ?></TD>
</TR>

<TR>
<TD align=right><strong>CURSO</strong></TD><TD><?PHP echo $nombre_moodle?></TD>
</TR>

<TR>
<TD align=right><strong>TUTOR/USUARIO</strong></TD>
<TD><?PHP echo $nombre_usuario?></TD>
</TR>



<TR>
<TD align=right><strong>ALUMNO</strong></TD>
<TD>
<?PHP
/// Lista de Alumnos
    $alumno_actual="";
	$sql1  ="Select userid, firstname, lastname, email, pidm_banner from mdl_user_students A ";
	$sql1 .="inner join mdl_user B on B.id=A.userid where A.course=". $id_curso ." and deleted=0 order by lastname";
	$res1=pg_query($sql1) or die('Query failed 77: ' . pg_last_error());
		
	echo "<SELECT name=sel_alumno id=sel_alumno>";
		while($roca=pg_fetch_array($res1))
			{
			$ct++;
			$id_alu=$roca["userid"];
			$apellidos=$roca["lastname"];
			$nombres=$roca["firstname"];
			$email=$roca["email"];
			$pidm=$roca["pidm_banner"];
			
			if ($id_alumno_leido==$id_alu)
				{$sela="selected";
				 $alumno_actual="<BR>". $apellidos . ", ".  $nombres . " - ".  $email . " (ID SINFO: ". $pidm . ")";
				}
			else
				{$sela="";}			
			
			echo "<OPTION ". $sela ." value='". $id_alu . "'>" . $apellidos . ", ".  $nombres . " - ".  $email . " (ID SINFO: ". $pidm . ")</OPTION>";
			}
	
	echo "</SELECT>";
	echo $alumno_actual;
	

if ($fecha_leida!="")
	{
	 $fecha_poner=$fecha_leida;
	 $fecha_title="FECHA DE REGISTRO";
	}
else
	{
	 $fecha_poner=$dia_actual.'-'. $mes_actual. '-' . $ano_actual .  " (D/M/A)";
	 $fecha_title="FECHA ACTUAL";
	}

?>
</TD>
</TR>
<TR>
<TD align=right><strong>INCIDENCIA</strong></TD>
<TD>
<TEXTAREA id="txarea_incidencia" name="txarea_incidencia" cols=80 rows=10 OnKeyPress="return comillas();"><?PHP echo $incidencia_leida ?></TEXTAREA>
</TD>
</TR>
<TR>
<TD align=right><strong><?PHP echo $fecha_title ?></strong></TD>
<TD>
<?PHP

if ($fecha_leida!="")
   {echo $fecha_leida;}
else
   {echo  $dia_actual.'-'. $mes_actual. '-' . $ano_actual .  " (D/M/A)&nbsp;";}
?>
   
</TD>
</TR>

<TR>
<TD>&nbsp;</TD>
<TD align=center><INPUT type=button onClick="enviar_incidencia();" value="ENVIAR"></TD>
</TR>

</TABLE>

<input type=hidden name="tx_id_incidencia" id="tx_id_incidencia" value="<?PHP echo $id_incidencia?>"/>
<input type=hidden name="tx_id_curso" id="tx_id_curso" value="<?PHP echo $id_curso?>"/>
<input type=hidden name="tx_id_tutor" id="tx_id_tutor" value="<?PHP echo $id_usuario?>"/>

<input type=hidden name="nombre_moodle" id="nombre_moodle" value="<?PHP echo $nombre_moodle?>"/>
<input type=hidden name="txh_accion" id="txh_accion" value=""/>
</form>

<?PHP		
	////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	
// Mostrar las incidencias del CURSO


$qsel ="Select to_char(A.fecha, 'DD Mon YYYY HH12:MI:SS') as fechax, A.*, B.lastname||', '||B.firstname as alumno, C.lastname||', '||C.firstname as tutor from senati_reg_incidencias A ";
$qsel .="inner join mdl_user B on B.id=A.id_alu ";
$qsel .="inner join mdl_user C on C.id=A.id_tutor ";
$qsel .="where id_curso=". $id_curso . " order by id_inc desc";


$rsel = pg_query($qsel) or die('Query failed 254: ' . pg_last_error());



echo "<BR><STRONG>Incidencias de este Curso</STRONG><BR><TABLE border=1 cellspacing=2 cellpadding=2>\n";
echo "<TR><TD bgcolor=silver><strong>Alumno</strong></TD><TD bgcolor=silver><strong>Tutor</strong></TD><TD bgcolor=silver><strong>INCIDENCIA</strong></TD><TD bgcolor=silver><strong>FECHA/HORA</strong></TD></TR>\n";



while($roxa=pg_fetch_array($rsel))
		{
		$link_alumno="http://virtual.senati.edu.pe/user/view.php?id=". $roxa["id_alu"] ."&course=". $id_curso;
		$link_tutor="http://virtual.senati.edu.pe/user/view.php?id=". $roxa["id_tutor"] ."&course=". $id_curso;

		
		echo "<TR><TD nowrap><a href='". $link_alumno ."' target=_blank><u>". $roxa["alumno"] ."</u></a></TD><TD nowrap>". $roxa["tutor"] ."</TD><TD>". $roxa["incidencia"] ."</TD><TD nowrap>".  $roxa["fechax"] . "</TR>\n";
		}
echo "</TABLE>";


	
	}
else

	{
	echo "Debe ser Administrador o Tutor del Curso para entrar a esta pagina.";
	}	

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
	if (wek==39 || wek==34)
	{
	window.event.keyCode=0;
	return false;
	}
	else
	{
	return true;
	}
}


function enviar_incidencia(){
	obje("txh_accion").value="salvar";
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

</script>
