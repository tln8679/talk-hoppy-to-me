<?php class Beer {
    private $beer_name;
    private $beer_maker;
    private $description;
    private $location;
    private $rating;
    private $abv;
    private $ibu;
    private $style;

    public function __construct($beer_name,$beer_maker,$description,$location,$rating,$abv,$ibu,$style){
        $this->beer_name=$beer_name;
        $this->beer_maker=$beer_maker;
        $this->description=$description;
        $this->location=$location;
        $this->rating=$rating;
        $this->abv=$abv;
        $this->ibu=$ibu;
        $this->style=$style;
    }

    public function get_beer_name(){
        return $this->beer_name;
    }
    public function get_beer_maker(){
        return $this->beer_maker;
    }
    public function get_description(){
        return $this->description;
    }
    public function get_location(){
        return $this->location;
    }
    public function get_rating(){
        return $this->beer_name;
    }
    public function get_abv(){
        return $this->abv;
    }
    public function get_ibu(){
        return $this->ibu;
    }
    public function get_style(){
        return $this->style;
    }
}
?>
