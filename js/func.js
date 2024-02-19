
function openAdd(e){
    addNew.classList.add("add-active");

    console.log(e)
}

function closeAdd(){
    addNew.classList.remove("add-active");
}

function addNewData(local, data){
    fetch(`../sys/api/${local}`,{
        method: "POST",
        body: JSON.stringify(data)
    })
    .then(e=>e.json())
    .then(e=>{
        let msg = document.createElement("div");
        let color = e.response ? "sucesso-add" : "erro-add";
        msg.classList.add(`msg-add`);
        msg.classList.add(color);
        msg.innerText = e.mensagem;
        document.body.appendChild(msg);

        if(e.response){
            closeAdd();
            cleanInps();
        }

        setTimeout(()=>{
            msg.remove();
        },2000)
    })
}

function cleanInps(){
    let inpsAdd = document.querySelectorAll('#addNew input');

    for(let i of inpsAdd){
        i.value = '';
    }
}


async function getActInact(e){
    let get = await fetch(`../sys/api/usuarios/get/total`,{
        method: "POST",
        body: JSON.stringify({
            type: e
        })
    })

    let data = await get.json();
    
    if(data.response){
        inactive.innerText = data.mensagem.inactive;
        active.innerText = data.mensagem.active;
    }

    return data;
}


searchBar.addEventListener('keyup', ()=>{
    console.log(searchBar.value);
})