'use strict';

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

        // Check for errors
        if (data.error) {

          const errorElement = document.createElement('p');
          errorElement.classList.add('error');
          errorElement.textContent = data.error;

          parent.appendChild(errorElement);

          setTimeout(function(){
            parent.removeChild(errorElement);
          }, 3000);

        } else {

          // Update vote count if successful
          voteCountElement.innerHTML = data.newCount;

          // Change colors depending on value
          if (data.newCount <= -1) {
            voteCountElement.style.color = '#ff0000';
          } else if (data.newCount == 0) {
            voteCountElement.style.color = '#313131';
          } else if (data.newCount >= 1) {
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

  let voteCount = singleBox.parentElement.children[2];
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

        // Create new element with updated content
        const newContentElement = document.createElement('p');
        newContentElement.setAttribute('class', 'postContent');
        newContentElement.setAttribute('id', 'id-'+id);
        newContentElement.innerHTML = data.newPost.post_content;

        // Create response element that confirms change
        const editConfirm = document.createElement('p');
        editConfirm.setAttribute('class', 'message');
        editConfirm.innerHTML = data.message;

        // Execute new elements create
        parent.removeChild(input);
        parent.removeChild(saveButton);
        parent.removeChild(cancelButton);
        parent.insertBefore(newContentElement, sibling);
        parent.insertBefore(editConfirm, sibling);

        // Timeout function for removing message
        setTimeout(function(){
          parent.removeChild(editConfirm);
        }, 3000);

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
