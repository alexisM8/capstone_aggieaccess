/*
//////////////////////// STUDENT INFORMATION /////////////////
//      Below is all the querys to do on a student as       //
//           well as querys a student would do              //
//////////////////////////////////////////////////////////////
*/

/* 
Shows all students enrolled into a course.
Given CRN from course and time range from time 
Essentially this can be uesd to display the class roster
*/

SELECT student.fname, student.lname, student.email 
FROM enrollment 
JOIN student ON enrollment.studentID = student.sid 
JOIN class ON enrollment.classID = class.classID
JOIN time ON class.timeID = time.timeID
JOIN course ON course.courseID = class.courseID
WHERE course.CRN = '$CRN'
AND time.timeRange = '$time';

/*
get information from a student based
*/

/* 
insert a student into the student table
phone number and advisor are null by default the others must have a value 
reminder $varname are variables that we create to store the values in the 
form. we access form values by using post array. ex 
$fname = $_POST['fname']; 
*/

INSERT INTO student(fname, email, lname, major, classification, phone)
VALUES('$fname', '$email', '$lname', '$major', '$classification', '$phone')

/*
update information of a student
we should query to get the sid of a student. we also want the form to have 
a default value of the student information as it currently is so we will 
have to query for the student ino and save it into a $variables then give the form 
the default vaule of the query we made eariler 
*/

UPDATE student
SET fname = '$fname',
    email = '$email',
    lname = '$lname',
    major = '$major',
    classification = '$classification',
    phone = '$phone',
    advisor = '$advisor'
WHERE sid IN (SELECT sid FROM student WHERE email = "$email");

/*
deleting a student and all instances of the student
student is referenced in enrollment, student and student password
!!NEVER run a delete query with out a where clause if you do all records will be deleted
*/

DELETE FROM enrollment WHERE studentID IN (SELECT sid FROM student WHERE email = "$email");
DELETE FROM student_passwords WHERE studentID IN (SELECT sid FROM student WHERE email = "$email");
DELETE FROM student WHERE sid IN (SELECT sid FROM student WHERE email = "$email");

/*
//////////////////////// FACULTY INFORMATION /////////////////
//      Below is all the querys to do on a faculty as       //
//           well as querys a faculty would do              //
//////////////////////////////////////////////////////////////
*/

/*
insert faculty into faculty table
all fields are required and non are null
roll and office are foreign key values of faculty_roles 
and location respectivly
*/

INSERT INTO faculty (fname, email, lname, role, office, phone) 
	VALUES ('$fname', '$email', '$lname',
	(SELECT frid FROM faculty_roles WHERE faculty_roles.roles = '$role'),
	(SELECT locationID FROM (SELECT locationID, buildAbbrv, roomNum
	    FROM location JOIN building ON location.buildID = building.buildID
		JOIN rooms ON location.roomID = rooms.roomID) AS temp 
		WHERE CONCAT(temp.buildAbbrv, temp.roomNUM) = '$office'), '$phone');

/*
update information of a faculty
we should query to get the fid of a faculty. we also want the form to have 
a default value of the faculty information as it currently is so we will 
have to query for the faculty ino and save it into $variables then give the form 
the default vaule of the query we made eariler 
*/

UPDATE faculty
SET fname = '$fname',
    email = '$email',
    lname = '$lname',
    phone = '$phone',
    role = (select locationID 
            FROM (SELECT locationID, buildAbbrv, roomNum
                    FROM location 
                    JOIN building ON location.buildID = building.buildID
                    JOIN rooms ON location.roomID = rooms.roomID) 
            as temp where temp.buildAbbrv = '$builAbbrv' AND temp.roomNUM = '$roomNum';) 
WHERE fid IN (SELECT fid FROM faculty WHERE email = "$email");

/*
deleting a aculty and all instances of the faculty
faculty is referenced in enrollment, faculty and faculty password
!!NEVER run a delete query with out a where clause if you do all records will be deleted
*/

DELETE FROM enrollment WHERE facultyID IN (SELECT fid FROM faculty WHERE email = "$email");
DELETE FROM faculty_passwords WHERE facultyID IN (SELECT fid FROM faculty WHERE email = "$email");
DELETE FROM faculty WHERE fid IN (SELECT sid FROM faculty WHERE email = "$email");

/*
show all classes a professor is enrolled into based on last name and faculty ID
*/

SELECT DISTINCT c.courseTitle AS Course_Title,
            f.lname AS Instructor,        
            t.timerange AS Time,        
            d.days AS Meeting_Days,        
            dt.startDate AS Start_Date,        
            dt.endDate AS End_Date,        
            r.roomNum AS Room 
        FROM course AS c INNER JOIN class AS cl ON c.courseID = cl.courseID 
        INNER JOIN enrollment AS e ON cl.classID = e.classID 
        INNER JOIN faculty AS g ON e.facultyID = g.fid AND g.lname = '$lname'
        INNER JOIN enrollment AS z ON cl.classID = z.classID AND z.facultyID = g.fid
        INNER JOIN faculty AS f ON z.facultyID = f.fid 
        INNER JOIN time AS t ON cl.timeID = t.timeID 
        INNER JOIN day AS d ON cl.dayID = d.daysID 
        INNER JOIN date AS dt ON cl.dateID = dt.dateID 
        INNER JOIN location AS l ON cl.locationID = l.locationID 
        INNER JOIN rooms AS r ON l.roomID = r.roomID;


/*
List all classes and information about them
*/

SELECT course.courseTitle, course.CRN, faculty.lname, time.timeRange, date.startDate, date.endDate, rooms.roomNum, building.buildAbbrv
FROM course 
JOIN class ON course.courseID = class.courseID 
JOIN time ON class.timeID = time.timeID 
JOIN date ON class.dateID = date.dateID 
JOIN location ON class.locationID = location.locationID 
JOIN rooms ON location.roomID = rooms.roomID
JOIN building ON location.buildID = building.buildID
JOIN faculty ON class.profID = faculty.fid;

/*
Shows all classes that match a given CRN
*/

SELECT course.courseTitle, course.CRN, faculty.lname, time.timeRange, date.startDate, date.endDate, rooms.roomNum, building.buildAbbrv
FROM course 
JOIN class ON course.courseID = class.courseID 
JOIN time ON class.timeID = time.timeID 
JOIN date ON class.dateID = date.dateID 
JOIN location ON class.locationID = location.locationID 
JOIN rooms ON location.roomID = rooms.roomID
JOIN building ON location.buildID = building.buildID
JOIN faculty ON class.profID = faculty.fid
WHERE course.CRN = '$CRN';


/*
Shows all from course table while hiding courseID
*/

SELECT course.courseTitle, course.CRN FROM course;


/*
Show all from course table where the CRN contains ???$departmentAbbrv???
EX: if $departmentAbbrv is 'CS' query will display all 12 CS courses
*/

SELECT courseTitle, CRN, departmentAbbrv
FROM course 
JOIN department ON course.departmentID = department.departmentID
WHERE departmentAbbrv = '$departmantAbbrv';