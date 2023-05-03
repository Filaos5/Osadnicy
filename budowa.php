<?php
$polaczenie = @new mysqli($host, $db_user, $db_password, $db_name);
    $sql = "SELECT * FROM budynki WHERE id=2";
    if($rezultat = @$polaczenie->query($sql))
    {
        $pobranywiersz = $rezultat->fetch_assoc();          
    }
    $pieniądze=$pobranywiersz['pieniadze'];
    $koszt=(int)$wiersz_gospoda['pieniadze']; 
    if($wiersz['pieniadze']>$wiersz_gospoda['pieniadze']){
    ##    && $wioska_budynki['gospodarstwo']=0
    $sql = "UPDATE wioska SET gospodarstwo=1 WHERE id=1";
    @$polaczenie->query($sql);
    $sql = "UPDATE uczestnicy SET pieniadze=pieniadze-$koszt WHERE id=1";
    }
    @$polaczenie->query($sql);
    $polaczenie->close();
    
    ?>