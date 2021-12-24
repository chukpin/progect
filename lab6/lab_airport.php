<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
	<style>
		table,td {
			border: 1px solid #333333;
			border-collapse: collapse;
			padding:10px;

		}
	</style>
</head>
<body>
	
	<?php 
		
		$host = "localhost";
		$user = "root";
		$password = "";
		$database = "aerport";

		mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

		// connect to mysql database
		try{
		    $connect = mysqli_connect($host, $user, $password, $database);
		} catch (mysqli_sql_exception $ex) {
		    echo 'Error';
		}
			
		$aircraft_id = "";
		$model = "";
		$number_sits = "";
		$type = "";


		$email = "";

		function getPosts()
			{
			    $posts = array();
			    $posts[0] = $_POST['aircraft_id'];
			    $posts[1] = $_POST['model'];
			    $posts[2] = $_POST['number_sits'];
			    $posts[3] = $_POST['type'];
			    return $posts;
			}


			$sql = "SELECT * FROM aircrafts ORDER BY 'ASC' LIMIT 10";

				if (!$result = mysqli_query($connect, $sql)) {
			    echo "Извините, возникла проблема в работе сайта.";
			    exit;
			}

			echo "<table>\n";
			echo "<thead><tr><th colspan = '4'>Самолеты</tr></th></thead>\n";
				while ($admin = $result->fetch_assoc()) {
					echo "<tr>\n";
				    echo "<td>" . $admin['aircraft_id'] . "</td><td>". $admin['model'] . "</td><td>" . $admin['number_sits'] . "</td><td>" . $admin['type'] . "</td>" ;
				    echo "</tr>";
				}

			echo "</table>\n";


			// Search
			if(isset($_POST['search']))
			{
			    $data = getPosts();
			    
			    $search_Query = "SELECT * FROM aircrafts WHERE aircraft_id = $data[0]";
			    
			    $search_Result = mysqli_query($connect, $search_Query);
			    
			    if($search_Result)
			    {
			        if(mysqli_num_rows($search_Result))
			        {
			            while($row = mysqli_fetch_array($search_Result))
			            {
			                $aircraft_id = $row['aircraft_id'];
			                $model = $row['model'];
			                $number_sits = $row['number_sits'];
			                $type = $row['type'];
			            }
			        }else{
			            echo 'No Data For This Id';
			        }
			    } else{
			        echo 'Result Error';
			    }
			}

			

			// Insert
			if(isset($_POST['insert']))
			{
			    $data = getPosts();
			    $insert_Query = "INSERT INTO `aircrafts`(`model`, `number_sits`, `type`) VALUES ('$data[1]','$data[2]','$data[3]')";
			    try{
			        $insert_Result = mysqli_query($connect, $insert_Query);
			        
			        if($insert_Result)
			        {
			            if(mysqli_affected_rows($connect) > 0)
			            {
			                echo 'Data Inserted';
			            }else{
			                echo 'Data Not Inserted';
			            }
			        }
			    } catch (Exception $ex) {
			        echo 'Error Insert '.$ex->getMessage();
			    }
			}


			// Delete
			if(isset($_POST['delete']))
			{
			    $data = getPosts();
			    $delete_Query = "DELETE FROM `aircrafts` WHERE `aircraft_id` = $data[0]";
			    try{
			        $delete_Result = mysqli_query($connect, $delete_Query);
			        
			        if($delete_Result)
			        {
			            if(mysqli_affected_rows($connect) > 0)
			            {
			                echo 'Data Deleted';
			            }else{
			                echo 'Data Not Deleted';
			            }
			        }
			    } catch (Exception $ex) {
			        echo 'Error Delete '.$ex->getMessage();
			    }
			}


			// Edit
			if(isset($_POST['update']))
			{
			    $data = getPosts();
			    $update_Query = "UPDATE `aircrafts` SET `model`='$data[1]',`number_sits`='$data[2]',`type`='$data[3]' WHERE `aircraft_id` = $data[0]";
			    try{
			        $update_Result = mysqli_query($connect, $update_Query);
			        
			        if($update_Result)
			        {
			            if(mysqli_affected_rows($connect) > 0)
			            {
			                echo 'Data Updated';
			            }else{
			                echo 'Data Not Updated';
			            }
			        }
			    } catch (Exception $ex) {
			        echo 'Error Update '.$ex->getMessage();
			    }
			}


		?>

	<form action="lab_airport.php" method="post"><br><br>
		<input type="number" name = "aircraft_id" placeholder = "aircraft_id" value="<?php echo $aircraft_id;?>"><br><br>
		<input type="text" name = "model" placeholder = "model" value="<?php echo $model;?>"><br><br>
		<input type="number" name = "number_sits" placeholder = "number_sits" value="<?php echo $number_sits;?>"><br><br>
		<input type="text" name = "type" placeholder = "type" value="<?php echo $type;?>"><br><br>
		
		<div>
			<input type="submit" name = "insert" value="Add">
			<input type="submit" name = "update" value="Update">
			<input type="submit" name = "delete" value="Delete">
			<input type="submit" name = "search" value="Search">
		</div>
	</form>




	
</body>
</html>