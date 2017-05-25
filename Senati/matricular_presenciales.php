<?PHP
    require_once("../config.php");
    require_once("lib.php");
	
	///DESDE UN CURSO CON CAMPUS
	
	// ESTE MODULO RECIBE UN PERIODO y LUEGO LISTA TODOS LOS PRESENCIALES
	// LUEGO LEE LOS CURSOS PADRE y SUS CAMP PRES Y JALA SUS MATRICULAS
	// LUEGO LOS MATRICULA EN EL CURSO

	
    if (isadmin())
{

	$site = get_site();
	
	  
	// IMPORTAR MATRICULAS
	//VERIFICO SI DEBO MATRICULAR ALUMNOS
	$mensaje="";
	$accion=$_POST["tx_accion"];
	$periodo_seleccionado=$_POST["th_periodo"];	
	
///////////////////////////// IMPORTAR

	$mostrar_matriculas_nuevas=false;
	
	if ($accion=="importar")
	   {
	   $mostrar_matriculas_nuevas=true;
	   
	    // ACA tengo que leer los hidden
   	    // th_id_curso_pres[]
	    // th_presencial_de[]
	    // th_camp_pres[]
	    // th_periodo
	   
	    // HAGO UNA ITERACION
	    // $periodo_seleccionado
		
	    $numero_registros=count($_POST["th_id_curso_pres"]);

		// TENGO QUE CREAR UN REGISTRO PARA EL REPORTE DE CADA CURSO
		// CREO UN ARRAY
		// $imp_id_curso[]
		// $imp_matri_nuevas[]
		// $imp_total_cursos

		$imp_total_cursos=$numero_registros;
		for ($i=0; $i<$numero_registros; $i++)
			{
			$id_curso_pres=$_POST["th_id_curso_pres"][$i];
			$id_curso_padre=$_POST["th_presencial_de"][$i];
			$camp_importar=$_POST["th_camp_pres"][$i];
			
			$imp_id_curso[$i]=$id_curso_pres;
			$matri_nuevas=0;
			// el camp hay que evaluarlo es probable que este vacio
			if ($camp_importar!="")
			   {
				$sql_fuente="Select userid,camp,nrc,bloque from mdl_user_students where course=". $id_curso_padre ." and camp='". $camp_importar . "'";
				$res_fuente=pg_query($sql_fuente) or die('Query failed 68: ' . pg_last_error());
				// YA TENGO TODAS LAS MATRICULAS DEL CURSO FUENTE
				
				while($row=pg_fetch_array($res_fuente))
					{
					 $id_usuario=$row["userid"];
					 $nrc=$row["nrc"];
					 $bloque=$row["bloque"];
					 $camp=trim($row["camp"]);

					 /// VERIFICAR QUE EL ALUMNO NO ESTA MATRICULADO
					 $qexiste="SELECT COALESCE((SELECT 1 FROM mdl_user_students WHERE course=". $id_curso_pres ." and userid=". $id_usuario ." LIMIT 1),0) as existe";
					 $rexiste=pg_query($qexiste) or die('Query failed 80: ' . pg_last_error());
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
							$qmatri .= $id_curso_pres. "," . $id_usuario . ",". $camp. "," . $nrc. ",'". $periodo_seleccionado ."',". $bloque . ",'manual')";
							$rmatri=pg_query($qmatri) or die('Query failed 110: ' . pg_last_error());
							$matri_nuevas++;
						}//FIN DEL IF EXISTE
					} //FIN DEL WHILE
			   }//FIN DEL IF CAMP_IMPORTAR
			$imp_matri_nuevas[$i]=$matri_nuevas;
			}//FIN DEL FOR
		$accion="listar";
		}/// FIN DE ACCION=IMPORTAR

//////////////////////////// FIN IMPORTAR

	$titulo_pagina1 = "Importaci&oacute;n de Matriculas para Cursos Presenciales ";
	$titulo_pagina2 = $titulo_pagina1;
	
	print_header("$site->shortname : ". $titulo_pagina1, "X1", $titulo_pagina2, "", "", true, "");
	

	if ($accion=="listar")
		{
			/// Listar los cursos de ese periodo
			$periodo_seleccionado=$_POST["tx_periodo"];	
			$query_cp  ="Select A.id as id_curso_pres, ";
			$query_cp .="fullname,";
			$query_cp .="presencial_de,";
			$query_cp .="camp_pres,";
			$query_cp .="nombre_centro, (select count(*) from mdl_user_students C where C.course=A.id) as matriculas ";
			$query_cp .="from mdl_course A ";
			$query_cp .="left join senati_centros B on B.id_centro=A.camp_pres ";
			$query_cp .="where presencial_de is not null and periodo='". $periodo_seleccionado ."' order by presencial_de";
			$rs_cp=pg_query($query_cp) or die('Query failed 130: ' . pg_last_error());
		}

	
?>	
<strong style="color:blue">Importaci&oacute;n de Matriculas para Cursos Presenciales</strong><BR><BR>

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

<strong>Seleccione el Periodo : </strong>
<INPUT type=text value="<?PHP echo $periodo_seleccionado?>" name="tx_periodo" id="tx_periodo" size=5 maxlength=6 onkeypress="return numeros();" >
&nbsp;&nbsp;
<INPUT type=button value="Listar" onclick="listar_cursos_presenciales();">
&nbsp;&nbsp;<font color=red name="fon_rep" id="fon_rep"></font>


