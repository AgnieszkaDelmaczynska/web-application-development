<!doctype html>
<html lang="pl">
<head>
    <meta charset="UTF-8" />
    <title>Travel</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" type="text/css" href="static/formularz.css">
    <link rel="icon" href="static/plane_icon.ico" sizes="16x16" type="image/ico">

    <script>
        function changeBG() {
            var selectedBGColor = document.getElementById("bgchoice").value;
            document.body.style.backgroundColor = selectedBGColor;
        }
    </script>

</head>
<body>
    <div id="wrapper">
        <header>
            <h1>Wypełnij formularz</h1>
        </header>

        <div id="content">

            <p style="font-size: large">
            To jest to miejsce, w którym to właśnie Ty możesz wysłać swoje zdjęcie!<br>
            Maksymalny rozmiar zdjęcia to 1 MB. Dozwolony typ pliku to jpg lub png.<br><br>
            Wypełnij:
            </p>

            <form method="post" enctype="multipart/form-data">
               <div id="in_content">

                    <?php 
                        if (isset($_SESSION['user_login']))
                        {
                            echo 'Autor:<input type="text" name="author" value="'.$_SESSION['user_login'].'"/><br>';
                        }
                        else
                        {
                            echo 'Autor:<input type="text" name="author" placeholder="Autor" required/><br>';
                        }
                    ?>
               <!--Autor:<input type="text" name="author" placeholder="Autor" required><br>-->
               Tytuł:<input type="text" name="title" placeholder="Tytuł" required><br>
               Znak wodny:<input type="text" name="watermark" placeholder="Znak wodny" required><br><br>

                    <?php if(isset($_SESSION['user_id'])): ?>
                        Prywatne<input type="radio" name="priv_radio" value="private"/>
                        Publiczne<input type="radio" name="priv_radio" value="public"/>
                         <?php else: ?>
                        Publiczne<input type="radio" name="priv_radio" value="public" checked required/>
                     <?php endif ?>

               </div> 
                <input type="file" name="zdjecie" required/><br><br>                           
                <input type="submit" name="zapis_zdjec" value="Wyślij" />
            </form><br>

            <?php include '../views/partial/strona_komunikaty_view.php'; ?>
             
            <form action="cart/add" method="post">
            <table>
                <thead>
                    <tr>
                        <th>Autor</th>
                        <th>Tytuł</th>                    
                        <th>Zdjęcie</th>
                        <th>Opcje</th>
                        <th>Zaznacz</th>
                    </tr>
                </thead>          
                
                <tbody>
                    <?php if (count($products)): ?>
                        <?php $counter=0 ?>
                            <?php
                
                                $page = isset($_GET['page']) ? (int) $_GET['page'] : 1;
                                $pageSize=3;
             
                                $opts = [
                                'skip' => (($page - 1)* $pageSize),
                                'limit' => $pageSize
                                ];
                                            
                                $ilezdjec=count($products);
                                $ilestron=ceil($ilezdjec / $pageSize);
                              
                                //echo 'Ilość stron: '.$ilestron.'<br><br><br>';

                                if ($page==1)
                                {
                                    $prev = 1;
                                }
                                else
                                {
                                    $prev = ($page-1);
                                }
                                if ($page==ceil(count($products)/$pageSize))
                                {
                                    $next=ceil(count($products)/$pageSize);
                                }
                                else
                                {
                                    $next = ($page+1); 
                                }
                
                                $results = get_db()->products->find([],$opts); //było $products zamiast results
                
                            ?>

                            <br><br>
                            <div class="pagination">
                                <a href="?page=<?php echo $prev ?>">&laquo;</a>
                                   
                                    <?php 
                                    for($i=1; $i<=ceil(count($products)/$pageSize); $i++)
                                        {
                                            if ($page===$i) {echo '<a class="active" href="?page=' .$i.'">'.$i.'</a>';}
                                            else {echo '<a href="?page=' .$i.'">'.$i.'</a>';}
                                        }                                       
                                    ?>                                   
                                <a href="?page=<?php echo $next ?>">&raquo;</a>
                            </div>

                            <?php
                                foreach ($results as $product): //było $products zamiast result

                                if(isset($_SESSION['user_id'])):

                                    if(!isset($product['user_id']) || $product['user_id']==$_SESSION['user_id']):
                            ?>
                            <tr>
                                <td>
                                <a>    <?= $product['author'] ?> </a>
                                </td>
                               
                                <td><?= $product['title'] ?> </td>
                                <td>
                                        <?php
                                            $filename=pathinfo($product['photo']['name'],PATHINFO_FILENAME);
                                            $extension=pathinfo($product['photo']['name'],PATHINFO_EXTENSION);
                                            $image_path = 'images/'.$filename.".".$extension;
                                            //$image_path = 'images/'.$product['photo']['name'];

                                            $filename2=pathinfo($product['photo']['tmp_name'],PATHINFO_FILENAME);
                                            $extension2=pathinfo($product['photo']['tmp_name'],PATHINFO_EXTENSION);
                                            $image_link_path = 'images/'.$filename2.".".$extension2;
                                            //$image_link_path = 'images/'.$product['photo']['tmp_name'];
                                        ?>
                                    <a href="<?=$image_link_path?>" target="_blank"><img src="<?=$image_path?>"/></a><br>
                                </td>
                                <td>                        
                                    <a id="styl" href="delete?id=<?= $product['_id'] ?>">Usuń</a>
                                </td>
                                <td>
                                    <?php
                                        if (is_checked($product['_id'])):
                                    ?>        
                                        <input type="checkbox" name="box[]" value="<?= $product['_id'] ?>" checked>
                                    <?php else: ?>
                                        <input type="checkbox" name="box[]" value="<?= $product['_id'] ?>">
                                    <?php endif ?>
                                </td>
                            </tr>
                            <?php endif ?>
                            <?php elseif(!isset($product['user_id'])): ?>
                            <tr>
                                <td>
                                <a>    <?= $product['author'] ?> </a>
                                </td>
                               
                                <td><?= $product['title'] ?> </td>
                                <td>
                                        <?php
                                            //$filename=pathinfo($product['photo']['name'],PATHINFO_FILENAME);
                                            //$extension=pathinfo($product['photo']['name'],PATHINFO_EXTENSION);
                                            //$image_path = 'images/'.$filename.".".$extension;
                                            $image_path = 'images/'.$product['photo']['name'];

                                            //$filename2=pathinfo($product['photo']['tmp_name'],PATHINFO_FILENAME);
                                            //$extension2=pathinfo($product['photo']['tmp_name'],PATHINFO_EXTENSION);
                                            //$image_link_path = 'images/'.$filename2.".".$extension2;
                                            $image_link_path = 'images/'.$product['photo']['tmp_name'];
                                        ?>
                                    <a href="<?=$image_link_path?>" target="_blank"><img src="<?=$image_path?>"/></a><br>
                                </td>
                                <td>                        
                                    <a id="styl" href="delete?id=<?= $product['_id'] ?>">Usuń</a>
                                </td>
                                <td>
                                    <?php
                                        if (is_checked($product['_id'])):
                                    ?>        
                                        <input type="checkbox" name="box[]" value="<?= $product['_id'] ?>" checked>
                                    <?php else: ?>
                                        <input type="checkbox" name="box[]" value="<?= $product['_id'] ?>">
                                    <?php endif ?>
                                </td>
                            </tr>
                            <?php endif ?>
                            <?php endforeach ?>
                    <?php else: ?>
                        <tr>
                             <td colspan="3">Brak zdjęć</td>
                        </tr>
                    <?php endif ?>
                </tbody>

                <tfoot>
                <tr>
                    <td colspan="2">Łącznie: <?= count($products) ?></td>
                </tr>
                </tfoot>      
            </table>
            <input type="submit" name="zapamietaj" value="Zapamiętaj wybrane">
            </form>

            <a id="styl" href="wybrane_zdjecia">Pokaż wybrane</a> <!-- było show_cart, zmiana na wybrane_zdjecia-->

            <?php dispatch($routing, '/cart') ?>

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
                    <li><a class="active" href="#">✉ Strona</a></li>
                    <li><a href="/wybrane_zdjecia">Wybrane zdjęcia</a></li>
                    <li><a href="/wyszukiwarka_widok">Wyszukiwarka</a></li>

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

    <div id="wybierz_kolor">
            <select id="bgchoice" onchange="changeBG()">
                <option value="#91BDDF">domyślny (błękitny)</option>
                <option value="#DDBDCD">pudrowy róż</option>
                <option value="#BDC0DD">fiołkowy</option>
                <option value="#4cb4b4">turkusowy</option>
            </select>
        </div>
    <footer> Copyright 2020, Agnieszka Delmaczyńska, grupa 1</footer>
</body>
</html>