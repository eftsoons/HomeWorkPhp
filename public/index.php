<?php
    require_once('config.php');
    #$_SESSION = array();
    $addtext = "";
    $selectbankomat = null;
    $selectclient = null;
    $infoclientoperation = null;
    
    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        if (isset($_GET['bankomat'])) {
            $_SESSION['bankomat'] = $_GET['bankomat'];
        }

        if (isset($_GET['methodbankomat'])) {
            if ($_GET['methodbankomat'] == "clear") {
                $_SESSION['bankomat'] = null;
            }
        }

        if (isset($_GET['client'])) {
            $_SESSION['client'] = $_GET['client'];
            $_SESSION['bankomat'] = null;
        }

        if (isset($_GET['methodclient'])) {
            if ($_GET['methodclient'] == "clear") {
                $_SESSION['client'] = null;
            }
        }

        if (isset($_GET['sum']) && isset($_SESSION["client"]) && isset($_SESSION["bankomat"])) {
            if ($_GET['sum'] <= 2147483647 && $_GET['sum'] >= -2147483647) {
                $comission = isset($_GET['comission']) ? 1 : 0;
                $addtext = "Вы успешно пополнили сумму юзеру $_SESSION[client] на $_GET[sum] через банкомат №$_SESSION[bankomat]";
                #$connect->query("INSERT INTO `operation`(`clientid`, `bankomatid`, `comission`, `sum`) VALUES ($_SESSION[client], $_SESSION[bankomat], $comission, $_GET[sum])");
                $stmt = $connect->prepare("INSERT INTO `operation`(`clientid`, `bankomatid`, `comission`, `sum`) VALUES (?, ?, ?, ?)");
                $stmt->bind_param("iiii", $_SESSION["client"], $_SESSION["bankomat"], $comission, $_GET["sum"]);
                $stmt->execute();
                #$_SESSION = array();
            } else {
                $addtext = "Сумма пополнения не подходит";
            }
        }
    }

    if (isset($_SESSION['bankomat'])) {
        $selectbankomat = $_SESSION['bankomat'];
    }

    if (isset($_SESSION['client'])) {
        $selectclient = $_SESSION['client'];
    } else {
        $selectbankomat = null;
        $_SESSION['bankomat'] = null;
    }
    
    if (!empty($selectclient)) {
        $stmt = $connect->prepare("SELECT * FROM client RIGHT JOIN operation ON operation.clientid = client.id WHERE client.id = ?");
        $stmt->bind_param("i", $selectclient);
        $stmt->execute();
        $result3 = $stmt->get_result(); 
        $infoclient = current(array_filter($allclient, fn($info) => $info["id"] == $selectclient));
        $infoclientoperation = $result3->fetch_all(MYSQLI_ASSOC);
        if (!empty($infoclient)) {
            $stmt = $connect->prepare("SELECT * FROM bankomat LEFT JOIN bank ON bankomat.codebank = bank.idbank WHERE bank.idbank = ?");
            $stmt->bind_param("i", $infoclient["codebank"]);
            $stmt->execute();
            $result2 = $stmt->get_result(); 
            $infobankomat = $result2->fetch_all(MYSQLI_ASSOC);
        } else {
            $infobankomat = null;
        }
    } else {
        $infoclient = null;
        $infobankomat = null;
    }

    echo "<table border=1>";

    foreach ($infobank as $info) {
        echo "<tr>";
        echo "<td>$info[idbank]</td>";
        echo "<td>$info[namebank]</td>";
        echo "<td>$info[adressbank]</td>";
        echo "</tr>";
    }

    echo "</table>";
    
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Huninn&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>
<body>
    <main>
        <div class='w-full'>
            <?php 
                if (empty($selectclient)) {
                    echo "<h3>Клиент не выбран</h3>";
                } else {
                    echo "<h3>Клиент выбран: $selectclient</h3>";
                }
            ?>
            Выбор клиента:
            <div class='flex flex-col gap-[8px]'>
                <form action="#" method="GET">
                    <?php 
                        foreach ($allclient as $info) {
                            $checked = ($info["id"] == $selectclient) ? 'checked' : '';
                            $client_info_bank = current(array_filter($infobank, fn($infobank) => $infobank["idbank"] == $info["codebank"]));
                            echo "<div class='flex justify-between'>";
                            echo "<label for='client$info[id]'>id: $info[id], fullname: $info[fullname], bankname: $client_info_bank[namebank]</label>";
                            echo "<input type='radio' id='client$info[id]' name='client' value='$info[id]' $checked onchange='this.form.submit()' />";
                            echo "</div>";
                            #echo "<input type='submit' value='Удалить' />"; могу сделать если надо
                        }
                    ?>
                </form>
                <form action="#" method="GET">
                    <input type="hidden" name='methodclient' value="clear">
                    <input type="submit" value="Очистить">
                </form>
            </div>
        </div>
        <div class='w-full'>
            <?php
                if (empty($selectclient)) {
                    echo "<h3>Банкомат нельзя выбрать</h3>";
                } else {
                    if (empty($selectbankomat)) {
                        echo "<h3>Банкомат не выбран</h3>";
                    } else {
                        echo "<h3>Банкомат выбран: $selectbankomat</h3>";
                    }

                    echo "Выбор банкомата:";
                    echo "<div class='flex flex-col gap-[8px] w-full'>";
                    echo "<form action='#' method='GET'>";
                    if (!empty($infobankomat)) {
                        foreach ($infobankomat as $info) {
                            $checked = (!empty($selectbankomat) && $info['idbankomat'] == $selectbankomat) ? 'checked' : '';
                            echo "<div class='flex justify-between'>";
                            echo "<label for='bankomat$info[idbankomat]'>id: $info[idbankomat], namebank: $info[namebank], adressbankomat: $info[adressbankomat]</label>";
                            echo "<input type='radio' id='bankomat$info[idbankomat]' name='bankomat' value='$info[idbankomat]' $checked onchange='this.form.submit()' />";
                            echo "</div>";
                        }
                    }
                    echo "</form>";
                    echo "<form>";
                    echo "<input type='hidden' name='methodbankomat' value='clear'>";
                    echo "<input type='submit' value='Очистить'>";
                    echo "</form>";
                    echo '</div>';
                }
                
            ?>
        </div>
        <div class='w-full'>
            <?php 
                #echo <<<HTML
                #<h3>Операция:</h3>
                #<form action='#' method='GET'>
                #    <label for='sum'>Сколько:</label>
                #    <input type='number' id='sum' name='sum' />
                #    <input type='submit' value='Пополнить'>
                #    <input type='checkbox' id='comission' name='comission' value='1'>
                #    <label for='comission'>Комиссия</label>
                #</form>
                #HTML;

                if (!empty($selectclient) && !empty($selectbankomat)) {
                    echo "<h3>Операция:</h3>";

                    echo "<form action='#' method='GET' class='flex flex-col gap-[8px]'>";
                    echo "<label for='sum'>Сколько:</label>";
                    echo "<input type='number' placeholder='Сумма' id='sum' name='sum' />";
                    echo "<div class='flex justify-between'>";
                    echo "<label>Коммисия</label>";
                    echo "<input type='checkbox' id='comission' name='comission' value='1' />";
                    echo "</div>";
                    echo "<input type='submit' value='Пополнить'>";
                    echo "</form>";
                }
            ?>
        </div>
        <br />
        <div class='w-full'>
            <?php if (!empty($infoclientoperation)): ?>
                <h3>Операции клиента:</h3>
                <div>
                    <?php 
                        foreach ($infoclientoperation as $info) {
                            echo "<h4>date: $info[date], sum: $info[sum], comission: $info[comission], bankomatid: $info[bankomatid]</h4>";
                        }
                    ?>
                </div>
            <?php else: ?>
                <h3>Операции нет</h3>
            <?php endif; ?>
        </div>
        <br />
        <h1><?=$addtext?></h1>
    </main>
    <footer><a href="/admin" class='w-[80%]'><button>Перейти в админку</button></a></footer>
</body>
</html>