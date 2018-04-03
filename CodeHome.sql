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




CREATE FUNCTION post_answer() RETURNS TRIGGER AS
$BODY$
BEGIN
  IF EXISTS (SELECT questionID, postID, isClosed FROM Question WHERE NEW.questionID = "Question".postID AND "Question".isClosed = TRUE) THEN
    RAISE EXCEPTION 'A closed question cannot be answered to and it’s answers cannot be edited.';
  END IF;
  RETURN NEW;
END
$BODY$
LANGUAGE plpgsql;
 
CREATE TRIGGER post_answer
  BEFORE INSERT OR UPDATE ON "Answer"
  EXECUTE PROCEDURE loan_item(); 



CREATE FUNCTION make_post() RETURNS TRIGGER AS
$BODY$
BEGIN
  IF EXISTS (SELECT state FROM User WHERE NEW.posterID = "User".ID AND "User".state <> 'ACTIVE') THEN
    RAISE EXCEPTION 'A banned user cannot post neither questions nor answers.';
  END IF;
  RETURN NEW;
END
$BODY$
LANGUAGE plpgsql;
 
CREATE TRIGGER make_post
  BEFORE INSERT OR UPDATE ON "Post"
  EXECUTE PROCEDURE make_post(); 



CREATE FUNCTION update_user_points() RETURNS TRIGGER AS
$BODY$
BEGIN
  IF EXISTS (SELECT "User".id AS usr_id1 FROM User WHERE NEW.posterID = usr_id1) THEN
  UPDATE "User" AS usr_id2
  SET points = points + NEW.value,
  WHERE usr_id1 = usr_id2;
  END IF;
  RETURN NEW;
END
$BODY$
LANGUAGE plpgsql;
 
CREATE TRIGGER update_user_points
  AFTER INSERT OR UPDATE ON "PostVote"
  EXECUTE PROCEDURE update_user_points(); 



CREATE FUNCTION admin_check_procedure() RETURNS TRIGGER AS
$BODY$
BEGIN
  IF (not((SELECT type FROM User WHERE userID = NEW.adminID)='admin')) THEN
      RAISE EXCEPTION 'User must be admin to ban';
  END IF;
  RETURN NEW;
END
$BODY$
LANGUAGE plpgsql;

CREATE TRIGGER adminCheckTrigger
    BEFORE INSERT OR UPDATE on BanInfo
    EXECUTE PROCEDURE adminCheckProcedure();




