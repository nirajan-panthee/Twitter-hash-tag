
	$(document).ready(function() { 
        $("#tblS").tablesorter(); 
		$('#hover').mouseover(function(){
			if($('#embed').css('display')=='none')
			{
				$('#embed').slideDown().show();
			}
				 
		});
		$('#embed').mouseenter(function(){
			$('#embed').show();
		
		}).mouseleave(function(){
			$('#embed').slideUp().hide();
		
		});
		
		
	});	

	
	
	setTimeout(function(){
		document.getElementById('message').style.display = 'none';
    }, 3000);

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
	
	 
	 
	
	function notweet(){
	
		alert("NO TWEET AVAILABLE");
		return false;
	
	}
	
	
	function deleteHash(){
	
		r=confirm("Are you sure to Delete");
		return r;
	}
	
	//search
		$(function(){
		$('#search').keyup(function(){
				var newentry = $('#search').val();
	
			$.ajax({
					url: "search_hash.php?search="+newentry ,
				success: function(value) {
					if(value){
						
						$(".table-striped #data").html(value);
					}
				}
			});
	
		});
	});

	function sort(i){
	
	
		$(".table-striped #data .q").hide();
		
		
		if(document.getElementsByClassName('header')[i]){
			document.getElementsByClassName('header')[i].style.backgroundImage = 'url(img/asc.gif)';
		} 
		
		if(document.getElementsByClassName('header headerSortDown')[0]){
			document.getElementsByClassName('header headerSortDown')[0].style.backgroundImage = 'url(img/desc.gif)';
		}
		
		if(document.getElementsByClassName('header headerSortUp')[0]){
			document.getElementsByClassName('header headerSortUp')[0].style.backgroundImage = 'url(img/asc.gif)';
		} 
	
	}
	
//infinite scroll
	$(document).ready(function() {
		
		$(window).scroll(function() {
			
			if($(window).scrollTop() == $(document).height() - $(window).height()) {   
				
					$('div#loadMoreComments').show();
			
				$.ajax({
	
						url: "scroll.php?lastComment="+ $(".postedComment:last").attr('id')+"&hash="+hashtag ,
						success: function(html) {
							if(html){      
								$("#postedComments").append(html);
								$('div#loadMoreComments').hide();
							}
						}
				});
			}
		});
	});
	
	
	