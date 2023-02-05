<meta charset="utf-8">
<?php
if ( isset( $_POST[ 'email' ] ) ) {


  $email_to      = "5064664@naver.com";
  $email_subject = "[폼메일] 문의사항입니다.";
  $email_subject = '=?UTF-8?B?' . base64_encode( $email_subject ) . '?=';



  function died( $error )
  {
    // your error code can go here
    echo "<script> alert('메일발송을 실패하였습니다.');";
    echo "history.go(-1);";
    echo "</script>";
    die();
  }

  // validation expected data exists
  if (
    // ! isset( $_POST[ 'first_name' ] ) ||
    ! isset( $_POST[ 'email' ] ) ||
    ! isset( $_POST[ 'comments' ] ) ||
    ! isset( $_POST[ 'toggleform' ] )
  ) {
    died( 'We are sorry, but there appears to be a problem with the form you submitted.' );
  }

  // $first_name    = $_POST[ 'first_name' ]; // required
  $email_from    = $_POST[ 'email' ]; // required
  $comments      = $_POST[ 'comments' ]; // required
  $toggleform    = $_POST[ 'toggleform' ]; // required

  $error_message = "";
  $email_exp     = '/^[A-Za-z0-9._%-]+@[A-Za-z0-9.-]+.[A-Za-z]{2,4}$/';
  if ( ! preg_match( $email_exp, $email_from ) ) {
    $error_message .= 'The Email Address you entered does not appear to be valid.<br />';
  }

  if ( strlen( $comments ) < 2 ) {
    $error_message .= 'The Comments you entered do not appear to be valid.<br />';
  }
  if ( strlen( $error_message ) > 0 ) {
    died( $error_message );
  }
  $email_message = "";

  function clean_string( $string )
  {
    $bad = array( "content-type", "bcc:", "to:", "cc:", "href" );
    return str_replace( $bad, "", $string );
  }

  $email_message .= "이메일 : " . clean_string( $email_from ) . "\n\n";
  $email_message .= "문의사항 : " . clean_string( $comments ) . "\n\n";
  $email_message .= "문의사항 : " . clean_string( $toggleform ) . "\n\n";


  // create email headers
  $headers       = 'From: ' . $email_from;
  // 제목이 깨질경우 아래 캐릭터셋 적용

  @mail( $email_to, $email_subject, $email_message, $headers );
  ?>

  <!-- include your own success html here -->

  <script>
    location.href = '../';
  </script>

  <?php
}
?>