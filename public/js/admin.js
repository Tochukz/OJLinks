 var catArray, categories;
$(document).ready(function(){	
	var url = window.location.href;
	$('#category, #managebook, #storekeeper, #order, #transact, #overview').removeClass('active');
	if(url.match(/category/i)){
		$('#category').addClass('active');
	}else if(url.match(/managebook/i)){
		$('#managebook').addClass('active');
	}else if(url.match(/storekeeper/i)){
		$('#storekeeper').addClass('active');
	}else if(url.match(/order/i)){
		$('#order').addClass('active');
	}else if(url.match(/transaction/i)){
		$('#transact').addClass('active');
	}else{
		$('#overview').addClass('active');
	}

	/**
	 * An AJAX call to get JSONfile which holds the categories and subcategory of the books stored in the database.
	 * The object retrieved is used in building the rows of book catrgories using build() and to display them on the page. 
	 */ 
	$.getJSON('/getJSONfile', function(data, status){
        catArray = data['catArray'];
        categories = data['categories'];
        var option;
        $('#cat_field').append('<option value="all">All</option>');        
       for(var cat in catArray){
       		option = '<option value="'+catArray[cat]+'" id="'+catArray[cat]+'">'+catArray[cat]+'</option>';
       		$('#cat_field').append(option);
       		$('[name="category"]').append(option);
       }

       if(url.match(/medicine/i)){
	   		$('#medicine').attr('selected','selected');
	    }else if(url.match(/pharmacy/i)){
	    	$('#pharmacy').attr('selected','selected');
	    }else if(url.match(/engineering/i)){
	    	$('#engineering').attr('selected','selected');
	    }else if(url.match(/physical-science/i)){
	    	$('#physical-science').attr('selected','selected');
	    }else if(url.match(/life-science/i)){
	    	$('#life-science').attr('selected','selected');
	    }else if(url.match(/agric-science/i)){
	    	$('#agric-science').attr('selected','selected');
	    }else if(url.match(/law/i)){
	    	$('#law').attr('selected','selected');
	    }else if(url.match(/art/i)){
	    	$('#art').attr('selected','selected');
	    }

	    loadSubcat(null, null);      
    });

    $('#cat_field, [name="category"]').on('change', function(e){
    	var field = $(e.currentTarget);  
    	var fieldVal = field.val();  		
    	if(field.attr('id')=='cat_field'){ //This will take careof the category/{category} page
    		$('#subcat_field').empty();
    		$('#subcat_field').append('<option value="all" >All</option>');
    		var subcatElem  = '#subcat_field';
    		loadSubcat(fieldVal, subcatElem);  
    	}else{ //This will take care of the managebook/add page
    		$('[name="subcategory"]').empty();
    		$('[name="subcategory"]').append('<option value="" >Subcategory</option>');
    		var subcatElem  = '[name="subcategory"]';
    		loadSubcat(fieldVal, subcatElem);  
    	}
    	  	
    });	
});

  
function loadSubcat(field, subElem){
	fieldVal  = (field==null)? $('#cat_field').val(): field;
	subcatElem =  (subElem==null)? '#subcat_field' : subElem
	var subjects = categories[fieldVal];
	var option;
	for(var sub in subjects){
		option = '<option value="'+subjects[sub]+'">'+subjects[sub]+'</option>';
		$(subcatElem).append(option);
	}
}