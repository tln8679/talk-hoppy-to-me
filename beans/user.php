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

    public function __construct(){
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
        return $this->lastName
      }

        }
    }
?>
