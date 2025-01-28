--
-- PostgreSQL database dump
--

-- Dumped from database version 17.2 (Debian 17.2-1.pgdg120+1)
-- Dumped by pg_dump version 17.2

-- Started on 2025-01-28 14:46:17 UTC

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
-- TOC entry 227 (class 1255 OID 16434)
-- Name: check_team_capacity(); Type: FUNCTION; Schema: public; Owner: docker
--

CREATE FUNCTION public.check_team_capacity() RETURNS trigger
    LANGUAGE plpgsql
    AS $$
BEGIN
    IF (SELECT COUNT(*) FROM user_teams WHERE team_id = NEW.team_id) >= 7 THEN
        RAISE EXCEPTION 'Team is already full (max 7 players). Cannot add more.';
END IF;

RETURN NEW;
END;
$$;


ALTER FUNCTION public.check_team_capacity() OWNER TO docker;

--
-- TOC entry 228 (class 1255 OID 16481)
-- Name: create_team_with_players(character varying, integer, integer[], character varying[]); Type: PROCEDURE; Schema: public; Owner: docker
--

CREATE PROCEDURE public.create_team_with_players(IN _team_name character varying, IN _created_by integer, IN _player_ids integer[], IN _positions character varying[])
    LANGUAGE plpgsql
    AS $$
DECLARE
_new_team_id int;
    i int;
BEGIN
INSERT INTO teams (team_name, created_by)
VALUES (_team_name, _created_by)
    RETURNING team_id INTO _new_team_id;

IF _player_ids IS NOT NULL AND _positions IS NOT NULL AND array_length(_player_ids, 1) = array_length(_positions, 1)
    THEN
        FOR i IN 1 .. array_length(_player_ids, 1) LOOP
            INSERT INTO user_teams (user_id, team_id, position)
            VALUES (_player_ids[i], _new_team_id, _positions[i]);
END LOOP;
END IF;
END;
$$;


ALTER PROCEDURE public.create_team_with_players(IN _team_name character varying, IN _created_by integer, IN _player_ids integer[], IN _positions character varying[]) OWNER TO docker;

SET default_tablespace = '';

SET default_table_access_method = heap;

--
-- TOC entry 225 (class 1259 OID 16483)
-- Name: match_teams; Type: TABLE; Schema: public; Owner: docker
--

CREATE TABLE public.match_teams (
                                    match_id integer NOT NULL,
                                    team_id integer NOT NULL
);


ALTER TABLE public.match_teams OWNER TO docker;

--
-- TOC entry 223 (class 1259 OID 16449)
-- Name: matches; Type: TABLE; Schema: public; Owner: docker
--

CREATE TABLE public.matches (
                                match_id integer NOT NULL,
                                match_date date NOT NULL,
                                match_time time without time zone NOT NULL,
                                location character varying(100) NOT NULL,
                                created_by integer NOT NULL,
                                created_at timestamp without time zone DEFAULT CURRENT_TIMESTAMP
);


ALTER TABLE public.matches OWNER TO docker;

--
-- TOC entry 222 (class 1259 OID 16448)
-- Name: matches_match_id_seq; Type: SEQUENCE; Schema: public; Owner: docker
--

CREATE SEQUENCE public.matches_match_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.matches_match_id_seq OWNER TO docker;

--
-- TOC entry 3429 (class 0 OID 0)
-- Dependencies: 222
-- Name: matches_match_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: docker
--

ALTER SEQUENCE public.matches_match_id_seq OWNED BY public.matches.match_id;


--
-- TOC entry 220 (class 1259 OID 16406)
-- Name: teams; Type: TABLE; Schema: public; Owner: docker
--

CREATE TABLE public.teams (
                              team_id integer NOT NULL,
                              team_name character varying(50) NOT NULL,
                              created_by integer NOT NULL,
                              created_at timestamp without time zone DEFAULT CURRENT_TIMESTAMP
);


ALTER TABLE public.teams OWNER TO docker;

--
-- TOC entry 219 (class 1259 OID 16405)
-- Name: teams_team_id_seq; Type: SEQUENCE; Schema: public; Owner: docker
--

