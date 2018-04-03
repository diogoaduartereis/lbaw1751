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
