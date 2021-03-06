export default {
  init() {
    $('.venobox').venobox({
      spinner: 'wave',
      bgcolor: '#000',
    });

    $('#services-select').change(function (e) {
      window.location.href = e.target.value;
    })

    $('#skip-to-main').click(function(e){
      if($('#ihh-site-notification').length) {
        e.preventDefault();
        $('#ihh-site-notification').focus();
      }
    });

    $(document).ready(function(){
      $('a[target=_blank]').each(function(){
        $(this).append(' <span class="ihh-visually-hidden">opens in new tab</span>')
      });
    })
  },
  finalize() {
  },
};
