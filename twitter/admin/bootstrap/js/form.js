			function showForm(selected){
				var formname="editform"+selected.substring(4);
	
	
	var button = document.getElementById(selected);
	var hashtag="edit"+selected.substring(4);
	var newform = document.getElementById(formname);
	
	button.parentNode.removeChild(button);
	
	var textelement = document.createElement("input");
	textelement.setAttribute("type", "text");
    textelement.setAttribute("placeholder", "Type New # Tag to update");
    textelement.setAttribute("name", "new");
	textelement.setAttribute("style", "vertical-align:top");
	
	
	var submitelement = document.createElement("input");
	submitelement.setAttribute("type", "submit");
    submitelement.setAttribute("class", "btn btn-info");
    submitelement.setAttribute("name", hashtag);
	
	
	newform.appendChild(textelement);
	newform.appendChild(submitelement);
	
						}
						
	function addHash(){
	
r=confirm("Are you sure to Add New # Tag!!!");
return r;
	}
	
		function deleteHash(){
	
r=confirm("Are you sure to Delete");
return r;
	}
	
		function editHash(){
	
r=confirm("Are you sure to Update");
return r;
	}
						