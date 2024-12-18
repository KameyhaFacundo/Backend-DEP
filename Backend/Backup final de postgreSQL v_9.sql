--
-- PostgreSQL database dump
--

-- Dumped from database version 9.3.25
-- Dumped by pg_dump version 9.3.1
-- Started on 2024-12-14 09:29:48

SET statement_timeout = 0;
SET lock_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SET check_function_bodies = false;
SET client_min_messages = warning;

DROP DATABASE "DEP-Stock";
--
-- TOC entry 2031 (class 1262 OID 16393)
-- Name: DEP-Stock; Type: DATABASE; Schema: -; Owner: postgres
--

CREATE DATABASE "DEP-Stock" WITH TEMPLATE = template0 ENCODING = 'UTF8' LC_COLLATE = 'Spanish_Argentina.1252' LC_CTYPE = 'Spanish_Argentina.1252';


ALTER DATABASE "DEP-Stock" OWNER TO postgres;

\connect "DEP-Stock"

SET statement_timeout = 0;
SET lock_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SET check_function_bodies = false;
SET client_min_messages = warning;

--
-- TOC entry 5 (class 2615 OID 2200)
-- Name: public; Type: SCHEMA; Schema: -; Owner: postgres
--

CREATE SCHEMA public;


ALTER SCHEMA public OWNER TO postgres;

--
-- TOC entry 2032 (class 0 OID 0)
-- Dependencies: 5
-- Name: SCHEMA public; Type: COMMENT; Schema: -; Owner: postgres
--

COMMENT ON SCHEMA public IS 'standard public schema';


--
-- TOC entry 189 (class 3079 OID 11750)
-- Name: plpgsql; Type: EXTENSION; Schema: -; Owner: 
--

CREATE EXTENSION IF NOT EXISTS plpgsql WITH SCHEMA pg_catalog;


--
-- TOC entry 2034 (class 0 OID 0)
-- Dependencies: 189
-- Name: EXTENSION plpgsql; Type: COMMENT; Schema: -; Owner: 
--

COMMENT ON EXTENSION plpgsql IS 'PL/pgSQL procedural language';


SET search_path = public, pg_catalog;

--
-- TOC entry 202 (class 1255 OID 16810)
-- Name: generate_id_concepto(); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION generate_id_concepto() RETURNS trigger
    LANGUAGE plpgsql
    AS $$
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
$$;


ALTER FUNCTION public.generate_id_concepto() OWNER TO postgres;

--
-- TOC entry 173 (class 1259 OID 16909)
-- Name: Acciones_IdAccion_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE "Acciones_IdAccion_seq"
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    MAXVALUE 32767
    CACHE 1;


ALTER TABLE public."Acciones_IdAccion_seq" OWNER TO postgres;

SET default_tablespace = '';

SET default_with_oids = false;

--
-- TOC entry 182 (class 1259 OID 16927)
-- Name: Acciones; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE "Acciones" (
    "IdAccion" smallint DEFAULT nextval('"Acciones_IdAccion_seq"'::regclass) NOT NULL,
    "Accion" character varying(120) NOT NULL
);


ALTER TABLE public."Acciones" OWNER TO postgres;

--
-- TOC entry 183 (class 1259 OID 16931)
-- Name: Articulos; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE "Articulos" (
    "IdArticulo" integer NOT NULL,
    "IdRubro" smallint NOT NULL,
    "IdConcepto" character(5) NOT NULL,
    "Articulo" character varying(200) NOT NULL
);


ALTER TABLE public."Articulos" OWNER TO postgres;

--
-- TOC entry 174 (class 1259 OID 16911)
-- Name: Cargas_IdCargas_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE "Cargas_IdCargas_seq"
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public."Cargas_IdCargas_seq" OWNER TO postgres;

--
-- TOC entry 175 (class 1259 OID 16913)
-- Name: Centros_idcentro_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE "Centros_idcentro_seq"
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public."Centros_idcentro_seq" OWNER TO postgres;

--
-- TOC entry 184 (class 1259 OID 16934)
-- Name: Centros; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE "Centros" (
    "IdCentro" integer DEFAULT nextval('"Centros_idcentro_seq"'::regclass) NOT NULL,
    "Centro" character varying NOT NULL
);


ALTER TABLE public."Centros" OWNER TO postgres;

--
-- TOC entry 172 (class 1259 OID 16506)
-- Name: Movimientos_IdMovimientos_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE "Movimientos_IdMovimientos_seq"
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public."Movimientos_IdMovimientos_seq" OWNER TO postgres;

