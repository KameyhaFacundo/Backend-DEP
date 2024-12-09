PGDMP  #    8    
        
    |            depStock    17.0    17.2 =    6           0    0    ENCODING    ENCODING        SET client_encoding = 'UTF8';
                           false            7           0    0 
   STDSTRINGS 
   STDSTRINGS     (   SET standard_conforming_strings = 'on';
                           false            8           0    0 
   SEARCHPATH 
   SEARCHPATH     8   SELECT pg_catalog.set_config('search_path', '', false);
                           false            9           1262    32781    depStock    DATABASE     }   CREATE DATABASE "depStock" WITH TEMPLATE = template0 ENCODING = 'UTF8' LOCALE_PROVIDER = libc LOCALE = 'Spanish_Spain.1252';
    DROP DATABASE "depStock";
                     postgres    false                        2615    2200    public    SCHEMA        CREATE SCHEMA public;
    DROP SCHEMA public;
                     pg_database_owner    false            :           0    0    SCHEMA public    COMMENT     6   COMMENT ON SCHEMA public IS 'standard public schema';
                        pg_database_owner    false    4            �            1259    32971    Acciones_IdAccion_seq    SEQUENCE     �   CREATE SEQUENCE public."Acciones_IdAccion_seq"
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    MAXVALUE 32767
    CACHE 1;
 .   DROP SEQUENCE public."Acciones_IdAccion_seq";
       public               postgres    false    4            �            1259    32806    Acciones    TABLE     �   CREATE TABLE public."Acciones" (
    "IdAccion" smallint DEFAULT nextval('public."Acciones_IdAccion_seq"'::regclass) NOT NULL,
    "Accion" character varying(120) NOT NULL
);
    DROP TABLE public."Acciones";
       public         heap r       postgres    false    231    4            �            1259    32889 	   Articulos    TABLE     �   CREATE TABLE public."Articulos" (
    "IdConcepto" text NOT NULL,
    "IdArticulo" integer NOT NULL,
    "IdRubro" smallint NOT NULL,
    "Articulo" character varying(200) NOT NULL
);
    DROP TABLE public."Articulos";
       public         heap r       postgres    false    4            �            1259    32888    Articulos_IdArticulo_seq    SEQUENCE     �   CREATE SEQUENCE public."Articulos_IdArticulo_seq"
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 1   DROP SEQUENCE public."Articulos_IdArticulo_seq";
       public               postgres    false    224    4            ;           0    0    Articulos_IdArticulo_seq    SEQUENCE OWNED BY     [   ALTER SEQUENCE public."Articulos_IdArticulo_seq" OWNED BY public."Articulos"."IdArticulo";
          public               postgres    false    223            �            1259    32812    Movimientos    TABLE     �  CREATE TABLE public."Movimientos" (
    "IdMovimiento" integer NOT NULL,
    "Fecha" date DEFAULT CURRENT_DATE NOT NULL,
    "IdCentro" integer NOT NULL,
    "Cantidad" integer NOT NULL,
    "DescripUnidad" character varying(150),
    "IdAccion" smallint NOT NULL,
    "IdConcepto" text NOT NULL,
    "Unidad" character varying(100),
    "IdUsuario" integer NOT NULL,
    "Hora" time without time zone DEFAULT CURRENT_TIME NOT NULL,
    "Motivo" text
);
 !   DROP TABLE public."Movimientos";
       public         heap r       postgres    false    4            �            1259    32811    Cargas_IdCargas_seq    SEQUENCE     �   CREATE SEQUENCE public."Cargas_IdCargas_seq"
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 ,   DROP SEQUENCE public."Cargas_IdCargas_seq";
       public               postgres    false    4    221            <           0    0    Cargas_IdCargas_seq    SEQUENCE OWNED BY     Z   ALTER SEQUENCE public."Cargas_IdCargas_seq" OWNED BY public."Movimientos"."IdMovimiento";
          public               postgres    false    220            �            1259    32833    oficinas_idoficina_seq    SEQUENCE        CREATE SEQUENCE public.oficinas_idoficina_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 -   DROP SEQUENCE public.oficinas_idoficina_seq;
       public               postgres    false    4            �            1259    32799    Centros    TABLE     �   CREATE TABLE public."Centros" (
    "IdCentro" integer DEFAULT nextval('public.oficinas_idoficina_seq'::regclass) NOT NULL,
    "Centro" character varying NOT NULL
);
    DROP TABLE public."Centros";
       public         heap r       postgres    false    222    4            �            1259    32945    Movimientos_IdUsuario_seq    SEQUENCE     �   CREATE SEQUENCE public."Movimientos_IdUsuario_seq"
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 2   DROP SEQUENCE public."Movimientos_IdUsuario_seq";
       public               postgres    false    221    4            =           0    0    Movimientos_IdUsuario_seq    SEQUENCE OWNED BY     ]   ALTER SEQUENCE public."Movimientos_IdUsuario_seq" OWNED BY public."Movimientos"."IdUsuario";
          public               postgres    false    230            �            1259    32920    Roles    TABLE     �   CREATE TABLE public."Roles" (
    "IdRol" integer NOT NULL,
    "Rol" character varying(100) NOT NULL,
    "Descripcion" text
);
    DROP TABLE public."Roles";
       public         heap r       postgres    false    4            �            1259    32919    Roles_IdRol_seq    SEQUENCE     �   CREATE SEQUENCE public."Roles_IdRol_seq"
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 (   DROP SEQUENCE public."Roles_IdRol_seq";
       public               postgres    false    4    227            >           0    0    Roles_IdRol_seq    SEQUENCE OWNED BY     I   ALTER SEQUENCE public."Roles_IdRol_seq" OWNED BY public."Roles"."IdRol";
          public               postgres    false    226            �            1259    32789    Rubros    TABLE     o   CREATE TABLE public."Rubros" (
    "IdRubro" smallint NOT NULL,
    "Rubro" character varying(120) NOT NULL
);
    DROP TABLE public."Rubros";
       public         heap r       postgres    false    4            �            1259    32916    Usuarios    TABLE     �   CREATE TABLE public."Usuarios" (
    "IdUsuario" integer NOT NULL,
    "IdRol" integer NOT NULL,
    "Usuario" character varying(120) NOT NULL,
    "Password" character varying(250) NOT NULL
);
    DROP TABLE public."Usuarios";
       public         heap r       postgres    false    4            �            1259    32933    Usuarios_IdRol_seq    SEQUENCE     �   CREATE SEQUENCE public."Usuarios_IdRol_seq"
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 +   DROP SEQUENCE public."Usuarios_IdRol_seq";
       public               postgres    false    4    225            ?           0    0    Usuarios_IdRol_seq    SEQUENCE OWNED BY     O   ALTER SEQUENCE public."Usuarios_IdRol_seq" OWNED BY public."Usuarios"."IdRol";
          public               postgres    false    229            �            1259    32928    Usuarios_IdUsuarios_seq    SEQUENCE     �   CREATE SEQUENCE public."Usuarios_IdUsuarios_seq"
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 0   DROP SEQUENCE public."Usuarios_IdUsuarios_seq";
       public               postgres    false    225    4            @           0    0    Usuarios_IdUsuarios_seq    SEQUENCE OWNED BY     X   ALTER SEQUENCE public."Usuarios_IdUsuarios_seq" OWNED BY public."Usuarios"."IdUsuario";
          public               postgres    false    228            |           2604    32892    Articulos IdArticulo    DEFAULT     �   ALTER TABLE ONLY public."Articulos" ALTER COLUMN "IdArticulo" SET DEFAULT nextval('public."Articulos_IdArticulo_seq"'::regclass);
 G   ALTER TABLE public."Articulos" ALTER COLUMN "IdArticulo" DROP DEFAULT;
       public               postgres    false    223    224    224            x           2604    32815    Movimientos IdMovimiento    DEFAULT     �   ALTER TABLE ONLY public."Movimientos" ALTER COLUMN "IdMovimiento" SET DEFAULT nextval('public."Cargas_IdCargas_seq"'::regclass);
 K   ALTER TABLE public."Movimientos" ALTER COLUMN "IdMovimiento" DROP DEFAULT;
       public               postgres    false    220    221    221            z           2604    32946    Movimientos IdUsuario    DEFAULT     �   ALTER TABLE ONLY public."Movimientos" ALTER COLUMN "IdUsuario" SET DEFAULT nextval('public."Movimientos_IdUsuario_seq"'::regclass);
 H   ALTER TABLE public."Movimientos" ALTER COLUMN "IdUsuario" DROP DEFAULT;
       public               postgres    false    230    221                       2604    32923    Roles IdRol    DEFAULT     p   ALTER TABLE ONLY public."Roles" ALTER COLUMN "IdRol" SET DEFAULT nextval('public."Roles_IdRol_seq"'::regclass);
 >   ALTER TABLE public."Roles" ALTER COLUMN "IdRol" DROP DEFAULT;
       public               postgres    false    226    227    227            }           2604    32929    Usuarios IdUsuario    DEFAULT        ALTER TABLE ONLY public."Usuarios" ALTER COLUMN "IdUsuario" SET DEFAULT nextval('public."Usuarios_IdUsuarios_seq"'::regclass);
 E   ALTER TABLE public."Usuarios" ALTER COLUMN "IdUsuario" DROP DEFAULT;
       public               postgres    false    228    225            ~           2604    32934    Usuarios IdRol    DEFAULT     v   ALTER TABLE ONLY public."Usuarios" ALTER COLUMN "IdRol" SET DEFAULT nextval('public."Usuarios_IdRol_seq"'::regclass);
 A   ALTER TABLE public."Usuarios" ALTER COLUMN "IdRol" DROP DEFAULT;
       public               postgres    false    229    225            '          0    32806    Acciones 
   TABLE DATA                 public               postgres    false    219   'F       ,          0    32889 	   Articulos 
   TABLE DATA                 public               postgres    false    224   �F       &          0    32799    Centros 
   TABLE DATA                 public               postgres    false    218   ;L       )          0    32812    Movimientos 
   TABLE DATA                 public               postgres    false    221   M       /          0    32920    Roles 
   TABLE DATA                 public               postgres    false    227   �M       %          0    32789    Rubros 
   TABLE DATA                 public               postgres    false    217   N       -          0    32916    Usuarios 
   TABLE DATA                 public               postgres    false    225   �N       A           0    0    Acciones_IdAccion_seq    SEQUENCE SET     E   SELECT pg_catalog.setval('public."Acciones_IdAccion_seq"', 2, true);
          public               postgres    false    231            B           0    0    Articulos_IdArticulo_seq    SEQUENCE SET     I   SELECT pg_catalog.setval('public."Articulos_IdArticulo_seq"', 1, false);
          public               postgres    false    223            C           0    0    Cargas_IdCargas_seq    SEQUENCE SET     D   SELECT pg_catalog.setval('public."Cargas_IdCargas_seq"', 1, false);
          public               postgres    false    220            D           0    0    Movimientos_IdUsuario_seq    SEQUENCE SET     J   SELECT pg_catalog.setval('public."Movimientos_IdUsuario_seq"', 1, false);
          public               postgres    false    230            E           0    0    Roles_IdRol_seq    SEQUENCE SET     @   SELECT pg_catalog.setval('public."Roles_IdRol_seq"', 1, false);
          public               postgres    false    226            F           0    0    Usuarios_IdRol_seq    SEQUENCE SET     C   SELECT pg_catalog.setval('public."Usuarios_IdRol_seq"', 1, false);
          public               postgres    false    229            G           0    0    Usuarios_IdUsuarios_seq    SEQUENCE SET     H   SELECT pg_catalog.setval('public."Usuarios_IdUsuarios_seq"', 1, false);
          public               postgres    false    228            H           0    0    oficinas_idoficina_seq    SEQUENCE SET     E   SELECT pg_catalog.setval('public.oficinas_idoficina_seq', 1, false);
          public               postgres    false    222            �           2606    32810    Acciones Acciones_pkey 
   CONSTRAINT     `   ALTER TABLE ONLY public."Acciones"
    ADD CONSTRAINT "Acciones_pkey" PRIMARY KEY ("IdAccion");
 D   ALTER TABLE ONLY public."Acciones" DROP CONSTRAINT "Acciones_pkey";
       public                 postgres    false    219            �           2606    32896    Articulos Articulos_pkey 
   CONSTRAINT     d   ALTER TABLE ONLY public."Articulos"
    ADD CONSTRAINT "Articulos_pkey" PRIMARY KEY ("IdConcepto");
 F   ALTER TABLE ONLY public."Articulos" DROP CONSTRAINT "Articulos_pkey";
       public                 postgres    false    224            �           2606    32817    Movimientos Cargas_pkey 
   CONSTRAINT     e   ALTER TABLE ONLY public."Movimientos"
    ADD CONSTRAINT "Cargas_pkey" PRIMARY KEY ("IdMovimiento");
 E   ALTER TABLE ONLY public."Movimientos" DROP CONSTRAINT "Cargas_pkey";
       public                 postgres    false    221            �           2606    32805    Centros Centro_pkey 
   CONSTRAINT     ]   ALTER TABLE ONLY public."Centros"
    ADD CONSTRAINT "Centro_pkey" PRIMARY KEY ("IdCentro");
 A   ALTER TABLE ONLY public."Centros" DROP CONSTRAINT "Centro_pkey";
       public                 postgres    false    218            �           2606    32927    Roles Roles_pkey 
   CONSTRAINT     W   ALTER TABLE ONLY public."Roles"
    ADD CONSTRAINT "Roles_pkey" PRIMARY KEY ("IdRol");
 >   ALTER TABLE ONLY public."Roles" DROP CONSTRAINT "Roles_pkey";
       public                 postgres    false    227            �           2606    32793    Rubros Rubros_pkey 
   CONSTRAINT     [   ALTER TABLE ONLY public."Rubros"
    ADD CONSTRAINT "Rubros_pkey" PRIMARY KEY ("IdRubro");
 @   ALTER TABLE ONLY public."Rubros" DROP CONSTRAINT "Rubros_pkey";
       public                 postgres    false    217            �           2606    32939    Usuarios Usuarios_pkey 
   CONSTRAINT     a   ALTER TABLE ONLY public."Usuarios"
    ADD CONSTRAINT "Usuarios_pkey" PRIMARY KEY ("IdUsuario");
 D   ALTER TABLE ONLY public."Usuarios" DROP CONSTRAINT "Usuarios_pkey";
       public                 postgres    false    225            �           2606    32897    Articulos articulo_rubro_fkey    FK CONSTRAINT     �   ALTER TABLE ONLY public."Articulos"
    ADD CONSTRAINT articulo_rubro_fkey FOREIGN KEY ("IdRubro") REFERENCES public."Rubros"("IdRubro");
 I   ALTER TABLE ONLY public."Articulos" DROP CONSTRAINT articulo_rubro_fkey;
       public               postgres    false    224    4737    217            �           2606    32828 "   Movimientos movimiento_accion_fkey    FK CONSTRAINT     �   ALTER TABLE ONLY public."Movimientos"
    ADD CONSTRAINT movimiento_accion_fkey FOREIGN KEY ("IdAccion") REFERENCES public."Acciones"("IdAccion") NOT VALID;
 N   ALTER TABLE ONLY public."Movimientos" DROP CONSTRAINT movimiento_accion_fkey;
       public               postgres    false    221    4741    219            �           2606    32902 $   Movimientos movimiento_articulo_fkey    FK CONSTRAINT     �   ALTER TABLE ONLY public."Movimientos"
    ADD CONSTRAINT movimiento_articulo_fkey FOREIGN KEY ("IdConcepto") REFERENCES public."Articulos"("IdConcepto") NOT VALID;
 P   ALTER TABLE ONLY public."Movimientos" DROP CONSTRAINT movimiento_articulo_fkey;
       public               postgres    false    224    221    4745            �           2606    32823 "   Movimientos movimiento_centro_fkey    FK CONSTRAINT     �   ALTER TABLE ONLY public."Movimientos"
    ADD CONSTRAINT movimiento_centro_fkey FOREIGN KEY ("IdCentro") REFERENCES public."Centros"("IdCentro");
 N   ALTER TABLE ONLY public."Movimientos" DROP CONSTRAINT movimiento_centro_fkey;
       public               postgres    false    4739    218    221            �           2606    32953 #   Movimientos movimiento_usuario_fkey    FK CONSTRAINT     �   ALTER TABLE ONLY public."Movimientos"
    ADD CONSTRAINT movimiento_usuario_fkey FOREIGN KEY ("IdUsuario") REFERENCES public."Usuarios"("IdUsuario") ON UPDATE CASCADE ON DELETE CASCADE NOT VALID;
 O   ALTER TABLE ONLY public."Movimientos" DROP CONSTRAINT movimiento_usuario_fkey;
       public               postgres    false    221    4747    225            �           2606    32940    Usuarios usuario_rol_fkey    FK CONSTRAINT     �   ALTER TABLE ONLY public."Usuarios"
    ADD CONSTRAINT usuario_rol_fkey FOREIGN KEY ("IdRol") REFERENCES public."Roles"("IdRol") ON UPDATE CASCADE ON DELETE CASCADE NOT VALID;
 E   ALTER TABLE ONLY public."Usuarios" DROP CONSTRAINT usuario_rol_fkey;
       public               postgres    false    227    4749    225            '   Y   x���v
Q���W((M��L�SrLN���K-VR�P�L��t��J�
a�>���
�:
�y%E�)���\���e4+81'b �.+�      ,   �  x���MSG���S\�);ޝ��r26T ���$�fwC��lfw]6���9�r�1�c��@¦r��(J龎�{>�NgKqt�|'��2��;3כb�l�#�v�ʹm
��v��g���Άs7>�{���8;�p�{�QE���?�3|kq	�u ��U�>�����Kԗ����U�!�P^����n�
D��Ue9L$h"	&4�����~�O#�
���NRt�z'��=NE�2
gA��@�����O�A�� ~J�,㑣��;[��[�5ٴ�G3؇��	?�dm�֦�c����Y�mkEeڎ�4��Ę�Ј��C{Tń�X>�g���8�����j}���A�t=Tb�px!D�ɝ��M?`�C�^�ϭ.�nz��PV�M�c%Θ����8�T�CP�CN�A���%��8�v����8<�Pj�X�K�C�p\|A�qx!��Ӈ^�/�����=��
:o�,��zL���V���a��ӌ���2p�LwP�T��o�le����}c����$�J��k/La8bUTe��[[cӋto�5�6�S�w�D��'I�h�q�CFe��!Ż��+]��[�M��:�< ��@�CSٻb�Q z�)4��v%G5��M9�V�\��{EhT�C�F���+b���;&+��
�;0~w��S��������`*�s��Yد��*p�\A���	U���}�Y���t�s}�" � ���]�r���҄?�ߵ5�T`E�S�M]�
�{*`o��ZQ�l9r>!�%ѽv;`�΢L�K���'.��@�P'�%�u��>,Xjj���.!�%�Q��͏�q�>��P�.y������.͕fNB�K�[ջ5����K�ؓiTW�hB�K�G�P#�i���&.m�6�S1�&$&�-��PN	�i������xΡNPL���p�S��?8ԉ��z��:�������4ٔ��'*��LT�y�O�i`u74+�;-?;q"#��a���f�V��2�%�8�|K�T���e�r��Ҁ��ؒ�,v�{�.4[�����Hvwv��V��`�O������b��C��>���G�2=�^�z�_,�ư�G�����P�
8�*d8�M��J�Ft�wr�SZgi�_O��)�HY6^.�=�OД�aS)�¯ugK?ϸ��>�TȪ��?�Z�\�|�1��^�-��5�V����h�+��3�[��-���3}uJX��5�ӱG'����J�<����q��3E�e
�������!M�5W^�ga��aѥ�D�xݥ��r��x�!OC�YZÕ�/�ƻy���qAiVf���8MP�.C~OA�\�9��xFO����8�ţ�C7+?�ť�z����< r����V4+�2 �I��^��v}b�$���@�0�V�^�F3�y��?��KZ      &   4  x���=O�0�=�┥�Tʇ�J��Rh)�Gl�Cq.���z�H���َ��r�7jY.^7�����GM�i���s�S�J&�������ۢ�q6��\[j�w+�f4�K�@<��7�!�f��T��=�=ܙ
��e�rto~���E�m�w��U���d�A[�B��Df�$en#�3�YpT���|��;1��T�fg<x%ҿ���"��6A�Q��������y�j
g����@{n���b#��k2��u�K��񎚊xž&���	d[2�b6��ѡ�/���X���Z�C���I��Z�.      )   
   x���          /   u   x���v
Q���W((M��L�S
��I-VR�P�L2�t���KjqrQfArf~���B��O�k�������cJnf^fqIQbJ~�:P@A]Ӛ˓rÍ�f��&e�S�Xc���ps�� �HL�      %   i   x���v
Q���W((M��L�S
*M*�/VR�P�L��t �J�
a�>���
�:
�>�IE�E��&�kZsy�k��$ǜ��Լ��b�L2�)� 3�
�$.. iA�      -   ~   x���v
Q���W((M��L�S
-.M,��/VR�P�L��t����I, ���<�(EIS!��'�5XA�PG��Sr3�2�K�S�ԁ�F�&��\�4��HG�ԡ�hm�1�m���qq C�b`     