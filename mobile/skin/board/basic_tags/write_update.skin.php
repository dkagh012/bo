<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가

$wr_tags = $_POST['wr_tags'];
$sql = " update {$write_table} set wr_tags = '$wr_tags' where wr_id = '$wr_id' ";
sql_query($sql);

?>