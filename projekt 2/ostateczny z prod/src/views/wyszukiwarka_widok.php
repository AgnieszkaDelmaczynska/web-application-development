﻿<!doctype html>
<html lang="pl">
<head>
    <meta charset="UTF-8" />
    <title>Travel</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" type="text/css" href="static/formularz.css">
    <link rel="icon" href="static/plane_icon.ico" sizes="16x16" type="image/ico">

</head>
<body>
    <div id="wrapper">
        <header>
            <h1>AJAX – wyszukiwarka zdjęć</h1>
        </header>

        <div id="content">

            <h2>AJAX – wyszukiwarka zdjęć</h2>
            <input type="text" placeholder="Wpisz tytuł zdjęcia do wyszukania" onkeyup="pokaz_podpowiedz(this.value)" style="width: 40%;"/>
            <div id="gallery"></div><br/>

            <a id="styl" href="strona" class="cancel">Wróć</a>

            <script>
                function pokaz_podpowiedz(tekst)
                {
                    const gallery = document.getElementById('gallery');
            
                    if (tekst.length == 0)
                    {
                        gallery.innerHTML = "";
                    }
                    else
                    {
                        var xmlhttp = new XMLHttpRequest();
                        xmlhttp.onreadystatechange = function()
                        {
                            if (this.readyState == 4 && this.status == 200)
                            {
                                gallery.innerHTML = this.responseText;
                            }
                        };
                        xmlhttp.open("GET", "wyszukiwarka_widok?phrase=" + tekst, true);
                        xmlhttp.send();
                    }
                }
            </script>

        </div>

        <nav>
            <ul>
                    <?php 
                        if (isset($_SESSION['user_login']))
                        {
                            echo 'Witaj <b>'.$_SESSION['user_login'].'</b>!<br><br>';
                        }                   
                    ?>

                    <li><a href="/index">✈ Strona główna</a></li>           
                    <li><a href="/strona">✉ Strona</a></li>
                    <li><a href="/wybrane_zdjecia">Wybrane zdjęcia</a></li>
                    <li><a class="active" href="/wyszukiwarka_widok">Wyszukiwarka</a></li>

                    <?php if (isset($_SESSION['user_login']))
                    {
                        echo '<br>';	                   
                    }
                    ?>

                    <?php
                    if (empty($_SESSION['user_login']))
                    {
                        echo '<li><a href="/logowanie">Zaloguj się</a></li>';
	                    echo '<li><a href="/rejestracja">Zarejestruj się</a></li>';
                    }
                    if (isset($_SESSION['user_login']))
                    {
                        echo '<li><a href="/wyloguj">Wyloguj się</a></li>';
                    }
                    ?>
                    
            </ul>
            <h3>Linki do ciekawych stron:</h3>

            <ul>
                <li><a href="https://kolosy.pl/" target="_blank">Kolosy</a></li>
                <li><a href="https://www.ef.pl/blog/language/dlaczego-podrozowanie/" target="_blank">10 powodów, dla których podróżowanie jest najlepszym sposobem nauki</a></li>
                <li><a href="https://podroze.gazeta.pl/podroze/56,114158,13347605,polska-miejsca-ktore-warto-zobaczyc-galeria-40-zdjec.html" target="_blank">Polska. Miejsca, które warto zobaczyć</a></li>
                <li><a href="https://podroze.onet.pl/" target="_blank">Podróże Onet</a></li>
                <li><a href="https://www.google.com/search?q=podr%C3%B3%C5%BCe&client=firefox-b-d&source=lnms&tbm=isch&sa=X&ved=2ahUKEwivh7LYzuntAhUOzhoKHUozBQ8Q_AUoAXoECAEQAw&biw=1128&bih=610" target="_blank">Zdjęcia, które warto zobaczyć</a></li>
            </ul>
        </nav>
        <a href="#" class="go-top">Idź do góry strony</a>
    </div>
    <footer> Copyright 2020, Agnieszka Delmaczyńska, grupa 1</footer>
</body>
</html>
