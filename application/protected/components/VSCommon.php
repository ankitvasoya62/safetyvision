<?php

class VSCommon extends CComponent {

    public static function formatSize($bytes) {
        if ($bytes < 1)
            return '';
        $s = array('bytes', 'KB', 'MB', 'GB', 'TB', 'PB');
        $e = floor(log($bytes) / log(1024));
        return sprintf('%.1f' . $s[$e], ($bytes / pow(1024, floor($e))));
    }

    public static function formateDateTime($date) {
        if ($date != 0) {
            return date("d.m.Y", $date);
        } else {
            return null;
        }
    }

    public static function getPlaceByIp($ip) {
        $result = 'Localhost';
        if (!empty($ip)) {
            $content = file_get_contents(Yii::app()->params->ip . $ip);
            if (!empty($content)) {
                $data = json_decode($content, TRUE);

                if ($data['status'] == 'success') {
                    $result = $data['city'] . '(' . $data['countryCode'] . ')';
                }
            }
        }
        return $result;
    }

    public static function checkSpotStatus($sdate, $edate, $stime, $etime) {
        $autoplay = 0;
        $now = $_SERVER['REQUEST_TIME'];
        $now_h_s = date('H:i', $now);
        if (!empty($edate)) {
            if ($sdate <= $now && $now <= $edate) {
                if (!empty($stime)) {
                    if (!empty($etime)) {
                        if ($stime <= $now_h_s && $now_h_s <= $etime) {
                            $autoplay = 1;
                        }
                    } else {
                        if ($stime <= $now_h_s) {
                            $autoplay = 1;
                        }
                    }
                } else {
                    if (!empty($etime)) {
                        if ($now_h_s <= $etime) {
                            $autoplay = 1;
                        }
                    } else {
                        $autoplay = 1;
                    }
                }
            }
        } else {
            if (!empty($stime)) {
                if (!empty($etime)) {
                    if ($stime <= $now_h_s && $now_h_s <= $etime) {
                        $autoplay = 1;
                    }
                } else {
                    if ($stime <= $now_h_s) {
                        $autoplay = 1;
                    }
                }
            } else {
                if (!empty($etime)) {
                    if ($now_h_s <= $etime) {
                        $autoplay = 1;
                    }
                } else {
                    $autoplay = 2;
                }
            }
        }
        return $autoplay;
    }

    public static function Show($data) {
        echo '<pre>';
        print_r($data);
        exit();
    }

}
