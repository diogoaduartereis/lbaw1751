DROP TABLE IF EXISTS "User";
CREATE TABLE "User" (
    id              SERIAL CONSTRAINT userPK PRIMARY KEY,
    username        TEXT NOT NULL UNIQUE,
    type            TEXT NOT NULL DEFAULT 'REGULAR',
    pass_token      TEXT NOT NULL,
    auth_type       INTEGER NOT NULL,
    CHECK           (auth_type = 0 OR auth_type = 1),
    email           TEXT NOT NULL UNIQUE,
    state           TEXT NOT NULL DEFAULT 'ACTIVE',
    description     TEXT,
    img_path        TEXT NOT NULL DEFAULT '0.png',
    points          INTEGER NOT NULL DEFAULT 0
);

DROP TABLE IF EXISTS Subject;
CREATE TABLE Subject(
    subjectID       SERIAL CONSTRAINT  subjectPK PRIMARY KEY,
    name            TEXT NOT NULL UNIQUE
);

DROP TABLE IF EXISTS Contact;
CREATE TABLE Contact(
    id              SERIAL CONSTRAINT contactPK PRIMARY KEY,
    message         TEXT NOT NULL,
    "date"          TIMESTAMP WITH TIME zone DEFAULT now() NOT NULL,
    userID          INTEGER NOT NULL REFERENCES "User",
    subjectID       INTEGER NOT NULL REFERENCES Subject
);

DROP TABLE IF EXISTS BanInfo;
CREATE TABLE BanInfo(
    id              SERIAL CONSTRAINT banPK PRIMARY KEY,
    duration        BIGINT,
    description     TEXT NOT NULL,
    isPermanent     BOOLEAN NOT NULL,
    initDate        TIMESTAMP WITH TIME zone DEFAULT now(),
    endDate         TIMESTAMP WITH TIME zone,
    CHECK           (((endDate IS NOT NULL AND endDate > now()) OR isPermanent IS TRUE)),
    userID          INTEGER NOT NULL REFERENCES "User",
    adminID         INTEGER NOT NULL REFERENCES "User"
);

DROP TABLE IF EXISTS Tag;
CREATE TABLE Tag(
    id           SERIAL CONSTRAINT tagPK PRIMARY KEY,
    name         TEXT NOT NULL UNIQUE
);

DROP TABLE IF EXISTS Post;
CREATE TABLE Post (
	id          SERIAL CONSTRAINT postpk PRIMARY KEY,
	posterID    SERIAL REFERENCES "User",
	content     text NOT NULL,
	"date"      TIMESTAMP WITH TIME zone DEFAULT now() NOT NULL,
	isVisible   boolean NOT NULL DEFAULT TRUE,
	points      INTEGER DEFAULT 0 NOT NULL
);

DROP TABLE IF EXISTS Answer;
CREATE TABLE Answer (
	postID      SERIAL REFERENCES Post CONSTRAINT answerpk PRIMARY KEY,
	questionID  SERIAL REFERENCES Question, 
	isCorrect   boolean NOT NULL DEFAULT FALSE
);

DROP TABLE IF EXISTS Question;
CREATE TABLE Question  (
	postID      SERIAL REFERENCES Post CONSTRAINT questionpk PRIMARY KEY,
	isClosed    boolean NOT NULL DEFAULT FALSE,
	nViews      BIGINT NOT NULL DEFAULT 0,
	CHECK (nViews > 0),
	tittle text NOT NULL
);

DROP TABLE IF EXISTS TagQuestion;
CREATE TABLE TagQuestion(
    question_id  SERIAL NOT NULL REFERENCES Question,
    tag_id       SERIAL NOT NULL REFERENCES Tag,
    PRIMARY KEY(question_id, tag_id)
);

DROP TABLE IF EXISTS PostVote;
CREATE TABLE PostVote (
	postID      SERIAL REFERENCES Post NOT NULL,
	posterID    BIGINT REFERENCES "User" NOT NULL,
	value       INTEGER NOT NULL,
	CHECK (value = 1 OR value = -1),
	PRIMARY KEY(postID, posterID)
);

DROP TABLE IF EXISTS PostReport;
CREATE TABLE PostReport (
	postID      SERIAL NOT NULL,
	reporterID  BIGINT NOT NULL,
	"date"      TIMESTAMP WITH TIME zone DEFAULT now() NOT NULL,
	PRIMARY KEY(postID, reporterID)
);

