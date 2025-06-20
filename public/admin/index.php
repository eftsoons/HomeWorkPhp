<?php
    require_once('../config.php');
    require_once('../function.php');

    $setcategoty = null;
    $setcategotyindex = null;
    $infocategotyindex = null;

    if (!isset($_SESSION["auth"])) {
        $_SESSION["auth"] = false;
    } else {
        if (isset($_SESSION["login"]) && isset($_SESSION["password"])) {
            $result5 = $connect->query("SELECT * FROM users");
            $allusers = $result5->fetch_all(MYSQLI_ASSOC);

            if (array_some($allusers, function($data) {return $data["login"] == $_SESSION["login"] && $data["password"] == $_SESSION["password"];})) {
                $_SESSION["auth"] = true;
            } else {
                $_SESSION["auth"] = false;
            }
        } else {
            $_SESSION["auth"] = false;
        }
    }

    if (!isset($_SESSION["reg"])) {
        $_SESSION["reg"] = false;
    }

    $auth = $_SESSION["auth"];
    $reg = $_SESSION["reg"];

    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        if (isset($_GET["method"])) {
            if ($_GET["method"] == "auth") {
                if (isset($_GET["login"]) && isset($_GET["password"])) {
                    $result5 = $connect->query("SELECT * FROM users");
                    $allusers = $result5->fetch_all(MYSQLI_ASSOC);

                    if (array_some($allusers, function($data) {return $data["login"] == $_GET["login"] && $data["password"] == $_GET["password"];})) {
                        $_SESSION["login"] = $_GET["login"];
                        $_SESSION["password"] = $_GET["password"];
                        $_SESSION["setcategoty"] = null;
                    }
                }
            } else if ($_GET["method"] == "reg") {
                $_SESSION["reg"] = true;
            } else if ($_GET["method"] == "regexit") {
                $_SESSION["reg"] = false;
            } else if ($_GET["method"] == "regadd") {
                if (isset($_GET["login"]) && isset($_GET["password"]) && !empty($_GET["login"]) && !empty($_GET["password"])) {
                    $stmt = $connect->prepare("INSERT INTO users (`login`, `password`) VALUES (?, ?)");
                    $stmt->bind_param("ss", $_GET["login"], $_GET["password"]);
                    $stmt->execute();

                    $result5 = $connect->query("SELECT * FROM users");
                    $allusers = $result5->fetch_all(MYSQLI_ASSOC);

                    $_SESSION["reg"] = false;
                }
            } else if ($_GET["method"] == "exitlogin") {
                $_SESSION["login"] = null;
                $_SESSION["password"] = null;
            }
            
            if ($auth) {
                if ($_GET["method"] == "addcategoty") {
                    if (isset($_SESSION["setcategoty"])) {
                        if ($_SESSION["setcategoty"] == "bank") {
                            $connect->query("INSERT INTO bank(namebank, adressbank) VALUES ('Пусто','Пусто')");

                            $result = $connect->query("SELECT * FROM bank");
                            $infobank = $result->fetch_all(MYSQLI_ASSOC);
                        } else if ($_SESSION["setcategoty"] == "bankomat") {
                            if (count($infobank) >= 1) {
                                $stmt = $connect->prepare("INSERT INTO bankomat (codebank, adressbankomat) VALUES (?, 'Пусто')");
                                $stmt->bind_param("i", $infobank[0]["idbank"]);
                                $stmt->execute();
                            }

                            $result = $connect->query("SELECT * FROM bankomat");
                            $infobankomat = $result->fetch_all(MYSQLI_ASSOC);
                        } else if ($_SESSION["setcategoty"] == "client") {
                            if (count($infobank) >= 1) {
                                $stmt = $connect->prepare("INSERT INTO client (fullname, adress, codebank) VALUES ('Пусто', 'Пусто', ?)");
                                $stmt->bind_param("i", $infobank[0]["idbank"]);
                                $stmt->execute();
                            }

                            $result = $connect->query("SELECT * FROM client");
                            $infoclient = $result->fetch_all(MYSQLI_ASSOC);
                        }
                    }
                } else if ($_GET["method"] == "setcategoty") {
                    if (isset($_GET["setcategoty"])) {
                        $_SESSION["setcategoty"] = $_GET["setcategoty"];
                    } else {
                        $_SESSION["setcategoty"] = null;
                    }

                    $_SESSION["setcategotyindex"] = null;
                } else if ($_GET["method"] == "setcategotyindex") {
                    if (isset($_GET["setindex"])) {
                        $_SESSION["setcategotyindex"] = $_GET["setindex"];
                    } else {
                        $_SESSION["setcategotyindex"] = null;
                    }
                } else if ($_GET["method"] == "exitcategotyindex") {
                    $_SESSION["setcategotyindex"] = null;
                } else if ($_GET["method"] == "setcategotyinfo") {
                    if (isset($_SESSION["setcategoty"]) && isset($_SESSION["setcategotyindex"])) {
                        if ($_SESSION["setcategoty"] == "bank") {
                            try {
                                if (isset($_GET["delete"])) {
                                    $stmt = $connect->prepare("DELETE FROM bank WHERE idbank = ?");
                                    $stmt->bind_param("i", $_SESSION["setcategotyindex"]);
                                    $stmt->execute();
                                } else {
                                    if (isset($_GET["name"]) && isset($_GET["adress"]) && isset($_GET["id"])) {
                                        $stmt = $connect->prepare("UPDATE bank SET idbank = ?, namebank = ?, adressbank = ? WHERE idbank = ?");
                                        $stmt->bind_param("issi", $_GET["id"], $_GET["name"], $_GET["adress"], $_SESSION["setcategotyindex"]);
                                        $stmt->execute();
                                    }
                                }

                                $result = $connect->query("SELECT * FROM bank");
                                $infobank = $result->fetch_all(MYSQLI_ASSOC);
                            } catch (mysqli_sql_exception $e) {

                            }
                        } else if ($_SESSION["setcategoty"] == "bankomat") {
                            try {
                                if (isset($_GET["delete"])) {
                                    $stmt = $connect->prepare("DELETE FROM operation WHERE bankomatid = ?");
                                    $stmt->bind_param("i", $_SESSION["setcategotyindex"]);
                                    $stmt->execute();

                                    $stmt = $connect->prepare("DELETE FROM bankomat WHERE idbankomat = ?");
                                    $stmt->bind_param("i", $_SESSION["setcategotyindex"]);
                                    $stmt->execute();
                                } else {
                                    if (isset($_GET["id"]) && isset($_GET["adress"]) && isset($_GET["codebank"])) {
                                        $stmt = $connect->prepare("UPDATE bankomat SET idbankomat = ?, codebank = ?, adressbankomat = ? WHERE idbankomat = ?");
                                        $stmt->bind_param("iisi", $_GET["id"], $_GET["codebank"], $_GET["adress"], $_SESSION["setcategotyindex"]);
                                        $stmt->execute();
                                    }
                                }

                                $result = $connect->query("SELECT * FROM bankomat");
                                $infobankomat = $result->fetch_all(MYSQLI_ASSOC);

                            } catch (mysqli_sql_exception $e) {

                            }
                        } else if ($_SESSION["setcategoty"] == "client") {
                            try {
                                if (isset($_GET["delete"])) {
                                    $stmt = $connect->prepare("DELETE FROM operation WHERE clientid = ?");
                                    $stmt->bind_param("i", $_SESSION["setcategotyindex"]);
                                    $stmt->execute();

                                    $stmt = $connect->prepare("DELETE FROM client WHERE id = ?");
                                    $stmt->bind_param("i", $_SESSION["setcategotyindex"]);
                                    $stmt->execute();
                                } else {
                                    if (isset($_GET["id"]) && isset($_GET["adress"]) && isset($_GET["codebank"])) {
                                        $stmt = $connect->prepare("UPDATE client SET id = ?, fullname = ?, adress = ?, codebank = ? WHERE id = ?");
                                        $stmt->bind_param("issii", $_GET["id"], $_GET["fullname"], $_GET["adress"], $_GET["codebank"], $_SESSION["setcategotyindex"]);
                                        $stmt->execute();
                                    }
                                }

                                $result = $connect->query("SELECT * FROM client");
                                $infoclient = $result->fetch_all(MYSQLI_ASSOC);
                            } catch (mysqli_sql_exception $e) {

                            }
                        }

                        $_SESSION["setcategotyindex"] = null;
                    }
                }
            }

            $clean_url = strtok($_SERVER['REQUEST_URI'], '?');

            header("Location: " . $clean_url);
            exit();
        }
    }

    if (isset($_SESSION["setcategoty"])) {
        $setcategoty = $_SESSION["setcategoty"];
    }

    if (isset($_SESSION["setcategotyindex"])) {
        $setcategotyindex = $_SESSION["setcategotyindex"];
    }

    if ($setcategoty && $setcategotyindex) {
        if ($setcategoty == "bank") {
            $stmt = $connect->prepare("SELECT * FROM bank WHERE idbank = ?");
            $stmt->bind_param("i", $setcategotyindex);
            $stmt->execute();
            $result = $stmt->get_result();
            $infocategotyindex = $result->fetch_assoc();
        } else if ($setcategoty == "bankomat") {
            $stmt = $connect->prepare("SELECT * FROM bankomat WHERE idbankomat = ?");
            $stmt->bind_param("i", $setcategotyindex);
            $stmt->execute();
            $result = $stmt->get_result();
            $infocategotyindex = $result->fetch_assoc();
        } else if ($setcategoty == "client") {
            $stmt = $connect->prepare("SELECT * FROM client WHERE id = ?");
            $stmt->bind_param("i", $setcategotyindex);
            $stmt->execute();
            $result = $stmt->get_result();
            $infocategotyindex = $result->fetch_assoc();
        }
    }

    #print_r($_GET);
    #print_r($infocategotyindex);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Huninn&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <title>Document</title>
