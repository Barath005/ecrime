<?php 
// array for JSON response
$response = array();

// include db connect class
require_once __DIR__ . '/db_connect.php';

// connecting to db


$data = json_decode(file_get_contents("php://input"));
$get_id_1 =$_POST['cook_upload_id'];
//$get_id = substr($get_id_1, 1, -1);

if (!empty( $_FILES ))
{
	
	$tempPath = $_FILES[ 'file' ][ 'tmp_name' ];
    $target_dir = "uploads/";
	$uploadPath = $target_dir . basename($_FILES[ 'file' ][ 'name' ]);
	$imageFileType = pathinfo($uploadPath,PATHINFO_EXTENSION);
	
    $get_file = "http://localhost/projects/crime/web/uploads/".$_FILES[ 'file' ][ 'name' ]."";
    //$get_file = "http://10.0.2.2/projects/crime/web/uploads/".$_FILES[ 'file' ][ 'name' ]."";
	$encrypted = md5($get_file); // Encrypted output 
	

			
		$result = mysqli_query($conn,"SELECT * FROM complaint  ");

		if(mysqli_num_rows($result))
		{
			$response["details"] = array();	

			while($Alldetails = mysqli_fetch_array($result))
			{
				// temp user array
				$details = array();
				$encrypted_old_img = $Alldetails["field_17"];

				if (strcmp($encrypted ,$encrypted_old_img )==0)
				{
						$get_matched_id = $Alldetails["cus_id"];
						mysqli_query($conn,"UPDATE search SET email='$get_matched_id',field_1='$encrypted',field_2='$encrypted_old_img' WHERE cus_id='100' ");
				}
				array_push($response["details"],$details);
			}
				
			/*
			move_uploaded_file( $tempPath, $uploadPath );
			*/
			$answer = array( 'answer' => 'File transfer completed' );
			$json = json_encode( $answer );
			echo $json;
		}
		else
		{
			echo 'No files';
		}
		
	
	
} 
else 
{
    echo 'No files';
}

?>