<?php 
    //Page title
    $title = 'Add new';
    //Require functions file
    require 'inc/functions.php';

    $item_title = $item_date = $item_duration = $item_learned = $item_resources = '';

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
            if(addEntry($item_title, $item_date, $item_duration, $item_learned, $item_resources)) {
                header('location:index.php');
                exit;
            } else {
                $error_message = 'Could not add new entry. Try again.';
            }
        }
    }

    //Include header file
    include 'header.php';

?>
<section>
    <div class="container">
        <div class="new-entry">
            <h2>New Entry</h2>
            <?php
            if (isset($error_message)) {
                echo '<p class="message">' . $error_message . '</p>';
            }
            ?>
            <form method="POST" action="new.php">
                <label for="title"> Title</label>
                <input id="title" type="text" name="title" value="<?php echo htmlspecialchars($item_title); ?>"><br>
                <label for="date">Date</label>
                <input id="date" type="date" name="date" value="<?php echo htmlspecialchars($item_date); ?>"><br>
                <label for="time-spent"> Time Spent</label>
                <input id="time-spent" type="text" name="timeSpent" value="<?php echo $item_duration; ?>"><br>
                <label for="what-i-learned">What I Learned</label>
                <textarea id="what-i-learned" rows="5" name="whatILearned"><?php echo $item_learned; ?></textarea>
                <label for="resources-to-remember">Resources to Remember</label>
                <textarea id="resources-to-remember" rows="5" name="resourcesToRemember"><?php echo $item_resources; ?></textarea>
                <input type="submit" value="Publish Entry" class="button">
                <a href="index.php" class="button button-secondary">Cancel</a>
            </form>
        </div>
    </div>
</section>
<?php 
    //Include footer file
    include 'footer.php';
?>