INSERT INTO "User" (id,username,type,pass_token,auth_type,email,state,description,img_path,points) VALUES (1,'Orli Dominguez','REGULAR','EUB20LRK6WF','1','et@vulputatelacusCras.com','INACTIVE','et ipsum cursus vestibulum. Mauris magna. Duis dignissim tempor arcu. Vestibulum ut',1.png,787);
INSERT INTO "User" (id,username,type,pass_token,auth_type,email,state,description,img_path,points) VALUES (2,'Jackson Washington','REGULAR','PPT71JNO2ZS','1','egestas@Cumsociis.net','ACTIVE','euismod urna. Nullam lobortis quam a felis ullamcorper',2.png,329);
INSERT INTO "User" (id,username,type,pass_token,auth_type,email,state,description,img_path,points) VALUES (3,'Piper E. Dale','ADMIN','STA70JVU4OJ','0','ante.iaculis.nec@enimCurabiturmassa.net','ACTIVE','mauris erat eget ipsum. Suspendisse sagittis. Nullam vitae diam. Proin dolor.',3.png,281);
INSERT INTO "User" (id,username,type,pass_token,auth_type,email,state,description,img_path,points) VALUES (4,'Ruth A. Rodgers','REGULAR','QRC88GVQ5FC','0','convallis@loremDonec.org','BANNED','enim diam vel arcu. Curabitur ut odio vel est tempor bibendum. Donec felis',4.png,118);
INSERT INTO "User" (id,username,type,pass_token,auth_type,email,state,description,img_path,points) VALUES (5,'Chaim Grimes','REGULAR','YUV38DJX4MF','1','sed@arcuVestibulumut.ca','BANNED','mauris, rhoncus id, mollis nec, cursus a,',5.png,897);
INSERT INTO "User" (id,username,type,pass_token,auth_type,email,state,description,img_path,points) VALUES (6,'Acton V. Deleon','REGULAR','GTS53IRN6IW','1','luctus@sit.edu','BANNED','lacinia at, iaculis quis, pede. Praesent eu dui. Cum sociis natoque',6.png,414);
INSERT INTO "User" (id,username,type,pass_token,auth_type,email,state,description,img_path,points) VALUES (7,'Miranda Tran','REGULAR','SCF27ITP4PO','1','magnis.dis.parturient@Fuscealiquetmagna.org','INACTIVE','molestie tortor nibh sit amet orci. Ut sagittis lobortis mauris. Suspendisse',7.png,885);
INSERT INTO "User" (id,username,type,pass_token,auth_type,email,state,description,img_path,points) VALUES (8,'Ciara Mays','REGULAR','IHQ00DSP8WP','1','ipsum@arcuNuncmauris.edu','BANNED','Integer vitae nibh. Donec est mauris, rhoncus id, mollis nec, cursus a, enim. Suspendisse aliquet,',8.png,929);
INSERT INTO "User" (id,username,type,pass_token,auth_type,email,state,description,img_path,points) VALUES (9,'Courtney Pollard','REGULAR','HFQ25QLG9PF','1','a.tortor.Nunc@ligulaeu.ca','INACTIVE','Sed diam lorem, auctor quis, tristique ac, eleifend vitae, erat. Vivamus nisi.',9.png,399);
INSERT INTO "User" (id,username,type,pass_token,auth_type,email,state,description,img_path,points) VALUES (10,'Bryar D. Watts','REGULAR','AOK00QZO8ZA','1','amet@vitaesodalesnisi.org','BANNED','augue malesuada malesuada. Integer id magna et ipsum cursus',10.png,307);
INSERT INTO "User" (id,username,type,pass_token,auth_type,email,state,description,img_path,points) VALUES (11,'Yoko Slater','ADMIN','ACE62ABA0ZP','1','tincidunt@eu.ca','INACTIVE','Duis elementum, dui quis accumsan',11.png,94);
INSERT INTO "User" (id,username,type,pass_token,auth_type,email,state,description,img_path,points) VALUES (12,'Katell J. Coleman','REGULAR','PKQ89WPE1RK','0','lorem.luctus@Aliquamerat.edu','BANNED','Donec tempus, lorem fringilla ornare placerat, orci lacus vestibulum lorem, sit amet ultricies sem magna',12.png,908);
INSERT INTO "User" (id,username,type,pass_token,auth_type,email,state,description,img_path,points) VALUES (13,'Tanner E. Dean','REGULAR','OOU71RVL4GU','0','ligula.eu@eu.ca','ACTIVE','pede sagittis augue, eu tempor erat',13.png,919);
INSERT INTO "User" (id,username,type,pass_token,auth_type,email,state,description,img_path,points) VALUES (14,'Christopher Tanner','REGULAR','JAC15KKO4FB','1','lorem.ipsum.sodales@amet.com','INACTIVE','Integer urna. Vivamus molestie dapibus ligula. Aliquam',14.png,987);
INSERT INTO "User" (id,username,type,pass_token,auth_type,email,state,description,img_path,points) VALUES (15,'Kyra Chapman','REGULAR','WHZ01AZR9VR','0','Maecenas@dictum.com','ACTIVE','dictum ultricies ligula. Nullam enim. Sed nulla ante, iaculis nec, eleifend',15.png,533);
INSERT INTO "User" (id,username,type,pass_token,auth_type,email,state,description,img_path,points) VALUES (16,'Steven Nelson','REGULAR','BIQ73DKL1BJ','0','augue.malesuada.malesuada@nisiMauris.org','ACTIVE','Cras eget nisi dictum augue malesuada malesuada. Integer id magna et ipsum',16.png,206);
INSERT INTO "User" (id,username,type,pass_token,auth_type,email,state,description,img_path,points) VALUES (17,'Maryam Mason','REGULAR','FYU36EDI3QV','0','nunc@nonsollicitudin.ca','INACTIVE','dapibus gravida. Aliquam tincidunt, nunc ac mattis ornare,',17.png,200);
INSERT INTO "User" (id,username,type,pass_token,auth_type,email,state,description,img_path,points) VALUES (18,'Maggy Oneil','REGULAR','JKB52QPJ0GG','1','tristique.pharetra.Quisque@ametdapibusid.com','BANNED','mus. Proin vel arcu eu odio tristique pharetra. Quisque ac libero nec',18.png,281);
INSERT INTO "User" (id,username,type,pass_token,auth_type,email,state,description,img_path,points) VALUES (19,'Bryar Stokes','REGULAR','QLF57BJU1WF','0','arcu@non.org','INACTIVE','Aenean gravida nunc sed pede. Cum sociis natoque penatibus et magnis dis parturient',19.png,216);
INSERT INTO "User" (id,username,type,pass_token,auth_type,email,state,description,img_path,points) VALUES (20,'Jamal I. Mathis','REGULAR','UXS09API3HS','0','adipiscing.non@magna.net','BANNED','ut quam vel sapien imperdiet ornare. In faucibus. Morbi vehicula. Pellentesque tincidunt tempus',20.png,333);
INSERT INTO "User" (id,username,type,pass_token,auth_type,email,state,description,img_path,points) VALUES (21,'Ursula Vazquez','REGULAR','LDB48CTF6AC','1','sociis@ametconsectetuer.edu','INACTIVE','et tristique pellentesque, tellus sem mollis dui, in',21.png,306);
INSERT INTO "User" (id,username,type,pass_token,auth_type,email,state,description,img_path,points) VALUES (22,'Yvette Simmons','REGULAR','KGZ54ZDK4ZY','0','dapibus.quam.quis@inlobortistellus.net','ACTIVE','felis purus ac tellus. Suspendisse sed dolor.',22.png,456);
INSERT INTO "User" (id,username,type,pass_token,auth_type,email,state,description,img_path,points) VALUES (23,'Noelle Reese','REGULAR','MHL66YCM0MB','1','urna.nec.luctus@In.ca','ACTIVE','et magnis dis parturient montes, nascetur ridiculus mus. Donec',23.png,195);
INSERT INTO "User" (id,username,type,pass_token,auth_type,email,state,description,img_path,points) VALUES (24,'Imelda Gill','REGULAR','JRU29IMQ3IL','1','ullamcorper.viverra@justofaucibus.co.uk','INACTIVE','fames ac turpis egestas. Fusce aliquet magna a neque. Nullam ut nisi',24.png,911);
INSERT INTO "User" (id,username,type,pass_token,auth_type,email,state,description,img_path,points) VALUES (25,'Jacqueline Hendrix','REGULAR','ZKV92SER3TA','0','odio.sagittis.semper@Cras.org','INACTIVE','fringilla cursus purus. Nullam scelerisque',25.png,955);


