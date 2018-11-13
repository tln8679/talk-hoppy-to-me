<?php
    class Post {
        // id is auto incremented so im not adding it because we cant have the id until we insert it into the DB
        private $rating;
        private $comment;
        private $user_id;
        private $beer_id;

        public function __construct($rating,$comment,$user_id,$beer_id){
            $this->rating=$rating;
            $this->comment=$comment;
            $this->user_id=$user_id;
            $this->beer_id=$beer_id;
        }
        public function getRating(){
            return $this->rating;
          }
          public function getComment(){
            return $this->comment;
          }
          public function getUserID(){
            return $this->user_id;
          }
          public function getBeerID(){
            return $this->beer_id;
          }
    }
?>
