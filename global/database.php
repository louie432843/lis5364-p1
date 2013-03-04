<?php
    $dsn = 'mysql:host=jowett-mysql.cci.fsu.edu;dbname=ljg08c';
    $username = 'ljg08c';
    $password = '31d2027f';

    try {
        $db = new PDO($dsn, $username, $password);
    } catch (PDOException $e) {
        $error_message = $e->getMessage();
        include('database_error.php');
        exit();
    }
?>