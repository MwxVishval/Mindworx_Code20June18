<style type="text/css">
    #Edit_ServiceEnginner label.error {
        color: #FB3A3A;
        display: inline-block;
        padding: 0;
        text-align: left;
        width: 220px;
    }
</style>
<script type="text/javascript">

    (function ($, W, D)
    {
        var JQUERY4U = {};

        JQUERY4U.UTIL =
                {
                    setupFormValidation: function ()
                    {
                        //form validation rules
                        $("#Edit_ServiceEnginner").validate({
                            rules: {
                                fse_name: "required",
                                fse_username: {
                                    //regx: /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])\w{6,}$/,
                                    required: true,
                                    minlength: 6,
                                    maxlength: 18,
                                },
                                ent_id: "required",
                                branch_id: "required",
                                fse_password: {
                                    regx: /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])\w{6,}$/,
                                    required: true,
                                    minlength: 6,
                                    maxlength: 18,
                                },
                                fse_cpassword: {
                                    equalTo: "#fse_password",
                                    minlength: 6,
                                    maxlength: 18,
                                },
                                fse_email: {
                                    required: true,
                                    email: true
                                },
                                fse_mobile: "required",
                                fse_address: "required",
                                fse_type_id: {
                                    required: true
                                }
                            },
                            messages: {
                                fse_name: "Please Enter FSE Name",
                                fse_username: "Please Enter Valid FSE UserName length between 6-18",
                                fse_password: "Please Enter Valid Password length between 6-18,1 Uppercase, 1 Lowercase, 1 Number",
                                fse_cpassword: "Please Enter the Same Passsword",
                                fse_type_id: "Please Select FSE Type",
                                fse_email: "Please Enter Valid FSE Email",
                                fse_mobile: "Please Enter FSE Mobile",
                                fse_address: "Please Enter FSE Address",
                                ent_id: "Please Select Entity Name",
                                branch_id: "Please Select Branch Name",
                            },
                            submitHandler: function (form) {
                                form.submit();
                            }
                        });
                    }
                }

        //when the dom has loaded setup form validation rules
        $(D).ready(function ($) {
            JQUERY4U.UTIL.setupFormValidation();
        });

    })(jQuery, window, document);
    $.validator.addMethod("regx", function (value, element, regexpr) {
        return regexpr.test(value);
    }, "Please enter a valid.");
</script>
<script>
    $(document).ready(function () {
        $("input[name$='optradio']").click(function () {
            var test = $(this).val();
            $("div.desc").hide();
            $("#" + test).show();
        });
    });
</script>

<div class="x_panel"  style="height:900px;">
    <div class="x_title">
        <h2>Edit Service Engineer<small></small></h2>
        <div class="clearfix"></div>
    </div>
    <div class="x_content">
        <br />
        <form id="Edit_ServiceEnginner" name="Edit_ServiceEnginner" data-parsley-validate class="form-horizontal form-label-left" action="" method="POST">
            <input type="hidden" name="id" value="<?php echo $result[0]['id']; ?>">
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">FSE Name <span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <input type="text" id="fse_name" name="fse_name" value="<?php echo $result[0]['fse_name']; ?>" class="form-control col-md-7 col-xs-12">
                    <span class="text-danger"><?php echo form_error('fse_name'); ?></span>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">FSE UserName <span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <input type="text" id="fse_username" name="fse_username"  value="<?php echo $result[0]['fse_username']; ?>" class="form-control col-md-7 col-xs-12" maxlength="18">
                    <span class="text-danger"><?php echo form_error('fse_username'); ?></span>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">FSE Type<span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <input id="ms1" style="width:500px;" type="text" name="ms1"/>
                    <div style="clear:both;"></div>
                    <span class="text-danger"><?php echo form_error('fse_type_id'); ?></span>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">FSE Email <span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <input type="text" id="fse_email" name="fse_email" value="<?php echo $result[0]['fse_email']; ?>" class="form-control col-md-7 col-xs-12">
                    <span class="text-danger"><?php echo form_error('fse_email'); ?></span>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">FSE Mobile <span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <input type="text" id="fse_mobile" name="fse_mobile" value="<?php echo $result[0]['fse_mobile']; ?>" class="form-control col-md-7 col-xs-12" onkeyup="if (/\D/g.test(this.value))
                                this.value = this.value.replace(/\D/g, '')">
                    <span class="text-danger"><?php echo form_error('fse_mobile'); ?></span>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">FSE Address <span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <textarea class="form-control col-md-7 col-xs-12" name="fse_address" id="fse_address"><?php echo $result[0]['fse_address']; ?></textarea>
                    <span class="text-danger"><?php echo form_error('fse_address'); ?></span>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Choose Company / Branch
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <div class="radio">
                        <label><input type="radio" name="optradio" <?php if ($result[0]['ent_id'] != 0) { ?> checked="checked" <?php } ?> value="companyDiv">Company</label> 
                        <label><input type="radio" name="optradio" <?php if ($result[0]['branch_id'] != 0) { ?> checked="checked" <?php } ?> value="branchDiv">Branch</label>
                    </div>
                </div>
            </div> 

            <div class="form-group desc" id="companyDiv" <?php if ($result[0]['ent_id'] != 0) { ?>style="display:block;"<?php } else { ?>style="display:none;"<?php } ?>> 
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Company <span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <?php
                    $attributes = 'class="form-control" name="ent_id" id="ent_id"';
                    echo form_dropdown('ent_id', $entity_name, set_value('ent_id', $result[0]['ent_id']), $attributes);
                    ?>
                    <span class="text-danger"><?php echo form_error('ent_id'); ?></span>
                </div>
            </div>
            <div class="form-group desc"  id="branchDiv" <?php if ($result[0]['branch_id'] != 0) { ?>style="display:block;"<?php } else { ?>style="display:none;"<?php } ?>>
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Branch <span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <?php
                    $attributes = 'class="form-control" name="branch_id" id="branch_id"';
                    echo form_dropdown('branch_id', $branch_name, set_value('branch_id', $result[0]['branch_id']), $attributes);
                    ?>
                    <span class="text-danger"><?php echo form_error('branch_id'); ?></span>
                </div>
            </div> 
            <div class="form-group">
                <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                    <a href="<?php echo base_url() ?>serviceEngineer" class="btn btn-primary">Cancel</a>  
                    <input type="submit" class="btn btn-success" name="submit" value="Submit">
                </div>
            </div>

        </form>
    </div>
