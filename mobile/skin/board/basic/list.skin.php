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
<div class="latest_ca">
    <div id="bo_list">

        <?php if ($is_category) { ?>
            <nav id="bo_cate">
                <h2><?php echo ($board['bo_mobile_subject'] ? $board['bo_mobile_subject'] : $board['bo_subject']) ?> 카테고리
                </h2>
                <ul id="bo_cate_ul">
                    <?php echo $category_option ?>
                </ul>
            </nav>
        <?php } ?>
    </div>


    <div id="gnb">
        <div class="gnb_bg"></div>
        <div class="gnb_wr">
            <button type="button" id="gnb_close" class="m_view"><i class="fa fa-times"></i><span class="sound_only">메뉴
                    닫기</span></button>
            
            <ul id="gnb_1dul">
                <?php
                $menu_datas = get_menu_db(1, true);
                $i = 0;
                foreach ($menu_datas as $row) {
                    if (empty($row))
                        continue;
                    ?>
                    <li class="gnb_1dli">
                        <a href="<?php echo $row['me_link']; ?>" target="_<?php echo $row['me_target']; ?>" class="gnb_1da">
                            <?php echo $row['me_name'] ?>
                        </a>
                        <?php
                        $k = 0;
                        foreach ((array) $row['sub'] as $row2) {
                            if (empty($row2))
                                continue;

                            if ($k == 0)
                                echo '<button type="button" class="btn_gnb_op">하위분류</button><ul class="gnb_2dul">' . PHP_EOL;
                            ?>
                        <li class="gnb_2dli"><a href="<?php echo $row2['me_link']; ?>"
                                target="_<?php echo $row2['me_target']; ?>" class="gnb_2da"><span></span>
                                <?php echo $row2['me_name'] ?>
                            </a></li>
                        <?php
                        $k++;
                        } //end foreach $row2
                    
                        if ($k > 0)
                            echo '</ul>' . PHP_EOL;
                        ?>
                    </li>
                    <?php
                    $i++;
                } //end foreach $row
                
                if ($i == 0) { ?>
                    <li id="gnb_empty">메뉴 준비 중입니다.<?php if ($is_admin) { ?> <br><a
                                href="<?php echo G5_ADMIN_URL; ?>/menu_list.php">관리자모드 &gt; 환경설정 &gt; 메뉴설정</a>에서 설정하세요.<?php } ?></li>
                <?php } ?>
            </ul>


            <button type="button" class="pc_view" id="sch_op_btn"><span class="sound_only">검색열기</span><i
                    class="fa fa-search" aria-hidden="true"></i></button>
            <div id="hd_sch">
                <h2>사이트 내 전체검색</h2>

                <form name="fsearchbox" action="<?php echo G5_BBS_URL ?>/search.php"
                    onsubmit="return fsearchbox_submit(this);" method="get">
                    <input type="hidden" name="sfl" value="wr_subject||wr_content">
                    <input type="hidden" name="sop" value="and">
                    <input type="text" name="stx" id="sch_stx" placeholder="검색어(필수)" required maxlength="20">
                    <button type="submit" value="검색" id="sch_submit"><i class="fa fa-search"
                            aria-hidden="true"></i><span class="sound_only">검색</span></button>
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

                <button type="button" class="sch_cl_btn pc_view"><span class="sound_only">닫기</span><i
                        class="fa fa-times-circle-o"></i></button>
            </div>

            <?php echo popular('theme/basic'); // 인기검색어 ?>

        </div>
    </div>
</div>


<div class="latest_list">

    <?php echo latest("theme/false9_notice", 'free', 5, 30); ?>
    <?php echo latest_basic("theme/basic", "free", 10, 50, "", "", "365", "wr_id"); ?>
</div>




<!-- 게시판 목록 끝 -->