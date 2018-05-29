drop index username_user;
drop index user_id;
drop index post_id;
drop index question_id;
drop index answer_id;
drop index tag_id;
drop index tagquestion_questionid;
drop index title_search;
drop index body_search;

CREATE INDEX username_user ON users USING hash(username);
CREATE INDEX user_id ON users USING hash(id);
CREATE INDEX post_id ON Post USING hash(id);
CREATE INDEX question_id ON Question USING hash(postId);
CREATE INDEX answer_id ON Answer USING hash(postId);
CREATE INDEX tag_id ON Tag USING hash(id);
CREATE INDEX tagquestion_questionid ON TagQuestion USING hash
(question_id);
CREATE INDEX title_search ON Question using gist (to_tsvector('english', title));
CREATE INDEX body_search ON Post using gist (to_tsvector('english',content));