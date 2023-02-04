<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">

<html>

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <title>폼메일보내기</title>
  <style>
    table {
      width: 100%;

    }


    .hide {
      display: none;
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

    .toggleform {
      height: 50px;
      outline: none;
      border: none;
      background: #040B11;
    }

    .email>input::placeholder {
      color: #fff;
      font-size: 16px;
      line-height: 20px;
    }

    .toggleform select {
      height: 50px;
      font-size: 16px;
      outline: none;
      border: none;
      background: #040B11;
      color: white;
      font-weight: bold;
      padding: 15px 12px;
    }

    .comments_box {
      padding-top: 8px;
      display: block;
    }

    .ipt:focus {
      outline: none;
      font-size: 16px;
    }

    .comment_text {
      resize: none;
    }

    .comment_text:focus {
      outline: none;
      font-size: 16px;
    }

    .CommentArea {
      position: fixed;
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%);
      width: 100%;
      height: 100vh;
      background: rgba(0, 0, 0, .3);
      z-index: 12;
      line-height: 1.8em;
    }

    .CommentContents {
      position: fixed;
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%);
      width: 260px;
      height: 150px;
      padding: 1rem;
      background: #f8f8f8;
      border-radius: 1.5rem;
      z-index: 13;
      text-align: center;
    }

    .commnet_BTN {
      width: 100%;
      height: 50px;
      border: 1px solid var(--colorLogo);
      background: #040B11;
      color: var(--colorLogo);
      font-weight: 700;
      font-size: 16px;
      line-height: 20px;
      margin-top: 54px;
    }

    .comments_down {
      position: relative;
      width: 900px;
    }

    #Comment_Count {
      width: 100%;
      height: 42px;
      padding-right: 12px;
      background: #040B11;
      font-style: normal;
      font-weight: 400;
      font-size: 14px;
      line-height: 18px;
      text-align: right;
      color: #888888;
      position: absolute;
      bottom: -37px;
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
          <td class="email">
            <input name="email" type="text" class="ipt" size="30"
              style="width:100%; height:50px; background:#040B11;border:none; color:#fff;padding: 15px 12px;margin-bottom: 9px;font-size:16px;"
              maxlength="80" placeholder="답변 받으실 이메일 주소를 입력해주세요" onblur="this.placeholder='답변 받으실 이메일 주소를 입력해주세요'"
              required>
          </td>
        </tr>

        <tr>
          <th scope="row">
            <label for="toggleform">유형</label>
          </th>
          <td class="toggleform">
            <select name="toggleform" id="" style="width:100%" required>
              <option value="문의 유형" disabled selected style="display:none;">문의 유형</option>
              <option class="toggleItem" value="광고 문의">광고 문의</option>
              <option class="toggleItem" value="이용 문의">이용 문의</option>
              <option class="toggleItem" value="오류 신고">오류 신고</option>
              <option class="toggleItem" value="계정 문의">계정 문의</option>
              <option class="toggleItem" value="건의 사항">건의 사항</option>
              <option class="toggleItem" value="기타">기타</option>
            </select>
          </td>
        </tr>

        <tr class="comments_box">
          <th scope="row">
            <label for="comments">문의내용</label>
          </th>
          <td valign="bottom" class="comments_down">
            <textarea onkeyup="counter(this,3000)" class="comment_text" name="comments" cols="50" rows="10"
              maxlength="3000"
              style="width:100%; height:208px; background:#040B11;border:none; color:#fff;    padding: 12px 12px 0px 12px;font-size:16px;"
              required></textarea>
            <p id="Comment_Count">0 / 3000</p>
          </td>
        </tr>

        <div class="CommentArea hide">
          <div class="CommentContents">
            <!-- <h1 class="secretTitles">비밀번호를 입력해주세요</h1> -->
            <input type="submit" value="전송하기" class="btn_submit">
          </div>
        </div>

      </table>
    </form>
    <div>
      <button type="button" class="commnet_BTN">제출하기</button>
    </div>
  </div>
  <script>
    function counter(text, length) {
      var limit = length;
      var str = text.value.length;
      if (str > limit) {
        document.getElementById("Comment_Count").innerHTML = "1500자 이상 입력 했습니다";
        text.focus();
      }
      document.getElementById("Comment_Count").innerHTML = text.value.length + "/" + limit;
    }
    function popupToggle(toggleBtn, area) {
      if (document.querySelector(`.${toggleBtn}`) !== null) {
        const BTN = document.querySelector(`.${toggleBtn}`)
        const AREA = document.querySelector(`.${area}`)

        BTN.addEventListener('click', () => toggleClassList(AREA, 'hide'));


        AREA.addEventListener('click', (e) => {
          if (e.target.className === AREA.className) {
            toggleClassList(AREA, 'hide');
          };
        });
      };
    }

    popupToggle('commnet_BTN', 'CommentArea');

  </script>
</body>

</html>