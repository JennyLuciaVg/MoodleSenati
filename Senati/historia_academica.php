<?PHP

    require_once("../config.php");
    require_once("lib.php");
    require_once("../conexion.php");

    if (isadmin())
{

	$titulo_pagina = "Historia Academica";
	$site = get_site();

	print_header("$site->shortname : ". $titulo_pagina, "X1", $titulo_pagina, "", "", true, "");

	
	$query1 ='SELECT A.*, b.*, (select count(*) From senati_rela_cursos_cursos F Where F.id_curso_senati=A.id_curso) as "TOTAL_DICTADOS" FROM senati_cursos A inner Join mdl_course_categories B on B.id=id_categoria order by nombre_curso';
	$result1 = pg_query($query1) or die('Query failed: ' . pg_last_error());
	
	


?>
<BR />
<strong style="color:blue">Historia Academica - Seleccione un Curso :</strong>
<table cellpadding="1" cellspacing="1" border="1">
<tr bgcolor="#999999">
<td><strong>Código&nbsp;</strong></td>
<td><strong>Nombre</strong></td>
<td><strong>Categoria</strong></td>
<td><strong>&nbsp;Dictado (N&deg; de Veces)&nbsp;</strong></td>
</tr>
<?PHP
while($rox=pg_fetch_array($result1)) 
	{
$id_curso=$rox["id_curso"];
?>  
<tr>
<td  align=center><?PHP echo $rox["banner_subj_code"].'-'.$rox["banner_crse_numb"]?>&nbsp;</td>
<td><u style="color:blue;cursor:hand;cursor:pointer" onClick="ver_cursos(<?PHP echo $id_curso?>,'<?PHP echo $rox["nombre_curso"]?>')"><?PHP echo $rox["nombre_curso"]?></u>&nbsp;</td>
<td><?PHP echo $rox["name"]?>&nbsp;</td>
<td align=right><?PHP echo $rox["TOTAL_DICTADOS"]?>&nbsp;</td>
</tr>

<?PHP
  
  }
echo "</table><BR>";


print_footer();
?> 

<form name="thisform" id="thisform" method="post" action="ha_cursos.php">
<input type="hidden" id="id_csen" name="id_csen">
<input type="hidden" id="nombre_csen" name="nombre_csen">
</form>


<script language="javascript">
function obje(ide){
	var obex=document.getElementById(ide);
	return obex;
}



function ver_cursos(id_curso_senati,nome_curso){
	obje("id_csen").value=id_curso_senati;
	obje("nombre_csen").value=trim(nome_curso);
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