INSERT INTO Subject (subjectId, name) VALUES (1, 'Performance');
INSERT INTO Subject (subjectId, name) VALUES (2, 'Reliability');
INSERT INTO Subject (subjectId, name) VALUES (3, 'Offensive language');
INSERT INTO Subject (subjectId, name) VALUES (4, 'My post have been removed');
INSERT INTO Subject (subjectId, name) VALUES (5, 'Forgot password');


INSERT INTO "Contact" (id,message,date,userID,subjectID) VALUES (1,'non, lobortis quis, pede. Suspendisse dui.','1515296655',20,1);
INSERT INTO "Contact" (id,message,date,userID,subjectID) VALUES (2,'neque venenatis lacus. Etiam bibendum fermentum metus. Aenean sed pede nec','1524050828',39,3);
INSERT INTO "Contact" (id,message,date,userID,subjectID) VALUES (3,'lacus. Quisque imperdiet, erat nonummy ultricies ornare, elit elit fermentum risus,','1514868512',9,2);
INSERT INTO "Contact" (id,message,date,userID,subjectID) VALUES (4,'Nulla aliquet. Proin velit. Sed','1501730948',38,4);
INSERT INTO "Contact" (id,message,date,userID,subjectID) VALUES (5,'ornare placerat, orci lacus vestibulum lorem, sit amet ultricies sem magna nec quam. Curabitur vel lectus. Cum sociis natoque penatibus et magnis','1510164481',17,5);
INSERT INTO "Contact" (id,message,date,userID,subjectID) VALUES (6,'lorem ut aliquam iaculis, lacus pede sagittis augue, eu tempor erat','1507245622',30,5);
INSERT INTO "Contact" (id,message,date,userID,subjectID) VALUES (7,'gravida molestie arcu. Sed eu nibh vulputate','1502567523',23,1);
INSERT INTO "Contact" (id,message,date,userID,subjectID) VALUES (8,'libero et tristique pellentesque, tellus sem mollis dui, in sodales elit erat vitae risus. Duis a mi fringilla','1499608029',28,3);
INSERT INTO "Contact" (id,message,date,userID,subjectID) VALUES (9,'Aliquam erat volutpat. Nulla dignissim. Maecenas ornare egestas ligula.','1536891957',18,5);
INSERT INTO "Contact" (id,message,date,userID,subjectID) VALUES (10,'placerat velit. Quisque varius. Nam porttitor scelerisque neque. Nullam nisl. Maecenas malesuada fringilla est. Mauris eu turpis. Nulla','1529930396',20,3);


INSERT INTO "BanInfo" (id,duration,description,isPermanent,initDate,endDate,userId,adminId) VALUES (1,51190,'gravida mauris ut mi. Duis risus odio, auctor vitae, aliquet nec, imperdiet nec, leo. Morbi neque','true','1529780932','1530460724','17','11');
INSERT INTO "BanInfo" (id,duration,description,isPermanent,initDate,endDate,userId,adminId) VALUES (2,35080,'In at pede. Cras vulputate velit eu sem. Pellentesque ut ipsum ac mi eleifend egestas. Sed pharetra, felis eget varius','false','1529904666','1530609979','8','3');
INSERT INTO "BanInfo" (id,duration,description,isPermanent,initDate,endDate,userId,adminId) VALUES (3,23203,'nunc risus varius orci, in consequat enim diam vel arcu. Curabitur ut','false','1529380198','1530743239','5','11');
INSERT INTO "BanInfo" (id,duration,description,isPermanent,initDate,endDate,userId,adminId) VALUES (4,36054,'Etiam imperdiet dictum magna. Ut tincidunt orci quis lectus. Nullam suscipit, est','true','1530118232','1531170698','2','11');
INSERT INTO "BanInfo" (id,duration,description,isPermanent,initDate,endDate,userId,adminId) VALUES (5,39197,'posuere at, velit. Cras lorem lorem, luctus ut, pellentesque eget, dictum placerat, augue. Sed molestie.','true','1530424985','1531708913','20','11');
INSERT INTO "BanInfo" (id,duration,description,isPermanent,initDate,endDate,userId,adminId) VALUES (6,47880,'ultrices posuere cubilia Curae; Donec tincidunt. Donec vitae erat vel pede blandit','false','1527888967','1531240271','7','3');
INSERT INTO "BanInfo" (id,duration,description,isPermanent,initDate,endDate,userId,adminId) VALUES (7,44694,'odio a purus. Duis elementum, dui quis accumsan convallis, ante lectus convallis est, vitae sodales nisi magna sed','false','1529668142','1531284041','20','11');
INSERT INTO "BanInfo" (id,duration,description,isPermanent,initDate,endDate,userId,adminId) VALUES (8,54219,'vulputate, posuere vulputate, lacus. Cras interdum. Nunc sollicitudin commodo ipsum. Suspendisse non leo.','true','1530157130','1531621584','6','11');
INSERT INTO "BanInfo" (id,duration,description,isPermanent,initDate,endDate,userId,adminId) VALUES (9,50423,'erat. Sed nunc est, mollis non, cursus non, egestas a, dui. Cras pellentesque. Sed dictum. Proin eget odio. Aliquam','true','1530020219','1530811212','1','3');
INSERT INTO "BanInfo" (id,duration,description,isPermanent,initDate,endDate,userId,adminId) VALUES (10,32023,'et, lacinia vitae, sodales at, velit. Pellentesque ultricies dignissim lacus. Aliquam rutrum','true','1528764316','1530608276','1','3');


