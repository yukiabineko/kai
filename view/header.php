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
              <img src="./image/top.svg" alt="トップページ" srcset="./image/top.svg">
              トップページ
            </a>
          </li>

          <li>
            <a href="lineup.html">
              <img src="./image/item.svg" alt="出品商品" srcset="./image/item.svg">
              出品商品
            </a>
          </li>

          <li>
            <a href="./info">
              <img src="./image/info.svg" alt="サイト案内" srcsest="./image/info.svg">
              サイト案内
            </a>
          </li>

          <li>
            <a href="./contact?action=new">
              <img src="./image/contact.svg" alt="問い合わせ" srcset="./image/contact.svg">
              問い合わせ
            </a>
          </li>

          <li>
            <?php if (isset($_SESSION['auth_id'])) : ?>
              <dl class="owner-mobile">
                <!-- 1行目 -->
                <dt>
                  <img src="./image/user.svg" alt="店舗さんメニュー" srcset="./image/user.svg">
                  店舗さんメニュー
                </dt>
                <!-- メニュー1 -->
                <dd class="owner-items">
                  <a href="./shop?action=show&id=<?= $_SESSION['auth_id'] ?>">
                    <img src="./image/shop.svg" alt="店舗ページ" srcset="./image/shop.svg">
                    店舗様ページ
                  </a>
                </dd>
                <!-- メニュー2 -->
                <dd class="owner-items">
                  <a href="./shop?action=show&id=<?= $_SESSION['auth_id'] ?>">
                    <img src="./image/shop.svg" alt="注文リスト" srcset="./image/shop.svg">
                    注文リスト
                  </a>
                </dd>
                <!-- メニュー3 -->
                <dd class="owner-items">
                  <form action="./auth?action=delete&id=<?= $_SESSION['auth_id'] ?>" method="post">
                    <button type="submit" class="logout-mobile-btn">
                      <img src="./image/logout.svg" alt="ログアウト" srcset="./image/logout.svg">
                      ログアウト
                    </button>
                    <!--csrf -->
                    <input type="hidden" name="csrf-token" , value="<?= $token; ?>">
                  </form>

                </dd>
              </dl>

            <?php else : ?>
              <a href="./auth?action=new">
                <img src="./image/login.svg" alt="ログイン" srcset="./image/login.svg">
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
        <a href="./info">
          <?php include('image/info.svg'); ?>
          サイト案内
        </a>
      </li>
      <li>
        <a href="./contact?action=new">
          <?php include('image/contact.svg'); ?>
          問い合わせ
        </a>
      </li>
      <li>
        <?php if (isset($_SESSION['auth_id'])) : ?>
          <div class="owner">
            <input type="checkbox" id="ownerbox">
            <label for="ownerbox" class="menu-label">
              <img src="./image/user.svg" alt="ログアウト" srcset="./image/user.svg">
              店舗様メニュー
            </label>
            <ul class="owner-ul">
              <li class="sub-menu-list">
                <a href="./shop?action=show&id=<?= $_SESSION['auth_id'] ?>" class="sub-menu-link">
                  <img src="./image/shop.svg" alt="店舗" srcset="./image/shop.svg" class="sub-menu-icons">
                  店舗様ページ
                </a>
              </li>
              <li class="sub-menu-list">
                <a href="./item?action=new" class="sub-menu-link">
                  <img src="./image/icons/grape.svg" alt="商品" srcset="./image/icons/grape.svg" class="sub-menu-icons">
                  新規商品登録
                </a>
              </li>
              <li class="sub-menu-list">
                <form action="./auth?action=delete&id=<?= $_SESSION['auth_id'] ?>" method="post">
                  <button type="submit" class="sub-menu-link">
                    <img src="./image/logout.svg" alt="ログアウト" srcset="./image/logout.svg" class="sub-menu-icons">
                    ログアウト
                  </button>
                  <!--csrf -->
                  <input type="hidden" name="csrf-token" , value="<?= $token; ?>">
                </form>
              </li>
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