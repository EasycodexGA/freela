function openAdd(e){
    closeAdd();
    addNew.classList.add("add-active");
}

function openDetail(cat, id){
    closeAdd();
    getDetails(cat, id);
}

function closeAdd(){
    if(addNew){
        addNew.classList.remove("add-active");
    }
    details.classList.remove("add-active");
}

function addNewData(local, data){
    fetch(`../sys/api/${local}`,{
        method: "POST",
        body: JSON.stringify(data)
    })
    .then(e=>e.json())
    .then(e=>{
        newMsg(e);

        if(e.response){
            closeAdd();
            cleanInps();
            window.location.reload()
        }

        
    })
}

function newMsg(e){
    let msg = document.createElement("div");
    let color = e.response ? "sucesso-add" : "erro-add";
    msg.classList.add(`msg-add`);
    msg.classList.add(color);
    msg.innerText = e.mensagem;
    document.body.appendChild(msg);
    setTimeout(()=>{
        msg.remove();
    },2000)
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

const preSets = {
    'profissionais': {
        'link': '../sys/api/usuarios/get/professores',
        'data': 'usersprofessor',
        'th': ['nome', 'email', 'data', 'status']
    },
    'alunos': {
        'link': '../sys/api/usuarios/get/alunos',
        'data': 'usersalunos',
        'th': ['nome', 'email', 'data', 'status']
    },
    'categorias': {
        'link': '../sys/api/usuarios/get/categorias',
        'data': 'categorias',
        'th': ['nome', 'turmas', 'status']
    },
    'eventos': {
        'link': '../sys/api/turmas/get/eventos',
        'data': 'eventos',
        'th': ['nome', 'turma','categoria', 'data', 'status']
    },
    'turmas': {
        'link': '../sys/api/turmas/get/turmas',
        'data': 'turmas',
        'th': ['nome', 'categoria', 'profissionais', 'alunos', 'status']
    },
    'aulas': {
        'link': '../sys/api/turmas/get/aulas',
        'th': ['data']
    }
}

let allbgl;

function getData(link){
    return fetch(`${link}`)
    .then(e=>e.json())
    .then(e=>{
        allbgl = e.mensagem;
        for(let i of e.mensagem){
            if(i.data){
                let date = new Date(i.data * 1000 + 86400000);
                i.data = date.toLocaleDateString("pt-BR");
            }
            
            let tr = document.createElement('tr');
            tr.classList.add('empty-line');
            tr.classList.add('table-line');
            tr.id = `key${i.id}`;

            for(const [key, value] of Object.entries(i)){
                if(key != 'id' && key != '_name'){
                    let td = document.createElement('td');
                    td.classList.add(`td-${key}`);

                    if(key == 'status'){
                        let td2 = document.createElement('td');
                        td2.innerHTML = `<button class="ver-detalhes" onclick="openDetail('${i._name}', ${i.id})">Ver detalhes</button>`;
                        tr.appendChild(td2);
                    }

                    td.innerHTML = value;
                    tr.appendChild(td);
                }
            }
            tabList.appendChild(tr)
        }
        tabList.innerHTML += "<tr class='empty-line table-line2' id='notData'><td></td><td style='text-align: center'>Nenhum dado encontrado</td><td></td></tr>";

        if(tabList.querySelectorAll('.table-line').length > 0){
            notData.classList.remove('table-line2');
        }
    })
}

function createTh(arr){
    tr = document.createElement('tr');

    hlo = document.querySelector('.header-list-out');
    select = document.createElement('select');
    select.id = 'selectFilter';

    for(i of arr){
        if(i == 'status'){
            th2 = document.createElement('th');
            tr.appendChild(th2);
        }
        th = document.createElement('th');
        th.innerHTML = i;
        tr.appendChild(th);

        option = document.createElement('option');
        option.value = i;
        option.innerHTML = i;
        select.appendChild(option);
    }
    headList.appendChild(tr);
    hlo.appendChild(select);
}

searchBar.addEventListener('keyup', ()=>{
    let val = searchBar.value;
    let filter = selectFilter.value;
    for(let i of allbgl){
        let name = i[filter];
        
        if(Number(name)){
            name = Number(name);
            name = new Date((name * 1000) + 86400000).toLocaleDateString('pt-br');
        } else {
            name = name.toString().toLowerCase();
        }
        console.log("name ", name);
        if(name.includes(val)){
            document.getElementById(`key${i.id}`).classList.add('table-line');
        } else {
            document.getElementById(`key${i.id}`).classList.remove('table-line');
        }
        if(tabList.querySelectorAll('.table-line').length == 0){
            notData.classList.add('table-line2');
        } else {
            notData.classList.remove('table-line2');
        }
    }
})

const callFunc = (func) => func();

function startPage(e){
    // callFunc(func);
    preset = preSets[`${e}`];
    createTh(preset.th);
    getData(preset.link);
    getActInact(preset.data);
}

function getDetails(cat, id){
    jump = ['id', 'turmas', 'status', 'imagem'];
    return fetch(`../sys/api/detalhes/${cat}?id=${id}`)
    .then(e=>e.json())
    .then(e=>{
        if(!e.response){
            newMsg(e);
            return;
        }
        details.classList.add("add-active");
        i = e.mensagem[0];
        if(i.data){
            let date = new Date(i.data * 1000 + 86400000);
            i.data = date.toLocaleDateString("pt-BR");
        }
        for(const [key, value] of Object.entries(i)){
            if(!jump.includes(key)){
                document.getElementById(`${key}Get`).innerHTML = value;
            }
        }
    })
}