<?php

    if ($_POST && isset($_POST['user'])) {
        $val = $_POST['user'];

        $command = escapeshellcmd("python scripts/predict.py $val");
        $output = exec($command);
        echo $output;
    }

?>