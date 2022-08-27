

window.addEventListener('load', () => {

  getMapPointer().then((mpoint)=>{
    //js有効時時間フォームデフォルトreadOnly化
    document.querySelector('.datetime-form').readOnly = true;

    var map = L.map('mapcontainer', { zoomControl: false });
    //座標の指定
    
    map.setView(mpoint, 15);
    L.tileLayer('https://cyberjapandata.gsi.go.jp/xyz/std/{z}/{x}/{y}.png', {
      attribution: "<a href='https://maps.gsi.go.jp/development/ichiran.html' target='_blank'>地理院タイル</a>"
    }).addTo(map);
    //マーカーを地図に追加
    L.marker(mpoint, { title: document.getElementById('adress').value, draggable: true }).addTo(map);

  });
  document.getElementById('form-button').addEventListener('click', (e)=>{
    let oderNum = document.getElementById("order_num").value;
    let dateTime = document.getElementById("dtm").value;
    if( oderNum <=0 || dateTime == ""){
      e.preventDefault();
      alert('未入力の項目があります。確認してください。');
    }
  });

});
const priceCalc = (target) => {
  //商品ベース価格
  let itemPrice = parseInt(document.querySelector('.price').children[0].textContent);
  let count = parseInt(target.value);
  let total = itemPrice * count;
  document.querySelector('.total-money').children[0].textContent = total;

}
/*************************************************地図ポイント取得******************************************************************************** */
/**ajaxでデータ取得 */
const apiAction = async()=>{
  const adress = document.getElementById('adress').value;
  let mapData = [];
   //ajaxによる地図データの取得
   return await fetch(`https://msearch.gsi.go.jp/address-search/AddressSearch?q=${adress}`)
    .then(response => response.json())
}
/******データを変数で返す */
const getMapPointer = async()=>{
  let data = await apiAction();
  return  data[0]['geometry']['coordinates'].reverse();
  
}

    


/**************************************************カレンダー関連**************************************************************************
 * **************************************************************************************************************************
 * ***************************************************************************************************************************
 * *******************************************************************************************************************
 */
/**
 * カレンダー表示
 */
/******************************************************************************************************************************** */
const viewCalender = (start,finish, tms) =>{
  //地図非表示
  document.getElementById('mapcontainer').style.display = "none";
  

  let timeData = JSON.parse(tms);
  

  let modal = document.getElementById('modal');
  let back = document.getElementById('modal-back');
  back.style.display = 'block';

  let input = document.getElementById("dtm");
  modal.style.top = (input.getBoundingClientRect().top + window.scrollY) + "px";

  let calendar = new Calendar(
    document.getElementById('target-date').textContent,
    document.querySelector('.btns').nextElementSibling
  );
  calendar.setDateTimeRange(start, finish);

  //終了日時が当月で終了の場合は次月のボタンを非表示
  let finishObj = new Date(finish.replace( /-/g , "/" ) );
  if( finishObj <= calendar.getLast()){
    document.querySelector('.next').setAttribute("disabled", true);
  }
  

  //月ラベルの更新
  document.querySelector('.year-month').textContent = calendar.getDateLabel();
  prevButtonCheck();   //前月ボタン分岐
  nextButtonCheck(calendar, finish);  //次月ボタン分岐


  //時間フォームの時のセレクト内容を格納
 const hurs = hourParameter(timeData[0]);

 //時間フォームの分のセレクト内容を格納
 const mins = minParameter(timeData[1]);
 
  let time = new TimeForm();
  time.setForm(hurs, mins);
  console.log(time.getTimeLabel());
  
  //カレンダー各日付押下更新
  calendar.cellsAction(); 

  ButtonCreate(null, calendar);

  //開始、終了時間によるセレクトボックス変更
  changeMinSelectBox(start, finish);
  
}
/**
 * 
 * 次月ボタン押下の処理
 * 
 */
