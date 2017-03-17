<?php

function selectQuery($select) {
    $arrayReturn = array();
    $counter = 0;
    $query = mysqli_query($GLOBALS['conn'], $select);
    while ($row = mysqli_fetch_array($query)) {
        $arrayReturn[$counter] = $row;
        $counter++;
    }
    return $arrayReturn;
}
function insertQuery($query) {
    if (mysqli_query($GLOBALS['conn'], $query)) {
        return mysqli_insert_id($GLOBALS['conn']);
    } else {
        echo "<br>";
        echo "Error: " . $query . "<br>" . mysqli_error($GLOBALS['conn']);
        echo "<br>";
        
        return false;
    }
}

?>


