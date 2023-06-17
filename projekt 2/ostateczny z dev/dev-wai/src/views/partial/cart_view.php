<div id="cart">
    <br><br>
    <h3>Wybrane zdjęcia</h3>

    <table>
        <thead>
        <tr>
            <th>Tytuł</th>
        </tr>
        </thead>

        <tbody>
        <?php if (!empty($cart)): ?>
            <?php foreach ($cart as $id => $product): ?>
                <tr>
                    <td>
                        <?php echo $product['title'] ?>
                    </td>
                </tr>
            <?php endforeach ?>
        <?php else: ?>
            <tr>
                <td colspan="2">Nie wybrano zdjęć</td>
            </tr>
        <?php endif ?>
        </tbody>

        <tfoot>
        <tr>
            <td>
                <form action="cart/clear" method="post" class="inline">                    
                    Łącznie pozycji: <?= count($cart) ?>
                    <input type="submit" value="Usuń wszystkie wybrane" name="clear_cart"/>                   
                </form>
            </td>
        </tr>
        </tfoot>
    </table>
</div>
