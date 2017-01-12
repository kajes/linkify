'use strict';

//================================================================================================
// Functions
//================================================================================================
function hideShow(element)
{
  element.classList.toggle('clicked');
}

//================================================================================================
// User settings
//================================================================================================

// Show/hide new post form on click
document.querySelector('button.newPost').addEventListener('click', function(){
  hideShow(document.querySelector('section.newPostWrap'));
})

// Show/hide settings Menu on click
document.querySelector('button.userSettings').addEventListener('click', function(){
  hideShow(document.querySelector('section.userSettingsWrapper'));
})

// Avatar placeholder click event
const avatarPlaceholder = document.querySelector('.placeholder.avatar');
const avatarUpload = document.querySelector('.avatarUpload');

avatarPlaceholder.addEventListener('click', function(){
  avatarUpload.click();
});