--
-- TOC entry 185 (class 1259 OID 16941)
-- Name: Movimientos; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE "Movimientos" (
    "IdMovimiento" integer DEFAULT nextval('"Movimientos_IdMovimientos_seq"'::regclass) NOT NULL,
    "FechaActual" date DEFAULT ('now'::text)::date NOT NULL,
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


ALTER TABLE public."Movimientos" OWNER TO postgres;

--
-- TOC entry 176 (class 1259 OID 16915)
-- Name: Roles_IdRol_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE "Roles_IdRol_seq"
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public."Roles_IdRol_seq" OWNER TO postgres;

--
-- TOC entry 186 (class 1259 OID 16949)
-- Name: Roles; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE "Roles" (
    "IdRol" integer DEFAULT nextval('"Roles_IdRol_seq"'::regclass) NOT NULL,
    "Rol" character varying(100) NOT NULL,
    "Descripcion" text
);


ALTER TABLE public."Roles" OWNER TO postgres;

--
-- TOC entry 187 (class 1259 OID 16955)
-- Name: Rubros; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE "Rubros" (
    "IdRubro" smallint NOT NULL,
    "Rubro" character varying(120) NOT NULL
);


ALTER TABLE public."Rubros" OWNER TO postgres;

--
-- TOC entry 177 (class 1259 OID 16917)
-- Name: Usuarios_IdRol_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE "Usuarios_IdRol_seq"
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public."Usuarios_IdRol_seq" OWNER TO postgres;

--
-- TOC entry 178 (class 1259 OID 16919)
-- Name: Usuarios_IdUsuarios_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE "Usuarios_IdUsuarios_seq"
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public."Usuarios_IdUsuarios_seq" OWNER TO postgres;

--
-- TOC entry 188 (class 1259 OID 16958)
-- Name: Usuarios; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE "Usuarios" (
    "IdUsuario" integer DEFAULT nextval('"Usuarios_IdUsuarios_seq"'::regclass) NOT NULL,
    "IdRol" integer DEFAULT nextval('"Usuarios_IdRol_seq"'::regclass) NOT NULL,
    "Usuario" character varying(120) NOT NULL,
    "Password" character varying(250) NOT NULL
);


ALTER TABLE public."Usuarios" OWNER TO postgres;

--
-- TOC entry 171 (class 1259 OID 16504)
-- Name: centros_idcentro_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE centros_idcentro_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.centros_idcentro_seq OWNER TO postgres;

--
-- TOC entry 170 (class 1259 OID 16490)
-- Name: oficinas_idoficina_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE oficinas_idoficina_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.oficinas_idoficina_seq OWNER TO postgres;

--
-- TOC entry 179 (class 1259 OID 16921)
-- Name: seq_alimentos; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE seq_alimentos
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.seq_alimentos OWNER TO postgres;

--
-- TOC entry 180 (class 1259 OID 16923)
-- Name: seq_libreria; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE seq_libreria
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.seq_libreria OWNER TO postgres;

--
-- TOC entry 181 (class 1259 OID 16925)
-- Name: seq_limpieza; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE seq_limpieza
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.seq_limpieza OWNER TO postgres;

--
-- TOC entry 2020 (class 0 OID 16927)
-- Dependencies: 182
-- Data for Name: Acciones; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO "Acciones" ("IdAccion", "Accion") VALUES (1, 'Entrada');
INSERT INTO "Acciones" ("IdAccion", "Accion") VALUES (2, 'Salida');


--
-- TOC entry 2035 (class 0 OID 0)
-- Dependencies: 173
-- Name: Acciones_IdAccion_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('"Acciones_IdAccion_seq"', 1, false);


--
-- TOC entry 2021 (class 0 OID 16931)
-- Dependencies: 183
-- Data for Name: Articulos; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO "Articulos" ("IdArticulo", "IdRubro", "IdConcepto", "Articulo") VALUES (1, 1, '01001', 'abrochadora 10/50');
INSERT INTO "Articulos" ("IdArticulo", "IdRubro", "IdConcepto", "Articulo") VALUES (2, 1, '01002', 'abrochadora 21/6');
INSERT INTO "Articulos" ("IdArticulo", "IdRubro", "IdConcepto", "Articulo") VALUES (3, 1, '01003', 'almohadilla para sello');
INSERT INTO "Articulos" ("IdArticulo", "IdRubro", "IdConcepto", "Articulo") VALUES (4, 1, '01004', 'arandelas de carton(caja )');
INSERT INTO "Articulos" ("IdArticulo", "IdRubro", "IdConcepto", "Articulo") VALUES (5, 1, '01005', 'bibliorato');
INSERT INTO "Articulos" ("IdArticulo", "IdRubro", "IdConcepto", "Articulo") VALUES (6, 1, '01006', 'broche Nº 4 para arandela(cajita*50U)');
INSERT INTO "Articulos" ("IdArticulo", "IdRubro", "IdConcepto", "Articulo") VALUES (7, 1, '01007', 'broche Nº 6 para arandela(cajita*50u)');
INSERT INTO "Articulos" ("IdArticulo", "IdRubro", "IdConcepto", "Articulo") VALUES (8, 1, '01008', 'broches para abrochadora 10/50 (caja*1000u)');
INSERT INTO "Articulos" ("IdArticulo", "IdRubro", "IdConcepto", "Articulo") VALUES (9, 1, '01009', 'broches para abrochadora 21/6 (caja*1000u)');
INSERT INTO "Articulos" ("IdArticulo", "IdRubro", "IdConcepto", "Articulo") VALUES (10, 1, '01010', 'broches clips nª4 (cajita *100u)');
INSERT INTO "Articulos" ("IdArticulo", "IdRubro", "IdConcepto", "Articulo") VALUES (11, 1, '01011', 'broches clips nª6 (cajita*50u)');
INSERT INTO "Articulos" ("IdArticulo", "IdRubro", "IdConcepto", "Articulo") VALUES (12, 1, '01012', 'broches clips nª8 (cajita *50u)');
INSERT INTO "Articulos" ("IdArticulo", "IdRubro", "IdConcepto", "Articulo") VALUES (13, 1, '01013', 'carpeta plastica cristal A4');
INSERT INTO "Articulos" ("IdArticulo", "IdRubro", "IdConcepto", "Articulo") VALUES (14, 1, '01014', 'caratula amarilla para expte');
INSERT INTO "Articulos" ("IdArticulo", "IdRubro", "IdConcepto", "Articulo") VALUES (15, 1, '01015', 'cinta adhesiva');
INSERT INTO "Articulos" ("IdArticulo", "IdRubro", "IdConcepto", "Articulo") VALUES (16, 1, '01016', 'cinta para embalar (ancha)');
INSERT INTO "Articulos" ("IdArticulo", "IdRubro", "IdConcepto", "Articulo") VALUES (17, 1, '01017', 'cinta papel(ancha)');
INSERT INTO "Articulos" ("IdArticulo", "IdRubro", "IdConcepto", "Articulo") VALUES (18, 1, '01018', 'cuaderno A4 tapa dura rayado');
INSERT INTO "Articulos" ("IdArticulo", "IdRubro", "IdConcepto", "Articulo") VALUES (19, 1, '01019', 'cuaderno A5 tapa dura cuadriculado 120 hojas');
INSERT INTO "Articulos" ("IdArticulo", "IdRubro", "IdConcepto", "Articulo") VALUES (20, 1, '01020', 'cuaderno tamaño chico rayado 100 hojas');
INSERT INTO "Articulos" ("IdArticulo", "IdRubro", "IdConcepto", "Articulo") VALUES (21, 1, '01021', 'resaltadores de color');
INSERT INTO "Articulos" ("IdArticulo", "IdRubro", "IdConcepto", "Articulo") VALUES (22, 1, '01022', 'folio A4');
INSERT INTO "Articulos" ("IdArticulo", "IdRubro", "IdConcepto", "Articulo") VALUES (23, 1, '01023', 'folio oficio');
INSERT INTO "Articulos" ("IdArticulo", "IdRubro", "IdConcepto", "Articulo") VALUES (24, 1, '01024', 'gomas lapiz');
INSERT INTO "Articulos" ("IdArticulo", "IdRubro", "IdConcepto", "Articulo") VALUES (25, 1, '01025', 'gomillas (caja *500gs)');
INSERT INTO "Articulos" ("IdArticulo", "IdRubro", "IdConcepto", "Articulo") VALUES (26, 1, '01026', 'hojas membretadas preimpresas');
INSERT INTO "Articulos" ("IdArticulo", "IdRubro", "IdConcepto", "Articulo") VALUES (27, 1, '01027', 'hilo plastico');
INSERT INTO "Articulos" ("IdArticulo", "IdRubro", "IdConcepto", "Articulo") VALUES (28, 1, '01028', 'lapicera verde');
INSERT INTO "Articulos" ("IdArticulo", "IdRubro", "IdConcepto", "Articulo") VALUES (29, 1, '01029', 'lapiceras azules');
INSERT INTO "Articulos" ("IdArticulo", "IdRubro", "IdConcepto", "Articulo") VALUES (30, 1, '01030', 'lapiceras negras');
INSERT INTO "Articulos" ("IdArticulo", "IdRubro", "IdConcepto", "Articulo") VALUES (31, 1, '01031', 'lapiceras rojas');
INSERT INTO "Articulos" ("IdArticulo", "IdRubro", "IdConcepto", "Articulo") VALUES (32, 1, '01032', 'lapiz negro');
INSERT INTO "Articulos" ("IdArticulo", "IdRubro", "IdConcepto", "Articulo") VALUES (33, 1, '01033', 'liquido corrector');
INSERT INTO "Articulos" ("IdArticulo", "IdRubro", "IdConcepto", "Articulo") VALUES (34, 1, '01034', 'marcador negro');
INSERT INTO "Articulos" ("IdArticulo", "IdRubro", "IdConcepto", "Articulo") VALUES (35, 1, '01035', 'marcadores negro para pizarra');
INSERT INTO "Articulos" ("IdArticulo", "IdRubro", "IdConcepto", "Articulo") VALUES (36, 1, '01036', 'perforadora');
INSERT INTO "Articulos" ("IdArticulo", "IdRubro", "IdConcepto", "Articulo") VALUES (37, 1, '01037', 'resma A4');
INSERT INTO "Articulos" ("IdArticulo", "IdRubro", "IdConcepto", "Articulo") VALUES (38, 1, '01038', 'resma oficio');
INSERT INTO "Articulos" ("IdArticulo", "IdRubro", "IdConcepto", "Articulo") VALUES (39, 1, '01039', 'saca ganchos');
INSERT INTO "Articulos" ("IdArticulo", "IdRubro", "IdConcepto", "Articulo") VALUES (40, 1, '01040', 'sacapuntas');
INSERT INTO "Articulos" ("IdArticulo", "IdRubro", "IdConcepto", "Articulo") VALUES (41, 1, '01041', 'sello foliador');
INSERT INTO "Articulos" ("IdArticulo", "IdRubro", "IdConcepto", "Articulo") VALUES (42, 1, '01042', 'sobre papel madera A4');
INSERT INTO "Articulos" ("IdArticulo", "IdRubro", "IdConcepto", "Articulo") VALUES (43, 1, '01043', 'sobre papel madera OFICIO');
INSERT INTO "Articulos" ("IdArticulo", "IdRubro", "IdConcepto", "Articulo") VALUES (44, 1, '01044', 'tacos papel /anotador');
INSERT INTO "Articulos" ("IdArticulo", "IdRubro", "IdConcepto", "Articulo") VALUES (45, 1, '01045', 'tijera');
INSERT INTO "Articulos" ("IdArticulo", "IdRubro", "IdConcepto", "Articulo") VALUES (46, 1, '01046', 'tinta para sello negra (250ml)');
INSERT INTO "Articulos" ("IdArticulo", "IdRubro", "IdConcepto", "Articulo") VALUES (47, 1, '01047', 'tinta para sello azul (250ml)');
INSERT INTO "Articulos" ("IdArticulo", "IdRubro", "IdConcepto", "Articulo") VALUES (48, 1, '01048', 'toner 279 A');
INSERT INTO "Articulos" ("IdArticulo", "IdRubro", "IdConcepto", "Articulo") VALUES (49, 1, '01049', 'toner 283A');
INSERT INTO "Articulos" ("IdArticulo", "IdRubro", "IdConcepto", "Articulo") VALUES (50, 1, '01050', 'toner BT 5001C');
INSERT INTO "Articulos" ("IdArticulo", "IdRubro", "IdConcepto", "Articulo") VALUES (51, 1, '01051', 'toner BT 5001M');
INSERT INTO "Articulos" ("IdArticulo", "IdRubro", "IdConcepto", "Articulo") VALUES (52, 1, '01052', 'toner BT 5001Y');
INSERT INTO "Articulos" ("IdArticulo", "IdRubro", "IdConcepto", "Articulo") VALUES (53, 1, '01053', 'toner BT D60 BK');
INSERT INTO "Articulos" ("IdArticulo", "IdRubro", "IdConcepto", "Articulo") VALUES (54, 1, '01054', 'toner CB435A-436A');
INSERT INTO "Articulos" ("IdArticulo", "IdRubro", "IdConcepto", "Articulo") VALUES (55, 1, '01055', 'toner samsung xpress M2020W');
INSERT INTO "Articulos" ("IdArticulo", "IdRubro", "IdConcepto", "Articulo") VALUES (56, 1, '01056', 'toner TH2612A');
INSERT INTO "Articulos" ("IdArticulo", "IdRubro", "IdConcepto", "Articulo") VALUES (57, 1, '01057', 'toner TN 580-650');
INSERT INTO "Articulos" ("IdArticulo", "IdRubro", "IdConcepto", "Articulo") VALUES (58, 1, '01058', 'voligoma (mediana');
INSERT INTO "Articulos" ("IdArticulo", "IdRubro", "IdConcepto", "Articulo") VALUES (1, 2, '02001', 'Azucar');
INSERT INTO "Articulos" ("IdArticulo", "IdRubro", "IdConcepto", "Articulo") VALUES (2, 2, '02002', 'Café');
INSERT INTO "Articulos" ("IdArticulo", "IdRubro", "IdConcepto", "Articulo") VALUES (3, 2, '02003', 'Te');
INSERT INTO "Articulos" ("IdArticulo", "IdRubro", "IdConcepto", "Articulo") VALUES (4, 2, '02004', 'Mate cocido');
INSERT INTO "Articulos" ("IdArticulo", "IdRubro", "IdConcepto", "Articulo") VALUES (5, 2, '02005', 'Edulcorante');
INSERT INTO "Articulos" ("IdArticulo", "IdRubro", "IdConcepto", "Articulo") VALUES (6, 2, '02006', 'Azucar en sobre');
INSERT INTO "Articulos" ("IdArticulo", "IdRubro", "IdConcepto", "Articulo") VALUES (7, 2, '02007', 'Agua');
INSERT INTO "Articulos" ("IdArticulo", "IdRubro", "IdConcepto", "Articulo") VALUES (1, 3, '03001', 'Lavandina');
INSERT INTO "Articulos" ("IdArticulo", "IdRubro", "IdConcepto", "Articulo") VALUES (2, 3, '03002', 'Desodorante piso');
INSERT INTO "Articulos" ("IdArticulo", "IdRubro", "IdConcepto", "Articulo") VALUES (3, 3, '03003', 'Esponja');
INSERT INTO "Articulos" ("IdArticulo", "IdRubro", "IdConcepto", "Articulo") VALUES (4, 3, '03004', 'Gamuza algodón para escritorios');
INSERT INTO "Articulos" ("IdArticulo", "IdRubro", "IdConcepto", "Articulo") VALUES (5, 3, '03005', 'Rejilla para limpieza baños y cocina');
INSERT INTO "Articulos" ("IdArticulo", "IdRubro", "IdConcepto", "Articulo") VALUES (6, 3, '03006', 'Escoba de paja');
INSERT INTO "Articulos" ("IdArticulo", "IdRubro", "IdConcepto", "Articulo") VALUES (7, 3, '03007', 'Escobillón');
INSERT INTO "Articulos" ("IdArticulo", "IdRubro", "IdConcepto", "Articulo") VALUES (8, 3, '03008', 'Haragán');
INSERT INTO "Articulos" ("IdArticulo", "IdRubro", "IdConcepto", "Articulo") VALUES (9, 3, '03009', 'Trapo piso');
INSERT INTO "Articulos" ("IdArticulo", "IdRubro", "IdConcepto", "Articulo") VALUES (10, 3, '03010', 'Rollo de cocina');
INSERT INTO "Articulos" ("IdArticulo", "IdRubro", "IdConcepto", "Articulo") VALUES (11, 3, '03011', 'Papel higiénico');
INSERT INTO "Articulos" ("IdArticulo", "IdRubro", "IdConcepto", "Articulo") VALUES (12, 3, '03012', 'Desinfectante ambiente en aerosol');
INSERT INTO "Articulos" ("IdArticulo", "IdRubro", "IdConcepto", "Articulo") VALUES (13, 3, '03013', 'Insecticida shelton');
INSERT INTO "Articulos" ("IdArticulo", "IdRubro", "IdConcepto", "Articulo") VALUES (14, 3, '03014', 'Alcohol en gel');
INSERT INTO "Articulos" ("IdArticulo", "IdRubro", "IdConcepto", "Articulo") VALUES (15, 3, '03015', 'Alcohol líquido');
INSERT INTO "Articulos" ("IdArticulo", "IdRubro", "IdConcepto", "Articulo") VALUES (16, 3, '03016', 'Guantes de látex para limpieza');


--
-- TOC entry 2036 (class 0 OID 0)
-- Dependencies: 174
-- Name: Cargas_IdCargas_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('"Cargas_IdCargas_seq"', 1, false);


--
-- TOC entry 2022 (class 0 OID 16934)
-- Dependencies: 184
-- Data for Name: Centros; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO "Centros" ("IdCentro", "Centro") VALUES (1, 'Administracion');
INSERT INTO "Centros" ("IdCentro", "Centro") VALUES (2, 'Asesoria legal');
INSERT INTO "Centros" ("IdCentro", "Centro") VALUES (3, 'Biblioteca');
INSERT INTO "Centros" ("IdCentro", "Centro") VALUES (4, 'Cartografia');
INSERT INTO "Centros" ("IdCentro", "Centro") VALUES (5, 'Computos');
INSERT INTO "Centros" ("IdCentro", "Centro") VALUES (6, 'Demografia');
INSERT INTO "Centros" ("IdCentro", "Centro") VALUES (7, 'EIL');
INSERT INTO "Centros" ("IdCentro", "Centro") VALUES (8, 'EOH');
INSERT INTO "Centros" ("IdCentro", "Centro") VALUES (9, 'EPH');
INSERT INTO "Centros" ("IdCentro", "Centro") VALUES (10, 'ICC');
INSERT INTO "Centros" ("IdCentro", "Centro") VALUES (11, 'IPC');
INSERT INTO "Centros" ("IdCentro", "Centro") VALUES (12, 'Indicadores sociodemograficos');
INSERT INTO "Centros" ("IdCentro", "Centro") VALUES (13, 'Mesa de entrada');
INSERT INTO "Centros" ("IdCentro", "Centro") VALUES (14, 'Permiso de edificacion');
INSERT INTO "Centros" ("IdCentro", "Centro") VALUES (15, 'Personal');
INSERT INTO "Centros" ("IdCentro", "Centro") VALUES (16, 'Sistema estadistico provincial');
INSERT INTO "Centros" ("IdCentro", "Centro") VALUES (17, 'Elvira - Limpieza ');
INSERT INTO "Centros" ("IdCentro", "Centro") VALUES (18, 'Gramajo - Limpieza');
INSERT INTO "Centros" ("IdCentro", "Centro") VALUES (19, 'Quipildor - Limpieza');


--
-- TOC entry 2037 (class 0 OID 0)
-- Dependencies: 175
-- Name: Centros_idcentro_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('"Centros_idcentro_seq"', 1, false);


--
-- TOC entry 2023 (class 0 OID 16941)
-- Dependencies: 185
-- Data for Name: Movimientos; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO "Movimientos" ("IdMovimiento", "FechaActual", "IdCentro", "Cantidad", "DescripUnidad", "IdAccion", "IdConcepto", "Unidad", "Motivo", "FechaMov") VALUES (1, '2024-12-14', 1, 100, 'Unidades', 1, '01001', 'Caja', 'Entrada de material', '2024-12-14');
INSERT INTO "Movimientos" ("IdMovimiento", "FechaActual", "IdCentro", "Cantidad", "DescripUnidad", "IdAccion", "IdConcepto", "Unidad", "Motivo", "FechaMov") VALUES (2, '2024-12-14', 1, 50, 'Unidades', 2, '02002', 'Sobre', 'Salida de material', '2024-12-14');
INSERT INTO "Movimientos" ("IdMovimiento", "FechaActual", "IdCentro", "Cantidad", "DescripUnidad", "IdAccion", "IdConcepto", "Unidad", "Motivo", "FechaMov") VALUES (3, '2024-12-14', 2, 200, 'Unidades', 1, '03001', 'Botellas', 'Entrada de material', '2024-12-14');
INSERT INTO "Movimientos" ("IdMovimiento", "FechaActual", "IdCentro", "Cantidad", "DescripUnidad", "IdAccion", "IdConcepto", "Unidad", "Motivo", "FechaMov") VALUES (4, '2024-12-14', 3, 150, 'Unidades', 2, '01004', 'Cajas', 'Salida de material', '2024-12-14');
INSERT INTO "Movimientos" ("IdMovimiento", "FechaActual", "IdCentro", "Cantidad", "DescripUnidad", "IdAccion", "IdConcepto", "Unidad", "Motivo", "FechaMov") VALUES (5, '2024-12-14', 4, 75, 'Unidades', 1, '02003', 'Sacos', 'Entrada de material', '2024-12-14');
INSERT INTO "Movimientos" ("IdMovimiento", "FechaActual", "IdCentro", "Cantidad", "DescripUnidad", "IdAccion", "IdConcepto", "Unidad", "Motivo", "FechaMov") VALUES (6, '2024-12-14', 5, 80, 'Unidades', 2, '03005', 'Bolsas', 'Salida de material', '2024-12-14');
INSERT INTO "Movimientos" ("IdMovimiento", "FechaActual", "IdCentro", "Cantidad", "DescripUnidad", "IdAccion", "IdConcepto", "Unidad", "Motivo", "FechaMov") VALUES (7, '2024-12-14', 6, 60, 'Unidades', 1, '01002', 'Paquete', 'Entrada de material', '2024-12-14');
INSERT INTO "Movimientos" ("IdMovimiento", "FechaActual", "IdCentro", "Cantidad", "DescripUnidad", "IdAccion", "IdConcepto", "Unidad", "Motivo", "FechaMov") VALUES (8, '2024-12-14', 7, 90, 'Unidades', 2, '03007', 'Contenedores', 'Salida de material', '2024-12-14');
INSERT INTO "Movimientos" ("IdMovimiento", "FechaActual", "IdCentro", "Cantidad", "DescripUnidad", "IdAccion", "IdConcepto", "Unidad", "Motivo", "FechaMov") VALUES (9, '2024-12-14', 8, 120, 'Unidades', 1, '01012', 'Carros', 'Entrada de material', '2024-12-14');
INSERT INTO "Movimientos" ("IdMovimiento", "FechaActual", "IdCentro", "Cantidad", "DescripUnidad", "IdAccion", "IdConcepto", "Unidad", "Motivo", "FechaMov") VALUES (10, '2024-12-14', 9, 110, 'Unidades', 2, '03011', 'Aspiradoras', 'Salida de material', '2024-12-14');
INSERT INTO "Movimientos" ("IdMovimiento", "FechaActual", "IdCentro", "Cantidad", "DescripUnidad", "IdAccion", "IdConcepto", "Unidad", "Motivo", "FechaMov") VALUES (11, '2024-12-14', 4, 1, '-', 1, '01008', '-', '-', '2024-12-12');


--
-- TOC entry 2038 (class 0 OID 0)
-- Dependencies: 172
-- Name: Movimientos_IdMovimientos_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('"Movimientos_IdMovimientos_seq"', 11, true);


--
-- TOC entry 2024 (class 0 OID 16949)
-- Dependencies: 186
-- Data for Name: Roles; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO "Roles" ("IdRol", "Rol", "Descripcion") VALUES (1, 'administrador', ' ');
INSERT INTO "Roles" ("IdRol", "Rol", "Descripcion") VALUES (2, 'usuario', ' ');
INSERT INTO "Roles" ("IdRol", "Rol", "Descripcion") VALUES (3, 'lector', ' ');


--
-- TOC entry 2039 (class 0 OID 0)
-- Dependencies: 176
-- Name: Roles_IdRol_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('"Roles_IdRol_seq"', 1, false);


--
-- TOC entry 2025 (class 0 OID 16955)
-- Dependencies: 187
-- Data for Name: Rubros; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO "Rubros" ("IdRubro", "Rubro") VALUES (1, 'Librería');
INSERT INTO "Rubros" ("IdRubro", "Rubro") VALUES (2, 'Alimentos');
INSERT INTO "Rubros" ("IdRubro", "Rubro") VALUES (3, 'Limpieza');


--
-- TOC entry 2026 (class 0 OID 16958)
-- Dependencies: 188
-- Data for Name: Usuarios; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO "Usuarios" ("IdUsuario", "IdRol", "Usuario", "Password") VALUES (5, 1, 'administrador', '0a2a58cccf143acc6c360e892af6137e');
INSERT INTO "Usuarios" ("IdUsuario", "IdRol", "Usuario", "Password") VALUES (6, 2, 'usuario', '401cec94d3ed586d8cb895c10c0f7db6');
INSERT INTO "Usuarios" ("IdUsuario", "IdRol", "Usuario", "Password") VALUES (7, 3, 'lector', '250dcaeace0463fb5ddf02cf752593ec');


--
-- TOC entry 2040 (class 0 OID 0)
-- Dependencies: 177
-- Name: Usuarios_IdRol_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('"Usuarios_IdRol_seq"', 1, false);


--
-- TOC entry 2041 (class 0 OID 0)
-- Dependencies: 178
-- Name: Usuarios_IdUsuarios_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('"Usuarios_IdUsuarios_seq"', 1, false);


--
-- TOC entry 2042 (class 0 OID 0)
-- Dependencies: 171
-- Name: centros_idcentro_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('centros_idcentro_seq', 1, false);


--
-- TOC entry 2043 (class 0 OID 0)
-- Dependencies: 170
-- Name: oficinas_idoficina_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('oficinas_idoficina_seq', 1, false);


--
-- TOC entry 2044 (class 0 OID 0)
-- Dependencies: 179
-- Name: seq_alimentos; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('seq_alimentos', 7, true);


--
-- TOC entry 2045 (class 0 OID 0)
-- Dependencies: 180
-- Name: seq_libreria; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('seq_libreria', 58, true);


--
-- TOC entry 2046 (class 0 OID 0)
-- Dependencies: 181
-- Name: seq_limpieza; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('seq_limpieza', 16, true);


--
-- TOC entry 1882 (class 2606 OID 16962)
-- Name: Acciones_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY "Acciones"
    ADD CONSTRAINT "Acciones_pkey" PRIMARY KEY ("IdAccion");


--
-- TOC entry 1884 (class 2606 OID 16964)
-- Name: Articulos_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY "Articulos"
    ADD CONSTRAINT "Articulos_pkey" PRIMARY KEY ("IdConcepto");


--
-- TOC entry 1886 (class 2606 OID 16966)
-- Name: Centros_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY "Centros"
    ADD CONSTRAINT "Centros_pkey" PRIMARY KEY ("IdCentro");


--
-- TOC entry 1888 (class 2606 OID 16968)
-- Name: Movimientos_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY "Movimientos"
    ADD CONSTRAINT "Movimientos_pkey" PRIMARY KEY ("IdMovimiento");


--
-- TOC entry 1890 (class 2606 OID 16970)
-- Name: Roles_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY "Roles"
    ADD CONSTRAINT "Roles_pkey" PRIMARY KEY ("IdRol");


--
-- TOC entry 1892 (class 2606 OID 16972)
-- Name: Rubros_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY "Rubros"
    ADD CONSTRAINT "Rubros_pkey" PRIMARY KEY ("IdRubro");


--
-- TOC entry 1894 (class 2606 OID 16974)
-- Name: Usuarios_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY "Usuarios"
    ADD CONSTRAINT "Usuarios_pkey" PRIMARY KEY ("IdUsuario");


--
-- TOC entry 1900 (class 2620 OID 17004)
-- Name: before_insert_articulos; Type: TRIGGER; Schema: public; Owner: postgres
--

CREATE TRIGGER before_insert_articulos BEFORE INSERT ON public."Articulos" FOR EACH ROW EXECUTE PROCEDURE generate_id_concepto();


--
-- TOC entry 1895 (class 2606 OID 16975)
-- Name: fk_articulos_rubro; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY "Articulos"
    ADD CONSTRAINT fk_articulos_rubro FOREIGN KEY ("IdRubro") REFERENCES "Rubros"("IdRubro");


--
-- TOC entry 1896 (class 2606 OID 16980)
-- Name: fk_movimientos_accion; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY "Movimientos"
    ADD CONSTRAINT fk_movimientos_accion FOREIGN KEY ("IdAccion") REFERENCES "Acciones"("IdAccion");


--
-- TOC entry 1898 (class 2606 OID 16999)
-- Name: fk_movimientos_articulos; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY "Movimientos"
    ADD CONSTRAINT fk_movimientos_articulos FOREIGN KEY ("IdConcepto") REFERENCES "Articulos"("IdConcepto");


--
-- TOC entry 1897 (class 2606 OID 16985)
-- Name: fk_movimientos_centro; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY "Movimientos"
    ADD CONSTRAINT fk_movimientos_centro FOREIGN KEY ("IdCentro") REFERENCES "Centros"("IdCentro");


--
-- TOC entry 1899 (class 2606 OID 16990)
-- Name: fk_usuarios_rol; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY "Usuarios"
    ADD CONSTRAINT fk_usuarios_rol FOREIGN KEY ("IdRol") REFERENCES "Roles"("IdRol");


--
-- TOC entry 2033 (class 0 OID 0)
-- Dependencies: 5
-- Name: public; Type: ACL; Schema: -; Owner: postgres
--

REVOKE ALL ON SCHEMA public FROM PUBLIC;
REVOKE ALL ON SCHEMA public FROM postgres;
GRANT ALL ON SCHEMA public TO postgres;
GRANT ALL ON SCHEMA public TO PUBLIC;


-- Completed on 2024-12-14 09:29:48

--
-- PostgreSQL database dump complete
--

