<?php

namespace app\models;

use Yii;
use yii\base\Security;

class Lib extends \yii\base\Model
{
    public static function date2Ind($str, $spasi = true)
    {
        $bulan = array(
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
        );

        $tgl = explode('-', $str);

        if (!empty($str) && isset($tgl[1])) {
            $index = (int) $tgl[1];
            if (isset($bulan[$index])) {
                $date = $tgl[2] . ' ' . $bulan[(int) $tgl[1]] . ' ' . $tgl[0];
                if ($spasi == true) {
                    return $date . "&nbsp;";
                } else {
                    return $date;
                }
            } else {
                return '';
            }
        } else {
            return '';
        }
    }

    public static function dateInd($ex, $day = true)
    {
        if ($ex == "0000-00-00" or empty($ex)) {
            return null;
        } else {
            $pecah = explode(" ", $ex);
            $nameofDay = '';
            if ($day == true) {
                $nameofDay = Lib::getNamaHari($pecah[0]) . ', ';
            } else {
                $nameofDay = '';
            }
            if (!empty($pecah[1])) {
                $tgl = $pecah[0];
                $tanggal = substr($tgl, 8, 2);
                $bulan = Lib::getBulan(substr($tgl, 5, 2));
                $tahun = substr($tgl, 0, 4);
                return $nameofDay . $tanggal . ' ' . $bulan . ' ' . $tahun . ' ' . $pecah[1] . ' WIB';
            } else {
                $tgl = $pecah[0];
                $tanggal = substr($tgl, 8, 2);
                $bulan = Lib::getBulan(substr($tgl, 5, 2));
                $tahun = substr($tgl, 0, 4);
                return $nameofDay . $tanggal . ' ' . $bulan . ' ' . $tahun;
            }
        }
    }

    public static function dateIndLaporan($ex, $day = true)
    {
        $pecah = explode(" ", $ex);
        $nameofDay = '';
        if ($day == true) {
            $nameofDay = Lib::getNamaHari($pecah[0]) . '';
        } else {
            $nameofDay = '';
        }
        if (!empty($pecah[1])) {
            $tgl = $pecah[0];
            $tanggal = substr($tgl, 8, 2);
            $bulan = Lib::getBulan(substr($tgl, 5, 2));
            $tahun = substr($tgl, 0, 4);
            return $nameofDay . "/" . $tanggal . ' ' . $bulan . ' ' . $tahun;
        } else {
            $tgl = $pecah[0];
            $tanggal = substr($tgl, 8, 2);
            $bulan = Lib::getBulan(substr($tgl, 5, 2));
            $tahun = substr($tgl, 0, 4);
            return $nameofDay . "/" . $tanggal . ' ' . $bulan . ' ' . $tahun;
        }
    }

    public static function dateInd1($ex, $day = true)
    {
        if ($ex == "0000-00-00" or empty($ex)) {
            return null;
        } else {
            $pecah = explode(" ", $ex);
            $nameofDay = '';
            if ($day == true) {
                $nameofDay = Lib::getNamaHari($pecah[0]) . ', ';
            } else {
                $nameofDay = '';
            }
            if (!empty($pecah[1])) {
                $tgl = $pecah[0];
                $tanggal = substr($tgl, 8, 2);
                $bulan = substr($tgl, 5, 2);
                $tahun = substr($tgl, 0, 4);
                return $nameofDay . $tanggal . '/' . $bulan . '/' . $tahun . '<br>(' . $pecah[1] . ' WIB)';
            } else {
                $tgl = $pecah[0];
                $tanggal = substr($tgl, 8, 2);
                $bulan = substr($tgl, 5, 2);
                $tahun = substr($tgl, 0, 4);
                return $nameofDay . $tanggal . '-' . $bulan . '-' . $tahun;
            }
        }
    }

    public static function cut_text($x, $n)
    {
        $kata = strtok(strip_tags($x), " ");
        $new = "";
        for ($i = 1; $i <= $n; $i++) {    //membatasi berapa kata yang akan ditampilkan di halaman utama
            $new .= $kata;        //tulis isi agenda
            $new .= " ";
            $kata = strtok(" ");
        }
        return $new;
    }


    public static function cek_img_tag($text, $original)
    {
        //membuat auto thumbnails
        @preg_match("/src=\"(.+)\"/", $text, $cocok);
        @$patern = explode("\"", $cocok[1]);
        $img = str_replace("\"/>", "", $patern[0]);
        $img = str_replace("../", "", $img);
        $img = str_replace("/>", "", $img);
        if ($img == "") {
            $img = $original;
        } else {
            $img = str_replace("\&quot;", "", $img);
        }

        return $img;
    }

    public static function simbolRemoving($title)
    {
        $linkbaru = strtolower($title);
        $tanda = array("|", ",", "\"", "'", ".", "(", ")", "-", "_", ":", ";", "?", "!", "@", "#", "\$", "%", "^", "&", "*", "+", "/", "\\", ">", "<", "\r", "\t", "\n");
        $rep = stripslashes(str_replace($tanda, "", $linkbaru));
        $rep = stripslashes(str_replace('  ', "-", $rep));
        $rep = stripslashes(str_replace(' ', "-", $rep));
        return $rep;
    }

    public static function getNamaHari($date)
    {
        $namahari = date('D', strtotime($date));
        //Function date(String1, strtotime(String2)); adalah fungsi untuk mendapatkan nama hari
        return Lib::getHari($namahari);
    }

