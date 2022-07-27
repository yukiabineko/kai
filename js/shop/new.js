window.addEventListener('load', () => {
  document.getElementById('user-form').addEventListener('submit', (e) => {
   
    let passwordString = document.getElementById('password').value;
    let confirmation = document.getElementById('confirmation').value;


    document.querySelectorAll('.error').forEach((error) => {
      let id = error.id.split('error-')[1];
      if(document.getElementById(id).value.length > 0){
        error.classList.remove('show')
      }
      else{
        e.preventDefault();
        error.classList.add('show');
      }  
    });
    //パスワードフォームの検証
    let passwordError = document.getElementById('error-password');
    if (passwordString.length === 0) {
      e.preventDefault();
      passwordError.classList.add('show');
      passwordError.textContent = "パスワードは必須です。";
    }
    else if (passwordString.length > 0 && passwordString.length < 8) {
      e.preventDefault();
      passwordError.classList.add('show');
      passwordError.textContent = "パスワードは8文字以上です。";
    }
    else if (passwordString.length >= 8 && passwordString != confirmation) {
      e.preventDefault();
      passwordError.classList.add('show');
      passwordError.textContent = "パスワード確認の内容が異なります。";
    }
    //パスワード確認の検証
    let confirmationError = document.getElementById('error-confirmation');
    if (confirmation.length === 0) {
      e.preventDefault();
      confirmationError.classList.add('show');
      confirmationError.textContent = "パスワードは必須です。";
    }
    else if (confirmation.length > 0 && confirmation.length < 8) {
      e.preventDefault();
      confirmationError.classList.add('show');
      confirmationError.textContent = "パスワードは8文字以上です。";
    }
    else if (confirmation.length >= 8 && passwordString != confirmation) {
      e.preventDefault();
      confirmationError.classList.add('show');
      confirmationError.textContent = "パスワード確認の内容が異なります。";
    }

  });

});