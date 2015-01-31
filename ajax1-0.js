var xmlHttp = createXmlHttpRequestObject();
var xmlHttpRepeat = 0;
var xmlHttpTo="worker.php"

function createXmlHttpRequestObject() {
	// stores the reference to the XMLHttpRequest object
	var xmlHttp;
	// if running Internet Explorer 6 or older
	if (window.ActiveXObject) {
		try {
			xmlHttp = new ActiveXObject("Microsoft.XMLHTTP");
		} catch (e) {
			xmlHttp = false;
		}
	}
	// if running Mozilla or other browsers
	else {
		try {
			xmlHttp = new XMLHttpRequest();
		} catch (e) {
			xmlHttp = false;
		}
	}
	// return the created object or display an error message
	if (!xmlHttp) alert("Error creating the XMLHttpRequest object.");
	else
	return xmlHttp;
}
// make asynchronous HTTP request using the XMLHttpRequest object
//repeat each xxs second if >0

function process() {
	
	// proceed only if the xmlHttp object isn't busy
	if (xmlHttp.readyState == 4 || xmlHttp.readyState == 0) {
		// retrieve the name typed by the user on the form
		data = encodeURIComponent(myData);
		
		// execute page from the server
		xmlHttp.open("POST", xmlHttpTo, true);
		// define the method to handle server responses		
		xmlHttp.onreadystatechange = handleServerResponse();
		// make the server request
		xmlHttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded"); //solo POST
		xmlHttp.send("name=" + data);
		//xmlHttp.send(null); para GET
	} else
	// if the connection is busy, try again after one second
	
	setTimeout('process()', 1000);
}
// callback function executed when a message is received from the
//server

function handleServerResponse() {

	// move forward only if the transaction has completed
	if (xmlHttp.readyState == 4) {
		// status of 200 indicates the transaction completed
		//successfully
		if (xmlHttp.status == 200) {
			// extract the XML retrieved from the server
			xmlResponse = xmlHttp.responseXML;
			// obtain the document element (the root element) of the XML
			//structure
			xmlDocumentElement = xmlResponse.documentElement;
			// get the text message, which is in the first child of
			// the the document element
			helloMessage = xmlDocumentElement.firstChild.data;
			// display the data received from the server
			//var xxObj=document.getElementById("divMessage")||parent.document.getElementById("divMessage");
			//xxObj.innerHTML =  "Guardado con exito!" ;
			//execute function after process
			afterprocess(helloMessage); 
			// restart sequence
			if (xmlHttpRepeat > 0) setTimeout('process(xmlHttpRepeat)', 1000 * xmlHttpRepeat);
		}
		// a HTTP status different than 200 signals an error
		else {
			document.getElementById("divMessage").innerHTML ="There was a problem accessing the server: " + xmlHttp.statusText;
		}
	}
	else{
			setTimeout('handleServerResponse()', 500);
		}
	
}