/******************************************************************************************************************************************** */
const changeNextMonth = (currentDate, start, finish, tms) => {
  let timeData = JSON.parse(tms);

  let targetDate = currentDate ? new Date(currentDate.replace( /-/g , "/" ) ) : new Date();
  let year = targetDate.getFullYear();
  let month = targetDate.getMonth() + 2;
  let nextString = year + "-" + month.toString().padStart(2, "0") + "-01"
  document.getElementById('target-date').textContent = nextString;

  //更新のためカレンダーを一度削除その後前月のカレンダー作成
  document.getElementById('modal-contents').removeChild(document.getElementById('calendar'));
  let calendar = new Calendar(nextString, document.querySelector('.btns').nextElementSibling);
  console.log('次月のカレンダー');
  console.log(calendar);
  calendar.setDateTimeRange(start, finish, 'next');

  let dateObject = calendar.getTargetDate();

  //日日のパラメーター
  dateString = dateObject.getFullYear() + "-" + (dateObject.getMonth() + 1).toString().padStart(2, "0") + "-";

   //時間フォームの時のセレクト内容を格納
 const hurs = hourParameter(timeData[0]);

 //時間フォームの分のセレクト内容を格納
 const mins = minParameter(timeData[1]);
  //時間フォーム作成
  new TimeForm().setForm(hurs, mins);


  //月ラベルの更新
  document.querySelector('.year-month').textContent = calendar.getDateLabel();
  prevButtonCheck();
  nextButtonCheck(calendar, finish);  //次月ボタン分岐

  //カレンダー各日付押下更新
  calendar.cellsAction(); 
  console.log("カレンダー");
  console.log(calendar);
  ButtonCreate(null, calendar);

   //開始、終了時間によるセレクトボックス変更
   changeMinSelectBox(start, finish);


}
/**
 * 
 * 前月ボタン押下の処理
 * 
 */
/******************************************************************************************************************************************** */
const changePrevMonth = (currentDate, start, finish, tms) => {
  let timeData = JSON.parse(tms);

  let targetDate = currentDate ? new Date(currentDate.replace( /-/g , "/" ) ) : new Date();
  let year = targetDate.getFullYear();
  let month = targetDate.getMonth();
  let nextString = year + "-" + month.toString().padStart(2, "0") + "-01"
  document.getElementById('target-date').textContent = nextString;

  //更新のためカレンダーを一度削除その後前月のカレンダー作成
  document.getElementById('modal-contents').removeChild(document.getElementById('calendar'));
  let calendar = new Calendar(nextString, document.querySelector('.btns').nextElementSibling);
  console.log('前月のカレンダー');
  console.log(calendar);
  calendar.setDateTimeRange(start, finish, 'prev');

  let dateObject = calendar.getTargetDate();

  //日日のパラメーター
  dateString = dateObject.getFullYear() + "-" + (dateObject.getMonth() + 1).toString().padStart(2, "0") + "-";

  //時間フォームの時のセレクト内容を格納
  const hurs = hourParameter(timeData[0]);

  //時間フォームの分のセレクト内容を格納
  const mins = minParameter(timeData[1]);

  //時間フォーム作成
  new TimeForm().setForm(hurs, mins);



  //月ラベルの更新
  document.querySelector('.year-month').textContent = calendar.getDateLabel();
  prevButtonCheck();
  nextButtonCheck(calendar, finish);  //次月ボタン分岐

  //カレンダー各日付押下更新
  calendar.cellsAction(); 
  console.log("カレンダー");
  console.log(calendar);
  ButtonCreate(null, calendar);

   //開始、終了時間によるセレクトボックス変更
   changeMinSelectBox(start, finish);


}

/*************************************************************************************************************** */
/**
 * 時間パラメーター
 */
/**************************************************************************************************************** */
const hourParameter = (hours) =>{
  let datas = [];
  hours.forEach((hour)=>{
     datas.push({text: `${hour}時`, value: hour.toString().padStart(2, "0")});
  });
  return datas;
}
/**
 * 分パラメーター
 */
