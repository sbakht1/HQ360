<?php
use App\Models\Meta;

function unique_array($array, $key) { 
    $temp_array = [];
    foreach ($array as &$v) {
        if (!isset($temp_array[$v[$key]]))
        $temp_array[$v[$key]] =& $v;
    }
    $array = array_values($temp_array);
    return $array;
}

function meta_data($cat,$key) {
    $meta = new Meta();
    return $meta->find_data($cat,$key);
}

function array_to_csv_download($array, $filename = "export.csv", $delimiter=",") {
    // open raw memory as file so no temp files needed, you might run out of memory though
    $f = fopen('php://memory', 'w');
    $titles = array_keys($array[0]);
    fputcsv($f,$titles,$delimiter); 
    // loop over the input array
    foreach ($array as $line) { 
        // generate csv lines from the inner arrays
        fputcsv($f, $line, $delimiter); 
    }
    // reset the file pointer to the start of the file
    fseek($f, 0);
    // tell the browser it's going to be a csv file
    header('Content-Type: text/csv');
    // tell the browser we want to save it instead of displaying it
    header('Content-Disposition: attachment; filename="'.$filename.'";');
    // make php send the generated csv lines to the browser
    fpassthru($f);
}

function lower_keys($arr)
{
    return array_map(function($item){
        if(is_array($item)) return array_change_key_case($item,CASE_LOWER);
    },array_change_key_case($arr));
}

