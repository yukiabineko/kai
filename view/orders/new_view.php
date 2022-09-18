<?php require_once "./helper/order_helper.php"; ?>

<article>
  <form action="./orders?action=create" method="post" id="order-form" novalidate>

    <!-- タイトルと合計金額エリア-->
    <div class="title">
      <h1>買い物かご確認</h1>
      <div class="total-area">
        <p>合計金額</p>
        <div class="total-price">
          <div class="price-area">0</div>
          <span>円</span>
        </div>
      </div>
    </div>
    <!-- 未入力等エラーがあった場合の表示　-->
    <div class="cart-form-error"></div>

    <div class="cart-session-error">
      <?php if (!empty($_SESSION['error_message'])) : ?>
        <?php foreach ($_SESSION['error_message'] as $error) : ?>
          <div class="error-session"><?= $error ?></div>
        <?php endforeach; ?>
      <?php endif;
      unset($_SESSION['error_message']); ?>
    </div>


    <!-- カート商品エリア-->
    <section class="carts">
      <ul class="items">

        <?php foreach ($_SESSION['orders'] as $data) : ?>
          <!-- 商品 -->
          <li id="order-item-<?= $data['id'] ?>">
            <div class="contents">
              <img src="<?= $data['thumbnail'] ?>" alt="<?= $data['name'] ?>">
              <div class="info">
                <!-- 最上段-->
                <div class="item-info">
                  <div class="name">商品名<span><?= $data['name'] ?></span></div>

                  <div class="price-info">単価
                    <span class="price" id="price-<?= $data['id'] ?>"><?= $data['price'] ?>
                      <sapn class="en">円</sapn>
                    </span>
                  </div>

                </div>
                <!--２段目 -->
                <div class="shop-info">
                  <div class="receiving_store">受け取り店舗</div>
                  <div class="store-name"><?= $data['shop_name'] ?></div>
                </div>
              </div>
            </div>


            <!-- フォームエリア-->
            <div class="form-group">

              <!--注文数-->
              <div class="number-label">注文数</div>
              <input type="number" name="number[]" class="order-number" value="<?= $data['stockInfo']['input'] ?>" id="number-<?= $data['id'] ?>" min="1" max="<?= $data['stockInfo']['limit'] ?>" onchange="priceChange(this)">

              <!--受け取り時間-->
              <div class="receiving-label">受取時間</div>
              <input type="text" name="receiving[]" class="receiving-box" id="receiving-<?= $data["id"] ?>" onclick="changeviewCalender(this,`<?= $data['dtInfo']['start'] ?>`,`<?= $data['dtInfo']['finish'] ?>`,
               `<?= json_encode(setDateTime($data['dtInfo']['start'], $data['dtInfo']['finish'])) ?>`)" value="<?= $data['dtInfo']['input'] ?>">

              <!--パラメータ隠し要素各種 -->
              <div id="hidden-start-<?= $data['id'] ?>" class="hidden-element"><?= $data['dtInfo']['start'] ?></div>
              <div id="hidden-end-<?= $data['id'] ?>" class="hidden-element"><?= $data['dtInfo']['finish'] ?></div>
              <div id="hidden-times-<?= $data['id'] ?>" class="hidden-element"><?= json_encode(setDateTime($data['dtInfo']['start'], $data['dtInfo']['finish'])) ?></div>

              <input type="hidden" name="items[]" value="<?= $data['item_id'] ?>">
              <input type="hidden" name="shops[]" value="<?= $data['shop_name'] ?>">
              <input type="hidden" name="item_names[]" value="<?= $data['name'] ?>">
              <input type="hidden" name="price[]" value="<?= $data['price'] ?>">


            </div>


            <div class="hr"></div>
            <!--合計金額-->
            <div class="total">
              <div class="total-price" id="total-<?= $data['id'] ?>">
                合計<?= total_price($data['price'], $data['stockInfo']['input'])  ?>
              </div>

              <div class="total-price-tax">税込合計
                <span id="taxprice-<?= $data['id'] ?>" class="tax-price">
                  <?= total_tax_price($data['price'], $data['stockInfo']['input'])  ?>
                </span> 円
              </div>

              <button class="del-button" id="cart-delete-<?= $data['id'] ?>" onclick="deleteCartItem(event,<?= $data['id'] ?>)"><img src="image/icons/trash.svg" alt="ゴミ箱">削除</button>
            </div>

          </li>
        <?php endforeach; ?>
      </ul>
    </section>

    <!-- ユーザーエリア-->
    <section class="user">
      <h1>お客様情報入力</h1>
      <table class="user-table">
        <!-- 名前-->
        <tr>
          <th>
            <img src="image/icons/user.svg" alt="ユーザー">
            <div class="name">お名前<span>(*必須です)</span></div>
          </th>
          <td><input type="text" name="name" id="user-name"></td>
        </tr>

        <!-- 電話番号-->
        <tr>
          <th class="tel-tr">
            <img src="image/icons/tel.svg" alt="電話番号">
            <div class="tel">電話番号<span>(*必須です)</span></div>
          </th>
          <td><input type="text" name="tel" id="user-tel"></td>
        </tr>

        <!-- メールアドレス-->
        <tr class="mail-tr">
          <th>
            <img src="image/icons/mail.svg" alt="メールアドレス">
            <div class="email">メールアドレス</div>
          </th>
          <td><input type="email" name="email" id="user-mail"></td>
        </tr>
      </table>
    </section>
    <!-- ボタン -->
    <div class="btns">
      <input type="submit" value="注文確定する">
      <a href="./item">注文一覧に戻る</a>
    </div>

  </form>

</article>

<!-- モーダル-->
<div id="modal-back"></div>
<div id="modal">
  <div style="text-align:right;margin-top:5%;"><button class="modal-bt" onclick="closeModal()">x</button></div>
  <div id="modal-contents">
    <h3>日時登録</h3>
    <div class="btns">
      <button class="prev" onclick="changePrevMonth(
          document.getElementById('target-date').textContent)">前月</button>
      <div class="year-month">xxx</div>
      <button class="next" onclick="changeNextMonth(
          document.getElementById('target-date').textContent)">次月</button>
    </div>
    <!-- カレンダー -->
    <table class="calendar"></table>
    <!-- 月パラメータ用 -->
    <div id="target-date"></div>
  </div>
</div>