<?php # Ullman Advanced -  register.php
// This script performs an INSERT query to add a record to the users table.

$page_title = 'Class_create';
include ('../includes/header_login.php');

// Check for form submission:
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

	$errors = array(); // Initialize an error array.
	
	// Check for a day:
	if (empty($_POST['day'])) {
		$errors[] = 'You forgot to enter the day of the class.';
	}
	
	// Check for a hour:
	if (empty($_POST['hour'])) {
		$errors[] = 'You forgot to enter the hour of the class.';
	}
	
	// Check for a duration:
	if (empty($_POST['duration'])) {
		$errors[] = 'You forgot to enter the duration of the class.';
	}
	
	if (empty($errors)) { // If everything's OK.
	
		require ('../connect.php'); // Connect to the db
		
		$id=$_GET['id'];
		
		// Make query data save
	
		// Make the query:
		
		$sql = "INSERT INTO time_class VALUES (NULL, ".$id.", ".$_POST['teacher_name'].", '".$_POST['day']."', '".$_POST['hour']."', '".$_POST['duration']."')";
		$res = mysqli_query ($db, $sql);
		
		if ($res) { // If it ran OK.

			// Print a message:
			echo '<h1>The class was added successfully</h1>';	
			echo '<p><a class="new" href=5.create_timetable.php?id='.$id.'>Add a new one</a></p>';
			echo '<p><a class="goback" href="1.home_adm.php">Go to home page</a></p>';

		} else { // If it did not run OK.
	
			// Public message:
			echo '<h1>System Error</h1>
			<p class="error">You could not be registered due to a system error. We apologize for any inconvenience.</p>'; 

			echo '<p>' . mysqli_error($db) . '<br /><br />Query: ' . $sql . '</p>';
				
		} // End of if ($r) IF.
		
		mysqli_close($db); // Close the database connection.
		
		// Include the footer and quit the script:
		include ('../includes/footer.php'); 
		exit();
	
	} else { // Report the errors.
	
		echo '<h1>Error!</h1>
		<p class="error">The following error(s) occurred:<br />';
		foreach ($errors as $msg) { // Print each error.
			echo " - $msg<br />\n";
		}
		echo '</p><p>Please try again.</p><p><br /></p>';
		
	} // End of if (empty($errors)) IF.

} // End of the main Submit conditional.
?>
<?php
	require ('../connect.php');
	$id=$_GET['id'];
	$sql="SELECT * from class where id_class=".$id;
    $result = mysqli_query ($db, $sql);
    $num = mysqli_num_rows($result);
    $row = mysqli_fetch_array($result);

	echo '<h1>Create a new Timetable for '.$row['name_class'].'</h1>';
?>
<form action="" method="post">
    	<table class="form">
		<tr>
			<td>Teacher Name:</td>
        	<td><select name='teacher_name'>";
				<?php 
					require ('../connect.php');
					$sql = "SELECT id_teacher, first_name, last_name FROM teacher";
					$res = mysqli_query ($db, $sql);
					
   					while ($row = mysqli_fetch_array($res)) {
						echo '<option value="'.$row["id_teacher"].'">'.$row["first_name"].' '.$row["last_name"].'</option>';
    				}
    			?>
	    </select></td>
		</tr>
		<tr>
			<td>Day:</td>
			<td><input type="text" name="day" size="15" maxlength="20" /></td>
		</tr>
		<tr>
			<td>Hour:</td>
			<td><input type="text" name="hour" size="15" maxlength="20" /></td>
		</tr>
		<tr>
			<td>Duration:</td>
			<td><input type="text" name="duration" size="15" maxlength="20" /></td>
		</tr>
	</table>
	<p><input type="submit" name="submit" value="Create" /></p>
</form>
<a class="goback" href="5.timetable_list.php?id=<?php echo $_GET['id']; ?>">Go back</a>
<?php include ('../includes/footer.php'); ?>