DROP TABLE IF EXISTS FaqEntry;
CREATE TABLE FaqEntry (
	id          SERIAL CONSTRAINT postreportpk PRIMARY KEY,
	question    text NOT NULL,
	answer      text NOT NULL
);

DROP TABLE IF EXISTS Team;
CREATE TABLE Team (
  id          SERIAL CONSTRAINT teamPk PRIMARY KEY,
  name        TEXT NOT NULL
);

DROP TABLE IF EXISTS TeamMember;
CREATE TABLE TeamMember (
  id          SERIAL CONSTRAINT teamMemberPK PRIMARY KEY,
  name        TEXT NOT NULL,
  email       TEXT NOT NULL,
  title       TEXT NOT NULL,
  joinDate    TIMESTAMP WITH TIME ZONE DEFAULT now() NOT NULL,
  img_path    TEXT NOT NULL DEFAULT '0.png'
);

DROP TABLE IF EXISTS TeamToTeamMember;
CREATE TABLE TeamToTeamMember (
  teamId        SERIAL,
  teamMemberID  SERIAL,
  PRIMARY KEY (teamId,teamMemberID)
);


ALTER TABLE Contact
    ADD CONSTRAINT userID_fk FOREIGN KEY (userID) REFERENCES "User"(id) ON UPDATE CASCADE;

ALTER TABLE Contact
    ADD CONSTRAINT subjectIDfk FOREIGN KEY (subjectID) REFERENCES Subject(subjectID) ON UPDATE CASCADE;

ALTER TABLE BanInfo
    ADD CONSTRAINT userIDfk FOREIGN KEY (userID) REFERENCES "User"(id) ON UPDATE CASCADE;

ALTER TABLE BanInfo
    ADD CONSTRAINT adminIDfk FOREIGN KEY (adminID) REFERENCES "User"(id) ON UPDATE CASCADE;

ALTER TABLE Post
    ADD CONSTRAINT postIdFk FOREIGN KEY (posterID) REFERENCES "User"(id) ON UPDATE CASCADE;

ALTER TABLE Answer
    ADD CONSTRAINT postIDfk FOREIGN KEY (postID) REFERENCES Post(id) ON UPDATE CASCADE;

ALTER TABLE Answer
    ADD CONSTRAINT questionIDfk FOREIGN KEY (questionID) REFERENCES Question(postID) ON UPDATE CASCADE;

ALTER TABLE Question
    ADD CONSTRAINT postIDfk FOREIGN KEY (postID) REFERENCES Post(id) ON UPDATE CASCADE;

ALTER TABLE TagQuestion
    ADD CONSTRAINT question_idFK FOREIGN KEY (question_id) REFERENCES Question(postID) ON UPDATE CASCADE;

ALTER TABLE TagQuestion
    ADD CONSTRAINT tag_idFK FOREIGN KEY (tag_id) REFERENCES Tag(id) ON UPDATE CASCADE;

ALTER TABLE PostVote
    ADD CONSTRAINT postIdFk FOREIGN KEY (postID) REFERENCES Post(id) ON UPDATE CASCADE;
	
ALTER TABLE ONLY PostVote
	ADD CONSTRAINT postreport_user_fk FOREIGN KEY (posterID) REFERENCES "User"(id) ON UPDATE CASCADE;
	
ALTER TABLE ONLY PostReport
	ADD CONSTRAINT postreport_post_fk FOREIGN KEY (postID) REFERENCES Post(id) ON UPDATE CASCADE;

ALTER TABLE ONLY PostReport
	ADD CONSTRAINT postreport_user_fk FOREIGN KEY (reporterId) REFERENCES "User"(id) ON UPDATE CASCADE;
	
ALTER TABLE ONLY TeamToTeamMember
	ADD CONSTRAINT teamtoteamember_teamid_fk FOREIGN KEY (teamID) REFERENCES Team(id) ON UPDATE CASCADE;

ALTER TABLE ONLY TeamToTeamMember
	ADD CONSTRAINT teamtoteamember_teammemberid_fk FOREIGN KEY (teamMemberID) REFERENCES TeamMember(id) ON UPDATE CASCADE;