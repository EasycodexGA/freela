class File{
    constructor(id, idAluno){
        this.name = ''
        this.arrayStrAdd = {}
        this.saveToAdd = ''
        this.linkGet = ''
        this.thContent = []
        this.allData = {}
        this.allEspera = {}
        this.idDetail = '';
        this.jumpDetail = ['id']
        this.arrayDetail = []
        this.numsDetail = ['created']
        this.typeUser = id;
        this.idAluno = idAluno
    }

    getData(){
        let link = '../sys/api/' + this.linkGet
        return fetch(`${link}`)
        .then(e=>e.json())
        .then(e=>{ 
            this.allData = e.mensagem;
            for(let i of e.mensagem){
                if(i.data){
                    let date = new Date(i.data * 1000 + 86400000);
                    i.data = date.toLocaleDateString("pt-BR");
                }
                
                let tr = document.createElement('tr');
                tr.classList.add('empty-line');
                tr.classList.add('table-line');
                tr.id = `key${i.id}`;
    
                for(let [key, value] of Object.entries(i)){
                    if(key != 'id' && key != '_name'){
                        let td = document.createElement('td');
                        td.classList.add(`td-${key}`);

                        if(key == 'status'){
                            let preStatus = value == 'active' ? true : false;
                            tr.dataset.status = preStatus;
                            let td2 = document.createElement('td');
                            td2.innerHTML = `<button class="ver-detalhes" onclick="openDetail(${i.id})">Ver detalhes</button>`;
                            tr.appendChild(td2);
                        }
    
                        td.innerHTML = `<span>${key}:</span> <asd>${value}<asd`;
                        tr.appendChild(td);
                    }
                }
                tabList.appendChild(tr)
            }
            tabList.innerHTML += "<tr class='empty-line table-line2' id='notData'><td></td><td style='text-align: center'>Nenhum dado encontrado</td><td></td></tr>";
    
            if(tabList.querySelectorAll('.table-line').length > 0){
                notData.classList.remove('table-line2');
            }
            this.getNums();
        })
        .catch(e=>newMsg({
            mensagem: "Ocorreu algum erro, contate o administrador",
            response: false
        }))
    }

    createTh(){
        let tr = document.createElement('tr');
    
        let hlo = document.querySelector('.header-list-out');
        let select = document.createElement('select');
        select.id = 'selectFilter';
    
        for(let i of this.thContent){
            if(i.toLowerCase() == 'status'){
                let th2 = document.createElement('th');
                tr.appendChild(th2);
            }
            let th = document.createElement('th');
            th.innerHTML = i;
            tr.appendChild(th);
    
            let option = document.createElement('option');
            option.value = i;
            option.innerHTML = i[0].toUpperCase() + (i.substr(1, i.length));
            select.appendChild(option);
        }
        headList.appendChild(tr);
        hlo.appendChild(select);
    }

    getDetails(){
        let link = '../sys/api/detalhes/' + this.name + '?id=' + this.idDetail
        return fetch(link)
        .then(e=>e.json())
        .then(e=>{
            if(!e.response){
                newMsg(e);
                return;
            }
            details.classList.add("add-active");
            detailContainer.innerHTML = '';

            let h1 = document.createElement("h1");
            h1.classList.add("title-add");
            h1.innerText = "Detalhes";

            let inpsAdd = document.createElement("div")
            inpsAdd.classList.add("inps-add");

            let outBt = document.createElement("div");
            outBt.classList.add("out-bt-sv");

            let btClose = document.createElement("button");
            btClose.classList.add("btn-close");
            btClose.setAttribute("onclick", "closeAdd()");
            btClose.innerText = "Fechar";
            outBt.append(btClose);

            if((this.typeUser >= 2) || (this.typeUser > 1 && (this.name == 'alunos' || this.name == 'recados'))){
                let btRemove = document.createElement("button");
                btRemove.classList.add("btn-add");
                btRemove.id = 'btnRemove';
                btRemove.setAttribute("onclick", `file.removeSec('${this.name}',${this.idDetail})`)
                btRemove.innerText = "Excluir";
                outBt.append(btRemove);
            }

            if(this.name == 'turmas' && this.typeUser > 1){
                let btAddAula = document.createElement("button");
                btAddAula.classList.add("btn-add");
                btAddAula.setAttribute('onclick', `openAddAula()`);
                btAddAula.innerText = "Adicionar aula";

                outBt.append(btAddAula);
                let data = e.mensagem[0].alunos;
                data = data.map((x)=>JSON.stringify(x));
                data = data.join('#');
                this.arrayStrAdd.addAulaArray = data
                verPresencaBt.setAttribute('onclick', "verMais('addAula', 1, 'Chamada')");
            }

            if((this.typeUser >= 2) || (this.typeUser > 1 && (this.name == 'alunos' || this.name == 'recados'))){
                let btSave = document.createElement("button");
                btSave.classList.add("btn-add");
                btSave.setAttribute("onclick", "sendEdit(file.idDetail, file.name, this.parentNode.parentNode)");
                btSave.innerText = "Salvar";
                outBt.append(btSave);
            }

            let i = e.mensagem[0];
            
            for(let [key, value] of Object.entries(i)){
                let qt;
                let type = 0;
                let deftime = 0;
                if((key == 'turmas' || key == 'equipes') && (this.name == 'alunos' || this.name == 'profissionais' || this.name == 'eventos')){
                    type = 1;
                }
                if(this.numsDetail.includes(key)){
                    deftime = value;
                    value = (new Date(value * 1000 + 86400000)).toLocaleDateString("pt-BR");
                }
                if(this.arrayDetail.includes(key)){
                    if(key == 'aulas'){
                        type = 2;
                        for(let i of value){
                            let value2 = i.chamada;
                            value2 = value2.map((x)=> JSON.stringify(x));
                            value2 = value2.join('#');
                            this.arrayStrAdd[`${key}${i.id}Array`] = value2;
                        }
                    }
                    qt = value.length;
                    for(let j in value){
                        if(key == 'alunos'){
                            value[j].checked = 0;
                        }
                        value[j] = JSON.stringify(value[j]);
                    }
                    value = value.join("#");
                    
                    this.arrayStrAdd[`${key}Array`] = value == '' ? false : value;
                    value = `<button class='btn-add btn-send-data' data-key='${key}' onclick='verMais("${key}", ${type}, "${key}")'>Ver ${key}</button>`;
                }
                if(!this.jumpDetail.includes(key)){
                    let addOut = document.createElement("div");
                    addOut.classList.add("inp-add-out");

                    let p = document.createElement("p");
                    let h3 = document.createElement("h3");

                    if(key == 'descricao'){
                        key = 'descrição';
                        addOut.style = 'width: calc(100%);';
                    }

                    h3.innerText = key;

                    addOut.append(h3);

                    let disablekey = ["from", "to", "type", "categoria", "created"];

                    if(key == 'imagem'){
                        key = 'Foto';
                        let imgOut = document.createElement('div');
                        imgOut.classList.add('img-out-dt');

                        let img = document.createElement("img");
                        let srcImg = value ? '../imagens/perfil/' + value : '../img/default.webp';
                        img.src = srcImg;

                        imgOut.append(img);
                        addOut.append(imgOut);

                    } else if(key == 'curriculo'){
                        if(value){
                            let srcCur = '../arquivos/curriculos/' + value;
                            let a = document.createElement("a");
                            a.href = srcCur;
                            a.innerText = 'Ver currículo';
                            a.target = '_blank';
                            a.classList.add('a-cur');
                            p.append(a);
                            if(this.typeUser == 3 || (this.typeUser > 1 && (this.name == 'alunos' || this.name == 'turmas'))){
                                addOut.append(p);
                            }
                        }
                    } else if(key == 'status' && this.typeUser >= 2){
                        let input = document.createElement("input");
                        input.type = 'checkbox';
                        input.classList.add("checkbox-presenca");
                        input.classList.add("input-americano");
                        input.dataset.key = key;

                        if(disablekey.includes(key)){
                            input.disabled = true;
                        }
                        
                        if(value == 'active'){
                            input.checked = true;
                        }
                        input.id = 'statusInp';

                        let label = document.createElement("label");
                        label.setAttribute('for','statusInp');
                        label.classList.add('toggle-switch');

                        addOut.append(input);
                        addOut.append(label);

                    } else if((this.typeUser == 3 || (this.typeUser > 1 && (this.name == 'alunos' || this.name == 'turmas'))) && !(this.arrayDetail.includes(key)) && key != 'presencas' && key != 'faltas'){
                        let input = document.createElement("input");
                        let typeInp = 'text';
                        let isNumInp = false;
                        if(key == 'nascimento' || key == 'data'){
                            typeInp = 'date';
                            isNumInp = true;
                        }

                        console.log(`-> ${key}`);

                        if(key == 'horario'){
                            typeInp = 'time';
                            isNumInp = true;
                        }
                        input.classList.add('input-americano');
                        input.dataset.key = key;
                        input.type = typeInp;
                        if(disablekey.includes(key)){
                            input.disabled = true;
                        }
                        if(isNumInp){
                            if(typeof e.mensagem[0].def_time != "undefined"){
                                input.valueAsNumber = Number(e.mensagem[0].def_time);
                                console.log("chegou 3");

                            } else {
                                input.valueAsNumber = deftime * 1000;
                                console.log("chegou 2");
                            }

                        } else {
                            input.value = value;
                            console.log("chegou 1");

                        }
                        addOut.append(input);

                    } else {
                        console.log("chegou 0");
                        if(key == "horario"){
                            p.innerHTML = convertHora(e.mensagem[0].def_time);
                        } else {
                            p.innerHTML = value.toString();
                        }
                        addOut.append(p);
                    }
                    inpsAdd.append(addOut);
                }
            }
            detailContainer.append(h1);
            detailContainer.append(inpsAdd);
            detailContainer.append(outBt);
        })
        .catch(e=>newMsg({
            mensagem: "Ocorreu algum erro, contate o administrador",
            response: false
        }))
    }

    removeSec(local, data){
        let link = '../sys/api/extra/remove?local=' + local + '&id=' + data
        fetch(link)
        .then(e=>e.json())
        .then(e=>{
            newMsg(e);
        })
        .catch(e=>newMsg({
            mensagem: "Ocorreu algum erro, contate o administrador",
            response: false
        }))
    }

    createThEspera(){
        let tr = document.createElement('tr');
    
        let hlo = document.querySelectorAll('.header-list-out');
        let select = document.createElement('select');
        select.id = 'selectFilter2';
    
        for(let i of ["nome", "email", "nascimento"]){
            let th = document.createElement('th');
            th.innerHTML = i;
            tr.appendChild(th);
    
            let option = document.createElement('option');
            option.value = i;
            option.innerHTML = i[0].toUpperCase() + (i.substr(1, i.length));
            select.appendChild(option);
        }
        let th = document.createElement("th");
        tr.append(th);
        let th2 = document.createElement("th");
        tr.append(th2);
        headList2.appendChild(tr);
        hlo[1].appendChild(select);
    }

    async createEspera(){
        let link = '../sys/api/usuarios/getEspera?type=' + this.name
        return await fetch(`${link}`)
        .then(e=>e.json())
        .then(e=>{ 
            this.allEspera = e.mensagem;
            for(let i of e.mensagem){
                if(i.data){
                    let date = new Date(i.data * 1000 + 86400000);
                    i.data = date.toLocaleDateString("pt-BR");
                }
                let tr = document.createElement('tr');
                tr.classList.add('empty-line');
                tr.classList.add('table-line');
                tr.id = `key${i.id}E`;
                tr.dataset.status = 'espera';
    
                for(let [key, value] of Object.entries(i)){
                    if(key != 'id' && key != '_name'){
                        let td = document.createElement('td');
                        td.classList.add(`td-${key}`);
                        
                        td.innerHTML = value;
                        tr.appendChild(td);
                    }
                }
                let td1 = document.createElement('td');
                td1.innerHTML = `<button class="ver-detalhes remove-espera" onclick="file.removeSec('espera', '${i.email}')">Remover</button>`
                let td2 = document.createElement('td');
                td2.innerHTML = `<button class="ver-detalhes" onclick="file.sendEspera('${i.email}')">Aprovar</button>`;
                tr.appendChild(td1);
                tr.appendChild(td2);

                tabList2.appendChild(tr)
            }
            tabList2.innerHTML += "<tr class='empty-line table-line2' id='notData2'><td></td><td style='text-align: center'>Nenhum dado encontrado</td><td></td></tr>";

            if(tabList2.querySelectorAll('.table-line').length > 0){
                notData2.classList.remove('table-line2');
            }
            this.getNums();
        })
        .catch(e=>newMsg({
            mensagem: "Ocorreu algum erro, contate o administrador22",
            response: false
        }))
    }

    sendEspera(email){
        let nome = this.name == 'alunos' ? 'aluno' : 'professor'
        let local = 'usuarios/cadastrar/' + nome
        let data = {email: email, espera: true, insert: true}
        addNewData(local, data);
    }

    getNums(){
        let statusDiv = document.querySelectorAll(".table-line");
        let activevar = 0;
        let inactivevar = 0;
        let esperavar = 0;

        for(let i of statusDiv){
            let statusI = i.dataset.status;
            if(statusI == 'true'){
                activevar++;
            } else if(statusI == 'false'){
                inactivevar++;
            } else if(statusI == 'espera'){
                esperavar++;
            }
        }
        inactive.innerText = inactivevar;
        active.innerText = activevar;
        typeof esperaat != "undefined" ? esperaat.innerText = esperavar : "";
    }
}

