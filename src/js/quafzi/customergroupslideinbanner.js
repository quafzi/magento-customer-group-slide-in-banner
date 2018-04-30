window.addEventListener('load', function () {
  if (document.querySelector('.slidein-banner a')) {
    document.querySelector('.slidein-banner a').onclick = function (e) {
      var banner = document.querySelector('.slidein-banner')
      var content = document.querySelector('.slidein-banner .banner-content')
      if (banner.classList.contains('collapsed')) {
        content.style.height = '100%';
      } else {
        content.style.height = 0;
      }
      banner.classList.toggle('collapsed')
      e.preventDefault()
    }
  }
})
