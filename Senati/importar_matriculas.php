<?PHP
    require_once("../config.php");
    require_once("lib.php");
	
	///DESDE UN CURSO CON CAMPUS
	

    if (isadmin())
{
	//$id_curso_moodle= optional_param('id', 0, PARAM_INT);
	
	$id_curso_moodle=$_GET["id"];
	$site = get_site();
	
	if($id_curso_moodle=="")
	  {$id_curso_moodle=$_POST["id_curso_moodle"];}
	  
	//MATRICULAR  
	//VERIFICO SI DEBO MATRICULAR ALUMNOS
	$mensaje="";
	$accion=$_POST["tx_accion"];
	$alus_importados="";
	
///////////////////////////// IMPORTAR

    $id_curso_fuente=trim($_POST["id_curso_fuente"]);
    $id_campus=trim($_POST["id_campus"]);
	
	/*echo $id_curso_fuente . "<BR>\n";
	echo $id_campus . "<BR>\n";
	echo $accion . "<BR>\n";
	*/

	if ($accion=="importar")
	   {
	   if ($id_curso_moodle!=$id_curso_fuente && $id_curso_fuente!="")
		   {
			$periodico=$_POST["periodo_curso"];
			
			if($id_campus!="")
				{
				$sql_fuente="Select * from mdl_user_students where course=". $id_curso_fuente ." and camp='". $id_campus . "'";
				}
			else
				{
				$sql_fuente="Select * from mdl_user_students where course=". $id_curso_fuente;
				}
		
			$res_fuente=pg_query($sql_fuente) or die('Query failed 33: ' . pg_last_error());
			
			$rxmat=0;
			while($row=pg_fetch_array($res_fuente))
				 {
				 $id_usuario=$row["userid"];
				 $nrc=$row["nrc"];
				 $bloque=$row["bloque"];
				 $camp=trim($row["camp"]);

				 /// VERIFICAR QUE EL ALUMNO NO ESTA MATRICULADO
				 $qexiste="SELECT COALESCE((SELECT 1 FROM mdl_user_students WHERE course=". $id_curso_moodle ." and userid=". $id_usuario ." LIMIT 1),0) as existe";
				 $rexiste=pg_query($qexiste) or die('Query failed 44: ' . pg_last_error());
				 $row_existe=pg_fetch_array($rexiste);
				 $existe=$row_existe["existe"];
				 
				 if ($existe=="0")
					{
						if ($nrc=="")
						   {$nrc="NULL";}
						else
						   {$nrc="'".$nrc."'";}
						
						if ($bloque=="")
						   {$bloque="NULL";}
						else
						   {$bloque="'".$bloque."'";}
						
						if ($camp=="")
						   {$camp="NULL";}
						else
						   {$camp="'".$camp."'";}
					
						$qmatri  = "Insert into mdl_user_students (course,userid,camp,nrc,periodo,bloque,enrol) values (";
						$qmatri .= $id_curso_moodle. "," . $id_usuario . ",". $camp. "," . $nrc. ",'". $periodico ."',". $bloque . ",'manual')";
						$rmatri=pg_query($qmatri) or die('Query failed 61: ' . pg_last_error());
						$rxmat++;
						//echo $qmatri . "<BR>\n";
					}					
				 }
				$mensaje="Se importaron ". $rxmat . " Alumnos desde el curso: " . $id_curso_fuente . ", campus : ". $id_campus ;
			}
		}

//////////////////////////// FIN IMPORTAR
	
	//// OBTENCION DE DATOS DEL CURSO
		$camp_presencial="";
		$query0  = "Select fullname,periodo,camp_pres, (Select count(*) from mdl_user_students where course=A.id) as matriculas from mdl_course A where A.id=". $id_curso_moodle;
	    $result0 = pg_query($query0) or die('Query failed: ' . pg_last_error());
		$roxy=pg_fetch_array($result0); 
		
		$periodo_curso=$roxy["periodo"];
		$nombre_moodle =$roxy["fullname"];
		$matriculas_actuales =$roxy["matriculas"];
		$camp_presencial=$roxy["camp_pres"];
		

			//Campus distintos
				$querycamp  ="SELECT distinct(camp), nombre_centro From mdl_user_students ";
				$querycamp .="left join senati_centros on camp=id_centro ";
				$querycamp .="Where camp is not null and course=" . $id_curso_moodle;
				$resultcamp = pg_query($querycamp) or die('Query failed 113: ' . pg_last_error());

			$camp_distintos="";
			$campus_distintos="";

			$cz=0;
			while($roca=pg_fetch_array($resultcamp)) 
				{
				$camp=$roca["camp"];
				$campus=$roca["nombre_centro"];
				if($cz==0)
					{
					$camp_distintos="'". $camp . "'";
					$campus_distintos=$campus . " (". $camp . ")";
					}
				else
					{
					$camp_distintos .=",'" . $camp . "'";
					$campus_distintos .= "<BR>".$campus . " (". $camp . ")";
					}
				$cz++;
				}	

		

		
		
		
	
	//// FIN DE OBTENCION DE DATOS DEL CURSO
	
	/// VERIFICAR SI EXISTE EL CURSO PADRE SACARLO Y PONER EN EL RECUADRO
	
	//Campus distintos
		$querypres ="SELECT presencial_de from mdl_course where id=". $id_curso_moodle;
		$resultpres = pg_query($querypres) or die('Query failed 145: ' . pg_last_error());
	    $roxa=pg_fetch_array($resultpres); 
		$id_curso_padre=$roxa["presencial_de"];


	
	  
	  
	

	$titulo_pagina1 = "Importaci&oacute;n de Matriculas de otro Curso ";
	$titulo_pagina2 = "Importaci&oacute;n de Matriculas de otro Curso ";
	
	print_header("$site->shortname : ". $titulo_pagina1, "X1", $titulo_pagina2, "", "", true, "");
	
?>	
<strong style="color:blue">IMPORTACION de Matriculas : <a href="view.php?id=<?PHP echo $id_curso_moodle?>"><u><?PHP echo $nombre_moodle ?></u></a></strong><BR><BR>

<?PHP
if ($mensaje!="")
	{
	echo "<p><FONT color=red>" . $mensaje . "</font></p>";
	}

if ($alus_importados!="")
   {
   echo "ALUMNOS MATRICULADOS<BR><font color=green>". $alus_importados . "</font>";
   }
?>
<form name="thisform" id="thisform" method="post">
<strong>ID CURSO ACTUAL : <font style="font-size:18px" color=blue><?PHP echo $id_curso_moodle?></font></strong><BR>
<strong>CURSO ACTUAL :</strong> <font color=blue><?PHP echo $nombre_moodle ?></font><BR>
<strong>MATRICULAS ACTUALES :</strong> <font color=blue><?PHP echo $matriculas_actuales ?></font><BR>
<strong>Campus Distintos :</strong><BR>
<?PHP echo $campus_distintos ?>
<p>
<HR>

<table cellspacing=2 cellpadding=2 border=1 bordercolor=gray>
<TR>
<TD>
<strong>ID Curso Fuente </strong>
</TD>
<TD>
<input type=text name="id_curso_fuente" id="id_curso_fuente" size=5 value="<?PHP echo $id_curso_padre?>" onkeypress="return numeros();" >
</TD>
</TR>
<TR> 
<TD>
<strong>CAMP </strong>
</TD>
<TD>
<input type=text name="id_campus" id="id_campus" size=5 value="<?PHP echo $camp_presencial ?>" onkeypress="return comillas();" > (deje en blanco si desea importar de todos los campus)&nbsp;
</TD>
</TR>
<TR>
<TD colspan=2><INPUT type=button value="IMPORTAR" onClick="importar();"></TD>
</TR>
</TABLE>
<input type=hidden name="id_curso_moodle" id="id_curso_moodle" value="<?PHP echo $id_curso_moodle?>" >
<input type=hidden name="periodo_curso" id="periodo_curso" value="<?PHP echo $periodo_curso?>" >
<input type=hidden name="tx_accion" id="tx_accion" value="" >
</p>
</form>

<?PHP
print_footer();
?>
<script language="javascript">

function obje(ide){
	var obex=document.getElementById(ide);
	return obex;
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

function importar(){
	var id_curso_fuente=trim(obje("id_curso_fuente").value);
	//var id_campus=trim(obje("id_campus").value);
	if (id_curso_fuente !="")
	   {
	   obje("tx_accion").value="importar";
	   obje("thisform").submit();
	   }
}	
	
</script>
<?PHP
}
else
{
echo "Debe ser administrador para entrar a esta pagina";
}
?>


