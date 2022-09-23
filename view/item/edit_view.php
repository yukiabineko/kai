<link rel="stylesheet" href="./css/item/new.css" media="screen and (min-width: 980px)">
<link rel="stylesheet" href="./css/item/new-mobile.css"" media=" screen and (max-width: 979px)">
<script src="./js/item/new.js"></script>

<!-- コンテンツ -->
<article>
  <!-- タイトル -->
  <section class="edit-form-title">
    <img src="image/icons/grape.svg" alt="タイトル">
    <h2>【<?= $item->name ?>】編集</h2>
  </section>
  <?php if(isset($_SERVER['HTTP_REFERER'])) : ?>
    <a href="<?= $_SERVER['HTTP_REFERER'] ?>" class="back-button">戻る</a>
  <?php endif; ?>

  <!--フォーム-->

  <section class="form">
    <form action="./item?action=update&id=<?= $item->id; ?>" method="post" id="item-form" enctype="multipart/form-data">
      <table class="item-table">
        <!-- 商品名-->
        <tr>
          <th>
            <img src="image/icons/grape2.svg" alt="商品名">商品名
            <span>(*必須です。)</span>
          </th>
          <td>
            <div class="error" id="error-name">商品名は必須です。</div>
            <input type="text" name="name" id="name" class="input" value="<?= $item->name ?>">
          </td>
        </tr>

        <!-- 価格 -->
        <tr>
          <th>
            <img src="image/icons/price.svg" alt="価格">価格
            <span>(*必須です。)</span>
          </th>
          <td>
            <div class="error" id="error-price">価格は必須です。</div>
            <input type="number" name="price" id="price" class="input" value="<?= $item->price ?>">
          </td>
        </tr>

        <!-- 在庫 -->
        <tr>
          <th>
            <img src="image/icons/memo2.svg" alt="在庫">在庫
            <span>(*必須です。)</span>
          </th>
          <td>
            <div class="error" id="error-stock">在庫は必須です。</div>
            <input type="number" name="stock" id="stock" class="input" value="<?= $item->stock ?>">
          </td>
        </tr>

        <!-- 販売日 -->
        <tr>
          <th class="datetime">
            <img src="image/icons/date.svg" alt="販売日">販売日
            <span>(*必須です。)</span>
          </th>
          <td>
            <div class="error" id="error-startDate">開始日は必須です。</div>
            <input type="text" name="startDate" id="startDate" placeholder="開始日" class="input dt-input" value="<?= date('Y-m-d', strtotime($item->start)); ?>" autocomplete="off">
            <div class="error" id="error-endDate">終了日は必須です。</div>
            <input type="text" name="endDate" id="endDate" placeholder="終了日" class="input dt-input" value="<?= date('Y-m-d', strtotime($item->finish)); ?>" autocomplete="off">
          </td>
        </tr>

        <!-- 販売時間 -->
        <tr>
          <th class="datetime">
            <img src="image/icons/time.svg" alt="販売時間">販売時間
            <span>(*必須です。)</span>
          </th>
          <td>
            <div class="error" id="error-startTime">開始時間は必須です。</div>
            <input type="text" name="startTime" id="startTime" class="input tm-input" placeholder="開始時間" value="<?= date('G:i', strtotime($item->start)); ?>">
            <div class="error" id="error-endTime">終了時間は必須です。</div>
            <input type="text" name="endTime" id="endTime" class="input tm-input" placeholder="終了時間" value="<?= date('G:i', strtotime($item->finish)); ?>">
          </td>
        </tr>


        <!-- 商品説明 -->
        <tr>
          <th class="info">
            <img src="image/icons/pen.svg" alt="説明">商品説明
          </th>
          <td class="info">
            <textarea name="info" id="info" class="input-area" cols="30" rows="10"><?= $item->info ?></textarea>
          </td>
        </tr>
      </table>

      <!-- 画像関連 -->
      <section class="image">
        <div class="img-title">
          <h2 class="edit-img-title">画像登録編集</h2>
        </div>
        <p>見出し画像と3点の商品画像を登録/編集できます。</p>
        <h3>見出し画像</h3>
        <div class="file" id="fileArea1">
          <div class="preview" id="preview-1">
            <img src="<?= $item->thumbnail; ?>" alt="商品1" srcset="<?= $item->thumbnail; ?>">
          </div>
          <div class="form">
            <span class="file-view" id="imgform-1">編集する場合はファイルを選択してください。</span>
            <label for="file1">ファイルを選択</label>
            <input type="file" name="thumbnail" class="file-input" id="file1" onchange="showImage(event,this.id)">
          </div>
        </div>

        <!-- 画像が登録されている場合 -->

        <?php $count = 2;
        if (!empty($images[0])) : ?>
          <!-- 編集画像分 -->
          <h3>商品画像編集</h3>
          <?php foreach ($images as $key => $img) : ?>
            <div class="file" id="fileArea<?= $count; ?>">
              <?php if (!empty($images[$key])) : ?>
                <div class="preview" id="preview-<?= $count ?>">
                  <img src="<?= $images[$key]; ?>" alt="商品<?= $count; ?>" srcset="<?= $images[$key]; ?>">
                </div>

              <?php endif; ?>
              <div class="form">
                <span class="file-view" id="imgform-<?= $count; ?>">編集する場合はファイルを選択してください。</span>
                <label for="file<?= $count; ?>">ファイルを選択</label>
                <input type="file" name="upload-file[]" class="file-input" id="file<?= $count; ?>" onchange="showImage(event,this.id)">
              </div>
            </div>
          <?php $count++;
          endforeach; ?>
          <!-- 残りを新規登録側に　-->
          <?php if ($count <= 4) : ?>
            <h3>商品画像追加</h3>
            <?php for ($i = $count; $i <= 4; $i++) : ?>
              <div class="file" id="fileArea<?= $i ?>">
                <div class="form">
                  <span class="file-view" id="imgform-<?= $i; ?>">ファイルを選択してください。</span>
                  <label for="file<?= $i; ?>">ファイルを選択</label>
                  <input type="file" name="file[]" class="file-input" id="file<?= $i; ?>" onchange="showImage(event,this.id)">
                </div>
              </div>
            <?php endfor; ?>
          <?php endif; ?>
          <!-- 一つも画像が登録されてない場合の処理 -->
        <?php else : ?>
          <h3>商品画像追加</h3>
          <?php for ($i = $count; $i <= 4; $i++) : ?>
            <div class="file" id="fileArea<?= $i ?>">
              <div class="form">
                <span class="file-view" id="imgform-<?= $i; ?>">ファイルを選択してください。</span>
                <label for="file<?= $i; ?>">ファイルを選択</label>
                <input type="file" name="file[]" class="file-input" id="file<?= $i; ?>" onchange="showImage(event,this.id)">
              </div>
            </div>
          <?php endfor; ?>

        <?php endif; ?>



      </section>

      <input type="hidden" name="csrf-token" value="<?= $token; ?>">
      <input type="submit" value="送信">

    </form>
  </section>

