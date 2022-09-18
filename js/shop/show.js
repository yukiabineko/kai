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
