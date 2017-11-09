
</div><!--end container-->
</div>

<footer class="container">
    <div class="row">
        <div class="col-xs-4"><br><br>
            <div class="links" id="socialBar">
                <a href="#"><i class="fa fa-facebook-square fa-2x" aria-hidden="true"></i></a>
                <a href="#"><i class="fa fa-twitter-square fa-2x" aria-hidden="true"></i></a>
                <a href="#"><i class="fa fa-pinterest-square fa-2x" aria-hidden="true"></i></a>
                <a href="#"><i class="fa fa-instagram fa-2x" aria-hidden="true"></i></a>
            </div>
        </div>
        <div class="col-xs-4">
            <br>
            <div class="text-center">
                <p class="bigFooter">The Hat Company</p> 
                <p>&copy; 2017</p>
            </div>
        </div>
        <div class="col-xs-4">
        <br><br>
            <div class="text-center">
                <a href="manage.php">Admin</a>
            </div>
        </div>

    </div>
</footer><!-- end footer -->
         


    


<!--========SCRIPTS===============-->
<script src="slick/slick.min.js"></script>
<!--Toggle button Script-->
<script>
    $(document).ready(function(){
        $(".nav-button").click(function () {
        $(".nav-button,.primary-nav").toggleClass("open");
        });    
    });
    $(document).on('ready', function() {
      $(".regular").slick({
        dots: true,
        infinite: true,
        slidesToShow: 3,
        slidesToScroll: 3
      });
      $(".center").slick({
        dots: true,
        infinite: true,
        centerMode: true,
        slidesToShow: 3,
        slidesToScroll: 3
      });
      $(".variable").slick({
        dots: true,
        infinite: true,
        variableWidth: true
      });
    });
</script>

</body>
</html>