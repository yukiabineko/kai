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

    <form action="./orders" class="order-form" method="GET">
      <input type="hidden" name="item_id" value="<?= $item->id ?>">
      <input type="hidden" name="action" value="new">
      <input type="hidden" name="thumbnail" value="<?= $item->thumbnail ?>">
      <input type="hidden" name="name" value="<?= $item->name ?>">
      <input type="hidden" name="price" value="<?= $item->price ?>">
      <input type="hidden" name="shop_name" value="<?= $shop->name ?>">
      <input type="hidden" name="dtInfo[start]" value="<?= $item->start ?>">
      <input type="hidden" name="dtInfo[finish]" value="<?= $item->finish ?>">
      <input type="hidden" name="stockInfo[limit]" value="<?= $item->stock ?>">

      <div class="form-group">
        <p>注文数</p>
        <input type="number" id="order_num" name="stockInfo[input]" onchange="priceCalc(this)" max="<?= $item->stock ?>" min="0">
      </div>

      <div class="form-group group2">
        <p>受け取り時間</p>
        <input type="text" class="datetime-form" name="dtInfo[input]" id="dtm" onclick="viewCalender(`<?= $item->start ?>`,`<?= $item->finish ?>`, `<?= $times ?>`)">
      </div>
      <!-- 店舗住所 -->
      <input type="hidden" id="adress" value="<?= $shop->adress ?>">

      <div class="form-border"></div>
      <!-- 合計金額 -->

      <div class="total">
        <div class="total-title">合計金額</div>
        <div class="total-money">¥<span><?= $item->price ?></span>円</div>
      </div>
      <!-- ボタン　-->
      <div class="btns">
        <button id="form-button" class="cart">
          <img src="image/icons//bag2.svg" alt="アイコン" width="10" height="10">カゴに入れる
        </button>
        <a href="./item?action=show&id=<?= $item->id ?>" class="back">戻る</a>
      </div>
    </form>
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
        <?php foreach ($others as $other) : ?>
          <li>
            <img src="<?= $other->thumbnail ?>" alt="<?= $other->name ?>" class="item-img">
            <div class="name"><?= $other->name ?></div>
            <div class="price">価格<span><?= $other->price ?></span>円</div>
            <a href="./item?action=show&id=<?= $other->id ?>">
              <img src="image/search.png" alt="アイコン" width="10" height="10">詳細を見る
            </a>
          </li>
        <?php endforeach; ?>
      </ul>
      <a href="./item?shop_name=<?= $shop->name  ?>" class="other-item-link">このお店その他商品はこちら</a>
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
      <button class="prev" onclick="changePrevMonth(document.getElementById('target-date').textContent,`<?= $item->start ?>`,`<?= $item->finish ?>`, `<?= $times ?>`)">前月</button>
      <div class="year-month">xxx</div>
      <button class="next" onclick="changeNextMonth(document.getElementById('target-date').textContent,`<?= $item->start ?>`,`<?= $item->finish ?>`, `<?= $times ?>` )">次月</button>
    </div>
    <!-- カレンダー -->
    <table class="calendar"></table>
    <!-- 月パラメータ用 -->
    <div id="target-date"></div>
  </div>
</div>