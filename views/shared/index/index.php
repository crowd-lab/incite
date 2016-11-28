<!DOCTYPE html>
<html lang="en">
<?php
queue_css_file(array('bootstrap', 'style', 'bootstrap.min'));
$db = get_db();

include(dirname(__FILE__).'/../common/header.php');
?>

<style>
.carousel-inner {
    height: 150px;
}

.carousel-control {
    top: 20%;
}

.carousel-control.left, .carousel-control.right {
    background: none;
    color: @red;
    border: none;
}

.carousel-control.left {
    margin-left: -45px; color: black;
}

.carousel-control.right {
    margin-right: -45px; color: black;
}

@media (max-width: 748px) {
    #transcribe_itm > div, #tag_itm > div, #connect_itm > div , button.btn.btn-danger{
        font-size: 11px;
    }
    h1{
        font-size: 32px;
    }


}

@media (max-width: 590px) {
    #transcribe_itm > div, #tag_itm > div, #connect_itm > div, button.btn.btn-danger {
        font-size: 10px;
    }

    h1{
        font-size: 25px;
    }
    #transcribe_itm > div > img, #tag_itm > div > img, #connect_itm > div > img{
        height: 110px;
    }
    .all_task_item > img{
        height: 100px;

    }

}

@media (max-width: 410px) {
    #transcribe_itm > div, #tag_itm > div, #connect_itm > div, button.btn.btn-danger {
        font-size: 8px;
    }

    h1{
        font-size: 20px;
    }
    .all_task_item > img, #transcribe_itm > div > img, #tag_itm > div > img, #connect_itm > div > img{
        height: 80px;

    }

    #all_task_row > div {
        padding: 10px;
    }

}

</style>

<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.8";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>