CREATE SEQUENCE public.teams_team_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.teams_team_id_seq OWNER TO docker;

--
-- TOC entry 3430 (class 0 OID 0)
-- Dependencies: 219
-- Name: teams_team_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: docker
--

ALTER SEQUENCE public.teams_team_id_seq OWNED BY public.teams.team_id;


--
-- TOC entry 221 (class 1259 OID 16418)
-- Name: user_teams; Type: TABLE; Schema: public; Owner: docker
--

CREATE TABLE public.user_teams (
                                   user_id integer NOT NULL,
                                   team_id integer NOT NULL,
                                   "position" character varying(50),
                                   joined_at timestamp without time zone DEFAULT CURRENT_TIMESTAMP
);


ALTER TABLE public.user_teams OWNER TO docker;

--
-- TOC entry 218 (class 1259 OID 16390)
-- Name: users; Type: TABLE; Schema: public; Owner: docker
--

CREATE TABLE public.users (
                              user_id integer NOT NULL,
                              first_name character varying(50) NOT NULL,
                              last_name character varying(50) NOT NULL,
                              nickname character varying(50) NOT NULL,
                              email character varying(100) NOT NULL,
                              password text NOT NULL,
                              city character varying(50) DEFAULT 'Kraków'::character varying NOT NULL,
                              skill_level character(1) NOT NULL,
                              "position" character varying(50) NOT NULL,
                              profile_picture text,
                              created_at timestamp without time zone DEFAULT CURRENT_TIMESTAMP,
                              role character varying(20) DEFAULT 'USER'::character varying NOT NULL,
                              CONSTRAINT users_skill_level_check CHECK ((skill_level = ANY (ARRAY['A'::bpchar, 'B'::bpchar, 'C'::bpchar])))
);


ALTER TABLE public.users OWNER TO docker;

--
-- TOC entry 217 (class 1259 OID 16389)
-- Name: users_user_id_seq; Type: SEQUENCE; Schema: public; Owner: docker
--

CREATE SEQUENCE public.users_user_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.users_user_id_seq OWNER TO docker;

--
-- TOC entry 3431 (class 0 OID 0)
-- Dependencies: 217
-- Name: users_user_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: docker
--

ALTER SEQUENCE public.users_user_id_seq OWNED BY public.users.user_id;


--
-- TOC entry 226 (class 1259 OID 16498)
-- Name: view_all_matches; Type: VIEW; Schema: public; Owner: docker
--

CREATE VIEW public.view_all_matches AS
SELECT m.match_id,
       m.match_date,
       m.match_time,
       m.location,
       t.team_id,
       t.team_name,
       ( SELECT count(*) AS count
    FROM public.user_teams
    WHERE (user_teams.team_id = t.team_id)) AS team_player_count
    FROM ((public.matches m
    JOIN public.match_teams mt ON ((m.match_id = mt.match_id)))
    JOIN public.teams t ON ((t.team_id = mt.team_id)));


ALTER VIEW public.view_all_matches OWNER TO docker;

--
-- TOC entry 224 (class 1259 OID 16471)
-- Name: view_team_members; Type: VIEW; Schema: public; Owner: docker
--

CREATE VIEW public.view_team_members AS
SELECT t.team_id,
       t.team_name,
       u.user_id,
       u.first_name,
       u.last_name,
       ut."position",
       ut.joined_at
FROM ((public.teams t
    JOIN public.user_teams ut ON ((t.team_id = ut.team_id)))
    JOIN public.users u ON ((ut.user_id = u.user_id)));


ALTER VIEW public.view_team_members OWNER TO docker;

--
-- TOC entry 3245 (class 2604 OID 16452)
-- Name: matches match_id; Type: DEFAULT; Schema: public; Owner: docker
--

ALTER TABLE ONLY public.matches ALTER COLUMN match_id SET DEFAULT nextval('public.matches_match_id_seq'::regclass);


--
-- TOC entry 3242 (class 2604 OID 16409)
-- Name: teams team_id; Type: DEFAULT; Schema: public; Owner: docker
--

ALTER TABLE ONLY public.teams ALTER COLUMN team_id SET DEFAULT nextval('public.teams_team_id_seq'::regclass);


