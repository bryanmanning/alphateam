<?php
$file = "/var/www/vhosts/alphateam.y4x.com/alphateam/www/players";
$scorefile = "/var/www/vhosts/alphateam.y4x.com/alphateam/www/scoreboard";

if (isset($_GET["reset"]) && $_GET["reset"] == "1") {
  file_put_contents($file, "");
  file_put_contents($scorefile, "-1");
  header("Location: index.php");
  exit;
}

$players = file_get_contents($file);
$myId = rand(1000000000, 9999999999);
$players = $players . $myId . ":\n";
file_put_contents($file, $players);

$players_arr = split("\n", $players);
array_pop($players_arr);
$num_players = count($players_arr);

$myNum = "-1";
for ($idx = 0; $idx < count($players_arr); $idx++) {
  if ($players_arr[$idx] == $myId) {
    $myNum = $idx;
  }
}

$score = file_get_contents($scorefile);

?>

<html>
<head>
<title>alphateam</title>
<meta name="viewport" content="width=device-width, user-scalable=no" />
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script>
<script type="text/javascript">
var num_players = <?php echo $num_players; ?>;
  function resetGame() {
  window.location.href="/index.php?reset=1";
}
function displayPlayers() {
  console.log("running display");
  $.get("/players.php?myId=<?php echo $myId; ?>", function(data) { if (data == "-1") { window.location.href="/index.php"; } else 
	{ 
	  $("#playerList").text(data); 
	  num_players = (data.split(",").length - 1);
	} });
  $.get("/score.php", function(data) { if (data == "0") { playGame(); }});
}

function doBanner() {
  $("#commandBtn").css("background-color", "green");
  $("#commandBtn").animate({backgroundColor: 'red'},3 * 900);
  console.log("running timer");
  $.get("/score.php", function(data) { if(data == "-1") { alert("Score: " + $("#score").text());window.location.href="/index.php?reset=1"; } else { $("#score").text(data); }});
  var rnd = Math.floor((Math.random()*num_players));
  var num = rnd;
  $("#banner").text(num);


  $("#banner").effect("pulsate", { times:3 }, 500);
  $.get("/update.php?myId=<?php echo $myId; ?>&value=" + num);
}

var displayTimer;
function playGame() {
  clearInterval(displayTimer);
  $.get("/start.php");
  doBanner();
  setInterval(function() {doBanner();}, 4 * 1000);
}

function issueCommand() {
  $.get("/issueCommand.php?value=<?php echo $myNum ?>");
}

  $(document).ready(function() {
      $("#resetBtn").click(function() { resetGame(); });
      $("#playBtn").click(function() { playGame(); });
      $("#commandBtn").click(function() { issueCommand(); });
      displayTimer = setInterval(function() {displayPlayers()}, 1000);
    });
</script>
</script>
<style type="text/css">
    .large_text { font-size: 50pt; }
</style>
</head>
<body>
<h3>You are player <strong><?php echo $myId; ?></strong></h3>
<h4>All players: <div id="playerList" style="block: inline">
<?php
for ($idx = 0; $idx < count($players_arr); $idx++) { 
  $player_entry = split(":", $players_arr[$idx]);
  $player_name = $player_entry[0];
  $player_banner = $player_entry[1];
  echo $player_name . ", ";
}
?>
</div>
</h4>
  <button id="resetBtn">Reset the game</button>
  <button id="playBtn">Ready to play</button>
    <button id="commandBtn" class="large_text"><?php echo $myNum; ?></button>
    <div id="banner" class="large_text"></div>
    <div>Score: <div id="score" class="large_text"><?php echo $score; ?></div></div>
</body>
</html>
