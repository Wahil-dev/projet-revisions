<?php
    class Authentication {
        // supprimer les espaces / transformer les tags html en text / back slash
        public static function process_input($inp) {
            $inp = trim($inp);
            $inp = stripslashes($inp);
            $inp = htmlspecialchars($inp);
            return $inp;
        }
        
        public static function is_valid_password($password) {
            $uppercase = preg_match("@[A-Z]@", $password);
            $lowercase = preg_match("@[a-z]@", $password);
            $number = preg_match("@[0-9]@", $password);
            $specialChars = preg_match("@[^\w]@", $password);
            $length = strlen($password) >= 8 && strlen($password) < 255;
            if(!$uppercase || !$lowercase || !$number || !$specialChars || !$length) {
                return false;
            }
            return true;
        }
        
        
        public static function is_valid_email($email) {
            return filter_var($email, FILTER_VALIDATE_EMAIL);
        }
        
        public static function delete_error_session() {
            foreach(array_keys($_SESSION) as $key) {
                if(str_contains($key, "Err")) {
                    unset($_SESSION[$key]);
                }
            }
        }
        
    }