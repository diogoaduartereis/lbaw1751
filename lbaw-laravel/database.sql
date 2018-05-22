--
-- PostgreSQL database dump
--

-- Dumped from database version 9.4.17
-- Dumped by pg_dump version 9.5.12

-- Started on 2018-05-22 16:11:10 WEST

SET statement_timeout = 0;
SET lock_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SELECT pg_catalog.set_config('search_path', '', false);
SET check_function_bodies = false;
SET client_min_messages = warning;
SET row_security = off;

--
-- TOC entry 220 (class 1255 OID 49216)
-- Name: update_user_points_on_delete(); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION public.update_user_points_on_delete() RETURNS trigger
    LANGUAGE plpgsql
    AS $$
    DECLARE
        postvote_user_id    integer;
        post_poster_id      integer;
	post_id		    integer;
    BEGIN
        postvote_user_id = OLD.posterID;
        post_poster_id = (select users.id as id from postvote join Post on postvote.postid = Post.id join users on Post.posterid = users.id where postvote.postid = Old.postid limit 1);
        post_id = Old.postid;
        IF EXISTS (SELECT id AS userId1 FROM users WHERE id = post_poster_id) THEN
            UPDATE users
            SET points = points - OLD.value
            WHERE id = post_poster_id;
        END IF;
        IF EXISTS (SELECT id AS userId1 FROM Post WHERE id = post_id) THEN
            UPDATE Post
            SET points = points - OLD.value
            WHERE id = post_id;
        END IF;
        RETURN OLD;
    END
$$;


ALTER FUNCTION public.update_user_points_on_delete() OWNER TO postgres;

--
-- TOC entry 221 (class 1255 OID 49218)
-- Name: update_user_points_on_insert(); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION public.update_user_points_on_insert() RETURNS trigger
    LANGUAGE plpgsql
    AS $$
    DECLARE
        postvote_user_id    integer;
        post_poster_id      integer;
	post_id		    integer;
    BEGIN
        postvote_user_id = NEW.posterID;
        post_poster_id = (select users.id as id from postvote join Post on postvote.postid = Post.id join users on Post.posterid = users.id where postvote.postid = New.postid limit 1);
        post_id = New.postid;
        IF EXISTS (SELECT id AS userId1 FROM users WHERE id = NEW.posterID) THEN
            UPDATE users
            SET points = points + NEW.value
            WHERE id = post_poster_id;
        END IF;
        IF EXISTS (SELECT id FROM Post WHERE id = post_id) THEN
            UPDATE Post
            SET points = points + New.value
            WHERE id = post_id;
        END IF;
        RETURN NEW;
    END
$$;


ALTER FUNCTION public.update_user_points_on_insert() OWNER TO postgres;

--
-- TOC entry 219 (class 1255 OID 49220)
-- Name: update_user_points_on_update(); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION public.update_user_points_on_update() RETURNS trigger
    LANGUAGE plpgsql
    AS $$
    DECLARE
        postvote_user_id    integer;
        post_poster_id      integer;
	post_id		    integer;
    BEGIN
        postvote_user_id = NEW.posterID;
        post_poster_id = (select users.id as id from postvote join Post on postvote.postid = Post.id join users on Post.posterid = users.id where postvote.postid = Old.postid limit 1);
        post_id = Old.postid;
        IF EXISTS (SELECT id AS userId1 FROM users WHERE id = postvote_user_id) THEN
            UPDATE users
            SET points = points - OLD.value + NEW.value
            WHERE id = post_poster_id;
        END IF;
        IF EXISTS (SELECT id FROM Post WHERE id = post_id) THEN
            UPDATE Post
            SET points = points - Old.value + New.value
            WHERE id = post_id;
        END IF;
        RETURN NEW;
    END
$$;


ALTER FUNCTION public.update_user_points_on_update() OWNER TO postgres;

SET default_tablespace = '';

SET default_with_oids = false;

--
-- TOC entry 174 (class 1259 OID 33076)
-- Name: users; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.users (
    id integer NOT NULL,
    username text NOT NULL,
    type text DEFAULT 'REGULAR'::text NOT NULL,
    pass_token text NOT NULL,
    auth_type integer NOT NULL,
    email text NOT NULL,
    state text DEFAULT 'ACTIVE'::text NOT NULL,
    description text,
    img_path text DEFAULT '0.png'::text NOT NULL,
    points integer DEFAULT 0 NOT NULL,
    remember_token text,
    CONSTRAINT "User_auth_type_check" CHECK (((auth_type = 0) OR (auth_type = 1)))
);


ALTER TABLE public.users OWNER TO postgres;

--
-- TOC entry 173 (class 1259 OID 33074)
-- Name: User_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public."User_id_seq"
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public."User_id_seq" OWNER TO postgres;

--
-- TOC entry 2252 (class 0 OID 0)
-- Dependencies: 173
-- Name: User_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public."User_id_seq" OWNED BY public.users.id;


--
-- TOC entry 188 (class 1259 OID 33210)
-- Name: answer; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.answer (
    postid integer NOT NULL,
    questionid integer NOT NULL,
    iscorrect boolean DEFAULT false NOT NULL
);


ALTER TABLE public.answer OWNER TO postgres;

--
-- TOC entry 186 (class 1259 OID 33206)
-- Name: answer_postid_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.answer_postid_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.answer_postid_seq OWNER TO postgres;

--
-- TOC entry 2253 (class 0 OID 0)
-- Dependencies: 186
-- Name: answer_postid_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.answer_postid_seq OWNED BY public.answer.postid;


--
-- TOC entry 187 (class 1259 OID 33208)
-- Name: answer_questionid_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.answer_questionid_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.answer_questionid_seq OWNER TO postgres;

--
-- TOC entry 2254 (class 0 OID 0)
-- Dependencies: 187
-- Name: answer_questionid_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.answer_questionid_seq OWNED BY public.answer.questionid;


--
-- TOC entry 178 (class 1259 OID 33131)
-- Name: baninfo; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.baninfo (
    id integer NOT NULL,
    duration bigint,
    description text NOT NULL,
    ispermanent boolean NOT NULL,
    initdate timestamp with time zone DEFAULT now(),
    enddate timestamp with time zone,
    userid integer NOT NULL,
    adminid integer NOT NULL,
    CONSTRAINT baninfo_check CHECK ((((enddate IS NOT NULL) AND (enddate > now())) OR (ispermanent IS TRUE)))
);


ALTER TABLE public.baninfo OWNER TO postgres;

--
-- TOC entry 177 (class 1259 OID 33129)
-- Name: baninfo_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.baninfo_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.baninfo_id_seq OWNER TO postgres;

--
-- TOC entry 2255 (class 0 OID 0)
-- Dependencies: 177
-- Name: baninfo_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.baninfo_id_seq OWNED BY public.baninfo.id;


--
-- TOC entry 204 (class 1259 OID 49240)
-- Name: contact; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.contact (
    id integer NOT NULL,
    message text NOT NULL,
    date timestamp with time zone DEFAULT now() NOT NULL,
    userid integer,
    subjectid integer NOT NULL,
    processed boolean DEFAULT false NOT NULL
);


ALTER TABLE public.contact OWNER TO postgres;

--
-- TOC entry 203 (class 1259 OID 49238)
-- Name: contact_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.contact_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.contact_id_seq OWNER TO postgres;

--
-- TOC entry 2256 (class 0 OID 0)
-- Dependencies: 203
-- Name: contact_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.contact_id_seq OWNED BY public.contact.id;


--
-- TOC entry 205 (class 1259 OID 49271)
-- Name: faqcategory; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.faqcategory (
    id bigint NOT NULL,
    name text NOT NULL
);


ALTER TABLE public.faqcategory OWNER TO postgres;

--
-- TOC entry 206 (class 1259 OID 49282)
-- Name: faqentry; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.faqentry (
    id bigint NOT NULL,
    question text NOT NULL,
    answer text NOT NULL,
    category bigint NOT NULL
);


ALTER TABLE public.faqentry OWNER TO postgres;

--
-- TOC entry 183 (class 1259 OID 33169)
-- Name: post; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.post (
    id integer NOT NULL,
    posterid integer NOT NULL,
    content text NOT NULL,
    date timestamp with time zone DEFAULT now() NOT NULL,
    isvisible boolean DEFAULT true NOT NULL,
    points integer DEFAULT 0 NOT NULL
);


