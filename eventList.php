<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
require_once 'Classes/DBInfo.php';
require_once 'Classes/Database.php';
$Database = new Database();
$Connection = $Database::Connect($Server, $Username, $Password, $DatabaseName);
$Result = $Database::Read($Connection, "SELECT * FROM `events` ORDER BY `eventId` DESC");
$_SESSION['currentEvents'] = md5(serialize($Result));
$Database::Disconnect($Connection);
if (count($Result) == 0) {
    ?>
    <h1 class="noData">No events.</h1>
    <?php
} else {
    foreach ($Result as $Value) {
        $eventId = $Value["eventId"];
        $eventTitle = $Value["title"];
        ?>
        <a id='<?php echo $eventId; ?>' class='eventName' href='registration.php'><?php echo $eventTitle; ?></a><br>
        <?php
    }
}
?>