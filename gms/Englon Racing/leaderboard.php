<?php

/* Connection Variable ("Servername",
"username","password","database") */
$con = mysqli_connect(
   "localhost",
   "phpmysql",
   "j%XNr&P'j!#~89@",
   "englon"
);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
   if (isset($_POST['username']) && isset($_POST['laptime'])) {

      $username = preg_replace("/[^a-zA-Z0-9\s]/", "", $_POST['username']);
      $laptime = preg_replace("/[^a-zA-Z0-9\.\:\s]/", "", $_POST['laptime']);

      mysqli_query($con, "INSERT INTO leaderboard(username, lapTime)
   VALUES ('{$username}', '{$laptime}')");
   } else {
      http_response_code(400);
      die("Invalid request");
   }
} else {
   $result = mysqli_query($con, "SELECT username,
   lapTime FROM leaderboard ORDER BY lapTime ASC");

   $ranking = 1;
   echo "<ol>";
   /* Fetch Rows from the SQL query */
   if (mysqli_num_rows($result)) {
      while ($row = mysqli_fetch_array($result)) {
         $thisusername = $row['username'];
         $thislaptime = $row['lapTime'];
         echo "<li>$thisusername - $thislaptime</li>";
         $ranking++;
      }
   }
   echo "</ol>";
}
?>