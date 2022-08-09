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
  <script src="./js/object.js"></script>
  <script src="./js/modal.js"></script>
  <script src="./js/<?= $controllerName ?>/<?= $actionName ?>.js"></script>

</head>

<body>
  <?php
  include("./view/header.php");
  include("./view/" . $controllerName . "/" . $actionName . "_view.php");
  include("./view/footer.php");
  ?>

</body>

</html>