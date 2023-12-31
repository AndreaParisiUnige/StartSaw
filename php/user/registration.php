<?php
require_once '../structure/header.php';
exitIfLogged($con);

if ($_SERVER["REQUEST_METHOD"] === "POST") {

	checkNotEmptyParams($_POST["firstname"], $_POST["lastname"], $_POST["email"], $_POST["pass"], $_POST["confirm"]);
	validateEmail($_POST["email"]);
	validatePassword($_POST["pass"], $_POST["confirm"]);

	$hash =  password_hash(trim(($_POST["pass"])), PASSWORD_DEFAULT);
	$toInsert = [
		"id" => "NULL", 
		"nome" => $_POST["firstname"], 
		"cognome" => $_POST["lastname"], 
		"email" => trim($_POST["email"]), 
		"password" => $hash,
		"registration_date" => NULL,
		"admin" => 0
	];

	try {
		if (generic_Insert("users", $toInsert, $con)) {
			$_SESSION['message'] = 'Registrazione completata';
			header("Location: ../user/login.php");
			exit;
		}
	} catch (Exception $e) {
		$_SESSION['error_message'] = "Errore: qualcosa è andato storto, si prega di riprovare più tardi";
		error_log("Failed to insert ". ($_POST["email"]). " data into the database: " . $e->getMessage() . "\n", 3, "error.log");
		reloadPage();
	}
	mysqli_close($con);
	exit;
}
?>

<div class="main_content">
	<form class="inputForm" id="form" action="registration.php" method="post" novalidate>
		<input hidden type="text" id="sectionTitle" value="Registrazione">
		<div class="input-control">
			<label for="firstname">Nome:</label>
			<input type="text" id="firstname" name="firstname" placeholder="Enter your name">
		</div>

		<div class="input-control">
			<label for="lastname" class="label">Cognome:</label>
			<input type="text" id="lastname" name="lastname" placeholder="Enter your surname">
		</div>

		<div class="input-control">
			<label for="email" class="label">Email:</label>
			<input type="email" id="email" name="email" placeholder="Enter your email" >
		</div>

		<div class="input-control">
			<label for="pass" class="label">Password:</label>
			<input type="password" id="pass" name="pass" placeholder="Enter your password">
		</div>

		<div class="input-control">
			<label for="confirm" class="label">Conferma password:</label>
			<input type="password" id="confirm" name="confirm" placeholder="Confirm your password">
		</div>
		<button class="responsive small small-elevate" id="submit_button" type="submit">Registrati</button>
	</form>
</div>

<script defer src="../../js/validateInput.js"></script>

<?php
require_once '../structure/footer.php';
?>