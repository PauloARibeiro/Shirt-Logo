class FooterNav{
  constructor(){
    this.footerHeader = document.querySelectorAll('.footer-header');
    this.footerArrow = document.querySelectorAll('footer .footer-header .sort-down');

    this.footerHeader.forEach( (header, index) => {
      header.addEventListener('click', () =>{
        footerNav.OpenMenu(index);
      })
    })
  }
  //MOBILE FOOTER MENUS
  OpenMenu(index){
    var footerUl = document.querySelectorAll('footer ul');
    footerUl.forEach( (ul, i) =>{
      if(i === index){
        if(i === 1){
          ul.style.height = '140px';
        }else{
          ul.style.height = '120px';
        }
        this.footerArrow[i].style.transform = 'rotate(-90deg)';
        this.footerHeader[i].style.marginBottom = '15px';
      }else{
        ul.style.height = '0px';
        this.footerHeader[i].style.marginBottom = '30px';
        this.footerArrow[i].style.transform = 'rotate(0deg)';
      }
    })
  }
}

var footerNav = new FooterNav;
