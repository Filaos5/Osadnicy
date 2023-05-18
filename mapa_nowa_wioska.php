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

    <a href="ratusz.php">
        <div class="powrot">Powrot</div></a>
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
        <br><br><br>
        <script>
 function sprawdz_pozycja(id){
    zmiennajava = id;
    document.getElementById("nazmienna").value = zmiennajava;
    document.getElementById("pozycja_form").submit();
}
</script>
        <?php
        require_once "secure.php";
 
 $polaczenie = @new mysqli($host, $db_user, $db_password, $db_name);

 if($polaczenie->connect_errno!=0)
 {
     echo "Error:".$polaczenie->connect_errno." Opis: ". $polaczenie->connect_error;
     //header('Location: index.php');
 }
 else
 {

$id_user=$_SESSION['id_sesji'];
$id_uczestnik_zalogowany=$_SESSION['id_zalogowanego_uczestnika'];
$id_wioski=$_SESSION['id_wioski'];
    if($_SESSION['mecz_przeslany']==0)
    {
        header('Location: moje_konto.php');
    }
$id_meczu=$_SESSION['mecz_przeslany'];
 $sql = "SELECT * FROM uzytkownicy WHERE id=$id_user";
 //$sql=0;
 if($rezultat = @$polaczenie->query($sql))
 {
     //$ilu_userow = $rezultat->num_rows;
     $wiersz = $rezultat->fetch_assoc();
     $login_gracza=$wiersz['login'];
 }

 $sql = "SELECT * FROM wioska WHERE id=$id_wioski";
 if($rezultat3 = @$polaczenie->query($sql))
 {
     $pobranywiersz = $rezultat3->fetch_assoc();
     $pobranyczas=$pobranywiersz['czas'];
    $czas=time();
    $zmiana=$czas-(int)$pobranyczas;  
    $predkosc_zywnosc=$pobranywiersz['predkosc_zywnosc'];
    $predkosc_drewno=$pobranywiersz['predkosc_drewno'];
    $predkosc_kamien=$pobranywiersz['predkosc_kamien'];
    $predkosc_metal=$pobranywiersz['predkosc_metal'];
    $predkosc_zl=$pobranywiersz['predkosc_zl'];
 }
 //echo 'zywnosc ';
 //echo $predkosc_zywnosc;
 //echo 'drewno ';
 //echo $predkosc_drewno;
 //echo 'kamien ';
 //echo $predkosc_kamien;
 //echo 'metal ';
 //echo $predkosc_metal;
 //echo 'zl ';
 //echo $predkosc_zl;
 //echo 'zmiana ';
 //echo $zmiana;
 $sql = "SELECT * FROM uczestnicy WHERE id=$id_uczestnik_zalogowany";
//$sql=0;
if($rezultat = @$polaczenie->query($sql))
{
  $ilu_userow = $rezultat->num_rows;
  $wiersz = $rezultat->fetch_assoc();
 
}
?>

<script>
     window.onload = surowce_odliczac;
     var zywnosc_liczba = <?php echo $pobranywiersz['zywnosc']; ?>;
     var drewno_liczba = <?php echo $pobranywiersz['drewno']; ?>;
     var kamien_liczba = <?php echo $pobranywiersz['kamien']; ?>;
     var metal_liczba = <?php echo $pobranywiersz['metal']; ?>;
     var zl_liczba = <?php echo $pobranywiersz['pieniadze']; ?>;
     var predkosc_zywnosc = <?php echo $predkosc_zywnosc; ?>;
     var predkosc_drewno = <?php echo $predkosc_drewno; ?>;
     var predkosc_kamien = <?php echo $predkosc_kamien; ?>;
     var predkosc_metal = <?php echo $predkosc_metal; ?>;
     var predkosc_zl = <?php echo $predkosc_zl; ?>;
 function surowce_odliczac()
     {
         zywnosc_liczba = zywnosc_liczba+predkosc_zywnosc;
         drewno_liczba = drewno_liczba+predkosc_drewno;
         kamien_liczba = kamien_liczba+predkosc_kamien;
         metal_liczba = metal_liczba+predkosc_metal;
         zl_liczba = zl_liczba+predkosc_zl;
         document.getElementById("zywnosc").innerHTML = zywnosc_liczba ;
         document.getElementById("drewno").innerHTML = drewno_liczba ;
         document.getElementById("kamien").innerHTML = kamien_liczba ;
         document.getElementById("metal").innerHTML = metal_liczba ;
         document.getElementById("zl").innerHTML = zl_liczba ;
         setTimeout("surowce_odliczac()",1000);
     }
</script>
     <div class="surowce">
         <ul class="surowiec">
          <li>   Żywność:<div id="zywnosc"></div></li>
          <li>   Drewno:<div id="drewno"></div></li>
          <li>   Kamień:<div id="kamien"></div></li>
          <li>   Metal:<div id="metal"></div></li>
          <li>   Złotówki:<div id="zl"></div></li>
 </ul>
 </div>
 <div class="container">
    <h4>Mapa mecz numer <?php echo $id_meczu ?></h4>
    <div class="objasnienia"> Zaznacz gdzie chcesz ma mieć nową wioskę.</div>
    <div class="tabela">
        <?php
        $sql = "SELECT * FROM wioska WHERE mecz=$id_meczu";
        if($rezultat = @$polaczenie->query($sql))
        {
            for($y=0;$y<20;$y++){
                ?>
                <div class="wiersz">         
                    <?php
                    for($x=0;$x<20;$x++){
                    $wiersz = $rezultat->fetch_assoc();
                    if($wiersz['id_uczestnika']==0){
                    ?>		  
                <div class="pole" onclick="sprawdz_pozycja(id)" id=<?php echo $y*20+$x;?>>
                </div>
                <?php
                }
                if($wiersz['id_uczestnika']>0){
                if($wiersz['id_uczestnika']!=$id_uczestnik_zalogowany){
                ?>		  
                <div class="przeciwnik2" id=<?php echo $y*20+$x;?>>
                </div>
                <?php
                }
                else if($wiersz['id_uczestnika']==$id_uczestnik_zalogowany){
                ?>		  
                <div class="moja2" id=<?php echo $y*20+$x;?>>
                </div>
                <?php  
                }}} 
                ?>	 
                </div>
                <?php
                }
                ?>	
                </div>
                <?php
        }
        $polaczenie->close();
    }
        ?>
    </div>
    </div>  
    <br> <br> 
    <form id="pozycja_form" action="nowa_wioska.php" method="POST">
<input type="hidden" name="wioska_Pozycja"  id='nazmienna' required /><br />
<script>
document.getElementById("nazmienna").value = zmiennajava;</script>
</form>
        <footer class="footer">
            <p><div id="tekst"></div> Filip Sawicki 2023 </p>
        </footer>
    
</body>

</html>