ALTER TABLE public.post OWNER TO postgres;

--
-- TOC entry 181 (class 1259 OID 33165)
-- Name: post_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.post_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.post_id_seq OWNER TO postgres;

--
-- TOC entry 2257 (class 0 OID 0)
-- Dependencies: 181
-- Name: post_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.post_id_seq OWNED BY public.post.id;


--
-- TOC entry 182 (class 1259 OID 33167)
-- Name: post_posterid_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.post_posterid_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.post_posterid_seq OWNER TO postgres;

--
-- TOC entry 2258 (class 0 OID 0)
-- Dependencies: 182
-- Name: post_posterid_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.post_posterid_seq OWNED BY public.post.posterid;


--
-- TOC entry 195 (class 1259 OID 33270)
-- Name: postreport; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.postreport (
    postid integer NOT NULL,
    reporterid bigint NOT NULL,
    date timestamp with time zone DEFAULT now() NOT NULL,
    reason text NOT NULL
);


ALTER TABLE public.postreport OWNER TO postgres;

--
-- TOC entry 194 (class 1259 OID 33268)
-- Name: postreport_postid_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.postreport_postid_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.postreport_postid_seq OWNER TO postgres;

--
-- TOC entry 2259 (class 0 OID 0)
-- Dependencies: 194
-- Name: postreport_postid_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.postreport_postid_seq OWNED BY public.postreport.postid;


--
-- TOC entry 193 (class 1259 OID 33251)
-- Name: postvote; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.postvote (
    postid integer NOT NULL,
    posterid bigint NOT NULL,
    value integer NOT NULL,
    CONSTRAINT postvote_value_check CHECK (((value = 1) OR (value = (-1))))
);


ALTER TABLE public.postvote OWNER TO postgres;

--
-- TOC entry 192 (class 1259 OID 33249)
-- Name: postvote_postid_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.postvote_postid_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.postvote_postid_seq OWNER TO postgres;

--
-- TOC entry 2260 (class 0 OID 0)
-- Dependencies: 192
-- Name: postvote_postid_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.postvote_postid_seq OWNED BY public.postvote.postid;


--
-- TOC entry 185 (class 1259 OID 33189)
-- Name: question; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.question (
    postid integer NOT NULL,
    isclosed boolean DEFAULT false NOT NULL,
    nviews bigint DEFAULT 0 NOT NULL,
    title text NOT NULL,
    CONSTRAINT question_nviews_check CHECK ((nviews >= 0))
);


ALTER TABLE public.question OWNER TO postgres;

--
-- TOC entry 184 (class 1259 OID 33187)
-- Name: question_postid_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.question_postid_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.question_postid_seq OWNER TO postgres;

--
-- TOC entry 2261 (class 0 OID 0)
-- Dependencies: 184
-- Name: question_postid_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.question_postid_seq OWNED BY public.question.postid;


--
-- TOC entry 176 (class 1259 OID 33096)
-- Name: subject; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.subject (
    subjectid integer NOT NULL,
    name text NOT NULL
);


ALTER TABLE public.subject OWNER TO postgres;

--
-- TOC entry 175 (class 1259 OID 33094)
-- Name: subject_subjectid_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.subject_subjectid_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.subject_subjectid_seq OWNER TO postgres;

--
-- TOC entry 2262 (class 0 OID 0)
-- Dependencies: 175
-- Name: subject_subjectid_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.subject_subjectid_seq OWNED BY public.subject.subjectid;


--
-- TOC entry 180 (class 1259 OID 33154)
-- Name: tag; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.tag (
    id integer NOT NULL,
    name text NOT NULL
);


ALTER TABLE public.tag OWNER TO postgres;

--
-- TOC entry 179 (class 1259 OID 33152)
-- Name: tag_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.tag_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.tag_id_seq OWNER TO postgres;

--
-- TOC entry 2263 (class 0 OID 0)
-- Dependencies: 179
-- Name: tag_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.tag_id_seq OWNED BY public.tag.id;


--
-- TOC entry 191 (class 1259 OID 33232)
-- Name: tagquestion; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.tagquestion (
    question_id integer NOT NULL,
    tag_id integer NOT NULL
);


ALTER TABLE public.tagquestion OWNER TO postgres;

--
-- TOC entry 189 (class 1259 OID 33228)
-- Name: tagquestion_question_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.tagquestion_question_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.tagquestion_question_id_seq OWNER TO postgres;

--
-- TOC entry 2264 (class 0 OID 0)
-- Dependencies: 189
-- Name: tagquestion_question_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.tagquestion_question_id_seq OWNED BY public.tagquestion.question_id;


--
-- TOC entry 190 (class 1259 OID 33230)
-- Name: tagquestion_tag_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.tagquestion_tag_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.tagquestion_tag_id_seq OWNER TO postgres;

--
-- TOC entry 2265 (class 0 OID 0)
-- Dependencies: 190
-- Name: tagquestion_tag_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.tagquestion_tag_id_seq OWNED BY public.tagquestion.tag_id;


--
-- TOC entry 197 (class 1259 OID 33290)
-- Name: team; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.team (
    id integer NOT NULL,
    name text NOT NULL
);


ALTER TABLE public.team OWNER TO postgres;

--
-- TOC entry 196 (class 1259 OID 33288)
-- Name: team_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.team_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.team_id_seq OWNER TO postgres;

--
-- TOC entry 2266 (class 0 OID 0)
-- Dependencies: 196
-- Name: team_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.team_id_seq OWNED BY public.team.id;


--
-- TOC entry 199 (class 1259 OID 33301)
-- Name: teammember; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.teammember (
    id integer NOT NULL,
    name text NOT NULL,
    email text NOT NULL,
    title text NOT NULL,
    joindate timestamp with time zone DEFAULT now() NOT NULL,
    img_path text DEFAULT '0.png'::text NOT NULL
);


ALTER TABLE public.teammember OWNER TO postgres;

--
-- TOC entry 198 (class 1259 OID 33299)
-- Name: teammember_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.teammember_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.teammember_id_seq OWNER TO postgres;

--
-- TOC entry 2267 (class 0 OID 0)
-- Dependencies: 198
-- Name: teammember_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.teammember_id_seq OWNED BY public.teammember.id;


--
-- TOC entry 202 (class 1259 OID 33316)
-- Name: teamtoteammember; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.teamtoteammember (
    teamid integer NOT NULL,
    teammemberid integer NOT NULL
);


ALTER TABLE public.teamtoteammember OWNER TO postgres;

--
-- TOC entry 200 (class 1259 OID 33312)
-- Name: teamtoteammember_teamid_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.teamtoteammember_teamid_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.teamtoteammember_teamid_seq OWNER TO postgres;

--
-- TOC entry 2268 (class 0 OID 0)
-- Dependencies: 200
-- Name: teamtoteammember_teamid_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.teamtoteammember_teamid_seq OWNED BY public.teamtoteammember.teamid;


--
-- TOC entry 201 (class 1259 OID 33314)
-- Name: teamtoteammember_teammemberid_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.teamtoteammember_teammemberid_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.teamtoteammember_teammemberid_seq OWNER TO postgres;

--
-- TOC entry 2269 (class 0 OID 0)
-- Dependencies: 201
-- Name: teamtoteammember_teammemberid_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.teamtoteammember_teammemberid_seq OWNED BY public.teamtoteammember.teammemberid;


--
-- TOC entry 2014 (class 2604 OID 33213)
-- Name: postid; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.answer ALTER COLUMN postid SET DEFAULT nextval('public.answer_postid_seq'::regclass);


--
-- TOC entry 2015 (class 2604 OID 33214)
-- Name: questionid; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.answer ALTER COLUMN questionid SET DEFAULT nextval('public.answer_questionid_seq'::regclass);


--
-- TOC entry 2001 (class 2604 OID 33134)
-- Name: id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.baninfo ALTER COLUMN id SET DEFAULT nextval('public.baninfo_id_seq'::regclass);


--
-- TOC entry 2029 (class 2604 OID 49243)
-- Name: id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.contact ALTER COLUMN id SET DEFAULT nextval('public.contact_id_seq'::regclass);


--
-- TOC entry 2005 (class 2604 OID 33172)
-- Name: id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.post ALTER COLUMN id SET DEFAULT nextval('public.post_id_seq'::regclass);


