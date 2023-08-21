window.addEventListener('scroll', onScroll)

onScroll()
function onScroll() {
    showBackToTopButtonOnScroll()
    activateMenuAtCurrentSection(home)
    activateMenuAtCurrentSection(services)
    activateMenuAtCurrentSection(about)
    activateMenuAtCurrentSection(contact)
}

function activateMenuAtCurrentSection(section) {
    const targetLine = scrollY + innerHeight / 2
    const sectionTop = section.offsetTop
    const sectionHeight = section.offsetHeight
    const sectionTopReachOrPassedTargetline = targetLine >= sectionTop
    const sectionEndsAt = sectionTop + sectionHeight
    const sectionEndPassedTargetline = sectionEndsAt <= targetLine
    const sectionBoundaries =
        sectionTopReachOrPassedTargetline && !sectionEndPassedTargetline
    const sectionId = section.getAttribute('id')
    const menuElement = document.querySelector(`.menu a[href*=${sectionId}]`)
    menuElement.classList.remove('active')
    if (sectionBoundaries) {
        menuElement.classList.add('active')
    }
}

function showBackToTopButtonOnScroll() {
    if (scrollY > 550) {
        backToTopButton.classList.add('show')
    } else {
        backToTopButton.classList.remove('show')
    }
}

function openMenu() {
    document.body.classList.add('menu-expanded')
}

function closeMenu() {
    document.body.classList.remove('menu-expanded')
}

ScrollReveal({
    origin: 'top',
    distance: '30px',
    duration: 700
}).reveal(
    `#home, 
    #home img, 
    #home .stats, 
    #services,
    #services header,
    #services .card,
    #about,
    #about header
    #about .content`
)

const cards = document.querySelectorAll('.card')
const cardsContainer = document.querySelector('.cards')
cards.forEach(card => {
    card.addEventListener('click', () => {
        // verifica se já tá selecionado e remove a classe
        if (card.classList.contains('selected')) {
            card.classList.remove('selected')
            card.style.backgroundColor = '#ffffff'
            card.style.border = '1px solid hsl(calc(var(--hue) - 22), 23%, 89%)'
        } else {
            // se não tiver selecionado, adiciona a classe
            card.classList.add('selected')
            card.style.backgroundColor = '#56f86c'
            card.style.border = '1px solid #008b00'
        }
    })
})

function updateSelectedCardsInput() {
    document.getElementById('atividades').value = [
        ...document.querySelectorAll('.card.selected h3')
    ].map(e => e.innerText).join(',' + "\n")
}

var modal = document.getElementById('myModal')
var btn = document.getElementsByClassName('open-modal-btn')[0]
var span = document.getElementsByClassName('close')[0]

btn.onclick = function () {
    modal.style.display = 'block'
}

span.onclick = function () {
    modal.style.display = 'none'
}

window.onclick = function (event) {
    if (event.target == modal) {
        modal.style.display = 'none'
    }
}

const fileInput = document.getElementById('comprovante')
const fileNameSpan = document.getElementById('file-name')
fileInput.addEventListener('change', function () {
    if (fileInput.files.length > 0) {
        const fileName = fileInput.files[0].name
        fileNameSpan.textContent = fileName
    } else {
        fileNameSpan.textContent = ''
    }
})