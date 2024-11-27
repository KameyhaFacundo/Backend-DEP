-- Codigo para agregar un autoincremental si ya tengo datos cargados y no quiero borrar la tabla
CREATE SEQUENCE public.cargas_seq START 1 INCREMENT 1;
ALTER TABLE public."Acciones"
ALTER COLUMN "IdAcciones" SET DEFAULT nextval('public.oficinas_idoficina_seq');

SELECT setval('public.oficinas_idoficina_seq', (SELECT COALESCE(MAX("IdOficina"), 1) FROM public."Oficinas"));



SELECT TO_CHAR("IdArticulo", 'FM000') AS IdArticulo, "Articulo" 
FROM "Articulos";


SELECT TO_CHAR("IdRubro", 'FM00') AS IdRubro, "Rubro" 
FROM "Rubros";

-- Consulta para formar el idConcepto

SELECT 
    CONCAT(TO_CHAR(r."IdRubro", 'FM00'), TO_CHAR(a."IdArticulo", 'FM000')) AS IdConcepto,
    r."Rubro" AS "Rubro",
    a."Articulo"
FROM 
    "Rubros" r
JOIN 
    "Articulos" a
ON 
    r."IdRubro" = a."IdRubro";




-- Insertar en Articulos (IdArticulo se genera automáticamente)
-- Insertar en Articulos y devolver el IdArticulo
INSERT INTO public."Articulos" ("Articulo", "IdRubro")
VALUES ('Lápiz', 1)
RETURNING "IdArticulo";


-- Generar el IdConcepto
DO $$ 
DECLARE
    concepto_id VARCHAR(10);
BEGIN
    SELECT CONCAT(TO_CHAR(01, 'FM00'), TO_CHAR(IdArticulo, 'FM000')) INTO concepto_id;
END $$;

-- Insertar en Cargas
INSERT INTO Cargas (Fecha, IdAccion, Accion, IdArticulo, IdRubro, IdOficina, IdConcepto, Unidad, DescripcionUnidad, PrecioUnitario, Cantidad)
VALUES 
    (CURRENT_DATE, 1, 'Ingreso', articulo_id, rubro_id, oficina_id, concepto_id, 1, 'Unidad estándar', 12.50, 10);


-- Genero el IdConcepto

DO $$ 
DECLARE
    concepto_id VARCHAR(10);
BEGIN
    SELECT CONCAT(TO_CHAR(01, 'FM00'), TO_CHAR(articulo_id, 'FM000')) INTO concepto_id;
END $$;


INSERT INTO public."Oficinas"("Oficina")
VALUES 

('Asesoria legal'),
('Biblioteca'),
('Cartografia'),
('Computos'),
('Demografia'),
('EIL'),
('EOH'),
('EPH'),
('ICC'),
('IPC'),
('Indicadores sociodemograficos'),
('Mesa de entrada'),
('Permiso de edificacion'),
('Personal'),
('Sistema estadistico provincial'),
('Elvira - Limpieza '),
('Gramajo - Limpieza'),
('Quipildor - Limpieza');

SELECT * FROM "Movimientos";
SELECT * FROM "Rubros";
SELECT * FROM "Acciones";
SELECT * FROM "Articulos";

DELETE FROM "Movimientos";

BEGIN;

SELECT setval('public."Cargas_IdCargas_seq"', 1, false);
SELECT setval('public."oficinas_idoficina_seq"', 1, false);
SELECT setval('public."Articulos_IdArticulo_seq"', 1, false);
SELECT setval('public."Roles_IdRol_seq"', 1, false);
SELECT setval('public."Usuarios_IdUsuarios_seq"', 1, false);
SELECT setval('public."Usuarios_IdRol_seq"', 1, false);
SELECT setval('public."Movimientos_IdUsuario_seq"', 1, false);

COMMIT;



SELECT *
FROM pg_sequences
WHERE schemaname = 'public';

DROP SEQUENCE IF EXISTS public."Cargas_IdCargas_seq";}


-- FUNCIONA BIEN ESTA CONSULTA

SELECT a."IdArticulo", 
       a."IdRubro", 
       a."Articulo", 
       ROW_NUMBER() OVER (PARTITION BY a."IdRubro" ORDER BY a."IdArticulo") AS "SecuenciaPorRubro"
FROM public."Articulos" a;

-- Le agrego la forma para agregar un idConcepto

-- Paso 2: Actualizar IdConcepto con el formato deseado
UPDATE public."Articulos" AS main
SET "IdConcepto" = LPAD(CAST(main."IdRubro" AS TEXT), 2, '0') || 
                   LPAD(CAST(subquery."SecuenciaPorRubro" AS TEXT), 3, '0')
FROM (
    SELECT a."IdArticulo",
           a."IdRubro",
           ROW_NUMBER() OVER (PARTITION BY a."IdRubro" ORDER BY a."IdArticulo") AS "SecuenciaPorRubro"
    FROM public."Articulos" a
) AS subquery
WHERE main."IdArticulo" = subquery."IdArticulo";

SELECT "IdArticulo", "IdRubro", "Articulo", "IdConcepto"
FROM public."Articulos"
ORDER BY "IdRubro", "IdConcepto";


INSERT INTO public."Movimientos" ("Fecha", "IdCentro", "Cantidad", "Unidad", "DescripUnidad", "IdAccion", "IdConcepto", "IdUsuario", "Hora")
SELECT
    CURRENT_DATE, -- Fecha actual
    c."IdCentro",
    10,           -- Ejemplo de cantidad
    'kg',         -- Unidad (ejemplo)
    'Kilogramos', -- Descripción de la unidad (ejemplo)
    a."IdAccion",
    ar."IdConcepto",
    u."IdUsuario",
    CURRENT_TIME  -- Hora actual
FROM public."Centros" c
JOIN public."Acciones" a ON a."Accion" = 'Salida'         -- Accion de ejemplo
JOIN public."Articulos" ar ON ar."Articulo" = 'Lavandina'     -- Artículo de ejemplo
JOIN public."Usuarios" u ON u."Usuario" = 'Administrados'        -- Usuario de ejemplo
WHERE c."Centro" = 'Computos';                   -- Centro de ejemplo



SELECT 
    m."IdConcepto",
    a."Accion" AS "Accion", 
    m."Motivo" AS "Motivo", 
    ar."Articulo" AS "Articulo",
    r."Rubro" AS "Rubro",
    m."Fecha", 
    TO_CHAR(m."Hora", 'HH24:MI:SS') AS "Hora",
    c."Centro" AS "Centro",  
    m."Cantidad", 
    m."Unidad", 
    m."DescripUnidad"
FROM public."Movimientos" m
JOIN public."Usuarios" u ON m."IdUsuario" = u."IdUsuario"
JOIN public."Centros" c ON m."IdCentro" = c."IdCentro"
JOIN public."Acciones" a ON m."IdAccion" = a."IdAccion"   
JOIN public."Articulos" ar ON m."IdConcepto" = ar."IdConcepto"
JOIN public."Rubros" r ON ar."IdRubro" = r."IdRubro";

SELECT * FROM "Acciones";
DELETE FROM "Acciones";

DELETE FROM "Movimientos"