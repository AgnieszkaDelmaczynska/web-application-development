<!DOCTYPE html>
<html>
    <head>
        <title>Produkty</title>
        <link rel="stylesheet" href="static/css/styles.css"/>
    </head>
    <body>

        <h1> Zdjecia</h1>    

        <form method="post" enctype="multipart/form-data">

            Author: <input type="text" name="author"><br>
            Title: <input type="text" name="title"><br>
            Watermark:<input type="text" name="watermark" required><br><br>

            <input type="file" name="photo" required/><br><br>                           
            <input type="submit" value="Send photo!" />
        </form><br>
        <table>
            <thead>
                <tr>
                    <th>Autor</th>
                    <th>Title</th>                    
                    <th>Photo</th>
                    <th>Opcje</th>
                </tr>
            </thead>
            
            <tbody>
                <?php if (count($products)): ?>
                <?php $counter=0 ?>
                <?php foreach ($products as $product): 
                
                $page = isset($_GET['page']) ? (int) $_GET['page']:1;              
              
                $pageSize=3;
             
                   $opts = [
                    'skip' => (($page - 1)* $pageSize),
                    'limit' => $pageSize
                            ];
                
                $next = ($page+1);
                $prev = ($page-1);
                
                $products = get_db()->products->find([],$opts);
                
                $image_path = 'images/'.$product['photo']['name'];
                           //echo $product['photo']['name'];
                //echo $next;
                ?>
                <tr>
                    <td>
                        <a href="view?id=<?= $product['_id'] ?>"><?= $product['author'] ?></a>
                    </td>
                    <td><?= $product['title'] ?> </td>                    
                    <td>
                        <?php
                            $filename=pathinfo($product['photo']['name'],PATHINFO_FILENAME);
                            $extension=pathinfo($product['photo']['name'],PATHINFO_EXTENSION);
                            $image_path = 'images/'."MIN".$filename.$counter.".".$extension;
                        
                            $counter++;
                         //  echo $image_path;
                        ?>
                        <a href=""><img src="<?=$image_path?>"/></a>
                    </td>
                    <td>                        
                        <a href="delete?id=<?= $product['_id'] ?>">Usuń</a>
                    </td>
                </tr>
                <?php endforeach ?>
                <?php else: ?>
                <tr>
                    <td colspan="4">Brak produktów</td>
                </tr>
                <?php endif ?>
            </tbody>

            <tfoot>
                <tr>
                    <td colspan="2">Łącznie: <?= count($products) ?></td>
                    <td>
                        <a href="edit">nowy produkt</a>
                    </td>
                </tr>
            </tfoot>
        </table>

        <?php dispatch($routing, '/cart') ?>

    </body>
</html>
