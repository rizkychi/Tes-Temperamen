<?php
    if ($_POST) {
        $twitter_id = $_POST['twitter_id'];
        $answer = array();

        for ($i=0; $i < 40; $i++) { 
            array_push($answer, $_POST['answer_'.$i]);
        }
        
        var_dump($answer);

        $result = array_count_values($answer);
        $max = max($result);

        var_dump($result);

        echo $max;
        $type = array_keys($result, $max);
        echo '<br>';
        echo $type[0];
        if ($type[0] == 0) {
            echo 'Sanguinis';
        } else if ($type[0] == 1) {
            echo 'Koleris';
        } else if ($type[0] == 2) {
            echo 'Melankolis';
        } else if ($type[0] == 3) {
            echo 'Phlegmatis';
        }

        $temp = json_encode($answer);
        echo $temp;
    }
?>