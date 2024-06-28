<!-- <!DOCTYPE html> -->
<html lang="en">
<head>
	<title>Register</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!-- <link rel="icon" type="image/png" href="images/icons/favicon.ico"/> -->
	<!-- <link rel="stylesheet" type="text/css" href="vendor/bootstrap/css/bootstrap.min.css"> -->
	<!-- <link rel="stylesheet" type="text/css" href="vendor/animate/animate.css"> -->
	<!-- <link rel="stylesheet" type="text/css" href="vendor/css-hamburgers/hamburgers.min.css"> -->
	<!-- <link rel="stylesheet" type="text/css" href="vendor/animsition/css/animsition.min.css"> -->
	<!-- <link rel="stylesheet" type="text/css" href="vendor/select2/select2.min.css"> -->
	<!-- <link rel="stylesheet" type="text/css" href="vendor/daterangepicker/daterangepicker.css"> -->
	<link rel="stylesheet" type="text/css" href="Login_assets/fonts/font-awesome-4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" type="text/css" href="Login_assets/css/main.css">
	<link rel="stylesheet" type="text/css" href="Login_assets/css/util.css">
 
</head>
<body>
    
    <?php
    // require_once('connection.php');

    // if ($_SERVER["REQUEST_METHOD"] == "POST") {
	// 	$usrname = $_POST['username'];
	// 	$contactNo = $_POST['contactno'];
	// 	$email = $_POST['email'];
	// 	$passwrd = $_POST['pass'];
	
	// 	$stmt = $conn->prepare("INSERT INTO register_user (username, contactno, email, pass) VALUES (?, ?, ?, ?)");
	// 	$stmt->bind_param("ssss", $usrname, $contactNo, $email, $passwrd);
    //     if (!($stmt->execute())) {
    //         echo "Error: <br>" . $stmt->error;
    //     }
	// 	$stmt->close();
	// 	header("Location: homepage.php");
    // 	exit();	
    // }
	// $conn->close();
	require_once('connection.php');

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $usrname = $_POST['username'];
        $contactNo = $_POST['contactno'];
        $email = $_POST['email'];
        $passwrd = $_POST['pass'];

        // Check if email already exists in the database
        $checkEmailQuery = "SELECT * FROM register_user WHERE email = ?";
        $checkStmt = $conn->prepare($checkEmailQuery);
        $checkStmt->bind_param("s", $email);
        $checkStmt->execute();
        $checkResult = $checkStmt->get_result();

        if ($checkResult->num_rows > 0) {
            // Email already exists, show alert
            echo "<script>alert('User already exists');</script>";
			echo "<script>window.location.href='loginPage.php';</script>";
        } else {
            // Email doesn't exist, proceed with insertion
            $insertQuery = "INSERT INTO register_user (username, contactno, email, pass) VALUES (?, ?, ?, ?)";
            $stmt = $conn->prepare($insertQuery);
            $stmt->bind_param("ssss", $usrname, $contactNo, $email, $passwrd);
            
            if ($stmt->execute()) {
                // Insertion successful, redirect to homepage
                header("Location: ./HomePage/index.html");
                exit();
            } else {
                // Insertion failed, show error
                echo "Error: <br>" . $stmt->error;
            }
            $stmt->close();
        }
        $checkStmt->close();
    }
    $conn->close();
    ?>
	<div class="headingClass">
        <div class="patterns">
            <svg width="100%" height="100%">
                <rect x="0" y="0" width="100%" height="1000%" fill="url(#polka-dots)"> </rect>
                <text x="50%" y="60%"  text-anchor="middle">
                    ExpenseGraphica
                </text>
            </svg>
        </div>
    </div>
	<div class="limiter">
		<div class="container-login100">
			<div class="wrap-login100">
				<form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post" class="login100-form validate-form p-l-55 p-r-55 p-t-160">
					<span class="login100-form-title">
						Register
					</span>

					<div class="wrap-input100 validate-input m-b-16" data-validate="Please enter username">
						<input class="input100" type="text" name="username" placeholder="Username">
						<span class="focus-input100"></span>
					</div>

                    <div class="wrap-input100 validate-input m-b-16" data-validate="Please enter contact no">
						<input class="input100" type="text" name="contactno" placeholder="Contact No">
						<span class="focus-input100"></span>
					</div>

                    <div class="wrap-input100 validate-input m-b-16" data-validate="Please enter email">
						<input class="input100" type="text" name="email" placeholder="E-mail">
						<span class="focus-input100"></span>
					</div>

					<div class="wrap-input100 validate-input" data-validate = "Please enter password">
						<input class="input100" type="password" name="pass" placeholder="Password">
						<span class="focus-input100"></span>
					</div>

					<div class="container-login100-form-btn m-t-50">
						<button class="login100-form-btn" type="submit">
							Sign in
						</button>
					</div>

					<div class="flex-col-c p-t-100 p-b-40">
						<span class="txt1 p-b-9">
							Already have an account?
						</span>

						<a href="loginPage.php" class="txt3">
							Login
						</a>
					</div>
				</form>
			</div>
		</div>
	</div>

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
