<?php
    session_start();
    if(isset($_SESSION['zalogowany'])){
        if($_SESSION['zalogowany']==true)
        {
            header('Location: index.php');
        }
    }
?>


<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Dobre ładowarki samochodowe</title>
    <link rel="shortcut icon" href="favicon.png" type="image/png">
    <link rel="stylesheet" type="text/css" href="style.css">

</head>

<body class="body">
    <Header class="header">
        <h1 id="naglowek">Osadnicy</h1>
    
    </Header>

    <div class="container">
        <main>
        <h2>Rejestracja</h2>
        <div id="formularz">
    <form action="zarejestruj.php" method="POST">
      <ul class="flex">
        <li class="form-group">
          <label for="fName">Imie:</label>
          <input type="text" name="fName" size=20 maxsize=30 required /><br />
        </li>
        <li class="form-group">
          <label for="lName">Nazwisko:</label>
          <input type="text" name="lName" size=20 maxsize=30 required /><br />
        </li>
        <li class="form-group">
          <label for="email">Email:</label>
          <input type="email" name="email" size=20 maxsize=50 required /><br />
        </li>
        <li class="form-group">
          <label for="uName">Nazwa u&#380;ytkownika:</label>
          <input type="text" name="uName" size=20 maxsize=30 required /><br />
        </li>
        <li class="form-group">
          <label for="pass">Has&#322;o:</label>
          <input type="password" name="pass" size=20 maxsize=50 required /><br />
        </li>
        <li class="form-group">
          <label for="rpass">Powt&#243;rzone has&#322;o:</label>
          <input type="password" name="rpass" size=20 maxsize=50 required /><br />
        </li>
        <li class="form-group">
          <button type="submit" name="rejestracja" id="przycisk" >Zarejestruj</button>
        </li>
        <li class="form-group">
          <p>
            Masz ju&#380; konto?
            <a href="logowanie.php">Logowanie</a>
          </p>
        </li>
      </ul>
    </form>
  </div>
        </main>
    </div>


    <footer class="footer">
        <p><div id="tekst"></div> Filip Sawicki 2022</p>
        <p id="nazwafirmy"></p>
        <p id="dane"></p>

    </footer>
    
</body>

</html>