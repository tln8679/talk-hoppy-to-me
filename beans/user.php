<?php
    class User {
      // User id is auto incremented so we will not put it here
      private $firstName;
      private $lastName;
      private $avatar;
      private $email;
      private $password;
      private $phoneNumber;
      private $city;
      private $state;

    public function __construct($firstName,$lastName,$avatar,$email,$password,$phoneNumber,$city,$state){
      $this->firstName=$firstName;
      $this->lastName=$firstName;
      $this->avatar=$avatar;
      $this->email=$email;
      $this->password=$password;
      $this->phoneNumber=$phoneNumber;
      $this->city=$city;
      $this->state=$state;
    }
    
    public function getFirstName(){
      return $this->firstName;
    }
    public function getLastName(){
        return $this->lastName;
    }
    public function getEmail(){
        return $this->$email;
    }
    public function getPassword(){
      return $this->password;
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

}
    
?>
