<?php

include '../BD/conexion.php';

	function Actualizar_PrimerPost($id_new_post,$id_new_discussion){               
		$con = new Conexion();
		$ca=$con->initConnection();
        $result = mysqli_query($ca, "call SP_FOROS_ACTUALIZAR_PRIMERPOST('$id_new_post','$id_new_discussion');") or die("Query fail: " . mysqli_error());
	}
	
	function BY_ID($Id_curso_moodle){               
		$con = new Conexion();
		$ca=$con->initConnection();
        $result = mysqli_query($ca, "call SP_FOROS_BYID('$Id_curso_moodle');") or die("Query fail: " . mysqli_error());
		$data = [];
			if (mysqli_num_rows($result)>0){
				while ($row = mysqli_fetch_array($result, MYSQLI_NUM)){
                        array_push($data,array(
                        'id_tutor'=> $row[0],                 
                        'firstname'=> $row[1],                 
                        'lastname'=> $row[2]               
					));
                }  
            }
            echo json_encode($data);
	}
	
	function BY_ID_GENERAL($id_curso_moodle){               
		$con = new Conexion();
		$ca=$con->initConnection();
        $result = mysqli_query($ca, "call SP_FOROS_BYID_GENERAL('$id_curso_moodle');") or die("Query fail: " . mysqli_error());
		$data = [];
			if (mysqli_num_rows($result)>0){
				while ($row = mysqli_fetch_array($result, MYSQLI_NUM)){
                        array_push($data,array(
                        'id_foro'=> $row[0],                 
                        'name'=> $row[1],                 
                        'unidad'=> $row[2]             
					));
                }  
            }
            echo json_encode($data);
	}
	
	function BY_ID_Curso_Moodle($id_curso_moodle,$id_tutorg){               
		$con = new Conexion();
		$ca=$con->initConnection();
        $result = mysqli_query($ca, "call SP_FOROS_BYIDCURSOMODDLE('$id_curso_moodle','$id_tutorg');") or die("Query fail: " . mysqli_error());
		$data = [];
			if (mysqli_num_rows($result)>0){
				while ($row = mysqli_fetch_array($result, MYSQLI_NUM)){
                        array_push($data,array(
                        'nombre_grupo'=> $row[0],                 
                        'id_grupo'=> $row[1]           
					));
                }  
            }
            echo json_encode($data);
	}
	
	function BY_ID_Foro($id_patron,$id_forox){               
		$con = new Conexion();
		$ca=$con->initConnection();
        $result = mysqli_query($ca, "call SP_FOROS_BYIDFORO('$id_patron','$id_forox');") or die("Query fail: " . mysqli_error());
		$data = [];
			if (mysqli_num_rows($result)>0){
				while ($row = mysqli_fetch_array($result, MYSQLI_NUM)){
                        array_push($data,array(
                        'id_post'=> $row[0],                 
                        'name'=> $row[1]             
					));
                }  
            }
            echo json_encode($data);
	}
	
	function BY_ID_Grupo($id_curso_moodle,$id_grupo){               
		$con = new Conexion();
		$ca=$con->initConnection();
        $result = mysqli_query($ca, "call SP_FOROS_BYIDTUTOR_IDGRUPO('$id_curso_moodle','$id_grupo');") or die("Query fail: " . mysqli_error());
		$data = [];
			if (mysqli_num_rows($result)>0){
				while ($row = mysqli_fetch_array($result, MYSQLI_NUM)){
                        array_push($data,array(
                        'total_foros'=> $row[0],                 
                        'unidad'=> $row[1],             
                        'id_foro'=> $row[2]          
					));
                }  
            }
            echo json_encode($data);
	}
	
	
	function Existe($id_curso_moodle){               
		$con = new Conexion();
		$ca=$con->initConnection();
        $result = mysqli_query($ca, "call SP_FOROS_EXISTE('$id_curso_moodle');") or die("Query fail: " . mysqli_error());
		$data = [];
			if (mysqli_num_rows($result)>0){
				while ($row = mysqli_fetch_array($result, MYSQLI_NUM)){
                        array_push($data,array(
                        'existe'=> $row[0]          
					));
                }  
            }
            echo json_encode($data);
	}
	
	
	function Datos_Importar($id_postix){               
		$con = new Conexion();
		$ca=$con->initConnection();
        $result = mysqli_query($ca, "call SP_FOROS_EXTRAER_DATOS_A_IMPORTAR('$id_postix');") or die("Query fail: " . mysqli_error());
		$data = [];
			if (mysqli_num_rows($result)>0){
				while ($row = mysqli_fetch_array($result, MYSQLI_NUM)){
                        array_push($data,array(
                        'subject'=> $row[0],                 
                        'message '=> $row[1]             
					));
                }  
            }
            echo json_encode($data);
	}
	
	function Id_Genero($id_forox,$name_forox,$id_tutorx,$id_grupox,$fecha_actual){               
		$con = new Conexion();
		$ca=$con->initConnection();
        $result = mysqli_query($ca, "call SP_FOROS_ID_GENERO('$id_forox','$name_forox','$id_tutorx','$id_grupox','$fecha_actual');") or die("Query fail: " . mysqli_error());
		$data = [];
			if (mysqli_num_rows($result)>0){
				while ($row = mysqli_fetch_array($result, MYSQLI_NUM)){
                        array_push($data,array(
                        'id'=> $row[0]            
					));
                }  
            }
            echo json_encode($data);
	}
	
	function Patron_Semilla($id_curso_moodle){               
		$con = new Conexion();
		$ca=$con->initConnection();
        $result = mysqli_query($ca, "call SP_FOROS_ID_PATRON_SEMILLA('$id_curso_moodle');") or die("Query fail: " . mysqli_error());
		$data = [];
			if (mysqli_num_rows($result)>0){
				while ($row = mysqli_fetch_array($result, MYSQLI_NUM)){
                        array_push($data,array(
                        'id_patron_semilla'=> $row[0]  
					));
                }  
            }
            echo json_encode($data);
	}
	
	function Insertar_Forum($Id_forox,$name_forox,$id_tutorx,$id_grupox,$fecha_actual,$id_cursox){               
		$con = new Conexion();
		$ca=$con->initConnection();
        $result = mysqli_query($ca, "call SP_FOROS_IDENTIFICAR_ID_FORO('$Id_forox','$name_forox','$id_tutorx','$id_grupox','$fecha_actual','$id_cursox');") or die("Query fail: " . mysqli_error());
	}
	
	function Insertar_Post($id_new_discussion,$name_forox,$id_tutorx,$datax,$fecha_actual){               
		$con = new Conexion();
		$ca=$con->initConnection();
        $result = mysqli_query($ca, "call SP_FOROS_INSERT_POST('$id_new_discussion','$name_forox','$id_tutorx','$datax','$fecha_actual');") or die("Query fail: " . mysqli_error());	
	}
	
	function Listar_Fotos_Grupo($id_patron){               
		$con = new Conexion();
		$ca=$con->initConnection();
        $result = mysqli_query($ca, "call SP_FOROS_LISTAR_FOTOS_GRUPO('$id_patron');") or die("Query fail: " . mysqli_error());
		$data = [];
			if (mysqli_num_rows($result)>0){
				while ($row = mysqli_fetch_array($result, MYSQLI_NUM)){
                        array_push($data,array(
                        'nombre_foro'=> $row[0],                 
                        'id_foro '=> $row[1],             
                        'unidad '=> $row[2]             
					));
                }  
            }
            echo json_encode($data);
	}
	
	function Grupo_Existe($id_curso_moodle){               
		$con = new Conexion();
		$ca=$con->initConnection();
        $result = mysqli_query($ca, "call SP_FOROS_LISTAR_GRUPO_EXIST('$id_curso_moodle');") or die("Query fail: " . mysqli_error());
		$data = [];
			if (mysqli_num_rows($result)>0){
				while ($row = mysqli_fetch_array($result, MYSQLI_NUM)){
                        array_push($data,array(
                        'nombre_foro'=> $row[0],                 
                        'id_foro '=> $row[1],             
                        'unidad '=> $row[2]             
					));
                }  
            }
            echo json_encode($data);
	}
	
	function Tema_Cero_Tutores($id_curso_moodle,$id_foro){               
		$con = new Conexion();
		$ca=$con->initConnection();
        $result = mysqli_query($ca, "call SP_FOROS_TEMA_CERO_TUTORES('$id_curso_moodle','$id_foro');") or die("Query fail: " . mysqli_error());
		$data = [];
			if (mysqli_num_rows($result)>0){
				while ($row = mysqli_fetch_array($result, MYSQLI_NUM)){
                        array_push($data,array(
                        'id_discussion'=> $row[0],                 
                        'name_discussion'=> $row[1],             
                        'id_tutor'=> $row[2],             
                        'id_grupo'=> $row[3],             
                        'firstname'=> $row[4],             
                        'lastname'=> $row[5],             
                        'message'=> $row[6],             
                        'id_post'=> $row[7]             
					));
                }  
            }
            echo json_encode($data);
	}
	
	function Verificar_Id_Generado($id_new_discussion,$name_forox,$id_tutorx,$fecha_actual){               
		$con = new Conexion();
		$ca=$con->initConnection();
        $result = mysqli_query($ca, "call SP_FOROS_VERIFICAR_ID_GENERADO('$id_new_discussion','$name_forox','$id_tutorx','$fecha_actual');") or die("Query fail: " . mysqli_error());
		$data = [];
			if (mysqli_num_rows($result)>0){
				while ($row = mysqli_fetch_array($result, MYSQLI_NUM)){
                        array_push($data,array(
                        'id'=> $row[0]                 
					));
                }  
            }
            echo json_encode($data);
	}
	

	
	function Lista_Datos_Curso($id_forox,$name_forox,$id_tutorx,$id_grupox,$fecha_hora_actual_integer){               
		$con = new Conexion();
		$ca=$con->initConnection();
        $result = mysqli_query($ca, "call SP_VERFICAR_ID_GENERO('$id_forox','$name_forox','$id_tutorx','$id_grupox','$fecha_hora_actual_integer');") or die("Query fail: " . mysqli_error());
		$data = [];
			if (mysqli_num_rows($result)>0){
				while ($row = mysqli_fetch_array($result, MYSQLI_NUM)){
                        array_push($data,array(
                        'id'=> $row[0]                  
					));
                }  
            }
            echo json_encode($data);
	}
	
	
	$action = (strlen($_GET['action'])>0)?$_GET['action']:'';

    switch ($action) {
        case 'ActuPrimerPost':
			$id_new_post = (strlen($_GET['id_new_post'])>0)?$_GET['id_new_post']:''; 
			$id_new_discussion = (strlen($_GET['id_new_discussion'])>0)?$_GET['id_new_discussion']:'';
			Actualizar_PrimerPost($id_new_post,$id_new_discussion);
        break;
		case 'BYID':
			$id_curso_moodle = (strlen($_GET['id_curso_moodle'])>0)?$_GET['id_curso_moodle']:'';  
			BY_ID($Id_curso_moodle)
        break;
		case 'IDGENERAL':
			$id_curso_moodle = (strlen($_GET['id_curso_moodle'])>0)?$_GET['id_curso_moodle']:'';
			BY_ID_GENERAL($id_curso_moodle);
		break;
		 case 'CursoMoodle':
			$id_curso_moodle = (strlen($_GET['id_curso_moodle'])>0)?$_GET['id_curso_moodle']:''; 
			$id_tutorg = (strlen($_GET['id_tutorg'])>0)?$_GET['id_tutorg']:''; 
			BY_ID_Curso_Moodle($id_curso_moodle,$id_tutorg);
        break;
		case 'IDForo':
			$id_patron = (strlen($_GET['id_patron'])>0)?$_GET['id_patron']:''; 
			$id_forox = (strlen($_GET['id_forox'])>0)?$_GET['id_forox']:''; 
			BY_ID_Foro($id_patron,$id_forox);
        break;
		case 'IDGrupo':
			$id_curso_moodle = (strlen($_GET['id_curso_moodle'])>0)?$_GET['id_curso_moodle']:''; 
			$id_grupo = (strlen($_GET['id_grupo'])>0)?$_GET['id_grupo']:''; 
			BY_ID_Grupo($id_curso_moodle,$id_grupo)
        break;
		case 'Existes':
			$id_curso_moodle = (strlen($_GET['id_curso_moodle'])>0)?$_GET['id_curso_moodle']:''; 
			Existe($id_curso_moodle);
        break;
		case 'DatosImportar':
			$id_postix = (strlen($_GET['id_postix'])>0)?$_GET['id_postix']:''; 
			Datos_Importar($id_postix);
        break;
		case 'IdGenero':
			$id_forox = (strlen($_GET['id_forox'])>0)?$_GET['id_forox']:''; 
			$name_forox = (strlen($_GET['name_forox'])>0)?$_GET['name_forox']:''; 
			$id_tutorx = (strlen($_GET['id_tutorx'])>0)?$_GET['id_tutorx']:''; 
			$id_grupox = (strlen($_GET['id_grupox'])>0)?$_GET['id_grupox']:''; 
			$fecha_actual = (strlen($_GET['fecha_actual'])>0)?$_GET['fecha_actual']:''; 
			Id_Genero($id_forox,$name_forox,$id_tutorx,$id_grupox,$fecha_actual);
        break;
		case 'PatronSemilla':
			$id_curso_moodle = (strlen($_GET['id_curso_moodle'])>0)?$_GET['id_curso_moodle']:''; 
			Patron_Semilla($id_curso_moodle);
        break;
		case 'InsertarForum':
			$Id_forox = (strlen($_POST['Id_forox'])>0)?$_POST['Id_forox']:''; 
			$name_forox = (strlen($_POST['name_forox'])>0)?$_POST['name_forox']:''; 
			$id_tutorx = (strlen($_POST['id_tutorx'])>0)?$_POST['id_tutorx']:''; 
			$id_grupox = (strlen($_POST['id_grupox'])>0)?$_POST['id_grupox']:''; 
			$fecha_actual = (strlen($_POST['fecha_actual'])>0)?$_POST['fecha_actual']:''; 
			$id_cursox = (strlen($_POST['id_cursox'])>0)?$_POST['id_cursox']:''; 
			Insertar_Forum($Id_forox,$name_forox,$id_tutorx,$id_grupox,$fecha_actual,$id_cursox);
        break;
		case 'InsertarPost':
			$id_new_discussion = (strlen($_POST['id_new_discussion'])>0)?$_POST['id_new_discussion']:''; 
			$name_forox = (strlen($_POST['name_forox'])>0)?$_POST['name_forox']:''; 
			$id_tutorx = (strlen($_POST['id_tutorx'])>0)?$_POST['id_tutorx']:''; 
			$datax = (strlen($_POST['datax'])>0)?$_POST['datax']:''; 
			$fecha_actual = (strlen($_POST['fecha_actual'])>0)?$_POST['fecha_actual']:''; 
			Insertar_Post($id_new_discussion,$name_forox,$id_tutorx,$datax,$fecha_actual);
        break;
		case 'FotosGrupo':
			$id_patron = (strlen($_GET['id_patron'])>0)?$_GET['id_patron']:'';
			Listar_Fotos_Grupo($id_patron);
        break;
		case 'GrupoExiste':
			$id_curso_moodle = (strlen($_GET['id_curso_moodle'])>0)?$_GET['id_curso_moodle']:''; 
			Grupo_Existe($id_curso_moodle);
        break;
		case 'CeroTutores':
			$id_curso_moodle = (strlen($_GET['id_curso_moodle'])>0)?$_GET['id_curso_moodle']:''; 
			$id_foro = (strlen($_GET['id_foro'])>0)?$_GET['id_foro']:''; 
			Tema_Cero_Tutores($id_curso_moodle,$id_foro);
        break;
		case 'VerificarIdGenerado':
			$id_new_discussion = (strlen($_GET['id_new_discussion'])>0)?$_GET['id_new_discussion']:''; 
			$name_forox = (strlen($_GET['name_forox'])>0)?$_GET['name_forox']:''; 
			$id_tutorx = (strlen($_GET['id_tutorx'])>0)?$_GET['id_tutorx']:''; 
			$fecha_actual = (strlen($_GET['fecha_actual'])>0)?$_GET['fecha_actual']:''; 
			Verificar_Id_Generado($id_new_discussion,$name_forox,$id_tutorx,$fecha_actual);
        break;
		case 'NombreCentro':
			$id_forox = (strlen($_GET['id_forox'])>0)?$_GET['id_forox']:''; 
			$name_forox = (strlen($_GET['name_forox'])>0)?$_GET['name_forox']:''; 
			$id_tutorx = (strlen($_GET['id_tutorx'])>0)?$_GET['id_tutorx']:''; 
			$id_grupox = (strlen($_GET['id_grupox'])>0)?$_GET['id_grupox']:''; 
			$fecha_hora_actual_integer = (strlen($_GET['fecha_hora_actual_integer'])>0)?$_GET['fecha_hora_actual_integer']:''; 
			Lista_Datos_Curso($id_forox,$name_forox,$id_tutorx,$id_grupox,$fecha_hora_actual_integer);
        break;
    }
?>	