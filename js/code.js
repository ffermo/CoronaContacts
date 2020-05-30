// Global variables.
var urlBase = 'http://coronacontacts.club/APICode';
var extension = 'php';

var userId = 0;
var firstName = "";
var lastName = "";
var email = "";
var password ="";

function displayName()                                                              
{                                                                                   
	    document.getElementById("userFirstName").innerHTML = "Hello " + firstName + "!";
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
		document.getElementById("regResult").innerHTML = err.message;
	}
}

function addContact()
{
	userId = 0;


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
	var jsonPayload = '{"name" : "' + name + '", "email" : "' + email + '", "city" : "'+ city + '", "state" : "' + state + '", "zip" : "' + zip + '", "phoneNumber" : "' + phoneNumber + '", "infected" : "' + infected + '", "contactId" : "' + userId + '"}';
	var url = urlBase + '/CreateContact.' + extension;

	var xhr = new XMLHttpRequest();
	xhr.open("POST", url, false);
	xhr.setRequestHeader("Content-type", "application/json; charset=UTF-8");

	try
	{
	xhr.send(jsonPayload);
	var jsonObject = JSON.parse( xhr.responseText );
	userId = jsonObject.id;

	// if( userId < 1  )
	// {
	//  	document.getElementById("regResult").innerHTML = "E-mail already exists!";
	//  	return;
	// }

	// document.getElementById("regResult").innerHTML = "In Database";
	// firstName = jsonObject.firstName;
	// lastName = jsonObject.lastName;

	// 	saveCookie();

		alert("New Contact Added");

	// window.location.href = "dashboard.html";
		
	}
	catch(err)
	{	
		alert("Error" + err.message);
	 	// document.getElementById("regResult").innerHTML = err.message;
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

function searchContact()
{
	var srch = document.getElementById("searchText").value;
	//document.getElementById("searchResults").innerHTML = "";

	// Json DB elements
	var table = document.getElementById("contactTable");
	var name = "";
	var email = "";
	var city = "";
	var state = "";
	var zip = "";
	var phoneNumber = "";
	var infected = "";
	var contactId = "";
	// var btn = document.createElement("button");

	// Variables for Table
	

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
					document.getElementById("searchResults").innerHTML = jsonObject.results.length + " contacts found!";


				for( var i=0; i<jsonObject.results.length; i++ )
				{
					// Needs to convert to 
				
					// name += jsonObject.results[i].name;
					// email += jsonObject.results[i].email;
					// city += jsonObject.results[i].city;
					// state += jsonObject.results[i].state;
					// zip += jsonObject.results[i].zip;
					// phoneNumber += jsonObject.results[i].phoneNumber;
					// infected += jsonObject.results[i].infected;
					// btn += btn;
				
					name = jsonObject.results[i].name;
					email = jsonObject.results[i].email;
					city = jsonObject.results[i].city;
					state = jsonObject.results[i].state;
					zip = jsonObject.results[i].zip;
					phoneNumber = jsonObject.results[i].phoneNumber;
					infected = jsonObject.results[i].infected;
					contactId = jsonObject.results[i].contactId;

					var row = table.insertRow(-1);
					
					var cell1 = row.insertCell(0);
					var cell2 = row.insertCell(1);
					var cell3 = row.insertCell(2);
					var cell4 = row.insertCell(3);
					var cell5 = row.insertCell(4);
					var cell6 = row.insertCell(5);
					var cell7 = row.insertCell(6);
					var cell8 = row.insertCell(7);
					
					cell1.innerHTML = name;
					cell2.innerHTML = email;
					cell3.innerHTML = city;
					cell4.innerHTML = state;
					cell5.innerHTML = zip;
					cell6.innerHTML = phoneNumber;
					cell7.innerHTML = infected;
					cell8.innerHTML = '<button type="button" class="btn btn-primary">Edit</button><button type="button" class="btn btn-dark">Delete</button>';
					// cell8.innerHTML = contactId;
					
					
					if( i < jsonObject.results.length - 1 )
					{	
						// name += "<br />\r\n";
						// email += "<br />\r\n";
						// city += "<br />\r\n";
						// state += "<br />\r\n";
						// zip += "<br />\r\n";
						// phoneNumber += "<br />\r\n";
						// infected += "<br />\r\n";
						// btn += "<br />\r\n";
					
						
						// do the same thing with all the field
					}
				}
				// document.getElementById("print_sector").innerHTML = name;
				// document.getElementById("nameField").innerHTML = name;
				// document.getElementById("emailField").innerHTML = email;
				// document.getElementById("cityField").innerHTML = city;
				// document.getElementById("stateField").innerHTML = state;
				// document.getElementById("zipField").innerHTML = zip;
				// document.getElementById("phoneNumberField").innerHTML = phoneNumber;
				// document.getElementById("infectedField").innerHTML = infected;
				// document.getElementById("btnId").innerHTML = btn.type;
				// document.getElementsByTagName("p")[i].innerHTML = test_name;

			}
		};
		xhr.send(jsonPayload);

	}
	catch(err)
	{
		document.getElementById("searchResults").innerHTML = err.message;
	}
	
}


