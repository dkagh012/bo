<?php
if (!defined('_GNUBOARD_'))
  exit; // 개별 페이지 접근 불가
include_once(G5_LIB_PATH . '/thumbnail.lib.php');

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="' . $latest_skin_url . '/style.css">', 0);
$thumb_width = 210;
$thumb_height = 150;
?>

<div class="photo_pic_lt">
  <ul>
    <?php
    for ($i = 0; $i < count($list); $i++) {
      $thumb = get_list_thumbnail($bo_table, $list[$i]['wr_id'], $thumb_width, $thumb_height, false, true);

      if ($thumb['src']) {
        $img = $thumb['src'];
      } else {
        $img = G5_IMG_URL . '/no_img.png';
        $thumb['alt'] = '이미지가 없습니다.';
      }
      $img_content = '<img src="' . $img . '" alt="' . $thumb['alt'] . '" >';
      ?>
      <li>
        <a href="<?php echo $list[$i]['href'] ?>" class="photo_lt_img"><?php echo $img_content; ?></a>
        <div class="photo_basic_title">

          <span class="bo_cate_link">[<?php echo $list[$i]['ca_name'] ?>]
          </span>
          <?php


          echo "<a href=\"" . $list[$i]['href'] . "\"> ";
          if ($list[$i]['is_notice'])
            echo "<strong>" . $list[$i]['subject'] . "</strong>";
          else
            echo $list[$i]['subject'];
          echo "</a>";
          ?>
        </div>
        <p class="photo_content">
          <a href="<?php echo $list[$i]['href'] ?>">
            <?php echo cut_str(strip_tags($list[$i]['wr_content']), 100) ?>
          </a>
        </p>
        <span class="photo_lt_date">
          <?php echo $list[$i]['datetime'] ?>
        </span>
      </li>
    <?php } ?>
    <?php if (count($list) == 0) { //게시물이 없을 때  ?>
      <li class="photo_empty_li">게시물이 없습니다.</li>
    <?php } ?>
  </ul>
  <a href="<?php echo get_pretty_url($bo_table); ?>" class="photo_lt_more"><span class="sound_only">
      <?php echo $bo_subject ?>
    </span><i class="fa fa-plus" aria-hidden="true"></i><span class="sound_only"> 더보기</span></a>

</div>