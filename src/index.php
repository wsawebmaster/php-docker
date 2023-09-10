<?php

echo "Olá caro Dev, servidor em perfeito funcionamento!" . PHP_EOL;

try {
    $dbh = new \PDO('mysql:host=mysql;port=3306', 'root', '');
    echo "<br /><br />" . "Conexão MySQL estabelecida com êxito!";
} catch (PDOException $e) {
    echo "Houve falhar na conexão MySQL!" . "<br/>";
    print "Error!: " . $e->getMessage() . "<br/>";
    die();
}
