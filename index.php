<?php 
    //Page title
    $title = 'Index';
    //Require functions file
    require 'inc/functions.php';

    if (isset($_POST['delete'])) {
        if (deleteItem(filter_input(INPUT_POST, 'delete', FILTER_SANITIZE_NUMBER_INT))) {

            header('location: index.php?msg=Entry deleted');
            exit;
        } else {
            header('location: index.php?msg=Unable to delete this entry');
            exit;
        }
    }

    if (isset($_GET['msg'])) {
        $error_message = trim(filter_input(INPUT_GET, 'msg', FILTER_SANITIZE_STRING));
    }

    //Include header file
    include 'header.php';
?>

<section>
    <div class="container">
        <div class="entry-list">
            <?php 
            if (isset($error_message)) {
                echo '<p class="message">' . $error_message . '<a href="index.php" class="close">x</a></p>';
            }
            ?>

            <?php //Loop start
            foreach (getJournalItems() as $item) { 
                $id = $item['id']; //Get id
                $item_title = $item['title']; //Get title
                $item_date = $item['date']; //Get date
                ?>
                <article>
                    <h2>
                        <a href="detail.php?id=<?php echo $id; ?>">
                            <?php echo $item_title; ?>
                        </a>
                    </h2>
                    <div class="flex-container">
                        <time datetime="<?php echo $item_date; ?>">
                            <?php 
                                echo date("F j, Y ", strtotime($item_date)); 
                                echo " | ";
                            ?>
                        </time> 
                        <form method="POST" action="index.php" onsubmit="return confirm('Are you sure you want to delete this?');">
                            <input type="hidden" value="<?php echo $id; ?>" name="delete">
                            <input type="submit" value="Delete Entry" class="delete">
                        </form>
                    </div>
                </article>
            <?php }  //Loop end?>
        </div>
    </div>
</section>

<?php 
    //Include footer file
    include 'footer.php';
?>