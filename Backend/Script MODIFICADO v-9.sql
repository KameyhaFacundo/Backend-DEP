-- Eliminar secuencias si existen (usando CASCADE para eliminar dependencias)
DROP SEQUENCE IF EXISTS public."Acciones_IdAccion_seq" CASCADE;
DROP SEQUENCE IF EXISTS public."Movimientos_IdMovimientos_seq" CASCADE;
DROP SEQUENCE IF EXISTS public."Centros_idcentro_seq" CASCADE;
DROP SEQUENCE IF EXISTS public."Roles_IdRol_seq" CASCADE;
DROP SEQUENCE IF EXISTS public."Usuarios_IdRol_seq" CASCADE;
DROP SEQUENCE IF EXISTS public."Usuarios_IdUsuarios_seq" CASCADE;
DROP SEQUENCE IF EXISTS public.seq_alimentos CASCADE;
DROP SEQUENCE IF EXISTS public.seq_libreria CASCADE;
DROP SEQUENCE IF EXISTS public.seq_limpieza CASCADE;

-- Eliminar tablas si existen
DROP TABLE IF EXISTS public."Acciones" CASCADE;
DROP TABLE IF EXISTS public."Articulos" CASCADE;
DROP TABLE IF EXISTS public."Centros" CASCADE;
DROP TABLE IF EXISTS public."Movimientos" CASCADE;
DROP TABLE IF EXISTS public."Roles" CASCADE;
DROP TABLE IF EXISTS public."Rubros" CASCADE;
DROP TABLE IF EXISTS public."Usuarios" CASCADE;

-- Crear secuencias
CREATE SEQUENCE public."Acciones_IdAccion_seq"
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    MAXVALUE 32767
    CACHE 1;

CREATE SEQUENCE public."Movimientos_IdMovimientos_seq"
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;

CREATE SEQUENCE public."Centros_idcentro_seq"
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;

CREATE SEQUENCE public."Roles_IdRol_seq"
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;

CREATE SEQUENCE public."Usuarios_IdRol_seq"
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;

CREATE SEQUENCE public."Usuarios_IdUsuarios_seq"
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;

CREATE SEQUENCE public.seq_alimentos
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;

CREATE SEQUENCE public.seq_libreria
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;

CREATE SEQUENCE public.seq_limpieza
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;

-- Crear tablas
CREATE TABLE public."Acciones" (
    "IdAccion" smallint DEFAULT nextval('public."Acciones_IdAccion_seq"'::regclass) NOT NULL,
    "Accion" character varying(120) NOT NULL
);

CREATE TABLE public."Articulos" (
    "IdArticulo" integer NOT NULL,
    "IdRubro" smallint NOT NULL,
    "IdConcepto" character(5) NOT NULL,
    "Articulo" character varying(200) NOT NULL,
    "Cantidad" integer DEFAULT 1 NOT NULL CHECK ("Cantidad" > 0)
);

CREATE TABLE public."Centros" (
    "IdCentro" integer DEFAULT nextval('public."Centros_idcentro_seq"'::regclass) NOT NULL,
    "Centro" character varying NOT NULL
);

CREATE TABLE public."Movimientos" (
    "IdMovimiento" integer NOT NULL,
    "FechaActual" date DEFAULT CURRENT_DATE NOT NULL,
    "IdCentro" integer NOT NULL,
    "Cantidad" integer NOT NULL,
    "DescripUnidad" character varying(150),
    "IdAccion" smallint NOT NULL,
    "IdConcepto" character(5) NOT NULL,
    "Unidad" character varying(100),
    "Motivo" text,
    "FechaMov" date NOT NULL,
    CONSTRAINT chk_cantidad_positive CHECK (("Cantidad" > 0))
);



CREATE TABLE public."Roles" (
    "IdRol" integer NOT NULL,
    "Rol" character varying(100) NOT NULL,
    "Descripcion" text
);

CREATE TABLE public."Rubros" (
    "IdRubro" smallint NOT NULL,
    "Rubro" character varying(120) NOT NULL
);

