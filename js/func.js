
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
            window.location.reload()
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


function getActInact(e){
    return fetch(`../sys/api/usuarios/get/total`,{
        method: "POST",
        body: JSON.stringify({
            type: e
        })
    })
    .then(e=>e.json())
    .then(e=>{
        if(e.response){
            inactive.innerText = e.mensagem.inactive;
            active.innerText = e.mensagem.active;
        }
        return e;
    })
}

function getCategorias(){
    return fetch(`../sys/api/usuarios/get/categorias`)
    .then(e=>e.json())
    .then(e=>{
        for(let i of e.mensagem){
            tabList.innerHTML += `
                <tr>
                    <td>${i.nome}</td>
                    <td>${i.turmas}</td>
                    <td>Ver detalhes</td>
                    <td>${i.status}</td>
                </tr>
            `;
        }
    })
}


function getTurmas(){
    return fetch(`../sys/api/turmas/get/turmas`)
    .then(e=>e.json())
    .then(e=>{
        for(let i of e.mensagem){
            tabList.innerHTML += `
                <tr>
                    <td>${i.nome}</td>
                    <td>${i.categoria}</td>
                    <td>${i.profissionais}</td>
                    <td>${i.alunos}</td>
                    <td>Ver detalhes</td>
                    <td>${i.status}</td>
                </tr>
            `;
        }
    })
}

function getAlunos(){
    return fetch(`../sys/api/usuarios/get/alunos`)
    .then(e=>e.json())
    .then(e=>{
        for(let i of e.mensagem){
            tabList.innerHTML += `
                <tr>
                    <td>${i.nome}</td>
                    <td>${i.turma}</td>
                    <td>${i.categoria}</td>
                    <td>Ver detalhes</td>
                    <td>${i.status}</td>
                </tr>
            `;
        }
    })
}

let allbgl = [];

function getProfessores(){
    return fetch(`../sys/api/usuarios/get/professores`)
    .then(e=>e.json())
    .then(e=>{
        allbgl.push(e);
        for(let i of e.mensagem){
            tabList.innerHTML += `
                <tr id='key${i.id}'>
                    <td>${i.nome}</td>
                    <td>${i.titularidade}</td>
                    <td>${i.turmas}</td>
                    <td>Ver detalhes</td>
                    <td>${i.status}</td>
                </tr>
            `;
        }
    })
}


searchBar.addEventListener('keyup', ()=>{
    console.log(searchBar.value);
    console.log(allbgl);
})

const callFunc = (func) => func();

function startPage(func, e){
    callFunc(func);
    getActInact(e);
}