<!-- コンテンツ -->
<article>
  <h3>商品名:<?= $item->name; ?></h3>

  <div class="info">
    <!-- 画像関連 -->
    <div class="images">
      <img src="<?= $item->thumbnail; ?>" alt="商品" width="480" height="450" id="view-img">
      <div class="image-list">
        <img src="<?= !empty($images[0]) ? $images[0] : './image/icons/empty.svg'; ?>" alt="商品リスト1" id="img-list-0" class="img-lists">
        <img src="<?= !empty($images[1]) ? $images[1] : './image/icons/empty.svg';; ?>" alt="商品リスト2" id="img-list-1" class="img-lists">
        <img src="<?= !empty($images[2]) ? $images[2] : './image/icons/empty.svg'; ?>" alt="商品リスト3" id="img-list-2" class="img-lists">
      </div>
    </div>

    <!-- 商品データ関連 -->
    <table class="item-data">
      <tr>
        <th>商品名</th>
        <td style="font-size:18px;"><?= $item->name ?></td>
      </tr>

      <tr>
        <th>価格</th>
        <td><?= $item->price ?>円</td>
      </tr>

      <tr>
        <th>販売店名</th>
        <td><?= $shop->name; ?></td>
      </tr>

      <tr>
        <th>販売数</th>
        <td><?= $item->stock; ?></td>
      </tr>

      <tr>
        <th>販売期間</th>
        <td class="date">
          <?= $item->start_processing() . "~" . $item->end_processing() ?>
        </td>
      </tr>

      <tr>
        <td colspan="2">
          <div class="text-icon">
            <img src="./image/icons/point.png" alt="おすすめポイント" class="recommended-point">
          </div>
          <div class="text">
            <?= $item->info; ?>
          </div>
        </td>
      </tr>

    </table>
  </div>
  <!-- ボタン　-->
  <div class="btns">
    <a 
     href="<?php echo (!isset($_SESSION['auth_id']) || $_SESSION['auth_id'] != $item->shop_id)?
     "./item" : "./shop?action=show&id=".$shop->id ?>" 
     class="back">一覧へ戻る
    </a>
    <!-- 注文ボタンは掲載店がログインしている場合は非表示 -->
    <?php if (!isset($_SESSION['auth_id']) || ($_SESSION['auth_id'] != $item->shop_id)) : ?>
      <a href="./order?action=show&id=<?= $item->id ?>" class="order">
        <img src="image/icons/bag2.svg" alt="注文アイコン">注文する
      </a>
    <?php endif; ?>
  </div>
</article>