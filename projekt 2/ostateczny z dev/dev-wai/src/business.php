<?php


use MongoDB\BSON\ObjectID;


function get_db()
{
    $mongo = new MongoDB\Client(
        "mongodb://localhost:27017/wai",
        [
            'username' => 'wai_web',
            'password' => 'w@i_w3b',
        ]);

    $db = $mongo->wai;

    return $db;
}

function get_products()
{
    $db = get_db();
    return $db->products->find()->toArray();
}

function get_products_by_category($cat)
{
    $db = get_db();
    $products = $db->products->find(['cat' => $cat]);
    return $products;
}

function get_product($id)
{
    $db = get_db();
    return $db->products->findOne(['_id' => new ObjectID($id)]);
}

function save_product($id, $product)
{
    $db = get_db();

    if ($id == null) {
        $db->products->insertOne($product);
    } else {
        $db->products->replaceOne(['_id' => new ObjectID($id)], $product);
    }

    return true;
}

function delete_product($id)
{
    $db = get_db();
    $db->products->deleteOne(['_id' => new ObjectID($id)]);
}

function get_users()
{
    $db = get_db();
    return $db->users->find()->toArray();
}

function get_user_by_id($id)
{
    $db = get_db();
    return $db->users->findOne(['_id' => new ObjectID($id)]);
}

function get_user_by_login($login)
{
    $db = get_db();
    return $db->users->findOne(['login' => $login]);
}

function save_user($id, $user)
{
    $db = get_db();

    if ($id == null)
    {
        $db->users->insertOne($user);
    }
    else
    {
        $db->users->replaceOne(['_id' => new ObjectID($id)], $user);
    }
    return true;
}

function check_login_correct($login)
{
    $correct = true;

    if ((strlen($login) < 3) || (strlen($login) > 15))
    {
        $correct = false;
        echo 'Login musi posiadać od 3 do 15 znaków<br>';
    }

    if (check_if_login_exist($login))
    {
        $correct = false;
        echo 'Login jest już zajęty<br>';
    }

    return $correct;
}

function check_password_correct($password, $repeat_password)
{
    $correct = true;

    if (strlen($password) < 5 || strlen($password) > 15)
    {
        $correct = false;
        echo 'Hasło musi posiadać od 5 do 15 znaków<br>';
    }
    if ($password != $repeat_password)
    {
        $correct = false;
        echo 'Podane hasła różnią się';
    }
    return $correct;
}

function check_if_login_exist($login)
{
    $users = get_users();

    foreach ($users as $user)
    {
        if ($user['login'] == $login)
        return true; //taki login już istnieje
    }
    return false;
}

function is_checked($id)
{
    $cart = get_cart();
    foreach ($cart as $element) {
        if ($element['id'] == $id)
        return true;
    }
    return false;
}

function zapisz_jpg_w_folderze($upload,$imagecount,$watermark)
{
     $image = imagecreatefromjpeg($upload);
     $imageResized=imagescale($image , 200, 125); 
     $color =imagecolorallocate($image,255,0,255);
     $imageWatermark = imagestring($image, 100, 0, 0,$watermark,$color); 
     imagejpeg($imageResized,"/var/www/dev/src/web/images/"."mini".$imagecount.".jpg");
     imagejpeg($image,"/var/www/dev/src/web/images/"."imagewm".$imagecount.".jpg");
}
function zapisz_png_w_folderze($upload,$imagecount,$watermark)
{
    $image = imagecreatefrompng($upload);
    $imageResized=imagescale($image,200,125); 
    $color =imagecolorallocate($image,255,0,255);
    $imageWatermark = imagestring($image, 100, 10, 10, $watermark,$color);
    imagepng($imageResized,"/var/www/dev/src/web/images/"."mini".$imagecount.".png");
    imagepng($image,"/var/www/dev/src/web/images/"."imagewm".$imagecount.".png");
}
function sprawdz_mime_type($mime_type)
{
    if ($mime_type === 'image/png') return ".png";
    else if ($mime_type === 'image/jpeg') return ".jpg";
}
function ustaw_nazwy_plikow($imagecount,$rozszerzenie)
{
     $_FILES['zdjecie']['name']="mini".$imagecount.$rozszerzenie;
     $_FILES['zdjecie']['tmp_name']="imagewm".$imagecount.$rozszerzenie;
}