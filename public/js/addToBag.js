//ADDS ITEMS TO CART
class AddToBag{
  constructor(){
    this.addToBagBtn = document.querySelector('.add-to-bag');
    this.cartBtn = document.querySelectorAll('.fa-shopping-cart');
    this.itemAdded = document.getElementById('added-item');
    this.closeBtn = document.getElementById('added-close');

    //CLOSE BUTTON
    this.closeBtn.addEventListener('click', () =>{
      this.itemAdded.style.top = '-400px';
    })
    //ADD TO BAG BUTTON
    if(this.addToBagBtn != null){
      this.addToBagBtn.addEventListener('click', () =>{
        this.itemAdded.style.top = '58px';
        let size = this.SelectSize();
        //checks session
        this.CheckSession(this.addToBagBtn, size);
      })
    }
    //QUICK ADD TO BAG BUTTON
    this.cartBtn.forEach( (cartBtn, i) =>{
      if(i != 0){
        cartBtn.addEventListener('click', () =>{
          if(cartBtn.classList.contains('fa-shopping-cart')){
            cartBtn.classList.remove('fa-shopping-cart');
            cartBtn.classList.add('fa-check');

            this.itemAdded.style.top = '58px';
            //checks session
            this.CheckSession(cartBtn, 'empty');
          }
        })
      }
    })
  }
  //this will check if user is logged in and adds item to user cart
  CheckSession(item, size){
    //loading spinner
    document.getElementById('spinner-holder').style.display = 'block';

    //this will make an ajax request
    let xhr = new XMLHttpRequest();
    let params = `?add=` + item.id + '&size=' + size;

    xhr.open("POST", 'sessionCheck.php' + params, true);

    //Send the proper header information along with the request
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

    xhr.onreadystatechange = () => {
      if(xhr.readyState == 4 && xhr.status == 200) {
         let data = JSON.parse(xhr.responseText);
         this.UpdateUI(data, item);

         //if the user is not logged in the item will be stored in a temporary cart
         if(data.false == true){
           this.AddItemToCart(data, item);
         }
       }
    }
    xhr.send();
  }

  UpdateUI(data, item){
    let addedItemImg = document.querySelector('#added-item img');
    let addedItemName = document.querySelector('#added-item h5');
    let addedItemPrice = document.querySelector('#added-item h6');

    addedItemImg.src = 'img/' + data[0].item_main_img;
    addedItemName.textContent = data[0].item_name;
    addedItemPrice.textContent = data[0].item_price + ' €';

    if(item.classList.contains('btn') && !item.classList.contains('btn-disabled')){
      item.className = "";
      item.classList.add('btn');
      item.classList.add('btn-disabled');
      item.innerHTML = "In cart &#10004;";
      //updates the header cart price
      this.UpdateHeaderPrice(data);
    }

    if(item.classList.contains('fas')){
      this.UpdateHeaderPrice(data);
    }

    document.getElementById('spinner-holder').style.display = 'none';
  }

  UpdateHeaderPrice(data){
    let totalPrice = document.querySelector('#cart-nav .price');
    let price = 0;

    price = parseInt(totalPrice.textContent);
    price += parseInt(data[0].item_price);
    price = Math.round(price * 100) / 100;

    totalPrice.textContent = price + '€';
  }

  AddItemToCart(data, item){
    //this will check if there is an active cookie
    var match = document.cookie.match(new RegExp('(^| )' + 'id' + '=([^;]+)'));
    if (match) {
      //store cookie value
      var currentValue = match[2];
      currentValue += item.id;
    }else{
      currentValue = item.id;
    }

    //will remove any duplicate ids
    currentValue = this.RemoveDuplicateIds(currentValue);

    let expires = "";
    let days = 1;
    if (days) {
        let date = new Date();
        date.setTime(date.getTime() + (days*24*60*60*1000));
        expires = "; expires=" + date.toUTCString();
    }
    //create cookies
    document.cookie = 'id' + "=" + currentValue + "," + expires + "; path=/";
  }

  RemoveDuplicateIds(string){
    //splits string into array
    string = string.split(",");
    //final result will be stored in here
    const result = [];
    //This will store the non duplicate ids
    const checker = new Object();

    for (var i = 0; i < string.length; i++) {
      let element = string[i];
      //if the checker element doesnt not contain the current character then push it to result
      if(!checker[element]){
        checker[element] = true;
        result.push(element);
      }
    }
    return result;
  }

  SelectSize(){
    var result = "";
    let sizes = document.querySelectorAll('.size-box');
    sizes.forEach( (size) => {
      if(size.classList.contains('selected')){
        result = size.querySelector('span').textContent;
      }
    })
    return result;
  }

}
//CHANGE THE HEART TO FULL WHEN USER CLICKS IT(ADDS TO FAVORITES)
class Favorite{
  constructor(){
    this.heart = document.querySelectorAll('#item-list .item-menu div .fa-heart');

    this.heart.forEach( (heart) => {
      heart.addEventListener('click', () =>{
        if(heart.classList.contains('far')){
          heart.classList.remove('far');
          heart.classList.add('fas');
          this.FavoriteAjaxRequest('?fav=1' + '&add=' + heart.id);
        }else{
          heart.classList.remove('fas');
          heart.classList.add('far');
          this.FavoriteAjaxRequest(`?fav=1` + '&remove=' + heart.id);
        }
      })
    })
  }

  FavoriteAjaxRequest(params){
    //loading spinner
    document.getElementById('spinner-holder').style.display = 'block';

    //this will make an ajax request
    let xhr = new XMLHttpRequest();

    xhr.open("POST", 'sessionCheck.php' + params, true);

    //Send the proper header information along with the request
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

    xhr.onreadystatechange = () => {
      if(xhr.readyState == 4 && xhr.status == 200) {
        document.getElementById('spinner-holder').style.display = 'none';
       }
    }
    xhr.send();
  }
}


var favorite = new Favorite;
var addToBag = new AddToBag;
