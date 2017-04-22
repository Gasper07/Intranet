<?php 
require('lib/Pusher.php');

// Change the following with your app details:
// Create your own pusher account @ https://app.pusher.com
$app_id = '309483'; // App ID
$app_key = '1699db0a3a3aec4d93c6'; // App Key
$app_secret = '17a8b609741fa2891df9'; // App Secret
$pusher = new Pusher($app_key, $app_secret, $app_id);

//Open a new connection to the MySQL server
$mysqli = new mysqli("btzb9icdm-mysql.services.clever-cloud.com", "u6v5e7r3xhfoadzq", "2ZHpKpA8lD9rvgrOIPX", "btzb9icdm");

//Output any connection error
if ($mysqli->connect_error) {
    die('Error : ('. $mysqli->connect_errno .') '. $mysqli->connect_error);
}

if ( 0 < $_FILES['file']['error'] ) {
	print_r('ho');
}
else {
	$imageName = $_FILES['file']['name'];
	print_r($imageName);
	$SaveFile = \Storage::disk('ubUploadsChange')->put('documents/'.$imageName,  \File::get($_FILES['file']));
}
// 	print_r($_FILES['file']);
// 	// $targetPath2 = $_FILES['file']['name']; 
// 	// $direc = __FILE__;
// 	// $new = '../public/'.$direc;
// 	// $new2 = '/home/bas/app_7983e06f-f506-428d-aef9-aea82667c6d7/public/';
// 	// Upload file
// 	$dat = $_FILES['file'];
// 	$datN = dirname(__FILE__).'/uploads/'.$_FILES['file']['name'];
// 	$datN2 = dirname(__FILE__).'/public/uploads/'.$_FILES['file']['name'];
// 	// $sourcePath = "public/assets/images/";       
// 	// $targetPath = "documents-chat/".$_FILES['file']['name']; 
// 	move_uploaded_file($dat,$datN) ;
// 	move_uploaded_file($dat,$datN2) ;

// 	print_r($dat);
// 	print_r($datN);


// 	// if(!move_uploaded_file($_FILES['file'], 'uploads/' . $_FILES['file']['name'])){
// 	//     echo 'Error uploading file - check destination is writeable.';
// 	// }else{
// 	// 	echo 'se fue';
// 	// }

// 	print_r($new2);
// }

// Check the receive message
if(isset($_POST['message']) && !empty($_POST['message'])) {		
	$data['message'] = $_POST['message'];
	print_r($_FILES['file']);	

	$Menssage = $_POST['conversation'];	
	$id_user = $_POST['id_Usuario'];	
	$id_userConversation = $_POST['id_Usuario_conversation'];	
	
	// Return the received message
	if($pusher->trigger('test_channel', 'my_event', $data)) {			
		//MySqli Insert Query
		$insert_row = $mysqli->query("INSERT INTO chats_users (id, conversations, id_user, id_user_conversation) VALUES('', '$Menssage', '$id_user', '$id_userConversation')");
		mysqli_close($mysqli);
	
		echo 'success';			
	} else {		
		echo 'error';	
	}
}