INSERT INTO Tag (id, name) VALUES (1, 'figds');
INSERT INTO Tag (id, name) VALUES (2, 'finqm');
INSERT INTO Tag (id, name) VALUES (3, 'xztxi');
INSERT INTO Tag (id, name) VALUES (4, 'uglqg');
INSERT INTO Tag (id, name) VALUES (5, 'axkse');
INSERT INTO Tag (id, name) VALUES (6, 'rgxol');
INSERT INTO Tag (id, name) VALUES (7, 'tsyie');
INSERT INTO Tag (id, name) VALUES (8, 'jxayz');
INSERT INTO Tag (id, name) VALUES (9, 'fuzki');
INSERT INTO Tag (id, name) VALUES (10, 'fdvwk');


INSERT INTO "Post" (id,posterId,content,date,isVisible,points) VALUES (1,'4','Donec dignissim magna a tortor. Nunc commodo auctor velit. Aliquam nisl. Nulla eu neque pellentesque massa lobortis ultrices. Vivamus rhoncus. Donec est. Nunc ullamcorper,','1529689764','true',1);
INSERT INTO "Post" (id,posterId,content,date,isVisible,points) VALUES (2,'4','at arcu. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Donec tincidunt. Donec vitae erat','1514170271','false',3);
INSERT INTO "Post" (id,posterId,content,date,isVisible,points) VALUES (3,'8','sem egestas blandit. Nam nulla magna, malesuada vel, convallis in, cursus et, eros. Proin ultrices.','1552053535','false',1);
INSERT INTO "Post" (id,posterId,content,date,isVisible,points) VALUES (4,'7','Suspendisse dui. Fusce diam nunc, ullamcorper eu, euismod ac, fermentum vel, mauris. Integer sem elit, pharetra ut, pharetra sed, hendrerit a,','1506114724','true',1);
INSERT INTO "Post" (id,posterId,content,date,isVisible,points) VALUES (5,'16','id magna et ipsum cursus vestibulum. Mauris magna. Duis dignissim tempor arcu. Vestibulum ut eros non enim commodo','1541433984','true',1);
INSERT INTO "Post" (id,posterId,content,date,isVisible,points) VALUES (6,'13','risus. Morbi metus. Vivamus euismod urna. Nullam lobortis quam a felis ullamcorper viverra. Maecenas iaculis aliquet diam.','1506570766','false',1);
INSERT INTO "Post" (id,posterId,content,date,isVisible,points) VALUES (7,'3','a, enim. Suspendisse aliquet, sem ut cursus luctus, ipsum leo elementum sem, vitae aliquam eros turpis non enim. Mauris quis turpis','1546696133','false',1);
INSERT INTO "Post" (id,posterId,content,date,isVisible,points) VALUES (8,'18','justo. Proin non massa non ante bibendum ullamcorper. Duis cursus, diam at pretium aliquet, metus urna convallis erat,','1514623898','false',1);
INSERT INTO "Post" (id,posterId,content,date,isVisible,points) VALUES (9,'11','dolor dolor, tempus non, lacinia at, iaculis quis, pede. Praesent eu dui. Cum sociis natoque penatibus et magnis dis parturient','1542089449','false',3);
INSERT INTO "Post" (id,posterId,content,date,isVisible,points) VALUES (10,'12','dictum eu, eleifend nec, malesuada ut, sem. Nulla interdum. Curabitur dictum. Phasellus in felis. Nulla tempor augue ac ipsum. Phasellus','1527305293','true',2);
INSERT INTO "Post" (id,posterId,content,date,isVisible,points) VALUES (11,'10','Duis risus odio, auctor vitae, aliquet nec, imperdiet nec, leo. Morbi neque tellus, imperdiet non, vestibulum nec, euismod in, dolor. Fusce feugiat. Lorem','1506453612','false',2);
INSERT INTO "Post" (id,posterId,content,date,isVisible,points) VALUES (12,'20','auctor non, feugiat nec, diam. Duis mi enim, condimentum eget, volutpat ornare, facilisis eget, ipsum. Donec sollicitudin adipiscing ligula. Aenean','1513090527','false',2);
INSERT INTO "Post" (id,posterId,content,date,isVisible,points) VALUES (13,'5','auctor velit. Aliquam nisl. Nulla eu neque pellentesque massa lobortis ultrices. Vivamus rhoncus. Donec est. Nunc ullamcorper,','1533970749','true',3);
INSERT INTO "Post" (id,posterId,content,date,isVisible,points) VALUES (14,'19','Curae; Donec tincidunt. Donec vitae erat vel pede blandit congue. In scelerisque scelerisque dui. Suspendisse ac metus vitae velit egestas lacinia.','1533053701','false',1);
INSERT INTO "Post" (id,posterId,content,date,isVisible,points) VALUES (15,'14','Integer tincidunt aliquam arcu. Aliquam ultrices iaculis odio. Nam interdum enim non nisi. Aenean eget metus.','1511358281','false',2);
INSERT INTO "Post" (id,posterId,content,date,isVisible,points) VALUES (16,'2','eget mollis lectus pede et risus. Quisque libero lacus, varius et, euismod et, commodo at, libero. Morbi accumsan laoreet ipsum. Curabitur consequat, lectus sit','1545180642','false',2);
INSERT INTO "Post" (id,posterId,content,date,isVisible,points) VALUES (17,'4','cursus vestibulum. Mauris magna. Duis dignissim tempor arcu. Vestibulum ut eros non enim commodo hendrerit. Donec porttitor tellus non magna. Nam ligula elit, pretium','1504375218','true',1);
INSERT INTO "Post" (id,posterId,content,date,isVisible,points) VALUES (18,'7','eget nisi dictum augue malesuada malesuada. Integer id magna et ipsum cursus vestibulum. Mauris magna. Duis dignissim','1500829395','false',2);
INSERT INTO "Post" (id,posterId,content,date,isVisible,points) VALUES (19,'1','arcu. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Donec tincidunt. Donec vitae erat','1493782069','true',1);
INSERT INTO "Post" (id,posterId,content,date,isVisible,points) VALUES (20,'5','enim consequat purus. Maecenas libero est, congue a, aliquet vel, vulputate eu,','1540931545','false',2);
INSERT INTO "Post" (id,posterId,content,date,isVisible,points) VALUES (21,'5','nulla. Integer urna. Vivamus molestie dapibus ligula. Aliquam erat volutpat. Nulla dignissim. Maecenas ornare egestas ligula. Nullam feugiat placerat velit. Quisque','1542568770','true',1);
INSERT INTO "Post" (id,posterId,content,date,isVisible,points) VALUES (22,'16','lacinia mattis. Integer eu lacus. Quisque imperdiet, erat nonummy ultricies ornare, elit elit fermentum risus, at','1532342509','true',2);
INSERT INTO "Post" (id,posterId,content,date,isVisible,points) VALUES (23,'4','ut dolor dapibus gravida. Aliquam tincidunt, nunc ac mattis ornare, lectus ante dictum mi, ac mattis velit justo','1506936997','true',2);
INSERT INTO "Post" (id,posterId,content,date,isVisible,points) VALUES (24,'15','Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Proin vel arcu eu odio','1492779701','true',1);
INSERT INTO "Post" (id,posterId,content,date,isVisible,points) VALUES (25,'12','aliquet, sem ut cursus luctus, ipsum leo elementum sem, vitae aliquam eros turpis non enim. Mauris quis','1550198174','false',2);
INSERT INTO "Post" (id,posterId,content,date,isVisible,points) VALUES (26,'3','auctor, velit eget laoreet posuere, enim nisl elementum purus, accumsan interdum','1516347710','false',3);
INSERT INTO "Post" (id,posterId,content,date,isVisible,points) VALUES (27,'18','bibendum sed, est. Nunc laoreet lectus quis massa. Mauris vestibulum, neque sed dictum eleifend, nunc risus varius orci, in consequat','1531386844','false',3);
INSERT INTO "Post" (id,posterId,content,date,isVisible,points) VALUES (28,'17','scelerisque scelerisque dui. Suspendisse ac metus vitae velit egestas lacinia. Sed','1542227825','false',1);
INSERT INTO "Post" (id,posterId,content,date,isVisible,points) VALUES (29,'11','ullamcorper. Duis at lacus. Quisque purus sapien, gravida non, sollicitudin a, malesuada id, erat. Etiam vestibulum','1515226268','false',2);
INSERT INTO "Post" (id,posterId,content,date,isVisible,points) VALUES (30,'16','lacus. Quisque imperdiet, erat nonummy ultricies ornare, elit elit fermentum risus, at fringilla purus mauris a nunc. In at pede. Cras vulputate','1531958361','true',3);
INSERT INTO "Post" (id,posterId,content,date,isVisible,points) VALUES (31,'8','orci. Ut semper pretium neque. Morbi quis urna. Nunc quis arcu vel quam dignissim','1493206799','false',3);
INSERT INTO "Post" (id,posterId,content,date,isVisible,points) VALUES (32,'13','risus. Nulla eget metus eu erat semper rutrum. Fusce dolor quam, elementum at, egestas a, scelerisque sed, sapien. Nunc pulvinar arcu et pede. Nunc','1538039315','true',1);
INSERT INTO "Post" (id,posterId,content,date,isVisible,points) VALUES (33,'16','Vivamus molestie dapibus ligula. Aliquam erat volutpat. Nulla dignissim. Maecenas','1501088591','true',3);
INSERT INTO "Post" (id,posterId,content,date,isVisible,points) VALUES (34,'2','mauris elit, dictum eu, eleifend nec, malesuada ut, sem. Nulla interdum. Curabitur dictum. Phasellus in felis. Nulla tempor augue ac ipsum. Phasellus vitae','1518936565','false',1);
INSERT INTO "Post" (id,posterId,content,date,isVisible,points) VALUES (35,'9','nascetur ridiculus mus. Aenean eget magna. Suspendisse tristique neque venenatis lacus. Etiam bibendum fermentum metus. Aenean sed','1506030929','false',1);
INSERT INTO "Post" (id,posterId,content,date,isVisible,points) VALUES (36,'12','Mauris quis turpis vitae purus gravida sagittis. Duis gravida. Praesent eu nulla at sem','1518587127','true',3);
INSERT INTO "Post" (id,posterId,content,date,isVisible,points) VALUES (37,'6','ipsum. Curabitur consequat, lectus sit amet luctus vulputate, nisi sem semper erat, in consectetuer','1491573205','false',2);
INSERT INTO "Post" (id,posterId,content,date,isVisible,points) VALUES (38,'5','sagittis semper. Nam tempor diam dictum sapien. Aenean massa. Integer vitae nibh. Donec est mauris, rhoncus id, mollis','1513331822','false',2);
INSERT INTO "Post" (id,posterId,content,date,isVisible,points) VALUES (39,'20','malesuada fames ac turpis egestas. Fusce aliquet magna a neque. Nullam ut','1508687592','true',3);
INSERT INTO "Post" (id,posterId,content,date,isVisible,points) VALUES (40,'20','Praesent eu dui. Cum sociis natoque penatibus et magnis dis','1542750698','false',2);
INSERT INTO "Post" (id,posterId,content,date,isVisible,points) VALUES (41,'17','mus. Aenean eget magna. Suspendisse tristique neque venenatis lacus. Etiam bibendum fermentum metus. Aenean sed pede nec','1523058855','true',2);
INSERT INTO "Post" (id,posterId,content,date,isVisible,points) VALUES (42,'13','Donec fringilla. Donec feugiat metus sit amet ante. Vivamus non','1509493241','true',3);
INSERT INTO "Post" (id,posterId,content,date,isVisible,points) VALUES (43,'18','purus, in molestie tortor nibh sit amet orci. Ut sagittis lobortis mauris. Suspendisse aliquet molestie tellus. Aenean egestas hendrerit neque. In ornare sagittis','1535051584','false',3);
INSERT INTO "Post" (id,posterId,content,date,isVisible,points) VALUES (44,'10','enim. Etiam imperdiet dictum magna. Ut tincidunt orci quis lectus. Nullam suscipit,','1531531062','false',1);
INSERT INTO "Post" (id,posterId,content,date,isVisible,points) VALUES (45,'13','ipsum non arcu. Vivamus sit amet risus. Donec egestas. Aliquam nec enim. Nunc ut erat. Sed nunc','1508613392','false',2);
INSERT INTO "Post" (id,posterId,content,date,isVisible,points) VALUES (46,'20','montes, nascetur ridiculus mus. Aenean eget magna. Suspendisse tristique neque venenatis lacus. Etiam bibendum fermentum metus. Aenean sed pede nec ante blandit viverra. Donec tempus,','1534662053','false',1);
INSERT INTO "Post" (id,posterId,content,date,isVisible,points) VALUES (47,'11','nec, mollis vitae, posuere at, velit. Cras lorem lorem, luctus ut, pellentesque eget, dictum placerat, augue. Sed molestie. Sed id risus','1492559400','false',3);
INSERT INTO "Post" (id,posterId,content,date,isVisible,points) VALUES (48,'5','ligula. Nullam feugiat placerat velit. Quisque varius. Nam porttitor scelerisque neque. Nullam nisl. Maecenas malesuada fringilla est. Mauris eu','1543761038','true',3);
INSERT INTO "Post" (id,posterId,content,date,isVisible,points) VALUES (49,'5','libero. Proin sed turpis nec mauris blandit mattis. Cras eget nisi dictum augue malesuada malesuada. Integer id magna et ipsum cursus vestibulum. Mauris','1536067481','false',3);
INSERT INTO "Post" (id,posterId,content,date,isVisible,points) VALUES (50,'7','sem egestas blandit. Nam nulla magna, malesuada vel, convallis in, cursus et, eros. Proin ultrices.','1534721675','true',3);