--
-- TOC entry 2006 (class 2604 OID 33173)
-- Name: posterid; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.post ALTER COLUMN posterid SET DEFAULT nextval('public.post_posterid_seq'::regclass);


--
-- TOC entry 2021 (class 2604 OID 33273)
-- Name: postid; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.postreport ALTER COLUMN postid SET DEFAULT nextval('public.postreport_postid_seq'::regclass);


--
-- TOC entry 2019 (class 2604 OID 33254)
-- Name: postid; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.postvote ALTER COLUMN postid SET DEFAULT nextval('public.postvote_postid_seq'::regclass);


--
-- TOC entry 2010 (class 2604 OID 33192)
-- Name: postid; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.question ALTER COLUMN postid SET DEFAULT nextval('public.question_postid_seq'::regclass);


--
-- TOC entry 2000 (class 2604 OID 33099)
-- Name: subjectid; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.subject ALTER COLUMN subjectid SET DEFAULT nextval('public.subject_subjectid_seq'::regclass);


--
-- TOC entry 2004 (class 2604 OID 33157)
-- Name: id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tag ALTER COLUMN id SET DEFAULT nextval('public.tag_id_seq'::regclass);


--
-- TOC entry 2017 (class 2604 OID 33235)
-- Name: question_id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tagquestion ALTER COLUMN question_id SET DEFAULT nextval('public.tagquestion_question_id_seq'::regclass);


--
-- TOC entry 2018 (class 2604 OID 33236)
-- Name: tag_id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tagquestion ALTER COLUMN tag_id SET DEFAULT nextval('public.tagquestion_tag_id_seq'::regclass);


--
-- TOC entry 2023 (class 2604 OID 33293)
-- Name: id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.team ALTER COLUMN id SET DEFAULT nextval('public.team_id_seq'::regclass);


--
-- TOC entry 2024 (class 2604 OID 33304)
-- Name: id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.teammember ALTER COLUMN id SET DEFAULT nextval('public.teammember_id_seq'::regclass);


--
-- TOC entry 2027 (class 2604 OID 33319)
-- Name: teamid; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.teamtoteammember ALTER COLUMN teamid SET DEFAULT nextval('public.teamtoteammember_teamid_seq'::regclass);


--
-- TOC entry 2028 (class 2604 OID 33320)
-- Name: teammemberid; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.teamtoteammember ALTER COLUMN teammemberid SET DEFAULT nextval('public.teamtoteammember_teammemberid_seq'::regclass);


--
-- TOC entry 1994 (class 2604 OID 33079)
-- Name: id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.users ALTER COLUMN id SET DEFAULT nextval('public."User_id_seq"'::regclass);


--
-- TOC entry 2270 (class 0 OID 0)
-- Dependencies: 173
-- Name: User_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public."User_id_seq"', 125, true);


--
-- TOC entry 2226 (class 0 OID 33210)
-- Dependencies: 188
-- Data for Name: answer; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.answer (postid, questionid, iscorrect) FROM stdin;
19	18	f
20	18	f
21	18	f
65	18	f
66	18	f
67	18	f
68	18	f
69	18	f
71	70	f
72	3	f
73	3	f
77	41	f
78	15	f
80	18	f
86	85	f
87	85	f
88	85	f
89	85	f
90	85	f
91	85	f
92	85	f
94	93	f
96	95	f
102	101	f
103	101	f
124	107	f
\.


--
-- TOC entry 2271 (class 0 OID 0)
-- Dependencies: 186
-- Name: answer_postid_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.answer_postid_seq', 1, false);


--
-- TOC entry 2272 (class 0 OID 0)
-- Dependencies: 187
-- Name: answer_questionid_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.answer_questionid_seq', 1, true);


--
-- TOC entry 2216 (class 0 OID 33131)
-- Dependencies: 178
-- Data for Name: baninfo; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.baninfo (id, duration, description, ispermanent, initdate, enddate, userid, adminid) FROM stdin;
10	2	sadsadas	f	2018-05-06 13:48:27.653286+00	2018-05-08 00:00:00+00	37	37
11	\N	dAAdad	t	2018-05-06 13:49:43.538402+00	\N	37	37
12	\N	FSAFASFAS	t	2018-05-06 13:49:54.569891+00	\N	37	37
13	\N	dgsdgsdg	t	2018-05-06 13:56:22.905139+00	\N	37	37
14	\N	hk	t	2018-05-06 14:36:58.346103+00	\N	99	37
15	\N	vcvfhdfhdf	t	2018-05-06 19:41:49.539917+00	\N	98	37
16	\N	gddsg	t	2018-05-09 15:57:14.717901+00	\N	60	99
17	1	Toxicity	f	2018-05-10 00:11:57.325786+00	2018-05-11 00:00:00+00	1	48
18	1	dsd	f	2018-05-10 00:18:09.936509+00	2018-05-11 00:00:00+00	1	48
19	1	sdsd	f	2018-05-10 00:27:38.334877+00	2018-05-11 00:00:00+00	1	48
20	1	we	f	2018-05-10 02:12:17.478969+00	2018-05-11 00:00:00+00	1	48
21	1	s	f	2018-05-10 03:22:57.682441+00	2018-05-11 00:00:00+00	1	48
22	1	sd	f	2018-05-12 15:44:39.801784+00	2018-05-13 00:00:00+00	49	48
\.


--
-- TOC entry 2273 (class 0 OID 0)
-- Dependencies: 177
-- Name: baninfo_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.baninfo_id_seq', 22, true);


--
-- TOC entry 2242 (class 0 OID 49240)
-- Dependencies: 204
-- Data for Name: contact; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.contact (id, message, date, userid, subjectid, processed) FROM stdin;
2	ddgdsgsdgsdgsd	2018-05-05 15:20:46.157996+00	99	1	t
4	sdfsdfdsf	2018-05-06 18:01:15+00	\N	1	f
5	dsdsad	2018-05-06 18:26:10+00	\N	2	f
6	dsdsad	2018-05-06 18:26:19+00	\N	2	f
7	dsdsad	2018-05-06 18:26:40+00	\N	2	f
8	dsdsad	2018-05-06 18:26:57+00	\N	2	f
9	asd	2018-05-06 18:27:28+00	\N	2	f
10	asdasd	2018-05-06 18:37:09+00	\N	2	f
11	dadsadasdas	2018-05-09 15:49:35+00	99	2	t
12	sdggdssdgsdgsdg	2018-05-10 19:50:22+00	37	1	t
13	sdkgjdsk	2018-05-15 14:16:39+00	37	1	t
\.


--
-- TOC entry 2274 (class 0 OID 0)
-- Dependencies: 203
-- Name: contact_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.contact_id_seq', 13, true);


--
-- TOC entry 2243 (class 0 OID 49271)
-- Dependencies: 205
-- Data for Name: faqcategory; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.faqcategory (id, name) FROM stdin;
1	General Questions
2	Community Members
\.


--
-- TOC entry 2244 (class 0 OID 49282)
-- Dependencies: 206
-- Data for Name: faqentry; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.faqentry (id, question, answer, category) FROM stdin;
1	Is account registration required?	Account registration at\n                                                <strong>Code Home</strong> is only required if you want to post or responde to questions.	1
2	How to avoid being banned?	 Respect other users.\n                                                <br> Respond only when you have knowldge about the theme\n                                                <br> Bump is only allowed after 48 hours with no response	2
\.


