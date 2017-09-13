<?php 

die("<h1>Derzeit nicht verfügbar!</h1>"); ?>

<?php
/* Form Required Field Validation */
if ($_POST["register-user"] == "Registrieren") {
foreach($_POST as $key=>$value) {
	if(empty($_POST[$key])) {
	$error_message = "Du musst alle Felder ausfüllen";
	break;
	}
}
/* Password Matching Validation */
if($_POST['password'] != $_POST['confirm_password']){ 
$error_message = 'Die Passwörte sollten gleich sein!<br>'; 
}

/* Login Name Creator */
$login = $_POST["lastName"] . substr($_POST["firstName"], 0, 1);

/* Email Validation 
if(!isset($error_message)) {
	if (!filter_var($_POST["userEmail"], FILTER_VALIDATE_EMAIL)) {
	$error_message = "Invalid Email Address";
	}
}
*/

/* Validation to check if Terms and Conditions are accepted */
if(!isset($error_message)) {
	if(!isset($_POST["terms"])) {
	$error_message = "Du musst die Nutzungsbedingungen akzeptieren!";
	}
}

if(!isset($error_message)) {
	require_once("mysqlconn.php");
	$query = "INSERT INTO users (login, vorname, name, passwort) VALUES
	('" . $login . "', '" . $_POST["firstName"] . "', '" . $_POST["lastName"] . "', '" . password_hash($_POST["password"], PASSWORD_DEFAULT) . "')";
	$result = $userConn->query($query);
	if(!empty($result)) {
		$error_message = "";
		$success_message = "Du hast dich erfolgreich registriert!";	
		unset($_POST);
	} else {
		$error_message = "Es ist ein Problem aufgetreten. Bitte versuche es später nocheinmal!";	
	}
}

}
?>
<style>
.error-message {
	padding: 7px 10px;
	background: #fff1f2;
	border: #ffd5da 1px solid;
	color: #d6001c;
	border-radius: 4px;
}
.success-message {
	padding: 7px 10px;
	background: #cae0c4;
	border: #c3d0b5 1px solid;
	color: #027506;
	border-radius: 4px;
}
.demo-table {
	background: #d9eeff;
	width: 100%;
	border-spacing: initial;
	margin: 2px 0px;
	word-break: break-word;
	table-layout: auto;
	line-height: 1.8em;
	color: #333;
	border-radius: 4px;
	padding: 20px 40px;
}
.demo-table td {
	padding: 15px 0px;
}
.demoInputBox {
	padding: 10px 30px;
	border: #a9a9a9 1px solid;
	border-radius: 4px;
}
.btnRegister {
	padding: 10px 30px;
	background-color: #3367b2;
	border: 0;
	color: #FFF;
	cursor: pointer;
	border-radius: 4px;
	margin-left: 10px;
}
</style>

<form name="frmRegistration" method="post" action="">
	<table border="0" width="500" align="center" class="demo-table">
		<?php if(!empty($success_message)) { ?>	
		<div class="success-message"><?php if(isset($success_message)) echo $success_message; ?></div>
		<?php } ?>
		<?php if(!empty($error_message)) { ?>	
		<div class="error-message"><?php if(isset($error_message)) echo $error_message; ?></div>
		<?php } ?>
		<tr>
			<td>Vorname</td>
			<td><input type="text" class="demoInputBox" name="firstName" value="<?php if(isset($_POST['firstName'])) echo $_POST['firstName']; ?>"></td>
		</tr>
		<tr>
			<td>Nachname</td>
			<td><input type="text" class="demoInputBox" name="lastName" value="<?php if(isset($_POST['lastName'])) echo $_POST['lastName']; ?>"></td>
		</tr>
		<tr>
			<td>Passwort</td>
			<td><input type="password" class="demoInputBox" name="password" value=""></td>
		</tr>
		<tr>
			<td>Passwort wiederholen</td>
			<td><input type="password" class="demoInputBox" name="confirm_password" value=""></td>
		</tr>
		<tr>
			<td colspan=2>
			<input type="checkbox" name="terms"> Ich akzeptiere die <a target="agbs" href="/agbs">Nutzungsbedingungen</a> <input type="submit" name="register-user" value="Registrieren" class="btnRegister"></td>
		</tr>
	</table>
</form>