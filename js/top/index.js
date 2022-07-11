window.onload = () => {
  const mediaQuery = window.matchMedia('(min-width: 980px)')
  let mainVisualUl = document.querySelector('.main-visual-ul');
  let mainVisualLists = document.querySelectorAll('.main-visual-li');
  let width = mainVisualLists[0].clientWidth;
  let counter = 0;
  let isAnimation = true;

  mainVisualLists[0].classList.add('show');

  let li = document.createElement('li');
  li.classList = "main-visual-li";

  let img = document.createElement('img');
  let file = "image/" + mainVisualLists[0].children[0].src.split('/').slice(-1)[0];
  img.src = file;
  li.appendChild(img);
  mainVisualUl.appendChild(li);

  /**
   * スライダー処理
   */
  const slider = () => {
    lists = document.querySelectorAll('.main-visual-li');
    if (isAnimation) {
      mainVisualUl.style.transition = ".5s";
      for (let i = 0; i < lists.length; i++) {
        lists[i].style.transition = ".7s";
      }
    }
    else {
      mainVisualUl.style.transition = null;
      for (let i = 0; i < lists.length; i++) {
        lists[i].style.transition = null;
      }
    }
    counter++;
    mainVisualUl.style.transform = "translateX(" + -width * counter + "px)";
    for (let i = 0; i < lists.length; i++) {
      lists[i].classList.remove('show');
    }
    lists[counter].classList.add('show');
    if (counter === lists.length - 1) {
      counter = -1;
      isAnimation = false;
    }
    else {
      isAnimation = true;
    }
  }
  /**
   * 花びらの処理
   */
  const createPetal = () => {
    let petal = document.createElement('span');
    petal.classList = "petal";
    const max = 30;
    const min = 10;
    let size = Math.random() * (max + 1 - min) + min + "px";
    petal.style.width = size;
    petal.style.height = size;
    petal.style.left = Math.random() * window.innerWidth + "px";
    document.querySelector('html').appendChild(petal);

    setTimeout(() => {
      petal.remove();
    }, 3000);
  }
  setInterval(() => {
    slider();
  }, 3000);
  if (mediaQuery.matches) {
    setInterval(() => {
      createPetal();
    }, 300);
  }



}