<div id="div_lista">
<?PHP

if ($accion=="listar")
	{
	echo "<HR>";
	echo "<table cellspacing=0 cellpadding=2 border=1 bordercolor=#efefef>";
	echo "<TR>";
	echo "<TD bgcolor=silver>";
	echo "<STRONG>N&deg;</STRONG>";
	echo "</TD>";
	echo "<TD bgcolor=silver>";
	echo "<STRONG>Id Curso</STRONG>";
	echo "</TD>";
	echo "<TD bgcolor=silver>";
	echo "<STRONG>Curso Presencial</STRONG>";
	echo "</TD>";
	echo "<TD bgcolor=silver>";
	echo "<STRONG>Id Curso Padre</STRONG>";
	echo "</TD>";
	echo "<TD bgcolor=silver>";
	echo "<STRONG>Camp Presencial</STRONG>";
	echo "</TD>";
	echo "<TD bgcolor=silver>";
	echo "<STRONG>Campus Presencial</STRONG>";
	echo "</TD>";
	echo "<TD bgcolor=silver>";
	echo "<STRONG>Matriculas</STRONG>";
	echo "</TD>";
if($mostrar_matriculas_nuevas)
	{	
		echo "<TD bgcolor=silver>";
		echo "<STRONG>Nuevas</STRONG>";
		echo "</TD>";
	}	
	echo "</TR>";
	
	$ct=0;
	while($row=pg_fetch_array($rs_cp))
		{
		$ct++;
?>		
		<TR>
		<TD align=center><?PHP echo $ct?></TD>
		<TD align=center><?PHP echo $row["id_curso_pres"]?></TD>
		<TD><?PHP echo $row["fullname"]?></TD>
		<TD align=center><?PHP echo $row["presencial_de"]?></TD>
		<TD align=center><?PHP echo $row["camp_pres"]?></TD>
		<TD ><?PHP echo $row["nombre_centro"]?></TD>
		<TD align=right><?PHP echo $row["matriculas"]?>
		<INPUT type=hidden name="th_id_curso_pres[]" value="<?PHP echo $row["id_curso_pres"]?>">
		<INPUT type=hidden name="th_presencial_de[]" value="<?PHP echo $row["presencial_de"]?>">
		<INPUT type=hidden name="th_camp_pres[]" value="<?PHP echo $row["camp_pres"]?>">
		</TD>
<?PHP		
if($mostrar_matriculas_nuevas)
	{
// itero desde 0 a $imp_total_cursos y verifico si algun $imp_id_curso es igual al $row["id_curso_pres"]
// de ahi muestro las matriculas nuevas
        $mat_new=0;
		for ($i=0; $i<$imp_total_cursos; $i++)
			{
			if ($imp_id_curso[$i]==$row["id_curso_pres"])
				{
				$mat_new=$imp_matri_nuevas[$i];
				break;
				}
			}
		
		echo "<TD align=right>";
		echo "<font color=red>". $mat_new . "</font>";
        echo "</TD>";
	}		
?>		
	</TR>
<?PHP	
		// fin del while
		}
		echo "</TABLE>";
	
	/// ACA PONGO EL BOTON PARA REALIZAR LA IMPORTACION DE MATRICULAS
	echo "<p>";
	echo "<INPUT type=button value='Importar Matriculas' onclick='importar();'>";
	echo "&nbsp;&nbsp;<font color=red name=fon_rep2 id=fon_rep2></font>";
	echo "</p>";	
		
    //fin del if ($accion=="listar")
	}

	

?>
</div>
<input type=hidden name="th_periodo" id="th_periodo" value="<?PHP echo $periodo_seleccionado?>" >
<input type=hidden name="tx_accion" id="tx_accion" value="">

</form>



<?PHP		
if($mostrar_matriculas_nuevas)
	{
	echo "<BR>Total Cursos : ". $imp_total_cursos .", " . $numero_registros . ", " . $periodo_seleccionado. "<BR>";
	// itero desde 0 a $imp_total_cursos y verifico si algun $imp_id_curso es igual al $row["id_curso_pres"]
	// de ahi muestro las matriculas nuevas
        
		for ($i=0; $i<$imp_total_cursos; $i++)
			{
			echo "ID: ". $imp_id_curso[$i] . ", Matriculas Nuevas : ". $imp_matri_nuevas[$i];
			echo "<BR>";
			
			}
	}		
?>
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


function listar_cursos_presenciales(){
	if (trim(obje("tx_periodo").value) !="")
		{
		obje("div_lista").innerHTML="";
		obje("div_lista").innerText="";
		obje("fon_rep").innerText="Espere...";
		obje("th_periodo").value=trim(obje("tx_periodo").value);
		obje("tx_accion").value="listar";
		obje("thisform").submit();
		}
}

function importar(){
	if (trim(obje("tx_periodo").value) !="")
		{
		obje("fon_rep").innerText="Espere...";
		obje("fon_rep2").innerText="Espere...";
		obje("tx_periodo").value=trim(obje("th_periodo").value);
		obje("tx_accion").value="importar";
		obje("thisform").submit();
		}
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