class Alunos extends File{
    constructor(id){
        super(id)
        this.name = 'alunos'
        this.linkGet = 'usuarios/get/alunos'
        this.thContent = ['Nome', 'email', 'nascimento', 'status']
        this.jumpDetail.push('allTurmas')
        this.numsDetail.push('nascimento')
        this.arrayDetail.push('turmas', 'equipes')
        this.createTh()
        this.getData()
        this.createThEspera()
        this.createEspera()
    }
}

class Categorias extends File{
    constructor(id){
        super(id)
        this.name = 'categorias'
        this.linkGet = 'usuarios/get/categorias'
        this.thContent = ['nome', 'turmas', 'status']
        // this.jumpDetail.push()
        // this.numsDetail.push()
        this.arrayDetail.push('turmas')
        this.createTh()
        this.getData()
    }
}

class Eventos extends File{
    constructor(id){
        super(id)
        this.name = 'eventos'
        this.linkGet = 'turmas/get/eventos'
        this.thContent = ['nome', 'data', 'status']
        // this.jumpDetail.push()
        this.numsDetail.push('data')
        this.arrayDetail.push('turmas', 'equipes')
        this.createTh()
        this.getData()
    }
}

class Profissionais extends File{
    constructor(id){
        super(id)
        this.name = 'profissionais'
        this.linkGet = 'usuarios/get/profissionais'
        this.thContent = ['nome', 'email', 'nascimento', 'titularidade', 'status']
        this.jumpDetail.push('allTurmas')
        this.numsDetail.push('nascimento')
        this.arrayDetail.push('turmas')
        this.createTh()
        this.getData()
        this.createThEspera()
        this.createEspera()
    }
}

