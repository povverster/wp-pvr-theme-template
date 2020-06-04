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
