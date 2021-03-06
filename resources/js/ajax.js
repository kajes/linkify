'use strict';

//================================================================================================
// Response Message Function
//================================================================================================
function responseMessage(data)
{

  const errorMessage = document.querySelector('header .errorMessage');
  const messageSuccess = document.querySelector('header .messageSuccess');

  if (data.error) {
    errorMessage.innerHTML = data.error;
    errorMessage.parentElement.classList.add('clicked');
    setTimeout(function(){
      errorMessage.parentElement.classList.remove('clicked')
    }, 3000);
  } else if (data.message) {
    messageSuccess.innerHTML = data.message;
    messageSuccess.parentElement.classList.add('clicked');
    setTimeout(function(){
      messageSuccess.parentElement.classList.remove('clicked');
    }, 3000);
  }
}

//================================================================================================
// Register Function
//================================================================================================
function userRegister()
{
  const firstName = document.querySelector('.register.firstName').value;
  const lastName = document.querySelector('.register.lastName').value;
  const email = document.querySelector('.register.email').value;
  const password = document.querySelector('.register.password').value;
  const passwordVerify = document.querySelector('.register.passwordReenter').value;

  const registerData = new FormData();
  registerData.append('firstName', firstName);
  registerData.append('lastName', lastName);
  registerData.append('email', email);
  registerData.append('password', password);
  registerData.append('password_reenter', passwordVerify);

  fetch('/resources/lib/register.php', {
    method: 'POST',
    header: {'Content-type': 'application/x-www-form-urlencoded; charset=UTF-8'},
    credentials: 'same-origin',
    body: registerData
  })
  .then(function(response){
    if (response.status != 200) {
      console.log('Something went wrong with the register request. Status code: ' + response.status);
      return;
    }

    response.json().then(function(data){

      responseMessage(data);

      if (data.message) {
        setTimeout(function(){
          location.reload();
        }, 3000)
      }

    })

  })
}

const registerSubmit = document.querySelector('.register.registerSubmit');

if (registerSubmit) {
  registerSubmit.addEventListener('click', function(event){
    event.preventDefault();
    userRegister();
  })
}

//================================================================================================
// Login function
//================================================================================================

function login(event)
{
  event.preventDefault();

  const username = document.querySelector('.login.email').value;
  const password = document.querySelector('.login.password').value;
  const rememberMe = document.querySelector('.rememberMe').checked;

  const loginData = new FormData();
  loginData.append('email', username);
  loginData.append('password', password);
  if (rememberMe == true) {
    loginData.append('rememberMe', rememberMe);
  }

  fetch('/resources/lib/login.php', {
    method: 'POST',
    header: {'Content-type': 'application/x-www-form-urlencoded; charset=UTF-8'},
    credentials: 'same-origin',
    body: loginData
  })
  .then(function(response){
    if (response.status != 200) {
      console.log('Something went wrong with the login request. Status code: ' + response.status);
      return;
    }

    response.json().then(function(data){

      responseMessage(data);

      if (data.message) {
        setTimeout(function(){
          location.reload();
        }, 3000)
      }

    })
  })

}

const loginSubmit = document.querySelector('.login.submit');

if (loginSubmit) {
  loginSubmit.addEventListener('click', function(event){
    login(event);
  })
}

//================================================================================================
// Create Post Function
//================================================================================================
function createPost()
{
  const postTitle = document.querySelector('.postTitle').value;
  const postLink = document.querySelector('.postLink').value;
  const postContent = document.querySelector('.postContent').value;
  const parentID = document.querySelector('.parentID').value;

  const postData = new FormData();
  postData.append('postTitle', postTitle);
  postData.append('postLink', postLink);
  postData.append('postContent', postContent);
  postData.append('parent_id', parentID);

  fetch('/resources/lib/createPost.php', {
    method: 'POST',
    header: {'Content-type': 'application/x-www-form-urlencoded; charset=UTF-8'},
    credentials: 'same-origin',
    body: postData
  })
  .then(function(response){
    if (response.status != 200) {
      console.log('Something went wrong with the login request. Status code: ' + response.status);
      return;
    }

    response.json().then(function(data){

      const openElement = document.querySelector('.hide.clicked');
      openElement.classList.remove('clicked');
      responseMessage(data);

      setTimeout(function(){
        location.reload();
      }, 3000);

    });

  });
}

