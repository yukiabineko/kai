window.addEventListener('load', ()=>{
  document.querySelectorAll('.statusbtn').forEach((btn)=>{
    btn.addEventListener('click', ()=>{
      let params = new URLSearchParams();
      params.set('change', true);
      const idElement = btn.previousElementSibling;
      const id = idElement.value;
      fetch(`./orders?action=update&id=${id}`,{
        method: 'POST',
        body: params,
      })
      .then(response => response.json())
      .then(res =>{
         if(res.status == "1" ){
           btn.parentElement.firstElementChild.classList.add('incomplete');
           btn.parentElement.firstElementChild.textContent = "未完";
           alert('受け渡し状況を【未完了】に変更しました。');
         }
         else{
           btn.parentElement.firstElementChild.classList.remove('incomplete');
           btn.parentElement.firstElementChild.textContent = "完了";
           alert('受け渡し状況を【完了】に変更しました。');
         }
      })
      .catch(error =>{
        alert(error);
        console.log(error);
      });
     
    });
  });
  
  
});
/*************************************各種関数******************************************************************************************************************** */
/**
 * 
 * 商品削除
 */
const deleteItem = (id) =>{
  const result = confirm('削除してもよろしいですか？');
  if(result){
    let token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    let params = new URLSearchParams();
    params.set('id', id);
    fetch(`./item?action=delete&id=${id}`,{
      method: 'POST',
      headers: {
        'X-CSRF-Token': token
      },
      body: params,
      
    })
    .then(response => response.json())
    .then(res =>{
      alert("削除しました。");
      //該当要素をみえなくする。
      document.getElementById('list-' + id).style.display = "none";
      let flash = document.querySelector('.flash');
      if(flash){
       flash.textContent = "削除しました。";
        flash.style.background = 'red';
      }
      else{
        let flash = document.createElement('div');
        flash.classList.add('flash');
        flash.textContent = '削除しました。';
        flash.style.background = 'red';
        document.body.insertBefore(flash, document.querySelector('main'));
      }
    })
    .catch(error =>{
      alert(error);
      console.log(error);
    })
  }
}
/*********************************削除モーダル関連************************************************************************************** */
const openDeleteModal = (element, item_id, count)=>{
  //前回のレコードの削除
  const tbody = document.querySelector('.order-tbody');
  while(tbody.firstChild){
    tbody.removeChild(tbody.firstChild);
  }
  
  /************************************************* */
  //対象商品にオーダーがある場合。
  if(count > 0 ){
    const form = document.querySelector('.delete-orders-form');
    form.action = `./item?action=delete&id=${item_id}`;
    const modal = document.querySelector('.delete-modal');
    const modalBack = document.querySelector('.modal-back');
    modal.style.top = (element.getBoundingClientRect().top + 100) + "px";
    modalBack.style.display = "block";
    let token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    let params = new URLSearchParams();
    params.set('id', item_id);
    params.set('multiple',true);
    fetch(`./shop?action=modal`, {
      method: 'POST',
      headers: {
        'X-CSRF-Token': token
      },
      body: params,

    })
      .then(response => response.json())
      .then(res => {
        res.forEach((obj)=>{
          const dt = new Date(obj.receiving.replace(/-/g, "/"));
          const tr = document.createElement('tr');
          const daytd = document.createElement('td');
          const weektd = document.createElement('td');
          const timetd = document.createElement('td');
          const nametd = document.createElement('td');
          const teltd = document.createElement('td');
          const mailtd = document.createElement('td');
          const checktd = document.createElement('td');
          const checkbox = document.createElement('input');
          checkbox.type = 'checkbox';
          checkbox.classList = "confirm-check";
          checkbox.id = `check-${obj.id}`;
          checkbox.addEventListener('change', checkBoxStatus, false);
          checkbox.name = 'check[]';
          daytd.textContent = `${dt.getMonth() + 1}/${dt.getDate().toString().padStart(2, "0")}`;
          weektd.textContent = ["日", "月", "火", "水", "木", "金", "土"][dt.getDay()];
          timetd.textContent = `${dt.getHours().toString().padStart(2, '0')}:${dt.getMinutes().toString().padStart(2, '0')}`
          nametd.textContent = obj.name + "様";
          const tel = document.createElement('a');
          tel.href = `tel:${obj.tel}`;
          tel.textContent = obj.tel;
          teltd.appendChild(tel);

          const mail = document.createElement('a');
          mail.href = `mailto:${obj.email}`;
          mail.textContent = obj.email;
          mailtd.appendChild(mail);
          checktd.appendChild(checkbox);

          //モバイルの場合の処理
          if (window.matchMedia('(max-width: 768px)').matches) {
            const usertr = document.createElement('tr');
            usertr.style.display = 'block';
            
           
            nametd.style.color = 'white';
            nametd.style.lineHeight = 2.5;
            nametd.style.background = '#522f60';
            nametd.textContent = "";

            const nameElement = document.createElement('div');
            nameElement.textContent = "お客様名:" + obj.name;
           

            const checkParent = document.createElement('div');
            checkParent.style.width = "100%";

            const group = document.createElement('div');
            group.style.display = "flex";
            group.style.alignItems = "center";
            group.style.justifyContent = "end";

          
            const label = document.createElement('label');
            label.htmlFor = `check-${obj.id}`;
            label.textContent = "連絡確認";
            checkbox.style.display = "block";
            checkbox.style.width = "calc(100vw * 0.1)";
            checkbox.style.height = "calc(100vw * 0.1)";
            group.appendChild(label);
            group.appendChild(checkbox);

            checkParent.appendChild(group);
            nametd.appendChild(checkParent);
            nametd.appendChild(nameElement);



            daytd.textContent = `受け取り日時:
            ${dt.getMonth() + 1} /${dt.getDate().toString().padStart(2, "0")} ${["日", "月", "火", "水", "木", "金", "土"][dt.getDay()]} ${dt.getHours().toString().padStart(2, '0')}:${dt.getMinutes().toString().padStart(2, '0')}`;
            mail.textContent = `メールアドレス: ${ obj.email}`;
            tel.textContent = `電話番号: ${obj.tel}`;

            usertr.appendChild(nametd);
            usertr.appendChild(daytd);
            usertr.appendChild(mailtd);
            usertr.appendChild(teltd);
            tr.appendChild(usertr);
            tbody.appendChild(tr);
           
          //
          } else {
            
            tr.appendChild(daytd);
            tr.appendChild(weektd);
            tr.appendChild(timetd);
            tr.appendChild(nametd);
            tr.appendChild(teltd);
            tr.appendChild(mailtd);
            tr.appendChild(checktd);
            tbody.appendChild(tr);
          }
        });
        const rect = element.getBoundingClientRect();
        const top = rect.top;
        document.documentElement.scrollTop = top;
      })
      .catch(error => {
        alert(error);
        console.log(error);
      });
  }
  /******************************************************************** */
  //商品にオーダーがない場合
  else{
    const result = confirm('削除してもよろしいですか？');
    if (result) {
      let token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

      let params = new URLSearchParams();
      params.set('id', item_id);
      fetch(`./item?action=delete&id=${item_id}`, {
        method: 'POST',
        headers: {
          'X-CSRF-Token': token
        },
        body: params,

      })
        .then(response => response.json())
        .then(res => {
          alert("削除しました。");
          //該当要素をみえなくする。
          document.getElementById('list-' + item_id ).style.display = "none";
          let flash = document.querySelector('.flash');
          if (flash) {
            flash.textContent = "削除しました。";
            flash.style.background = 'red';
          }
          else {
            let flash = document.createElement('div');
            flash.classList.add('flash');
            flash.textContent = '削除しました。';
            flash.style.background = 'red';
            document.body.insertBefore(flash, document.querySelector('main'));
          }
        })
        .catch(error => {
          alert(error);
          console.log(error);
        });
    }
  }
  
}
const deleteModalClose = ()=>{
  const modal = document.querySelector('.delete-modal');
  const modalBack = document.querySelector('.modal-back');
  modal.style.top = "-100%";
  modalBack.style.display = "none";

}
/**************************チェックボックス************************************************************************************************* */
const checkBoxStatus = (element)=>{
  let status = true;
  document.querySelectorAll('.confirm-check').forEach(checkbox => {
    checkbox.checked == true ? "" : status = false;
  });
   document.querySelector('.delete-modal-submit').disabled = status == true ? false : true;
}