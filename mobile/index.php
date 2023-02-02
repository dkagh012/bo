<?php
if ( ! defined( '_GNUBOARD_' ) )
    exit; // 개별 페이지 접근 불가

include_once( G5_THEME_MOBILE_PATH . '/head.php' );
add_javascript( '<script src="' . G5_THEME_JS_URL . '/waterfall-light.js"></script>', 10 );
add_javascript( '<script src="' . G5_JS_URL . '/jquery.bxslider.js"></script>', 10 );


?>
<link href='//spoqa.github.io/spoqa-han-sans/css/SpoqaHanSansNeo.css' rel='stylesheet' type='text/css'>


<div class="latest_wr">


    <!-- 메인화면 최신글 시작 -->
    <?php
    echo latest( 'theme/index_main', 'ani', 5, 23 );
    ?>

    <!-- 메인화면 최신글 끝 -->

</div>

<div data-aos="fade-up">
    <div class="latest_img">
        <?php
        echo latest( 'theme/index_xns_gnuboard_latest_gallery_thumbnail', 'ani', 6, 23 );

        ?>
    </div>
</div>

<div data-aos="fade-up">
    <div class="latest_img">
        <?php
        echo latest( 'theme/index_community', 'ani', 27, 23 );

        ?>
    </div>
</div>




<script>
    $('.lt_slider').each(function () {
        $(this).bxSlider({
            pager: true,
            hideControlOnEnd: true,
            nextText: '<i class="fa fa-angle-right" aria-hidden="true"></i>',
            prevText: '<i class="fa fa-angle-left" aria-hidden="true"></i>'
        });
    });
    AOS.init();


</script>


<?php
include_once( G5_THEME_MOBILE_PATH . '/tail.php' );
?>