<?php
    require_once("Bdd.php");
    class Article extends Bdd {
        private $tbname = "article";
        private $bdd = NULL;
        private $title;
        private $category;
        private $content;
        private $image;

        public function __construct($title, $category, $content, $image) {
            $this->bdd = Parent::__construct();
            $this->title = $title;
            $this->content = $content;
            $this->image = $image;
            $this->category = $category;

            $sql = "INSERT INTO ".$this->get_tbname()."(title, category, content, imagePath, user_id) VALUES(?, ?, ?, ?, ?)";
            $req = $this->bdd->prepare($sql);
            $req->execute([$this->title, $this->category, $this->content, $this->image, $_SESSION["user_id"]]);
            
            return true;
        }

        //______________________________________ Getters
        public function get_tbname() {
            return $this->tbname;
        }


        //_______________________________________
        
    }