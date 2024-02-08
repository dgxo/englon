<?php
//include auth_session.php file on all user panel pages
require("auth_session.php");
require('db.php');
try {
    // Update notes in table
    if (isset($_GET['notes'])) {
        $notes = $_GET['notes'];
        $username = $_SESSION['username'];
        /* create a prepared statement */
        $stmt = mysqli_stmt_init($con);
        mysqli_stmt_prepare($stmt, "UPDATE users SET notes=? WHERE username=?");

        /* bind parameters for markers */
        mysqli_stmt_bind_param($stmt, "ss", $notes, $username);

        mysqli_stmt_execute($stmt);

        if (mysqli_stmt_error($stmt) == "") {
            $_SESSION['notes'] = $notes;
            header("Location: dashboard");
        } else {
            $error = "MySQL query failed when saving notes: " . mysqli_stmt_error($stmt);
            throw new Exception($error);
        }
    }

    // Get profile picture from table
    $id = mysqli_real_escape_string($con, $_SESSION['id']);
    $query = "SELECT avatar FROM `users`
          WHERE id = '$id'";
    $result = mysqli_query($con, $query);

    if ($result) {
        $avatar = $result->fetch_array(MYSQLI_ASSOC)['avatar'];
        if (!$avatar) {
            $avatar = 'default.png';
        }
    } else {
        $error = "MySQL query failed when fetching avatar: " . mysqli_error($con);
        throw new Exception($error);
    }
    ?>
    <!DOCTYPE html>
    <html>

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta http-equiv="Content-Type" content="text/html">

        <title>Untitled document - Google Docs</title>
        <meta name="description" content="Tools & Utilities">

        <meta property="og:title" content="Dashboard - Englon">
        <meta property="og:description" content="Tools & Utilities">
        <meta property="og:type" content="website">
        <meta property="og:url" content="https://englon.biz">

        <link rel="shortcut icon" href="https://ssl.gstatic.com/docs/documents/images/kix-favicon7.ico">
        <link rel="icon" type="image/x-icon" href="https://ssl.gstatic.com/docs/documents/images/kix-favicon7.ico">
        <link rel="stylesheet" href="stylesheet.css?1.7.2">
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
            <div id="dashboard">
                <h1 class="title">Account Dashboard</h1>

                <div class="grid">
                    <div class="info">
                        <div class="user">
                            <div class="pfp">
                                <img src="/images/avatars/<?= $avatar ?>" alt="     Profile picture">
                                <label for="fileinput">
                                    <div class="overlay"><svg xmlns="http://www.w3.org/2000/svg" height="1.5em"
                                            viewBox="0 0 512 512"><!--! From Font Awesome -->
                                            <path fill="#DDD"
                                                d="M362.7 19.3L314.3 67.7 444.3 197.7l48.4-48.4c25-25 25-65.5 0-90.5L453.3 19.3c-25-25-65.5-25-90.5 0zm-71 71L58.6 323.5c-10.4 10.4-18 23.3-22.2 37.4L1 481.2C-1.5 489.7 .8 498.8 7 505s15.3 8.5 23.7 6.1l120.3-35.4c14.1-4.2 27-11.8 37.4-22.2L421.7 220.3 291.7 90.3z">
                                        </svg></div>
                                </label>
                                <form id="uploadform" action="dashboard" enctype="multipart/form-data" method="post">
                                    <input type="file" name="avatar" id="fileinput" style="display: none">
                                </form>
                                <script src="index.js"></script>
                            </div>
                            <?= $_SESSION['username'] ?>
                        </div>
                        <div class="stats-labels">
                            Messages:<br>
                            Created:
                        </div>
                        <div class="stats">
                            <?= $_SESSION['messages'] ?><br>
                            <?= $_SESSION['creation'] ?><br>
                        </div>
                        <div class="help">
                            Need help?<br>Make a ticket on <a class="link" href="https://discord.gg/JKPBAbcQRU">Discord</a>
                        </div>
                    </div>
                    <div class="support">
                        <?php
                        if (isset($_FILES['avatar'])) {
                            $target_dir = "../images/avatars/";
                            $imageFileType = strtolower(pathinfo($_FILES['avatar']['name'], PATHINFO_EXTENSION));

                            // Extract the number from the current filename using a regular expression
                            preg_match('/(\d+)/', $_SESSION['avatar'], $matches);
                            $avatarNumber = isset($matches[1]) ? intval($matches[1]) + 1 : 0;

                            // New avatar file name
                            $filename = preg_replace("/[^A-Za-z0-9.]/", "", $_SESSION['username']) . '-' . $avatarNumber . '.' . stripslashes($imageFileType);
                            $target_file = $target_dir . $filename;

                            // Check if image file is a actual image or fake image
                            $size_check = getimagesize($_FILES["avatar"]["tmp_name"]);
                            if ($size_check == false) {
                                echo "File is not an image.";
                                die();
                            }

                            // Check file size
                            if ($_FILES["avatar"]["size"] > 3_000_000) { // 3MB
                                echo "Your file is too large.";
                                die();
                            }

                            // Allow certain file formats
                            if (
                                $imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
                                && $imageFileType != "gif" && $imageFileType != "webp"
                            ) {
                                echo "Only JPG, PNG & GIF files are allowed.";
                                die();
                            }
                            // optimise then save to target
                            if (file_put_contents($target_file, ($imageFileType == "jpg" || $imageFileType != "jpeg") ? $_FILES["avatar"]["tmp_name"] : compress_png($_FILES["avatar"]["tmp_name"]))) {
                                // Save file name to table
                                $filename = mysqli_real_escape_string($con, $filename);
                                $_SESSION['avatar'] = $filename;
                                $id = mysqli_real_escape_string($con, $_SESSION['id']);
                                $query = "UPDATE users SET
                                      avatar = '$filename'
                                      WHERE id = '$id'";
                                $result = mysqli_query($con, $query);

                                if ($result) {
                                    header("Location: dashboard");
                                    echo '<script>location.href = "dashboard"</script>';
                                } else {
                                    $error = "MySQL query failed when saving avatar: " . mysqli_error($con);
                                    throw new Exception($error);
                                }
                            } else {
                                $error = "Couldn't move uploaded avatar " . $_FILES['avatar']['name'];
                                throw new Exception($error);
                            }
                        }

                        ?>
                        <?php if (isset($_SESSION['admin'])): ?>
                            <h2>Experiments</h2>
                            <p>Flags you can enable to preview or add certain features.</p>
                            <div class="experiments-grid">
                                <label class="experiment">
                                    <span>Jaymie bentley 2: electric cum</span>
                                    <input type="checkbox" />
                                    <div class="b-input"></div>
                                </label><label class="experiment">
                                    <span>Jaymie bentley 2: electric greuihofwfrguhtroehtuietuieghtbiuu frgenuiiowe</span>
                                    <input type="checkbox" />
                                    <div class="b-input"></div>
                                </label>
                            </div>

                            <br>
                            <br>
                            You are an admin!<br>
                            <a class="link" href="adminer">Adminer</a><br>
                            <a class="link" href="admin">Admin Page</a><br>
                            <br>
                            <button id="modal">Show Vars</button>
                            <dialog id="dialog">
                                <button id="close">Close</button>
                                Session:
                                <pre><?php var_dump($_SESSION) ?></pre>
                                Server:
                                <pre><?php var_dump($_SERVER) ?></pre>
                                Files:
                                <pre><?php var_dump($_FILES) ?></pre>
                                Post:
                                <pre><?php var_dump($_POST) ?></pre>
                            </dialog>


                            <script>
                                const dialog = document.getElementById('dialog');
                                const modal = document.getElementById('modal');
                                const close = document.getElementById('close');

                                modal.addEventListener('click', (event) => {
                                    dialog.show();
                                });

                                close.addEventListener('click', (event) => {
                                    dialog.close();
                                });
                            </script>
                        <?php endif ?>
                    </div>
                    <div class="notes">
                        <!-- Notes -->
                        <h2>Notes</h2>
                        <form class="notes">
                            <textarea placeholder="Info, links, etc." name="notes" maxlength="50000" id="notes" cols="30"
                                rows="5"><?= $_SESSION['notes'] ?></textarea>
                            <input type="submit" value="Save">
                        </form>
                    </div>
                    <div class="logout">
                        <a class="button" href="logout">Logout</a>
                    </div>
                </div>


            </div>
        </main>
    </body>

    </html>

    <?php
} catch (Exception $e) {
    $error = "Caught exception in dashboard: " . $e->getMessage();
    error_log("Gave SWR error: " . $error);
    header("Location: /swr?id=" . base64_encode($error));
    die("<h1>An error occurred! Report it on <a href='https://discord.gg/4GtRz4W'>Discord</a> or the <a href='/issue'>issue page</a>, providing this ID: " . base64_encode($error) . "</h1>");
}
?>