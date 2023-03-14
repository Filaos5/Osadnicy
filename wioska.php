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
   
        <div class="powrot" onclick="budynek(id)" id="index">Mapa</div>
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
        <div id="zegar"></div> 
        <h4>SUROWCE</h4>
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
    if(isset($_SESSION['mecz_przeslany'])){
        if($_SESSION['mecz_przeslany']==0)
        {
            header('Location: moje_konto.php');
        }
    }
    else{
        header('Location: moje_konto.php');
    }
    $id_meczu=$_SESSION['mecz_przeslany'];
    if(isset($_SESSION['wioska_pozycja'])){
        if($_SESSION['wioska_pozycja']<0)
        {
            $_SESSION['wioska_pozycja']=$_POST['wioska_Pozycja'];
        }
    }
    else{
        $_SESSION['wioska_pozycja']=$_POST['wioska_Pozycja'];
    }
  //  echo $_SESSION['wioska_pozycja'].' pozycja <br>';
   // echo $id_uczestnik_zalogowany.' uczestnik <br>';
   // echo $id_meczu.' mecz <br>';
    $wioska_pozycja=(int)$_SESSION['wioska_pozycja'];
    $pozycja_x=((int)$wioska_pozycja)%20;
    $pozycja_y=((((int)$wioska_pozycja)-$pozycja_x)/20)+1;
    $pozycja_x=$pozycja_x+1;
  //  echo $pozycja_x.' x <br>';
 //   echo $pozycja_y.' y <br>';
 $sql = "SELECT * FROM wioska WHERE id_uczestnika=$id_uczestnik_zalogowany AND mecz=$id_meczu AND pozycjax=$pozycja_x AND pozycjay=$pozycja_y";
 if($rezultat3 = $polaczenie->query($sql))
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
 $id_wioski=$wioska_budynki['id'];
