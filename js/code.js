// Global variables.
var urlBase = 'http://coronacontacts.club/APICode';
var extension = 'php';

var userId = 0;
var firstName = "";
var lastName = "";
var email = "";
var password ="";

// var name ='';
// var city = '';
// var state = ''; 
// var zip = '';
// var phoneNumber ='';
// var infected =''; 
// var contactId ='';

function displayName()                                                              
{                                                                                   
	    document.getElementById("userFirstName").innerHTML = ("Hello " + firstName + "!");
}                                                                                   

function refreshList()
{
	document.getElementById("contactTable").innerHTML = "";
}

function doLogin()
{
	userId = 0;
	firstName = "";
	lastName = "";

    var email = document.getElementById("email").value;
    var password = document.getElementById("password").value;
	//var hash = md5(password);

	document.getElementById("loginResult").innerHTML = "";

	//var jsonPayload = '{"login" : "' + login + '", "password" : "' + hash + '"}';
	var jsonPayload = '{"email" : "' + email + '", "password" : "' + password + '"}';
	var url = urlBase + '/Login.' + extension;

	var xhr = new XMLHttpRequest();
	xhr.open("POST", url, false);
	xhr.setRequestHeader("Content-type", "application/json; charset=UTF-8");

	try
	{
		xhr.send(jsonPayload);
		var jsonObject = JSON.parse( xhr.responseText  );
		userId = jsonObject.id;

		if( userId < 1  )
		{
			document.getElementById("loginResult").innerHTML = "User/Password combination incorrect";
			return;
		}

		firstName = jsonObject.firstName;
		lastName = jsonObject.lastName;

		saveCookie();

		window.location.href = "dashboard.html";
		
	}
	catch(err)
	{
		document.getElementById("loginResult").innerHTML = err.message;
	}
}

function doRegister()
{
	userId = 0;
    firstName = "";
	lastName = "";
	email = "";
	password = "";

	var firstName = document.getElementById("firstName").value;
    var lastName = document.getElementById("lastName").value;
    var email = document.getElementById("email").value;
    var password = document.getElementById("password").value;
	//var hash = md5(password);

	document.getElementById("regResult").innerHTML = "";

	//var jsonPayload = '{"login" : "' + login + '", "password" : "' + hash + '"}';
	var jsonPayload = '{"first" : "' + firstName + '", "last" : "' + lastName + '", "email" : "'+ email + '", "password" : "' + password + '"}';
	var url = urlBase + '/Register.' + extension;

	var xhr = new XMLHttpRequest();
	xhr.open("POST", url, false);
	xhr.setRequestHeader("Content-type", "application/json; charset=UTF-8");

	try
	{
		xhr.send(jsonPayload);
		var jsonObject = JSON.parse( xhr.responseText );
		userId = jsonObject.id;

		if( userId < 1  )
		{
			        document.getElementById("regResult").innerHTML = "E-mail already exists!";
			        return;
		}

		document.getElementById("regResult").innerHTML = "In Database";
		firstName = jsonObject.firstName;
		lastName = jsonObject.lastName;

		saveCookie();

		alert("Successfully Registered");

		window.location.href = "dashboard.html";
		
	}
	catch(err)
	{
	}
}

function addContact()
{

	var name = document.getElementById("name").value;
    var email = document.getElementById("email").value;
    var city = document.getElementById("city").value;
	var state = document.getElementById("state").value;
	var zip = document.getElementById("zip").value;
    var phoneNumber = document.getElementById("phoneNumber").value;
    var infected = document.getElementById("infected").value;
    // var contactId = userId;
	//var hash = md5(password);

	// document.getElementById("regResult").innerHTML = "";

	//var jsonPayload = '{"login" : "' + login + '", "password" : "' + hash + '"}';
	var jsonPayload = '{"name" : "' + name + '", "email" : "' + email + '", "city" : "' + city + '", "state" : "' + state + '", "zip" : "' + zip + '", "phoneNumber" : "' + phoneNumber + '", "infected" : "' + infected + '", "userId" : "' + userId + '"}';

	var url = urlBase + '/CreateContact.' + extension;
	

	var xhr = new XMLHttpRequest();
	xhr.open("POST", url, false);
	xhr.setRequestHeader("Content-type", "application/json; charset=UTF-8");

	try
	{
	xhr.send(jsonPayload);
	var jsonObject = JSON.parse( xhr.responseText );
	// userId = jsonObject.id;

	// if( userId < 1  )
	// {
	//  	document.getElementById("regResult").innerHTML = "E-mail already exists!";
	//  	return;
	// }

	// document.getElementById("printHere") = jsonPayload;
	// firstName = jsonObject.firstName;
	// lastName = jsonObject.lastName;

	// 	saveCookie();


	document.getElementById("printHere").innerHTML = "Added!";
	alert("Contact Added!");
	window.location.href = "dashboard.html";

		
	}
	catch(err)
	{	
		alert("Error" + err.message);
	 	// document.getElementById("regResult").innerHTML = err.message;
	}
}


