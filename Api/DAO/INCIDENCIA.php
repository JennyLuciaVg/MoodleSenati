<?php

include '../BD/conexion.php';

	function Lista_Incidencias($Id_incidencia){               
		$con = new Conexion();
		$ca=$con->initConnection();
        $result = mysqli_query($ca, "call SP_INCIDENCIAS('$Id_incidencia');") or die("Query fail: " . mysqli_error());
		$data = [];
			if (mysqli_num_rows($result)>0){
				while ($row = mysqli_fetch_array($result, MYSQLI_NUM)){
                        array_push($data,array(				
                        'id_alumno'=> $row[0],
                        'incidencia'=> $row[1],
                        'fecha_leida'=> $row[2]
					));
                }  
            }
            echo json_encode($data);
	
	}
	
	function Lista_Curso($id_curso){               
		$con = new Conexion();
		$ca=$con->initConnection();
        $result = mysqli_query($ca, "call SP_INCIDENCIAS_DEL CURSO('$id_curso');") or die("Query fail: " . mysqli_error());
		$data = [];
			if (mysqli_num_rows($result)>0){
				while ($row = mysqli_fetch_array($result, MYSQLI_NUM)){
                        array_push($data,array(
                        'fechax'=> $row[0],
                        'id_inc'=> $row[1],
                        'id_tutor'=> $row[2],
                        'id_alu'=> $row[3],
                        'id_curso'=> $row[4],
                        'incidencia'=> $row[5],
                        'fecha'=> $row[6],
                        'alumno'=> $row[7],
                        'tutor'=> $row[8]
					));
                }  
            }
            echo json_encode($data);
	}
	
	function Insertar_Incidencias($id_tutorx,$id_alumnox,$id_cursox,$incidencia){               
		$con = new Conexion();
		$ca=$con->initConnection();
        $result = mysqli_query($ca, "call SP_INCIDENCIAS_INSET('$id_tutorx','$id_alumnox','$id_cursox','$incidencia');") or die("Query fail: " . mysqli_error());
	}
	
	function Lista_Alumnos($id_curso){               
		$con = new Conexion();
		$ca=$con->initConnection();
        $result = mysqli_query($ca, "call SP_INCIDENCIAS_LISTA_ALUMNOS('$id_curso');") or die("Query fail: " . mysqli_error());
		$data = [];
			if (mysqli_num_rows($result)>0){
				while ($row = mysqli_fetch_array($result, MYSQLI_NUM)){
                        array_push($data,array(
                        'userid'=> $row[0],
                        'firstname'=> $row[1],
                        'lastname'=> $row[2],
                        'email'=> $row[3],
                        'pidm_banner'=> $row[4],
					));
                }  
            }
            echo json_encode($data);
	}
	
	function Lista_Nombre_Moodle($id_curso){               
		$con = new Conexion();
		$ca=$con->initConnection();
        $result = mysqli_query($ca, "call SP_INCIDENCIAS_NOMBRE_MODDLE('$id_curso');") or die("Query fail: " . mysqli_error());
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
	
	function Listar_Nombre_Usuario($id_usuario){               
		$con = new Conexion();
		$ca=$con->initConnection();
        $result = mysqli_query($ca, "call SP_INCIDENCIAS_NOMBRE_USUARIO('$id_usuario');") or die("Query fail: " . mysqli_error());
		$data = [];
			if (mysqli_num_rows($result)>0){
				while ($row = mysqli_fetch_array($result, MYSQLI_NUM)){
                        array_push($data,array(
                        'firstname'=> $row[0],
                        'lastname'=> $row[1]
					));
                }  
            }
            echo json_encode($data);
	}
	
	function Lista_Id_Inc($id_alumnox,$id_tutorx,$id_cursox){               
		$con = new Conexion();
		$ca=$con->initConnection();
        $result = mysqli_query($ca, "call SP_INCIDENCIAS_NUMERO('$id_alumnox','$id_tutorx','$id_cursox');") or die("Query fail: " . mysqli_error());
		$data = [];
			if (mysqli_num_rows($result)>0){
				while ($row = mysqli_fetch_array($result, MYSQLI_NUM)){
                        array_push($data,array(
                        'idx'=> $row[0]
					));
                }  
            }
            echo json_encode($data);
	}
	
	function Update_Incidencias($d_tutorx,$id_alumnox,$id_cursox,$incidencia){               
		$con = new Conexion();
		$ca=$con->initConnection();
        $result = mysqli_query($ca, "call SP_INCIDENCIAS_UPDATE('$d_tutorx','$id_alumnox','$id_cursox','$incidencia');") or die("Query fail: " . mysqli_error());
	}
	
	$action = (strlen($_GET['action'])>0)?$_GET['action']:'';

    switch ($action) {
        case 'ListaIncidencia':
			$Id_incidencia = (strlen($_GET['Id_incidencia'])>0)?$_GET['Id_incidencia']:''; 
			Lista_Incidencias($Id_incidencia);
        break;
		case 'ListaCurso':
			$id_curso = (strlen($_GET['id_curso'])>0)?$_GET['id_curso']:''; 
			Lista_Curso($id_curso);
        break;
		case 'InsertIncidencia':
			 $id_tutorx = (strlen($_POST['id_tutorx'])>0)?$_POST['id_tutorx']:''; 
			 $id_alumnox = (strlen($_POST['id_alumnox'])>0)?$_POST['id_alumnox']:''; 
			 $id_cursox = (strlen($_POST['id_cursox'])>0)?$_POST['id_cursox']:''; 
			 $incidencia = (strlen($_POST['incidencia'])>0)?$_POST['incidencia']:''; 
			 Insertar_Incidencias($id_tutorx,$id_alumnox,$id_cursox,$incidencia);
        break;
		case 'ListaAlumno': 
			$id_curso = (strlen($_GET['id_curso'])>0)?$_GET['id_curso']:''; 
			Lista_Alumnos($id_curso);
        break;
		case 'ListaNombreMoodle': 
			$id_curso = (strlen($_GET['id_curso'])>0)?$_GET['id_curso']:''; 
			Lista_Nombre_Moodle($id_curso);
        break;
		case 'ListarNombreUsuario': 
			$id_usuario = (strlen($_GET['id_usuario'])>0)?$_GET['id_usuario']:''; 
			Listar_Nombre_Usuario($id_usuario);
        break;
		case 'ListaIdInc': 
			$id_alumnox = (strlen($_GET['id_alumnox'])>0)?$_GET['id_alumnox']:''; 
			$id_tutorx = (strlen($_GET['id_tutorx'])>0)?$_GET['id_tutorx']:''; 
			$id_cursox = (strlen($_GET['id_cursox'])>0)?$_GET['id_cursox']:''; 
			 Lista_Id_Inc($id_alumnox,$id_tutorx,$id_cursox);
        break;
		case 'UpdateIncidencias': 
			$d_tutorx = (strlen($_POST['d_tutorx'])>0)?$_POST['d_tutorx']:''; 
			$id_alumnox = (strlen($_POST['id_alumnox'])>0)?$_POST['id_alumnox']:''; 
			$id_cursox = (strlen($_POST['id_cursox'])>0)?$_POST['id_cursox']:''; 
			$incidencia = (strlen($_POST['incidencia'])>0)?$_POST['incidencia']:''; 
			Update_Incidencias($d_tutorx,$id_alumnox,$id_cursox,$incidencia)
        break;
    }
?>	