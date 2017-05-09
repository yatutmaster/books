
var csrfParam = $('meta[name="csrf-param"]').attr("content"),
      csrfToken = $('meta[name="csrf-token"]').attr("content"),
	  is_busy = false;
	  
$(".btn-hist").click(function(){
	
	var params = {},
	      obj = $(this);
	
	params[csrfParam] = csrfToken;
	params.id_hist = obj.data('id_hist');
	params.id_book = obj.data('id_book');
	 
	if(!is_busy) 
	{
		is_busy = true;
		$.post(Url_to, params,function( data ) {
					   
					  for (var item in data) {
						  
						  if(item == 'image')
							 document
								  .getElementById("dv_img")
									  .src = 'uploads/prev/'+data[item];
						 
						  var myElem = document.getElementById("dv_"+item);
						
						  if (myElem !== null) 
								 myElem.innerHTML= data[item];
						  
					 }
					
					 $(".btn-hist:disabled").removeAttr('disabled').removeClass('btn-success').addClass('btn-default');
					 obj.attr('disabled','disabled').removeClass('btn-default').addClass('btn-success');
					 $("#update_link").attr('href',data.update_link);
					
					 is_busy = false;
		 });
		
		
	}	
	
});

$(".btn-access").click(function(e){
	
	e.preventDefault();
	
	var flag = $(this).hasClass('btn-success')?1:0,
		  params = {},
		  obj = $(this);
	
	params[csrfParam] = csrfToken;
	params.id_access = flag;
	params.id_book = obj.data('id_book');

	if(!is_busy)
	{
		 is_busy = true;
		 $.post(Url_to,params,function(){
		     
			if(flag)
			{
				obj.text('Изменение разрешено')
					.removeClass('btn-success').addClass('btn-danger');
			}	
			else
			{
				obj.text('Изменение запрещено')
					.removeClass('btn-danger').addClass('btn-success');
			}	
			 
			 is_busy = false;

	     });
	}	
	  
	
	
	
	
	
	
});











// 
