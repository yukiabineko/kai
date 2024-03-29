/*************************************カレンダー************************************************************************** */
class Calendar {

  constructor(setDt = null, dom = null) {
    
    this.dayCount = 1;
    this.targetDateObject = setDt ? new Date(setDt.replace( /-/g , "/" ) ) : new Date();
    //選択されているセルの日付け
    this.select = "";


    this.year = this.targetDateObject.getFullYear();
    this.month = this.targetDateObject.getMonth() + 1;

    //月初と終わりのオブジェクト
    this.beginObject = new Date(this.year, this.month - 1, 1);
    this.lastObject = new Date(this.year, this.month, 0);

    //月初と終わりの曜日番号
    this.begin_number = this.beginObject.getDay();
    this.last_number = this.lastObject.getDay();


    //月初と終わりの日日
    this.beginDate = this.beginObject.getDate();
    this.lastDate = this.lastObject.getDate();

    //前月の最終日
    this.prevLastDate = new Date(this.year, this.month - 1, 0).getDate();
    this.prevLastDate -= this.begin_number - 1;



    let modalTable = document.getElementById('calendar');
    if (modalTable) {
      document.getElementById('modal-contents').removeChild(modalTable);
    }

    this.table = document.createElement('table');
    this.table.id = "calendar";
    this.setWeek();
    this.setFirstWeek();
    this.setDate();
    dom ? document.getElementById('modal-contents').insertBefore(this.table, dom) : document.getElementById('modal-contents').appendChild(this.table);

    this.cellsAction();

  }
  getYear(){
    return this.year;
  }
  getMonth(){
    return this.month;
  }
  getLast(){
    return this.lastObject;
  }
  /**
   * 曜日thのセット
   */
  setWeek() {
    const weeks = ["日", "月", "火", "水", "木", "金", "土"];
    let tr = document.createElement('tr');
    weeks.forEach((week) => {
      let th = document.createElement('th');
      th.textContent = week;
      tr.appendChild(th);
    });
    this.table.appendChild(tr);
  }
  /**
   * 月最初の週のセッティング
   */
  setFirstWeek() {
    let tr = document.createElement('tr');
    if (this.begin_number == 0) {
      for (let i = 0; i <= 6; i++) {
        let td = document.createElement('td');
        td.classList = "cal-td";
        td.id = 'cal-' + this.dayCount;
        td.textContent = this.dayCount;
        tr.appendChild(td);
        this.dayCount++;
      }
    }
    else {
      for (let i = 0; i < this.begin_number; i++) {
        let td = document.createElement('td');
        td.classList.add("prev-td");
        td.classList.add("emp");
       
        td.textContent = this.prevLastDate
        tr.appendChild(td);
        this.prevLastDate++;
      }
      for (let i = this.begin_number; i <= 6; i++) {
        let td = document.createElement('td');
        td.classList = "cal-td";
        td.id = "cal-" + this.dayCount;
        td.textContent = this.dayCount;
        tr.appendChild(td);
        this.dayCount++;
      }

    }
    this.table.appendChild(tr);
  }
  /**
   * その他の週の格納
   */
  setDate() {
    let nextMonth = 1;
    for (let i = this.dayCount; i <= this.lastDate; i++) {
      let dateObject = new Date(this.year, this.month - 1, i);
      let dt = dateObject.getDate();

      let weekNum = dateObject.getDay();
      if (weekNum == 0) {
        let tr = document.createElement('tr');
        for (let j = dt; j <= dt + 6; j++) {
          let td = document.createElement('td');
          if (j <= this.lastDate) {
            td.textContent = j;
            td.classList = "cal-td";
            td.id = "cal-" + j;
          }
          else {
            td.classList.add('next-td');
            td.classList.add("emp");
            td.textContent = nextMonth;
            nextMonth++;
          }
          tr.appendChild(td);
        }
        this.table.appendChild(tr);
      }
    }

  }
  /**
   * 現在の表示カレンダーの月を返す
   */
  getTargetDate() {
    return this.targetDateObject;
  }
  /**
   * テキスト表示の整形
   */
  getDateLabel() {
    return this.year + "年" + this.month + "月";
  }
  /**
   * 日付けの範囲指定
   */
  setDateRange(begin = null, last = null) {
    let beginDate = begin == null ? this.beginDate : begin;
    let lastDate = last == null ? this.lastDate : last;


    let cells = document.querySelectorAll('.cal-td');
    console.log(cells);
    //一度すべて非表示
    cells.forEach((td) => {
      td.classList.remove('cal-td');
      td.classList.add('emp');
    });
    
    if(begin && !last){
      for (let i = beginDate; i <= this.lastDate; i++) {
        let cell = document.getElementById('cal-' + i);
        cell.classList.remove('emp');
        cell.classList.add('cal-td');
      }
      document.querySelectorAll('.next-td').forEach((td)=>{
         td.classList.remove('emp');
         td.style.border = "1px solid #c0c0c0";
         td.addEventListener('mouseover',()=>{
          td.style.background = 'orange';
         })
         td.addEventListener('mouseleave',()=>{
          td.style.background = 'white';
         })
      });
    }
    else if(begin && last){
      alert('ok');
    }
    else{
      //範囲のみ表示
      for (let i = beginDate; i <= this.lastDate; i++) {
        let cell = document.getElementById('cal-' + i);
        cell.classList.remove('emp');
        cell.classList.add('cal-td');
      }
    }
  }
  /**
   * 日付けの範囲指定
   */
/************************************************************************************************************************** */
   setDateTimeRange(begin = null, last = null, status = null) {

    let cells = document.querySelectorAll('.cal-td');

    //一度すべて非表示
    cells.forEach((td) => {
      td.classList.remove('cal-td');
      td.classList.add('emp');
    });
     let today = new Date();
     let beginObj = new Date(begin.replace( /-/g , "/" ) );
     //範囲の初日
     let beginDate = beginObj.getDate();
     let beginMonth = beginObj.getMonth() + 1;
     let lastObj = new Date(last.replace( /-/g , "/" ) );


    //prev,nextボタン押下時、通常時で分岐
    if(status == 'next'){
      for(let i = this.beginDate; i<= this.lastDate; i++){
        let targetObj = new Date(this.year, this.month - 1, i);
  
        //対象日が販売終了日以内か
        if (targetObj <= lastObj ) {
          let cell = document.getElementById('cal-' + i);
          cell.classList.remove('emp');
          cell.classList.add('cal-td');
        }
      }
      //前の月で範囲内のものはボタンを押せるようにする。
      document.querySelectorAll('.prev-td').forEach((cell)=>{
        let targetObj = new Date(this.year, this.month -2, cell.textContent);
        if( (beginObj <= targetObj) && ( targetObj > today  )){
          console.log("prev");
          console.log(cell);
          cell.classList.remove('emp');
          cell.classList.add('cal-td');
          cell.style.color = "green";
          cell.style.fontWeight = "bold";
        }
      });
      //次の月で範囲内のものはボタンを押せるようにする。
      document.querySelectorAll('.next-td').forEach((cell)=>{
        let targetObj = new Date(this.year, this.month , cell.textContent);
        if(lastObj >= targetObj){
          console.log("next");
          cell.classList.remove('emp');
          cell.classList.add('cal-td');
          cell.style.color = "blue";
          cell.style.fontWeight = "bold";
        }
      });


    }
    /******************************************************************************************* */
    else if(status == 'prev'){

      //カレンダーが当月かどうかで分岐また販売初日が前月かで分岐

      if(this.month == today.getMonth() + 1 && beginMonth == today.getMonth() + 1 ){
        for (let i = beginDate; i <= this.lastDate; i++) {
          let targetObj = new Date(this.year, this.month - 1, i);
          if (targetObj <= lastObj && targetObj >= today) {

            let cell = document.getElementById('cal-' + i);
            cell.classList.remove('emp');
            cell.classList.add('cal-td');
          }
        }
        //最終日が範囲内なら次の月の日付は押下かのうにする
        document.querySelectorAll('.next-td').forEach((next) => {
          let target = new Date(this.year, this.month, next.textContent);
          if (lastObj >= target) {
            next.classList.remove('emp');
            next.classList.add('cal-td');
            next.style.color = "blue";
            next.style.fontWeight = "bold";
          }
        });
        //前の月の日付は非表示
        document.querySelectorAll('.prev-td').forEach((cell) => {
            cell.className = "emp";
            
          });
      }
      //販売初日が前月で過ぎてしまっている場合前月のボタン無効化。
      else if( this.month == today.getMonth() + 1 && beginMonth < today.getMonth() + 1){
        for (let i = this.beginDate; i <= this.lastDate; i++) {
          let targetObj = new Date(this.year, this.month - 1, i);
          //対象日が販売終了日以内か
          if (targetObj <= lastObj && targetObj >= today) {
            let cell = document.getElementById('cal-' + i);
            cell.classList.remove('emp');
            cell.classList.add('cal-td');
          }
        }
        //前の月の日付は非表示
        document.querySelectorAll('.prev-td').forEach((cell) => {
          cell.className = "emp";
          
        });
      }
      else{
        for (let i = this.beginDate; i <= this.lastDate; i++) {
          let targetObj = new Date(this.year, this.month - 1, i);
          //対象日が販売終了日以内か
          if (targetObj <= lastObj && targetObj >= today) {
            let cell = document.getElementById('cal-' + i);
            cell.classList.remove('emp');
            cell.classList.add('cal-td');
          }
        }
      }
      
      //前の月で範囲内のものはボタンを押せるようにする。
      document.querySelectorAll('.prev-td').forEach((cell) => {
        let targetObj = new Date(this.year, this.month - 1, cell.textContent);
        if (beginObj <= targetObj) {
          console.log("prev");
          console.log(cell);
          cell.classList.remove('emp');
          cell.classList.add('cal-td');
          cell.style.color = "green";
          cell.style.fontWeight = "bold";
        }
      });
      //次の月で範囲内のものはボタンを押せるようにする。
      document.querySelectorAll('.next-td').forEach((cell) => {
        let targetObj = new Date(this.year, this.month, cell.textContent);
        if (lastObj >= targetObj) {
          console.log("next");
          cell.classList.remove('emp');
          cell.classList.add('cal-td');
          cell.style.color = "blue";
          cell.style.fontWeight = "bold";
        }
      });

    }
    /********************************************************************************************* */
    else{
      //範囲のみ表示

      //開始日が当月以前の場合
       if(today.getMonth() + 1 > beginObj.getMonth() +1){
        for(let i=  this.beginDate;  i<= this.lastDate; i++ ){
          let targetObj = new Date(this.year, this.month - 1, i);
          if (targetObj <= lastObj && targetObj >= today) {
            
            let cell = document.getElementById('cal-' + i);
            cell.classList.remove('emp');
            cell.classList.add('cal-td');
          }
        }
       }

      //開始日が当月以内の場合
      for (let i = beginDate; i <= this.lastDate; i++) {
        let targetObj = new Date(this.year, this.month - 1, i);
        if (targetObj <= lastObj && targetObj >= today) {
          
          let cell = document.getElementById('cal-' + i);
          cell.classList.remove('emp');
          cell.classList.add('cal-td');
        }
      }
      //最終日が範囲内なら次の月の日付は押下かのうにする
      document.querySelectorAll('.next-td').forEach((next) => {
        let target = new Date(this.year, this.month, next.textContent);
        if (lastObj >= target) {
          next.classList.remove('emp');
          next.classList.add('cal-td');
          next.style.color = "blue";
          next.style.fontWeight = "bold";
        }
      });
      
    }
    
  }
  /**
   * セルを押したときの処理
   */
/*************************************************************************************************************************** */
  cellsAction() {
    document.querySelectorAll('.cal-td').forEach((cell) => {
      cell.classList.remove('isSelect');
      cell.addEventListener('click', () => {
        document.querySelectorAll('.cal-td').forEach((cl) => {
          cl.classList.remove('isSelect');
        });
        cell.classList.add('isSelect');
        console.log('押されたセルクラス:' + cell.classList);
        console.log('押されたセルコンテンツ:' + cell.textContent);
        //次の月の場合にオブジェクト更新
        if(cell.classList.contains('next-td') == true){
          this.targetDateObject = new Date(this.year, this.month, cell.textContent);
        }
        //前の月の場合にオブジェクト更新
        if(cell.classList.contains('prev-td') == true){
          
          //this.targetDateObject = new Date(this.year, this.month-1, cell.textContent);
        }

      });
    });
  }

}
/**************************時間フォームの作成************************************************ */
class TimeForm {
  constructor() {
    //時のセレクトボックス作成
    this.hourSelect = document.createElement('select');
    this.hourSelect.classList.add('hour-select');

    //分のセレクトボックス作成
    this.minSelect = document.createElement('select');
    this.minSelect.classList.add('min-select');
  }
  setForm(hourObjects, minObjects) {
    let modal = document.getElementById('modal-contents');
    let title = document.createElement('h2');
    title.classList.add('time-title');
    title.textContent = "時間入力";
    let main = document.querySelector('.time-contents');

    if (main) {
      modal.removeChild(main);
    }

    main = document.createElement('div');
    main.classList.add('time-contents')

    let contents = document.createElement('div');
    contents.classList = "time-form";

    let hourLabel = document.createElement('span');
    hourLabel.classList.add('hour-label');
    hourLabel.textContent = "時";
    contents.appendChild(hourLabel);


    //時フォームオプション追加
    hourObjects.forEach((obj) => {
      let option = document.createElement('option');
      option.text = obj['text'];
      option.value = obj['value'];
      this.hourSelect.appendChild(option);
    });
    contents.appendChild(this.hourSelect);

    let minLabel = document.createElement('span');
    minLabel.classList.add('min-label');
    minLabel.textContent = "分";
    contents.appendChild(minLabel);

    
    //分フォームオプション追加
    minObjects.forEach((obj) => {
      let option = document.createElement('option');
      option.text = obj['text'];
      option.value = obj['value'];
      this.minSelect.appendChild(option);
    });

    contents.appendChild(this.minSelect);
    main.appendChild(title)
    main.appendChild(contents);
    modal.appendChild(main);

  }
  //選択された時間をテキストで返す
  getTimeLabel() {
    return `${this.hourSelect.value.padStart(2, "0")}:${this.minSelect.value.padStart(2, "0")}`;
  }
}
/**********************************値段オブジェクト************************************************ */
class Price {
  constructor(basePrice = null) {
    this.result = 0;
    this.base = basePrice ? basePrice : 0;  //計算対象価格
  }
  //掛け算計算
  resultMultiplication(count) {
    this.result += this.base * count;
    return this.result;
  }
  //消費税の計算
  resultTaxPrice() {
    this.result *= 1.1;
    return parseInt(this.result);
  }
}
