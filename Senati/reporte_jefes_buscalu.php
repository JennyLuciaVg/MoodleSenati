<?PHP

// BUSCAR UN ALUMNO

    require_once('../config.php');
    require_once("../course/lib.php");
	
	$usuario=$USER->id;
	//VERIFICO SI ES JEFE DE CENTRO
	$qjefe  ='SELECT jefe_centro, campus_repo from mdl_user where id=' . $usuario;
	$result_jefe=pg_query($qjefe) or die('Query failed: ' . pg_last_error());
	
	$roj=pg_fetch_array($result_jefe);
	
	$esjefe=$roj["jefe_centro"];
	$campus_repo=$roj["campus_repo"];
	
	// Si $esjefe
	// Si en campus_repo esta vacio significa que es para todos los campus
	// Sino entonces los campus deben estar separados por comas y comillas simples
	
   if ($esjefe=="s")
{
	
	$site = get_site();
   	$titulo_pagina = "Reporte para Jefes de Centro - B&uacute;squeda de Alumnos";
	print_header("$site->shortname : ". $titulo_pagina, "X1", $titulo_pagina, "", "", true, "");

	$pidm_buscado="";
	$apes_buscado="";
	$nom_buscado="";
	$dni_buscado="";
	$idsv_buscado="";
	
	$accion=$_POST["tx_accion"];


	if ($accion=="buscar idsv")
		{
		$idsv_buscado=trim($_POST["tx_idsv"]);
		$query_where="where deleted=0 and A.id=". $idsv_buscado ;
		}
	
	if ($accion=="buscar pidm")
		{
		$pidm_buscado=trim($_POST["tx_pidm"]);
		$query_where="where deleted=0 and pidm_banner=". $pidm_buscado ;
		}
		
	if ($accion=="buscar apellidos")
		{
		$apes_buscado=trim($_POST["tx_apellidos"]);
		$query_where="where deleted=0 and upper(lastname) like upper('%". $apes_buscado ."')||'%' order by lastname";
		}

	if ($accion=="buscar nombres")
		{
		$nom_buscado=trim($_POST["tx_nombres"]);
		$query_where="where deleted=0 and upper(firstname) like upper('%". $nom_buscado ."')||'%' order by lastname";
		}
	if ($accion=="buscar dni")
		{
		$dni_buscado=trim($_POST["tx_dni"]);
		$query_where="where deleted=0 and (dni='". $dni_buscado ."' or username='".  $dni_buscado."') order by lastname";
		}	
		

if ($accion!="")
   {
	$query_fin  ="SELECT A.id, firstname, lastname, email, campus, nombre_centro, pidm_banner, tipo_user, publico,dni ";
	$query_fin .="from mdl_user A ";
	$query_fin .="left join senati_centros B on A.campus=B.id_centro ";
	$query_fin .="left join senati_costos C on A.tipo_user=C.id ";
	$query_fin .=$query_where;

	$resultado=pg_query($query_fin) or die('Query failed: ' . pg_last_error());	
   }   
		
?>
<strong style="color:blue"><a href="reporte_jefes.php"><u>Reporte para Jefes de Centro</u></a> - B&uacute;squeda de Alumnos</strong><BR><BR>
<BR>
<form name="thisform" id="thisform" method="post">

<strong style="color:blue">Ingrese un criterio de B&uacute;squeda</strong>
<table cellpadding="2" cellspacing="2" border=1>
<TR>
<TD>Buscar por PIDM SINFO</TD>
<TD><INPUT type="text" name="tx_pidm" id="tx_pidm" maxlength=10 OnKeyPress="validar1(event);return isNumberKey(event);" value="<?PHP echo $pidm_buscado ?>"></TD>
<TD><INPUT type="button" value="Buscar" onclick="buscar_pidm();"></TD>
</tr>

<TR>
<TD>Buscar por ID de SENATI VIRTUAL</TD>
<TD><INPUT type="text" name="tx_idsv" id="tx_idsv" maxlength=10 OnKeyPress="validar2(event);return isNumberKey(event)" value="<?PHP echo $idsv_buscado ?>"></TD>
<TD><INPUT type="button" value="Buscar" onclick="buscar_idsv();"></TD>
</tr>

<tr>
<td>Buscar por Apellido(s)</td>
<td><INPUT type="text" name="tx_apellidos" id="tx_apellidos" maxlength=20 OnKeyPress="validar3(event);comillas();" value="<?PHP echo $apes_buscado ?>"></TD>
<td><INPUT type="button" value="Buscar" onclick="buscar_ape();"></td>
</tr>
<tr>
<td>Buscar por Nombre(s)</td>
<td><INPUT type="text" name="tx_nombres" id="tx_nombres" maxlength=20 OnKeyPress="validar4(event);comillas();" value="<?PHP echo $nom_buscado ?>"></TD>
<td><INPUT type="button" value="Buscar" onclick="buscar_nom();"></td>
</tr>

<tr>
<td>Buscar por Usuario</td>
<td><INPUT type="text" name="tx_dni" id="tx_dni" maxlength=15 OnKeyPress="validar5(event);comillas();" value="<?PHP echo $dni_buscado ?>"></TD>
<td><INPUT type="button" value="Buscar" onclick="buscar_dni();"></td>
</tr>


</table>
<input type="hidden" name="tx_accion" id="tx_accion">
</form>

<?PHP

if ($accion!="")
   {

?>

<BR><BR>
<strong style="color:blue">Resultado</strong>

<em>Haga click en el alumno para ver su historial.</em>
<TABLE cellpadding=2 cellspacing=2 border=1>
<TR bgcolor="silver">
<TD><strong>Apellidos, Nombres</strong></TD>
<TD><strong>Centro</strong></TD>
<td><strong>ID SV</strong></TD>
<td><strong>PIDM SINFO</strong></TD>
<td><strong>Datos</strong></TD>
</TR>

<?PHP
while($row=pg_fetch_array($resultado))
	{
?>
	<TR>
	<TD><?PHP echo $row["lastname"] . ', '. $row["firstname"] ?></td>
	<TD><?PHP echo $row["nombre_centro"] ?></td>
	<TD align=right><?PHP echo $row["id"] ?></td>
	<TD align=right><?PHP echo $row["pidm_banner"] ?></td>
	<TD><a href="javascript:ver_alumno(<?PHP echo $row["id"] ?>)"><u>Ver Historial</u></a></td>
	</TR>
<?PHP
	}
?>
</TABLE>
<FORM name="thisform2" id="thisform2" action="reporte_jefes_alu_historial.php" method="post">
<INPUT type=hidden name="txh_id_alu" id="txh_id_alu" value="">
</FORM>

<?PHP   
   }
?>
<BR>
<BR>

<?PHP
print_footer();
?>
<script language="javascript">

function obje(ide){
	var obex=document.getElementById(ide);
	return obex;
}

function ver_alumno(id_alumno){
	obje("txh_id_alu").value=id_alumno;
	obje("thisform2").submit();	
}

function validar1(e) {
  tecla = (document.all) ? e.keyCode : e.which;
  if (tecla==13)
	 {
	 buscar_pidm();
	 }
}

function validar2(e) {
  tecla = (document.all) ? e.keyCode : e.which;
  if (tecla==13)
	 {
	 buscar_idsv();
	 }
}

function validar3(e) {
  tecla = (document.all) ? e.keyCode : e.which;
  if (tecla==13)
	 {
	 buscar_ape();
	 }
}

function validar4(e) {
  tecla = (document.all) ? e.keyCode : e.which;
  if (tecla==13)
	 {
	 buscar_nom();
	 }
}

function validar5(e) {
  tecla = (document.all) ? e.keyCode : e.which;
  if (tecla==13)
	 {
	 buscar_dni();
	 }
}

function buscar_dni(){
	var dni=trim(obje("tx_dni").value);
	if (dni !="")
	   {obje("tx_accion").value="buscar dni";
		obje("thisform").submit();
	   }
}


function buscar_idsv(){
	var idsv=trim(obje("tx_idsv").value);
	if (idsv !="")
	   {obje("tx_accion").value="buscar idsv";
		obje("thisform").submit();
	   }
}


function buscar_pidm(){
	var pidm=trim(obje("tx_pidm").value);
	if (pidm !="")
	   {obje("tx_accion").value="buscar pidm";
		obje("thisform").submit();
	   }
}

function buscar_ape(){
	var apellidos=trim(obje("tx_apellidos").value);

	if (apellidos !="")
	   {obje("tx_accion").value="buscar apellidos";
		obje("thisform").submit();
	   }
}


function buscar_nom(){
	var nombres=trim(obje("tx_nombres").value);

	if (nombres !="")
	   {obje("tx_accion").value="buscar nombres";
		obje("thisform").submit();
	   }
}



function comillas() {
	//no acepta comillas simples ni dobles
	wek=window.event.keyCode;
	if (wek==39 || wek==34) {window.event.keyCode=0;}
}

function isNumberKey(evt)
      {
         var charCode = (evt.which) ? evt.which : event.keyCode
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
echo "Debe ser Jefe para ver esta pagina";
}
?>