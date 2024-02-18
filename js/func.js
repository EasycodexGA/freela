
function openAdd(e){
    addNew.classList.add("add-active");

    console.log(e)
}

function closeAdd(){
    addNew.classList.remove("add-active");
}

function addNewData(local, data){
    fetch(`https://freela.anizero.cc/sys/api/${local}`,{
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