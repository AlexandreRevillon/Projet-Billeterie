--
-- PostgreSQL database dump
--

-- Dumped from database version 9.6.15
-- Dumped by pg_dump version 13.3 (Debian 13.3-1)

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

--
-- Name: bornerecharge; Type: TABLE; Schema: public; Owner: mtieha
--

CREATE TABLE public.bornerecharge (
    codebr character varying(5) NOT NULL,
    nums integer
);


ALTER TABLE public.bornerecharge OWNER TO mtieha;

--
-- Name: bornevalidation; Type: TABLE; Schema: public; Owner: mtieha
--

CREATE TABLE public.bornevalidation (
    codebv character varying(5) NOT NULL,
    nums integer
);


ALTER TABLE public.bornevalidation OWNER TO mtieha;

--
-- Name: carte; Type: TABLE; Schema: public; Owner: mtieha
--

CREATE TABLE public.carte (
    numc integer NOT NULL,
    numu integer,
    codetype character varying(3)
);


ALTER TABLE public.carte OWNER TO mtieha;

--
-- Name: profil; Type: TABLE; Schema: public; Owner: mtieha
--

CREATE TABLE public.profil (
    codep character varying(5) NOT NULL,
    libp character varying(30)
);


ALTER TABLE public.profil OWNER TO mtieha;

--
-- Name: recharge; Type: TABLE; Schema: public; Owner: mtieha
--

CREATE TABLE public.recharge (
    numc integer NOT NULL,
    codet character varying(5) NOT NULL,
    codebr character varying(5) NOT NULL,
    dateheurerecharge date NOT NULL
);


ALTER TABLE public.recharge OWNER TO mtieha;

--
-- Name: soldecarte; Type: TABLE; Schema: public; Owner: mtieha
--

CREATE TABLE public.soldecarte (
    numc integer NOT NULL,
    codet character varying(5) NOT NULL,
    datedebut date NOT NULL,
    quantite integer
);


ALTER TABLE public.soldecarte OWNER TO mtieha;

--
-- Name: station; Type: TABLE; Schema: public; Owner: mtieha
--

CREATE TABLE public.station (
    nums integer NOT NULL,
    libs character varying(50),
    ville character varying(30)
);


ALTER TABLE public.station OWNER TO mtieha;

--
-- Name: titretransport; Type: TABLE; Schema: public; Owner: mtieha
--

CREATE TABLE public.titretransport (
    codet character varying(10) NOT NULL,
    libt character varying(20),
    prix double precision,
    dureevalidheure integer,
    dureevalidjour integer,
    type character varying(20),
    codep character varying(5)
);


ALTER TABLE public.titretransport OWNER TO mtieha;

--
-- Name: typecarte; Type: TABLE; Schema: public; Owner: mtieha
--

CREATE TABLE public.typecarte (
    codetype character varying(3) NOT NULL,
    libtype character varying(30)
);


ALTER TABLE public.typecarte OWNER TO mtieha;

--
-- Name: utilisateur; Type: TABLE; Schema: public; Owner: mtieha
--

CREATE TABLE public.utilisateur (
    numu integer NOT NULL,
    nom character varying(30),
    prenom character varying(30),
    dn date,
    adresse character varying(50),
    codep character varying(5),
    codet character varying(10),
    datedebutabo date,
    password character varying(100),
    email character varying(100)
);


ALTER TABLE public.utilisateur OWNER TO mtieha;

--
-- Name: validation; Type: TABLE; Schema: public; Owner: mtieha
--

CREATE TABLE public.validation (
    numc integer NOT NULL,
    codet character varying(5) NOT NULL,
    codebv character varying(5) NOT NULL,
    dateheurevalid date NOT NULL
);


ALTER TABLE public.validation OWNER TO mtieha;

--
-- Data for Name: bornerecharge; Type: TABLE DATA; Schema: public; Owner: mtieha
--

