<?php
    session_start();
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
    $sql = "SELECT * FROM uczestnicy";
    $mecz=1;
    if($rezultat = @$polaczenie->query($sql))
    {
        $ilu_userow = $rezultat->num_rows;
        for($i=1;$i<=$ilu_userow;$i=$i+1){
            $wiersz = $rezultat->fetch_assoc();
            $id_meczu=$wiersz['mecz'];
            if($mecz<=$id_meczu){
                $mecz=$id_meczu+1;
            }
        }
        
    }
    $czas=time();
    $sql = "INSERT INTO uczestnicy ( id_user, mecz, era, zywnosc, drewno, kamien, metal, pieniadze, czas, uczestnictwo)
                VALUES ( '$id_user', '$mecz', 1, 0, 0, 0, 0, 10000, '$czas', 2)";
                $polaczenie->query($sql);
    //$sql = "SELECT * FROM uczestnicy WHERE mecz='$mecz'";
   // if($rezultat2 = @$polaczenie->query($sql))
   // {
   //     $wiersz2 = $rezultat2->fetch_assoc();
   //     $id_uczestnika=$wiersz2['id'];
   // }
    for($y=1;$y<=20;$y++){
        for($x=1;$x<=20;$x++){  
            $sql = "INSERT INTO wioska ( id_uczestnika, mecz, pozycjax, pozycjay, ratusz, morale)
                VALUES ( 0 , '$mecz', '$x', '$y', '0', 1)";
                $polaczenie->query($sql);
            }
        }
        $_SESSION['mecz_przeslany']=$mecz;
        //$sql = "INSERT INTO wioska ( id_uczestnika, mecz, pozycjax, pozycjay, ratusz)
         //       VALUES ( '$id_uczestnika', '$mecz', '$x', '$y', '0')";
          //      @$polaczenie->query($sql);
         // $_POST['mPozycja']=
        header('Location: mapa_nowy_mecz_tw.php');
    $polaczenie->close();
    }

?>