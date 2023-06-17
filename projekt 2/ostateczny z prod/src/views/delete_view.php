<!DOCTYPE html>
<html>
<head>
    <title>Usuwanie produktu</title>
    <link rel="stylesheet" href="static/formularz.css"/>
</head>
<body>
    <div id="wrapper">
            <header>
                <h1>Wysłane zdjęcia</h1>
            </header>

            <div id="content">
                <form method="post">
                    Czy usunąć produkt: <?= $product['photo']['name'] ?>?

                    <input type="hidden" name="id" value="<?= $product['_id'] ?>">

                    <div>
                        <a id="styl" href="strona" class="cancel">Anuluj</a>
                        <input type="submit" value="Potwierdź"/>
                    </div>
                </form>

            </div>

            <nav>
                <ul>
                    <li><a href="/index">✈ Strona główna</a></li>           
                    <li><a href="/strona">✉ Strona</a></li>
                    <li><a href="/wyslane_zdjecia">Wysłane zdjęcia</a></li>
                    <li><a href="/logowanie">Logowanie</a></li>
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