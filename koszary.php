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

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Osadnicy</title>
    <link rel="shortcut icon" href="favicon.png" type="image/png">
    <link rel="stylesheet" type="text/css" href="style.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <script src="js/vue.js"></script>
    <script src="https://unpkg.com/vue@next"></script>
</head>
<body class="body" onload="odliczanie();">
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
        <a href="wioska.php">
        <div class="powrot">Powrót</div></a>
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
        if(isset($_SESSION['surowce_malo'])){
            if($_SESSION['surowce_malo']==1){
                ?>
                <script>
                alert("Za mało surowców!");
                </script>
                <?php
            }
            $_SESSION['surowce_malo']=0;
        }
    ?>
    </h2>
        </div>
        <br><br><br>
        <h4>SUROWCE</h4>
        <div id="zegar"></div>
        <script>
 function ile_miecznikow(){
    //jednostka=1;
    document.getElementById("miecznik_ilosc").submit();
    //jednostka.submit();
}
function ile_lucznikow(){
    document.getElementById("lucznik_ilosc").submit();
}
function ile_karabinow(){
    document.getElementById("karabiny_ilosc").submit();
}
function ile_karabinowmaszynowych(){
    document.getElementById("karabinymaszynowe_ilosc").submit();
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
    if(isset($_SESSION['surowce_malo'])){
        if($_SESSION['surowce_malo']==1){
            ?>
            <script>
            alert("Za mało surowców!");
            </script>
            <?php
        }
        $_SESSION['surowce_malo']=0;
    }
$id_user=$_SESSION['id_sesji'];
$id_uczestnik_zalogowany=$_SESSION['id_zalogowanego_uczestnika'];
$id_meczu=$_SESSION['mecz_przeslany'];
$id_wioski=$_SESSION['id_wioski'];
$pobranyczas = "SELECT * FROM uczestnicy WHERE id=$id_uczestnik_zalogowany";
if($rezultat = @$polaczenie->query($pobranyczas))
{
    $ilu_userow = $rezultat->num_rows;
    $wiersz = $rezultat->fetch_assoc();
   
}

 $sql = "SELECT * FROM budynki";
 if($rezultat2 = @$polaczenie->query($sql))
 {
     $ilu_userow = $rezultat->num_rows;
     $wiersz_ratusz = $rezultat2->fetch_assoc();
     $wiersz_gospoda = $rezultat2->fetch_assoc();
     $wiersz_tartak = $rezultat2->fetch_assoc();
     $wiersz_kuznia = $rezultat2->fetch_assoc();
     $wiersz_kamienilom = $rezultat2->fetch_assoc();
     $wiersz_dom = $rezultat2->fetch_assoc();
     $wiersz_blok = $rezultat2->fetch_assoc();
     $wiersz_kosciol = $rezultat2->fetch_assoc();
     $wiersz_koszary = $rezultat2->fetch_assoc();
     $wiersz_stajnia = $rezultat2->fetch_assoc();
     $wiersz_huta = $rezultat2->fetch_assoc();
     $wiersz_fabryka = $rezultat2->fetch_assoc();
     $wiersz_lotnisko = $rezultat2->fetch_assoc();
     $wiersz_uniwersytet = $rezultat2->fetch_assoc();
    
 }
 $sql = "SELECT * FROM wojsko WHERE nazwa='Miecznik' OR nazwa='Lucznik' OR nazwa='Karabin' OR nazwa='Karabinmaszynowy'";
 if($rezultat2 = @$polaczenie->query($sql))
 {
     $wiersz_miecznik = $rezultat2->fetch_assoc();
     $wiersz_lucznik = $rezultat2->fetch_assoc();
     $wiersz_karabin = $rezultat2->fetch_assoc();
     $wiersz_karabinmaszynowy = $rezultat2->fetch_assoc();   
 }
 $sql = "SELECT * FROM wioska WHERE id=$id_wioski";
 if($rezultat3 = @$polaczenie->query($sql))
 {
     $wioska_budynki = $rezultat3->fetch_assoc();
     $pobranyczas=$wioska_budynki['czas'];
    $czas=time();
    $zmiana=$czas-(int)$pobranyczas;  
    $predkosc_zywnosc=$wioska_budynki['predkosc_zywnosc'];
    $predkosc_drewno=$wioska_budynki['predkosc_drewno'];
    $predkosc_kamien=$wioska_budynki['predkosc_kamien'];
    $predkosc_metal=$wioska_budynki['predkosc_metal'];
    $predkosc_zl=$wioska_budynki['predkosc_zl'];
 }

$sql = "UPDATE wioska SET zywnosc=zywnosc+ $zmiana*$predkosc_zywnosc, drewno =drewno+ $zmiana*$predkosc_drewno,
kamien=kamien+ $zmiana*$predkosc_kamien, metal=metal+ $zmiana*$predkosc_metal, pieniadze=pieniadze+ $zmiana*$predkosc_zl,
czas=$czas WHERE id=$id_wioski";
@$polaczenie->query($sql);
 }
 ?>
