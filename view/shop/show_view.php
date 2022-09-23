<?php require_once './helper/shop_helper.php';  ?>
<!-- ajax用csrfトークン格納　-->
<meta name="csrf-token" content="<?php echo $token; ?>" />
<p class="shop-name"><?= $shop->name; ?>様</p>

<!----------------------------フラッシュ----------------------------------------------------------------------------->
<!-- ログインフラッシュ-->
<?php if (isset($_SESSION["flash"])) : ?>
  <div class="flash"><?= $_SESSION["flash"]; ?></div>
  <?php unset($_SESSION["flash"]); ?>
<?php endif; ?>


<!-- コンテンツ -->
<main>
  <!-- 店舗情報 -->
  <article class="shop">
    <section class="info">
      <h3>店舗様情報</h3>
      <a href="list.html" class="order-link">注文一覧へ</a>
      <table class="shop-table">
        <tr>
          <th>店舗名</th>
          <td><?= $shop->name ?></td>
        </tr>
        <tr>
          <th>メールアドレス</th>
          <td><?= $shop->email ?></td>
        </tr>
        <tr>
          <th>電話番号</th>
          <td><?= $shop->tel ?></td>
        </tr>
        <tr>
          <th>住所</th>
          <td><?= $shop->adress ?></td>
        </tr>
      </table>
      <a href="./shop?action=edit&id=<?= $shop->id ?>" class="edit">編集</a>
    </section>
    <!-- *****************************************************************************************************-->
    <!-- 登録商品覧-->
    <section class="itemlists">
      <h3>ご登録商品一覧</h3>
      <a href="./item?action=new" class="btn">新規登録</a>
      <?php if (count($items) > 0) : ?>
        <ul class="item-list">
          <?php foreach ($items as $item) : ?>
            <?php $tgoders = $item->hasMany('orders');  ?>

            <!-- リスト　-->
            <li class="list" id="list-<?= $item->id ?>">
              <a href=" ./item?action=show&id=<?= $item->id; ?>" class="link"></a>

              <!-- 画像、値段サイド-->
              <div class="img-price">
                <img src="shops/item<?= $item->id ?>/thumbnail.jpg" alt="商品2" srcset="shops/item<?= $item->id ?>/thumbnail.jpg" class="item-img">
                <ul class="price">
                  <li class="name"><?= $item->name ?></li>
                  <li class="price">
                    <img src="image/icons/price.svg" alt="価格">
                    <span><?= $item->price ?></span>円
                  </li>
                </ul>
              </div>

              <!-- 期限サイド -->
              <div class="time-limit">
                <img src="image/icons/date.svg" alt="カレンダー">
                <div class="date"><?= $item->start_processing(); ?> ~ <?= $item->end_processing(); ?></div>
              </div>

              <div class="li-btns">
                <!-- 編集ボタン　-->
                <a href="./item?action=edit&id=<?= $item->id ?>" class="edit-button">
                  <img src="image/icons/pen2.svg" alt="編集ボタン" srcset="image/icons/pen2.svg">
                </a>
                <!-- 削除ボタン　-->
                <button onclick="openDeleteModal(this, <?= $item->id ?>, <?= count($tgoders) ?>)" class="delete-button">
                  <img src="image/icons/trash.svg" alt="削除ボタン" srcset="image/icons/trash.svg">
                </button>
              </div>

            </li>
          <?php endforeach; ?>
        </ul>
      <?php else : ?>
        <div class="empty-item">現在登録されている商品はありません。</div>
      <?php endif; ?>
    </section>

  </article>
  <!-- ******************************************************************************************************-->
  <!-- 注文状況　-->
  <article class="order">
    <section class="info">
      <h3>注文依頼リスト</h3>
      <!-- オーダーがあるかどうかで分岐　-->
      <?php if (count($orders) > 0) : ?>
        <ul class="lists">
          <!-- ****************************list1********************************************** -->
          <?php foreach ($orders as $order) : ?>
            <li>
              <!-- 引き渡しステータス -->
              <?php if ($order['status'] == "1") : ?>
                <div class="status incomplete">未完</div>
              <?php else : ?>
                <div class="status">完了</div>
              <?php endif; ?>

              <div class=" <?= customer_strlen_check($order['name']) ?>">
                <img src="image/icons/user.svg" alt="ユーザー" srcset="image/icons/user.svg">
                <?= $order['name'] ?>様
              </div>

              <!-- 商品名-->
              <div class="item">
                <img src="image/icons/grape2.svg" alt="アイコン" srcset="image/icons/grape2.svg">
                <?= $order['item_name'] ?>
              </div>

              <!-- 価格-->
              <div class="price">
                <img src="image/icons/price.svg" alt="価格" srcset="image/icons/price.svg">
                <span><?= $order['price'] ?></span>円
                <img src="image/icons/bag.svg" alt="数" srcset="image/icons/bag.svg" class="num"><?= $order['order_count'] ?>個
                <div class="total">
                  計<span>
                    <?= floor((int)$order['price'] * (int)$order['order_count'] * 1.1) ?>
                  </span>円<span class="tax">(税込)</span>
                </div>
              </div>

              <!-- 日時 -->
              <div class="datetime">
                <img src="image/icons/date.svg" alt="カレンダー" srcset="image/icons/date.svg">
                <?= date('Y年m/d', strtotime($order['receiving'])) ?>
                <img src="image/icons/time.svg" alt="時間" srcset="image/icons/time.svg" class="clock">
                <span><?= date('g:i', strtotime($order['receiving'])) ?></span>
              </div>

              <!-- 電話番号 -->
              <a class="tel" href="tel:<?php echo $order['tel'] ?>">
                <img src="image/icons/tel.svg" alt="電話番号" srcset="image/icons/tel.svg">
                <?= $order['tel'] ?>
              </a>

              <!-- メールアドレス -->
              <a class="<?= email_strlen_check($order['email']) ?>" href="mailto:<?php echo $order['email'] ?>">
                <img src="image/icons/mail.svg" alt="メールアドレス" srcset="image/icons/mail.svg">
                <?= $order['email'] ?>
              </a>

              <!-- 隠しパラメータオーダーのid -->
              <input type="hidden" id="order-id" value="<?= $order['id'] ?>">

              <!-- 変更ボタン -->
              <button class="statusbtn">状況変更</button>
            </li>
          <?php endforeach; ?>
        </ul>
      <?php else : ?>
        <div class="order-empty">現在注文はありません。</div>
      <?php endif; ?>

    </section>
  </article>
