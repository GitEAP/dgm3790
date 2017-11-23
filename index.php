<?php
require_once('variable.php');

$dbconnect = mysqli_connect(HOST, USERNAME, PASSWORD, DATABASE) or die('connection failed');

$query = "SELECT * FROM member";

$result = mysqli_query($dbconnect, $query) or die('run query failed');

include 'head.php'; 
 
?>

<div class="row">
    <div class="col-xs-12 text-center">

        <h1>Welcome to The Hat Company</h1>

        <p class="centerText">Aesthetic dolor copper mug incididunt, officia shabby chic you probably haven't heard of them. Sriracha humblebrag pok pok ad pinterest. Shaman polaroid deep v laboris ut gluten-free kombucha synth farm-to-table enim la croix single-origin coffee. Helvetica cloud bread venmo, normcore cray brooklyn dolor butcher squid man bun salvia yuccie. Lo-fi irure qui la croix, humblebrag four dollar toast swag. Cronut culpa irony meh velit tilde 3 wolf moon austin bespoke tattooed.</p>
    </div>
</div>

<div class="row">
    <article class="col-xs-10 col-sm-6">
        <figure><img src="img/hatperson1.jpg" alt="fish"/></figure>
    </article>

    <article class="col-xs-12 col-sm-6">
        <blockquote>"       Four loko ex raclette keffiyeh mustache, ethical fixie heirloom edison bulb. Ennui tempor brunch, keytar fugiat taxidermy fam vaporware. Wolf affogato ugh master cleanse consequat, 3 wolf moon man bun before they sold out."<br>-The Swag</blockquote> 
    </article>
</div><!--end row-->

<div class="row">
    <article class="col-xs-12 col-sm-6">
        <blockquote>"Ex gentrify irure cardigan fixie dolore four dollar toast. Duis velit migas, plaid asymmetrical palo santo pitchfork irony. VHS normcore viral in, meggings before they sold out semiotics. Heirloom street art cred DIY humblebrag duis, locavore sriracha snackwave ennui four dollar toast. Aute hoodie aesthetic, fugiat man bun cornhole you probably haven't heard of them jianbing shaman farm-to-table meggings affogato poke gastropub tofu."<br>-The YOLO</blockquote> 
    </article>

    <article class="col-xs-10 col-sm-6">
        <figure class="right w50"><img src="img/hatperson2.jpg" alt="fish"/></figure>
    </article>
</div><!--end row--> 

<div class="row">
    <article class="col-xs-10 col-sm-6">
        <figure><img src="img/hatperson4.jpg" alt="fish"/></figure>
    </article>

    <article class="col-xs-12 col-sm-6">
        <blockquote>"Activated charcoal slow-carb commodo reprehenderit unicorn live-edge ipsum bushwick chillwave sustainable cred non poke farm-to-table pickled. Live-edge sartorial tousled polaroid tacos man braid hella vexillologist retro pug."<br> -Hipster</blockquote> 
    </article>
</div><!--end row-->

<div class="row">
    <article class="col-xs-12 col-sm-6">
        <blockquote>"Heirloom iceland snackwave, do ut marfa pinterest fixie dreamcatcher drinking vinegar pariatur YOLO. Anim PBR&B leggings lomo knausgaard, iPhone listicle shoreditch master cleanse letterpress keytar kitsch."<br>-Famous</blockquote> 
    </article>

    <article class="col-xs-10 col-sm-6">
        <figure class="right w50"><img src="img/hatperson3.jpg" alt="fish"/></figure>
    </article>
</div><!--end row-->

<?php include 'footer.php'; ?>
