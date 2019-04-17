create table aspects(
  id int,
  advisorid int,
  startYear VARCHAR(16),
  gradYear VARCHAR(16),
  -- role varchar(100),
  reviewForm int,
  approveThesis int,
  clearedToGrad int,
  primary key(id),
  foreign key(id) references user(uid)
);


INSERT INTO aspects VALUES (
    88888888, 
    NULL,
    2017, 
    2021,
    0, 
    0,
    0
);

INSERT INTO aspects VALUES (
    99999999,
    NULL,
    2017, 
    2021,
    0, 
    0,
    0
);
