<?php

include '../BD/conexion.php';


	function Lista_Anio($ano_listar){               
		$con = new Conexion();
		$ca=$con->initConnection();
        $result = mysqli_query($ca, "call SP_LISTA_CON_ANIO('$ano_listar');") or die("Query fail: " . mysqli_error());
		$data = [];
			if (mysqli_num_rows($result)>0){
				while ($row = mysqli_fetch_array($result, MYSQLI_NUM)){
                        array_push($data,array(
                        'id'=> $row[0],
                        'fullname'=> $row[1],
                        'startdate'=> $row[2],
                        'periodo'=> $row[3],
                        'subsanacion'=> $row[4],
                        'induccion'=> $row[5],
                        'presencial'=> $row[6],
                        'id_publico'=> $row[7],
                        'Inscritos'=> $row[8],
                        'numsections'=> $row[9],
                        'enrollable'=> $row[10],
                        'visible'=> $row[11],
                        'patron'=> $row[12],
                        'aprobados'=> $row[13],
                        'desaprobados'=> $row[14],
                        'retinp'=> $row[15]
					));
                }  
            }
            echo json_encode($data);
	}
	
	function ActualizarCurso($periodo,$sel_visible,$sel_patron,$sel_subsa,$sel_induccion,$sel_presencial,$sel_publico,$id_curso){               
		$con = new Conexion();
		$ca=$con->initConnection();
        $result = mysqli_query($ca, "call SP_ACTUALIZAR_CURSO_ADMIN('$periodo','$sel_visible','$sel_patron','$sel_subsa','$sel_induccion','$sel_presencial','$sel_publico','$id_curso');") or die("Query fail: " . mysqli_error());
	}
	
	$action = (strlen($_GET['action'])>0)?$_GET['action']:'';

    switch ($action) {
        case 'ListarA':
			$ano_listar = (strlen($_GET['ano_listar'])>0)?$_GET['ano_listar']:'';
			Lista_Anio($ano_listar);
        break;
		case 'ActualizarCAdmin':
			$periodo = (strlen($_POST['periodo'])>0)?$_POST['periodo']:'';
			$sel_visible = (strlen($_POST['sel_visible'])>0)?$_POST['sel_visible']:'';
			$sel_patron = (strlen($_POST['sel_patron'])>0)?$_POST['sel_patron']:'';
			$sel_subsa = (strlen($_POST['sel_subsa'])>0)?$_POST['sel_subsa']:'';
			$sel_induccion = (strlen($_POST['sel_induccion'])>0)?$_POST['sel_induccion']:'';
			$sel_presencial = (strlen($_POST['sel_presencial'])>0)?$_POST['sel_presencial']:'';
			$sel_publico = (strlen($_POST['sel_publico'])>0)?$_POST['sel_publico']:'';
			$id_curso = (strlen($_POST['id_curso'])>0)?$_POST['id_curso']:'';
            ActualizarCurso($periodo,$sel_visible,$sel_patron,$sel_subsa,$sel_induccion,$sel_presencial,$sel_publico,$id_curso);
        break;
		
		
    }
?>	