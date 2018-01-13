<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
require_once 'Classes/DBInfo.php';
require_once 'Classes/Database.php';
$Database = new Database();
$Connection = $Database::Connect($Server, $Username, $Password, $DatabaseName);
$EventId = $_SESSION['eventId'];
$Result = $Database::Read($Connection, "SELECT * FROM `attendees` WHERE `event`='$EventId'");
$Database::Disconnect($Connection);
$_SESSION['currentAttendees'] = md5(serialize($Result));
if (count($Result) == 0) {
    ?>
    <h1 class="noData">No attendees.</h1>
    <?php
} else {
    ?>
    <h4>Head Count = <?php echo count($Result); ?></h4>
    <br><br>
    <table style="width:100%">
        <tr class="tableHeader">
            <th>Position</th><th>First Name</th><th>Last Name</th><th>Company</th><th>Designation</th><th>Email</th><th>Contact Number</th><th>Event Fee</th>
        </tr>
        <?php
        $position = 1;
        $ColumnNames = array_keys($Result[0]);
        foreach ($Result as $Value) {
            ?>
            <tr class="<?php echo $ColumnNames[0]; ?>" value="<?php echo $Value[$ColumnNames[0]]; ?>">
                <td class="position"><?php echo $position++; ?></td>
                <?php for ($i = 2; $i < count($ColumnNames); $i++) { ?>
                    <?php if ($Value[$ColumnNames[$i]] != null) { ?>
                        <td class="<?php echo $ColumnNames[$i]; ?>" value="true"><?php echo $Value[$ColumnNames[$i]]; ?></td>
                    <?php } else { ?>
                        <td class="<?php echo $ColumnNames[$i]; ?>" value="false"><span class="emptyCell">-</span></td>
                    <?php } ?>
                <?php } ?>
            </tr>
            <?php
        }
    }
    ?>
</table>