<?php
$connection = mysqli_connect("localhost", "root", "", "lotto");

if (!$connection) {
    die("Connection failed: " . mysqli_connect_error());
}

$result = mysqli_query($connection, "SELECT * FROM `results` LIMIT 1");
if (mysqli_num_rows($result) == 0) {

    $data = file_get_contents("http://www.mbnet.com.pl/dl.txt");
    $lines = explode("\n", $data);

    foreach ($lines as $line) {
        $line = trim($line);
        if (!empty($line)) {
            $date_end_pos = strpos($line, " "); 
            $date_string = substr($line, 0, $date_end_pos); 
            $result_date = date("Y-m-d", strtotime($date_string));

            $numbers_string = substr($line, $date_end_pos + 1);

            $numbers = explode(",", $numbers_string);

            $query = "INSERT INTO `results` (`result_date`, `n1`, `n2`, `n3`, `n4`, `n5`, `n6`) 
                      VALUES ('$result_date', '$numbers[0]', '$numbers[1]', '$numbers[2]', '$numbers[3]', '$numbers[4]', '$numbers[5]')";
            mysqli_query($connection, $query);
        }
    }

    echo "<h1>Pomyślnie dodano dane do tabeli 'Results'.</h1>";
} else {
    echo "<h1>Dane już zostały wprowadzone.</h1>";
}
mysqli_close($connection);
?>
