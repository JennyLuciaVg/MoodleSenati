<?PHP
    require_once("../config.php");
    require_once("lib.php");
// JUSCE ADMINISTRACION DE CURSOS

// VISIBLE, PERIODO.

//JUSCE PONER SI ES DE SUBSANACION O NO


$ano_actual=date ("Y");
$ano_listar=$ano_actual;

	$titulo_pagina = "Administraci&oacute;n de Cursos de SENATI VIRTUAL";
	$site = get_site();

	print_header("$site->shortname : ". $titulo_pagina, "X1", $titulo_pagina, "", "", true, "");


    if (isadmin())

{


$tip_ord=$_POST["tip_ord"];
$colu_ord=$_POST["colu_ord"];


if ($tip_ord=="")
   {$tip_ord="DESC";}

if ($colu_ord=="")
   {$colu_ord="1";}

$accion = $_POST["th_accion"];
   
if ($accion=="ordenar")
   {$ano_listar=$_POST["th_ano_sel"];}


$mensaje="";
$numex="0"; 
if ($accion=="salvar")
	{
	$numex = count($_POST['id_curso']); 

	for($i=0;$i<$numex;$i++)
		{
		$course=$_POST['id_curso'][$i];
		$periox=$_POST['periodo'][$i];
		$abiertoy=$_POST['sel_open'][$i];
		$visibley=$_POST['sel_visible'][$i];
		$patrony=$_POST['sel_patron'][$i];
		$subsay=$_POST['sel_subsa'][$i];
		$induxi=$_POST['sel_induccion'][$i];
		$presexi=$_POST['sel_presencial'][$i];
		$id_pubix=$_POST['sel_publico'][$i];
		
		if ($id_pubix=="")
		   {$id_pubix="NULL";}
		
		if ($patrony=="s")
		   {$patronz=" ,patron='s'";}
		else
		   {$patronz=" ,patron=NULL";}

		
		   
		$query_save ="update mdl_course set periodo='". $periox . "', enrollable=". $abiertoy . ", visible=". $visibley . $patronz . ", subsanacion='". $subsay. "', ";
		$query_save .="induccion='". $induxi . "', presencial='" . $presexi . "', id_publico=" . $id_pubix . " where id=". $course;
		$result_save = pg_query($query_save) or die('Query failed 71: ' . pg_last_error());
		$rox=pg_fetch_array($result_save);
        }
	$mensaje="Se actualizaron ". $numex . " Cursos.";
	$ano_listar=$_POST["th_ano_sel"];
	}

if ($accion=="listar_ano")
   {$ano_listar=$_POST["sel_ano"];}
	

//name es categoria
	$query2 ="SELECT a.id, fullname,startdate, periodo, subsanacion, induccion, presencial, id_publico, ";
	$query2 =$query2 . "(Select count(*) from mdl_user_students Z where Z.course=A.id) as Inscritos, numsections, enrollable, visible, patron, ";
	$query2 =$query2 . "(Select count(*) from senati_actas_notas K where K.id_curso=A.id and estado='AP') as aprobados, ";
	$query2 =$query2 . "(Select count(*) from senati_actas_notas J where J.id_curso=A.id and estado='DE') as desaprobados, ";
	$query2 =$query2 . "(Select count(*) from senati_actas_notas M where M.id_curso=A.id and (estado<>'AP' and estado<>'DE')) as retinp ";
	$query2 =$query2 . "FROM mdl_course A where id<>1 and to_char(startdate::abstime, 'YYYY')='". $ano_listar . "' order by ". $colu_ord . " ". $tip_ord;
	$result2 = pg_query($query2) or die('Query failed: ' . pg_last_error());

?>
<BR />

<strong style="color:blue"><a href="cursos_admin_menu.php"><u>Administraci&oacute;n de Cursos</u></a> - Administraci&oacute;n General</strong><BR><BR>

<?PHP 

if ($mensaje !="")
   { echo "<font color=red>". $mensaje . "</font><BR><BR>";}

?>

<form name="thisform" id="thisform" method="post">

<strong>Seleccionar Año :</strong>
<select name="sel_ano">
<?PHP 

for ($i=$ano_actual;$i>2005;$i--)
    {
	if ($ano_listar==$i)
	   {$ata="selected";}
	else
	   {$ata="";}
	       
	   
	    	
?>
<option value="<?PHP echo $i ?>" <?PHP echo $ata ?>><?PHP echo $i ?></option>	
<?PHP	
	}
?>	
</select>
&nbsp;
<input type="button" value="Listar" onclick="listar_ano();"/>
&nbsp; &nbsp; &nbsp; 
<input type="button" value="SALVAR" onclick="salvar();" /> 
<BR />
<BR />


<strong><font color=red>NOTA 1 :</font></strong> El campo <strong>"Abierto"</strong> siempre debe estar en <strong>No</strong>, pues nosotros matriculamos manualmente a los usuarios.<BR />
<strong><font color=red>NOTA 2 :</font></strong> Se pueden ordenar los cursos haciendo click en los campos subrayados (color blanco).<BR /><BR />
<table cellpadding="1" cellspacing="1" border="1" bordercolor="#999999" >
<tr bgcolor="#999999">
<td height="23">&nbsp;<strong>N&deg;</strong>&nbsp;</td>
<td align="center" style="cursor:hand" onClick="ordenar(1);" title="Ordenar">&nbsp;<u style="color:white"><strong>Id Curso</strong></u>&nbsp;</td>
<td style="cursor:hand" onClick="ordenar(4);" title="Ordenar">&nbsp;<u style="color:white"><strong>Período</strong></u>&nbsp;</td>
<td style="cursor:hand" onClick="ordenar(8);" title="Ordenar">&nbsp;<u style="color:white"><strong>Visible</strong></u>&nbsp;</td>
<td style="cursor:hand" onClick="ordenar(7);" title="Ordenar">&nbsp;<u style="color:white"><strong>Abierto</strong></u>&nbsp;</td>
<td style="cursor:hand" onClick="ordenar(9);" title="Ordenar">&nbsp;<u style="color:white"><strong>Patr&oacute;n</strong></u>&nbsp;</td>
<td>&nbsp;<strong>Subsanaci&oacute;n</strong>&nbsp;</td>

<td>&nbsp;<strong>Inducci&oacute;n</strong>&nbsp;</td>
<td>&nbsp;<strong>Presencial</strong>&nbsp;</td>
<td>&nbsp;<strong>P&uacute;blico</strong>&nbsp;</td>

<td align="center">&nbsp;<strong>Fecha de Inicio</strong>&nbsp;</td>
<td style="cursor:hand" onClick="ordenar(2);" title="Ordenar">&nbsp;<u style="color:white"><strong>Nombre</strong></u>&nbsp;</td>
<td>&nbsp;<strong>Secciones</strong>&nbsp;</td>
<td>&nbsp;<strong>Inscritos</strong>&nbsp;</td>
<td title="Aprobados de Historia Academica">&nbsp;<strong>AP-HA</strong>&nbsp;</td>
<td title="Desaprobados de Historia Académica">&nbsp;<strong>DE-HA</strong>&nbsp;</td>
<td title="Retirados y No participaron de Historia Academica">&nbsp;<strong>RE/NP-HA</strong>&nbsp;</td>

</tr>
<?PHP
$ct=0;
$total_inscritos=0;
$total_aprobados=0;
$total_desaprobados=0;
$total_retinp=0;

while($rox2=pg_fetch_array($result2)) 
	{
$ct++;

if (trim($rox2["inscritos"]) != "")  
    {$total_inscritos=$total_inscritos +1 - 1 + $rox2["inscritos"];}

	$retirados_np=$rox2["retinp"];
	
	if ($rox2["retinp"]!= $rox2["aprobados"] + $rox2["desaprobados"])
	   {$retirados_np=$rox2["inscritos"]- $rox2["aprobados"] - $rox2["desaprobados"];}

   if ($retirados_np <0)
	   {$retirados_np=0;}


$total_aprobados=$total_aprobados+1-1+$rox2["aprobados"];
$total_desaprobados=$total_desaprobados+1-1+$rox2["desaprobados"];
$total_retinp=$total_retinp+1-1+$retirados_np;

$fecha_curso=$rox2["startdate"];	
$fecha_inicio_curso=date("d-m-Y",$fecha_curso);
$perox=$rox2["periodo"];
if ($perox=="")
    {$perox=date("Y",$fecha_curso);}
	
if ($perox=="2008")
	{$perox="200820";}
	
if ($perox=="2006")
	{$perox="200600";}	

if ($perox=="2007")
	{$perox="200700";}

	
$clase="";
	
if ($rox2["visible"] =="1")
    {$visi1="selected";
	 $visi2="";
	}
else
    {$visi2="selected";
	 $visi1="";
	 $clase="style='color:gray'";
	}

if ($rox2["enrollable"] =="1")
    {$open1="selected";
	 $open2="";
	 $cola_enrol="bgcolor=#CC9933";
	}
else
    {$open2="selected";
	 $open1="";
 	 $cola_enrol="";
	}

$patron=$rox2["patron"];

if($patron=="s")
   {$patron_si="selected";
    $patron_no="";
   }
else
   {$patron_si="";
    $patron_no="selected";
   }

   $cola_subsa="";
   
    if($rox2["subsanacion"]=="s" || $rox2["subsanacion"]=="S" )
	  {$subsa_si="selected";
	  $subsa_no="";
	  $subsax="s";
	  $cola_subsa="bgcolor=#CC9933";
	  }
	else
	  {$subsa_no="selected";
	  $subsa_si="";
	  $subsax="n";
	  }

/////induccion, presencial, id_publico,

if($rox2["induccion"]=="s")
   {$induccion_si="selected";
    $induccion_no="";
	$cola_indu="bgcolor=#CC9933";
   }
else
   {$induccion_no="selected";
    $induccion_si="";
	$cola_indu="";
   }

$cola_presencial="";
if($rox2["presencial"]=="s")
   {$presencial_si="selected";
    $presencial_no="";
	$cola_presencial="bgcolor=#CC9933";
   }
else
   {$presencial_no="selected";
    $presencial_si="";
   }

$sel_pub0="";
$sel_pub1="";
$sel_pub2="";
$sel_pub3="";
$sel_pub4="";
$sel_pub5="";
$sel_pub6="";

   
if($rox2["id_publico"]=="")
  {$sel_pub0="selected";}

if($rox2["id_publico"]=="1")
  {$sel_pub1="selected";}  

if($rox2["id_publico"]=="2")
  {$sel_pub2="selected";} 
  
if($rox2["id_publico"]=="3")
  {$sel_pub3="selected";}
  
if($rox2["id_publico"]=="4")
  {$sel_pub4="selected";}
  
if($rox2["id_publico"]=="5")
  {$sel_pub5="selected";}

if($rox2["id_publico"]=="6")
  {$sel_pub6="selected";}  
  
 ?> 
<tr>
<td align=right><?PHP echo $ct ?>&nbsp;</td>
<td align=center><?PHP echo $rox2["id"] ?>&nbsp;<input name="id_curso[]" value="<?PHP echo $rox2["id"] ?>" type="hidden" /></td>
<td align=center><input onkeypress="return numeros();" name="periodo[]" value="<?PHP echo $perox  ?>" maxlength=6 size=5 type="text" />&nbsp;</td>
<td align="center">
<select name="sel_visible[]">
<option <?PHP echo $visi1 ?> value="1">Si</option>
<option <?PHP echo $visi2 ?> value="0">No</option>
</select>
</td>
<td align="center" <?PHP echo $cola_enrol?>>
<select name="sel_open[]">
<option <?PHP echo $open1 ?> value="1">Si</option>
<option <?PHP echo $open2 ?> value="0">No</option>
</select>
</td>

<td align="center" >
<select name="sel_patron[]">
<option <?PHP echo $patron_si ?> value="s">Si</option>
<option <?PHP echo $patron_no ?> value="">No</option>
</select>
</td>

<td align="center" <?PHP echo $cola_subsa?>>
<select name="sel_subsa[]">
<option <?PHP echo $subsa_si ?> value="s">Si</option>
<option <?PHP echo $subsa_no ?> value="n">No</option>
</select>
</td>

<td align="center" <?PHP echo $cola_indu ?> >
<select name="sel_induccion[]">
<option <?PHP echo $induccion_si ?> value="s">Si</option>
<option <?PHP echo $induccion_no ?> value="n">No</option>
</select>
</td>

<td align="center" <?PHP echo $cola_presencial ?> >
<select name="sel_presencial[]">
<option <?PHP echo $presencial_si ?> value="s">Si</option>
<option <?PHP echo $presencial_no ?> value="n">No</option>
</select>
</td>
<td align="center" >
<SELECT name="sel_publico[]">
<OPTION <?PHP echo $sel_pub0 ?> value="">N/E</OPTION>
<OPTION <?PHP echo $sel_pub1 ?> value="1">Ex Alumnos</OPTION>
<OPTION <?PHP echo $sel_pub2 ?> value="2">Tr. Emp. Apor.</OPTION>
<OPTION <?PHP echo $sel_pub3 ?> value="3">Alumnos SENATI</OPTION>
<OPTION <?PHP echo $sel_pub4 ?> value="4">Publico General</OPTION>
<OPTION <?PHP echo $sel_pub5 ?> value="5">Trabajadores SENATI</OPTION>
<OPTION <?PHP echo $sel_pub6 ?> value="6">Equipo SENATI VIRTUAL</OPTION>
</td>

<td align=center><?PHP echo $fecha_inicio_curso ?></td>
<td><a <?PHP echo $clase ?> href="view.php?id=<?PHP echo $rox2["id"] ?>"><u <?PHP echo $clase ?>><?PHP echo $rox2["fullname"] ?></u></a>&nbsp;</td>
<td align="right"><?PHP echo $rox2["numsections"] ?></td>
<td align=right><?PHP echo $rox2["inscritos"] ?></td>
<td align=right><?PHP echo $rox2["aprobados"] ?></td>
<td align=right><?PHP echo $rox2["desaprobados"] ?></td>
<td align=right><?PHP echo $retirados_np ?></td>
</tr>
<?PHP
}
?>
<tr bgcolor="#efefef">
<td colspan=9 align=right><strong>TOTAL</strong></td>
<td align=right><strong><?PHP echo $total_inscritos ?></strong></td>
<td align=right><strong><?PHP echo $total_aprobados ?></strong></td>
<td align=right><strong><?PHP echo $total_desaprobados ?></strong></td>
<td align=right><strong><?PHP echo $total_retinp ?></strong></td>
</tr>
</table>
<BR>
<strong>LEYENDA :</strong><br>
<ul>
<li><strong>AP-HA</strong> : Aprobados - de Historia Academica
<li><strong>DE-HA</strong> : Desaprobados - de Historia Academica
<li><strong>RE/NP-HA</strong> : Retirados y No participaron - de Historia Academica
</ul>
<input type="hidden" name="tip_ord" id="tip_ord" value="<?PHP echo $tip_ord ?>" />
<input type="hidden" name="colu_ord" id="colu_ord" value="<?PHP echo $colu_ord ?>" />
<input type="hidden" name="th_accion" id="th_accion" value="" />
<input type="hidden" name="th_ano_sel" id="th_ano_sel" value="<?PHP echo $ano_listar ?>" />

<BR />
<input type="button" value="SALVAR" onclick="salvar();" />

</form>
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

function numeros(){
// trans-browser compatibility
// solo acepta numeros
var e = event || evt;
var charCode = e.which || e.keyCode;
if (charCode > 31 && (charCode < 48 || charCode > 57))
   return false;
   return true;
}

function salvar(){
    obje("th_accion").value="salvar";
	obje("thisform").submit();
}


function listar_ano(){
    obje("th_accion").value="listar_ano";
	obje("thisform").submit();
}



function ordenar(nume){
    if (obje("colu_ord").value==nume)
       {
       if (obje("tip_ord").value=="ASC")
          {obje("tip_ord").value="DESC";}
       else   
		  {obje("tip_ord").value="ASC";}
       }
    else
     {obje("colu_ord").value=nume;
      obje("tip_ord").value="ASC";
     }
    obje("th_accion").value="ordenar";
    obje("thisform").submit();
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