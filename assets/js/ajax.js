$(function(){
    $(document).on('click', '.genre-link', function(e){
		e.preventDefault();
		var genre = $(this).data('genre');

		$.ajax({
			type: 'POST',
			url: $(this).data('action'),
			async: false,
			data: {
				genre: genre
			},
			success: function(jsonData)
			{
				if (genre == 0) {
					$('#genre-select').html('');
				}
				else {
					$('#genre-select').html('Genre '+genre);
				}
				
				$('#book_list').html(jsonData);
				$('.nav-pills > li.submenu').children('ul').addClass('inactive');
				$('.navbar-toggle').click();
			},
			error: function(XMLHttpRequest, textStatus, errorThrown) {
				alert(errorThrown);
			}
		});
	});

	var options = {
		url: function(inputSearch){
			if (inputSearch != '') {
				return $('#search').data('action')+'?search='+inputSearch;
			}
			else {
				return $('#search').data('action')+'?search=false';
			}
		},
		ajaxSettings: {
			dataType: "json"
		},
		getValue: "name",
		listLocation: "list",
		list: {	
			match: {
			  enabled: true
			},
			maxNumberOfElements: 8
		  },
		  theme: "dark"
		};

	  $("#search").easyAutocomplete(options);
		$("#search-mobile").easyAutocomplete(options);
		
		$(document).on('click', '.jr-glyphicon', function(e){
			var hasEbook   = true;
			var idBook     = $(this).data('book');
			var idCustomer = $(this).data('customer');

			if ($(this).hasClass('glyphicon-ok')){
				hasEbook = false;
			}

			$.ajax({
				type: 'POST',
				url: $(this).data('action'),
				async: false,
				data: {
					hasEbook: hasEbook,
					idBook: idBook,
					idCustomer: idCustomer,
				},
				success: function(jsonData)
				{
					if (hasEbook == false) {
						$('.jr-glyphicon').removeClass('glyphicon-ok');
						$('.jr-glyphicon').addClass('glyphicon-remove');
					}
					else {
						$('.jr-glyphicon').removeClass('glyphicon-remove');
						$('.jr-glyphicon').addClass('glyphicon-ok');
					}
				},
				error: function(XMLHttpRequest, textStatus, errorThrown) {
					alert(errorThrown);
				}
			});
		});
});