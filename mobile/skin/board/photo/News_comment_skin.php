<?php
if ( ! defined( '_GNUBOARD_' ) )
  exit; // 개별 페이지 접근 불가

?>

<script>
  // 글자수 제한
  var char_min = parseInt(<?php echo $comment_min ?>); // 최소
  var char_max = parseInt(<?php echo $comment_max ?>); // 최대
</script>


<?php if ( $is_comment_write ) {
  if ( $w == '' )
    $w = 'c';
  ?>


  <!-- 댓글 쓰기 시작 { -->
  <div class="News_comments">
    <aside id="" class="">
      <form class="News_input" name="fviewcomment" id="fviewcomment" action="<?php echo $comment_action_url; ?>"
        onsubmit="return fviewcomment_submit(this);" method="post" autocomplete="off">
        <input type="hidden" name="w" value="<?php echo $w ?>" id="w">
        <input type="hidden" name="bo_table" value="<?php echo $bo_table ?>">
        <input type="hidden" name="wr_id" value="<?php echo $wr_id ?>">
        <input type="hidden" name="comment_id" value="<?php echo $c_id ?>" id="comment_id">
        <input type="hidden" name="sca" value="<?php echo $sca ?>">
        <input type="hidden" name="sfl" value="<?php echo $sfl ?>">
        <input type="hidden" name="stx" value="<?php echo $stx ?>">
        <input type="hidden" name="spt" value="<?php echo $spt ?>">
        <input type="hidden" name="page" value="<?php echo $page ?>">
        <input type="hidden" name="is_good" value="">

        <div class="bo_vc_w_info hide">
          <?php if ( $is_guest ) { ?>
            <label for="wr_name" class="sound_only">이름<strong> 필수</strong></label>
            <input type="text" name="wr_name" value="<?php echo get_cookie( "ck_sns_name" ); ?>" id="wr_name" required
              class="frm_input required" size="25" placeholder="이름">
            <label for="wr_password" class="sound_only">비밀번호<strong> 필수</strong></label>
            <input type="password" name="wr_password" id="wr_password" required class="frm_input required" size="25"
              placeholder="비밀번호">
            <?php echo $captcha_html; ?>
          <?php }
          else { ?>
            <?php echo $member[ 'mb_nick' ]; ?>
          <?php } ?>

          <?php if ( $board[ 'bo_use_sns' ] && ( $config[ 'cf_facebook_appid' ] || $config[ 'cf_twitter_key' ] ) ) { ?>
            <span class="sound_only">SNS 동시등록</span>
            <span id="bo_vc_send_sns"></span>
          <?php } ?>
        </div>
        <div class="News_info">
          <span class="sound_only">내용</span>
          <textarea id="wr_content" class="News_content" name="wr_content" maxlength="10000" required class="required"
            title="내용" placeholder="댓글내용을 입력해주세요" <?php if ( $comment_min || $comment_max ) { ?>onkeyup="check_byte('wr_content', 'char_count');" <?php } ?>><?php echo $c_wr_content; ?></textarea>
          <?php if ( $comment_min || $comment_max ) { ?>
            <script> check_byte('wr_content', 'char_count'); </script><?php } ?>

          <div class="News_info_btn">
            <?php if ( $comment_min || $comment_max ) { ?><strong id="char_cnt"><span id="char_count">0</span>/
                <?php echo $comment_max; ?>
              </strong>
            <?php } ?>

            <script>
              $(document).on("keyup change", "textarea#wr_content[maxlength]", function () {
                var str = $(this).val()
                var mx = parseInt($(this).attr("maxlength"))
                if (str.length > mx) {
                  $(this).val(str.substr(0, mx));
                  return false;
                }
              });
            </script>
            <button type="submit" id="btn_submit" class="btn btn_cmt_submit News_submit">등록</button>
          </div>
        </div>
      </form>
    </aside>
    <script>
      const News_content = document.querySelector('.News_content');

    </script>
    <script>
      var save_before = '';
      var save_html = document.getElementById('bo_vc_w').innerHTML;

      function good_and_write() {
        var f = document.fviewcomment;
        if (fviewcomment_submit(f)) {
          f.is_good.value = 1;
          f.submit();
        } else {
          f.is_good.value = 0;
        }
      }

      function fviewcomment_submit(f) {
        var pattern = /(^\s*)|(\s*$)/g; // \s 공백 문자

        f.is_good.value = 0;

        var subject = "";
        var content = "";
        $.ajax({
          url: g5_bbs_url + "/ajax.filter.php",
          type: "POST",
          data: {
            "subject": "",
            "content": f.wr_content.value
          },
          dataType: "json",
          async: false,
          cache: false,
          success: function (data, textStatus) {
            subject = data.subject;
            content = data.content;
          }
        });

        if (content) {
          alert("내용에 금지단어('" + content + "')가 포함되어있습니다");
          f.wr_content.focus();
          return false;
        }

        // 양쪽 공백 없애기
        var pattern = /(^\s*)|(\s*$)/g; // \s 공백 문자
        document.getElementById('wr_content').value = document.getElementById('wr_content').value.replace(pattern, "");
        if (char_min > 0 || char_max > 0) {
          check_byte('wr_content', 'char_count');
          var cnt = parseInt(document.getElementById('char_count').innerHTML);
          if (char_min > 0 && char_min > cnt) {
            alert("댓글은 " + char_min + "글자 이상 쓰셔야 합니다.");
            return false;
          } else if (char_max > 0 && char_max < cnt) {
            alert("댓글은 " + char_max + "글자 이하로 쓰셔야 합니다.");
            return false;
          }
        }
        else if (!document.getElementById('wr_content').value) {
          alert("댓글을 입력하여 주십시오.");
          return false;
        }

        if (typeof (f.wr_name) != 'undefined') {
          f.wr_name.value = f.wr_name.value.replace(pattern, "");
          if (f.wr_name.value == '') {
            alert('이름이 입력되지 않았습니다.');
            f.wr_name.focus();
            return false;
          }
        }

        if (typeof (f.wr_password) != 'undefined') {
          f.wr_password.value = f.wr_password.value.replace(pattern, "");
          if (f.wr_password.value == '') {
            alert('비밀번호가 입력되지 않았습니다.');
            f.wr_password.focus();
            return false;
          }
        }

        <?php if ( $is_guest )
          echo chk_captcha_js(); ?>

        set_comment_token(f);

        document.getElementById("btn_submit").disabled = "disabled";

        return true;
      }

      function comment_box(comment_id, work) {
        var el_id,
          form_el = 'fviewcomment',
          respond = document.getElementById(form_el);

        // 댓글 아이디가 넘어오면 답변, 수정
        if (comment_id) {
          if (work == 'c')
            el_id = 'reply_' + comment_id;
          else
            el_id = 'edit_' + comment_id;
        }
        else
          el_id = 'bo_vc_w';

        if (save_before != el_id) {
          if (save_before) {
            document.getElementById(save_before).style.display = 'none';
          }

          document.getElementById(el_id).style.display = '';
          document.getElementById(el_id).appendChild(respond);
          //입력값 초기화
          document.getElementById('wr_content').value = '';

          document.getElementById('comment_id').value = comment_id;
          document.getElementById('w').value = work;

          if (save_before)
            // $("#captcha_reload").trigger("click");

            save_before = el_id;
        }
      }

      function comment_delete() {
        return confirm("이 댓글을 삭제하시겠습니까?");
      }

      comment_box('', 'c'); // 댓글 입력폼이 보이도록 처리하기위해서 추가 (root님)

      <?php if ( $board[ 'bo_use_sns' ] && ( $config[ 'cf_facebook_appid' ] || $config[ 'cf_twitter_key' ] ) ) { ?>

        $(function () {
          // sns 등록
          $("#bo_vc_send_sns").load(
            "<?php echo G5_SNS_URL; ?>/view_comment_write.sns.skin.php?bo_table=<?php echo $bo_table; ?>",
            function () {
              save_html = document.getElementById('bo_vc_w').innerHTML;
            }
          );
        });
                                                                                                                                                                                          <?php } ?>
    </script>
    <!-- } 댓글 쓰기 끝 -->
  <?php }