/**************************************************************************************************************** */
const minParameter = (mins) =>{
  let datas = [];
  mins.forEach((min)=>{
     console.log('分');
     console.log(min);
     datas.push({text: `${min}分`, value: min.toString().padStart(2, "0")});
  });
  return datas;
}
/**確定ボタンの生成 */
/**************************************************************************************************************** */
const ButtonCreate = (id = null, calendar) => {
  
  let modal = document.getElementById('modal');
  let button = document.querySelector('.change-button');
  if (button) { modal.removeChild(button); }
  button = document.createElement('button');
  button.classList.add('change-button');
  button.textContent = "確定";
  modal.appendChild(button);


  button.addEventListener('click', () => {
    let dateObject = document.querySelector('.isSelect');
  //日日のパラメーター
   let str = "";


    //推された日付が当月か次月で分岐して文字列作成
    if( dateObject.classList.contains('next-td')  == true){
      str += calendar.getYear() + "-" + (calendar.getMonth() + 1).toString().padStart(2, '0') + "-"  + dateObject.textContent.toString().padStart(2,'0');
    }
    else if(  dateObject.classList.contains('prev-td')  == true){
      str += calendar.getYear() + "-" + (calendar.getMonth() - 1).toString().padStart(2, '0') + "-"  + dateObject.textContent.toString().padStart(2,'0');
    }
    else{
      str += calendar.getYear() + "-" + calendar.getMonth().toString().padStart(2, '0') + "-"  + dateObject.textContent.toString().padStart(2, '0');
    }


    let hourSelect = document.querySelector('.hour-select');

    if (hourSelect) {
      //カレンダーで選択されているかで分岐
      if (document.querySelector('.isSelect')) {
        let viewText
          = str + ` ${document.querySelector('.hour-select').value.padStart(2, "0")}:${document.querySelector('.min-select').value.padStart(2, "0")}`;
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
}
/**
 * 次月ボタン最終販売日がその月の収まる場合は非表示
 */
/****************************************************************************************************************************************** */
const nextButtonCheck = ( targetCalendar, last )=>{
  let targetLastDate = targetCalendar.lastObject     //表示されているカレンダーの月最終日
  let lastDate = new Date(last.replace( /-/g , "/" ) );                     //販売終了日

  console.log('カレンダー最終日');
  console.log(targetLastDate);

  console.log('販売最終日');
  console.log(lastDate);

  if( targetLastDate > lastDate ){
    document.querySelector('.next').disabled = true;
  }
  else{
    document.querySelector('.next').disabled = false;
  }
}
/*******************時間のリセット******************************************************************** */
const timeFormReset = ()=>{
  let minSelect = document.querySelector('.min-select');

  while(minSelect.firstChild){
    minSelect.removeChild(minSelect.firstChild);
  }
}
/***********************開始時間と終了時間により分のセレクトボックスの変動****************************************************************************** */
const changeMinSelectBox = ( start, finish )=>{
  //時間フォームを選択した場合で最初と最後時間とそれ以外の場合に分の選択を変える。
  let start_hour = new Date(start).getHours();
  let start_min = new Date(start).getMinutes();
  let end_hour = new Date(finish).getHours();
  let end_min = new Date(finish).getMinutes();
  
  const hourSelect = document.querySelector('.hour-select');
  let minSelect = document.querySelector('.min-select');
  hourSelect.addEventListener('change', ()=>{

   //開始時間の場合に初期値から開始でリセットして入れ替える
   if( hourSelect.value == start_hour ){
      timeFormReset();

      for(let i = start_min; i<= 45; i+= 15){
        let option = document.createElement('option');
        option.text = `${i}分`;
        option.value = i;
        minSelect.appendChild(option);
      }
    }
     //終了時間の場合に最終分をリミットにリセットして入れ替える
    else if( hourSelect.value == end_hour){
      timeFormReset();

      for(let i= 0; i<= end_min; i+=15){
        let option = document.createElement('option');
        option.text = `${i}分`;
        option.value = i;
        minSelect.appendChild(option);
      }
    }
    //その他の時間を入れ替える。
    else{
      timeFormReset();

      for(let i= 0; i<= 45; i+=15){
        let option = document.createElement('option');
        option.text = `${i}分`;
        option.value = i;
        minSelect.appendChild(option);
      }
    }
  });
}
