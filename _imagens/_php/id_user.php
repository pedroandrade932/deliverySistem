<?php
function uniqidReal($leng = 5) {
    $item = rand(0,999999);
    $numero = str_pad($item, $leng, 0, STR_PAD_LEFT);
    return $numero;    
}
?>
