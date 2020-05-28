// Global variables.
var urlBase = 'http://coronacontacts.club/APICode';
var extension = 'php';

var userId = 0;
var firstName = "";
var lastName = "";
var email = "";
var password ="";

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
		window.location.href = "index.html";
	}
	else
	{
		document.getElementById("userName").innerHTML = "Logged in as " + firstName + " " + lastName;
	}
}

function searchContact()
{
	alert("Search Utilitzed");
	var srch = document.getElementById("searchText").value;
	document.getElementById("searchResults").innerHTML = "";

	var colorList = "testing";
	var jsonPayload = '{"search" : "' + srch + '","userId" : ' + userId + '}';
	var url = urlBase + '/SearchContact.' + extension;
	
	var xhr = new XMLHttpRequest();
	xhr.open("POST", url, true);
	xhr.setRequestHeader("Content-type", "application/json; charset=UTF-8");
	try
	{
		xhr.onreadystatechange = function() 
		{
			if (this.readyState == 4 && this.status == 200) 
			{
				document.getElementById("searchResults").innerHTML = "Resulting Search Displayed";
				var jsonObject = JSON.parse( xhr.responseText );
				
				for( var i=0; i<jsonObject.results.length; i++ )
				{
					colorList += jsonObject.results[i];
					if( i < jsonObject.results.length - 1 )
					{	
						
						colorList += "<br />\r\n";
					}
				}
				
				document.getElementsByTagName("p")[0].innerHTML = colorList;
			}
		};
		xhr.send(jsonPayload);

	}
	catch(err)
	{
		document.getElementById("searchResults").innerHTML = err.message;
	}
	
}