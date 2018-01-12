<?php

    class UUID
    {
        /**
        * ------------------------------------------------------------------------------------------------------
        * Version 4 UUIDs are pseudo-random
        * ------------------------------------------------------------------------------------------------------
        *  Usage
        * ------------------------------------------------------------------------------------------------------
        * include 'UUID.php';
        * ------------------------------------------------------------------------------------------------------
        * Pseudo-random UUID
        * $uuid = UUID::v4();
        *
        *       OR
        *
        * UUID::v4();
        * $uuid = UUID::v4();
        *
        * http://php.net/manual/en/language.oop5.static.php
        * ------------------------------------------------------------------------------------------------------
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

        /**
        * ------------------------------------------------------------------------------------------------------
        *  Using /dev/random
        * ------------------------------------------------------------------------------------------------------
        *  Usage
        * ------------------------------------------------------------------------------------------------------
        * include 'UUID.php';
        * ------------------------------------------------------------------------------------------------------
        * Pseudo-random UUID
        * $uuid = UUID::uuidSecure();
        *
        *       OR
        *
        * UUID::uuidSecure();
        * $uuid = UUID::uuidSecure();
        * ------------------------------------------------------------------------------------------------------
        */

        public static function uuidSecure() {

            $pr_bits = null;
            $fp = @fopen('/dev/urandom','rb');
            if ($fp !== false) {
                $pr_bits .= @fread($fp, 16);
                @fclose($fp);
            } else {
                $this->cakeError('randomNumber');
            }

            $time_low = bin2hex(substr($pr_bits,0, 4));
            $time_mid = bin2hex(substr($pr_bits,4, 2));
            $time_hi_and_version = bin2hex(substr($pr_bits,6, 2));
            $clock_seq_hi_and_reserved = bin2hex(substr($pr_bits,8, 2));
            $node = bin2hex(substr($pr_bits,10, 6));

            /**
             * Set the four most significant bits (bits 12 through 15) of the
             * time_hi_and_version field to the 4-bit version number from
             * Section 4.1.3.
             * @see http://tools.ietf.org/html/rfc4122#section-4.1.3
             */
            $time_hi_and_version = hexdec($time_hi_and_version);
            $time_hi_and_version = $time_hi_and_version >> 4;
            $time_hi_and_version = $time_hi_and_version | 0x4000;

            /**
             * Set the two most significant bits (bits 6 and 7) of the
             * clock_seq_hi_and_reserved to zero and one, respectively.
             */
            $clock_seq_hi_and_reserved = hexdec($clock_seq_hi_and_reserved);
            $clock_seq_hi_and_reserved = $clock_seq_hi_and_reserved >> 2;
            $clock_seq_hi_and_reserved = $clock_seq_hi_and_reserved | 0x8000;

            return sprintf('%08s-%04s-%04x-%04x-%012s',
                $time_low, $time_mid, $time_hi_and_version, $clock_seq_hi_and_reserved, $node);
        }
    }
?>