<script>
        window.onload = surowce_odliczac;
        var zywnosc_liczba = <?php echo $wioska_budynki['zywnosc']; ?>;
        var drewno_liczba = <?php echo $wioska_budynki['drewno']; ?>;
        var kamien_liczba = <?php echo $wioska_budynki['kamien']; ?>;
        var metal_liczba = <?php echo $wioska_budynki['metal']; ?>;
        var zl_liczba = <?php echo $wioska_budynki['pieniadze']; ?>;
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
    <br>  
        <div class="nazwa_budynku"> Koszary </div>
<?php

        $sql_x = "SELECT * FROM szkolenia WHERE kiedy_koniec>$czas AND zrobione=0 AND wioska=$id_wioski ORDER BY kiedy_koniec";
   // $polaczenie->query($sql);
    if($rezultat_x = @$polaczenie->query($sql_x))
    {
        $ile_szkolen = $rezultat_x->num_rows;
        for($i=0;$i<$ile_szkolen;$i++){
            $wiersz_p = $rezultat_x->fetch_assoc();
            $ilosc=$wiersz_p['ilosc'];
            $jednostka=$wiersz_p['jednostka'];
            if($jednostka=='miecznik' || $jednostka=='lucznik' || $jednostka=='karabin' || $jednostka=='karabinmaszynowy'){
            ?>
            <div class="budynek_budowa2">

        <?php
    echo "Szkolenie: ", $jednostka," ilość: ",$ilosc; 
    ?>
    </div>
    <?php
        }
    }
    }
    $polaczenie->close();
        ?>
        <div class="wojsko_ramka"> Miecznik
        <div class="budynek_budowa">
        <ul class="koszty_w">
             <li>   Żywność <?php echo $wiersz_miecznik['zywnosc']; ?></li>
             <li>   Drewno <?php echo $wiersz_miecznik['drewno']; ?></li>
             <li>   Metal <?php echo $wiersz_miecznik['metal']; ?></li>
             <li>   Złotówki <?php echo $wiersz_miecznik['pieniadze']; ?></li>
             <li>  <form id="miecznik_ilosc" action="szkolenie/zapis_do_bazy.php" method="POST"> Ilość            
            <input type="number" name="miecz_ilosc"  value="0" id='miecznik' required /></li>
        </ul>        
    </div>
    </div>
    <div class="wojsko_ramka"> Łucznik
    <div class="budynek_budowa">
        <ul class="koszty_w">
             <li>   Żywność <?php echo $wiersz_lucznik['zywnosc']; ?></li>
             <li>   Drewno <?php echo $wiersz_lucznik['drewno']; ?></li>
             <li>   Metal <?php echo $wiersz_lucznik['metal']; ?></li>
             <li>   Złotówki <?php echo $wiersz_lucznik['pieniadze']; ?></li>
             <li>   Ilość            
            <input type="number" name="luk_ilosc" value="0" id='miecznik' required /></li>
        </ul>    
    </div>
    </div>
    <?php
    if( $wiersz['era']>2){
        ?>
    <div class="wojsko_ramka"> Żołnierz z karabinem
    <div class="budynek_budowa">   
        <ul class="koszty_w">
             <li>   Żywność <?php echo $wiersz_karabin['zywnosc']; ?></li>
             <li>   Drewno <?php echo $wiersz_karabin['drewno']; ?></li>
             <li>   Metal <?php echo $wiersz_karabin['metal']; ?></li>
             <li>   Złotówki <?php echo $wiersz_karabin['pieniadze']; ?></li>
             <li>   Ilość            
            <input type="number" name="karabin_ilosc" value="0" id='karabin' required /></li>
        </ul>     
    </div>
    </div>
    <?php
    }
    if( $wiersz['era']>3){
    ?>
    <div class="wojsko_ramka"> Żołnierz z karabinem maszynowym
    <div class="budynek_budowa">    
        <ul class="koszty_w">
             <li>   Żywność <?php echo $wiersz_karabinmaszynowy['zywnosc']; ?></li>
             <li>   Drewno <?php echo $wiersz_karabinmaszynowy['drewno']; ?></li>
             <li>   Metal <?php echo $wiersz_karabinmaszynowy['metal']; ?></li>
             <li>   Złotówki <?php echo $wiersz_karabinmaszynowy['pieniadze']; ?></li>
             <li>   Ilość            
            <input type="number" name="karabinmaszynowy_ilosc" value="0" id='karabinmaszynowy' required /></li>
        </ul> 
        
    </div>
    </div>
    <?php
    }
    ?>
    <center><button class="button-2" type="submit" name="rejestracja" id="przycisk" >TRENUJ</button></center>

         </form>   
    <br><br><br>

    <br><br>
    <div class="jednostka">
