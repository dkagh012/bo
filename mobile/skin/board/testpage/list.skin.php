<?php
if ( ! defined( '_GNUBOARD_' ) )
  exit; // 개별 페이지 접근 불가

// 선택옵션으로 인해 셀합치기가 가변적으로 변함
$colspan = 2;

if ( $is_checkbox )
  $colspan++;
include_once( G5_LIB_PATH . '/latest_basic.lib.php' );

include_once( G5_LIB_PATH . '/popular.bbs.lib.php' );

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet( '<link rel="stylesheet" href="' . $board_skin_url . '/bo_style.css">', 0 );
?>

<!-- 게시판 목록 시작 -->
<div class="bo_latestBackground">
  <div class="bo_latestform">
    <div class="latest_ca">
      <div class="testpage_ca">
        <div class="latest_search_form">


          <div id="dd">
            <h2>사이트 내 전체검색</h2>

            <form name="fsearchbox" action="<?php echo G5_BBS_URL ?>/search.php"
              onsubmit="return fsearchbox_submit(this);" method="get">
              <input type="hidden" name="sfl" value="wr_subject||wr_content">
              <input type="hidden" name="sop" value="and">
              <input type="text" name="stx" id="sch_stx" placeholder="검색어(필수)" required maxlength="20">
              <button type="submit" value="검색" id="sch_submit">
                <i class="xi-search xi-1x"></i>
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
          <?php if ( $is_category ) { ?>
            <nav id="bo_cate">
              <h2>
                <?php echo ( $board[ 'bo_mobile_subject' ] ? $board[ 'bo_mobile_subject' ] : $board[ 'contentsubject' ] ) ?>
                카테고리
              </h2>
              <ul id="bo_cate_ul">
                <?php echo $category_option ?>
              </ul>
            </nav>
          <?php } ?>
        </div>
      </div>
    </div>

    <div class="latest_list">
      <?php echo latest( "theme/testpage_notice", 'ani', 5, 30 ); ?>

      <?php
      echo latest_basic( "theme/testpage_ba", "ani", 5, 50, "", "", "70", "wr_hit" )
        ?>

      <div id="bo_list">
        <div class="board_wr">
          <form name="fboardlist" id="fboardlist" action="<?php echo G5_BBS_URL; ?>/board_list_update.php"
            onsubmit="return fboardlist_submit(this);" method="post">
            <input type="hidden" name="bo_table" value="<?php echo $bo_table ?>">
            <input type="hidden" name="sfl" value="<?php echo $sfl ?>">
            <input type="hidden" name="stx" value="<?php echo $stx ?>">
            <input type="hidden" name="spt" value="<?php echo $spt ?>">
            <input type="hidden" name="sst" value="<?php echo $sst ?>">
            <input type="hidden" name="sod" value="<?php echo $sod ?>">
            <input type="hidden" name="page" value="<?php echo $page ?>">
            <input type="hidden" name="sw" value="">

            <script>
              $(function () {
                $(".view_op_btn_list").click(function () {
                  $(this).next(".btn_list_op").toggle();
                });
                $(document).mouseup(function (e) {
                  var container = $(".btn_list_op");
                  if (!container.is(e.target) && container.has(e.target).length === 0) {
                    container.css("display", "none");
                  }
                });

                $(".btn_bosch_op").click(function () {
                  $("#bo_sch").show();
                });

                $("#bo_sch .btn_close").click(function () {
                  $("#bo_sch").hide();
                });
              });
            </script>


            <div class="bo_ul">
              <div class="bo_hit_box">
                <a href="<?php echo get_pretty_url( $bo_table ); ?>" class="bo_title"><strong>실시간
                    피드</strong></a>
              </div>

              <ul id="ajax_data">
                <?php
                for ( $i = 0; $i < count( $list ); $i++ ) {
                  ?>
                  <li class="<?php if ( $list[ $i ][ 'is_notice' ] )
                    echo "bo_notice"; ?>">

                    <div class="bo_list_left">

                      <div class="bo_ca">
                        <?php
                        if ( $is_category && $list[ $i ][ 'ca_name' ] ) {
                          ?>
                          <a href="<?php echo $list[ $i ][ 'ca_name_href' ] ?>" class="bo_cate_link">
                            <?php echo $list[ $i ][ 'ca_name' ] ?>
                          </a>
                        <?php } ?>
                      </div>


                      <div class="bo_content">
                        <a href="<?php echo $list[ $i ][ 'href' ] ?>">
                          <p>
                            <?php echo cut_str( strip_tags( $list[ $i ][ 'wr_content' ] ), 100 ) ?>
                          </p>
                        </a>
                      </div>
                      <div class="bo_info_form">

                        <div class="bo_info">
                          <div class="bo_info2">
                            <p>
                              <span class="lt_info_view"><i class="xi-thumbs-up xi-1x" aria-hidden="true"></i>
                                <?php echo $list[ $i ][ 'wr_good' ] ?>
                              </span>
                            </p>
                            <p>
                              <?php if ( $list[ $i ][ 'comment_cnt' ] ) { ?>
                                <span class="sound_only">댓글</span><i class="xi-speech-o xi-1x" aria-hidden="true"></i>
                                <?php echo $list[ $i ][ 'comment_cnt' ]; ?><span class="sound_only">개</span>
                              <?php } ?>
                            </p>
                          </div>
                          <div class="bo_comment">
                            <div class="bo_name">
                              <?php echo $list[ $i ][ 'name' ] ?>
                            </div>
                            <span class="bo_date"><i class="xi-time-o x1-1x" aria-hidden="true"></i>
                              <?php echo $list[ $i ][ 'datetime3' ] ?>
                            </span>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="bo_list_right">
                      <?php
                      if ( $list[ $i ][ 'is_notice' ] ) { // 공지사항
                        $img_content = '<img src="' . $board_skin_url . '/img/notice.jpg">';
                      }
                      else {
                        $thumb = get_list_thumbnail( $board[ 'bo_table' ], $list[ $i ][ 'wr_id' ], $board[ 'bo_gallery_width' ], $board[ 'bo_gallery_height' ], true, true );

                        if ( $thumb[ 'src' ] ) {
                          $img_content = '<img src="' . $thumb[ 'src' ] . '" alt="' . $thumb[ 'alt' ] . '" >';
                        }
                        else {
                          $img_content = '<img src="' . $board_skin_url . '/img/noimg.jpg">';
                        }
                      }
                      echo $img_content;
                      ?>

                    </div>
                  </li>
                <?php } ?>
                <?php
                if ( count( $list ) == 0 ) {
                  echo '<li class="empty_table" datano="no">게시물이 없습니다.</li>';
                }
                ;
                ?>
              </ul>
              <div class="more_button">더보기 more</div>
            </div>


          </form>
        </div>
      </div>
    </div>
    <!-- <div class="latest_best">
      <?php
      // if ($is_member) { 
      ?>
        <a href="http://127.0.0.1/bbs/board.php?bo_table=qowjdxo&level_ck=y&sop=and&sfl=mb_id&stx={$member['mb_id']}"
          class="latest_list_link">내 프로필로 이동</a>
      <?php
      //  } ?>

    </div> -->
    <ul class="latest_best">
      <div class="testpage_best">
        <?php if ( $is_member ) { ?>
          <li><a href="<?php echo $write_href ?>" class="latest_list_link">글쓰기</a></li>

        <?php }
        else { ?>

          <li class="membershipBtn latest_list_link ">
            <p>글쓰기</p>
          </li>
        <?php } ?>
      </div>
    </ul>
  </div>
