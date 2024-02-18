
function openAdd(e){
    addNew.classList.add("add-active");

    console.log(e)
}

function closeAdd(){
    addNew.classList.remove("add-active");
}

function addProfessor(data){
    fetch("https://freela.anizero.cc/sys/api/usuarios/cadastrar/professor",{
        method: "POST",
        body: JSON.stringify(data)
    })
    .then(e=>e.json())
    .then(e=>{
        let msg = document.createElement("div");
        let color = e.response ? "sucess-add" : "erro-add";
        msg.classList.add(`msg-add`);
        msg.classList.add(color);
        msg.innerText = e.mensagem;
        document.body.appendChild(msg);

        setTimeout(()=>{
            msg.remove();
        },2000)
    })
}