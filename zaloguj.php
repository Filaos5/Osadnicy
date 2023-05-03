<?php
    session_start();
    require_once "secure.php";
    $polaczenie = @new mysqli($host, $db_user, $db_password, $db_name);

    if($polaczenie->connect_errno!=0)
    {
        echo "Error:".$polaczenie->connect_errno." Opis: ". $polaczenie->connect_error;
        header('Location: logowanie.php');
    }
    else
    {
        $login=$_POST['uName'];
        $password=$_POST['pass'];
        $login = htmlentities($login, ENT_QUOTES, "UTF-8");
		$password = htmlentities($password, ENT_QUOTES, "UTF-8");
    //$sql = "SELECT * FROM uzytkownicy WHERE login='$login' AND password='$password'";
    //$sql=sprintf("SELECT * FROM uzytkownicy WHERE login='%s' AND password='%s'",
    //mysqli_real_escape_string($polaczenie,$login),
    //mysqli_real_escape_string($polaczenie,$password)); //$sql=0;
    if ($rezultat = @$polaczenie->query(
		sprintf("SELECT * FROM uzytkownicy WHERE login='%s' AND password='%s'",
		mysqli_real_escape_string($polaczenie,$login),
		mysqli_real_escape_string($polaczenie,$password))))
    {
        $ilu_userow = $rezultat->num_rows;
        if($ilu_userow>0)
        {
            $wiersz = $rezultat->fetch_assoc();
            $user = $wiersz['id'];
            $_SESSION['uzytkownik_zalogowany']=$user;
            $rezultat->close();
            $_SESSION['zalogowany']=true;
            $_SESSION['login']=$login;
            $_SESSION['id_sesji']=$user;
            //$_SESSION['mecz_przeslany']=35;
            $_SESSION['link']=1;
            $_SESSION['kolejne_przejscie']="moje_konto";
            header('Location: zdarzenie_cokolwiek.php');
        }
        else
        {
            header('Location: logowanie.php');
        }
    }
    $polaczenie->close();
    }
  

?>   