</article>

<!-- カレンダーモーダル-->
<div id="modal-back"></div>
<div id="modal">
  <div style="text-align:right;margin-top:5%;"><button class="modal-bt" onclick="closeModal()">x</button></div>
  <div id="modal-contents">
    <h3>日付け登録</h3>
    <div class="btns">
      <button class="prev" onclick="prevItemMonth(document.getElementById('target-date').textContent )">前月</button>
      <div class="year-month">xxx</div>
      <button class="next" onclick="nextItemMonth(document.getElementById('target-date').textContent )">次月</button>
    </div>
    <!-- カレンダー -->
    <table class="calendar"></table>
    <!-- 月パラメータ用 -->
    <div id="target-date"></div>
    <input type="hidden" name="inputName" id="inputName">
  </div>
</div>

<!-- 時間モーダル -->
<div id="Timemodal">
  <div style="text-align:right;margin-top:5%;"><button class="modal-bt" onclick="closeTimeModal()">x</button></div>
  <div class="contents">
    <h3>販売時間の入力</h3>
    <div class="time-form">
      <!-- 時 -->
      <div class="hour">
        <span>時</span>
        <select class="modal-hour-select">
          <option value="07">午前7時</option>
          <option value="08">午前8時</option>
          <option value="09">午前9時</option>
          <option value="10">午前10時</option>
          <option value="11">午前11時</option>
          <option value="12">午前12時</option>
          <option value="13">午後1時</option>
          <option value="14">午後2時</option>
          <option value="15">午後3時</option>
          <option value="16">午後4時</option>
          <option value="17">午後5時</option>
          <option value="18">午後6時</option>
          <option value="19">午後7時</option>
          <option value="20">午後8時</option>
          <option value="21">午後9時</option>
          <option value="22">午後10時</option>
          <option value="23">午後11時</option>
          <option value="00">午前0時</option>
          <option value="01">午前1時</option>
          <option value="02">午前2時</option>
          <option value="03">午前3時</option>
          <option value="04">午前4時</option>
          <option value="05">午前5時</option>
          <option value="06">午前6時</option>
        </select>
      </div>
      <!-- 分 -->
      <div class="min">
        <span>分</span>
        <select class="modal-min-select">
          <option value="00">0分</option>
          <option value="15">15分</option>
          <option value="30">30分</option>
          <option value="45">45分</option>
        </select>
      </div>
    </div>
    <button class="modal-time-result-button">確定</button>
  </div>

</div>