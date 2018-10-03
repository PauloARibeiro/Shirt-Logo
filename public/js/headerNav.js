// MENU NAV
class Nav{
  constructor(){
    //THIS IS WILL MAKE THE NAV BAR SMALLER WHEN USER SCROLLS DOWN
    this.navContainer = document.querySelector('nav .container');
    window.onscroll = () =>{				//THIS WILL TRIGGER WHEN THE USER SCROLLS DOWN
    	this.OnScroll();
    };

    this.headerNav = document.querySelectorAll('.nav');
    this.headerMenu = document.querySelectorAll('.menu');
    this.arrows = document.querySelectorAll('.nav .sort-down');
    // USER HOVER OR CLICK ON HEADER NAV
    this.headerNav.forEach( (header, index) => {
      header.addEventListener('mouseenter', () =>{
        console.log(index);
        nav.ClearMenu(this.headerMenu, this.arrows);
        if(index == 2){
          nav.DisplayMenu(this.headerMenu, index, '220px', this.arrows);
        }else{
          nav.DisplayMenu(this.headerMenu, index, '180px', this.arrows);
        }
      })
    })
    // USER MOUSELEAVE
    this.headerMenu.forEach( (header, index) => {
      header.addEventListener('mouseleave', () =>{
        nav.ClearMenu(this.headerMenu, this.arrows);
        nav.HideMenu(this.headerMenu, index, this.arrows);
      })
    })

    // HAMBURGER
    this.hamburger = document.getElementById('hameburger-holder');
    this.hamburger.addEventListener('click', ()=>{
      nav.Hamburger();
      mobileModal.style.width = '100%';
      // mobileNav.style.width = '280px';
      mobileNav.style.left = "0px";
      navBar.style.marginLeft = '265px';
    })

    // USER CLICK ON MOBILE NAV
    this.mobileHeaderNav = document.querySelectorAll('.mobile-item-nav');
    this.mobileHeaderMenu = document.querySelectorAll('.mobile-item-nav ul');
    this.mobileArrows = document.querySelectorAll('.mobile-item-nav .menu-header .sort-down');

    this.mobileHeaderNav.forEach( (headerNav, index) =>{
      headerNav.addEventListener('click', () =>{
        nav.ClearMenu(this.mobileHeaderMenu, this.mobileArrows);
        if (index == this.mobileHeaderNav.length - 1) {
          nav.DisplayMenu(this.mobileHeaderMenu, index, '100px', this.mobileArrows);
        }else{
          nav.DisplayMenu(this.mobileHeaderMenu, index, '190px', this.mobileArrows);
        }
      })
    })
  }
  //THIS IS WILL MAKE THE NAV BAR SMALLER WHEN USER SCROLLS DOWN
  OnScroll(){
    if (window.matchMedia("(max-width: 450px)").matches) {
      if(document.body.scrollTop > 50 || document.documentElement.scrollTop > 50){
        this.navContainer.style.padding = '15px 20px';
      }else {
        this.navContainer.style.padding = '20px 20px';
      }
    }else{
      if(document.body.scrollTop > 50 || document.documentElement.scrollTop > 50){
        this.navContainer.style.padding = '15px 30px';
      }else {
        this.navContainer.style.padding = '20px 30px';
      }
    }
  }
  //HIDES ALL THE MENUS
  ClearMenu(header, arrows){
    header.forEach( (menu, i) =>{
      arrows[i].style.transform = "rotate(0deg)";
      menu.style.opacity = '0';
      menu.style.height = "0px";
      menu.style.zIndex = '1';
    })
  }
  //DISPLAYS THE MENU THATS BEING HOVERED ON
  DisplayMenu(header,index, height, arrows){
    header.forEach( (menu, i) =>{
      if(i === index){
        arrows[index].style.transform = "rotate(-90deg)";
        menu.style.opacity = '1';
        menu.style.height =  height;
        menu.style.zIndex = '999';
      }
    })
  }
  //HIDES THE MENU
  HideMenu(header, index, arrows){
    header.forEach( (menu, i) =>{
      if(i === index){
        arrows[index].style.transform = "rotate(0deg)";
        menu.style.opacity = '0';
        menu.style.height = "0px";
        menu.style.zIndex = '1';
      }
    })
  }
  //HAMBURGER ICON ANIMATION
  Hamburger(){
    if(this.hamburger.classList.contains('change')){
      this.hamburger.classList.remove('change');
    }else{
      this.hamburger.classList.add('change');
    }
  }
}
class MobileRedefine {
  constructor(){
    this.redefineList = document.getElementById('item-filters');
    this.redefineBtn = document.getElementById('redefine-btn');
    if(this.redefineBtn !== null){
      this.redefineBtn.addEventListener('click', () =>{
        this.redefineList.style.left = '0';
        mobileModal.style.width = '100%';
        navBar.style.marginLeft = '265px';
        nav.Hamburger();
      })
    }
  }
}
let mobileRedefine = new MobileRedefine;

var mobileModal = document.getElementById('mobile-modal');
var mobileNav = document.getElementById('mobile-nav');
var navBar = document.querySelector('nav .container');
window.addEventListener("click",function(e){		//IF THE USER CLICKS OUTSIDE THE IMAGE THE MODAL WILL CLOSE
  if(e.target == mobileModal){
    if(mobileRedefine.redefineList !== null){
      mobileRedefine.redefineList.style.left = '-300px';
    }
    mobileModal.style.width = '0px';
    mobileNav.style.left = '-300px';
    navBar.style.marginLeft = '0px';
    nav.Hamburger();
  }
})
var nav = new Nav;
