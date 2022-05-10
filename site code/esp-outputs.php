<?php
include_once('esp-database.php');

$result = getAllOutputs();
$html_buttons = null;
if ($result) {
    while ($row = $result->fetch_assoc()) {
        if ($row["state"] == "1") {
            $button_checked = "checked";
        } else {
            $button_checked = "";
        }
        $html_buttons .= '<h3>' .
            $row["name"] .
            ' - Name ' . $row["name"] .
            ' - MAC ' . $row["mac"] .
            ' (<i><a onclick="deleteOutput(this)" href="javascript:void(0);
        " id="' . $row["id"] .
            '">Delete</a></i>)</h3><label class="switch"><input type="checkbox" onchange="updateOutput(this)
        " id="' . $row["id"] .
            '" ' . $button_checked . '><span class="slider"></span></label>';
    }
}

$html_boards = null;
if ($result) {
    $html_boards .= '<h3>PC</h3>';
    while ($row = $result->fetch_assoc()) {
        $row_reading_time = $row["last_request"];
        // Uncomment to set timezone to - 1 hour (you can change 1 to any number)
        //$row_reading_time = date("Y-m-d H:i:s", strtotime("$row_reading_time - 1 hours"));

        // Uncomment to set timezone to + 4 hours (you can change 4 to any number)
        //$row_reading_time = date("Y-m-d H:i:s", strtotime("$row_reading_time + 7 hours"));
        $html_boards .= '<p><strong>Board ' . $row["mac"] . '</strong> - Last Request Time: ' . $row_reading_time . '</p>';
    }
}

/*$DB_NAME = 'my_giandoweb';
$DB_HOST = 'localhost';
$DB_USER = 'giandoweb';
$DB_PASS = '';

$string = "mysql:host=" . $DB_HOST . ";dbname=" . $DB_NAME;
if (!$connection = new PDO($string, $DB_USER, $DB_PASS)) {
    die();
}
$val3 = date("Y/m/d");
date_default_timezone_set("Europe/Rome");
$time = date("h:i:sa");
$tim = $time;

$ip_address = $_SERVER['HTTP_CF_CONNECTING_IP'];
$geopluginURL = 'http://ip-api.com/php/' . $ip_address;
$addrDetailsArr = unserialize(file_get_contents($geopluginURL));

$ip_address = $addrDetailsArr['query'];
$city = $addrDetailsArr['city'];
$country = $addrDetailsArr['country'];
$isp = $addrDetailsArr['isp'];

ob_start();
system('ipconfig /all');
$mycom = ob_get_contents();

ob_clean();

$findme = "Physical";
$pmac = strpos($mycom, $findme);
$mac = substr($mycom, ($pmac + 36), 17);

$arr['val3'] = $val3;
$arr['tim'] = $tim;
$arr['ip_address'] = $ip_address;
$arr['mac'] = $mac;
$arr['city'] = $city;
$arr['country'] = $country;
$arr['isp'] = $isp;
$arr['pagina'] = 'wakeonarduino/view';

$sql = "INSERT INTO ipuser(logindate, logintime, ip, mac, city, country, isp, page) values(:val3, :tim, :ip_address, :mac, :city, :country, :isp, :pagina)";

$stm = $connection->prepare($sql);
$stm->execute($arr);*/
?>

