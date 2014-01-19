<?php
$scorefile = "/var/www/vhosts/alphateam.y4x.com/alphateam/www/scoreboard";
$score = file_get_contents($scorefile);
echo $score;
?>