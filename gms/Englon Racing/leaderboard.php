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

      $username = $_POST['username'];
      $laptime = $_POST['laptime'];

      // Use prepared statement to prevent SQL injection
      $query = "INSERT INTO leaderboard(username, lapTime) VALUES (?, ?)";
      $stmt = mysqli_prepare($con, $query);
      if (!$stmt) {
         http_response_code(500);
         die("Database error");
      }
      mysqli_stmt_bind_param($stmt, 'ss', $username, $laptime);
      if (!mysqli_stmt_execute($stmt)) {
         http_response_code(400);
         die("Invalid request");
      }
      mysqli_stmt_close($stmt);
   } else {
      http_response_code(400);
      die("Invalid request");
   }
} else {
   // Use SELECT to fetch leaderboard
   $query = "SELECT username, lapTime FROM leaderboard ORDER BY lapTime ASC";
   $result = mysqli_query($con, $query);

   if (!$result) {
      http_response_code(500);
      die("Database error");
   }

   $ranking = 1;
   echo "<ol>";
   /* Fetch Rows from the SQL query */
   if (mysqli_num_rows($result)) {
      while ($row = mysqli_fetch_array($result)) {
         $thisusername = htmlspecialchars($row['username'], ENT_QUOTES, 'UTF-8');
         $thislaptime = htmlspecialchars($row['lapTime'], ENT_QUOTES, 'UTF-8');
         echo "<li>" . $thisusername . " - " . $thislaptime . "</li>";
         $ranking++;
      }
   }
   echo "</ol>";
}
?>
