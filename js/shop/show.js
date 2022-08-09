window.addEventListener('load', ()=>{
  
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