--
-- TOC entry 2221 (class 0 OID 33169)
-- Dependencies: 183
-- Data for Name: post; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.post (id, posterid, content, date, isvisible, points) FROM stdin;
35	99	<p>szfafasfassf</p>	2018-05-03 16:36:16.55929+00	f	0
34	99	<p>szfafasfassf</p>	2018-05-03 16:36:00.708235+00	f	0
33	99	<p>szfafasfassf</p>	2018-05-03 16:33:32.160861+00	f	0
18	99	<p>sdsd</p>	2018-04-27 01:05:50.918721+00	f	0
19	98	teste	2018-04-27 01:05:50.918721+00	f	20
20	98	teste2	2018-04-27 01:06:50.918721+00	f	10
21	48	teste3	2018-04-27 01:07:50.918721+00	f	500
65	48	<p>teste4</p>	2018-05-03 16:50:10.937131+00	f	0
66	48	<p>teste5</p>	2018-05-03 16:51:05.224574+00	f	0
67	48	<p>teste6</p>	2018-05-03 16:55:20.898203+00	f	0
68	48	teste7	2018-05-03 17:02:50.380265+00	f	0
69	48	teste8	2018-05-03 17:48:48.741932+00	f	0
80	48	teste3	2018-05-08 00:14:49.890497+00	f	0
16	99	<p>sdsd</p>	2018-04-27 01:04:06.282108+00	f	0
85	48	<p>asdadsads<br></p>	2018-05-09 02:07:26.490743+00	f	0
86	48	cgfbhchvg	2018-05-09 02:11:16.745774+00	f	0
87	48	stuffing	2018-05-09 02:11:27.175579+00	f	0
17	99	<p>sdsd</p>	2018-04-27 01:04:56.392649+00	f	0
88	99	zxcxczzxczx	2018-05-09 02:13:48.357705+00	f	0
15	99	<p>sdsd</p>	2018-04-27 01:03:46.69028+00	f	0
78	121	Hi :)	2018-05-05 23:12:31.876914+00	f	0
12	99	<p>sdsd</p>	2018-04-27 01:00:07.083242+00	f	0
11	99	<p>sdsd</p>	2018-04-27 00:58:02.597729+00	f	0
10	99	<p>sdsd</p>	2018-04-27 00:54:46.885796+00	f	0
89	99	zxdcfzdczdf	2018-05-09 02:15:47.2301+00	f	0
90	48	dfsdfssfd	2018-05-09 02:15:49.728509+00	f	0
91	99	sdfdsfsfdsfdsfd	2018-05-09 02:16:14.536024+00	f	0
92	99	zxczxcczxzcx	2018-05-09 02:16:21.479977+00	f	0
93	99	<p>dasasddas<br></p>	2018-05-09 02:17:48.713921+00	f	0
94	99	zcxzxcczx	2018-05-09 02:17:51.685149+00	f	0
95	99	<p>xcvvxcxcv<br></p>	2018-05-09 02:18:21.087297+00	f	0
96	99	xcvxvcxcvcxvcvxxcv	2018-05-09 02:18:34.509845+00	f	0
76	48	<p>asdasdsdasdaasd<br></p>	2018-05-03 21:05:08.176249+00	f	-19
74	48	<p>dsaasdsdaasd<br></p>	2018-05-03 20:50:45.64504+00	f	1
70	99	<p>dasasdsa</p>	2018-05-03 18:28:20.675851+00	f	0
71	99	sdgsdgsdgsd	2018-05-03 18:29:02.18165+00	f	1
64	99	<p>szfafasfassf</p>	2018-05-03 16:48:48.393968+00	f	0
75	48	<p>stuffing stufish<br></p>	2018-05-03 20:51:13.546772+00	f	-1
79	48	<p>asdasdsad<br></p>	2018-05-06 18:51:35.861536+00	f	0
98	48	<p>AH AFINAL SABE<br></p>	2018-05-10 02:40:48.741293+00	t	0
97	48	<p>asdasdas<br></p>	2018-05-10 02:24:38.911473+00	t	0
14	99	<p>asas</p>	2018-04-27 01:02:13.961202+00	f	0
13	99	<p>asas</p>	2018-04-27 01:00:53.112376+00	f	0
6	99	<p>sdsd</p>	2018-04-27 00:45:55.767274+00	f	1
119	48	<p>5<br></p>	2018-05-12 01:26:00.065045+00	f	0
41	99	<p>szfafasfassf</p>	2018-05-03 16:41:42.988414+00	f	0
5	99	<p>adad</p>	2018-04-27 00:45:34.889573+00	f	-1
77	37	ewstwefdsds	2018-05-05 11:35:50.484174+00	f	0
4	99	<p>asdsad</p>	2018-04-27 00:44:48.780128+00	f	-19
118	48	<p>5<br></p>	2018-05-12 01:25:56.7234+00	f	0
3	99	<p>sdsd</p>	2018-04-27 00:23:47.305082+00	f	-1
72	48	asdasddas	2018-05-03 20:34:38.362448+00	f	0
73	48	scccxcccc	2018-05-03 20:34:46.082382+00	f	0
81	48	<p>gfhhfg<br></p>	2018-05-09 02:06:26.29116+00	f	0
82	48	<p>dgfgdf<br></p>	2018-05-09 02:06:47.129932+00	t	0
83	48	<p>dfgdf<br></p>	2018-05-09 02:06:56.110293+00	t	0
84	48	<p>asdasdas<br></p>	2018-05-09 02:07:09.449519+00	t	0
117	48	<p>5<br></p>	2018-05-12 01:25:54.15516+00	f	0
8	99	<p>sdsd</p>	2018-04-27 00:50:54.777485+00	f	8888
110	48	<p>5<br></p>	2018-05-12 01:25:11.367526+00	f	0
109	48	<p>5<br></p>	2018-05-12 01:25:08.495211+00	f	0
121	48	<p>5<br></p>	2018-05-12 01:26:06.322515+00	f	0
108	48	<p>5<br></p>	2018-05-12 01:25:05.969879+00	f	0
104	48	<p>as<br></p>	2018-05-12 01:24:40.514944+00	t	0
105	48	<p>2<br></p>	2018-05-12 01:24:47.808061+00	t	0
106	48	<p>5<br></p>	2018-05-12 01:24:57.288909+00	t	0
100	48	<p>asdasdas<br></p>	2018-05-11 01:07:13.824287+00	t	0
116	48	<p>5<br></p>	2018-05-12 01:25:51.511812+00	f	0
115	48	<p>5<br></p>	2018-05-12 01:25:48.781642+00	f	0
114	48	<p>5<br></p>	2018-05-12 01:25:46.012579+00	f	0
123	48	<p>5<br></p>	2018-05-12 01:26:11.849453+00	t	-1
113	48	<p>5<br></p>	2018-05-12 01:25:22.18375+00	f	0
112	48	<p>5<br></p>	2018-05-12 01:25:17.355648+00	f	0
101	37	<p>fasfaffasfsa</p>	2018-05-11 14:41:30.799635+00	f	0
9	99	<p>sdsd</p>	2018-04-27 00:52:41.236788+00	f	88888
7	99	<p>sdsd</p>	2018-04-27 00:47:52.406911+00	f	888
102	37	dasfsafasfas	2018-05-11 14:41:36.822025+00	f	0
122	48	<p>5<br></p>	2018-05-12 01:26:09.257772+00	f	0
103	37	fsafasfasfsa	2018-05-11 14:41:54.097013+00	f	0
120	48	<p>5<br></p>	2018-05-12 01:26:03.685807+00	f	0
111	48	<p>5<br></p>	2018-05-12 01:25:14.230354+00	f	0
107	48	<p>5<br></p>	2018-05-12 01:25:03.443267+00	t	1
99	48	<p>stuffing<br></p>	2018-05-10 03:00:51.238043+00	t	1
124	121	responde	2018-05-22 13:39:02.455877+00	t	0
\.


--
-- TOC entry 2275 (class 0 OID 0)
-- Dependencies: 181
-- Name: post_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.post_id_seq', 124, true);


--
-- TOC entry 2276 (class 0 OID 0)
-- Dependencies: 182
-- Name: post_posterid_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.post_posterid_seq', 1, false);


--
-- TOC entry 2233 (class 0 OID 33270)
-- Dependencies: 195
-- Data for Name: postreport; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.postreport (postid, reporterid, date, reason) FROM stdin;
34	48	2018-05-05 21:13:12+00	asdadsasd
79	48	2018-05-08 19:00:15+00	aaaa
85	48	2018-05-09 02:11:12+00	asasasas
87	48	2018-05-09 02:13:06+00	sdfsdfdfssdf
85	99	2018-05-09 02:13:42+00	sddssd
87	99	2018-05-09 02:15:31+00	xzzx
99	37	2018-05-11 00:32:09+00	Test report
97	48	2018-05-11 02:10:42+00	dfbdfb
100	48	2018-05-11 02:10:52+00	asd
100	37	2018-05-11 11:26:30+00	asfasfsafasfasfasf
107	37	2018-05-15 13:56:34+00	dfsfsdfs
\.


--
-- TOC entry 2277 (class 0 OID 0)
-- Dependencies: 194
-- Name: postreport_postid_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.postreport_postid_seq', 1, false);


