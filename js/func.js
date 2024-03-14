function openAdd(e){
    closeAdd();

    let allT =  addNew.children;

    for(let i = 0; i < allT.length; i++){
        allT[i].style.display = "none";
    }
    e.style.display = "flex";
    addNew.classList.add("add-active");
   
}

function openDetail(cat, id){
    closeAdd();
    getDetails(cat, id);
}

function closeAdd(){
    addNew.classList.remove("add-active");
    details.classList.remove("add-active");
}

function openAddAula(){
    addNewAula.classList.add("add-active");
}

function closeAddAula(){
    addNewAula.classList.remove('add-active');
}

function verMais(me, type, titleStr){
    verMaisDiv.innerHTML = '';
    let string = me.getAttribute('data-array');
    let array = string.split('#');

    let divOut = document.createElement('div');
    divOut.classList.add('add-container');

    let title = document.createElement("h1");
    title.classList.add("title-add");
    title.innerHTML = titleStr;

    let divMid = document.createElement("div");

    for(i of array){
        i = JSON.parse(i);
        console.log(i.nome);
        let div = document.createElement('div');
        let p = document.createElement("p");
        p.innerHTML = i.nome;
        div.append(p);
        divMid.append(div);
    }

    outBt = document.createElement("div");
    outBt.classList.add("out-bt-sv");

    closeBt = document.createElement("button");
    closeBt.setAttribute("onclick", 'closeVerMais()');
    closeBt.innerHTML = 'Fechar';
    closeBt.classList.add("btn-close");
    outBt.append(closeBt);

    divOut.append(title);
    divOut.append(divMid);
    divOut.append(outBt);
    verMaisDiv.append(divOut);
    verMaisDiv.classList.add('add-active');
}

function closeVerMais(){
    verMaisDiv.classList.remove('add-active');
}

isActive = false;
function addNewData(local, data){
    if(isActive) return;
    isActive = true;
    fetch(`../sys/api/${local}`,{
        method: "POST",
        body: JSON.stringify(data)
    })
    .then(e=>e.json())
    .then(e=>{
        isActive = false;
        newMsg(e);
    })
}

function newMsg(e){
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
}

function cleanInps(){
    let inpsAdd = document.querySelectorAll('#addNew input');

    for(let i of inpsAdd){
        i.value = '';
    }
}

function getActInact(e){
    const statusDiv = document.querySelectorAll(".td-status");
    let activevar = 0;
    let inactivevar = 0;

    for(i of statusDiv){
        let statusI = i.getAttribute("status");
        if(statusI){
            activevar++;
        } else {
            inactivevar++;
        }
    }
    inactive.innerText = inactivevar;
    active.innerText = activevar;
}

const preSets = {
    'profissionais': {
        'link': '../sys/api/usuarios/get/professores',
        'th': ['nome', 'email', 'nascimento', 'titularidade', 'status']
    },
    'alunos': {
        'link': '../sys/api/usuarios/get/alunos',
        'th': ['nome', 'email', 'nascimento', 'status']
    },
    'categorias': {
        'link': '../sys/api/usuarios/get/categorias',
        'th': ['nome', 'turmas', 'status']
    },
    'eventos': {
        'link': '../sys/api/turmas/get/eventos',
        'th': ['nome', 'turma','categoria', 'data', 'status']
    },
    'turmas': {
        'link': '../sys/api/turmas/get/turmas',
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
                        let preStatus = value == 'active' ? true : false;
                        td.setAttribute("status", preStatus);
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
    let tr = document.createElement('tr');

    let hlo = document.querySelector('.header-list-out');
    let select = document.createElement('select');
    select.id = 'selectFilter';

    for(let i of arr){
        if(i == 'status'){
            let th2 = document.createElement('th');
            tr.appendChild(th2);
        }
        let th = document.createElement('th');
        th.innerHTML = i;
        tr.appendChild(th);

        let option = document.createElement('option');
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

async function startPage(e){
    // callFunc(func);
    let preset = preSets[`${e}`];
    createTh(preset.th);
    await getData(preset.link);
    getActInact();
}

function getDetails(cat, id){
    let jump = ['id', 'status', 'imagem'];
    let nums = ['data', 'nascimento', 'created'];
    let arrays = ['alunos', 'profissionais', 'turmas'];
    
    return fetch(`../sys/api/detalhes/${cat}?id=${id}`)
    .then(e=>e.json())
    .then(e=>{
        if(!e.response){
            newMsg(e);
            return;
        }
        details.classList.add("add-active");
        btnRemove.onclick = () => {
            removeSec(cat, id);
        }

        i = e.mensagem[0];

        for(let [key, value] of Object.entries(i)){
            if(nums.includes(key)){
                value = (new Date(value * 1000 + 86400000)).toLocaleDateString("pt-BR");
            }
            if(arrays.includes(key)){
                for(i in value){
                    value[i] = JSON.stringify(value[i]);
                }
                value = value.join("#");
                if(key == 'alunos'){
                    verPresencaBt.setAttribute('onclick', `verMais(this, 1, "Chamada")`);
                    verPresencaBt.setAttribute("data-array", `${value}`);
                }
                value = `<button data-array='${value}' onclick='verMais(this, 0, "${key}")'>Ver ${key}</button>`;
            }
            if(!jump.includes(key)){
                document.getElementById(`${key}Get`).innerHTML = value;
            }
        }
        idTurma.value = id;
    })
}

function removeSec(local, id){
    fetch(`../sys/api/extra/remove?local=${local}&id=${id}`)
    .then(e=>e.json())
    .then(e=>{
        newMsg(e);
    })

}