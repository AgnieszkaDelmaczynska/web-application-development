<?php foreach ($results as $image): ?>
        Tytuł: <?= $image['title'] ?> <br/>
        
        <?php $path = 'images/'.'mini'. pos2($image['photo']['name']).".". pathinfo($image['photo']['name'], PATHINFO_EXTENSION); ?>
        <img src="<?= $path ?>" alt="alt_photo"/> <br/>
<?php endforeach?>
<?php
function pos2($str)
{  
    $chars = str_split($str);
    foreach($chars as $litera)
    {
        if(is_numeric($litera))
        {
            return $litera;
        }
    }
}
?>