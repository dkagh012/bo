<?php
if (!defined('_GNUBOARD_')) exit;
add_stylesheet('<link rel="stylesheet" href="'.$latest_skin_url.'/style.css">', 0);
?>

<div class="main_latest">
	<div class="main_latest_div">

		<div class="li01">
			<div class="li01_1">
				<a href="<?php echo G5_BBS_URL ?>/board.php?bo_table=<?php echo $bo_table ?>"><?php echo $bo_subject; ?></a>
			</div>

			<div class="li01_txt">
				<div class="block">
					<ul id="ticker">

			
  <?php for ($i=0; $i<count($list); $i++) {  ?>
    <li><a href="<?php echo $list[$i]['href']?>" title="<?php echo $list[$i]['subject']?>">
      <?php
      if ($list[$i]['is_notice'])
        echo "<strong>".$list[$i]['subject']."</strong>";
      else
        echo $list[$i]['subject'];
      //if ($list[$i]['comment_cnt'])
        //echo ' '.$list[$i]['comment_cnt'];
      // if ($list[$i]['link']['count']) { echo "[{$list[$i]['link']['count']}]"; }
      // if ($list[$i]['file']['count']) { echo "<{$list[$i]['file']['count']}>"; }
      //if (isset($list[$i]['icon_new'])) echo "&nbsp; " . $list[$i]['icon_new'];
      // if (isset($list[$i]['icon_hot'])) echo " " . $list[$i]['icon_hot'];
      // if (isset($list[$i]['icon_file'])) echo " " . $list[$i]['icon_file'];
      // if (isset($list[$i]['icon_link'])) echo " " . $list[$i]['icon_link'];
      // if (isset($list[$i]['icon_secret'])) echo " " . $list[$i]['icon_secret'];
      // echo '<span class="datetime">'.$list[$i]['wr_name'].' &nbsp;'.$list[$i]['datetime2'].'</span>';
      ?>
      <!--span class="datetime"><?php echo $list[$i]['datetime2']?></span-->
    </a></li>
  <?php } ?>
  <?php if (count($list) == 0) { ?>
  <li>등록된 게시물이 없습니다.</li>
  <?php } ?>

					</ul>
				</div>
			</div>
		</div>
	</div>
</div>

<script>
jQuery(function($)
{
    var ticker = function()
    {
        timer = setTimeout(function(){
            $('#ticker li:first').animate( {marginTop: '-30px'}, 400, function()
            {
                $(this).detach().appendTo('ul#ticker').removeAttr('style');
            });
            ticker();
        }, 2000);
      };

      $(document).on('click','.prev',function(){
        $('#ticker li:last').hide().prependTo($('#ticker')).slideDown();
        clearTimeout(timer);
        ticker();
        if($('.pause').text() == 'Unpause'){
          tickerUnpause();
        };
      });


      $(document).on('click','.next',function(){
            $('#ticker li:first').animate( {marginTop: '-30px'}, 400, function()
                    {
                        $(this).detach().appendTo('ul#ticker').removeAttr('style');
                    });
            clearTimeout(timer);
            ticker();
            
            if($('.pause').text() == 'Unpause'){
              tickerUnpause();
            };
          });


	var tickerUnpause = function()
	{
		$('.pause').text('Pause');
	};


    var tickerpause = function()
  {
    $('.pause').click(function(){
      $this = $(this);
      if($this.text() == 'Pause'){
        $this.text('Unpause');
        clearTimeout(timer);
      }
      else {
        tickerUnpause();
      }
    });
  };
  tickerpause();
	var tickerover = function(event)
	{
		$('#ticker').mouseover(function(){
			clearTimeout(timer);
		});
		$('#ticker').mouseout(function(){
			ticker();
		});
	};
	tickerover();
	ticker();
});
</script>