--
-- TOC entry 3238 (class 2604 OID 16393)
-- Name: users user_id; Type: DEFAULT; Schema: public; Owner: docker
--

ALTER TABLE ONLY public.users ALTER COLUMN user_id SET DEFAULT nextval('public.users_user_id_seq'::regclass);


--
-- TOC entry 3423 (class 0 OID 16483)
-- Dependencies: 225
-- Data for Name: match_teams; Type: TABLE DATA; Schema: public; Owner: docker
--

COPY public.match_teams (match_id, team_id) FROM stdin;
3	4
4	5
5	4
6	6
8	7
9	8
10	9
11	10
12	15
13	9
14	18
15	19
\.


--
-- TOC entry 3422 (class 0 OID 16449)
-- Dependencies: 223
-- Data for Name: matches; Type: TABLE DATA; Schema: public; Owner: docker
--

COPY public.matches (match_id, match_date, match_time, location, created_by, created_at) FROM stdin;
3	2025-01-25	19:00:00	Kraków Hall 2	1	2025-01-09 14:24:15.068485
4	2025-01-25	19:00:00	Kraków Hall 2	3	2025-01-09 14:26:38.722698
5	2025-01-31	17:00:00	Kraków Hall 4	1	2025-01-09 16:57:21.691678
6	2025-02-08	18:00:00	Kraków Hall 1	1	2025-01-09 16:58:46.2166
8	2025-02-06	19:30:00	Kraków Hall 2	12	2025-01-12 21:00:59.94651
9	2025-01-12	16:15:00	Kraków Hall 1	11	2025-01-12 22:15:23.593183
10	2025-01-13	13:50:00	Kraków Hall 1	12	2025-01-12 22:46:19.379045
11	2025-02-10	21:05:00	Kraków Hall 3	13	2025-01-14 20:51:21.93963
12	2025-02-12	12:15:00	Kraków Hall 2	15	2025-01-27 19:11:04.90735
13	2025-02-08	15:10:00	Kraków Hall 3	12	2025-01-28 00:10:14.148995
14	2025-02-02	16:00:00	Kraków Hall 2	17	2025-01-28 13:55:58.553092
15	2025-01-31	20:00:00	Kraków Hall 3	18	2025-01-28 14:03:03.594678
\.


--
-- TOC entry 3419 (class 0 OID 16406)
-- Dependencies: 220
-- Data for Name: teams; Type: TABLE DATA; Schema: public; Owner: docker
--

COPY public.teams (team_id, team_name, created_by, created_at) FROM stdin;
4	Wolves	1	2025-01-09 14:23:39.661909
5	Dragons	3	2025-01-09 14:26:20.329111
6	Stones	1	2025-01-09 16:58:14.938025
7	BOTB	12	2025-01-12 21:00:35.662986
8	Mix	11	2025-01-12 22:14:53.731604
9	Bears	12	2025-01-12 22:45:56.883354
10	Flowers	13	2025-01-14 20:50:51.210657
15	Gang	15	2025-01-27 19:10:38.716634
18	Stars	17	2025-01-28 13:55:42.232424
19	Players	18	2025-01-28 14:02:44.470217
\.


--
-- TOC entry 3420 (class 0 OID 16418)
-- Dependencies: 221
-- Data for Name: user_teams; Type: TABLE DATA; Schema: public; Owner: docker
--

