class EditItem{
  constructor(){
    this.pencil = document.querySelectorAll('#cart-item .fa-pencil-alt');
    this.deleteBtn = document.querySelectorAll('#cart-item .fa-times');
    this.modalHolder = document.getElementById('item-edit-holder');
    this.modalContent = document.getElementById('item-edit');
    this.modalCloseBtn = document.querySelector('#item-edit .fas');
    //loading spinner
    this.loading = document.getElementById('spinner-holder');
    //update button
    this.updateBtn = document.getElementById('update-btn');
    //currently selected item to edit
    this.currentSelected = 0;

    this.pencil.forEach( (pencil, i) => {
      pencil.addEventListener('click', (e) =>{
        document.querySelector('#edit-flex #error').style.display= 'none';
        this.modalContent.style.height = '370px';
        this.GetItem(pencil.id);
        this.currentSelected = i;
        console.log(this.currentSelected);
        e.preventDefault();
      })
    })

    this.deleteBtn.forEach((deleteBtn, i) => {
      deleteBtn.addEventListener('click', (e) =>{
        let cartItem = document.querySelectorAll('#cart-item');
        let totalPrice = document.querySelector('#checkout h4 span');
        let cartPrice = document.querySelectorAll('.cart-price');
        let headerCartPrice = document.querySelector('#cart-nav .price');

        cartItem[i].classList.remove('fadeOut');
        cartItem[i].classList.add('fadeOut');
        cartItem[i].style.pointerEvents = "none";

        setTimeout(() =>{
          cartItem[i].style.display = "none";
        }, 1100);

        //this will calculate the total price and display it
        totalPrice.textContent -= cartPrice[i].textContent;
        totalPrice.textContent = Math.round(totalPrice.textContent * 100) / 100;
        headerCartPrice.textContent = Math.round(totalPrice.textContent * 100) / 100 + " €";
        this.DeleteItem(deleteBtn.id, cartItem[i]);
      })
    })

    //closes item editor modal
    this.modalCloseBtn.addEventListener('click', () =>{
      this.modalHolder.style.height = '0%';
      this.modalContent.style.transform = 'translate(-50%, -250%)';
    })

    //update button
    this.updateBtn.addEventListener('click', () =>{
      this.sizes = document.querySelectorAll('.size-box');
      this.cartItem =  document.querySelectorAll('.cart-info-size span');

      this.sizes.forEach( (size, i) =>{
        if(size.classList.contains('selected') && !size.classList.contains('disabled')){
          this.cartItem[this.currentSelected].textContent = size.textContent;
          this.modalHolder.style.height = '0%';
          this.modalContent.style.transform = 'translate(-50%, -250%)';
        }else{
          document.querySelector('#edit-flex #error').style.display= 'block';
          document.getElementById('item-edit').style.height = '420px';
        }
      })
    })
  }

  DeleteItem(id, cart){
    //this will make an ajax request
    let xhr = new XMLHttpRequest();
    let params = `?delete=` + id;

    xhr.open("POST", 'delete.php' + params, true);

    //Send the proper header information along with the request
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

    xhr.onreadystatechange = () => {
    if(xhr.readyState == 4 && xhr.status == 200) {
       if(xhr.responseText == "empty"){
         this.RemoveItemFromCookie(id);
       }
     }
    }

    xhr.send();
  }

  //this will remove the item id inside the cookie when user presses delete
  RemoveItemFromCookie(id){
    let match = document.cookie.match(new RegExp('(^| )' + 'id' + '=([^;]+)'));

    if(match[2].indexOf(id) > -1 ){
      match[2] = match[2].replace(id, '');

      let expires = "";
      let days = 1;
      if (days) {
          let date = new Date();
          date.setTime(date.getTime() + (days*24*60*60*1000));
          expires = "; expires=" + date.toUTCString();
      }
      //create cookies
      document.cookie = 'id' + "=" + match[2] + "," + expires + "; path=/";
    }

  }

  //gets item info from the database
  GetItem(id){
    //this will make an ajax request
    this.loading.style.display = 'block';
    let xhr = new XMLHttpRequest();
    let params = `?edit=` + id;

    xhr.open("POST", 'itemEdit.php' + params, true);

    //Send the proper header information along with the request
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

    xhr.onreadystatechange = () => {
    if(xhr.readyState == 4 && xhr.status == 200) {
       let data = JSON.parse(xhr.responseText);
       //updates ui
       this.UpdateUI(data);
       this.loading.style.display = 'none';
       this.modalHolder.style.height = '100%';
       this.modalContent.style.transform = 'translate(-50%, -50%)';
     }
    }

    xhr.send();

  }

  //this will update the item edior when the data has been recived
  UpdateUI(data){
    document.querySelector('#edit-flex h4').textContent = data[0].item_name;
    document.querySelector('#available-colors .square').classList.add(data[0].color);
    document.querySelector('#edit-flex img').src = 'img/' + data[0].item_main_img;

    let sizes = this.GetSizes(data);
    let sizesHolder = document.querySelectorAll('#available-size div');

    sizesHolder.forEach( (element, i) =>{
      if(element.classList.contains('disabled')){
        element.classList.remove('disabled');
      }
      if(!sizes[i] == ""){
        element.classList.add('disabled');
      }
      itemSettings.SizeSelector();

    })
    // this.modalHolder.innerHTML += updateForm;
  }

  GetSizes(data){
    let sizes = [];

    if(data[0].x_small > 0){
      sizes.push('');
    }else{
      sizes.push('disabled');
    }

    if(data[0].small > 0){
      sizes.push('');
    }else{
      sizes.push('disabled');
    }

    if(data[0].medium > 0){
      sizes.push('');
    }else{
      sizes.push('disabled');
    }

    if(data[0].large > 0){
      sizes.push('');
    }else{
      sizes.push('disabled');
    }

    return sizes;
  }

}
var editItem = new EditItem;

window.addEventListener("click",function(e){		//IF THE USER CLICKS OUTSIDE THE IMAGE THE MODAL WILL CLOSE
  if(e.target == editItem.modalHolder){
    editItem.modalHolder.style.height = '0%';
    editItem.modalContent.style.transform = 'translate(-50%, -250%)';
  }
})
