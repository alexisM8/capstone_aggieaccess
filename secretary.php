
<!DOCTYPE html>
<html>
<head>
	<title>Secretary</title>
	<style>
		body {
			margin: 20;
			padding: 0;
			font-family: Arial, sans-serif;
			background-color: #f2f2f2;
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
			background-color: #000000;
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
			color: #FEC52E;
			text-decoration: none;
			transition: background-color 0.3s ease;
			border-radius: 20px;
		}

		nav a:hover {
			background-color: #ccc;
			text-shadow: #000000 1px 1px;
		}

		nav a.active {
			background-color: #ddd;
			text-shadow: #000000 1px 1px;
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
			border: 1px solid #000000;
		}

		th {
			background-color: #FEC52E;
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
			background-color: #000000;
			color: #fff;
			border: none;
			padding: 10px 20px;
			border-radius: 5px;
			cursor: pointer;
			transition: all 0.3s ease;
		}

		button {
			background-color: #000000;
			color: #fff;
			border: none;
			padding: 10px 20px;
			border-radius: 5px;
			cursor: pointer;
			transition: all 0.3s ease;
			margin-left: 450px;
		}

		button:hover{
			background-color: #FEC52E;
			color: #000000;
		}

		input[type="submit"]:hover {
			background-color: #FEC52E;
			color: #000000;
		}
	</style>
</head>
<body>
	<nav>
        <ul>
		  <li><img src="Aggies.png" style="width: 175px; height: 100px;"></li>
		  <li><a href="?page=Home" class="<?php if (isset($_GET['page']) && $_GET['page'] === 'Home')
						echo 'active'; ?>">Home Page</a></li>
          <li><a href="?page=ListCsStudent" class="<?php if(isset($_GET['page']) && $_GET['page'] === 'ListcsStudent') echo 'active'; ?>">Computer Science Student List</a></li>
          <li><a href="?page=ListItStudent" class="<?php if(isset($_GET['page']) && $_GET['page'] === 'ListitStudent') echo 'active'; ?>">IT Student List</a></li>
          <li><a href="?page=LisrAdvisor" class="<?php if(isset($_GET['page']) && $_GET['page'] === 'ListAdvisor') echo 'active'; ?>">Advisor List</a></li>
          <li><a href="?page=ContactStudent" class="<?php if(isset($_GET['page']) && $_GET['page'] === 'ContactStudent') echo 'active'; ?>">Contact Student</a></li>
          <li><a href="?page=ContactTeacher" class="<?php if(isset($_GET['page']) && $_GET['page'] === 'ContactTeacher') echo 'active'; ?>">Contact Teacher</a></li>
          <li><a href="?page=logout" class="<?php if(isset($_GET['page']) && $_GET['page'] === 'logout') echo 'active'; ?>">Logout</a></li>
        </ul>
      </nav>
	  <main>
		<?php if (isset($_GET['page'])) {
			if ($_GET['page'] === 'Home')
			include('Secretary/Home.php');
			elseif ($_GET['page'] === 'ListCsStudent')
				include('Secretary/ListCsStudent.php');
			elseif ($_GET['page'] === 'ListItStudent')
				include('Secretary/ListItStudent.php');
			elseif ($_GET['page'] === 'LisrAdvisor')
				include('Secretary/LisrAdvisor.php');
			elseif ($_GET['page'] === 'ContactStudent')
				include('Secretary/ContactStudent.php');
			elseif ($_GET['page'] === 'ContactTeacher')
				include('Secretary/ContactTeacher.php');
			elseif ($_GET['page'] === 'logout')
				include('Secretary/logout.php');
		} ?>
	</main>





</body>
</html>