--
-- TOC entry 2231 (class 0 OID 33251)
-- Dependencies: 193
-- Data for Name: postvote; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.postvote (postid, posterid, value) FROM stdin;
123	37	-1
107	37	1
99	37	1
\.


--
-- TOC entry 2278 (class 0 OID 0)
-- Dependencies: 192
-- Name: postvote_postid_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.postvote_postid_seq', 1, false);


--
-- TOC entry 2223 (class 0 OID 33189)
-- Dependencies: 185
-- Data for Name: question; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.question (postid, isclosed, nviews, title) FROM stdin;
13	f	1	asas
14	f	1	asas
15	f	1	sdsd
16	f	1	sdsd
6	t	1	sdsd
3	t	1	sdsd
4	t	1	asdasd
5	t	1	adad
7	t	1	sdsd
8	t	1	sdsd
9	t	1	sdsd
10	t	1	sdsd
11	t	1	sdsd
12	t	1	sdsd
18	t	1	sdsd
17	t	1	sdsd
33	f	0	Title
34	f	0	Title
35	f	0	Title
41	f	0	Title
74	f	0	sadsda
75	f	0	stuffing
76	f	0	asczx
70	t	0	fsdsfsdf
64	t	0	Title
79	f	0	cenas question
81	f	0	cvbbcvcbghf
82	f	0	cbvdfgdfgfd
83	f	0	dgfgdf
84	f	0	gsdfgfgfdfgdfg
85	f	0	Javas
93	f	0	asddas
95	f	0	xvcvxc
97	f	0	sdfs
98	f	0	QuestionThatHasJavaTag
99	f	0	This Question has tag C++
100	f	0	C++ and Java Tags
101	f	0	fassfas
104	f	0	1
105	f	0	2
106	f	0	3
107	f	0	4
108	f	0	5
109	f	0	6
110	f	0	7
111	f	0	8
112	f	0	9
113	f	0	10
114	f	0	11
115	f	0	12
116	f	0	13
117	f	0	14
118	f	0	15
119	f	0	16
120	f	0	17
121	f	0	18
122	f	0	19
123	f	0	20
\.


--
-- TOC entry 2279 (class 0 OID 0)
-- Dependencies: 184
-- Name: question_postid_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.question_postid_seq', 1, false);


--
-- TOC entry 2214 (class 0 OID 33096)
-- Dependencies: 176
-- Data for Name: subject; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.subject (subjectid, name) FROM stdin;
1	General Customer Service
2	Suggestions
3	Product Support
\.


--
-- TOC entry 2280 (class 0 OID 0)
-- Dependencies: 175
-- Name: subject_subjectid_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.subject_subjectid_seq', 1, false);


--
-- TOC entry 2218 (class 0 OID 33154)
-- Dependencies: 180
-- Data for Name: tag; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.tag (id, name) FROM stdin;
1	c++
2	Java
3	JavaScript
11	frt
12	yyy
13	java
14	gffggh
15	gdfdgf
16	gdfdgfdfgfgddfg
17	asdasd
18	cxvxcvxcv
19	C++
20	as
21	2
22	4
\.


--
-- TOC entry 2281 (class 0 OID 0)
-- Dependencies: 179
-- Name: tag_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.tag_id_seq', 22, true);


--
-- TOC entry 2229 (class 0 OID 33232)
-- Dependencies: 191
-- Data for Name: tagquestion; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.tagquestion (question_id, tag_id) FROM stdin;
76	2
79	2
81	14
82	15
83	16
84	2
85	3
93	17
95	18
97	2
98	2
99	19
100	19
100	2
101	3
104	20
105	21
106	22
107	22
108	22
109	22
110	22
111	22
112	22
113	22
114	22
115	22
116	22
117	22
118	22
119	22
120	22
121	22
122	22
123	22
\.


--
-- TOC entry 2282 (class 0 OID 0)
-- Dependencies: 189
-- Name: tagquestion_question_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.tagquestion_question_id_seq', 1, false);


--
-- TOC entry 2283 (class 0 OID 0)
-- Dependencies: 190
-- Name: tagquestion_tag_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.tagquestion_tag_id_seq', 1, false);


--
-- TOC entry 2235 (class 0 OID 33290)
-- Dependencies: 197
-- Data for Name: team; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.team (id, name) FROM stdin;
1	General
2	Quality Assurance
3	Support
\.


--
-- TOC entry 2284 (class 0 OID 0)
-- Dependencies: 196
-- Name: team_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.team_id_seq', 1, false);


--
-- TOC entry 2237 (class 0 OID 33301)
-- Dependencies: 199
-- Data for Name: teammember; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.teammember (id, name, email, title, joindate, img_path) FROM stdin;
1	Davide Costa	up201503995@fe.up.pt	MIEIC Student	2018-05-08 17:23:54.892421+00	Davide Costa.jpg
4	Tiago Magalhães	up2016	MIEIC Student	2018-05-08 17:26:28.871703+00	Tiago Magalhaes.jpg
3	Diogo Reis	up201505472@fe.up.pt	MIEIC Student	2018-05-08 17:26:28.871703+00	Diogo Reis.jpg
2	Dinis SIlva	up201504196@fe.up.pt	MIEIC Student	2018-05-08 17:26:28.871703+00	Dinis Trigo.jpg
\.


--
-- TOC entry 2285 (class 0 OID 0)
-- Dependencies: 198
-- Name: teammember_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.teammember_id_seq', 1, false);


--
-- TOC entry 2240 (class 0 OID 33316)
-- Dependencies: 202
-- Data for Name: teamtoteammember; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.teamtoteammember (teamid, teammemberid) FROM stdin;
1	1
1	2
1	3
1	4
2	1
2	3
3	2
3	4
\.


--
-- TOC entry 2286 (class 0 OID 0)
-- Dependencies: 200
-- Name: teamtoteammember_teamid_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.teamtoteammember_teamid_seq', 1, false);


--
-- TOC entry 2287 (class 0 OID 0)
-- Dependencies: 201
-- Name: teamtoteammember_teammemberid_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.teamtoteammember_teammemberid_seq', 1, false);


