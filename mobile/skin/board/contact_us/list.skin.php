<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">

<html>

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <title>폼메일보내기</title>
  <style>
    table {
      width: 100%;

    }



    th {
      display: none;
    }

    .btn_submit {
      border-radius: 3px;
      background: #3c95d5;
      border: 1px solid #3c95d5;
      padding: 10px 20px;
      font-size: 1.083em
    }

    .mail_form {
      width: 100%;
      max-width: 900px;
      margin: 0 auto;
    }

    .mail_form .mail_tit {
      padding-top: 50px;
      padding-bottom: 40px;
      font-weight: 700;
      font-size: 24px;
      line-height: 30px;
      text-align: center;
      letter-spacing: -0.6px;
      color: #FFFFFF;
    }
  </style>
</head>

<body>
  <div class="mail_form">
    <div class="mail_tit">
      <h1>문의하기</h1>
    </div>
    <form name="contactform" method="post" action="send.php">
      <table>
        <tr>
          <th scope="row">
            <label for="email">이메일 주소</label>
          </th>
          <td>
            <input name="email" type="text" class="ipt" size="30" style="width:100%; height:50px;" maxlength="80"
              placeholder="텍스트" required>
          </td>
        </tr>

        <tr>
          <th scope="row">
            <label for="toggleform">유형</label>
          </th>
          <td>
            <select name="toggleform" id="" style="width:100%" required>
              <option value="광고 문의">광고 문의</option>
              <option value="이용 문의">이용 문의</option>
              <option value="오류 신고" selected>오류 신고</option>
              <option value="계정 문의">계정 문의</option>
              <option value="건의 사항">건의 사항</option>
              <option value="기타">기타</option>
            </select>
          </td>
        </tr>


        <tr>
          <th scope="row">
            <label for="comments">문의내용</label>
          </th>
          <td height="170" valign="bottom">
            <textarea name="comments" cols="50" rows="10" style="width:100%" required></textarea>
          </td>
        </tr>
        <tr>
          <td height="40" colspan="2" style="text-align:center">
            <input type="submit" value="전송하기" class="btn_submit">
          </td>
        </tr>
      </table>
    </form>
  </div>
</body>

</html>