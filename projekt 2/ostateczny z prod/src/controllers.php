<?php
require_once 'business.php';
require_once 'controller_utils.php';

define("MAXSIZE", 1024*1024);

function strona(&$model)
{   
    $products = get_products();
    $model['products'] = $products;

    $model['dodawanejpg']=false;
    $model['komunikat']=false;
    $model['czy_post']=false;

    //zapisywanie zdjecia   
    $miniaturki = glob("/var/www/prod/src/web/images/mini*.*");
    $znakiwodne=glob("/var/www/prod/src/web/images/imagewm*.*");
    $imagecount = (count(glob("/var/www/prod/src/web/images/*.jpg"))+count(glob("/var/www/prod/src/web/images/*.png"))/3);

    if (!empty($_POST['zapis_zdjec']))
    {
        $author=$_POST['author'];
        $title=$_POST['title'];
        $image=$_FILES['zdjecie'];
        $watermark=$_POST['watermark'];
        $file_info= finfo_open(FILEINFO_MIME_TYPE);
        $file_name= $_FILES['zdjecie']['tmp_name'];
        $mime_type= finfo_file($file_info, $file_name);
        $upload = "/var/www/prod/src/web/images/". $_FILES['zdjecie']['name'];

        $model['czy_post']=true;

        if (is_uploaded_file($_FILES['zdjecie']['tmp_name']))
        {          
            if (($_FILES['zdjecie']['size'] < MAXSIZE) && (($mime_type === 'image/jpeg') || ($mime_type === 'image/png')))
            {           
                $model['dodawanejpg']=$image['name'];
                $model['komunikat']=$image['size'];

                $rozszerzenie = sprawdz_mime_type($mime_type);
                move_uploaded_file($_FILES['zdjecie']['tmp_name'],$upload);                         
                ustaw_nazwy_plikow($imagecount,$rozszerzenie);                
                if ($mime_type === 'image/png')
                {
                    zapisz_png_w_folderze($upload,$imagecount,$watermark);
                }
                else if ($mime_type === 'image/jpeg')
                {
                    zapisz_jpg_w_folderze($upload,$imagecount,$watermark);
                }
            }
            else if ($mime_type !== 'image/jpeg' && $mime_type !== 'image/png' ) 
            {
                return 'redirect:komunikat_format';
            }
            else if ($_FILES['zdjecie']['size'] > MAXSIZE)
            {  
                return 'redirect:komunikat_rozmiar';
            }           
        }
    }

    $product = [
            'author' => null,
            'title' => null,
            'watermark' => null,
            'photo'=> null,
            '_id' => null,
            'private' => null,
            'user_id' => null
            ];

    if (!empty($_POST['zapis_zdjec']))
    {
        if (!empty($_POST['author']) && !empty($_POST['title']) && !empty($_POST['watermark'])) 
        {
            $id = isset($_POST['id']) ? $_POST['id'] : null;
            if(   (isset($_SESSION['user_id'])) && ($_POST['priv_radio']=="private") )
            {
                 $product = [
                'author' => $_POST['author'],
                'title' => $_POST['title'],
                'watermark' => $_POST['watermark'],
                'photo'=> $_FILES['zdjecie'],
                'private' => true,
                'user_id' => $_SESSION['user_id']
                ];
            }
            else
            {
                $product = [
                'author' => $_POST['author'],
                'title' => $_POST['title'],
                'watermark' => $_POST['watermark'],
                'photo'=> $_FILES['zdjecie'],
                'private' => false
                ];
            }
            if (save_product($id, $product))
            {
                return 'redirect:komunikat_powodzenie';
            }
        }
    }

    if (!empty($_POST['zapamietaj']))
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id']))
        {
            if (isset($_POST['oznaczenie']))
            {
                $ile = count($_POST['oznaczenie']);

                for ($i = 0; $i < $ile; $i++)
                {
                    $product = get_product($_POST['oznaczenie'][$i]);

                    $cart = &get_cart();

                    $cart[$_POST['oznaczenie'][$i]] = ['id' => $_POST['oznaczenie'][$i], 'title' => $product['title'], 'amount' => 1];
                }
            }
            return 'redirect:' . $_SERVER['HTTP_REFERER'];
        }
    }
    return 'strona_view';
}

function cart(&$model)
{
    $model['cart'] = get_cart();
    return 'partial/cart_view';
}

function add_to_cart()
{
    if (!empty($_POST['zapamietaj']))
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST')
        {
            if (isset($_POST['box']))
            {
                $ile = count($_POST['box']);
                for ($i = 0; $i < $ile; $i++)
                {
                    $product = get_product($_POST['box'][$i]);

                    $cart = &get_cart();

                    $cart[$_POST['box'][$i]] = ['id' => $_POST['box'][$i], 'title' => $product['title'], 'amount' => 1];
                }
            }
            return 'redirect:' . $_SERVER['HTTP_REFERER'];
        }
    }
}

