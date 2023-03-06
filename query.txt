//Shows all students enrolled into a course.
//Give CRN from course and time range from time

SELECT student.fname, student.lname, student.email 
FROM enrollment 
JOIN student ON enrollment.studentID = student.sid 
JOIN class ON enrollment.classID = class.classID
JOIN time ON class.timeID = time.timeID
JOIN course ON course.courseID = class.courseID
WHERE course.CRN = 'CS 1314'
AND time.timeRange = '12:00-1:00PM';

//insert a student into the student table
//phone number and advisor are null by default the others must have a value

insert into student(fname, email, lname, major, classification)
values("FirstName", "Email", "LastName", "major", "classification")

//update information of a student
//we should query to get the sid of a student

update student
set fname = "NewName",
    email = "NewEmail",
    lname = "NewName",
    major = "NewMajor",
    classification = "NewClassification"
where sid in (select sid from student where email = "OldEmail");

//deleting a student and all instances of the student
//student is referenced in enrollment, student and student password
//!!!NEVER run a delete query with out a where clause if you do all records will be deleted

delete from enrollment where studentID in (select sid from student where email = "StudentEmail");
delete from student_passwords where studentID in (select sid from student where email = "StudentEmail");
delete from student where sid in (select sid from student where email = "StudentEmail");

//insert faculty into faculty table
//all feilds are required and non are null
//roll and office are foreign key values of faculty_roles and location respectivly

insert into faculty(fname, email, lname, role, office)
valuse("FirstName", "Email", "LastName", roleNum, locationNum);

//


//Query a professors schedule 
SELECT DISTINCT c.courseTitle AS Course_Title,
            f.lname AS Instructor,        
            t.timerange AS Time,        
            d.days AS Meeting_Days,        
            dt.startDate AS Start_Date,        
            dt.endDate AS End_Date,        
            r.roomNum AS Room 
        FROM course AS c INNER JOIN class AS cl ON c.courseID = cl.courseID 
        INNER JOIN enrollment AS e ON cl.classID = e.classID 
        INNER JOIN faculty AS g ON e.facultyID = g.fid AND g.lname = 'Zhao'
        INNER JOIN enrollment AS z ON cl.classID = z.classID AND z.facultyID = g.fid
        INNER JOIN faculty AS f ON z.facultyID = f.fid 
        INNER JOIN time AS t ON cl.timeID = t.timeID 
        INNER JOIN day AS d ON cl.dayID = d.daysID 
        INNER JOIN date AS dt ON cl.dateID = dt.dateID 
        INNER JOIN location AS l ON cl.locationID = l.locationID 
        INNER JOIN rooms AS r ON l.roomID = r.roomID;
