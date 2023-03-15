<?php
    require_once("Bdd.php");
    class Categories extends Bdd {
        private $tbname = "categories";
        private static $tb_name = "categories";
        private $bdd = NULL;
        private $name;
        private $category_id;

        public function __construct($name, $category_id) {
            $this->bdd = Parent::__construct();
            $this->name = $name;
            $this->category_id = $category_id;
            $sql = "INSERT INTO ".$this->get_tbname()."(name, category_id, user_id) VALUES(?, ?, ?)";

            $req = $this->bdd->prepare($sql);
            $req->execute([$this->name, $this->category_id, $_SESSION["user_id"]]);
            return true;
        }

        //______________________________________ Getters
        public function get_tbname() {
            return $this->tbname;
        }

        //_______________________________________
        

        //_______________________________________ Static Method
        public static function get_all_categories() {
            $bdd = Parent::get_conn();
            $sql = "SELECT * FROM ".self::$tb_name;

            $req = $bdd->prepare($sql);
            $req->execute();
            $res = $req->fetchAll(PDO::FETCH_OBJ);
            return $res;
        }

        public static function display_categories() {
            $categories = self::get_all_categories();?>
            <select name="categories" id="categories">
                <option value="" default>chose category</option>
                <?php if($categories) :?>
                    <?php for($i=0; isset($categories[$i]); $i++) :?>
                        <option value="<?= $categories[$i]->name?>"><?= $categories[$i]->name?></option>
                    <?php endfor ;?>
                <?php endif ;?>
            </select>
    <?php }
    }