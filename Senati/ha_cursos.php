<?PHP

    require_once("../config.php");
    require_once("lib.php");

    if (isadmin())
{

	$titulo_pagina = "Historia Academica - Cursos Dictados";
	$site = get_site();

	print_header("$site->shortname : ". $titulo_pagina, "X1", $titulo_pagina, "", "", true, "");


$id_csen=$_POST["id_csen"];
$nombre_csen=$_POST["nombre_csen"];

	
$query1 ='SELECT fullname, E.id as id_curso_moodle , startdate, numsections, (Select count(*) from mdl_user_students Z where Z.course=E.id) as Inscritos,  '; 
$query1=$query1. '(SELECT COALESCE((SELECT 1 FROM mdl_course_modules K WHERE K.module=21 and K.course=E.id LIMIT 1),0)) as "Tiene_Certificado" From senati_Cursos A ';
$query1=$query1. 'left Join senati_rela_cursos_cursos  C on id_Curso_senati=A.id_Curso '; 
$query1=$query1. 'Inner Join mdl_course E on id_course_moodle=E.id ';
$query1=$query1. 'Where id_curso_senati=' . $id_csen ;
$query1=$query1. ' Order by startdate desc';

//echo $query1;

$result1 = pg_query($query1) or die('Query failed: ' . pg_last_error());

?>
<BR />

<strong style="color:blue"><a href="historia_academica.php"><u>Historia Academica</u></a> - <?PHP echo $nombre_csen?> - Cursos Dictados </strong><BR><BR>
<strong>ID Curso SENATI : <?PHP echo $id_csen?> </strong><BR><BR>
<form name="thisform" id="thisform" method="post">
<table cellpadding="1" cellspacing="1" border="1">
<tr bgcolor="#999999">
<td align="center"><strong>Seleccionar<BR /><a href="javascript:sel_toni();"><u style="color:blue">Todos/Ninguno</u></a></strong></td>
<td><strong>Nombre Moodle</strong></td>
<td><strong>Unidades</strong></td>
<td><strong>Fecha Inicio</strong></td>
<td><strong>Fecha Termino</strong></td>
<td><strong>Inscritos</strong></td>
<td align="center"><strong>ID Curso<BR>Moodle</strong></td>
<td><strong>Acta de Notas</strong></td>
<td>&nbsp;<strong>Certificaci&oacute;n</strong>&nbsp;</td>
</tr>
<?PHP
while($rox=pg_fetch_array($result1)) 
	{

$fecha_curso=$rox["startdate"];

$fecha_inicio_curso=date("d-m-Y",$fecha_curso);
$add_dias=7*$rox["numsections"];
$mana = mktime(0, 0, 0, date("m",$fecha_curso), date("d",$fecha_curso)+$add_dias, date("y",$fecha_curso));
$fecha_fin_curso=date("d-m-Y",$mana);

$id_cursom=$rox["id_curso_moodle"];

if ($rox["Tiene_Certificado"]==1)
    {$tcer="SI";}
else
    {$tcer="NO";}

$cursoy=trim($rox["fullname"]);

?>  
<tr>
<td align="center"><input type="checkbox" onClick="chequear(this);" name="sel_curso_moodle[]" value="<?PHP echo $id_cursom ?>" /></td>
<td><?PHP echo $rox["fullname"]?>&nbsp;</td>
<td align="center"><?PHP echo $rox["numsections"]?>&nbsp;</td>
<td align="center"><?PHP echo $fecha_inicio_curso ?>&nbsp;</td>
<td align="center"><?PHP echo $fecha_fin_curso ?>&nbsp;</td>
<td align=right><?PHP echo $rox["inscritos"]?>&nbsp;</td>
<td align="center"><?PHP echo $id_cursom ?>&nbsp;</td>
<td align=center>&nbsp;<u style="cursor:hand;cursor:pointer;color:blue" onClick="enviar(<?PHP echo $id_cursom?>,'<?PHP echo $fecha_inicio_curso ?>','<?PHP echo $cursoy ?>')">Acta SV</u>
&nbsp;<u style="cursor:hand;cursor:pointer;color:blue" onClick="enviar_sinfo(<?PHP echo $id_cursom?>,this)">Acta SINFO</u>&nbsp;	
<u style="cursor:hand;cursor:pointer;color:blue" onClick="enviar_desa(<?PHP echo $id_cursom?>,this)">Desaprobados</u>&nbsp;
<u style="cursor:hand;cursor:pointer;color:blue" onClick="editar_matri(<?PHP echo $id_cursom?>,this)">Editar Matriculas</u>&nbsp;	
</td>
<td align=center><?PHP echo $tcer?></td>
</tr>

<?PHP
  }
echo "</table><BR>";
?>

<input type="hidden" name="id_csen" id="id_csen" value="<?PHP echo $id_csen?>"/>
<input type="hidden" name="nombre_csen" id="nombre_csen" value="<?PHP echo $nombre_csen?>"/>
<input type="hidden" name="id_curso_moodle" id="id_curso_moodle" />
<input type="hidden" name="fecha_inicio" id="fecha_inicio" />
<input type="hidden" name="nombre_moodle" id="nombre_moodle" />
<input type="hidden" name="tx_total_sel" id="tx_total_sel" value=0 />

</form>
<BR>
<font style="font-size:14px"><a href="javascript:ver_nrcs();"><u style="color:blue">Actas SINFO de este curso SENATI (=SINFO) por NRC-PERIODO</u></a></font>&nbsp;(no es necesario hacer ningún check)
<BR><BR>
<strong>Con los cursos seleccionados :</strong>
<UL>
<li><a href="javascript:ver_desa();"><u style="color:blue">Ver Actas de Desaprobados Total</u></a></li>
<li><a href="javascript:ver_desa_excel();"><u style="color:blue">Ver Actas de Desaprobados Total Formato Excel</u></a></li>
<li><a href="javascript:ver_apro();"><u style="color:blue">Ver Actas de Aprobados Total</u></a></li>
<li><a href="javascript:ver_apro_uni();"><u style="color:blue">Ver Actas de Aprobados Total LISTA UNIFICADA</u></a></li>
<li><a href="javascript:ver_np();"><u style="color:blue">Ver Actas de NUNCA PARTICIPARON Total</u></a></li>
<li><a href="javascript:ver_np_excel();"><u style="color:blue">Ver Actas de NUNCA PARTICIPARON Total Formato Excel</u></a></li>
</ul>

	



<?PHP
print_footer();
?>


<script language="javascript">
function obje(ide){
	var obex=document.getElementById(ide);
	return obex;
}

function sel_toni()
{
	var cole = document.getElementsByName("sel_curso_moodle[]");
	var lex=cole.length;
	if (lex !=0 )
	   {
	   if (cole.item(0).checked==false)
		  {poner=true;
		  total=lex;
		  }
	   else
		  {poner=false;
		  total=0;
		  }
	   
	   for (i=0;i<lex;i++)
		   {
		   cole.item(i).checked=poner;
		   }
		obje("tx_total_sel").value=total;
	   } 
}

function ver_nrcs(){
obje("thisform").action="ha_cursos_acta_por_nrc.php";	
obje("thisform").submit();
}



function chequear(este){
	var total_chequeados=obje("tx_total_sel").value;
	if (este.checked)
		{
		total_chequeados++;
		}
	else	
		{
		total_chequeados--;
		}
		obje("tx_total_sel").value=total_chequeados;
}

function ver_np_excel(){
if (obje("tx_total_sel").value !="0")
	{
	obje("thisform").action="ha_cursos_acta_NP_total_excel.php";	
	obje("thisform").submit();
	}
}


function ver_np(){
if (obje("tx_total_sel").value !="0")
	{
	obje("thisform").action="ha_cursos_acta_NP_total.php";	
	obje("thisform").submit();
	}
}

function ver_desa(){
if (obje("tx_total_sel").value !="0")
	{
	obje("thisform").action="ha_cursos_acta_desa_total.php";	
	obje("thisform").submit();
	}
}

function ver_apro_uni(){
if (obje("tx_total_sel").value !="0")
	{
	obje("thisform").action="ha_cursos_acta_apro_uni.php";	
	obje("thisform").submit();
	}
}
function ver_apro(){
if (obje("tx_total_sel").value !="0")
	{
	obje("thisform").action="ha_cursos_acta_apro_total.php";	
	obje("thisform").submit();
	}
}

function ver_desa_excel(){
if (obje("tx_total_sel").value !="0")
	{
	obje("thisform").action="ha_cursos_acta_desa_total_excel.php";	
	obje("thisform").submit();
	}
}

function enviar(idcm,finicio,nome_curso){
	obje("id_curso_moodle").value=idcm;
	//idx=este.sourceIndex;
	//var finicio=document.all[idx-5].innerText;
	//var nombre_moodle=document.all[idx-7].innerText;
	obje("fecha_inicio").value=trim(finicio);
	obje("thisform").nombre_moodle.value=trim(nome_curso);
	obje("thisform").action="ha_cursos_acta.php";
	obje("thisform").submit();
}

function enviar_sinfo(idcm,este){
	obje("thisform").id_curso_moodle.value=idcm;
	idx=este.sourceIndex;
	var finicio=document.all[idx-6].innerText;
	var nombre_moodle=document.all[idx-8].innerText;
	obje("fecha_inicio").value=trim(finicio);
	obje("nombre_moodle").value=trim(nombre_moodle);
	obje("thisform").action="ha_cursos_acta_sinfo.php";
	obje("thisform").submit();
}
function enviar_desa(idcm,este){
obje("thisform").id_curso_moodle.value=idcm;
idx=este.sourceIndex;
var finicio=document.all[idx-7].innerText;
var nombre_moodle=document.all[idx-9].innerText;
obje("fecha_inicio").value=trim(finicio);
obje("nombre_moodle").value=trim(nombre_moodle);
obje("thisform").action="ha_cursos_acta_desa.php";
obje("thisform").submit();
}



function editar_matri(idcm,este){
obje("thisform").id_curso_moodle.value=idcm;
idx=este.sourceIndex;
var finicio=document.all[idx-8].innerText;
var nombre_moodle=document.all[idx-10].innerText;
obje("fecha_inicio").value=trim(finicio);
obje("nombre_moodle").value=trim(nombre_moodle);
obje("thisform").action="ha_curso_editar_matri.php";
obje("thisform").submit();
}


function numeros(){
// solo acepta numeros
wek=window.event.keyCode;
if (wek<48 || wek>57){window.event.keyCode=0;}
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
echo "Debe ser administrador para entrar a esta página";
}
?>