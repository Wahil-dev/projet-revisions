<?php
    require_once("Bdd.php");
    class Article extends Bdd {
        private $tbname = "article";
        private static $tb_name = "article";
        private $bdd = NULL;
        private $title;
        private $category_id;
        private $content;
        private $image;

        public function __construct($title, $content, $image, $category_id) {
            $this->bdd = Parent::__construct();
            $this->title = $title;
            $this->content = $content;
            $this->image = $image;
            $this->category_id = $category_id;

            $sql = "INSERT INTO ".$this->get_tbname()."(title, content, imagePath, user_id, category_id) VALUES(?, ?, ?, ?, ?)";
            $req = $this->bdd->prepare($sql);
            $req->execute([$this->title, $this->content, $this->image, $_SESSION["user_id"], $this->category_id]);
            
            return true;
        }

        //______________________________________ Getters
        public function get_tbname() {
            return $this->tbname;
        }

        //_______________________________________
        

        //_______________________________________ Static Method
        public static function get_all_articles($order = "ASC") {
            $bdd = Parent::get_conn();

            $sql = "SELECT 
            utilisateurs.login AS author, 
            categories.name AS category, ".
            self::$tb_name.".user_id, ".
            self::$tb_name.".title, ".
            self::$tb_name.".category_id, ".
            self::$tb_name.".content, ".
            self::$tb_name.".postDate, ".
            self::$tb_name.".imagePath FROM ".self::$tb_name.
            " INNER JOIN utilisateurs ON ".self::$tb_name.".user_id = utilisateurs.id".
            " INNER JOIN categories ON ".self::$tb_name.".category_id = categories.id
            ORDER BY ".self::$tb_name.".postDate ".$order;

            $req = $bdd->prepare($sql);
            $req->execute();

            $res = $req->fetchAll(PDO::FETCH_OBJ);
            return $res;
        }

        public static function display_all_articles($order) {
            $articles = self::get_all_articles($order);
            if($articles) :?>
                <?php for($i=0; isset($articles[$i]); $i++) :?>
                    <article class="article">
                        <div class="info flex-r">
                            <p>title : <span><?= $articles[$i]->title?></span></p>
                            <p>category : <span><?= $articles[$i]->category?></span></p>
                            <p>author : <span><?= $articles[$i]->author?></span></p>
                            <p>postDate : <span><?= $articles[$i]->postDate?></span></p>
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