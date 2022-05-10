<?php
$servername = "localhost";
// Your Database name
$dbname = "DBNAME";
// Your Database user
$username = "localhost";
// Your Database user password
$password = "";

function createOutput($name, $mac, $state)
{
    global $servername, $username, $password, $dbname;

    $conn = new mysqli($servername, $username, $password, $dbname);
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "INSERT INTO wol (name, mac, state)
        VALUES ('" . $name . "', '" . $mac . "', '" . $state . "')";

    if ($conn->query($sql) === TRUE) {
        return "New output created successfully";
    } else {
        return "Error: " . $sql . "<br>" . $conn->error;
    }
    $conn->close();
}

function deleteOutput($id)
{
    global $servername, $username, $password, $dbname;

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "DELETE FROM wol WHERE id='" . $id .  "'";

    if ($conn->query($sql) === TRUE) {
        return "Output deleted successfully";
    } else {
        return "Error: " . $sql . "<br>" . $conn->error;
    }
    $conn->close();
}

function updateOutput($id, $state)
{
    global $servername, $username, $password, $dbname;

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "UPDATE wol SET state='" . $state . "' WHERE id='" . $id .  "'";

    if ($conn->query($sql) === TRUE) {
        return "Output state updated successfully";
    } else {
        return "Error: " . $sql . "<br>" . $conn->error;
    }
    $conn->close();
}

function getAllOutputs()
{
    global $servername, $username, $password, $dbname;

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "SELECT id, name, mac, state, last_request FROM wol ORDER BY id";
    if ($result = $conn->query($sql)) {
        return $result;
    } else {
        return false;
    }
    $conn->close();
}

function getOutput($id)
{
    global $servername, $username, $password, $dbname;

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "SELECT * FROM wol WHERE id '" . $id . "'";
    if ($result = $conn->query($sql)) {
        return $result;
    } else {
        return false;
    }
    $conn->close();
}

function getAllOutputStates()
{
    global $servername, $username, $password, $dbname;

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "SELECT mac, state FROM wol";
    if ($result = $conn->query($sql)) {
        return $result;
    } else {
        return false;
    }
    $conn->close();
}

function updateLastWolTime($id)
{
    global $servername, $username, $password, $dbname;

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "UPDATE wol SET last_request=now() WHERE id='" . $id .  "'";

    if ($conn->query($sql) === TRUE) {
        return "Output state updated successfully";
    } else {
        return "Error: " . $sql . "<br>" . $conn->error;
    }
    $conn->close();
}
