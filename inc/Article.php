<?php
    require_once("Bdd.php");
    class Article extends Bdd {
        private $tbname = "article";
        private static $tb_name = "article";
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
        

        //_______________________________________ Static Method
        public static function get_all_articles() {
            $bdd = Parent::get_conn();

            $sql = "SELECT 
            utilisateurs.login AS author, ".
            self::$tb_name.".user_id, ".
            self::$tb_name.".title, ".
            self::$tb_name.".category, ".
            self::$tb_name.".content, ".
            self::$tb_name.".imagePath FROM ".self::$tb_name.
            " INNER JOIN utilisateurs ON ".
            self::$tb_name.".user_id = utilisateurs.id";

            $req = $bdd->prepare($sql);
            $req->execute();

            $res = $req->fetchAll(PDO::FETCH_OBJ);
            return $res;
        }

        public static function display_all_articles() {
            $articles = self::get_all_articles();
            if($articles) :?>
                <?php for($i=0; isset($articles[$i]); $i++) :?>
                    <article class="article">
                        <div class="info flex-r">
                            <p>title : <span><?= $articles[$i]->title?></span></p>
                            <p>category : <span><?= $articles[$i]->category?></span></p>
                            <p>author : <span><?= $articles[$i]->author?></span></p>
                        </div>
                        <div class="content">
                            <?= $articles[$i]->content?>
                        </div>
                    </article>
                <?php endfor ;?>
            <?php else :?>
                <h3>Accune article publier</h3>
                <p>voulez-vous publier un article <a href="new_article.php">new_article</a></p>
            <?php endif ;?>
        
    <?php }
        
    }