<!DOCTYPE HTML>
<html>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="esp-style.css">
    <title>Wake on Arduino</title>

    <link rel="manifest" href="/wakeonarduino/img/manifest.webmanifest">

    <meta name="msapplication-TileColor" content="#000000">
    <meta name="msapplication-TileImage" content="/wakeonarduino/img/ms-icon-144x144.png">
    <meta name="theme-color" content="#000000">

    <meta name="application-name" content="Wake on Arduino">
    <meta name="apple-mobile-web-app-title" content="WakeOnArduino">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">

    <link rel="shortcut icon" href="/wakeonarduino/img/favicon.ico" type="image/x-icon">

    <link rel="apple-touch-icon" href="/wakeonarduino/img/apple-icon.png">

    <link rel="apple-touch-icon" sizes="57x57" href="/wakeonarduino/img/apple-icon-57x57.png">
    <link rel="apple-touch-icon" sizes="60x60" href="/wakeonarduino/img/apple-icon-60x60.png">
    <link rel="apple-touch-icon" sizes="72x72" href="/wakeonarduino/img/apple-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="76x76" href="/wakeonarduino/img/apple-icon-76x76.png">
    <link rel="apple-touch-icon" sizes="114x114" href="/wakeonarduino/img/apple-icon-114x114.png">
    <link rel="apple-touch-icon" sizes="120x120" href="/wakeonarduino/img/apple-icon-120x120.png">
    <link rel="apple-touch-icon" sizes="144x144" href="/wakeonarduino/img/apple-icon-144x144.png">
    <link rel="apple-touch-icon" sizes="152x152" href="/wakeonarduino/img/apple-icon-152x152.png">
    <link rel="apple-touch-icon" sizes="180x180" href="/wakeonarduino/img/apple-icon-180x180.png">
    <link rel="icon" type="image/png" sizes="192x192" href="/wakeonarduino/img/android-icon-192x192.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/wakeonarduino/img/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="96x96" href="/wakeonarduino/img/favicon-96x96.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/wakeonarduino/img/favicon-16x16.png">


    <script type="text/javascript" src="/wakeonarduino/s-w.js"></script>

    <script>
        $(document).ready(function() {
            if (!(sessionStorage.getItem('token') || localStorage.getItem('token'))) {
                
            }
        });
        if ("serviceWorker" in navigator) {
            window.addEventListener("load", function() {
                navigator.serviceWorker
                    .register('/wakeonarduino/s-w.js', {
                        scope: '/wakeonarduino/'
                    })
                    .then(res => console.log("service worker registered"))
                    .catch(err => console.log("service worker not registered", err))
            })
        } else {
            console.log("Service worker not supported!");
        }
    </script>
</head>

<body>
    <br>
    <br>
    <h2>Wake On Lan</h2>
    <?php echo $html_buttons; ?>
    <br><br>
    <?php echo $html_boards; ?>
    <br><br>
    <div>
        <form onsubmit="return createOutput();">
            <h3>Create New Output</h3>

            <label for="outputName">Name</label>
            <input type="text" name="name" id="outputName"><br>

            <label for="outputMac">Mac</label>
            <input type="text" name="mac" id="outputMac">

            <!--<label for="outputState">Initial WOL State</label>
            <select id="outputState" name="state">
                <option value="0">0 = OFF</option>
                <option value="1">1 = ON</option>
            </select>-->
            <input type="submit" value="Create Output">
            <p><strong>Note:</strong> in some devices, you might need to refresh the page to see your newly created buttons or to remove deleted buttons.</p>
        </form>
    </div>

    <div>
        <br>Created by Giandomenico Mazzilli.
    </div>

    <script>
        function updateOutput(element) {
            var xhr = new XMLHttpRequest();
            if (element.checked) {
                xhr.open("GET", "esp-outputs-action.php?action=output_update&id=" + element.id + "&state=1", true);
            } else {
                xhr.open("GET", "esp-outputs-action.php?action=output_update&id=" + element.id + "&state=0", true);
            }
            xhr.send();
        }

        function deleteOutput(element) {
            var result = confirm("Want to delete this output?");
            if (result) {
                var xhr = new XMLHttpRequest();
                xhr.open("GET", "esp-outputs-action.php?action=output_delete&id=" + element.id, true);
                xhr.send();
                alert("Output deleted");
                setTimeout(function() {
                    window.location.reload();
                });
            }
        }

        function createOutput(element) {
            var xhr = new XMLHttpRequest();
            xhr.open("POST", "esp-outputs-action.php", true);

            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

            xhr.onreadystatechange = function() {
                if (this.readyState === XMLHttpRequest.DONE && this.status === 200) {
                    alert("Output created");
                    setTimeout(function() {
                        window.location.reload();
                    });
                }
            }
            var outputName = document.getElementById("outputName").value;
            var outputMac = document.getElementById("outputMac").value;
            // var outputState = document.getElementById("outputState").value;
            var outputState = 0; // 0 ==> OFF

            var httpRequestData = "action=output_create&name=" + outputName + "&mac=" + outputMac + "&state=" + outputState;
            xhr.send(httpRequestData);
        }
    </script>
</body>

</html>