function clear_cart()
{
    if ($_SERVER['REQUEST_METHOD'] === 'POST')
    {
        $_SESSION['cart'] = [];
        return 'redirect:' . $_SERVER['HTTP_REFERER'];
    }
}

function delete_cart()
{
    if ($_SERVER['REQUEST_METHOD'] === 'POST')
    {
        if (isset($_POST['usun_box']))
        {
            $ile = count($_POST['usun_box']);
            for ($i = 0; $i < $ile; $i++)
            {
                $cart = &get_cart();
                unset($cart[$_POST['usun_box'][$i]]);
            }
        }
        return 'redirect:' . $_SERVER['HTTP_REFERER'];
    }
}

function wybrane_zdjecia(&$model)
{    
    return 'wybrane_zdjecia_view';
}

function rejestracja(&$model)
{  
    $user = [
    'login' => null,
    'password' => null,
    'email' => null,
    '_id' => null
    ];
    
    if ($_SERVER['REQUEST_METHOD'] === 'POST')
    {
        if( !empty($_POST['email']) &&
            !empty($_POST['login']) &&
            !empty($_POST['pass']) &&
            !empty($_POST['repeat_pass'] &&
            check_password_correct($_POST['pass'],$_POST['repeat_pass']) &&
            check_login_correct($_POST['login'])
            )
           )
        {        
            $login = $_POST['login'];
            $password = $_POST['pass'];
            $repeat_password = $_POST['repeat_pass'];
            $hash = password_hash($_POST['pass'], PASSWORD_DEFAULT);

            $id = isset($_POST['id']) ? $_POST['id'] : null;

            $hash = password_hash($_POST['pass'], PASSWORD_DEFAULT);
                
            $user = [
            'login' => $_POST['login'],
            'password' => $hash,
            'email' => $_POST['email'],
            ];

            if (save_user($id, $user))
            {
                return 'redirect:sukces';
            }

        }
    }
    $model['user'] = $user;

    return 'rejestracja_view';
}

function logowanie(&$model)
{   
    if ($_SERVER['REQUEST_METHOD'] === 'POST')
    {
        if(!empty($_POST['login']) && !empty($_POST['pass']))
        {
            $login = $_POST['login'];
            $password = $_POST['pass'];

            $user = get_user_by_login($login);

            if ($user!== null && password_verify($password, $user['password']))//hasło poprawne
            {
                session_regenerate_id();
                $_SESSION['user_id'] = $user['_id'];
                $_SESSION['user_login'] = $user['login'];
                return 'redirect:profile';
            }
            else
            {
                echo 'Nieprawidłowy login lub hasło lub nie posiadasz jeszcze konta';    
            }
        }
    }
    return 'logowanie_view';
}

function wyloguj(&$model)
{
    session_destroy();
    return 'redirect:strona';
}

function index(&$model)
{
    return 'index_view';
}

function komunikat_powodzenie(&$model)
{
    return 'komunikat_powodzenie_view';
}

function komunikat_rozmiar(&$model)
{
    return 'komunikat_rozmiar_view';
}

function komunikat_format(&$model)
{
    return 'komunikat_format_view';
}

function sukces(&$model)
{
    return 'sukces_view';
}

function profile(&$model)
{
    return 'profile_view';
}

function delete(&$model)
{
    if (!empty($_REQUEST['id']))
    {
        $id = $_REQUEST['id'];

        if ($_SERVER['REQUEST_METHOD'] === 'POST')
        {
            delete_product($id);
            return 'redirect:strona';
        }
        else
        {
            if ($product = get_product($id))
            {
                $model['product'] = $product;
                return 'delete_view';
            }
        }
    }
    http_response_code(404);
    exit;
}

function znajdz_zdjecie(&$model)
{
    if(isset($_GET['phrase'])) {
        $phrase = $_GET['phrase'];
        $results = wyszuka_zdj_w_bazie($phrase);
        $model['results'] = $results;
        //print_r ($results);
        //echo "pokaz";
        return 'szukanie_implementacja';
    } else {
        return 'wyszukiwarka_widok';
    }
}

function wyszuka_zdj_w_bazie($phrase)
{
    //echo $phrase;
    $db = get_db();
    $query = [
        '$and' => [
            [ 'private' => false ],
            [ 'title' => ['$regex' => $phrase]],
        ]
    ];

    $results = $db->products->find($query)->toArray();
    return $results;
}