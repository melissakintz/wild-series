document.querySelector('#watchlist').addEventListener('click', (event) => {
    event.preventDefault();
    let watchlistlink = event.currentTarget;
    let link = watchlistlink.href;

    fetch(link)
        .then(response => response.json())
        .then(function (response){
            let watchlistIcon = watchlistlink.firstElementChild;
            if (response.isInWatchlist){
                watchlistIcon.classList.remove('bi-heart');
                watchlistIcon.classList.add('bi-heart-fill');
            }else {
                watchlistIcon.classList.remove('bi-heart-fill');
                watchlistIcon.classList.add('bi-heart');
            }
        });
})
