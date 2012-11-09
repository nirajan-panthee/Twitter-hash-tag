	
			
	function notweet(){
	
		alert("NO TWEET AVAILABLE");
		return false;
	
	}
	

			
	function addHash(name){
			var hash=document.forms[name]['hashtag'].value;
		if(hash==null || hash== ""){
			alert("No # tag given");
			return false;
		}
		else if (hash.charAt(0)!='#'){
			alert("invalid # Tag!!!");
			return false;
		}
	
		r=confirm("Are you sure to Add New # Tag!!!");
		return r;
	}
	
	function deleteHash(){
	
		r=confirm("Are you sure to Delete");
		return r;
	}
	
	setTimeout(function(){
		document.getElementById('message').style.display = 'none';
    
	}, 3000);
  
  
  //for slider
  
  
	
	function searchbyhash(){
			var hash=document.forms['search']['query'].value;
			var id='#'+ hash;
			var div = document.getElementById(id);
			title = div.parentNode.firstChild.innerHTML;
			//document.getElementById('tw-form').innerHTML=title;
		if(check=='active'){
			location.href="index.php?panel="+title+"&query="+encodeURIComponent(hash);
			return false;
		}
		else {
			location.href="deactivated.php?panel="+title+"&query="+encodeURIComponent(hash);
			return false;
		}
	}
	
	$(function() {
		
			
		$.ajax({
					url: "auto.php" ,
			success: function(value) {
				if(value){
						var tags=$.parseJSON(value);
					$( "#tw-input-text" ).autocomplete({
						source: tags
					});
				}
			}
		});
	
		
	});
	
	$().ready(function(){

      /* Here is the slider using default settings */
      $('#slider-id').codaSlider({
			firstPanelToLoad:title
	  });
 
    });