<div class="jednostka_pojemnik">
<div class="jednostka_tytul">Miecznik</div>
<div class="jednostka_opis">Atak: <?php echo $wiersz_miecznik['atak']; ?> punktów</div>
<div class="jednostka_opis">Obrona: <?php echo $wiersz_miecznik['obrona']; ?> punktów</div>
<div class="jednostka_opis">Prędkość: <?php echo $wiersz_miecznik['predkosc']; ?> km/h</div>
<div class="jednostka_opis">Ilość: <?php echo $wioska_budynki['miecznik']; ?></div>
</div>
<img class="jednostka_zdjecie" src="zdjecia/miecznik.jpg">
<div class="koniec"></div>
    </div>
    <br> <br> 
    <div class="jednostka">
<div class="jednostka_pojemnik">
<div class="jednostka_tytul">Łucznik</div>
<div class="jednostka_opis">Atak: <?php echo $wiersz_lucznik['atak']; ?> punktów</div>
<div class="jednostka_opis">Obrona: <?php echo $wiersz_lucznik['obrona']; ?> punktów</div>
<div class="jednostka_opis">Prędkość: <?php echo $wiersz_lucznik['predkosc']; ?> km/h</div>
<div class="jednostka_opis">Ilość: <?php echo $wioska_budynki['lucznik']; ?></div>
</div>
<img class="jednostka_zdjecie" src="zdjecia/lucznik.jpg">
<div class="koniec"></div>
    </div>   
    <br> <br> 
    <?php
    if( $wiersz['era']>2){
        ?>
    <div class="jednostka">
<div class="jednostka_pojemnik">
<div class="jednostka_tytul">Żołnierz z karabinem</div>
<div class="jednostka_opis">Atak: <?php echo $wiersz_karabin['atak']; ?> punktów</div>
<div class="jednostka_opis">Obrona: <?php echo $wiersz_karabin['obrona']; ?> punktów</div>
<div class="jednostka_opis">Prędkość: <?php echo $wiersz_karabin['predkosc']; ?> km/h</div>
<div class="jednostka_opis">Ilość: <?php echo $wioska_budynki['karabin']; ?></div>
</div>
<img class="jednostka_zdjecie" src="zdjecia/z_karabinem.jpg">
<div class="koniec"></div>
    </div>
    <br> <br> 
    <?php
    }
    if( $wiersz['era']>3){
    ?>
    <div class="jednostka">
<div class="jednostka_pojemnik">
<div class="jednostka_tytul">Żołnierz z karabinem maszynowym</div>
<div class="jednostka_opis">Atak: <?php echo $wiersz_karabin['atak']; ?> punktów</div>
<div class="jednostka_opis">Obrona: <?php echo $wiersz_karabin['obrona']; ?> punktów</div>
<div class="jednostka_opis">Prędkość: <?php echo $wiersz_karabin['predkosc']; ?> km/h</div>
<div class="jednostka_opis">Ilość: <?php echo $wioska_budynki['karabinmaszynowy']; ?></div>
</div>
<img class="jednostka_zdjecie" src="zdjecia/karabin_maszynowy.jpg">
<div class="koniec"></div>
    </div>
    <br> <br> 
    <?php
    }
    ?>
    </div>
        <footer class="footer">
        <p><div id="tekst">
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