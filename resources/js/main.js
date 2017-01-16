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

if (document.querySelector('.callToAction')) {
  // Comment wrapper hide/show
  const commentButton = document.querySelector('.callToAction');
  const newCommentContainer = document.querySelector('.newCommentWrap');

  commentButton.addEventListener('click', function(){
    hideShow(newCommentContainer);
  });
};

// Fix position of main content relative to header
const mainHeader = document.querySelector('.mainHeader');
const mainContent = document.querySelector('.mainContent');
const mainH1 = document.querySelector('.mainHeader h1');
const menuBar = document.querySelector('section.userMenu');
mainContent.style.paddingTop = mainH1.clientHeight+menuBar.clientHeight+'px';

window.addEventListener('scroll', function(e){

  if (window.scrollY >= mainH1.clientHeight) {
    mainHeader.style.transform = 'translateY('+-mainH1.clientHeight+'px)';
  } else {
    mainHeader.style.transform = 'translateY(0)';
  }

});
