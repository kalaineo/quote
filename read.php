<?php

$_Acontent = file("harddisc.csv");

$_Aheader =array_map('trim',explode(',',$_Acontent[0]));

$_Adata = array();
foreach($_Acontent as $k => $v){
    if($k==0) continue;
    $_Arow = array_map('trim',explode(',',$v));
    foreach($_Arow as $inKey => $inVal){
        $_Adata[$k][$_Aheader[$inKey]] = $inVal;
    }
}

$insertBatch = array();
foreach($_Adata as $k => $val){
 
    $insert = array();
    $insert[] = 0;
    $insert[] = $val['Model'];
   
    list($ramsize,$ramtype) =  explode('GB',$val['RAM']);
     $insert[] = $ramsize; //16GBDDR3
     $insert[] = 'GB'; //16GBDDR3
     $insert[] = $ramtype; //16GBDDR3
    
    list($hdsize,$hdtype) =  explode('TB',$val['HDD']);  //2x2TBSATA2
    $unit = 'TB';
    if(empty($hdtype)){
        list($hdsize,$hdtype) =  explode('GB',$val['HDD']);  //2x2TBSATA2
        $unit = 'GB';
    }
    
    //$hdsize = eval('yes '.$hdsize.';');
    list($first,$sec) = explode('x',$hdsize);
    
    
     $insert[] = $first * $sec; //16GBDDR3
     $insert[] = $unit; //16GBDDR3
     $insert[] = $hdtype; //16GBDDR3
    
    $insert[] = $val['Location'];
    
    $insert[] = $val['Price'];
    $insert[] = $val['Currency'];
    
    $insertBatch[] = "('".implode("','",$insert)."')";
}


$sql = "INSERT INTO quotation VALUES ".implode(',',$insertBatch);
print_r($sql);