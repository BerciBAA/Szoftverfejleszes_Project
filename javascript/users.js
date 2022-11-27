userList = document.querySelector(".users .usersList");

setInterval(()=>{
    let xhr = new XMLHttpRequest();
    xhr.open("GET", "onLoadUser.php",true);
    xhr.onload = ()=>{
        if(xhr.readyState === XMLHttpRequest.DONE){
            if(xhr.status === 200){
                let data = xhr.response;
                userList.innerHTML = data
            }
        }
    }
    xhr.send();
},100)