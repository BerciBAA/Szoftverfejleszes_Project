const form = document.querySelector(".typingArea"),
inputField = form.querySelector(".inputField"),
sendBtn = form.querySelector("button"),
chatBox = document.querySelector(".chatBox");

form.onsubmit = (e)=>{
    e.preventDefault();
}

sendBtn.onclick = ()=>{
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "insertChat.php", true);
    xhr.onload = ()=>{
        if(xhr.readyState === XMLHttpRequest.DONE){
            if(xhr.status === 200){
              inputField.value = "";
            }
        }
    }

    let formData = new FormData(form);
    xhr.send(formData);
}

setInterval(()=>{
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "getChat.php",true);
    xhr.onload = ()=>{
        if(xhr.readyState === XMLHttpRequest.DONE){
            if(xhr.status === 200){
                let data = xhr.response;
                chatBox.innerHTML = data
                
            }
        }
    }
    let formData = new FormData(form);
    xhr.send(formData);
},500)

setInterval(()=>{
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "getChat.php",true);
    xhr.onload = ()=>{
        if(xhr.readyState === XMLHttpRequest.DONE){
            if(xhr.status === 200){
                let data = xhr.response;
                chatBox.innerHTML = data
            }
        }
    }
    let formData = new FormData(form);
    xhr.send(formData);
},500)