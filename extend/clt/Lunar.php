<?php

namespace clt;
class Lunar
{
    var $MIN_YEAR = 1891;
    var $MAX_YEAR = 2100;
    var $lunarInfo = array(
        array(0, 2, 9, 21936), array(6, 1, 30, 9656), array(0, 2, 17, 9584), array(0, 2, 6, 21168), array(5, 1, 26, 43344), array(0, 2, 13, 59728),
        array(0, 2, 2, 27296), array(3, 1, 22, 44368), array(0, 2, 10, 43856), array(8, 1, 30, 19304), array(0, 2, 19, 19168), array(0, 2, 8, 42352),
        array(5, 1, 29, 21096), array(0, 2, 16, 53856), array(0, 2, 4, 55632), array(4, 1, 25, 27304), array(0, 2, 13, 22176), array(0, 2, 2, 39632),
        array(2, 1, 22, 19176), array(0, 2, 10, 19168), array(6, 1, 30, 42200), array(0, 2, 18, 42192), array(0, 2, 6, 53840), array(5, 1, 26, 54568),
        array(0, 2, 14, 46400), array(0, 2, 3, 54944), array(2, 1, 23, 38608), array(0, 2, 11, 38320), array(7, 2, 1, 18872), array(0, 2, 20, 18800),
        array(0, 2, 8, 42160), array(5, 1, 28, 45656), array(0, 2, 16, 27216), array(0, 2, 5, 27968), array(4, 1, 24, 44456), array(0, 2, 13, 11104),
        array(0, 2, 2, 38256), array(2, 1, 23, 18808), array(0, 2, 10, 18800), array(6, 1, 30, 25776), array(0, 2, 17, 54432), array(0, 2, 6, 59984),
        array(5, 1, 26, 27976), array(0, 2, 14, 23248), array(0, 2, 4, 11104), array(3, 1, 24, 37744), array(0, 2, 11, 37600), array(7, 1, 31, 51560),
        array(0, 2, 19, 51536), array(0, 2, 8, 54432), array(6, 1, 27, 55888), array(0, 2, 15, 46416), array(0, 2, 5, 22176), array(4, 1, 25, 43736),
        array(0, 2, 13, 9680), array(0, 2, 2, 37584), array(2, 1, 22, 51544), array(0, 2, 10, 43344), array(7, 1, 29, 46248), array(0, 2, 17, 27808),
        array(0, 2, 6, 46416), array(5, 1, 27, 21928), array(0, 2, 14, 19872), array(0, 2, 3, 42416), array(3, 1, 24, 21176), array(0, 2, 12, 21168),
        array(8, 1, 31, 43344), array(0, 2, 18, 59728), array(0, 2, 8, 27296), array(6, 1, 28, 44368), array(0, 2, 15, 43856), array(0, 2, 5, 19296),
        array(4, 1, 25, 42352), array(0, 2, 13, 42352), array(0, 2, 2, 21088), array(3, 1, 21, 59696), array(0, 2, 9, 55632), array(7, 1, 30, 23208),
        array(0, 2, 17, 22176), array(0, 2, 6, 38608), array(5, 1, 27, 19176), array(0, 2, 15, 19152), array(0, 2, 3, 42192), array(4, 1, 23, 53864),
        array(0, 2, 11, 53840), array(8, 1, 31, 54568), array(0, 2, 18, 46400), array(0, 2, 7, 46752), array(6, 1, 28, 38608), array(0, 2, 16, 38320),
        array(0, 2, 5, 18864), array(4, 1, 25, 42168), array(0, 2, 13, 42160), array(10, 2, 2, 45656), array(0, 2, 20, 27216), array(0, 2, 9, 27968),
        array(6, 1, 29, 44448), array(0, 2, 17, 43872), array(0, 2, 6, 38256), array(5, 1, 27, 18808), array(0, 2, 15, 18800), array(0, 2, 4, 25776),
        array(3, 1, 23, 27216), array(0, 2, 10, 59984), array(8, 1, 31, 27432), array(0, 2, 19, 23232), array(0, 2, 7, 43872), array(5, 1, 28, 37736),
        array(0, 2, 16, 37600), array(0, 2, 5, 51552), array(4, 1, 24, 54440), array(0, 2, 12, 54432), array(0, 2, 1, 55888), array(2, 1, 22, 23208),
        array(0, 2, 9, 22176), array(7, 1, 29, 43736), array(0, 2, 18, 9680), array(0, 2, 7, 37584), array(5, 1, 26, 51544), array(0, 2, 14, 43344),
        array(0, 2, 3, 46240), array(4, 1, 23, 46416), array(0, 2, 10, 44368), array(9, 1, 31, 21928), array(0, 2, 19, 19360), array(0, 2, 8, 42416),
        array(6, 1, 28, 21176), array(0, 2, 16, 21168), array(0, 2, 5, 43312), array(4, 1, 25, 29864), array(0, 2, 12, 27296), array(0, 2, 1, 44368),
        array(2, 1, 22, 19880), array(0, 2, 10, 19296), array(6, 1, 29, 42352), array(0, 2, 17, 42208), array(0, 2, 6, 53856), array(5, 1, 26, 59696),
        array(0, 2, 13, 54576), array(0, 2, 3, 23200), array(3, 1, 23, 27472), array(0, 2, 11, 38608), array(11, 1, 31, 19176), array(0, 2, 19, 19152),
        array(0, 2, 8, 42192), array(6, 1, 28, 53848), array(0, 2, 15, 53840), array(0, 2, 4, 54560), array(5, 1, 24, 55968), array(0, 2, 12, 46496),
        array(0, 2, 1, 22224), array(2, 1, 22, 19160), array(0, 2, 10, 18864), array(7, 1, 30, 42168), array(0, 2, 17, 42160), array(0, 2, 6, 43600),
        array(5, 1, 26, 46376), array(0, 2, 14, 27936), array(0, 2, 2, 44448), array(3, 1, 23, 21936), array(0, 2, 11, 37744), array(8, 2, 1, 18808),
        array(0, 2, 19, 18800), array(0, 2, 8, 25776), array(6, 1, 28, 27216), array(0, 2, 15, 59984), array(0, 2, 4, 27424), array(4, 1, 24, 43872),
        array(0, 2, 12, 43744), array(0, 2, 2, 37600), array(3, 1, 21, 51568), array(0, 2, 9, 51552), array(7, 1, 29, 54440), array(0, 2, 17, 54432),
        array(0, 2, 5, 55888), array(5, 1, 26, 23208), array(0, 2, 14, 22176), array(0, 2, 3, 42704), array(4, 1, 23, 21224), array(0, 2, 11, 21200),
        array(8, 1, 31, 43352), array(0, 2, 19, 43344), array(0, 2, 7, 46240), array(6, 1, 27, 46416), array(0, 2, 15, 44368), array(0, 2, 5, 21920),
        array(4, 1, 24, 42448), array(0, 2, 12, 42416), array(0, 2, 2, 21168), array(3, 1, 22, 43320), array(0, 2, 9, 26928), array(7, 1, 29, 29336),
        array(0, 2, 17, 27296), array(0, 2, 6, 44368), array(5, 1, 26, 19880), array(0, 2, 14, 19296), array(0, 2, 3, 42352), array(4, 1, 24, 21104),
        array(0, 2, 10, 53856), array(8, 1, 30, 59696), array(0, 2, 18, 54560), array(0, 2, 7, 55968), array(6, 1, 27, 27472), array(0, 2, 15, 22224),
        array(0, 2, 5, 19168), array(4, 1, 25, 42216), array(0, 2, 12, 42192), array(0, 2, 1, 53584), array(2, 1, 21, 55592), array(0, 2, 9, 54560)
    );

