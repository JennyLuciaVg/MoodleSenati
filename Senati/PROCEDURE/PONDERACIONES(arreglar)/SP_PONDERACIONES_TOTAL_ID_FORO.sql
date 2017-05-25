
CREATE PROCEDURE SP_PONDERACIONES_TOTAL_ID_FORO
(
@id_cursox,
@valor_id_foro 
)
AS
BEGIN
			SELECT COUNT(*) as total
			FROM senati_pesos_recursos
			WHERE id_curso=@id_cursox
			and id_recurso=@valor_id_foro 
			and  tipo_recurso=3
END