CREATE TABLE public."Usuarios" (
    "IdUsuario" integer NOT NULL,
    "IdRol" integer NOT NULL,
    "Usuario" character varying(120) NOT NULL,
    "Password" character varying(250) NOT NULL
);

-- Crear relaciones (Foreign Keys) y claves primarias (Primary Keys)
ALTER TABLE public."Acciones" ADD PRIMARY KEY ("IdAccion");
ALTER TABLE public."Articulos" ADD PRIMARY KEY ("IdConcepto");
ALTER TABLE public."Centros" ADD PRIMARY KEY ("IdCentro");
ALTER TABLE public."Movimientos" ADD PRIMARY KEY ("IdMovimiento");
ALTER TABLE public."Roles" ADD PRIMARY KEY ("IdRol");
ALTER TABLE public."Rubros" ADD PRIMARY KEY ("IdRubro");
ALTER TABLE public."Usuarios" ADD PRIMARY KEY ("IdUsuario");

ALTER TABLE public."Articulos" ADD CONSTRAINT fk_articulos_rubro FOREIGN KEY ("IdRubro") REFERENCES public."Rubros"("IdRubro");
ALTER TABLE public."Movimientos" ADD CONSTRAINT fk_movimientos_accion FOREIGN KEY ("IdAccion") REFERENCES public."Acciones"("IdAccion");
ALTER TABLE public."Movimientos" ADD CONSTRAINT fk_movimientos_centro FOREIGN KEY ("IdCentro") REFERENCES public."Centros"("IdCentro");
ALTER TABLE public."Usuarios" ADD CONSTRAINT fk_usuarios_rol FOREIGN KEY ("IdRol") REFERENCES public."Roles"("IdRol");

-- Asignar secuencias a las tablas correspondientes
ALTER TABLE ONLY public."Movimientos" ALTER COLUMN "IdMovimiento" SET DEFAULT nextval('public."Movimientos_IdMovimientos_seq"'::regclass);
ALTER TABLE ONLY public."Roles" ALTER COLUMN "IdRol" SET DEFAULT nextval('public."Roles_IdRol_seq"'::regclass);
ALTER TABLE ONLY public."Usuarios" ALTER COLUMN "IdUsuario" SET DEFAULT nextval('public."Usuarios_IdUsuarios_seq"'::regclass);
ALTER TABLE ONLY public."Usuarios" ALTER COLUMN "IdRol" SET DEFAULT nextval('public."Usuarios_IdRol_seq"'::regclass);
ALTER TABLE public."Movimientos" ADD CONSTRAINT fk_movimientos_articulos FOREIGN KEY ("IdConcepto") REFERENCES public."Articulos"("IdConcepto");


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


--------------------------------------------------------------------------------------------------------------------
----------------------------------- INSERCION DE DATOS -------------------------------------------------------------
DELETE FROM public."Movimientos";
DELETE FROM public."Usuarios";
DELETE FROM public."Articulos";
DELETE FROM public."Roles";
DELETE FROM public."Rubros";
DELETE FROM public."Acciones";
DELETE FROM public."Centros";


-- Resetear secuencias a 1
ALTER SEQUENCE public."Centros_idcentro_seq" RESTART WITH 1;
ALTER SEQUENCE public."Movimientos_IdMovimientos_seq" RESTART WITH 1;
ALTER SEQUENCE public."Acciones_IdAccion_seq" RESTART WITH 1;
ALTER SEQUENCE public."Centros_idcentro_seq" RESTART WITH 1;
ALTER SEQUENCE public."Roles_IdRol_seq" RESTART WITH 1;
ALTER SEQUENCE public."Usuarios_IdRol_seq" RESTART WITH 1;
ALTER SEQUENCE public."Usuarios_IdUsuarios_seq" RESTART WITH 1;
ALTER SEQUENCE public."seq_alimentos" RESTART WITH 1;
ALTER SEQUENCE public."seq_libreria" RESTART WITH 1;
ALTER SEQUENCE public."seq_limpieza" RESTART WITH 1;