</head>
<body>
    <main>
        <?php if ($reg): ?>
            <h3>Регистрация:</h3>
            <div class="flex flex-col gap-[8px]">
                <form action="#" method="GET">
                    <div class="flex flex-col gap-[6px]">
                        <input type="hidden" name="method" value="regadd">
                        <input id="login" name="login" placeholder="Логин" />
                        <input type="password" id="password" name="password" placeholder="Пароль" />
                    </div>
                    <br />
                    <input type="submit" value="Зарегистрировать аккаунт">
                </form>
                <form action="#" method="GET">
                    <input type="hidden" name="method" value="regexit">
                    <input type="submit" value="Назад">
                </form>
            </div>
        <?php elseif (!$auth): ?>
            <h3>Авторизация</h3>
            <div class="flex flex-col gap-[8px]">
                <form action="#" method="GET">
                    <div class="flex flex-col gap-[6px]">
                        <input id="login" name="login" placeholder="Логин" />
                        <input type="password" id="password" name="password" placeholder="Пароль" />
                    </div>
                    <br />
                    <input type="hidden" value="auth" name="method" />
                    <input type="submit" value="Авторизация">
                </form>
                <form action="#" method="GET">
                    <input type="hidden" value="reg" name="method" />
                    <input type="submit" value="Регистрация">
                </form>
            </div>
        <?php elseif (empty($setcategoty)): ?>
            <h3>Выберите категорию для редакции:</h3>
            <div class='flex flex-col gap-[8px]'>
                <form>
                    <input type="hidden" name="method" value="setcategoty">
                    <input type="hidden" name="setcategoty" value="bank">
                    <input type="submit" value="Банки" />
                </form>
                <form>
                    <input type="hidden" name="method" value="setcategoty">
                    <input type="hidden" name="setcategoty" value="bankomat">
                    <input type="submit" value="Банкоматы" />
                </form>
                <form>
                    <input type="hidden" name="method" value="setcategoty">
                    <input type="hidden" name="setcategoty" value="client">
                    <input type="submit" value="Клиенты" />
                </form>
            </div>
        <?php elseif ($setcategoty == "bank"): ?>
            <?=bankHTML($infobank, $setcategotyindex, $infocategotyindex)?>
        <?php elseif ($setcategoty == "bankomat"): ?>
            <?=bankomatHTML($allbankomat, $setcategotyindex, $infocategotyindex)?>
        <?php elseif ($setcategoty == "client"): ?>
            <?=clientHTML($allclient, $setcategotyindex, $infocategotyindex)?>
        <?php endif; ?>
        <?php if (!empty($setcategoty) && $auth && empty($setcategotyindex)): ?>
            <form action="#" method="GET">
                <input type="hidden" name="method" value="addcategoty">
                <input type="submit" value="Добавить">
            </form>
            <form action="#" method="GET">
                <input type="hidden" name="method" value="setcategoty">
                <input type="submit" value="Назад">
            </form>
        <?php elseif (!empty($setcategoty) && $auth && !empty($setcategotyindex)): ?>
            <form action="#" method="GET">
                <input type="hidden" name="method" value="exitcategotyindex">
                <input type="submit" value="Назад">
            </form>
        <?php endif; ?>
        <?php if ($auth): ?>
            <form>
                <input type="hidden" name="method" value="exitlogin">
                <input type="submit" value="Выход из аккаунта">
            </form>
        <?php endif; ?>
    </main>
    <footer><a href="/"><button>Перейти в пользовательское меню</button></a></footer>
</body>
</html>