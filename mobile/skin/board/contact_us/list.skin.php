<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">

<html>

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <title>폼메일보내기</title>
  <style>
    .mainTit {
      display: none;
    }

    .hide {
      display: none;
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

    .inner_BTN:focus {
      outline: none;
      font-size: 16px;
    }

    .comment_text {
      resize: none;
      background: #040B11;
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

    .ipt {
      width: 100%;
      height: 50px;
      background: #040B11;
      border: none;
      color: #fff;
      padding: 15px 12px;
      margin-bottom: 9px;
      font-size: 16px;
    }

    .CommentContents {
      position: fixed;
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%);
      width: 400px;
      height: 200px;
      padding-top: 40px;
      background: var(--colorBlack);
      z-index: 13;
      text-align: center;
    }

    .commnet_BTN {
      width: 100%;
      display: none;
      height: 50px;
      border: 1px solid var(--colorLogo);
      background: #040B11;
      color: var(--colorLogo);
      font-weight: 700;
      font-size: 16px;
      line-height: 20px;
      margin-top: 54px;
    }

    .notcommnet_BTN {
      display: block;
      width: 100%;
      height: 50px;
      border: 0;
      background: #040B11;
      color: var(--colorGray);
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

    .CommentTIT {
      font-weight: 700;
      font-size: 16px;
      line-height: 20px;
      letter-spacing: -0.4px;
      color: #FFFFFF;
      padding-bottom: 8px;
    }

    .CommentTITTE {
      font-weight: 400;
      font-size: 16px;
      line-height: 20px;
      letter-spacing: -0.4px;
      color: #888888;
      padding-bottom: 24px;
    }

    .CommentBTN {
      font-weight: 700;
      font-size: 16px;
      line-height: 20px;
      letter-spacing: -0.4px;
      color: #26E2B3;
      padding: 12px 48px;
      background: transparent;
      border: 1px solid var(--colorLogo);
      cursor: pointer;
    }

    .Comment_lower {
      padding-top: 32px;
      text-align: center;
    }

    .Comment_lower>h1 {
      font-weight: 400;
      font-size: 14px;
      line-height: 18px;
      padding-bottom: 8px;
      color: #FFFFFF;
    }

    .Comment_lower>p {
      font-weight: 400;
      font-size: 14px;
      line-height: 18px;
      text-align: center;
      color: #888888;
    }

    .desc_padding {
      display: none;
      padding-top: 50px;
    }

    .Cotact_desc {
      text-align: right;
      padding-bottom: 24px;
    }

    .email_form {
      display: none;
    }

    .Cotact_desc>h1 {
      font-weight: 500;
      font-size: 14px;
      line-height: 18px;
      color: var(--colorLogo);
      line-height: 18px;
    }

    .Usertext_BOX {
      display: none;
    }
  </style>
</head>

<body>
  <div class="mail_Container">
    <div class="mail_form">
      <div class="mail_tit">
        <h1>문의하기</h1>
      </div>
      <form name="contactform" method="post" action="send.php">
        <div>
          <div>
            <div class="mainTit">
              <label>이메일 주소</label>
            </div>
            <div class="email">
              <input name="email" type="email" class="ipt" size="30" id="email" maxlength="80"
                placeholder="답변 받으실 이메일 주소를 입력해주세요" onblur="this.placeholder='답변 받으실 이메일 주소를 입력해주세요'" required>
              <!-- <button onclick="check_email()">확인</button> -->
            </div>
            <div class="Cotact_desc email_form">
              <h1>이메일을 확인해주세요</h1>
            </div>
          </div>

          <div>
            <div>
              <label class="mainTit">유형</label>
            </div>
            <div class="toggleform">
              <select name="toggleform" id="Mail_Select" style="width:100%" onchange="toggle(this.value)" required>
                <option value="문의 유형" disabled selected style="display:none;">문의 유형</option>
                <option class="toggleItem" value="광고 문의">광고 문의</option>
                <option class="toggleItem" value="이용 문의">이용 문의</option>
                <option class="toggleItem" value="오류 신고">오류 신고</option>
                <option class="toggleItem" value="계정 문의">계정 문의</option>
                <option class="toggleItem" value="건의 사항">건의 사항</option>
                <option class="toggleItem" value="기타">기타</option>
              </select>
            </div>
          </div>
          <div class="Usertext_BOX">
            <div class="comments_box">
              <div scope="row">
                <label class="mainTit">문의내용</label>
              </div>
              <div valign="bottom" class="comments_down">
                <textarea onkeyup="counter(this,3000)" class="comment_text" name="comments" cols="50" rows="10"
                  maxlength="3000" id="comment_text" class=""
                  style="width:100%; height:208px; background:#040B11;border:none; color:#fff;    padding: 12px 12px 0px 12px;font-size:16px;"
                  required></textarea>
                <p id="Comment_Count">0 / 3000</p>
              </div>
              <div class="Cotact_desc desc_padding">
                <h1>내용 파악을 위해 30자 이상을 작성해 주세요</h1>
              </div>
            </div>
            <div>
              <button type="button" class="commnet_BTN">제출하기</button>
            </div>
            <div>
              <input type="button" value="확인" class="notcommnet_BTN">
            </div>
            <div class="Comment_lower">
              <h1>고객센터 운영시간: 평일 9:00 - 18:00 (주말 · 공휴일 제외)</h1>
              <p>휴일을 제외한 평일에는 빠른 답변을 드리겠습니다<br>
                오래 기다려도 답변이 오지 않으면 스팸 메일함을 확인해주세요</p>
            </div>
          </div>
          <div class="CommentArea hide">
            <div class="CommentContents">
              <h1 class="CommentTIT">문의가 정상적으로 접수되었습니다</h1>
              <h1 class="CommentTITTE">빠르게 답변을 드리도록 하겠습니다</h1>
              <input type="submit" value="확인" class="CommentBTN">
            </div>
          </div>
      </form>
    </div>
  </div>


  <script>
    // function chageLangSelect() {
    //   var langSelect = document.getElementById("Mail_Select");
    //   const Comment_lower = document.querySelector('.Comment_lower');
    //   // select element에서 선택된 option의 value가 저장된다.  
    //   var selectValue = langSelect.options[langSelect.selectedIndex].value;

    //   // select element에서 선택된 option의 text가 저장된다.  
    //   var selectText = langSelect.options[langSelect.selectedIndex].text;
    //   if (langSelect.options[langSelect.selectedIndex].value !== "") {
    //     Comment_lower.style.display = "x";
    //   }
    // }
    function toggle(value) {
      const UserTXT = document.querySelector('.Usertext_BOX');
      if (value !== "") {
        UserTXT.style.display = "block";
      }
    }


    let textarea = document.getElementById('comment_text');

    // 텍스트
    textarea.addEventListener('keypress', () => {
      const textarea_Box = document.querySelector('.desc_padding');
      const comments = document.querySelector('.commnet_BTN');
      const notcomments = document.querySelector('.notcommnet_BTN');
      if (textarea.value.length <= 30) {
        textarea_Box.style.display = 'block';
        comments.style.display = 'none';
        notcomments.style.display = 'block';
      } else if (textarea.value.length > 30) {
        textarea_Box.style.display = 'none';
        comments.style.display = 'block';
        notcomments.style.display = 'none';
      }
    })

    // 이메일 내용
    let emailtest = document.getElementById("email");
    emailtest.addEventListener('keypress', () => {
      let input = document.getElementById("email").value;
      const TE = document.querySelector('.email_form');
      const comments = document.querySelector('.commnet_BTN');
      const notcomments = document.querySelector('.notcommnet_BTN');
      let email_format = /^([0-9a-zA-Z_\.-]+)@([0-9a-zA-Z_-]+)(\.[0-9a-zA-Z_-]+){1,2}$/;
      if (email_format.test(input)) {
        // 조건이 맞하하면
        TE.style.display = 'none';

      }
      else {
        // 아니라 하면
        TE.style.display = 'block';

      }
    })

    // 텍스트 글자 갯수
    function counter(text, length) {
      var limit = length;
      var str = text.value.length;
      if (str > limit) {
        document.getElementById("Comment_Count").innerHTML = "3000자 이상 입력 했습니다";
        text.focus();
      }
      document.getElementById("Comment_Count").innerHTML = text.value.length + "/" + limit;
    }

    // 아래 버튼 클릭
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