INSERT INTO public."Roles" ("IdRol", "Rol", "Descripcion") VALUES (1, 'administrador', ' ');
INSERT INTO public."Roles" ("IdRol", "Rol", "Descripcion") VALUES (2, 'usuario', ' ');
INSERT INTO public."Roles" ("IdRol", "Rol", "Descripcion") VALUES (3, 'lector', ' ');

INSERT INTO public."Rubros" ("IdRubro", "Rubro") VALUES (1, 'Librería');
INSERT INTO public."Rubros" ("IdRubro", "Rubro") VALUES (2, 'Alimentos');
INSERT INTO public."Rubros" ("IdRubro", "Rubro") VALUES (3, 'Limpieza');

INSERT INTO public."Usuarios" ("IdUsuario", "IdRol", "Usuario", "Password") 
VALUES 
(5, 1, 'admin', MD5('admin123')),
(6, 2, 'usuario', MD5('usuario123')),
(7, 3, 'lector', MD5('lector123'));

INSERT INTO public."Acciones" ("IdAccion", "Accion") VALUES (1, 'Entrada');
INSERT INTO public."Acciones" ("IdAccion", "Accion") VALUES (2, 'Salida');

INSERT INTO public."Centros" ("IdCentro", "Centro") VALUES (1, 'Administracion');
INSERT INTO public."Centros" ("IdCentro", "Centro") VALUES (2, 'Asesoria legal');
INSERT INTO public."Centros" ("IdCentro", "Centro") VALUES (3, 'Biblioteca');
INSERT INTO public."Centros" ("IdCentro", "Centro") VALUES (4, 'Cartografia');
INSERT INTO public."Centros" ("IdCentro", "Centro") VALUES (5, 'Computos');
INSERT INTO public."Centros" ("IdCentro", "Centro") VALUES (6, 'Demografia');
INSERT INTO public."Centros" ("IdCentro", "Centro") VALUES (7, 'EIL');
INSERT INTO public."Centros" ("IdCentro", "Centro") VALUES (8, 'EOH');
INSERT INTO public."Centros" ("IdCentro", "Centro") VALUES (9, 'EPH');
INSERT INTO public."Centros" ("IdCentro", "Centro") VALUES (10, 'ICC');
INSERT INTO public."Centros" ("IdCentro", "Centro") VALUES (11, 'IPC');
INSERT INTO public."Centros" ("IdCentro", "Centro") VALUES (12, 'Indicadores sociodemograficos');
INSERT INTO public."Centros" ("IdCentro", "Centro") VALUES (13, 'Mesa de entrada');
INSERT INTO public."Centros" ("IdCentro", "Centro") VALUES (14, 'Permiso de edificacion');
INSERT INTO public."Centros" ("IdCentro", "Centro") VALUES (15, 'Personal');
INSERT INTO public."Centros" ("IdCentro", "Centro") VALUES (16, 'Sistema estadistico provincial');
INSERT INTO public."Centros" ("IdCentro", "Centro") VALUES (17, 'Elvira - Limpieza ');
INSERT INTO public."Centros" ("IdCentro", "Centro") VALUES (18, 'Gramajo - Limpieza');
INSERT INTO public."Centros" ("IdCentro", "Centro") VALUES (19, 'Quipildor - Limpieza');

