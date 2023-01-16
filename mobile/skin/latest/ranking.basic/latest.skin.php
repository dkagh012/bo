<?php
if (! defined("_GNUBOARD_"))
    exit(); // 개별 페이지 접근 불가

    add_stylesheet('<link rel="stylesheet" href="'.$latest_skin_url.'/style.css">', 0);
    // $setStartDay = 30; 오늘날짜 $setEndDay = 30 어제날짜
    function ranking_list($setStartDay = 0, $setEndDay = 0, $order_by, $skin_dir = '', $bo_table, $rows = 10, $subject_len = 40, $cache_time = 1, $options = '')
    {
    

    global $g5;

    if (! $skin_dir)
        $skin_dir = 'basic';

    if (preg_match('#^theme/(.+)$#', $skin_dir, $match)) {
        if (G5_IS_MOBILE) {
            $latest_skin_path = G5_THEME_MOBILE_PATH . '/' . G5_SKIN_DIR . '/latest/' . $match[1];
            if (! is_dir($latest_skin_path))
                $latest_skin_path = G5_THEME_PATH . '/' . G5_SKIN_DIR . '/latest/' . $match[1];
            $latest_skin_url = str_replace(G5_PATH, G5_URL, $latest_skin_path);
        } else {
            $latest_skin_path = G5_THEME_PATH . '/' . G5_SKIN_DIR . '/latest/' . $match[1];
            $latest_skin_url = str_replace(G5_PATH, G5_URL, $latest_skin_path);
        }
        $skin_dir = $match[1];
    } else {
        if (G5_IS_MOBILE) {
            $latest_skin_path = G5_MOBILE_PATH . '/' . G5_SKIN_DIR . '/latest/' . $skin_dir;
            $latest_skin_url = G5_MOBILE_URL . '/' . G5_SKIN_DIR . '/latest/' . $skin_dir;
        } else {
            $latest_skin_path = G5_SKIN_PATH . '/latest/' . $skin_dir;
            $latest_skin_url = G5_SKIN_URL . '/latest/' . $skin_dir;
        }
    }

    $caches = null;

    $Day_before_yesterday = date("Y-m-d", strtotime(date('Y-m-d') . ' -' . $setEndDay . ' day'));
    $Day_after_today = date("Y-m-d", strtotime(date('Y-m-d') . ' -' . $setStartDay . ' day'));

    if (G5_USE_CACHE) {
        $cache_file_name = "latest-{$bo_table}-{$skin_dir}-{$Day_before_yesterday}-{$Day_after_today}-" . g5_cache_secret_key();
        $caches = g5_get_cache($cache_file_name);
        $cache_list = isset($caches['list']) ? $caches['list'] : array();
        g5_latest_cache_data($bo_table, $cache_list);
    }

    if ($caches === false) {

        $list = array();

        $board = get_board_db($bo_table, true);

        $bo_subject = get_text($board['bo_subject']);
        $datetime = date('Y-m-d');
        $sql_search = "wr_datetime BETWEEN '" . $Day_before_yesterday . " 00:00:00' AND '" . $Day_after_today . " 23:59:59' OR wr_last BETWEEN '" . $Day_before_yesterday . " 00:00:00' AND '" . $Day_after_today . " 23:59:59'";
        $tmp_write_table = $g5['write_prefix'] . $bo_table; // 게시판 테이블 전체이름

        $sql = " select * from {$tmp_write_table} where $sql_search limit 0, {$rows} ";

        $result = sql_query($sql);
        for ($i = 0; $row = sql_fetch_array($result); $i ++) {
            try {
                unset($row['wr_password']); // 패스워드 저장 안함( 아예 삭제 )
            } catch (Exception $e) {}
            $row['wr_email'] = ''; // 이메일 저장 안함
            if (strstr($row['wr_option'], 'secret')) { // 비밀글일 경우 내용, 링크, 파일 저장 안함
                $row['wr_content'] = $row['wr_link1'] = $row['wr_link2'] = '';
                $row['file'] = array(
                    'count' => 0
                );
            }
            $list[$i] = get_list($row, $board, $latest_skin_url, $subject_len);

            $list[$i]['first_file_thumb'] = (isset($row['wr_file']) && $row['wr_file']) ? get_board_file_db($bo_table, $row['wr_id'], 'bf_file, bf_content', "and bf_type between '1' and '3'", true) : array(
                'bf_file' => '',
                'bf_content' => ''
            );
            $list[$i]['bo_table'] = $bo_table;
            // 썸네일 추가
            if ($options && is_string($options)) {
                $options_arr = explode(',', $options);
                $thumb_width = $options_arr[0];
                $thumb_height = $options_arr[1];
                $thumb = get_list_thumbnail($bo_table, $row['wr_id'], $thumb_width, $thumb_height, false, true);
                // 이미지 썸네일
                if ($thumb['src']) {
                    $img_content = '<img src="' . $thumb['src'] . '" alt="' . $thumb['alt'] . '" width="' . $thumb_width . '" height="' . $thumb_height . '">';
                    $list[$i]['img_thumbnail'] = '<a href="' . $list[$i]['href'] . '" class="lt_img">' . $img_content . '</a>';
                    // } else {
                    // $img_content = '<img src="'. G5_IMG_URL.'/no_img.png'.'" alt="'.$thumb['alt'].'" width="'.$thumb_width.'" height="'.$thumb_height.'" class="no_img">';
                }
            }
        }
        g5_latest_cache_data($bo_table, $list);

        if (G5_USE_CACHE) {

            $caches = array(
                'list' => $list,
                'bo_subject' => sql_escape_string($bo_subject)
            );

            g5_set_cache($cache_file_name, $caches, 3600 * $cache_time);
        }
    } else {
        $list = $cache_list;
        $bo_subject = (is_array($caches) && isset($caches['bo_subject'])) ? $caches['bo_subject'] : '';
    }

    ob_start();
    $content = ob_get_contents();
    ob_end_clean();

    return $list;
}
$today_list = array();
$yesterday_list = array();
$sql = " select bo_table
                from `{$g5['board_table']}` a left join `{$g5['group_table']}` b on (a.gr_id=b.gr_id)
                where a.bo_device <> 'mobile' ";
