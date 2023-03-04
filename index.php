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
        <h1 id="naglowek"> Osadnicy</h1>


    </Header>

    <a href="moje_konto.php">
        <div class="powrot">Moje konto</div></a>
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
        //$_SESSION['alert_nowa_wioska']=1;
        if(isset($_SESSION['alert_nowa_wioska'])){
            if($_SESSION['alert_nowa_wioska']==1){
                ?>
                <script>
                alert("Za mało surowców!");
                </script>
                <?php
            }
            $_SESSION['alert_nowa_wioska']=0;
        }
    ?>
    </h2>
        </div>
        <br>
        <script>
            
 function wioska_pozycja(id){
    zmiennajava = id;
    document.getElementById("nazmienna_wioska").value = zmiennajava;
    document.getElementById("wioska_index").submit();
}
</script>
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
 //$uzytkownik_przeslany=$_SESSION['uzytkownik_przeslany'];
 if(isset($_SESSION['mecz_przeslany'])){
    if($_SESSION['mecz_przeslany']<1)
    {
        $_SESSION['mecz_przeslany']=$_POST['mWioska'];
    }
}
else{
    $_SESSION['mecz_przeslany']=$_POST['mWioska'];
}
$id_meczu=$_SESSION['mecz_przeslany'];
$_SESSION['wioska_pozycja']=-1;
$sql = "SELECT * FROM uczestnicy WHERE id_user='$id_user' AND mecz='$id_meczu'";
if($rezultat = $polaczenie->query($sql))
{
    $ilu_userow = $rezultat->num_rows;
    $wiersz = $rezultat->fetch_assoc();
    //$id_meczu=$wiersz['mecz'];
    $id_uczestnik_zalogowany=$wiersz['id'];
    $_SESSION['id_zalogowanego_uczestnika']=$wiersz['id'];
    
}
$pobranyczas=$wiersz['czas'];
$czas=time();
$zmiana=$czas-(int)$pobranyczas;  
$predkosc_zywnosc=$wiersz['predkosc_zywnosc'];
$predkosc_drewno=$wiersz['predkosc_drewno'];
$predkosc_kamien=$wiersz['predkosc_kamien'];
$predkosc_metal=$wiersz['predkosc_metal'];
$predkosc_zl=$wiersz['predkosc_zl'];
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
    <h4>MAPA</h4>
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
                    $wiersz_map = $rezultat->fetch_assoc();
                    if($wiersz_map['id_uczestnika']==0){
                    ?>		  
                <div class="pole2" id=<?php echo $y*20+$x;?>>
                </div>
                <?php
                }
                if($wiersz_map['id_uczestnika']>0){
                if($wiersz_map['id_uczestnika']!=$id_uczestnik_zalogowany){
                ?>		  
                <div class="przeciwnik2" id=<?php echo $y*20+$x;?>>
                </div>
                <?php
                }
                else if($wiersz_map['id_uczestnika']==$id_uczestnik_zalogowany){
                ?>		  
                <div class="moja" onclick="wioska_pozycja(id)" id=<?php echo $y*20+$x;?>>
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
    <form id="wioska_index" action="wioska.php" method="POST">
<input type="hidden" name="wioska_Pozycja"  id='nazmienna_wioska' required /><br />
<script>
document.getElementById("nazmienna_wioska").value = zmiennajava;</script>
</form>
        <footer class="footer">
            <p><div id="tekst"></div> Filip Sawicki 2022 </p>
        </footer>
    
</body>

</html>