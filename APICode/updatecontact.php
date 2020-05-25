<?php
	$inData = getRequestInfo();
	
	$name = $inData["name"];
	$email = $inData["email"];
	$city = $inData["city"];
	$state = $inData["state"];
	$zip = $inData["zip"];
	$phone = $inData["phone"];
	$infected = $inData["infected"];
	$ID = $inData["ID"];
	$userId = $inData["userId"];

	$conn = new mysqli("localhost", "faizar", "", "coronacontacts");
	
	if ($conn->connect_error) 
	{
		returnWithError( $conn->connect_error );
	} 
	
	else 
	{
		// To update info already in a table.: UPDATE [table name] SET Select_priv = 'Y',Insert_priv = 'Y',Update_priv = 'Y' where [field name] = 'user';

		$sql = "UPDATE Contacts SET Name = '$name', Email = '$email', City = '$city', State = '$state', Zip = '$zip', Phone = '$phone', Infected = '$infected' WHERE ID = '$ID'";

		// $sql = "insert into Contacts (Name, Email, City, State, Zip, Phone, Infected, UserId) VALUES ('$name','$email','$city','$state','$zip','$phone', '$infected', '$userId')";
		
		if( $result = $conn->query($sql) != TRUE )
		{
			returnWithError( $conn->error );
		}
		
		$conn->close();
	}
	
	returnWithError("CONTACT CREATED!");
	
	function getRequestInfo()
	{
		return json_decode(file_get_contents('php://input'), true);
	}

	function sendResultInfoAsJson( $obj )
	{
		header('Content-type: application/json');
		echo $obj;
	}
	
	function returnWithError( $err )
	{
		$retValue = '{"error":"' . $err . '"}';
		sendResultInfoAsJson( $retValue );
	}
	
?>