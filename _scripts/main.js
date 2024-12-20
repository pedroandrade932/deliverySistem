//Funcionalidade da barra de pesquisa (efeito de surgir)

const search = document.getElementById('lupa');
//Evento que ativa a barra de pesquisa
search.addEventListener('mouseenter', () => {
    let searchfield = document.getElementById('search');
    searchfield.classList.toggle('searchAtive');
});

//Funcionalidade do header na rolagem
window.addEventListener('scroll', () => {
    let header = document.getElementById('header');
    header.classList.toggle('scroll',window.scrollY > 200);
});

//Funcionalidade da janela modal do usuário
const janelaModal = document.getElementById('janelaModal');
const close = document.getElementById('close');

//Funcionalidade para abrir modal ao clicar no ícone
function openPerfil(){
    janelaModal.classList.add('openModal');
}
janelaModal.addEventListener('click', (element) => {
    if(element.target.id === 'close' || element.target.id === 'modal'){
        janelaModal.classList.remove('openModal');
    }
});

//Funcionalidade da Janela modal dos alimentos (info)
const modalInfo = document.getElementById('janelaModalInfo');
function openInfo(){
    modalInfo.classList.toggle('ativeInfo');
    modalInfo.addEventListener('click', (element) => {
        console.log(element.target.id);
        if(element.target.id === 'closeInfo' || element.target.id === 'modalInfo'){
            modalInfo.classList.remove('ativeInfo');
        }
    });
}

//Funcionalidade do filter
const iconIconFilter = document.getElementById('iconFilter');
function openFilter(){
    let contentFilter = document.getElementById('content-filter');
    contentFilter.classList.toggle('ativeFilter');
}
iconIconFilter.addEventListener('click', () => {
    iconIconFilter.classList.toggle('ativeIcon');
});

//Funcionalidade menu Dropdown do filtro

const menuDrop = document.querySelectorAll('.openOption');
const contentDrop = document.querySelectorAll('.menuDropdown');
const iconOp = document.querySelectorAll('.iconOption');
menuDrop.forEach((elemento, index) => {
    elemento.addEventListener('click', () => {
        contentDrop[index].classList.toggle('ativeDrop');
        console.log(contentDrop[index].classList.value);
        iconOp[index].classList.toggle('iconAnimate');
    });
});

//Funcionalidades do chat (feedback)

const janelaFeedBack = document.getElementById('janelaFeedback');
const iconFeed = document.getElementById('iconFeed');
function openChat(){
    janelaFeedBack.classList.add('ativeChat');
}
janelaFeedBack.addEventListener('click', (object) => {
    console.log(object.target.id);
    if(object.target.id === 'btnClose-feed' || object.target.id === 'modalFeedback'){
        janelaFeedBack.classList.remove('ativeChat');
    }
    if(object.target.id === 'iconFeed'){
        iconFeed.classList.toggle('animateIcon');
    }
});

//Funcionalidade da abertura dos comentários na janela de feedback
const contentForms = document.getElementById('contentForms');
const contentChat = document.getElementById('contentChat');
function openFeed(){
    contentForms.classList.toggle('desativeForms');
    contentChat.classList.toggle('ativeFeed');
}

//Funcionalidade da janela modal do carrinho
const windowCart = document.getElementById('janelaCarrinho');
const closeCart = document.getElementById('closeCart');
function openCart(){
    windowCart.classList.add('ativeCart');
}
windowCart.addEventListener('click', (element) => {
    if(element.target.id === 'closeCart'){
        windowCart.classList.remove('ativeCart');
    }
})