    /**
     * ????????????????????????
     * @param year ??????-???
     * @param month ??????-???
     * @param date ??????-???
     */
    function convertSolarToLunar($year, $month, $date)
    {
//debugger;
        $yearData = $this->lunarInfo[$year - $this->MIN_YEAR];
        if ($year == $this->MIN_YEAR && $month <= 2 && $date <= 9) return array(1891, '??????', '??????', '??????', 1, 1, '???');
        return $this->getLunarByBetween($year, $this->getDaysBetweenSolar($year, $month, $date, $yearData[1], $yearData[2]));
    }

    function convertSolarMonthToLunar($year, $month)
    {
        $yearData = $this->lunarInfo[$year - $this->MIN_YEAR];
        if ($year == $this->MIN_YEAR && $month <= 2 && $date <= 9) return array(1891, '??????', '??????', '??????', 1, 1, '???');
        $month_days_ary = array(31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31);
        $dd = $month_days_ary[$month];
        if ($this->isLeapYear($year) && $month == 2) $dd++;
        $lunar_ary = array();
        for ($i = 1; $i < $dd; $i++) {
            $array = $this->getLunarByBetween($year, $this->getDaysBetweenSolar($year, $month, $i, $yearData[1], $yearData[2]));
            $array[] = $year . '-' . $month . '-' . $i;
            $lunar_ary[$i] = $array;
        }
        return $lunar_ary;
    }