--
-- TOC entry 2212 (class 0 OID 33076)
-- Dependencies: 174
-- Data for Name: users; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.users (id, username, type, pass_token, auth_type, email, state, description, img_path, points, remember_token) FROM stdin;
3	test1	REGULAR	11	0	test1	ACTIVE	test1	0.png	0	\N
4	gbgdsgsd	REGULAR	klj	0	jk	ACTIVE	lkj	0.png	0	\N
7	gbgdsgsdrwqrqw	REGULAR	12	0	jkrwqrqwrqwr	ACTIVE	lkjqrqwr	0.png	0	\N
60	cenas12345	REGULAR	$2y$10$WgDiRUP5l4FFA4sQb0teG.ZJQn9R6hFvKGEcF1Sq4KaOItHXDFswS	0	1@gmail.com	ACTIVE	\N	0.png	0	NFQd2TGjIbvWtUhlsempXx0llU6cKy1qXy3SCiTwScN6l7uu0afZKSoK3rWF
9	gbgdsgsdrwqrqwfsa	REGULAR	12	0	jkrwqrqfasfaswrqwr	ACTIVE	lkjqrqwr	0.png	0	\N
10	sfsfafsa	REGULAR	12	0	sfasfaasf	ACTIVE	fsasaffas	0.png	0	\N
11	sfsfafsagds	REGULAR	12	0	sfasfaasfgds	ACTIVE	fsasaffas	0.png	0	\N
12	sfsfafsagdsfsaaf	REGULAR	12	0	sfasfaasfgfsafds	ACTIVE	fsasaffasfsa	0.png	0	\N
98	cenas20	REGULAR	$2y$10$O5kXZDsf26OP4Rrvbt9zfuzsiHWKgAosFtClUDv3TKbOnMVHA2SVG	0	adjbabd@sd.com	ACTIVE	\N	0.png	1	\N
14	sfsfafsagdsfsaafasf	REGULAR	12	0	sfasfaasfgfsafsafds	ACTIVE	fsasaffasfsa	0.png	0	\N
15	sfsfafsagdsfsaafasfsffa	REGULAR	12	0	sfasfaasfgfsafsafdsfasfa	ACTIVE	fsasaffasfsa	0.png	0	\N
16	caca	REGULAR	Caca1234	0	caca@gmail	ACTIVE	kjljkljk	0.png	0	\N
17	sfsfafsagdsfsaafasfsffafassfa	REGULAR	12	0	sfasfaasfgfsafsafdsfasfafsasaf	ACTIVE	fsasaffasfsa	0.png	0	\N
18	fsdfsd	REGULAR	Caca1234	0	fsdfsdfs	ACTIVE	fsdfsfsd	0.png	0	\N
19	fsdfs	REGULAR	Caca1234	0	fsdfs@gmail.com	ACTIVE	fsdfsd	0.png	0	\N
20	sfsfafsagdsfsaafasfsffafassfafsaasf	REGULAR	12	0	sfasfaasfgfsafsafdsfasfafsasaffasasf	ACTIVE	fsasaffasfsa	0.png	0	\N
1	test	REGULAR	12	0	test	BANNED	test	0.png	0	\N
23	sfsfafsagdsfsaafasfsffafassfafsaasfdgsdgsdsg	REGULAR	12	0	sfasfaasfgfsafsafdsfasfafsasaffasasfdgssdgdsg	ACTIVE	fsasaffasfsa	0.png	0	\N
24	saafasfsffafassfafsaasfdgsdgsdsg	REGULAR	12	0	sffsasaffasasfsafdgssdgdsg	ACTIVE	fsasaffasfsa	0.png	0	\N
26	fsasfasaf	REGULAR	Test1234	0	asfsafsfa@jdflkgjkd.com	ACTIVE	fssafasffas	0.png	0	\N
49	cenas1	REGULAR	$2y$10$QUU9RvKeWayOFXRJNSCZtuqYSv.BpNw5WL0jKcgawAIbf1QkCiUFq	0	manel1@gmail.com	BANNED	\N	0.png	0	pXrwZYwAu9fA8C9nRq8YjHNrMnVctE8p31X1v7qfYRsDZXBOfqELmwlw4llU
29	www	REGULAR	Test1234	0	dd@afdl.com	ACTIVE	eqdasfasf	0.png	0	\N
32	123	REGULAR	$2y$10$0SCcufAl2GQmAom7AThmy.ar7SOFYbN60O/57ZLYwBaSA6/0TWGyy	0	dsgsdgd@fkçslk	ACTIVE	gdsdgsdgsgsd	0.png	0	\N
35	kjsdfhkjsdghjs	REGULAR	$2y$10$411IXiz3Hfd2kREz1upoB.GseDxrnLhufjKszM9iTNBphJWia0fE2	0	slkgjsdl@dsjg.com	ACTIVE	fpoafkçlf	0.png	0	\N
34	diogo	REGULAR	$2y$10$RGh3EkT3o4kIQcYP6TdPQu/xOVHz5Dn9x2cLpRA8ZNmkNcm9YjQ4.	0	gdsdgsdg@jdsagfdls.com	ACTIVE	21412412	0.png	0	\N
36	gfdgdf	REGULAR	$2y$10$RxB116KcBZvndW/R6PPlsOOwbSoSCpUqIO1oarXqoFNg6qXcZsQXG	0	ffff@gmail.com	ACTIVE	dfgfdg	0.png	0	\N
38	testtest	REGULAR	$2y$10$22sNedAGIEK0rsm1nwH03.bNHN2fuR.E.KDarpAWKzIiE5ULsLaIO	0	test@gmail.com	ACTIVE	iasfhjlkasfj	0.png	0	\N
39	111	REGULAR	$2y$10$4M3aLHWr.fVypPVJQvT..eZsBf5W2C4dDc0gDlB1D0kB3qWDyr3ti	0	fskljsdl@hjfdlks.com	ACTIVE	fçsalkfçlaskçlfsakç	0.png	0	\N
51	diogoreis	REGULAR	$2y$10$2jPo9hOBBO0AoCazowMqKOVlcAs13kKeHchXgsVoSgdcTCADwAcf2	0	diogoreis95@hotmail.com	ACTIVE	\N	0.png	0	SjYOslOR7ID2NWh1jVILZkUiraWy6HIRlGUSKLi6ix7q1gyse91MLOcmeair
31	1111	REGULAR	$2y$10$.fKabDAj9ftOjFjOR8UiiOvM7S4RGVjJlhT2uL740B7mJUVGUfW.2	0	DHKAJF@DHJVHJVLKSK.COM	ACTIVE	1E414R32	0.png	0	xOjSclXbmT8jjxXkx86XoAIdNoG3w2VwDGM4hxywmhDKOy7ASPDL9fo77rPi
54	ppppdAADaD	REGULAR	$2y$10$D4qKb0AU.IPl1j9smLs6IedHrA6miVS5dizDPkrALG36vJQF3mn7W	0	pppp@gmail.comDAadAd	INACTIVE	fsadsasfaafsfgasfsasfaasffsasafasffffffffffffffffffffffff	0.png	0	uhLtqEcbjXUNwh0IOQihCNx76voraTlqRQr7F7tagLcvzlhlxBULsroZpWfD
53	blabla	REGULAR	$2y$10$X7mt5PsU5Ml3ET9BK072Y.7tlGDyJ2tj0OQhN7/JW73RmzLBJb1uq	0	wooerwq@jdlasfj.com	ACTIVE	\N	0.png	0	37pNlZcWkKmkusSmMKDqff3FTSK3fe5gPtaPjmGOhZK3l2rn7IUldqgPh5nH
56	cenas12	ADMIN	$2y$10$2SnS2rH/4p.cxIgiVT0u9uuEGwU8F18z6Iwrdg.cGyJ.t6LMLS2hm	0	cenas@cenas.com	ACTIVE	\N	0.png	0	ewHay7k97qBEcMNtr6lynPwDgD91K93ehgaNrisPHeQo0fHdmQMyC25Gw96O
94	asffsa	REGULAR	$2y$10$tijC03z931b94Cf3rtQI1.dfFzjeEBLF1zC0kURCD4hxyNMdAZ0d2	0	fsasaffs@asfkjahk.com	ACTIVE	\N	0.png	0	8nvPXAfKUDElXkFXT5ckmNpxKfEhbu2tEN2rXoOJqbKTcv9SsBJ7clVCvcIe
55	TestingN	REGULAR	$2y$10$bAktZreL2ZmO7SqAHMmLh.Jq4qbXkICOrGtlFzYVOtE5om4u1whZS	0	Testing@gmail.com	ACTIVE	\N	0.png	0	1nk8rNTzgZRQGTtQpBGxch01DCTrEmGjd60RwyI8Pf99B4jjRaMqYUSNq4nu
46	cenas123	REGULAR	$2y$10$NioJshEwdh2I2RgsIoFZxuQ859a6pRyWLFcojw2jZ1DqDlLvJf.Dm	0	manel@gmail.com2	ACTIVE	\N	0.png	0	6Rt5SwNZHxFhx7lhfhKLh7XXi3mF9hNOrVlUtduzR3LP0WxgYhRIXzr7pwNo
95	stuffingstuff	REGULAR	$2y$10$qxQJN7nj0ssTUOkQQ9bIbueRxWvflWbAKnsAy8Uvqin6S.7UkjiTO	0	stuffingstuff@gmail.com	INACTIVE	\N	0.png	0	efloua05phtc35QBXEfkxeyDCybo7MsAt6zgyZQnw65fVLv76rqyoYMtoqQH
61	jaslkfkaçl	REGULAR	$2y$10$8KwwbG5DW8ACYntdCYPhFu2yROW/g8Miq/LnKTKIjoM6v6jiSXFq6	0	ddddd@kfldas.com	ACTIVE	\N	0.png	0	wIZCBB6HqJC9J5VcgnqdnS5l1bxX9rrRC9puX3okZHtswzbRUauZuoTlDBxE
40	222	REGULAR	$2y$10$bssA3wPxE8.2WFoUbR8TGuUv0csPKR0kNmdWU1gbdfXaatYmNy75m	0	222@fe.up.pt	INACTIVE	fljalkfsjsaflkjsaflk	0.png	0	\N
58	yyy	REGULAR	$2y$10$yq3bmHNFsWdtNsE110gd/O8rQ2VZyMencZAUWNjgtXt.32nPb2B8y	0	aklsfjalsk@djlks.com	INACTIVE	fasfsafsafsa	0.png	0	3agXICSgDI3Te5acNGuRjpdSIW5LVTiwDo5ajyepwmbLzIKERVuzLyNIHGb8
57	ttt	REGULAR	$2y$10$B1PwtmugBsMGYzeIeU63JO6X0LiwB/QRGLVlS4g0CGaXkkDGCIrPO	0	gfasfsaassa@gmail.com	INACTIVE	\N	0.png	0	3LYqaPKywhyvWBZjlBXJRvHEpQyyaaGqKepz7QNOYSSQjRKrF6cCh6tds3zM
59	Lbaw	REGULAR	$2y$10$Np72MQqd3EHRWrmvKDcTxe6GF4Mf0DENP1b5lKotm0lwyDny8t.ia	0	Lbaw@gmail.com	INACTIVE	Lbaw	0.png	0	MOXWEoPW6Ab667JrkKLEHtw8i8Bagnw1yWjMho5DHpbnjmFrzo87OZAEySe9
96	arrefole	REGULAR	$2y$10$j8JRVvcqYJIruFwRi7c14u.v6b5jhhklSDW.c/2TB5wTuweCVd2Oa	0	arrefole@banda.com	ACTIVE	\N	0.png	0	tuQV5If2lB71fC2DqlYL3h5X8wqyzZZ1iMEREJCvYAqSxYLSQvAXyYu1KGCs
97	cenas10	REGULAR	$2y$10$26fZ.E0pqBwhhRl.tQ/jsu4/4ggW.lHq/i4n6Os.BzSsIWVG/MNiW	0	sodj@gm.com	ACTIVE	\N	0.png	0	E2uflGYDAij5ZNAYd1V0jDlBWDMwPNDoByOBSDTRaXSjkyeDFClSn0d33L1A
125	Davide Henrique Fernandes da Costa22474506	REGULAR	102067226835393709342	1	davidehfc@gmail.com	ACTIVE	\N	https://lh6.googleusercontent.com/-eQ6gCuJiQ3I/AAAAAAAAAAI/AAAAAAAAAIM/si99Z4LW024/s96-c/photo.jpg	0	ha9Ov7R1ogUxvMq5mRmHHqz385d1RjQWfhn53V82JT7JV3CXkWxk01cRdydA
48	cenas	ADMIN	$2y$10$GPtwomHX4zv.yJZipBMkpOAgeUQDjDupUnjPlF7IDmj/xOfBf3p/G	0	manel@gmail.com	ACTIVE	sdsdsd	0.png	7	qymMOGV9MSuBqfKfqLzcrgoLud5yX3OAeKVy4nlecEgHAEvVBbyDAmNbADqs
118	TiagoTest2	REGULAR	$2y$10$NEkFRB7z9JQgT0QIt7AuE./TvUJ8cBi2fRt.DZ26BljDqBRpI/TS.	0	testtest@gmail.com	ACTIVE	\N	0.png	0	IE7g5OSnmWv9otzZ8hNIYJJy5OH3V7syyLonI4t1IP6npd5vUlyfj8fkYh5B
121	strbonus	ADMIN	114477816892656720569	1	crakylps@gmail.com	ACTIVE	Rock And Roll	https://lh5.googleusercontent.com/-o1nnl1HcNJ0/AAAAAAAAAAI/AAAAAAAAARU/TPI2xeywB60/s96-c/photo.jpg	0	hFfFFVMZu8wf6yIB4tJBzA2eT9N6jtDbY2Xg27vMXLpp73AbLe2mrFu2sNuv
120	Tiago Magalhães21121	ADMIN	106048134885856570006	1	tiagojsmagalhaes@gmail.com	ACTIVE	\N	0.png	0	WBFPk86I8cYL7LHDLXgEYXUCzAVgOKIgqTGeSHDex7uEAnb6LwYWj3YWoykS
99	cenas69	ADMIN	$2y$10$mkZJJMTlfieuZPZNHLmW2OB16Y3AGAagILLR2wyyNO1NptJO.q0fm	0	cenas@oajfoajf.com	ACTIVE	addasad	99.png	-101	jSiY50Rl3x2xnUNGf22opny98C7mAgii7lwAuVTrdc2N8ATOHOLFMJFXiLf1
37	TiagoTest	ADMIN	$2y$10$mkZJJMTlfieuZPZNHLmW2OB16Y3AGAagILLR2wyyNO1NptJO.q0fm	0	TiagoTest@email.com	ACTIVE	Programmer	0.png	100	bGnZffZDmgqR5QyzsBCuYesUpX9myumgSy6RalhvMuoUVzNLFjOHkPMPvMKJ
119	Testing123	REGULAR	$2y$10$U69KMUU5bFZaERMn6GgRPuQaAcaEd4yMMJ2U6EYoSqd1Et1kxWKvy	0	testing1234@gmail.com	ACTIVE	\N	0.png	0	46e2l29sK0wGuWJenZH842X2omIa4QBiw5yVRsx7myoUwlpiyWMRGOwMgzbA
\.


