<?php 
    //Page title
    $title = 'Details';
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
    

    //Include header file
    include 'header.php';


?>
<section>
    <div class="container">
        <div class="entry-list single">
            <article>
                <h1><?php echo $item_title; ?></h1>
                
                <time datetime="<?php echo $item_date; ?>">
                    <?php echo date("F j, Y", strtotime($item_date)); ?>
                </time>
                <div class="entry">
                    <h3>Time Spent: </h3>
                    <p><?php echo $item_duration; ?></p>
                </div>
                <div class="entry">
                    <h3>What I Learned:</h3>
                    <p><?php echo $item_learned; ?></p>
                </div>
                <div class="entry">
                    <h3>Resources to Remember:</h3>
                    <p><?php echo $item_resources; ?></p>
                </div>
            </article>
        </div>
    </div>
    <div class="edit">
        <p>
            <a href="edit.php?id=<?php echo $id; ?>">Edit Entry</a> | 
            <a href="#">Delete Entry</a>
        </p>
    </div>
</section>
<?php 
    //Include footer file
    include 'footer.php';
?>