<?php
    require_once("Bdd.php");
    class Categories extends Bdd {
        private $tbname = "categories";
        private static $tb_name = "categories";
        private $bdd = NULL;
        private $name;

        public function __construct($name) {
            $this->bdd = Parent::__construct();
            $this->name = $name;
            $sql = "INSERT INTO ".$this->get_tbname()."(name) VALUES(?)";

            $req = $this->bdd->prepare($sql);
            $req->execute([$this->name]);
            return true;
        }

        //______________________________________ Getters
        public function get_tbname() {
            return $this->tbname;
        }

        //_______________________________________
        

        public static function is_exist($name) {
            $bdd = Parent::get_conn();
            $sql = "SELECT * FROM ".self::$tb_name." WHERE name = ?";
            $req = $bdd->prepare($sql);
            $req->execute([$name]);

            if($req->rowCount() == 0) {
                return false;
            }
            return true;
        }

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
                        <option value="<?= $categories[$i]->id?>"><?= $categories[$i]->name?></option>
                    <?php endfor ;?>
                <?php endif ;?>
            </select>
    <?php }
    }