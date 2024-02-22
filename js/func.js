
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

const preSets = {
    'profissionais': {
        'link': '../sys/api/usuarios/get/professores',
        'data': 'usersprofessor',
        'th': ['nome', 'email', 'nascimento', 'status']
    },
    'alunos': {
        'link': '../sys/api/usuarios/get/alunos',
        'data': 'usersalunos',
        'th': ['nome', 'email', 'nascimento', 'status']
    },
    'categorias': {
        'link': '../sys/api/usuarios/get/categorias',
        'data': 'categorias',
        'th': ['nome', 'turmas', 'status']
    },
    'eventos': {
        'link': '../sys/api/turmas/get/eventos',
        'data': 'eventos',
        'th': ['nome', 'turma', 'data', 'status']
    },
    'turmas': {
        'link': '../sys/api/turmas/get/turmas',
        'data': 'turmas',
        'th': ['nome', 'categoria', 'profissionais', 'alunos', 'status']
    }
}

let allbgl;

function getData(link){
    return fetch(`../sys/api/${link}`)
    .then(e=>e.json())
    .then(e=>{
        allbgl = e.mensagem;
        for(let i of e.mensagem){
            let date = new Date(i.data * 1000 + 86400000);
            date = date.toLocaleDateString("pt-BR");
            let tr = document.createElement('tr');
            tr.classList.add('empty-line');
            tr.classList.add('table-line');
            tr.id = `key${i.id}`;
            for(const [key, value] of Object.entries(i)){
                if(key != 'id'){
                    let td = document.createElement('td');
                    td.classList.add(`td-${key}`);
                    if(key == 'status'){
                        let td2 = document.createElement('td');
                        td2.innerHTML = 'Ver detalhes';
                        tr.appendChild(td2);
                    }
                    if(key == 'data'){
                        td.innerHTML = date;
                    } else {
                        td.innerHTML = value;
                    }
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
        let name = i[`${filter}`].toLowerCase();
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