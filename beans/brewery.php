<?php
    class Brewer {
        // Added the brew id because i don't plan on adding breweries from the admin site. But we may have to.
        private $brewerID;
        private $name;
        private $city;
        private $state;

    public function __construct($brewerID,$name,$city,$state){
        $this->brewerID=$brewerID;
        $this->name=$name;
        $this->city=$city;
        $this->state=$state;
      }

      public function getBrewerID(){
        return $this->brewerID;
      }
      public function getName(){
        return $this->name;
      }
      public function getCity(){
        return $this->city;
      }
      public function getState(){
        return $this->state;
      }

    }
?>