INSERT INTO public."Articulos" ("IdArticulo", "IdRubro", "IdConcepto", "Articulo", "Cantidad") VALUES (1, 1, '01001', 'abrochadora 10/50', 1);
INSERT INTO public."Articulos" ("IdArticulo", "IdRubro", "IdConcepto", "Articulo", "Cantidad") VALUES (2, 1, '01002', 'abrochadora 21/6', 1);
INSERT INTO public."Articulos" ("IdArticulo", "IdRubro", "IdConcepto", "Articulo", "Cantidad") VALUES (3, 1, '01003', 'almohadilla para sello', 1);
INSERT INTO public."Articulos" ("IdArticulo", "IdRubro", "IdConcepto", "Articulo", "Cantidad") VALUES (4, 1, '01004', 'arandelas de carton(caja )', 1);
INSERT INTO public."Articulos" ("IdArticulo", "IdRubro", "IdConcepto", "Articulo", "Cantidad") VALUES (5, 1, '01005', 'bibliorato', 1);
INSERT INTO public."Articulos" ("IdArticulo", "IdRubro", "IdConcepto", "Articulo", "Cantidad") VALUES (6, 1, '01006', 'broche Nº 4 para arandela(cajita*50U)', 1);
INSERT INTO public."Articulos" ("IdArticulo", "IdRubro", "IdConcepto", "Articulo", "Cantidad") VALUES (7, 1, '01007', 'broche Nº 6 para arandela(cajita*50u)', 1);
INSERT INTO public."Articulos" ("IdArticulo", "IdRubro", "IdConcepto", "Articulo", "Cantidad") VALUES (8, 1, '01008', 'broches para abrochadora 10/50 (caja*1000u)', 1);
INSERT INTO public."Articulos" ("IdArticulo", "IdRubro", "IdConcepto", "Articulo", "Cantidad") VALUES (9, 1, '01009', 'broches para abrochadora 21/6 (caja*1000u)', 1);
INSERT INTO public."Articulos" ("IdArticulo", "IdRubro", "IdConcepto", "Articulo", "Cantidad") VALUES (10, 1, '01010', 'broches clips nª4 (cajita *100u)', 1);
INSERT INTO public."Articulos" ("IdArticulo", "IdRubro", "IdConcepto", "Articulo", "Cantidad") VALUES (11, 1, '01011', 'broches clips nª6 (cajita*50u)', 1);
INSERT INTO public."Articulos" ("IdArticulo", "IdRubro", "IdConcepto", "Articulo", "Cantidad") VALUES (12, 1, '01012', 'broches clips nª8 (cajita *50u)', 1);
INSERT INTO public."Articulos" ("IdArticulo", "IdRubro", "IdConcepto", "Articulo", "Cantidad") VALUES (13, 1, '01013', 'carpeta plastica cristal A4', 1);
INSERT INTO public."Articulos" ("IdArticulo", "IdRubro", "IdConcepto", "Articulo", "Cantidad") VALUES (14, 1, '01014', 'caratula amarilla para expte', 1);
INSERT INTO public."Articulos" ("IdArticulo", "IdRubro", "IdConcepto", "Articulo", "Cantidad") VALUES (15, 1, '01015', 'cinta adhesiva', 1);
INSERT INTO public."Articulos" ("IdArticulo", "IdRubro", "IdConcepto", "Articulo", "Cantidad") VALUES (16, 1, '01016', 'cinta para embalar (ancha)', 1);
INSERT INTO public."Articulos" ("IdArticulo", "IdRubro", "IdConcepto", "Articulo", "Cantidad") VALUES (17, 1, '01017', 'cinta papel(ancha)', 1);
INSERT INTO public."Articulos" ("IdArticulo", "IdRubro", "IdConcepto", "Articulo", "Cantidad") VALUES (18, 1, '01018', 'cuaderno A4 tapa dura rayado', 1);
INSERT INTO public."Articulos" ("IdArticulo", "IdRubro", "IdConcepto", "Articulo", "Cantidad") VALUES (19, 1, '01019', 'cuaderno A5 tapa dura cuadriculado 120 hojas', 1);
INSERT INTO public."Articulos" ("IdArticulo", "IdRubro", "IdConcepto", "Articulo", "Cantidad") VALUES (20, 1, '01020', 'cuaderno tamaño chico rayado 100 hojas', 1);
INSERT INTO public."Articulos" ("IdArticulo", "IdRubro", "IdConcepto", "Articulo", "Cantidad") VALUES (21, 1, '01021', 'resaltadores de color', 1);
INSERT INTO public."Articulos" ("IdArticulo", "IdRubro", "IdConcepto", "Articulo", "Cantidad") VALUES (22, 1, '01022', 'folio A4', 1);
INSERT INTO public."Articulos" ("IdArticulo", "IdRubro", "IdConcepto", "Articulo", "Cantidad") VALUES (23, 1, '01023', 'folio oficio', 1);
INSERT INTO public."Articulos" ("IdArticulo", "IdRubro", "IdConcepto", "Articulo", "Cantidad") VALUES (24, 1, '01024', 'gomas lapiz', 1);
INSERT INTO public."Articulos" ("IdArticulo", "IdRubro", "IdConcepto", "Articulo", "Cantidad") VALUES (25, 1, '01025', 'gomillas (caja *500gs)', 1);
INSERT INTO public."Articulos" ("IdArticulo", "IdRubro", "IdConcepto", "Articulo", "Cantidad") VALUES (26, 1, '01026', 'hojas membretadas preimpresas', 1);
INSERT INTO public."Articulos" ("IdArticulo", "IdRubro", "IdConcepto", "Articulo", "Cantidad") VALUES (27, 1, '01027', 'hilo plastico', 1);
INSERT INTO public."Articulos" ("IdArticulo", "IdRubro", "IdConcepto", "Articulo", "Cantidad") VALUES (28, 1, '01028', 'lapicera verde', 1);
INSERT INTO public."Articulos" ("IdArticulo", "IdRubro", "IdConcepto", "Articulo", "Cantidad") VALUES (29, 1, '01029', 'lapiceras azules', 1);
INSERT INTO public."Articulos" ("IdArticulo", "IdRubro", "IdConcepto", "Articulo", "Cantidad") VALUES (30, 1, '01030', 'lapiceras negras', 1);
INSERT INTO public."Articulos" ("IdArticulo", "IdRubro", "IdConcepto", "Articulo", "Cantidad") VALUES (31, 1, '01031', 'lapiceras rojas', 1);
INSERT INTO public."Articulos" ("IdArticulo", "IdRubro", "IdConcepto", "Articulo", "Cantidad") VALUES (32, 1, '01032', 'lapiz negro', 1);
INSERT INTO public."Articulos" ("IdArticulo", "IdRubro", "IdConcepto", "Articulo", "Cantidad") VALUES (33, 1, '01033', 'liquido corrector', 1);
INSERT INTO public."Articulos" ("IdArticulo", "IdRubro", "IdConcepto", "Articulo", "Cantidad") VALUES (34, 1, '01034', 'marcador negro', 1);


