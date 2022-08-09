<!-- フラッシュ通知 -->
 <?php if(isset($_SESSION["error-flash"])): ?>
   <div class="error-flash"><?= $_SESSION["error-flash"]; ?></div>
 <?php unset($_SESSION["error-flash"]); endif; ?>
<!-- コンテンツ -->
<article>
    <!-- タイトル -->
    <section class="title">
      <h2>販売店ログイン</h2>
    </section>

    <!--フォーム-->
    <section class="form">
      <form action="./auth?action=create" method="post" id="login-form">
        <table class="login-table">
         
          <!-- メールアドレス -->
          <tr>
            <th>
              <img src="image/icons/mail.svg" alt="メールアドレス">メールアドレス
              <span>(*必須です。)</span>
            </th>
            <td>
              <div class="error" id="error-email">メールアドレスは必須です。</div>
              <input type="email" name="email" id="email" class="input">
            </td>
          </tr>
          <!-- パスワード -->
          <tr>
            <th class="last">
              <img src="image/icons/password.svg" alt="パスワード">パスワード
              <span>(*必須です。)</span>
            </th>
            <td class="last">
              <div class="error" id="error-password">パスワードは必須です。</div>
              <input type="password" name="password" id="password" class="input">
            </td>
          </tr>
        <input type="hidden" name="csrf-token" value="<?= $token; ?>">
        </table>
        <button type="submit" id="login"><img src="image/icons/login.png" alt="ログイン" >ログイン</button>
        <a href="./shop?action=new" class="new-user-link">
          <img src="image/icons/memo2.svg" alt="新規リンク">
          新規店舗さん登録はこちら
        </a>
      </form>
    </section>

  </article>