INSERT INTO "Answer" (postId,questionId,isCorrect) VALUES (1,46,'false');
INSERT INTO "Answer" (postId,questionId,isCorrect) VALUES (2,42,'false');
INSERT INTO "Answer" (postId,questionId,isCorrect) VALUES (3,38,'true');
INSERT INTO "Answer" (postId,questionId,isCorrect) VALUES (4,32,'false');
INSERT INTO "Answer" (postId,questionId,isCorrect) VALUES (5,35,'true');
INSERT INTO "Answer" (postId,questionId,isCorrect) VALUES (6,49,'false');
INSERT INTO "Answer" (postId,questionId,isCorrect) VALUES (7,45,'true');
INSERT INTO "Answer" (postId,questionId,isCorrect) VALUES (8,39,'false');
INSERT INTO "Answer" (postId,questionId,isCorrect) VALUES (9,32,'false');
INSERT INTO "Answer" (postId,questionId,isCorrect) VALUES (10,45,'true');
INSERT INTO "Answer" (postId,questionId,isCorrect) VALUES (11,35,'false');
INSERT INTO "Answer" (postId,questionId,isCorrect) VALUES (12,47,'true');
INSERT INTO "Answer" (postId,questionId,isCorrect) VALUES (13,44,'false');
INSERT INTO "Answer" (postId,questionId,isCorrect) VALUES (14,46,'true');
INSERT INTO "Answer" (postId,questionId,isCorrect) VALUES (15,47,'false');
INSERT INTO "Answer" (postId,questionId,isCorrect) VALUES (16,34,'false');
INSERT INTO "Answer" (postId,questionId,isCorrect) VALUES (17,45,'false');
INSERT INTO "Answer" (postId,questionId,isCorrect) VALUES (18,47,'true');
INSERT INTO "Answer" (postId,questionId,isCorrect) VALUES (19,40,'false');
INSERT INTO "Answer" (postId,questionId,isCorrect) VALUES (20,45,'true');
INSERT INTO "Answer" (postId,questionId,isCorrect) VALUES (21,49,'true');
INSERT INTO "Answer" (postId,questionId,isCorrect) VALUES (22,39,'true');
INSERT INTO "Answer" (postId,questionId,isCorrect) VALUES (23,47,'false');
INSERT INTO "Answer" (postId,questionId,isCorrect) VALUES (24,36,'false');
INSERT INTO "Answer" (postId,questionId,isCorrect) VALUES (25,50,'true');
INSERT INTO "Answer" (postId,questionId,isCorrect) VALUES (26,35,'true');
INSERT INTO "Answer" (postId,questionId,isCorrect) VALUES (27,35,'true');
INSERT INTO "Answer" (postId,questionId,isCorrect) VALUES (28,45,'false');
INSERT INTO "Answer" (postId,questionId,isCorrect) VALUES (29,37,'true');
INSERT INTO "Answer" (postId,questionId,isCorrect) VALUES (30,44,'false');


