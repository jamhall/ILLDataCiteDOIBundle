$(function () {
	$("a[id='xml']").click(function() {
        $.ajax({
            url: $("a[id='xml']").data("url"),
            type: "GET",
            cache: false,
            dataType: 'text',
            success: function (result) {
				$("div[id='xmlModal']").find(".prettyprint").text(vkbeautify.xml(result));
				prettyPrint();
				$("div[id='xmlModal']").modal({
				        backdrop: true,
				        keyboard: true
				    }).css({
				       'width': function () { 
				           return ($(document).width() * .9) + 'px';  
				       },
				       'margin-left': function () { 
				           return -($(this).width() / 2); 
				       }
				});
            },
            error: function (result) {
                alert('Sorry, there was an error');
            }
        });
	});
});