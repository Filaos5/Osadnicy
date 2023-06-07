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
    $_SESSION['mapa']=1;
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
    <script src="js/vue.js"></script>
    <script src="https://unpkg.com/vue@next"></script>
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

        <div class="powrot" onclick="przejscie(id)" id="moje_konto">Moje konto</div>
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
  function przejscie(id){
    zmiennajava = id;
    console.log ( '#someButton was clicked' );
    //document.getElementById("kolejne_przejscie").value = zmiennajava;
    //document.getElementById("kolejne_przejscie").value = 'moje_konto';
    document.getElementById("link_nazwa").submit();
}          
 function wioska_pozycja(id){
    zmiennajava = id;
    document.getElementById("nazmienna_wioska").value = zmiennajava;
    document.getElementById("kolejne_przejscie").value = 'wioska';
    document.getElementById("wioska_index").submit();
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
$_SESSION['kolejne_przejscie']="moje_konto";
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
?>
<br><br>
<?php
    $sql = "SELECT * FROM ataki WHERE czas_dotarcia>$czas ORDER BY czas_dotarcia";
   // $polaczenie->query($sql);
    if($rezultat = @$polaczenie->query($sql))
    {
        $ile_atakow = $rezultat->num_rows;
        for($i=0;$i<$ile_atakow;$i++){
            $wiersz = $rezultat->fetch_assoc();
            $id_koniec=$wiersz['wioska_koniec'];
            $id_poczatek=$wiersz['wioska_poczatek'];
            $sojusz_atak=$wiersz['sojusz_atak'];
            $sql5="SELECT * FROM wioska WHERE id=$id_koniec";
            if($rezultat5 = @$polaczenie->query($sql5))
            {
                $wiersz5 = $rezultat5->fetch_assoc();
               // echo $wiersz5['id_uczestnika'];
               // echo $id_uczestnik_zalogowany;
                if($wiersz5['id_uczestnika']==$id_uczestnik_zalogowany){
     
    $id_pobrane=$wiersz['wioska_poczatek'];
    $id_celu=$wiersz['wioska_koniec'];
    $id_uczestnika=$wiersz['uczestnik'];
    if($sojusz_atak==1){
        ?>
        <div class="budynek_budowa">
        <?php
    echo "Atak przybędzie: ", date("Y-m-d H:i:s", $wiersz['czas_dotarcia']); 
    //else{
    //echo "Pomoc przybędzie: ", date("Y-m-d H:i:s", $wiersz['czas_dotarcia']);    
    //}
    $sql4="SELECT * FROM wioska WHERE id=$id_pobrane";
    if($rezultat4 = @$polaczenie->query($sql4))
        {
            $wiersz4 = $rezultat4->fetch_assoc();
            $poz_x=$wiersz4['pozycjax'];
            $poz_y=$wiersz4['pozycjay'];
            echo "   z miasta o pozycji x", $poz_x, " i pozycji y",$poz_y;
        }
    $sql2 = "SELECT * FROM uczestnicy WHERE id=$id_uczestnika";
    if($rezultat2 = @$polaczenie->query($sql2))
    {
        $wiersz2 = $rezultat2->fetch_assoc();
        $id_user_pobrane=$wiersz2['id_user'];
        $sql3 = "SELECT login FROM uzytkownicy WHERE id=$id_user_pobrane";
        if($rezultat3 = @$polaczenie->query($sql3))
        {
            $wiersz3 = $rezultat3->fetch_assoc();
            echo " należącego do gracza ",$wiersz3['login'];
        }
    }
    ?><br> <?php 
    $sql4="SELECT * FROM wioska WHERE id=$id_celu";
    if($rezultat5 = @$polaczenie->query($sql4))
        {
            $wiersz5 = $rezultat5->fetch_assoc();
            $poz_xc=$wiersz5['pozycjax'];
            $poz_yc=$wiersz5['pozycjay'];
            echo "do miasta o pozycji x", $poz_xc, " i pozycji y",$poz_yc;
        }
        ?> 
    </div> 
            <?php 
    }
    
        }  }
    }    
    }
    $sql = "SELECT * FROM ataki WHERE czas_dotarcia>$czas ORDER BY czas_dotarcia";
   // $polaczenie->query($sql);
    if($rezultat = @$polaczenie->query($sql))
    {
        $ile_atakow = $rezultat->num_rows;
    for($i=0;$i<$ile_atakow;$i++){
        $wiersz = $rezultat->fetch_assoc();
        $id_koniec=$wiersz['wioska_koniec'];
        $id_poczatek=$wiersz['wioska_poczatek'];
        $sojusz_atak=$wiersz['sojusz_atak'];
        $sql5="SELECT * FROM wioska WHERE id=$id_poczatek";
        if($rezultat5 = @$polaczenie->query($sql5))
        {
            $wiersz5 = $rezultat5->fetch_assoc();
           // echo $wiersz5['id_uczestnika'];
           // echo $id_uczestnik_zalogowany;
            if($wiersz5['id_uczestnika']==$id_uczestnik_zalogowany){
        ?>
<div class="budynek_budowa">
<?php
$id_pobrane=$wiersz['wioska_poczatek'];
$id_celu=$wiersz['wioska_koniec'];
if($sojusz_atak==1){
echo "Atak dotrze do celu: ", date("Y-m-d H:i:s", $wiersz['czas_dotarcia']);
}
else{
echo "Pomoc dotrze do celu: ", date("Y-m-d H:i:s", $wiersz['czas_dotarcia']);    
}
$sql4="SELECT * FROM wioska WHERE id=$id_celu";
if($rezultat4 = @$polaczenie->query($sql4))
    {
        $wiersz4 = $rezultat4->fetch_assoc();
        $poz_x=$wiersz4['pozycjax'];
        $poz_y=$wiersz4['pozycjay'];
        $id_uczestnika_atakowanego=$wiersz4['id_uczestnika'];
        echo "   do miasta o pozycji x", $poz_x, " i pozycji y",$poz_y;
    }
$sql2 = "SELECT * FROM uczestnicy WHERE id=$id_uczestnika_atakowanego";
if($rezultat2 = @$polaczenie->query($sql2))
{
    //echo $id_celu;
    $wiersz2 = $rezultat2->fetch_assoc();
    $id_user_pobrane=$wiersz2['id_user'];
    $sql3 = "SELECT login FROM uzytkownicy WHERE id=$id_user_pobrane";
    if($rezultat3 = @$polaczenie->query($sql3))
    {
        $wiersz3 = $rezultat3->fetch_assoc();
        echo " należącego do gracza ",$wiersz3['login'];
    }
}
?><br> <?php 
$sql4="SELECT * FROM wioska WHERE id=$id_pobrane";
if($rezultat5 = @$polaczenie->query($sql4))
    {
        $wiersz5 = $rezultat5->fetch_assoc();
        $poz_xc=$wiersz5['pozycjax'];
        $poz_yc=$wiersz5['pozycjay'];
        echo "z miasta o pozycji x", $poz_xc, " i pozycji y",$poz_yc;
    }

?> 
</div> 
        <?php 
    }  }  
}
    }
    ?>
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
    <form id="wioska_index" action="zdarzenie_cokolwiek.php" method="POST">
    <input type="hidden" name="kolejne_przejscie"  id='kolejne_przejscie' required /><br />
<input type="hidden" name="wioska_Pozycja"  id='nazmienna_wioska' required /><br />
<script>
document.getElementById("nazmienna_wioska").value = zmiennajava;</script>
</form>
<form id="link_nazwa" action="zdarzenie_cokolwiek.php" method="POST">
<input type="hidden" name="kolejne_przejscie"  id='kolejne_przejscie' required /><br />
<script>
document.getElementById("kolejne_przejscie").value = zmiennajava;</script>
</form>
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