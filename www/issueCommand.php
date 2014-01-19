<?php
$file = "/var/www/vhosts/alphateam.y4x.com/alphateam/www/players";
$scorefile = "/var/www/vhosts/alphateam.y4x.com/alphateam/www/scoreboard";

$players = file_get_contents($file);

$players_arr = split("\n", $players);
array_pop($players_arr);

$command_is_good = false;
for ($idx = 0; $idx < count($players_arr); $idx++) {
  $player_entry = split(":", $players_arr[$idx]);
  $player_name = $player_entry[0];
  $player_banner = $player_entry[1];
  if($_GET["value"] == $player_banner) {
    $command_is_good = true;
  }
}

if ($command_is_good) {
  $score = file_get_contents($scorefile);
  $score = $score + 1;
  file_put_contents($scorefile, $score);
} else {
  file_put_contents($file, "");
  file_put_contents($scorefile, "-1");
}

?>