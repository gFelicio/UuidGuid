<?php
    /**
        *----------------------------------------------------------------------------------------
        * UUID class
        *
        * @author Andrew Moore
        * @link http://www.php.net/manual/en/function.uniqid.php#94959
        *
        *----------------------------------------------------------------------------------------
        *  Usage
        * ---------------------------------------------------------------------------------------
        *
        * include 'UUID.php';
        *
        * ---------------------------------------------------------------------------------------
        *
        * Pseudo-random UUID
        * $v4uuid = UUID::v4();
        *
        *       OR
        *
        * UUID::v4();
        * $uuid = UUID::v4();
        *
        *
        * http://php.net/manual/en/language.oop5.static.php
        *
        * ---------------------------------------------------------------------------------------
    */

    class UUID
    {
        /*
            *----------------------------------------------------------------------------------
            * Generate v4 UUID
            *----------------------------------------------------------------------------------
            * Version 4 UUIDs are pseudo-random.
            *----------------------------------------------------------------------------------
        */

        public static function v4()
        {
            return sprintf('%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
                // 32 bits for "time_low"
                mt_rand(0, 0xffff), mt_rand(0, 0xffff),
                // 16 bits for "time_mid"
                mt_rand(0, 0xffff),
                // 16 bits for "time_hi_and_version",
                // four most significant bits holds version number 4
                mt_rand(0, 0x0fff) | 0x4000,
                // 16 bits, 8 bits for "clk_seq_hi_res",
                // 8 bits for "clk_seq_low",
                // two most significant bits holds zero and one for variant DCE1.1
                mt_rand(0, 0x3fff) | 0x8000,
                // 48 bits for "node"
                mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff)
            );
        }

        public static function is_valid($uuid)
        {
            return preg_match('/^\{?[0-9a-f]{8}\-?[0-9a-f]{4}\-?[0-9a-f]{4}\-?'.
            '[0-9a-f]{4}\-?[0-9a-f]{12}\}?$/i', $uuid) === 1;
        }

        /*
            *----------------------------------------------------------------------------------
            * Somewhat fake UUIDv4 OR another function to create version 4 UUIDs
            * Somewhat fake because a TRUE v4 UUID have two fields set with predefined values
            * This function randomizes every field in the generated UUID
            *----------------------------------------------------------------------------------
            * Generate XXXXXXXX-XXXX-XXXX-XXXX-XXXXXXXXXXXX style unique id,
            * (8 letters)-(4 letters)-(4 letters)-(4 letters)-(12 letters)
            *----------------------------------------------------------------------------------
            * USAGE
            *----------------------------------------------------------------------------------
            * $Guid = guid();
            * echo $Guid;
            * echo "<br>";
            *----------------------------------------------------------------------------------
        */

        public static function guid()
        {
            $salt = strtoupper(crypt(uniqid(mt_rand(),true)));
            $gen =
            substr($salt,0,8) . '-' .
            substr($salt,8,4) . '-' .
            substr($salt,12,4). '-' .
            substr($salt,16,4). '-' .
            substr($salt,20);

            return $gen;
        }
    }
?>
