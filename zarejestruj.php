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

        $login=$_POST['uName'];
        $password=$_POST['pass'];
        $password2=$_POST['rpass'];
        $imie=$_POST['fName'];
        $nazwisko=$_POST['lName'];
        $mail=$_POST['email'];

    $sql = "SELECT * FROM uzytkownicy WHERE login='$login' AND password='$password'";
    //$sql=0;
    if($rezultat = @$polaczenie->query($sql))
    {
        $ilu_userow = $rezultat->num_rows;
        if($ilu_userow==0 && $password==$password2)
        {
            $wiersz = $rezultat->fetch_assoc();

            $sql = "INSERT INTO uzytkownicy ( imie, nazwisko, email, login, password)
            VALUES ( '$imie', '$nazwisko', '$mail', '$login', '$password')";
            @$polaczenie->query($sql);
            header('Location: logowanie.php');
            //$_SESSION['zalogowany']=true;
        }
        else
        {
            header('Location: rejestracja.php');
        }
    }
    $polaczenie->close();
    }

?>