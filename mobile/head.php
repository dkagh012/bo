<?php
if ( ! defined( '_GNUBOARD_' ) )
  exit; // 개별 페이지 접근 불가

include_once( G5_THEME_PATH . '/head.sub.php' );
include_once( G5_LIB_PATH . '/latest.lib.php' );
include_once( G5_LIB_PATH . '/outlogin.lib.php' );
include_once( G5_LIB_PATH . '/poll.lib.php' );
include_once( G5_LIB_PATH . '/visit.lib.php' );
include_once( G5_LIB_PATH . '/connect.lib.php' );
include_once( G5_LIB_PATH . '/popular.lib.php' );

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
<header id="hd">
  <h1 id="hd_h1">
    <?php echo $g5[ 'title' ] ?>
  </h1>

  <div class="to_content"><a href="#container">본문 바로가기</a></div>
  <?php if ( $is_admin == 'super' || $is_auth ) { ?><a href="<?php echo G5_ADMIN_URL ?>" class="hd_admin"
      target="blank">관리자</a>
  <?php } ?>

  <?php
  if ( defined( '_INDEX_' ) ) { // index에서만 실행
    include G5_MOBILE_PATH . '/newwin.inc.php'; // 팝업레이어
  } ?>

  <div id="hd_wrapper">

    <div id="logo">
      <div class="logo_inner">
        <a href="<?php echo G5_URL ?>">
          <span class="sound_only">
            <?php echo $config[ 'cf_title' ]; ?>
          </span>
          <img class="logo_img" src="<?php echo G5_IMG_URL ?>/logo.png" alt="<?php echo $config[ 'cf_title' ]; ?>">
        </a>
      </div>
    </div>
    <ul id="gnb_1dul">
      <?php
      $menu_datas = get_menu_db( 1, true );
      $i          = 0;
      foreach ( $menu_datas as $row ) {
        if ( empty( $row ) )
          continue;
        ?>

        <?php if ( $row[ 'me_name' ] == "COMMUNITY" ) { ?>
          <li class="gnb_1dli <?php echo $_GET[ "bo_table" ] == "free" ? "menu_color " : "gnb_1dlie "; ?>">
            <a href="<?php echo $row[ 'me_link' ]; ?>" target="_<?php echo $row[ 'me_target' ]; ?>" class="gnb_1da free">
              <?php echo $row[ 'me_name' ] ?>
            </a>
          <?php }
        else if ( $row[ 'me_name' ] == "NEWS" ) { ?>
            <li class="gnb_1dli <?php echo $_GET[ "bo_table" ] == "notice" ? "menu_color " : "gnb_1dlie "; ?>">
              <a href="<?php echo $row[ 'me_link' ]; ?>" target="_<?php echo $row[ 'me_target' ]; ?>" class="gnb_1da news">
              <?php echo $row[ 'me_name' ] ?>
              </a>
          <?php }
        else if ( $row[ 'me_name' ] == "HOME" ) { ?>
              <li class="gnb_1dli <?php echo $_GET[ "bo_table" ] == "" ? "menu_color " : "gnb_1dlie "; ?>">
                <a href="<?php echo $row[ 'me_link' ]; ?>" target="_<?php echo $row[ 'me_target' ]; ?>" class="gnb_1da home">
              <?php echo $row[ 'me_name' ] ?>
                </a>
          <?php }
        else if ( $row[ 'me_name' ] == "ABOUT US" ) { ?>
                <li class="gnb_1dli <?php echo $_GET[ "bo_table" ] == "ani" ? "menu_color " : "gnb_1dlie "; ?>">
                  <a href="<?php echo $row[ 'me_link' ]; ?>" target="_<?php echo $row[ 'me_target' ]; ?>" class="gnb_1da about">
              <?php echo $row[ 'me_name' ] ?>
                  </a>
          <?php }
        else if ( $row[ 'me_name' ] == "CONTACT US" ) { ?>
                  <li class="gnb_1dli <?php echo $_GET[ "bo_table" ] == "ani" ? "menu_color " : "gnb_1dlie "; ?>">
                    <a href="<?php echo $row[ 'me_link' ]; ?>" target="_<?php echo $row[ 'me_target' ]; ?>" class="gnb_1da contact">
              <?php echo $row[ 'me_name' ] ?>
                    </a>
          <?php }
        else if ( $row[ 'me_name' ] == "ART" ) { ?>
                    <li class="gnb_1dli <?php echo $_GET[ "bo_table" ] == "ani" ? "menu_color " : "gnb_1dlie "; ?>">
                      <a href="<?php echo $row[ 'me_link' ]; ?>" target="_<?php echo $row[ 'me_target' ]; ?>" class="gnb_1da art">
              <?php echo $row[ 'me_name' ] ?>
                      </a>

          <?php }
        else if ( $row[ 'me_name' ] == "ANI" ) { ?>
                      <li class="gnb_1dli <?php if ( $_GET[ "bo_table" ] == "ani" && $_GET[ "sca" ] == "애니" ) {
                        echo "menu_color";
                      }
                      else {
                        echo "ani gnb_1dlie";
                      } ?>">

          <?php }
        else if ( $row[ 'me_name' ] == "ANI" ) { ?>
                        <li class="gnb_1dli <?php echo $_GET[ "bo_table" ] == "ani" ? "menu_color" : "ani"; ?>">


          <?php }
        else if ( $row[ 'me_name' ] == "게임" ) { ?>
                          <li class="gnb_1dli <?php if ( $_GET[ "bo_table" ] == "ani" && $_GET[ "sca" ] == "게임" ) {
                            echo "menu_color";
                          }
                          else {
                            echo "game gnb_1dlie";
                          } ?>">

          <?php }
        else if ( $row[ 'me_name' ] == "코스프레" ) { ?>
                            <li class="gnb_1dli <?php if ( $_GET[ "bo_table" ] == "ani" && $_GET[ "sca" ] == "코스프레" ) {
                              echo "menu_color";
                            }
                            else {
                              echo "cosp gnb_1dlie";
                            } ?>">

          <?php }
        else { ?>
                            <li class="gnb_1dli ">
          <?php } ?>

          <!-- 
                                                                          <a href="<?php echo $row[ 'me_link' ]; ?>" target="_<?php echo $row[ 'me_target' ]; ?>" class="gnb_1da">
                                                                            <?php echo $row[ 'me_name' ] ?>
                                                                          </a> -->
          <a class="">
            <?= $act_3; ?>
          </a>
        </li>

        <?php
        $k = 0;
        foreach ( (array) $row[ 'sub' ] as $row2 ) {
          if ( empty( $row2 ) )
            continue;

          if ( $k == 0 )
            echo '<button type="button" class="btn_gnb_op"><span class="sound_only">하위분류</span></button><ul class="gnb_2dul">' . PHP_EOL;
          ?>
          <li class="gnb_2dli"><a href="<?php echo $row2[ 'me_link' ]; ?>" target="_<?php echo $row2[ 'me_target' ]; ?>"
              class="gnb_2da"><span></span>
              <?php echo $row2[ 'me_name' ] ?>
            </a></li>
          <?php
          $k++;
        } //end foreach $row2
      
        if ( $k > 0 )
          echo '</ul>' . PHP_EOL;
        ?>
        </li>
        <?php
        $i++;
      } //end foreach $row
      
      if ( $i == 0 ) { ?>
        <li id="gnb_empty">메뉴 준비 중입니다.
          <?php if ( $is_admin ) { ?> <br><a href="<?php echo G5_ADMIN_URL; ?>/menu_list.php">관리자모드 &gt; 환경설정 &gt;
              메뉴설정</a>에서 설정하세요.
          <?php } ?>
        </li>
      <?php } ?>
    </ul>

    <ul id="profile_list" class="pc_view">
      <?php if ( $is_member ) { ?>
        <li id="tnb-arm">
          <?php if ( $is_member ) { ?>
            <?php include_once( G5_PATH . '/plugin/srd-pushmsg/pushmsg_view.php' ); ?>
          <?php } ?>
        </li>
        <li id="tnb">
          <?php echo outlogin( "theme/basic" ); ?>
        </li>
      <?php }
      else { ?>
        <li class="header_login ">
          <p>로그인 / 회원가입</p>
        </li>
        <li class="admin_headLogin"><a href="<?php echo G5_BBS_URL ?>/login.php">로그인</a></li>
      <?php } ?>
    </ul>
</header>



<script>


  const LoginArea = document.querySelector('.LoginArea');
  function toggleClassList(target, className) {
    target.classList.toggle(className);
  }
  function popupToggle(toggleBtn, area, closeBtnClass) {
    if (document.querySelector(`.${toggleBtn}`) !== null) {
      const BTN = document.querySelector(`.${toggleBtn}`)
      const AREA = document.querySelector(`.${area}`)
      BTN.addEventListener('click', () => toggleClassList(AREA, 'hide'));

      AREA.addEventListener('click', (e) => {
        if (e.target.className === AREA.className || e.target.className === closeBtnClass) {
          toggleClassList(AREA, 'hide');
        };
      });
    };
  }
  popupToggle('header_login', 'LoginArea', 'xi-close-thin xi-2x xi_bold');

</script>

<div id="wrapper">

  <div id="container">
    <div id="idx_left">
      <?php
      if ( ! defined( "_INDEX_" ) ) {
        ?>

      <?php } ?>