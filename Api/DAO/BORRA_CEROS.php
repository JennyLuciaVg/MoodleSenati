<?php

include '../BD/conexion.php';


	function Eliminar_Intento($id_intento){               
		$con = new Conexion();
		$ca=$con->initConnection();
        $result = mysqli_query($ca, "call SP_BORRA_CEROS_ELIMINAR_INTENTO('$id_intento');") or die("Query fail: " . mysqli_error());
	}
	
	function Inser_Tabla_Log($id_user,$id_alux,$id_intento,$id_cursox,$id_quix){               
		$con = new Conexion();
		$ca=$con->initConnection();
        $result = mysqli_query($ca, "call SP_BORRA_CEROS_INSERTAR_TABLA_LOG('$id_user','id_alux','$id_intento','$id_cursox','$id_quix');") or die("Query fail: " . mysqli_error());
	}
	
	function Borra_Cero_Lista($id_cursox){               
		$con = new Conexion();
		$ca=$con->initConnection();
        $result = mysqli_query($ca, "call SP_BORRA_CEROS_LISTA('$id_cursox');") or die("Query fail: " . mysqli_error());
		$data = [];
			if (mysqli_num_rows($result)>0){
				while ($row = mysqli_fetch_array($result, MYSQLI_NUM)){
                        array_push($data,array(
                        'id'=> $row[0],
                        'quiz'=> $row[1],
                        'userid'=> $row[2],
                        'attempt'=> $row[3],
                        'uniqueid'=> $row[4],
                        'layout'=> $row[5],
                        'currentpage'=> $row[6],
                        'preview'=> $row[7],
                        'state'=> $row[8],
                        'timestart'=> $row[9],
                        'timefinish'=> $row[10],
                        'timemodified'=> $row[11],
                        'timemodifiedoffline'=> $row[12],
                        'timecheckstate'=> $row[13],
                        'sumgrades'=> $row[14],
                        'alumno'=> $row[15],
                        'id_alumno'=> $row[16],
                        'nombre_quiz'=> $row[17]                        
					));
                }  
            }
            echo json_encode($data);
	}
	
	function Cero_Lista_Quizes($id_cursox){               
		$con = new Conexion();
		$ca=$con->initConnection();
        $result = mysqli_query($ca, "call SP_BORRA_CEROS_LISTA_QUIZES('$id_cursox');") or die("Query fail: " . mysqli_error());
		$data = [];
			if (mysqli_num_rows($result)>0){
				while ($row = mysqli_fetch_array($result, MYSQLI_NUM)){
                        array_push($data,array(
                        'id'=> $row[0],
                        'name'=> $row[1],
                        'timeopen'=> $row[2],
                        'timeclose'=> $row[3],
                        'timelimit'=> $row[4],
                        'section'=> $row[5],
                        'instance'=> $row[6],
                        'visible'=> $row[7],
                        'unidad_visible'=> $row[8],
                        'id_module'=> $row[9]                     
					));
                }  
            }
            echo json_encode($data);
	}
	
	function Nombre_Curso($id_cursox){               
		$con = new Conexion();
		$ca=$con->initConnection();
        $result = mysqli_query($ca, "call SP_BORRA_CEROS_NOMBRE_CURSO('$id_cursox');") or die("Query fail: " . mysqli_error());
		$data = [];
			if (mysqli_num_rows($result)>0){
				while ($row = mysqli_fetch_array($result, MYSQLI_NUM)){
                        array_push($data,array(
                        'fullname'=> $row[0]
                                          
					));
                }  
            }
            echo json_encode($data);
	}
	
	
	
	$action = (strlen($_GET['action'])>0)?$_GET['action']:'';

    switch ($action) {
        case 'EliminarIntento':
			$id_intento = (strlen($_GET['id_intento'])>0)?$_GET['id_intento']:''; 
			Eliminar_Intento($id_intento);
        break;
		case 'InsertarLog':
			$id_user = (strlen($_POST['id_user'])>0)?$_POST['id_user']:'';
			$id_alux = (strlen($_POST['id_alux'])>0)?$_POST['id_alux']:'';
			$id_intento = (strlen($_POST['id_intento'])>0)?$_POST['id_intento']:'';
			$id_cursox = (strlen($_POST['id_cursox'])>0)?$_POST['id_cursox']:'';
			$id_quix = (strlen($_POST['id_quix'])>0)?$_POST['id_quix']:'';
			Inser_Tabla_Log($id_user,$id_alux,$id_intento,$id_cursox,$id_quix);
        break;
		case 'BorraCeroLista':
			$id_cursox = (strlen($_GET['id_cursox'])>0)?$_GET['id_cursox']:'';
			Borra_Cero_Lista($id_cursox);
		break;
		case 'CeroListaQuizes':
			$id_cursox = (strlen($_GET['id_cursox'])>0)?$_GET['id_cursox']:'';
            Cero_Lista_Quizes($id_cursox);
        break;
		case 'NombreCurso':
			$id_cursox = (strlen($_GET['id_cursox'])>0)?$_GET['id_cursox']:'';
            Nombre_Curso($id_cursox);
        break;
		
    }
?>	