const postSubmit = document.querySelector('.postSubmit');
const commentSubmit = document.querySelector('.commentSubmit');

if (postSubmit) {
  postSubmit.addEventListener('click', function(event){
    event.preventDefault();
    createPost();
  })
}

//================================================================================================
// Create Comment Function
//================================================================================================
function createComment()
{
  const commentContent = document.querySelector('.commentContent').value;
  const commentParent = document.querySelector('.commentParent').value;

  const commentData = new FormData();
  commentData.append('postContent', commentContent);
  commentData.append('parent_id', commentParent);

  fetch('/resources/lib/createPost.php', {
    method: 'POST',
    header: {'Content-type': 'application/x-www-form-urlencoded; charset=UTF-8'},
    credentials: 'same-origin',
    body: commentData
  })
  .then(function(response){
    if (response.status != 200) {
      console.log('Something went wrong with the comment request. Status code: ' + response.status);
      return;
    }

    response.json().then(function(data){

      const openElement = document.querySelector('.hide.clicked');
      openElement.classList.remove('clicked');
      responseMessage(data);

      setTimeout(function(){
        location.reload();
      }, 3000);

    });

  });

}

if (commentSubmit) {
  commentSubmit.addEventListener('click', function(event){
    event.preventDefault();
    createComment();
  })
}

//================================================================================================
// Voting system
//================================================================================================

// Event function for voting
function vote(value, voteCountElement, parent)
{

  // Data that goes into the post request body
  let voteData = new FormData();
  voteData.append('vote', value);
  voteData.append('postID', voteCountElement.dataset.postid);

  fetch('/resources/lib/vote.php', {
    method: 'POST',
    header: {'Content-type': 'application/x-www-form-urlencoded; charset=UTF-8'},
    credentials: 'same-origin',
    body: voteData
  })
  .then(
    function(response){
      if (response.status != 200) {
        console.log('Something went wrong with the request. Status code: ' + response.status);
        return;
      }

      response.json().then(function(data){

        responseMessage(data);

        if (data.message) {

          // Update vote count if successful
          voteCountElement.innerHTML = data.content.newCount;

          // Change colors depending on value
          if (data.content.newCount <= -1) {
            voteCountElement.style.color = '#ff0000';
          } else if (data.content.newCount == 0) {
            voteCountElement.style.color = '#313131';
          } else if (data.content.newCount >= 1) {
            voteCountElement.style.color = '#00ff00';
          }

        }

      });
    }
  )
  .catch(function(error){
    console.log('Fetch error: ' + error);
  });
}

// Get all voting elements
const voteBox = document.querySelectorAll('.voteBox');

// Loop through them and add event listeners
voteBox.forEach(function(singleBox){

  const voteCount = singleBox.parentElement.querySelector('.voteCount');
  const voteUp = singleBox.querySelector('.voteUp');
  const voteDown = singleBox.querySelector('.voteDown');

  // Color the vote count based on value
  if (voteCount.innerHTML <= -1) {
    voteCount.style.color = '#ff0000';
  } else if (voteCount.innerHTML == 0) {
    voteCount.style.color = '#313131';
  } else if (voteCount.innerHTML >= 1) {
    voteCount.style.color = '#00ff00';
  }

  // Seperate event listeners for up and down voting
  voteUp.addEventListener('click', function(){ vote(1, voteCount, singleBox) });
  voteDown.addEventListener('click', function(){ vote(-1, voteCount, singleBox) });

});

//================================================================================================
// Edit and update post
//================================================================================================

