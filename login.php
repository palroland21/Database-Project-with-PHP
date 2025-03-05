<style>

   a {
	display: block;
	width: 15%;
	text-align: center;
	margin-top: 20px;
	background: #FFFFCC;
	color: black;
    font-weight: bold;
	border: 1px solid;
	border-radius: 5px;
	padding: 2px;
	align: center;
	text-decoration: none;
   }
   
   a:hover {
	background: #00FF80;
   }

</style>
<?php
session_start();

// Conectare la baza de date
$servername = "localhost";
$username = "student";
$password = "student";
$dbname = "chestionare";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Conexiune esuata: " . $conn->connect_error);
}

// Preluare date din formular
$nume = $_POST['nume'];
$parola = $_POST['parola'];

// Verificare utilizator
$sql = "SELECT parola FROM acces WHERE nume = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $nume);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    if ($row['parola'] == $parola) {
        // Setam sesiunea
        $_SESSION['logat'] = true;
        $_SESSION['nume'] = $nume;
        header("Location: index.php");
        exit;
    } else {
        echo "Parola este incorecta!";
		echo "<a href=\"login.html\">Inapoi la pagina principala</a>";
    }
} else {
    echo "Utilizatorul nu exista!";
	echo "<a href=\"login.html\">Inapoi la pagina principala</a>";
}

$stmt->close();
$conn->close();
?>