COPY public.bornerecharge (codebr, nums) FROM stdin;
1	1
2	1
3	1
4	2
5	2
6	3
7	4
8	5
9	6
10	6
11	6
12	7
13	7
14	8
15	8
16	8
17	8
18	9
19	9
20	9
21	9
22	10
23	10
24	10
25	10
26	10
27	11
28	11
29	11
30	11
31	11
32	11
33	12
34	12
35	12
36	12
37	13
38	13
39	13
40	13
41	14
42	14
43	14
44	14
45	15
46	15
47	16
48	17
49	18
50	18
51	18
52	18
53	18
54	16
55	16
56	16
57	16
58	17
59	17
60	17
61	17
62	17
63	17
64	18
65	18
66	18
67	18
\.


--
-- Data for Name: bornevalidation; Type: TABLE DATA; Schema: public; Owner: mtieha
--

COPY public.bornevalidation (codebv, nums) FROM stdin;
1	1
2	1
3	2
4	2
5	2
6	3
7	4
8	4
9	4
10	4
11	4
12	5
13	5
14	5
15	5
16	6
17	6
18	6
19	6
20	6
21	6
22	7
23	7
24	7
25	8
26	8
27	8
28	8
29	9
30	9
31	9
32	9
33	9
34	10
35	10
36	11
37	11
38	12
39	12
40	12
41	12
42	12
43	12
44	13
45	13
46	13
47	14
48	15
49	15
50	15
51	15
52	15
53	16
54	16
55	16
56	17
57	17
58	17
59	17
60	18
61	18
\.


--
-- Data for Name: carte; Type: TABLE DATA; Schema: public; Owner: mtieha
--

COPY public.carte (numc, numu, codetype) FROM stdin;
117348	\N	CNP
117349	1	CNP
117350	\N	CNP
117351	\N	CNP
117352	\N	CNP
\.


--
-- Data for Name: profil; Type: TABLE DATA; Schema: public; Owner: mtieha
--

COPY public.profil (codep, libp) FROM stdin;
TP	Tout public
4-25	4-25 ans
65+	+ de 65 ans
\.


--
-- Data for Name: recharge; Type: TABLE DATA; Schema: public; Owner: mtieha
--

COPY public.recharge (numc, codet, codebr, dateheurerecharge) FROM stdin;
\.


--
-- Data for Name: soldecarte; Type: TABLE DATA; Schema: public; Owner: mtieha
--

COPY public.soldecarte (numc, codet, datedebut, quantite) FROM stdin;
117349	TU	2021-12-07	10
117349	TZ	2021-12-07	4
\.


--
-- Data for Name: station; Type: TABLE DATA; Schema: public; Owner: mtieha
--

COPY public.station (nums, libs, ville) FROM stdin;
1	CHU-Eurasanté	Lille
2	CHU-Centre O. Lambret	Lille
3	Porte des Postes	Lille
4	Wazemmes	Lille
5	Gambetta	Lille
6	Republique Beaux-Arts	Lille
7	Rihour	Lille
8	Gare Lille Flandres	Lille
9	Caulier	Lille
10	Fives	Lille
11	Marbrerie	Lille
12	Mairie Hellemmes	Lille
13	Square Flandres	Lille
15	Villeneuve d Ascq Hôtel de ville	Villeneuve d Ascq
16	Triolo	Villeneuve d Ascq
17	Cité scientifique Pr. Gabillard	Villeneuve d Ascq
18	4 Cantons Stade Pierre Mauroy	Villeneuve d Ascq
14	Pont de Bois	Villeneuve d Ascq
\.


--
-- Data for Name: titretransport; Type: TABLE DATA; Schema: public; Owner: mtieha
--

COPY public.titretransport (codet, libt, prix, dureevalidheure, dureevalidjour, type, codep) FROM stdin;
TU	Trajet unitaire	1.64999999999999991	1	\N	Ticket unitaire	\N
TZ	Trajet ZAP	1.10000000000000009	1	\N	Ticket zap	\N
1M/4-25	1 mois 4-25	30.5	\N	31	Abonnement	4-25
12M/4-25	12 mois 4-25	312	\N	365	Abonnement	4-25
1M/TP	1 mois Tout Public	61	\N	31	Abonnement	TP
12M/TP	12 mois Tout Public	672	\N	365	Abonnement	TP
1M/65+	1 mois + de 65 ans	30.5	\N	31	Abonnement	65+
12M/65+	12 mois + de 65 ans	312	\N	365	Abonnement	65+
\.