</main>
<!-- 削除時の確認モーダル -->
<div class="modal-back" onclick="deleteModalClose()"></div>
<!-- モーダル本体 -->
<div class="delete-modal">
  <div class="modal-content">
    <!-- タイトル 閉じるボタン　-->
    <div class="modal-header">
      <h1>【ご確認ください】</h1>
      <button onclick="deleteModalClose()">x</button>
    </div>
    <!-- 内容　-->
    <div class="modal-body">
      <p class="modal-info">*すでに注文をなさっているお客様がいらっしゃいます。すべて連絡を終えてから削除してください。</p>
      <form action="#" method="POST" class="delete-orders-form">
        <table class="modal-table">
          <thead class="pc-thead">
            <tr>
              <th colspan="3">日時</th>
              <th rowspan="2">お客様名</th>
              <th rowspan="2">電話番号</th>
              <th rowspan="2">メールアドレス</th>
              <th rowspan="2">連絡確認</th>
            </tr>
            <tr>
              <th>日付け</th>
              <th>曜日</th>
              <th>時間</th>
            </tr>
          </thead>
          <tbody class="order-tbody"></tbody>
        </table>
        <input type="hidden" name="multiple" value="true">
        <input type="hidden" name="csrf-token" value="<?= $token ?>">
        <input type="submit" value="削除する" class="delete-modal-submit" disabled>
      </form>
    </div>
    <!-- 内容 -->
  </div>
</div>
<!-- モーダル本体 -->