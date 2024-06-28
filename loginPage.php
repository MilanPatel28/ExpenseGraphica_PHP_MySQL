<!-- <!DOCTYPE html> -->
<html lang="en">

<head>
	<title>Login</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!-- <link rel="icon" type="image/png" href="images/icons/favicon.ico"/> -->
	<!-- <link rel="stylesheet" type="text/css" href="vendor/bootstrap/css/bootstrap.min.css"> -->
	<!-- <link rel="stylesheet" type="text/css" href="vendor/animate/animate.css"> -->
	<!-- <link rel="stylesheet" type="text/css" href="vendor/css-hamburgers/hamburgers.min.css"> -->
	<!-- <link rel="stylesheet" type="text/css" href="vendor/animsition/css/animsition.min.css"> -->
	<!-- <link rel="stylesheet" type="text/css" href="vendor/select2/select2.min.css"> -->
	<!-- <link rel="stylesheet" type="text/css" href="vendor/daterangepicker/daterangepicker.css"> -->
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
	<link rel="stylesheet" type="text/css" href="Login_assets/fonts/font-awesome-4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" type="text/css" href="Login_assets/css/util.css">
	<link rel="stylesheet" type="text/css" href="Login_assets/css/main.css">

</head>

<body>
	<?php
	require_once('connection.php'); // Include your database connection code
	session_start(); // Start the session
	if ($_SERVER["REQUEST_METHOD"] == "POST") {
		$email = $_POST['email'];
		$password = $_POST['pass'];

		// Check if email exists in the database
		$checkEmailQuery = "SELECT * FROM register_user WHERE email = ?";
		$stmt = $conn->prepare($checkEmailQuery);
		$stmt->bind_param("s", $email);
		$stmt->execute();
		$result = $stmt->get_result();

		if ($result->num_rows > 0) {
			// Email exists, check if password matches
			$user = $result->fetch_assoc();
			if ($user['pass'] == $password) {
				$userId = $user['id']; // Assuming 'id' is the column name in the database
				$_SESSION['userId'] = $userId; // Store userId in a session variable
				// header("Location: Statement/statementPage.html");
				header("Location: HomePage/index.html");
				// header("Location: Expense_form/expenseform.php");
				exit();
				// $userId = "SELECT id FROM register_user WHERE email = $email";
				// Password matches, redirect to homepage
				// header("Location: homepage.php");
				// exit();
			} else {
				// echo "<script>
				// 	window.onload = function() {
				// 		var alertDiv = document.getElementById('alert-div');
				// 		alertDiv.innerHTML = 'Incorrect Password';
				// 	};					
				// 	</script>";
				echo "<script>
                window.onload = function() {
                    var alertDiv = document.getElementById('alert-div');
                    alertDiv.innerHTML = '<div class=\"alert alert-danger\" role=\"alert\">Incorrect Password</div>';
                };					
              	</script>";
			}
			// } else {
			// 	// Incorrect password, show alert and set email field
			// 	echo "<script>alert('Incorrect Password');</script>";
			// }
		} else {
			// User does not exist, show alert and redirect to signup page
			// echo "<script>alert('User does not exist. Register Yourself first.');</script>";
			echo "<script>
            window.onload = function() {
                var alertDiv = document.getElementById('alert-div');
                alertDiv.innerHTML = '<div class=\"alert alert-warning\" role=\"alert\">User does not exist. Register Yourself first.</div>';
            };
          </script>";
			// echo "<script>window.location.href='registerform.php';</script>";
			// exit();
		}
		$stmt->close();
	}
	$conn->close();
	?>
	<div class="headingClass">
		<div class="patterns">
			<svg width="100%" height="100%">
				<rect x="0" y="0" width="100%" height="1000%" fill="url(#polka-dots)"> </rect>
				<text x="50%" y="60%" text-anchor="middle">
					ExpenseGraphica
				</text>
			</svg>
		</div>
	</div>
	<div class="limiter">
		<div class="container-login100">
			<div class="wrap-login100">
				<form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" class="login100-form validate-form p-l-55 p-r-55 p-t-178">
					<span class="login100-form-title">
						Sign In
					</span>
					<div id="alert-div">
						<!-- <div class="alert alert-warning" role="alert">
							A simple warning alert—check it out!
						</div> -->
					</div>
					<div class="wrap-input100 validate-input m-b-16" data-validate="Please enter email">
						<input class="input100" type="email" name="email" id="email" placeholder="Email">
						<span class="focus-input100"></span>
					</div>

					<div class="wrap-input100 validate-input" data-validate="Please enter password">
						<input class="input100" type="password" name="pass" placeholder="Password">
						<span class="focus-input100"></span>
					</div>

					<div class="container-login100-form-btn m-t-50">
						<button class="login100-form-btn">
							Sign in
						</button>
					</div>

					<div class="flex-col-c p-t-170 p-b-40">
						<span class="txt1 p-b-9">
							Don't have an account?
						</span>

						<a href="registerform.php" class="txt3">
							Sign up now
						</a>
					</div>
				</form>
			</div>
		</div>
	</div>

	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
	<script src="Login_assets/vendor/jquery/jquery-3.2.1.min.js"></script>
	<script src="Login_assets/vendor/animsition/js/animsition.min.js"></script>
	<script src="Login_assets/vendor/bootstrap/js/popper.js"></script>
	<script src="Login_assets/vendor/bootstrap/js/bootstrap.min.js"></script>
	<script src="Login_assets/vendor/select2/select2.min.js"></script>
	<script src="Login_assets/vendor/daterangepicker/moment.min.js"></script>
	<script src="Login_assets/vendor/daterangepicker/daterangepicker.js"></script>
	<script src="Login_assets/vendor/countdowntime/countdowntime.js"></script>
	<script src="Login_assets/js/main.js"></script>
</body>

</html>