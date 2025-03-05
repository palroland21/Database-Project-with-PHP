<?php
session_start();

// Verifica daca utilizatorul NU este autentificat
if (!isset($_SESSION['logat']) || $_SESSION['logat'] !== true) {
    // Redirectioneaza catre pagina de login
    header("Location: login.html");
    exit;
}
?>

<html>
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Proiect PAL ROLAND</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background-color: #f4f4f9;
    }
    header {
      background: #007BFF;
      color: black;
      padding: 1rem 0;
      text-align: center;
    }
    header h1 {
      margin: 0;
      font-size: 50px;
    }
    main {
      padding: 2rem;
      max-width: 800px;
      margin: 0 auto;
      background: #ffffff;
      border-radius: 30px;
    }
    h2 {
      color: #007BFF;
      border-bottom: 2px solid #007BFF;
    }
    form {
      margin-bottom: 20px;
    }

	.logout-btn {
    float: right;
    background-color: #FF4C4C;
    color: white;
    padding: 0.5rem 1rem;
    border-radius: 5px;
    font-size: 1rem;
    text-decoration: none;
    margin-top: -25px;
	margin-right: 5px;
}
	
    .logout-btn:hover {
      background-color: #D03434;
    }
	
    input[type="number"], select {
      width: 100%;
      padding: 0.5rem;
      margin: 0.5rem 0;
      border: 1px solid #ddd;
      border-radius: 5px;
    }

    input[type="submit"] {
      background: #007BFF;
      color: white;
      border: none;
      padding: 0.5rem 1rem;
      border-radius: 5px;
      font-size: 1rem;
    }
	
    input[type="submit"]:hover {
      background: #0056b3;
    }
	
    footer {
      text-align: center;
      padding: 0.1rem;
      background: #007BFF;
      color: black;
	  font-weight: bold;
      width: 100%;
    }
  </style>
</head>
<body>

<header>
  <h1>Interogari</h1>
  <a href="logout.php" class="logout-btn">Logout</a>
</header>

<main>
  <h2>Exercitiul 3.a</h2>
  <form action="codulPHP.php" method="post">
    <label>Raspunsurile pentru intrebarile cu id_i intre [1,3] si cu id_t:</label>
    <input type="number" name="id_t" max="999" min="0" required>
    <input type="submit" name="submit_3a" value="Trimite Interogarea 3.a">
  </form>

  <h2>Exercitiul 3.b</h2>
  <form action="codulPHP.php" method="post">
    <label>Gaseste id_t si data, ordonat crescator dupa data, pentru testele din anul 2024 din semestrul:</label>
    <select name="semestrul" required>
      <option value="1">Semestrul 1</option>
      <option value="2">Semestrul 2</option>
    </select>
    <input type="submit" name="submit_3b" value="Trimite Interogarea 3.b">
  </form>

  <h2>Exercitiul 4.a</h2>
  <form action="codulPHP.php" method="post">
    <label>Interogare care extrage raspunsurile model si raspunsurile date la intrebare cu punctaj obtinut:</label>
    <input type="number" name="pct_obtinut" max="999" min="0" required>
    <input type="submit" name="submit_4a" value="Trimite Interogarea 4.a">
  </form>

  <h2>Exercitiul 4.b</h2>
  <form action="codulPHP.php" method="post">
    <label>Interogare care gaseste perechile de teste (id_t1, id_t2) care au cel putin o intrebare identica in cele doua teste si sa aiba acelasi punctaj:</label>
    <input type="submit" name="submit_4b" value="Trimite Interogarea 4.b">
  </form>

  <h2>Exercitiul 5.a</h2>
  <form action="codulPHP.php" method="post">
    <label>Interogare care gaseste raspunsurile valide la testul cu identificatorul:</label>
    <input type="number" name="test_id" max="999" min="0" required>
    <input type="submit" name="submit_5a" value="Trimite Interogarea 5.a">
  </form>

  <h2>Exercitiul 5.b</h2>
  <form action="codulPHP.php" method="post">
    <label>Interogare care gaseste testele pentru care s-au dat toate raspunsurile la toate intrebarile:</label>
    <input type="submit" name="submit_5b" value="Trimite Interogarea 5.b">
  </form>

  <h2>Exercitiul 6.a</h2>
  <form action="codulPHP.php" method="post">
    <label>Interogare care gaseste pentru fiecare test numarul de intrebari si punctajul total:</label>
    <input type="submit" name="submit_6a" value="Trimite Interogarea 6.a">
  </form>

  <h2>Exercitiul 6.b</h2>
  <form action="codulPHP.php" method="post">
    <label>Interogare care gaseste intrebarile cu valoarea maxima a raportului intre suma punctajului si nr de teste in care apare intrebarea:</label>
    <input type="submit" name="submit_6b" value="Trimite Interogarea 6.b">
  </form>
</main>

<footer>
  <p>Proiect realizat de PAL ROLAND</p>
</footer>

</body>
</html>
