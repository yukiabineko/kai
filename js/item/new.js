window.addEventListener('load', () => {

  document.getElementById("item-form").addEventListener('submit', (e) => {
    

    //エラーがすでに表示されている場合があるのでリセット
    document.querySelectorAll('.error').forEach((error) => {
      error.classList.remove('show');
    });

    //エラー表示関連
    document.querySelectorAll('.input').forEach((input) => {
      
      if (input.value.length === 0) {
        e.preventDefault();
        const id = input.id;
        console.log(document.getElementById('error-' + id));
        document.getElementById('error-' + id).classList.add('show');
      }
    });
    //カレンダー整合性
    calendarIntegrity(e);
    //時間整合性
    timeIntegrity(e);
    window.scroll({ top: 0, behavior: 'smooth' });
  });
  //カレンダーmodalの表示
  document.querySelectorAll('.dt-input').forEach((input) => {
    input.addEventListener('click', () => {
      let calendar = document.getElementById('calendar');
      if (calendar) { document.getElementById('modal-contents').removeChild(calendar); }

      itemFormCalendar(input.id);
    });
  });
  //時間modalの表示
  document.querySelectorAll('.tm-input').forEach((input) => {
    input.addEventListener('click', () => {
      openTimeModal(input);
    });
  });

});


/**
 * 画像表示eはイベントfileIdはinput fileのid
 */
const showImage = (e, fileId) => {
  let files = e.target.files;
  const id = fileId.split('file')[1];
  document.getElementById('imgform-' + id).textContent = files[0].name;
  document.getElementById('imgform-' + id).style.color = "black";

  let main = document.getElementById('fileArea' + id);

  let preview = document.getElementById('preview-' + id);
  if (preview) { main.removeChild(preview); }


  let reader = new FileReader();
  reader.onload = () => {
    preview = document.createElement('div');
    preview.classList.add('preview');
    preview.id = "preview-" + id;

    let img = document.createElement('img');
    img.classList = "previewImage";
    img.style.width = "100%";
    img.style.height = "100%";
    img.src = reader.result;

    preview.appendChild(img);
    main.prepend(preview);
  }
  reader.readAsDataURL(files[0]);

}
/**
 * 時間モーダルの表示 
 * 
 * 
 */
const openTimeModal = (input) => {
  let back = document.getElementById('modal-back');
  back.style.display = 'block';
  document.getElementById('Timemodal').style.top = (input.getBoundingClientRect().top + window.scrollY) + "px";
  document.querySelector('.hidden').textContent = input.id;
}
/**
 * 時間モーダル閉じる
 */
const closeTimeModal = () => {
  let back = document.getElementById('modal-back');
  back.style.display = 'none';
  document.getElementById('Timemodal').style.top = "-150%";

}
/**
 * 時間モーダル確定ボタン
 */
const timeDataSend = () => {
  let hour = document.querySelector('.modal-hour-select').value;
  let min = document.querySelector('.modal-min-select').value;
  let time = hour + ":" + min;
  const id = document.querySelector('.hidden').textContent;
  document.getElementById(id).value = time;
  closeTimeModal();

}
/**カレンダー開始日と終了日の整合性のチェック */
const calendarIntegrity = (e) => {
 
  let start = document.getElementById('startDate');
  let end = document.getElementById('endDate');
  //DATEへ変換
  const startDate = new Date(start.value);
  const endDate = new Date(end.value);
  if (startDate > endDate) {
    e.preventDefault();
    const error = "開始日が終了日より後になっています。";
    let startError = document.getElementById('error-' + start.id);
    let endError = document.getElementById('error-' + end.id);
    startError.textContent = error;
    endError.textContent = error;
    startError.classList.add('show');
    endError.classList.add('show');
  }
}
/**カレンダー開始日と終了日の整合性のチェック */
const timeIntegrity = (e) => {
 
  let start = document.getElementById('startTime');
  let end = document.getElementById('endTime');

  let startValue = start.value;
  let startHour = parseInt(startValue.split(':')[0]);
  let startMin = parseInt(startValue.split(':')[1]);
  const startData = startHour * 60 + startMin;

  let endValue = end.value;
  let endHour = parseInt(endValue.split(':')[0]);
  let endMin = parseInt(endValue.split(':')[1]);
  const endtData = endHour * 60 + endMin;


  if (startData > endtData) {
    e.preventDefault();
    const error = "開始時間が終了時間より後になっています。";
    let startError = document.getElementById('error-' + start.id);
    let endError = document.getElementById('error-' + end.id);
    startError.textContent = error;
    endError.textContent = error;
    startError.classList.add('show');
    endError.classList.add('show');
  }
}
/**
 * 
 * カレンダー作成
 * 
 * 
 */