function searchContact()
{
	var srch = document.getElementById("searchText").value;

	// Json DB elements
	var table = document.getElementById("contactTable");
	var name = "";
	var ContactEmail = "";
	var city = "";
	var state = "";
	var zip = "";
	var phoneNumber = "";
	var infected = "";
	var datecontactcreated = "";
	var contactId = "";
	
	// Converts to JSON package + sends to the API
	var jsonPayload = '{"search" : "' + srch + '","userId" : ' + userId + '}';
	var url = urlBase + '/SearchContact.' + extension;
	
	// API Call
	var xhr = new XMLHttpRequest();
	xhr.open("POST", url, true);
	xhr.setRequestHeader("Content-type", "application/json; charset=UTF-8");
	try
	{
		xhr.onreadystatechange = function() 
		{
			if (this.readyState == 4 && this.status == 200) 
			{	
				var jsonObject = JSON.parse( xhr.responseText );

				// Text displays to inform client the search results are displayed. 
				if (jsonObject.results.length == 0)
					document.getElementById("searchResults").innerHTML = "No contacts found!";
				else if (jsonObject.results.length == 1)
					document.getElementById("searchResults").innerHTML = "1 contact found!";
				else if (jsonObject.results.length > 1)
					document.getElementById("searchResults").innerHTML = jsonObject.results.length + " Contacts found!";


				for( var i=0; i<jsonObject.results.length; i++ )
				{				
					// Parsing JSON objects
					name = jsonObject.results[i].name.toString();
					email = jsonObject.results[i].email.toString();
					city = jsonObject.results[i].city.toString();
					state = jsonObject.results[i].state.toString();
					zip = jsonObject.results[i].zip.toString();
					phoneNumber = jsonObject.results[i].phoneNumber.toString();
					datecontactcreated = jsonObject.results[i].datecontactcreated.toString();
					infected = jsonObject.results[i].infected.toString();
					contactId = jsonObject.results[i].id.toString();

					
					// var obj = 
					// {
					// 	name: name,
					// 	email: email,
					// 	city: city,
					// 	state: state,
					// 	zip: zip,
					// 	phoneNumber: phoneNumber,
					// 	date: datecontactcreated,
					// 	infect: infected,
					// 	id: contactId

					// }
					// var parseObj = JSON.parse(obj);
					//  console.log(obj);
					// console.log(`Parsed ${parseObj}`);

					// Inserting from the bottom
					var row = table.insertRow(-1);
					
					// Creating a Cell into Position
					var cell0 = row.insertCell(0);
					var cell1 = row.insertCell(1);
					var cell2 = row.insertCell(2);
					var cell3 = row.insertCell(3);
					var cell4 = row.insertCell(4);
					var cell5 = row.insertCell(5);
					var cell6 = row.insertCell(6);
					var cell7 = row.insertCell(7);
					var cell8 = row.insertCell(8);
					var cell9 = row.insertCell(9);
					
					// Data Renders variables on HTML
					cell0.innerHTML = name;
					cell1.innerHTML = email;
					cell2.innerHTML = city;
					cell3.innerHTML = state;
					cell4.innerHTML = zip;
					cell5.innerHTML = phoneNumber;
					cell6.innerHTML = infected;
					cell7.innerHTML = datecontactcreated; 
					cell8.innerHTML = '<button type="button" class="btn btn-primary" onclick="editContact(\''+ name + '\', \''  + email + '\', \'' + city + '\',\'' + state + '\',\'' + zip + '\',\'' + phoneNumber + '\',\'' + infected + '\',\'' + contactId + '\')">Edit</button>';
					console.log("Line 265 " + cell8.innerHTML.toString());

					// cell8.innerHTML = '<button type="button" class="btn btn-primary" onClick="editContact(\''+ name + '\')">Edit</button>';
					cell9.innerHTML = '<button type="button" class="btn btn-dark" onClick="deleteContact(' + contactId + ')">Delete</button>';
					// cell8.innerHTML = '<button type="button" class="btn btn-primary" onclick="editContact( name )">Edit</button><button type="button" class="btn btn-dark" onclick="deleteContact(' + contactId + ')">Delete</button>';
					// cell8.innerHTML = '<button type="button" class="btn btn-primary" onclick="editContact( name , email , city , state, zip , phoneNumber , infected , contactId )">Edit</button> <button type="button" class="btn btn-dark" onclick="deleteContact(' + contactId + ')">Delete</button>';

					if( i < jsonObject.results.length - 1 )
					{	
						
					}
				}
			}
			};

		xhr.send(jsonPayload);

	}
	catch(err)
	{
		document.getElementById("searchResults").innerHTML = err.message;
	}
	
}

