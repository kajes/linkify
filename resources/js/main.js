'use strict';


//================================================================================================
// Voting system
//================================================================================================

// Event function for voting
function vote(value, voteCountElement)
{

  // Data that goes into the post request body
  let postData = new FormData();
  postData.append('vote', value);
  postData.append('postID', voteCountElement.dataset.postid);

  fetch('/resources/lib/vote.php', {
    method: 'POST',
    header: {'Content-type': 'application/x-www-form-urlencoded; charset=UTF-8'},
    body: postData
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