const itemFormCalendar = (id, startDate = null, endDate = null) => { 
  //起点となるinputのidをhiddenに格納 
  document.getElementById('inputName').value = id;
  
  let modal = document.getElementById('modal');
  let back = document.getElementById('modal-back');
  back.style.display = 'block';
  if (id) {
    let input = document.getElementById(id);
    modal.style.top = (input.getBoundingClientRect().top + window.scrollY) + "px";
    window.scroll({top: (input.getBoundingClientRect().top + window.scrollY), behavior: 'smooth'});
  }
  else {
    modal.style.top = '30%';
  }


  let calendar = new Calendar(
    document.getElementById('target-date').textContent,
    document.querySelector('.btns').nextElementSibling
  );
  let today = new Date();
  calendar.setDateRange(today.getDate());
  calendar.cellsAction();
  document.getElementById('calendar').style.marginBottom = "3rem";


  let dateObject = calendar.getTargetDate();

  //日日のパラメーター
  dateString = dateObject.getFullYear() + "-" + (dateObject.getMonth() + 1).toString().padStart(2, "0") + "-";


  //月ラベルの更新
  document.querySelector('.year-month').textContent = calendar.getDateLabel();
  prevButtonCheck();   //前月ボタン分岐


  //本月の日が押された場合
  document.querySelectorAll('.cal-td').forEach((cell) => {
    cell.addEventListener('click', () => {
      document.getElementById(id).value = dateString + cell.textContent.toString().padStart(2, "0");
      document.getElementById('target-date').textContent = new Date();
      closeModal();
    });
  });

  //次月の日が押された場合
  document.querySelectorAll('.next-td').forEach((cell) => {
    cell.style.color = "blue";
    cell.addEventListener('click', () => {
      nextMonthDateString = dateObject.getFullYear() + "-" + (dateObject.getMonth() + 2).toString().padStart(2, "0") + "-";
      document.getElementById(id).value = nextMonthDateString + cell.textContent.toString().padStart(2, "0");
      document.getElementById('target-date').textContent = new Date();
      closeModal();
    });
  });
}
/**************************************************************************** */
/**
 * 
 * 次の月
 * 
 * 
 * 
 * 
 * 
 */
const nextItemMonth = (currentDate) => {  
 
                          
  let targetDate = currentDate ? new Date(currentDate) : new Date();
  let year = targetDate.getFullYear();
  let month = targetDate.getMonth() + 2;
  let nextString = year + "-" + month.toString().padStart(2, "0") + "-01"
  document.getElementById('target-date').textContent = nextString;

  //更新のためカレンダーを一度削除その後前月のカレンダー作成
  document.getElementById('modal-contents').removeChild(document.getElementById('calendar'));
  let calendar = new Calendar(nextString, document.querySelector('.btns').nextElementSibling);
  document.getElementById('calendar').style.marginBottom = "3rem";

  let dateObject = calendar.getTargetDate();

  //日日のパラメーター
  dateString = dateObject.getFullYear() + "-" + (dateObject.getMonth() + 1).toString().padStart(2, "0") + "-";
  

  //*******************************前月の残り、次月の残りともにアクセスできるようにする。*********************************//

  document.querySelectorAll('.prev-td').forEach((td) => {
    td.classList.remove('emp');
    td.style.border = "1px solid #c0c0c0";
    td.style.color = "blue";
    td.addEventListener('mouseover', () => {
      td.style.background = 'orange';
    })
    td.addEventListener('mouseleave', () => {
      td.style.background = 'white';
    })
  });

  document.querySelectorAll('.next-td').forEach((td) => {
    td.classList.remove('emp');
    td.style.border = "1px solid #c0c0c0";
    td.style.color = "blue";
    td.addEventListener('mouseover', () => {
      td.style.background = 'orange';
    })
    td.addEventListener('mouseleave', () => {
      td.style.background = 'white';
    })
  });
  

  //月ラベルの更新
  document.querySelector('.year-month').textContent = calendar.getDateLabel();
  prevButtonCheck();
  let id = document.getElementById('inputName').value;
  /************************ボタンアクション************************************* */
  //前月の日が押された場合
  document.querySelectorAll('.prev-td').forEach((cell) => {
    cell.addEventListener('click', () => {
      document.getElementById(id).value = dateString + cell.textContent.toString().padStart(2, "0");
      document.getElementById('target-date').textContent = new Date();
      closeModal();
    });
  });
  //本月の日が押された場合
  document.querySelectorAll('.cal-td').forEach((cell) => {
    cell.addEventListener('click', () => {
      document.getElementById(id).value = dateString + cell.textContent.toString().padStart(2, "0");
      document.getElementById('target-date').textContent = new Date();
      closeModal();
    });
  });

  //次月の日が押された場合
  document.querySelectorAll('.next-td').forEach((cell) => {
    cell.addEventListener('click', () => {
      nextMonthDateString = dateObject.getFullYear() + "-" + (dateObject.getMonth() + 2).toString().padStart(2, "0") + "-";
      document.getElementById(id).value = nextMonthDateString + cell.textContent.toString().padStart(2, "0");
      document.getElementById('target-date').textContent = new Date();
      closeModal();
    });
  });

}
/************************************************************************************************************************* */
/**
 * 
 * 前の月
 * 
 * 
 * 
 * 
 * 
 * 
 * 
 */
