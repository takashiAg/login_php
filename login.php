<?php

/*
 * phpとmysqlでセッションログイン処理を実装するときにとかそういうのを作るのが面倒だったので、exampleを残します。。
 * made : ryosuke ando <ryo@ando.link>
 *
 */


require_once __DIR__ . "/vendor/autoload.php";

use  josegonzalez\Dotenv\Loader as Dotenv;


class login
{
    private $dbh;

    public function __construct()
    {
        $appDir = __DIR__;
        Dotenv::load([
            'filepath' => $appDir . '/.env',
            'toEnv' => true
        ]);

        $mysqlUser = $_ENV['MYSQL_USER'];
        $mysqlPass = $_ENV['MYSQL_PASS'];
        $mysqlHost = $_ENV['MYSQL_HOST'];
        $mysqlDbName = $_ENV['MYSQL_DBNAME'];

        $dsn = sprintf("mysql:host=%s;dbname=%s;charset=UTF8", $mysqlHost, $mysqlDbName);
        try {
            $this->dbh = new PDO($dsn, $mysqlUser, $mysqlPass);
            $this->dbh->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
            $this->dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo "error: " . $e->getMessage() . "\n";
            exit(1);
        }
    }

    public function login($email, $password)
    {
        $sql = "SELECT * FROM users WHERE mail = ? AND password = ?";

        $sth = $this->dbh->prepare($sql);

        $sth->bindParam(1, $email, PDO::PARAM_STR);
        $sth->bindParam(2, $password, PDO::PARAM_STR);
        $sth->execute();

        $userInfo = $sth->fetch(PDO::FETCH_ASSOC);
        session_start();
        $_SESSION["user_info"] = $userInfo;
        return $userInfo;
    }

    public function check()
    {
        /*
         * ログインされていれば、ログイン情報を連想配列で返します。
         * ログインに失敗しているならば、nullを返します。
         */

        session_start();
        //ログインされているかチェックし、ログイン
        if (!isset($_SESSION["user_info"]))
            return null;

        return $_SESSION["user_info"];
    }

    public function logout()
    {
        session_start();
        $_SESSION["user_info"] = null;
    }

}
