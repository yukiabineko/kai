<article>
  <div class="title">
    <h3>商品注文</h3>
  </div>

  <section class="contents">
    <!-- 商品情報　-->

    <div class="item">
      <img src="<?= $item->thumbnail; ?>" alt="商品">
      <ul>
        <li><?= $item->name ?></li>
        <li class="price">¥<span><?= $item->price ?></span>円</li>
        <li><?= $shop->name ?></li>
      </ul>
    </div>
    <div class="border"></div>
    <!-- 注文数等フォーム　-->

    <form action="#" class="order-form">
      <div class="form-group">
        <p>注文数</p>
        <input type="number" name="number"  onchange="priceCalc(this)" max="<?= $item->stock ?>" min="0">
      </div>

      <div class="form-group group2">
        <p>受け取り時間</p>
        <input type="text" class="datetime-form" name="datetime" onclick="createCalendar()">
      </div>
    </form>
    <div class="border"></div>
    <!-- 合計金額 -->

    <div class="total">
      <div class="total-title">合計金額</div>
      <div class="total-money">¥<span>297</span>円</div>
    </div>
    <!-- ボタン　-->
    <div class="btns">
      <a href="cart.html" class="cart">
        <img src="image/icons//bag.svg" alt="アイコン" width="10" height="10">カゴに入れる
      </a>
      <a href="item-show.html" class="back">戻る</a>
    </div>
  </section>

  <!-- 地図エリア　-->
  <section class="map">
    <h3>受け取り店舗地図検索</h3>
    <p>*場所によっては表示されない場合がございますのでご了承ください。</p>
    <div id="mapcontainer"></div>
  </section>

  <!-- その他商品　-->
  <section class="others">
    <h3>このお店その他商品</h3>
    <div class="contents">
      <ul>
        <!-- 商品１ -->
        <li>
          <img src="image/items/item2.png" alt="商品１" class="item-img">
          <div class="name">大福1個</div>
          <div class="price">価格<span>99</span>円</div>
          <a href="item-show.html">
            <img src="image/search.png" alt="アイコン" width="10" height="10">詳細を見る
          </a>
        </li>
        <!-- 商品2 -->
        <li>
          <img src="image/items/item9.png" alt="商品2" class="item-img">
          <div class="name">つぶあんどら焼き</div>
          <div class="price">価格<span>99</span>円</div>
          <a href="item-show.html">
            <img src="image/search.png" alt="アイコン" width="10" height="10">詳細を見る
          </a>
        </li>
        <!-- 商品3 -->
        <li>
          <img src="image/items/item10.png" alt="商品2" class="item-img">
          <div class="name">三色団子</div>
          <div class="price">価格<span>99</span>円</div>
          <a href="item-show.html">
            <img src="image/search.png" alt="アイコン" width="10" height="10">詳細を見る
          </a>
        </li>
      </ul>
      <a href="item-show.html" class="other-item-link">このお店その他商品はこちら</a>
    </div>
  </section>
</article>

<!-- モーダル-->
<div id="modal-back"></div>
<div id="modal">
  <div style="text-align:right;margin-top:5%;"><button class="modal-bt" onclick="closeModal()">x</button></div>
  <div id="modal-contents">
    <h3>日時登録</h3>
    <div class="btns">
      <button class="prev" onclick="prevMonth(document.getElementById('target-date').textContent)">全月</button>
      <div class="year-month">xxx</div>
      <button class="next" onclick="nextMonth(document.getElementById('target-date').textContent)">次月</button>
    </div>
    <!-- カレンダー -->
    <table class="calendar"></table>
    <!-- 月パラメータ用 -->
    <div id="target-date"></div>
  </div>
</div>