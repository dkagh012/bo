<?php
if ( ! defined( '_GNUBOARD_' ) )
	exit; // 개별 페이지 접근 불가
include_once( G5_LIB_PATH . '/thumbnail.lib.php' );

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet( '<link rel="stylesheet" href="' . $board_skin_url . '/style.css">', 0 );
add_stylesheet( '<link rel="stylesheet" href="' . G5_THEME_CSS_URL . '/board.css">', 0 );
?>

<link rel="stylesheet" href="<?php echo G5_THEME_CSS_URL; ?>/jquery.wookmark.css">
<style>

</style>

<!-- 게시판 목록 시작 { -->
<div id="bo_list">

	<h2 class="sound_only">
		<?php echo $board[ 'bo_subject' ]; ?>
	</h2>

	<?php if ( $is_category ) { ?>
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
		echo latest( 'theme/photo_basic', 'ani', 3, 23 );
		?>


		<div id="photo_type">
			<h2 class="sound_only">
				<?php echo $board[ 'bo_subject' ] ?> 목록</caption>
			</h2>

			<ul class="tiles" id="ajax_data">
				<?php for ( $i = 0; $i < count( $list ); $i++ ) { ?>
					<li class="titles_list">
						<a class="titles_img" href="<?php echo $list[ $i ][ 'href' ] ?>">
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
						</a>

						<div class="con_title">
							<div class="con">
								<?php if ( $is_category && $list[ $i ][ 'ca_name' ] ) { ?>
									<p class="bo_cate_link">
										<?php echo $list[ $i ][ 'ca_name' ] ?>
									</p>
								<?php } ?>
								<p class="subject">
									<?php echo $list[ $i ][ 'subject' ] ?>
							</div>

							<div class="cont2">
								<p class="content">
									<a href="<?php echo $list[ $i ][ 'href' ] ?>">
										<?php echo cut_str( strip_tags( $list[ $i ][ 'wr_content' ] ), 100 ) ?>
									</a>
								</p>
							</div>
							<div class="cont3">
								<span class="sound_only">작성일</span>
								<?php echo $list[ $i ][ 'datetime' ]; ?>
							</div>

						</div>
						<!--<a href="<?php echo $list[ $i ][ 'href' ] ?>" class="btn_detail">
																																											<div class="detail"><i class="xi-library-books-o xi-x xi-4x"></i><br>DETAIL VIEW.</div>
																																										</a>-->



					</li>
				<?php } ?>
				<?php if ( count( $list ) == 0 ) {
					echo '<li class="empty_table" datano="no">게시물이 없습니다.</li>';
				} ?>
			</ul>
		</div>

		<?php if ( $list_href || $is_checkbox || $write_href ) { ?>
			<div class="bo_fx">
				<?php if ( $list_href || $write_href ) { ?>
					<ul class="btn_bo_user">
						<?php if ( $admin_href ) { ?>
							<!-- <li><a href="<?php echo $admin_href ?>" class="btn btn_admin" title="관리자">관리자</a></li> -->
						<?php } ?>
						<?php if ( $member[ 'mb_level' ] == 10 ) { ?>
							<?php if ( $write_href ) { ?>
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
	<div class="more_Btn">
		<div class="more_button">더보기 more</div>
		<div class="spinner"></div>
	</div>
	<!-- 게시판 검색 시작 { -->
	<div class="bo_sch_wrap">
		<fieldset class="bo_sch">
			<form name="fsearch" method="get">
				<input type="hidden" name="bo_table" value="<?php echo $bo_table ?>">
				<input type="hidden" name="sca" value="<?php echo $sca ?>">
				<input type="hidden" name="sop" value="and">
		</fieldset>
	</div>


	<!-- } 게시판 검색 끝 -->
</div>

<?php if ( $is_checkbox ) { ?>
	<noscript>
		<p>자바스크립트를 사용하지 않는 경우<br>별도의 확인 절차 없이 바로 선택삭제 처리하므로 주의하시기 바랍니다.</p>
	</noscript>
<?php } ?>


<!-- 페이지 -->
<?php echo $write_pages; ?>

<script>

	const more = document.querySelector('.more_button');
	const spin = document.querySelector('.spinner');
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
						// more.style.display = "none";
						$(".pg_current").html(parseInt(page_n) + 1);
						// $(".more_button").html("더 보기");
					} else {
						more.style.display = "block";
						spin.style.display = "none";
						$(".more_button").html("더 이상 게시글이 없습니다.");
					}
				})
			}, 1000)
		}
	})
	$(window).scroll(function () {
		if ((window.innerHeight + window.scrollY + 1) >= document.body.scrollHeight) {
			// more.style.display = "none";
			console.log("테스트");
		}
	});

</script>
<!-- } 게시판 목록 끝 -->