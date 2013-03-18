var MetadataModel = function() {
    var self = this;
    self.titles = ko.observableArray([{ title: "Jamie Hall", type: ['AlternativeTitle', 'Subtitle', 'Other']}]);

    self.addTitle = function() {
        self.titles.push({
            title: "",
            type: ['AlternativeTitle', 'Subtitle', 'Other']
        });
    };
 
    self.removeTitle = function(title) {
        self.titles.remove(title);
    };
 
    self.save = function(form) {
        //ko.utils.postJson($("form")[0], self.gifts);
        alert("Could now transmit to server: " + ko.utils.stringifyJson(self.gifts));
        // To actually transmit to server as a regular form post, write this: ko.utils.postJson($("form")[0], self.gifts);
    };
};

ko.applyBindings(new MetadataModel());




// Activate jQuery Validation
//$("form").validate({ submitHandler: viewModel.save });