--
-- TOC entry 2033 (class 2606 OID 33093)
-- Name: User_email_key; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.users
    ADD CONSTRAINT "User_email_key" UNIQUE (email);


--
-- TOC entry 2035 (class 2606 OID 33091)
-- Name: User_username_key; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.users
    ADD CONSTRAINT "User_username_key" UNIQUE (username);


--
-- TOC entry 2053 (class 2606 OID 33217)
-- Name: answerpk; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.answer
    ADD CONSTRAINT answerpk PRIMARY KEY (postid);


--
-- TOC entry 2043 (class 2606 OID 33141)
-- Name: banpk; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.baninfo
    ADD CONSTRAINT banpk PRIMARY KEY (id);


--
-- TOC entry 2067 (class 2606 OID 49250)
-- Name: contactpk; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.contact
    ADD CONSTRAINT contactpk PRIMARY KEY (id);


--
-- TOC entry 2069 (class 2606 OID 49278)
-- Name: faqcategory_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.faqcategory
    ADD CONSTRAINT faqcategory_pkey PRIMARY KEY (id);


--
-- TOC entry 2049 (class 2606 OID 33181)
-- Name: postpk; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.post
    ADD CONSTRAINT postpk PRIMARY KEY (id);


--
-- TOC entry 2059 (class 2606 OID 33276)
-- Name: postreport_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.postreport
    ADD CONSTRAINT postreport_pkey PRIMARY KEY (postid, reporterid);


--
-- TOC entry 2071 (class 2606 OID 49289)
-- Name: postreportpk; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.faqentry
    ADD CONSTRAINT postreportpk PRIMARY KEY (id);


--
-- TOC entry 2057 (class 2606 OID 33257)
-- Name: postvote_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.postvote
    ADD CONSTRAINT postvote_pkey PRIMARY KEY (postid, posterid);


--
-- TOC entry 2051 (class 2606 OID 33200)
-- Name: questionpk; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.question
    ADD CONSTRAINT questionpk PRIMARY KEY (postid);


--
-- TOC entry 2039 (class 2606 OID 33106)
-- Name: subject_name_key; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.subject
    ADD CONSTRAINT subject_name_key UNIQUE (name);


--
-- TOC entry 2041 (class 2606 OID 33104)
-- Name: subjectpk; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.subject
    ADD CONSTRAINT subjectpk PRIMARY KEY (subjectid);


--
-- TOC entry 2045 (class 2606 OID 33164)
-- Name: tag_name_key; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tag
    ADD CONSTRAINT tag_name_key UNIQUE (name);


--
-- TOC entry 2047 (class 2606 OID 33162)
-- Name: tagpk; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tag
    ADD CONSTRAINT tagpk PRIMARY KEY (id);


--
-- TOC entry 2055 (class 2606 OID 33238)
-- Name: tagquestion_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tagquestion
    ADD CONSTRAINT tagquestion_pkey PRIMARY KEY (question_id, tag_id);


--
-- TOC entry 2063 (class 2606 OID 33311)
-- Name: teammemberpk; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.teammember
    ADD CONSTRAINT teammemberpk PRIMARY KEY (id);


--
-- TOC entry 2061 (class 2606 OID 33298)
-- Name: teampk; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.team
    ADD CONSTRAINT teampk PRIMARY KEY (id);


--
-- TOC entry 2065 (class 2606 OID 33322)
-- Name: teamtoteammember_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.teamtoteammember
    ADD CONSTRAINT teamtoteammember_pkey PRIMARY KEY (teamid, teammemberid);


