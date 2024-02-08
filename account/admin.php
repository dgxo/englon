<?php
require("auth_session.php");
require("db.php");

if (!isset($_SESSION["admin"]) || $_SESSION["admin"] == false) {
   $error = 'This goofy guy tried to get into the admin panel, and has the username ' . $_SESSION['username'];
   error_log("Gave SWR error: " . $error);
   header("Location: /swr?id=" . base64_encode($error));
   header("Location: login");
   exit();
}

$_SESSION["adminnotes"] = file_get_contents('/var/www/html/chatutils/adminnotes.txt');

if (isset($_GET['adminnotes'])) {
   $notes = stripslashes($_GET['adminnotes']);
   $notes = htmlspecialchars($notes);
   $result = file_put_contents('/var/www/html/chatutils/adminnotes.txt', $notes, LOCK_EX);

   if ($result) {
      header("Location: admin");
   } else {
      echo "Something went wrong saving!";
      error_log("Failed when saving admin notes");
   }
}

?>

<!DOCTYPE html>
<html>

<head>
   <meta charset="utf-8">
   <title>Admin Panel - Englon</title>
   <link rel="stylesheet" href="stylesheet.css">
   <script>
      var _paq = window._paq = window._paq || [];

      _paq.push(['setCustomDimension', customDimensionId = 1, customDimensionValue = '<?= $_SESSION['username'] ?>']);
      _paq.push(['trackPageView']);
      _paq.push(['enableLinkTracking']);
      (function () {
         var u = "//stats.englon.biz/";
         _paq.push(['setTrackerUrl', u + 'e']);
         _paq.push(['setSiteId', '1']);
         var d = document, g = d.createElement('script'), s = d.getElementsByTagName('script')[0];
         g.async = true; g.src = u + 'js/'; s.parentNode.insertBefore(g, s);
      })();
   </script>
   <!-- End Matomo Code -->
</head>

<body>
   <?php
   include("/var/www/html/englon/header.php");
   ?>
   <main>
      <div id="admin">
         <h1 class="title">Admin Panel</h1>
         <h2>Users</h2>
         <div class="table-wrapper">
            <table>
               <thead>
                  <tr>
                     <th></th>
                     <th>User ID</th>
                     <th>Username</th>
                     <th>Creation Date</th>
                     <th>Messages</th>
                     <th>Admin</th>
                     <th>Notes</th>
                     <th>Edit</th>
                  </tr>
               </thead>
               <tbody>
                  <?php
                  $query = "SELECT *
                           FROM `users`
                           LIMIT 300";
                  $result = mysqli_query($con, $query);
                  if ($result) {

                     while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
                        $avatar = $row['avatar'];  
                        $id = $row['id'];
                        $username = $row['username'];
                        $creation = mb_split("\s", $row['create_datetime'])[1];
                        $messages = $row['messages'];
                        $admin = $row['admin'] ? 'True' : 'False';
                        $notes = mb_strimwidth($row['notes'], 0, 30, '...');
                        $controls = "<a target='_blank' href='adminer.php?username=phpmysql&db=englon&edit=users&where%5Bid%5D=$id'><svg xmlns='http://www.w3.org/2000/svg' height='1em' viewBox='0 0 512 512'><!--! from Font Awesome --><path fill='white' d='M362.7 19.3L314.3 67.7 444.3 197.7l48.4-48.4c25-25 25-65.5 0-90.5L453.3 19.3c-25-25-65.5-25-90.5 0zm-71 71L58.6 323.5c-10.4 10.4-18 23.3-22.2 37.4L1 481.2C-1.5 489.7 .8 498.8 7 505s15.3 8.5 23.7 6.1l120.3-35.4c14.1-4.2 27-11.8 37.4-22.2L421.7 220.3 291.7 90.3z'/></svg></a>";
                        echo "<tr>
                                 <td><img
                                       src='/images/avatars/$avatar'
                                       alt='Profile picture'></td>
                                 <td>$id</td>
                                 <td>$username</td>
                                 <td>$creation</td>
                                 <td>$messages</td>
                                 <td>$admin</td>
                                 <td id='notes'>$notes</td>
                                 <td>$controls</td>
                              </tr>";
                     }
                  } else {
                     echo "Something went wrong!";
                     error_log("MySQL query failed when fetching users: " . mysqli_error($con));
                  }
                  ?>

               </tbody>
            </table>
         </div>


         <h2>Notes</h2>
         <form>
            <textarea placeholder="Visible to anyone with admin" name="adminnotes" maxlength="50000" id="adminnotes"
               cols="40" rows="4"><?= $_SESSION["adminnotes"] ?></textarea>
            <input type="submit" value="Save">
         </form>
      </div>
   </main>
</body>

</html>
