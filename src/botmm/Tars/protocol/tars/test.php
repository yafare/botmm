<?php
//Function required to reverse a string on blocks of two
function strrev_x($s, $x = 2) {
    if ($x <= 1) {
        return strrev($s);
    } else {
        return (implode(array_reverse(array_map('implode', array_chunk(str_split($s), $x)))));
    }
}

echo 'double pack'. PHP_EOL;
$tst = pack('d', '1.1');
var_dump('xxxx '.bin2hex($tst));
var_dump(strrev_x(bin2hex($tst)));
$tst = pack('d', 8-6.4);
var_dump(strrev_x(bin2hex($tst)));
echo 'float pack'. PHP_EOL;
$tst = pack('f', '1.1');
var_dump(strrev_x(bin2hex($tst)));
$tst = pack('f', 8-6.4);
var_dump(strrev_x(bin2hex($tst)));
?>