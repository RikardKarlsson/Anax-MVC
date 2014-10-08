<?php 
// -------------------------------------------------------------------------------------------
//
// Function to open and read a directory, return its content as an array.
//
// $aPath: A path to the directory to scan for files. 
// 
//  http://php.net/manual/en/function.is-dir.php
//  http://php.net/manual/en/function.opendir.php
//  http://php.net/manual/en/function.readdir.php
//  http://php.net/manual/en/function.is-file.php
//  http://php.net/manual/en/function.closedir.php
//  http://php.net/manual/en/function.sort.php
//  
function readDirectory($aPath) {
  $list = Array();
  if(is_dir($aPath)) {
    if ($dh = opendir($aPath)) {
      while (($file = readdir($dh)) !== false) {
        if(is_file("$aPath/$file") && $file != '.htaccess') {
          $list[$file] = "$file";
        }
      }
      closedir($dh);
    }
  }
  sort($list, SORT_STRING);
  return $list;
}

date_default_timezone_set("Europe/Stockholm");
$year = date('Y'); //example 2013
$month = date('n'); //example 3
if ( isset($_GET['year']) ) {
    if ( \RikardKarlsson\Calendar\CDateUtil::isValidYear($_GET['year'])) {
        $year = $_GET['year'];
    }
}
if ( isset($_GET['month']) ) {
    if ( \RikardKarlsson\Calendar\CDateUtil::isValidMonth($_GET['month'])) {
        $month = $_GET['month'];
    }
}
//button next pressed
if ( isset($_GET['btn_next']) && $_GET['btn_next'] == 'next' ) {
    if ( isset($_GET['month']) ) {
        if ( \RikardKarlsson\Calendar\CDateUtil::isValidMonth($_GET['month'])) {
            //var_dump($month);
            $month = 1 + $_GET['month'];
            //var_dump($month);
            if ( $month > 12 ) {
                $month = 1;
                $year += 1;
            }
        }
    }
    //echo "next";
}

//button previous pressed
if ( isset($_GET['btn_previous']) && $_GET['btn_previous'] == 'previous' ) {
    if ( isset($_GET['month']) ) {
        if ( \RikardKarlsson\Calendar\CDateUtil::isValidMonth($_GET['month'])) {
            $month = $_GET['month'] - 1;
            if ( $month < 1 ) {
                $month = 12;
                $year -= 1;
            }
        }
    }
    //echo "previous";
}
//$monthName = CDateUtil::getMonthName($month);
$date = new \RikardKarlsson\Calendar\CDateTimeAdvanced();
$date->setDate($year, $month, 1);
$calender = new \RikardKarlsson\Calendar\CCalenderMonth($year, $month);
$date->modify("-1 months");
$year = $date->getYear();
$month = $date->getMonth();
$leftCalender = new \RikardKarlsson\Calendar\CCalenderMonth($year, $month); //TODO $month-1 could be 0 not good?
$date->modify("+2 months");
$year = $date->getYear();
$month = $date->getMonth();
$rightCalender = new \RikardKarlsson\Calendar\CCalenderMonth($year, $month);
$date->modify("-1 months");
$year = $date->getYear();
$month = $date->getMonth();

$path = "img/calender/";
$images = readDirectory($path);


// Do it and store it all in variables in the Lark container.
$lark['title'] = "Kalender";

$lark['main'] = <<<EOD
<div class='page-calender t-clearfix'>
    <form method="get">
        <input type="hidden" name="year" value="{$year}" />
        <input type="hidden" name="month" value="{$month}" />
        <button class="button t-left" name = "btn_previous" value = "previous"><div class='t-left calender--medium-wrapper'> {$leftCalender->getHtml(TRUE) } </div></button>
    </form>
    
</div>
EOD;
$lark['main'] .= <<<EOD
<div class='page-calender t-clearfix'>
    <form method="get">
        <input type="hidden" name="year" value="{$year}" />
        <input type="hidden" name="month" value="{$month}" />
        <button class="button t-right" name = "btn_next" value="next"><div class='t-right calender--medium-wrapper'> {$rightCalender->getHtml(TRUE)} </div></button>
    </form>
    
</div>
EOD;
//$lark['main'] .="<div class='t-left calender--small-wrapper'> {$leftCalender->getHtml(TRUE) } </div>";
//$lark['main'] .="<div class='t-right calender--small-wrapper'> {$rightCalender->getHtml(TRUE)} </div>";         
$lark['main'] .="    <div class='calender-month-image'>
        <img  src='{$path}{$images[$month-1]}' width='300' alt='Månadsbild'>
    </div>
";

//$lark['main'] .="<div class='t-left'> {$leftCalender->getHtml(TRUE) } </div>";

//$lark['main'] .= "<div class='t-left'> {$leftCalender->getHtml(TRUE) } </div>";
//$lark['main'] .= "<div class='t-right'> {$rightCalender->getHtml(TRUE)} </div>";
$lark['main'] .= $calender->getHtml(FALSE);


// Finally, leave it all to the rendering phase of Lark.