    /**
     * ????????????????????????
     * @param year ??????-???
     * @param month ??????-?????????????????????????????????????????????????????????????????????????????????????????????????????????13??????????????????????????????13??????????????????0
     * @param date ??????-???
     */
    function convertLunarToSolar($year, $month, $date)
    {
        $yearData = $this->lunarInfo[$year - $this->MIN_YEAR];
        $between = $this->getDaysBetweenLunar($year, $month, $date);
        $res = mktime(0, 0, 0, $yearData[1], $yearData[2], $year);
        $res = date('Y-m-d', $res + $between * 24 * 60 * 60);
        $day = explode('-', $res);
        $year = $day[0];
        $month = $day[1];
        $day = $day[2];
        return array($year, $month, $day);
    }

    /**
     * ?????????????????????
     * @param year
     */
    function isLeapYear($year)
    {
        return (($year % 4 == 0 && $year % 100 != 0) || ($year % 400 == 0));
    }

    /**
     * ??????????????????
     * @param year
     */
    function getLunarYearName($year)
    {
        $sky = array('???', '???', '???', '???', '???', '???', '???', '???', '???', '???');
        $earth = array('???', '???', '???', '???', '???', '???', '???', '???', '???', '???', '???', '???');
        $year = $year . '';
        return $sky[$year{3}] . $earth[$year % 12];
    }

    /**
     * ???????????????????????????
     * @param year ?????????
     */
    function getYearZodiac($year)
    {
        $zodiac = array('???', '???', '???', '???', '???', '???', '???', '???', '???', '???', '???', '???');
        return $zodiac[$year % 12];
    }

    /**
     * ???????????????????????????
     * @param year ??????-???
     * @param month ??????-???
     */
    function getSolarMonthDays($year, $month)
    {
        $monthHash = array('1' => 31, '2' => $this->isLeapYear($year) ? 29 : 28, '3' => 31, '4' => 30, '5' => 31, '6' => 30, '7' => 31, '8' => 31, '9' => 30, '10' => 31, '11' => 30, '12' => 31);
        return $monthHash["$month"];
    }

    /**
     * ???????????????????????????
     * @param year ??????-???
     * @param month ??????-?????????????????????
     */
    function getLunarMonthDays($year, $month)
    {
        $monthData = $this->getLunarMonths($year);
        return $monthData[$month - 1];
    }

