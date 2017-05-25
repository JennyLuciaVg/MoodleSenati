//Verifico si tiene Ponderaciones

CREATE PROCEDURE SP_NOTAS_TUTOR_TIENE_PONDERACIONES
(
@id_cursox
)
AS
BEGIN
	SELECT count(1) as tiene_pond
	FROM senati_pesos_recursos
	WHERE id_curso=@id_cursox
END