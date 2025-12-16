<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
</head>
<body>
    <h1>Register PDO</h1>

    <?php
    if (isset($_POST["user"])) {

        $dbhost = $_ENV["DB_HOST"];
        $dbname = $_ENV["DB_NAME"];
        $dbuser = $_ENV["DB_USER"];
        $dbpass = $_ENV["DB_PASSWORD"];

        // Conexión segura con PDO
        $pdo = new PDO("mysql:host=$dbhost;dbname=$dbname;charset=utf8mb4", $dbuser, $dbpass);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $user = $_POST["user"];     
        $pass = $_POST["password"];

        // Query segura
        $qstr = "INSERT INTO users (name, password, role) 
                 VALUES (:name, SHA2(:pass, 512), 'user');";

        $consulta = $pdo->prepare($qstr);
        $consulta->bindParam(':name', $user, PDO::PARAM_STR);
        $consulta->bindParam(':pass', $pass, PDO::PARAM_STR);

        try {
            $consulta->execute();
            echo "<div class='user'>Usuari $user creat correctament.</div>";
        } catch (PDOException $e) {
            echo "<div class='user'>ERROR: " . $e->getMessage() . "</div>";
        }
    }
    ?>

    <form action="registre.php" method="post">
        User: <input type="text" name="user" /><br>
        Pass: <input type="text" name="password" /><br>
        <input type="submit" value="Registre" />
    </form>

</body>
</html>