COPY public.user_teams (user_id, team_id, "position", joined_at) FROM stdin;
2	4	Libero	2025-01-09 14:24:51.322203
3	5	Middle blocker	2025-01-09 14:26:20.329111
4	5	Opposite hitter	2025-01-09 16:23:47.791711
1	6	Opposite hitter	2025-01-09 16:58:14.938025
4	6	Opposite hitter	2025-01-09 16:59:15.215413
1	4	Opposite hitter	2025-01-09 17:00:20.99111
8	6	Libero	2025-01-12 19:46:02.412395
12	7	Middle blocker	2025-01-12 21:03:42.14506
11	7	Opposite hitter	2025-01-12 21:36:01.932101
11	8	Opposite hitter	2025-01-12 22:14:53.731604
12	9	Middle blocker	2025-01-12 22:45:56.883354
8	9	Libero	2025-01-12 22:45:56.883354
9	9	Outside hitter	2025-01-12 22:45:56.883354
10	9	Middle blocker	2025-01-12 22:45:56.883354
6	9	Setter	2025-01-12 22:45:56.883354
11	9	Opposite hitter	2025-01-12 22:59:15.511877
13	8	Opposite hitter	2025-01-14 20:50:00.809018
13	10	Opposite hitter	2025-01-14 20:50:51.210657
4	10	Opposite hitter	2025-01-14 20:50:51.210657
12	4	Middle blocker	2025-01-26 20:57:48.998172
15	15	Middle blocker	2025-01-27 19:10:38.716634
4	15	Opposite hitter	2025-01-27 19:10:38.716634
17	18	Outside hitter	2025-01-28 13:55:42.232424
3	18	Middle blocker	2025-01-28 13:55:42.232424
18	18	Outside hitter	2025-01-28 14:02:18.508611
18	19	Outside hitter	2025-01-28 14:02:44.470217
10	19	Middle blocker	2025-01-28 14:02:44.470217
\.


--
-- TOC entry 3417 (class 0 OID 16390)
-- Dependencies: 218
-- Data for Name: users; Type: TABLE DATA; Schema: public; Owner: docker
--

