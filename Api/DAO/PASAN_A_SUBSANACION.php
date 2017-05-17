<?php

include '../BD/conexion.php';

 	function GetForos($id_foro,$discuss,$id_userx,$post,$rating,$peso_recurso,$id_cursox){               
		$con = new Conexion();
		$ca=$con->initConnection();
    $result = mysqli_query($ca, "call SP_SUBSANACION_FOROS
 		('$id_foro','$discuss','$id_userx','$post','$rating','$peso_recurso','$post','$id_cursox');") or die("Query fail: " . mysqli_error());
		$data = [];
			if (mysqli_num_rows($result)>0){
				while ($row = mysqli_fetch_array($result, MYSQLI_NUM)){
                               array_push($data,array(
                                'id_foro'=> $row[0],
                                'discuss'=> $row[1],
                                'userid'=> $row[2],
                                'post'=> $row[3],
                                'rating'=> $row[4],
                                'peso_recurso'=> $row[5]
                                
							   ));
                  }    
            }
               echo json_encode($data);
	}





     function GetDistinc($id,$scale,$peso_recurso,$id_cursox){               
    $con = new Conexion();
    $ca=$con->initConnection();
    $result = mysqli_query($ca, "call SP_SUBSANACION_FOROS_DISTINC
    ('$id','$scale','$peso_recurso','$id_cursox');") or die("Query fail: " . mysqli_error());
    $data = [];
      if (mysqli_num_rows($result)>0){
        while ($row = mysqli_fetch_array($result, MYSQLI_NUM)){
                               array_push($data,array(
                                'id'=> $row[0],
                                'scale'=> $row[1],
                                'peso_recurso'=> $row[1],
                               
                                                    
                 ));
                  }    
            }
               echo json_encode($data);
  }


    function UpdateEstudiantes($id_curso_sub,$camp,$nrc,$periodo,$bloque, $manual,$id_user_sv,$last_id_enrol){               
    $con = new Conexion();
    $ca=$con->initConnection();
        $result = mysqli_query($ca, "call SP_SUBSANACION_INSERTAR_ESTUDIANTES('$id_curso_sub,$camp,$nrc,$periodo,$bloque, $manual,$id_user_sv,$last_id_enrol');") or die("Query fail: " . mysqli_error());
    
          
  }



   
     function GetList($id,$Grade,$nota_maxima,$peso_recurso,$numfiles,$id_link,$assignmenttype,$id_userx,$id_cursox){               
    $con = new Conexion();
    $ca=$con->initConnection();
    $result = mysqli_query($ca, "call SP_SUBSANACION_FOROS_DISTINC
    ('$id','$Grade','$nota_maxima','$peso_recurso','$numfiles','$id_link','$assignmenttype','$id_userx','id_cursox');") or die("Query fail: " . mysqli_error());
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
    

     function GetCurso($userid,$firstname,$lastname,$camp,$nombre_centro,$nrc,$pidm_banner,$periodo,$id_cursox){               
    $con = new Conexion();
    $ca=$con->initConnection();
    $result = mysqli_query($ca, "call SP_SUBSANACION_LISTAR_CURSO
    ('$userid','$firstname','$lastname','$camp','$nombre_centro','$nrc','$pidm_banner','$periodo','$id_cursox');") or die("Query fail: " . mysqli_error());
    $data = [];
      if (mysqli_num_rows($result)>0){
        while ($row = mysqli_fetch_array($result, MYSQLI_NUM)){
                               array_push($data,array(
                                'userid'=> $row[0],
                                'firstname'=> $row[1],
                                'lastname'=> $row[2],
                                'camp'=> $row[3],
                                'nombre_centro'=> $row[4],
                                'nrc'=> $row[5],
                                'pidm_banner'=> $row[6],
                                'periodo'=> $row[7]       
                                                    
                 ));
                  }    
            }
               echo json_encode($data);
  }
 



     function GetSubsanacions($fullname,$subsanacion,$id_publico,$presencial,$id_cursox){               
    $con = new Conexion();
    $ca=$con->initConnection();
    $result = mysqli_query($ca, "call SP_SUBSANACION_LISTAR_CURSO
    ('$fullname','$subsanacion','$id_publico','$presencial','$id_cursox');") or die("Query fail: " . mysqli_error());
    $data = [];
      if (mysqli_num_rows($result)>0){
        while ($row = mysqli_fetch_array($result, MYSQLI_NUM)){
                               array_push($data,array(
                                'userid'=> $row[0],
                                'firstname'=> $row[1],
                                'lastname'=> $row[2],
                                'camp'=> $row[3],
                                'nombre_centro'=> $row[4],
                                'nrc'=> $row[5],
                                'pidm_banner'=> $row[6],
                                'periodo'=> $row[7]       
                                                    
                 ));
                  }    
            }
               echo json_encode($data);
  }



    function GetQuiz($id,$nota_grade,$nota_maxima,$peso_recurso,$id_userx,$id_cursox){               
    $con = new Conexion();
    $ca=$con->initConnection();
    $result = mysqli_query($ca, "call SP_SUBSANACION_QUIZ
    ('$id','$nota_grade','$nota_maxima','$peso_recurso','$id_userx','$id_cursox');") or die("Query fail: " . mysqli_error());
    $data = [];
      if (mysqli_num_rows($result)>0){
        while ($row = mysqli_fetch_array($result, MYSQLI_NUM)){
                               array_push($data,array(
                                'userid'=> $row[0],
                                'nota_grade'=> $row[1],
                                'nota_maxima'=> $row[2],
                                'peso_recurso'=> $row[3]
                                  
                                                    
                 ));
                  }    
            }
               echo json_encode($data);
  

    }

    function GetPerformings($id,$peso_recurso,$name,$id_cursox){               
    $con = new Conexion();
    $ca=$con->initConnection();
    $result = mysqli_query($ca, "call SP_SUBSANACION_QUIZ_PERFORMING
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

      function GetPerformingsSQL($id,$assignmenttype,$peso_recurso,$name,$id_cursox){               
    $con = new Conexion();
    $ca=$con->initConnection();
    $result = mysqli_query($ca, "call SP_SUBSANACION_QUIZ_PERFORMING_SQL
    ('$id','$assignmenttype','$peso_recurso','$name','$id_cursox');") or die("Query fail: " . mysqli_error());
    $data = [];
      if (mysqli_num_rows($result)>0){
        while ($row = mysqli_fetch_array($result, MYSQLI_NUM)){
                               array_push($data,array(
                                'id'=> $row[0],
                                'assignmenttype'=> $row[1],
                                'peso_recurso'=> $row[2],
                                'name'=> $row[3]
                                                                
                 ));
                  }    
            }
               echo json_encode($data);

    }




        function UpdateEstudiante($camp,$nrc,$periodo,$bloque,$id_curso_sub,$id_user_sv){               
    $con = new Conexion();
    $ca=$con->initConnection();
        $result = mysqli_query($ca, "call SP_SUBSANACION_INSERTAR_ESTUDIANTES('$camp','$nrc','$periodo','$bloque','$id_curso_sub','$id_user_sv');") or die("Query fail: " . mysqli_error());
    
          
  }

      

        function GetExiste($existe,$id_curso_sub,$id_user_sv){               
    $con = new Conexion();
    $ca=$con->initConnection();
    $result = mysqli_query($ca, "call SP_SUBSANACION_VALIDAR_EXISTE
    ('$existe','$id_curso_sub','$id_user_sv');") or die("Query fail: " . mysqli_error());
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

     function GetPonderacion($tiene_pond,$id_cursox){               
    $con = new Conexion();
    $ca=$con->initConnection();
    $result = mysqli_query($ca, "call SP_SUBSANACION_VERIFICO_PONDERACIONES
    ('$tiene_pond','$id_cursox');") or die("Query fail: " . mysqli_error());
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
              $id_foro = (strlen($_GET['id_foro'])>0)?$_GET['id_foro']:'';
              $discuss = (strlen($_GET['discuss'])>0)?$_GET['discuss']:'';
              $id_foro = (strlen($_GET['id_foro'])>0)?$_GET['id_foro']:'';
              $id_userx = (strlen($_GET['id_userx'])>0)?$_GET['id_userx']:'';
              $post = (strlen($_GET['post'])>0)?$_GET['post']:'';
              $rating = (strlen($_GET['rating'])>0)?$_GET['rating']:'';
              $peso_recurso = (strlen($_GET['peso_recursoo'])>0)?$_GET['peso_recurso']:'';
              $id_cursox = (strlen($_GET['id_foro'])>0)?$_GET['id_foro']:'';
                   
              GetForos($id_foro,$discuss,$id_userx,$post,$rating,$peso_recurso,$id_cursox);       
                # code...
                break;

              case 'list2':
              $id = (strlen($_GET['id'])>0)?$_GET['id']:'';
              $scale = (strlen($_GET['scale'])>0)?$_GET['scale']:'';
              $peso_recurso = (strlen($_GET['peso_recurso'])>0)?$_GET['peso_recurso']:'';
              $id_cursox = (strlen($_GET['id_cursox '])>0)?$_GET['id_cursox']:'';
                   
              GetDistinc($id,$scale,$peso_recurso,$id_cursox);       
                # code...
                break;

              case 'Update3':
              $id_curso_sub = (strlen($_GET['id_curso_sub'])>0)?$_GET['id_curso_sub']:'';
              $camp = (strlen($_GET['camp'])>0)?$_GET['camp']:'';
              $nrc = (strlen($_GET['nrc'])>0)?$_GET['nrc']:'';
              $periodo = (strlen($_GET['periodo'])>0)?$_GET['periodo']:'';
              $bloque = (strlen($_GET['bloque'])>0)?$_GET['bloque']:'';
              $manual = (strlen($_GET['manual'])>0)?$_GET['manual']:'';
              $id_user_sv = (strlen($_GET['id_user_sv'])>0)?$_GET['id_user_sv']:'';
              $last_id_enrol = (strlen($_GET['last_id_enrol'])>0)?$_GET['last_id_enrol']:'';
                   
              UpdateEstudiantes($id_curso_sub,$camp,$nrc,$periodo,$bloque,$manual,$id_user_sv,$last_id_enrol);       
                # code...
                break;


              case 'list4':
              $id = (strlen($_GET['id'])>0)?$_GET['id']:'';
              $Grade = (strlen($_GET['Grade'])>0)?$_GET['Grade']:'';
              $nota_maxima = (strlen($_GET['nota_maxima'])>0)?$_GET['nota_maxima']:'';
              $peso_recurso = (strlen($_GET['peso_recurso'])>0)?$_GET['peso_recurso']:'';
              $numfiles = (strlen($_GET['numfiles'])>0)?$_GET['numfilese']:'';
              $id_link = (strlen($_GET['id_link'])>0)?$_GET['id_link']:'';
              $assignmenttype = (strlen($_GET['assignmenttype'])>0)?$_GET['assignmenttype']:'';
              $id_userx = (strlen($_GET['id_userx'])>0)?$_GET['id_userx']:'';
              $id_cursox = (strlen($_GET['id_cursox'])>0)?$_GET['id_cursox']:'';
                   
             GetList($id,$Grade,$nota_maxima,$peso_recurso,$numfiles,$id_link,$assignmenttype,$id_userx,$id_cursox)      
                # code...
                break;

              case 'list5':
              $userid = (strlen($_GET['userid'])>0)?$_GET['userid']:'';
              $firstname = (strlen($_GET['firstname'])>0)?$_GET['firstname']:'';
              $lastname = (strlen($_GET['lastname'])>0)?$_GET['lastname']:'';
              $camp = (strlen($_GET['camp'])>0)?$_GET['camp']:'';
              $nombre_centro = (strlen($_GET['nombre_centro'])>0)?$_GET['nombre_centro']:'';
              $nrc= (strlen($_GET['nrc'])>0)?$_GET['inrc']:'';
              $pidm_banner = (strlen($_GET['pidm_banner'])>0)?$_GET['pidm_banner']:'';
              $periodo = (strlen($_GET['periodo'])>0)?$_GET['periodo']:'';
              $id_cursox = (strlen($_GET['id_cursox'])>0)?$_GET['id_cursox']:'';
                   
             GetCurso($userid,$firstname,$lastname,$camp,$nombre_centro,$nrc,$pidm_banner,$periodo,$id_cursox) ;    
                # code...
                break;


                
              case 'list6':
              $fullname = (strlen($_GET['fullname'])>0)?$_GET['fullname']:'';
              $subsanacion = (strlen($_GET['subsanacion'])>0)?$_GET['subsanacion']:'';
              $id_publico = (strlen($_GET['id_publico'])>0)?$_GET['id_publico']:'';
              $presencial = (strlen($_GET['presencial'])>0)?$_GET['presencial']:'';
               $id_cursox = (strlen($_GET['id_cursox'])>0)?$_GET['id_cursox']:'';
              
              GetSubsanacions($fullname,$subsanacion,$id_publico,$presencial,$id_cursox) ;    
                # code...
                break;



              case 'list7':
              $id = (strlen($_GET['id'])>0)?$_GET['id']:'';
              $nota_grade = (strlen($_GET['nota_grade'])>0)?$_GET['nota_grade']:'';
              $nota_maxima = (strlen($_GET['nota_maxima'])>0)?$_GET['nota_maxima']:'';
              $peso_recurso = (strlen($_GET['peso_recurso'])>0)?$_GET['peso_recurso']:'';
              $id_userx = (strlen($_GET['id_userx'])>0)?$_GET['id_userx']:'';
              $id_cursox = (strlen($_GET['id_cursox'])>0)?$_GET['id_cursox']:'';
              
              GetQuiz($id,$nota_grade,$nota_maxima,$peso_recurso,$id_userx,$id_cursox)
               ;    
                # code...
                break;



                 case 'list8':
              $id = (strlen($_GET['id'])>0)?$_GET['id']:'';             
              $peso_recurso = (strlen($_GET['peso_recurso'])>0)?$_GET['peso_recurso']:'';
              $name = (strlen($_GET['name'])>0)?$_GET['name']:'';
              $id_cursox = (strlen($_GET['id_cursox'])>0)?$_GET['id_cursox']:'';
              
              GetPerformings($id,$peso_recurso,$name,$id_cursox)
               ;    
                # code...
                break;

               
                 
                case 'list9':
              $id = (strlen($_GET['id'])>0)?$_GET['id']:''; 
              $assignmenttype = (strlen($_GET['assignmenttype'])>0)?$_GET['assignmenttype']:''; 
              $peso_recurso = (strlen($_GET['peso_recurso'])>0)?$_GET['peso_recurso']:'';
              $name = (strlen($_GET['name'])>0)?$_GET['name']:'';
              $id_cursox = (strlen($_GET['id_cursox'])>0)?$_GET['id_cursox']:'';
              
              GetPerformingsSQL($id,$assignmenttype,$peso_recurso,$name,$id_cursox)
               ;    
                # code...
                break;



              case 'list10':
              $camp = (strlen($_GET['camp'])>0)?$_GET['camp']:''; 
              $nrc = (strlen($_GET['nrc'])>0)?$_GET['nrc']:''; 
              $periodo = (strlen($_GET['periodo'])>0)?$_GET['periodo']:'';
              $bloque = (strlen($_GET['bloque'])>0)?$_GET['bloque']:'';
              $id_curso_sub = (strlen($_GET['id_curso_sub'])>0)?$_GET['id_curso_sub']:'';
              $id_user_sv = (strlen($_GET['id_user_sv'])>0)?$_GET['id_user_sv']:'';


              UpdateEstudiante($camp,$nrc,$periodo,$bloque,$id_curso_sub,$id_user_sv);    
                # code...
                break;


              case 'list10':
              $existe = (strlen($_GET['camp'])>0)?$_GET['camp']:''; 
              $id_curso_sub = (strlen($_GET['id_curso_sub'])>0)?$_GET['id_curso_sub']:'';
              $id_user_sv = (strlen($_GET['id_user_sv'])>0)?$_GET['id_user_sv']:'';

              GetExiste($existe,$id_curso_sub,$id_user_sv);    
                # code...
                break;


                 case 'list10':
              $tiene_pond = (strlen($_GET['tiene_pond'])>0)?$_GET['tiene_pond']:''; 
              $id_cursox = (strlen($_GET['id_cursox'])>0)?$_GET['id_cursox']:'';
             

               GetPonderacion($tiene_pond,$id_cursox);    
                # code...
                break;


               

    }
                           
    
?>
