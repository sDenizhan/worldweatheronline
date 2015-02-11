<?php

require_once 'class.wwo.php';

$weather = new WWO();
$weather->q('Istanbul,Turkey')
        ->date(date('Y-m-d'))
        ->key('4c645c2c6049609980f2ee8ae8519')
        ->run()
        ->getData('weather');

echo 'Min. Hava Sıcaklığı:' . $weather->getMinC().'<br>';
echo 'Max. Hava Sıcaklığı:' . $weather->getMaxC().'<br>';
echo 'Hava Durumu:' . $weather->getText().'<br>';
echo 'Hava Durumu İkonu: <img src="' . $weather->getIcon().'" /><br>';
