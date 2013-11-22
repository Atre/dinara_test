<?php
require('Database.php');
require('simple_html_dom.php');

if(isset($_GET['sign'])) {
    header("Content-type: text/txt; charset=UTF-8");
    $signId = htmlspecialchars($_GET['sign']);
    $xml = simplexml_load_file("http://horoscope.ra-project.net/api/" . $signId);
    $text = $xml->item->text;
    $dt = $date=date('Y-m-d');
    $db = Database::getInstance()->addToDb($dt, $signId, $text);
    $arr = array('text' => $text, 'link' => 'index.php' . '?h=' . $db);

    $parseSigns = array('cancer', 'lion', 'virgo', 'libra', 'scorpio', 'sagittarius', 'capricorn', 'aquarius',
        'pisces', 'aries', 'taurus', 'gemini');

    $html = file_get_html('http://orakul.ua/horoscope/astro/general/today/' . $parseSigns[$signId + 1] . '.html');
    foreach($html->find('div.horoBlock') as $el) {
        $arr['parse'] = $el->find('p')[0]->plaintext;
    }

    echo(json_encode($arr));
}

if(isset($_GET['date'])) {
    header("Content-type: text/txt; charset=UTF-8");
    $date = htmlspecialchars($_GET['date']);
    $d = intval(date('d',strtotime($date)));
    $m = intval(date('m',strtotime($date)));
    $id;
    //$signs = array('Козерог', 'Водолей', 'Рыбы', 'Овен' ,'Телец', 'Близнецы', 'Рак', 'Лев', 'Дева', 'Весы', 'Скорпион','Стрелец');
    $signs = array('10', '11', '12', '1' ,'2', '3', '4', '5', '6', '7', '8','9');
    $periods = array(1=>20, 2=>19, 3=>21, 4=>20, 5=>21, 6=>21, 7=>23, 8=>23, 9=>23, 10=>23, 11=>22, 12=>22);
    if($d<$periods[$m]){
        $id=$signs[$m-1];
    }
    else{
        $id=$signs[$m%12];
    }
    echo $id;
}


