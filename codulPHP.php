<html>
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
</html>




<?php

// Conectarea la baza de date
$servername = "localhost"; 
$username = "student"; 
$password = "student"; 
$dbname = "chestionare"; 

// Crearea conexiunii
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificarea conexiunii
if ($conn->connect_error) {
    die("Conexiune esuata: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
	
    // 3.a) Procesare pentru interogarea 3.a
    if (isset($_POST['submit_3a'])) {
        $id_t = $_POST['id_t'];

        if (!empty($id_t)) {
            $sql1 = "CALL GetRaspunsuri(?)";

            // Pregatirea interogarii
            if ($stmt1 = $conn->prepare($sql1)) {
                $stmt1->bind_param("i", $id_t);
                $stmt1->execute();
                $result1 = $stmt1->get_result();

				if ($result1->num_rows > 0) {
					echo "<h2>Raspunsurile pentru intrebarile cu id_i intre [1,3] si cu id_t = $id_t:</h2>";
					echo "<table border='1'><tr><th>ID intrebare</th><th>Raspunsul</th></tr>";
					while ($row = $result1->fetch_assoc()) {
						echo "<tr><td>" . $row['ID intrebare'] . "</td><td>" . $row['Raspunsul'] . "</td></tr>";
					}
					echo "</table>";

					$stmt1->close();
				} else {
					echo "<h2>Nu exista date pentru id_t = $id_t!</h2>";
				}
			echo "<a href=\"index.php\">Inapoi la pagina principala</a>";
        }
    }
	}

    // 3.b) Procesare pentru interogarea 3.b
    if (isset($_POST['submit_3b'])) {
        $semestrul = $_POST['semestrul'];

        if (!empty($semestrul)) {
            // Seteaza intervalul de date in functie de semestrul selectat
             $start_date = ($semestrul == 1) ? '2024-01-01' : '2024-07-01';
             $end_date = ($semestrul == 1) ? '2024-06-30' : '2024-12-31';

            $sql2 = "CALL GetTesteSemestru(?, ?)";

            // Pregatirea interogarii
            if ($stmt2 = $conn->prepare($sql2)) {
                $stmt2->bind_param("ss", $start_date, $end_date);
                $stmt2->execute();
                $result2 = $stmt2->get_result();

				if ($result2->num_rows > 0) {
					echo "<h2>Testele din semestrul $semestrul din 2024:</h2>";
					echo "<table border='1'><tr><th>ID Test</th><th>Data</th></tr>";
					while ($row = $result2->fetch_assoc()) {
						echo "<tr><td>" . $row['id_t'] . "</td><td>" . $row['data'] . "</td></tr>";
					}
					echo "</table>";

					$stmt2->close();
				}
				else {
					echo "<h2>Nu exista date!</h2>";
				}
            }
			echo "<a href=\"index.php\">Inapoi la pagina principala</a>";
        }
    }

	
	// 4.a) Procesare pentru interogarea 4.a
	if (isset($_POST['submit_4a'])) {
		$pct_obt = $_POST['pct_obtinut'];
		$corect_value = ($pct_obt == 0) ? 'N' : 'D'; // Seteaza "corect" pe baza pct_obt

		$sql4a = "CALL GetRaspunsuriModel(?, ?)";

		if ($stmt4a = $conn->prepare($sql4a)) {
			$stmt4a->bind_param("is", $pct_obt, $corect_value); // Legatura parametrilor: 'i' pentru intreg, 's' pentru string
			$stmt4a->execute();
			$result4a = $stmt4a->get_result();

			if ($result4a->num_rows > 0) {
				echo "<h2>Raspunsuri model si raspunsuri date cu punctaj obtinut = $pct_obt:</h2>";
				echo "<table border='1'><tr><th>ID_T (Nr. Test)</th><th>ID_I (Nr. Intrebare)</th><th>Raspunsul Model</th><th>Raspuns dat</th></tr>";
				while ($row = $result4a->fetch_assoc()) {
					echo "<tr><td>" . $row['id_t'] . "</td><td>" . $row['id_i'] . "</td><td>" . $row['Raspunsul Model'] . "</td><td>" . $row['Raspuns dat'] . "</td></tr>";
				}
				echo "</table>";
			} else {
				echo "<h2>Punctajul obtinut poate fi doar '1' sau '0'. Ati adaugat valoarea $pct_obt.</h2>";
			}
			echo "<a href=\"index.php\">Inapoi la pagina principala</a>";
			$stmt4a->close();
		}
	}

    // 4.b) Procesare pentru interogarea 4.b
	if (isset($_POST['submit_4b'])) {
		$sql4b = "CALL GetPerechiTeste()";

		if ($stmt4b = $conn->prepare($sql4b)) {
			$stmt4b->execute();
			$result4b = $stmt4b->get_result();
			echo "<h2>Perechi de teste cu o intrebare comuna si acelasi punctaj:</h2>";
			echo "<table border='1'><tr><th>Test 1</th><th>Test 2</th></tr>";
			while ($row = $result4b->fetch_assoc()) {
				echo "<tr><td>" . $row['Test1'] . "</td><td>" . $row['Test2'] . "</td></tr>";
			}
			echo "</table>";

			$stmt4b->close();
		} else {
			echo "Eroare la pregătirea interogării: " . $conn->error;
		}
		echo "<a href=\"index.php\">Inapoi la pagina principala</a>";
	}
	
	// 5.a) Interogare care gaseste raspunsurile valide la testul cu identificatorul dat.
	if(isset($_POST['submit_5a'])){
		$test_id = $_POST['test_id'];
		
		$sql5a = "CALL GetRaspunsuriCorecte(?)";
	
	if($stmt5a = $conn->prepare($sql5a)){
		$stmt5a->bind_param("i", $test_id);
		$stmt5a->execute();
		$result5a = $stmt5a->get_result();
		
			if($result5a->num_rows > 0) {
				echo "<h2>Raspunsurile corecte pentru testul cu identificatorul $test_id </h2>";
				echo "<table border =2><tr><td>Testul</td><td>Intrebarea</td><td>Raspunsul</td></tr>";
				while($row = $result5a->fetch_assoc()) {
					echo "<tr><td>" . $row['Testul'] . "</td><td>" . $row['Intrebarea'] . "</td><td>" . $row['Raspunsul'] . "</td></tr>";
				}
				echo "</table>";
				
				$stmt5a->close();
			}
			else {
				echo "<h2>Nu exista niciun rezultat pentru $test_id.</h2>";
			}
			echo "<a href=\"index.php\">Inapoi la pagina principala</a>";
		}
	}

	
	// 5.b) Interogare care gaseste testele pentru care s-au dat toate raspunsurile la toate intrebarile
	if(isset($_POST['submit_5b'])) {
	   $sql5b = "CALL GetTesteCompletRaspunse()";	
				
	   if($stmt5b = $conn->prepare($sql5b)){
		   $stmt5b->execute();
		   $result5b = $stmt5b->get_result();
		   
		   if($result5b->num_rows > 0) {
			   echo "<h2>Testele la care s-au raspuns la toate intrebarile</h2>";
			   echo "<table border=1><tr><td>Testul</td></tr>";
			   while($row = $result5b->fetch_assoc()){
				   echo "<tr><td>" . $row['id_t'] . "</td></tr>";
			   }
			   echo "</table>";
			   $stmt5b->close();
		   } else {
			   echo "<h2>Nu exista teste la care s-au raspuns la toate intrebarile!";
		   }
		   echo "<a href=\"index.php\">Inapoi la pagina principala</a>";
	   }			
	}
	
	
	
	// 6.a) Interogare care gaseste pentru fiecare test numarul de intrebari si punctajul total.
	if(isset($_POST['submit_6a'])) {
	   $sql6a = "CALL GetNrIntrebariSiPunctajTotal()";	
				
	   if($stmt6a = $conn->prepare($sql6a)){
		   $stmt6a->execute();
		   $result6a = $stmt6a->get_result();
		   
		   if($result6a->num_rows > 0) {
			   echo "<h2>Gasirea pentru fiecare test numarul de intrebari si punctajul total obtinut</h2>";
			   echo "<table border=1><tr><td>ID Test</td><td>Nr. Intrebari</td><td>Total puncte</td></tr>";
			   while($row = $result6a->fetch_assoc()){
				   echo "<tr><td>" . $row['ID Test'] . "</td><td>" . $row['Nr Intrebari'] . "</td><td>"  . $row['Total puncte'] . "</td></tr>";
			   }
			   echo "</table>";
			   $stmt6a->close();
		   } else {
			   echo "<h2>Nu exista teste!";
		   }
		   echo "<a href=\"index.php\">Inapoi la pagina principala</a>";
	   }			
	}
	

	// 6.b) Interogare care gaseste intrebarile cu valoarea maxima a raportului intre suma punctajului si nr de teste in care apare intrebarea
	if(isset($_POST['submit_6b'])) {
	   $sql6b = "CALL GetIntrebariCuRaportMaxim()";	
				
	   if($stmt6b = $conn->prepare($sql6b)){
		   $stmt6b->execute();
		   $result6b = $stmt6b->get_result();
		   
		   if($result6b->num_rows > 0) {
			   echo "<h2>Gasirea intrebarilor cu valoarea maxima a raportului intre suma punctajului si nr de teste in care apare intrebarea</h2>";
			   echo "<h3>Afisat in ordinea descrescatoare in functie de raport</h3>";
			   echo "<table border=1><tr><td>ID Intrebare</td><td>Raportul</td></tr>";
			   while($row = $result6b->fetch_assoc()){
				   echo "<tr><td>" . $row['id_i'] . "</td><td>" . $row['raport_maxim'] . "</td></tr>";
			   }
			   echo "</table>";
			   $stmt6b->close();
		   } else {
			   echo "<h2>Nu exista teste!";
		   }
		   echo "<a href=\"index.php\">Inapoi la pagina principala</a>";
	   }			
	}
	
}
$conn->close();
?>