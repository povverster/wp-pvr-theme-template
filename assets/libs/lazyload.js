/*
 * File: lazyload.js
 * Project: wp-pvr-theme-template
 * File Created: Thursday, 4th June 2020 1:23:46 pm
 * Author: povverster (povverster@gmail.com)
 * GitHub: https://github.com/povverster
 * -----
 * Last Modified: Thursday, 4th June 2020 2:48:25 pm
 * Modified By: povverster (povverster@gmail.com>)
 */

jQuery(document).ready(function($) {
  var LazyLoad = function() {
    this.init();
  };

  LazyLoad.prototype.init = function() {
    var self = this;

    self.show();

    $(window).on('scroll', function() {
      self.show();
    });
  };

  LazyLoad.prototype.show = function() {
    var self = this;

    var windowWidth =
      window.innerWidth ||
      document.documentElement.clientWidth ||
      document.body.clientWidth;

    [].forEach.call(document.querySelectorAll('img[data-src]'), function(img) {
      if (self.isVisible(img) && self.isScrolledTo(img)) {
        var dataSrc = img.getAttribute('data-src');
        var sizes = self.getSizes(dataSrc);

        var src = '';
        for (var i in sizes) {
          if (parseInt(i) > windowWidth) {
            break;
          }

          src = sizes[i];
        }

        img.setAttribute('src', src);
      }
    });

    [].forEach.call(document.querySelectorAll('[data-img-bg]'), function(img) {
      if (self.isVisible(img) && self.isScrolledTo(img)) {
        var dataSrc = img.getAttribute('data-img-bg');
        var sizes = self.getSizes(dataSrc);

        var src = '';
        for (var i in sizes) {
          if (parseInt(i) > windowWidth) {
            break;
          }

          src = sizes[i];
        }

        img.setAttribute('style', 'background-image: url(' + src + ')');
      }
    });
  };

  LazyLoad.prototype.isVisible = function(img) {
    return $(img).is(':visible');
  };

  LazyLoad.prototype.isScrolledTo = function(img) {
    var pageScrollTop =
      document.documentElement.scrollTop || document.body.scrollTop;

    var windowHeight =
      window.innerHeight ||
      document.documentElement.clientHeight ||
      document.body.clientHeight;

    var offset = $(img).offset();
    var offsetTop = offset && offset.top ? offset.top : null;

    return (
      offsetTop > pageScrollTop && offsetTop < pageScrollTop + windowHeight
    );
  };

  LazyLoad.prototype.getSizes = function(sizes) {
    var sizes_obj = {};
    var sizes_arr = [];
    if (sizes) {
      sizes = sizes.split(', ');

      if (sizes && sizes.length) {
        for (var i in sizes) {
          var line = sizes[i].split(' ');
          if (line && line.length > 0) {
            if (line.length > 1) {
              sizes_arr[parseInt(line[1])] = line[0];
            } else {
              sizes_arr[0] = line[0];
            }
          }
        }
      }
    }

    for (var j in sizes_arr) {
      sizes_obj[j] = sizes_arr[j];
    }

    return sizes_obj;
  };

  new LazyLoad();
});
