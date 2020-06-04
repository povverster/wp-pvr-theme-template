/*
 * File: loader.js
 * Project: wp-pvr-theme-template
 * File Created: Thursday, 4th June 2020 1:22:07 pm
 * Author: povverster (povverster@gmail.com)
 * GitHub: https://github.com/povverster
 * -----
 * Last Modified: Thursday, 4th June 2020 2:48:25 pm
 * Modified By: povverster (povverster@gmail.com>)
 */

function showLoader() {
  $('#loader').show();

  [].forEach.call(document.querySelectorAll('img[data-loader-src]'), function (img) {
    var dataSrc = img.getAttribute('data-loader-src');
    img.setAttribute('src', dataSrc);
    img.onload = function () {
      img.removeAttribute('data-loader-src');
    };
  });
}

function hideLoader() {
  $('#loader').hide();
}
