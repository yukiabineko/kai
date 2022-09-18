<article>
  <?php if(isset($_SESSION['success'])) : ?>
    <div class="flash-success"><?= $_SESSION['success'] ?></div>
  <?php unset($_SESSION['success']); endif;   ?>
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
    <?php if (count($items) > 0) : ?>
      <ul class="item">
        <?php foreach ($items as $item) : ?>
          <li class="list">
            <img src="<?= !empty($item->thumbnail) ? $item->thumbnail : './image/icons/empty.svg' ?>" alt="<?= $item->name ?>" class="img">
            <div class="items"><?= $item->name ?></div>
            <div class="price">価格<span><?= $item->price ?></span>円</div>
            <div class="shop"><?= $item->belogsTo('shop')->name ?></div>
            <?php if($item->stock > 0) : ?>
              <a href="./item?action=show&id=<?= $item->id ?>"><img src="image/icons/eye.png" alt="search">詳細を見る</a>
            <?php else: ?>
              <div class="solidout">売り切れ</div>
            <?php endif; ?>
          </li>
        <?php endforeach; ?>
      </ul>
      <br>
    <?php else : ?>
      <div class="empty">商品がありません。</div>
    <?php endif; ?>

    <!-- ページネーション　-->
    <?php if (count($pages) > 1) : ?>
      <ul class="pagination">

        <!-- 最初ボタンの表示分岐ページ数１０以上の場合 -->
        <?php if (count($pages) >= 10) : ?>
          <li><a href="./item?page=1">最初へ</a></li>
        <?php endif; ?>

        <!-- 前へボタンの表示分岐 -->
        <?php if (isset($current_page) && $current_page != $pages[0]) : ?>
          <li>
            <a href="./item?page=<?= (int)$current_page - 1  ?>">
              <前へ</a>
          </li>
        <?php endif; ?>

        <!---------------------------ページ10以上----------------------------------------------------------------------------------------------------------------------------------------->
        <!-- メインページ部ページ１０以上、未満で分岐 -->
        <?php if (count($pages) >= 10) : ?>
          <?php foreach ($counts as $ct) : ?>
            <!-- 5の倍数で分割　-->
            <?php if (($ct * 5) < $current_page  && (($ct + 1) * 5) >= $current_page) : ?>
              <?php for ($i = $current_page; $i <= ($current_page + 4); $i++) : ?>
                <!--合計ページ数を超えたら非表示 -->
                <?php if ($i <= end($pages)) : ?>
                  <li>
                    <a href="./item?page=<?= $i  ?>" class="<?php echo $i == $current_page ? "select-page" : ""     ?>">
                      <?= $i ?>
                    </a>
                  </li>
                <?php endif; ?>
              <?php endfor; ?>
            <?php endif; ?>
          <?php endforeach; ?>

          <!-- 中間 -->
          <?php if ($current_page != end($pages)) : ?>
            <li>
              <div class="centers">...</div>
            </li>
          <?php endif; ?>

          <!-----------------------------ページ10未満------------------------------------------------------------------------------------------------------------------------------------------>
        <?php else : ?>
          <?php foreach ($pages as $page) : ?>
            <li><a href="./item?page=<?= $page  ?>" class=<?php echo (isset($current_page) && $current_page == $page) ? "select-page" : ""  ?>><?= $page ?></a></li>
          <?php endforeach; ?>
        <?php endif; ?>

        <!------------------------------------------------------------------------------------------------------------->

        <!-- 次へボタンの表示分岐 -->
        <?php if (isset($current_page) && $current_page != end($pages)) : ?>
          <li><a href="./item?page=<?= (int)$current_page + 1  ?>">次へ</a></li>
        <?php endif; ?>

        <!-- 最後ボタンの表示分岐ページ数１０以上の場合 -->
        <?php if (count($pages) >= 10) : ?>
          <li><a href="./item?page=<?= end($pages) ?>">最後</a></li>
        <?php endif; ?>
      </ul>
    <?php endif; ?>

    <footer class="ft">
      <a href="#" class="top-jump">top</a>
      <ul>
        <li><a href="./top">トップページ</a></li>
        <li><a href="./item">出品商品</a></li>
        <li><a href="./info">サイト案内</a></li>
        <li><a href="./shop?action=new">販売店登録</a></li>
        <li><a href="./contact?action=new">お問合せ</a></li>
      </ul>
      <small>copyright kai</small>
    </footer>

  </section>


</article>