INSERT INTO "Question" (postId,isClosed,nViews,title) VALUES (31,'true',18,'velit. Pellentesque ultricies');
INSERT INTO "Question" (postId,isClosed,nViews,title) VALUES (32,'true',15,'diam. Sed');
INSERT INTO "Question" (postId,isClosed,nViews,title) VALUES (33,'true',20,'nulla. Integer');
INSERT INTO "Question" (postId,isClosed,nViews,title) VALUES (34,'false',19,'cursus in, hendrerit');
INSERT INTO "Question" (postId,isClosed,nViews,title) VALUES (35,'false',12,'fermentum risus, at');
INSERT INTO "Question" (postId,isClosed,nViews,title) VALUES (36,'true',17,'semper et, lacinia');
INSERT INTO "Question" (postId,isClosed,nViews,title) VALUES (37,'true',20,'rhoncus id,');
INSERT INTO "Question" (postId,isClosed,nViews,title) VALUES (38,'false',6,'orci. Ut semper');
INSERT INTO "Question" (postId,isClosed,nViews,title) VALUES (39,'true',3,'lobortis');
INSERT INTO "Question" (postId,isClosed,nViews,title) VALUES (40,'false',4,'volutpat.');
INSERT INTO "Question" (postId,isClosed,nViews,title) VALUES (41,'true',10,'molestie tellus.');
INSERT INTO "Question" (postId,isClosed,nViews,title) VALUES (42,'true',9,'egestas.');
INSERT INTO "Question" (postId,isClosed,nViews,title) VALUES (43,'true',19,'sociis');
INSERT INTO "Question" (postId,isClosed,nViews,title) VALUES (44,'true',7,'quis diam luctus');
INSERT INTO "Question" (postId,isClosed,nViews,title) VALUES (45,'false',11,'aliquet odio.');
INSERT INTO "Question" (postId,isClosed,nViews,title) VALUES (46,'false',19,'euismod et,');
INSERT INTO "Question" (postId,isClosed,nViews,title) VALUES (47,'true',15,'montes, nascetur');
INSERT INTO "Question" (postId,isClosed,nViews,title) VALUES (48,'true',9,'Duis a');
INSERT INTO "Question" (postId,isClosed,nViews,title) VALUES (49,'true',19,'orci, in');
INSERT INTO "Question" (postId,isClosed,nViews,title) VALUES (50,'true',4,'Nam');


