class ItemFilters{
  constructor(){
    this.item = document.querySelectorAll('.item');
    this.priceFilter = document.querySelectorAll('.price-filter');
    this.sizeFilter = document.querySelectorAll('#filter-sizes li input');
    this.colorFilter = document.querySelectorAll('#filter-colors li input');
    this.order = document.querySelectorAll('#sort-menu li');
    this.mobileOrder = document.querySelector('.mobile-sort');

    let url = this.getURLParams();

    if(url.searchParams.get('price')){
      this.CheckPriceFilters(url.searchParams.get('price'));
    }
    if(url.searchParams.get('size')){
      this.CheckSizeFilters(url.searchParams.get('size'));
    }
    if(url.searchParams.get('color')){
      this.CheckColorFilters(url.searchParams.get('color'));
    }
    if(url.searchParams.get('order')){
      this.CheckOrderFilters(url.searchParams.get('order'));
    }

    //price filter
    this.priceFilter.forEach( (filter) =>{
      if(!filter.checked){
        filter.addEventListener('click', () =>{
          this.PriceFilter(filter.value);
        })
      }
    })

    //size filter
    this.sizeFilter.forEach( (filter, i) =>{
      if(!filter.checked){
        filter.addEventListener('click', () =>{
          this.SizeFilter(i);
        })
      }else{
        filter.addEventListener('click', () =>{
          this.RemoveSizeFilter(i);
        })
      }
    })

    //color filter
    this.colorFilter.forEach( (filter, i) =>{
      if(!filter.checked){
        filter.addEventListener('click', () =>{
          this.ColorFilter(i);
        })
      }else{
        filter.addEventListener('click', () =>{
          this.RemoveColorFilter(i);
        })
      }
    })

    //order filter
    this.order.forEach( (filter, i) =>{
      if(i != 0){
        filter.addEventListener('click', () =>{
          this.OrderFilter(filter.textContent);
        })
       }
     })
  }

  //
  CheckPriceFilters(value){
    switch (value) {
      case '0.2':
        this.priceFilter[0].checked = true;
      break;
      case '2.4':
        this.priceFilter[1].checked = true;
        break;
      case '4.6':
        this.priceFilter[2].checked = true;
        break;
      case '6':
        this.priceFilter[3].checked = true;
        break;
    }
  }

  CheckSizeFilters(value){
    if(value.includes('_xsmall')){
      this.sizeFilter[0].checked = true;
    }

    if(value.includes('_small')){
      this.sizeFilter[1].checked = true;
    }

    if(value.includes('_medium')){
      this.sizeFilter[2].checked = true;
    }

    if(value.includes('_large')){
      this.sizeFilter[3].checked = true;
    }
  }

  CheckColorFilters(value){
    if(value.includes('_black')){
      this.colorFilter[0].checked = true;
    }

    if(value.includes('_red')){
      this.colorFilter[1].checked = true;
    }

    if(value.includes('_yellow')){
      this.colorFilter[2].checked = true;
    }

    if(value.includes('_green')){
      this.colorFilter[3].checked = true;
    }

    if(value.includes('_blue')){
      this.colorFilter[4].checked = true;
    }
  }

  CheckOrderFilters(value){
    if(value.includes('new')){
      this.order[0].innerHTML = "Newest First <i class='fas fa-sort-down sort-down' style='transform: rotate(0deg);'></i>";
      this.order[1].textContent = "Price (lowest first)";
      this.order[2].textContent = "Price (highest first)";
    }
    if(value.includes('low')){
      this.order[0].innerHTML = "Price (lowest first) <i class='fas fa-sort-down sort-down' style='transform: rotate(0deg);'></i>";
      this.order[1].textContent = "Newest First";
      this.order[2].textContent = "Price (highest first)";
    }
    if(value.includes('high')){
      this.order[0].innerHTML = "Price (highest first) <i class='fas fa-sort-down sort-down' style='transform: rotate(0deg);'></i>";
      this.order[1].textContent = "Price (lowest first)";
      this.order[2].textContent = "Newest First";
    }
  }

  //price filter
  PriceFilter(value){
    let url = this.getURLParams();
    switch (value) {
      case '20':
        value = 0.20;
      break;
      case '20-40':
        value = 2.4;
        break;
      case '40-60':
        value = 4.6;
        break;
      case '60+':
        break;
    }

    //if price filter is not set then it will APPEND if it is then it will SET
    if(!this.CheckURLParams('price', url)){
      this.AppendURLParams(url, 'price', value);
    }else{
      this.SetURLParams(url, 'price', value);
    }
  }

