<?php
    class User {
      // User id is auto incremented so we will not put it here
      private $firstName;
      private $lastName;
      private $avatar;
      private $email;
      private $phoneNumber;
      private $city;
      private $state;
      private $isAdmin;

    public function __construct($firstName,$lastName,$avatar,$email,$phoneNumber,$city,$state,$isAdmin){
      $this->firstName=$firstName;
      $this->lastName=$lastName;
      $this->avatar=$avatar;
      $this->email=$email;
      $this->phoneNumber=$phoneNumber;
      $this->city=$city;
      $this->state=$state;
      $this->isAdmin=$isAdmin;
    }
    
    public function getFirstName(){
      return $this->firstName;
    }
    public function getLastName(){
      return $this->lastName;
    }
    public function getEmail(){
      return $this->email;
    }
    public function getPhoneNumber(){
      return $this->phoneNumber;
    }
    public function getAvatar(){
        return $this->avatar;
    }
    public function getCity(){
      return $this->city;
    }
    public function getState(){
      return $this->state;
    }
    public function getIsAdmin(){
      return $this->isAdmin;
    }

}
    
?>
