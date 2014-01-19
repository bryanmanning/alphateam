<?php
$file = "players";
$num_players = file_get_contents($file);
$myNum = $num_players;
file_put_contents($file, $num_players++);
?>

<html>
<head>
<title>alphateam</title>
</head>
<body>
<!-- <?php echo rand(1000000000, 9999999999); ?> -->
  <button id="myBtn" value="<?php echo $myNum; ?>"/>
  <?php echo $num_players; ?>
</body>
</html>