function deleteContact( contactId )
{
	var jsonPayload = '{"ID" : "' + contactId + '", "userId" : "' + userId + '"}';
	var url = urlBase + '/DeleteContact.' + extension;
	
	var xhr = new XMLHttpRequest();
	xhr.open("POST", url, false);
	xhr.setRequestHeader("Content-type", "application/json; charset=UTF-8");

	try
	{
		xhr.send(jsonPayload);
		alert("Contact Deleted!");
		window.location.href = "dashboard.html";
	}
	catch(err)
	{	
		alert("Error: " + err.message);
	}
}

function editContact( name, email,city,state,zip,phoneNumber,infected,contactId )
{
	alert("Change contact information for " + name + "on lower left hand box.");

	// Change the text on the Add Contacts to that of Edit Contact
	document.getElementById("update_contact").innerHTML = "Edit Contact " + name;

	
	// console.log(name) ;
    // console.log(email) ;
	// console.log(city);
	// console.log(state);
	// console.log(zip);
	// console.log(phoneNumber);
	// console.log(infected);
	// Button Text Changes
	document.getElementById("addUpdateButton").innerHTML = '<button type="button" class="btn btn-dark" onClick="enterContact()">Update Contact</button>';
}

function enterContact()
{
	// Get ElementbyId on the forms from HTML after you send it in
	name = document.getElementById("name").value;
    email = document.getElementById("email").value;
    city = document.getElementById("city").value;
	state = document.getElementById("state").value;
	zip = document.getElementById("zip").value;
    phoneNumber = document.getElementById("phoneNumber").value;
    infected = document.getElementById("infected").value;

	// Creates the JSON token
	var jsonPayload = '{"name" : "' + name + '", "email" : "' + email + '", "city" : "' + city + '", "state" : "' + state + '", "zip" : "' + zip + '", "phoneNumber" : "' + phoneNumber + '", "infected" : "' + infected + '", "id" : "' + contactId + '","userId" : "' + userId + '"}';
	
	console.log(jsonPayload);
	// Configures to Update Contact API
	var url = urlBase + '/UpdateContact.' + extension;

	// API functions get called
	var xhr = new XMLHttpRequest();
	xhr.open("POST", url, false);
	xhr.setRequestHeader("Content-type", "application/json; charset=UTF-8");

	try
	{

		xhr.send(jsonPayload);
		alert("Contact Updated!");
		 
	 	window.location.href = "dashboard.html";

		
	}
	catch(err)
	{	
	 	alert("Error: " + err.message);
	}
}



function saveCookie()
{
	    var minutes = 20;
	    var date = new Date();
	    date.setTime(date.getTime()+(minutes*60*1000));
	    document.cookie = "firstName=" + firstName + ",lastName=" + lastName + ",userId=" + userId + ";expires=" + date.toGMTString();
}

function readCookie()
{
	userId = -1;
	var data = document.cookie;
	var splits = data.split(",");
	for(var i = 0; i < splits.length; i++) 
	{
		var thisOne = splits[i].trim();
		var tokens = thisOne.split("=");
		if( tokens[0] == "firstName" )
		{
			firstName = tokens[1];
		}
		else if( tokens[0] == "lastName" )
		{
			lastName = tokens[1];
		}
		else if( tokens[0] == "userId" )
		{
			userId = parseInt( tokens[1].trim() );
		}
	}
	
	if( userId < 0 )
	{
		window.location.href = "dashboard.html";
	}
	else
	{
	}
}