INSERT INTO "TagQuestion" (question_id,tag_id) VALUES (31,8);
INSERT INTO "TagQuestion" (question_id,tag_id) VALUES (32,2);
INSERT INTO "TagQuestion" (question_id,tag_id) VALUES (33,8);
INSERT INTO "TagQuestion" (question_id,tag_id) VALUES (34,1);
INSERT INTO "TagQuestion" (question_id,tag_id) VALUES (35,10);
INSERT INTO "TagQuestion" (question_id,tag_id) VALUES (36,6);
INSERT INTO "TagQuestion" (question_id,tag_id) VALUES (37,5);
INSERT INTO "TagQuestion" (question_id,tag_id) VALUES (38,2);
INSERT INTO "TagQuestion" (question_id,tag_id) VALUES (39,6);
INSERT INTO "TagQuestion" (question_id,tag_id) VALUES (40,6);
INSERT INTO "TagQuestion" (question_id,tag_id) VALUES (41,5);
INSERT INTO "TagQuestion" (question_id,tag_id) VALUES (42,5);
INSERT INTO "TagQuestion" (question_id,tag_id) VALUES (43,6);
INSERT INTO "TagQuestion" (question_id,tag_id) VALUES (44,10);
INSERT INTO "TagQuestion" (question_id,tag_id) VALUES (45,10);
INSERT INTO "TagQuestion" (question_id,tag_id) VALUES (46,2);
INSERT INTO "TagQuestion" (question_id,tag_id) VALUES (47,7);
INSERT INTO "TagQuestion" (question_id,tag_id) VALUES (48,4);
INSERT INTO "TagQuestion" (question_id,tag_id) VALUES (49,8);
INSERT INTO "TagQuestion" (question_id,tag_id) VALUES (50,10);


