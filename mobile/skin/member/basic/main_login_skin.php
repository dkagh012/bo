<?php
if ( ! defined( '_GNUBOARD_' ) )
  exit; // 개별 페이지 접근 불가

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet( '<link rel="stylesheet" href="' . $member_skin_url . '/main_login.style.css">', 0 );
?>

<div id="mb_login" class="mbskin">

  <img class="logo_img" src="<?php echo G5_IMG_URL ?>/logo.png" alt="<?php echo $config[ 'cf_title' ]; ?>">
  <div class="close_BTN"><i class="xi-close-thin xi-2x xi_bold"></i></div>
  <h1 class="test">
    간편 가입/로그인
  </h1>

  <form name="flogin" action="<?php echo $login_action_url ?>" onsubmit="return flogin_submit(this);" method="post"
    id="flogin">
    <input type="hidden" name="url" value="<?php echo $login_url ?>">


    <?php
    // 소셜로그인 사용시 소셜로그인 버튼
    @include_once( get_social_skin_path() . '/mb_login.skin.php' );
    ?>

    <section class="mb_login_join">
      <div>
        <input type="checkbox" name="auto_login" id="login_auto_login">
        <label for="login_auto_login" class="autoLogin"> 로그인 상태 유지</label>
      </div>
      <a class="mb_Privacy" href="<?php echo get_pretty_url( 'content', 'privacy' ); ?>">개인정보처리방침</a>
    </section>


  </form>

</div>

<script>
  $(function () {
    $("#login_auto_login").click(function () {
      if (this.checked) {
        this.checked = confirm("자동로그인을 사용하시면 다음부터 회원아이디와 비밀번호를 입력하실 필요가 없습니다.\n\n공공장소에서는 개인정보가 유출될 수 있으니 사용을 자제하여 주십시오.\n\n자동로그인을 사용하시겠습니까?");
      }
    });
  });

  function flogin_submit(f) {
    if ($(document.body).triggerHandler('login_sumit', [f, 'flogin']) !== false) {
      return true;
    }
    return false;
  }
</script>