$(function(){
});

function deleteProductImage(obj, product_id, name_image){
	if(confirm('Удалить?')){
		$.ajax({
			url: '/admin/products/'+product_id+'/'+name_image+'/delete',
			type: 'DELETE',
			success: function(response){
				if(response.result){
					$(obj).parent().fadeOut('fast', function(){
						$(this).remove();
						
						if($('.img-wrapper').length === 0){
							window.location.reload();
						}
					});
					
				} else {
					alert(response.msg);
				}
			},
			error: function(){
				
			}
		});
	}
}
function deleteProduct(product_id){
	if(confirm('Удалить?')){
		$.ajax({
			url: '/admin/products/'+product_id+'/delete',
			type: 'DELETE',
			success: function(response){
				if(response.result){
					window.location.href= '/admin/products';
					
				} else {
					alert(response.msg);
				}
			},
			error: function(){
				
			}
		});
	}
}
function deleteComment(item_id){
	if(confirm('Удалить?')){
		$.ajax({
			url: '/admin/comments/'+item_id+'/delete',
			type: 'DELETE',
			success: function(response){
				if(response.result){
					window.location.href= '/admin/comments';
					
				} else {
					alert(response.msg);
				}
			},
			error: function(){
				
			}
		});
	}
}
function deletePage(item_id){
	if(confirm('Удалить?')){
		$.ajax({
			url: '/admin/pages/'+item_id+'/delete',
			type: 'DELETE',
			success: function(response){
				if(response.result){
					window.location.href= '/admin/pages';
					
				} else {
					alert(response.msg);
				}
			},
			error: function(){
				
			}
		});
	}
}