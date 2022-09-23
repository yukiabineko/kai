<!-- コンテンツ -->
<article>
  <!-- タイトル -->
  <section class="title">
    <img src="image/icons/memo.svg" alt="タイトルアイコン">
    <h2>新規店舗登録</h2>
  </section>
  <?php if(isset($_SERVER['HTTP_REFERER'])) : ?>
    <a href="<?= $_SERVER['HTTP_REFERER'] ?>" class="back-button">戻る</a>
  <?php endif; ?>
  <!--フォーム-->
  <section class="form">
    <form action="./shop?action=create" method="post" id="user-form">
      <table class="user-table">
        <!-- 店舗名-->
        <tr>
          <th>
            <img src="image/icons/shop.svg" alt="店舗">店舗名
            <span>(*必須です。)</span>
          </th>
          <td>
            <div class="error" id="error-name">店舗名は必須です。</div>
            <input type="text" name="name" id="name" value="<?php echo  isset($_SESSION['input'])?  $_SESSION['input']['name'] : ''  ?>">
          </td>
        </tr>
        <!-- メールアドレス -->
        <tr>
          <th>
            <img src="image/icons/mail.svg" alt="メールアドレス">メールアドレス
            <span>(*必須です。)</span>
          </th>
          <td>
            <div class="error" id="error-email">メールアドレスは必須です。</div>
            <?php if(isset($_SESSION['vallidation']['mail_error']) ) : ?>
              <div class="error-vallidation"><?= $_SESSION['vallidation']['mail_error'] ?></div>
            <?php endif; ?>
            <input type="email" name="email" id="email" value="<?php echo  isset($_SESSION['input'])?  $_SESSION['input']['email'] : ''  ?>">
          </td>
        </tr>
        <!-- 電話番号 -->
        <tr>
          <th>
            <img src="image/icons/tel.svg" alt="電話番号">電話番号
            <span>(*必須です。)</span>
          </th>
          <td>
            <div class="error" id="error-tel">電話番号は必須です。</div>
            <?php if(isset($_SESSION['vallidation']['tel_error']) ) : ?>
              <div class="error-vallidation"><?= $_SESSION['vallidation']['tel_error'] ?></div>
            <?php endif; ?>
            <input 
              type="tel" name="tel" id="tel" placeholder="ハイフン(-)は入れないでください。(例09011112222)" 
              value="<?php echo  isset($_SESSION['input'])?  $_SESSION['input']['tel'] : ''  ?>"
            >
          </td>
        </tr>
        <!-- 住所 -->
        <tr>
          <th>
            <img src="image/icons/adress.svg" alt="住所">住所
            <span>(*必須です。)</span>
          </th>
          <td>
            <div class="error" id="error-adress">住所は必須です。</div>
            <input type="text" name="adress" id="adress" placeholder="*市町村から入力ください(例 甲府市丸の内一丁目1-8)" 
                  value="<?php echo  isset($_SESSION['input'])?  $_SESSION['input']['adress'] : ''  ?>"
            >
          </td>
        </tr>
        <!-- パスワード -->
        <tr>
          <th>
            <img src="image/icons/password.svg" alt="パスワード">パスワード
            <span>(*必須です。)</span>
          </th>
          <td>
            <div class="error" id="error-password">パスワードは必須です。</div>
            <input type="password" name="password" id="password" placeholder="*8文字でお願いします.">
          </td>
        </tr>

        <!-- パスワード確認 -->
        <tr>
          <th class="last">
            <img src="image/icons/password.svg" alt="パスワード確認">パスワード確認
            <span>(*必須です。)</span>
          </th>
          <td class="last">
            <div class="error error-conf" id="error-confirmation">パスワード確認は必須です。</div>
            <input type="password" name="password_confirmation" id="confirmation" placeholder="*もう一度同じパスワードを入力してください。">
          </td>
        </tr>
      </table>
      <!-- csrf対策 -->
      <input type="hidden" name="csrf-token" value="<?= $token; ?>">
      <input type="submit" value="送信">
      
    </form>
  </section>

</article>
<!-- バリデーションセッションがある場合は削除 -->
<?php if(isset($_SESSION['vallidation'])){
  unset($_SESSION['vallidation']);
 }
 
?>