--
-- TOC entry 2037 (class 2606 OID 33089)
-- Name: userpk; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.users
    ADD CONSTRAINT userpk PRIMARY KEY (id);


--
-- TOC entry 2099 (class 2620 OID 49217)
-- Name: update_user_points_on_delete; Type: TRIGGER; Schema: public; Owner: postgres
--

CREATE TRIGGER update_user_points_on_delete BEFORE DELETE ON public.postvote FOR EACH ROW EXECUTE PROCEDURE public.update_user_points_on_delete();


--
-- TOC entry 2100 (class 2620 OID 49219)
-- Name: update_user_points_on_insert; Type: TRIGGER; Schema: public; Owner: postgres
--

CREATE TRIGGER update_user_points_on_insert AFTER INSERT ON public.postvote FOR EACH ROW EXECUTE PROCEDURE public.update_user_points_on_insert();


--
-- TOC entry 2101 (class 2620 OID 49221)
-- Name: update_user_points_on_update; Type: TRIGGER; Schema: public; Owner: postgres
--

CREATE TRIGGER update_user_points_on_update AFTER UPDATE ON public.postvote FOR EACH ROW EXECUTE PROCEDURE public.update_user_points_on_update();


--
-- TOC entry 2075 (class 2606 OID 33338)
-- Name: adminidfk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.baninfo
    ADD CONSTRAINT adminidfk FOREIGN KEY (adminid) REFERENCES public.users(id) ON UPDATE CASCADE;


--
-- TOC entry 2080 (class 2606 OID 33218)
-- Name: answer_postid_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.answer
    ADD CONSTRAINT answer_postid_fkey FOREIGN KEY (postid) REFERENCES public.post(id);


--
-- TOC entry 2081 (class 2606 OID 33223)
-- Name: answer_questionid_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.answer
    ADD CONSTRAINT answer_questionid_fkey FOREIGN KEY (questionid) REFERENCES public.question(postid);


--
-- TOC entry 2073 (class 2606 OID 33147)
-- Name: baninfo_adminid_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.baninfo
    ADD CONSTRAINT baninfo_adminid_fkey FOREIGN KEY (adminid) REFERENCES public.users(id);


--
-- TOC entry 2072 (class 2606 OID 33142)
-- Name: baninfo_userid_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.baninfo
    ADD CONSTRAINT baninfo_userid_fkey FOREIGN KEY (userid) REFERENCES public.users(id);


--
-- TOC entry 2097 (class 2606 OID 49256)
-- Name: contact_subjectid_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.contact
    ADD CONSTRAINT contact_subjectid_fkey FOREIGN KEY (subjectid) REFERENCES public.subject(subjectid);


--
-- TOC entry 2096 (class 2606 OID 49251)
-- Name: contact_userid_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.contact
    ADD CONSTRAINT contact_userid_fkey FOREIGN KEY (userid) REFERENCES public.users(id);


--
-- TOC entry 2098 (class 2606 OID 49290)
-- Name: faqentry_category_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.faqentry
    ADD CONSTRAINT faqentry_category_fkey FOREIGN KEY (category) REFERENCES public.faqcategory(id);


--
-- TOC entry 2076 (class 2606 OID 33182)
-- Name: post_posterid_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.post
    ADD CONSTRAINT post_posterid_fkey FOREIGN KEY (posterid) REFERENCES public.users(id);


--
-- TOC entry 2077 (class 2606 OID 33343)
-- Name: postidfk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.post
    ADD CONSTRAINT postidfk FOREIGN KEY (posterid) REFERENCES public.users(id) ON UPDATE CASCADE;


--
-- TOC entry 2082 (class 2606 OID 33348)
-- Name: postidfk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.answer
    ADD CONSTRAINT postidfk FOREIGN KEY (postid) REFERENCES public.post(id) ON UPDATE CASCADE;


--
-- TOC entry 2079 (class 2606 OID 33358)
-- Name: postidfk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.question
    ADD CONSTRAINT postidfk FOREIGN KEY (postid) REFERENCES public.post(id) ON UPDATE CASCADE;


--
-- TOC entry 2090 (class 2606 OID 33373)
-- Name: postidfk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.postvote
    ADD CONSTRAINT postidfk FOREIGN KEY (postid) REFERENCES public.post(id) ON UPDATE CASCADE;


--
-- TOC entry 2092 (class 2606 OID 33383)
-- Name: postreport_post_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.postreport
    ADD CONSTRAINT postreport_post_fk FOREIGN KEY (postid) REFERENCES public.post(id) ON UPDATE CASCADE;


--
-- TOC entry 2091 (class 2606 OID 33378)
-- Name: postreport_user_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.postvote
    ADD CONSTRAINT postreport_user_fk FOREIGN KEY (posterid) REFERENCES public.users(id) ON UPDATE CASCADE;


--
-- TOC entry 2093 (class 2606 OID 33388)
-- Name: postreport_user_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.postreport
    ADD CONSTRAINT postreport_user_fk FOREIGN KEY (reporterid) REFERENCES public.users(id) ON UPDATE CASCADE;


--
-- TOC entry 2089 (class 2606 OID 33263)
-- Name: postvote_posterid_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.postvote
    ADD CONSTRAINT postvote_posterid_fkey FOREIGN KEY (posterid) REFERENCES public.users(id);


--
-- TOC entry 2088 (class 2606 OID 33258)
-- Name: postvote_postid_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.postvote
    ADD CONSTRAINT postvote_postid_fkey FOREIGN KEY (postid) REFERENCES public.post(id);


--
-- TOC entry 2086 (class 2606 OID 33363)
-- Name: question_idfk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tagquestion
    ADD CONSTRAINT question_idfk FOREIGN KEY (question_id) REFERENCES public.question(postid) ON UPDATE CASCADE;


--
-- TOC entry 2078 (class 2606 OID 33201)
-- Name: question_postid_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.question
    ADD CONSTRAINT question_postid_fkey FOREIGN KEY (postid) REFERENCES public.post(id);


--
-- TOC entry 2083 (class 2606 OID 33353)
-- Name: questionidfk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.answer
    ADD CONSTRAINT questionidfk FOREIGN KEY (questionid) REFERENCES public.question(postid) ON UPDATE CASCADE;


--
-- TOC entry 2087 (class 2606 OID 33368)
-- Name: tag_idfk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tagquestion
    ADD CONSTRAINT tag_idfk FOREIGN KEY (tag_id) REFERENCES public.tag(id) ON UPDATE CASCADE;


--
-- TOC entry 2084 (class 2606 OID 33239)
-- Name: tagquestion_question_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tagquestion
    ADD CONSTRAINT tagquestion_question_id_fkey FOREIGN KEY (question_id) REFERENCES public.question(postid);


--
-- TOC entry 2085 (class 2606 OID 33244)
-- Name: tagquestion_tag_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tagquestion
    ADD CONSTRAINT tagquestion_tag_id_fkey FOREIGN KEY (tag_id) REFERENCES public.tag(id);


--
-- TOC entry 2094 (class 2606 OID 33393)
-- Name: teamtoteamember_teamid_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.teamtoteammember
    ADD CONSTRAINT teamtoteamember_teamid_fk FOREIGN KEY (teamid) REFERENCES public.team(id) ON UPDATE CASCADE;


--
-- TOC entry 2095 (class 2606 OID 33398)
-- Name: teamtoteamember_teammemberid_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.teamtoteammember
    ADD CONSTRAINT teamtoteamember_teammemberid_fk FOREIGN KEY (teammemberid) REFERENCES public.teammember(id) ON UPDATE CASCADE;


--
-- TOC entry 2074 (class 2606 OID 33333)
-- Name: useridfk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.baninfo
    ADD CONSTRAINT useridfk FOREIGN KEY (userid) REFERENCES public.users(id) ON UPDATE CASCADE;


--
-- TOC entry 2251 (class 0 OID 0)
-- Dependencies: 6
-- Name: SCHEMA public; Type: ACL; Schema: -; Owner: postgres
--

REVOKE ALL ON SCHEMA public FROM PUBLIC;
REVOKE ALL ON SCHEMA public FROM postgres;
GRANT ALL ON SCHEMA public TO postgres;
GRANT ALL ON SCHEMA public TO PUBLIC;


-- Completed on 2018-05-22 16:11:14 WEST

--
-- PostgreSQL database dump complete
--

