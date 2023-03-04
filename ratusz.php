﻿<?php
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
</head>
<body class="body" onload="odliczanie();">
    <Header class="header">
        <h1 id="naglowek"> Osadnicy</h1>


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
        if(isset($_SESSION['atak_jednostki_malo'])){
            if($_SESSION['atak_jednostki_malo']==1){
                ?>
                <script>
                alert("Podaj prawidłową ilość jednostek!");
                </script>
                <?php
            }
            $_SESSION['atak_jednostki_malo']=0;
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
        <div id="zegar"></div>
        <script>
         //   showNotification() {
 //   const notification = new Notification('Masz nową wiadomość!');
//}
 function ile_domow(){
    document.getElementById("domy_ilosc").submit();
}
function ile_blokow(){
    document.getElementById("bloki_ilosc").submit();
}
function ile_cywili(){
    document.getElementById("ludnosc_ilosc").submit();
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
$id_meczu=$_SESSION['mecz_przeslany'];
$id_wioski=$_SESSION['id_wioski'];
$pobranyczas = "SELECT * FROM uczestnicy WHERE id=$id_uczestnik_zalogowany";
if($rezultat = @$polaczenie->query($pobranyczas))
{
    $ilu_userow = $rezultat->num_rows;
    $wiersz = $rezultat->fetch_assoc();
   
}
$pobranyczas=$wiersz['czas'];
$czas=time();
$zmiana=$czas-(int)$pobranyczas;  
$predkosc_zywnosc=$wiersz['predkosc_zywnosc'];
$predkosc_drewno=$wiersz['predkosc_drewno'];
$predkosc_kamien=$wiersz['predkosc_kamien'];
$predkosc_metal=$wiersz['predkosc_metal'];
$predkosc_zl=$wiersz['predkosc_zl'];
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
$sql = "UPDATE uczestnicy SET zywnosc=zywnosc+ $zmiana*$predkosc_zywnosc, drewno =drewno+ $zmiana*$predkosc_drewno,
kamien=kamien+ $zmiana*$predkosc_kamien, metal=metal+ $zmiana*$predkosc_metal, pieniadze=pieniadze+ $zmiana*$predkosc_zl,
czas=$czas WHERE id=$id_uczestnik_zalogowany";
$polaczenie->query($sql);
 $sql = "SELECT * FROM uczestnicy WHERE id=$id_uczestnik_zalogowany";
 if($rezultat = @$polaczenie->query($sql))
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
$wioska_pozycja=(int)$_SESSION['wioska_pozycja'];
$pozycja_x=((int)$wioska_pozycja)%20;
$pozycja_y=((((int)$wioska_pozycja)-$pozycja_x)/20)+1;
$pozycja_x=$pozycja_x+1;
$sql = "SELECT * FROM wioska WHERE id=$id_wioski";
 //$sql = "SELECT * FROM wioska WHERE id_uczestnika=$id_uczestnik_zalogowany AND mecz=$id_meczu AND pozycjax=$pozycja_x AND pozycjay=$pozycja_y";
 if($rezultat3 = @$polaczenie->query($sql))
 {
     $wioska_budynki = $rezultat3->fetch_assoc();
 }
 $id_wioski=$wioska_budynki['id'];
 $_SESSION['id_wioski']=$id_wioski;
 $polaczenie->close();
 }
 //<li>   Żywność:<div id="zywnosc"></div></li>
 ?>
<h4>SUROWCE</h4>
<script>

        window.onload = surowce_odliczac;
        var zywnosc_liczba = <?php echo $wiersz['zywnosc']; ?>;
        var drewno_liczba = <?php echo $wiersz['drewno']; ?>;
        var kamien_liczba = <?php echo $wiersz['kamien']; ?>;
        var metal_liczba = <?php echo $wiersz['metal']; ?>;
        var zl_liczba = <?php echo $wiersz['pieniadze']; ?>;
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
    <br>
    <div class="container">
        <div class="nazwa_budynku"> Ratusz</div>
        <br>
        <center><img class="zdjecie2" src="zdjecia/ratusz.jpg"></center>
        <br>
        <a href="mapa_atak.php">
    <div class=tworzenie> Ataki</div>
    </a>
    <br>
    <a href="mapa_pomoc.php">
    <div class=tworzenie> Przekaż pomoc</div>
    </a>
    <br>
    <a href="mapa_nowa_wioska.php">
    <div class=tworzenie> Załóż nową wioskę</div>
    </a>
    <br>
        <div class="nazwa_budynku"> Budynki</div>
        <?php
    if($wioska_budynki['gospodarstwo']==0){
    ?>
        <div class="budynek_budowa">
        <div class="b_budowa"> Gospodarstwo rolne
        </div>       
        <ul class="koszty">
             <li>   Drewno <?php echo $wiersz_gospoda['drewno']; ?></li>
             <li>   Kamień <?php echo $wiersz_gospoda['kamien']; ?></li>
             <li>   Metal <?php echo $wiersz_gospoda['metal']; ?></li>
             <li>   Złotówki <?php echo $wiersz_gospoda['pieniadze']; ?></li>
        </ul> 
        <a href="budowa/gospodarstwo_budowa.php">
        <div class="budowa">BUDUJ  </div>
        </a>
    </div>
    <?php
    }
    if($wioska_budynki['tartak']==0){
    ?>
    <div class="budynek_budowa">
    <div class="b_budowa"> Tartak
        </div>       
        <ul class="koszty">
             <li>   Drewno <?php echo $wiersz_tartak['drewno']; ?></li>
             <li>   Kamień <?php echo $wiersz_tartak['kamien']; ?></li>
             <li>   Metal <?php echo $wiersz_tartak['metal']; ?></li>
             <li>   Złotówki <?php echo $wiersz_tartak['pieniadze']; ?></li>
        </ul> 
        <a href="budowa/tartak_budowa.php">
        <div class="budowa">BUDUJ  </div>
        </a>
    </div>
    <?php
    }
    if($wioska_budynki['kuznia']==0){
    ?>
    <div class="budynek_budowa">
    <div class="b_budowa"> Kuźnia
        </div>       
        <ul class="koszty">
             <li>   Drewno <?php echo $wiersz_kuznia['drewno']; ?></li>
             <li>   Kamień <?php echo $wiersz_kuznia['kamien']; ?></li>
             <li>   Metal <?php echo $wiersz_kuznia['metal']; ?></li>
             <li>   Złotówki <?php echo $wiersz_kuznia['pieniadze']; ?></li>
        </ul> 
        <a href="budowa/kuznia_budowa.php">
        <div class="budowa">BUDUJ  </div>
        </a>
        </div>
        <?php
    }
    if($wioska_budynki['kamieniolom']==0){
    ?>   
    <div class="budynek_budowa">
    <div class="b_budowa"> Kamieniołom
        </div>       
        <ul class="koszty">
             <li>   Drewno <?php echo $wiersz_kamienilom['drewno']; ?></li>
             <li>   Kamień <?php echo $wiersz_kamienilom['kamien']; ?></li>
             <li>   Metal <?php echo $wiersz_kamienilom['metal']; ?></li>
             <li>   Złotówki <?php echo $wiersz_kamienilom['pieniadze']; ?></li>
        </ul> 
        <a href="budowa/kamieniolom_budowa.php">
        <div class="budowa">BUDUJ  </div>
        </a>
    </div>
    <?php
    }
    if($wioska_budynki['kosciol']==0){
    ?>
    <div class="budynek_budowa">
    <div class="b_budowa"> Kościół
        </div>       
        <ul class="koszty">
             <li>   Drewno <?php echo $wiersz_kosciol['drewno']; ?></li>
             <li>   Kamień <?php echo $wiersz_kosciol['kamien']; ?></li>
             <li>   Metal <?php echo $wiersz_kosciol['metal']; ?></li>
             <li>   Złotówki <?php echo $wiersz_kosciol['pieniadze']; ?></li>
        </ul> 
        <a href="budowa/kosciol_budowa.php">
        <div class="budowa">BUDUJ  </div>
        </a>
    </div>
    <?php
    }
    if($wioska_budynki['koszary']==0){
    ?>
    <div class="budynek_budowa">
    <div class="b_budowa"> Koszary
        </div>       
        <ul class="koszty">
             <li>   Drewno <?php echo $wiersz_koszary['drewno']; ?></li>
             <li>   Kamień <?php echo $wiersz_koszary['kamien']; ?></li>
             <li>   Metal <?php echo $wiersz_koszary['metal']; ?></li>
             <li>   Złotówki <?php echo $wiersz_koszary['pieniadze']; ?></li>
        </ul> 
        <a href="budowa/koszary_budowa.php">
        <div class="budowa">BUDUJ  </div>
        </a>
    </div>
    <?php
    }
    if($wioska_budynki['stajnia']==0 && $wiersz['era']>1){
    ?>
    <div class="budynek_budowa">
    <div class="b_budowa"> Stajnia
        </div>       
        <ul class="koszty">
             <li>   Drewno <?php echo $wiersz_koszary['drewno']; ?></li>
             <li>   Kamień <?php echo $wiersz_koszary['kamien']; ?></li>
             <li>   Metal <?php echo $wiersz_koszary['metal']; ?></li>
             <li>   Złotówki <?php echo $wiersz_koszary['pieniadze']; ?></li>
        </ul> 
        <a href="budowa/stajnia_budowa.php">
        <div class="budowa">BUDUJ  </div>
        </a>
    </div>
    <?php
    }
    if($wioska_budynki['uniwersytet']==0){
    ?>
    <div class="budynek_budowa">
    <div class="b_budowa"> Uniwersytet
        </div>       
        <ul class="koszty">
             <li>   Drewno <?php echo $wiersz_uniwersytet['drewno']; ?></li>
             <li>   Kamień <?php echo $wiersz_uniwersytet['kamien']; ?></li>
             <li>   Metal <?php echo $wiersz_uniwersytet['metal']; ?></li>
             <li>   Złotówki <?php echo $wiersz_uniwersytet['pieniadze']; ?></li>
        </ul> 
        <a href="budowa/uniwersytet_budowa.php">
        <div class="budowa">BUDUJ  </div>
        </a>
    </div>
    <?php
    }
    if($wioska_budynki['huta']==0 && $wiersz['era']>2){
    ?>
    <div class="budynek_budowa">
    <div class="b_budowa"> Huta
        </div>       
        <ul class="koszty">
             <li>   Drewno <?php echo $wiersz_huta['drewno']; ?></li>
             <li>   Kamień <?php echo $wiersz_huta['kamien']; ?></li>
             <li>   Metal <?php echo $wiersz_huta['metal']; ?></li>
             <li>   Złotówki <?php echo $wiersz_huta['pieniadze']; ?></li>
        </ul> 
        <a href="budowa/huta_budowa.php">
        <div class="budowa">BUDUJ  </div>
        </a>
    </div>
    <?php
    }
    if($wioska_budynki['fabryka']==0 && $wiersz['era']>2){
    ?>
    <div class="budynek_budowa">
    <div class="b_budowa"> Fabryka
        </div>       
        <ul class="koszty">
             <li>   Drewno <?php echo $wiersz_koszary['drewno']; ?></li>
             <li>   Kamień <?php echo $wiersz_koszary['kamien']; ?></li>
             <li>   Metal <?php echo $wiersz_koszary['metal']; ?></li>
             <li>   Złotówki <?php echo $wiersz_koszary['pieniadze']; ?></li>
        </ul> 
        <a href="budowa/fabryka_budowa.php">
        <div class="budowa">BUDUJ  </div>
        </a>
    </div>
    <?php
    }
    if($wioska_budynki['lotnisko']==0 && $wiersz['era']>3){
    ?>
    <div class="budynek_budowa">
    <div class="b_budowa"> Lotnisko
        </div>       
        <ul class="koszty">
             <li>   Drewno <?php echo $wiersz_lotnisko['drewno']; ?></li>
             <li>   Kamień <?php echo $wiersz_lotnisko['kamien']; ?></li>
             <li>   Metal <?php echo $wiersz_lotnisko['metal']; ?></li>
             <li>   Złotówki <?php echo $wiersz_lotnisko['pieniadze']; ?></li>
        </ul> 
        <a href="budowa/lotnisko_budowa.php">
        <div class="budowa">BUDUJ  </div>
        </a>
    </div>
    <?php
    }
    ?>
    <div class="budynek_budowa">
    <div class="m_budowa"> Domy
        </div>       
        <ul class="koszty_d">
             <li>   Drewno <?php echo $wiersz_dom['drewno']; ?></li>
             <li>   Kamień <?php echo $wiersz_dom['kamien']; ?></li>
             <li>   Metal <?php echo $wiersz_dom['metal']; ?></li>
             <li>   Złotówki <?php echo $wiersz_dom['pieniadze']; ?></li>
             <li>  <form id="domy_ilosc" action="budowa/dom_budowa.php" method="POST">Ilość 
            <input type="number" name="dom_ilosc"  id='domy' required /></form></li>
        </ul> 
        <div class="budowa" onclick="ile_domow()">BUDUJ  </div>
        
    </div>
    <?php
    if($wiersz['era']>2){
    ?>
    <div class="budynek_budowa">
    <div class="m_budowa"> Bloki
        </div>       
        <ul class="koszty_d">
             <li>   Drewno <?php echo $wiersz_blok['drewno']; ?></li>
             <li>   Kamień <?php echo $wiersz_blok['kamien']; ?></li>
             <li>   Metal <?php echo $wiersz_blok['metal']; ?></li>
             <li>   Złotówki <?php echo $wiersz_blok['pieniadze']; ?></li>
             <li>  <form id="bloki_ilosc" action="budowa/blok_budowa.php" method="POST">Ilość            
            <input type="number" name="blok_ilosc"  id='bloki' required /></form></li>
        </ul> 
        <div class="budowa" onclick="ile_blokow()">BUDUJ  </div>
        
    </div>
    <?php
    }
    $ludnosc_zywnosc=200;
    $ludnosc_cena=2000;
    $ludnosc_maksymalna=$wioska_budynki['domy']*5+$wioska_budynki['bloki']*200+100;
    ?>
    <div class="budynek_zbudowany"> Zbudowane domy <?php echo $wioska_budynki['domy']; ?>
    </div>
    <div class="budynek_zbudowany"> Zbudowane bloki <?php echo $wioska_budynki['bloki']; ?>
    </div>
    <br> 
    <div class="nazwa_budynku"> Ludność</div>
    <div class="budynek_budowa">
    <div class="b_budowa"> Ludność
        </div>       
        <ul class="koszty_l">
             <li>   Żywność <?php echo $ludnosc_zywnosc;; ?></li>
             <li>   Złotówki <?php echo $ludnosc_cena; ?></li>
             <li>  <form id="ludnosc_ilosc" action="szkolenie/cywile.php" method="POST"> Ilość            
            <input type="number" name="ludzie_ilosc"  id='ludzie' required /></form></li>
        </ul> 
        <div class="budowa2" onclick="ile_cywili()">ZATRUDNIJ  </div>
    </div>
    <div class="budynek_zbudowany"> 
        <div class="populacja">Ludność cywilna <?php echo $wioska_budynki['cywile']; ?> </div>
        <div class="populacja2">Maksymalna możliwa liczba ludności <?php echo $ludnosc_maksymalna; ?> </div>
    </div>
    </div>
    <br> <br> 
    
        <footer class="footer">
            <p><div id="tekst"></div> Filip Sawicki 2022 </p>
        </footer>
    
</body>

</html>