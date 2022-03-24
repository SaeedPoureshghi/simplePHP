<?php

trait DB {

    private $host = '127.0.0.1';
    private $dbname = 'DBNAME';
    private $username = 'DBUSER';
    private $password = 'DBPASS';
    public $admin_ids = []; //*TODO: admin ids in user table when login.


    public function db() {
        
          @$mysql = new mysqli($this->host,$this->username,$this->password,$this->dbname);
          if ($mysql->connect_error) {
               echo 'db Error';
               die();
          }
          $mysql->set_charset("utf8");
          return $mysql;
      }
      private function   toJSON($res) {
        $result = array();
        while ($row = $res->fetch_array(MYSQLI_ASSOC)) {
          array_push($result,$row);
        }
        return json_encode($result);
      }

      public function isAdmin() {
        return (in_array($_SESSION['UID'],$this->admin_ids));
      }
}

?>