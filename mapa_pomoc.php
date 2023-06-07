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

    <a href="ratusz.php">
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
//$_SESSION['wioska_pozycja']=-1;
$id_wioski= $_SESSION['id_wioski'];
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
    <div class="container">
    <h4>MAPA</h4>
    <h3>Wybierz miasto któremu chcesz przekazać wsparcie</h3>
   
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
                    if($id_wioski==$wiersz_map['id']){
                        ?>  
                        <div class="aktualna"  id=<?php echo $y*20+$x;?>>
                        </div>   
                        <?php    
                    } else{
                ?>	
                	  
                <div class="moja" onclick="wioska_pozycja(id)" id=<?php echo $y*20+$x;?>>
                </div>
                <?php  
                    }}}} 
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
    <form id="wioska_index" action="tworzenie_pomocy.php" method="POST">
<input type="hidden" name="wioska_Pozycja"  id='nazmienna_wioska' required /><br />
<script>
document.getElementById("nazmienna_wioska").value = zmiennajava;</script>
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