    /**
     * ????????????????????????????????????
     * @param year
     */
    function getLunarMonths($year)
    {
        $yearData = $this->lunarInfo[$year - $this->MIN_YEAR];
        $leapMonth = $yearData[0];
        $bit = decbin($yearData[3]);
        for ($i = 0; $i < strlen($bit); $i++) $bitArray[$i] = substr($bit, $i, 1);
        for ($k = 0, $klen = 16 - count($bitArray); $k < $klen; $k++) array_unshift($bitArray, '0');
        $bitArray = array_slice($bitArray, 0, ($leapMonth == 0 ? 12 : 13));
        for ($i = 0; $i < count($bitArray); $i++) $bitArray[$i] = $bitArray[$i] + 29;
        return $bitArray;
    }

    /**
     * ???????????????????????????
     * @param year ????????????
     */
    function getLunarYearDays($year)
    {
        $yearData = $this->lunarInfo[$year - $this->MIN_YEAR];
        $monthArray = $this->getLunarYearMonths($year);
        $len = count($monthArray);
        return ($monthArray[$len - 1] == 0 ? $monthArray[$len - 2] : $monthArray[$len - 1]);
    }

    function getLunarYearMonths($year)
    {
//debugger;
        $monthData = $this->getLunarMonths($year);
        $res = array();
        $temp = 0;
        $yearData = $this->lunarInfo[$year - $this->MIN_YEAR];
        $len = ($yearData[0] == 0 ? 12 : 13);
        for ($i = 0; $i < $len; $i++) {
            $temp = 0;
            for ($j = 0; $j <= $i; $j++) $temp += $monthData[$j];
            array_push($res, $temp);
        }
        return $res;
    }

    /**
     * ????????????
     * @param year ????????????
     */
    function getLeapMonth($year)
    {
        $yearData = $this->lunarInfo[$year - $this->MIN_YEAR];
        return $yearData[0];
    }

    /**
     * ????????????????????????????????????????????????
     * @param year
     * @param month
     * @param date
     */
    function getDaysBetweenLunar($year, $month, $date)
    {
        $yearMonth = $this->getLunarMonths($year);
        $res = 0;
        for ($i = 1; $i < $month; $i++) $res += $yearMonth[$i - 1];
        $res += $date - 1;
        return $res;
    }

    /**
     * ??????2??????????????????????????????
     * @param year ?????????
     * @param cmonth
     * @param cdate
     * @param dmonth ?????????????????????????????????
     * @param ddate ?????????????????????????????????
     */
    function getDaysBetweenSolar($year, $cmonth, $cdate, $dmonth, $ddate)
    {
        $a = mktime(0, 0, 0, $cmonth, $cdate, $year);
        $b = mktime(0, 0, 0, $dmonth, $ddate, $year);
        return ceil(($a - $b) / 24 / 3600);
    }

    /**
     * ???????????????????????????????????????????????????
     * @param year ?????????
     * @param between ??????
     */
    function getLunarByBetween($year, $between)
    {
//debugger;
        $lunarArray = array();
        $yearMonth = array();
        $t = 0;
        $e = 0;
        $leapMonth = 0;
        $m = '';
        if ($between == 0) {
            array_push($lunarArray, $year, '??????', '??????');
            $t = 1;
            $e = 1;
        } else {
            $year = $between > 0 ? $year : ($year - 1);
            $yearMonth = $this->getLunarYearMonths($year);
            $leapMonth = $this->getLeapMonth($year);
            $between = $between > 0 ? $between : ($this->getLunarYearDays($year) + $between);
            for ($i = 0; $i < 13; $i++) {
                if ($between == $yearMonth[$i]) {
                    $t = $i + 2;
                    $e = 1;
                    break;
                } else if ($between < $yearMonth[$i]) {
                    $t = $i + 1;
                    $e = $between - (empty($yearMonth[$i - 1]) ? 0 : $yearMonth[$i - 1]) + 1;
                    break;
                }
            }
            $m = ($leapMonth != 0 && $t == $leapMonth + 1) ? ('???' . $this->getCapitalNum($t - 1, true)) : $this->getCapitalNum(($leapMonth != 0 && $leapMonth + 1 < $t ? ($t - 1) : $t), true);
            array_push($lunarArray, $year, $m, $this->getCapitalNum($e, false));
        }
        array_push($lunarArray, $this->getLunarYearName($year));// ????????????
        array_push($lunarArray, $t, $e);
        array_push($lunarArray, $this->getYearZodiac($year));// 12??????
        array_push($lunarArray, $leapMonth);// ?????????
        return $lunarArray;
    }

