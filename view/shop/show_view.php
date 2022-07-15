<p class="shop-name"><?= $shop->name; ?>様</p>

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
      <a href="new-item.html" class="btn">新規登録</a>
      <ul class="item-list">
        <!-- 商品1 -->
        <li class="list">
          <a href="item-show.html" class="link"></a>
          <!-- 画像、値段サイド-->
          <div class="img-price">
            <img src="image/items/item3.png" alt="商品1" srcset="image/items/item3.png" class="item-img">
            <ul class="price">
              <li class="name">柏餅1個</li>
              <li class="price">
                <img src="image/icons/price.svg" alt="価格">
                <span>99 </span>円
              </li>
            </ul>
          </div>
          <!-- 期限サイド -->
          <div class="time-limit">
            <img src="image/icons/date.svg" alt="カレンダー">
            <div class="date">7/23 9:00 ~ 7/24 16:00</div>
          </div>
          <!-- 編集・削除ボタン-->

          <div class="li-btns">
            <!-- 編集ボタン　-->
            <a href="eidt-item.html" class="edit-button">
              <img src="image/icons/pen2.svg" alt="編集ボタン" srcset="image/icons/pen2.svg">
            </a>
            <!-- 削除ボタン　-->
            <button class="delete-button">
              <img src="image/icons/trash.svg" alt="削除ボタン" srcset="image/icons/trash.svg">
            </button>
          </div>
        </li>
        <!-- *****************************************************-->
        <!-- 商品2 -->
        <li class="list">
          <a href="item-show.html" class="link"></a>
          <!-- 画像、値段サイド-->
          <div class="img-price">
            <img src="image/items/item9.png" alt="商品2" srcset="image/items/item9.png" class="item-img">
            <ul class="price">
              <li class="name">どらやき1個</li>
              <li class="price">
                <img src="image/icons/price.svg" alt="価格">
                <span>99</span>円
              </li>
            </ul>
          </div>
          <!-- 期限サイド -->
          <div class="time-limit">
            <img src="image/icons/date.svg" alt="カレンダー">
            <div class="date">7/23 9:00 ~ 7/24 16:00</div>
          </div>

          <!-- 編集・削除ボタン-->

          <div class="li-btns">
            <!-- 編集ボタン　-->
            <a href="eidt-item.html" class="edit-button">
              <img src="image/icons/pen2.svg" alt="編集ボタン" srcset="image/icons/pen2.svg">
            </a>
            <!-- 削除ボタン　-->
            <button class="delete-button">
              <img src="image/icons/trash.svg" alt="削除ボタン" srcset="image/icons/trash.svg">
            </button>
          </div>

        </li>
        <!-- *****************************************************-->
        <!-- 商品3 -->
        <li class="list">
          <a href="item-shop.html" class="link"></a>
          <!-- 画像、値段サイド-->
          <div class="img-price">
            <img src="image/items/item2.png" alt="商品2" srcset="image/items/item2.png" class="item-img">
            <ul class="price">
              <li class="name">大福1個</li>
              <li class="price">
                <img src="image/icons/price.svg" alt="価格">
                <span>99</span>円
              </li>
            </ul>
          </div>
          <!-- 期限サイド -->
          <div class="time-limit">
            <img src="image/icons/date.svg" alt="カレンダー">
            <div class="date">7/23 9:00 ~ 7/24 16:00</div>
          </div>

          <!-- 編集・削除ボタン-->

          <div class="li-btns">
            <!-- 編集ボタン　-->
            <a href="eidt-item.html" class="edit-button">
              <img src="image/icons/pen2.svg" alt="編集ボタン" srcset="image/icons/pen2.svg">
            </a>
            <!-- 削除ボタン　-->
            <button class="delete-button">
              <img src="image/icons/trash.svg" alt="削除ボタン" srcset="image/icons/trash.svg">
            </button>
          </div>
        </li>
        <!-- *****************************************************-->
        <!-- 商品4 -->
        <li class="list">
          <a href="item-show.html" class="link"></a>
          <!-- 画像、値段サイド-->
          <div class="img-price">
            <img src="image/items/item10.png" alt="商品2" srcset="image/items/item10.png" class="item-img">
            <ul class="price">
              <li class="name">三色団子1pc</li>
              <li class="price">
                <img src="image/icons/price.svg" alt="価格">
                <span>99</span>円
              </li>
            </ul>
          </div>
          <!-- 期限サイド -->
          <div class="time-limit">
            <img src="image/icons/date.svg" alt="カレンダー">
            <div class="date">7/23 9:00 ~ 7/24 16:00</div>
          </div>

          <!-- 編集・削除ボタン-->

          <div class="li-btns">
            <!-- 編集ボタン　-->
            <a href="eidt-item.html" class="edit-button">
              <img src="image/icons/pen2.svg" alt="編集ボタン" srcset="image/icons/pen2.svg">
            </a>
            <!-- 削除ボタン　-->
            <button class="delete-button">
              <img src="image/icons/trash.svg" alt="削除ボタン" srcset="image/icons/trash.svg">
            </button>
          </div>
        </li>

      </ul>
    </section>

  </article>
  <!-- ******************************************************************************************************-->
  <!-- 注文状況　-->
  <article class="order">
    <section class="info">
      <h3>注文依頼リスト</h3>
      <ul class="lists">
        <!-- ****************************list1********************************************** -->
        <li>
          <div class="status">完了</div>
          <div class="user">
            <img src="image/icons/user.svg" alt="ユーザー" srcset="image/icons/user.svg">
            田中　太郎様
          </div>

          <!-- 商品名-->
          <div class="item">
            <img src="image/icons/grape2.svg" alt="アイコン" srcset="image/icons/grape2.svg">
            柏餅1個
          </div>

          <!-- 価格-->
          <div class="price">
            <img src="image/icons/price.svg" alt="価格" srcset="image/icons/price.svg">
            <span>99</span>円
            <img src="image/icons/bag.svg" alt="数" srcset="image/icons/bag.svg" class="num">2個
            <div class="total">
              計<span>217</span>円<span class="tax">(税込)</span>
            </div>
          </div>

          <!-- 日時 -->
          <div class="datetime">
            <img src="image/icons/date.svg" alt="カレンダー" srcset="image/icons/date.svg">
            22年8/22
            <img src="image/icons/time.svg" alt="時間" srcset="image/icons/time.svg" class="clock">
            <span>15:00</span>
          </div>

          <!-- 電話番号 -->
          <div class="tel">
            <img src="image/icons/tel.svg" alt="電話番号" srcset="image/icons/tel.svg">
            090-1111-2224
          </div>

          <!-- メールアドレス -->
          <a class="email" href="mailto:tanaka@example.com">
            <img src="image/icons/mail.svg" alt="メールアドレス" srcset="image/icons/mail.svg">
            tanaka@example.com
          </a>

          <!-- 変更ボタン -->
          <button class="statusbtn">状況変更</button>
        </li>
        <!-- ****************************list2********************************************** -->
        <li>
          <div class="status incomplete">未完</div>
          <div class="user">
            <img src="image/icons/user.svg" alt="ユーザー" srcset="image/icons/user.svg">
            山田　花子様
          </div>

          <!-- 商品名-->
          <div class="item">
            <img src="image/icons/grape2.svg" alt="アイコン" srcset="image/icons/grape2.svg">
            大福1個
          </div>

          <!-- 価格-->
          <div class="price">
            <img src="image/icons/price.svg" alt="価格" srcset="image/icons/price.svg">
            <span>99</span>円
            <img src="image/icons/bag.svg" alt="数" srcset="image/icons/bag.svg" class="num">2個
            <div class="total">
              計<span>217</span>円
            </div>
          </div>

          <!-- 日時 -->
          <div class="datetime">
            <img src="image/icons/date.svg" alt="カレンダー" srcset="image/icons/date.svg">
            22年8/23
            <img src="image/icons/time.svg" alt="時間" srcset="image/icons/time.svg" class="clock">
            <span>17:00</span>
          </div>

          <!-- 電話番号 -->
          <div class="tel">
            <img src="image/icons/tel.svg" alt="電話番号" srcset="image/icons/tel.svg">
            090-1111-2223
          </div>

          <!-- メールアドレス -->
          <a class="email" href="mailto:yamada@example.com">
            <img src="image/icons/mail.svg" alt="メールアドレス" srcset="image/icons/mail.svg">
            yamada@example.com
          </a>

          <!-- 変更ボタン -->
          <button class="statusbtn">状況変更</button>
        </li>
        <!-- ****************************list3********************************************** -->
        <li>
          <div class="status incomplete">未完</div>
          <div class="user">
            <img src="image/icons/user.svg" alt="ユーザー" srcset="image/icons/user.svg">
            山田　花子様
          </div>

          <!-- 商品名-->
          <div class="item">
            <img src="image/icons/grape2.svg" alt="アイコン" srcset="image/icons/grape2.svg">
            どら焼き1個
          </div>

          <!-- 価格-->
          <div class="price">
            <img src="image/icons/price.svg" alt="価格" srcset="image/icons/price.svg">
            <span class="unit-price">99</span>円
            <img src="image/icons/bag.svg" alt="数" srcset="image/icons/bag.svg" class="num">4個
            <div class="total">
              計<span>435</span>円
            </div>
          </div>

          <!-- 日時 -->
          <div class="datetime">
            <img src="image/icons/date.svg" alt="カレンダー" srcset="image/icons/date.svg">
            22年8/24
            <img src="image/icons/time.svg" alt="時間" srcset="image/icons/time.svg" class="clock">
            <span>11:00</span>
          </div>

          <!-- 電話番号 -->
          <div class="tel">
            <img src="image/icons/tel.svg" alt="電話番号" srcset="image/icons/tel.svg">
            090-1111-2223
          </div>

          <!-- メールアドレス -->
          <a class="email" href="mailto:yamada@example.com">
            <img src="image/icons/mail.svg" alt="メールアドレス" srcset="image/icons/mail.svg">
            yamada@example.com
          </a>

          <!-- 変更ボタン -->
          <button class="statusbtn">状況変更</button>
        </li>
      </ul>
    </section>
  </article>
</main>