// echo $id_wioski.' id wioski <br>';
 $_SESSION['id_wioski']=$id_wioski;
    $pobranyczas = "SELECT * FROM uczestnicy WHERE id=$id_uczestnik_zalogowany";
    if($rezultat = @$polaczenie->query($pobranyczas))
    {
        $ilu_userow = $rezultat->num_rows;
        $pobranywiersz = $rezultat->fetch_assoc();  
     
    }
    //$id_uczestnika=$pobranywiersz['id'];

    $sql = "UPDATE wioska SET zywnosc=zywnosc+ $zmiana*$predkosc_zywnosc, drewno =drewno+ $zmiana*$predkosc_drewno,
    kamien=kamien+ $zmiana*$predkosc_kamien, metal=metal+ $zmiana*$predkosc_metal, pieniadze=pieniadze+ $zmiana*$predkosc_zl,
    czas=$czas WHERE id=$id_wioski";
    $polaczenie->query($sql);
    $sql = "SELECT * FROM uczestnicy WHERE id=$id_uczestnik_zalogowany";
 //$sql=0;
 if($rezultat = @$polaczenie->query($sql))
 {
     $ilu_userow = $rezultat->num_rows;
     $wierszu = $rezultat->fetch_assoc();
    
 }
 $sql = "SELECT * FROM wioska WHERE id=$id_wioski";
 //$sql=0;
 if($rezultat = @$polaczenie->query($sql))
 {
     $ilu_userow = $rezultat->num_rows;
     $wiersz = $rezultat->fetch_assoc();
    
 }
 $polaczenie->close();
 }
 ?>

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
        function budynek(id){
    zmiennajava = id;
    console.log ( '#someButton was clicked' );
    document.getElementById("kolejne_przejscie").value = zmiennajava;
    document.getElementById("budynek_nazwa").submit();
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
    <h4>BUDYNKI</h4>
    <div class="budynek" onclick="budynek(id)" id="ratusz" >
        <div class="b_opis"> Ratusz</div>
        <img class="zdjecie_b" src="zdjecia/ratusz.jpg">
    </div>
    <?php 
    if($wioska_budynki['gospodarstwo']>0){
    ?>
    <div class="budynek" onclick="budynek(id)" id="gospodarstwo" >
        <div class="b_opis"> Gospodarstwo rolne</div>
        <img class="zdjecie_b" src="zdjecia/gospodarstwo.jpg">
    </div>
    <?php 
    }
    if($wioska_budynki['kuznia']>0){
    ?>
    <div class="budynek" onclick="budynek(id)" id="kuznia">
        <div class="b_opis"> Kuźnia</div>
        <img class="zdjecie_b" src="zdjecia/kuznia.jpg">
    </div>
    <?php 
    }
    if($wioska_budynki['tartak']>0){
    ?>
    <div class="budynek" onclick="budynek(id)" id="tartak">
        <div class="b_opis"> Tartak</div>
        <img class="zdjecie_b" src="zdjecia/tartak.jpg">
    </div>
    <?php 
    }
    if($wioska_budynki['kamieniolom']>0){
    ?>
    <div class="budynek" onclick="budynek(id)" id="kamieniolom">
        <div class="b_opis"> Kamieniołom</div>
        <img class="zdjecie_b" src="zdjecia/kamieniolom.jpg">
    </div>
    <?php 
    }
    if($wioska_budynki['kosciol']>0){
    ?>
    <div class="budynek" onclick="budynek(id)" id="kosciol">
        <div class="b_opis"> Kościół</div>
        <?php if($wierszu['era']<=3 ){ ?>
        <img class="zdjecie_b" src="zdjecia/kosciol.jpg">
        <?php 
        }
        if($wierszu['era']>3 ){ ?>
        <img class="zdjecie_b" src="zdjecia/kosciol5.jpg">
        <?php 
        }?>
    </div>
    <?php 
    }
    if($wioska_budynki['uniwersytet']>0){
    ?>
    <div class="budynek" onclick="budynek(id)" id="uniwersytet">
        <div class="b_opis"> Uniwersytet</div>
        <img class="zdjecie_b" src="zdjecia/uniwersytet.jpg">
    </div>
    <?php 
    }
    if($wioska_budynki['koszary']>0){
    ?>
    <a href="koszary.php" class="tilelink"> 
    <div class="budynek" onclick="budynek(id)" id="koszary">
        <div class="b_opis"> Koszary</div>
        <img class="zdjecie_b" src="zdjecia/koszary.jpg">
    </div>
    </a>
    <?php 
    }
    if($wioska_budynki['stajnia']>0){
    ?>
    <div class="budynek" onclick="budynek(id)" id="stajnia">
        <div class="b_opis"> Stajnia</div>
        <img class="zdjecie_b" src="zdjecia/stajnia.jpg">
    </div>
    <?php 
    }
    if($wioska_budynki['huta']>0){
    ?>
    <div class="budynek" onclick="budynek(id)" id="huta">
        <div class="b_opis"> Huta</div>
        <img class="zdjecie_b" src="zdjecia/huta.jpg">
    </div>
    <?php 
    }
    if($wioska_budynki['fabryka']>0){
    ?>
    <div class="budynek" onclick="budynek(id)" id="fabryka">
        <div class="b_opis"> Fabryka</div>
        <?php if($wierszu['era']<=3 ){ ?>
        <img class="zdjecie_b" src="zdjecia/fabryka_stara.jpg">
        <?php 
        }
        if($wierszu['era']>=4 ){ ?>
        <img class="zdjecie_b" src="zdjecia/fabryka.jpg">
        <?php 
        }?>
    </div>
    <?php 
    }
    if($wioska_budynki['lotnisko']>0){
    ?>
    <div class="budynek" onclick="budynek(id)" id="lotnisko">
        <div class="b_opis"> Lotnisko</div>
        <img class="zdjecie_b" src="zdjecia/lotnisko.jpg">
    </div>
    <?php 
    }
    ?>

    </div>
    <br> <br> 
    <form id="budynek_nazwa" action="zdarzenie_cokolwiek.php" method="POST">
<input type="hidden" name="kolejne_przejscie"  id='kolejne_przejscie' required /><br />
<script>
document.getElementById("kolejne_przejscie").value = zmiennajava;</script>
</form>
        <footer class="footer">
            <p><div id="tekst"></div> Filip Sawicki 2023</p>
        </footer>
    
</body>

</html>

