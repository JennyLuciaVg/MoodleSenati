<?php

include '../BD/conexion.php';

 	function GetCampus($camp,$nombre_centro,$carr,$carrera,$total_alu,$id_cursox){               
		$con = new Conexion();
		$ca=$con->initConnection();
    $result = mysqli_query($ca, "call SP_REPORTE_EVIDENCIAS_ALUMNOS_CAMPUS
 		('$camp','$nombre_centro','$carr','$carrera','$total_alu','$id_cursox');") or die("Query fail: " . mysqli_error());
		$data = [];
			if (mysqli_num_rows($result)>0){
				while ($row = mysqli_fetch_array($result, MYSQLI_NUM)){
                               array_push($data,array(
                               	'camp'=> $row[0],     
                               	'nombre_centro'=> $row[1], 
                               	'carr'=> $row[2],                             
                               	'carrera'=> $row[3], 
                               	'total_alu'=> $row[4],
                                'id_cursox'=> $row[5] 

							   ));
                  }    
            }
               echo json_encode($data);
	}

  function GetLista($userid,$firstname,$lastname,$camp,$nombre_centro,$carr,$grupo,$id_cursox){               
    $con = new Conexion();
    $ca=$con->initConnection();
        $result = mysqli_query($ca, "call SP_REPORTE_EVIDENCIAS_LISTA
   ('$userid','$firstname','$lastname','$camp','$nombre_centro','$carr','$grupo','$id_cursox');") or die("Query fail: " . mysqli_error());
    $data = [];
      if (mysqli_num_rows($result)>0){
        while ($row = mysqli_fetch_array($result, MYSQLI_NUM)){
                               array_push($data,array(
                                'userid'=> $row[0],     
                                'firstname'=> $row[1], 
                                'lastname'=> $row[2],                            
                                'camp'=> $row[3], 
                                'nombre_centro'=> $row[4], 
                                'carr'=> $row[5],
                                'grupo'=> $row[6],
                                'id_cursox'=> $row[7] 
                                
                 ));
                  }    
            }
               echo json_encode($data);
  }

   function GetCurso($fullname,$id_cursox){               
    $con = new Conexion();
    $ca=$con->initConnection();
    $result = mysqli_query($ca, "SP_REPORTE_EVIDENCIAS_NOMBRE_CURSO
    ('$fullname','$id_cursox');") or die("Query fail: " . mysqli_error());
    $data = [];
      if (mysqli_num_rows($result)>0){
        while ($row = mysqli_fetch_array($result, MYSQLI_NUM)){
                               array_push($data,array(
                                'fullname'=> $row[0],
                                'id_cursox'=> $row[1]      
                                                 
                 ));
                  }    
            }
               echo json_encode($data);
  }

   function GetGrupos($existe,$id_cursox){               
    $con = new Conexion();
    $ca=$con->initConnection();
    $result = mysqli_query($ca, "SP_REPORTE_EVIDENCIAS_VERIFICO_TIENE_GRUPOS
    ('$existe','$id_cursox');") or die("Query fail: " . mysqli_error());
    $data = [];
      if (mysqli_num_rows($result)>0){
        while ($row = mysqli_fetch_array($result, MYSQLI_NUM)){
                               array_push($data,array(
                                'existe'=> $row[0],
                                'id_cursox'=> $row[1]      
                                
                                
                 ));
                  }    
            }
               echo json_encode($data);
  }

    function GetPonderaciones($existe,$id_cursox){               
    $con = new Conexion();
    $ca=$con->initConnection();
    $result = mysqli_query($ca, "SP_REPORTE_EVIDENCIAS_VERIFICO_TIENE_PONDERACIONES
    ('$existe','$id_cursox');") or die("Query fail: " . mysqli_error());
    $data = [];
      if (mysqli_num_rows($result)>0){
        while ($row = mysqli_fetch_array($result, MYSQLI_NUM)){
                               array_push($data,array(
                                'existe'=> $row[0],
                                '$id_cursox'=>%row[1]     
                 ));
                  }    
            }
               echo json_encode($data);
  }





	                
            $action = (strlen($_GET['action'])>0)?$_GET['action']:'';

            switch ($action) {
            	case 'list1':
            	$camp = (strlen($_GET['camp'])>0)?$_GET['camp']:'';
      			 	$nombre_centro = (strlen($_GET['nombre_centro'])>0)?$_GET['nombre_centro']:'';
      			 	$carr = (strlen($_GET['carr'])>0)?$_GET['carr']:'';
      				$carrera = (strlen($_GET['carrera'])>0)?$_GET['carrera']:'';
      				$total_alu = (strlen($_GET['total_alu'])>0)?$_GET['total_alu']:'';

      				$id_cursox = (strlen($_GET['id_cursox'])>0)?$_GET['id_cursox']:'';			 	

            	GetCampus($camp,$nombre_centro,$carr,$carrera,$total_alu,$id_cursox);        	
            		# code...
            		break;

              case 'list2':
              $userid = (strlen($_GET['userid'])>0)?$_GET['userid']:'';
              $firstname = (strlen($_GET['firstname'])>0)?$_GET['firstname']:'';
              $lastname = (strlen($_GET['lastname'])>0)?$_GET['lastname']:'';
              $camp = (strlen($_GET['camp'])>0)?$_GET['camp']:'';
              $nombre_centro = (strlen($_GET['nombre_centro'])>0)?$_GET['nombre_centro']:'';
              $carr = (strlen($_GET['carr'])>0)?$_GET['carr']:'';
              $grupo = (strlen($_GET['grupo'])>0)?$_GET['grupo']:'';

              $id_cursox = (strlen($_GET['id_cursox'])>0)?$_GET['id_cursox']:'';

              GetLista($userid,$firstname,$lastname,$camp,$nombre_centro,$carr,$grupo,$id_cursox);
                # code...
                break;

               case 'list3':
              $fullname = (strlen($_GET['fullname'])>0)?$_GET['fullname']:'';

              $id_cursox = (strlen($_GET['id_cursox'])>0)?$_GET['id_cursox']:'';

              GetCurso($fullname,$id_cursox);
                # code...
                break;

                case 'list4':
              $existe = (strlen($_GET['existe'])>0)?$_GET['existe']:'';

              $id_cursox = (strlen($_GET['id_cursox'])>0)?$_GET['id_cursox']:'';

              GetGrupos($existe,$id_cursox);
                # code...
                break;

                default:
              $existe = (strlen($_GET['existe'])>0)?$_GET['existe']:'';
               $id_curso = (strlen($_GET['id_curso'])>0)?$_GET['id_curso']:'';

              $id_cursox = (strlen($_GET['id_cursox'])>0)?$_GET['id_cursox']:'';

              GetPonderaciones($existe,$id_cursox);

                # code...
                break;




    }
                           
		
?>	