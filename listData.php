<?php

$conn = mysqli_connect('localhost','root','neo','lara');

if(!$conn) die('Unable to connect database');
mysqli_set_charset($conn, 'utf8');

$sql = "select * from quotation";
$result = $conn->query($sql);
$listData = mysqli_fetch_all($result,MYSQLI_ASSOC);

$sql = "select location from quotation group by location";
$result = $conn->query($sql);
$locationData = mysqli_fetch_all($result,MYSQLI_ASSOC);

$locationData = array_column($locationData,'location');
$locationData = array_combine($locationData,$locationData);

//echo "<pre>";print_r($locationData);exit;

$sql = "select hard_disc_type from quotation group by hard_disc_type";
$result = $conn->query($sql);
$hdtypeData = mysqli_fetch_all($result,MYSQLI_ASSOC);
$hdtypeData = array_column($hdtypeData,'hard_disc_type');
$hdtypeData = array_combine($hdtypeData,$hdtypeData);

$sql = "select hard_disc_size from quotation group by hard_disc_size order by abs(hard_disc_size)";
$result = $conn->query($sql);
$hdsizeData = mysqli_fetch_all($result,MYSQLI_ASSOC);
$hdsizeData = array_column($hdsizeData,'hard_disc_size');
$hdsizeData = array_combine($hdsizeData,$hdsizeData);

$sql = "select ram_size from quotation group by ram_size order by abs(ram_size)";
$result = $conn->query($sql);
$ramsizeData = mysqli_fetch_all($result,MYSQLI_ASSOC);
$ramsizeData = array_column($ramsizeData,'ram_size');
$ramsizeData = array_combine($ramsizeData,$ramsizeData);

//echo "<pre>";print_r($hdsizeData);exit;

// For Filter works
$sql = "select * from quotation WHERE 1 ";



if(isset($_POST['hard_disc_type']) && $_POST['hard_disc_type'] != 'undefined'){
    $sql .= " AND hard_disc_type = '".$_POST['hard_disc_type']."'";
}

if(isset($_POST['location']) && !empty($_POST['location']) && $_POST['location'] != 'undefined' ){
    $sql .= " AND location = '".$_POST['location']."'";
}

if(isset($_POST['ram_size']) && !empty($_POST['ram_size']) && $_POST['ram_size'] != 'undefined' ){
    $sql .= " AND ram_size IN(".$_POST['ram_size'].")";
}
if(isset($_POST['hard_disc_size_min']) && !empty($_POST['hard_disc_size_min']) && $_POST['hard_disc_size_min'] != 'undefined' ){
    $sql .= "  AND (hard_disc_size BETWEEN ".$_POST['hard_disc_size_min']." AND ".$_POST['hard_disc_size_max'];
    
    if($_POST['hard_disc_size_max'] > 1024){
        $sql .= " OR hard_disc_unit = 'TB' )";
    }
    else{
        $sql .= ")";
    }
    
}

//echo "<pre>";print_r($sql);exit;
$result = $conn->query($sql);
$filteredData = mysqli_fetch_all($result,MYSQLI_ASSOC);



$_Aresult = array();
$_Aresult['listData']       = $listData;
$_Aresult['locationData']   = $locationData;
$_Aresult['hdtypeData']         = $hdtypeData;
$_Aresult['ramsizeData']    = $ramsizeData;
$_Aresult['hdsizeData']    = $hdsizeData;
$_Aresult['filteredData']    = $filteredData;

echo json_encode($_Aresult);