</div>

<link rel="stylesheet" href="//code.jquery.com/ui/1.11.0/themes/smoothness/jquery-ui.css">
<script src="//code.jquery.com/ui/1.11.0/jquery-ui.js"></script>

<script>
                        (function ($)
                        {
                            "use strict";
                            var TagSuggest = function (element, options)
                            {

                                var ms = this;

                                var defaults = {
                                    allowFreeEntries: true,
                                    cls: '',
                                    data: null,
                                    dataUrlParams: {},
                                    disabled: false,
                                    displayField: 'name',
                                    editable: true,
                                    emptyText: function () {
                                        return cfg.editable ? 'Type or click here' : 'Click here';
                                    },
                                    emptyTextCls: 'tag-empty-text',
                                    expanded: false,
                                    expandOnFocus: function () {
                                        return cfg.editable ? false : true;
                                    },
                                    groupBy: null,
                                    hideTrigger: false,
                                    highlight: true,
                                    id: function () {
                                        return 'tag-ctn-' + $('div[id^="tag-ctn"]').length;
                                    },
                                    infoMsgCls: '',
                                    inputCfg: {},
                                    invalidCls: 'tag-ctn-invalid',
                                    matchCase: false,
                                    maxDropHeight: 290,
                                    maxEntryLength: null,
                                    maxEntryRenderer: function (v) {
                                        return 'Please reduce your entry by ' + v + ' character' + (v > 1 ? 's' : '');
                                    },
                                    maxSuggestions: null,
                                    maxSelection: 10,
                                    maxSelectionRenderer: function (v) {
                                        return 'You cannot choose more than ' + v + ' item' + (v > 1 ? 's' : '');
                                    },
                                    method: 'POST',
                                    minChars: 0,
                                    minCharsRenderer: function (v) {
                                        return 'Please type ' + v + ' more character' + (v > 1 ? 's' : '');
                                    },
                                    name: null,
                                    noSuggestionText: 'No suggestions',
                                    preselectSingleSuggestion: true,
                                    renderer: null,
                                    required: false,
                                    resultAsString: false,
                                    resultsField: 'results',
                                    selectionCls: '',
                                    selectionPosition: 'inner',
                                    selectionRenderer: null,
                                    selectionStacked: false,
                                    sortDir: 'asc',
                                    sortOrder: null,
                                    strictSuggest: false,
                                    style: '',
                                    toggleOnClick: false,
                                    typeDelay: 400,
                                    useTabKey: false,
                                    useCommaKey: true,
                                    useZebraStyle: true,
                                    value: null,
                                    valueField: 'id',
                                    width: function () {
                                        return $(this).width();
                                    }
                                };

                                var conf = $.extend({}, options);
                                var cfg = $.extend(true, {}, defaults, conf);

                                // some init stuff
                                if ($.isFunction(cfg.emptyText)) {
                                    cfg.emptyText = cfg.emptyText.call(this);
                                }
                                if ($.isFunction(cfg.expandOnFocus)) {
                                    cfg.expandOnFocus = cfg.expandOnFocus.call(this);
                                }
                                if ($.isFunction(cfg.id)) {
                                    cfg.id = cfg.id.call(this);
                                }

                                this.addToSelection = function (items, isSilent)
                                {
                                    if (!cfg.maxSelection || _selection.length < cfg.maxSelection) {
                                        if (!$.isArray(items)) {
                                            items = [items];
                                        }
                                        var valuechanged = false;
                                        $.each(items, function (index, json) {
                                            if ($.inArray(json[cfg.valueField], ms.getValue()) === -1) {
                                                _selection.push(json);
                                                valuechanged = true;
                                            }
                                        });
                                        if (valuechanged === true) {
                                            self._renderSelection();
                                            this.empty();
                                            if (isSilent !== true) {
                                                $(this).trigger('selectionchange', [this, this.getSelectedItems()]);
                                            }
                                        }
                                    }
                                };

                                this.clear = function (isSilent)
                                {
                                    this.removeFromSelection(_selection.slice(0), isSilent); // clone array to avoid concurrency issues
                                };
                                this.collapse = function ()
                                {
                                    if (cfg.expanded === true) {
                                        this.combobox.detach();
                                        cfg.expanded = false;
                                        $(this).trigger('collapse', [this]);
                                    }
                                };

                                this.disable = function ()
                                {
                                    this.container.addClass('tag-ctn-disabled');
                                    cfg.disabled = true;
                                    ms.input.attr('disabled', true);
                                };

                                this.empty = function () {
                                    this.input.removeClass(cfg.emptyTextCls);
                                    this.input.val('');
                                };

                                this.enable = function ()
                                {
                                    this.container.removeClass('tag-ctn-disabled');
                                    cfg.disabled = false;
                                    ms.input.attr('disabled', false);
                                };

                                this.expand = function ()
                                {
                                    if (!cfg.expanded && (this.input.val().length >= cfg.minChars || this.combobox.children().size() > 0)) {
                                        this.combobox.appendTo(this.container);
                                        self._processSuggestions();
                                        cfg.expanded = true;
                                        $(this).trigger('expand', [this]);
                                    }
                                };

                                this.isDisabled = function ()
                                {
                                    return cfg.disabled;
                                };

                                this.isValid = function ()
                                {
                                    return cfg.required === false || _selection.length > 0;
                                };

                                this.getDataUrlParams = function ()
                                {
                                    return cfg.dataUrlParams;
                                };


                                this.getName = function ()
                                {
                                    return cfg.name;
                                };


                                this.getSelectedItems = function ()
                                {
                                    return _selection;
                                };

                                /**
                                 * Retrieve the current text entered by the user
                                 */
                                this.getRawValue = function () {
                                    return ms.input.val() !== cfg.emptyText ? ms.input.val() : '';
                                };

                                /**
                                 * Retrieve an array of selected values
                                 */
                                this.getValue = function ()
                                {
                                    return $.map(_selection, function (o) {
                                        return o[cfg.valueField];
                                    });
                                };

                                /**
                                 * Remove one or multiples json items from the current selection
                                 * @param items - json object or array of json objects
                                 * @param isSilent - (optional) set to true to suppress 'selectionchange' event from being triggered
                                 */
                                this.removeFromSelection = function (items, isSilent)
                                {
                                    if (!$.isArray(items)) {
                                        items = [items];
                                    }
                                    var valuechanged = false;
                                    $.each(items, function (index, json) {
                                        var i = $.inArray(json[cfg.valueField], ms.getValue());
                                        if (i > -1) {
                                            _selection.splice(i, 1);
                                            valuechanged = true;
                                        }
                                    });
                                    if (valuechanged === true) {
                                        self._renderSelection();
                                        if (isSilent !== true) {
                                            $(this).trigger('selectionchange', [this, this.getSelectedItems()]);
                                        }
                                        if (cfg.expandOnFocus) {
                                            ms.expand();
                                        }
                                        if (cfg.expanded) {
                                            self._processSuggestions();
                                        }
                                    }
                                };

                                /**
                                 * Set up some combo data after it has been rendered
                                 * @param data
                                 */
                                this.setData = function (data) {
                                    cfg.data = data;
                                    self._processSuggestions();
                                };

                                /**
                                 * Sets the name for the input field so it can be fetched in the form
                                 * @param name
                                 */
                                this.setName = function (name) {
                                    cfg.name = name;
                                    if (ms._valueContainer) {
                                        ms._valueContainer.name = name;
                                    }
                                };

                                /**
                                 * Sets a value for the combo box. Value must be a value or an array of value with data type matching valueField one.
                                 * @param data
                                 */
                                this.setValue = function (data)
                                {
                                    var values = data, items = [];
                                    if (!$.isArray(data)) {
                                        if (typeof (data) === 'string') {
                                            if (data.indexOf('[') > -1) {
                                                values = eval(data);
                                            } else if (data.indexOf(',') > -1) {
                                                values = data.split(',');
                                            }
                                        } else {
                                            values = [data];
                                        }
                                    }

                                    $.each(_cbData, function (index, obj) {
                                        if ($.inArray(obj[cfg.valueField], values) > -1) {
                                            items.push(obj);
                                        }
                                    });
                                    if (items.length > 0) {
                                        this.addToSelection(items);
                                    }
                                };

                                /**
                                 * Sets data params for subsequent ajax requests
                                 * @param params
                                 */
                                this.setDataUrlParams = function (params)
                                {
                                    cfg.dataUrlParams = $.extend({}, params);
                                };

                                /**********  PRIVATE ************/
                                var _selection = [], // selected objects
                                        _comboItemHeight = 0, // height for each combo item.
                                        _timer,
                                        _hasFocus = false,
                                        _groups = null,
                                        _cbData = [],
                                        _ctrlDown = false;

                                var self = {
                                    /**
                                     * Empties the result container and refills it with the array of json results in input
                                     * @private
                                     */
                                    _displaySuggestions: function (data) {
                                        ms.combobox.empty();

                                        var resHeight = 0, // total height taken by displayed results.
                                                nbGroups = 0;

                                        if (_groups === null) {
                                            self._renderComboItems(data);
                                            resHeight = _comboItemHeight * data.length;
                                        }
                                        else {
                                            for (var grpName in _groups) {
                                                nbGroups += 1;
                                                $('<div/>', {
                                                    'class': 'tag-res-group',
                                                    html: grpName
                                                }).appendTo(ms.combobox);
                                                self._renderComboItems(_groups[grpName].items, true);
                                            }
                                            resHeight = _comboItemHeight * (data.length + nbGroups);
                                        }

                                        if (resHeight < ms.combobox.height() || resHeight <= cfg.maxDropHeight) {
                                            ms.combobox.height(resHeight);
                                        }
                                        else if (resHeight >= ms.combobox.height() && resHeight > cfg.maxDropHeight) {
                                            ms.combobox.height(cfg.maxDropHeight);
                                        }

                                        if (data.length === 1 && cfg.preselectSingleSuggestion === true) {
                                            ms.combobox.children().filter(':last').addClass('tag-res-item-active');
                                        }

                                        if (data.length === 0 && ms.getRawValue() !== "") {
                                            self._updateHelper(cfg.noSuggestionText);
                                            ms.collapse();
                                        }
                                    },
                                    /**
                                     * Returns an array of json objects from an array of strings.
                                     * @private
                                     */
                                    _getEntriesFromStringArray: function (data) {
                                        var json = [];
                                        $.each(data, function (index, s) {
                                            var entry = {};
                                            entry[cfg.displayField] = entry[cfg.valueField] = $.trim(s);
                                            json.push(entry);
                                        });
                                        return json;
                                    },
                                    /**
                                     * Replaces html with highlighted html according to case
                                     * @param html
                                     * @private
                                     */
                                    _highlightSuggestion: function (html) {
                                        var q = ms.input.val() !== cfg.emptyText ? ms.input.val() : '';
                                        if (q.length === 0) {
                                            return html; // nothing entered as input
                                        }

                                        if (cfg.matchCase === true) {
                                            html = html.replace(new RegExp('(' + q + ')(?!([^<]+)?>)', 'g'), '<em>$1</em>');
                                        }
                                        else {
                                            html = html.replace(new RegExp('(' + q + ')(?!([^<]+)?>)', 'gi'), '<em>$1</em>');
                                        }
                                        return html;
                                    },
                                    /**
                                     * Moves the selected cursor amongst the list item
                                     * @param dir - 'up' or 'down'
                                     * @private
                                     */
                                    _moveSelectedRow: function (dir) {
                                        if (!cfg.expanded) {
                                            ms.expand();
                                        }
                                        var list, start, active, scrollPos;
                                        list = ms.combobox.find(".tag-res-item");
                                        if (dir === 'down') {
                                            start = list.eq(0);
                                        }
                                        else {
                                            start = list.filter(':last');
                                        }
                                        active = ms.combobox.find('.tag-res-item-active:first');
                                        if (active.length > 0) {
                                            if (dir === 'down') {
                                                start = active.nextAll('.tag-res-item').first();
                                                if (start.length === 0) {
                                                    start = list.eq(0);
                                                }
                                                scrollPos = ms.combobox.scrollTop();
                                                ms.combobox.scrollTop(0);
                                                if (start[0].offsetTop + start.outerHeight() > ms.combobox.height()) {
                                                    ms.combobox.scrollTop(scrollPos + _comboItemHeight);
                                                }
                                            }
                                            else {
                                                start = active.prevAll('.tag-res-item').first();
                                                if (start.length === 0) {
                                                    start = list.filter(':last');
                                                    ms.combobox.scrollTop(_comboItemHeight * list.length);
                                                }
                                                if (start[0].offsetTop < ms.combobox.scrollTop()) {
                                                    ms.combobox.scrollTop(ms.combobox.scrollTop() - _comboItemHeight);
                                                }
                                            }
                                        }
                                        list.removeClass("tag-res-item-active");
                                        start.addClass("tag-res-item-active");
                                    },
                                    /**
                                     * According to given data and query, sort and add suggestions in their container
                                     * @private
                                     */
                                    _processSuggestions: function (source) {
                                        var json = null, data = source || cfg.data;
                                        if (data !== null) {
                                            if (typeof (data) === 'function') {
                                                data = data.call(ms);
                                            }
                                            if (typeof (data) === 'string' && data.indexOf(',') < 0) { // get results from ajax
                                                $(ms).trigger('beforeload', [ms]);
                                                var params = $.extend({query: ms.input.val()}, cfg.dataUrlParams);
                                                $.ajax({
                                                    type: cfg.method,
                                                    url: data,
                                                    data: params,
                                                    success: function (asyncData) {
                                                        json = typeof (asyncData) === 'string' ? JSON.parse(asyncData) : asyncData;
                                                        self._processSuggestions(json);
                                                        $(ms).trigger('load', [ms, json]);
                                                    },
                                                    error: function () {
                                                        throw("Could not reach server");
                                                    }
                                                });
                                                return;
                                            } else if (typeof (data) === 'string' && data.indexOf(',') > -1) { // results from csv string
                                                _cbData = self._getEntriesFromStringArray(data.split(','));
                                            } else { // results from local array
                                                if (data.length > 0 && typeof (data[0]) === 'string') { // results from array of strings
                                                    _cbData = self._getEntriesFromStringArray(data);
                                                } else { // regular json array or json object with results property
                                                    _cbData = data[cfg.resultsField] || data;
                                                }
                                            }
                                            self._displaySuggestions(self._sortAndTrim(_cbData));

                                        }
                                    },
                                    /**
                                     * Render the component to the given input DOM element
                                     * @private
                                     */
                                    _render: function (el) {
                                        $(ms).trigger('beforerender', [ms]);
                                        var w = $.isFunction(cfg.width) ? cfg.width.call(el) : cfg.width;
                                        // holds the main div, will relay the focus events to the contained input element.
                                        ms.container = $('<div/>', {
                                            id: cfg.id,
                                            'class': 'tag-ctn ' + cfg.cls +
                                                    (cfg.disabled === true ? ' tag-ctn-disabled' : '') +
                                                    (cfg.editable === true ? '' : ' tag-ctn-readonly'),
                                            style: cfg.style
                                        }).width(w);
                                        ms.container.focus($.proxy(handlers._onFocus, this));
                                        ms.container.blur($.proxy(handlers._onBlur, this));
                                        ms.container.keydown($.proxy(handlers._onKeyDown, this));
                                        ms.container.keyup($.proxy(handlers._onKeyUp, this));

                                        // holds the input field
                                        ms.input = $('<input/>', $.extend({
                                            id: 'tag-input-' + $('input[id^="tag-input"]').length,
                                            type: 'text',
                                            'class': cfg.emptyTextCls + (cfg.editable === true ? '' : ' tag-input-readonly'),
                                            value: cfg.emptyText,
                                            readonly: !cfg.editable,
                                            disabled: cfg.disabled
                                        }, cfg.inputCfg)).width(w - (cfg.hideTrigger ? 16 : 42));

                                        ms.input.focus($.proxy(handlers._onInputFocus, this));
                                        ms.input.click($.proxy(handlers._onInputClick, this));

                                        // holds the trigger on the right side
                                        if (cfg.hideTrigger === false) {
                                            ms.trigger = $('<div/>', {
                                                id: 'tag-trigger-' + $('div[id^="tag-trigger"]').length,
                                                'class': 'tag-trigger',
                                                html: '<div class="tag-trigger-ico"></div>'
                                            });
                                            ms.trigger.click($.proxy(handlers._onTriggerClick, this));
                                            ms.container.append(ms.trigger);
                                        }

                                        // holds the suggestions. will always be placed on focus
                                        ms.combobox = $('<div/>', {
                                            id: 'tag-res-ctn-' + $('div[id^="tag-res-ctn"]').length,
                                            'class': 'tag-res-ctn '
                                        }).width(w).height(cfg.maxDropHeight);

                                        // bind the onclick and mouseover using delegated events (needs jQuery >= 1.7)
                                        ms.combobox.on('click', 'div.tag-res-item', $.proxy(handlers._onComboItemSelected, this));
                                        ms.combobox.on('mouseover', 'div.tag-res-item', $.proxy(handlers._onComboItemMouseOver, this));

                                        ms.selectionContainer = $('<div/>', {
                                            id: 'tag-sel-ctn-' + $('div[id^="tag-sel-ctn"]').length,
                                            'class': 'tag-sel-ctn'
                                        });
                                        ms.selectionContainer.click($.proxy(handlers._onFocus, this));

                                        if (cfg.selectionPosition === 'inner') {
                                            ms.selectionContainer.append(ms.input);
                                        }
                                        else {
                                            ms.container.append(ms.input);
                                        }

                                        ms.helper = $('<div/>', {
                                            'class': 'tag-helper ' + cfg.infoMsgCls
                                        });
                                        self._updateHelper();
                                        ms.container.append(ms.helper);


                                        // Render the whole thing
                                        $(el).replaceWith(ms.container);

                                        switch (cfg.selectionPosition) {
                                            case 'bottom':
                                                ms.selectionContainer.insertAfter(ms.container);
                                                if (cfg.selectionStacked === true) {
                                                    ms.selectionContainer.width(ms.container.width());
                                                    ms.selectionContainer.addClass('tag-stacked');
                                                }
                                                break;
                                            case 'right':
                                                ms.selectionContainer.insertAfter(ms.container);
                                                ms.container.css('float', 'left');
                                                break;
                                            default:
                                                ms.container.append(ms.selectionContainer);
                                                break;
                                        }

                                        self._processSuggestions();
                                        if (cfg.value !== null) {
                                            ms.setValue(cfg.value);
                                            self._renderSelection();
                                        }

                                        $(ms).trigger('afterrender', [ms]);
                                        $("body").click(function (e) {
                                            if (ms.container.hasClass('tag-ctn-bootstrap-focus') &&
                                                    ms.container.has(e.target).length === 0 &&
                                                    e.target.className.indexOf('tag-res-item') < 0 &&
                                                    e.target.className.indexOf('tag-close-btn') < 0 &&
                                                    ms.container[0] !== e.target) {
                                                handlers._onBlur();
                                            }
                                        });

                                        if (cfg.expanded === true) {
                                            cfg.expanded = false;
                                            ms.expand();
                                        }
                                    },
                                    _renderComboItems: function (items, isGrouped) {
                                        var ref = this, html = '';
                                        $.each(items, function (index, value) {
                                            var displayed = cfg.renderer !== null ? cfg.renderer.call(ref, value) : value[cfg.displayField];
                                            var resultItemEl = $('<div/>', {
                                                'class': 'tag-res-item ' + (isGrouped ? 'tag-res-item-grouped ' : '') +
                                                        (index % 2 === 1 && cfg.useZebraStyle === true ? 'tag-res-odd' : ''),
                                                html: cfg.highlight === true ? self._highlightSuggestion(displayed) : displayed,
                                                'data-json': JSON.stringify(value)
                                            });
                                            resultItemEl.click($.proxy(handlers._onComboItemSelected, ref));
                                            resultItemEl.mouseover($.proxy(handlers._onComboItemMouseOver, ref));
                                            html += $('<div/>').append(resultItemEl).html();
                                        });
                                        ms.combobox.append(html);
                                        _comboItemHeight = ms.combobox.find('.tag-res-item:first').outerHeight();
                                    },
                                    /**
                                     * Renders the selected items into their container.
                                     * @private
                                     */
                                    _renderSelection: function () {
                                        var ref = this, w = 0, inputOffset = 0, items = [],
                                                asText = cfg.resultAsString === true && !_hasFocus;

                                        ms.selectionContainer.find('.tag-sel-item').remove();
                                        if (ms._valueContainer !== undefined) {
                                            ms._valueContainer.remove();
                                        }

                                        $.each(_selection, function (index, value) {

                                            var selectedItemEl, delItemEl,
                                                    selectedItemHtml = cfg.selectionRenderer !== null ? cfg.selectionRenderer.call(ref, value) : value[cfg.displayField];
                                            // tag representing selected value
                                            if (asText === true) {
                                                selectedItemEl = $('<div/>', {
                                                    'class': 'tag-sel-item tag-sel-text ' + cfg.selectionCls,
                                                    html: selectedItemHtml + (index === (_selection.length - 1) ? '' : ',')
                                                }).data('json', value);
                                            }
                                            else {
                                                selectedItemEl = $('<div/>', {
                                                    'class': 'tag-sel-item ' + cfg.selectionCls,
                                                    html: selectedItemHtml
                                                }).data('json', value);

                                                if (cfg.disabled === false) {
                                                    // small cross img
                                                    delItemEl = $('<span/>', {
                                                        'class': 'tag-close-btn'
                                                    }).data('json', value).appendTo(selectedItemEl);

                                                    delItemEl.click($.proxy(handlers._onTagTriggerClick, ref));
                                                }
                                            }

                                            items.push(selectedItemEl);
                                        });

                                        ms.selectionContainer.prepend(items);
                                        ms._valueContainer = $('<input/>', {
                                            type: 'hidden',
                                            name: cfg.name,
                                            value: JSON.stringify(ms.getValue())
                                        });
                                        ms._valueContainer.appendTo(ms.selectionContainer);

                                        if (cfg.selectionPosition === 'inner') {
                                            ms.input.width(0);
                                            inputOffset = ms.input.offset().left - ms.selectionContainer.offset().left;
                                            w = ms.container.width() - inputOffset - 42;
                                            ms.input.width(w);
                                            ms.container.height(ms.selectionContainer.height());
                                        }

                                        if (_selection.length === cfg.maxSelection) {
                                            self._updateHelper(cfg.maxSelectionRenderer.call(this, _selection.length));
                                        } else {
                                            ms.helper.hide();
                                        }
                                    },
                                    /**
                                     * Select an item either through keyboard or mouse
                                     * @param item
                                     * @private
                                     */
                                    _selectItem: function (item) {
                                        if (cfg.maxSelection === 1) {
                                            _selection = [];
                                        }
                                        ms.addToSelection(item.data('json'));
                                        item.removeClass('tag-res-item-active');
                                        if (cfg.expandOnFocus === false || _selection.length === cfg.maxSelection) {
                                            ms.collapse();
                                        }
                                        if (!_hasFocus) {
                                            ms.input.focus();
                                        } else if (_hasFocus && (cfg.expandOnFocus || _ctrlDown)) {
                                            self._processSuggestions();
                                            if (_ctrlDown) {
                                                ms.expand();
                                            }
                                        }
                                    },
                                    /**
                                     * Sorts the results and cut them down to max # of displayed results at once
                                     * @private
                                     */
                                    _sortAndTrim: function (data) {
                                        var q = ms.getRawValue(),
                                                filtered = [],
                                                newSuggestions = [],
                                                selectedValues = ms.getValue();
                                        // filter the data according to given input
                                        if (q.length > 0) {
                                            $.each(data, function (index, obj) {
                                                var name = obj[cfg.displayField];
                                                if ((cfg.matchCase === true && name.indexOf(q) > -1) ||
                                                        (cfg.matchCase === false && name.toLowerCase().indexOf(q.toLowerCase()) > -1)) {
                                                    if (cfg.strictSuggest === false || name.toLowerCase().indexOf(q.toLowerCase()) === 0) {
                                                        filtered.push(obj);
                                                    }
                                                }
                                            });
                                        }
                                        else {
                                            filtered = data;
                                        }
                                        // take out the ones that have already been selected
                                        $.each(filtered, function (index, obj) {
                                            if ($.inArray(obj[cfg.valueField], selectedValues) === -1) {
                                                newSuggestions.push(obj);
                                            }
                                        });
                                        // sort the data
                                        if (cfg.sortOrder !== null) {
                                            newSuggestions.sort(function (a, b) {
                                                if (a[cfg.sortOrder] < b[cfg.sortOrder]) {
                                                    return cfg.sortDir === 'asc' ? -1 : 1;
                                                }
                                                if (a[cfg.sortOrder] > b[cfg.sortOrder]) {
                                                    return cfg.sortDir === 'asc' ? 1 : -1;
                                                }
                                                return 0;
                                            });
                                        }
                                        // trim it down
                                        if (cfg.maxSuggestions && cfg.maxSuggestions > 0) {
                                            newSuggestions = newSuggestions.slice(0, cfg.maxSuggestions);
                                        }
                                        // build groups
                                        if (cfg.groupBy !== null) {
                                            _groups = {};
                                            $.each(newSuggestions, function (index, value) {
                                                if (_groups[value[cfg.groupBy]] === undefined) {
                                                    _groups[value[cfg.groupBy]] = {title: value[cfg.groupBy], items: [value]};
                                                }
                                                else {
                                                    _groups[value[cfg.groupBy]].items.push(value);
                                                }
                                            });
                                        }
                                        return newSuggestions;
                                    },
                                    /**
                                     * Update the helper text
                                     * @private
                                     */
                                    _updateHelper: function (html) {
                                        ms.helper.html(html);
                                        if (!ms.helper.is(":visible")) {
                                            ms.helper.fadeIn();
                                        }
                                    }
                                };

                                var handlers = {
                                    /**
                                     * Triggered when blurring out of the component
                                     * @private
                                     */
                                    _onBlur: function () {
                                        ms.container.removeClass('tag-ctn-bootstrap-focus');
                                        ms.collapse();
                                        _hasFocus = false;
                                        if (ms.getRawValue() !== '' && cfg.allowFreeEntries === true) {
                                            var obj = {};
                                            obj[cfg.displayField] = obj[cfg.valueField] = ms.getRawValue();
                                            ms.addToSelection(obj);
                                        }
                                        self._renderSelection();

                                        if (ms.isValid() === false) {
                                            ms.container.addClass('tag-ctn-invalid');
                                        }

                                        if (ms.input.val() === '' && _selection.length === 0) {
                                            ms.input.addClass(cfg.emptyTextCls);
                                            ms.input.val(cfg.emptyText);
                                        }
                                        else if (ms.input.val() !== '' && cfg.allowFreeEntries === false) {
                                            ms.empty();
                                            self._updateHelper('');
                                        }

                                        if (ms.input.is(":focus")) {
                                            $(ms).trigger('blur', [ms]);
                                        }
                                    },
                                    /**
                                     * Triggered when hovering an element in the combo
                                     * @param e
                                     * @private
                                     */
                                    _onComboItemMouseOver: function (e) {
                                        ms.combobox.children().removeClass('tag-res-item-active');
                                        $(e.currentTarget).addClass('tag-res-item-active');
                                    },
                                    /**
                                     * Triggered when an item is chosen from the list
                                     * @param e
                                     * @private
                                     */
                                    _onComboItemSelected: function (e) {
                                        self._selectItem($(e.currentTarget));
                                    },
                                    /**
                                     * Triggered when focusing on the container div. Will focus on the input field instead.
                                     * @private
                                     */
                                    _onFocus: function () {
                                        ms.input.focus();
                                    },
                                    /**
                                     * Triggered when clicking on the input text field
                                     * @private
                                     */
                                    _onInputClick: function () {
                                        if (ms.isDisabled() === false && _hasFocus) {
                                            if (cfg.toggleOnClick === true) {
                                                if (cfg.expanded) {
                                                    ms.collapse();
                                                } else {
                                                    ms.expand();
                                                }
                                            }
                                        }
                                    },
                                    /**
                                     * Triggered when focusing on the input text field.
                                     * @private
                                     */
                                    _onInputFocus: function () {
                                        if (ms.isDisabled() === false && !_hasFocus) {
                                            _hasFocus = true;
                                            ms.container.addClass('tag-ctn-bootstrap-focus');
                                            ms.container.removeClass(cfg.invalidCls);

                                            if (ms.input.val() === cfg.emptyText) {
                                                ms.empty();
                                            }

                                            var curLength = ms.getRawValue().length;
                                            if (cfg.expandOnFocus === true) {
                                                ms.expand();
                                            }

                                            if (_selection.length === cfg.maxSelection) {
                                                self._updateHelper(cfg.maxSelectionRenderer.call(this, _selection.length));
                                            } else if (curLength < cfg.minChars) {
                                                self._updateHelper(cfg.minCharsRenderer.call(this, cfg.minChars - curLength));
                                            }

                                            self._renderSelection();
                                            $(ms).trigger('focus', [ms]);
                                        }
                                    },
                                    _onKeyDown: function (e) {
                                        // check how tab should be handled
                                        var active = ms.combobox.find('.tag-res-item-active:first'),
                                                freeInput = ms.input.val() !== cfg.emptyText ? ms.input.val() : '';
                                        $(ms).trigger('keydown', [ms, e]);

                                        if (e.keyCode === 9 && (cfg.useTabKey === false ||
                                                (cfg.useTabKey === true && active.length === 0 && ms.input.val().length === 0))) {
                                            handlers._onBlur();
                                            return;
                                        }
                                        switch (e.keyCode) {
                                            case 8: //backspace
                                                if (freeInput.length === 0 && ms.getSelectedItems().length > 0 && cfg.selectionPosition === 'inner') {
                                                    _selection.pop();
                                                    self._renderSelection();
                                                    $(ms).trigger('selectionchange', [ms, ms.getSelectedItems()]);
                                                    ms.input.focus();
                                                    e.preventDefault();
                                                }
                                                break;
                                            case 9: // tab
                                            case 188: // esc
                                            case 13: // enter
                                                e.preventDefault();
                                                break;
                                            case 17: // ctrl
                                                _ctrlDown = true;
                                                break;
                                            case 40: // down
                                                e.preventDefault();
                                                self._moveSelectedRow("down");
                                                break;
                                            case 38: // up
                                                e.preventDefault();
                                                self._moveSelectedRow("up");
                                                break;
                                            default:
                                                if (_selection.length === cfg.maxSelection) {
                                                    e.preventDefault();
                                                }
                                                break;
                                        }
                                    },
                                    /**
                                     * Triggered when a key is released while the component has focus
                                     * @param e
                                     * @private
                                     */
                                    _onKeyUp: function (e) {
                                        var freeInput = ms.getRawValue(),
                                                inputValid = $.trim(ms.input.val()).length > 0 && ms.input.val() !== cfg.emptyText &&
                                                (!cfg.maxEntryLength || $.trim(ms.input.val()).length <= cfg.maxEntryLength),
                                                selected,
                                                obj = {};

                                        $(ms).trigger('keyup', [ms, e]);

                                        clearTimeout(_timer);

                                        // collapse if escape, but keep focus.
                                        if (e.keyCode === 27 && cfg.expanded) {
                                            ms.combobox.height(0);
                                        }
                                        // ignore a bunch of keys
                                        if ((e.keyCode === 9 && cfg.useTabKey === false) || (e.keyCode > 13 && e.keyCode < 32)) {
                                            if (e.keyCode === 17) {
                                                _ctrlDown = false;
                                            }
                                            return;
                                        }
                                        switch (e.keyCode) {
                                            case 40:
                                            case 38: // up, down
                                                e.preventDefault();
                                                break;
                                            case 13:
                                            case 9:
                                            case 188:// enter, tab, comma
                                                if (e.keyCode !== 188 || cfg.useCommaKey === true) {
                                                    e.preventDefault();
                                                    if (cfg.expanded === true) { // if a selection is performed, select it and reset field
                                                        selected = ms.combobox.find('.tag-res-item-active:first');
                                                        if (selected.length > 0) {
                                                            self._selectItem(selected);
                                                            return;
                                                        }
                                                    }
                                                    // if no selection or if freetext entered and free entries allowed, add new obj to selection
                                                    if (inputValid === true && cfg.allowFreeEntries === true) {
                                                        obj[cfg.displayField] = obj[cfg.valueField] = freeInput;
                                                        ms.addToSelection(obj);
                                                        ms.collapse(); // reset combo suggestions
                                                        ms.input.focus();
                                                    }
                                                    break;
                                                }
                                            default:
                                                if (_selection.length === cfg.maxSelection) {
                                                    self._updateHelper(cfg.maxSelectionRenderer.call(this, _selection.length));
                                                }
                                                else {
                                                    if (freeInput.length < cfg.minChars) {
                                                        self._updateHelper(cfg.minCharsRenderer.call(this, cfg.minChars - freeInput.length));
                                                        if (cfg.expanded === true) {
                                                            ms.collapse();
                                                        }
                                                    }
                                                    else if (cfg.maxEntryLength && freeInput.length > cfg.maxEntryLength) {
                                                        self._updateHelper(cfg.maxEntryRenderer.call(this, freeInput.length - cfg.maxEntryLength));
                                                        if (cfg.expanded === true) {
                                                            ms.collapse();
                                                        }
                                                    }
                                                    else {
                                                        ms.helper.hide();
                                                        if (cfg.minChars <= freeInput.length) {
                                                            _timer = setTimeout(function () {
                                                                if (cfg.expanded === true) {
                                                                    self._processSuggestions();
                                                                } else {
                                                                    ms.expand();
                                                                }
                                                            }, cfg.typeDelay);
                                                        }
                                                    }
                                                }
                                                break;
                                        }
                                    },
                                    /**
                                     * Triggered when clicking upon cross for deletion
                                     * @param e
                                     * @private
                                     */
                                    _onTagTriggerClick: function (e) {
                                        ms.removeFromSelection($(e.currentTarget).data('json'));
                                    },
                                    /**
                                     * Triggered when clicking on the small trigger in the right
                                     * @private
                                     */
                                    _onTriggerClick: function () {
                                        if (ms.isDisabled() === false && !(cfg.expandOnFocus === true && _selection.length === cfg.maxSelection)) {
                                            $(ms).trigger('triggerclick', [ms]);
                                            if (cfg.expanded === true) {
                                                ms.collapse();
                                            } else {
                                                var curLength = ms.getRawValue().length;
                                                if (curLength >= cfg.minChars) {
                                                    ms.input.focus();
                                                    ms.expand();
                                                } else {
                                                    self._updateHelper(cfg.minCharsRenderer.call(this, cfg.minChars - curLength));
                                                }
                                            }
                                        }
                                    }
                                };

                                // startup point
                                if (element !== null) {
                                    self._render(element);
                                }
                            };

                            $.fn.tagSuggest = function (options) {
                                var obj = $(this);

                                if (obj.size() === 1 && obj.data('tagSuggest')) {
                                    return obj.data('tagSuggest');
                                }

                                obj.each(function (i) {
                                    // assume $(this) is an element
                                    var cntr = $(this);

                                    // Return early if this element already has a plugin instance
                                    if (cntr.data('tagSuggest')) {
                                        return;
                                    }

                                    if (this.nodeName.toLowerCase() === 'select') { // rendering from select
                                        options.data = [];
                                        options.value = [];
                                        options.data.push({id: 1, name: 'ABC'});
                                        $.each(this.children, function (index, child) {
                                            if (child.nodeName && child.nodeName.toLowerCase() === 'option') {
                                                options.data.push({id: child.value, name: child.text});
                                                options.data.push({id: 1, name: 'ABC'});
                                                if (child.selected) {
                                                    options.value.push(child.value);
                                                }
                                            }
                                        });

                                    }

                                    var def = {};
                                    // set values from DOM container element
                                    $.each(this.attributes, function (i, att) {
                                        def[att.name] = att.value;
                                    });
                                    var field = new TagSuggest(this, $.extend(options, def));
                                    cntr.data('tagSuggest', field);
                                    field.container.data('tagSuggest', field);
                                });

                                if (obj.size() === 1) {
                                    return obj.data('tagSuggest');
                                }
                                return obj;
                            };
                        })(jQuery);


                        $(document).ready(function () {

                            var jsonData = [];
                            $.ajax({
                                url: "<?php echo base_url() ?>managementcontroller/get_fse_type",
                                type: 'post',
                                dataType: 'json',
                                success: function (res) {
                                    jsonData = res;
                                    var ms1 = $('#ms1').tagSuggest({
                                        data: jsonData,
                                        sortOrder: 'name',
                                        maxDropHeight: 200,
                                        name: 'ms1',
                                        value: '<?php echo $result[0]['fse_list'] ?>'

                                    });
                                }
                            });
                        });

