<?php
if (!defined('_GNUBOARD_'))
  exit; // 개별 페이지 접근 불가
include_once(G5_LIB_PATH . '/thumbnail.lib.php');

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="' . $latest_skin_url . '/style.css">', 0);
$thumb_width = 500;
$thumb_height = 350;
?>
<div class="hit_box">
  <div class="latest_hit_box">
    <a href="<?php echo get_pretty_url($bo_table); ?>" class="lt_title"><strong>실시간 베스트</strong></a>
  </div>
  <div class="lt_box">
    <ul>
      <?php
      for ($i = 0; $i < count($list); $i++) {
        $thumb = get_list_thumbnail($bo_table, $list[$i]['wr_id'], $thumb_width, $thumb_height, false, true);

        if ($thumb['src']) {
          $img = $thumb['src'];
          $img_content = '<img src="' . $img . '" alt="' . $thumb['alt'] . '" >';
        }
        ?>
        <li>
          <div class="lt_info">
            <div>
              <?php echo "<a href=\"" . $list[$i]['href'] . "\" >"; ?>
              <p>[<?php echo $list[$i]['ca_name'] ?>]
              </p>
              <p>
                <?php echo $list[$i]['subject']; ?>
              </p>
            </div>
            <?php


            if ($list[$i]['icon_secret'])
              echo "<i class=\"fa fa-lock\" aria-hidden=\"true\"></i> ";
            if ($list[$i]['is_notice'])
              echo "<strong>" . $list[$i]['subject'] . "</strong>";
            else



              echo "</a>";

            ?>


            <div class="lt_info_title">
              <p>
                <span class="lt_info_view"><i class="xi-thumbs-up xi-1x" aria-hidden="true"></i>
                  <?php echo $list[$i]['wr_good'] ?>
                </span>
              </p>
              <p>
                <?php if ($list[$i]['comment_cnt']) { ?>
                  <span class="sound_only">댓글</span><i class="xi-speech-o xi-1x" aria-hidden="true"></i>
                  <?php echo $list[$i]['comment_cnt']; ?><span class="sound_only">개</span>
                <?php } ?>
              </p>
            </div>
          </div>
        </li>
      <?php } ?>
      <?php if (count($list) == 0) { //게시물이 없을 때 ?>
        <li class="empty_li">게시물이 없습니다.</li>
      <?php } ?>
    </ul>

  </div>
</div>