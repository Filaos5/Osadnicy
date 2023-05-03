<?php
  session_start();
  if(isset($_SESSION['zalogowany'])){
      if($_SESSION['zalogowany']!=true)
      {
          header('Location: logowanie.php');
      }
  }
  else{
  header('Location: logowanie.php');
  }
  $_SESSION['link']=0; 
?>
<script type="text/javascript" src="timer.js"></script>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Osadnicy</title>
    <link rel="shortcut icon" href="favicon.png" type="image/png">
    <link rel="stylesheet" type="text/css" href="style.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>

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
    <div id = "random"></div>

<script type = "text/javascript">
var zmiennajava;
</script>

    <div class="container">
    <a href="index.php"></a>
        <div class="powrot">USTAWIENIA</div>
        <div class="wylogowanie">
    <h2>
        <?php
       if(isset($_SESSION['login'])){
        echo "Użytkownik  ". $_SESSION['login'];
        ?>
        <a href="wyloguj.php">
            <div class="tilelink2">Wyloguj się
       </div>
        </a>
        <?php
        }
    ?>
    </h2>
        </div>
        <br><br>
        <?php
        require_once "secure.php";
        //$_SESSION['mecz_przeslany']=38;
 $polaczenie = @new mysqli($host, $db_user, $db_password, $db_name);

 if($polaczenie->connect_errno!=0)
 {
     echo "Error:".$polaczenie->connect_errno." Opis: ". $polaczenie->connect_error;
     //header('Location: index.php');
 }
 else
 {

$id_user=$_SESSION['id_sesji'];
$_SESSION['mecz_przeslany']=-1;
$_SESSION['wioska_pozycja']=-5;
$_SESSION['uzytkownik_przeslany']=0;
$id_user=$_SESSION['uzytkownik_zalogowany'];
/*
 $sql = "SELECT * FROM uczestnicy WHERE id_user=$id_user";
 //$sql=0;
 if($rezultat = $polaczenie->query($sql))
 {
     $wiersz = $rezultat->fetch_assoc();
     $id_meczu=$wiersz['mecz'];
 }
       */
  ?>
<br> <br> <br>
<h4>Moje mecze</h4>
<script>
 function sprawdz(id){
    zmiennajava = id;
    document.getElementById("nazmienna").value = zmiennajava;
    document.getElementById("mecz_form").submit();
}
function do_wioski(id){
    zmiennajava = id;
    document.getElementById("nazmienna2").value = zmiennajava;
    document.getElementById("do_wioski_form").submit();
}
</script>

 <?php
  $sql = "SELECT * FROM uczestnicy WHERE id_user=$id_user AND uczestnictwo>0 AND zatwierdzone=1";
  if($rezultat2 = $polaczenie->query($sql))
  {
      $ilu_userow = $rezultat2->num_rows;
  }
    for($i=0;$i<$ilu_userow;$i++){
        $wiersz = $rezultat2->fetch_assoc();
        $id_uzytkownika=$wiersz['id_user'];
        $uczestnictwo=$wiersz['uczestnictwo'];
        //echo $uczestnictwo. 'uczestnictwo <br>';
        //echo $id_user. 'uzytkownik <br>';
        if($id_user==$id_uzytkownika){
        ?> 
        <a href="index.php"></a> 
         <div class=mecz onclick="do_wioski(id)" id=<?php echo $wiersz['mecz'];?>>Mecz <?php echo $wiersz['mecz']; $_SESSION['mecz']=$wiersz['mecz'];?> </div>            
        <?php
    }}
 ?>
<h4>Tworzone mecze</h4>
<?php
  $sql = "SELECT * FROM uczestnicy WHERE id_user=$id_user AND uczestnictwo>0 AND zatwierdzone=0";
  if($rezultat2 = @$polaczenie->query($sql))
  {
      $ilu_userow = $rezultat2->num_rows;
  }
    for($i=0;$i<$ilu_userow;$i++){
        $wiersz = $rezultat2->fetch_assoc();
        $id_uzytkownika=$wiersz['id_user'];
        if($id_user==$id_uzytkownika){
        ?> 
         <div class=mecz onclick="sprawdz(id)" id=<?php echo $wiersz['mecz'];?>>Mecz <?php echo $wiersz['mecz']; $_SESSION['mecz']=$wiersz['mecz'];?> </div>
            
          
        <?php
    }}

    $polaczenie->close();
}
 ?>
<form id="mecz_form" action="tworzenie_meczu.php" method="POST">
<input type="hidden" name="mName"  id='nazmienna' required /><br />
<script>
document.getElementById("nazmienna").value = zmiennajava;</script>
</form>
<form id="do_wioski_form" action="index.php" method="POST">
<input type="hidden" name="mWioska"  id='nazmienna2' required /><br />
<script>
document.getElementById("nazmienna2").value = zmiennajava;</script>
</form>
  <br> <br> 
  <p id="dane"></p>
<a href="utworz_mecz.php">
    <div class=tworzenie> Utwórz nowy mecz</div>
    </a>
    </div>
    </div>     
    <br> <br>    
        <footer class="footer">
            <p><div id="tekst"></div> Filip Sawicki 2023</p>
        </footer>
    
</body>
</html>