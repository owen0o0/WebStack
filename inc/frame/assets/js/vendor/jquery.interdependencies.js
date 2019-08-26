/**
 * jQuery Interdependencies library
 *
 * http://miohtama.github.com/jquery-interdependencies/
 *
 * Copyright 2012-2013 Mikko Ohtamaa, others
 */

/*global console, window*/

(function($) {

    "use strict";

    /**
     * Microsoft safe helper to spit out our little diagnostics information
     *
     * @ignore
     */
    function log(msg) {
        if(window.console && window.console.log) {
            console.log(msg);
        }
    }


    /**
     * jQuery.find() workaround for IE7
     *
     * If your selector is an pure tag id (#foo) IE7 finds nothing
     * if you do jQuery.find() in a specific jQuery context.
     *
     * This workaround makes a (false) assumptions
     * ids are always unique across the page.
     *
     * @ignore
     *
     * @param  {jQuery} context  jQuery context where we look child elements
     * @param  {String} selector selector as a string
     * @return {jQuery}          context.find() result
     */
    function safeFind(context, selector) {

        if(selector[0] == "#") {

            // Pseudo-check that this is a simple id selector
            // and not a complex jQuery selector
            if(selector.indexOf(" ") < 0) {
                return $(selector);
            }
        }

        return context.find(selector);
    }

    /**
     * Sample configuration object which can be passed to {@link jQuery.deps#enable}
     *
     * @class Configuration
     */
    var configExample = {

        /**
         * @cfg show Callback function show(elem) for showing elements
         * @type {Function}
         */
        show : null,

        /**
         * @cfg hide Callback function hide(elem) for hiding elements
         * @type {Function}
         */
        hide : null,

        /**
         * @cfg log Write console.log() output of rule applying
         * @type {Boolean}
         */
        log : false,


        /**
         * @cfg checkTargets When ruleset is enabled, check that all controllers and controls referred by ruleset exist on the page.
         *
         * @default true
         *
         * @type {Boolean}
         */
        checkTargets : true

    };

    /**
     * Define one field inter-dependency rule.
     *
     * When condition is true then this input and all
     * its children rules' inputs are visible.
     *
     * Possible condition strings:
     *
     *  * **==**  Widget value must be equal to given value
     *
     *  * **any** Widget value must be any of the values in the given value array
     *
     *  * **non-any** Widget value must not be any of the values in the given value array
     *
     *  * **!=** Widget value must not be qual to given value
     *
     *  * **()** Call value as a function(context, controller, ourWidgetValue) and if it's true then the condition is true
     *
     *  * **null** This input does not have any sub-conditions
     *
     *
     *
     */
    function Rule(controller, condition, value) {
        this.init(controller, condition, value);
    }

    $.extend(Rule.prototype, {

        /**
         * @method constructor
         *
         * @param {String} controller     jQuery expression to match the `<input>`   source
         *
         * @param {String} condition What input value must be that {@link Rule the rule takes effective}.
         *
         * @param value Matching value of **controller** when widgets become visible
         *
         */
        init : function(controller, condition, value) {
            this.controller = controller;

            this.condition = condition;

            this.value = value;

            // Child rules
            this.rules = [];

            // Controls shown/hidden by this rule
            this.controls = [];
        },

        /**
         * Evaluation engine
         *
         * @param  {String} condition Any of given conditions in Rule class description
         * @param  {Object} val1      The base value we compare against
         * @param  {Object} val2      Something we got out of input
         * @return {Boolean}          true or false
         */
        evalCondition : function(context, control, condition, val1, val2) {

          /**
           *
           * Codestar Framework
           * Added new condition for Codestar Framework
           *
           * @since 1.0.0
           * @version 1.0.0
           *
           */
          if(condition == "==" || condition == "OR") {
            return this.checkBoolean(val1) == this.checkBoolean(val2);
          } else if(condition == "!=") {
            return this.checkBoolean(val1) != this.checkBoolean(val2);
          } else if(condition == ">=") {
            return Number(val2) >= Number(val1);
          } else if(condition == "<=") {
            return Number(val2) <= Number(val1);
          } else if(condition == ">") {
            return Number(val2) > Number(val1);
          } else if(condition == "<") {
            return Number(val2) < Number(val1);
          } else if(condition == "()") {
            return window[val1](context, control, val2); // FIXED: function method
          } else if(condition == "any") {
            return $.inArray(val2, val1.split(',')) > -1;
          } else if(condition == "not-any") {
            return $.inArray(val2, val1.split(',')) == -1;
          } else {
            throw new Error("Unknown condition:" + condition);
          }

        },

        /**
         *
         * Codestar Framework
         * Added Boolean value type checker
         *
         * @since 1.0.0
         * @version 1.0.0
         *
         */
        checkBoolean: function(value) {

          switch(value) {

            case true:
            case 'true':
            case 1:
            case '1':
            //case 'on':
            //case 'yes':
              value = true;
            break;

            case false:
            case 'false':
            case 0:
            case '0':
            //case 'off':
            //case 'no':
              value = false;
            break;

          }

          return value;
        },

        /**
         * Evaluate the condition of this rule in given jQuery context.
         *
         * The widget value is extracted using getControlValue()
         *
         * @param {jQuery} context The jQuery selection in which this rule is evaluated.
         *
         */
        checkCondition : function(context, cfg) {

            // We do not have condition set, we are always true
            if(!this.condition) {
                return true;
            }

            var control = context.find(this.controller);
            if(control.size() === 0 && cfg.log) {
                log("Evaling condition: Could not find controller input " + this.controller);
            }

            var val = this.getControlValue(context, control);
            if(cfg.log && val === undefined) {
                log("Evaling condition: Could not exctract value from input " + this.controller);
            }

            if(val === undefined) {
                return false;
            }

            val = this.normalizeValue(control, this.value, val);

            return this.evalCondition(context, control, this.condition, this.value, val);
        },

        /**
         * Make sure that what we read from input field is comparable against Javascript primitives
         *
         */
        normalizeValue : function(control, baseValue, val) {

            if(typeof baseValue == "number") {
                // Make sure we compare numbers against numbers
                return parseFloat(val);
            }

            return val;
        },

        /**
         * Read value from a diffent HTML controls.
         *
         * Handle, text, checkbox, radio, select.
         *
         */
        getControlValue : function(context, control) {

          /**
           *
           * Codestar Framework
           * Added multiple checkbox value control
           *
           * @since 1.0.0
           * @version 1.0.0
           *
           */
          if( ( control.attr("type") == "radio" || control.attr("type") == "checkbox" ) && control.size() > 1 ) {
            return control.filter(":checked").val();
          }

          // Handle individual checkboxes & radio
          if ( control.attr("type") == "checkbox" || control.attr("type") == "radio" ) {
            return control.is(":checked");
          }

          return control.val();

        },

        /**
         * Create a sub-rule.
         *
         * Example:
         *
         *      var masterSwitch = ruleset.createRule("#mechanicalThrombectomyDevice")
         *      var twoAttempts = masterSwitch.createRule("#numberOfAttempts", "==", 2);
         *
         * @return Rule instance
         */
        createRule : function(controller, condition, value) {
            var rule = new Rule(controller, condition, value);
            this.rules.push(rule);
            return rule;
        },

        /**
         * Include a control in this rule.
         *
         * @param  {String} input     jQuery expression to match the input within ruleset context
         */
        include : function(input) {

            if(!input) {
                throw new Error("Must give an input selector");
            }

            this.controls.push(input);
        },

        /**
         * Apply this rule to all controls in the given context
         *
         * @param  {jQuery} context  jQuery selection within we operate
         * @param  {Object} cfg      {@link Configuration} object or undefined
         * @param  {Object} enforced Recursive rule enforcer: undefined to evaluate condition, true show always, false hide always
         *
         */
        applyRule : function(context, cfg, enforced) {

            var result;

            if(enforced === undefined) {
                result = this.checkCondition(context, cfg);
            } else {
                result = enforced;
            }

            if(cfg.log) {
                log("Applying rule on " + this.controller + "==" + this.value + " enforced:" + enforced + " result:" + result);
            }

            if(cfg.log && !this.controls.length) {
                log("Zero length controls slipped through");
            }

            // Get show/hide callback functions

            var show = cfg.show || function(control) {
                control.show();
            };

            var hide = cfg.hide || function(control) {
                control.hide();
            };


            // Resolve controls from ids to jQuery selections
            // we are controlling in this context
            var controls = $.map(this.controls, function(elem, idx) {
                var control = context.find(elem);
                if(cfg.log && control.size() === 0) {
                    log("Could not find element:" + elem);
                }
                return control;
            });

            if(result) {

                $(controls).each(function() {


                    // Some friendly debug info
                    if(cfg.log && $(this).size() === 0) {
                        log("Control selection is empty when showing");
                        log(this);
                    }

                    show(this);
                });

                // Evaluate all child rules
                $(this.rules).each(function() {
                  if(this.condition !== "OR"){
                    this.applyRule(context, cfg);
                  }
                });

            } else {

                $(controls).each(function() {

                    // Some friendly debug info
                    if(cfg.log && $(this).size() === 0) {
                        log("Control selection is empty when hiding:");
                        log(this);
                    }

                    hide(this);
                });

                // Supress all child rules
                $(this.rules).each(function() {
                  if(this.condition !== "OR"){
                    this.applyRule(context, cfg, false);
                  } else {
                    this.applyRule(context, cfg);
                  }
                });
            }
        }
    });

    /**
     * A class which manages interdependenice rules.
     */
    function Ruleset() {

        // Hold a tree of rules
        this.rules = [];
    }

    $.extend(Ruleset.prototype, {

        /**
         * Add a new rule into this ruletset.
         *
         * See  {@link Rule} about the contstruction parameters.
         * @return {Rule}
         */
        createRule : function(controller, condition, value) {
            var rule = new Rule(controller, condition, value);
            this.rules.push(rule);
            return rule;
        },

        /**
         * Apply these rules on an element.
         *
         * @param {jQuery} context Selection we are dealing with
         *
         * @param cfg {@link Configuration} object or undefined.
         */
        applyRules: function(context, cfg) {
            var i;

            cfg = cfg || {};

            if(cfg.log) {
                log("Starting evaluation ruleset of " + this.rules.length + " rules");
            }

            for(i=0; i<this.rules.length; i++) {
                this.rules[i].applyRule(context, cfg);
            }
        },

        /**
         * Walk all rules and sub-rules in this ruleset
         * @param  {Function} callback(rule)
         *
         * @return {Array} Rules as depth-first searched
         */
        walk : function() {

            var rules = [];

            function descent(rule) {

                rules.push(rule);

                $(rule.children).each(function() {
                    descent(this);
                });
            }

            $(this.rules).each(function() {
                descent(this);
            });

            return rules;
        },


        /**
         * Check that all controllers and controls referred in ruleset exist.
         *
         * Throws an Error if any of them are missing.
         *
         * @param {jQuery} context jQuery selection of items
         *
         * @param  {Configuration} cfg
         */
        checkTargets : function(context, cfg) {

            var controls = 0;
            var rules = this.walk();

            $(rules).each(function() {

                if(context.find(this.controller).size() === 0) {
                    throw new Error("Rule's controller does not exist:" + this.controller);
                }

                if(this.controls.length === 0) {
                    throw new Error("Rule has no controls:" + this);
                }

                $(this.controls).each(function() {

                    if(safeFind(context, this) === 0) {
                        throw new Error("Rule's target control " + this + " does not exist in context " + context.get(0));
                    }

                    controls++;
                });

            });

            if(cfg.log) {
                log("Controller check ok, rules count " + rules.length + " controls count " + controls);
            }

        },

        /**
         * Make this ruleset effective on the whole page.
         *
         * Set event handler on **window.document** to catch all input events
         * and apply those events to defined rules.
         *
         * @param  {Configuration} cfg {@link Configuration} object or undefined
         *
         */
        install : function(cfg) {
            $.deps.enable($(document.body), this, cfg);
        }

    });

    /**
     * jQuery interdependencie plug-in
     *
     * @class jQuery.deps
     *
     */
    var deps = {

        /**
         * Create a new Ruleset instance.
         *
         * Example:
         *
         *      $(document).ready(function() {
         *           // Start creating a new ruleset
         *           var ruleset = $.deps.createRuleset();
         *
         *
         * @return {Ruleset}
         */
        createRuleset : function() {
            return new Ruleset();
        },


        /**
         * Enable ruleset on a specific jQuery selection.
         *
         * Checks the existince of all ruleset controllers and controls
         * by default (see config).
         *
         * See possible IE event bubbling problems: http://stackoverflow.com/q/265074/315168
         *
         * @param  {Object} selection jQuery selection in where we monitor all change events. All controls and controllers must exist within this selection.
         * @param  {Ruleset} ruleset
         * @param  {Configuration} cfg
         */
        enable : function(selection, ruleset, cfg) {

            cfg = cfg || {};

            if(cfg.checkTargets || cfg.checkTargets === undefined) {
                ruleset.checkTargets(selection, cfg);
            }

            var self = this;

            if(cfg.log) {
                log("Enabling dependency change monitoring on " + selection.get(0));
            }

            // Namespace our handler to avoid conflicts
            //
            var handler = function() { ruleset.applyRules(selection, cfg); };
            var val = selection.on ? selection.on("change.deps", null, null, handler) : selection.live("change.deps", handler);

            ruleset.applyRules(selection, cfg);

            return val;
        }
    };

    $.deps = deps;

})(jQuery);
