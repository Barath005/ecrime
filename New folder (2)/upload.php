<?php 
// array for JSON response
$response = array();

// include db connect class
require_once __DIR__ . '/db_connect.php';

// connecting to db


$data = json_decode(file_get_contents("php://input"));
$get_id_1 =$_POST['cook_app_id'];
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

	
	$result = mysqli_query($conn,"UPDATE complaint SET field_16='$get_file', field_17='$encrypted' WHERE cus_id='$get_id_1' ");
	// check for empty result
	if($result)
	{
		move_uploaded_file( $tempPath, $uploadPath );
		// success
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