
CREATE FUNCTION update_user_points_on_delete() RETURNS trigger
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

CREATE FUNCTION update_user_points_on_insert() RETURNS trigger
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

CREATE FUNCTION update_user_points_on_update() RETURNS trigger
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

CREATE TABLE users (
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

CREATE TABLE answer (
    postid integer NOT NULL,
    questionid integer NOT NULL,
    iscorrect boolean DEFAULT false NOT NULL
);

CREATE TABLE baninfo (
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

CREATE TABLE contact (
    id integer NOT NULL,
    message text NOT NULL,
    date timestamp with time zone DEFAULT now() NOT NULL,
    userid integer,
    subjectid integer NOT NULL,
    processed boolean DEFAULT false NOT NULL
);

CREATE TABLE faqcategory (
    id bigint NOT NULL,
    name text NOT NULL
);

CREATE TABLE faqentry (
    id bigint NOT NULL,
    question text NOT NULL,
    answer text NOT NULL,
    category bigint NOT NULL
);

CREATE TABLE migrations (
    id integer NOT NULL,
    migration character varying(255) NOT NULL,
    batch integer NOT NULL
);

CREATE TABLE password_resets (
    id integer NOT NULL,
    email character varying(255) NOT NULL,
    token character varying(255) NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);

CREATE TABLE post (
    id integer NOT NULL,
    posterid integer NOT NULL,
    content text NOT NULL,
    date timestamp with time zone DEFAULT now() NOT NULL,
    isvisible boolean DEFAULT true NOT NULL,
    points integer DEFAULT 0 NOT NULL
);

CREATE TABLE postreport (
    postid integer NOT NULL,
    reporterid bigint NOT NULL,
    date timestamp with time zone DEFAULT now() NOT NULL,
    reason text NOT NULL
);

CREATE TABLE postvote (
    postid integer NOT NULL,
    posterid bigint NOT NULL,
    value integer NOT NULL,
    CONSTRAINT postvote_value_check CHECK (((value = 1) OR (value = (-1))))
);

CREATE TABLE question (
    postid integer NOT NULL,
    isclosed boolean DEFAULT false NOT NULL,
    nviews bigint DEFAULT 0 NOT NULL,
    title text NOT NULL,
    CONSTRAINT question_nviews_check CHECK ((nviews >= 0))
);

CREATE TABLE subject (
    subjectid integer NOT NULL,
    name text NOT NULL
);

CREATE TABLE tag (
    id integer NOT NULL,
    name text NOT NULL
);

CREATE TABLE tagquestion (
    question_id integer NOT NULL,
    tag_id integer NOT NULL
);

CREATE TABLE team (
    id integer NOT NULL,
    name text NOT NULL
);

CREATE TABLE teammember (
    id integer NOT NULL,
    name text NOT NULL,
    email text NOT NULL,
    title text NOT NULL,
    joindate timestamp with time zone DEFAULT now() NOT NULL,
    img_path text DEFAULT '0.png'::text NOT NULL
);

CREATE TABLE teamtoteammember (
    teamid integer NOT NULL,
    teammemberid integer NOT NULL
);

ALTER TABLE ONLY users
    ADD CONSTRAINT "User_email_key" UNIQUE (email);

ALTER TABLE ONLY users
    ADD CONSTRAINT "User_username_key" UNIQUE (username);

ALTER TABLE ONLY answer
    ADD CONSTRAINT answerpk PRIMARY KEY (postid);

ALTER TABLE ONLY baninfo
    ADD CONSTRAINT banpk PRIMARY KEY (id);

ALTER TABLE ONLY contact
    ADD CONSTRAINT contactpk PRIMARY KEY (id);

ALTER TABLE ONLY faqcategory
    ADD CONSTRAINT faqcategory_pkey PRIMARY KEY (id);

ALTER TABLE ONLY migrations
    ADD CONSTRAINT migrations_pkey PRIMARY KEY (id);

ALTER TABLE ONLY password_resets
    ADD CONSTRAINT password_resets_pkey PRIMARY KEY (id);

ALTER TABLE ONLY post
    ADD CONSTRAINT postpk PRIMARY KEY (id);

ALTER TABLE ONLY postreport
    ADD CONSTRAINT postreport_pkey PRIMARY KEY (postid, reporterid);

ALTER TABLE ONLY faqentry
    ADD CONSTRAINT postreportpk PRIMARY KEY (id);

ALTER TABLE ONLY postvote
    ADD CONSTRAINT postvote_pkey PRIMARY KEY (postid, posterid);

ALTER TABLE ONLY question
    ADD CONSTRAINT questionpk PRIMARY KEY (postid);

ALTER TABLE ONLY subject
    ADD CONSTRAINT subject_name_key UNIQUE (name);

ALTER TABLE ONLY subject
    ADD CONSTRAINT subjectpk PRIMARY KEY (subjectid);

ALTER TABLE ONLY tag
    ADD CONSTRAINT tag_name_key UNIQUE (name);

ALTER TABLE ONLY tag
    ADD CONSTRAINT tagpk PRIMARY KEY (id);

ALTER TABLE ONLY tagquestion
    ADD CONSTRAINT tagquestion_pkey PRIMARY KEY (question_id, tag_id);

ALTER TABLE ONLY teammember
    ADD CONSTRAINT teammemberpk PRIMARY KEY (id);

ALTER TABLE ONLY team
    ADD CONSTRAINT teampk PRIMARY KEY (id);

ALTER TABLE ONLY teamtoteammember
    ADD CONSTRAINT teamtoteammember_pkey PRIMARY KEY (teamid, teammemberid);

ALTER TABLE ONLY users
    ADD CONSTRAINT userpk PRIMARY KEY (id);

CREATE INDEX password_resets_email_index ON password_resets USING btree (email);

CREATE INDEX password_resets_token_index ON password_resets USING btree (token);

CREATE TRIGGER update_user_points_on_delete BEFORE DELETE ON postvote FOR EACH ROW EXECUTE PROCEDURE public.update_user_points_on_delete();

CREATE TRIGGER update_user_points_on_insert AFTER INSERT ON postvote FOR EACH ROW EXECUTE PROCEDURE public.update_user_points_on_insert();

CREATE TRIGGER update_user_points_on_update AFTER UPDATE ON public.postvote FOR EACH ROW EXECUTE PROCEDURE public.update_user_points_on_update();

ALTER TABLE ONLY baninfo
    ADD CONSTRAINT adminidfk FOREIGN KEY (adminid) REFERENCES users(id) ON UPDATE CASCADE;

ALTER TABLE ONLY answer
    ADD CONSTRAINT answer_postid_fkey FOREIGN KEY (postid) REFERENCES post(id);

ALTER TABLE ONLY answer
    ADD CONSTRAINT answer_questionid_fkey FOREIGN KEY (questionid) REFERENCES public.question(postid);

ALTER TABLE ONLY baninfo
    ADD CONSTRAINT baninfo_adminid_fkey FOREIGN KEY (adminid) REFERENCES users(id);

ALTER TABLE ONLY baninfo
    ADD CONSTRAINT baninfo_userid_fkey FOREIGN KEY (userid) REFERENCES users(id);

ALTER TABLE ONLY contact
    ADD CONSTRAINT contact_subjectid_fkey FOREIGN KEY (subjectid) REFERENCES subject(subjectid);

ALTER TABLE ONLY contact
    ADD CONSTRAINT contact_userid_fkey FOREIGN KEY (userid) REFERENCES users(id);

ALTER TABLE ONLY faqentry
    ADD CONSTRAINT faqentry_category_fkey FOREIGN KEY (category) REFERENCES faqcategory(id);

ALTER TABLE ONLY post
    ADD CONSTRAINT post_posterid_fkey FOREIGN KEY (posterid) REFERENCES users(id);

ALTER TABLE ONLY post
    ADD CONSTRAINT postidfk FOREIGN KEY (posterid) REFERENCES users(id) ON UPDATE CASCADE;

ALTER TABLE ONLY answer
    ADD CONSTRAINT postidfk FOREIGN KEY (postid) REFERENCES post(id) ON UPDATE CASCADE;

ALTER TABLE ONLY question
    ADD CONSTRAINT postidfk FOREIGN KEY (postid) REFERENCES post(id) ON UPDATE CASCADE;

ALTER TABLE ONLY postvote
    ADD CONSTRAINT postidfk FOREIGN KEY (postid) REFERENCES post(id) ON UPDATE CASCADE;

ALTER TABLE ONLY postreport
    ADD CONSTRAINT postreport_post_fk FOREIGN KEY (postid) REFERENCES post(id) ON UPDATE CASCADE;

ALTER TABLE ONLY postvote
    ADD CONSTRAINT postreport_user_fk FOREIGN KEY (posterid) REFERENCES users(id) ON UPDATE CASCADE;

ALTER TABLE ONLY postreport
    ADD CONSTRAINT postreport_user_fk FOREIGN KEY (reporterid) REFERENCES users(id) ON UPDATE CASCADE;

ALTER TABLE ONLY postvote
    ADD CONSTRAINT postvote_posterid_fkey FOREIGN KEY (posterid) REFERENCES users(id);
	
ALTER TABLE ONLY postvote
    ADD CONSTRAINT postvote_postid_fkey FOREIGN KEY (postid) REFERENCES post(id);

ALTER TABLE ONLY tagquestion
    ADD CONSTRAINT question_idfk FOREIGN KEY (question_id) REFERENCES question(postid) ON UPDATE CASCADE;

ALTER TABLE ONLY question
    ADD CONSTRAINT question_postid_fkey FOREIGN KEY (postid) REFERENCES post(id);

ALTER TABLE ONLY answer
    ADD CONSTRAINT questionidfk FOREIGN KEY (questionid) REFERENCES question(postid) ON UPDATE CASCADE;

ALTER TABLE ONLY tagquestion
    ADD CONSTRAINT tag_idfk FOREIGN KEY (tag_id) REFERENCES tag(id) ON UPDATE CASCADE;

ALTER TABLE ONLY tagquestion
    ADD CONSTRAINT tagquestion_question_id_fkey FOREIGN KEY (question_id) REFERENCES question(postid);

ALTER TABLE ONLY tagquestion
    ADD CONSTRAINT tagquestion_tag_id_fkey FOREIGN KEY (tag_id) REFERENCES tag(id);

ALTER TABLE ONLY teamtoteammember
    ADD CONSTRAINT teamtoteamember_teamid_fk FOREIGN KEY (teamid) REFERENCES team(id) ON UPDATE CASCADE;

ALTER TABLE ONLY teamtoteammember
    ADD CONSTRAINT teamtoteamember_teammemberid_fk FOREIGN KEY (teammemberid) REFERENCES public.teammember(id) ON UPDATE CASCADE;

ALTER TABLE ONLY baninfo
    ADD CONSTRAINT useridfk FOREIGN KEY (userid) REFERENCES users(id) ON UPDATE CASCADE;