    /**
     * ???????????????????????????
     * @param num ??????
     * @param isMonth ????????????????????????
     */
    function getCapitalNum($num, $isMonth)
    {
        $isMonth = $isMonth || false;
        $dateHash = array('0' => '', '1' => '1', '2' => '2', '3' => '3', '4' => '4', '5' => '5', '6' => '6', '7' => '7', '8' => '8', '9' => '9', '10' => '0 ');
        $monthHash = array('0' => '', '1' => '01', '2' => '02', '3' => '03', '4' => '04', '5' => '05', '6' => '06', '7' => '07', '8' => '08', '9' => '09', '10' => '10', '11' => '11', '12' => '12');
        $res = '';
        if ($isMonth) $res = $monthHash[$num];
        else {
            if ($num <= 10) $res = '0' . $dateHash[$num];
            else if ($num > 10 && $num < 20) $res = '1' . $dateHash[$num - 10];
            else if ($num == 20) $res = "20";
            else if ($num > 20 && $num < 30) $res = "2" . $dateHash[$num - 20];
            else if ($num == 30) $res = "30";
        }
        return $res;
    }

    /*
    * ??????????????????
    */
    function getJieQi($_year, $month, $day)
    {
        $year = substr($_year, -2) + 0;
        $coefficient = array(
            array(5.4055, 2019, -1),//??????
            array(20.12, 2082, 1),//??????
            array(3.87),//??????
            array(18.74, 2026, -1),//??????
            array(5.63),//??????
            array(20.646, 2084, 1),//??????
            array(4.81),//??????
            array(20.1),//??????
            array(5.52, 1911, 1),//??????
            array(21.04, 2008, 1),//??????
            array(5.678, 1902, 1),//??????
            array(21.37, 1928, 1),//??????
            array(7.108, 2016, 1),//??????
            array(22.83, 1922, 1),//??????
            array(7.5, 2002, 1),//??????
            array(23.13),//??????
            array(7.646, 1927, 1),//??????
            array(23.042, 1942, 1),//??????
            array(8.318),//??????
            array(23.438, 2089, 1),//??????
            array(7.438, 2089, 1),//??????
            array(22.36, 1978, 1),//??????
            array(7.18, 1954, 1),//??????
            array(21.94, 2021, -1)//??????
        );
        $term_name = array(
            "??????", "??????", "??????", "??????", "??????", "??????", "??????", "??????",
            "??????", "??????", "??????", "??????", "??????", "??????", "??????", "??????",
            "??????", "??????", "??????", "??????", "??????", "??????", "??????", "??????");

        $idx1 = ($month - 1) * 2;
        $_leap_value = floor(($year - 1) / 4);
        $day1 = floor($year * 0.2422 + $coefficient[$idx1][0]) - $_leap_value;
        if (isset($coefficient[$idx1][1]) && $coefficient[$idx1][1] == $_year) $day1 += $coefficient[$idx1][2];
        $day2 = floor($year * 0.2422 + $coefficient[$idx1 + 1][0]) - $_leap_value;
        if (isset($coefficient[$idx1 + 1][1]) && $coefficient[$idx1 + 1][1] == $_year) $day1 += $coefficient[$idx1 + 1][2];

//echo __FILE__.'->'.__LINE__.' $day1='.$day1,',$day2='.$day2.'<br/>'.chr(10);
        $data = array();
        if ($day < $day1) {
            $data['name1'] = $term_name[$idx1 - 1];
            $data['name2'] = $term_name[$idx1 - 1] . '???';
        } else if ($day == $day1) {
            $data['name1'] = $term_name[$idx1];
            $data['name2'] = $term_name[$idx1];
        } else if ($day > $day1 && $day < $day2) {
            $data['name1'] = $term_name[$idx1];
            $data['name2'] = $term_name[$idx1] . '???';
        } else if ($day == $day2) {
            $data['name1'] = $term_name[$idx1 + 1];
            $data['name2'] = $term_name[$idx1 + 1];
        } else if ($day > $day2) {
            $data['name1'] = $term_name[$idx1 + 1];
            $data['name2'] = $term_name[$idx1 + 1] . '???';
        }
        return $data;
    }

