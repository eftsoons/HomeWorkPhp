<?php
    function bankHTML($infobank, $setcategotyindex, $infocategotyindex) {
        ?>
        <div class='flex flex-col items-center'>
            <h2>Банки</h2>
            <?php if (!$setcategotyindex): ?>
                <h3>Выберите банк для редакции:</h3>
            </div>
                <div class='flex flex-col gap-[8px]'>
                    <?php
                        foreach ($infobank as $key => $info) {
                            $index = $key + 1;
                            echo "<form action='#' method='GET'>";
                            echo "<input type='hidden' name='method' value='setcategotyindex'>";
                            echo "<input id='bank$info[idbank]' type='submit' value='$index. idbank: $info[idbank], namebank: $info[namebank], adressbank: $info[adressbank]' />";
                            echo "<input for='bank$info[idbank]' type='hidden' name='setindex' value='$info[idbank]' />";
                            echo '</form>';
                        }
                    ?>
                </div>
            <?php elseif ($infocategotyindex): ?>
                <h3>Редакция банка <?=$setcategotyindex?>:</h3>
                </div>
                <form class='flex flex-col gap-[8px]'>
                    <input type="hidden" name="method" value="setcategotyinfo">
                    <input type="number" id="id" name="id" value="<?=$infocategotyindex["idbank"]?>" placeholder="Id" />
                    <input id="name" name="name" value="<?=$infocategotyindex["namebank"]?>" placeholder="Название" />
                    <input id="adress" name="adress" value="<?=$infocategotyindex["adressbank"]?>" placeholder="Адрес" />
                    <input type="submit" value="Изменить" />
                    <input type="submit" name="delete" value="Удалить банк" />
                </form>
            <?php else: ?>
                </div>
                <h3>Ошибка, банк не найден</h3>
            <?php endif; ?>
        <?php
    };

    function bankomatHTML($allbankomat, $setcategotyindex, $infocategotyindex) {
        ?>
        <div class='flex flex-col items-center'>
        <h2>Банкоматы</h2>
            <?php if (!$setcategotyindex): ?>
                <h3>Выберите банкомат для редакции:</h3>
                </div>
                <div class='flex flex-col gap-[8px]'>
                    <?php
                        foreach ($allbankomat as $key => $info) {
                            $index = $key + 1;
                            echo "<form action='#' method='GET'>";
                            echo "<input type='hidden' name='method' value='setcategotyindex'>";
                            echo "<input type='submit' value='$index. idbankomat: $info[idbankomat], codebank: $info[codebank], adressbankomat: $info[adressbankomat]' />";
                            echo "<input type='hidden' name='setindex' value='$info[idbankomat]' />";
                            echo "</form>";
                        }
                    ?>
                </div>
            <?php elseif ($infocategotyindex): ?>
                <h3>Редакция банкомата <?=$setcategotyindex?>:</h3>
                </div>
                <form class='flex flex-col gap-[8px]'>
                    <input type="hidden" name="method" value="setcategotyinfo">
                    <input type="number" id="id" name="id" value="<?=$infocategotyindex["idbankomat"]?>" placeholder='Id' />
                    <input id="codebank" name="codebank" value="<?=$infocategotyindex["codebank"]?>" placeholder='Код банка' />
                    <input id="adress" name="adress" value="<?=$infocategotyindex["adressbankomat"]?>" placeholder='Адрес' />
                    <input type="submit" value="Изменить" />
                    <input type="submit" name="delete" value="Удалить банкомат" />
                </form>
            <?php else: ?>
                </div>
                <h3>Ошибка, банкомат не найден</h3>
            <?php endif; ?>
        <?php
    };

    function clientHTML($allclient, $setcategotyindex, $infocategotyindex) {
        ?>
        <div class='flex flex-col items-center'>
        <h2>Клиенты</h2>
            <?php if (!$setcategotyindex): ?>
                <h3>Выберите клиента для редакции:</h3>
                </div>
                <div class='flex flex-col gap-[8px]'>
                    <?php
                        foreach ($allclient as $key => $info) {
                            $index = $key + 1;
                            echo "<form action='#' method='GET'>";
                            echo "<input type='hidden' name='method' value='setcategotyindex'>";
                            echo "<input type='submit' value='$index. id: $info[id], fullname: $info[fullname], adress: $info[adress], codebank: $info[codebank]' />";
                            echo "<input type='hidden' name='setindex' value='$info[id]' />";
                            echo "</form>";
                        }
                    ?>
                </div>
            <?php elseif ($infocategotyindex): ?>
                <h3>Редакция клиента <?=$setcategotyindex?>:</h3>
                </div>
                <form class='flex flex-col gap-[8px]'>
                    <input type="hidden" name="method" value="setcategotyinfo">
                    <input type="number" id="id" name="id" value="<?=$infocategotyindex["id"]?>" placeholder="Id" />
                    <input id="fullname" name="fullname" value="<?=$infocategotyindex["fullname"]?>" placeholder="ФИО" />
                    <input id="adress" name="adress" value="<?=$infocategotyindex["adress"]?>" placeholder="Адрес" />
                    <input id="codebank" name="codebank" value="<?=$infocategotyindex["codebank"]?>" placeholder="Код банка" />
                    <input type="submit" value="Изменить" />
                    <input type="submit" name="delete" value="Удалить клиента" />
                </form>
            <?php else: ?>
                </div>
                <h3>Ошибка, клиент не найден</h3>
            <?php endif; ?>
        <?php
    }


    function array_some(array $array, callable $callback): bool {
        foreach ($array as $item) {
            if ($callback($item)) {
                return true;
            }
        }

        return false;
    }
?>