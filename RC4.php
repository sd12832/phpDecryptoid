<?php

function encrypt($data, $pwd, $case) {
    $data=$case == 'de' ? $data = urldecode($data) : $data;
    $v[] = "";$b[] = "";$s = "";$t = ""; $k = "";$f = "";$z = "";$l = 0;$x = 0;$a = 0;$j = 0;$l = strlen($pwd);$d=strlen($data);
    for ($i = 0; $i <= 255; $i++){$v[$i] = ord(substr($pwd, ($i % $l), 1)); $b[$i] = $i;}
    for ($i = 0; $i <= 255; $i++){$x = ($x + $b[$i] + $v[$i]) % 256; $s = $b[$i]; $b[$i] = $b[$x]; $b[$x] = $s; }
    for ($i = 0; $i < $d; $i++)  {$a = ($a + 1) % 256; $j = ($j + $b[$a]) % 256;$t = $b[$a]; $b[$a] = $b[$j];$b[$j] = $t;$k = $b[(($b[$a] + $b[$j]) % 256)]; $f = ord(substr($data, $i, 1)) ^ $k;$z .= chr($f);}
    $z=$case =="de" ? urldecode(urlencode($z)): $z;
    return $z;
}

function RC4_Encrypt($data, $cipher) {
    return encrypt(urlencode($data), $cipher,"en");
}

function decrypt($data, $cipher) {
    return encrypt(urlencode($data), $cipher,"de");
}

?>