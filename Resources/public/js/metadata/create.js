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
    this.identifier = ko.observable(identifier).extend({
        validation: {
            validator: function (val, someOtherVal) {
                if(val === null || val == "") {
                    //console.log("Zero!");
                    return true;
                }
                if(scheme === null) {
                    return false;
                }
                return true;
            },
            message: 'Please fill in both fields',
            params: scheme
        }
    });
    this.scheme = ko.observable(scheme);
};

var Creator = function(name, nameIdentifier) {
    this.name =  ko.observable(name).extend({ required: true });
    this.nameIdentifier = nameIdentifier;
};

var Contributor = function(name, type, nameIdentifier) {
    this.name = ko.observable(name).extend({ required: true });
    this.type = ko.observable(type);
    this.nameIdentifier = ko.observable(nameIdentifier);
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
    self.prefixes = ko.observableArray();
    self.publicationYears = ko.observableArray();
    self.publicationYear = ko.observable("2013").extend({
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
    /**
     * Credits to fractalizer.ru for the language codes
     * http://www.fractalizer.ru/frpost_267/php-array-of-iso-639-1-language-codes-names/
     */
    self.languages = [{id:"ab",value:"Abkhazian"},{id:"aa",value:"Afar"},{id:"af",value:"Afrikaans"},{id:"ak",value:"Akan"},{id:"sq",value:"Albanian"},{id:"am",value:"Amharic"},{id:"ar",value:"Arabic"},{id:"an",value:"Aragonese"},{id:"hy",value:"Armenian"},{id:"as",value:"Assamese"},{id:"av",value:"Avaric"},{id:"ae",value:"Avestan"},{id:"ay",value:"Aymara"},{id:"az",value:"Azerbaijani"},{id:"bm",value:"Bambara"},{id:"ba",value:"Bashkir"},{id:"eu",value:"Basque"},{id:"be",value:"Belarusian"},{id:"bn",value:"Bengali"},{id:"bh",value:"Bihari"},{id:"bi",value:"Bislama"},{id:"bs",value:"Bosnian"},{id:"br",value:"Breton"},{id:"bg",value:"Bulgarian"},{id:"my",value:"Burmese"},{id:"ca",value:"Catalan"},{id:"ch",value:"Chamorro"},{id:"ce",value:"Chechen"},{id:"ny",value:"Chichewa"},{id:"zh",value:"Chinese"},{id:"cu",value:"Church Slavic"},{id:"cv",value:"Chuvash"},{id:"kw",value:"Cornish"},{id:"co",value:"Corsican"},{id:"cr",value:"Cree"},{id:"hr",value:"Croatian"},{id:"cs",value:"Czech"},{id:"da",value:"Danish"},{id:"dv",value:"Divehi"},{id:"nl",value:"Dutch"},{id:"dz",value:"Dzongkha"},{id:"en",value:"English"},{id:"eo",value:"Esperanto"},{id:"et",value:"Estonian"},{id:"ee",value:"Ewe"},{id:"fo",value:"Faroese"},{id:"fj",value:"Fijian"},{id:"fi",value:"Finnish"},{id:"fr",value:"French"},{id:"ff",value:"Fulah"},{id:"gl",value:"Galician"},{id:"lg",value:"Ganda"},{id:"ka",value:"Georgian"},{id:"de",value:"German"},{id:"el",value:"Greek"},{id:"gn",value:"Guarani"},{id:"gu",value:"Gujarati"},{id:"ht",value:"Haitian"},{id:"ha",value:"Hausa"},{id:"he",value:"Hebrew"},{id:"hz",value:"Herero"},{id:"hi",value:"Hindi"},{id:"ho",value:"Hiri Motu"},{id:"hu",value:"Hungarian"},{id:"is",value:"Icelandic"},{id:"io",value:"Ido"},{id:"ig",value:"Igbo"},{id:"id",value:"Indonesian"},{id:"ia",value:"Interlingua (International Auxiliary Language Association)"},{id:"ie",value:"Interlingue"},{id:"iu",value:"Inuktitut"},{id:"ik",value:"Inupiaq"},{id:"ga",value:"Irish"},{id:"it",value:"Italian"},{id:"ja",value:"Japanese"},{id:"jv",value:"Javanese"},{id:"kl",value:"Kalaallisut"},{id:"kn",value:"Kannada"},{id:"kr",value:"Kanuri"},{id:"ks",value:"Kashmiri"},{id:"kk",value:"Kazakh"},{id:"km",value:"Khmer"},{id:"ki",value:"Kikuyu"},{id:"rw",value:"Kinyarwanda"},{id:"ky",value:"Kirghiz"},{id:"rn",value:"Kirundi"},{id:"kv",value:"Komi"},{id:"kg",value:"Kongo"},{id:"ko",value:"Korean"},{id:"ku",value:"Kurdish"},{id:"kj",value:"Kwanyama"},{id:"lo",value:"Lao"},{id:"la",value:"Latin"},{id:"lv",value:"Latvian"},{id:"li",value:"Limburgish"},{id:"ln",value:"Lingala"},{id:"lt",value:"Lithuanian"},{id:"lu",value:"Luba-Katanga"},{id:"lb",value:"Luxembourgish"},{id:"mk",value:"Macedonian"},{id:"mg",value:"Malagasy"},{id:"ms",value:"Malay"},{id:"ml",value:"Malayalam"},{id:"mt",value:"Maltese"},{id:"gv",value:"Manx"},{id:"mi",value:"Maori"},{id:"mr",value:"Marathi"},{id:"mh",value:"Marshallese"},{id:"mn",value:"Mongolian"},{id:"na",value:"Nauru"},{id:"nv",value:"Navajo"},{id:"ng",value:"Ndonga"},{id:"ne",value:"Nepali"},{id:"nd",value:"North Ndebele"},{id:"se",value:"Northern Sami"},{id:"no",value:"Norwegian"},{id:"nb",value:"Norwegian Bokmal"},{id:"nn",value:"Norwegian Nynorsk"},{id:"oc",value:"Occitan"},{id:"oj",value:"Ojibwa"},{id:"or",value:"Oriya"},{id:"om",value:"Oromo"},{id:"os",value:"Ossetian"},{id:"pi",value:"Pali"},{id:"pa",value:"Panjabi"},{id:"ps",value:"Pashto"},{id:"fa",value:"Persian"},{id:"pl",value:"Polish"},{id:"pt",value:"Portuguese"},{id:"qu",value:"Quechua"},{id:"rm",value:"Raeto-Romance"},{id:"ro",value:"Romanian"},{id:"ru",value:"Russian"},{id:"sm",value:"Samoan"},{id:"sg",value:"Sango"},{id:"sa",value:"Sanskrit"},{id:"sc",value:"Sardinian"},{id:"gd",value:"Scottish Gaelic"},{id:"sr",value:"Serbian"},{id:"sn",value:"Shona"},{id:"ii",value:"Sichuan Yi"},{id:"sd",value:"Sindhi"},{id:"si",value:"Sinhala"},{id:"sk",value:"Slovak"},{id:"sl",value:"Slovenian"},{id:"so",value:"Somali"},{id:"nr",value:"South Ndebele"},{id:"st",value:"Southern Sotho"},{id:"es",value:"Spanish"},{id:"su",value:"Sundanese"},{id:"sw",value:"Swahili"},{id:"ss",value:"Swati"},{id:"sv",value:"Swedish"},{id:"tl",value:"Tagalog"},{id:"ty",value:"Tahitian"},{id:"tg",value:"Tajik"},{id:"ta",value:"Tamil"},{id:"tt",value:"Tatar"},{id:"te",value:"Telugu"},{id:"th",value:"Thai"},{id:"bo",value:"Tibetan"},{id:"ti",value:"Tigrinya"},{id:"to",value:"Tonga"},{id:"ts",value:"Tsonga"},{id:"tn",value:"Tswana"},{id:"tr",value:"Turkish"},{id:"tk",value:"Turkmen"},{id:"tw",value:"Twi"},{id:"ug",value:"Uighur"},{id:"uk",value:"Ukrainian"},{id:"ur",value:"Urdu"},{id:"uz",value:"Uzbek"},{id:"ve",value:"Venda"},{id:"vi",value:"Vietnamese"},{id:"vo",value:"Volapuk"},{id:"wa",value:"Walloon"},{id:"cy",value:"Welsh"},{id:"fy",value:"Western Frisian"},{id:"wo",value:"Wolof"},{id:"xh",value:"Xhosa"},{id:"yi",value:"Yiddish"},{id:"yo",value:"Yoruba"},{id:"za",value:"Zhuang"},{id:"zu",value:"Zulu"}];
    self.language = ko.observable("en");
    self.prefix =  ko.observable(null).extend({ required: true, message: "Thie is required" });
    self.suffix =  ko.observable(null).extend({ required: true });
    self.rights = ko.observable();
    self.publisher = ko.observable();
    self.titles = ko.observableArray();
    self.subjects = ko.observableArray();
    self.creators = ko.observableArray();
    self.contributors = ko.observableArray();
    self.resourceType = ko.observable(new ResourceType('', ''));
    /**
     * Populate publication years drop down
     */
    for (i = 2050; i > 1950; i--)
    {
        self.publicationYears.push({ id: i, value: i });
    }
    self.toJson = function(){
        console.log("Hello");
    };
};

var viewModel = function() {
    self.metadata = new Metadata();
    self.validationModel = ko.validatedObservable(self.metadata);
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

    self.addPrefix = function(prefix) {

    };

    self.clearPublisher = function() {
        self.metadata.publisher(null);
    };
    this.isNew = function() {
        self.addCreator();
        self.addTitle();
    };
    this.getConfig = function() {
        $.ajax({
            url:  $("form[id='metadataForm']").data("config-url"),
            contentType: 'application/json',
            type: "GET",
            dataType: 'json',
            success: function (result) {
                for (var i = 0, j = result.prefixes.length; i < j; i++){
                    self.metadata.prefixes.push({
                                                    id: result.prefixes[i].prefix,
                                                    value: result.prefixes[i].prefix + " - " + result.prefixes[i].description
                                                });
                }
            },
            error: function (result) {
                alert('Sorry, there was an error');
            }
        });
    };
    self.validate = function() {

    };
    self.save = function(form) {
        if (self.validationModel.errors().length == 0) {
            alert('Thank you.');
        } else {
            alert('Please check your submission.');
            console.debug(self.validationModel.errors.showAllMessages());
        }

       /* $.blockUI({
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
        }); */
        self.metadata.toJSON = function() {
            var copy = ko.toJS(this);
            delete copy.contributorTypes;
            delete copy.resourceTypes;
            delete copy.titleTypes;
            delete copy.languages;
            delete copy.prefixes;
            delete copy.publicationYears;
            /**
             * Format the identifier
             */
            copy.identifier = copy.prefix + "/" + copy.suffix;
            delete copy.prefix;
            delete copy.suffix;
            /**
             * Remove redundant data
             */
            if(copy.contributors.length === 0) {
                delete copy.contributors;
            } else {
                for (var i = 0, j = copy.contributors.length; i < j; i++) {
                    if(copy.contributors[i].nameIdentifier.identifier === null && copy.contributors[i].nameIdentifier.scheme === null) {
                        delete copy.contributors[i].nameIdentifier;
                    }
                }
            }

            if(copy.creators.length === 0) {
                delete copy.creators;
            } else {
                for (var i = 0, j = copy.creators.length; i < j; i++) {
                    if(copy.creators[i].nameIdentifier.identifier === null && copy.creators[i].nameIdentifier.scheme === null) {
                        delete copy.creators[i].nameIdentifier;
                    }
                }
            }

            if(copy.subjects.length === 0) {
                delete copy.subjects;
            } else {
                for (var i = 0, j = copy.subjects.length; i < j; i++){
                    if(copy.subjects[i].subject === null && copy.subjects[i].scheme === null) {
                        delete copy.subjects[i];
                    }
                }
            }

            if(copy.titles.length == 0) {
                delete copy.titles;
            }

            if(copy.language === null || copy.language == "") {
                delete copy.language;
            }

            delete copy.resourceType;
            return copy;
        };

        $.ajax({
            url:  $("form[id='metadataForm']").attr("action"),
            contentType: 'application/json',
            type: "POST",
            data: ko.toJSON(self.metadata),
            dataType: 'json',
            success: function (result) {
                console.log(result);
            }
        });
        // To actually transmit to server as a regular form post, write this: ko.utils.postJson($("form")[0], self.gifts);
    };
};

$(document).ajaxStop($.unblockUI);
$(function () {
    $("div[id='publicationYears']").datepicker();
    $("input[data-toggle=popover]").popover({ trigger: "focus" });
    $("select[data-toggle=popover]").popover({ trigger: "focus" });

    var vm = new viewModel();
    /**
     * Get configuration options
     */
    vm.getConfig();
    vm.isNew();
    /**
     * Code to get chosen to work with knockoutjs
     */
    ko.bindingHandlers.chosen = {
        init: function(element, valueAccessor, allBindingsAccessor, viewModel) {
            var allBindings = allBindingsAccessor();
            var options = {default: 'Select one...'};
            $.extend(options, allBindings.chosen)
            $(element).attr('data-placeholder', options.default).addClass('chzn-select');
        },
        update: function(element, valueAccessor, allBindingsAccessor, viewModel) {
            $('.chzn-select').chosen();
        }
    };
    ko.applyBindings(vm);
});