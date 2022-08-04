<article>
  <!-- 説明エリア -->
  <section>
    <div class="title">
      <img src="image/icons/grape.svg" alt="葡萄">
      <h1>出品商品一覧</h1>
    </div>
    <p class="title-info">
      各お店から出品された商品の商品一覧ページです。気になる商品がございましたら、
      該当商品をクリックして詳細をご確認の上ご注文ください。尚、店鋪ごとの商品の一覧を
      照会なさいたい場合は検索ボックスの店舗名をご記入の上検索をお願い致します。
    </p>
    <div class="search">
      <form action="./item" method="get">
        <input type="hidden" name="action" value="index">
        <input type="text" name="shop_name" placeholder="お店の名前を入力してください。">
        <input type="submit" value="検索">
      </form>
      <input type="checkbox" id="open">
      <label class="map-button" for="open">
        <img src="image/icons/map.png" alt="地図">
        <span>地図検索</span>
      </label>
      <!-- 地図エリア　-->
      <div class="map">
        <div class="map-info">
          <h3>【地図から検索】</h3>
          <div class="map-buttons">
            <a href="./item" class="all-area-button">全地域で検索</a>
            <button onclick="closeMap()" class="close-map">閉じる</button>
          </div>
        </div>
        <div class="map-content">
          <?php include('./view/map.php'); ?>
        </div>
      </div>
    </div>
  </section>



  <!-- 商品エリア -->
  <section class="items-session">
    <?php if( count($items) > 0 ) : ?>
      <ul class="item">
        <?php foreach ($items as $item) : ?>
          <li class="list">
            <img src="<?= $item->thumbnail ?>" alt="<?= $item->name ?>" class="img">
            <div class="items"><?= $item->name ?></div>
            <div class="price">価格<span><?= $item->price ?></span>円</div>
            <div class="shop"><?= $item->belogsTo('shop')->name ?></div>
            <a href="./item?action=show&id=<?= $item->id ?>"><img src="image/icons/eye.png" alt="search">詳細を見る</a>
          </li>
        <?php endforeach; ?>
      </ul>
    <?php else: ?>
      <div class="empty">商品がありません。</div>
    <?php endif; ?>
    <!-- ページネーション　-->
    <ul class="pagination">
      <li>
        <a href="#"><前へ</a>
      </li>
      <li><a href="#">1</a></li>
      <li><a href="#">2</a></li>
      <li><a href="#" class="select-page">3</a></li>
      <li><a href="#">次へ></a></li>
    </ul>
  </section>

</article>
