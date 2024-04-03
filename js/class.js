class File{
    constructor(id){
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
    }

    getData(){
        console.log("Get Data: " + this.name)
        let link = '../sys/api/' + this.linkGet
        return fetch(`${link}`)
        .then(e=>e.json())
        .then(e=>{ 
            console.log("Fetching")
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
            let statusDiv = document.querySelectorAll(".td-status");
            let activevar = 0;
            let inactivevar = 0;

            for(let i of statusDiv){
                let statusI = i.getAttribute("status");
                if(statusI){
                    activevar++;
                } else {
                    inactivevar++;
                }
            }
            inactive.innerText = inactivevar;
            active.innerText = activevar;
        })
        .catch(e=>newMsg({
            mensagem: "Ocorreu algum erro, contate o administrador",
            response: false
        }))
    }

    createTh(){
        console.log('Creating TH: ' + this.name);
        let tr = document.createElement('tr');
    
        let hlo = document.querySelector('.header-list-out');
        let select = document.createElement('select');
        select.id = 'selectFilter';
    
        for(let i of this.thContent){
            if(i == 'status'){
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

            if((this.typeUser > 2) || (this.typeUser > 1 && (this.name == 'alunos' || this.name == 'recados'))){
                let btRemove = document.createElement("button");
                btRemove.classList.add("btn-add");
                btRemove.id = 'btnRemove';
                btRemove.setAttribute("onclick", "file.removeSec()")
                btRemove.innerText = "Excluir";
                outBt.append(btRemove);
            }
            let i = e.mensagem[0];
            
            for(let [key, value] of Object.entries(i)){
                let qt;
                let type = 0;
                let deftime = 0;
                if(key == 'turmas' && (this.name == 'alunos' || this.name == 'profissionais')){
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
                            for(let j in value2){
                                value2[j] = JSON.stringify(value2[j]);
                            }
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
                    
                    if(key == 'alunos' && this.typeUser > 1){
                        let btAddAula = document.createElement("button");
                        btAddAula.classList.add("btn-add");
                        btAddAula.setAttribute('onclick', `openAddAula()`);
                        btAddAula.innerText = "Adicionar aula";

                        outBt.append(btAddAula);
                        verPresencaBt.setAttribute('onclick', "verMais(this, 1, 'Chamada')");
                    }
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

                    if(this.arrayDetail.includes(key)){
                        let span = document.createElement("span");
                        span.innerText = qt;

                        h3.innerText = key + ' - ';
                        h3.append(span);

                    } else {
                        h3.innerText = key;
                    }

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
                    } else if(key == 'status'){
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
                                console.log(`-NOT UNDEF: ${deftime}}`);

                            } else {
                                input.valueAsNumber = deftime * 1000;
                                console.log(`-DEF: ${deftime}`);
                            }
                        } else {
                            input.value = value;
                        }
                        addOut.append(input);
                    } else {
                        console.log(value);
                        p.innerHTML = value.toString();
                        addOut.append(p);
                    }
                    inpsAdd.append(addOut);
                }
            }
            if((this.typeUser > 2) || (this.typeUser > 1 && (this.name == 'alunos' || this.name == 'recados'))){
                let btSave = document.createElement("button");
                btSave.classList.add("btn-add");
                btSave.setAttribute("onclick", "sendEdit(file.idDetail, file.name, this.parentNode.parentNode)");
                btSave.innerText = "Salvar";
                outBt.append(btSave);
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

    removeSec(){
        let link = '../sys/api/extra/remove?local=' + this.name + '&id=' + this.idDetail
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
        console.log('Creating TH: ' + this.name);
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
        headList2.appendChild(tr);
        hlo[1].appendChild(select);
    }

    createEspera(){
        console.log("Get Espera: " + this.name)
        let link = '../sys/api/usuarios/getEspera?type=' + this.name
        return fetch(`${link}`)
        .then(e=>e.json())
        .then(e=>{ 
            console.log("Fetching")
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
    
                for(let [key, value] of Object.entries(i)){
                    if(key != 'id' && key != '_name'){
                        let td = document.createElement('td');
                        td.classList.add(`td-${key}`);
                        
                        td.innerHTML = value;
                        tr.appendChild(td);
                    }
                }
                let td2 = document.createElement('td');
                td2.innerHTML = `<button class="ver-detalhes" onclick="file.sendEspera(${i.email})">Aprovar</button>`;
                tr.appendChild(td2);

                tabList2.appendChild(tr)
            }
            tabList2.innerHTML += "<tr class='empty-line table-line2' id='notData2'><td></td><td style='text-align: center'>Nenhum dado encontrado</td><td></td></tr>";

            if(tabList2.querySelectorAll('.table-line').length > 0){
                notData2.classList.remove('table-line2');
            }
        })
        .catch(e=>newMsg({
            mensagem: "Ocorreu algum erro, contate o administrador22",
            response: false
        }))
    }

    sendEspera(id){
        let nome = this.name == 'alunos' ? 'aluno' : 'professor'
        let local = 'usuarios/cadastrar/' + nome
        let data = {id: id, espera: true}
        addNewData(local, data);
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
        this.arrayDetail.push('turmas')
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
        this.thContent = ['nome', 'turma','categoria', 'data', 'status']
        // this.jumpDetail.push()
        this.numsDetail.push('data')
        this.arrayDetail.push('turmas')
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
    constructor(id){
        super(id)
        this.name = 'turmas'
        this.linkGet = 'turmas/get/turmas'
        this.thContent = ['Nome', 'Categoria', 'Profissionais', 'Alunos', 'Status']
        this.jumpDetail.push('alunosQt', 'profissionaisQt', 'def_time')
        this.numsDetail.push('horario')
        this.arrayDetail.push('profissionais', 'alunos', 'aulas')
        this.createTh()
        this.getData()
    }
}