<?php

include '../BD/conexion.php';

 	function GetAgre($id_tarea,$id_user_sv,$notaq){               
		$con = new Conexion();
		$ca=$con->initConnection();
		$result = mysqli_query($ca, "call SP_PROMEDIOS_PRESENCIALES_EVALUA_AGRE('$id_tarea','$id_user_sv','$notaq');") or die("Query fail: " . mysqli_error());
	
	}
	
	function GetUp($id_tarea,$id_user_sv,$notaq){               
		$con = new Conexion();
		$ca=$con->initConnection();
		$result = mysqli_query($ca, "call SP_PROMEDIOS_PRESENCIALES_EVALUA_UP('$id_tarea','$id_user_sv','$notaq');") or die("Query fail: " . mysqli_error());
	
	}

    function GetActa($existe_acta,$id_curso_moodle){               
    $con = new Conexion();
    $ca=$con->initConnection();
    $result = mysqli_query($ca, "call SP_R_P_EXISTE_ACTA
    ('$existe_acta','$id_curso_moodle');") or die("Query fail: " . mysqli_error());
    $data = [];
      if (mysqli_num_rows($result)>0){
        while ($row = mysqli_fetch_array($result, MYSQLI_NUM)){
                               array_push($data,array(
                                'existe_acta'=> $row[0]                   
                 ));
                  }    
            }
               echo json_encode($data);
  }



       function GetTarea($id_tarea1_pres,$cursox){               
    $con = new Conexion();
    $ca=$con->initConnection();
    $result = mysqli_query($ca, "call SP_PROMEDIOS_PRESENCIALES_LEO_TAREA
    ('$id_tarea1_pres','$cursox');") or die("Query fail: " . mysqli_error());
    $data = [];
      if (mysqli_num_rows($result)>0){
        while ($row = mysqli_fetch_array($result, MYSQLI_NUM)){
                               array_push($data,array(
                                'id_tarea1_pres'=> $row[0],
                                                    
                 ));
                  }    
            }
               echo json_encode($data);
  }


     function GetListar($userid,$firstname,$lastname,$camp,$nombre_centro,$bloque,$nrc,$pidm_banner,$status_sinfo,$id_cursox){               
    $con = new Conexion();
    $ca=$con->initConnection();
    $result = mysqli_query($ca, "call SP_PROMEDIOS_PRESENCIALES_LISTAR
    ('$userid','$firstname','$lastname','$camp','$nombre_centro','$bloque','$nrc','$pidm_banner','$status_sinfo','$id_cursox');") or die("Query fail: " . mysqli_error());
    $data = [];
      if (mysqli_num_rows($result)>0){
        while ($row = mysqli_fetch_array($result, MYSQLI_NUM)){
                               array_push($data,array(
                                'userid'=> $row[0],
                                'firstname'=> $row[1],
                                'lastname'=> $row[2],
                                'camp'=> $row[3],
                                'nombre_centro'=> $row[4],
                                'bloque'=> $row[5],
                                'nrc'=> $row[6],
                                'pidm_banner'=> $row[7],
                                'status_sinfo'=> $row[8]
                                                    
                 ));
                  }    
            }
               echo json_encode($data);
  }

     function GetTable3($id,$grade,$id_userx,$id_cursox){               
    $con = new Conexion();
    $ca=$con->initConnection();
    $result = mysqli_query($ca, "call SP_PROMEDIOS_PRESENCIALES_LISTAR_TABLE_3
    ('$id','$grade','$id_userx','$id_cursox');") or die("Query fail: " . mysqli_error());
    $data = [];
      if (mysqli_num_rows($result)>0){
        while ($row = mysqli_fetch_array($result, MYSQLI_NUM)){
                               array_push($data,array(
                                'id'=> $row[0],
                                'grade'=> $row[1]
                               
                                                    
                 ));
                  }    
            }
               echo json_encode($data);
  }

    function GetPerforming($id,$peso_recurso,$name,$id_cursox){               
    $con = new Conexion();
    $ca=$con->initConnection();
    $result = mysqli_query($ca, "call SP_PROMEDIOS_PRESENCIALES_SQL_PERFORMING
    ('$id','$peso_recurso','$name','$id_cursox');") or die("Query fail: " . mysqli_error());
    $data = [];
      if (mysqli_num_rows($result)>0){
        while ($row = mysqli_fetch_array($result, MYSQLI_NUM)){
                               array_push($data,array(
                                'id'=> $row[0],
                                'peso_recurso'=> $row[1],
                                'name'=> $row[2]
                               
                                                    
                 ));
                  }    
            }
               echo json_encode($data);
  }
    
    function GetPonderaciones($tiene_pond,$id_cursox){               
    $con = new Conexion();
    $ca=$con->initConnection();
    $result = mysqli_query($ca, "call SP_PROMEDIOS_PRESENCIALES_VERIFICO_PONDERACIONES
    ('$tiene_pond,$id_cursox');") or die("Query fail: " . mysqli_error());
    $data = [];
      if (mysqli_num_rows($result)>0){
        while ($row = mysqli_fetch_array($result, MYSQLI_NUM)){
                               array_push($data,array(
                                'tiene_pond'=> $row[0]
                                                                
                 ));
                  }    
            }
               echo json_encode($data);
  }


   $action = (strlen($_GET['action'])>0)?$_GET['action']:'';

            switch ($action) {
			  	
              case 'list1':
              $id_matricula = (strlen($_GET['id_matricula'])>0)?$_GET['id_matricula']:'';
                   
              GetMatriculados($id_matricula);         
                # code...
                break;

              case 'list2':
              $existe_acta= (strlen($_GET['existe_acta'])>0)?$_GET['existe_acta']:'';
              $id_curso_moodle= (strlen($_GET['id_curso_moodle'])>0)?$_GET['id_curso_moodle']:'';
                   
              GetActa($existe_acta,$id_curso_moodle);         
                # code...
                break;


              case 'list3':
              $id_tarea1_pres = (strlen($_GET['id_tarea1_pres'])>0)?$_GET['id_tarea1_pres']:'';
              $cursox = (strlen($_GET['cursox'])>0)?$_GET['cursox']:'';
              
                   
              GetTarea($id_tarea1_pres,$cursox);         
                # code...
                break;

              case 'list4':
              $userid = (strlen($_GET['userid'])>0)?$_GET['userid']:'';
              $firstname = (strlen($_GET['firstname'])>0)?$_GET['firstname']:'';
              $lastname= (strlen($_GET['lastname'])>0)?$_GET['lastname']:'';
              $camp= (strlen($_GET['camp'])>0)?$_GET['icamp']:'';
              $nombre_centro = (strlen($_GET['nombre_centro'])>0)?$_GET['nombre_centro']:'';
              $bloque = (strlen($_GET['bloque'])>0)?$_GET['bloque']:'';
              $nrc = (strlen($_GET['nrc'])>0)?$_GET['nrc']:'';
              $pidm_banner = (strlen($_GET['pidm_banner'])>0)?$_GET['pidm_banner']:'';
              $status_sinfo = (strlen($_GET['status_sinfo'])>0)?$_GET['status_sinfo']:'';
                   
               GetListar($userid,$firstname,$lastname,$camp,$nombre_centro,$bloque,$nrc,$pidm_banner,$status_sinfo,$id_cursox);         
                # code...
                break;
                
               case 'list5':
              $id = (strlen($_GET['id'])>0)?$_GET['id']:'';
              $grade = (strlen($_GET['grade'])>0)?$_GET['grade']:'';
              $id_userx = (strlen($_GET['lastname'])>0)?$_GET['lastname']:'';
              $id_cursox = (strlen($_GET['id_cursox'])>0)?$_GET['id_cursox']:'';
             
                   
              GetTable3($id,$grade,$id_userx,$id_cursox);         
                # code...
                break;
            
              case 'list6':
              $id = (strlen($_GET['id'])>0)?$_GET['id']:'';
              $peso_recurso = (strlen($_GET['peso_recurso'])>0)?$_GET['peso_recurso']:'';
              $name = (strlen($_GET['name'])>0)?$_GET['name']:'';
              $id_cursox = (strlen($_GET['id_cursox'])>0)?$_GET['id_cursox']:'';
             
                   
              GetPerforming($id,$peso_recurso,$name,$id_cursox);         
                # code...
                break;

                 case 'list6':
              $tiene_pond = (strlen($_GET['tiene_pond'])>0)?$_GET['tiene_pond']:'';
              $id_cursox = (strlen($_GET['id_cursox'])>0)?$_GET['id_cursox']:'';
            
                   
                GetPonderaciones($tiene_pond,$id_cursox);         
                # code...
                break;




    }
                           
    
?>
