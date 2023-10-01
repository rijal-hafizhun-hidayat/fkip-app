<?php

function setStatuAccBimbingan($val){
    if($val == 0){
        $setVal = 'Menunggu proses Dpl';
    }
    else if($val == 1){
        $setVal = 'Direvisi';
    }
    else if($val == 2){
        $setVal = 'Disetujui';
    }
    else if($val == 3){
        $setVal = 'Ditolak';
    }
    return $setVal;
}