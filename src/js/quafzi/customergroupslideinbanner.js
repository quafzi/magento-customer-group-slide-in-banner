window.addEventListener('load', function () {
  if (document.querySelector('.slidein-banner a')) {
    document.querySelector('.slidein-banner a').onclick = function (e) {
      var banner = document.querySelector('.slidein-banner')
      var content = document.querySelector('.slidein-banner .banner-content')
      if (banner.classList.contains('collapsed')) {
        banner.classList.remove('collapsed')
        content.style.display = 'block'
        content.style.height = window.innerHeight * 0.6 + 'px'
      } else {
        banner.classList.add('collapsed')
        content.style.display = 'none'
      }
      e.preventDefault()
    }
  }
})
