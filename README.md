# 분리의 신(God of Segregation)
<img width="20%" src="https://github.com/audgns722/recycle-project/blob/main/assets/img/logo2.jpg?raw=true"/>


## 🖥️ 프로젝트 소개
분리의신은 일상 생활 속에서 발생하는 잘못된 분리배출을 알려주고, 간편한 검색을 통해 올바른 배출 방법을 안내하는 웹사이트입니다.
<br>
<div align="center"><img style="border-radius:15px" width="100%" src="https://github.com/audgns722/recycle-project/blob/main/recycleGodIntroImg.png?raw=true"/></div>

 ### [사이트 바로가기📎](http://audgns722.dothome.co.kr/teamplemain/firstmain.php)
 ### [INDEX 바로가기📎](http://audgns722.dothome.co.kr/teamplemain/index.html)



## 🕰️ 개발 기간 및 작업 관리
* 개발 기간: 2023년 10월 11일부터 2023년 11월 16일까지
* 작업 관리: Slack과 Notion을 활용하여 팀 내에서 작업 현황을 공유 및 관리하였습니다.
### 🧑‍🤝‍🧑 맴버구성
 - 팀원 : 이명훈, 김희진

### 🙋‍♀️ 역할 분담
 - 이명훈  : 
   - 디자인 
   - 기능
 - 김희진  : 
   - 디자인 
   - 기능

### ⚙️ 개발 환경
  ![JavaScript](https://img.shields.io/badge/javascript-%23323330.svg?style=for-the-badge&logo=javascript&logoColor=%23F7DF1E) ![PHP](https://img.shields.io/badge/php-%23777BB4.svg?style=for-the-badge&logo=php&logoColor=white) ![MySQL](https://img.shields.io/badge/mysql-%2300f.svg?style=for-the-badge&logo=mysql&logoColor=white) ![HTML5](https://img.shields.io/badge/html5-%23E34F26.svg?style=for-the-badge&logo=html5&logoColor=white) ![CSS3](https://img.shields.io/badge/css3-%231572B6.svg?style=for-the-badge&logo=css3&logoColor=white) ![GitHub](https://img.shields.io/badge/github-%23121011.svg?style=for-the-badge&logo=github&logoColor=white) ![Slack](https://img.shields.io/badge/Slack-4A154B?style=for-the-badge&logo=slack&logoColor=white) ![Notion](https://img.shields.io/badge/Notion-%23000000.svg?style=for-the-badge&logo=notion&logoColor=white)
## 📌 주요 기능
#### 로그인 - <a href="http://audgns722.dothome.co.kr/teamplemain/php/login/login.php">상세보기 - 이동</a>
- DB값 검증 : 사용자가 입력한 ID와 비밀번호를 DB에서 확인하여 유효성을 검증
- ID찾기, PW찾기 : 사용자가 ID나 비밀번호를 잊어버린 경우를 대비해, 각각의 정보를 찾을 수 있는 기능을 제공
- 세션(Session) 생성 : 세션을 생성하여 사용자의 로그인 상태를 유지하고, 로그인 여부를 확인
#### 회원가입 - <a href="http://audgns722.dothome.co.kr/teamplemain/php/join/joinAgree.php" >상세보기 - 이동</a>
- 유효성 검사 : 아이디, 비밀번호, 비밀번호 확인, 이름, 휴대폰 번호, 생년월일 등의  유효성을 체크
- AJAX를 사용하여 회원가입 폼의 데이터를 서버에 전송하고, 서버에서는 DB에 새로운 회원 정보를 추가합니다.
- 주소 API 연동
- ID 중복 체크 : 사용자가 입력한 아이디가 이미 사용 중인지를 확인하고 중복을 방지
#### 마이 페이지 - <a href="http://audgns722.dothome.co.kr/teamplemain/php/mypage/mypage.php" >상세보기 - 이동</a>(id:admin/pw:1234)
- 프로필 이미지 업로드: 이미지를 업로드할 수 있는 기능을 제공(확장자 검사 및 크키 제한)
- 회원 탈퇴 : 회원탈퇴 시에는 사용자에게 확인 메시지를 제공하여 실수로 탈퇴하는 것을 방지
- 작성 글 보기
- 비밀번호 변경 : 사용자가 새로운 비밀번호를 설정하기 전에 현재 비밀번호를 확인
#### 주요 페이지 - <a href="http://audgns722.dothome.co.kr/teamplemain/php/subboard/submain.php" >상세보기 - 이동</a>
- 카테고리별 검색 기능 : AJAX를 사용하여 해당 PHP 페이지에 카테고리를 전달하고 데이터를 받아옴
- 게시판(수정하기, 삭제하기) : 수정 및 삭제는 해당 게시글을 작성한 사용자 또는 관리자에게만 허용(세션체크)
- 댓글 기능 구현(댓글 수정, 삭제) : 댓글 수정 및 삭제는 해당 댓글을 작성한 사용자 또는 관리자에게만 허용(세션체크)
- 게시글 좋아요 : 비동기방식으로 AJAX를 사용하여 페이지 전체를 새로고침하지 않고 좋아요 상태를 갱신 및 테이블에 저장(로그인확인 및 중복체크불가)
- Pagination : 전체 데이터의 양과 페이지당 표시되는 아이템 수를 고려하여 전체 페이지 수를 계산하여 사용자에게 제공 
#### 메인 페이지 - <a href="http://audgns722.dothome.co.kr/teamplemain/php/main/main.php" >상세보기 - 이동</a>
- 퀴즈 문제 풀기(JSON) - AJAX 사용
  - JSON 형식으로 퀴즈 데이터를 설계(질문, 선택지, 정답) ->  AJAX를 통해 호출 -> 받아온 JSON 데이터를 JavaScript에서 처리 -> JavaScript를 사용하여 선택한 답안을 기록 및 서버에 제출 -> 사용자에게 퀴즈 결과를 표시
- 메인 이미지 슬라이드(CSS)

## 🎯 개선목표 및 프로젝트 후기
#### 김희진
- 짧은 개발 기간동안 사용자에게 정보를 전달하는 페이지를 만들면서 많은 것을 생각해보고 구현하는 경험을 쌓을수 있었습니다. PHP구현을 통한 어려움이 많았지만 같이 작업하는 팀원을 통하여 많이 배우고 발전할 수 있는 계기가 되었습니다. 또한 디자인과 기획 측면에서도 조금더 사용자의 중심에서 생각해볼수 있는 좋은 경험이였으며, 혼자만의 개발이 아닌 팀과의 소통과 협업이 중요하다고 생각한 계기가 되었습니다. 또한 다양한 기술 스택을 사용해보며 발전할수 있는것이 좋았습니다.
#### 이명훈
- 개발 기간 동안 디자인과 기능 구현 측면에서 많은 경험을 쌓을 수 있었습니다. 처음 접해본 PHP를 통해 여러 시행착오를 격으면서 많은 경험을 하였고, 사용자의 피드백을 통해 더 나은 서비스를 제공하는 방향으로 개선하고 싶습니다. 가장 크게 느낀점은 프로젝트를 통해 팀원과의 협업의 중요성을 느꼇고, 다양한 기술 스택을 활용해 볼 수 있었습니다. 
