/* SQLEditor (MySQL (2))*/

CREATE TABLE courses
(
id INTEGER NOT NULL AUTO_INCREMENT,
initial_date DATE DEFAULT NULL,
final_date DATE DEFAULT NULL,
name VARCHAR(255) DEFAULT '' NOT NULL,
created_at DATETIME NOT NULL,
PRIMARY KEY (id)
);

CREATE TABLE classrooms
(
id INTEGER NOT NULL AUTO_INCREMENT,
name VARCHAR(255) NOT NULL,
type VARCHAR(255) NOT NULL,
capacity INTEGER NOT NULL,
created_at DATETIME NOT NULL,
PRIMARY KEY (id)
);

CREATE TABLE events
(
id INTEGER NOT NULL AUTO_INCREMENT,
parent_id INTEGER,
group_id INTEGER NOT NULL,
activity_id INTEGER DEFAULT '0' NOT NULL,
teacher_id INTEGER UNIQUE,
initial_hour DATETIME NOT NULL,
final_hour DATETIME NOT NULL,
classroom_id INTEGER DEFAULT '0' NOT NULL,
duration DECIMAL NOT NULL,
created_at DATETIME,
PRIMARY KEY (id)
);

CREATE TABLE users
(
id INTEGER NOT NULL AUTO_INCREMENT,
type VARCHAR(255) NOT NULL,
dni VARCHAR(255) DEFAULT '' NOT NULL,
first_name VARCHAR(255) DEFAULT '' NOT NULL,
last_name VARCHAR(255) DEFAULT '' NOT NULL,
username VARCHAR(255) DEFAULT '' NOT NULL,
phone VARCHAR(255) DEFAULT '',
password VARCHAR(40) DEFAULT '' NOT NULL,
created_at DATETIME NOT NULL,
PRIMARY KEY (id)
);

INSERT INTO users(type, dni, first_name, last_name, username, password, created_at) VALUES('Administrador', '45759313P', 'Daniel', 'Hernandez Aguiar', 'daniel.hernandezaguiar@gmail.com', '955d22a09bc7ea3eb99365ef7adc199553862fdb', NOW());

CREATE TABLE subjects
(
Id INTEGER NOT NULL AUTO_INCREMENT,
course_id INTEGER DEFAULT '0' NOT NULL,
code INTEGER DEFAULT '0' NOT NULL,
level VARCHAR(255) DEFAULT '' NOT NULL,
type VARCHAR(255) NOT NULL,
name VARCHAR(255) DEFAULT '' NOT NULL,
acronym VARCHAR(255) NOT NULL,
semester VARCHAR(255) NOT NULL,
credits_number DECIMAL NOT NULL,
coordinator_id INTEGER DEFAULT '0' NOT NULL,
practice_responsible_id INTEGER NOT NULL,
created_at DATETIME NOT NULL,
PRIMARY KEY (Id)
);

CREATE TABLE bookings
(
id INTEGER NOT NULL AUTO_INCREMENT,
parent_id INTEGER,
user_id INTEGER DEFAULT '0' NOT NULL,
initial_hour DATETIME NOT NULL,
classroom_id INTEGER DEFAULT '0' NOT NULL,
final_hour DATETIME NOT NULL,
reason VARCHAR(255) DEFAULT '' NOT NULL,
required_equipment TEXT,
created_at DATETIME NOT NULL,
PRIMARY KEY (id)
);

CREATE TABLE groups
(
id INTEGER NOT NULL AUTO_INCREMENT,
subject_id INTEGER DEFAULT '0' NOT NULL,
name VARCHAR(255) DEFAULT '' NOT NULL,
type VARCHAR(255) DEFAULT '' NOT NULL,
capacity INTEGER DEFAULT '0' NOT NULL,
notes TEXT,
created_at DATETIME NOT NULL,
PRIMARY KEY (id)
);

CREATE TABLE activities
(
id INTEGER NOT NULL AUTO_INCREMENT,
subject_id INTEGER DEFAULT '0' NOT NULL,
type VARCHAR(255) DEFAULT '' NOT NULL,
name VARCHAR(255) DEFAULT '' NOT NULL,
notes TEXT,
duration DECIMAL NOT NULL,
created_at DATETIME NOT NULL,
PRIMARY KEY (id)
);

CREATE TABLE student_groups_activities
(
group_id INTEGER,
activity_id INTEGER,
student_id INTEGER
);

