<?php

namespace common\helpers;

use app\models\User;
use app\models\UserRegister;
use app\models\StgSapDaily;
use yii;
use linslin\yii2\curl\Curl;
use yii\base\DynamicModel;
use setasign\Fpdi\Fpdi;
use Da\QrCode\QrCode;
use DateTime;

class Utils
{
    // Helper function to generate a 36-character VARCHAR UUID
    static function generateUuid()
    {
        return substr(md5(uniqid('', true)), 0, 36);
    }
    // public static function randNomor()
    // {
    //     $huruf = "ABCDEFGHJKLMNPQRTUVWXYZ";
    //     $digits = 10;
    //     return $huruf[\rand(0, 22)] . $huruf[\rand(0, 22)] . $huruf[\rand(0, 22)] . "_" . rand(pow(10, $digits - 1), pow(10, $digits) - 1);
    // }


    public static function titleRole($title)
    {
        $result = str_replace("_", " ", $title);
        return ucwords($result);
    }

    public static function generateInitial(string $name = null): string
    {
        if (!$name) {
            return "NN";
        }
        $words = explode(' ', $name);
        if (count($words) >= 2) {
            return mb_strtoupper(
                mb_substr($words[0], 0, 1, 'UTF-8') .
                    mb_substr(end($words), 0, 1, 'UTF-8'),
                'UTF-8'
            );
        }
        return Utils::makeInitialsFromSingleWord($name);
    }

    protected static function makeInitialsFromSingleWord(string $name): string
    {
        preg_match_all('#([A-Z]+)#', $name, $capitals);
        if (count($capitals[1]) >= 2) {
            return mb_substr(implode('', $capitals[1]), 0, 2, 'UTF-8');
        }
        return mb_strtoupper(mb_substr($name, 0, 2, 'UTF-8'), 'UTF-8');
    }

    public static function dateDiff(string $date)
    {
        $origin = new \DateTimeImmutable(date('Y-m-d'));
        $target = new \DateTimeImmutable($date);
        $interval = $origin->diff($target);
        return $interval->format('%a');
    }

    public static function convertArray($arr = [])
    {
        $result = [];
        foreach ($arr as $item) {
            $result[] = $item;
        }
        return $result;
    }

    public static function convertExcelDate($date)
    {
        if (is_int(($date))) {
            $dateConvert = ($date - 25569) * 86400;
        } else {
            return null;
        }
        return @gmdate("Y-m-d", (int) $dateConvert);
    }

    public static function YMBetweenDates($dateFrom, $dateTo)
    {
        $date1 = new DateTime($dateFrom);
        $date2 = new DateTime($dateTo);
        $interval = $date1->diff($date2);
        // return $interval->y;
        if ($interval->y > 0) {
            return $interval->y . "Y " . $interval->m . "M";
        } else {
            return $interval->m . "M";
        }
    }

    public static function YmdBetweenDates($dateFrom, $dateTo)
    {
        $date1 = new DateTime($dateFrom);
        $date2 = new DateTime($dateTo);
        $interval = $date1->diff($date2);
        // return $interval->y;
        if ($interval->y > 0) {
            return $interval->y . "Y " . $interval->m . "M " . $interval->m . "D";
        } else if ($interval->m > 0) {

            return $interval->y . "Y " . $interval->m . "M";
        } else {
            return $interval->d . "D";
        }
    }

    public static function CountHoursBetweenDates($dateFrom, $dateTo)
    {
        $date1 = new DateTime($dateFrom);
        $date2 = new DateTime($dateTo);
        $interval = $date1->diff($date2);
        return $interval->days * 24;
    }

    // public static function getYesterdayDate()
    // {
    //     $sdaily = StgSapDaily::find()->where(['is not', 'date', null])->orderBy('date desc')->one();
    //     return $sdaily->date;
    //     $today = new DateTime();
    //     $yesterday = $today->modify('-1 day');

    //     return $yesterday->format('Y-m-d');
    // }

    public static function monthIndonesia($month)
    {
        $months = [
            '01' => 'Januari',
            '02' => 'Februari',
            '03' => 'Maret',
            '04' => 'April',
            '05' => 'Mei',
            '06' => 'Juni',
            '07' => 'Juli',
            '08' => 'Agustus',
            '09' => 'September',
            1 => 'Januari',
            2 => 'Februari',
            3 => 'Maret',
            4 => 'April',
            5 => 'Mei',
            6 => 'Juni',
            7 => 'Juli',
            8 => 'Agustus',
            9 => 'September',
            10 => 'Oktober',
            11 => 'November',
            12 => 'Desember',
        ];
        return $months[$month];
    }

    static function lastDate($date)
    {
        return date('Y-m-t', strtotime($date));
    }
}
