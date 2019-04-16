DROP TABLE IF EXISTS formOne;
DROP TABLE IF EXISTS formOneValid;
DROP TABLE IF EXISTS enrolls;
DROP TABLE IF EXISTS schedule;
DROP TABLE IF EXISTS course;
DROP TABLE IF EXISTS role;
DROP TABLE IF EXISTS aspects;
DROP TABLE IF EXISTS user;

-- Create user table
CREATE TABLE user (
    uid INT,
    password VARCHAR(32),
    username VARCHAR(32),
    email VARCHAR(100),
    fname VARCHAR(32),
    lname VARCHAR(32),
    address VARCHAR(128),
    balance float(20,2),
    PRIMARY KEY (uid)
);

-- Create role table
CREATE TABLE role (
    uid INT,
    type VARCHAR(16),
    FOREIGN KEY (uid) REFERENCES user(uid)
);

--
create table aspects(
  id int,
  advisorid int,
  -- role varchar(100),
  reviewForm int,
  approveThesis int,
  clearedToGrad int,
  primary key(id),
  foreign key(id) references user(uid)
);
--

-- Create course table
CREATE TABLE course (
    cid INT AUTO_INCREMENT,
    dept VARCHAR(4),
    cnum INT,
    title VARCHAR(64),
    credits INT,
    instructor_id INT,
    prereq1_id INT,
    prereq2_id INT,
    PRIMARY KEY (cid),
    -- Uncomment when 'user' table is created
    FOREIGN KEY (instructor_id) REFERENCES user(uid),
    FOREIGN KEY (prereq1_id) REFERENCES course(cid),
    FOREIGN KEY (prereq2_id) REFERENCES course(cid),
    CONSTRAINT unique_course UNIQUE(dept, cnum)
);

-- Create schedule table
CREATE TABLE schedule (
    sid INT AUTO_INCREMENT,
    cid INT,
    section INT,
    term VARCHAR(4),
    day VARCHAR(1),
    start TIME,
    end TIME,
    is_current INT, -- tells us whether this is the latest semester or not
    PRIMARY KEY (sid),
    FOREIGN KEY (cid) REFERENCES course(cid)
);

-- Create enrolls table
CREATE TABLE enrolls (
    uid INT,
    sid INT,
    grade VARCHAR(2),
    -- Uncomment when 'user' table is created
    FOREIGN KEY (uid) REFERENCES user(uid),
    FOREIGN KEY (sid) REFERENCES schedule(sid)
);


--
create table formOne(
  num int auto_increment,
  id int,
  courseNumber int,
  dept varchar(100),
  primary key(num),
  foreign key(id) references user(uid)
  );
  
  create table formOneValid(
  num int auto_increment,
  id int,
  courseNumber int,
  dept varchar(100),
  primary key(num)
  );
--

source populate_users.sql;
source populate_role.sql;
source populate_courses.sql;
source populate_schedule.sql;
source populate_enrolls.sql;