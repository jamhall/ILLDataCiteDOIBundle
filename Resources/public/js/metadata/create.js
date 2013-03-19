ko.validation.configure({
    insertMessages: false,
    decorateElement: true,
    errorElementClass: 'error'
});

var Title = function (title, type) {
    this.title = title;
    this.type = type;
};

var viewModel = function() {
    var self = this;
    self.availableTitleTypes = ko.observableArray([{ id: "AlternativeTitle", value: "Alternative title"}, { id: "Subtitle", value: "Subtitle"}]);
    self.publicationYear = ko.observable().extend({
        required: { message: "You have to specify the publication year." },
        pattern: {
            params: /^\d{4}$/,
            message: "Not a valid year"
        }
    });
    self.titles = ko.observableArray([new Title(), new Title()]);
    self.addTitle = function() {
        self.titles.push(new Title("", "Subtitle"));
    };
    self.removeTitle = function(title) {
       self.titles.remove(title);
    };
    self.save = function(form) {
        //ko.utils.postJson($("form")[0], self.titles);
       alert("Could now transmit to server: " + ko.utils.stringifyJson(self.titles));
        // To actually transmit to server as a regular form post, write this: ko.utils.postJson($("form")[0], self.gifts);
    };
};
$(function () {
ko.applyBindings(new viewModel());
});