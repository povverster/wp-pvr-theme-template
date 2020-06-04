(function ($, window, document, undefined) {
  var pluginName = 'customForm',
    defaults = {};

  function Plugin(element, options) {
    this.element = element;
    this.options = $.extend({}, defaults, options);

    this._defaults = defaults;
    this._name = pluginName;

    this.init();
  }

  Plugin.prototype.customFile = function () {
    $(this.element).hide();
    var obj = this.element;

    $(this.element).wrap('<div class="customInputFileWrap"></div>');
    $(this.element).after('<div class="customInputFile">UPLOAD &raquo;</div><div class="customInputSignature"></div>');

    var par = $(this.element).closest('.customInputFileWrap');

    par.find('.customInputFile').on('click', function () {
      $(obj).trigger('click');
    });

    $(this.element).on('change', function () {
      par.find('.customInputSignature').text($(this.element).val());
    });
  };

  Plugin.prototype.customRadioBox = function () {
    $(this.element).css({ display: 'none' });

    if ($(this.element).attr('checked') == 'checked') {
      $(this.element).after('<div class="radio_ch"></div>');
    } else {
      $(this.element).after('<div class="radio_unch"></div>');
    }

    var obj = this.element;

    $(this.element)
      .next()
      .on('click', function () {
        $obj = $(this);
        // $(obj).trigger('click');

        if ($(obj).attr('checked') == 'checked') {
          $(obj).removeAttr('checked');
        } else {
          $(obj).attr('checked', 'checked');
        }

        var radioName = $(obj).attr('name');
        $(':radio[name=' + radioName + ']')
          .next()
          .removeClass('radio_ch')
          .addClass('radio_unch');
        $(obj).next().removeClass('radio_unch').addClass('radio_ch');
      });
  };

  Plugin.prototype.customCheckBox = function () {
    $(this.element).css({ display: 'none' });

    if ($(this.element).attr('checked') == 'checked') {
      $(this.element).after('<div class="ch_ch"></div>');
    } else {
      $(this.element).after('<div class="ch_unch"></div>');
    }

    var obj = this.element;
    $(this.element).on('click', function () {
      $(obj).next().toggleClass('ch_unch').toggleClass('ch_ch');

      if ($(obj).attr('checked') == 'checked') {
        $(obj).removeAttr('checked');
      } else {
        $(obj).attr('checked', 'checked');
      }
    });
  };

  Plugin.prototype.CustomSelect = function () {
    var $this = $(this.element);
    var numberOfOptions = $(this.element).children('option').length;

    var isDisabled = $this.attr('disabled');

    // Reinit actions
    if ($this.parent().is('.customSelect')) {
      $this.unwrap();
      $this.next('.styledSelect').remove();
      $this.next('.options').remove();
    }

    // Hides the select element
    $this.addClass('s-hidden');

    // Wrap the select element in a div
    $this.wrap('<div class="customSelect"></div>');

    // Insert a styled div to sit over the top of the hidden select element
    $this.after('<div class="styledSelect" contentEditable="true"><div class="arr"></div></div>');

    // Cache the styled div
    var $styledSelect = $this.next('div.styledSelect');
    $styledSelect.css({ caretColor: 'transparent' });
    $styledSelect.append('<div class="styledSelectInput" ></div><div class="styledSelectBtn"></div>');
    var $styledSelectInput = $styledSelect.find('.styledSelectInput');
    var $styledSelectBtn = $styledSelect.find('.styledSelectBtn');
    // Show the first select option in the styled div
    if ($this.children('option:selected').length > 0) {
      $styledSelectInput.text($this.children('option:selected').eq(0).text());
    } else {
      $styledSelectInput.text($this.children('option').eq(0).text());
    }

    if (isDisabled) {
      $styledSelect.addClass('disabled');
    }

    // Insert an unordered list after the styled div and also cache the list
    var $list = $('<ul />', {
      class: 'options'
    }).insertAfter($styledSelect);

    // Insert a list item into the unordered list for each select option
    for (var i = 0; i < numberOfOptions; i++) {
      $('<li />', {
        class: $this.children('option').eq(i).is(':selected') ? 'selected' : null,
        text: $this.children('option').eq(i).text(),
        rel: $this.children('option').eq(i).val()
      }).appendTo($list);
    }

    // Cache the list items
    var $listItems = $list.children('li');

    // Show the unordered list when the styled div is clicked (also hides it if the div is clicked again)
    $styledSelect.click(function (e) {
      $el = $(this);

      if ($this.attr('disabled') !== undefined || $this.attr('readonly') !== undefined) {
        return false;
      }

      $('.customSelect .styledSelect.active')
        .not($el)
        .each(function () {
          $(this).removeClass('active');
        });

      $('.customSelect .options.active')
        .not($el)
        .each(function () {
          $(this).removeClass('active');
        });

      if ($styledSelect.hasClass('active')) {
        $styledSelect.removeClass('active');
        $list.removeClass('active');
      } else {
        $styledSelect.addClass('active');
        $list.addClass('active');

        var $firstItem = $list.find('li:first-child');
        var $selectedItem = $list.find('li.selected');
        if ($firstItem.length && $selectedItem.length) {
          $list.animate({ scrollTop: $selectedItem.position().top - $firstItem.position().top }, 0);
        }
      }

      e.stopPropagation();
    });

    // Keyboard control
    $styledSelect.on('keydown', function (e) {
      var key;
      if (window.event) {
        key = e.keyCode;
      } else if (e.which) {
        key = e.which;
      }

      if (key >= 49 && key <= 90) {
        var char = String.fromCharCode(key);

        var regex = new RegExp('^' + char + '(.)*', ['i']);

        var $elements = $listItems.filter(function () {
          return regex.test($(this).text());
        });

        if ($elements[0]) {
          $list.animate({ scrollTop: $($listItems[0]).position().top }, 0);

          $list.animate({ scrollTop: $($elements[0]).position().top }, 0);
        }
      } else if (key === 13) {
        // enter
        if (!$styledSelect.hasClass('active')) {
          $styledSelect.addClass('active');
          $list.addClass('active');
          return false;
        }

        var $selectedItem = $list.find('li.selected');
        if ($selectedItem.length) {
          $selectedItem.trigger('click');
        }
      } else if (key === 27) {
        // escape
        if ($styledSelect.hasClass('active')) {
          $styledSelect.removeClass('active');
          $list.removeClass('active');
        }
      } else if (key === 38) {
        // arrow up
        if (!$styledSelect.hasClass('active')) {
          return false;
        }

        var $firstItem = $list.find('li:first-child');
        if (!$firstItem.length) {
          return false;
        }

        var $selectedItem = $list.find('li.selected');
        if (!$selectedItem.length) {
          $selectedItem = $list.find('li:first-child');
          if ($selectedItem.length) {
            $selectedItem.addClass('selected');
          } else {
            return false;
          }
        }

        var $prevItem = $selectedItem.prev('li');
        if (!$prevItem.length) {
          $prevItem = $list.find('li:last-child');
          if (!$prevItem.length) {
            return false;
          }
        }

        $selectedItem.removeClass('selected');
        $prevItem.addClass('selected');
        $list.animate({ scrollTop: $prevItem.position().top - $firstItem.position().top }, 0);
      } else if (key === 40) {
        // arrow down
        var $firstItem = $list.find('li:first-child');
        if (!$firstItem.length) {
          return false;
        }

        var $selectedItem = $list.find('li.selected');
        if (!$selectedItem.length) {
          $selectedItem = $list.find('li:first-child');
          if ($selectedItem.length) {
            $selectedItem.addClass('selected');
          } else {
            return false;
          }
        }

        $list.animate({ scrollTop: $selectedItem.position().top - $firstItem.position().top }, 0);

        // first open
        if (!$styledSelect.hasClass('active')) {
          $styledSelect.addClass('active');
          $list.addClass('active');
          return false;
        }

        var $nextItem = $selectedItem.next('li');
        if (!$nextItem.length) {
          $nextItem = $list.find('li:first-child');
          if (!$nextItem.length) {
            return false;
          }
        }

        $selectedItem.removeClass('selected');
        $nextItem.addClass('selected');
        $list.animate({ scrollTop: $nextItem.position().top - $firstItem.position().top }, 0);
      }

      return false;
    });

    // Hides the unordered list when a list item is clicked and updates the styled div to show the selected list item
    // Updates the select element to have the value of the equivalent option
    $listItems.click(function (e) {
      var selectValue = $this.val();
      var relValue = $(this).attr('rel');

      if (relValue === 'custom_range') {
        return false;
      }

      e.stopPropagation();
      $styledSelect.removeClass('active');
      $styledSelectInput.text($(this).text());

      if (selectValue !== relValue) {
        $this.val($(this).attr('rel')).trigger('change');
      }

      $list.removeClass('active');

      // mark selected option
      var $options = $list.find('li');
      var $selectedOption = $list.find('li[rel="' + relValue + '"]');
      if ($options) {
        $options.removeClass('selected');
      }
      if ($selectedOption) {
        $selectedOption.addClass('selected');
      }

      // $list.hide();
      // alert($this.val()); // Uncomment this for demonstration!
    });

    // Hides the unordered list when clicking outside of it
    $(document).click(function () {
      $styledSelect.removeClass('active');
      $list.removeClass('active');
    });

    // $this.trigger( "loaded" );
  };

  Plugin.prototype.init = function () {
    if ($(this.element).is('select')) {
      this.CustomSelect();
    } else if ($(this.element).attr('type') == 'checkbox') {
      this.customCheckBox();
    } else if ($(this.element).attr('type') == 'radio') {
      this.customRadioBox();
    } else if ($(this.element).is("input[type='file']")) {
      this.customFile();
    }
  };

  $.fn[pluginName] = function (options) {
    return this.each(function () {
      // if (!$.data(this, 'plugin_' + pluginName)) {
      $.data(this, 'plugin_' + pluginName, new Plugin(this, options));
      // }
    });
  };
})(jQuery, window, document);
