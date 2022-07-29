<!-- コンテンツ -->
<article>
    <h3>商品名:<?= $item->name; ?></h3>
    
    <div class="info">
      <!-- 画像関連 -->
      <div class="images">
        <img src="<?= $item->thumbnail; ?>" alt="商品" width="480" height="450" id="view-img">
        <div class="image-list">
          <img src="<?= $images[0]; ?>" alt="商品リスト1" id="img-list-0" class="img-lists">
          <img src="<?= $images[1]; ?>" alt="商品リスト2" id="img-list-1" class="img-lists">
          <img src="<?= $images[2]; ?>" alt="商品リスト3" id="img-list-2" class="img-lists">
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
            <?= $item->start_processing()."~".$item->end_processing() ?>
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
      <a href="./shop?action=show&id=<?= $item->id ?>" class="back">一覧へ戻る</a>
      <a href="order.html" class="order">
        <img src="image/icons/bag2.svg" alt="注文アイコン">注文する
      </a>
    </div>
  </article>