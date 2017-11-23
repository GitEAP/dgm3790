
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

<script type="text/javascript">
$(document).ready(function(){
// *************************** Categories Filter **************************************
    var filterForm = $('#filterForm');
    var filterFormInputs = $('#filterForm label');
    var clickedInput = $('#filterForm').find('input[id=all]');


    filterFormInputs.on("change", function (){

    if($(this).is(filterFormInputs[0])){
        clickedInput.attr("value", "userAll");
        filterForm.submit();
    } else {
         filterForm.submit();
    }
    });

// *************************** Responsive menu **************************************
    var openBtn = $('.menuBtn');
    var closeBtn = $('.closeBtn');
    var navOverlay = $('.navOverlay');

    // run test on initial page load
    checkSize();
    // run test on resize of the window
    $(window).resize(checkSize);

    //Function to the css rule
    function checkSize(){
        //when resize from tablet/desktop to mobile, keep menu close by default.
        navOverlay.css({"left": "-100000px", "width": "0%"});
        $('body').css("overflow", "visible");
        //makes width 25% if tablet or desktop
        if ($(window).width() >= 993) {
            navOverlay.css({"left": "0", "width": "100%"});
            $('body').css("overflow", "visible");
        }
        //checks if it's mobile
        if ($(window).width() < 993) {  
            //if close button is clicked, then close the menu
            closeBtn.click(function(){
                navOverlay.css({"left": "-100000px", "width": "0%"});
                $('body').css("overflow", "visible");

            });
            //if open button is clicked, then open the menu
            openBtn.click(function(){
                navOverlay.css({"left": "0", "width": "100%"});
                $('body').css("overflow", "hidden");
            });
        }
    }
});
</script>

</body>
</html>