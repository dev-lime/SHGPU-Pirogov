--
-- PostgreSQL database cluster dump
--

-- Started on 2025-04-15 11:57:35

SET default_transaction_read_only = off;

SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;

--
-- Roles
--

CREATE ROLE postgres;
ALTER ROLE postgres WITH SUPERUSER INHERIT CREATEROLE CREATEDB LOGIN REPLICATION BYPASSRLS;

--
-- User Configurations
--








--
-- Databases
--

--
-- Database "template1" dump
--

\connect template1

--
-- PostgreSQL database dump
--

-- Dumped from database version 17.4
-- Dumped by pg_dump version 17.4

-- Started on 2025-04-15 11:57:35

SET statement_timeout = 0;
SET lock_timeout = 0;
SET idle_in_transaction_session_timeout = 0;
SET transaction_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SELECT pg_catalog.set_config('search_path', '', false);
SET check_function_bodies = false;
SET xmloption = content;
SET client_min_messages = warning;
SET row_security = off;

-- Completed on 2025-04-15 11:57:35

--
-- PostgreSQL database dump complete
--

--
-- Database "tk" dump
--

--
-- PostgreSQL database dump
--

-- Dumped from database version 17.4
-- Dumped by pg_dump version 17.4

-- Started on 2025-04-15 11:57:35

SET statement_timeout = 0;
SET lock_timeout = 0;
SET idle_in_transaction_session_timeout = 0;
SET transaction_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SELECT pg_catalog.set_config('search_path', '', false);
SET check_function_bodies = false;
SET xmloption = content;
SET client_min_messages = warning;
SET row_security = off;

--
-- TOC entry 4848 (class 1262 OID 16387)
-- Name: tk; Type: DATABASE; Schema: -; Owner: postgres
--

CREATE DATABASE tk WITH TEMPLATE = template0 ENCODING = 'UTF8' LOCALE_PROVIDER = libc LOCALE = 'en-US';


ALTER DATABASE tk OWNER TO postgres;

\connect tk

SET statement_timeout = 0;
SET lock_timeout = 0;
SET idle_in_transaction_session_timeout = 0;
SET transaction_timeout = 0;
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
-- TOC entry 218 (class 1259 OID 16596)
-- Name: clients; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.clients (
    client_id integer NOT NULL,
    full_name character varying(255) NOT NULL,
    phone character varying(20),
    email character varying(100),
    company_name character varying(255)
);


ALTER TABLE public.clients OWNER TO postgres;

--
-- TOC entry 217 (class 1259 OID 16595)
-- Name: clients_client_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.clients_client_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.clients_client_id_seq OWNER TO postgres;

--
-- TOC entry 4849 (class 0 OID 0)
-- Dependencies: 217
-- Name: clients_client_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.clients_client_id_seq OWNED BY public.clients.client_id;


--
-- TOC entry 220 (class 1259 OID 16605)
-- Name: dispatchers; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.dispatchers (
    dispatcher_id integer NOT NULL,
    full_name character varying(255) NOT NULL,
    phone character varying(20),
    email character varying(100)
);


ALTER TABLE public.dispatchers OWNER TO postgres;

--
-- TOC entry 219 (class 1259 OID 16604)
-- Name: dispatchers_dispatcher_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.dispatchers_dispatcher_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.dispatchers_dispatcher_id_seq OWNER TO postgres;

--
-- TOC entry 4850 (class 0 OID 0)
-- Dependencies: 219
-- Name: dispatchers_dispatcher_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.dispatchers_dispatcher_id_seq OWNED BY public.dispatchers.dispatcher_id;


--
-- TOC entry 222 (class 1259 OID 16612)
-- Name: drivers; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.drivers (
    driver_id integer NOT NULL,
    full_name character varying(255) NOT NULL,
    license_number character varying(50) NOT NULL,
    phone character varying(20)
);


ALTER TABLE public.drivers OWNER TO postgres;

--
-- TOC entry 221 (class 1259 OID 16611)
-- Name: drivers_driver_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.drivers_driver_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.drivers_driver_id_seq OWNER TO postgres;

--
-- TOC entry 4851 (class 0 OID 0)
-- Dependencies: 221
-- Name: drivers_driver_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.drivers_driver_id_seq OWNED BY public.drivers.driver_id;


