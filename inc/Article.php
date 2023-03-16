<?php
    require_once("Bdd.php");
    class Article extends Bdd {
        private $tbname = "article";
        private static $tb_name = "article";
        private $bdd = NULL;
        private $title;
        private $category_id;
        private $content;
        private $postImage;

        public function __construct($title, $content, $postImage, $category_id) {
            $this->bdd = Parent::__construct();
            $this->title = $title;
            $this->content = $content;
            $this->postImage = $postImage;
            $this->category_id = $category_id;

            $sql = "INSERT INTO ".$this->get_tbname()."(title, content, postImage, user_id, category_id) VALUES(?, ?, ?, ?, ?)";
            $req = $this->bdd->prepare($sql);
            $req->execute([$this->title, $this->content, $this->postImage, $_SESSION["user_id"], $this->category_id]);
            
            return true;
        }

        //______________________________________ Getters
        private function get_tbname() {
            return $this->tbname;
        }

        //_______________________________________
        

        //_______________________________________ Static Method
        private static function get_all_articles($order = "ASC") {
            $bdd = Parent::get_conn();
            $sql = "SELECT 
            utilisateurs.login AS author, 
            categories.name AS category, ".
            self::$tb_name.".* FROM ".self::$tb_name.
            " INNER JOIN utilisateurs ON ".self::$tb_name.".user_id = utilisateurs.id".
            " INNER JOIN categories ON ".self::$tb_name.".category_id = categories.id
            ORDER BY ".self::$tb_name.".postDate ".$order;
            $req = $bdd->prepare($sql);
            $req->execute();

            $res = $req->fetchAll(PDO::FETCH_OBJ);
            return $res;
        }

        private static function get_article_by_id($article_id) {
            $bdd = Parent::get_conn();
            $sql = "SELECT 
            utilisateurs.login AS author, 
            categories.name AS category, ".
            self::$tb_name.".* FROM ".self::$tb_name.
            " INNER JOIN utilisateurs ON ".self::$tb_name.".user_id = utilisateurs.id 
            INNER JOIN categories ON ".self::$tb_name.".category_id = categories.id 
            WHERE ".self::$tb_name.".id = ?";
            $req = $bdd->prepare($sql);
            $req->execute([$article_id]);

            $res = $req->fetchObject();
            return $res;
        }

        public static function display_all_articles($order) {
            $articles = self::get_all_articles($order);
            if($articles) :?>
            <section class="content">
                <div class="box-lien">
                    <a href="?order=ASC">ASC</a>
                    <a href="?order=DESC">DESC</a>
                </div>
                <?php for($i=0; isset($articles[$i]); $i++) :?>
                    <article class="article flex-c">
                        <div class="box-img">
                            <img src="assets/img/articles/<?=$articles[$i]->postImage?>" alt="<?= $articles[$i]->postImage?>">
                        </div>
                        <div class="info flex-r">
                            <p>title : <span><?= $articles[$i]->title?></span></p>
                            <p>category : <span><?= $articles[$i]->category?></span></p>
                            <p>author : <span><?= $articles[$i]->author?></span></p>
                            <p>postDate : <span><?= $articles[$i]->postDate?></span></p>
                        </div>
                        <div class="text flex-c">
                            <p>
                                <?= substr($articles[$i]->content, 0, 250)?> ...
                            </p>
                            <a class="path_lien btn-custom" href="page-article.php?article_id=<?= $articles[$i]->id?>" target="_blank">Lire plus</a>
                        </div>
                    </article>
                <?php endfor ;?>
                <?php else :?>
                    <h3>Accune article publier</h3>
                    <p>voulez-vous publier un article <a href="article.php" class="btn-custom">new_article</a></p>
                <?php endif ;?>
            </section>
    <?php }

        public static function display_article($article_id) {
            $article = self::get_article_by_id($article_id);
            if($article) :?>
            <section class="content">
                    <article class="article flex-c">
                        <div class="box-img">
                            <img src="assets/img/articles/<?=$article->postImage?>" alt="<?= $article->postImage?>">
                        </div>
                        <div class="info flex-r">
                            <p>title : <span><?= $article->title?></span></p>
                            <p>category : <span><?= $article->category?></span></p>
                            <p>author : <span><?= $article->author?></span></p>
                            <p>postDate : <span><?= $article->postDate?></span></p>
                        </div>
                        <div class="text">
                            <p> <?=$article->content?> </p>
                        </div>
                        <a href="articles.php" class="btn-custom">Articles List</a>
                    </article>
                <?php else :?>
                    <h3>article pas trouver (supprimer) !</h3>
                    <p>voulez-vous publier un article <a href="article.php">new_article</a></p>
                <?php endif ;?>
            </section>
        <?php }
    }