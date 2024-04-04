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

function verMais(id,type, titleStr){
    verMaisDiv.innerHTML = '';
    let string = file.arrayStrAdd[`${id}Array`];
    console.log(`-VER_MAIS_CONTENT: ${string}`)

    if(!string){
        newMsg({
            mensagem: "Em desenvolvimento",
            response: false
        })
        return;
    }

    let array = string.split('#');

    let divOut = document.createElement('div');
    divOut.classList.add('add-container');

    let title = document.createElement("h1");
    title.classList.add("title-add");
    title.innerText = titleStr;

    let divMid = document.createElement("div");
    divMid.classList.add("chamadaout");

    for(let i of array){
        i = JSON.parse(i);
        let div = document.createElement('div');
        div.classList.add("chamada-list")
        let p = document.createElement("p");
        p.innerText = i.nome ? i.nome : i.data;
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
        if(type == 2){
            presencaBt = document.createElement("button");
            presencaBt.classList.add("btn-add");
            presencaBt.classList.add("btn-presenca");
            presencaBt.innerText = 'Ver chamada';
            presencaBt.setAttribute("onclick", `verMais('${id}${i.id}', 1, 'Chamada')`);
            presencaBt.dataset.id = id;
            div.append(presencaBt);
        }

        divMid.append(div);
    }

    let outBt = document.createElement("div");
    outBt.classList.add("out-bt-sv");

    if(id != 'aulas'){
        let closeBt = document.createElement("button");
        let typee = id.includes('aulas') && id != 'aulas' ? 1 : 0;
        closeBt.setAttribute("onclick", `closeVerMais('${id}', ${typee})`);
        closeBt.innerText = 'Fechar';
        closeBt.classList.add("btn-close");
        outBt.append(closeBt);
    }
    
    if(type > 0){
        let saveBt = document.createElement("button");
        console.log(id);
        let typee = id.includes('aulas') && id != 'aulas' ? 1 : 0;
        saveBt.setAttribute("onclick", `salvarCheckbox('${id}', ${typee})`);
        saveBt.innerText = 'Salvar';
        saveBt.classList.add("btn-add");
        outBt.append(saveBt);
    }

    divOut.append(title);
    divOut.append(divMid);
    divOut.append(outBt);
    verMaisDiv.append(divOut);
    verMaisDiv.classList.add('add-active');
}

function closeVerMais(id, type){
    // console.log(file.arrayStrAdd);
    if(type == 1 && id.includes('aulas')){
        verMais("aulas", 2, "aulas");
    } else {
        verMaisDiv.classList.remove('add-active');
    }
}

function salvarCheckbox(id, type){
    if(id == 'aulas'){
        let temp = file.arrayStrAdd["aulasArray"];
        temp = temp.split("#");
        let buttons = document.querySelectorAll(".btn-presenca");
        for(let i = 0; i < buttons.length; i++){
            let takeData = buttons[i].dataset.id;
            let temp2 = file.arrayStrAdd[`${takeData}Array`];
            temp[i].chamada = temp2;
        }
        temp = temp.join("#");
        file.arrayStrAdd["aulasArray"] = temp;
    } else {
        let string = file.arrayStrAdd[`${id}Array`];
        let array = string.split('#');
        array = array[0];

        let allBts = document.querySelectorAll('.checkbox-presenca');
        for(let i = 0; i < allBts.length; i++){
            bool = allBts[i].checked ? 1 : 0 ;
            console.log(array[i]);
            array[i] = JSON.parse(array[i]);
            array[i].checked = bool;
            array[i] = JSON.stringify(array[i]);
        }
        let value = array.join('#');
        file.arrayStrAdd[`${id}Array`] = value;
    }
    if(type == 1 && id.includes('aulas')){
        verMais("aulas", 2, "aulas");
    } else {
        closeVerMais(0, 0);
    }
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
    console.log(`Reciving data:`, data)
    console.log(`To local: ${local}`)
    if(isActive) return;
    isActive = true;
    fetch(`../sys/api/${local}`,{
        method: "POST",
        body: JSON.stringify(data)
    })
    .then(e=>e.json())
    .then(e=>{
        console.log(`Recived from: ${local}`)
        console.log(`Response:`, e)
        isActive = false;
        newMsg(e);
    })
    .catch(e=>newMsg({
        mensagem: "Ocorreu algum erro, contate o administrador",
        response: false
    }))
}

function sendEdit(id, name, parent){
    let url = 'editar/' + name;
    let data = {"id": id}
    let inputs = parent.querySelectorAll(".input-americano");
    let buttons = parent.querySelectorAll(".btn-send-data");
    for(let i of inputs){
        if(i.dataset.key == "nascimento" || i.dataset.key == "data"){
            data[`${i.dataset.key}`] = i.valueAsNumber / 1000;
        } else if(i.dataset.key == "horario"){
            data[`${i.dataset.key}`] = i.valueAsNumber;
        } else if(i.dataset.key == 'status'){
            let val = i.checked ? 1 : 0;
            data[`active`] = val;
        }else {
            data[`${i.dataset.key}`] = i.value;
        }
    }
    for(let i of buttons){
        let preData = file.arrayStrAdd[`${i.dataset.key}Array`];
        if(preData){
            preData = preData.split("#");
            for(let j in preData){
                preData[j] = JSON.parse(preData[j]);
            }
        }
        data[`${i.dataset.key}`] = preData;
    }
    console.log(data)
    addNewData(url, data);
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
        let val = searchBar.value.toString();
        let filter = selectFilter.value.toLowerCase();
        filter = filter == 'nascimento' ? 'data' : filter;
        for(let i of file.allData){
            let name = i[filter];
            name = name.toString().toLowerCase();
            console.log(file.allData, name, val, filter);
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
if (typeof searchBar2 !== "undefined"){
    searchBar2.addEventListener('keyup', ()=>{
        let val = searchBar2.value.toString();
        let filter = selectFilter2.value.toLowerCase();
        filter = filter == 'nascimento' ? 'data' : filter;
        for(let i of file.allEspera){
            let name = i[filter];
            name = name.toString().toLowerCase();
            console.log(file.allEspera, name, val, filter);
            if(name.includes(val)){
                document.getElementById(`key${i.id}E`).classList.add('table-line');
            } else {
                document.getElementById(`key${i.id}E`).classList.remove('table-line');
            }
            if(tabList2.querySelectorAll('.table-line').length == 0){
                notData2.classList.add('table-line2');
            } else {
                notData2.classList.remove('table-line2');
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
        .catch(e=>newMsg({
            mensagem: "Ocorreu algum erro, contate o administrador",
            response: false
        }))
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