--
-- Data for Name: typecarte; Type: TABLE DATA; Schema: public; Owner: mtieha
--

COPY public.typecarte (codetype, libtype) FROM stdin;
CP	Carte Personnelle
CNP	Carte non Personnelle
\.


--
-- Data for Name: utilisateur; Type: TABLE DATA; Schema: public; Owner: mtieha
--

COPY public.utilisateur (numu, nom, prenom, dn, adresse, codep, codet, datedebutabo, password, email) FROM stdin;
2	test	test	2000-03-22	43 rue du marechal lyautey 59370	4-25	\N	\N	$2y$10$vrpGAzZbJCH8HNoDO8BB1eMthPePDls9T3VrywNS/lBTKBMKHSInK	test2@test.fr
1	Revillon	Alexandre	1996-03-22	43 rue du marechal lyautey 59370	TP	12M/TP	2021-05-02	$2y$10$KyeJ.jlRB3s.UIRmBhJfVOfyxySBD7f7sK71O6qTd0KOXyzZj6E6u	test@test.fr
\.


--
-- Data for Name: validation; Type: TABLE DATA; Schema: public; Owner: mtieha
--

COPY public.validation (numc, codet, codebv, dateheurevalid) FROM stdin;
\.


--
-- Name: bornerecharge bornerecharge_pkey; Type: CONSTRAINT; Schema: public; Owner: mtieha
--

ALTER TABLE ONLY public.bornerecharge
    ADD CONSTRAINT bornerecharge_pkey PRIMARY KEY (codebr);


--
-- Name: bornevalidation bornevalidation_pkey; Type: CONSTRAINT; Schema: public; Owner: mtieha
--

ALTER TABLE ONLY public.bornevalidation
    ADD CONSTRAINT bornevalidation_pkey PRIMARY KEY (codebv);


--
-- Name: carte carte_pkey; Type: CONSTRAINT; Schema: public; Owner: mtieha
--

ALTER TABLE ONLY public.carte
    ADD CONSTRAINT carte_pkey PRIMARY KEY (numc);


--
-- Name: profil profil_pkey; Type: CONSTRAINT; Schema: public; Owner: mtieha
--

ALTER TABLE ONLY public.profil
    ADD CONSTRAINT profil_pkey PRIMARY KEY (codep);


--
-- Name: recharge recharge_pkey; Type: CONSTRAINT; Schema: public; Owner: mtieha
--

ALTER TABLE ONLY public.recharge
    ADD CONSTRAINT recharge_pkey PRIMARY KEY (numc, codet, codebr, dateheurerecharge);


--
-- Name: soldecarte soldecarte_pkey; Type: CONSTRAINT; Schema: public; Owner: mtieha
--

ALTER TABLE ONLY public.soldecarte
    ADD CONSTRAINT soldecarte_pkey PRIMARY KEY (numc, codet, datedebut);


--
-- Name: station station_pkey; Type: CONSTRAINT; Schema: public; Owner: mtieha
--

ALTER TABLE ONLY public.station
    ADD CONSTRAINT station_pkey PRIMARY KEY (nums);


--
-- Name: titretransport titretransport_pkey; Type: CONSTRAINT; Schema: public; Owner: mtieha
--

ALTER TABLE ONLY public.titretransport
    ADD CONSTRAINT titretransport_pkey PRIMARY KEY (codet);


--
-- Name: typecarte typecarte_pkey; Type: CONSTRAINT; Schema: public; Owner: mtieha
--

ALTER TABLE ONLY public.typecarte
    ADD CONSTRAINT typecarte_pkey PRIMARY KEY (codetype);


--
-- Name: utilisateur utilisateur_pkey; Type: CONSTRAINT; Schema: public; Owner: mtieha
--

ALTER TABLE ONLY public.utilisateur
    ADD CONSTRAINT utilisateur_pkey PRIMARY KEY (numu);


--
-- Name: validation validation_pkey; Type: CONSTRAINT; Schema: public; Owner: mtieha
--

ALTER TABLE ONLY public.validation
    ADD CONSTRAINT validation_pkey PRIMARY KEY (numc, codet, codebv, dateheurevalid);


