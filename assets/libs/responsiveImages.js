/*
 * File: responsiveImages.js
 * Project: wp-pvr-theme-template
 * File Created: Thursday, 4th June 2020 1:51:00 pm
 * Author: povverster (povverster@gmail.com)
 * -----
 * Last Modified: Thursday, 4th June 2020 2:00:53 pm
 * Modified By: povverster (povverster@gmail.com>)
 */

jQuery(function($) {
  var ra = new ResponsiveImages();
  ra.init();

  function ResponsiveImages() {
    this.window_width = 0;

    this.init = function() {
      var self = this;

      $('body [data-img-sizes]').each(function() {
        self.countSizes(self, this);
      });

      self.resizeWindow(self);

      $(window).on('resize', function() {
        self.resizeWindow(self);
      });
    };

    this.resizeWindow = function(self) {
      self.window_width = document.body.clientWidth;
      $('body [data-img-sizes]').each(function() {
        self.resizeImg(self, this);
      });
    };

    this.countSizes = function(self, el) {
      var sizes = $(el).attr('data-img-sizes');
      sizes = self.getSizes(sizes);
      if (sizes) {
        $.data(el, 'sizes', JSON.stringify(sizes));
      }
    };

    this.getSizes = function(sizes) {
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

    this.getImg = function(self, sizes) {
      var src = '';
      if (sizes[0]) {
        src = sizes[0];
      }

      var last_src = '';
      for (var i in sizes) {
        if (parseInt(i) > self.window_width) {
          src = sizes[i];
          break;
        }

        last_src = sizes[i];
      }

      if (src == '') {
        src = last_src;
      }

      return src;
    };

    this.resizeImg = function(self, el) {
      if (!el) {
        return;
      }

      var sizes = $.data(el, 'sizes');
      if (!sizes) {
        return;
      }

      var src = self.getImg(self, JSON.parse(sizes));

      var img = new Image();
      img.src = src;
      img.onload = function() {
        if ($(el)[0] && $(el)[0].tagName === 'IMG') {
          $(el).attr('src', src);
        } else {
          $(el).css('backgroundImage', 'url(' + src + ')');
        }
      };
    };
  }
});
