<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <title>폼메일보내기</title>
  <style>
    table {
      width: 100%;
      border: 1px solid #C4C4C4;
      border-collapse: collapse;
    }

    th {
      width: 20%;
      border: 1px solid #c4c4c4;
      background: #ebebeb;
      color: #383838;
      text-align: center;
      font-size: 1.083em;
    }

    td {
      border: 1px solid #dfdfdf;
      padding: 17px 5px;
      font-size: 1.083em;
      color: #666
    }

    btn_submit {
      border-radius: 3px;
      background: #3c95d5;
      border: 1px solid #3c95d5;
      padding: 10px 20px;
      font-size: 1.083em
    }
  </style>
</head>

<body>
  <form name="contactform" method="post" action="send.php">
    <table>
      <tr>
        <th scope="row">
          <label for="first_name">이름</label>
        </th>
        <td width="80%">

          <input name="first_name" type="text" class="ipt" style="height:20px" size="30" maxlength="50" required>
        </td>
      </tr>

      <tr>
        <th scope="row">
          <label for="email">이메일 주소</label>
        </th>
        <td>
          <input name="email" type="text" class="ipt" style="height:20px" size="30" maxlength="80" required>
        </td>
      </tr>
      <tr>
        <th scope="row">
          <label for="telephone">연락처</label>
        </th>
        <td>
          <input name="telephone" type="text" class="ipt" style="height:20px" size="30" maxlength="30" required>
        </td>
      </tr>
      <tr>
        <th scope="row">
          <label for="comments">문의내용</label>
        </th>
        <td height="170" valign="bottom">
          <textarea name="comments" cols="50" rows="10" style="width:95%" required></textarea>
        </td>
      </tr>
      <tr>
        <td height="40" colspan="2" style="text-align:center">
          <input type="submit" value="전송하기" class="btn_submit">
          <input name="재설정" type="reset" value="다시작성" class="btn_submit">
        </td>
      </tr>
    </table>
  </form>
</body>

</html>