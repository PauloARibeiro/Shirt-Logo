class ItemSettings{
  constructor(){
    //COLOR SELECTOR
    this.colors = document.querySelectorAll('.square');
    //ADD TO BAG BUTTON
    this.addItem = document.getElementById('add-to-bag');
    this.SizeSelector();

    this.mainImg = document.querySelector('.main-img ');
    this.subImgs = document.querySelectorAll('.sub-img');
    this.subImgs.forEach( (subImg) =>{
      subImg.addEventListener('click', () =>{
        this.RemoveActive();
        subImg.classList.add('active-product');
        this.mainImg.src = subImg.src;
      })
    })
  }
  SizeSelector(){
    //SIZE SELECTOR
    this.sizes = document.querySelectorAll('.size-box');
    this.sizes.forEach( (size) =>{
      setTimeout(() =>{
        if(!size.classList.contains('disabled')){
          size.addEventListener('click', (e) =>{
            this.ResetSettings(this.sizes, 'selected');
            size.classList.add('selected');
          })
        }
      }, 2000)
    })
  }
  ResetSettings(item, itemClass){
    for (var i = 0; i < item.length; i++) {
      item[i].classList.remove(itemClass);
    }
  }
  RemoveActive(){
    for (var i = 0; i < this.subImgs.length; i++) {
      this.subImgs[i].classList.remove('active-product');
    }
  }
}

var itemSettings = new ItemSettings;
