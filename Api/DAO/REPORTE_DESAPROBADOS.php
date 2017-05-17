<?php

include '../BD/conexion.php';

 	function GetEstudiantes($userid,$firstname,$lastname,$camp,$nombre_centro,$bloque,$nrc,$pidm_banner,$id_cursox){               
		$con = new Conexion();
		$ca=$con->initConnection();
    $result = mysqli_query($ca, "call SP_REPORTES_DESAPROBADOS_ESTUDIANTES
 		('$userid','$firstname','$lastname','$camp','$nombre_centro','$bloque','$nrc','$pidm_banner','$id_cursox');") or die("Query fail: " . mysqli_error());
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
                                'pidm_banner'=> $row[7]
                                
							   ));
                  }    
            }
               echo json_encode($data);
	}

    function GetForo($id,$scale,$peso_recurso,$id_cursox){               
    $con = new Conexion();
    $ca=$con->initConnection();
    $result = mysqli_query($ca, "call SP_REPORTES_DESAPROBADOS_FORO
    ('$id','$scale','$peso_recurso','$id_cursox');") or die("Query fail: " . mysqli_error());
    $data = [];
      if (mysqli_num_rows($result)>0){
        while ($row = mysqli_fetch_array($result, MYSQLI_NUM)){
                               array_push($data,array(
                                'id'=> $row[0],     
                                'scale'=> $row[1], 
                                'peso_recurso'=> $row[2]                           
                                
                                
                 ));
                  }    
            }
               echo json_encode($data);
  }


    function GetForos($id_foro,$discuss,$id_userx,$post,$rating,$peso_recurso,$id_cursox){               
    $con = new Conexion();
    $ca=$con->initConnection();
    $result = mysqli_query($ca, "call SP_REPORTES_DESAPROBADOS_FOROS
    ('$id_foro','$discuss','$id_userx','$post','$rating','$peso_recurso','$id_cursox');") or die("Query fail: " . mysqli_error());
    $data = [];
      if (mysqli_num_rows($result)>0){
        while ($row = mysqli_fetch_array($result, MYSQLI_NUM)){
                               array_push($data,array(
                                'id_foro'=> $row[0],     
                                'discuss'=> $row[1], 
                                'id_userx'=> $row[2],  
                                'post'=> $row[3] , 
                                'rating'=> $row[4],  
                                'peso_recurso'=> $row[5]                       
                                
                 ));
                  }    
            }
               echo json_encode($data);
  }

      function GetCurso($fullname,$subsanacion,$induccion,$id_cursox){               
    $con = new Conexion();
    $ca=$con->initConnection();
    $result = mysqli_query($ca, "call SP_REPORTES_DESAPROBADOS_LISTA_CURSO
    ('$fullname','$subsanacion','$induccion','$id_cursox');") or die("Query fail: " . mysqli_error());
    $data = [];
      if (mysqli_num_rows($result)>0){
        while ($row = mysqli_fetch_array($result, MYSQLI_NUM)){
                               array_push($data,array(
                                'fullname'=> $row[0],     
                                'subsanacion'=> $row[1], 
                                'induccion'=> $row[2]  
                                
                 ));
                  }    
            }
               echo json_encode($data);
  }

   function GetQuiz($id,$nota_grade,$nota_maxima,$peso_recurso,$id_userx,$id_cursox){               
    $con = new Conexion();
    $ca=$con->initConnection();
    $result = mysqli_query($ca, "call SP_REPORTES_DESAPROBADOS_LISTA_QUIZ
    ('$id','$nota_grade','$nota_maxima','$peso_recurso','$id_userx','$id_cursox');") or die("Query fail: " . mysqli_error());
    $data = [];
      if (mysqli_num_rows($result)>0){
        while ($row = mysqli_fetch_array($result, MYSQLI_NUM)){
                               array_push($data,array(
                                'id'=> $row[0],     
                                'nota_grade'=> $row[1], 
                                'nota_maxima'=> $row[2],
                                'peso_recurso'=> $row[3]
                                                           
                 ));
                  }    
            }
               echo json_encode($data);
  }

    function GetPerforming($id,$peso_recurso,$name,$id_cursox){               
    $con = new Conexion();
    $ca=$con->initConnection();
    $result = mysqli_query($ca, "call SP_REPORTES_DESAPROBADOS_PERFORMING
    ('$id','$peso_recurso','$name');") or die("Query fail: " . mysqli_error());
    $data = [];
      if (mysqli_num_rows($result)>0){
        while ($row = mysqli_fetch_array($result, MYSQLI_NUM)){
                               array_push($data,array(
                                'id'=> $row[0],     
                                'peso_recurso'=> $row[1], 
                                'name'=> $row[2],
                                'id_cursox'=> $row[3]
                                                           
                 ));
                  }    
            }
               echo json_encode($data);
  }

      function GetPerformingSQL($id,$assignmenttype,$peso_recurso,$name,$id_cursox){               
    $con = new Conexion();
    $ca=$con->initConnection();
    $result = mysqli_query($ca, "call SP_REPORTES_DESAPROBADOS_PERFORMING_SQL
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

       function GetTarea($id,$Grade,$nota_maxima,$peso_recurso,$numbfiles,$id_link,$assignmenttype,$id_userx,$id_cursox){               
    $con = new Conexion();
    $ca=$con->initConnection();
    $result = mysqli_query($ca, "call SP_REPORTES_DESAPROBADOS_TAREA
    ('$id','$Grade','$nota_maxima','$peso_recurso','$numbfiles','$id_link','$assignmenttype','$id_userx','$id_cursox');") or die("Query fail: " . mysqli_error());
    $data = [];
      if (mysqli_num_rows($result)>0){
        while ($row = mysqli_fetch_array($result, MYSQLI_NUM)){
                               array_push($data,array(
                                'id'=> $row[0],     
                                'Grade'=> $row[1], 
                                'nota_maxima'=> $row[2],
                                'peso_recurso'=> $row[3],
                                'numbfiles'=> $row[4],
                                'id_link'=> $row[5],
                                'assignmenttype'=> $row[6]
                                                         
                 ));
                  }    
            }
               echo json_encode($data);
  }

       function GetPonderaciones($tiene_pond,$id_cursox){               
    $con = new Conexion();
    $ca=$con->initConnection();
    $result = mysqli_query($ca, "call SP_REPORTES_DESAPROBADOS_TIENE_PONDERACIONES
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
              $userid = (strlen($_GET['camp'])>0)?$_GET['camp']:'';
              $firstname = (strlen($_GET['nombre_centro'])>0)?$_GET['nombre_centro']:'';
              $lastname = (strlen($_GET['carr'])>0)?$_GET['carr']:'';
              $camp = (strlen($_GET['carrera'])>0)?$_GET['carrera']:'';
              $nombre_centro = (strlen($_GET['total_alu'])>0)?$_GET['total_alu']:'';

              $bloque = (strlen($_GET['id_cursox'])>0)?$_GET['id_cursox']:'';  
              $nrc = (strlen($_GET['id_cursox'])>0)?$_GET['id_cursox']:''; 
              $pidm_banner = (strlen($_GET['id_cursox'])>0)?$_GET['id_cursox']:''; 
              $id_cursox = (strlen($_GET['id_cursox'])>0)?$_GET['id_cursox']:'';       

              GetEstudiantes($userid,$firstname,$lastname,$camp,$nombre_centro,$bloque,$nrc,$pidm_banner,$id_cursox);         
                # code...
                break;

              case 'list2':
              $id = (strlen($_GET['id'])>0)?$_GET['id']:'';
              $scale = (strlen($_GET['scale'])>0)?$_GET['scale']:'';
              $peso_recurso = (strlen($_GET['peso_recurso'])>0)?$_GET['peso_recurso']:'';
              $id_cursox = (strlen($_GET['id_cursox'])>0)?$_GET['id_cursox']:'';
                     

               GetForo($id,$scale,$peso_recurso,$id_cursox);         
                # code...
                break;

              case 'list3':
              $id_foro  = (strlen($_GET['id_foro'])>0)?$_GET['id_foro']:'';
              $discuss = (strlen($_GET['discuss'])>0)?$_GET['discuss']:'';
              $id_userx = (strlen($_GET['id_userx'])>0)?$_GET['id_userx']:'';
              $post = (strlen($_GET['post'])>0)?$_GET['post']:'';
              $rating = (strlen($_GET['rating '])>0)?$_GET['rating ']:'';
              $peso_recurso = (strlen($_GET['peso_recurso'])>0)?$_GET['peso_recurso']:'';
              $id_cursox = (strlen($_GET['id_cursox'])>0)?$_GET['id_cursox']:'';

                     

                GetForos($id_foro,$discuss,$id_userx,$post,$rating,$peso_recurso,$id_cursox);         
                # code...
                break;

              case 'list4':
              $fullname  = (strlen($_GET['fullname'])>0)?$_GET['fullname']:'';
              $subsanacion = (strlen($_GET['subsanacion'])>0)?$_GET['subsanacion']:'';
              $induccion = (strlen($_GET['induccion'])>0)?$_GET['induccion']:'';
             
              $id_cursox = (strlen($_GET['id_cursox'])>0)?$_GET['id_cursox']:'';

                     

                GetCurso($fullname,$subsanacion,$induccion,$id_cursox);         
                # code...
                break;

              case 'list5':
              $id  = (strlen($_GET['id'])>0)?$_GET['id']:'';
              $nota_grade = (strlen($_GET['nota_grade'])>0)?$_GET['nota_grade']:'';
              $nota_maxima = (strlen($_GET['nota_maxima'])>0)?$_GET['nota_maxima']:'';
              $peso_recurso = (strlen($_GET['peso_recurso'])>0)?$_GET['peso_recurso']:'';
              $id_userx = (strlen($_GET['id_userx'])>0)?$_GET['id_userx']:'';
              $id_cursox = (strlen($_GET['id_cursox'])>0)?$_GET['id_cursox']:'';
              

                     

               GetQuiz($id,$nota_grade,$nota_maxima,$peso_recurso,$id_userx,$id_cursox);         
                # code...
                break;


              case 'list6':
              $id  = (strlen($_GET['id'])>0)?$_GET['id']:'';
              $peso_recurso = (strlen($_GET['peso_recurso'])>0)?$_GET['peso_recurso']:'';
              $name = (strlen($_GET['name'])>0)?$_GET['name']:'';
              $id_cursox = (strlen($_GET['id_cursox'])>0)?$_GET['id_cursox']:'';        

              GetPerforming($id,$peso_recurso,$name,$id_cursox);         
                # code...
                break;


              case 'list7':
              $id  = (strlen($_GET['id'])>0)?$_GET['id']:'';
              $peso_recurso = (strlen($_GET['peso_recurso'])>0)?$_GET['peso_recurso']:'';
              $name = (strlen($_GET['name'])>0)?$_GET['name']:'';
              $id_cursox = (strlen($_GET['id_cursox'])>0)?$_GET['id_cursox']:'';        

              GetPerforming($id,$peso_recurso,$name,$id_cursox);         
                # code...
                break;



              case 'list8':
              $id  = (strlen($_GET['id'])>0)?$_GET['id']:'';
              $assignmenttype = (strlen($_GET['assignmenttype'])>0)?$_GET['assignmenttype']:'';
              $peso_recurso = (strlen($_GET['peso_recurso'])>0)?$_GET['peso_recurso']:'';
              $name = (strlen($_GET['name'])>0)?$_GET['name']:'';
              $id_cursox = (strlen($_GET['id_cursox'])>0)?$_GET['id_cursox']:'';        
               GetPerformingSQL($id,$assignmenttype,$peso_recurso,$name,$id_cursox);         
                # code...
                break;

              case 'list9':
              $id  = (strlen($_GET['id'])>0)?$_GET['id']:'';
              $assignmenttype = (strlen($_GET['assignmenttype'])>0)?$_GET['assignmenttype']:'';
              $peso_recurso = (strlen($_GET['peso_recurso'])>0)?$_GET['peso_recurso']:'';
              $name = (strlen($_GET['name'])>0)?$_GET['name']:'';
              $id_cursox = (strlen($_GET['id_cursox'])>0)?$_GET['id_cursox']:'';   

               GetPerformingSQL($id,$assignmenttype,$peso_recurso,$name,$id_cursox);         
                # code...
                break;  



              case 'list10':
              $id  = (strlen($_GET['id'])>0)?$_GET['id']:'';
              $Grade = (strlen($_GET['Grade'])>0)?$_GET['Grade']:'';
              $nota_maxima = (strlen($_GET['nota_maxima'])>0)?$_GET['nota_maxima']:'';
              $peso_recurso = (strlen($_GET['peso_recurso'])>0)?$_GET['peso_recurso']:'';
              $numbfiles = (strlen($_GET['numbfiles'])>0)?$_GET['numbfiles']:''; 
              $id_link = (strlen($_GET['id_link'])>0)?$_GET['id_link']:''; 
              $assignmenttype = (strlen($_GET['assignmenttype'])>0)?$_GET['assignmenttype']:''; 
              $id_userx = (strlen($_GET['id_userx'])>0)?$_GET['id_userx']:''; 
              $id_cursox = (strlen($_GET['id_cursox'])>0)?$_GET['id_cursox']:'';   

               GetTarea($id,$Grade,$nota_maxima,$peso_recurso,$numbfiles,$id_link,$assignmenttype,$id_userx,$id_cursox);         
                # code...
                break;  


              case 'list11s':
              $tiene_pond  = (strlen($_GET['tiene_pond'])>0)?$_GET['tiene_pond']:'';
              
              $id_cursox = (strlen($_GET['id_cursox'])>0)?$_GET['id_cursox']:'';   

               GetPonderaciones($tiene_pond,$id_cursox);         
                # code...
                break;  

              

              
             
    }
                           
    
?>  