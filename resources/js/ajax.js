'use strict';

//================================================================================================
// Voting system
//================================================================================================

// Event function for voting
function vote(value, voteCountElement)
{

  // Data that goes into the post request body
  let voteData = new FormData();
  voteData.append('vote', value);
  voteData.append('postID', voteCountElement.dataset.postid);

  fetch('/resources/lib/vote.php', {
    method: 'POST',
    header: {'Content-type': 'application/x-www-form-urlencoded; charset=UTF-8'},
    body: voteData
  })
  .then(
    function(response){
      if (response.status != 200) {
        console.log('Something went wrong with the request. Status code: ' + response.status);
        return;
      }

      response.json().then(function(data){

        // Update vote count if successful
        voteCountElement.innerHTML = data.newCount;

        // Change colors depending on value
        if (data.newCount <= -1) {
          voteCountElement.style.color = 'red';
        } else if (data.newCount == 0) {
          voteCountElement.style.color = 'black';
        } else if (data.newCount >= 1) {
          voteCountElement.style.color = 'green';
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

  let voteCount = singleBox.querySelector('.voteCount');
  const voteUp = singleBox.querySelector('.voteUp');
  const voteDown = singleBox.querySelector('.voteDown');

  // Color the vote count based on value
  if (voteCount.innerHTML <= -1) {
    voteCount.style.color = 'red';
  } else if (voteCount.innerHTML == 0) {
    voteCount.style.color = 'black';
  } else if (voteCount.innerHTML >= 1) {
    voteCount.style.color = 'green';
  }

  // Seperate event listeners for up and down voting
  voteUp.addEventListener('click', function(){ vote(1, voteCount) });
  voteDown.addEventListener('click', function(){ vote(-1, voteCount) });

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
  let contentInput = document.createElement('textarea');
  contentInput.setAttribute('class', 'newContentEdit');
  contentInput.innerHTML = oldContent;

  // Create save button
  const saveButton = document.createElement('button');
  saveButton.innerHTML = 'Save changes';
  saveButton.setAttribute('class', 'button editSaveButton for-'+id);

  // Execute remove and create elements
  elementParent.removeChild(contentElement);
  elementParent.insertBefore(contentInput, sibling);
  elementParent.insertBefore(saveButton, sibling);

  // Add event listener to new save button
  saveButton.addEventListener('click', function(){
    fetchEdit(id, newContent);
  })

}

function fetchEdit(id, newContent)
{

  // Variables to prepare for fetch call
  const newContent = contentInput.innerHTML;
  const editData = new FormData();
  editData.append('postEdit', newContent);
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
