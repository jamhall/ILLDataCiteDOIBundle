var validators;
(function (v) {

    // trim shim (thanks http://blog.stevenlevithan.com/archives/faster-trim-javascript)
    if (!String.prototype.trim) {
        String.prototype.trim = function (str) {
            str = str.replace(/^\s\s*/, '');
            var ws = /\s/,
                i = str.length;
            while (ws.test(str.charAt(--i)));
            return str.slice(0, i + 1);
        };
    }

    // thanks http://stackoverflow.com/a/1830844/64334
    function isNumber(n) {
        return !isNaN(parseFloat(n)) && isFinite(n);
    }

    // validator functions go here
    v.fn = {

        required: function (value, message) {
            if (!value || !value.trim()) {
                return message || 'Required';
            }
        },

        number: function (value, message) {
            if (value && !isNumber(value)) {
                return message || 'Must be a number';
            }
        },

        min: function (value, opts) {
            if (!value)
                return;

            var n = parseFloat(value);
            if (!n || n < opts.value)
                return opts.message || 'Must be at least ' + opts.value;
        }
    };

})(validators || (validators = {}));

/*
    extend view model properties to use validations:
    happyProperty = ko.observable().extend({
        validations: {
            required: 'THIS IS REQUIRED!',
            otherValidator: { the: 'validation', parameters: 'go here' }
        }
    });

*/
ko.extenders.validations = function (target, validations) {

    target.hadFocus = ko.observable(false);
    target.errorMessage = ko.observable();
    target.hasError = ko.computed(function () {
        return !!target.errorMessage();
    });

    target.validate = function () {
        target.errorMessage(null);

        if (!target.hadFocus())
            return;

        for (v in validations) {
            var msg = validators.fn[v](target(), validations[v]);
            if (msg) {
                target.errorMessage(msg);
                break;
            }
        }
    };

    target.subscribe(target.validate);
    target.hadFocus.subscribe(function () {
        target.validate();
    });
    return target;
};


/*
    use this binding on input elements to wire up event handling
    <input type="text" data-bind="value: happyProperty, validation: happyProperty" />
    
    I don't love this duplicate binding, but it works and I don't see a better way, yet.
*/
ko.bindingHandlers.validation = {
    init: function (element, valueAccessor, allBindingsAccessor) {
        ko.utils.registerEventHandler(element, 'blur', function () {
            allBindingsAccessor().validation.hadFocus(true);
        }); ;
    }
};

/*
    this function creates an object that lets you work 
    with all of the validated observables at once:    

    var valContainer = ko.makeValidationContainer([vm.happyProperty, vm.otherThing, vm.lastThing]);

    valContainer.clearErrors(); // self-explanatory
    valContainer.allErrors();   // ko.computed array of current error messages (doesn't cause validation)
    valContainer.isValid();     // ko.computed boolean (does cause validation)
    valContainer.forEachObservable(function(observable)); // do something with each observable
*/
ko.createValidationGroup = function (validatedObservables) {

    var group = {
        observables: validatedObservables
    };

    group.forEachObservable = function (action) {
        for (var i = 0; i < group.observables.length; i++) {
            action(group.observables[i]);
        }
    };

    group.clearErrors = function () {
        group.forEachObservable(function (o) { o.hadFocus(false); });
    };

    group.allErrors = ko.computed(function () {
        var errors = [];
        group.forEachObservable(function (o) {
            var err = o.errorMessage();
            if (err) errors.push(err);
        });
        return errors;
    });

    group.isValid = ko.computed({
        read: function () {
            var result = true;
            group.forEachObservable(function (o) {
                o.hadFocus(true);
                if (o.hasError()) result = false;
            });
            return result;
        },
        deferEvaluation: true
    });

    return group;
};