COPY public.users (user_id, first_name, last_name, nickname, email, password, city, skill_level, "position", profile_picture, created_at, role) FROM stdin;
2	Adam	Nowak	anowak	anowak@gmail.com	$2y$10$.iodjXYnI5KBqrFRWvPZpOnsETg3OWbtuK7orHqorC/PDr/IJRKfK	Kraków	C	Libero	\N	2025-01-08 15:21:40.518074	USER
3	Anna	Lis	alis	alis@gmail.com	$2y$10$1.O641NfPSh/vao04PKs2.t6bLR9m3GWD6Er57maBDEcYyNrqygbi	Kraków	A	Middle blocker	\N	2025-01-09 12:39:43.91606	USER
4	Ala	Kot	akot	akot@gmail.com	$2y$10$q/mGjqEvrHYmoYrlaIbY5uV/peLRzll2WBWk4lo6qnYgJ8H6AIq72	Kraków	B	Opposite hitter	\N	2025-01-09 13:38:18.82624	USER
6	Magdalena	Tost	mtost	mtost@gmail.com	$2y$10$pbEWACyr6lp6dCi6cGSt9.UZfaCNo/khsJ5pOwudFWF0zVmUMGzgq	Kraków	C	Setter	\N	2025-01-12 19:30:24.998286	USER
9	Paweł	Kula	pkula	pkula@gmail.com	$2y$10$TS5M.y0a/kseJJJWrwbyheq5NDcSRHywMTY0Y1yiSwgK9b8x9PASa	Kraków	A	Outside hitter	uploads/ff5e8ee88c045d99f1d88fa35b6ac7d084d3ec01.jpg	2025-01-12 19:46:48.016647	USER
10	Katarzyna	Kucharz	kkucharz	kkucharz@gmail.com	$2y$10$9FogvKBFVsAxFruaYTw8JuYSzjVcN.Ice7drbHKdxQ7FsINt7zd4K	Kraków	B	Middle blocker	uploads/a50eb092002a7db526ae22dc277f34590d6085c4.jpg	2025-01-12 20:20:52.729626	USER
11	Wojciech	Mucha	wmucha	wmucha@gmail.com	$2y$10$/ScMzP35MEIGLXlcroLsnua.TmdMX1x.hhvOc3CULRAgUSP79QsF2	Kraków	A	Opposite hitter	uploads/1e59fbc955fe42cfad1afc4222551bb47898cd97.jpg	2025-01-12 20:45:36.770744	USER
12	Marcin	Majka	mmajka	mmajka@gmail.com	$2y$10$b.ygkGt9uIeCHj3voOXmJOZJp1pSUqI5qRdvpjVzVL7HYzncpEFMG	Kraków	C	Middle blocker	uploads/05930348979b08355855db0d45e6ab43c6cb0c14.jpg	2025-01-12 20:56:54.901253	USER
8	Bartosz	Wiśniewski	bwisniewski	bwisniewski@gmail.com	$2y$10$ZpViK6DZmIm9B9BsR3NXJu1rGaGzDeJdisaTmxbbdzfbFn.qOu/gm	Kraków	B	Libero	uploads/1e59fbc955fe42cfad1afc4222551bb47898cd97.jpg	2025-01-12 19:38:22.318507	USER
13	Zuzanna	Kwiat	zkwiat	zkwiat@gmail.com	$2y$10$ZMPchYrn/KnrAb41J1C4Zurm.QW1FSL5b62YOiwSmGE7lNWRiRf4C	Kraków	C	Opposite hitter	uploads/bbe1ee82748e10e25d1b1315952e2d2750807218.jpg	2025-01-14 20:49:33.878905	USER
14	ADMIN	ADMIN	admin	admin@admin.com	$2y$10$WQ.CdpYvDt8miBlnLIlL0.xa.QsQX1qVNY9Me5IU7iHkAcT/P8hxG	Kraków	A	Setter	\N	2025-01-26 20:55:01.041721	ADMIN
1	Jan	Kowalski	jkowalski	jkowalski@gmail.com	$2y$10$WZEnxttEZzOLWD8sHh.K.Oioozi8Lt79YXPuqb47yciYndfbNeN3m	Kraków	B	Opposite hitter	\N	2025-01-08 15:18:25.877981	USER
15	Marzena	Ryś	mrys	mrys@gmail.com	$2y$10$XGwSb6NSLc9ig7Ct/xKsV.DkGDUV3D6HGvJs9T2PLuGXzzYzcwzz6	Kraków	B	Middle blocker	uploads/675cc626a049c5cb006ce8a18925667cabbd4012.jpg	2025-01-27 18:58:25.046533	USER
16	Krzysztof	Niedziela	kniedziela	kniedziela@gmail.com	$2y$10$nonvcU3JRZ5tcFQqrTgKguWpmF/mQ5PEvrbR7WtZ7bd/4NItHq9/W	Kraków	B	Setter	uploads/62fa7367819ac1cf400efc56bef7be794afcf797.jpg	2025-01-27 21:19:33.503044	USER
17	Tomasz	Fornal	tfornal	tfornal@gmail.com	$2y$10$LMMaEBjDd6Z4PSSI8XKnTeFcxewjTdNdPltkXJx5nx6..j7uD4CtG	Kraków	A	Outside hitter	uploads/dd66067eb4b89744475f280f3b628b3dd9b1af82.jpg	2025-01-28 13:54:26.04101	USER
18	Artur	Szalpuk	aszalpuk	aszalpuk@gmail.com	$2y$10$90z1GF5EIFmNzFVDfWwyFu6REIEYmndxg8sHwrZQALqsVMvPZwHJC	Kraków	A	Outside hitter	uploads/66847a4728b6d4ff477f0141af1b11bb5f679d0d.jpg	2025-01-28 14:02:04.168476	USER
\.


--
-- TOC entry 3432 (class 0 OID 0)
-- Dependencies: 222
-- Name: matches_match_id_seq; Type: SEQUENCE SET; Schema: public; Owner: docker
--

SELECT pg_catalog.setval('public.matches_match_id_seq', 15, true);


--
-- TOC entry 3433 (class 0 OID 0)
-- Dependencies: 219
-- Name: teams_team_id_seq; Type: SEQUENCE SET; Schema: public; Owner: docker
--

SELECT pg_catalog.setval('public.teams_team_id_seq', 19, true);


--
-- TOC entry 3434 (class 0 OID 0)
-- Dependencies: 217
-- Name: users_user_id_seq; Type: SEQUENCE SET; Schema: public; Owner: docker
--

SELECT pg_catalog.setval('public.users_user_id_seq', 18, true);


--
-- TOC entry 3261 (class 2606 OID 16487)
-- Name: match_teams match_teams_pkey; Type: CONSTRAINT; Schema: public; Owner: docker
--

ALTER TABLE ONLY public.match_teams
    ADD CONSTRAINT match_teams_pkey PRIMARY KEY (match_id, team_id);


--
-- TOC entry 3259 (class 2606 OID 16455)
-- Name: matches matches_pkey; Type: CONSTRAINT; Schema: public; Owner: docker
--

