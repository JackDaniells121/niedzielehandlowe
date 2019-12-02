<?php
/**
 * Funkcja sprawdza czy podana data jest dniem pracującym (TRUE) lub święto/sobota/niedziele (FALSE)
 *
 * @param string $date Data w formacie Y-m-d (np. 2015-08-26)
 * @return boolean
 */
function isThatDateWorkingDay($date) {
    $time = strtotime($date);
    $dayOfWeek = (int)date('w',$time);  //zwraca 1-ponidzialek....0-niedziela
    $year = (int)date('Y',$time);
 
    #lista swiat stalych
    $holiday=array('01-01', '01-06','05-01','05-03','08-15','11-01','11-11','12-25','12-26');
 
    #dodanie listy swiat ruchomych
    #wialkanoc
    $easter = date('m-d', easter_date( $year ));
    #poniedzialek wielkanocny
    $easterSec = date('m-d', strtotime('+1 day', strtotime( $year . '-' . $easter) ));
    #boze cialo
    $cc = date('m-d', strtotime('+60 days', strtotime( $year . '-' . $easter) ));
    #Zesłanie Ducha Świętego
    $p = date('m-d', strtotime('+49 days', strtotime( $year . '-' . $easter) ));

    #dodanie niedziel handlowych
    #niedziela handlowa przed wielkanocą
    $n1 = date('m-d', strtotime('-6 days', strtotime( $year . '-' . $easter) ));
    #dwie niedziele handlowe przed bożym narodzeniem
    $day_number_25_gru = date('N', strtotime($year . '-12-25'));        //zwraca 1-ponidzialek....7-niedziela
    $n2 = date('m-d', strtotime('-'.$day_number_25_gru .'days', strtotime( $year . '-12-25') ));
    $n3 = date('m-d', strtotime('-'.$day_number_25_gru-7 .'days', strtotime( $year . '-12-25')));
    #ostatnia handlowa niedziela stycznia
    $nsty = date('m-d', strtotime('-'.(int)date('w',strtotime( $year . '-01-31')) .'days', strtotime( $year . '-01-31') ));
    #ostatnia handlowa niedziela kwietnia
    $nkwi = date('m-d', strtotime('-'.(int)date('w',strtotime(  $year . '-04-30')) .'days', strtotime( $year . '-04-30') ));
    #ostatnia handlowa niedziela czerwca
    $ncze = date('m-d', strtotime('-'.(int)date('w',strtotime(  $year . '-06-30')) .'days', strtotime( $year . '-06-30') ));
    #ostatnia handlowa niedziela sierpnia
    $nsie = date('m-d', strtotime('-'.(int)date('w',strtotime(  $year . '-08-31')) .'days', strtotime( $year . '-08-31') ));

    $holiday[] = $easter;
    $holiday[] = $easterSec;
    $holiday[] = $cc;
    $holiday[] = $p;

    $worksundays[] = $n1;
    $worksundays[] = $n2;
    $worksundays[] = $n3;
    $worksundays[] = $nsty;
    $worksundays[] = $nkwi;
    $worksundays[] = $ncze;
    $worksundays[] = $nsie;
    
    #sprawdzenie czy to jest niedziela niehandlowa
    if(in_array(date('m-d',strtotime($date)),$worksundays)) return true;
    
    #sprawdzenie czy to nie weekend
    if( $dayOfWeek==6 || $dayOfWeek==0 )    return false;

    $md = date('m-d',strtotime($date));

    if(in_array($md, $worksundays)) return true;
    if(in_array($md, $holiday)) return false;
 
    return true;
}
//-----------------------------------------------------------------------------

$start_date = "2019-12-01";

$hmdg = $how_many_days_to_generate = 365;

for($i=0;$i<$hmdg;$i++)
{
    $day_status =  isThatDateWorkingDay($start_date)?"true":"false";            //sprawdz czy dzien pracujący czy nie
    
    //$day_status = $day_status=="true"?"3":"1";                                  //wyświetlanie 3="święto" 1-"dzien pracujący"
    
    //echo $i."\t null \t ".$day_status."\t".strtotime($start_date)."\t 1 \t null \t null \r\n";                                    //wypisz
    echo"\r\n $start_date \t $day_status";

    $start_date = date('Y-m-d', strtotime('+1 day', strtotime($start_date)));   //wez nastepny dzien
}

?>