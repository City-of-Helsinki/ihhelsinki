@php
  $footer_img = wp_get_attachment_image_url( get_theme_mod( 'ihh_footer_image' ), 'full' )
@endphp

<footer class="footer container-wide">
  {{--  <img src="@asset('images/footer.jpg')" alt="">--}}

  @if($footer_img)
    <img src="{{ $footer_img }}" alt="">
  @endif

  <div class="container">
    <div class="footer-content">
      <div class="footer-content-some hide-on-mobile">
        <img src="@asset('images/ihh_logo_black.png')" alt="International House Helsinki" class="footer-logo">

        <ul class="some-icons">
          <li><a class="no-blank-icon" href="https://twitter.com/ihhelsinki/" target="_blank"><i aria-hidden="true" class="fa fa-twitter"></i><span class="ihh-visually-hidden">External content: Twitter page for Internal House Helsinki</span></a></li>
          <li><a class="no-blank-icon" href="https://www.youtube.com/channel/UCnJcLjsyMaXh1RA0vZi4V0A" target="_blank"><i aria-hidden="true" class="fa fa-youtube"></i><span class="ihh-visually-hidden">External content: Youtube page for Internal House Helsinki</span></a></li>
          <li><a class="no-blank-icon" href="https://www.facebook.com/ihhelsinki/" target="_blank"><i aria-hidden="true" class="fa fa-facebook-official"></i><span class="ihh-visually-hidden">External content: Facebook page for Internal House Helsinki</span></a></li>
        </ul>
      </div>

      <div class="footer-content-info">
        {!! apply_filters('the_content', get_theme_mod('ihh_footer_text'))!!}
      </div>

      <div class="footer-content-contact">
        {!! apply_filters('the_content', get_theme_mod('ihh_footer_contact'))!!}
      </div>

      <div class="footer-content-some hide-on-desktop">
        <img src="@asset('images/ihh_logo_black.png')" alt="International House Helsinki" class="footer-logo">

        <ul class="some-icons">
          <li><a class="no-blank-icon" href="https://twitter.com/ihhelsinki/" target="_blank"><i aria-hidden="true" class="fa fa-twitter"></i><span class="ihh-visually-hidden">External content: Twitter page for Internal House Helsinki</span></a></li>
          <li><a class="no-blank-icon" href="https://www.youtube.com/channel/UCnJcLjsyMaXh1RA0vZi4V0A" target="_blank"><i aria-hidden="true" class="fa fa-youtube"></i><span class="ihh-visually-hidden">External content: Youtube page for Internal House Helsinki</span></a></li>
          <li><a class="no-blank-icon" href="https://www.facebook.com/ihhelsinki/" target="_blank"><i aria-hidden="true" class="fa fa-facebook-official"></i><span class="ihh-visually-hidden">External content: Facebook page for Internal House Helsinki</span></a></li>
        </ul>
      </div>

    </div>
  </div>
  @php
    $misc = get_field('miscellaneous', 2);
    $token = $misc['feedbackly_oid'] ?? false;
  @endphp
  @if($token)
    <script>
      (function(){
        var s = document.createElement('script'); s.type = 'text/javascript'; s.async = true; s.defer = true; s.src = 'https://survey.feedbackly.com/dist/plugin-v4.min.js'; var e = document.getElementsByTagName('body')[0] || document.getElementsByTagName('head')[0]; e.appendChild(s); window._fblyConf={oid: '@php echo $token @endphp',pth: 'https://survey.feedbackly.com',dmn:'default'}; window.FBLY = window.FBLY || {evbuf: []}; window.FBLY.action = window.FBLY.action || function(a,b,c){window.FBLY.evbuf.push([a,b,c])}; ['addProperty', 'clearProperty', 'setLanguage', 'open', 'addMeta'].forEach(function(m){ window.FBLY[m] = window.FBLY[m] || function(a, c){window.FBLY.evbuf.push([m,a,c])} });
      })();
    </script>
  @endif

</footer>
