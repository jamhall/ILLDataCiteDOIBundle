ko.validation.configure({
    insertMessages: false,
    decorateElement: true,
    errorElementClass: 'error'
});

var Title = function (title, type) {
    this.title = title;
    this.type = type;
};

var Metadata = function() {
    var self = this;
    self.availableTitleTypes = ko.observableArray([{ id: "AlternativeTitle", value: "Alternative title"}, { id: "Subtitle", value: "Subtitle"}]);
    self.publicationYear = ko.observable().extend({
        required: { message: "Please specify the publication year." },
        pattern: {
            params: /^\d{4}$/,
            message: "Not a valid year"
        }
    });
    self.identifier = ko.observable().extend({
        required: { message: "Please specify the identifier." },
        pattern: {
            params: /^([A-Za-z0-9\-.\_]+)$/,
            message: "Not a valid identifier (must only contain alphanumeric characters, hyphens or periods.)"
        }
    });
    self.language = ko.observable();
    self.rights = ko.observable();
    self.titles = ko.observableArray();
}

var viewModel = function() {
    self.metadata = new Metadata();
    self.addTitle = function() {
        self.metadata.titles.push(new Title("", "Subtitle"));
    };
    self.removeTitle = function(title) {
       self.metadata.titles.remove(title);
    };

    this.updateFromJSON = function() {
            $.blockUI({
                message: "<span style='font-size:18pt'>Fetching metadata from DataCite...please wait...</span>",
                css: {
                    border: 'none',
                    padding: '15px',
                    backgroundColor: '#000',
                    '-webkit-border-radius': '10px',
                    '-moz-border-radius': '10px',
                    opacity: ".5",
                    color: '#fff'
                }
            });
        $.ajax({
            url:  $("form[id='metadataForm']").data("url"),
            contentType: 'application/json',
            type: "POST",
            dataType: 'json',
            success: function (result) {
                // populate model
                if(result == null) {
                    alert('error');
                } else {
                    self.metadata.publicationYear(result.publicationYear);
                    self.metadata.identifier(result.identifier);
                    self.metadata.language(result.language);
                    self.metadata.rights(result.rights);
                    ko.utils.arrayPushAll(self.metadata.titles, result.titles);
                }
            },
            error: function (result) {
                alert('Sorry, there was an error');
            }
        });
    };
    self.save = function(form) {
        $.blockUI({
            timeout: 3000,
            message: "<span style='font-size:18pt'>You must have at least one title</span>",
            css: {
                border: 'none',
                padding: '15px',
                backgroundColor: '#000',
                '-webkit-border-radius': '10px',
                '-moz-border-radius': '10px',
                opacity: .5,
                color: '#fff'
            }
        });

        //ko.utils.postJson($("form")[0], self.titles);
       console.log("Could now transmit to server: " + ko.toJSON(self.metadata));
        // To actually transmit to server as a regular form post, write this: ko.utils.postJson($("form")[0], self.gifts);
    };

};

$(document).ajaxStop($.unblockUI);
$(function () {
    $("input[data-toggle=popover]").popover({ trigger: "focus" });
    var vm = new viewModel();
    vm.updateFromJSON();
    ko.applyBindings(vm);
});