<div id="homepage-content" style="margin-top: 25px; margin-left: 15%; margin-right:15%; margin-bottom: 25px;">
    <div id="homepage-summary" style="margin-bottom: 75px">
        <h1>Mapping the Fourth uses the power of crowdsourcing to rediscover how Independence Day was celebrated during     the Civil War era.</h1>
    </div>  <!-- homepage-summary -->
    <div id="homepage-carousel" class="carousel slide" data-ride="carousel">
        <div class="carousel-inner">
            <div class="item active">
                <div class="row" id="all_task_row">
                    <!-- <div class="col-md-offset-2"></div> -->
                    <div class ="col-md-offset-2 col-md-3 col-sm-offset-2 col-sm-3 col-xs-4"><a href=""><div class="all_task_item" style="display:inline-block; width: 33%;" data-target="#homepage-carousel" data-slide-to ="1"><img  style="max-height: 120px; margin: auto; display: block;" src="<?php echo getFullOmekaUrl(); ?>/plugins/Incite/views/shared/images/transcribe.png"></div></a></div>
                    <div class ="col-md-3 col-sm-3 col-xs-4">  <a href=""><div class="all_task_item" style="display:inline-block; width: 33%;" data-target="#homepage-carousel" data-slide-to ="2"><img style="max-height: 120px; margin: auto;   display: block;" src="<?php echo getFullOmekaUrl(); ?>/plugins/Incite/views/shared/images/tag.png"></div></a></div>
                    <div class ="col-md-3 col-sm-3 col-xs-4">  <a href=""><div  class="all_task_item" style="display:inline-block; width: 33%;" data-target="#homepage-carousel" data-slide-to ="3"><img style="max-height: 120px; margin: auto;   display: block;" src="<?php echo getFullOmekaUrl(); ?>/plugins/Incite/views/shared/images/connect.png"></div></a></div>
                </div>
            </div>
            <div class="item" id="transcribe_itm">
                <div style="display:inline-block; width: 33%; float: left;"><img style="max-height: 120px; margin: auto; display: block;" src="<?php echo getFullOmekaUrl(); ?>/plugins/Incite/views/shared/images/transcribe.png"></div>
                <div style="display:inline-block; width: 60%; position: relative;">
                    <div style="font-size: 180%;">Make historical documents more accessible and searchable.
                    </div>
                    <div style="position: absolute; top: 100px; width: 100%; margin-left: 40%;">
                        <a href="<?php echo getFullInciteUrl(); ?>/documents/contribute?task=transcribe"><button style="margin: 0 auto;" class="btn btn-danger">TRY IT NOW</button></a>
                    </div>
                </div>
            </div>
            <div class="item" id="tag_itm">
                <div style="display:inline-block; width: 33%; float: left;"><img style="max-height: 120px; margin: auto; display: block;" src="<?php echo getFullOmekaUrl(); ?>/plugins/Incite/views/shared/images/tag.png"></div>
                <div style="display:inline-block; width: 60%; position: relative;">
                    <div style="font-size: 180%;">Find people, places, organizations and events in history.
                    </div>
                    <div style="position: absolute; top: 100px; width: 100%; margin-left: 40%;">
                        <a href="<?php echo getFullInciteUrl(); ?>/documents/contribute?task=tag"><button style="margin: 0 auto;" class="btn btn-danger">TRY IT NOW</button></a>
                    </div>
                </div>
            </div>
            <div class="item" id="connect_itm">
                <div style="display:inline-block; width: 33%; float: left;"><img style="max-height: 120px; margin: auto; display: block;" src="<?php echo getFullOmekaUrl(); ?>/plugins/Incite/views/shared/images/connect.png"></div>
                <div style="display:inline-block; width: 60%; position: relative;">
                    <div style="font-size: 180%;">Connect historical documents with meaningful topics and themes.
                    </div>
                    <div style="position: absolute; top: 100px; width: 100%; margin-left: 40%;">
                        <a href="<?php echo getFullInciteUrl(); ?>/documents/contribute?task=connect"><button style="margin: 0 auto;" class="btn btn-danger">TRY IT NOW</button></a>
                    </div>
                </div>
            </div>
        </div>
        <!-- Carousel controls -->
        <a class="carousel-control left" href="#homepage-carousel" data-slide="prev" style="font-size: 450%">
            &lsaquo;
        </a>
        <a class="carousel-control right" href="#homepage-carousel" data-slide="next" style="font-size: 450%">
            &rsaquo;
        </a>
    </div> <!-- homepage-carousel -->
    <br>
    <div id="homepage-details" style="margin-top: 30px;">
        <div id="twitter-tweets" style="float: right; width:22%; margin-bottom: -250px;">
            <a href="https://twitter.com/July4CivilWar" class="twitter-follow-button" data-show-count="false">Follow @J    uly4CivilWar</a><script async src="//platform.twitter.com/widgets.js" charset="utf-8"></script>
            <a class="twitter-timeline" data-width="100%" data-height="300" data-theme="light" data-link-color="#2B7BB9    " href="https://twitter.com/July4CivilWar">Tweets by July4CivilWar</a> <script async src="//platform.twitter.com/widget    s.js" charset="utf-8"></script>
            <div style="border: 1px solid #dddddd; margin-bottom: 5px;"></div>
            <div class="fb-like" data-href="https://www.facebook.com/VCCWS/" data-width="275" data-layout="standard" da    ta-action="like" data-size="small" data-show-faces="true" data-share="true"></div>
        </div>

        <div id="homepage-introduction" style="width: 75%;">
            <h3 style="color: #8BB7C8;">WE ARE UNCOVERING AMERICAN HISTORY ONE DOCUMENT AT A TIME</h3>
            <div style="margin-left: 140px;">
                <div style="float: right; width:100%;"><p style="">The long crisis of the Civil War, stretching from the 1840s to the 1870s, forced Americans to confront difficult questions about the meaning and the boundaries of their nation. What did it mean to be an American? Who was included and excluded? Where did the nation's borders lie? Did those words "all men are created equal" apply to southerners as well as northerners, black as well as white Americans, women as well as men? How should Americans commemorate their nation's founding when that nation appeared to be falling apart? But it was on one particular day each year, July 4th, that they left the most explicit evidence of their views. In newspapers and speeches, in personal diaries and letters to their friends and family, Americans gave voice to typically unspoken beliefs about national identity.</p></div>
                <div style="max-width: 120px; float: left; margin-left: -140px;"><img src="<?php echo getFullOmekaUrl(); ?>/plugins/Incite/views/shared/images/doc-icon.jpg" style="margin-right: 20px; max-width: 120px; float: left;"></div>
                <div style="clear:both"></div>
            </div>
            <br>
            <h3 style="color: #8BB7C8;" style="clear: left;">POWERED BY INCITE</h3>
            <div style="margin-left: 140px;">
                <div style="float: right; width:100%;">
                    <p>Incite is a free, open-source tool for crowdsourced exploration of a document archive. It is a plug-in for <a href="http://www.omeka.org" target="_blank">Omeka</a>, a popular online publishing platform used by libraries, museums, and archives around the world. With Incite, users can:
                        <ul style="margin-left: -10px;">
                            <li> <b>transcribe</b> digitized documents to make them searchable;</li>
                            <li> <b>tag</b> people, locations, organizations and events with help from natural language processing tools;</li>
                            <li> <b>connect</b> documents to high-level concepts of interest; and </li>
                            <li> <b>discuss</b> their discoveries in context.</li>
                        </ul>
                    </p>
                </div>
                <div style="max-width: 120px; float: left; margin-left: -140px;"><img src="<?php echo getFullOmekaUrl(); ?>/plugins/Incite/views/shared/images/m4j-brand-icon.png" style="float: left; margin-right: 20px; max-width: 120px;"></div>
                <div style="clear:both"></div>
            </div>
        </div>   <!-- homepage-introduction -->
    </div>   <!-- homepage-details -->
