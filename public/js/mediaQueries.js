// // THIS WILL APPEND ALL THE ITEMS INTO A SINGLE PARENT ELEMENT
// let popularItems = document.querySelectorAll('.item');
// let popularHolder = document.querySelector('.item-holder');
// if (window.matchMedia("(max-width: 700px)").matches) {
//   popularItems.forEach( (item, i) =>{
//     popularHolder.appendChild(item);
//   })
// }


class MediaQueries {
  constructor(){
    // // THIS WILL APPEND ALL THE ITEMS INTO A SINGLE PARENT ELEMENT
    // this.popularItems = document.querySelectorAll('.item');
    // this.popularHolder = document.querySelector('.item-holder');

    //THIS IS FOR THE REDFINE BUTTON
    this.redefine = document.getElementById('item-filters');

    //THIS IS FOR THE SIDE IMGS NEXT TO THE MAIN ITEM IMG
    this.sideImgs = document.getElementById('side-imgs');
    //THIS IS FOR THE PRODUCT DEATILS
    this.productDetails = document.querySelectorAll('#product-details');

    this.featureHolder = document.querySelector('.features-item:nth-child(2)');
    this.AppendItems();
  }
  AppendItems(){
    // //THIS IS FOR THE REDFINE BUTTON
    // if (window.matchMedia("(max-width: 700px)").matches) {
    //   this.popularItems.forEach( (item, i) =>{
    //     this.popularHolder.appendChild(item);
    //   })
    // }
    //THIS IS FOR THE SIDE IMGS NEXT TO THE MAIN ITEM IMG
    if (window.matchMedia("(max-width: 840px)").matches) {
      if(this.sideImgs !== null){
        let productInfo = document.getElementById('product-info');
        productInfo.appendChild(this.sideImgs);
        this.productDetails[1].appendChild(this.productDetails[0]);
      }
    }

    if (window.matchMedia("(max-width: 1000px)").matches) {
      if(this.redefine !== null){
        let mobileNav = document.getElementById('mobile-modal');
        mobileModal.appendChild(this.redefine);
      }

      if(this.featureHolder !== null){
        let featureContent = document.querySelector('.features-item:nth-child(2) #features-content');
        this.featureHolder.style.marginTop = '30px';
        this.featureHolder.appendChild(featureContent);
      }
    }
  }
}

var mediaQueries = new MediaQueries;
