<!-- ヘッダー-->
<header>

  <div class="logo-image"><?php include('image/logo.svg'); ?></div>
  <!-- モバイル専用　-->
  <div class="mobile-menu">
    <?php include('image/logo.svg'); ?>
    <input type="checkbox" id="mobile-check">
    <label for="mobile-check" id="menu-label"><span></span></label>
    <div class="drower">
      <section>
        <div class="wrapper">
          <h2 class="menu-title">Menu</h2>
        </div>
        <ul class="mobile-menu-ul">
          <li>
            <a href="./top">
              <?php include('image/top.svg'); ?>
              トップページ
            </a>
          </li>

          <li>
            <a href="lineup.html">
              <?php include('image/item.svg'); ?>
              出品商品
            </a>
          </li>

          <li>
            <a href="info.html">
              <?php include('image/info.svg'); ?>
              サイト案内
            </a>
          </li>

          <li>
            <a href="contact.html">
              <?php include('image/contact.svg'); ?>
              問い合わせ
            </a>
          </li>

          <li>
            <?php if (isset($_SESSION['auth_id'])) : ?>
              <form action="./auth?action=delete">
                <button type="submit">ログアウト</button>
              </form>
            <?php else : ?>
              <a href="./auth?action=new">
                <?php include('image/login.svg'); ?>
                販売店ログイン
              </a>
            <?php endif; ?>
          </li>
        </ul>
      </section>
    </div>
  </div>
  <!-- /モバイル専用　-->

  <nav class="global-nav">

    <ul>
      <li>
        <a href="./top">
          <?php include('image/top.svg'); ?>
          トップページ
        </a>
      </li>
      <li>
        <a href="lineup.html">
          <img src="./image/item.svg" alt="商品" srcset="./image/item.svg">
          出品商品
        </a>
      </li>
      <li>
        <a href="info.html">
          <?php include('image/info.svg'); ?>
          サイト案内
        </a>
      </li>
      <li>
        <a href="contact.html">
          <?php include('image/contact.svg'); ?>
          問い合わせ
        </a>
      </li>
      <li>
        <?php if (isset($_SESSION['auth_id'])) : ?>
          <div class="owner">
            <img src="./image/user.svg" alt="ログアウト" srcset="./image/user.svg">
            <input type="checkbox" id="ownerbox">
            <label for="ownerbox">店舗様メニュー</label>
            <ul class="owner-ul">
              <li>店舗ページ</li>
              <li>ログアウト</li>
            </ul>
          </div>
        <?php else : ?>
          <a href="./auth?action=new">
            <?php include('image/login.svg'); ?>
            販売店ログイン
          </a>
        <?php endif; ?>
      </li>
    </ul>
  </nav>
</header>