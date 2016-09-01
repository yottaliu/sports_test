CREATE DATABASE student;
USE student;
CREATE TABLE user
(
    username VARCHAR(30) NOT NULL,
    password VARCHAR(16) NULL,
    type VARCHAR(15) NOT NULL,
    classid VARCHAR(10) NULL,
    PRIMARY KEY(username, type)
);
CREATE TABLE info
(
    no CHAR(11) NOT NULL UNIQUE,
    nationid CHAR(2) NULL,
    name VARCHAR(18) NULL,
    sex CHAR(1) NULL,
    birthday DATE NULL,
    zipcode CHAR(6) NULL,
    id CHAR(18) NULL UNIQUE,
    address VARCHAR(256) NULL,
    classid VARCHAR(10) NULL,
    PRIMARY KEY(no)
);
CREATE TABLE class
(
    classid VARCHAR(10) NOT NULL UNIQUE,
    gradeid CHAR(2) NULL,
    classname VARCHAR(24) NULL,
    PRIMARY KEY(classid)
);
CREATE TABLE score
(
    no CHAR(11) NOT NULL UNIQUE,
    height FLOAT(4,1) NULL,
    weight FLOAT(4,1) NULL,
    fvc INT NULL,				# 肺活量
    shortrunning FLOAT(3,1) NULL,
    jump FLOAT(3,2) NULL,
    sitandreach FLOAT(3,1) NULL,		# 坐位体前屈
    longrunning TIME NULL,
    pulluporsitup INT NULL,			# 引体向上或者仰卧起坐
    lefteye FLOAT(2,1) NULL,			# 视力
    righteye FLOAT(2,1) NULL,
    PRIMARY KEY(no)
);
/*
INSERT INTO mysql.user(Host, User, Password) VALUES ('localhost', 'admin_student', password('admin_student'));
INSERT INTO mysql.user(Host, User, Password) VALUES ('localhost', 'teacher_student', password('teacher_student'));
INSERT INTO mysql.user(Host, User, Password) VALUES ('localhost', 'typer_student', password('typer_student'));
INSERT INTO mysql.user(Host, User, Password) VALUES ('localhost', 'student_student', password('student_student'));
*/
CREATE USER 'admin_student'@'localhost' IDENTIFIED BY 'admin_student';
CREATE USER 'teacher_student'@'localhost' IDENTIFIED BY 'teacher_student';
CREATE USER 'typer_student'@'localhost' IDENTIFIED BY 'typer_student';
CREATE USER 'student_student'@'localhost' IDENTIFIED BY 'student_student';
GRANT ALL PRIVILEGES ON student.* TO admin_student@localhost;
GRANT SELECT, UPDATE ON student.user TO teacher_student@localhost;
GRANT ALL PRIVILEGES ON student.info TO teacher_student@localhost;
GRANT SELECT ON student.class TO teacher_student@localhost;
GRANT SELECT, DELETE ON student.score TO teacher_student@localhost;
GRANT SELECT, UPDATE ON student.user TO typer_student@localhost;
GRANT SELECT ON student.info TO typer_student@localhost;
GRANT SELECT ON student.class TO typer_student@localhost;
GRANT ALL PRIVILEGES ON student.score TO typer_student@localhost;
GRANT SELECT ON student.* TO student_student@localhost;
FLUSH PRIVILEGES;
INSERT INTO user (username, password, type, classid) VALUES ('admin', 'admin', '管理员', '0');
INSERT INTO user (username, password, type, classid) VALUES ('teacher', 'teacher', '素质导师', '1');
INSERT INTO user (username, password, type, classid) VALUES ('typer', 'typer', '录入人员', '1');
INSERT INTO user (username, password, type, classid) VALUES ('typer2', 'typer2', '录入人员', '2');
INSERT INTO info (no, nationid, name, sex, birthday, zipcode, id, address, classid) VALUES ('20144221032', '30', '刘尧', '1', '1995-06-16', '442411', '429021199506160511', '湖北省神农架林区', '1');
INSERT INTO info (no, nationid, name, sex, birthday, zipcode, id, address, classid) VALUES ('20144221033', '30', '林凡', '1', '1996-03-19', '430223', '420321199603190718', '湖北省武汉市', '1');
INSERT INTO info (no, nationid, name, sex, birthday, zipcode, id, address, classid) VALUES ('20144221123', '35', '小明', '2', '1996-05-29', '432145', '412431199605294312', '火星', '2');
INSERT INTO score (no, height, weight, fvc, shortrunning, jump, sitandreach, longrunning, pulluporsitup, lefteye, righteye) VALUES ('20144221032', 171.0, 55.0, 5050, 7.7, 2.31, 18.1, '00:04:20', 25, 3.1, 3.2);
INSERT INTO score (no, height, weight, fvc, shortrunning, jump, sitandreach, longrunning, pulluporsitup, lefteye, righteye) VALUES ('20144221033', 172.0, 60.5, 5110, 7.3, 2.26, 9.3, '00:04:16', 12, 3.8, 3.6);
INSERT INTO score (no, height, weight, fvc, shortrunning, jump, sitandreach, longrunning, pulluporsitup, lefteye, righteye) VALUES ('20144221123', 162.0, 45.0, 3400, 9.4, 1.78, 19.8, '00:04:38', 56, 3.6, 3.5);
INSERT INTO class (classid, gradeid, classname) VALUES ('1', '41', '计科1401');
INSERT INTO class (classid, gradeid, classname) VALUES ('2', '41', '计科1402');
INSERT INTO class (classid, gradeid, classname) VALUES ('3', '42', '计科1301');
