class Sort{
  constructor(){
    this.arrow = document.querySelector('#item-sort .sort-down');
    this.sortMenuUl = document.querySelector('#item-sort ul');
    this.sortMenuLi = document.querySelectorAll('#item-sort ul li');

    // THIS WILL SHOW THE ELEMENTS ON CLICK
    this.displaying = false;
    this.sortMenuLi[0].addEventListener('click', () =>{
      if(this.displaying === false){
        sort.DisplayAll();
        this.displaying = true;
      }else{
        sort.Hide();
        this.displaying = false;
      }
    })

    //ADDS A CLICK EVENT LISTNER TO THE SORT LIST ITEMS(EXCLUDING THE FIRST ONE)
    for (var i = 1; i < this.sortMenuLi.length; i++) {
      this.SortList(i);
    }

    this.Hide();
  }
  //ADDS A CLICK EVENT LISTNER TO THE SORT LIST ITEMS(EXCLUDING THE FIRST ONE)
  SortList(index){
    this.sortMenuLi[index].addEventListener('click', () =>{
      this.temp = this.sortMenuLi[0].textContent;
      this.sortMenuLi[0].textContent = this.sortMenuLi[index].textContent;
      this.sortMenuLi[index].textContent = this.temp;
    })
  }
  //THIS WILL HIDE THE NONE SELECTED ELEMENTS
  Hide(){
    this.sortMenuUl.style.height = '35px';
    this.arrow.style.transform = 'rotate(0deg)';
    this.sortMenuLi.forEach( (sort, index) =>{
      if(index !== 0){
        sort.style.display = 'none';
      }else{
        sort.style.borderBottom = 'none';
      }
    })
  }
  //THIS WILL SHOW ALL THE ELEMENTS
  DisplayAll(){
    this.arrow.style.transform = 'rotate(-90deg)';
    this.sortMenuUl.style.height = '100px';
    this.sortMenuLi.forEach( (sort, index) =>{
      if(index === 0){
        sort.style.borderBottom = '1px solid #A0A0A0';
      }
      sort.style.display = 'block';
    })
  }
}
let sort = new Sort;

window.addEventListener("click", (e)=> {
  if( e.target != sort.sortMenuLi[0] && sort.displaying === true){
    sort.Hide();
    sort.displaying = false;
  }
})
