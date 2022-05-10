<?php
include_once('esp-database.php');
ini_set("dysplay_errors", 0);
error_reporting(0);


$action = $id = $name = $state = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $action = test_input($_POST["action"]);
    if ($action == "output_create") {
        $name = test_input($_POST["name"]);
        $mac = test_input($_POST["mac"]);
        $state = test_input($_POST["state"]);

        $result = createOutput($name, $mac, $state);

        echo $result;
    } else {
        echo "No data posted with HTTP POST.";
    }
}

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $action = test_input($_GET["action"]);

    if ($action == "outputs_state") {
        $id = test_input($_GET["id"]);
        $result = getAllOutputStates();

        // build json with states
        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $rows[$row["mac"]] = $row["state"];
            }
        }
        echo json_encode($rows);
    } else 
    if ($action == "output_update") {
        $id = test_input($_GET["id"]);
        $state = test_input($_GET["state"]);
        $result = updateOutput($id, $state);
        echo $result;
    } else 
    if ($action == "output_delete") {
        $id = test_input($_GET["id"]);
        $result = deleteOutput($id);
        echo $result;
    } else {
        echo "Invalid HTTP request.";
    }
}

function test_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
