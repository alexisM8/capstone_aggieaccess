/* 
Shows all students enrolled into a course.
Give CRN from course and time range from time 
*/

SELECT student.fname, student.lname, student.email 
FROM enrollment 
JOIN student ON enrollment.studentID = student.sid 
JOIN class ON enrollment.classID = class.classID
JOIN time ON class.timeID = time.timeID
JOIN course ON course.courseID = class.courseID
WHERE course.CRN = 'CS 1314'
AND time.timeRange = '12:00-1:00PM';

/* 
insert a student into the student table
phone number and advisor are null by default the others must have a value 
reminder $varname are variables that we create to store the values in the 
form. we access form values by using post array. ex 
$fname = $_POST['fname']; 
*/

insert into student(fname, email, lname, major, classification)
values('$fname', "$email", "$lname", "$major", "$classification")

/*
update information of a student
we should query to get the sid of a student we also want the form to have 
a default value of the student information as it currently is so we will 
have to query for the student and save it into a  $variable then give the form 
the default vaule of the query we made eariler 
*/

update student
set fname = "$fname",
    email = "$email",
    lname = "$lname",
    major = "$major",
    classification = "$classification"
where sid in (select sid from student where email = "$email");

/*
deleting a student and all instances of the student
student is referenced in enrollment, student and student password
!!NEVER run a delete query with out a where clause if you do all records will be deleted
*/

delete from enrollment where studentID in (select sid from student where email = "StudentEmail");
delete from student_passwords where studentID in (select sid from student where email = "StudentEmail");
delete from student where sid in (select sid from student where email = "StudentEmail");

/*
insert faculty into faculty table
all fields are required and non are null
roll and office are foreign key values of faculty_roles 
and location respectivly
*/

INSERT INTO faculty (fname, email, lname,role, office, phone) 
	VALUES ('$fname', '$email', '$lname',
                (SELECT frid from faculty_roles 
                WHERE faculty_roles.roles = '$role'),$office, '$phone');


/*
show all classes a professor is enrolled into based on last name and
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
        INNER JOIN faculty AS g ON e.facultyID = g.fid AND g.lname = '$fname'
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