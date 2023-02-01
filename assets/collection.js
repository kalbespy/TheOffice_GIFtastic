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

collectionBtns = document.getElementsByClassName('collectionBtn')

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