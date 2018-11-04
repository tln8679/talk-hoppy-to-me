<?php
    class User {
      private $user_id;
      private $firstName;
      private $lastName;
      private $avatar;
      private $email;
      private $password;
      private $phoneNumber;
      private $is_admin;
      private $city;
      private $state;

    public function __construct($user_id,$firstName,$lastName,$avatar,$email,$password,$phoneNumber,$is_admin,$city,$state){
      $this->$user_id = $user_id;
      $this->$firstName=$firstName;
      $this->$lastName=$firstName;
      $this->$avatar=$avatar;
      $this->$email=$email;
      $this->$password=$password;
      $this->$phoneNumber=$phoneNumber;
      $this->$is_admin=$is_admin;
      $this->$city=$city;
      $this->state=$state;
    }
    public function get_user_id(){
      return $this->user_id;
    }
    public function getFirstName(){
      return $this->$firstName;
    }
    public function getLastName(){
        return $this->lastName;
    }

    public function getEmail(){
        return $this->user_id;
    }
    public function getPassword(){
      return $this->$firstName;
    }
    public function getPhoneNumber(){
      return $this->lastName;
    }

    public function get_is_admin(){
        return $this->lastName;
    }

}
    
?>