--
-- TOC entry 226 (class 1259 OID 16639)
-- Name: orders; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.orders (
    order_id integer NOT NULL,
    client_id integer,
    dispatcher_id integer,
    driver_id integer,
    vehicle_id integer,
    origin character varying(100) NOT NULL,
    destination character varying(100) NOT NULL,
    cargo_description text,
    weight_kg integer,
    status character varying(50) DEFAULT 'pending'::character varying,
    created_at timestamp without time zone DEFAULT CURRENT_TIMESTAMP,
    delivery_date date
);


ALTER TABLE public.orders OWNER TO postgres;

--
-- TOC entry 225 (class 1259 OID 16638)
-- Name: orders_order_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.orders_order_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.orders_order_id_seq OWNER TO postgres;

--
-- TOC entry 4852 (class 0 OID 0)
-- Dependencies: 225
-- Name: orders_order_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.orders_order_id_seq OWNED BY public.orders.order_id;


--
-- TOC entry 224 (class 1259 OID 16621)
-- Name: vehicles; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.vehicles (
    vehicle_id integer NOT NULL,
    plate_number character varying(20) NOT NULL,
    model character varying(100),
    capacity_kg integer,
    status character varying(50) DEFAULT 'available'::character varying,
    CONSTRAINT vehicles_capacity_kg_check CHECK ((capacity_kg > 0))
);


ALTER TABLE public.vehicles OWNER TO postgres;

--
-- TOC entry 223 (class 1259 OID 16620)
-- Name: vehicles_vehicle_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.vehicles_vehicle_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.vehicles_vehicle_id_seq OWNER TO postgres;

--
-- TOC entry 4853 (class 0 OID 0)
-- Dependencies: 223
-- Name: vehicles_vehicle_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.vehicles_vehicle_id_seq OWNED BY public.vehicles.vehicle_id;


--
-- TOC entry 4661 (class 2604 OID 16599)
-- Name: clients client_id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.clients ALTER COLUMN client_id SET DEFAULT nextval('public.clients_client_id_seq'::regclass);


--
-- TOC entry 4662 (class 2604 OID 16608)
-- Name: dispatchers dispatcher_id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.dispatchers ALTER COLUMN dispatcher_id SET DEFAULT nextval('public.dispatchers_dispatcher_id_seq'::regclass);


--
-- TOC entry 4663 (class 2604 OID 16615)
-- Name: drivers driver_id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.drivers ALTER COLUMN driver_id SET DEFAULT nextval('public.drivers_driver_id_seq'::regclass);


--
-- TOC entry 4666 (class 2604 OID 16642)
-- Name: orders order_id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.orders ALTER COLUMN order_id SET DEFAULT nextval('public.orders_order_id_seq'::regclass);


--
-- TOC entry 4664 (class 2604 OID 16624)
-- Name: vehicles vehicle_id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.vehicles ALTER COLUMN vehicle_id SET DEFAULT nextval('public.vehicles_vehicle_id_seq'::regclass);


--
-- TOC entry 4834 (class 0 OID 16596)
-- Dependencies: 218
-- Data for Name: clients; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.clients (client_id, full_name, phone, email, company_name) FROM stdin;
1	Иван Петров	+79031234567	ivan.petrov@mail.ru	ООО "ПетроТранс"
2	Мария Смирнова	+79031234568	m.smirnova@mail.ru	ИП Смирнова
3	John Doe	+447911223344	john.doe@globalcorp.com	GlobalCorp LTD
4	Дедюхин Артем Витальевич	+79292256967	artem@dedyuhin.ru	-
\.


--
-- TOC entry 4836 (class 0 OID 16605)
-- Dependencies: 220
-- Data for Name: dispatchers; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.dispatchers (dispatcher_id, full_name, phone, email) FROM stdin;
1	Александр Волков	+79035556677	volkov@tkdispatch.ru
2	Ольга Кузнецова	+79036667788	kuznetsova@tkdispatch.ru
3	Иванова Иоанна Сидоровна	+79646580987	sobaka@mail.com
\.


--
-- TOC entry 4838 (class 0 OID 16612)
-- Dependencies: 222
-- Data for Name: drivers; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.drivers (driver_id, full_name, license_number, phone) FROM stdin;
1	Сергей Орлов	AB1234567	+79037778899
2	Виктор Ильин	CD7654321	+79038889900
3	Pavel Morozov	EF0987654	+79039990011
4	Иосиф Холодец	FE9865321	+79646958987
\.


