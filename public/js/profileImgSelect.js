class ProfileImgSelect {
  constructor() {
    this.input = document.querySelector('.profile-img-holder input');
    this.inputHolder = document.querySelector('.profile-img-holder');
    this.inputText = document.querySelector('.profile-img-holder h3');
    this.errorText = document.getElementById('error');
    this.isUploading = false;

    this.inputHolder.addEventListener('click', () =>{
      if(!this.isUploading){
        this.input.click();
      }
    })
  }

  ImgChange(){
    const files = document.querySelector('input[type=file]').files[0];
    let formData = new FormData();
    formData.append('files', files);
    this.errorText.textContent = "Uploading...";

    fetch('profilePicture.php', {
        method: 'POST',
        body: 
    }).then(response => {
        return (response.text());
    }).then(body => {
        let text = String(body);
        this.errorText.textContent = text;
        window.location.replace("dashboard.php");
    });

  }
}

let profileImgSelect = new ProfileImgSelect;
