
<?
        function format_date($date) {
            $year = substr($date, 0, 4);
            $month = substr($date, 5, 2);
            $day = substr($date, 8,2);
            switch ($month) {
                case 1:
                    $month = JANUARY;
                    break;
                case 2:
                    $month= FEBRUARY;
                    break;
                case 3:
                    $month = MARCH;
                    break;
                case 4:
                    $month = APRIL;
                    break;
                case 5:
                    $month = MAY;
                    break;
                case 6:
                    $month = JUNE;
                    break;
                case 7:
                    $month = JULY;
                    break;
                case 8:
                    $month = AUGUST;
                    break;
                case 9:
                    $month = SEPTEMBER;
                    break;
                case 10:
                    $month = OCTOBER;
                    break;
                case 11:
                    $month = NOVEMBER;
                    break;
                case 12:
                    $month = DECEMBER;
                    break;
                default:
                    break;
            }
            return $day . " " . $month . " " . $year;
        }
?>