  //size filter
  SizeFilter(value){
    let url = this.getURLParams();
    switch (value) {
      case 0:
        value = '_xsmall';
      break;
      case 1:
        value = '_small';
        break;
      case 2:
        value = '_medium';
        break;
      case 3:
        value = '_large';
        break;
    }

    //if size filter is not set then it will APPEND if it is then it will SET
    if(this.CheckURLParams('size', url)){
      let newParams = url.searchParams.get('size');
      newParams += value;
      this.SetURLParams(url, 'size', newParams);
    }else{
      this.SetURLParams(url, 'size', value);
    }
  }

  //Remove size filter
  RemoveSizeFilter(value){
    let url = this.getURLParams();
    switch (value) {
      case 0:
        value = '_xsmall';
      break;
      case 1:
        value = '_small';
        break;
      case 2:
        value = '_medium';
        break;
      case 3:
        value = '_large';
        break;
    }

    //if size filter is not set then it will APPEND if it is then it will SET
    if(this.CheckURLParams('size', url)){
      let newParams = url.searchParams.get('size');
      newParams = newParams.replace(value, '');
      this.SetURLParams(url, 'size', newParams);
    }else{
      this.SetURLParams(url, 'size', value);
    }
  }

  //color filter
  ColorFilter(value){
    let url = this.getURLParams();
    switch (value) {
      case 0:
        value = '_black';
      break;
      case 1:
        value = '_red';
        break;
      case 2:
        value = '_yellow';
        break;
      case 3:
        value = '_green';
        break;
      case 4:
        value = '_blue';
        break;
    }

    //if color filter is not set then it will APPEND if it is then it will SET
    if(this.CheckURLParams('color', url)){
      let newParams = url.searchParams.get('color');
      newParams += value;
      this.SetURLParams(url, 'color', newParams);
    }else{
      this.SetURLParams(url, 'color', value);
    }
  }

  //Remove Color filter
  RemoveColorFilter(value){
    let url = this.getURLParams();
    switch (value) {
      case 0:
        value = '_black';
      break;
      case 1:
        value = '_red';
        break;
      case 2:
        value = '_yellow';
        break;
      case 3:
        value = '_green';
        break;
      case 4:
        value = '_blue';
        break;
    }

    //if size filter is not set then it will APPEND if it is then it will SET
    if(this.CheckURLParams('color', url)){
      let newParams = url.searchParams.get('color');
      newParams = newParams.replace(value, '');
      this.SetURLParams(url, 'color', newParams);
    }else{
      this.SetURLParams(url, 'color', value);
    }
  }

  OrderFilter(value){
    let url = this.getURLParams();
    if(value.includes('Newest First')){
      value = 'new';
    }
    if(value.includes('Price (lowest first)')){
      value = 'low';
    }
    if(value.includes('Price (highest first)')){
      value = 'high';
    }

    //if price order is not set then it will APPEND if it is then it will SET
    if(!this.CheckURLParams('order', url)){
      this.AppendURLParams(url, 'order', value);
    }else{
      this.SetURLParams(url, 'order', value);
    }
  }

  MobileOrderFilter(value){
    console.log(value);
    let url = this.getURLParams();
    switch (value) {
      case 1:
        value = 'new';
      break;
      case 0:
        value = 'low';
        break;
      case 2:
        value = 'high';
        break;
    }

    //if price order is not set then it will APPEND if it is then it will SET
    if(!this.CheckURLParams('order', url)){
      this.AppendURLParams(url, 'order', value);
    }else{
      this.SetURLParams(url, 'order', value);
    }
  }

  //checks if the  current url params contain certin values
  CheckURLParams(tag, url){
    if(url.searchParams.has(tag)){
      return true;
    }else{
      return false;
    }
  }

  //this will set the url params
  SetURLParams(url, tag, value){
    url.searchParams.set(tag, value);
    window.location.href = url.href;
  }

  //this will append the url params
  AppendURLParams(url, tag, value){
    url.searchParams.append(tag, value);
    window.location.href = url.href;
  }

  //creates new url object
  getURLParams() {
    // return url object
    return new URL(window.location.href);
  }

}

var itemFilter = new ItemFilters;
