<?php
namespace App\Auth;

class TwoFactor {
    public static function generateSecret(int $length = 16): string {
        $chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ234567';
        $secret = '';
        for ($i=0; $i<$length; $i++) {
            $secret .= $chars[random_int(0, strlen($chars)-1)];
        }
        return $secret;
    }

    private static function base32Decode($b32) {
        $alphabet = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ234567';
        $b32 = strtoupper($b32);
        $l = strlen($b32);
        $n = 0;
        $j = 0;
        $binary = '';
        for ($i = 0; $i < $l; $i++) {
            $n = $n << 5;
            $n = $n + strpos($alphabet, $b32[$i]);
            $j += 5;
            if ($j >= 8) {
                $j -= 8;
                $binary .= chr(($n & (0xFF << $j)) >> $j);
            }
        }
        return $binary;
    }

    public static function getCode(string $secret, int $timeSlice = null): string {
        if ($timeSlice === null) {
            $timeSlice = floor(time() / 30);
        }
        $secretkey = self::base32Decode($secret);
        $time = pack("N*", 0) . pack("N*", $timeSlice);
        $hash = hash_hmac('sha1', $time, $secretkey, true);
        $offset = ord($hash[19]) & 0x0F;
        $truncatedHash = substr($hash, $offset, 4);
        $value = unpack("N", $truncatedHash)[1] & 0x7FFFFFFF;
        $modulo = 1000000;
        return str_pad($value % $modulo, 6, '0', STR_PAD_LEFT);
    }

    public static function verifyCode(string $secret, string $code, int $discrepancy = 1): bool {
        $current = floor(time() / 30);
        for ($i = -$discrepancy; $i <= $discrepancy; $i++) {
            if (self::getCode($secret, $current + $i) === $code) {
                return true;
            }
        }
        return false;
    }

    public static function getQrUrl(string $userEmail, string $secret, string $issuer = 'LabOOPPHP'): string {
        $otpauth = "otpauth://totp/{$issuer}:{$userEmail}?secret={$secret}&issuer={$issuer}";
        return $otpauth;
    }
}
