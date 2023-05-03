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
    $mecz=0;
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
    $czas=(int)time();
    echo $mecz;
    $sql = "INSERT INTO uczestnicy ( id_user, mecz, era, czas, uczestnictwo, zatwierdzone)
                VALUES ('$id_user', '$mecz', 1 , '$czas', 2, 0)";
                $polaczenie->query($sql);

    for($y=1;$y<=20;$y++){
        for($x=1;$x<=20;$x++){  
            $sql = "INSERT INTO wioska ( id_uczestnika, mecz, pozycjax, pozycjay, ratusz, morale, cywile)
                VALUES ( 0 , '$mecz', '$x', '$y', '0', 1, 20)";
                $polaczenie->query($sql);
            }
        }
        $_SESSION['mecz_przeslany']=$mecz;
        header('Location: mapa_nowy_mecz_tw.php');
    $polaczenie->close();
    }

?>