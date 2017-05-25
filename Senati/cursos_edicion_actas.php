<?PHP

    require_once("../config.php");
    require_once("lib.php");
	
	//EDICION DE ACTAS DE NOTAS OFICIAL DENTRO DEL CURSO
	// 8 de JULIO 2014
    

    if (isadmin())
{

    $id_curso_moodle=required_param('id');              // course id


	if ($id_curso_moodle=="")
	   {
		$id_curso_moodle=$_POST["id_curso_moodle"];
	   }
	


	$titulo_pagina = "Edici&oacute;n de Acta de Notas Oficial";
	$site = get_site();

	print_header("$site->shortname : ". $titulo_pagina, "X1", $titulo_pagina, "", "", true, "");
 
 $qcurso ="Select * from mdl_course where id=".$id_curso_moodle;
 $rcurso =pg_query($qcurso) or die('Query failed 30: ' . pg_last_error());	
 $roma=pg_fetch_array($rcurso);
 $fecha_curso=$roma["startdate"];
 $fecha_inicio_curso=date("d-m-Y",$fecha_curso);
 
 $nombre_moodle=$roma["fullname"];


$tarea=$_POST["fg_tarea"]; // Solo cuando se pulsa el boton enviar

$usuario_id=$USER->id;
// ACA AVERIGUO SI VOY A SALVAR o NO
$registros_actualizados=0;
$mensaje="";

if ($tarea=="salvar")
	{
	$total_notas=$_POST["total_notas"];
		for ($i=1; $i<$total_notas+1; $i++)
			{
			  $ob_id_alu="id_alu_" . $i;
			  $ob_nota="inp_nota_" . $i;
			  $ob_estado="sel_estado_" . $i;
			  $ob_accion="th_accion_" . $i;
			  $ob_estado_anterior="estado_anterior_" . $i;
			  $ob_nota_anterior="nota_anterior_" . $i;
			  
			  $valor_id_alu=$_POST[$ob_id_alu];
			  $valor_nota=trim($_POST[$ob_nota]);
			  $valor_estado=trim($_POST[$ob_estado]);
			  $valor_nota_anterior=trim($_POST[$ob_nota_anterior]);
			  $valor_estado_anterior=trim($_POST[$ob_estado_anterior]);
			  $valor_accion=$_POST[$ob_accion];
		
				$editar="no";
				if ($valor_nota != $valor_nota_anterior || $valor_estado_anterior != $valor_estado)
				   {$editar="si";}
		
				if ($valor_nota=="")
				   {$valor_nota="NULL";}
				else
				   {$valor_nota="'". $valor_nota ."'";}
				
				if ($valor_estado=="")
				   {$valor_estado="NULL";}
				else
				   {$valor_estado="'". $valor_estado ."'";}
		
			$sqele="";
		
			if ($valor_accion=="editar" && $editar=="si")
				   {
					$sqele="Update senati_actas_notas set nota=". $valor_nota . ", estado=". $valor_estado. ", fecha_actividad=now(), id_usuario=". $usuario_id. " where id_alumno=". $valor_id_alu. " and id_curso=". $id_curso_moodle ."; COMMIT;";
				   }
			
			if ($valor_accion=="insertar")
				   {
				   $sqele="Insert into senati_actas_notas (id_alumno, id_curso, nota, fecha_actividad, estado, id_usuario) Values (" .$valor_id_alu. ",". $id_curso_moodle . "," . $valor_nota . ", now()," . $valor_estado . "," . $usuario_id .");COMMIT;";
				   }
		
			if ($sqele !="")
				{
				$resultado = pg_query($sqele) or die('Query failed 74: ' . pg_last_error());	
				$roma=pg_fetch_array($resultado); 
				$registros_actualizados++;
				}
			}

		if ($registros_actualizados==0)
            {$mensaje="<font color=green>No se actualiz&oacute; ning&uacute;n registro</font>";}
		if ($registros_actualizados==1)
            {$mensaje="<font color=green>Se actualiz&oacute; 1 registro</font>";}
		if ($registros_actualizados > 1)
            {$mensaje="<font color=green>Se actualizaron ". $registros_actualizados . " Registros</font>";}

}

//echo $sqele;
	
$query  =  'SELECT userid, username, firstname, lastname, email , city, A.nrc, Nota, Estado, pidm_banner From mdl_user_students A left join mdl_user B on userid=B.id ';
$query .= ' left join senati_actas_notas C on C.id_curso=A.course and B.id=id_alumno Where A.course=' . $id_curso_moodle . ' order by lastname';
$result = pg_query($query) or die('Query failed 94: ' . pg_last_error());
// Printing results in HTML

?>
<strong style="color:blue"><a href="view.php?id=<?PHP echo $id_curso_moodle?>"><u><?PHP echo $nombre_moodle?></u></a> - Edici&oacute;n de Acta de Notas (H.A.)</strong><BR><BR>


<table cellpadding="3" cellspacing="1" border="1" bordercolor="gray">
<tr><td align=right><strong>ID Curso Moodle</strong></td><td><strong><font style="font-size:16px"><?PHP echo $id_curso_moodle?></font></strong></td></tr>
<tr><td align=right><strong>Nombre Curso Moodle</strong></td><td><u style="color:blue;cursor:hand;cursor:pointer" onClick="window.navigate('view.php?id=<?PHP echo $id_curso_moodle?>')"><?PHP echo $nombre_moodle?></u></td></tr>
<tr><td align=right><strong>Fecha de Inicio</strong></td><td><?PHP echo $fecha_inicio_curso ?></td></tr>
<tr><td align=right><strong>Tutor(es)</strong></td>
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
</table>

<BR>
<? if ($mensaje != "")
	{
	echo "<strong>". $mensaje . ".</strong><BR/><BR/>";
	}
?>
<strong style="color:red">NOTA: La sesi&oacute;n de modificaci&oacute;n de estos datos ser&aacute; registrada en detalle por motivos de seguridad.</strong>  
<br /><br />
<form name="thisform" id="thisform" method="post">
<input type="button" onClick="enviar();" value="GUARDAR" />
<br /><br />
<table cellpadding="1" cellspacing="1" border="1">
<TR bgcolor="#dddddd">
<td ><strong>N&deg;</strong></td>
<td align=center><strong>Id Moodle</strong></td>
<td align=center><strong>PIDM SINFO</strong></td>
<td><strong>Apellidos, Nombres</strong></td>
<td><strong>NRC</strong></td>
<td><strong>Ciudad</strong></td>
<td><strong>NOTA</strong></td>
<td><strong>Estado</strong></td>
</TR>

<?PHP
$c1=0;

while($row=pg_fetch_array($result)) 
	{
	$id_userx=$row["userid"];
	$c1++;
    $stax=$row["estado"];

$atri1="";
$atri2="";
$atri3="";
$atri4="";

if ($stax=="AP")
   {$atri1="selected";}
if ($stax=="DE")
   {$atri2="selected";}
if ($stax=="RE")
   {$atri3="selected";}
if ($stax=="NP")
   {$atri4="selected";}

$sqw='SELECT COALESCE((SELECT 1 FROM senati_actas_notas WHERE id_curso='. $id_curso_moodle .' and id_alumno='. $id_userx. ' LIMIT 1),0) as "existe"';
$resa = pg_query($sqw) or die('Query failed: ' . pg_last_error());

while($ron=pg_fetch_array($resa)) 
	{
	$existe =$ron["existe"];
	}
// si es 1 existe si es 0 no existe

if ($existe=="1")
   {$accion="editar";}
if ($existe=="0")
   {$accion="insertar";}
?>
<TR>
<td align=right><?php echo $c1 ?>&nbsp;</td>
<td align=center><?php echo $row["userid"] ?>&nbsp;</td>
<td align=center style="color:blue"><?php echo $row["pidm_banner"] ?>&nbsp;</td>
<td><?php echo $row["lastname"]. ", ". $row["firstname"]  ?>&nbsp;</td>
<td align=center><?php echo $row["nrc"] ?>&nbsp;</td>
<td><?php echo $row["city"] ?>&nbsp;</td>
<td align="right"><input class="suxa" type="text" name="inp_nota_<?PHP echo $c1?>" onfocus="foquear(this);" onblur="blurear(this);" maxlength=4 size=4 onkeypress="numeros_deci(this);" value="<?php echo $row["nota"] ?>" /></td>
<td>
<select name="sel_estado_<?PHP echo $c1?>" class="sexa">
<option  value=""></option>
<option <?PHP echo $atri1?> value="AP">Aprobado</option>
<option <?PHP echo $atri2?> value="DE">Desaprobado</option>
<option <?PHP echo $atri3?> value="RE">Retirado</option>
<option <?PHP echo $atri4?> value="NP">No particip&oacute;</option>
</select>
<input type="hidden" name="estado_anterior_<?PHP echo $c1?>" value="<?PHP echo $row["estado"]?>" />
<input type="hidden" name="nota_anterior_<?PHP echo $c1?>" value="<?PHP echo $row["nota"]?>" />
<input type="hidden" name="id_alu_<?PHP echo $c1?>" value="<?PHP echo $row["userid"]?>" />
<input type="hidden" name="th_accion_<?PHP echo $c1?>" value="<?PHP echo $accion?>" />
</TD>
</TR>
<?PHP
}
?>
</table>
<input type="hidden" name="id_curso_moodle" id="id_curso_moodle" value="<?PHP echo $id_curso_moodle ?>" >
<input type="hidden" name="total_notas" id="total_notas" value="<?PHP echo $c1 ?>" >
<input type="hidden" name="fg_tarea" id="fg_tarea">

<p>
<input type="button" onClick="poner_status();" value="Poner Status a Todos" />&nbsp;&nbsp;&nbsp;<input type="button" onClick="enviar();" value="GUARDAR" />
</p>

<P>
<BR>
<BR>
<BR>
<BR>

<input type="button" onClick="aprobar_todos();" value="Poner Aprobado a Todos" />
</P>
</form>
<?PHP
print_footer();
?>
<script language="javascript">

function obje(ide){
	var obex=document.getElementById(ide);
	return obex;
}


function foquear(objex){
objex.style.backgroundColor="yellow";
}
function blurear(objex){
objex.style.backgroundColor="";
}

function poner_status(){
	var inp_nota = document.getElementsByClassName("suxa");
	var selex = document.getElementsByClassName("sexa");
	
	lex=selex.length;
	
	for (i=0;i<lex;i++)
		{
		var noto=trim(inp_nota[i].value);
		
		if (noto <10.5)
			{selex[i].value="DE";}
		if (noto >=10.5)
			{selex[i].value="AP";}	
		if (noto=="")
			{selex[i].value="NP";}		
		}

}

function aprobar_todos(){
	var colox = document.getElementsByClassName("sexa");

	lex=colox.length;

	for (i=0;i<lex;i++)
		{
		colox[i].value="AP";
		}
}

function enviar(){
obje("thisform").action='';
var cole=document.getElementsByTagName("INPUT");
var lex=cole.length;
inperror="0";
for (i=0; i<lex; i++)
	{
     var nombre = cole.item(i).name;
     if (nombre.indexOf("inp_nota") !=-1)
 		 {
			 var valor=cole.item(i).value;
			 if (valor > 20)
				{var inperror=cole.item(i);
				 break;}
 		 }
	}
if (inperror!="0")
   {inperror.focus();}
obje("fg_tarea").value="salvar";
obje("thisform").submit();
}


function numeros_deci(objex){
// solo acepta numeros y un punto
wek=window.event.keyCode;
var conte=objex.value;
if (conte.indexOf(".") !=-1 && wek == 46) {window.event.keyCode=0;}
if ((wek<48 || wek>57) && wek!=46){window.event.keyCode=0;}
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