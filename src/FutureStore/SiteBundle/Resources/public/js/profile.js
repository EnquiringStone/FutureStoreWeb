$().ready(function() {
	$('#add-products .add-product-to-list').on('click', function(e) {
		e.preventDefault();

		var tr = $(e.target).closest('tr');
		var quantity = $('.product-quantity', tr).val();
		var list_id = $('#add-products .list-id').val();
		var product_id = tr.data('product-id');
		$.ajax({
			url: '/profile/index',
			type: 'POST',
			beforeSend: function(xhrObj) {
				xhrObj.setRequestHeader('X-Request', 'Profile');
				xhrObj.setRequestHeader('X-Request-Method', 'addProductToList');
			},
			data: {
				arguments: {
					quantity: quantity,
					listId: list_id,
					productId: product_id
				}
			}, success: function() {
				$('.product-quantity', tr).val('');
				tr.add('<td>Product is toegevoegt</td>');
			}
		});
	});

	$('#list-products .remove-product').on('click', function(e) {
		e.preventDefault();
		var list_id = $('#list-products .list-id').val();
		var tr = $(e.target).closest('tr');
		var product_id = tr.data('product-id');
		$.ajax({
			url: '/profile/index',
			type: 'POST',
			beforeSend: function(xhrObj) {
				xhrObj.setRequestHeader('X-Request', 'Profile');
				xhrObj.setRequestHeader('X-Request-Method', 'removeProductFromList');
			},
			data: {
				arguments: {
					productId: product_id,
					listId: list_id
				}
			}, success: function() {
				$(tr).remove();
			}
		});
	});

	$('#list-products .product-quantity').on('change', function(e) {
		if(isNumber($(e.target).val())) {
			var list_id = $('#list-products .list-id').val();
			var tr = $(e.target).closest('tr');
			var product_id = tr.data('product-id');
			$.ajax({
				url: '/profile/index',
				type: 'POST',
				beforeSend: function(xhrObj) {
					xhrObj.setRequestHeader('X-Request', 'Profile');
					xhrObj.setRequestHeader('X-Request-Method', 'changeQuantityInList');
				},
				data: {
					arguments: {
						productId: product_id,
						listId: list_id,
						quantity: $(e.target).val()
					}
				}
			});
		}
	});
});

function sendAjax(url, sendMethod, functionMethod, service, arguments, success) {
	//TODO
}

function isNumber(n) {
	return !isNaN(parseFloat(n)) && isFinite(n);
}

