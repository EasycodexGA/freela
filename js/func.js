
function openAdd(e){
    addNew.classList.add("add-active");

    console.log(e)
}

function closeAdd(){
    addNew.classList.remove("add-active");
}

function addProfessor(){
    fetch("https://freela.anizero.cc/sys/api/usuarios/cadastrar/professor",{
        method: "POST",
        body: JSON.stringify(data)
    })
    .then(e=>e.text())
    .then(e=>console.log(e))
}