<?php

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
require_once 'dbinfo.php';
require_once 'Database.php';
require_once 'Tools.php';
$Database = new Database();
$Tool = new Tools();
$Connection = $Database::Connect($Server, $Username, $Password, $DatabaseName);
// Database Operations
if ($Connection != null) {
    if (isset($_POST['Create'])) {
        if ($_POST['Create'] == "insertEvent") {
            $Column = array("title", "information");
            $Data = array($_POST['title'], $_POST['description']);
            $Database::Create($Connection, "events", $Column, $Data);
        }
    }
    if (isset($_POST['Create'])) {
        if ($_POST['Create'] == "insertAttendee") {
            $Column = array("event", "firstName", "lastName", "company", "designation", "email", "contactNumber", "eventFee");
            $Data = json_decode($_POST['values']);
            array_unshift($Data, $_SESSION['eventId']);
            $Database::Create($Connection, "attendees", $Column, $Data);
        }
    }
    if (isset($_POST['Read'])) {
        if ($_POST['Read'] == "checkUpdates") {
            if ($_POST['target'] == "attendee") {
                $EventId = $_SESSION['eventId'];
                $Result = $Database::Read($Connection, "SELECT * FROM `attendees` WHERE `event`='$EventId'");
                if (md5(serialize($Result)) == $_SESSION['currentAttendees']) {
                    echo "false";
                } else {
                    echo "true";
                }
            } else {
                $Result = $Database::Read($Connection, "SELECT * FROM `events` ORDER BY `eventId` DESC");
                if (md5(serialize($Result)) == $_SESSION['currentEvents']) {
                    echo "false";
                } else {
                    echo "true";
                }
            }
        }
    }
    if (isset($_POST['Update'])) {
        if ($_POST['Update'] === "tableCell") {
            $Database::Update($Connection, "attendees", $_POST['targetColumn'], $_POST['newValue'], $_POST['referenceColumn'], $_POST['referenceValue']);
            $Database::Disconnect($Connection);
        }
    }
    if (isset($_POST['Delete'])) {
        if ($_POST['Delete'] === "attendee") {
            $Database::Delete($Connection, "attendees", "attendeeId", $_POST['referenceValue']);
            $Database::Disconnect($Connection);
        }
        if ($_POST['Delete'] === "event") {
            $Database::Delete($Connection, "attendees", "event", $_SESSION['eventId']);
            $Database::Delete($Connection, "events", "eventId", $_SESSION['eventId']);
            $Database::Disconnect($Connection);
        }
    }
} else {
    echo '<h1>Connection Failed!</h1>';
}
$Database::Disconnect($Connection);

if (isset($_POST['Read'])) {
    if ($_POST['Read'] === "eventId") {
        $_SESSION['eventId'] = $_POST['eventId'];
        echo $_SESSION['eventId'];
    }
}