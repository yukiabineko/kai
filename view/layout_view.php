<?php  require_once './helper/share_helper.php';  ?>

<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>ページ | <?= $controllerName ?></title>
  <link rel="stylesheet" href="./css/common.css">
  <link rel="stylesheet" href="./css/modal.css">
  <link rel="stylesheet" href="./css/<?= $controllerName ?>/<?= $actionName ?>.css" media="screen and (min-width: 980px)">
  <link rel="stylesheet" href="./css/<?= $controllerName ?>/<?= $actionName ?>-mobile.css" media="screen and (max-width: 979px)">
  <link rel="stylesheet" href="https://unpkg.com/leaflet@1.3.0/dist/leaflet.css" />
  <script src="https://unpkg.com/leaflet@1.3.0/dist/leaflet.js"></script>
  <script>
    (function(d) {
      var config = {
          kitId: 'wso2nvg',
          scriptTimeout: 3000,
          async: true
        },
        h = d.documentElement,
        t = setTimeout(function() {
          h.className = h.className.replace(/\bwf-loading\b/g, "") + " wf-inactive";
        }, config.scriptTimeout),
        tk = d.createElement("script"),
        f = false,
        s = d.getElementsByTagName("script")[0],
        a;
      h.className += " wf-loading";
      tk.src = 'https://use.typekit.net/' + config.kitId + '.js';
      tk.async = true;
      tk.onload = tk.onreadystatechange = function() {
        a = this.readyState;
        if (f || a && a != "complete" && a != "loaded") return;
        f = true;
        clearTimeout(t);
        try {
          Typekit.load(config)
        } catch (e) {}
      };
      s.parentNode.insertBefore(tk, s)
    })(document);
  </script>
  <script src="./js/main.js"></script>
  <script src="./js/object.js"></script>
  <script src="./js/modal.js"></script>
  <script src="./js/<?= $controllerName ?>/<?= $actionName ?>.js"></script>

</head>

<body>
  <!-- 買い物カゴに入れた場合のみ表示 -->
  <?php if (isset($_SESSION['orders']) && count($_SESSION['orders']) > 0) : ?>
    <div class="shopping-cart">
      <div class="shopping-cart-default">
        <div class="shopping-cart-icon">
          <img src="./image/icons/shopping-cart.svg" alt="カート" class="shopping-cart-img">
          <span class="shopping-cart-item-count">
            <?= count($_SESSION['orders']) ?>
          </span>
        </div>
        <!-- 買い物かごタイトル　-->
        <p class="shopping-cart-title">買い物かご確認</p>
        <a href="./order?action=new" class="shopping-cart-link" onclick="showOrders(arguments[0])">詳細を見る</a>
      </div>

      <!-- 拡大時の表示エリア -->
      <div class="shopping-cart-infomation">
        <h1>買い物かごリスト</h1>
        <p>注文を確定したい場合はしたのボタンを押下してください。</p>
        <table class="shopping-cart-table">
          <thead>
            <tr>
              <th>商品名</th>
              <th>価格</th>
              <th>注文数</th>
              <th>合計金額</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($_SESSION['orders'] as $cart) : ?>
              <tr>
                <td><?= $cart['name'] ?></td>
                <td style="text-align: center"><?= $cart['price'] ?></td>
                <td style="text-align: center"><?= $cart['stockInfo']['input'] ?></td>
                <td style="text-align: center"><?= (int)$cart['price'] * (int)$cart['stockInfo']['input'] ?></td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
        <div class="shopping-cart-buttos">
          <button class="shopping-cart-close" onclick="shoppingCartInfoClose()">閉じる</button>
          <a href="./order?action=new" class="oreder-link-button">注文ページへ</a>
        </div>
      </div>
    </div>
  <?php endif; ?>
  <!-- 各viewのコンテンツ -->
  <?php
  include("./view/header.php");
  include("./view/" . $controllerName . "/" . $actionName . "_view.php");
  include("./view/footer.php");
  ?>
</body>

</html>