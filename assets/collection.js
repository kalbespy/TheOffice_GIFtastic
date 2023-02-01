collectRandomBtns = document.getElementsByClassName('collectBtnRandom')

for (let i = 0; i < collectRandomBtns.length; i++) {
    collectRandomBtns[i].addEventListener('click', addToCollection);
}

function addToCollection(e) {
    e.preventDefault();

    console.log('Hello, my name is Computron, may I help you ?')

    const collectionLink = e.currentTarget;
    const link = collectionLink.href;

    try {
        fetch(link)
            .then(res => res.json())
            .then(data => {
                if (data.isInCollection) {
                    collectionLink.classList.remove("btn-primary");
                    collectionLink.classList.add("btn-success");
                    collectionLink.classList.add("disabled");
                    collectionLink.innerHTML = "GIF Collected";
                }
            });
    } catch (err) {
        console.error(err);
    };
}

collectionBtns = document.getElementsByClassName('collectionBtn');

for (let i = 0; i < collectionBtns.length; i++) {
    collectionBtns[i].addEventListener('click', removeFromCollection);
}

function removeFromCollection(e) {
    e.preventDefault();

    console.log('Hello, my name is Computron, may I help you ?')

    const collectionLink = e.currentTarget;
    const link = collectionLink.href;
    const gifCard = collectionLink.parentElement.parentElement

    try {
        fetch(link)
            .then(res => res.json())
            .then(data => {
                gifCard.classList.add("d-none");
            });
    } catch (err) {
        console.error(err);
    };
}

voteBtns = document.getElementsByClassName('voteBtn');

for (let i = 0; i < voteBtns.length; i++) {
    voteBtns[i].addEventListener('click', addVote);
}

function addVote(e) {
    e.preventDefault();

    console.log('Hello, my name is Computron, may I help you ?')

    const voteLink = e.currentTarget;
    const link = voteLink.href;
    const voteCount = voteLink.previousElementSibling.previousElementSibling.firstElementChild

    let voteNb = parseInt(voteCount.innerText);
    voteNb++

    try {
        fetch(link)
            .then(res => res.json())
            .then(data => {
                voteCount.innerHTML = voteNb;
            });
    } catch (err) {
        console.error(err);
    };
}