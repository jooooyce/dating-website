<?php

/*
Group09: Ellen Coombs, Will Beniuk, Andrew Daigneault & Yina Qin
November 10th, 2015
WEDE3201
*/

$title = "Profile Images";
$date = "2015-11-10";
$filename = "profile_images.php";
$banner = "Profile Images";
$description = "This page serves as a image upload page for the user.";

include ("header.php");
include ("secure-navbar.php");
?>

<?php
	
	if(isset($_SESSION['user']))
	{
		$userId = $_SESSION['user']['user_id'];
		$record = pg_execute($conn, "user_query", array($userId));
		$records = pg_num_rows($record);
		$directory = "images/".$userId."/";
		$output = "";

		if ($records == 1)
		{
			$user = pg_fetch_assoc($record, 0);
			$userType = $user['user_type'];
			
			if ($userType == ADMIN)
			{
				pageRedirect("admin.php");
			}
			elseif($userType == INCOMPLETE_CLIENT)
            {
                $_SESSION['profileMessage'] = "You must create a profile before you can upload a picture.";
                pageRedirect("create_profile.php");
            }
            
			elseif ($userType != CLIENT)
			{
                
				pageRedirect("index.php");
			}
		}
		
		else
		{
			pageRedirect("index.php");
		}
			
		if($_SERVER["REQUEST_METHOD"] == "POST") 
		{
			$fileCount = count(glob($directory . '*.jpg'));
			$fileNumber = ($fileCount + 1);
			$error = 0;
			
			if(isset($_POST["mainPhoto"]))
			{
				if(isset($_POST['mainBox']))
				{
					$selectedImage = $_POST['mainBox'];
					$file = $directory . $selectedImage . '.jpg';
					$newName = $directory . $userId . '.jpg';
					rename($file, $newName);
					
					$counter = 1;
					$dir = opendir($directory);
					
					while (false !== ($file = readdir($dir)))
					{
						if (strtolower(pathinfo($file, PATHINFO_EXTENSION)) == 'jpg')
						{
							$newName = $directory . $userId . $counter . 'x.jpg';
							$file = $directory . $file;
							rename($file, $newName);
							$counter++;
						}
					}
					
					closedir($dir);
					$dir = opendir($directory);
					
					$counter = 1;
					while (false !== ($file = readdir($dir)))
					{
						if (strtolower(pathinfo($file, PATHINFO_EXTENSION)) == 'jpg')
						{
							$newName = $directory . $userId . $counter . '.jpg';
							$file = $directory . $file;
							rename($file, $newName);
							$counter++;
						}
					}
					
					closedir($dir);
				}
			}
		
			
			
			if(isset($_POST["deletePhoto"]))
			{
			
				for ($counter = 1; $counter <= $fileCount; $counter++)
				{
					$button = "delete" . $counter;
					
					if (isset($_POST[$button]))
					{
						$fileToDelete = $directory . $userId . $counter . ".jpg";
						unlink($fileToDelete);
					}
				}
				
				$counter = 1;
				$dir = opendir($directory);
					
				while (false !== ($file = readdir($dir)))
				{
					if (strtolower(pathinfo($file, PATHINFO_EXTENSION)) == 'jpg')
					{
						$newName = $directory . $userId . $counter . '.jpg';
						$file = $directory . $file;
						rename($file, $newName);
						$counter++;
					}
				}
				
				closedir($dir);
				
				$fileCount = count(glob($directory . '*.jpg'));
				if ($fileCount < MINIMUM_PROFILE_IMAGES)
				{
					rmdir($directory);
				}
			}
			
			if(isset($_POST["submit"])) 
			{
				$test_file = $directory . basename($_FILES["uploadFile"]["name"]);
				$imageFileType = pathinfo($test_file,PATHINFO_EXTENSION);
				$target_file = $directory . $userId . $fileNumber . ".jpg";
				$isImage = getimagesize($_FILES["uploadFile"]["tmp_name"]);
				
				if($isImage == false) 
				{
					$output .= "File is not an image.<br />";
					$error = 1;
				}
									
				if ($_FILES["uploadFile"]["size"] > MAXIMUM_IMAGE_SIZE) 
				{
					$output .= "Your file is larger than the " . MAXIMUM_IMAGE_SIZE . "kb limit.<br />";
					$error = 1;
				}
				
				if($imageFileType != "jpg" && $imageFileType != "jpeg" && $imageFileType != "pjpeg") 
				{
					$output .= "Only JPG, JPEG and PJPEG files are allowed.<br />";
					$error = 1;
				}
				
				if ($_FILES["uploadFile"]["error"] != 0)
				{
					$output .= "There was an error with your upload!<br />";
					$error = 1;
				}			
				
				if ($fileCount >= MAXIMUM_PROFILE_IMAGES)
				{
					$output .= "You've reached the maximum amount of images!<br />";
					$error = 1;
				}
				
				if ($error == 1) 
				{
					$output .= "Your file was not uploaded.<br />";
				} 
				
				else 
				{
					if (!file_exists("{$directory}")) 
					{
						mkdir("{$directory}", 0777, true);
					}
			
					if (move_uploaded_file($_FILES["uploadFile"]["tmp_name"], $target_file)) 
					{
						$output .= "The file ". basename( $_FILES["uploadFile"]["name"]). " has been uploaded.<br />";
					} 
					
					else 
					{
						$output .= "There was an error uploading your file.<br />";
					}
				}
			}
			
			if (file_exists("{$directory}")) 
			{
				$fileCount = count(glob($directory . '*.jpg'));
			}
			
			else
			{
				$fileCount = 0;
			}
			
			
			pg_execute($conn, "image_update", array($fileCount, $userId));
			
		}
	
	
		
	}
	
	else
	{
			pageRedirect("index.php");
	}
