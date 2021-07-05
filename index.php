<!DOCTYPE html>
<html lang="en">

    <head>
        <?php include 'Imports/top.php'; ?>
        <title><?php echo $PageTitle; ?></title>
    </head>

    <body>
        <?php require_once 'navigationBar.php'; ?>

        <div class="content">
            <h1 class="events">Events</h1>
            <br>
            <span class="addData" id="addEvent"> New Event <i class="fa fa-plus" aria-hidden="true"></i></span>
            <hr>
            <div id="eventList">
            </div>
            <!-- Create Event -->
            <div id="newEventForm" class="modal fade" role="dialog">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title">New Event</h4>
                        </div>
                        <div class="modal-body">
                            <p>Event Title</p>
                            <input type="text" class="form-control eventFormTitle" id="eventFormTitle" name="title">
                            <br>
                            <p>Event Description</p>
                            <textarea type="text" class="form-control eventFormDesc" id="eventFormDesc" name="title"></textarea>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-success" id="confirmNewEvent">Confirm</button>
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <?php include 'Imports/bottom.php'; ?>
    </body>
</html>