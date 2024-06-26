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
    file.idDetail = id
    file.getDetails()
}

function closeAdd(){
    typeof addNew != "undefined" ? addNew.classList.remove("add-active") : console.log("faltou");;
    typeof details != "undefined" ? details.classList.remove("add-active") : console.log("faltou");;
}

function openAddAula(){
    addNewAula.classList.add("add-active");
}

function closeAddAula(){
    addNewAula.classList.remove('add-active');
}

function verMais(id,type, titleStr){
    verMaisDiv.innerHTML = '';
    let string = file.arrayStrAdd[`${id}Array`];

    if(!string){
        newMsg({
            mensagem: "Sem dados!",
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
        if(file.typeUser == 1 && i.checked == 0){
            continue
        }

        let div = document.createElement('div');
        div.classList.add("chamada-list")

        let div2 = document.createElement('div');
        div2.classList.add('chamada-list2');

        let p = document.createElement("p");
        if(i.data){
            let date = new Date(i.data * 1000 + 86400000);
            i.data = date.toLocaleDateString("pt-BR");
        }
        let createDesc = false;
        console.log(i);
        if(i.nome){
            p.innerText = i.nome;
        } else {
            p.innerText = i.data;
            createDesc = true;
        }

        div2.append(p);

        if(createDesc){
            let d = document.createElement('p');
            d.classList.add('desc-aulas-chamada');
            d.innerText = i.descricao;
            div2.append(d);
        }
        div.append(div2);

        if(type == 1){
            if(file.typeUser > 1){
                let input = document.createElement("input");
                input.type = 'checkbox';
                input.classList.add("checkbox-presenca");
                input.classList.add("checkbox-presencaa");
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
        }
        if(type == 2){
            if(file.typeUser > 1){
                presencaBt = document.createElement("button");
                presencaBt.classList.add("btn-add");
                presencaBt.classList.add("btn-presenca");
                presencaBt.innerText = 'Ver chamada';
                presencaBt.setAttribute("onclick", `verMais('${id}${i.id}', 1, 'Chamada')`);
                presencaBt.dataset.id = id;
                div.append(presencaBt);
            } else {
                let presenca = document.createElement('p');
                i.chamada.forEach((e, index) => {
                    if(e.idA == file.idAluno){
                        if(i.chamada[index].checked == 1){
                            presenca.innerText = 'presente';
                            presenca.classList.add('presenca-p');
                        } else {
                            presenca.innerText = 'ausente';
                            presenca.classList.add('presenca-a');
                        }
                    }
                });
                div.append(presenca)
            }
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
    if(type == 1 && id.includes('aulas')){
        verMais("aulas", 2, "aulas");
    } else {
        verMaisDiv.classList.remove('add-active');
    }
}

function convertHora(millis) {
    let seconds = Math.floor(millis / 1000);
    let minutes = Math.floor(seconds / 60);
    let hours = Math.floor(minutes / 60);
    
    seconds = seconds % 60;
    minutes = minutes % 60;
    hours = hours % 24;
    
    return `${hours.toString().padStart(2, '0')}:${minutes.toString().padStart(2, '0')}`;
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

        let allBts = document.querySelectorAll('.checkbox-presencaa');
        for(let i = 0; i < allBts.length; i++){
            bool = allBts[i].checked ? 1 : 0 ;
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
    .catch(e=>newMsg({
        mensagem: "Ocorreu algum erro, contate o administrador",
        response: false
    }))
}

function sendEdit(id, name, parent){
    let url = 'editar/' + name;
    let data = {"id": id}
    console.log(data);
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
        let newArr = [];
        if(preData){
            preData = preData.split("#");
            for(let j in preData){
                preData[j] = JSON.parse(preData[j]);
                console.log(`preData`, preData[j]);
                if(i.dataset.key == 'aulas'){
                    let manipulate = file.arrayStrAdd[`aulas${preData[j].id}Array`]                    
                    let test = preData[j].chamada
                    test = test.map((x)=>JSON.stringify(x))
                    test = test.join("#")
                    if(test != manipulate){
                        manipulate = manipulate.split("#")
                        manipulate = manipulate.map((x)=>JSON.parse(x));
                        preData[j].chamada = manipulate
                        newArr.push(preData[j]);
                    }
                } else {
                    newArr.push(preData[j])
                }
                console.log(newArr);
            }
        }
        data[`${i.dataset.key}`] = newArr;
    }
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

async function changeResp(){
    let resp1foto = imageResp1Add.files[0];
    let resp2foto = imageResp2Add.files[0];
    let base641 = false;
    let base642 = false;

    if(resp1foto){
        base641 = await getBase64(resp1foto);
    }

    if(resp2foto){
        base642 = await getBase64(resp2foto);
    }

    addNewData("extra/site/editresp", {
        nomeresp1: nomeResp1Add.value,
        nomeresp2: nomeResp2Add.value,
        telresp1: telResp1Add.value,
        telresp2: telResp2Add.value,
        mailresp1: mailResp1Add.value,
        mailresp2: mailResp2Add.value,
        imageresp1: base641,
        imageresp2: base642
    })
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
        val = val.toLowerCase();
        let filter = selectFilter.value.toLowerCase();
        filter = filter == 'nascimento' ? 'data' : filter;
        for(let i of file.allData){
            let name = i[filter];
            name = name.toString().toLowerCase();
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

const editSite = async () => {
    let file = bannerAdd.files[0];
    let base64 = false;
    if(file){
        base64 = await getBase64(file);
    }

    addNewData("extra/site/edit", {
        titulo: tituloAdd.value,
        image: base64
    })
}

const editDesc = async () => {
    addNewData("extra/site/editdesc", {
        desc: descAdd.value,
    })
}

const editLogo = async () => {
    let file = logoAdd.files[0];
    let base64 = false;
    if(file){
        base64 = await getBase64(file);
    }

    addNewData("extra/site/editlogo", {
        image: base64
    })
}

const editMiniDesc = async () => {
    addNewData("extra/site/editinfos", {
        info1: info1Add.value,
        info2: info2Add.value,
        info3: info3Add.value
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