class Recados extends File{
    constructor(id){
        super(id)
        this.name = 'recados'
        this.linkGet = 'recados/get.php'
        this.thContent = ['Título', 'Para', 'Data', 'Status']
        // this.jumpDetail.push()
        this.numsDetail.push("data")
        // this.arrayDetail.push()
        this.createTh()
        this.getData()
    }
}

class Turmas extends File{
    constructor(id, idAluno){
        super(id, idAluno)
        this.name = 'turmas'
        this.linkGet = 'turmas/get/turmas'
        this.thContent = ['Nome', 'Categoria', 'Profissionais', 'Alunos', 'Status']
        this.jumpDetail.push('def_time')
        this.numsDetail.push('horario')
        this.arrayDetail.push('profissionais', 'alunos', 'aulas')
        this.createTh()
        this.getData()
    }
}

class Equipes extends File{
    constructor(id){
        super(id)
        this.name = 'equipes'
        this.linkGet = 'turmas/get/equipes'
        this.thContent = ['Nome', 'Alunos', 'Status']
        // this.jumpDetail.push()
        // this.numsDetail.push()
        this.arrayDetail.push('alunos')
        this.createTh()
        this.getData()
    }
}

class Rifas extends File{
    constructor(id){
        super(id)
        this.name = 'rifas'
        this.linkGet = 'turmas/get/rifas'
        this.getData()
    }
    getData(){
        let link = '../sys/api/' + this.linkGet
        return fetch(`${link}`)
        .then(e=>e.json())
        .then(e=>{ 
            this.allData = e.mensagem;
            for(let i of e.mensagem){
                console.log(i);
                let div = document.createElement('div');
                div.classList.add('item-rifa');

                let nome = document.createElement('h1');
                nome.innerText = i.nome;

                let divImg = document.createElement('div');
                divImg.classList.add('image-rifa-out');

                let img = document.createElement('img');
                img.classList.add('image-rifa');
                img.src = '../sys/api/images/' + i.img

                let val = document.createElement('p');
                val.innerText = 'R$' + i.valor;

                let qt = document.createElement('span');
                qt.innerText = i.sel + '/' + i.qt

                let bt = document.createElement('button');
                bt.innerText = 'Ver detalhes';
                bt.onclick = ()=> {openDetail(i.id)}
                bt.classList.add('detalhes-rifa');


                div.append(nome);
                divImg.append(img);
                div.append(divImg);
                div.append(val);
                div.append(qt);
                div.append(bt);

                itensRifaOut.append(div);


            }
        })
    }
    
    getDetails(){
        let link = '../sys/api/detalhes/' + this.name + '?id=' + this.idDetail
        return fetch(link)
        .then(e=>e.json())
        .then(e=>{
            if(!e.response){
                newMsg(e);
                return;
            }
            // criar detalhes
        })
    }
}