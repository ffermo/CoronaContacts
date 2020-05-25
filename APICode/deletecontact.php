<?php
	$inData = getRequestInfo();
	$ID = getID();

	$searchResults = "";
	
	$name = $inData["name"];
	$email = $inData["email"];
	$city = $inData["city"];
	$state = $inData["state"];
	$zip = $inData["zip"];
	$phone = $inData["phone"];
	$infected = $inData["infected"];
	$userId = $inData["userId"];

	$conn = new mysqli("localhost", "faizar", "", "coronacontacts");

	if ($conn->connect_error) 
	{
		returnWithError( $conn->connect_error );
	} 

	else
	{
		$sql = "delete from Contacts where ID = '" . $row["ID"] . "'";
		
		if( $result = $conn->query($sql) != TRUE )
		{
			returnWithError( $conn->error );
		}
		
		$conn->close();
	}

	returnWithError("CONTACT DELETED!");

	// Figure out person being selected, then get ID from sql, then delete person from sql with sql command. 
	// Maybe return $row["ID"]
	function getID()
	{
		$thing = "select * from Contacts where (Name like '%" . $inData["search"] . "%' or Email like '%" . $inData["search"] . "%' or City like '%" . $inData["search"] . "%' or State like '%" . $inData["search"] . "%' or Zip like '%" . $inData["search"] . "%' or Phone like '%" . $inData["search"] . "%') and UserID =" . $inData["userId"];

		return $row["ID"];
	}
	
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