?>

<div class="container body-container" role="main">
	<section class="no-padding" id="portfolio">
		<div class="col-lg-12 text-center"><br/>
			<h2 class="section-heading">Image Upload</h2>
			<hr class="primary"/>
			<p><?php echo $output; ?></p>
			
			<?php
			if (file_exists("{$directory}")) 
			{
				$fileCount = count(glob($directory . '*.jpg'));
			}
			
			else
			{
				$fileCount = 0;
			} 
			?>
			
			<table align="center"><tr>
			<?php 
				if (file_exists("{$directory}")) 
				{
					$images = glob($directory."*.{jpg,jpeg,pjpeg}", GLOB_BRACE);
					foreach($images as $image) 
					{
						echo '<td><img src="'.$image.'" alt="Personal Image" width="110" /><br /></td>';
					}
				}
			?>
			</tr></table>
			
			
			<form id="updateForm" enctype="multipart/form-data" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
			<?php
				$counter = 1;
				if (file_exists("{$directory}")) 
				{
					foreach ($images as $image)
					{
						$name = "delete" . $counter;
						echo "<input type='checkbox' name='" . $name . "' value='delete" . $counter . "' /><label> Delete</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
						$counter++;
					}
					
					echo "<br />";
					$counter = 1;
					
					foreach ($images as $image)
					{
						$value = $userId . $counter;
						echo "<input type='radio' name='mainBox' value='". $value . "' /><label> Main</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
						$counter++;
					}
					echo "<br /><br /><input type='submit' value='Delete selected images' name='deletePhoto' />";
					echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
					echo "<input type='submit' value='Update main image' name='mainPhoto' />";
				}
			?>
			</form>
			
			<br/><br/>
			
			<form id="uploadForm" enctype="multipart/form-data" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>"><p align="center">
				<?php
					if ($fileCount < MAXIMUM_PROFILE_IMAGES)
					{
						echo "<strong>Select image for upload: </strong><br/><br/>";
						echo "<input type='file' name='uploadFile' id='uploadFile' style='padding-left: 95px'/><br/>";
						echo "<input type='submit' value='Upload New Image' name='submit' />";
					}
					else
					{
						echo "<strong>You must delete a photo before uploading a new one!</strong>";
					}
				?>
			</p></form>
			<form id="deleteformm" enctype="multipart/form-data" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
				
			</form>	
		</div>
	</section>
</div>

<?php include ("footer.php");?>