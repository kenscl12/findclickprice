// Here's my data model
var ViewModel = function(data, status) {
	model = this;
    model.result = ko.observableArray();
	model.Loading = ko.observable(false);
	model.isError = ko.observable(false);
	model.noResults = ko.observable(false);
	
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
	
	
	model.isValidUrl = ko.observable(true);
	
	model.urlSearchValid = function(){
		var re = /^https?:\/\/(?:[a-z\-]+\.)+[a-z]{2,6}(?:\/[^\/#?]+)+\.(?:jpe?g|gif|png)$/;
		if(re.test(model.url()) || model.url().length < 1){
			model.isValidUrl(true);
		} else {
			model.isValidUrl(false);
		}
	}
	
	model.url = ko.observable('');
	
	model.send = function() {
		model.urlSearchValid();
		if($('input[name=searchimg]').val() != '' || (model.isValidUrl() == true && model.url() != '') ){
			model.isError(false);
			model.noResults(false);
			
			$('.loading-container').fadeIn(1000);
			
			$('form[name=search]').submit();
		}
	};
    
};

