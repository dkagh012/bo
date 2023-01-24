<?php
if (!defined('_GNUBOARD_'))
	exit; // 개별 페이지 접근 불가
include_once(G5_LIB_PATH . '/thumbnail.lib.php');

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="' . $board_skin_url . '/style.css">', 0);
add_stylesheet('<link rel="stylesheet" href="' . G5_THEME_CSS_URL . '/board.css">', 0);
?>

<link rel="stylesheet" href="<?php echo G5_THEME_CSS_URL; ?>/jquery.wookmark.css">
<style>

</style>

<!-- 게시판 목록 시작 { -->
<div id="bo_list">

	<h2 class="sound_only">
		<?php echo $board['bo_subject']; ?>
	</h2>

	<?php if ($is_category) { ?>
		<!-- 게시판 카테고리 시작 { -->

		<!-- } 게시판 카테고리 끝 -->
	<?php } ?>

	<form name="fboardlist" id="fboardlist" action="<?php echo G5_BBS_URL; ?>/board_list_update.php"
		onsubmit="return fboardlist_submit(this);" method="post">

		<input type="hidden" name="bo_table" value="<?php echo $bo_table ?>">
		<input type="hidden" name="sfl" value="<?php echo $sfl ?>">
		<input type="hidden" name="stx" value="<?php echo $stx ?>">
		<input type="hidden" name="spt" value="<?php echo $spt ?>">
		<input type="hidden" name="sca" value="<?php echo $sca ?>">
		<input type="hidden" name="sst" value="<?php echo $sst ?>">
		<input type="hidden" name="sod" value="<?php echo $sod ?>">
		<input type="hidden" name="page" value="<?php echo $page ?>">
		<input type="hidden" name="sw" value="">

		<!-- 게시판 페이지 정보 및 버튼 시작 { -->



		<?php
		echo latest('theme/photo_basic', 'ani', 3, 23);
		?>


		<div id="photo_type">
			<h2 class="sound_only">
				<?php echo $board['bo_subject'] ?> 목록</caption>
			</h2>

			<ul id="tiles">
				<?php for ($i = 3; $i < count($list); $i++) { ?>
					<li class="titles_list">
						<a class="titles_img" href="<?php echo $list[$i]['href'] ?>">
							<?php
							if ($list[$i]['is_notice']) { // 공지사항
								$img_content = '<img src="' . $board_skin_url . '/img/notice.jpg">';
							} else {
								$thumb = get_list_thumbnail($board['bo_table'], $list[$i]['wr_id'], $board['bo_gallery_width'], $board['bo_gallery_height'], true, true);

								if ($thumb['src']) {
									$img_content = '<img src="' . $thumb['src'] . '" alt="' . $thumb['alt'] . '" >';
								} else {
									$img_content = '<img src="' . $board_skin_url . '/img/noimg.jpg">';
								}
							}
							echo $img_content;
							?>
						</a>

						<div class="con_title">
							<div class="con">
								<?php if ($is_category && $list[$i]['ca_name']) { ?>
									<p class="bo_cate_link">[<?php echo $list[$i]['ca_name'] ?>]
									</p>
								<?php } ?>
								<p class="subject">
									<?php echo $list[$i]['subject'] ?>
							</div>

							<div class="cont2">
								<p class="content">
									<a href="<?php echo $list[$i]['href'] ?>">
										<?php echo cut_str(strip_tags($list[$i]['wr_content']), 100) ?>
									</a>
								</p>
							</div>
							<div class="cont3">
								<span class="sound_only">작성일</span>
								<?php echo $list[$i]['datetime']; ?>
							</div>

						</div>
						<!--<a href="<?php echo $list[$i]['href'] ?>" class="btn_detail">
							<div class="detail"><i class="xi-library-books-o xi-x xi-4x"></i><br>DETAIL VIEW.</div>
						</a>-->



					</li>
				<?php } ?>
				<?php if (count($list) == 0) {
					echo '';
				} ?>
			</ul>
		</div>


		<?php if ($list_href || $is_checkbox || $write_href) { ?>
			<div class="bo_fx">
				<?php if ($list_href || $write_href) { ?>
					<ul class="btn_bo_user">
						<?php if ($admin_href) { ?>
							<!-- <li><a href="<?php echo $admin_href ?>" class="btn btn_admin" title="관리자">관리자</a></li> -->
						<?php } ?>
						<?php if ($member['mb_level']==10) { ?>
							<?php if ($write_href) { ?>
								<li>
									<a href="<?php echo $write_href ?>" class="btn btn_act" title="글쓰기">
									<i class="xi-pen-o xi-1x"></i></a>
								</li>
							<?php } ?>
						<?php } ?>
					</ul>
				<?php } ?>
			</div>
		<?php } ?>
	</form>

	<?php echo $write_pages; ?>

	<!-- 게시판 검색 시작 { -->
	<div class="bo_sch_wrap">
		<fieldset class="bo_sch">
			<form name="fsearch" method="get">
				<input type="hidden" name="bo_table" value="<?php echo $bo_table ?>">
				<input type="hidden" name="sca" value="<?php echo $sca ?>">
				<input type="hidden" name="sop" value="and">
		</fieldset>
	</div>


	<script>
		jQuery(function ($) {
			var select = $('.sch_select select');
			select.change(function () {
				var select_name = $(this).children('option:selected').text();
				$(this).siblings("label").text(select_name);
			});
		});
	</script>
	<!-- } 게시판 검색 끝 -->
</div>

<?php if ($is_checkbox) { ?>
	<noscript>
		<p>자바스크립트를 사용하지 않는 경우<br>별도의 확인 절차 없이 바로 선택삭제 처리하므로 주의하시기 바랍니다.</p>
	</noscript>
<?php } ?>

<script src="<?php echo G5_THEME_JS_URL; ?>/jquery.imagesloaded.js"></script>
<script src="<?php echo G5_THEME_JS_URL; ?>/jquery.wookmark.js"></script>


<script>



	<?php if ($is_checkbox) { ?>
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

			if (sw == "copy")
				str = "복사";
			else
				str = "이동";

			var sub_win = window.open("", "move", "left=50, top=50, width=500, height=550, scrollbars=1");

			f.sw.value = sw;
			f.target = "move";
			f.action = g5_bbs_url + "/move.php";
			f.submit();
		}

		// 게시판 리스트 관리자 옵션
		jQuery(function ($) {
			$(".btn_more_opt.is_list_btn").on("click", function (e) {
				e.stopPropagation();
				$(".more_opt.is_list_btn").toggle();
			});
			$(document).on("click", function (e) {
				if (!$(e.target).closest('.is_list_btn').length) {
					$(".more_opt.is_list_btn").hide();
				}
			});
		});
<?php } ?>
</script>
<!-- } 게시판 목록 끝 -->