    /*
    * ????????????????????????????????????????????????????????????
    */
    function getFestival($today, $nl_info = false, $config = 1)
    {
        if ($config == 1) {
            $arr_lunar = array('01-01' => '??????', '01-15' => '?????????', '02-02' => '?????????', '05-05' => '?????????', '07-07' => '?????????', '08-15' => '?????????', '09-09' => '?????????', '12-08' => '?????????', '12-23' => '??????');
            $arr_solar = array('01-01' => '??????', '02-14' => '?????????', '03-12' => '?????????', '04-01' => '?????????', '05-01' => '?????????', '06-01' => '?????????', '10-01' => '?????????', '10-31' => '?????????', '12-24' => '?????????', '12-25' => '?????????');
        }//????????????????????????????????????$config,????????????$arr_lunar???$arr_solar

        $festivals = array();

        list($y, $m, $d) = explode('-', $today);
        if (!$nl_info) $nl_info = $this->convertSolarToLunar($y, intval($m), intval($d));

        if ($nl_info[7] > 0 && $nl_info[7] < $nl_info[4]) $nl_info[4] -= 1;
        $md_lunar = substr('0' . $nl_info[4], -2) . '-' . substr('0' . $nl_info[5], -2);
        $md_solar = substr_replace($today, '', 0, 5);

        isset($arr_lunar[$md_lunar]) ? array_push($festivals, $arr_lunar[$md_lunar]) : '';
        isset($arr_solar[$md_solar]) ? array_push($festivals, $arr_solar[$md_solar]) : '';

        $glweek = date("w", strtotime($today));    //0-6

        if ($m == 5 && ($d > 7) && ($d < 15) && ($glweek == 0)) array_push($festivals, "?????????");
        if ($m == 6 && ($d > 14) && ($d < 22) && ($glweek == 0)) array_push($festivals, "?????????");

        $jieqi = $this->getJieQi($y, $m, $d);
        if ($jieqi) array_push($festivals, $jieqi);
        return implode('/', $festivals);
    }

    /*
    * ????????????????????????????????????
    @param int $time  ?????????
    */
    function getTheHour($h)
    {
        $d = $h;
        if ($d == 23 || $d == 0) {
            return '??????';
        } else if ($d == 1 || $d == 2) {
            return '??????';
        } else if ($d == 3 || $d == 4) {
            return '??????';
        } else if ($d == 5 || $d == 6) {
            return '??????';
        } else if ($d == 7 || $d == 8) {
            return '??????';
        } else if ($d == 9 || $d == 10) {
            return '??????';
        } else if ($d == 11 || $d == 12) {
            return '??????';
        } else if ($d == 13 || $d == 14) {
            return '??????';
        } else if ($d == 15 || $d == 16) {
            return '??????';
        } else if ($d == 17 || $d == 18) {
            return '??????';
        } else if ($d == 19 || $d == 20) {
            return '??????';
        } else if ($d == 21 || $d == 22) {
            return '??????';
        }
    }
}
/*$lunar=new Lunar();//
$month=$lunar->getJieQi(2017,05,13);//????????????????????????
echo '<pre>';
print_r($month);*/