<?php
    session_start();
    if(isset($_SESSION['zalogowany'])){
      if($_SESSION['zalogowany']==true)
      {
          header('Location: index.php');
      }
  }
  //header('Location: logowanie.php');
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Osadnicy</title>
    <link rel="shortcut icon" href="favicon.png" type="image/png">
    <link rel="stylesheet" type="text/css" href="style.css">
    <script src="js/vue.js"></script>
    <script src="https://unpkg.com/vue@next"></script>
    <script
            src="https://ajax.googleapis.com/ajax/libs/angularjs/1.7.8/angular.min.js"></script>
            <script
            src="https://ajax.googleapis.com/ajax/libs/angularjs/1.7.8/angular-route.js"></script>
</head>

<body class="body">
    <Header class="header">
    <div class="tlo">
        <br>
        <div class="tresc_tlo">
            <div id="naglowek_na_tle">
            <h1 id="naglowek"> Osadnicy</h1>
            </div>
        </div>
        </div>  
    </Header>
    <div class="container">
        <h2>
        <?php
       if(isset($_SESSION['login'])){
        echo "Użytkownik  ". $_SESSION['login'];
        ?>
        <a href="wyloguj.php">Wyloguj się</a>
        <?php
        }
    ?>  
    </h2>
    </br>
        <main>
        <h2>Zaloguj się</h2>  
        <form action="zaloguj.php" method="POST">
      <ul class="flex">       
        <li class="form-group">
          <label for="uName">Nazwa u&#380;ytkownika:</label>
          <input type="text" name="uName" size=20 maxsize=30 required /><br />
        </li>
        <li class="form-group">
          <label for="pass">Has&#322;o:</label>
          <input type="password" name="pass" size=20 maxsize=50 required /><br />
        </li>
        <li class="form-group">
          <button type="submit" name="zaloguj" id="przycisk" >Zaloguj się</button>
        </li>
        <li class="form-group">
          <p>
            Nie masz jeszcze konta?
            <a href="rejestracja.php">Zarejestruj się</a>
          </p>
        </li>
      </ul>
    </form>
    <img class="zdjecie" src="zdjecia/grod.jpg">
        </main>

    </div>

    
    <footer class="footer">
    <p><div id="tekst">  

    <div ng-app="mySPA">
    

            <div ng-view></div>
            <script src="spa.js"></script>  

    </div>
    <div id='app' class='content' ><h3>{{title}} {{name}} {{year}}</h3></div>
    <script>var data = new Date();
    x=data.getFullYear()
    const TestApp = {  data(){  
      return {     title: 'Copyright: ',     year: x,    name: 'Filip Sawicki',    } }}
      Vue.createApp(TestApp).mount('#app')</script>


</div></p>
    </footer>
    
</body>

</html>