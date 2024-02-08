<?php
// Enter your host name, database username, password, and database name.
// If you have not set database password on localhost then set empty.
$con = mysqli_connect(
    "localhost",
    "phpmysql",
    "j%XNr&P'j!#~89@",
    "englon"
);
;
// Check connection
if (mysqli_connect_errno()) {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
    $error = 'Failed to connect to the MySQL database englon: ' . mysqli_connect_error();
    error_log("Gave SWR error: " . $error);
    header("Location: /swr?id=" . base64_encode($error));
}


/**
 * Optimizes PNG file with pngquant 1.8 or later (reduces file size of 24-bit/32-bit PNG images).
 *
 * You need to install pngquant 1.8 on the server (ancient version 1.0 won't work).
 * There's package for Debian/Ubuntu and RPM for other distributions on http://pngquant.org
 *
 * @param $path_to_png_file string - path to any PNG file, e.g. $_FILE['file']['tmp_name']
 * @param $max_quality int - conversion quality, useful values from 60 to 100 (smaller number = smaller file)
 * @return string - content of PNG file after conversion
 */
function compress_png($path_to_png_file, $max_quality = 90)
{
    if (!file_exists($path_to_png_file)) {
        throw new Exception("File does not exist: $path_to_png_file");
    }

    // guarantee that quality won't be worse than that.
    $min_quality = 60;

    // '-' makes it use stdout, required to save to $compressed_png_content variable
    // '<' makes it read from the given file path
    // escapeshellarg() makes this safe to use with any path
    $compressed_png_content = shell_exec("pngquant --quality=$min_quality-$max_quality - < ".escapeshellarg(    $path_to_png_file));

    if (!$compressed_png_content) {
        throw new Exception("Conversion to compressed PNG failed. Is pngquant 1.8+ installed on the server?");
    }

    return $compressed_png_content;
}
?>