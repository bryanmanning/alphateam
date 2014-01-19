<?php
$file = "/var/www/vhosts/alphateam.y4x.com/alphateam/www/players";
$players = file_get_contents($file);

$players_arr = split("\n", $players);
array_pop($players_arr);

$myIdFound = false;
for ($idx = 0; $idx < count($players_arr); $idx++) {
  $player_entry = split(":", $players_arr[$idx]);
  $player_name = $player_entry[0];
  $player_banner = $player_entry[1];
  if ($_GET["myId"] == $player_name) {
    $myIdFound = true;
  }
}
if ($myIdFound == false) {
  echo "-1";
} else {
  for ($idx = 0; $idx < count($players_arr); $idx++) {
    $player_entry = split(":", $players_arr[$idx]);
    $player_name = $player_entry[0];
    $player_banner = $player_entry[1];
    echo $player_name . ", ";
  }
}
?>