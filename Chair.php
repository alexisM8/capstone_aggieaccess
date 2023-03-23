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
			padding-left: 40px;
			box-shadow: 0 0 10px rgba(0, 0, 0, 0.3);
			background-color: #009688;
			
            overflow-y: scroll;
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
			margin-left: 450px;
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
		<li><h1>Chair</h1></li>
		<li><a href="?page=Home" class="<?php if (isset($_GET['page']) && $_GET['page'] === 'Home')
						echo 'active'; ?>">Home Page</a></li>
		<li><a href="?page=ListCsStudent" class="<?php if(isset($_GET['page']) && $_GET['page'] === 'ListCsStudent') echo 'active'; ?>">Computer Science Student List</a></li>
		<li><a href="?page=ListItStudent" class="<?php if(isset($_GET['page']) && $_GET['page'] === 'ListItStudent') echo 'active'; ?>">IT Student List</a></li>
		<li><a href="?page=AssignAdvisor" class="<?php if(isset($_GET['page']) && $_GET['page'] === 'AssignAdvisor') echo 'active'; ?>">Assign Advisor</a></li>
		<li><a href="?page=ListAdvisor" class="<?php if(isset($_GET['page']) && $_GET['page'] === 'ListAdvisor') echo 'active'; ?>">List Advisor</a></li>
		<li><a href="?page=ClassListing" class="<?php if(isset($_GET['page']) && $_GET['page'] === 'ClassListing') echo 'active'; ?>">Find Class Listing</a></li>
        <li><a href="?page=ListTeachingSchedule" class="<?php if(isset($_GET['page']) && $_GET['page'] === 'ListTeachingSchedule') echo 'active'; ?>">List Teaching Schedule</a></li>
		<li><a href="?page=EnrollStudent" class="<?php if(isset($_GET['page']) && $_GET['page'] === 'EnrollStudent') echo 'active'; ?>">Enroll a Student</a></li>
		<li><a href="?page=ContactStudent" class="<?php if(isset($_GET['page']) && $_GET['page'] === 'ContactStudent') echo 'active'; ?>">Contact Student</a></li>
		<li><a href="?page=ContactTeacher" class="<?php if(isset($_GET['page']) && $_GET['page'] === 'ContactTeacher') echo 'active'; ?>">Contact Teacher</a></li>
		<li><a href="?page=GrantOverride" class="<?php if(isset($_GET['page']) && $_GET['page'] === 'GrantOverride') echo 'active'; ?>">Grant Override</a></li>
		<li><a href="?page=logout" class="<?php if(isset($_GET['page']) && $_GET['page'] === 'logout') echo 'active'; ?>">Logout</a></li>
	</ul>
</nav>

    <main>
		<?php if (isset($_GET['page'])) {
			if ($_GET['page'] === 'Home')include('chair/Home.php');
			elseif ($_GET['page'] === 'ListCsStudent')
				include('chair/ListCsStudent.php');
			elseif ($_GET['page'] === 'ListItStudent')
				include('chair/ListItStudent.php');
			elseif ($_GET['page'] === 'AssignAdvisor')
				include('chair/AssignAdvisor.php');
			elseif ($_GET['page'] === 'ListAdvisor')
				include('chair/ListAdvisor.php');
			elseif ($_GET['page'] === 'ClassListing')
				include('chair/ClassListing.php');
			elseif ($_GET['page'] === 'ListTeachingSchedule')
				include('chair/ListTeachingSchedule.php');
			elseif ($_GET['page'] === 'EnrollStudent')
				include('chair/EnrollStudent.php');
			elseif ($_GET['page'] === 'ContactStudent')
				include('chair/ContactStudent.php');
			elseif ($_GET['page'] === 'ContactTeacher')
				include('chair/ContactTeacher.php');
			elseif ($_GET['page'] === 'GrantOverride')
				include('chair/GrantOverride.php');
				
			elseif ($_GET['page'] === 'logout')
				include('chair/logout.php');
		} ?>
	</main>
</body>
</html>
