                    <?php
                    if(($dodawanejpg == true) && ($czy_post == true))
                    {
                        $komunikator = "Operacja wysyłania zdjecia przebiegła pomyślnie!<br>";
                        echo 'Plik: '.$dodawanejpg.' ma '.$komunikat.' bajtów<br><br>';
                        echo $komunikator;
                    }
                    else if (($dodawanejpg == false) && ($czy_post == false))
                    {
                        $komunikator = "Aby wysłać, uzupełnij pola wyżej<br><br>";
                        //echo $komunikator;
                    }
                    else if (($czy_post == true) && ($dodawanejpg == false))
                    {
                        $komunikator = "Operacja wysyłania zdjecia  nie powiodła się <br><br> Niepoprawny format lub rozmiar zdjęcia<br><br>";                                              
                        echo $komunikator;
                    }
                    ?>