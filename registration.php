<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
require_once 'Classes/DBInfo.php';
require_once 'Classes/Database.php';
$Database = new Database();
$Connection = $Database::Connect($Server, $Username, $Password, $DatabaseName);
$Result = $Database::Read($Connection, "SELECT `title`, `information` FROM `events` WHERE `eventId`='" . $_SESSION['eventId'] . "';");
$Enum = $Database::Read($Connection, "SHOW COLUMNS FROM `attendees` WHERE FIELD='eventFee'");
$Database::Disconnect($Connection);
$EventFeeFields = explode("','", preg_replace("/(enum|set)\('(.+?)'\)/", "\\2", $Enum[0][array_keys($Enum[0])[1]]));
?>
<!DOCTYPE html>
<html lang="en">

    <head>
        <?php include 'Imports/top.php'; ?>
        <title><?php echo $PageTitle; ?></title>
    </head>

    <body>

        <?php require_once 'navigationBar.php'; ?>

        <textarea class="edit-box" rows="1"></textarea>
        <select class="edit-fee">
            <?php
            foreach ($EventFeeFields as $Value) {
                ?>
                <option value="<?php echo $Value; ?>"><?php echo $Value; ?></option>
            <?php } ?>
        </select>
        <div class="content">

            <h1 class="eventTitle"><?php echo $Result[0][array_keys($Result[0])[0]]; ?></h1>
            <span data-toggle="tooltip" data-placement="bottom" title="<?php echo $Result[0][array_keys($Result[0])[1]]; ?>" class="eventDescription">View Event Description</span>
            <br>
            <span class="addData" id="deleteEvent"> Delete Event <i class="fa fa-trash" aria-hidden="true"></i></span>
            <hr>
            <span class="addData" id="addAttendee"> Add <i class="fa fa-plus" aria-hidden="true"></i></span>
            <div id="attendeeList">
            </div>

            <div id="newAttendeeForm" class="modal fade" role="dialog">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title">New Attendee</h4>
                        </div>
                        <div class="modal-body">
                            <p>First Name</p>
                            <input type="text" class="form-control eventFormTitle" id="firstName" name="title">
                            <p>Last Name</p>
                            <input type="text" class="form-control eventFormTitle" id="lastName" name="title">
                            <p>Company</p>
                            <input type="text" class="form-control eventFormTitle" id="company" name="title">
                            <p>Designation</p>
                            <input type="text" class="form-control eventFormTitle" id="designation" name="title">
                            <p>Email Address</p>
                            <input type="text" class="form-control eventFormTitle" id="email" name="title">
                            <p>Contact Number</p>
                            <input type="digits" class="form-control eventFormTitle" id="contactNumber" name="title">
                            <p>Event Fee</p>
                            <div class="eventFeeValues">
                                <select id="eventFee">
                                    <option value=""></option>
                                    <?php
                                    foreach ($EventFeeFields as $Value) {
                                        ?>
                                        <option value="<?php echo $Value; ?>"><?php echo $Value; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-success" id="confirmNewAttendee">Confirm</button>
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>

            <div id="deleteEventForm" class="modal fade" role="dialog">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title">Delete Row</h4>
                        </div>
                        <div class="modal-body">
                            <p>Are you sure you want to delete <strong><?php echo $Result[0][array_keys($Result[0])[0]]; ?></strong>?</p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" id="confirmDeleteEvent" data-dismiss="modal">Yes</button>
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>

            <div id="deleteRow" class="modal fade" role="dialog">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title">Delete Row</h4>
                        </div>
                        <div class="modal-body">
                            <p>Are you sure you want to delete this row?</p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" id="confirmDeleteRow" data-dismiss="modal">Yes</button>
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <?php include 'Imports/bottom.php'; ?>

    </body>

</html>