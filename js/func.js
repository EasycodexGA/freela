function openAdd(e){
    closeAdd();

    let allT =  addNew.children;

    for(let i = 0; i < allT.length; i++){
        allT[i].style.display = "none";
    }
    e.style.display = "flex";
    addNew.classList.add("add-active");
}

function openDetail(id){
    closeAdd();
    console.log(file.typeUser);
    file.idDetail = id
    file.getDetails()
}

function closeAdd(){
    addNew.classList.remove("add-active");
    details.classList.remove("add-active");
}

function openAddAula(){
    addNewAula.classList.add("add-active");
    file.idDetail = ''
}

function closeAddAula(){
    addNewAula.classList.remove('add-active');
}

function verMais(me, type, titleStr){
    verMaisDiv.innerHTML = '';
    let string = file.arrayStrAdd[`${me.dataset.id}Array`];
    let array = string.split('#');

    let divOut = document.createElement('div');
    divOut.classList.add('add-container');

    let title = document.createElement("h1");
    title.classList.add("title-add");
    title.innerHTML = titleStr;

    let divMid = document.createElement("div");
    divMid.classList.add("chamadaout");

    for(let i of array){
        i = JSON.parse(i);
        let div = document.createElement('div');
        div.classList.add("chamada-list")
        let p = document.createElement("p");
        p.innerHTML = i.nome;
        div.append(p);

        if(type == 1){
            let input = document.createElement("input");
            input.type = 'checkbox';
            input.classList.add("checkbox-presenca");
            input.id = 'checkId-' + i.id;

            if(i.checked == 1){
                input.checked = true;
            }

            let label = document.createElement("label");
            label.setAttribute('for','checkId-' + i.id);
            label.classList.add('toggle-switch');
            div.append(input);
            div.append(label);
        }

        divMid.append(div);
    }

    let outBt = document.createElement("div");
    outBt.classList.add("out-bt-sv");

    let closeBt = document.createElement("button");
    closeBt.setAttribute("onclick", 'closeVerMais()');
    closeBt.innerHTML = 'Fechar';
    closeBt.classList.add("btn-close");
    outBt.append(closeBt);

    if(type == 1){
        let saveBt = document.createElement("button");
        saveBt.setAttribute("onclick", 'salvarCheckbox(this)');
        saveBt.innerHTML = 'Salvar';
        saveBt.dataset.id = me.dataset.id
        saveBt.classList.add("btn-add");
        outBt.append(saveBt);
    }

    if(me.dataset.pre != 'false'){
        let addBt = document.createElement("button");
        addBt.setAttribute("onclick", 'verMais(this, 1, "adicionar turma")');
        addBt.innerHTML = 'Adicionar turma';
        addBt.classList.add("btn-add");
        addBt.dataset.id = me.dataset.pre
        outBt.append(addBt);
    }

    divOut.append(title);
    divOut.append(divMid);
    divOut.append(outBt);
    verMaisDiv.append(divOut);
    verMaisDiv.classList.add('add-active');
}

function closeVerMais(){
    verMaisDiv.classList.remove('add-active');
}

function salvarCheckbox(me){
    let string = file.arrayStrAdd[`${me.dataset.id}Array`];
    let array = string.split('#');

    let allBts = document.querySelectorAll('.checkbox-presenca');
    for(i = 0; i < allBts.length; i++){
        bool = allBts[i].checked ? 1 : 0 ;
        array[i] = JSON.parse(array[i]);
        array[i].checked = bool;
        array[i] = JSON.stringify(array[i]);
    }
    let value = array.join('#');
    file.arrayStrAdd[`${me.dataset.id}Array`] = value;
    closeVerMais();
}

function getPresenca(id){
    let string = file.arrayStrAdd[`${id}Array`];
    let array = string.split('#');
    for(i = 0; i < array.length; i++){
        array[i] = JSON.parse(array[i]);
    }

    return array;
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

function defineColor(e){
    let color = "sucesso-add";

    if(e == "aguardando" || e == 'ag'){
        color = "aguardando-add";
    } else if(!e){
        color = "erro-add";
    }

    return color;
}

async function newMsg(e){
    let msg = document.createElement("div");
    let color = defineColor(e.response);

    msg.classList.add(`msg-add`);
    msg.classList.add(color);
    msg.innerText = e.mensagem;
    document.body.appendChild(msg);
    if(e.response === true || e.response == 'ag'){
        closeAdd();
        cleanInps();
        if(e.response == 'ag'){
            await sleep(2000);
        }
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

if (typeof searchBar !== "undefined"){
    searchBar.addEventListener('keyup', ()=>{
        let val = searchBar.value;
        let filter = selectFilter.value;
        console.log(file.allData)
        for(let i of file.allData){
            let name = i[filter];
            console.log(name);
            
            if(Number(name)){
                name = Number(name);
                name = new Date((name * 1000) + 86400000).toLocaleDateString('pt-br');
            } else {
                name = name.toLowerCase();
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
}

const convert64 = async () => {
    let file = imageAdd.files[0];
    if(!file) return;
    let base64 = await getBase64(file);

    addNewData("extra/patrocinadores/add", {
        nome: nomeAdd.value,
        image: base64
    })
}
let sendActive = false;

const sendImgs = async () => {
    
    let files = imageAdd.files;
    let grupoFixo = Number(pastaAdd.value);
    if(!files) return;

    let tamanhoT = 0;
    let totalT = 0;

    for(let i = 0; i < files.length; i++){
        tamanhoT += files[i].size / 1000000;

        if((files[i].size / 1000000) > 5){
            newMsg({
                mensagem: "Tamanho máximo de imagem: 5MB.",
                response: false,
            })
            return;
        }
    }

    if(files.length > 300){
        newMsg({
            mensagem: "Mais de 300 arquivos",
            response: false
        })

        return;
    } else if(tamanhoT > 1000){
        newMsg({
            mensagem: "Total mais pesado que 1GB",
            response: false
        })

        return;
    }

    let foram = 0;
    let total = 0;
    let erro = false;

    if(sendActive) return;
    sendActive = true;

    outShowImgs.scrollTo(0, 0);
    for(let i in files){
        if(erro) break;

        if(!files[i]) {
            sendActive = false;
            return;
        };
        let base64 = await getBase64(files[i]);

        let data = {
            image: base64,
            grupo: grupoFixo
        }

        document.querySelectorAll(`#showgp${i} p`)[1].innerText = "Carregando";

        await fetch("../sys/api/galeria/foto/add",{
            method: "POST",
            body: JSON.stringify(data)
        })
        .then(e=>e.json())
        .then(e=>{
            totalT += files[i].size / 1000000;
            newMsg(e);
            if(e.response){
                document.getElementById(`showgp${i}`).remove();
                foram++;
                total++;
                countOut.innerHTML = "";
                countOut.innerHTML += `${foram} de ${files.length} - ${(tamanhoT - totalT).toFixed(2)}MB`;

            }
            if(!e.response){
                erro = true;
                sendActive = false;
            }

            if(total == files.length){
                window.location.reload();
                sendActive = false;

            }
        })
    }
    
}

const getBase64 = (e) => {
    return new Promise((res) => {
        const reader = new FileReader();
        reader.onload = () => res(reader.result);
        reader.readAsDataURL(e);
    });
}

function sleep(milliseconds) {
    return new Promise(resolve => setTimeout(resolve, milliseconds))
}
