--
-- PostgreSQL database dump
--

-- Dumped from database version 14.5
-- Dumped by pg_dump version 14.5

-- Started on 2022-10-17 09:03:37

SET statement_timeout = 0;
SET lock_timeout = 0;
SET idle_in_transaction_session_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SELECT pg_catalog.set_config('search_path', '', false);
SET check_function_bodies = false;
SET xmloption = content;
SET client_min_messages = warning;
SET row_security = off;

SET default_tablespace = '';

SET default_table_access_method = heap;

--
-- TOC entry 210 (class 1259 OID 16400)
-- Name: Product; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public."Product" (
    id integer NOT NULL,
    name character varying(50) NOT NULL,
    quantity integer NOT NULL,
    producttype_id integer,
    price double precision
);


ALTER TABLE public."Product" OWNER TO postgres;

--
-- TOC entry 209 (class 1259 OID 16395)
-- Name: ProductType; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public."ProductType" (
    id integer NOT NULL,
    name character varying(50) NOT NULL,
    tax double precision
);


ALTER TABLE public."ProductType" OWNER TO postgres;

--
-- TOC entry 216 (class 1259 OID 16433)
-- Name: ProductType_Sequence; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public."ProductType_Sequence"
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public."ProductType_Sequence" OWNER TO postgres;

--
-- TOC entry 3342 (class 0 OID 0)
-- Dependencies: 216
-- Name: ProductType_Sequence; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public."ProductType_Sequence" OWNED BY public."ProductType".id;


--
-- TOC entry 212 (class 1259 OID 16415)
-- Name: Product_Sale; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public."Product_Sale" (
    id integer NOT NULL,
    product_id integer NOT NULL,
    sale_id integer NOT NULL,
    quantity integer
);


ALTER TABLE public."Product_Sale" OWNER TO postgres;

--
-- TOC entry 215 (class 1259 OID 16432)
-- Name: Product_Sale_Sequence; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public."Product_Sale_Sequence"
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public."Product_Sale_Sequence" OWNER TO postgres;

--
-- TOC entry 3343 (class 0 OID 0)
-- Dependencies: 215
-- Name: Product_Sale_Sequence; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public."Product_Sale_Sequence" OWNED BY public."Product_Sale".id;


--
-- TOC entry 213 (class 1259 OID 16430)
-- Name: Product_Sequence; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public."Product_Sequence"
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public."Product_Sequence" OWNER TO postgres;

--
-- TOC entry 3344 (class 0 OID 0)
-- Dependencies: 213
-- Name: Product_Sequence; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public."Product_Sequence" OWNED BY public."Product".id;


--
-- TOC entry 211 (class 1259 OID 16410)
-- Name: Sale; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public."Sale" (
    id integer NOT NULL,
    "quantityItems" integer NOT NULL,
    "totalValue" double precision,
    "totalTax" double precision,
    "createdAt" timestamp without time zone
);


ALTER TABLE public."Sale" OWNER TO postgres;

--
-- TOC entry 214 (class 1259 OID 16431)
-- Name: Sale_Sequence; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public."Sale_Sequence"
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public."Sale_Sequence" OWNER TO postgres;

--
-- TOC entry 3345 (class 0 OID 0)
-- Dependencies: 214
-- Name: Sale_Sequence; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public."Sale_Sequence" OWNED BY public."Sale".id;


--
-- TOC entry 3330 (class 0 OID 16400)
-- Dependencies: 210
-- Data for Name: Product; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public."Product" (id, name, quantity, producttype_id, price) FROM stdin;
3	Sprite em Lata	30	1	3.99
2	Coca 2L	7	2	9.99
5	teste	1	1	2
4	Cerveja	300	3	3.99
6	teste	12	2	3.1
1	Coca em Lata	5	1	3.49
\.


--
-- TOC entry 3329 (class 0 OID 16395)
-- Dependencies: 209
-- Data for Name: ProductType; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public."ProductType" (id, name, tax) FROM stdin;
3	Bebida Alcoolica	10
1	Lata	15
2	Garrafa	20
\.


--
-- TOC entry 3332 (class 0 OID 16415)
-- Dependencies: 212
-- Data for Name: Product_Sale; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public."Product_Sale" (id, product_id, sale_id, quantity) FROM stdin;
\.


--
-- TOC entry 3331 (class 0 OID 16410)
-- Dependencies: 211
-- Data for Name: Sale; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public."Sale" (id, "quantityItems", "totalValue", "totalTax", "createdAt") FROM stdin;
\.


--
-- TOC entry 3346 (class 0 OID 0)
-- Dependencies: 216
-- Name: ProductType_Sequence; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public."ProductType_Sequence"', 1, false);


--
-- TOC entry 3347 (class 0 OID 0)
-- Dependencies: 215
-- Name: Product_Sale_Sequence; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public."Product_Sale_Sequence"', 1, false);


--
-- TOC entry 3348 (class 0 OID 0)
-- Dependencies: 213
-- Name: Product_Sequence; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public."Product_Sequence"', 1, false);


--
-- TOC entry 3349 (class 0 OID 0)
-- Dependencies: 214
-- Name: Sale_Sequence; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public."Sale_Sequence"', 1, false);


--
-- TOC entry 3180 (class 2606 OID 16399)
-- Name: ProductType ProductType_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public."ProductType"
    ADD CONSTRAINT "ProductType_pkey" PRIMARY KEY (id);


--
-- TOC entry 3186 (class 2606 OID 16419)
-- Name: Product_Sale Product_Sale_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public."Product_Sale"
    ADD CONSTRAINT "Product_Sale_pkey" PRIMARY KEY (id);


--
-- TOC entry 3182 (class 2606 OID 16404)
-- Name: Product Product_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public."Product"
    ADD CONSTRAINT "Product_pkey" PRIMARY KEY (id);


--
-- TOC entry 3184 (class 2606 OID 16414)
-- Name: Sale Sale_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public."Sale"
    ADD CONSTRAINT "Sale_pkey" PRIMARY KEY (id);


--
-- TOC entry 3188 (class 2606 OID 16420)
-- Name: Product_Sale product_id; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public."Product_Sale"
    ADD CONSTRAINT product_id FOREIGN KEY (product_id) REFERENCES public."Product"(id);


--
-- TOC entry 3187 (class 2606 OID 16405)
-- Name: Product producttype_id; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public."Product"
    ADD CONSTRAINT producttype_id FOREIGN KEY (producttype_id) REFERENCES public."ProductType"(id);


--
-- TOC entry 3189 (class 2606 OID 16425)
-- Name: Product_Sale sale_id; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public."Product_Sale"
    ADD CONSTRAINT sale_id FOREIGN KEY (sale_id) REFERENCES public."Sale"(id);


-- Completed on 2022-10-17 09:03:42

--
-- PostgreSQL database dump complete
--

