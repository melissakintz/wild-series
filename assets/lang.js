let lang = document.getElementById('lang');
lang.addEventListener('change', function() {
    if(this.value === 'en'){
        window.location.href = '/en/programs/the-walking-dead';
    }else if(this.value === 'fr'){
        window.location.href = '/fr/programs/the-walking-dead';
    }
})
