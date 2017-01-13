'use strict';

//================================================================================================
// Functions
//================================================================================================
function hideShow(element)
{
  if (document.querySelector('.hide.clicked')) {
    if (document.querySelector('.hide.clicked') == element) {
      element.classList.remove('clicked');
    } else {
      document.querySelector('.hide.clicked').classList.remove('clicked');
      element.classList.add('clicked');
    }
  } else {
    element.classList.toggle('clicked');
  }
}

//================================================================================================
// User settings
//================================================================================================

// Show/hide login/register form
if (document.querySelector('button.loginRegister')) {
  document.querySelector('button.loginRegister').addEventListener('click', function(){
    hideShow(document.querySelector('section.loginRegisterWrapper'));
  })
}


if (document.querySelector('button.newPost')) {
  // Show/hide new post form on click
  document.querySelector('button.newPost').addEventListener('click', function(){
    hideShow(document.querySelector('section.newPostWrap'));
  })

  // Show/hide settings Menu on click
  document.querySelector('button.userSettings').addEventListener('click', function(){
    hideShow(document.querySelector('section.userSettingsWrapper'));
  })

  // Logout redirect function
  document.querySelector('.logout').addEventListener('click', function(){
    window.location = "resources/lib/logout.php";
  })

  // Avatar placeholder click event
  const avatarPlaceholder = document.querySelector('.placeholder.avatar');
  const avatarUpload = document.querySelector('.avatarUpload');

  avatarPlaceholder.addEventListener('click', function(){
    avatarUpload.click();
  });
}

// Fix position of main content relative to header
const mainHeader = document.querySelector('.mainHeader');
const mainContent = document.querySelector('.mainContent');
mainContent.style.paddingTop = mainHeader.clientHeight+'px';

let lastKnownPosition = 0;
let ticking = false;
const mainH1 = document.querySelector('.mainHeader h1');

window.addEventListener('scroll', function(e){

  if (window.scrollY >= 1) {
    mainH1.classList.add('hide');
  } else {
    mainH1.classList.remove('hide');
  }

  console.log(window.scrollY);
});
