<?PHP

    require_once("../config.php");
    require_once("lib.php");
	
	$site = get_site();

    if (isadmin())
	{
	$accion=$_POST["txh_accion"];
	$mensaje="";
    $id_usuario=$USER->id;
	
	$lista_cursos_tutor="";
	
	if ($accion=="registrar")
		{
		$id_svx=$_POST["tx_id_user_sv"];
		$campx=$_POST["sel_camp"];
		
		// VERIFICAR QUE NO EXISTE LA DUPLA
		$query_verif="SELECT COALESCE((SELECT 1 FROM senati_asist_part WHERE id_user=". $id_svx ." and camp_user='". $campx ."' LIMIT 1),0) as existe";
		$result_verif = pg_query($query_verif) or die('Query failed 21: ' . pg_last_error());
		$rover=pg_fetch_array($result_verif);
		
		$existe=$rover["existe"];
		if  ($existe=="1")
		    {
			$mensaje="<p>Ese Administrador ya existe en ese Campus: " . $campx . "</p>";
			}
		else
			{
			$qinsert  ="insert into senati_asist_part (id_user, camp_user) values (" . $id_svx . ",'" . $campx . "')";
			$rinsert = pg_query($qinsert) or die('Query failed 32: ' . pg_last_error());
			$mensaje="<p>Se Insert&oacute; un Registro. USUARIO: ". $id_svx . ", CAMP: ". $campx. "</p>";
			}
		}
		
	if ($accion=="borrar")
        {
        ///BORRAR EL PAR REGISTRADO
		$camp_borrar=$_POST["tx_camp_borrar"];
		$id_user_borrar=$_POST["tx_id_sv_borrar"];
		
		$qdelete  ="delete from senati_asist_part where id_user=" . $id_user_borrar. " and camp_user='". $camp_borrar . "'";
		$rdelete = pg_query($qdelete) or die('Query failed 44: ' . pg_last_error());
		$mensaje="<p>Se borr&oacute; el Administrador, ID USER SV :" . $id_user_borrar .", CAMP: ". $camp_borrar. "</p>";
        }		

	if ($accion=="asignar tutores")
        {
		// Se registrarán como tutores a los administradores cuyos campus correspondan a cursos presenciales_de<>null y en 
		// cuyas matriculas exista por lo menos una matricula de su camp
		
		$periodo_cursos=$_POST["tx_periodo"];

		/// LEO LA LISTA DE TUTORES
		$sql_lista = "Select * from senati_asist_part";
		$rs_lista = pg_query($sql_lista) or die('Query failed 56: ' . pg_last_error());
		
		$lista_cursos_tutor="";
		while($roxy=pg_fetch_array($rs_lista))
			{
			$campo=$roxy["camp_user"];
			$id_user=$roxy["id_user"];
			
			$query_tutox = "Select lastname, firstname, email from mdl_user where id=".$id_user;
			$rs_tutox = pg_query($query_tutox) or die('Query failed 68: ' . pg_last_error());
			$rozt=pg_fetch_array($rs_tutox);
			$data_tutor=$rozt["lastname"] . ", ". $rozt["firstname"] . "(" . $rozt["email"];
			
			$lista_cursos_tutor .="<BR><BR><strong>TUTOR : ". $data_tutor . " (Id SV: ". $id_user . ") del CAMP: " . $campo. "</strong><BR>";
			
			// Chequeo los cursos que tengan periodo=$periodo_cursos (mdl_course)
			// Chequeo los cursos que tengan al menos una matricula con camp=$campo (mdl_user_students)
			// Crear query para tener la lista de cursos
			
			$query_cursos_camp  = "Select id, fullname from mdl_course A where periodo='". $periodo_cursos ."' and presencial_de is not null ";
			$query_cursos_camp .= "and (SELECT COALESCE((SELECT 1 FROM mdl_user_students B WHERE B.course=A.id and B.camp='". $campo ."' LIMIT 1),0) as existe)=1";
			
			$rs_cursos_camp = pg_query($query_cursos_camp) or die('Query failed 81: ' . pg_last_error());
			
			while($roz=pg_fetch_array($rs_cursos_camp))
				{
				$id_curso=$roz["id"];
				$nombre_curso=$roz["fullname"];
				
				/// VERIFICAR QUE NO EXISTE COMO TUTOR EN ESE CURSO
				$query_verif="SELECT COALESCE((SELECT 1 FROM mdl_user_teachers WHERE course=". $id_curso ." and userid=". $id_user ." LIMIT 1),0) as existe";
				$rs_verif=pg_query($query_verif) or die('Query failed 85: ' . pg_last_error());
				$rowa=pg_fetch_array($rs_verif);
				$existe=$rowa["existe"];
				if ($existe=="1")
				   {
				   $naranja_huando="0";
				   }
				else
				   {
				   /// Inscribirlo en mdl_user_teachers
				   $query_teachers_insert  ="insert into mdl_user_teachers (userid, course,authority,role,editall,enrol) values(";
				   $query_teachers_insert .=$id_user. ",". $id_curso . ",1,'Tutor Presencial',1,'manual')";
				   $ejecuta=pg_query($query_teachers_insert) or die('Query failed 97: ' . pg_last_error());

				   $lista_cursos_tutor .="Se registr&oacute; como Tutor en el Curso: <strong>". $nombre_curso . "</strong> (" . $id_curso. ") : usando metodo Matriculas<BR>";
				   }
				}
			////////////////// AHORA VEO OTRO METODO : BUSCO LOS CURSOS CON ESE PERIODO, QUE SEAN PRESENCIALES Y CUYO campo camp_pres es igual que el campus del tutor
			/// camp_pres de LOS CURSOS
			//$campo=$roxy["camp_user"];
			//$id_user=$roxy["id_user"];
			
			$query_cursos_camp2  = "Select id, fullname from mdl_course A where periodo='". $periodo_cursos ."' and presencial_de is not null and camp_pres='".  $campo ."'";
			$rs_cursos_camp2 = pg_query($query_cursos_camp2) or die('Query failed 110: ' . pg_last_error());
					while($roz2=pg_fetch_array($rs_cursos_camp2))
						{
						///////////////
						$id_curso2=$roz2["id"];
						$nombre_curso2=$roz2["fullname"];
						
						/// VERIFICAR QUE NO EXISTE COMO TUTOR EN ESE CURSO
						$query_verif2="SELECT COALESCE((SELECT 1 FROM mdl_user_teachers WHERE course=". $id_curso2 ." and userid=". $id_user ." LIMIT 1),0) as existe";
						$rs_verif2=pg_query($query_verif2) or die('Query failed 116: ' . pg_last_error());
						$rowax=pg_fetch_array($rs_verif2);
						$existe=$rowax["existe"];
						if ($existe=="1")
						   {
						   $naranja_huando="0";
						   }
						else
						   {
						   /// Inscribirlo en mdl_user_teachers
						   $query_teachers_insert  ="insert into mdl_user_teachers (userid, course,authority,role,editall,enrol) values(";
						   $query_teachers_insert .=$id_user. ",". $id_curso2 . ",1,'Tutor Presencial',1,'manual')";
						   $ejecuta=pg_query($query_teachers_insert) or die('Query failed 134: ' . pg_last_error());

						   $lista_cursos_tutor .="Se registr&oacute; como Tutor en el Curso: <strong>". $nombre_curso2 . "</strong> (" . $id_curso2. ") : usando metodo Campus Presencial del Curso<BR>";
						   }
						///////////////
						}
			}
		}	
	   
//LISTA DE ADMINISTRADORES DE CURSOS PRESENCIALES

$lista_emails="";

$sql_listadmin  = "Select A.id_user, pidm_banner, camp_user, nombre_centro, nombre_zonal, firstname, lastname, email from senati_asist_part A ";
$sql_listadmin .= "inner join mdl_user B on A.id_user=B.id ";
$sql_listadmin .= "inner join senati_centros C on A.camp_user=C.id_centro ";
$sql_listadmin .= "left join senati_zonales D on D.id_zonal=C.id_zonax ";
$sql_listadmin .= "order by nombre_zonal, nombre_centro, lastname ";

$rs_listadmin = pg_query($sql_listadmin) or die('Query failed: ' . pg_last_error());


//LISTA DE CENTROS

$query_centros  = "Select id_centro, nombre_centro from senati_centros where id_centro not in ('00','SV','STI','50','60Q','65','60R','72A','73','69','60I','60Y') ";
$query_centros .= "order by nombre_centro ";

$rs_centros = pg_query($query_centros) or die('Query failed: ' . pg_last_error());


//////////////// HEADER PAGINA ////////////////
$titulo_pagina = "Administradores de Cursos Presenciales";
$enlace = "<a href='../course/cursos_admin_menu.php'>Administraci&oacute;n de Cursos</a> &gt; Administradores de Cursos Presenciales";
print_header("$site->shortname : ". $titulo_pagina, "X1", $enlace, "", "", true, "");

?>

<strong style="color:blue"><a href="../course/cursos_admin_menu.php"><u>Administraci&oacute;n de Cursos</u></a> - Administradores de Cursos Presenciales</strong><BR><BR>
<form name="thisform" id="thisform" method="post">

<font style="font-size:14px" id=fones color=red><?PHP echo $mensaje?></font>

<?PHP echo $lista_cursos_tutor ?>


<TABLE cellspacing=2 cellpadding=2 border=1 bordercolor="#dddddd">
<tr bgcolor="silver">
<TD><strong>Zonal&nbsp;</strong></TD>
<TD align=center><strong>Camp&nbsp;</strong></TD>
<TD><strong>Campus&nbsp;</strong></TD>
<TD><strong>Administrador&nbsp;</strong></TD>
<TD><strong>ID User SV&nbsp;</strong></TD>
<TD><strong>PIDM SINFO&nbsp;</strong></TD>
		<?PHP if($id_usuario=="2")
		{
		?>
		<TD><strong>Acciones&nbsp;</strong></TD>
		<?PHP
		}
		?>
</TR>
<?PHP
while($roy=pg_fetch_array($rs_listadmin)) 
	{
	
	$camp=$roy["camp_user"];
	$campus=$roy["nombre_centro"];
	$zonal=$roy["nombre_zonal"];
	$persona=$roy["lastname"]. ", ". $roy["firstname"];
	$id_sv=$roy["id_user"];
	$pidm_sinfo=$roy["pidm_banner"];
	$email=$roy["email"];
	$lista_emails .=$email . "; "
?>
<TR>
<TD><?PHP echo $zonal ?></TD>
<TD align=center><?PHP echo $camp ?></TD>
<TD><?PHP echo $campus ?></TD>
<TD>
<a href="http://virtual.senati.edu.pe/user/view.php?id=<?PHP echo $id_sv ?>&course=1" target="_blank"><u><?PHP echo $persona ?></u></a>

</TD>
<TD><?PHP echo $id_sv ?></TD>
<TD><?PHP echo $pidm_sinfo ?></TD>
		<?PHP if( $id_usuario=="2")
		{
		$parametros=$id_sv . ",'". $camp . "'";
		?>
		<TD align=center><INPUT type=button value="Borrar" onClick="borrar(<?PHP echo $parametros ?>);"></TD>
		<?PHP
		}
		?>
</TR>
<?PHP
  }	
?>
</TABLE>

<?PHP

if( $id_usuario=="2")
	{
?>
<p>	

<strong>Inscribir a TODOS como Tutores a Cursos presenciales del Periodo :</strong>&nbsp;
<INPUT type=text size=8 maxlength=8 name="tx_periodo" id="tx_periodo" value="">&nbsp;
<INPUT type=button value="Asignar como Tutores" onClick="asignar_tutores();">

</div>
<?PHP
	}
?>





<p>
<strong><font id="fonrep" color=red></font></strong>
<TABLE cellspacing=2 cellpadding=2 border=1 bordercolor="#cccccc">
<TR bgcolor=silver>
<TD colspan=4><STRONG>B&uacute;squeda de Personas</strong></TD>
</TR>
<TR>
<TD><STRONG>BUSCAR POR APELLIDOS</strong></TD>
<TD><INPUT type=text name="tx_apellidos" id="tx_apellidos" maxlength=50 size=25 value=""></TD>
<TD align=center><INPUT type=button value="BUSCAR" onClick="buscar_apellidos();"></TD>
<TD rowspan=2 id="td_busqueda" valign=top>
</TD>
</TR>

<TR>
<TD><STRONG>BUSCAR POR PIDM</strong></TD>
<TD><INPUT type=text name="tx_pidm" id="tx_pidm" maxlength=8 size=10 value=""></TD>
<TD align=center><INPUT type=button value="BUSCAR" onClick="buscar_pidm();"></TD>
</TR>
</TABLE>
</p>
<p>
<TABLE cellspacing=2 cellpadding=2 border=1 bordercolor="#cccccc">
<TR bgcolor=silver>
<TD colspan=2><STRONG>NUEVO ADMINISTRADOR DE CAMPUS</strong></TD>
</TR>
<TR>

<TD><STRONG>ID User SV</strong></TD>
<TD><INPUT type=text name="tx_id_user_sv" id="tx_id_user_sv" size=8 maxlength=8></TD>
</TR>
<TR>
<TD><STRONG>CAMPUS</strong></TD>
<TD>
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
</TD>
</TR>
<TR>
<TD></TD>
<TD>
<input type="button" value="Registrar" onclick="registrar();" />&nbsp;&nbsp;
</TD>
</TR>
</TABLE>
</p>
<input type=hidden name="tx_id_sv_borrar" id="tx_id_sv_borrar" value=""/>
<input type=hidden name="tx_camp_borrar" id="tx_camp_borrar" value=""/>
<input type=hidden name="txh_accion" id="txh_accion" value=""/>
</form>

<strong>EMAILS DE TODOS LOS ADMINISTRADORES</strong>
<p>
<textarea cols=100 rows=10>
<?PHP echo $lista_emails ?>
</textarea>
</p>


<p>
<a href="admin_presenciales.php"><u>Administrar Datos de Cursos Presenciales</u></a>
</p>

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


function asignar_tutores(){

    var periodo=trim(obje("tx_periodo").value);
	if (periodo !="")
	  {
	  obje("tx_periodo").value=periodo;
	  obje("txh_accion").value="asignar tutores";
      obje("thisform").submit();
	  }
	
	
}

function comillas() {
	//no acepta comillas simples ni dobles
	wek=window.event.keyCode;
	if (wek==39 || wek==34) {window.event.keyCode=0;}
}

function borrar(id_sv,camp){
		obje("tx_camp_borrar").value=camp;
		obje("tx_id_sv_borrar").value=id_sv;

	    obje("txh_accion").value="borrar";
		obje("thisform").submit();

}

function registrar() {
	var camp=obje("sel_camp").value;
	var id_user_sv=trim(obje("tx_id_user_sv").value);

	if (camp!="" && id_user_sv!="")
		{
	
	    obje("txh_accion").value="registrar";
		obje("thisform").submit();
		}	
}

function buscar_pidm(){
	var pidm=obje("tx_pidm").value;
    if (pidm!="")
		{
		obje("td_busqueda").innerHTML="";
		obje("fonrep").innerText="Procesando";
		url="admin_presenciales_pidm_ajax.php";
		var xmlo=crea_xmlhttpPost(url);
			 xmlo.onreadystatechange = function()
			  {
			   if (xmlo.readyState == 4)
				   {
				   update_data_pidm(xmlo.responseText);
				   }
			  }
		qstr="pidm="+ escape(pidm);
		xmlo.send(qstr);
		}
}

function update_data_pidm(str){
	obje("fonrep").innerText="";
	obje("td_busqueda").innerHTML=str;
}

function buscar_apellidos(){
	
	var apellidos=obje("tx_apellidos").value;
	var apellidos=trim(apellidos.toUpperCase());
	obje("tx_apellidos").value=apellidos;

    if (apellidos!="")
		{
		obje("td_busqueda").innerHTML="";
		obje("fonrep").innerText="Procesando";
		url="admin_presenciales_apes_ajax.php";
		var xmlo=crea_xmlhttpPost(url);
			 xmlo.onreadystatechange = function()
			  {
			   if (xmlo.readyState == 4)
				   {
				   update_data_apellidos(xmlo.responseText);
				   }
			  }
		qstr="apellidos="+ escape(apellidos);
		xmlo.send(qstr);
		}
}

function update_data_apellidos(str){
	obje("fonrep").innerText="";
	obje("td_busqueda").innerHTML=str;
}




function cancelar()
{
	var se=12;
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
	
</script>
<?PHP
}
else
{
echo "Debe ser administrador para entrar a esta pagina";
}
?>