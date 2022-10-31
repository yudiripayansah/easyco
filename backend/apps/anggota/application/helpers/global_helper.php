<?php

if (!function_exists('cors')) {
    function cors($tanggal)
    {
        $a = explode('-', $tanggal);
        $tanggal = $a['2']." ".bulan($a['1'])." ".$a['0'];
        return $tanggal;
    }
}
