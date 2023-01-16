<?php
if (!defined('_GNUBOARD_'))
  exit; // 개별 페이지 접근 불가

// 선택옵션으로 인해 셀합치기가 가변적으로 변함
include_once(G5_LIB_PATH . '/latest_basic.lib.php');

include_once(G5_LIB_PATH . '/popular.bbs.lib.php');


// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="' . $board_skin_url . '/style.css">', 0);
?>

<!-- 게시판 목록 시작 -->
<div class="latest_background">

  <div class="latest_list_form">
    <div class="latest_ca">
      <div class="latest_search_form">


        <div id="dd">
          <h2>사이트 내 전체검색</h2>

          <form name="fsearchbox" action="<?php echo G5_BBS_URL ?>/search.php"
            onsubmit="return fsearchbox_submit(this);" method="get">
            <input type="hidden" name="sfl" value="wr_subject||wr_content">
            <input type="hidden" name="sop" value="and">
            <input type="text" name="stx" id="sch_stx" placeholder="검색어(필수)" required maxlength="20">
            <button type="submit" value="검색" id="sch_submit">
              <i class="fa fa-search" aria-hidden="true"></i>
              <span class="sound_only">검색</span></button>
          </form>

          <script>
            function fsearchbox_submit(f) {
              if (f.stx.value.length < 2) {
                alert("검색어는 두글자 이상 입력하십시오.");
                f.stx.select();
                f.stx.focus();
                return false;
              }

              // 검색에 많은 부하가 걸리는 경우 이 주석을 제거하세요.
              var cnt = 0;
              for (var i = 0; i < f.stx.value.length; i++) {
                if (f.stx.value.charAt(i) == ' ')
                  cnt++;
              }

              if (cnt > 1) {
                alert("빠른 검색을 위하여 검색어에 공백은 한개만 입력할 수 있습니다.");
                f.stx.select();
                f.stx.focus();
                return false;
              }

              return true;
            }
          </script>

        </div>

        <?php
        // echo popular('theme/basic'); 
// 인기검색어 ?>

      </div>

      <div id="bo_list">
        <h1 class="id_tit">카테고리</h1>
        <ul class="ca_lists">
          <li>
            <a href="http://127.0.0.1/bbs/board.php?bo_table=ani">
              <h1>일상</h1> <i class="fa fa-search" aria-hidden="true"></i>
            </a>
          </li>
          <li>
            <a href="http://127.0.0.1/bbs/board.php?bo_table=ani">
              <h1>게임</h1> <i class="fa fa-search" aria-hidden="true"></i>
            </a>
          </li>
          <li>
            <a href="http://127.0.0.1/bbs/board.php?bo_table=ani">
              <h1>애니</h1> <i class="fa fa-search" aria-hidden="true"></i>
            </a>
          </li>
        </ul>
      </div>
    </div>

    <div class="latest_list">
    
      <?php echo latest("theme/false9_notice", 'ani', 5, 30); ?>
      <?php echo latest_basic("theme/basic", "ani", 5, 50, "", "", "70", "wr_hit"); ?>
      <?php echo latest('theme/us-simple', 'ani', 6, 24);?>
    </div>

    <div class="latest_best">
      <?php
      echo latest_basic("theme/dt", "ani", 5, 50, "", "", "7", "wr_hit"); ?>
    </div>
  </div>
</div>




<!-- 게시판 목록 끝 -->