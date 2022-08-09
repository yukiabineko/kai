window.addEventListener('load', ()=>{
  let images = [];
  let mainImg = document.getElementById('view-img');
  let imageTags = document.querySelectorAll('.img-lists');

  imageTags.forEach((img,index)=>{
    images.push(img.src);
    const id = img.id.split('img-list-')[1];
    img.addEventListener('click',()=>{
      let file = mainImg.src;
       mainImg.src = img.src;
      images.splice(id, 1);
      images.push(file);
      imageTags.forEach((img,index)=>{
        img.src = images[index];
      })
    });
  });
});