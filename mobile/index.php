<?php
if ( ! defined( '_GNUBOARD_' ) )
    exit; // 개별 페이지 접근 불가

include_once( G5_THEME_MOBILE_PATH . '/head.php' );
add_javascript( '<script src="' . G5_THEME_JS_URL . '/waterfall-light.js"></script>', 10 );
add_javascript( '<script src="' . G5_JS_URL . '/jquery.bxslider.js"></script>', 10 );


?>

<div class="LoginArea hide">
    <?php

    if ( ! $is_member ) {
        $url   = isset( $_GET[ 'url' ] ) ? strip_tags( $_GET[ 'url' ] ) : '';
        $od_id = isset( $_POST[ 'od_id' ] ) ? safe_replace_regex( $_POST[ 'od_id' ], 'od_id' ) : '';

        if ( function_exists( 'social_check_login_before' ) ) {
            $social_login_html = social_check_login_before();
        }
        $g5[ 'title' ] = '로그인';


        // url 체크
        check_url_host( $url );
        $login_url        = login_url( $url );
        $login_action_url = G5_HTTPS_BBS_URL . "/login_check.php";


        $login_file       = $member_skin_path . '/main_login_skin.php';
        if ( ! file_exists( $login_file ) )
            $member_skin_path = G5_SKIN_PATH . '/member/basic';

        include_once( $member_skin_path . '/main_login_skin.php' );


        run_event( 'member_login_tail', $login_url, $login_action_url, $member_skin_path, $url );


    }

    ?>
</div>

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

    function toggleClassList(target, className) {
        target.classList.toggle(className);
    }
    function popupToggle(toggleBtn, area) {
        if (document.querySelector(`.${toggleBtn}`) !== null) {
            const BTN = document.querySelector(`.${toggleBtn}`)
            const AREA = document.querySelector(`.${area}`)
            BTN.addEventListener('click', () => toggleClassList(AREA, 'hide'));

            AREA.addEventListener('click', (e) => {
                if (e.target.className === AREA.className) {
                    toggleClassList(AREA, 'hide');
                };
            });
        };
    }
    popupToggle('head_login', 'LoginArea', 'xi-close-thin xi-2x');

</script>


<?php
include_once( G5_THEME_MOBILE_PATH . '/tail.php' );
?>