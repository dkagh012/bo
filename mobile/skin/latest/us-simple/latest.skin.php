
<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$latest_skin_url.'/style.css?version=2021042403">', 0);
$list_count = (is_array($list) && $list) ? count($list) : 0;
?>

<div class="list_lat">
    <h2 class="list_lat_title"><a href="<?php echo get_pretty_url($bo_table); ?>"><?php echo $bo_subject ?></a></h2>
    <ul>
    <?php for ($i=0; $i<$list_count; $i++) {  ?>
        <li class="list_basic_li">
			<!-- <span class="list_lt_date"><?php 
            // echo $list[$i]['datetime2'] 
            ?></span>     -->
        <div class="list_lat_ca">
        <?php if ($is_category && $list[$i]['ca_name'])  ?> <p class="bo_cate_link"><?php echo $list[$i]['ca_name'] ; ?>
            
        </div>
        <div class="lat_tit">
            
        <div class="lat_tit_o"></div>
            <?php
            
    
            if ($list[$i]['icon_secret']) echo "<i class=\"fa fa-lock\" aria-hidden=\"true\"></i><span class=\"sound_only\">비밀글</span> ";

            echo "<a href=\"".get_pretty_url($bo_table, $list[$i]['wr_id'])."\"> ";
            
            if ($list[$i]['is_notice'])
                echo "<strong>".$list[$i]['subject']."</strong>";
            else
            
                echo $list[$i]['subject'];

            echo "</a>";
			

            // if ($list[$i]['link']['count']) { echo "[{$list[$i]['link']['count']}]"; }
            // if ($list[$i]['file']['count']) { echo "<{$list[$i]['file']['count']}>"; }



            if ($list[$i]['comment_cnt'])  echo "
            <span class=\"lt_cmt\"><span class=\"sound_only\">댓글</span>".$list[$i]['comment_cnt']."</span>";

            ?>
            
            </div>
			            <a href="<?php echo $list[$i]['href'] ?>">
										<?php echo cut_str(strip_tags($list[$i]['wr_content']), 100) ?>
									</a>
            <div class="list_lt_info">
				<span class="list_lt_nick"><?php echo $list[$i]['name'] ?></span>
            	<span class="list_lt_date"><?php echo $list[$i]['datetime2'] ?></span>              
            </div>
        </li>
    <?php }  ?>
    <?php if ($list_count == 0) { //게시물이 없을 때  ?>
    <li class="empty_li">게시물이 없습니다.</li>
    <?php }  ?>
    </ul>
    <a href="<?php echo get_pretty_url($bo_table); ?>" class="lt_more"><span class="sound_only"><?php echo $bo_subject ?></span>더보기</a>

</div>
