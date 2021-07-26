let lang = document.getElementById('lang');
lang.addEventListener('change', function() {
    let href = window.location.pathname;
    if(this.value === 'en'){
        let path = href.replace('fr', 'en');
        window.location.href = path;
    }else if(this.value === 'fr'){
        let path = href.replace('en', 'fr');
        window.location.href = path;
    }
})
