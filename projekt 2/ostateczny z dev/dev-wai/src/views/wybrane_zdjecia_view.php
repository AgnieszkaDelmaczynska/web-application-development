<!doctype html>
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
            <h1>Wybrane zdjęcia</h1>
        </header>

        <div id="content">

            <form action="cart/delete" method="post">
                <table>
                    <thead>
                    <tr>
                        <th>Autor</th>
                        <th>Tytuł</th>                    
                        <th>Zdjęcie</th>
                        <th>Usuń z zapamiętanych</th>
                    </tr>
                    </thead>
                
                <tbody>
                    <?php
                        $cart = &get_cart();
                        if (count($cart)):
                    ?>
                        <?php
                            foreach ($cart as $element):
                            $product = get_product($element['id']);
                        ?>
                        <tr>
                            <td><?= $product['author'] ?> </td>
                            <td><?= $product['title'] ?> </td>
                            <td>
                            <?php                               
                                $filename=pathinfo($product['photo']['name'],PATHINFO_FILENAME);
                                $extension=pathinfo($product['photo']['name'],PATHINFO_EXTENSION);
                                $image_path = 'images/'.$filename.".".$extension;

                                $filename2=pathinfo($product['photo']['tmp_name'],PATHINFO_FILENAME);
                                $extension2=pathinfo($product['photo']['tmp_name'],PATHINFO_EXTENSION);
                                $image_link_path = 'images/'.$filename2.".".$extension2;

                            ?>
                                <a href="<?=$image_link_path?>" target="_blank"><img src="<?=$image_path?>"/></a><br>
                                </td>
                                <td>
                                    <input type="checkbox" name="usun_box[]" value="<?= $product['_id'] ?>">
                                </td>
                            </tr>
                            <?php endforeach ?>
                    <?php else: ?>
                        <tr>
                             <td colspan="3">Brak zdjęć</td>
                        </tr>
                    <?php endif ?>
                </tbody>

                <tfoot>
                <tr>
                    <td colspan="2">Łącznie: <?= count($cart) ?></td>
                </tr>
                </tfoot>
            </table>

        <input type="submit" value="Usuń zaznaczone z zapamiętanych" /> <!--  name="usun_z_zapamietanych" dodałabym, ale nie działa -->

        </form>

        <a id="styl" href="strona" class="cancel">&laquo; Wróć</a>

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
                <li><a class="active" href="#">Wybrane zdjęcia</a></li>
                <li><a href="/wyszukiwarka_widok">Wyszukiwarka</a></li>

                    <?php if (isset($_SESSION['user_login']))
                    {
                        echo '<br>';	                   
                    }
                    ?>

                    <?php if (empty($_SESSION['user_login']))
                    {
                        echo '<li><a href="/logowanie">Zaloguj się</a></li>';
	                    echo '<li><a href="/rejestracja">Zarejestruj się</a></li>';
                    } 
                    ?>

                    <?php 
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