CREATE TABLE attendance_registers
(
event_id INTEGER,
id INTEGER NOT NULL AUTO_INCREMENT,
initial_hour DATETIME NOT NULL,
final_hour DATETIME NOT NULL,
duration DECIMAL NOT NULL,
created_at DATETIME NOT NULL,
PRIMARY KEY (id)
);

CREATE TABLE users_attendance_register
(
user_id INTEGER NOT NULL,
attendance_register_id INTEGER NOT NULL,
user_gone BOOLEAN NOT NULL
);

CREATE INDEX parent_id_idxfk ON events(parent_id);
ALTER TABLE events ADD FOREIGN KEY parent_id_idxfk (parent_id) REFERENCES events (id);

CREATE INDEX group_id_idxfk ON events(group_id);
ALTER TABLE events ADD FOREIGN KEY group_id_idxfk (group_id) REFERENCES groups (id);

CREATE INDEX activity_id_idxfk ON events(activity_id);
ALTER TABLE events ADD FOREIGN KEY activity_id_idxfk (activity_id) REFERENCES activities (id);

CREATE INDEX classroom_id_idxfk ON events(classroom_id);
ALTER TABLE events ADD FOREIGN KEY classroom_id_idxfk (classroom_id) REFERENCES classrooms (id);

ALTER TABLE users ADD FOREIGN KEY id_idxfk (id) REFERENCES events (teacher_id);

CREATE INDEX course_id_idxfk ON subjects(course_id);
ALTER TABLE subjects ADD FOREIGN KEY course_id_idxfk (course_id) REFERENCES courses (id);

CREATE INDEX coordinator_id_idxfk ON subjects(coordinator_id);
ALTER TABLE subjects ADD FOREIGN KEY coordinator_id_idxfk (coordinator_id) REFERENCES users (id);

CREATE INDEX practice_responsible_id_idxfk ON subjects(practice_responsible_id);
ALTER TABLE subjects ADD FOREIGN KEY practice_responsible_id_idxfk (practice_responsible_id) REFERENCES users (id);

CREATE INDEX parent_id_idxfk ON bookings(parent_id);
ALTER TABLE bookings ADD FOREIGN KEY parent_id_idxfk_1 (parent_id) REFERENCES bookings (id);

CREATE INDEX user_id_idxfk ON bookings(user_id);
ALTER TABLE bookings ADD FOREIGN KEY user_id_idxfk (user_id) REFERENCES users (id);

CREATE INDEX classroom_id_idxfk ON bookings(classroom_id);
ALTER TABLE bookings ADD FOREIGN KEY classroom_id_idxfk_1 (classroom_id) REFERENCES classrooms (id);

CREATE INDEX subject_id_idxfk ON groups(subject_id);
ALTER TABLE groups ADD FOREIGN KEY subject_id_idxfk (subject_id) REFERENCES subjects (Id);

CREATE INDEX subject_id_idxfk ON activities(subject_id);
ALTER TABLE activities ADD FOREIGN KEY subject_id_idxfk_1 (subject_id) REFERENCES subjects (Id);

CREATE INDEX group_id_idxfk ON student_groups_activities(group_id);
ALTER TABLE student_groups_activities ADD FOREIGN KEY group_id_idxfk (group_id) REFERENCES groups (id);

CREATE INDEX activity_id_idxfk ON student_groups_activities(activity_id);
ALTER TABLE student_groups_activities ADD FOREIGN KEY activity_id_idxfk (activity_id) REFERENCES activities (id);

CREATE INDEX student_id_idxfk ON student_groups_activities(student_id);
ALTER TABLE student_groups_activities ADD FOREIGN KEY student_id_idxfk (student_id) REFERENCES users (id);

CREATE INDEX event_id_idxfk ON attendance_registers(event_id);
ALTER TABLE attendance_registers ADD FOREIGN KEY event_id_idxfk (event_id) REFERENCES events (id);

CREATE INDEX user_id_idxfk ON users_attendance_register(user_id);
ALTER TABLE users_attendance_register ADD FOREIGN KEY user_id_idxfk (user_id) REFERENCES users (id);

CREATE INDEX attendance_register_id_idxfk ON users_attendance_register(attendance_register_id);
ALTER TABLE users_attendance_register ADD FOREIGN KEY attendance_register_id_idxfk (attendance_register_id) REFERENCES attendance_registers (id);
