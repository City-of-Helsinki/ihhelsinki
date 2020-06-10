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
      <div class="footer-content-some">
        <img src="@asset('images/logo_white.svg')" alt="IHH Logo" class="footer-logo">

        <ul class="some-icons">
          <li><a href="https://twitter.com/ihhelsinki/" target="_blank"><i class="fa fa-twitter"></i></a></li>
          <li><a href="https://www.youtube.com/channel/UCnJcLjsyMaXh1RA0vZi4V0A" target="_blank"><i class="fa fa-youtube"></i></a></li>
        </ul>
      </div>

      <div class="footer-content-info">
        {!! apply_filters('the_content', get_theme_mod('ihh_footer_text'))!!}
      </div>

      <div class="footer-content-contact">
        {!! apply_filters('the_content', get_theme_mod('ihh_footer_contact'))!!}
      </div>
    </div>
  </div>
</footer>