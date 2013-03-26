ko.validation.configure({
    insertMessages: false,
    decorateElement: true,
    errorElementClass: 'error'
});

var Title = function (title, type) {
    this.title = ko.observable(title).extend({ required: true });
    this.type = ko.observable(type);
};

var Subject = function(subject, scheme) {
    this.subject =  ko.observable(subject).extend({ required: true });
    this.scheme = ko.observable(scheme);
};

var NameIdentifier = function(identifier, scheme)
{
    this.identifier = ko.observable(identifier);
    this.scheme = ko.observable(scheme);
};

var Creator = function(name, nameIdentifier) {
    this.name =  ko.observable(name).extend({ required: true });
    this.nameIdentifier = nameIdentifier;
};

var Contributor = function(name, type, nameIdentifier) {
    this.name = ko.observable(name).extend({ required: true });
    this.type = ko.observable(type);
    this.nameIdentifier = nameIdentifier;
};

var ResourceType = function(type, resourceType) {
    this.type = ko.observable(type).extend({ required: true });
    this.resourceType = ko.observable(resourceType);
};

var Metadata = function() {
    var self = this;
    self.titleTypes = ko.observableArray([{ id: "AlternativeTitle", value: "Alternative title" }, { id: "Subtitle", value: "Subtitle" }]);
    self.contributorTypes = ko.observableArray([
                                                { id: "ContactPerson", value: "Contact person" },
                                                { id: "DataCollector", value: "Data collector" },
                                                { id: "DataManager", value: "Data manager" },
                                                { id: "Editor", value: "Editor" },
                                                { id: "HostingInstitution", value: "Hosting institution" },
                                                { id: "ProjectLeader", value: "Project leader" },
                                                { id: "ProjectMember", value: "Project member" },
                                                { id: "RegistrationAgency", value: "Registration agency" },
                                                { id: "RegistrationAuthority", value: "Registration authority" },
                                                { id: "Researcher", value: "Research" },
                                                { id: "WorkPackageLeader", value: "Work package leader" }
                                               ]);
    self.resourceTypes = ko.observableArray([
                                                { id: "Collection", value: "Collection" },
                                                { id: "Dataset", value: "Dataset" },
                                                { id: "Film", value: "Film" },
                                                { id: "Image", value: "Image" },
                                                { id: "InteractiveResource", value: "Interactive resource" },
                                                { id: "PhysicalObject", value: "Physical object" },
                                                { id: "Service", value: "Software" },
                                                { id: "Software", value: "Software" },
                                                { id: "Sound", value: "Sound" },
                                                { id: "Text", value: "Text" }
                                            ]);
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
    self.publisher = ko.observable();
    self.titles = ko.observableArray();
    self.subjects = ko.observableArray();
    self.creators = ko.observableArray();
    self.contributors = ko.observableArray();
    self.resourceType = ko.observable(new ResourceType('', ''));
};

var viewModel = function() {
    self.metadata = new Metadata();

    self.addTitle = function() {
        self.metadata.titles.push(new Title(null, null));
    };
    self.removeTitle = function(title) {
       self.metadata.titles.remove(title);
    };

    self.addSubject = function() {
        self.metadata.subjects.push(new Subject("", ""));
    };
    self.removeSubject = function(subject) {
       self.metadata.subjects.remove(subject);
    };

    self.addCreator = function() {
       self.metadata.creators.push(new Creator(null, new NameIdentifier(null, null)));
    };

    self.removeCreator = function(creator) {
       self.metadata.creators.remove(creator);
    };

    self.addContributor = function() {
       self.metadata.contributors.push(new Contributor(null, null, new NameIdentifier(null, null)));
    };

    self.removeContributor = function(contributor) {
       self.metadata.contributors.remove(contributor);
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
                    self.metadata.publisher(result.publisher);
                    self.metadata.resourceType(new ResourceType(result.resourceType.type,result.resourceType.resourceType));
                    // add titles
                    for (var i = 0, j = result.titles.length; i < j; i++){
                        self.metadata.titles.push(new Title(result.titles[i].title, result.titles[i].type));
                    }

                    // add subjects
                    for (var i = 0, j = result.subjects.length; i < j; i++){
                        self.metadata.subjects.push(new Subject(result.subjects[i].subject, result.subjects[i].scheme));
                    }

                    // add creators
                    for (var i = 0, j = result.creators.length; i < j; i++){

                        if(result.creators[i].nameIdentifier == null) {
                            self.metadata.creators.push(new Creator(result.creators[i].name, new NameIdentifier(null, null)));
                        } else {
                            self.metadata.creators.push(new Creator(result.creators[i].name,
                                                        new NameIdentifier(result.creators[i].nameIdentifier.identifier,
                                                                          result.creators[i].nameIdentifier.scheme)));
                        }
                    }

                    // add contributors
                    for (var i = 0, j = result.contributors.length; i < j; i++){

                        if(result.contributors[i].nameIdentifier == null) {
                            self.metadata.contributors.push(new Contributor(result.contributors[i].name, result.contributors[i].type, new NameIdentifier(null, null)));
                        } else {
                            self.metadata.contributors.push(new Contributor(result.contributors[i].name, result.contributors[i].type,
                                                        new NameIdentifier(result.contributors[i].nameIdentifier.identifier,
                                                                          result.contributors[i].nameIdentifier.scheme)));
                        }
                    }

                    console.log(ko.toJSON(self.metadata.resourceType));

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
       console.log("Could now transmit to server: " + ko.toJSON(self.metadata.creators));
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