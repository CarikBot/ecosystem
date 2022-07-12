<?php

// Gregorian to Hijriah Converter
class HijriCalendar
{
  function monthName($i) // $i = 1..12
  
  {
    static $month = array(
      "Muharram",
      "Syafar",
      "Rabiul Awal",
      "Rabiul Akhir",
      "Jumadil Awal",
      "Jumadil Akhir",
      "Rajab",
      "Sya'ban",
      "Ramadhan",
      "Syawal",
      "Dzulka'dah",
      "Dzulhijjah"
    );
    return $month[$i - 1];
  }

  function GregorianToHijri($time = null)
  {
    if ($time === null) $time = time();
    $m = date('m', $time);
    $d = date('d', $time);
    $y = date('Y', $time);

    return HijriCalendar::JDToHijri(cal_to_jd(CAL_GREGORIAN, $m, $d, $y));
  }

  function HijriToGregorian($m, $d, $y)
  {
    return jd_to_cal(CAL_GREGORIAN, HijriCalendar::HijriToJD($m, $d, $y));
  }

  # Julian Day Count To Hijri
  function JDToHijri($jd)
  {
    $jd = $jd - 1948440 + 10632;
    $n = (int)(($jd - 1) / 10631);
    $jd = $jd - 10631 * $n + 354;
    $j = ((int)((10985 - $jd) / 5316)) * ((int)(50 * $jd / 17719)) + ((int)($jd / 5670)) * ((int)(43 * $jd / 15238));
    $jd = $jd - ((int)((30 - $j) / 15)) * ((int)((17719 * $j) / 50)) - ((int)($j / 16)) * ((int)((15238 * $j) / 43)) + 29;
    $m = (int)(24 * $jd / 709);
    $d = $jd - (int)(709 * $m / 24);
    $y = 30 * $n + $j - 30;

    return array(
      $m,
      $d,
      $y
    );
  }

  # Hijri To Julian Day Count
  function HijriToJD($m, $d, $y)
  {
    return (int)((11 * $y + 3) / 30) + 354 * $y + 30 * $m - (int)(($m - 1) / 2) + $d + 1948440 - 385;
  }
};

