<!-- コンテンツ -->
<article>
  <!-- タイトル -->
  <section class="title">
    <img src="image/icons/grape.svg" alt="タイトル">
    <h2>新規商品登録</h2>
  </section>
  <a href="shop.html" class="back-button">戻る</a>

  <!--フォーム-->
  <section class="form">
    <form action="./item?action=create" method="post" id="item-form" enctype="multipart/form-data">
      <table class="item-table">
        <!-- 商品名-->
        <tr>
          <th>
            <img src="image/icons/grape2.svg" alt="商品名">商品名
            <span>(*必須です。)</span>
          </th>
          <td>
            <div class="error" id="error-name">商品名は必須です。</div>
            <input type="text" name="name" id="name" class="input">
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
            <input type="number" name="price" id="price" class="input">
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
            <input type="number" name="stock" id="stock" class="input">
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
            <input type="text" name="startDate" id="startDate" placeholder="開始日" class="input dt-input" autocomplete="off">
            <div class="error" id="error-endDate">終了日は必須です。</div>
            <input type="text" name="endDate" id="endDate" placeholder="終了日" class="input dt-input" autocomplete="off">
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
            <input type="text" name="startTime" id="startTime" class="input tm-input" placeholder="開始時間" autocomplete="off">
            <div class="error" id="error-endTime">終了時間は必須です。</div>
            <input type="text" name="endTime" id="endTime" class="input tm-input" placeholder="終了時間" autocomplete="off">
          </td>
        </tr>


        <!-- 商品説明 -->
        <tr>
          <th class="info">
            <img src="image/icons/pen.svg" alt="説明">商品説明
          </th>
          <td class="info">
            <textarea name="info" id="info" class="textarea" cols="30" rows="10"></textarea>
          </td>
        </tr>
      </table>

      <!-- 画像関連 -->
      <section class="image">
        <div class="img-title">
          <h2>画像登録</h2>
        </div>
        <p>見出し画像と3点の商品画像を登録できます。</p>
        <h3>見出し画像</h3>
        <div class="file" id="fileArea1">
          <div class="form">
            <span class="file-view" id="imgform-1"></span>
            <label for="file1">ファイルを選択</label>
            <input type="file" name="thumbnail" class="file-input" id="file1" onchange="showImage(event,this.id)">
          </div>
        </div>


        <!-- 追加画像分 -->
        <h3>追加商品画像</h3>
        <!--画像1-->
        <div class="file" id="fileArea2">
          <div class="form">
            <span class="file-view" id="imgform-2"></span>
            <label for="file2">ファイルを選択</label>
            <input type="file" name="file[]" class="file-input" id="file2" onchange="showImage(event,this.id)">
          </div>
        </div>


        <!--画像2-->
        <div class="file" id="fileArea3">
          <div class="form">
            <span class="file-view" id="imgform-3"></span>
            <label for="file3">ファイルを選択</label>
            <input type="file" name="file[]" class="file-input" id="file3" onchange="showImage(event,this.id)">
          </div>
        </div>


        <!--画像3-->
        <div class="file" id="fileArea4">
          <div class="form">
            <span class="file-view" id="imgform-4"></span>
            <label for="file4">ファイルを選択</label>
            <input type="file" name="file[]" class="file-input" id="file4" onchange="showImage(event,this.id)">
          </div>
        </div>


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
      <button class="prev" onclick="prevItemMonth(document.getElementById('target-date').textContent, false)">前月</button>
      <div class="year-month">xxx</div>
      <button class="next" onclick="nextItemMonth(document.getElementById('target-date').textContent, false)">次月</button>
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
    <!-- パラメータ用　-->
    <div class="hidden" style="display: none ;"></div>
    <button class="modal-time-result-button" onclick="timeDataSend()">確定</button>
  </div>

</div>