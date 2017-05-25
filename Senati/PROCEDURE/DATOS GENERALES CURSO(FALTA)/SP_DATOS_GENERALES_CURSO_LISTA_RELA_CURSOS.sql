

CREATE PROCEDURE SP_DATOS_GENERALES_CURSO_RELA_CURSOS	
(
@id_curso_moodle
)
AS
BEGIN
		SELECT * 
		FROM senati_rela_cursos_cursos 
		INNER JOIN senati_cursos on id_curso_senati=id_curso 
		WHERE id_course_moodle=@id_curso_moodle
END
    