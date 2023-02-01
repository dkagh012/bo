<?php
if ( ! defined( '_GNUBOARD_' ) )
    exit; // 개별 페이지 접근 불가
?>



<!-- <div id="ft">
    <div class="ft_wr">
        <div id="ft_company">
            <a href="<?php echo get_pretty_url( 'content', 'company' ); ?>">회사소개</a>
            <a href="<?php echo get_pretty_url( 'content', 'privacy' ); ?>">개인정보처리방침</a>
            <a href="<?php echo get_pretty_url( 'content', 'provision' ); ?>">서비스이용약관</a>
        </div>
        <div id="ft_copy">Copyright &copy; <b>소유하신 도메인.</b> All rights reserved.<br>
        </div>
        <button type="button" id="top_btn"><i class="fa fa-arrow-up" aria-hidden="true"></i><span
                class="sound_only">상단으로</span></button>
        <?php
        // if (G5_DEVICE_BUTTON_DISPLAY && G5_IS_MOBILE) { ?>
        //     <a href="<?php
        // echo get_device_change_url(); 
        ?>" id="device_change">PC 버전으로 보기</a>
       
       <?php
       // }
       
       // if ($config['cf_analytics']) {
       //     echo $config['cf_analytics'];
       // }
       ?>
    </div> -->



<script>

    $(function () {

        $("#gnb_open").on("click", function () {
            $("#gnb").show();
        });

        $("#gnb_close, .gnb_bg").on("click", function () {
            $("#gnb").hide();
        });

        $("#container").on("click", function () {
            $(".hd_div").hide();
        });

        $(".btn_gnb_op").click(function () {
            $(this).toggleClass("btn_gnb_cl").next(".gnb_2dul").slideToggle(300);

        });

        $("#sch_op_btn").on("click", function () {
            $("#hd_sch").show();
        });

        $(".sch_cl_btn").on("click", function () {
            $("#hd_sch").hide();
        });

        $("#user_open").on("click", function () {
            $(".ol").show();
        });

        $(".ol .btn_close, .ol_bg").on("click", function () {
            $(".ol").hide();
        });
    });


    jQuery(function ($) {

        $(document).ready(function () {

            // 폰트 리사이즈 쿠키있으면 실행
            font_resize("container", get_cookie("ck_font_resize_rmv_class"), get_cookie("ck_font_resize_add_class"));

            //상단고정
            if ($(".top").length) {
                var jbOffset = $(".top").offset();
                $(window).scroll(function () {
                    if ($(document).scrollTop() > jbOffset.top) {
                        $('.top').addClass('fixed');
                    }
                    else {
                        $('.top').removeClass('fixed');
                    }
                });
            }

            //상단으로
            $("#top_btn").on("click", function () {
                $("html, body").animate({ scrollTop: 0 }, '500');
                return false;
            });

        });
    });
</script>

<?php
include_once( G5_THEME_PATH . "/tail.sub.php" );
?>