else { ?>
    <aside id="bo_vc_login" class="bo_vc_login">
      <a href="<?php echo G5_BBS_URL ?>/login.php">로그인 해주세요.</a>
    </aside>
  <?php } ?>
  <!-- } 댓글 쓰기 끝 -->


  <!-- 댓글 시작 { -->
  <section class="NewsComment" id="bo_vc">
    <h2>댓글목록</h2>
    <?php
    $cmt_amt = count( $list );
    for ( $i = 0; $i < $cmt_amt; $i++ ) {
      $comment_id = $list[ $i ][ 'wr_id' ];
      $cmt_depth  = strlen( $list[ $i ][ 'wr_comment_reply' ] ) * 20;
      $comment    = $list[ $i ][ 'content' ];
      /*
      if (strstr($list[$i]['wr_option'], "secret")) {
      $str = $str;
      }
      */
      $comment               = preg_replace( "/\[\<a\s.*href\=\"(http|https|ftp|mms)\:\/\/([^[:space:]]+)\.(mp3|wma|wmv|asf|asx|mpg|mpeg)\".*\<\/a\>\]/i", "<script>doc_write(obj_movie('$1://$2.$3'));</script>", $comment );
      $cmt_sv                = $cmt_amt - $i + 1; // 댓글 헤더 z-index 재설정 ie8 이하 사이드뷰 겹침 문제 해결
      $c_reply_href          = $comment_common_url . '&amp;c_id=' . $comment_id . '&amp;w=c#bo_vc_w';
      $c_edit_href           = $comment_common_url . '&amp;c_id=' . $comment_id . '&amp;w=cu#bo_vc_w';
      $is_comment_reply_edit = ( $list[ $i ][ 'is_reply' ] || $list[ $i ][ 'is_edit' ] || $list[ $i ][ 'is_del' ] ) ? 1 : 0;
      ?>

      <article id="c_<?php echo $comment_id ?>" <?php if ( $cmt_depth ) { ?>style="margin-left:<?php echo $cmt_depth; ?>px;" <?php } ?>>
        <div>
          <div class="News_profile">
            <div class="pf_img">
              <?php echo get_member_profile_img( $list[ $i ][ 'mb_id' ] ); ?>
              <?php echo get_text( $list[ $i ][ 'wr_name' ] ); ?>
              <span class="bo_vc_hdinfo">작성일 :
                <?php echo $list[ $i ][ 'datetime' ] ?>
              </span>
            </div>
            <ul class="bo_vc_act">
              <li>
                <a class="good_btn"
                  href="<?php echo G5_BBS_URL . '/good.php?bo_table=' . $bo_table . '&wr_id=' . $list[ $i ][ 'wr_id' ] . '&good=good'; ?>">
                  <img class="" src="<?php echo $board_skin_url; ?>/img/like.png"><strong style="margin-left:10px">
                    <?php echo number_format( $list[ $i ][ 'wr_good' ] ) ?>
                  </strong>
                  <b id="bo_v_act_good" class="bo_v_act_good"></b>
                </a>
              </li>
            </ul>
          </div>

          <div class="cm_wrap">

            <!-- 댓글 출력 -->
            <div class="contentsBox">
              <p>
                <?php if ( strstr( $list[ $i ][ 'wr_option' ], "secret" ) ) { ?><i class="xi-lock xi-x"></i>
                <?php } ?>
                <?php echo $comment ?>
              </p>
              <?php if ( $is_comment_reply_edit ) {
                if ( $w == 'cu' ) {
                  $sql = " select wr_id, wr_content, mb_id from $write_table where wr_id = '$c_id' and wr_is_comment = '1' ";
                  $cmt = sql_fetch( $sql );

                  if ( ! ( $is_admin || ( $member[ 'mb_id' ] == $cmt[ 'mb_id' ] && $cmt[ 'mb_id' ] ) ) )
                    $cmt[ 'wr_content' ] = '';
                  $c_wr_content = $cmt[ 'wr_content' ];
                }
                ?>
              <?php } ?>

              <span id="edit_<?php echo $comment_id ?>" class="bo_vc_w"></span><!-- 수정 -->
              <span id="reply_<?php echo $comment_id ?>" class="bo_vc_w"></span><!-- 답변 -->

              <input type="hidden" value="<?php echo strstr( $list[ $i ][ 'wr_option' ], "secret" ) ?>"
                id="secret_comment_<?php echo $comment_id ?>">
              <textarea id="save_comment_<?php echo $comment_id ?>"
                style="display:none"><?php echo get_text( $list[ $i ][ 'content1' ], 0 ) ?></textarea>
            </div>

            <?php if ( $is_comment_reply_edit ) { ?>
              <div class="bo_vl_opt">
                <button type="button" class="btn_cm_opt hide">
                  <i class="xi-ellipsis-v xi-x"></i>
                  <span class="sound_only">댓글 옵션</span>
                </button>
                <ul class="bo_vc_act hide">
                  <?php if ( $list[ $i ][ 'is_reply' ] ) { ?>
                    <li><a href="<?php echo $c_reply_href; ?>"
                        onclick="comment_box('<?php echo $comment_id ?>', 'c'); return false;">답변</a></li>
                  <?php } ?>
                  <?php if ( $list[ $i ][ 'is_edit' ] ) { ?>
                    <li><a href="<?php echo $c_edit_href; ?>"
                        onclick="comment_box('<?php echo $comment_id ?>', 'cu'); return false;">수정</a></li>
                  <?php } ?>
                  <?php if ( $list[ $i ][ 'is_del' ] ) { ?>
                    <li><a href="<?php echo $list[ $i ][ 'del_link' ]; ?>" onclick="return comment_delete();">삭제</a></li>
                  <?php } ?>
                </ul>
              </div>
            <?php } ?>
          </div>
        </div>
        <div class="comment_down">
          <?php if ( $list[ $i ][ 'is_reply' ] ) { ?>
            <p><a href="<?php echo $c_reply_href; ?>"
                onclick="comment_box('<?php echo $comment_id ?>', 'c'); return false;">답변</a></p>
          <?php } ?>
        </div>
      </article>
    <?php } ?>
    <?php if ( $i == 0 ) { //댓글이 없다면 ?>
      <p id="bo_vc_empty">등록된 댓글이 없습니다.</p>
    <?php } ?>

  </section>
</div>
<!-- } 댓글 끝 -->