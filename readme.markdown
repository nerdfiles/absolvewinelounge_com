# absolvewinelounge.com

## Analytics

See https://segment.com/nerdfiles/absolvewinelounge.com/ that facilitates:

1. Google Analytics
2. Mixpanel
3. GoSquared

### Google Analytics

    <script>
      (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
      (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
      m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
      })(window,document,'script','//www.google-analytics.com/analytics.js','ga');
      ga('create', 'UA-56505657-1', 'auto');
      ga('send', 'pageview');
    </script>

## TODO

1. Use Yeoman and generator-wp-grunted-theme[1] to generate SCSS, HTML, and  
   JS tailored WP templates.
2. (Probably will be essential to convert to CoffeeScript.)
3. Set up Gruntfile for faster development.
4. nodeenv?
5. Generate tagged design comps via git@github.com:MuMed/illustrator_export.git
6. https://github.com/MuMed/illustrator-scripts-for-mobile and other design  
   comp device responses

-
[1]: https://github.com/danielauener/
