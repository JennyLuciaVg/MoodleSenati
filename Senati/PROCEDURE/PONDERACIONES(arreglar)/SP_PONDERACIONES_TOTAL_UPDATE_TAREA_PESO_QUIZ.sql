CREATE PROCEDURE SP_PONDERACIONES_TOTAL_UPDATE_TAREA_PESO_QUIZ
(
@valor_peso,
@id_usuario,
@id_cursox,
@tiporecurso,
@valor_id_quiz 
)
AS
BEGIN
	
		UPDATE senati_pesos_recursos 
		SET peso_recurso=@valor_peso, id_usuario=@id_usuario
		WHERE id_curso=@id_cursox and tipo_recurso=@tiporecurso and id_recurso=@valor_id_quiz 

END
					
					
					
					
					