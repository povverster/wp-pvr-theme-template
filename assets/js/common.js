/*
 * File: common.js
 * Project: wp-pvr-theme-template
 * File Created: Thursday, 4th June 2020 1:21:44 pm
 * Author: povverster (povverster@gmail.com)
 * -----
 * Last Modified: Thursday, 4th June 2020 1:49:38 pm
 * Modified By: povverster (povverster@gmail.com>)
 * -----
 * Copyright 2020 - povverster
 */

function getURLParameters(paramName) {
  var sURL = window.document.URL.toString();
  if (sURL.indexOf('?') > 0) {
    var arrParams = sURL.split('?');
    var arrURLParams = arrParams[1].split('&');
    var arrParamNames = new Array(arrURLParams.length);
    var arrParamValues = new Array(arrURLParams.length);

    var i = 0;
    for (i = 0; i < arrURLParams.length; i++) {
      var sParam = arrURLParams[i].split('=');
      arrParamNames[i] = sParam[0];
      if (sParam[1] != '') arrParamValues[i] = unescape(sParam[1]);
      else arrParamValues[i] = 'No Value';
    }

    for (i = 0; i < arrURLParams.length; i++) {
      if (arrParamNames[i] == paramName) {
        return arrParamValues[i];
      }
    }

    return undefined;
  }
}

function resetValidationTips() {
  var $inputs = $(
    'input[type="text"], input[type="number"], input[type="tel"], input[type="email"], input[type="password"], textarea'
  );

  $inputs.removeClass('fe_error');
  $inputs.removeAttr('data-original-title').removeAttr('title').fltooltip('hide');

  var $customInp = $('input[type="radio"], input[type="checkbox"], select, input[name="signature"]');

  $customInp.parent().removeClass('fe_error');
  $customInp.parent().removeAttr('data-original-title').removeAttr('title').fltooltip('hide');
}

function validateForm($form) {
  resetValidationTips();

  var inputs = $form.find(
    'input[type="text"], input[type="email"], input[type="tel"], input[type="password"], textarea'
  );
  var emails = $form.find('input[type="email"]');
  var numbers = $form.find('input[type="number"]');
  var phones = $form.find('input[type="tel"]');
  var radios = $form.find('input[type="radio"]');
  var selects = $form.find('select');

  var isValid = true;

  inputs.each(function () {
    var $input = $(this);

    if ($input.prop('required') && $input.val().trim() === '') {
      $input.addClass('fe_error');

      $input
        .attr('data-original-title', 'This field is required')
        .attr('title', 'This field is required')
        .fltooltip('show');

      isValid = false;
    }
  });

  emails.each(function () {
    var $email = $(this);

    if ($email.val().trim() !== '' && $email.val().search(/^[^@]{2,}[@]{1}[^@]+[./]{1}[^@]+$/) === -1) {
      $email.addClass('fe_error');

      $email.attr('data-original-title', 'Not valid email').attr('title', 'Not valid email').fltooltip('show');

      isValid = false;
    }
  });

  numbers.each(function () {
    var $number = $(this);
    var value = $number.val();

    var min = $number.prop('min');
    var max = $number.prop('max');

    if ($number.prop('required') && value.trim() === '') {
      $number.addClass('fe_error');
      $number.attr('data-original-title', 'Not valid number').attr('title', 'Not valid number').fltooltip('show');

      isValid = false;
    } else {
      if (value.trim() !== '' && value.search(/^-?[\d]+$/) === -1 && value.search(/^-?[\d]+[,\.]?[\d]+$/) === -1) {
        $number.addClass('fe_error');
        $number.attr('data-original-title', 'Not valid number').attr('title', 'Not valid number').fltooltip('show');

        isValid = false;
      } else if (min !== undefined && parseFloat(value) < parseFloat(min)) {
        $number.addClass('fe_error');
        $number
          .attr('data-original-title', 'Min value is ' + min)
          .attr('title', 'Min value is ' + min)
          .fltooltip('show');

        isValid = false;
      } else if (max !== undefined && parseFloat(value) > parseFloat(max)) {
        $number.addClass('fe_error');
        $number
          .attr('data-original-title', 'Max value is ' + max)
          .attr('title', 'Max value is ' + max)
          .fltooltip('show');

        isValid = false;
      }
    }
  });

  phones.each(function () {
    var $phone = $(this);

    if ($phone.val().trim() !== '' && $phone.val().search(/^[)(\d\s+-]+$/) === -1) {
      $phone.addClass('fe_error');

      $phone.attr('data-original-title', 'Not valid value').attr('title', 'Not valid value').fltooltip('show');

      isValid = false;
    }
  });

  radios.each(function () {
    if ($(this).prop('required') && !$('input[name="' + this.name + '"]').is(':checked')) {
      $(this).parent().addClass('fe_error');

      $(this)
        .parent()
        .attr('data-original-title', 'This field is required')
        .attr('title', 'This field is required')
        .fltooltip('show');

      isValid = false;
    }
  });

  selects.each(function () {
    var $select = $(this);

    if (
      $select.prop('required') &&
      $select.find('option:selected').val() &&
      $select.find('option:selected').val() === '0'
    ) {
      $select.parent().addClass('fe_error');

      $select
        .parent()
        .attr('data-original-title', 'This field is required')
        .attr('title', 'This field is required')
        .fltooltip('show');

      isValid = false;
    }
  });

  return isValid;
}