--
-- Name: bornerecharge bornerecharge_nums_fkey; Type: FK CONSTRAINT; Schema: public; Owner: mtieha
--

ALTER TABLE ONLY public.bornerecharge
    ADD CONSTRAINT bornerecharge_nums_fkey FOREIGN KEY (nums) REFERENCES public.station(nums);


--
-- Name: bornevalidation bornevalidation_nums_fkey; Type: FK CONSTRAINT; Schema: public; Owner: mtieha
--

ALTER TABLE ONLY public.bornevalidation
    ADD CONSTRAINT bornevalidation_nums_fkey FOREIGN KEY (nums) REFERENCES public.station(nums);


--
-- Name: carte carte_codetype_fkey; Type: FK CONSTRAINT; Schema: public; Owner: mtieha
--

ALTER TABLE ONLY public.carte
    ADD CONSTRAINT carte_codetype_fkey FOREIGN KEY (codetype) REFERENCES public.typecarte(codetype);


--
-- Name: carte carte_numu_fkey; Type: FK CONSTRAINT; Schema: public; Owner: mtieha
--

ALTER TABLE ONLY public.carte
    ADD CONSTRAINT carte_numu_fkey FOREIGN KEY (numu) REFERENCES public.utilisateur(numu);


--
-- Name: recharge recharge_codebr_fkey; Type: FK CONSTRAINT; Schema: public; Owner: mtieha
--

ALTER TABLE ONLY public.recharge
    ADD CONSTRAINT recharge_codebr_fkey FOREIGN KEY (codebr) REFERENCES public.bornerecharge(codebr);


--
-- Name: recharge recharge_codet_fkey; Type: FK CONSTRAINT; Schema: public; Owner: mtieha
--

ALTER TABLE ONLY public.recharge
    ADD CONSTRAINT recharge_codet_fkey FOREIGN KEY (codet) REFERENCES public.titretransport(codet);


--
-- Name: recharge recharge_numc_fkey; Type: FK CONSTRAINT; Schema: public; Owner: mtieha
--

ALTER TABLE ONLY public.recharge
    ADD CONSTRAINT recharge_numc_fkey FOREIGN KEY (numc) REFERENCES public.carte(numc);


--
-- Name: titretransport titretransport_codep_fkey; Type: FK CONSTRAINT; Schema: public; Owner: mtieha
--

ALTER TABLE ONLY public.titretransport
    ADD CONSTRAINT titretransport_codep_fkey FOREIGN KEY (codep) REFERENCES public.profil(codep);


--
-- Name: utilisateur utilisateur_codep_fkey; Type: FK CONSTRAINT; Schema: public; Owner: mtieha
--

ALTER TABLE ONLY public.utilisateur
    ADD CONSTRAINT utilisateur_codep_fkey FOREIGN KEY (codep) REFERENCES public.profil(codep);


--
-- Name: utilisateur utilisateur_codet_fkey; Type: FK CONSTRAINT; Schema: public; Owner: mtieha
--

ALTER TABLE ONLY public.utilisateur
    ADD CONSTRAINT utilisateur_codet_fkey FOREIGN KEY (codet) REFERENCES public.titretransport(codet);


--
-- Name: validation validation_codebv_fkey; Type: FK CONSTRAINT; Schema: public; Owner: mtieha
--

ALTER TABLE ONLY public.validation
    ADD CONSTRAINT validation_codebv_fkey FOREIGN KEY (codebv) REFERENCES public.bornevalidation(codebv);


--
-- Name: validation validation_codet_fkey; Type: FK CONSTRAINT; Schema: public; Owner: mtieha
--

ALTER TABLE ONLY public.validation
    ADD CONSTRAINT validation_codet_fkey FOREIGN KEY (codet) REFERENCES public.titretransport(codet);


--
-- Name: validation validation_numc_fkey; Type: FK CONSTRAINT; Schema: public; Owner: mtieha
--

ALTER TABLE ONLY public.validation
    ADD CONSTRAINT validation_numc_fkey FOREIGN KEY (numc) REFERENCES public.carte(numc);


--
-- PostgreSQL database dump complete
--

