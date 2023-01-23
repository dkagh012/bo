<?php
if (!defined('_GNUBOARD_'))
    exit; // 개별 페이지 접근 불가

// 선택옵션으로 인해 셀합치기가 가변적으로 변함
$colspan = 2;

if ($is_checkbox)
    $colspan++;
include_once(G5_LIB_PATH . '/latest_basic.lib.php');

include_once(G5_LIB_PATH . '/popular.bbs.lib.php');

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="' . $board_skin_url . '/bo_style.css">', 0);
?>

<!-- 게시판 목록 시작 -->
<div class="bo_latestBackground">
    <div class="bo_latestform">
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
                <?php if ($is_category) { ?>
                    <nav id="bo_cate">
                        <h2>
                            <?php echo ($board['bo_mobile_subject'] ? $board['bo_mobile_subject'] : $board['contentsubject']) ?>
                            카테고리
                        </h2>
                        <ul id="bo_cate_ul">
                            <?php echo $category_option ?>
                        </ul>
                    </nav>
                <?php } ?>
            </div>
        </div>

        <div class="latest_list">
            <?php echo latest("theme/false9_notice", 'ani', 5, 30); ?>
            <?php echo latest_basic("theme/basic", "ani", 5, 50, "", "", "70", "wr_hit"); ?>

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
      <a href="<?php echo get_pretty_url($bo_table); ?>" class="bo_title"><strong>새글피드</strong></a>
      <a href="<?php echo get_pretty_url($bo_table); ?>" class="bo_more"><span class="sound_only">
          <?php echo $bo_subject ?>
        </span>전체보기</a>
    </div>

                            <ul class="<?php if ($is_checkbox) { ?>bo_ul_admin<?php } ?>">
                                <?php
                                for ($i = 0; $i < count($list); $i++) {
                                    ?>
                                    <li class="<?php if ($list[$i]['is_notice'])
                                        echo "bo_notice"; ?>">

                                        <div class="bo_ca">
                                            <?php
                                            if ($is_category && $list[$i]['ca_name']) {
                                                ?>
                                                <a href="<?php echo $list[$i]['ca_name_href'] ?>" class="bo_cate_link">
                                                    <?php echo $list[$i]['ca_name'] ?>
                                                </a>
                                            <?php } ?>
                                        </div>

                                        <div class="content-subject">
                                            <div class="lat_tit_o"></div>
                                            <?php if ($list[$i]['is_notice']) { ?><strong class="notice_icon"><i
                                                        class="fa fa-microphone" aria-hidden="true"></i><span
                                                        class="sound_only">공지</span></strong>
                                            <?php } ?>



                                            <a href="<?php echo $list[$i]['href'] ?>" class="bo_tit">
                                                <?php echo $list[$i]['icon_reply']; ?>
                                                <?php echo $list[$i]['subject'] ?>


                                            </a>

                                        </div>
                                        <div class="bo_content">
                                            <a href="<?php echo $list[$i]['href'] ?>">
                                                <?php echo cut_str(strip_tags($list[$i]['wr_content']), 100) ?>
                                            </a>
                                        </div>
                                        <div class="bo_info_form">
                                            <div class="bo_name">
                                                <?php echo $list[$i]['name'] ?>
                                            </div>
                                            <div class="bo_info">
                                                <span class="sound_only">작성자</span>
                                                <div class="bo_info2">
                                                    <?php echo $list[$i]['datetime2'] ?>
                                                </div>
                                                <div class="bo_comment">
                                                    <?php if ($list[$i]['comment_cnt']) { ?>
                                                        <span class="sound_only">댓글</span><i class="xi-bell-o xi-1x"
                                                            aria-hidden="true"></i>
                                                        <?php echo $list[$i]['comment_cnt']; ?><span
                                                            class="sound_only">개</span><?php } ?>
                                                    <span class="bo_view"><i class="xi-eye-o xi-1x" aria-hidden="true"></i>
                                                        <?php echo $list[$i]['wr_hit'] ?>
                                                    </span>
                                                    <span class="bo_date"><i class="xi-time-o x1-1x" aria-hidden="true"></i>
                                                        <?php echo $list[$i]['datetime'] ?>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>

                                    </li>
                                <?php } ?>
                                <?php if (count($list) == 0) {
                                    echo '<li class="empty_table">게시물이 없습니다.</li>';
                                } ?>
                            </ul>
                        </div>


                    </form>
                </div>
            </div>
        </div>
        <div class="latest_best">
        <?php if ($is_member) { ?>    
            <a href="http://127.0.0.1/bbs/board.php?bo_table=qowjdxo&level_ck=y&sop=and&sfl=mb_id&stx={$member['mb_id']}"class="latest_list_link">내 프로필로 이동</a>
            <?php } ?>
            
            <?php
            echo latest_basic("theme/dt", "ani", 5, 50, "", "", "7", "wr_hit"); ?>
        </div>
    </div>
</div>
<?php if ($is_checkbox) { ?>
    <noscript>
        <p>자바스크립트를 사용하지 않는 경우<br>별도의 확인 절차 없이 바로 선택삭제 처리하므로 주의하시기 바랍니다.</p>
    </noscript>
<?php } ?>

<!-- 페이지 -->
<?php echo $write_pages; ?>

<?php if ($is_checkbox) { ?>
    <script>
        function all_checked(sw) {
            var f = document.fboardlist;

            for (var i = 0; i < f.length; i++) {
                if (f.elements[i].name == "chk_wr_id[]")
                    f.elements[i].checked = sw;
            }
        }

        function fboardlist_submit(f) {
            var chk_count = 0;

            for (var i = 0; i < f.length; i++) {
                if (f.elements[i].name == "chk_wr_id[]" && f.elements[i].checked)
                    chk_count++;
            }

            if (!chk_count) {
                alert(document.pressed + "할 게시물을 하나 이상 선택하세요.");
                return false;
            }

            if (document.pressed == "선택복사") {
                select_copy("copy");
                return;
            }

            if (document.pressed == "선택이동") {
                select_copy("move");
                return;
            }

            if (document.pressed == "선택삭제") {
                if (!confirm("선택한 게시물을 정말 삭제하시겠습니까?\n\n한번 삭제한 자료는 복구할 수 없습니다\n\n답변글이 있는 게시글을 선택하신 경우\n답변글도 선택하셔야 게시글이 삭제됩니다."))
                    return false;

                f.removeAttribute("target");
                f.action = g5_bbs_url + "/board_list_update.php";
            }

            return true;
        }

        // 선택한 게시물 복사 및 이동
        function select_copy(sw) {
            var f = document.fboardlist;

            if (sw == 'copy')
                str = "복사";
            else
                str = "이동";

            var sub_win = window.open("", "move", "left=50, top=50, width=500, height=550, scrollbars=1");

            f.sw.value = sw;
            f.target = "move";
            f.action = g5_bbs_url + "/move.php";
            f.submit();
        }
    </script>
<?php } ?>
<!-- 게시판 목록 끝 -->