ALTER TABLE ONLY public.matches
    ADD CONSTRAINT matches_pkey PRIMARY KEY (match_id);


--
-- TOC entry 3255 (class 2606 OID 16412)
-- Name: teams teams_pkey; Type: CONSTRAINT; Schema: public; Owner: docker
--

ALTER TABLE ONLY public.teams
    ADD CONSTRAINT teams_pkey PRIMARY KEY (team_id);


--
-- TOC entry 3257 (class 2606 OID 16423)
-- Name: user_teams user_teams_pkey; Type: CONSTRAINT; Schema: public; Owner: docker
--

ALTER TABLE ONLY public.user_teams
    ADD CONSTRAINT user_teams_pkey PRIMARY KEY (user_id, team_id);


--
-- TOC entry 3249 (class 2606 OID 16404)
-- Name: users users_email_key; Type: CONSTRAINT; Schema: public; Owner: docker
--

ALTER TABLE ONLY public.users
    ADD CONSTRAINT users_email_key UNIQUE (email);


--
-- TOC entry 3251 (class 2606 OID 16402)
-- Name: users users_nickname_key; Type: CONSTRAINT; Schema: public; Owner: docker
--

ALTER TABLE ONLY public.users
    ADD CONSTRAINT users_nickname_key UNIQUE (nickname);


--
-- TOC entry 3253 (class 2606 OID 16400)
-- Name: users users_pkey; Type: CONSTRAINT; Schema: public; Owner: docker
--

ALTER TABLE ONLY public.users
    ADD CONSTRAINT users_pkey PRIMARY KEY (user_id);


--
-- TOC entry 3268 (class 2620 OID 16435)
-- Name: user_teams trg_check_team_capacity; Type: TRIGGER; Schema: public; Owner: docker
--

CREATE TRIGGER trg_check_team_capacity BEFORE INSERT ON public.user_teams FOR EACH ROW EXECUTE FUNCTION public.check_team_capacity();


--
-- TOC entry 3266 (class 2606 OID 16488)
-- Name: match_teams match_teams_match_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: docker
--

ALTER TABLE ONLY public.match_teams
    ADD CONSTRAINT match_teams_match_id_fkey FOREIGN KEY (match_id) REFERENCES public.matches(match_id) ON DELETE CASCADE;


--
-- TOC entry 3267 (class 2606 OID 16493)
-- Name: match_teams match_teams_team_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: docker
--

ALTER TABLE ONLY public.match_teams
    ADD CONSTRAINT match_teams_team_id_fkey FOREIGN KEY (team_id) REFERENCES public.teams(team_id) ON DELETE CASCADE;


--
-- TOC entry 3265 (class 2606 OID 16456)
-- Name: matches matches_created_by_fkey; Type: FK CONSTRAINT; Schema: public; Owner: docker
--

ALTER TABLE ONLY public.matches
    ADD CONSTRAINT matches_created_by_fkey FOREIGN KEY (created_by) REFERENCES public.users(user_id) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- TOC entry 3262 (class 2606 OID 16413)
-- Name: teams teams_created_by_fkey; Type: FK CONSTRAINT; Schema: public; Owner: docker
--

ALTER TABLE ONLY public.teams
    ADD CONSTRAINT teams_created_by_fkey FOREIGN KEY (created_by) REFERENCES public.users(user_id) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- TOC entry 3263 (class 2606 OID 16429)
-- Name: user_teams user_teams_team_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: docker
--

ALTER TABLE ONLY public.user_teams
    ADD CONSTRAINT user_teams_team_id_fkey FOREIGN KEY (team_id) REFERENCES public.teams(team_id) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- TOC entry 3264 (class 2606 OID 16424)
-- Name: user_teams user_teams_user_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: docker
--

ALTER TABLE ONLY public.user_teams
    ADD CONSTRAINT user_teams_user_id_fkey FOREIGN KEY (user_id) REFERENCES public.users(user_id) ON UPDATE CASCADE ON DELETE CASCADE;


-- Completed on 2025-01-28 14:46:17 UTC

--
-- PostgreSQL database dump complete
--