if (! $is_admin)
    $sql .= " and a.bo_use_cert = '' ";
$sql .= " and a.bo_table not in ('notice', 'gallery') "; // 공지사항과 갤러리 게시판은 제외
$sql .= " order by b.gr_order, a.bo_order ";
$result = sql_query($sql);
for ($i = 0; $i < 10; $i ++) { //0~10까지의 날짜를 검색합니다
    for ($i = 0; $row = sql_fetch_array($result); $i ++) {
        $today = ranking_list($i, $i, 'ORDER BY wr_datetime DESC', $row['bo_table'] . '_write', $row['bo_table'], 9990, 10000);
        $today_list = array_merge($today_list, $today);
        $yesterday = ranking_list(1 + $i, 1 + $i, 'ORDER BY wr_datetime DESC', $row['bo_table'] . '_write', $row['bo_table'], 9990, 10000);
        $yesterday_list = array_merge($yesterday_list, $yesterday);
    }
    if (count($today) > 0 || $today_list > 0)
        break;
        if (count($today) == 0 || $today_list == 0) {
        $today = array();
        $today_list = array();
        $yesterday = array();
        $yesterday_list = array();
    }
}
/*
 * $list = unique_multidim_array($list, 'ca_name');
 * $count = 0;
 * foreach ($list as $key => $val) {
 * if(strlen($val['ca_name']) > 1) {
 * if (count($list) - 1 > $count)
 * echo rtrim(ltrim($val['ca_name'])) . ',';
 * else
 * echo rtrim(ltrim($val['ca_name'])) . '';
 * $count ++;
 * }
 * }
 */
foreach ($today_list as $key => $value) {
    $sort_youtube_list[$key] = $value['wr_hit'];
}
array_multisort($sort_youtube_list, SORT_DESC, $today_list);
foreach ($yesterday_list as $key => $value) {
    $sort_youtube_list[$key] = $value['wr_hit'];
}
array_multisort($sort_youtube_list, SORT_DESC, $yesterday_list);
$list = $today_list;
// 오늘 날짜 - > id > 어제 날짜 - > id
$count = 0;
for ($i = 0; $i < count($today_list); $i ++) {
    $today_list[$i]['ranking'] = 0;
    if ($count < 10) {
        $count ++;
        $counts = 0;
        foreach ($yesterday_list as $keys => $values) {
            $counts ++;
            if ($today_list[$i]['wr_subject'] == $values['wr_subject']) {
                $today_list[$i]['ranking'] = $counts - $count;
                break;
            }
        }
    }
}
?>
<style>
#ranking {
	width: 100%;
}

#ranking ul {
	background-color: #eaeaea;
}

#ranking h2 {
	line-height: 1.6rem;
	border-radius: 3px;
	background: #5a5a5a;
	color: #eaeaea;
	font-size: 1.1rem;
	font-family: tahoma;
	font-weight: bolder;
	text-align: center;
}

#ranking li {
	width: 100%;
	overflow: hidden;
	white-space: nowrap;
}

