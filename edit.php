<?php 
    //Page title
    $title = 'Edit';
    //Require functions file
    require 'inc/functions.php';
    

    if (isset($_GET["id"]) && !empty($_GET["id"])) {
        $id = filter_input(INPUT_GET,"id",FILTER_SANITIZE_NUMBER_INT);
        $item = getItemDetails($id);
        $item_title = $item['title']; //Get title
        $item_date = $item['date']; //Get date
        $item_duration = $item['time_spent']; //Get time spent
        $item_learned = $item['learned']; //Get learned
        $item_resources = $item['resources']; //Get resources
    }

    //Post edits to db
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);
        $item_title = trim(filter_input(INPUT_POST, 'title', FILTER_SANITIZE_STRING));
        $item_date = trim(filter_input(INPUT_POST, 'date', FILTER_SANITIZE_STRING));
        $item_duration = trim(filter_input(INPUT_POST, 'timeSpent', FILTER_SANITIZE_STRING));
        $item_learned = trim(filter_input(INPUT_POST, 'whatILearned', FILTER_SANITIZE_STRING));
        $item_resources = trim(filter_input(INPUT_POST, 'resourcesToRemember', FILTER_SANITIZE_STRING));

        if (empty($item_title) || empty($item_date) || empty($item_duration) || empty($item_learned) ) {
            $error_message = 'Please fill in the required fields';
        } else {
            if(editEntry($id, $item_title, $item_date, $item_duration, $item_learned, $item_resources)) {
                header("location:detail.php?id=$id");
                exit;
            } else {
                $error_message = 'Could not edit entry. Try again.';
            }
        }
    }

    //Include header file
    include 'header.php';

    

?>
<section>
    <div class="container">
        <div class="edit-entry">
            <h2>Edit Entry</h2>
            <?php 
            if (isset($error_message)) {
                echo '<p class="message">' . $error_message . '</p>';
            }
            ?>
            <form method="POST" action="edit.php">
                <label for="title"> Title</label>
                <input id="title" type="text" name="title" value="<?php echo $item_title; ?>"><br>
                <label for="date">Date</label>
                <input id="date" type="date" name="date" value="<?php echo $item_date; ?>"><br>
                <label for="time-spent"> Time Spent</label>
                <input id="time-spent" type="text" name="timeSpent" value="<?php echo $item_duration; ?>"><br>
                <label for="what-i-learned">What I Learned</label>
                <textarea id="what-i-learned" rows="5" name="whatILearned"><?php echo $item_learned; ?></textarea>
                <label for="resources-to-remember">Resources to Remember</label>
                <textarea id="resources-to-remember" rows="5" name="resourcesToRemember"><?php echo $item_resources; ?></textarea>
                <?php if(!empty($id)) { ?>
                <input type="hidden" name="id" value="<?php echo $id; ?>">
                <?php } ?>
                <input type="submit" value="Publish Entry" class="button">
                <a href="detail.php?id=<?php echo $id; ?>" class="button button-secondary">Cancel</a>
            </form>
        </div>
    </div>
</section>
<?php 
    //Include footer file
    include 'footer.php';
?>