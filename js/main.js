const showOrders = (e)=>{
  e.preventDefault();
  let target = document.querySelector('.shopping-cart');
  target.classList.add('shopping-cart-large');

  //買い物カゴの内容を表示するクラス追加
  document.querySelector('.shopping-cart-infomation').classList.add('shopping-cart-infomation-show');
  //表示前のアイコン、ボタン等を非表示クラス追加
  document.querySelector('.shopping-cart-default').classList.add('shopping-cart-default-none');
  
}
const shoppingCartInfoClose = ()=>{
  let target = document.querySelector('.shopping-cart');
  target.classList.remove('shopping-cart-large');
  //買い物カゴの内容を表示するクラス削除
  document.querySelector('.shopping-cart-infomation').classList.remove('shopping-cart-infomation-show');
  //表示前のアイコン、ボタン等を非表示クラス削除
  document.querySelector('.shopping-cart-default').classList.remove('shopping-cart-default-none');
  
}