<script type="text/javascript">
	$(function(){

    var url = window.location.pathname, 
        urlRegExp = new RegExp(url.replace(/\/$/,'') + "$"); // create regexp to match current url pathname and remove trailing slash if present as it could collide with the link in navigation in case trailing slash wasn't present there
        // now grab every link from the navigation
        $('.nav a').each(function(){
            // and test its normalized href against the url pathname regexp
            if(urlRegExp.test(this.href.replace(/\/$/,''))){
                $(this).parent('li').parent().parent().addClass('active');
                $(this).parent('li').parent().addClass('in');
                $(this).addClass('active-menu');
            }
        });

    });

    window.setTimeout(function() {
        $("#alert").fadeTo(500, 0).slideUp(500, function(){
          $(this).remove();
      });
    }, 5000);

</script>