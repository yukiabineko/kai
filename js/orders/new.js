let targetOrderElement = null;   //どのオーダーがアクションされているか見分ける変数

window.addEventListener('load', () => {
  let total = 0;
  let errors = [];
  document.querySelectorAll('.receiving-box').forEach(element => {
    element.readOnly = true;
  });
  document.querySelectorAll('.tax-price').forEach((totalElement)=>{
    total += Number(totalElement.textContent);
    document.querySelector('.price-area').textContent = total;
  });
 /****************************ERROR関連開始************************************************************************* */ 
  //フォーム送信時の処理
  document.getElementById("order-form").addEventListener('submit', (event)=>{
     
     errors.splice(0);

    let errorsElement = document.querySelector('.cart-form-error');
    while(errorsElement.firstChild){
      errorsElement.removeChild(errorsElement.firstChild);
    }
     //個数のフォームで未入力があったらエラー配列に格納
     document.querySelectorAll('.order-number').forEach((input)=>{
        let error_num_message = "⚠︎個数を入力していない項目があります。";
        let exist = errors.indexOf(error_num_message);
        if(input.value == "" && exist < 0){ 
         
          errors.push(error_num_message);
        }
     });
    //日時が未入力フォームがある場合はエラー配列に格納
      document.querySelectorAll('.receiving-box').forEach((input)=>{
        let error_date_message = "⚠︎受け取り日時を入力していない項目があります。";
        let exist = errors.indexOf(error_date_message);
        if(input.value == "" && exist < 0 ){ 
          errors.push(error_date_message);
        }
      });
    //名前未入力の場合エラー配列に格納
    if( document.getElementById('user-name').value == "" ){
      let error_name_message = "⚠︎お名前が入力されていません。";
      let exist = errors.indexOf(error_name_message);
      if( exist < 0 ){ errors.push(error_name_message); }
    }
    //電話番号未入力の場合エラー配列に格納
    if( document.getElementById('user-tel').value == "" ){
      let error_tel_message = "⚠︎電話番号が入力されていません。";
      let exist = errors.indexOf(error_tel_message);
      if( exist < 0 ){ errors.push(error_tel_message); }
    }
    //メールアドレス未入力の場合エラー配列に格納
    if( document.getElementById('user-tel').value == "" ){
      let error_mail_message = "⚠︎メールアドレスが入力されていません。";
      let exist = errors.indexOf(error_mail_message);
      if( exist < 0){ errors.push(error_mail_message); }
    }

    if(errors.length > 0){
      event.preventDefault();
      errorsElement = document.querySelector('.cart-form-error');
      errorsElement.style.display = 'block';
      errors.forEach((error)=>{
        let errorMessage = document.createElement('div');
        errorMessage.classList ="error-message";
        errorMessage.textContent = error;
        errorsElement.appendChild(errorMessage);

      });
      errorsElement.scrollIntoView(true);
    }
    else{
      errorsElement.style.display = "none";

    }
  
  });
  /********************************ERROR関連終了*************************************************************************** */ 
  /*********************************注文数関連************************************************************************************** */
  document.querySelectorAll('.order-number').forEach((number)=>{
     number.addEventListener('change', ()=>{
        const max = Number(number.max);
        let num = Number(number.value);
        if( max < num){
          alert('販売数は' + max + "です。");
          number.value = max;
          priceChange(number);
        }
     });
  });
  /*********************************注文数関連終了************************************************************************************** */
});
const stopSubmit = (event)=>{
  event.preventDefault();
}
const priceChange = (target) => {
  let totalAll = 0;
  const id = target.id.split('number-')[1];
  let itemPrice = parseInt(document.getElementById('price-' + id ).textContent);
  let count = parseInt(target.value);

  //価格オブジェクト作成
  let price = new Price(itemPrice);

  //単品賞品合計その後合計を配置
  let total = price.resultMultiplication(count);
  document.getElementById('total-' + id).textContent = `合計${total}円`;

  //税込価格を計算後配置
  let taxprice = price.resultTaxPrice();
  document.getElementById('taxprice-' + id).textContent = taxprice;

  //合計金額計算配置

  document.querySelectorAll('.tax-price').forEach((obj) => {
    let taxprice = obj.textContent;
  });

  document.querySelectorAll('.total-price-tax').forEach((obj) => {
    let taxprice = obj.children[0].textContent;
    totalAll += parseInt(taxprice);
  });
  document.querySelector('.price-area').textContent = totalAll;

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
const changeviewCalender = (element,start,finish, tms) =>{
  let todayMonth = new Date().getMonth();
  let startMonth = new Date(start.replace(/-/g , "/")).getMonth();
  let calendar = null;
 
  let timeData = JSON.parse(tms);
  targetOrderElement  = element;
  

  let modal = document.getElementById('modal');
  let back = document.getElementById('modal-back');
  back.style.display = 'block';

  modal.style.top = (element.getBoundingClientRect().top + window.scrollY) + "px";

  //開始日ずけが現在の月以降の場合はカレンダーオブジェクトの引数をstartにする。
  if(todayMonth < startMonth){
    calendar = new Calendar(
      start,
      document.querySelector('.btns').nextElementSibling
    );
    document.getElementById('target-date').textContent = start;
  }
  else{
     calendar = new Calendar(
      document.getElementById('target-date').textContent,
      document.querySelector('.btns').nextElementSibling
    );
    
  }

  
  calendar.setDateTimeRange(start, finish);

  //終了日時が当月で終了の場合は次月のボタンを非表示
  let finishObj = new Date(finish.replace( /-/g , "/" ) );
  if( finishObj <= calendar.getLast()){
    document.querySelector('.next').setAttribute("disabled", true);
  }
  

  //月ラベルの更新
  document.querySelector('.year-month').textContent = calendar.getDateLabel();
  PrevButtonCheck(calendar, start);   //前月ボタン分岐
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

  ButtonCreate(element, null, calendar);

  //開始、終了時間によるセレクトボックス変更
  changeMinSelectBox(start, finish);
  
}
/**
 * 
 * 次月ボタン押下の処理
 * 
 */
/******************************************************************************************************************************************** */
const changeNextMonth = (currentDate) => {
  let id = targetOrderElement.id.split('receiving-')[1];
  let start = document.getElementById('hidden-start-' + id ).textContent;
  let finish = document.getElementById('hidden-end-' + id).textContent;
  let tms = document.getElementById('hidden-times-' + id).textContent;


  let timeData = JSON.parse(tms);
  let nextString = "";


  let targetDate = currentDate ? new Date(currentDate.replace( /-/g , "/" ) ) : new Date();
  let year = targetDate.getFullYear();
  let month = targetDate.getMonth() + 2;

  if( month == 12 ){
    nextString = ( year + 1 )  + "-01-01";
  }
  else{
    nextString = year + "-" + month.toString().padStart(2, "0") + "-01"
  }
  

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
  PrevButtonCheck(calendar, start);
  nextButtonCheck(calendar, finish);  //次月ボタン分岐

  //カレンダー各日付押下更新
  calendar.cellsAction(); 
  console.log("カレンダー");
  console.log(calendar);
  ButtonCreate(targetOrderElement, null, calendar);

   //開始、終了時間によるセレクトボックス変更
   changeMinSelectBox(start, finish);


}
/**
 * 
 * 前月ボタン押下の処理
 * 
 */
/******************************************************************************************************************************************** */
const changePrevMonth = (currentDate) => {
  let id = targetOrderElement.id.split('receiving-')[1];
  let start = document.getElementById('hidden-start-' + id).textContent;
  let finish = document.getElementById('hidden-end-' + id).textContent;
  let tms = document.getElementById('hidden-times-' + id).textContent;
  let prevString = "";

  let timeData = JSON.parse(tms);

  let targetDate = currentDate ? new Date(currentDate.replace( /-/g , "/" ) ) : new Date();
  let year = targetDate.getFullYear();
  let month = targetDate.getMonth();


  if( month == 0 ){
    prevString = (year -1) + "-12-01"
  }
  else{
    prevString = year + "-" + month.toString().padStart(2, "0") + "-01"
  }

  document.getElementById('target-date').textContent = prevString;

  //更新のためカレンダーを一度削除その後前月のカレンダー作成
  document.getElementById('modal-contents').removeChild(document.getElementById('calendar'));
  let calendar = new Calendar(prevString, document.querySelector('.btns').nextElementSibling);
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
  PrevButtonCheck(calendar, start);
  nextButtonCheck(calendar, finish);  //次月ボタン分岐

  //カレンダー各日付押下更新
  calendar.cellsAction(); 
  console.log("カレンダー");
  console.log(calendar);
  ButtonCreate(targetOrderElement, null, calendar);

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
const ButtonCreate = (element, id = null, calendar) => {
  
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
        
        element.value = viewText;
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
  let targetLastDate = targetCalendar.getLast();     //表示されているカレンダーの月最終日
  let lastDate = new Date(last.replace( /-/g , "/" ) );                     //販売終了日

  console.log('カレンダー最終日');
  console.log(targetLastDate);

  console.log('販売最終日');
  console.log(lastDate);

  if( targetLastDate > lastDate || targetLastDate.getDate() == lastDate.getDate() ){
    document.querySelector('.next').disabled = true;
  }
  else{
    document.querySelector('.next').disabled = false;
  }
}
/**
 * 
 */
/***************************************************************************************************** */
//前の月の表示チェック
const PrevButtonCheck = ( targetCalendar, start) => {
  //前月ボタン当月以前は非表示
  let today = new Date();
  let todayYear = today.getFullYear();
  let todayMonth = today.getMonth() + 1;

  let firstDate = new Date(start.replace(/-/g , "/"));
  let firstYear = firstDate.getFullYear();
  let firstMonth = firstDate.getMonth() + 1;

  let target = targetCalendar.getTargetDate();
  let targetYear = target.getFullYear();
  let targetMonth = target.getMonth() + 1;

  

  //同じ年で現在回覧カレンダー月が当月より先 または回覧カレンダーが次年度の場合ボタン不活性解除
  if( (todayMonth < targetMonth && todayYear == targetYear) || todayYear < targetYear){
    document.querySelector('.prev').disabled = false;
  }
  else{
    document.querySelector('.prev').disabled = true;
  }


 /* if(targetYear == todayYear && todayMonth <= targetMonth ){
    document.querySelector('.prev').disabled = false;
  }
  else if(targetYear > todayYear ){
    document.querySelector('.prev').disabled = false;
  }
  else{
    document.querySelector('.prev').disabled = true;
  }
  */

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
//買い物カートの削除(ajax)
const deleteCartItem = (event,id) =>{
  event.preventDefault();
  let warning = confirm('削除してもよいですか？');
  if(warning){
    let params = new URLSearchParams();
    params.set('id', id);
    fetch(`./order?action=delete&id=${id}`,{
      method: 'POST',
      body: params,
    })
    .then(response => response.json())
    .then(res =>{
      if(res['status'] == 1 ){
        let deletePrice = Math.floor( parseInt(res['price']) * parseInt(res['num']) *1.1);
        let totalPrice = parseInt(document.querySelector('.price-area').textContent);
        
        document.getElementById('order-item-' + id ).style.display = "none";
        let countElement = document.querySelector('.shopping-cart-item-count');
        let count = parseInt(countElement.textContent);
        countElement.textContent = count - 1;

        totalPrice -= deletePrice;
        document.querySelector('.price-area').textContent = totalPrice;


        if( countElement.textContent == 0 ){
          //document.querySelector('.shopping-cart').style.display = "none";
          window.location = "./item";
        }
        history.replaceState('', '買い物かご', './order?action=new');
      }
    })
    .catch(error =>{
      alert(error);
      console.log(error);
    })
    
  }
}