--
-- TOC entry 4842 (class 0 OID 16639)
-- Dependencies: 226
-- Data for Name: orders; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.orders (order_id, client_id, dispatcher_id, driver_id, vehicle_id, origin, destination, cargo_description, weight_kg, status, created_at, delivery_date) FROM stdin;
1	1	1	1	1	Москва	Санкт-Петербург	Оборудование	5000	in_progress	2025-04-11 14:06:09.803618	2025-04-13
2	2	2	2	2	Новосибирск	Екатеринбург	Мебель	3000	pending	2025-04-11 14:06:09.803618	2025-04-14
3	3	1	3	3	Минск	Киев	Товары народного потребления	8000	completed	2025-04-11 14:06:09.803618	2025-04-10
\.


--
-- TOC entry 4840 (class 0 OID 16621)
-- Dependencies: 224
-- Data for Name: vehicles; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.vehicles (vehicle_id, plate_number, model, capacity_kg, status) FROM stdin;
1	А123ВС77	MAN TGX	20000	available
2	К456НЕ77	Scania R450	18000	maintenance
3	M789XY77	Volvo FH	25000	in_transit
\.


--
-- TOC entry 4854 (class 0 OID 0)
-- Dependencies: 217
-- Name: clients_client_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.clients_client_id_seq', 4, true);


--
-- TOC entry 4855 (class 0 OID 0)
-- Dependencies: 219
-- Name: dispatchers_dispatcher_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.dispatchers_dispatcher_id_seq', 3, true);


--
-- TOC entry 4856 (class 0 OID 0)
-- Dependencies: 221
-- Name: drivers_driver_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.drivers_driver_id_seq', 4, true);


--
-- TOC entry 4857 (class 0 OID 0)
-- Dependencies: 225
-- Name: orders_order_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.orders_order_id_seq', 3, true);


--
-- TOC entry 4858 (class 0 OID 0)
-- Dependencies: 223
-- Name: vehicles_vehicle_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.vehicles_vehicle_id_seq', 3, true);


--
-- TOC entry 4671 (class 2606 OID 16603)
-- Name: clients clients_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.clients
    ADD CONSTRAINT clients_pkey PRIMARY KEY (client_id);


--
-- TOC entry 4673 (class 2606 OID 16610)
-- Name: dispatchers dispatchers_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.dispatchers
    ADD CONSTRAINT dispatchers_pkey PRIMARY KEY (dispatcher_id);


--
-- TOC entry 4675 (class 2606 OID 16619)
-- Name: drivers drivers_license_number_key; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.drivers
    ADD CONSTRAINT drivers_license_number_key UNIQUE (license_number);


--
-- TOC entry 4677 (class 2606 OID 16617)
-- Name: drivers drivers_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.drivers
    ADD CONSTRAINT drivers_pkey PRIMARY KEY (driver_id);


--
-- TOC entry 4683 (class 2606 OID 16648)
-- Name: orders orders_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.orders
    ADD CONSTRAINT orders_pkey PRIMARY KEY (order_id);


--
-- TOC entry 4679 (class 2606 OID 16628)
-- Name: vehicles vehicles_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.vehicles
    ADD CONSTRAINT vehicles_pkey PRIMARY KEY (vehicle_id);


--
-- TOC entry 4681 (class 2606 OID 16630)
-- Name: vehicles vehicles_plate_number_key; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.vehicles
    ADD CONSTRAINT vehicles_plate_number_key UNIQUE (plate_number);


--
-- TOC entry 4684 (class 2606 OID 16649)
-- Name: orders orders_client_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.orders
    ADD CONSTRAINT orders_client_id_fkey FOREIGN KEY (client_id) REFERENCES public.clients(client_id) ON DELETE SET NULL;


--
-- TOC entry 4685 (class 2606 OID 16654)
-- Name: orders orders_dispatcher_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.orders
    ADD CONSTRAINT orders_dispatcher_id_fkey FOREIGN KEY (dispatcher_id) REFERENCES public.dispatchers(dispatcher_id) ON DELETE SET NULL;


--
-- TOC entry 4686 (class 2606 OID 16659)
-- Name: orders orders_driver_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.orders
    ADD CONSTRAINT orders_driver_id_fkey FOREIGN KEY (driver_id) REFERENCES public.drivers(driver_id) ON DELETE SET NULL;


--
-- TOC entry 4687 (class 2606 OID 16664)
-- Name: orders orders_vehicle_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.orders
    ADD CONSTRAINT orders_vehicle_id_fkey FOREIGN KEY (vehicle_id) REFERENCES public.vehicles(vehicle_id) ON DELETE SET NULL;


-- Completed on 2025-04-15 11:57:36

--
-- PostgreSQL database dump complete
--

-- Completed on 2025-04-15 11:57:36

--
-- PostgreSQL database cluster dump complete
--

