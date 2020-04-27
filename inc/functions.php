<?php 

//Function to get all rows in db table
function getJournalItems() {

	include 'connection.php';

	$sql = 'SELECT * FROM entries ORDER BY date DESC';

	try {
		return $db->query($sql);
	} catch (Exception $e) {
		echo "Error!: " . $e->getMessage() . "<br />";
		return array();
	}

}

function getItemDetails($id) {
	include 'connection.php';

	$sql = 'SELECT * FROM entries WHERE id = ?';

	try {
	    $results = $db->prepare($sql);
	    $results->bindParam(1,$id,PDO::PARAM_INT);
	    $results->execute();
	  } catch (Exception $e) {
	    echo "Unable to retrived results";
	    exit;
	  }
	  $item = $results->fetch();
	  return $item;
}

function addEntry($item_title, $item_date, $item_duration, $item_learned, $item_resources = null) {

	include 'connection.php';

	$sql = 'INSERT INTO entries (title, date, time_spent, learned, resources) VALUES (?, ?, ?, ?, ?)';
	
	try {
		$db->beginTransaction();
		
		$results = $db->prepare($sql);
		$results->bindValue(1, $item_title, PDO::PARAM_STR);
		$results->bindValue(2, $item_date, PDO::PARAM_STR);
		$results->bindValue(3, $item_duration, PDO::PARAM_STR);
		$results->bindValue(4, $item_learned, PDO::PARAM_STR);
		$results->bindValue(5, $item_resources, PDO::PARAM_STR);
		$results->execute();

		$db->commit();

	} catch (Exception $e) {
		echo "Error!: " . $e->getMessage() . "<br />";
		return false;
	}
	return true;
}

function editEntry($id, $item_title, $item_date, $item_duration, $item_learned, $item_resources = null) {

	include 'connection.php';

	$sql = 'UPDATE entries SET title = ?, date = ?, time_spent = ?, learned = ?, resources = ? WHERE id = ?';

	try {

		$db->beginTransaction();

        $results = $db->prepare($sql);
        $results->bindValue(1, $item_title, PDO::PARAM_STR);
        $results->bindValue(2, $item_date, PDO::PARAM_STR);
        $results->bindValue(3, $item_duration, PDO::PARAM_STR);
        $results->bindValue(4, $item_learned, PDO::PARAM_STR);
        $results->bindValue(5, $item_resources, PDO::PARAM_STR);
        $results->bindValue(6, $id, PDO::PARAM_INT);
        $results->execute();
        $db->commit();

	} catch (Exception $e) {
		echo "Error!: " . $e->getMessage() . "<br />";
		return false;
	}
	return true;

}

function deleteItem($id) {

	include 'connection.php';

	$sql = 'DELETE FROM entries WHERE id = ?';

	try {
		
	    $results = $db->prepare($sql);
	    $results->bindParam(1,$id,PDO::PARAM_INT);
	    $results->execute();

	  } catch (Exception $e) {
	    echo "Unable to delete";
	    return false;
	  }

	  return true;
}


?>