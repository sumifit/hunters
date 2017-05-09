/**
 * 
 */

$(document).ready(function() {
	
	
	
	
	changepage = function changePage(page){
		
		 $.ajax({
		        url: "/hunters/dist/php/pageControl.php",
		        type: "post",
		        data: {pagina:page} ,
		        dataType : 'json',
		        success: function (response) {
		        	if(response == 1){
		        		$('#cont').html("");
		    			$('#cont').load('profileinclude.php');
		        	}else if (response == 0){
		        		$('#cont').html("");
		    			$('#cont').load('homeinclude.php');
		        	}

		        },
		        error: function(response) {
		           console.log(response);
		        }


		    });
	}
	
	
});