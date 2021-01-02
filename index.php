<?php include 'inc/header.php' ?>

<?php include 'lib/config.php' ?>

<?php include 'lib/Database.php' ?>

	<?php
	$db = new Database();
	?>
	<?php 
		if ($_SERVER["REQUEST_METHOD"] == "POST")
		{
			$permitted =array('jpg','jpeg','png','gif');

			 $file_name  = $_FILES['image']['name'];


			 $file_size  = $_FILES['image']['size'];


			 $file_tmp  = $_FILES['image']['tmp_name'];

			 $div = explode('.', $file_name);

			  $file_extn = strtolower(end($div));

			 $unique_image = substr(md5(time()), 0 , 10).'.'. $file_extn;

			 	$upload_image = "uploads/".$unique_image;

			 	if (empty($file_name)) 
			 	{
			 		echo "<span class='error'>Please select image.</span>";
			 	}
			 	elseif ($file_size > 1048576) 
			 	{
			 		echo "<span class='error'>Image size should not be more 1 Kb.</span>";
			 	}
				 elseif (in_array($file_extn, $permitted) === false) 
					{
				     echo "<span class='error'>You can upload only:-"
				     .implode(', ',$permitted)."</span>";
			 	}
			 	else
			 	{



			 move_uploaded_file($file_tmp,$upload_image );

			 $query = "INSERT INTO `tbl_image` (`image`) VALUES('$upload_image ')";

			 $inserted_rows = $db ->insert($query);

			 if( $inserted_rows)
			 {
			 	echo "<span class='success'>Image inserted successfully.</span>";
			 }
			 else
			 {
			 	echo "<span class='error'>Image not inserted.</span>";
			 }

			}
			
		}


	?>


				<form action="" method="post" enctype="multipart/form-data">
					<?php 
					if(isset($_GET['del']))
					{
						$id = $_GET['del'];



							 $getquery = "select * from tbl_image where id='$id'";

						   $getImg = $db->select($getquery);

						  if ($getImg) 
						   {
						    while ($imgdata = $getImg->fetch_assoc()) 
						    {
						    $delimg = $imgdata['image'];

						    unlink($delimg);
						    }
						   }


					
					$query = "DELETE FROM `tbl_image` WHERE id ='$id'";

						$deleteImg = $db -> delete($query);

						if( $deleteImg)
						 {
						 	echo "<span class='success'>Image delete successfully.</span>";
						 }

						 else
						 {
						 	echo "<span class='error'>Image delete successfully.</span>";
						 }
						}






					?>

					<table width="100%">
						<tr>
							<td>Select Image</td>
							<td><input type="file" name = "image" /></td>
						</tr>

						<tr>
							<td></td>
							<td><input type="submit" name = "submit" value = "Upload image" /></td>
						</tr>
					</table>

				</form>
				<table>
					<tr>
						<th width="30%">Serial</th>
						<th width = "35%">image</th>
						<th width="30%">action</th>
					</tr>
				<?php
				$query = "SELECT * FROM `tbl_image`";

				$result = $db -> select($query);

				if ($result) 
				{
					$i = 0;
					while($getimage=$result->fetch_assoc())
					{
						$i++;

				
				?>
				<tr>
					<td><?php echo $i;?></td>
					<td><img src = "<?php echo $getimage['image']; ?>" height="100px" width = "100px" />"</td>
					<td><a href="?del=<?php echo $getimage['id']; ?>">delete</a></td>

				</tr>
				
				
				
			<?php }} ?>
			</table>
			</div>
<?php include 'inc/footer.php' ?>
			