</script>

<style>
    .tag-ctn{
        position: relative;
        height: 28px;
        padding: 0;
        margin-bottom: 0px;
        font-size: 14px;
        line-height: 20px;
        color: #555555;
        -webkit-border-radius: 3px;
        -moz-border-radius: 3px;
        border-radius: 3px;
        background-color: #ffffff;
        border: 1px solid #cccccc;
        -webkit-box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075);
        -moz-box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075);
        box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075);
        -webkit-transition: border linear 0.2s, box-shadow linear 0.2s;
        -moz-transition: border linear 0.2s, box-shadow linear 0.2s;
        -o-transition: border linear 0.2s, box-shadow linear 0.2s;
        transition: border linear 0.2s, box-shadow linear 0.2s;
        cursor: default;
        display: block;
    }
    .tag-ctn-invalid{
        border: 1px solid #CC0000;
    }
    .tag-ctn-readonly{
        cursor: pointer;
    }
    .tag-ctn-disabled{
        cursor: not-allowed;
        background-color: #eeeeee;
    }
    .tag-ctn-bootstrap-focus,
    .tag-ctn-bootstrap-focus .tag-res-ctn{
        border-color: rgba(82, 168, 236, 0.8) !important;
        /* IE6-9 */
        -webkit-box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075), 0 0 8px rgba(82, 168, 236, 0.6) !important;
        -moz-box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075), 0 0 8px rgba(82, 168, 236, 0.6) !important;
        box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075), 0 0 8px rgba(82, 168, 236, 0.6) !important;
        border-bottom-left-radius: 0;
        border-bottom-right-radius: 0;
    }
    .tag-ctn input{
        border: 0;
        box-shadow: none;
        -webkit-transition: none;
        outline: none;
        display: block;
        padding: 4px 6px;
        line-height: normal;
        overflow: hidden;
        height: auto;
        border-radius: 0;
        float: left;
        margin: 2px 0 2px 2px;
    }
    .tag-ctn-disabled input{
        cursor: not-allowed;
        background-color: #eeeeee;
    }
    .tag-ctn .tag-input-readonly{
        cursor: pointer;
    }
    .tag-ctn .tag-empty-text{
        color: #DDD;
    }
    .tag-ctn input:focus{
        border: 0;
        box-shadow: none;
        -webkit-transition: none;
        background: #FFF;
    }
    .tag-ctn .tag-trigger{
        float: right;
        width: 27px;
        height:100%;
        position:absolute;
        right:0;
        border-left: 1px solid #CCC;
        background: #EEE;
        cursor: pointer;
    }
    .tag-ctn .tag-trigger .tag-trigger-ico {
        display: inline-block;
        width: 0;
        height: 0;
        vertical-align: top;
        border-top: 4px solid gray;
        border-right: 4px solid transparent;
        border-left: 4px solid transparent;
        content: "";
        margin-left: 9px;
        margin-top: 13px;
    }
    .tag-ctn .tag-trigger:hover{
        background: -moz-linear-gradient(100% 100% 90deg, #e3e3e3, #f1f1f1);
        background: -webkit-gradient(linear, 0% 0%, 0% 100%, from(#f1f1f1), to(#e3e3e3));
    }
    .tag-ctn .tag-trigger:hover .tag-trigger-ico{
        background-position: 0 -4px;
    }
    .tag-ctn-disabled .tag-trigger{
        cursor: not-allowed;
        background-color: #eeeeee;
    }
    .tag-ctn-bootstrap-focus{
        border-bottom: 1px solid #CCC;
    }
    .tag-res-ctn{
        position: relative;
        background: #FFF;
        overflow-y: auto;
        z-index: 9999;
        -webkit-border-radius: 3px;
        -moz-border-radius: 3px;
        border-radius: 3px;
        border: 1px solid #CCC;
        left: -1px;
        -webkit-box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075);
        -moz-box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075);
        box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075);
        -webkit-transition: border linear 0.2s, box-shadow linear 0.2s;
        -moz-transition: border linear 0.2s, box-shadow linear 0.2s;
        -o-transition: border linear 0.2s, box-shadow linear 0.2s;
        transition: border linear 0.2s, box-shadow linear 0.2s;
        border-top: 0;
        border-top-left-radius: 0;
        border-top-right-radius: 0;
    }
    .tag-res-ctn .tag-res-group{
        line-height: 23px;
        text-align: left;
        padding: 2px 5px;
        font-weight: bold;
        border-bottom: 1px dotted #CCC;
        border-top: 1px solid #CCC;
        background: #f3edff;
        color: #333;
    }
    .tag-res-ctn .tag-res-item{
        line-height: 25px;
        text-align: left;
        padding: 2px 5px;
        color: #666;
        cursor: pointer;
    }
    .tag-res-ctn .tag-res-item-grouped{
        padding-left: 15px;
    }
    .tag-res-ctn .tag-res-odd{
        background: #F3F3F3;
    }
    .tag-res-ctn .tag-res-item-active{
        background-color: #3875D7;
        filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#3875D7', endColorstr='#2A62BC', GradientType=0 );
        background-image: -webkit-gradient(linear, 0 0, 0 100%, color-stop(20%, #3875D7), color-stop(90%, #2A62BC));
        background-image: -webkit-linear-gradient(top, #3875D7 20%, #2A62BC 90%);
        background-image: -moz-linear-gradient(top, #3875D7 20%, #2A62BC 90%);
        background-image: -o-linear-gradient(top, #3875D7 20%, #2A62BC 90%);
        background-image: linear-gradient(#3875D7 20%, #2A62BC 90%);
        color: #fff;
    }
    .tag-sel-ctn{
        overflow: auto;
        line-height: 22px;
        padding-right:27px;
    }
    .tag-sel-ctn .tag-sel-item{
        background: #555;
        color: #EEE;
        float: left;
        font-size: 12px;
        padding: 0 5px;
        border-radius: 3px;
        margin-left: 5px;
        margin-top: 4px;
    }
    .tag-sel-ctn .tag-sel-text{
        background: #FFF;
        color: #666;
        padding-right: 0;
        margin-left: 0;
        font-size: 14px;
        font-weight: normal;
    }
    .tag-res-ctn .tag-res-item em{
        font-style: normal;
        background: #565656;
        color: #FFF;
    }
    .tag-sel-ctn .tag-sel-item:hover{
        background: #565656;
    }
    .tag-sel-ctn .tag-sel-text:hover{
        background: #FFF;
    }
    .tag-sel-ctn .tag-sel-item-active{
        border: 1px solid red;
        background: #757575;
    }
    .tag-ctn .tag-sel-ctn .tag-sel-item{
        margin-top: 3px;
    }
    .tag-stacked .tag-sel-item{
        float: inherit;
    }
    .tag-sel-ctn .tag-sel-item .tag-close-btn{
        width: 7px;
        cursor: pointer;
        height: 7px;
        float: right;
        margin: 8px 2px 0 10px;
        background-image: url(data:image/png;base64,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);

    }
    .tag-sel-ctn .tag-sel-item .tag-close-btn:hover{
        background-position: 0 -7px;
    }
    .tag-helper{
        color: #AAA;
        font-size: 10px;
        position: absolute;
        top: -17px;
        right: 0;
    }

</style>
