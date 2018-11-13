<?php
    class suggestion {
      // suggestion id is auto incremented so we will not put it here
      private $userID;
      private $suggestion;
      private $nature;

    public function __construct($userID,$suggestion,$nature){
      $this->userID=$userID;
      $this->suggestion=$suggestion;
      $this->avatar=$nature;
    }
    
    public function getUserID(){
      return $this->userID;
    }
    public function getSuggestion(){
      return $this->suggestion;
    }
    public function getNature(){
      return $this->nature;
    }
}
    
?>