INSERT INTO "PostVote" (postId,posterId,value) VALUES (12,1,'-1');
INSERT INTO "PostVote" (postId,posterId,value) VALUES (22,22,'1');
INSERT INTO "PostVote" (postId,posterId,value) VALUES (27,19,'1');
INSERT INTO "PostVote" (postId,posterId,value) VALUES (16,20,'1');
INSERT INTO "PostVote" (postId,posterId,value) VALUES (31,4,'1');
INSERT INTO "PostVote" (postId,posterId,value) VALUES (12,16,'-1');
INSERT INTO "PostVote" (postId,posterId,value) VALUES (14,17,'-1');
INSERT INTO "PostVote" (postId,posterId,value) VALUES (7,23,'-1');
INSERT INTO "PostVote" (postId,posterId,value) VALUES (43,10,'1');
INSERT INTO "PostVote" (postId,posterId,value) VALUES (50,7,'1');
INSERT INTO "PostVote" (postId,posterId,value) VALUES (30,21,'-1');
INSERT INTO "PostVote" (postId,posterId,value) VALUES (20,24,'1');
INSERT INTO "PostVote" (postId,posterId,value) VALUES (4,12,'1');
INSERT INTO "PostVote" (postId,posterId,value) VALUES (18,13,'1');
INSERT INTO "PostVote" (postId,posterId,value) VALUES (29,24,'-1');
INSERT INTO "PostVote" (postId,posterId,value) VALUES (46,23,'1');
INSERT INTO "PostVote" (postId,posterId,value) VALUES (50,5,'-1');
INSERT INTO "PostVote" (postId,posterId,value) VALUES (20,15,'1');
INSERT INTO "PostVote" (postId,posterId,value) VALUES (26,7,'-1');
INSERT INTO "PostVote" (postId,posterId,value) VALUES (47,19,'1');
INSERT INTO "PostVote" (postId,posterId,value) VALUES (40,15,'1');
INSERT INTO "PostVote" (postId,posterId,value) VALUES (49,21,'-1');
INSERT INTO "PostVote" (postId,posterId,value) VALUES (42,8,'-1');
INSERT INTO "PostVote" (postId,posterId,value) VALUES (4,22,'-1');
INSERT INTO "PostVote" (postId,posterId,value) VALUES (34,2,'1');
INSERT INTO "PostVote" (postId,posterId,value) VALUES (28,6,'1');
INSERT INTO "PostVote" (postId,posterId,value) VALUES (31,24,'-1');
INSERT INTO "PostVote" (postId,posterId,value) VALUES (44,19,'-1');
INSERT INTO "PostVote" (postId,posterId,value) VALUES (38,1,'-1');
INSERT INTO "PostVote" (postId,posterId,value) VALUES (46,6,'-1');
INSERT INTO "PostVote" (postId,posterId,value) VALUES (8,12,'-1');


INSERT INTO "PostReport" (postId,reporterId,date) VALUES (16,'11','1548566104');
INSERT INTO "PostReport" (postId,reporterId,date) VALUES (12,'3','1530298354');
INSERT INTO "PostReport" (postId,reporterId,date) VALUES (3,'11','1501972940');
INSERT INTO "PostReport" (postId,reporterId,date) VALUES (13,'3','1539129530');
INSERT INTO "PostReport" (postId,reporterId,date) VALUES (22,'3','1497615906');
INSERT INTO "PostReport" (postId,reporterId,date) VALUES (11,'3','1499043320');
INSERT INTO "PostReport" (postId,reporterId,date) VALUES (41,'3','1531923082');
INSERT INTO "PostReport" (postId,reporterId,date) VALUES (21,'11','1532722445');
INSERT INTO "PostReport" (postId,reporterId,date) VALUES (28,'3','1533531663');
INSERT INTO "PostReport" (postId,reporterId,date) VALUES (14,'11','1539100945');
INSERT INTO "PostReport" (postId,reporterId,date) VALUES (6,'3','1532826116');
INSERT INTO "PostReport" (postId,reporterId,date) VALUES (10,'3','1514026215');
INSERT INTO "PostReport" (postId,reporterId,date) VALUES (38,'11','1539883798');
INSERT INTO "PostReport" (postId,reporterId,date) VALUES (5,'11','1510428357');
INSERT INTO "PostReport" (postId,reporterId,date) VALUES (27,'3','1506376607');


INSERT INTO FaqEntry (id, question, answer) VALUES (1, 'Is account registration required?', 'Account registration at Code Home is only required if you want to post or responde to questions.');
INSERT INTO FaqEntry (id, question, answer) VALUES (2, 'How to avoid being banned?', 'Respect other users. Respond only when you have knowldge about the theme. Bump is only allowed after 48 hours with no response');


INSERT INTO Team (id, name) VALUES (1, 'Design');
INSERT INTO Team (id, name) VALUES (2, 'Quality Assurance');
INSERT INTO Team (id, name) VALUES (3, 'Engineering');
INSERT INTO Team (id, name) VALUES (4, 'Sales/Business');


INSERT INTO "TeamMember" (id,name,email,title,joinDate,img_path) VALUES (1,'Sophia West','nunc.sed@libero.org','Tester','1496411884',1.png);
INSERT INTO "TeamMember" (id,name,email,title,joinDate,img_path) VALUES (2,'Eric Greene','blandit.Nam@justosit.edu',' Markter','1537224774',2.png);
INSERT INTO "TeamMember" (id,name,email,title,joinDate,img_path) VALUES (3,'Derek Doyle','ornare.Fusce@anteblandit.ca','Engineer','1512984340',3.png);
INSERT INTO "TeamMember" (id,name,email,title,joinDate,img_path) VALUES (4,'Griffin Mcneil','nec.quam.Curabitur@ascelerisque.com','Designer','1504663278',4.png);
INSERT INTO "TeamMember" (id,name,email,title,joinDate,img_path) VALUES (5,'Pascale Simpson','nibh.enim.gravida@neccursus.net','Tester','1529834762',5.png);


INSERT INTO "TeamToTeamMember" (teamID,teamMemberId) VALUES (3,5);
INSERT INTO "TeamToTeamMember" (teamID,teamMemberId) VALUES (2,1);
INSERT INTO "TeamToTeamMember" (teamID,teamMemberId) VALUES (3,3);
INSERT INTO "TeamToTeamMember" (teamID,teamMemberId) VALUES (4,2);
INSERT INTO "TeamToTeamMember" (teamID,teamMemberId) VALUES (1,4);