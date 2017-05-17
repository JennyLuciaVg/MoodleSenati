<?php

include '../BD/conexion.php';


  
  function GetCuestionarion($id,$name,$id_cursox){               
    $con = new Conexion();
    $ca=$con->initConnection();
        $result = mysqli_query($ca, "call SP_NOTAS_PRESENCIALES_GET_CUESTIONARION
          ('$id','$name','$id_cursox');") or die("Query fail: " . mysqli_error());
    $data = [];
      if (mysqli_num_rows($result)>0){
        while ($row = mysqli_fetch_array($result, MYSQLI_NUM)){
                               array_push($data,array(
                                'id'=> $row[0],
                                'name'=> $row[1]                                 
                 
                 ));
                  }
                 
            }
               echo json_encode($data);
  }





  function GetCuestionarion($fullname,$subsanacion,$induccion,$presencial,$id_tarea1_pres,$id_tarea2_pres,$presencial_de,$Id_Curso){               
    $con = new Conexion();
    $ca=$con->initConnection();
        $result = mysqli_query($ca, "call SP_NOTAS_PRESENCIALES_GET_CURSO
          ('$fullname','$subsanacion','$induccion','$presencial','$id_tarea1_pres','$id_tarea2_pres','$presencial_de','Id_Curso');") or die("Query fail: " . mysqli_error());
    $data = [];
      if (mysqli_num_rows($result)>0){
        while ($row = mysqli_fetch_array($result, MYSQLI_NUM)){
                               array_push($data,array(
                                'fullname'=> $row[0],
                                'subsanacion'=> $row[1],
                                'induccion'=> $row[2],
                                'presencial'=> $row[3],
                                'id_tarea1_pres'=> $row[4],                                 
                                'id_tarea2_pres'=> $row[5],
                                'presencial_de'=> $row[6]
                               
                 
                 ));
                  }
                 
            }
               echo json_encode($data);
  }




  function GetForo($id,$scale,$peso_recurso,$id_cursox){               
    $con = new Conexion();
    $ca=$con->initConnection();
        $result = mysqli_query($ca, "call SP_NOTAS_PRESENCIALES_GET_FOROS
          ('$id','$scale','$peso_recurso','$id_cursox');") or die("Query fail: " . mysqli_error());
    $data = [];
      if (mysqli_num_rows($result)>0){
        while ($row = mysqli_fetch_array($result, MYSQLI_NUM)){
                               array_push($data,array(
                                'fullname'=> $row[0],
                                'subsanacion'=> $row[1]
                                            
                 ));
                  }
                 
            }
               echo json_encode($data);
  }

     function GetForo2($id_foro,$discuss,$id_userx,$post,$rating,$peso_recurso,$id_cursox){               
    $con = new Conexion();
    $ca=$con->initConnection();
        $result = mysqli_query($ca, "call SP_NOTAS_PRESENCIALES_GET_FOROS2
          ('$id_foro','$discuss','$id_userx','$post','$rating','$peso_recurso','$id_cursox');") or die("Query fail: " . mysqli_error());
    $data = [];
      if (mysqli_num_rows($result)>0){
        while ($row = mysqli_fetch_array($result, MYSQLI_NUM)){
                               array_push($data,array(
                                'id_foro'=> $row[0],
                                'discuss'=> $row[1],
                                'id_userx'=> $row[2],
                                'post'=> $row[3],
                                'rating'=> $row[4],
                                'peso_recurso'=> $row[5]
                                            
                 ));
                  }
                 
            }
               echo json_encode($data);
  }



      function GetMaxima($id,$nota_grade,$nota_maxima,$id_userx,$id_cursox){               
    $con = new Conexion();
    $ca=$con->initConnection();
        $result = mysqli_query($ca, "call SP_NOTAS_PRESENCIALES_GET_NOTA_MAXIMA
          ('$id,$nota_grade,$nota_maxima','$id_userx','$id_cursox');") or die("Query fail: " . mysqli_error());
    $data = [];
      if (mysqli_num_rows($result)>0){    
        while ($row = mysqli_fetch_array($result, MYSQLI_NUM)){
                               array_push($data,array(
                                'id'=> $row[0],
                                'nota_grade'=> $row[1],
                                'nota_maxima'=> $row[2]
                                
                                            
                 ));
                  }
                 
            }
               echo json_encode($data);
  }


      function GetTable1($userid,$firstname,$lastname,$camp,$nombre_centro,$bloque,$status_sinfo,$email,$pidm_banner,$id_cursox){               
    $con = new Conexion();
    $ca=$con->initConnection();
        $result = mysqli_query($ca, "call SP_NOTAS_PRESENCIALES_GET_TABLE1
          ('$userid','$firstname',$lastname','$camp','$nombre_centro','$bloque','$status_sinfo',$email,$pidm_banner,$id_cursox');") or die("Query fail: " . mysqli_error());
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
                                'status_sinfo'=> $row[6],
                                'email'=> $row[7],
                                'pidm_banner'=> $row[8]
                                
                                            
                 ));
                  }
                 
            }
               echo json_encode($data);
  }


      function GetAssignment($id,$Grade,$nota_maxima,$peso_recurso,$numfiles,$id_link,$assignmenttype,$id_userx,$id_cursox);{               
    $con = new Conexion();
    $ca=$con->initConnection();
        $result = mysqli_query($ca, "call SP_NOTAS_PRESENCIALES_LISTA_ASSIGNMENT
          ('$id','$Grade','$nota_maxima','$peso_recurso','$numfiles','$id_link','$assignmenttype','$id_userx','$id_cursox');") or die("Query fail: " . mysqli_error());
    $data = [];
      if (mysqli_num_rows($result)>0){    
        while ($row = mysqli_fetch_array($result, MYSQLI_NUM)){
                               array_push($data,array(
                                'id'=> $row[0],
                                'Grade'=> $row[1],
                                'nota_maxima'=> $row[2],
                                'peso_recurso'=> $row[3],
                                'numfiles'=> $row[4],
                                'id_link'=> $row[5],
                                'assignmenttype'=> $row[6]
                                
                                            
                 ));
                  }
                 
            }
               echo json_encode($data);
  }


         function GetTutores($nombre,$email,$id_cursox);{               
    $con = new Conexion();
    $ca=$con->initConnection();
        $result = mysqli_query($ca, "call SP_NOTAS_PRESENCIALES_LISTA_TUTORES
          ('$nombre','$email','id_cursox');") or die("Query fail: " . mysqli_error());
    $data = [];
      if (mysqli_num_rows($result)>0){    
        while ($row = mysqli_fetch_array($result, MYSQLI_NUM)){
                               array_push($data,array(
                                'nombre'=> $row[0],
                                'email'=> $row[1]
                                            
                 ));
                  }
                 
            }
               echo json_encode($data);
  }



                  
            $action = (strlen($_GET['action'])>0)?$_GET['action']:'';

            switch ($action) {
            
              case 'list1':
              $id = (strlen($_GET['id'])>0)?$_GET['id']:'';
              $name = (strlen($_GET['name'])>0)?$_GET['name']:'';
              $id_cursox = (strlen($_GET['id_cursox'])>0)?$_GET['id_cursox']:'';
             
              GetData($id,$name,$id_cursox);          
                # code...
                break;


                case 'list2':
              $fullname = (strlen($_GET['fullname'])>0)?$_GET['fullname']:'';
              $subsanacion = (strlen($_GET['subsanacion'])>0)?$_GET['subsanacion']:'';
              $induccion = (strlen($_GET['induccion'])>0)?$_GET['induccion']:'';
              $presencial = (strlen($_GET['presencial'])>0)?$_GET['presencial']:'';
              $id_tarea1_pres = (strlen($_GET['id_tarea1_pres'])>0)?$_GET['id_tarea1_pres']:'';
              $id_tarea2_pres = (strlen($_GET['id_tarea2_pres'])>0)?$_GET['id_tarea2_pres']:'';
              $presencial_de = (strlen($_GET['presencial_de'])>0)?$_GET['presencial_de']:'';
              $Id_Curso = (strlen($_GET['Id_Curso'])>0)?$_GET['Id_Curso']:'';

             
              
              GetCuestionarion($fullname,$subsanacion,$induccion,$presencial,$id_tarea1_pres,$id_tarea2_pres,$presencial_de,$Id_Curso);          
                # code...
                break;


              case 'list3':
              $id = (strlen($_GET['id'])>0)?$_GET['id']:'';
              $scale = (strlen($_GET['scale'])>0)?$_GET['scale']:'';
              $peso_recurso = (strlen($_GET['peso_recurso'])>0)?$_GET['peso_recurso']:'';
              $id_cursox = (strlen($_GET['id_cursox'])>0)?$_GET['id_cursox']:'';
                  
             GetForo($id,$scale,$peso_recurso,$id_cursox);
      
                # code...
                break;

              case 'list4':
              $id_foro = (strlen($_GET['id_foro'])>0)?$_GET['id_foro']:'';
              $discuss = (strlen($_GET['discuss'])>0)?$_GET['scale']:'';
              $id_userx = (strlen($_GET['id_userx'])>0)?$_GET['id_userx']:'';
              $post = (strlen($_GET['post'])>0)?$_GET['post']:'';
              $rating = (strlen($_GET['rating'])>0)?$_GET['rating']:'';
              $peso_recurso = (strlen($_GET['peso_recurso'])>0)?$_GET['peso_recurso']:'';
              $id_cursox = (strlen($_GET['id_cursox'])>0)?$_GET['id_cursox']:'';
    
             
                GetForo2($id_foro,$discuss,$id_userx,$post,$rating,$peso_recurso,$id_cursox);
      
                # code...
                break;


                
              case 'list5':
              $id = (strlen($_GET['id'])>0)?$_GET['id']:'';
              $nota_grade = (strlen($_GET['nota_grade'])>0)?$_GET['nota_grade']:'';
              $nota_maxima = (strlen($_GET['nota_maxima'])>0)?$_GET['nota_maxima']:'';
              $id_userx = (strlen($_GET['id_userx'])>0)?$_GET['id_userx']:'';
              $id_cursox = (strlen($_GET['id_cursox'])>0)?$_GET['id_cursox']:'';
    
             
                GetMaxima($id,$nota_grade,$nota_maxima,$id_userx,$id_cursox);
      
                # code...
                break;
           
              case 'list6':
              $userid = (strlen($_GET['userid'])>0)?$_GET['userid']:'';
              $firstname = (strlen($_GET['firstname'])>0)?$_GET['firstname']:'';
              $lastname = (strlen($_GET['lastname'])>0)?$_GET['lastname']:'';
              $camp = (strlen($_GET['camp'])>0)?$_GET['camp']:'';
              $nombre_centro = (strlen($_GET['nombre_centro'])>0)?$_GET['nombre_centro']:'';
              $bloque = (strlen($_GET['bloque'])>0)?$_GET['bloque']:'';
              $status_sinfo = (strlen($_GET['status_sinfo'])>0)?$_GET['status_sinfo']:'';
              $email = (strlen($_GET['email'])>0)?$_GET['email']:'';
              $pidm_banner = (strlen($_GET['pidm_banner'])>0)?$_GET['pidm_banner']:'';
    
             
                 GetTable1($userid,$firstname,$lastname,$camp,$nombre_centro,$bloque,$status_sinfo,$email,$pidm_banner,$id_cursox);
      
                # code...
                break;
            
              case 'list7':
              $id = (strlen($_GET['id'])>0)?$_GET['id']:'';
              $Grade = (strlen($_GET['Grade'])>0)?$_GET['Grade']:'';
              $nota_maxima = (strlen($_GET['nota_maxima'])>0)?$_GET['nota_maxima']:'';
              $peso_recurso = (strlen($_GET['peso_recurso'])>0)?$_GET['peso_recurso']:'';
              $numfiles = (strlen($_GET['numfiles'])>0)?$_GET['numfiles']:'';
              $id_link = (strlen($_GET['id_link'])>0)?$_GET['id_link']:'';
              $assignmenttype = (strlen($_GET['assignmenttype'])>0)?$_GET['assignmenttype']:'';
              $email = (strlen($_GET['email'])>0)?$_GET['email']:'';
              $pidm_banner = (strlen($_GET['pidm_banner'])>0)?$_GET['pidm_banner']:'';
              $id_userx = (strlen($_GET['id_userx'])>0)?$_GET['id_userx']:'';
              $id_cursox = (strlen($_GET['id_cursox'])>0)?$_GET['id_cursox']:'';
             
                GetAssignment($id,$Grade,$nota_maxima,$peso_recurso,$numfiles,$id_link,$assignmenttype,$id_userx,$id_cursox);
      
                # code...
                break;
            
              case 'list8':
              $nombre = (strlen($_GET['nombre'])>0)?$_GET['nombre']:'';
              $email = (strlen($_GET['email'])>0)?$_GET['email']:'';
              $id_cursox = (strlen($_GET['id_cursox'])>0)?$_GET['id_cursox']:'';
             
                  GetAssignment($nombre,$email,$id_cursox)
      
                # code...
                break;







            
            
             
    }
                           
    
?>  