// Event function for generating new fields for updating posts
function postEdit(id)
{

  // Assign varibles to important elements and old content
  const contentElement = document.querySelector('#id-'+id);
  const elementParent = contentElement.parentElement;
  const sibling = contentElement.nextElementSibling;
  const oldContent = contentElement.innerHTML;

  // Create input element with old content
  const contentInput = document.createElement('textarea');
  contentInput.classList.add('newContentEdit');
  contentInput.value = oldContent;

  // Create save button
  const saveButton = document.createElement('button');
  saveButton.innerHTML = 'Save changes';
  saveButton.classList.add('button', 'editSaveButton', 'for-'+id);

  // Create cancel button
  const cancelButton = document.createElement('button');
  cancelButton.innerHTML = "Cancel changes";
  cancelButton.classList.add('button', 'editCancelButton');

  // Execute remove and create elements
  elementParent.removeChild(contentElement);
  elementParent.insertBefore(contentInput, sibling);
  elementParent.insertBefore(saveButton, sibling);
  elementParent.insertBefore(cancelButton, sibling);

  // Add event listener to new save button
  saveButton.addEventListener('click', function(){
    fetchEdit(id, contentInput, elementParent, sibling, saveButton, cancelButton);
  });

  // Add event listener to cancel button
  cancelButton.addEventListener('click', function(){

    // Remove editing field and buttons
    elementParent.removeChild(contentInput);
    elementParent.removeChild(saveButton);
    elementParent.removeChild(cancelButton);

    // Add back the old element in unchanged state
    elementParent.insertBefore(contentElement, sibling);

  });

}

function fetchEdit(id, input, parent, sibling, saveButton, cancelButton)
{

  // Variables to prepare for fetch call
  const editData = new FormData();
  editData.append('postEdit', input.value);
  editData.append('postID', id);

  // Initiate fetch request
  fetch('resources/lib/postEdit.php', {
    method: 'POST',
    header: {'Content-type': 'application/x-www-form-urlencoded; charset=UTF-8'},
    body: editData
  })
  .then(
    function(response){
      if (response.status != 200) {
        console.log('Something went wrong with the request. Status code: ' + response.status);
        return;
      }

      response.json().then(function(data){

        console.log(data);

        // Create new element with updated content
        const newContentElement = document.createElement('p');
        newContentElement.setAttribute('class', 'postContent');
        newContentElement.setAttribute('id', 'id-'+id);
        newContentElement.innerHTML = data.content.post_content;

        // Execute new elements create
        parent.removeChild(input);
        parent.removeChild(saveButton);
        parent.removeChild(cancelButton);
        parent.insertBefore(newContentElement, sibling);

        responseMessage(data);

      });
    }
  )
  .catch(function(error){
    console.log('Fetch error: ' + error);
  });

}

// Get all edit buttons
const editButtons = document.querySelectorAll('.postEdit');

editButtons.forEach(function(button){

  // Get the post id
  const postID = button.dataset.postid;

  // Add event listener and run function
  button.addEventListener('click', function(){
    postEdit(postID);
  })
});

//================================================================================================
// Delete post feature
//================================================================================================

// Event listener for post delete button
const delButtons = document.querySelectorAll('.postRemove');

delButtons.forEach(function(button){

  const contentBox = button.parentElement.parentElement;
  const contentBoxParent = contentBox.parentElement;
  const delPostId = button.dataset.postid;

  button.addEventListener('click', function(){

    const delData = new FormData();
    delData.append('postID', delPostId);

    fetch('resources/lib/removePost.php', {
      method: 'POST',
      header: {'Content-type': 'application/x-www-form-urlencoded; charset=UTF-8'},
      credentials: 'same-origin',
      body: delData
    })
    .then(
      function(response){

        if (response.status != 200) {
          console.log('Sum Ting Wong Wit Wemove. Status code: '+response.status);
          return;
        }

        response.json().then(function(data){

          if (data.error) {
            console.log(data.error);
          } else if (data.message) {
            console.log(data.message);
            contentBoxParent.removeChild(contentBox);
          }

        });

      }
    )

  });

});
