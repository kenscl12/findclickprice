// Here's my data model
var ViewModel = function(data, status) {
	model = this;
	
    model.result = ko.observableArray();
	model.Loading = ko.observable(false);
	model.isError = ko.observable(false);
	model.noResults = ko.observable(false);
	
	model.fileUploadHandler = function(file){
		console.log(file);
	}
	
	if(status == 'success'){
		if(!jQuery.isEmptyObject(data)){
			$.each( data, function( key, value ) {
			  model.result.push(value);
			});
		}
	} else if(status == 'extension error') {
		model.isError(true);
	} else if(status == 'no results'){
		model.noResults(true);
	}
	
	
	//model.url = ko.observable('https://pp.vk.me/c837332/v837332425/266b/CqpbSYaeNqM.jpg');
	model.url = ko.observable('');
	
	model.send = function() {
		//var $btn = $('#searcn').button('loading')
		// business logic...
		
		// if($('input[name=searchimg]').val() == ''){
			// $('#search').button('loading');
			// model.Loading(true);
			// model.isError(false);
			// model.noResults(false);
			// $.get("https://bibinbot.herokuapp.com/ali/index.html", {
				// url:  model.url()
			// }, function(data) {
				
				// var parsed = data;
				// console.log(parsed);
				// model.result(parsed);
				// $('#search').button('reset');
				// model.Loading(false);
			// });
		// } else {
			$('form[name=search]').submit();
		// }
	};
    
};

