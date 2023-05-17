var spapp = angular.module("mySPA", ["ngRoute"]);
spapp.config(function ($routeProvider) {
$routeProvider
.when("/page1", {
template: "<div id='app' class='content' ><h3>{{title}} {{name}} {{year}}</h3></div><script>var data = new Date();x=data.getFullYear()const TestApp = {  data(){  return {     title: 'Copyright: ',     year: x,    name: 'Filip Sawicki',    } }}Vue.createApp(TestApp).mount('#app')</script>"
})
.when("/page2", {
template: "<div class='container'><main><h2>Zarejestruj się</h2><div id='formularz'><form action='zarejestruj.php' method='POST'><ul class='flex'><li class='form-group'><label for='fName'>Imie:</label><input type='text' name='fName' size=20 maxsize=30 required /><br /></li><li class='form-group'><label for='lName'>Nazwisko:</label><input type='text' name='lName' size=20 maxsize=30 required /><br /></li><li class='form-group'><label for='email'>Email:</label><input type='email' name='email' size=20 maxsize=50 required /><br /></li><li class='form-group'><label for='uName'>Nazwa u&#380;ytkownika:</label><input type='text' name='uName' size=20 maxsize=30 required /><br /></li><li class='form-group'><label for='pass'>Has&#322;o:</label><input type='password' name='pass' size=20 maxsize=50 required /><br /></li><li class='form-group'><label for='rpass'>Powt&#243;rzone has&#322;o:</label><input type='password' name='rpass' size=20 maxsize=50 required /><br /></li><li class='form-group'><button type='submit' name='rejestracja' id='przycisk' >Zarejestruj</button></li><li class='form-group'><p>Masz ju&#380; konto?<a href='zaloguj.php'>Logowanie</a></p></li></ul></form></div>"
//    template: "<div class='container'></br></br><main><h2>Cennik</h2><table id='tabela-pakietow' class='tabela'><thead><tr><th>Pakiet</th><th>Limit czasu</th><th>Maksymalna moc</th><th colspan='2'>Cena netto/brutto (zł)</th></tr></thead><tbody></tbody></table></br></br></br><div id='formularz'><form action='kalkulator.php' method='POST'><label for='miesiace'>Ilość miesięcy:</label><input type='text' name='miesiace' size=5 maxsize=5 /><br /></br></br><label for='model'>Wybrany model: </label><form name='form' action='test.php' method='post'><select id='cmbMake' name='model' ><option value='1'>Super premium</option><option value='2'>Premium</option><option value='3'>Standard</option><option value='4'>Mini</option></select>  </br>    <input type='submit' name='oblicz' id='przycisk' value='Oblicz' /></form></select></div></br><script type='text/javascript' src='https://www.gstatic.com/charts/loader.js'></script><script type='text/javascript'>google.charts.load('current', {'packages':['corechart']});google.charts.setOnLoadCallback(drawChart);function drawChart() {var wysjava1=w1;var wysjava2=w2;var wysjava3=w3;var wysjava4=w4;var data = google.visualization.arrayToDataTable([['Wybór', 'Ilość klientów'],['Super premium', wysjava1],['Premium',       wysjava2],['Standard',   wysjava3],['Mini',  wysjava4]]);var options = {title: 'Podział pakietów na klientów',backgroundColor: '#fac8c8'};var chart = new google.visualization.PieChart(document.getElementById('piechart'));chart.draw(data, options);}</script><div id='wynik'></div></br></br></main></div><div id='piechart' style='width: 900px; height: 500px;'></div>"
})
.when("/page3", {
template: "<div class='container'><main><section id=galeria><h2>Galeria</h2><figure><div class='zdjecie'><img src='image/ladowarka-tesla-roadster.jpg' height='400' alt='ladowarka tesla roadster'><figcaption> Ladowarka</figcaption></div><div class='zdjecie'><img src='image/ionity.png' height='400' alt='ionity'><figcaption> Ionity</figcaption></div><div class='zdjecie'><img src='image/stacja.png' height='400' alt='stacja'><figcaption> Stacja</figcaption></div><div class='zdjecie'><img src='image/tesla.png' height='400' alt='tesla'><figcaption> Tesla</figcaption></div><div class='zakonczenie'></div></figure></section></main></div>"
})
.when("/page4", {
    template: "<div class='container'><main><section id=opinie><h3>Komentarze</h3><div class='komentarze'><article class='opinia'><h4> Opinia 1</h4>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</article><article class='opinia'><h4> Opinia 2</h4>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</article><article class='opinia'><h4> Opinia 3</h4>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</article><article class='opinia'><h4> Opinia 4</h4>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</article></div></section></main></div>"
})
.when("/page5", {
    template: "<div class='container'><main><section id=wideo1><h3>Filmy</h3><div class='zdjecie'><video height='360' controls><source src='image/Tesla_Model_S.mp4' type='video/mp4' />Tesla</video></div></br></br></br></br></br></br></br></br></br></br></br></br></br></br></br></br></br></br></br></br></br></br></br></br></section></main></div>"
});
});