const prevItemMonth = (currentDate) => {


  let targetDate = currentDate ? new Date(currentDate) : new Date();
  let year = targetDate.getFullYear();
  let month = targetDate.getMonth();
  let prevString = year + "-" + month.toString().padStart(2, "0") + "-01";
  document.getElementById('target-date').textContent = prevString;

  //更新のためカレンダーを一度削除その後前月のカレンダー作成
  document.getElementById('modal-contents').removeChild(document.getElementById('calendar'));
  let calendar = new Calendar(prevString, document.querySelector('.btns').nextElementSibling);
  let dateObject = calendar.getTargetDate();
  document.getElementById('calendar').style.marginBottom = "3rem";

  //日日のパラメーター
  dateString = dateObject.getFullYear() + "-" + (dateObject.getMonth() + 1).toString().padStart(2, "0") + "-";


  //月ラベルの更新
  document.querySelector('.year-month').textContent = calendar.getDateLabel();
  prevButtonCheck();

  //*******************************前月の残り、次月の残りともにアクセスできるようにする。*********************************//

  document.querySelectorAll('.next-td').forEach((td) => {
    td.classList.remove('emp');
    td.style.border = "1px solid #c0c0c0";
    td.style.color = "blue";
    td.addEventListener('mouseover', () => {
      td.style.background = 'orange';
    })
    td.addEventListener('mouseleave', () => {
      td.style.background = 'white';
    })
  });

  //月ラベルの更新
  document.querySelector('.year-month').textContent = calendar.getDateLabel();
  prevButtonCheck();
  let id = document.getElementById('inputName').value;
  /**************************当月の時は当日以後当月以降は全て********************************************* */
  let today = new Date();
  let todayYear = today.getFullYear();
  let todayMonth  = today.getMonth() + 1;

  //当月の場合
  if(year == todayYear && month == todayMonth){
    calendar.setDateRange(today.getDate());
    /*************ボタンアクション**************** */
    //本月の日が押された場合
    document.querySelectorAll('.cal-td').forEach((cell) => {
      cell.addEventListener('click', () => {
        document.getElementById(id).value = dateString + cell.textContent.toString().padStart(2, "0");
        document.getElementById('target-date').textContent = new Date();
        closeModal();
      });
    });

    //次月の日が押された場合
    document.querySelectorAll('.next-td').forEach((cell) => {
      cell.addEventListener('click', () => {
        nextMonthDateString = dateObject.getFullYear() + "-" + (dateObject.getMonth() + 2).toString().padStart(2, "0") + "-";
        document.getElementById(id).value = nextMonthDateString + cell.textContent.toString().padStart(2, "0");
        document.getElementById('target-date').textContent = new Date();
        closeModal();
      });
    });

  }
  else{
    document.querySelectorAll('.prev-td').forEach((td) => {
      td.classList.remove('emp');
      td.style.border = "1px solid #c0c0c0";
      td.style.color = "blue";
      td.addEventListener('mouseover', () => {
        td.style.background = 'orange';
      })
      td.addEventListener('mouseleave', () => {
        td.style.background = 'white';
      })
    });
    /*************ボタンアクション**************** */
    //前月の日が押された場合
    document.querySelectorAll('.prev-td').forEach((cell) => {
      cell.addEventListener('click', () => {
        document.getElementById(id).value = dateString + cell.textContent.toString().padStart(2, "0");
        document.getElementById('target-date').textContent = new Date();
        closeModal();
      });
    });
    //本月の日が押された場合
    document.querySelectorAll('.cal-td').forEach((cell) => {
      cell.addEventListener('click', () => {
        document.getElementById(id).value = dateString + cell.textContent.toString().padStart(2, "0");
        document.getElementById('target-date').textContent = new Date();
        closeModal();
      });
    });

    //次月の日が押された場合
    document.querySelectorAll('.next-td').forEach((cell) => {
      cell.addEventListener('click', () => {
        nextMonthDateString = dateObject.getFullYear() + "-" + (dateObject.getMonth() + 2).toString().padStart(2, "0") + "-";
        document.getElementById(id).value = nextMonthDateString + cell.textContent.toString().padStart(2, "0");
        document.getElementById('target-date').textContent = new Date();
        closeModal();
      });
    });
  }
  

}