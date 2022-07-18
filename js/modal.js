let dateString = "";
//時間フォームの追加

const hour = [
  { text: '午前７時', value: 7 },
  { text: '午前8時', value: 8 },
  { text: '午前9時', value: 9 },
];
const min = [
  { text: '0分', value: 0 },
  { text: '15分', value: 15 },
  { text: '30分', value: 30 },
  { text: '45分', value: 45 },
];


const createCalendar = (timeform = true, id = null, startDate = null, endDate = null) => {         //timeformは時間のフォームを表示させるか？デフォルトはtrue idは入力後反映する要素
  let modal = document.getElementById('modal');
  let back = document.getElementById('modal-back');
  back.style.display = 'block';
  if (id) {
    let input = document.getElementById(id);
    modal.style.top = (input.getBoundingClientRect().top + window.scrollY) + "px";
  }
  else {
    modal.style.top = '30%';
  }


  let calendar = new Calendar(
    document.getElementById('target-date').textContent,
    document.querySelector('.btns').nextElementSibling
  );
  calendar.setDateRange(startDate, endDate);

  let dateObject = calendar.getTargetDate();

  //日日のパラメーター
  dateString = dateObject.getFullYear() + "-" + (dateObject.getMonth() + 1).toString().padStart(2, "0") + "-";




  //月ラベルの更新
  document.querySelector('.year-month').textContent = calendar.getDateLabel();
  prevButtonCheck();   //前月ボタン分岐


  if (timeform) {
    let time = new TimeForm();
    time.setForm(hour, min);
    console.log(time.getTimeLabel());
  }


  changeButtonCreate(id);


}
/**
 *modalとじる
 */
const closeModal = () => {
  let modal = document.getElementById('modal');
  let back = document.getElementById('modal-back');
  back.style.display = 'none';
  modal.style.top = '-200%';
}
/**
 * 
 * 前の月
 */
const prevMonth = (currentDate, timeForm = true) => {                            //timeformは時間のフォームを表示させるか？デフォルトはtrue

  let targetDate = currentDate ? new Date(currentDate) : new Date();
  let year = targetDate.getFullYear();
  let month = targetDate.getMonth();
  let prevString = year + "-" + month.toString().padStart(2, "0") + "-01";
  document.getElementById('target-date').textContent = prevString;

  //更新のためカレンダーを一度削除その後前月のカレンダー作成
  document.getElementById('modal-contents').removeChild(document.getElementById('calendar'));
  let calendar = new Calendar(prevString, document.querySelector('.btns').nextElementSibling);
  let dateObject = calendar.getTargetDate();

  //日日のパラメーター
  dateString = dateObject.getFullYear() + "-" + (dateObject.getMonth() + 1).toString().padStart(2, "0") + "-";


  //時間フォーム作成
  if (timeForm) {
    new TimeForm().setForm(hour, min);
  }


  //月ラベルの更新
  document.querySelector('.year-month').textContent = calendar.getDateLabel();
  prevButtonCheck();


}
/**
 * 
 * 次の月
 */
const nextMonth = (currentDate, timeForm = true) => {                               //timeformは時間のフォームを表示させるか？デフォルトはtrue
  let targetDate = currentDate ? new Date(currentDate) : new Date();
  let year = targetDate.getFullYear();
  let month = targetDate.getMonth() + 2;
  let nextString = year + "-" + month.toString().padStart(2, "0") + "-01"
  document.getElementById('target-date').textContent = nextString;

  //更新のためカレンダーを一度削除その後前月のカレンダー作成
  document.getElementById('modal-contents').removeChild(document.getElementById('calendar'));
  let calendar = new Calendar(nextString, document.querySelector('.btns').nextElementSibling);

  let dateObject = calendar.getTargetDate();

  //日日のパラメーター
  dateString = dateObject.getFullYear() + "-" + (dateObject.getMonth() + 1).toString().padStart(2, "0") + "-";

  //時間フォーム作成
  if (timeForm) {
    new TimeForm().setForm(hour, min);
  }


  //月ラベルの更新
  document.querySelector('.year-month').textContent = calendar.getDateLabel();
  prevButtonCheck();


}
//前の月の表示チェック
const prevButtonCheck = () => {
  //前月ボタン当月以前は非表示
  let today = new Date();
  let todayYear = today.getFullYear();
  let todayMonth = today.getMonth() + 1;

  let target = new Date(document.getElementById("target-date").textContent);
  let targetYear = target.getFullYear();
  let targetMonth = target.getMonth() + 1;

  console.log("当年:" + todayYear);
  console.log("ターゲット年:" + targetYear);
  console.log("当月:" + todayMonth);
  console.log("ターゲット月:" + targetMonth);

  if (parseInt(todayYear) <= parseInt(targetYear) && parseInt(todayMonth) < parseInt(targetMonth)) {
    document.querySelector('.prev').disabled = false;
  }
  else {
    document.querySelector('.prev').disabled = true;
  }

}
/**確定ボタンの生成 */
const changeButtonCreate = (id = null) => {
  let modal = document.getElementById('modal');
  let button = document.querySelector('.change-button');
  if (button) { modal.removeChild(button); }
  button = document.createElement('button');
  button.classList.add('change-button');
  button.textContent = "確定";
  button.addEventListener('click', () => {
    let hourSelect = document.querySelector('.hour-select');

    if (hourSelect) {
      //カレンダーで選択されているかで分岐
      if (document.querySelector('.isSelect')) {
        let viewText
          = dateString + document.querySelector('.isSelect').textContent.padStart(2, "0")
          + ` ${document.querySelector('.hour-select').value.padStart(2, "0")}:${document.querySelector('.min-select').value.padStart(2, "0")}`;
        //時間フォームへ格納
        document.querySelector('.datetime-form').value = viewText;
        //モーダル閉じる
        closeModal();
      }
      else {
        alert('受け取る日を選択してください。');
      }
    }
    //時間フォームがカレンダーにない場合
    else {
      document.getElementById(id).value = dateString + document.querySelector('.isSelect').textContent.padStart(2, "0");
      //モーダル閉じる
      closeModal();
    }


  });
  modal.appendChild(button);

}
/**
 * 時間モーダルの表示
 */

