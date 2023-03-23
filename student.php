<!DOCTYPE html>
<html>

<head>
	<title>Student Enrollment</title>
	<style>
		body {
			margin: 20;
			padding: 0;
			font-family: Arial, sans-serif;
		}

		nav {
			position: fixed;
			top: 0;
			left: 0;
			width: 200px;
			height: 100%;
			background-color: #f1f1f1;
			padding: 20px;
			box-shadow: 0 0 10px rgba(0, 0, 0, 0.3);
			background-color: #009688;
		}

		nav ul {
			list-style: none;
			padding: 0;
			margin: 0;
		}

		nav li {
			margin-bottom: 10px;

		}

		nav h1 {

			padding: 10px;
		}

		nav a {
			display: block;
			padding: 10px;
			color: #333;
			text-decoration: none;
			transition: background-color 0.3s ease;
			border-radius: 20px;
		}

		nav a:hover {
			background-color: #ccc;
		}

		nav a.active {
			background-color: #ddd;
		}

		/* Main content styles */
		main {
			margin-left: 220px;
			padding: 20px;
		}

		/* Page title styles */
		h1 {
			margin-top: 0;
			font-size: 36px;
			text-align: center;
		}

		/* Table styles */
		table {
			width: 100%;
			border-collapse: collapse;
			margin-bottom: 20px;
		}

		th,
		td {
			padding: 10px;
			text-align: left;
			border: 1px solid #ccc;
		}

		th {
			background-color: #009688;
			color: #fff;
		}

		/* Form styles */
		form {
			width: 80%;
			margin: 0 auto;
			border: 1px solid #ccc;
			padding: 20px;
			border-radius: 10px;
		}

		h2 {
			margin-left: 400px;
			

		}

		label {
			display: block;
			margin-bottom: 10px;
		}

		input[type="text"],
		input[type="email"],
		input[type="password"],
		select,
		textarea {
			width: 100%;
			padding: 10px;
			margin-bottom: 20px;
			border: 1px solid #ccc;
			border-radius: 5px;
		}

		input[type="submit"] {
			background-color: #009688;
			color: #fff;
			border: none;
			padding: 10px 20px;
			border-radius: 5px;
			cursor: pointer;
			transition: all 0.3s ease;
		}

		button {
			background-color: #009688;
			color: #fff;
			border: none;
			padding: 10px 20px;
			border-radius: 5px;
			cursor: pointer;
			transition: all 0.3s ease;
		}

		.print_btn{
        margin-top: 10px;
        float: right;
    	}

		input[type="submit"]:hover {
			background-color: #fff;
			color: #009688;
		}
	</style>
</head>

<body>
	<nav>
		<ul>
			<li>
				<h1>Student</h1>
			</li>
			<li><a href="?page=Home" class="<?php if (isset($_GET['page']) && $_GET['page'] === 'Home')
				echo 'active'; ?>">Home Page</a></li>
			<li><a href="?page=studentadviser" class="<?php if (isset($_GET['page']) && $_GET['page'] === 'studentadviser')
				echo 'active'; ?>">Contact
					Adviser</a></li>
			<li><a href="?page=studentschedule" class="<?php if (isset($_GET['page']) && $_GET['page'] === 'studentschedule')
				echo 'active'; ?>">View
					Schedule</a></li>
			<li><a href="?page=studentscourseenrollemnt" class="<?php if (isset($_GET['page']) && $_GET['page'] === 'studentscourseenrollemnt')
				echo 'active'; ?>">Request
					A Pin</a></li>
			<li><a href="?page=studentEnrollclasses" class="<?php if (isset($_GET['page']) && $_GET['page'] === 'studentEnrollclasses')
				echo 'active'; ?>">Enroll
					A Class</a></li>
			
			<li><a href="?page=logout" class="<?php if (isset($_GET['page']) && $_GET['page'] === 'logout')
				echo 'active'; ?>">Logout</a>
			</li>

		</ul>
	</nav>
	<main>
		<?php if (isset($_GET['page'])) {
			if ($_GET['page'] === 'Home')
				include('student/Home.php');
			elseif ($_GET['page'] === 'studentadviser')
				include('student/studentadviser.php');
			elseif ($_GET['page'] === 'studentcourses')
				include('student/studentcourses.php');
			elseif ($_GET['page'] === 'studentscourseenrollemnt')
				include('student/studentscourseenrollemnt.php');
			elseif ($_GET['page'] === 'studentEnrollclasses')
				include('student/studentEnrollclasses.php');
			elseif ($_GET['page'] === 'studentschedule')
				include('student/studentschedule.php');
			elseif ($_GET['page'] === 'logout')
				include('student/logout.php');
		} ?>
	</main>
</body>

</html>