</div>
<?php if ( $is_checkbox ) { ?>
  <noscript>
    <p>자바스크립트를 사용하지 않는 경우<br>별도의 확인 절차 없이 바로 선택삭제 처리하므로 주의하시기 바랍니다.</p>
  </noscript>
<?php } ?>

<!-- 페이지 -->
<?php echo $write_pages; ?>

<script>

  const membershipBtn = document.querySelector('.membershipBtn');

  membershipBtn.addEventListener('click', () => {
    LoginArea.classList.toggle('hide');
  })

  var page_on = $("#container").find(".pg_current");
  var page_check = $(".pg_current").text();
  $(document).ready(function () {
    if (page_check == "object Object") {
      $(".pg_current").text("0");
    } else {
      $(".pg_current").text("2");
    }
  });



  $(window).scroll(function () {
    if ((window.innerHeight + window.scrollY + 1) >= document.body.scrollHeight) {
      setTimeout(function () {
        $(this).html('<i class="xi-spinner-1"></i>');
        var disp_li_length = $("#gallery_json > li").length;
        var page_n = $(".pg_current").html();
        $.get("<?= G5_URL ?>/bbs/board.php?bo_table=<?= $bo_table ?>&ajax_ck=1&sca=<?php echo urlencode( $sca ) ?>&page=" + page_n, function (data) {
          var append_data = $(data).find("#ajax_data").html();
          var cking = $(data).find(".empty_table").attr("datano");
          if (page_check == 0) {
            $(".more_button").html("더 이상 게시글이 없습니다.");
            return false;
          }
          if (cking != "no") {
            $("#page_txt").html("");
            $("#ajax_data").append(append_data);
            $(".pg_current").html(parseInt(page_n) + 1);
            $(".more_button").html("더 보기");
          } else {
            $(".more_button").html("더 이상 게시글이 없습니다.");
          }
        })
        console.log("테스트");
      }, 500)
    }
  })




</script>
<!-- 게시판 목록 끝 -->