<!-- コンテンツ -->
<article>
  <!-- 送信時フラッシュ-->
  <?php if (isset($_SESSION["flash"])) : ?>
    <div class="flash"><?= $_SESSION["flash"]; ?></div>
    <?php unset($_SESSION["flash"]); ?>
  <?php endif; ?>


  <!-- タイトル -->
  <section class="title">
    <h2>お問い合わせ</h2>
    <p>本サイトについてのお問い合わせはこちらからお願い致します。</p>
  </section>

  <!--フォーム-->
  <section class="form">
    <form action="./contact?action=create" method="post" id="contact-form">
      <table class="contact_form">
        <!-- 名前　-->
        <tr>
          <th>お名前<span>(*必須です。)</span></th>
          <td>
            <div class="error error-name">⚠︎お客様名が入力されてません。</div>
            <input type="text" name="name" id="name" class="inputs">
          </td>
        </tr>
        <!-- メールアドレス -->
        <tr>
          <th>メールアドレス<span>(*必須です。)</span></th>
          <td>
            <div class="error error-email">⚠︎メールアドレスが入力されてません。</div>
            <input type="email" name="email" id="email" class="inputs">
          </td>
        </tr>
        <!-- 件名 -->
        <tr>
          <th>件名</th>
          <td><input type="text" name="subject" id="subject"></td>
        </tr>
        <!-- 問い合わせ内容 -->
        <tr>
          <th class="textara-th">問い合わせ内容</th>
          <td>
            <textarea name="content" id="content" cols="30" rows="5"></textarea>
          </td>
        </tr>
      </table>
      <!-- ボタン　-->
      <div class="btn">
        <input type="submit" value="送信">
        <input type="hidden" name="csrf-token" value="<?= $token ?>">
      </div>
    </form>
  </section>

</article>