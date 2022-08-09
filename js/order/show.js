window.addEventListener('load', () => {
  //js有効時時間フォームデフォルトreadOnly化
  document.querySelector('.datetime-form').readOnly = true;

  var map = L.map('mapcontainer', { zoomControl: false });
  //座標の指定
  var mpoint = [35.662231, 138.568298];
  map.setView(mpoint, 15);
  L.tileLayer('https://cyberjapandata.gsi.go.jp/xyz/std/{z}/{x}/{y}.png', {
    attribution: "<a href='https://maps.gsi.go.jp/development/ichiran.html' target='_blank'>地理院タイル</a>"
  }).addTo(map);
  //甲府市役所位置にドラッグ可能なマーカーを地図に追加
  L.marker(mpoint, { title: "甲府市役所", draggable: true }).addTo(map);


});
const priceCalc = (target) => {
  //商品ベース価格
  let itemPrice = parseInt(document.querySelector('.price').children[0].textContent);
  let count = parseInt(target.value);
  let total = itemPrice * count;
  document.querySelector('.total-money').children[0].textContent = total;

}