#ranking li div {
	overflow: hidden;
	white-space: nowrap;
	font-weight: bold;
	color: #8a8a8a;
}

.marquee-number {
	width: 15%;
	float: left;
	padding: 5px;
	margin: 3%;
	text-align: center;
	font-size: 18px;
	font-weight: bolder;
	background-color: #4e3232;
	color: white;
	line-height: 1.6rem;
	border-radius: 3px;
	background: #5a5a5a;
	color: #fff;
	font-size: 0.8rem;
	font-family: tahoma;
	font-weight: normal;
	text-align: center;
} /* //21 6 + 27 100  */
.marquee-title {
	width: 60%;
	float: left;
	padding: 5px;
	margin: 3%;
	margin-left: 0;
	margin-right: 0;
	line-height: 1.6rem;
	border-radius: 3px 0 0 3px;
	background: #f5f5f5;
	color: #000;
	font-size: 0.8rem;
	font-family: tahoma;
	font-weight: normal;
	text-align: center;
}

#ranking .ranking-number {
	width: 16%;
	float: right;
	padding: 5px;
	/* margin: 3%; */
	margin-left: 0;
	line-height: 2.5rem;
	border-radius: 0 3px 3px 0;
	background: #f5f5f5;
	color: #000;
	font-size: 0.8rem;
	font-family: tahoma;
	font-weight: normal;
	text-align: center;
}

#ranking .box {
	/*     padding: 10px;
    border: 1px solid black; */
	border: 2px solid #c7c7c7;
}

#ranking  strong {
	
}

#ranking i.fa-arrow-up {
	background: rgb(131, 58, 180);
	background: linear-gradient(90deg, rgba(131, 58, 180, 1) 0%,
		rgba(253, 29, 29, 1) 98%, rgba(252, 176, 69, 1) 100%);
	color: white;
}

#ranking i.fa-arrow-down {
	background: rgb(34, 193, 195);
	background: linear-gradient(0deg, rgba(34, 193, 195, 1) 0%,
		rgba(65, 192, 174, 1) 14%, rgba(113, 191, 141, 1) 36%,
		rgba(150, 190, 122, 0.33657212885154064) 49%, rgba(166, 190, 105, 1)
		60%, rgba(205, 189, 78, 1) 78%, rgba(220, 188, 68, 1) 85%,
		rgba(253, 187, 45, 1) 100%);
	color: white;
	color: white;
}

#ranking .up {
	color: #ff4040;
}

#ranking .down {
	color: #4060ff;
}

marquee {
	display: flex;
	justify-content: center;
	align-items: center;
}
</style>
<!-- 인기검색어 시작 { -->
<section id="ranking">
	<div class="box">
		<h2 style="text-align: center;">조회수 순위</h2>
		<ul>
	    <?php
    $count = 0;
    foreach ($today_list as $key => $val) {
        if ($count < 10) {
            $count ++;
            ?>
	        <li>
				<div class="marquee-number"><?=$count?></div>
				<div class="marquee-title">
					<a href="<?=$val['href']?>"><MARQUEE behavior="scroll"
							scrollamount="1" direction="left"><?=$val['wr_subject']?></MARQUEE>
					</a>
				</div>
				<div class="ranking-number">
					<?php if($val['ranking']==0) { ?>
						-
					<?php } ?>
					<?php if($val['ranking']>0) {?>
						<strong><span class="up"><i class="fa fa-arrow-up"
							aria-hidden="true"></i><?=$val['ranking']?></span></strong>
					<?php } ?> 
					<?php if($val['ranking']<0) {?>
						<strong><span class="down"><i class="fa fa-arrow-down"
							aria-hidden="true"></i><?=$val['ranking']?></span></strong>
					<?php } ?> 
				</div>
			</li>
	        
	        <?php
        }
    } // end foreach
    ?>
	    </ul>
	</div>
</section>
<script src="<?=$latest_skin_url?>/jquery.plugin/gistfile1.js"></script>
<script>
$(function () {
    $('marquee').marquee('pointer').mouseover(function () {    
       $(this).trigger('stop');
   }).mouseout(function () {
       $(this).trigger('start');
   }).mousemove(function (event) {
       if ($(this).data('drag') == true) {
           this.scrollLeft = $(this).data('scrollX') + ($(this).data('x') - event.clientX);
       }
   }).mousedown(function (event) {
       $(this).data('drag', true).data('x', event.clientX).data('scrollX', this.scrollLeft);
   }).mouseup(function () {
       $(this).data('drag', false);
   });
});


/* $("marquee").hover(function () { 
    this.stop();
}, function () {
    this.start();
}); */
</script>