    public static function getHari($hari)
    {
        switch ($hari) {
            case 'Mon':
                return "Senin";
                break;
            case 'Tue':
                return "Selasa";
                break;
            case 'Wed':
                return "Rabu";
                break;
            case 'Thu':
                return "Kamis";
                break;
            case 'Fri':
                return "Jumat";
                break;
            case 'Sat':
                return "Sabtu";
                break;
            case 'Sun':
                return "Minggu";
                break;
        }
    }
    public static function getBulan($bln)
    {
        switch ($bln) {
            case 1:
                return "Januari";
                break;
            case 2:
                return "Februari";
                break;
            case 3:
                return "Maret";
                break;
            case 4:
                return "April";
                break;
            case 5:
                return "Mei";
                break;
            case 6:
                return "Juni";
                break;
            case 7:
                return "Juli";
                break;
            case 8:
                return "Agustus";
                break;
            case 9:
                return "September";
                break;
            case 10:
                return "Oktober";
                break;
            case 11:
                return "November";
                break;
            case 12:
                return "Desember";
                break;
        }
    }

    public static function getBrowser()
    {
        $u_agent = $_SERVER['HTTP_USER_AGENT'];
        $bname = 'Unknown';
        $platform = 'Unknown';
        $version = "";

        //First get the platform?
        if (preg_match('/linux/i', $u_agent)) {
            $platform = 'linux';
        } elseif (preg_match('/macintosh|mac os x/i', $u_agent)) {
            $platform = 'mac';
        } elseif (preg_match('/windows|win32/i', $u_agent)) {
            $platform = 'windows';
        }

        // Next get the name of the useragent yes seperately and for good reason
        if (preg_match('/MSIE/i', $u_agent) && !preg_match('/Opera/i', $u_agent)) {
            $bname = 'Internet Explorer';
            $ub = "MSIE";
        } elseif (preg_match('/Firefox/i', $u_agent)) {
            $bname = 'Mozilla Firefox';
            $ub = "Firefox";
        } elseif (preg_match('/Chrome/i', $u_agent)) {
            $bname = 'Google Chrome';
            $ub = "Chrome";
        } elseif (preg_match('/Safari/i', $u_agent)) {
            $bname = 'Apple Safari';
            $ub = "Safari";
        } elseif (preg_match('/Opera/i', $u_agent)) {
            $bname = 'Opera';
            $ub = "Opera";
        } elseif (preg_match('/Netscape/i', $u_agent)) {
            $bname = 'Netscape';
            $ub = "Netscape";
        }

        // finally get the correct version number
        $known = array('Version', $ub, 'other');
        $pattern = '#(?<browser>' . join('|', $known) .
            ')[/ ]+(?<version>[0-9.|a-zA-Z.]*)#';
        if (!preg_match_all($pattern, $u_agent, $matches)) {
            // we have no matching number just continue
        }

        // see how many we have
        $i = count($matches['browser']);
        if ($i != 1) {
            //we will have two since we are not using 'other' argument yet
            //see if version is before or after the name
            if (strripos($u_agent, "Version") < strripos($u_agent, $ub)) {
                $version = $matches['version'][0];
            } else {
                $version = $matches['version'][1];
            }
        } else {
            $version = $matches['version'][0];
        }

        // check if we have a number
        if ($version == null || $version == "") {
            $version = "?";
        }
        $IP = $_SERVER['REMOTE_ADDR'];

        return array(
            'userAgent' => $u_agent,
            'name'      => $bname,
            'version'   => $version,
            'platform'  => $platform,
            'IP' => $IP,
        );
    }

    public static function selisih2tanggal($tgl1, $tgl2)
    {
        $pecah1 = explode("-", $tgl1);
        $date1 = $pecah1[2];
        $month1 = $pecah1[1];
        $year1 = $pecah1[0];

        // memecah tanggal untuk mendapatkan bagian tanggal, bulan dan tahun
        // dari tanggal kedua

        $pecah2 = explode("-", $tgl2);
        $date2 = $pecah2[2];
        $month2 = $pecah2[1];
        $year2 =  $pecah2[0];

        // menghitung JDN dari masing-masing tanggal

        $jd1 = GregorianToJD($month1, $date1, $year1);
        $jd2 = GregorianToJD($month2, $date2, $year2);

        // hitung selisih hari kedua tanggal

        $selisih = $jd2 - $jd1;

        return $selisih;
    }

    public static function anti_injection($d)
    {
        $f = (stripslashes(strip_tags(htmlspecialchars($d, ENT_QUOTES))));
        return $f;
    }

    public static function monthly()
    {
        return ['1' => 'Januari', '2' => 'Februari', '3' => 'Maret', '4' => 'April', '5' => 'Mei', '6' => 'Juni', '7' => 'Juli', '8' => 'Agustus', '9' => 'September', '10' => 'Oktober', '11' => 'November', '12' => 'Desember'];
    }

    public static function konvertBase64($url)
    {
        $path = \Yii::getAlias('@webroot') . $url;
        $type = pathinfo($path, PATHINFO_EXTENSION);
        $data = file_get_contents($path);
        $resultUrl = 'data:image/' . $type . ';base64,' . base64_encode($data);

        return $resultUrl;
    }

    public static function hashData($data)
    {
        $s = new Security();
        return $s->hashData($data, Yii::$app->params['other']['keys'] . date('Y-m-d'));
    }

    public static function validateData($data)
    {
        $s = new Security();
        return $s->validateData($data, Yii::$app->params['other']['keys'] . date('Y-m-d'));
    }
}