INSERT INTO public."Articulos" ("IdArticulo", "IdRubro", "IdConcepto", "Articulo", "Cantidad") VALUES (35, 1, '01035', 'marcadores negro para pizarra', 100);
INSERT INTO public."Articulos" ("IdArticulo", "IdRubro", "IdConcepto", "Articulo", "Cantidad") VALUES (36, 1, '01036', 'perforadora', 50);
INSERT INTO public."Articulos" ("IdArticulo", "IdRubro", "IdConcepto", "Articulo", "Cantidad") VALUES (37, 1, '01037', 'resma A4', 200);
INSERT INTO public."Articulos" ("IdArticulo", "IdRubro", "IdConcepto", "Articulo", "Cantidad") VALUES (38, 1, '01038', 'resma oficio', 150);
INSERT INTO public."Articulos" ("IdArticulo", "IdRubro", "IdConcepto", "Articulo", "Cantidad") VALUES (39, 1, '01039', 'saca ganchos', 30);
INSERT INTO public."Articulos" ("IdArticulo", "IdRubro", "IdConcepto", "Articulo", "Cantidad") VALUES (40, 1, '01040', 'sacapuntas', 60);
INSERT INTO public."Articulos" ("IdArticulo", "IdRubro", "IdConcepto", "Articulo", "Cantidad") VALUES (41, 1, '01041', 'sello foliador', 25);
INSERT INTO public."Articulos" ("IdArticulo", "IdRubro", "IdConcepto", "Articulo", "Cantidad") VALUES (42, 1, '01042', 'sobre papel madera A4', 500);
INSERT INTO public."Articulos" ("IdArticulo", "IdRubro", "IdConcepto", "Articulo", "Cantidad") VALUES (43, 1, '01043', 'sobre papel madera OFICIO', 400);
INSERT INTO public."Articulos" ("IdArticulo", "IdRubro", "IdConcepto", "Articulo", "Cantidad") VALUES (44, 1, '01044', 'tacos papel /anotador', 300);
INSERT INTO public."Articulos" ("IdArticulo", "IdRubro", "IdConcepto", "Articulo", "Cantidad") VALUES (45, 1, '01045', 'tijera', 100);
INSERT INTO public."Articulos" ("IdArticulo", "IdRubro", "IdConcepto", "Articulo", "Cantidad") VALUES (46, 1, '01046', 'tinta para sello negra (250ml)', 75);
INSERT INTO public."Articulos" ("IdArticulo", "IdRubro", "IdConcepto", "Articulo", "Cantidad") VALUES (47, 1, '01047', 'tinta para sello azul (250ml)', 50);
INSERT INTO public."Articulos" ("IdArticulo", "IdRubro", "IdConcepto", "Articulo", "Cantidad") VALUES (48, 1, '01048', 'toner 279 A', 20);
INSERT INTO public."Articulos" ("IdArticulo", "IdRubro", "IdConcepto", "Articulo", "Cantidad") VALUES (49, 1, '01049', 'toner 283A', 18);
INSERT INTO public."Articulos" ("IdArticulo", "IdRubro", "IdConcepto", "Articulo", "Cantidad") VALUES (50, 1, '01050', 'toner BT 5001C', 22);
INSERT INTO public."Articulos" ("IdArticulo", "IdRubro", "IdConcepto", "Articulo", "Cantidad") VALUES (51, 1, '01051', 'toner BT 5001M', 22);
INSERT INTO public."Articulos" ("IdArticulo", "IdRubro", "IdConcepto", "Articulo", "Cantidad") VALUES (52, 1, '01052', 'toner BT 5001Y', 22);
INSERT INTO public."Articulos" ("IdArticulo", "IdRubro", "IdConcepto", "Articulo", "Cantidad") VALUES (53, 1, '01053', 'toner BT D60 BK', 15);
INSERT INTO public."Articulos" ("IdArticulo", "IdRubro", "IdConcepto", "Articulo", "Cantidad") VALUES (54, 1, '01054', 'toner CB435A-436A', 12);
INSERT INTO public."Articulos" ("IdArticulo", "IdRubro", "IdConcepto", "Articulo", "Cantidad") VALUES (55, 1, '01055', 'toner samsung xpress M2020W', 10);
INSERT INTO public."Articulos" ("IdArticulo", "IdRubro", "IdConcepto", "Articulo", "Cantidad") VALUES (56, 1, '01056', 'toner TH2612A', 14);
INSERT INTO public."Articulos" ("IdArticulo", "IdRubro", "IdConcepto", "Articulo", "Cantidad") VALUES (57, 1, '01057', 'toner TN 580-650', 9);
INSERT INTO public."Articulos" ("IdArticulo", "IdRubro", "IdConcepto", "Articulo", "Cantidad") VALUES (58, 1, '01058', 'voligoma (mediana)', 200);
INSERT INTO public."Articulos" ("IdArticulo", "IdRubro", "IdConcepto", "Articulo", "Cantidad") VALUES (1, 2, '02001', 'Azucar', 300);
INSERT INTO public."Articulos" ("IdArticulo", "IdRubro", "IdConcepto", "Articulo", "Cantidad") VALUES (2, 2, '02002', 'Café', 250);
INSERT INTO public."Articulos" ("IdArticulo", "IdRubro", "IdConcepto", "Articulo", "Cantidad") VALUES (3, 2, '02003', 'Te', 150);
INSERT INTO public."Articulos" ("IdArticulo", "IdRubro", "IdConcepto", "Articulo", "Cantidad") VALUES (4, 2, '02004', 'Mate cocido', 100);
INSERT INTO public."Articulos" ("IdArticulo", "IdRubro", "IdConcepto", "Articulo", "Cantidad") VALUES (5, 2, '02005', 'Edulcorante', 200);
INSERT INTO public."Articulos" ("IdArticulo", "IdRubro", "IdConcepto", "Articulo", "Cantidad") VALUES (6, 2, '02006', 'Azucar en sobre', 180);
INSERT INTO public."Articulos" ("IdArticulo", "IdRubro", "IdConcepto", "Articulo", "Cantidad") VALUES (7, 2, '02007', 'Agua', 500);
INSERT INTO public."Articulos" ("IdArticulo", "IdRubro", "IdConcepto", "Articulo", "Cantidad") VALUES (1, 3, '03001', 'Lavandina', 100);
INSERT INTO public."Articulos" ("IdArticulo", "IdRubro", "IdConcepto", "Articulo", "Cantidad") VALUES (2, 3, '03002', 'Desodorante piso', 150);
INSERT INTO public."Articulos" ("IdArticulo", "IdRubro", "IdConcepto", "Articulo", "Cantidad") VALUES (3, 3, '03003', 'Esponja', 200);
INSERT INTO public."Articulos" ("IdArticulo", "IdRubro", "IdConcepto", "Articulo", "Cantidad") VALUES (4, 3, '03004', 'Gamuza algodón para escritorios', 100);
INSERT INTO public."Articulos" ("IdArticulo", "IdRubro", "IdConcepto", "Articulo", "Cantidad") VALUES (5, 3, '03005', 'Rejilla para limpieza baños y cocina', 80);
INSERT INTO public."Articulos" ("IdArticulo", "IdRubro", "IdConcepto", "Articulo", "Cantidad") VALUES (6, 3, '03006', 'Escoba de paja', 50);
INSERT INTO public."Articulos" ("IdArticulo", "IdRubro", "IdConcepto", "Articulo", "Cantidad") VALUES (7, 3, '03007', 'Escobillón', 75);
INSERT INTO public."Articulos" ("IdArticulo", "IdRubro", "IdConcepto", "Articulo", "Cantidad") VALUES (8, 3, '03008', 'Haragán', 60);
INSERT INTO public."Articulos" ("IdArticulo", "IdRubro", "IdConcepto", "Articulo", "Cantidad") VALUES (9, 3, '03009', 'Trapo piso', 90);
INSERT INTO public."Articulos" ("IdArticulo", "IdRubro", "IdConcepto", "Articulo", "Cantidad") VALUES (10, 3, '03010', 'Rollo de cocina', 120);
INSERT INTO public."Articulos" ("IdArticulo", "IdRubro", "IdConcepto", "Articulo", "Cantidad") VALUES (11, 3, '03011', 'Papel higiénico', 200);

INSERT INTO public."Articulos" ("IdArticulo", "IdRubro", "IdConcepto", "Articulo", "Cantidad") VALUES (12, 3, '03012', 'Desinfectante ambiente en aerosol', 150);
INSERT INTO public."Articulos" ("IdArticulo", "IdRubro", "IdConcepto", "Articulo", "Cantidad") VALUES (13, 3, '03013', 'Insecticida shelton', 100);
INSERT INTO public."Articulos" ("IdArticulo", "IdRubro", "IdConcepto", "Articulo", "Cantidad") VALUES (14, 3, '03014', 'Alcohol en gel', 200);
INSERT INTO public."Articulos" ("IdArticulo", "IdRubro", "IdConcepto", "Articulo", "Cantidad") VALUES (15, 3, '03015', 'Alcohol líquido', 250);
INSERT INTO public."Articulos" ("IdArticulo", "IdRubro", "IdConcepto", "Articulo", "Cantidad") VALUES (16, 3, '03016', 'Guantes de látex para limpieza', 100);

SELECT * FROM "Articulos"