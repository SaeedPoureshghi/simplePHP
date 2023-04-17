<?php

    //*TODO:
    /*
    //* @dev : tbl_messages need!
    */

    trait Message {

        use DB;

        public function insert($uid,$messagetype,$messagedesc,$messagelink) {

            $messagetime = date("Y-m-d H:i:s",time());

            $conn = $this->db();

            $conn->query('START TRANSACTION');
            
            $stmt = $conn->prepare('INSERT INTO tbl_messages (uid,messagetime,messagetype,messagedesc,messagelink) VALUES (?,?,?,?,?)');
            
            $stmt->bind_param("sssss",$uid,$messagetime,$messagetype,$messagedesc,$messagelink);

            $res = $stmt->execute();

            $conn->query('COMMIT');

        }



        public function setMessageRead($id) {

            $uid = $_SESSION['UID'];

            $conn = $this->db();

            $conn->query('START TRANSACTION');
            
            $stmt = $conn->prepare('UPDATE tbl_messages set readstatus=1 where id=? and uid=?');
            
            $stmt->bind_param("ss",$id,$uid);

            $res = $stmt->execute();

            $conn->query('COMMIT');
        }

        public function getMessagebyId($id) {

            $uid = $_SESSION['UID'];

            $conn = $this->db();
            
            $stmt = $conn->prepare('SELECT * from tbl_messages where uid=? and id=?');
            
            $stmt->bind_param("ss",$uid,$id);
            
            $res  = $stmt->execute();
            
            $res = $stmt->get_result();
            
            $res = $res->fetch_all(MYSQLI_ASSOC);
            
            return $res;
        }

        public function getMessages($uid,$unread = false){
  
            $conn = $this->db();

            if ($unread) {

                $stmt = $conn->prepare('SELECT * from tbl_messages where uid=? and readstatus=0 order by id desc');
                
            }else{

                $stmt = $conn->prepare('SELECT * from tbl_messages where uid=? order by id desc');
                
           }

            $stmt->bind_param("s",$uid);
            
            $res  = $stmt->execute();
            
            $res = $stmt->get_result();
            
            $res = $res->fetch_all(MYSQLI_ASSOC);
            
            return $res;

        }
    }
?>