</div> <!-- homepage-content -->


<script>
$(document).ready(function(){
    $('[data-toggle="popover"]').popover({ trigger: "hover" });
    var d = new Date();
    var mon = (d.getMonth()+1) < 10 ? ("0"+(d.getMonth()+1)) : (d.getMonth()+1);
    var dat = (d.getDate() < 10) ? ("0"+d.getDate()) : d.getDate();
    //var today = ''+(1830+(Math.floor(Math.random()*(1870-1830))+1))+'-'+mon+'-'+dat;
    var today = '1860-'+mon+'-'+dat;
    var d = new Date();
    d.setMonth(d.getMonth()-1);
    var a_month_ago = (d.getMonth()+1) < 10 ? ("0"+(d.getMonth()+1)) : (d.getMonth()+1);
    var start_year = d.getFullYear();
    d = new Date();
    var a_month_after = (d.getMonth()+2) < 10 ? ("0"+(d.getMonth()+2)) : (d.getMonth()+2);
    var end_year = d.getFullYear();
    var random_year = 1860;
    $('#time_picker2').daterangepicker({
        locale     : { format: 'YYYY-MM-DD'},
        "startDate": '1855-12-01',
        "endDate"  : '1865-2-28',
        "minDate"  : "1830-01-01",
        "maxDate"  : "1870-12-31",
        "opens"    : "center"
    },
    function (start, end, label) {
    });


    var hoverEvent = false;

    var slideIndex = {
        TRANSCRIBE: 0,
        TAG: 1,
        CONNECT: 2
    };

    $('#myCarousel').carousel({
        interval:   4000
    });

    $('#myCarousel').on('mouseenter', '.nav a', function() {
        hoverEvent = true;
        $('.nav li').removeClass('active');
        $(this).parent().addClass('active');

        var slideNumber = $(this).parent()[0].getAttribute('data-slide-to');
        $("#myCarousel").carousel(parseInt(slideNumber));
    }).on('click', '.nav a', function() {
        var slideNumber;

        slideNumber = $(this).parent()[0].getAttribute('data-slide-to');
        slideNumber = parseInt(slideNumber);

        if (slideNumber === slideIndex.TRANSCRIBE) {
            window.location = '<?php echo getFullInciteUrl(); ?>/documents/transcribe';
        } else if (slideNumber === slideIndex.TAG) {
            window.location = '<?php echo getFullInciteUrl(); ?>/documents/tag';
        } else if (slideNumber === slideIndex.CONNECT) {
            window.location = '<?php echo getFullInciteUrl(); ?>/documents/connect';
        }
    }).on('slid.bs.carousel', function(e) {
        if (!hoverEvent) {
            var count = $('#myCarousel > .nav').children().length -1;

            var current = $('.carouselNavLi.active');

            current.removeClass('active').next().addClass('active');
            var id = parseInt(current.data('slide-to'));
            if(count == id) {
                $('#myCarousel > .nav li').first().addClass('active');
            }
        }
        hoverEvent = false;
    });
});
</script>

<?php
include(dirname(__FILE__).'/../common/footer.php');
?>

</body>

</html>
