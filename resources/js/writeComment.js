let commentStart = document.getElementById("writeComment");
let commentContents = document.getElementById("commentCreate");
let cancelComment = document.getElementById("cancelComment");
let allComments = document.getElementById("comments");

function setScreen(){
    commentStart.style.display = "block";
    commentContents.style.display = "none";
    cancelComment.style.display = "none";
    allComments.style.display = "block";
}

function makeComment(){
    commentStart.style.display = "none";
    commentContents.style.display = "block";
    cancelComment.style.display = "block";
    allComments.style.display = "none";
}

commentStart.addEventListener("click", makeComment);
cancelComment.addEventListener("click", setScreen);

window.onload = () => {
    setScreen();
}
