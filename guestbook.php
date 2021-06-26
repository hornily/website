<?php
error_reporting (E_ALL ^ E_NOTICE);
?>
<!DOCTYPE html>
<?php
include "headerr.php";
?>
<h2>guestbook</h2>
<br>
<div class="box">
<font color="white">
<?php
	/*****************************************************/
	// connect to the database
	$con=mysqli_connect("localhost","root","");
	mysqli_select_db($con,"guestbook");
	/*****************************************************/
	//posts
	
	$query = mysqli_query($con,"SELECT * FROM guestbook ORDER BY id DESC");
	$numrows = mysqli_num_rows($query);
	if ($numrows > 0){
		echo "<hr>";
		while ($row = mysqli_fetch_assoc ($query)) {
			$id = $row['id'];
			$name = $row['name'];
			$email = $row['email'];
			$message = $row['message'];
			$time = $row['time'];
			$date = $row['date'];
			$ip = $row['ip'];
		
			$message = nl2br($message);
			
			echo "<div>
				by <b>$name</b> at <b>$time</b> on <b>$date</b><br>
				$message
			</div> <hr>";
		}
		
	}
	else
		echo "no posts were found.";	
	?>
	</div>
	<?php
	/*****************************************************/
	// form and add stuff
	
	echo "<h2>post</h2>";
	
	if(isset($_POST["postbtn"])) {
		$name = strip_tags($_POST['name']);
		$email = strip_tags($_POST['email']);
		$message = strip_tags($_POST['message']);
		
		if ($name && $email && $message){
			
			$time = date("h:i A");
			$date = date("F d, y");
			$ip = $_SERVER['REMOTE_ADDR'];
			
			// add to the db
			mysqli_query($con,"INSERT INTO guestbook (id, email, message, time, date, ip) VALUES (
			'', '$name', '$email', '$message', '$time', '$date', '$ip'
			)");
			
			echo "your post has been added.";
			
		}
		else
			echo "you didn't enter in all of the required info. or tried to do xss :troll:";
	}
	?>
	
	<form action='./guestbook.php' method='post'>
	<table>
	<tr>
		<td>username:</td>
		<td><input type='text' name='name' style='width: 200px;' /></td>
	</tr>
	<tr>
		<td>email:</td>
		<td><input type='text' name='email' style='width: 200px;' /></td>
	</tr>
	<tr>
		<td>message:</td>
		<td><textarea name='message' style='width: 200px height: 100px;'></textarea></td>
	</tr>
	<tr>
		<td></td>
		<td><input type='submit' name='postbtn' value='post' /></td>
	</tr>
	</table>
	</form>";
	
	
	
	

</font>
</div>