/* create tables */

CREATE TABLE users (
  ID integer NOT NULL,
  username text,
  password text NOT NULL,
  singer integer NOT NULL,
  writer integer NOT NULL,
  producer integer NOT NULL,
  PRIMARY KEY(ID)
);

CREATE TABLE studios (
  ID integer NOT NULL,
  name text NOT NULL,
  PRIMARY KEY(ID)
);
/* initial seed data */

/* manager position, when logged in granted access to add studios
username: manager, password: password0*/
INSERT INTO users (username,password,singer,writer,producer)
  VALUES ("manager","$2y$10$jT4MWyeZLUBFmvwxztEO1eh11MHeGt137kN9559AtNktA..QooAzS",1,1,1);
/* username: user1, password: password1 -*/
INSERT INTO users (username,password,singer,writer,producer)
  VALUES ("user1","$2y$10$zaelHmwSAEGxjTcgFkd0/.T6XTyJSWeqMUJjMcqtEDLZ11vCFEHyK",1,1,0);
/* username: user2, password: password2 */
INSERT INTO users (username,password,singer,writer,producer)
  VALUES ("user2","$2y$10$gfnqzLlxB5DNLyJ3xzHyCuwARRm1ykDqnnnH4iE3bEB8x7vOStJUe",0,1,1);
/* seed studio insert */
INSERT INTO studios (name) VALUES ("studio1");
INSERT INTO studios (name) VALUES ("studio2");
INSERT INTO studios (name) VALUES ("studio3");

CREATE TABLE manager (
  ID integer NOT NULL,
  studio text,
  slot text,
  partner1 text,
  partner2 text,
  role text,
  date date,
  PRIMARY KEY(ID)
);

CREATE TABLE user1 (
  ID integer NOT NULL,
  studio text,
  slot text,
  partner1 text,
  partner2 text,
  role text,
  date date,
  PRIMARY KEY(ID)
);

CREATE TABLE user2 (
  ID integer NOT NULL,
  studio text,
  slot text,
  partner1 text,
  partner2 text,
  role text,
  date date,
  PRIMARY KEY(ID)
);

CREATE TABLE studio1 (
  ID integer NOT NULL,
  `0_3` text,
  `3_6` text,
  `6_9` text,
  `9_12` text,
  `12_15` text,
  `15_18` text,
  `18_21` text,
  `21_0` text,
  date date NOT NULL,
  PRIMARY KEY (ID)
);

CREATE TABLE studio2 (
  ID integer NOT NULL,
  `0_3` text,
  `3_6` text,
  `6_9` text,
  `9_12` text,
  `12_15` text,
  `15_18` text,
  `18_21` text,
  `21_0` text,
  date date NOT NULL,
  PRIMARY KEY (ID)
);

CREATE TABLE studio3 (
  ID integer NOT NULL,
  `0_3` text,
  `3_6` text,
  `6_9` text,
  `9_12` text,
  `12_15` text,
  `15_18` text,
  `18_21` text,
  `21_0` text,
  date date NOT NULL,
  PRIMARY KEY (ID)
);
