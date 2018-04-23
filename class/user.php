<?php
require_once "db.php";
require_once "moveTo.php";

class User extends Datebase{
    private $id;
    private $login;
    private $email;
    private $password;
    private $date;

    public function setUser($id,$name,$login,$email,$password,$date){
        $this->id = $id;
        $this->login = $login;
        $this->email = $email;
        $this->password = $password;
        $this->date = $date;
    }

    public function setId($id){
        $this->id = $id;
    }
    public function getId(){
        return $this->id;
    }

    public function setLogin($login){
        $this->login = $login;
    }
    public function getLogin(){
        return $this->login;
    }

    public function setEmail($email){
        $this->email = $email;
    }
    public function getEmail(){
        return $this->email;
    }

    public function setPassword($password){
        $this->password = $password;
    }
    public function getPassword(){
        return $this->password;
    }

    public function setDate($date){
        $this->date = $date;
    }
    public function getDate(){
        return $this->date;
    }


    public function AddUser(){
        try{
            $password = md5($this->password);

            $users = R::dispense("users");
            $users->login =$this->login;
            $users->email=$this->email;
            $users->password=$password;
            $users->date= R::isoDateTime();
            R::store($users);
            return 1;
        }
        catch(Exception $e){
            echo($e);
        }
        R::close();
    }

    public function getEmailsUsers(){
        $arr_tmp = array();
        $users = R::findAll('users');
        foreach($users as $item){
            array_push($arr_tmp, $item->email);
        }
        return $arr_tmp;
    }

    public function getUserId_Cookie(){ //findIdUser
        $users = R::findAll('users');
        foreach($users as $item){
            $name = $item->login;
            if($name == $_COOKIE['SingIN'])
                $idUser = ($item->id);
        }
        return  $idUser;
    }

    public function getIdUserFromEmail(){
        $user = R::findAll('users',"email = '$this->email'");
        foreach($user as $item){
            return $item->id;
        }
    }

    public function NewPassword(){
        try{
            $usersAll = R::load("users", $this->id);
            $usersAll->password = md5($this->password);
            R::store($usersAll);
        }
        catch(Exception $e){
            echo($e);
        }
        R::close();
    }

    public function CheckUserLogin(){
        $user = R::find("users", "login = $this->login");
        if(!empty($user)) return true;
        else return false;
    }

    public function SingIn_User(){
        try{
            $rou = new MoveTo();
            $names = R::findAll('users');
            foreach ($names as $item) {
                if($this->login == $item->login) $your_pass = $item->password;
            }
            if(!isset($your_pass)){
                $_SESSION['login'] = "0";
                echo("<script> alert('Такого пользователя нет'); </script> ");
                $rou->moveToIndex();
                exit;
            }
            if($your_pass == md5($this->password)){
                setcookie("SingIN", $this->login, time()+60*60*24*365*10, '/');
                return 1;
            }
            else{
                $_SESSION['login'] = "1";
                $rou->moveToIndex();
            }
        }
        catch(Exception $e){
            echo $e;
        }
        R::close();
    }

    function getUserlogin_FromId($id_user){ //getUser_nameFromId
        $user = R::find('users', "id = $this->id");
        foreach($user as $item){
            echo($item->login);
        }
    }


}

?>