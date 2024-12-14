
-- Agrego un trigger para calcular el idConcepto
DROP TRIGGER IF EXISTS before_insert_articulos ON public."Articulos";

-- Crear una función que calcule el IdConcepto antes de insertar
CREATE OR REPLACE FUNCTION generate_id_concepto() 
RETURNS TRIGGER AS $$
BEGIN
    -- Asignar el idArticulo basado en la secuencia del rubro
    IF NEW."IdRubro" = 1 THEN
        NEW."IdArticulo" := nextval('seq_libreria');
    ELSIF NEW."IdRubro" = 2 THEN
        NEW."IdArticulo" := nextval('seq_alimentos');
    ELSIF NEW."IdRubro" = 3 THEN
        NEW."IdArticulo" := nextval('seq_limpieza');
    END IF;
    
    -- Generar el idConcepto combinando el IdRubro y el IdArticulo dependiendo que secuencia sea
    NEW."IdConcepto" := CONCAT(LPAD(NEW."IdRubro"::TEXT, 2, '0'), LPAD(NEW."IdArticulo"::TEXT, 3, '0'));
    RETURN NEW;
END;
$$ LANGUAGE plpgsql;

-- Crear el trigger para ejecutar antes de insertar
CREATE TRIGGER before_insert_articulos
    BEFORE INSERT ON public."Articulos"
    FOR EACH ROW
    EXECUTE PROCEDURE generate_id_concepto();