function validateFormPasswords($form) {
  resetValidationTips();

  var passwords = $form.find('input[type="password"]');

  var isValid = true;

  passwords.each(function () {
    var $password = $(this);

    if ($password.val().trim() !== '' && $password.val().search(/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,}$/) === -1) {
      $password.addClass('fe_error');

      $password
        .attr('data-original-title', 'Password (UpperCase, LowerCase, Number and min 6 Chars)')
        .attr('title', 'Password (UpperCase, LowerCase, Number and min 6 Chars)')
        .fltooltip('show');

      isValid = false;
    }
  });

  return isValid;
}

function validateFormPasswordsEquality(curPasswdSel, confPasswdSel) {
  resetValidationTips();

  var curPasswd = $(curPasswdSel);
  var confPasswd = $(confPasswdSel);

  var isValid = true;

  if (curPasswd.val().trim() !== '' && curPasswd.val().trim() !== confPasswd.val().trim()) {
    curPasswd.addClass('fe_error');
    confPasswd.addClass('fe_error');

    curPasswd
      .attr('data-original-title', 'Passwords is not equal')
      .attr('title', 'Passwords is not equal')
      .fltooltip('show');

    confPasswd
      .attr('data-original-title', 'Passwords is not equal')
      .attr('title', 'Passwords is not equal')
      .fltooltip('show');

    isValid = false;
  }

  return isValid;
}

function showSuccessPopup(message, callback) {
  Swal.fire({
    html: message,
    confirmButtonColor: '#29cb97'
  }).then(function () {
    if (typeof callback === 'function') {
      callback();
    }
  });
}

function showWarningPopup(message, callback) {
  Swal.fire({
    icon: 'warning',
    html: message,
    confirmButtonColor: '#ff8033'
  }).then(function () {
    if (typeof callback === 'function') {
      callback();
    }
  });
}

function showErrorPopup(message, callback) {
  Swal.fire({
    icon: 'error',
    html: message,
    confirmButtonColor: '#f32f2f'
  }).then(function () {
    if (typeof callback === 'function') {
      callback();
    }
  });
}

function showSomethingWrongPopup(callback) {
  showErrorPopup('Something wrong.', callback);
}

function showBotSuspicionPopup(callback) {
  showWarningPopup('Suspicious activity from your IP.<br />Please try later.', callback);
}
